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

class JSJobsModelShift extends JSModel{

    var $_config = null;
    var $_defaultcurrency = null;
    var $_client_auth_key = null;
    var $_siteurl = null;
    var $_shifts = null;

    function __construct() {
        parent :: __construct();
        $this->_client_auth_key = $this->getJSModel('jobsharing')->getClientAuthenticationKey();
        $this->_siteurl = JURI::root();
        $this->_defaultcurrency = $this->getJSModel('currency')->getDefaultCurrency();
        $user = JFactory::getUser();
        $this->_uid = $user->id;
    }

    function getShiftbyId($c_id) {
        if (is_numeric($c_id) == false)
            return false;
        $db = JFactory :: getDBO();
        $query = "SELECT * FROM #__js_job_shifts WHERE id = " . $c_id;

        $db->setQuery($query);
        $shift = $db->loadObject();
        return $shift;
    }

    function getAllShifts($limitstart, $limit) {
        $db = JFactory :: getDBO();
        $result = array();
        $query = "SELECT COUNT(id) FROM #__js_job_shifts";
        $db->setQuery($query);
        $total = $db->loadResult();

        if ($total <= $limitstart)
            $limitstart = 0;
        $query = "SELECT * FROM #__js_job_shifts ORDER BY ordering ASC";

        $db->setQuery($query, $limitstart, $limit);

        $result[0] = $db->loadObjectList();
        $result[1] = $total;
        return $result;
    }

    function storeShift() {
        $row = $this->getTable('shift');

        $data = JRequest :: get('post');
        $returnvalue = 1;

        if ($data['id'] == '') { // only for new
            $result = $this->isJobShiftsExist($data['title']);
            if ($result == true)
                $returnvalue = 3;
            else {
                $db = JFactory::getDBO();
                $query = "SELECT max(ordering)+1 AS maxordering FROM #__js_job_shifts";
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
            $server_jobshifts_data = array();
            if ($this->_client_auth_key != "") {
                $server_jobshifts_data['id'] = $row->id;
                $server_jobshifts_data['title'] = $row->title;
                $server_jobshifts_data['isactive'] = $row->isactive;
                $server_jobshifts_data['serverid'] = $row->serverid;
                $server_jobshifts_data['status'] = $row->status;
                $server_jobshifts_data['authkey'] = $this->_client_auth_key;
                $table = "shifts";
                $jobsharing = $this->getJSModel('jobsharing');

                $return_value = $jobsharing->storeDefaultTables($server_jobshifts_data, $table);
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

    function deleteShift() {
        $cids = JRequest :: getVar('cid', array(0), 'post', 'array');
        $row = $this->getTable('shift');
        $deleteall = 1;
        foreach ($cids as $cid) {
            if ($this->shiftCanDelete($cid) == true) {
                if (!$row->delete($cid)) {
                    $this->setError($row->getErrorMsg());
                    return false;
                }
            } else
                $deleteall++;
        }
        return $deleteall;
    }

    function shiftCanDelete($shiftid) {
        if (is_numeric($shiftid) == false)
            return false;
        $db = $this->getDBO();

        $query = "SELECT
                    ( SELECT COUNT(id) FROM `#__js_job_jobs` WHERE shift = " . $shiftid . ")
                    + ( SELECT COUNT(id) FROM `#__js_job_shifts` WHERE id = " . $shiftid . " AND isdefault = 1)
                    AS total ";

        $db->setQuery($query);
        $total = $db->loadResult();

        if ($total > 0)
            return false;
        else
            return true;
    }

    function getShift($title) {
        if (!$this->_shifts) {
            $db = JFactory::getDBO();
            $query = "SELECT id, title FROM `#__js_job_shifts` WHERE isactive = 1";
            if ($this->_client_auth_key != "")
                $query.=" AND serverid!='' AND serverid!=0";
            $query.= " ORDER BY ordering ASC ";
            $db->setQuery($query);
            $rows = $db->loadObjectList();
            if ($db->getErrorNum()) {
                echo $db->stderr();
                return false;
            }
            $this->_shifts = array();
            if ($title)
                $this->_shifts[] = array('value' => JText::_(''), 'text' => $title);
            foreach ($rows as $row) {
                $this->_shifts[] = array('value' => JText::_($row->id), 'text' => JText::_($row->title));
            }
        }
        return $this->_shifts;
    }

    function isJobShiftsExist($title) {
        $db = JFactory::getDBO();
        $query = "SELECT COUNT(id) FROM #__js_job_shifts WHERE title = " . $db->Quote($title);
        $db->setQuery($query);
        $result = $db->loadResult();
        if ($result == 0)
            return false;
        else
            return true;
    }

}

?>