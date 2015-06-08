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

class JSJobsModelSalaryrangetype extends JSModel{

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

    function getSalaryRangeTypebyId($c_id) {
        if (is_numeric($c_id) == false)
            return false;
        $db = JFactory :: getDBO();
        $query = "SELECT * FROM #__js_job_salaryrangetypes WHERE id = " . $c_id;

        $db->setQuery($query);
        $jobtype = $db->loadObject();
        return $jobtype;
    }

    function getAllSalaryRangeType($limitstart, $limit) {
        $db = JFactory :: getDBO();
        $result = array();
        $query = "SELECT COUNT(id) FROM #__js_job_salaryrangetypes";
        $db->setQuery($query);
        $total = $db->loadResult();

        if ($total <= $limitstart)
            $limitstart = 0;
        $query = "SELECT * FROM #__js_job_salaryrangetypes ORDER BY ordering ASC";

        $db->setQuery($query, $limitstart, $limit);

        $result[0] = $db->loadObjectList();
        $result[1] = $total;
        return $result;
    }

    function storeSalaryRangeType() {
        $row = $this->getTable('salaryrangetype');
        $returnvalue = 1;
        $data = JRequest :: get('post');

        if ($data['id'] == '') { // only for new
            $result = $this->isSalaryRangeTypeExist($data['title']);
            if ($result == true) {
                $returnvalue = 3;
            } else {
                $db = JFactory::getDBO();
                $query = "SELECT max(ordering)+1 AS maxordering FROM #__js_job_salaryrangetypes";
                $db->setQuery($query);
                $ordering = $db->loadResult();
                $data['ordering'] = $ordering;
                $data['isdefault'] = 0;
            }
        }
        if ($returnvalue == 1) {
            if (!$row->bind($data)) {
                $this->setError($this->_db->getErrorMsg());
                return false;
            }
            if (!$row->store()) {
                $this->setError($this->_db->getErrorMsg());
                return false;
            }
            $server_salaryrangetype_data = array();
            if ($this->_client_auth_key != "") {
                $server_salaryrangetype_data['id'] = $row->id;
                $server_salaryrangetype_data['title'] = $row->title;
                $server_salaryrangetype_data['status'] = $row->status;
                $server_salaryrangetype_data['serverid'] = $row->serverid;
                $server_salaryrangetype_data['authkey'] = $this->_client_auth_key;
                $table = "salaryrangetypes";
                $jobsharing = $this->getJSModel('jobsharing');
                $return_value = $jobsharing->storeDefaultTables($server_salaryrangetype_data, $table);
                $return_value['issharing'] = 1;
                $return_value[2] = $row->id;
            } else {
                $return_value['issharing'] = 0;
                $return_value[1] = $returnvalue;
                $return_value[2] = $row->id;
            }
            return $return_value;
        } else {
            return $returnvalue;
        }
    }

    function deleteSalaryRangeType() {
        $cids = JRequest :: getVar('cid', array(0), 'post', 'array');
        $row = $this->getTable('salaryrangetype');
        $deleteall = 1;
        foreach ($cids as $cid) {
            if ($this->salaryRangeTypeCanDelete($cid) == true) {
                if (!$row->delete($cid)) {
                    $this->setError($row->getErrorMsg());
                    return false;
                }
            } else
                $deleteall++;
        }
        return $deleteall;
    }

    function salaryRangeTypeCanDelete($id) {
        if (is_numeric($id) == false)
            return false;
        $db = $this->getDBO();
        $query = "SELECT
                    ( SELECT COUNT(id) FROM `#__js_job_jobs` WHERE salaryrangetype = " . $id . ")
                    + ( SELECT COUNT(id) FROM `#__js_job_salaryrangetypes` WHERE id = " . $id . " AND isdefault = 1)
                    AS total ";

        $db->setQuery($query);
        $total = $db->loadResult();
        if ($total > 0)
            return false;
        else
            return true;
    }

    function getSalaryRangeTypes($title) {
        $db = JFactory::getDBO();
        $query = "SELECT id, title FROM `#__js_job_salaryrangetypes` WHERE status = 1";
        if ($this->_client_auth_key != "")
            $query.=" AND serverid!='' AND serverid!=0";
        $query.= " ORDER BY ordering ASC ";
        $db->setQuery($query);
        $rows = $db->loadObjectList();
        if ($db->getErrorNum()) {
            echo $db->stderr();
            return false;
        }
        $types = array();
        if ($title)
            $types[] = array('value' => JText::_(''), 'text' => $title);
        foreach ($rows as $row) {
            $types[] = array('value' => $row->id, 'text' => $row->title);
        }
        return $types;
    }

    function isSalaryRangeTypeExist($title) {
        $db = JFactory::getDBO();
        $query = "SELECT COUNT(id) FROM #__js_job_salaryrangetypes WHERE title = " . $db->Quote($title);
        $db->setQuery($query);
        $result = $db->loadResult();
        if ($result == 0)
            return false;
        else
            return true;
    }

}

?>