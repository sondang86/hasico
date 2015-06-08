<?php

/**
 * @Copyright Copyright (C) 2009-2010 ... Ahmad Bilal
 * @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * Company:		Al-Barr Technologies
  + Contact:		www.al-barr.com , info@al-barr.com
 * Created on:	Jan 11, 2009
  ^
  + Project: 		Job Posting and Employment Application
 * File Name:	admin-----/models/jsjobs.php
  ^
 * Description: Model for application on admin site
  ^
 * History:		NONE
  ^
 */
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.model');
jimport('joomla.html.html');

class JSJobsModelState extends JSModel{

    var $_config = null;
    var $_defaultcurrency = null;
    var $_client_auth_key = null;
    var $_siteurl = null;

    function __construct() {
        parent :: __construct();
        $this->_client_auth_key = $this->getJSModel('jobsharing')->getClientAuthenticationKey();
        $this->_siteurl = JURI::root();
        $this->_defaultcurrency = $this->getJSModel('currency')->getDefaultCurrency();
        $user = JFactory::getUser();
        $this->_uid = $user->id;
    }

    function getStatebyId($c_id) {
        if (is_numeric($c_id) == false)
            return false;
        $db = JFactory :: getDBO();
        $query = "SELECT * FROM #__js_job_states WHERE id = " . $c_id;
        $db->setQuery($query);
        $state = $db->loadObject();
        return $state;
    }

    /* STRAT EXPORT RESUMES */

    function getDefaultStatesForSharing($title, $countryid) {
        if (!is_numeric($countryid))
            return false;
        $states = array();
        $db = JFactory::getDBO();
        $query = "SELECT serverid AS id,name FROM `#__js_job_states` WHERE enabled = 1 AND countryid=" . $countryid;
        if ($this->_client_auth_key != "")
            $query.=" AND serverid!='' AND serverid!=0";
        $query.= " ORDER BY name ASC ";
        $db->setQuery($query);
        $rows = $db->loadObjectList();
        if ($db->getErrorNum()) {
            echo $db->stderr();
            return false;
        }
        if ($title)
            $states[] = array('value' => JText::_(''), 'text' => $title);

        foreach ($rows as $row) {
            $states[] = array('value' => $row->id, 'text' => JText::_($row->name));
        }
        return $states;
    }

    function getDefaultStateCitiesForSharing($title, $stateid) {
        if (!is_numeric($stateid))
            return false;
        $cities = array();
        $db = JFactory::getDBO();
        $query = "SELECT serverid AS id,name FROM `#__js_job_cities` WHERE enabled = 1 AND stateid=" . $stateid;
        if ($this->_client_auth_key != "")
            $query.=" AND serverid!='' AND serverid!=0";
        $query.= " ORDER BY name ASC ";

        $db->setQuery($query);
        $rows = $db->loadObjectList();
        if ($db->getErrorNum()) {
            echo $db->stderr();
            return false;
        }
        if ($title)
            $cities[] = array('value' => JText::_(''), 'text' => $title);
        foreach ($rows as $row) {
            $cities[] = array('value' => $row->id, 'text' => JText::_($row->name));
        }
        return $cities;
    }

    function getAllCountryStates($searchname, $countryid, $limitstart, $limit) {
        $db = JFactory :: getDBO();
        $result = array();
        $query = "SELECT COUNT(id) FROM `#__js_job_states` WHERE countryid = " . $countryid;
        if ($searchname) {
            $query .= " AND name LIKE " . $db->Quote('%' . $searchname . '%', false);
        }
        $db->setQuery($query);
        $total = $db->loadResult();
        if ($total <= $limitstart)
            $limitstart = 0;

        $query = "SELECT * FROM `#__js_job_states` WHERE countryid = " . $countryid;

        if ($searchname) {
            $query .= " AND name LIKE " . $db->Quote('%' . $searchname . '%', false) . " ORDER BY name ASC";
        } else {
            $query .= " ORDER BY name ASC";
        }
        $db->setQuery($query, $limitstart, $limit);

        $result[0] = $db->loadObjectList();
        $result[1] = $total;
        if ($searchname) {
            $lists['searchname'] = $searchname;
            $result[2] = $lists;
        }
        return $result;
    }

