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

class JSJobsModelSalaryrange extends JSModel{

    var $_config = null;
    var $_defaultcurrency = null;
    var $_client_auth_key = null;
    var $_siteurl = null;
    var $_jobsalaryrange = null;

    function __construct() {
        parent :: __construct();
        $this->_client_auth_key = $this->getJSModel('jobsharing')->getClientAuthenticationKey();
        $this->_siteurl = JURI::root();
        $this->_defaultcurrency = $this->getJSModel('currency')->getDefaultCurrency();
        $user = JFactory::getUser();
        $this->_uid = $user->id;
    }

    function getSalaryRangebyId($c_id) {
        if (is_numeric($c_id) == false)
            return false;
        $db = JFactory :: getDBO();
        $query = "SELECT * FROM #__js_job_salaryrange WHERE id = " . $c_id;

        $db->setQuery($query);
        $this->_application = $db->loadObject();
        return $this->_application;
    }

    function getAllSalaryRange($limitstart, $limit) {
        $db = JFactory :: getDBO();
        $result = array();
        $query = "SELECT COUNT(id) FROM #__js_job_salaryrange";
        $db->setQuery($query);
        $total = $db->loadResult();
        if ($total <= $limitstart)
            $limitstart = 0;

        $query = "SELECT * FROM #__js_job_salaryrange ORDER BY ordering ASC";

        $db->setQuery($query, $limitstart, $limit);
        $this->_application = $db->loadObjectList();

        $result[0] = $this->_application;
        $result[1] = $total;
        return $result;
    }

    function storeSalaryRange() {
        $row = $this->getTable('salaryrange');
        $returnvalue = 1;
        $data = JRequest :: get('post');
        if ($data['id'] == '') { // only for new
            $result = $this->isSalaryRangeExist($data['rangestart'], $data['rangeend']);
            if ($result == true) {
                $returnvalue = 3;
            } else {
                $db = JFactory::getDBO();
                $query = "SELECT max(ordering)+1 AS maxordering FROM #__js_job_salaryrange";
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
            if (!$row->check()) {
                $this->setError($this->_db->getErrorMsg());
                $returnvalue = 2;
            }
            if (!$row->store()) {
                $this->setError($this->_db->getErrorMsg());
                return false;
            }
            $server_salaryrange_data = array();
            if ($this->_client_auth_key != "") {
                $server_salaryrange_data['id'] = $row->id;
                $server_salaryrange_data['rangestart'] = $row->rangestart;
                $server_salaryrange_data['rangeend'] = $row->rangeend;
                $server_salaryrange_data['serverid'] = $row->serverid;
                $server_salaryrange_data['authkey'] = $this->_client_auth_key;
                $table = "salaryrange";
                $jobsharing = $this->getJSModel('jobsharing');

                $return_value = $jobsharing->storeDefaultTables($server_salaryrange_data, $table);
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

    function deleteSalaryRange() {
        $cids = JRequest :: getVar('cid', array(0), 'post', 'array');
        $row = $this->getTable('salaryrange');
        $deleteall = 1;
        foreach ($cids as $cid) {
            if ($this->salaryRangeCanDelete($cid) == true) {
                if (!$row->delete($cid)) {
                    $this->setError($row->getErrorMsg());
                    return false;
                }
            }
            else
                $deleteall++;
        }
        return $deleteall;
    }

    function salaryRangeCanDelete($salaryid) {
        if (is_numeric($salaryid) == false)
            return false;
        $db = $this->getDBO();

        $query = "SELECT
                    ( SELECT COUNT(id) FROM `#__js_job_jobs` WHERE jobsalaryrange = " . $salaryid . ")
                    + ( SELECT COUNT(id) FROM `#__js_job_resume` WHERE jobsalaryrange = " . $salaryid . ")
                    + ( SELECT COUNT(id) FROM `#__js_job_salaryrange` WHERE id = " . $salaryid . " AND isdefault = 1)
                    AS total ";

        $db->setQuery($query);
        $total = $db->loadResult();

        if ($total > 0)
            return false;
        else
            return true;
    }

    function SalaryRangeValidation($rangestart, $rangeend) {
        $db = JFactory::getDBO();
        $query = "SELECT COUNT(id) FROM #__js_job_categories WHERE cat_title = " . $db->Quote($cat_title);
        $db->setQuery($query);
        $result = $db->loadResult();
        if ($result == 0)
            return false;
        else
            return true;
    }

    //send ma
    function getSalaryRange($title) {
        $db = JFactory::getDBO();
        if (!$this->_jobsalaryrange) {
            $query = "SELECT * FROM `#__js_job_salaryrange` ORDER BY 'ordering' ";
            $db->setQuery($query);
            $rows = $db->loadObjectList();
            if ($db->getErrorNum()) {
                echo $db->stderr();
                return false;
            }
            $this->_jobsalaryrange = $rows;
        }

        if (!$this->_config)
            $this->_config = $this->getJSModel('configuration')->getConfig('');
        foreach ($this->_config as $conf) {
            if ($conf->configname == 'currency')
                $currency = $conf->configvalue;
        }

        $jobsalaryrange = array();
        if ($title)
            $jobsalaryrange[] = array('value' => JText::_(''), 'text' => $title);

        foreach ($this->_jobsalaryrange as $row) {
            $salrange = $row->rangestart . ' - ' . $row->rangeend;
            $salrange = $row->rangestart; //.' - '.$currency . $row->rangeend;


            $jobsalaryrange[] = array('value' => $row->id, 'text' => $salrange);
        }
        return $jobsalaryrange;
    }

    function getJobSalaryRange($title, $value) {
        $db = JFactory::getDBO();
        $query = "SELECT * FROM `#__js_job_salaryrange`";
        if ($this->_client_auth_key != "")
            $query.=" WHERE serverid!='' AND serverid!=0";
        $query.= " ORDER BY 'id' ";

        $db->setQuery($query);
        $rows = $db->loadObjectList();
        if ($db->getErrorNum()) {
            echo $db->stderr();
            return false;
        }
        if (!$this->_config)
            $this->_config = $this->getJSModel('configuration')->getConfig();
        foreach ($this->_config as $conf) {
            if ($conf->configname == 'currency')
                $currency = $conf->configvalue;
        }
        $jobsalaryrange = array();
        if ($title)
            $jobsalaryrange[] = array('value' => JText::_($value), 'text' => JText::_($title));
        foreach ($rows as $row) {
            $salrange = $row->rangestart . ' - ' . $row->rangeend;
            $jobsalaryrange[] = array('value' => JText::_($row->id),
                'text' => JText::_($salrange));
        }
        return $jobsalaryrange;
    }

    function isSalaryRangeExist($rangestart, $rangeend) {
        $db = JFactory::getDBO();
        $query = "SELECT COUNT(id) FROM #__js_job_salaryrange WHERE rangestart = " . $db->Quote($rangestart) . " AND rangeend=" . $db->Quote($rangeend);
        $db->setQuery($query);
        $result = $db->loadResult();
        if ($result == 0)
            return false;
        else
            return true;
    }

}

?>