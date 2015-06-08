<?php

/**
 * @Copyright Copyright (C) 2009-2011
 * @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
  + Created by:          Ahmad Bilal
 * Company:		Buruj Solutions
  + Contact:		www.burujsolutions.com , ahmad@burujsolutions.com
 * Created on:	Jan 11, 2009
  ^
  + Project: 		JS Jobs
 * File Name:	models/customfields.php
  ^
 * Description: Model class for jsjobs data
  ^
 * History:		NONE
  ^
 */
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.model');
jimport('joomla.html.html');
$option = JRequest :: getVar('option', 'com_jsjobs');

class JSJobsModelCustomFields extends JSModel {

    var $_client_auth_key = null;
    var $_siteurl = null;

    function __construct() {
        parent :: __construct();
        $this->_client_auth_key = $this->getJSModel('common')->getClientAuthenticationKey();
        $this->_siteurl = JURI::root();
        $user = JFactory::getUser();
        $this->_uid = $user->id;
    }

    function deleteUserFieldData($refid) { //delete user field data
        if (is_numeric($refid) === false)
            return false;
        $db = JFactory::getDBO();

        $query = "DELETE FROM #__js_job_userfield_data WHERE referenceid = " . $refid;
        $db->setQuery($query);
        if (!$db->query()) {
            return false;
        }
        return true;
    }

    function getUserFields($fieldfor, $id) {
        if ($fieldfor)
            if (is_numeric($fieldfor) === false)
                return false;
        if($id)
        if (is_numeric($id) === false)
            return false;
        $db = $this->getDBO();
        $result;
        $field = array();
        $result = array();
        $query = "SELECT  * FROM `#__js_job_userfields` 
					WHERE published = 1 AND fieldfor = " . $fieldfor;
        $db->setQuery($query);
        $rows = $db->loadObjectList();

        $i = 0;
        foreach ($rows as $row) {
            $field[0] = $row;
            if ($id != "") {
                $query = "SELECT  * FROM `#__js_job_userfield_data` WHERE referenceid = " . $id . " AND field = " . $row->id;
                $db->setQuery($query);
                $data = $db->loadObject();
                $field[1] = $data;
            }
            if ($row->type == "select") {
                $query = "SELECT  * FROM `#__js_job_userfieldvalues` WHERE field = " . $row->id;
                $db->setQuery($query);
                $values = $db->loadObjectList();
                $field[2] = $values;
            }
            $result[] = $field;
            $i++;
        }
        return $result;
    }

    function getUserFieldsForView($fieldfor, $id) {
        if ($fieldfor)
            if (is_numeric($fieldfor) === false)
                return false;
        if (is_numeric($id) === false)
            return false;
        $db = $this->getDBO();
        $result;
        $field = array();
        $result = array();
        $query = "SELECT  * FROM `#__js_job_userfields` 
					WHERE published = 1 AND fieldfor = " . $fieldfor;
        $db->setQuery($query);
        $rows = $db->loadObjectList();

        $i = 0;
        foreach ($rows as $row) {
            $field[0] = $row;
            if ($id != "") {
                $query = "SELECT  * FROM `#__js_job_userfield_data` WHERE referenceid = " . $id . " AND field = " . $row->id;

                $db->setQuery($query);
                $data = $db->loadObject();
                $field[1] = $data;
            }
            if ($row->type == "select") {

                if (isset($id) && $id != "") {//if id is not empty
                    $query = "SELECT  fieldvalue.* FROM `#__js_job_userfield_data` AS fielddata
								JOIN `#__js_job_userfieldvalues` AS fieldvalue ON fieldvalue.id = fielddata.data
								WHERE fielddata.field = " . $row->id . " AND fielddata.referenceid = " . $id;
                } else {//general
                    $query = "SELECT  value.* FROM `#__js_job_userfieldvalues` AS value WHERE value.field = " . $row->id;
                }
                $db->setQuery($query);
                $value = $db->loadObject();
                $field[2] = $value;
            }
            $result[] = $field;
            $i++;
        }
        return $result;
    }

    function getFieldsOrdering($fieldfor) {
        if (is_numeric($fieldfor) === false)
            return false;
        $db = $this->getDBO();
        if ($fieldfor == 16) { // resume visitor case 
            $fieldfor = 3;
            $query = "SELECT  id,field,fieldtitle,ordering,section,fieldfor,isvisitorpublished AS published,sys,cannotunpublish,required 
						FROM `#__js_job_fieldsordering` 
						WHERE isvisitorpublished = 1 AND fieldfor =  " . $fieldfor
                    . " ORDER BY section,ordering";
        } else {
            $query = "SELECT  * FROM `#__js_job_fieldsordering` 
						WHERE published = 1 AND fieldfor =  " . $fieldfor
                    . " ORDER BY section,ordering";
        }
        $db->setQuery($query);
        $fields = $db->loadObjectList();
        return $fields;
    }

    function storeUserFieldData($data, $refid) { //store  user field data
        $row = $this->getTable('userfielddata');
        for ($i = 1; $i <= $data['userfields_total']; $i++) {
            $fname = "userfields_" . $i;
            $fid = "userfields_" . $i . "_id";
            $dataid = "userdata_" . $i . "_id";
            $fielddata['id'] = $data[$dataid];
            $fielddata['referenceid'] = $refid;
            $fielddata['field'] = $data[$fid];
            $fielddata['data'] = isset($data[$fname]) ? $data[$fname] : 0;

            if (!$row->bind($fielddata)) {
                $this->setError($this->_db->getErrorMsg());
                return false;
            }

            if (!$row->store()) {
                $this->setError($this->_db->getErrorMsg());
                echo $this->_db->getErrorMsg();
                exit;
                return false;
            }
        }
        return true;
    }

}
?>