    function storeState($countryid) {
        $row = $this->getTable('state');
        $db = $this->getDBO();
        $data = JRequest :: get('post');
        $data['countryid'] = $countryid;

        if (!$data['id']) { // only for new
            $existvalue = $this->isStateExist($data['name'], $data['countryid']);
            if ($existvalue == true)
                return 3;
            $data['shortRegion'] = $data['name'];
        } else
            $data['shortRegion'] = $data['name'];
        if (!$row->bind($data)) {
            $this->setError($this->_db->getErrorMsg());
            return false;
        }
        if (!$row->store()) {
            $this->setError($this->_db->getErrorMsg());
            return false;
        }
        $server_state_data = array();
        if ($this->_client_auth_key != "") {
            $server_state_data['id'] = $row->id;
            $server_state_data['shortRegion'] = $row->shortRegion;
            $server_state_data['name'] = $row->name;
            $server_state_data['enabled'] = $row->enabled;
            $server_state_data['countryid'] = $row->countryid;
            $server_state_data['serverid'] = $row->serverid;
            $server_state_data['authkey'] = $this->_client_auth_key;
            if ($data['countryid']) {
                $query = "SELECT serverid FROM `#__js_job_countries` WHERE   id = " . $data['countryid'];
                $db->setQuery($query);
                $country_serverid = $db->loadResult();
                if ($country_serverid)
                    $server_state_data['countryid'] = $country_serverid;
                else
                    $server_state_data['countryid'] = 0;
            } else
                $server_state_data['countryid'] = 0;
            $table = "states";
            $jobsharing = $this->getJSModel('jobsharing');
            $return_value = $jobsharing->storeDefaultTables($server_state_data, $table);
            return $return_value;
        }else {
            return true;
        }
    }

    function deleteState() {
        $cids = JRequest :: getVar('cid', array(0), 'post', 'array');
        $row = $this->getTable('state');
        $deleteall = 1;
        foreach ($cids as $cid) {
            if ($this->stateCanDelete($cid) == true) {
                if (!$row->delete($cid)) {
                    $this->setError($row->getErrorMsg());
                    return false;
                }
            } else
                $deleteall++;
        }
        return $deleteall;
    }

    function stateCanDelete($stateid) {
        if (is_numeric($stateid) == false)
            return false;
        $db = $this->getDBO();

        $query = "SELECT 
                    ( SELECT COUNT(mcity.id) 
                            FROM `#__js_job_cities` AS city
                            JOIN `#__js_job_jobcities` AS mcity ON mcity.cityid=city.id 
                            WHERE city.stateid = " . $stateid . "
                    )
                    + 
                    ( SELECT COUNT(cmcity.id) 
                            FROM `#__js_job_cities` AS city
                            JOIN `#__js_job_companycities` AS cmcity ON cmcity.cityid=city.id 
                            WHERE city.stateid = " . $stateid . "
                    )
                    +
                    ( SELECT COUNT(resume.id) 
                            FROM `#__js_job_cities` AS city
                            JOIN `#__js_job_resume` AS resume ON resume.address_city=city.id
                            WHERE city.stateid = " . $stateid . "
                    )
                    +
                    ( SELECT COUNT(resume.id) 
                            FROM `#__js_job_cities` AS city
                            JOIN `#__js_job_resume` AS resume ON resume.address1_city=city.id
                            WHERE city.stateid = " . $stateid . "
                    )
                    +
                    ( SELECT COUNT(resume.id) 
                            FROM `#__js_job_cities` AS city
                            JOIN `#__js_job_resume` AS resume ON resume.address2_city=city.id
                            WHERE city.stateid = " . $stateid . "
                    )
                    + 
                    ( SELECT COUNT(resume.id) 
                            FROM `#__js_job_cities` AS city
                            JOIN `#__js_job_resume` AS resume ON resume.institute_city=city.id
                            WHERE city.stateid = " . $stateid . "
                    )
                    + 
                    ( SELECT COUNT(resume.id) 
                            FROM `#__js_job_cities` AS city
                            JOIN `#__js_job_resume` AS resume ON resume.institute1_city=city.id
                            WHERE city.stateid = " . $stateid . "
                    )
                    + 
                    ( SELECT COUNT(resume.id) 
                            FROM `#__js_job_cities` AS city
                            JOIN `#__js_job_resume` AS resume ON resume.institute2_city=city.id
                            WHERE city.stateid = " . $stateid . "
                    )
                    + 
                    ( SELECT COUNT(resume.id) 
                            FROM `#__js_job_cities` AS city
                            JOIN `#__js_job_resume` AS resume ON resume.institute3_city=city.id
                            WHERE city.stateid = " . $stateid . "
                    )
                    + 
                    ( SELECT COUNT(resume.id) 
                            FROM `#__js_job_cities` AS city
                            JOIN `#__js_job_resume` AS resume ON resume.employer_city=city.id
                            WHERE city.stateid = " . $stateid . "
                    )
                    + 
                    ( SELECT COUNT(resume.id) 
                            FROM `#__js_job_cities` AS city
                            JOIN `#__js_job_resume` AS resume ON resume.employer1_city=city.id
                            WHERE city.stateid = " . $stateid . "
                    )
                    + 
                    ( SELECT COUNT(resume.id) 
                            FROM `#__js_job_cities` AS city
                            JOIN `#__js_job_resume` AS resume ON resume.employer2_city=city.id
                            WHERE city.stateid = " . $stateid . "
                    )
                    + 
                    ( SELECT COUNT(resume.id) 
                            FROM `#__js_job_cities` AS city
                            JOIN `#__js_job_resume` AS resume ON resume.employer3_city=city.id
                            WHERE city.stateid = " . $stateid . "
                    )
                    + 
                    ( SELECT COUNT(resume.id) 
                            FROM `#__js_job_cities` AS city
                            JOIN `#__js_job_resume` AS resume ON resume.reference_city=city.id
                            WHERE city.stateid = " . $stateid . "
                    )
                    + 
                    ( SELECT COUNT(resume.id) 
                            FROM `#__js_job_cities` AS city
                            JOIN `#__js_job_resume` AS resume ON resume.reference1_city=city.id
                            WHERE city.stateid = " . $stateid . "
                    )
                    + 
                    ( SELECT COUNT(resume.id) 
                            FROM `#__js_job_cities` AS city
                            JOIN `#__js_job_resume` AS resume ON resume.reference2_city=city.id
                            WHERE city.stateid = " . $stateid . "
                    )
                    + 
                    ( SELECT COUNT(resume.id) 
                            FROM `#__js_job_cities` AS city
                            JOIN `#__js_job_resume` AS resume ON resume.reference3_city=city.id
                            WHERE city.stateid = " . $stateid . "
                    )
                    AS total ";

        $db->setQuery($query);
        $total = $db->loadResult();

        if ($total > 0)
            return false;
        else
            return true;
    }

    function isStateExist($state, $countryid) {
        $db = JFactory::getDBO();
        $query = "SELECT COUNT(id) FROM #__js_job_states WHERE name = " . $db->Quote($state) . " AND countryid = " . $countryid;

        $db->setQuery($query);
        $result = $db->loadResult();
        if ($result == 0)
            return false;
        else
            return true;
    }

    function getStates($country) {
        $states = array();
        $db = JFactory::getDBO();
        if (is_null($country) OR empty($country))
            $country = 0;
        $query = "SELECT * FROM `#__js_job_states` WHERE enabled = 'Y' AND countryid = " . $country;
        if ($this->_client_auth_key != "")
            $query.=" AND serverid!='' AND serverid!=0";
        $query.= " ORDER BY name ASC ";
        $db->setQuery($query);
        $rows = $db->loadObjectList();
        if ($db->getErrorNum()) {
            echo $db->stderr();
            return false;
        }

        foreach ($rows as $row) {
            $states[] = array('value' => $row->id, 'text' => JText::_($row->name));
        }
        return $states;
    }

    function publishstates() {
        $row = $this->getTable('state');
        $cids = JRequest::getVar('cid');
        foreach ($cids AS $cid) {
            $data['id'] = $cid;
            $data['enabled'] = '1';
            if (!$row->bind($data)) {
                $this->setError($this->_db->getErrorMsg());
                return false;
            }
            if (!$row->store()) {
                $this->setError($this->_db->getErrorMsg());
                return false;
            }
        }

        return true;
    }

    function unpublishstates() {
        $row = $this->getTable('state');
        $cids = JRequest::getVar('cid');
        foreach ($cids AS $cid) {
            $data['id'] = $cid;
            $data['enabled'] = '0';
            if (!$row->bind($data)) {
                $this->setError($this->_db->getErrorMsg());
                return false;
            }
            if (!$row->store()) {
                $this->setError($this->_db->getErrorMsg());
                return false;
            }
        }
        return true;
    }

}

?>