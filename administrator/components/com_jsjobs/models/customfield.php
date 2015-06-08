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

class JSJobsModelCustomfield extends JSModel{

    var $_config = null;
    var $_defaultcurrency = null;
    var $_client_auth_key = null;
    var $_siteurl = null;
    var $_application = null;

    function __construct() {
        parent :: __construct();
        $this->_client_auth_key = $this->getJSModel('jobsharing')->getClientAuthenticationKey();
        $this->_siteurl = JURI::root();
        $this->_defaultcurrency = $this->getJSModel('currency')->getDefaultCurrency();
        $user = JFactory::getUser();
        $this->_uid = $user->id;
    }

    function deleteUserFieldOptionValue($id) {
        $row = $this->getTable('userfieldvalue');
        if ($row->load($id)) {
            $db = JFactory::getDBO();
            $query = "SELECT count(id) FROM `#__js_job_userfield_data` WHERE field = " . $row->field . " AND data=" . $row->id;
            $db->setQuery($query);
            $total = $db->loadResult();
            if ($total > 0)
                $return = false;
            else {
                $return = true;
                $row->delete();
            }
        } else
            $return = false;
        return $return;
    }

    function getUserFieldsForView($fieldfor, $id) {
        $db = $this->getDBO();
        $result;
        $field = array();
        $result = array();
        if (!is_numeric($fieldfor))
            return false;
        $query = "SELECT  * FROM `#__js_job_userfields` 
					WHERE published = 1 AND fieldfor = " . $fieldfor;
        $db->setQuery($query);
        $rows = $db->loadObjectList();

        $i = 0;
        foreach ($rows as $row) {
            $field[0] = $row;
            if ($id != "") {
                if (!is_numeric($id))
                    return false;
                $query = "SELECT  * FROM `#__js_job_userfield_data` WHERE referenceid = " . $id . " AND field = " . $row->id;
                $db->setQuery($query);
                $data = $db->loadObject();
                $field[1] = $data;
            }
            if ($row->type == "select") {
                if (isset($id) && $id != "") {//if id is not empty
                    if (!is_numeric($id))
                        return false;
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

    function getUserFields($fieldfor, $limitstart, $limit) {
        if (is_numeric($fieldfor) == false)
            return false;
        $db = JFactory :: getDBO();
        $result = array();

        $query = 'SELECT COUNT(id) FROM #__js_job_userfields WHERE fieldfor = ' . $fieldfor;
        $db->setQuery($query);
        $total = $db->loadResult();
        if ($total <= $limitstart)
            $limitstart = 0;

        $query = 'SELECT field.* FROM #__js_job_userfields AS field WHERE fieldfor = ' . $fieldfor;
        $query .= ' ORDER BY field.id';

        $db->setQuery($query, $limitstart, $limit);
        $this->_application = $db->loadObjectList();

        $result[0] = $this->_application;
        $result[1] = $total;
        return $result;
    }

    function getUserFieldsforForm($fieldfor, $refid) {
        if (is_numeric($fieldfor) == false)
            return false;
        if ($refid)
            if (is_numeric($refid) == false)
                return false;
        $db = $this->getDBO();
        $field = array();
        $result = array();
        $query = "SELECT  * FROM `#__js_job_userfields`
					WHERE published = 1 AND fieldfor = " . $fieldfor;
        $db->setQuery($query);
        $rows = $db->loadObjectList();

        $i = 0;
        foreach ($rows as $row) {
            //$result[$i] = $row;
            $field[0] = $row;
            if ($refid != "") {
                $query = "SELECT  * FROM `#__js_job_userfield_data` WHERE referenceid = " . $refid . " AND field = " . $row->id;
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

    function getUserFieldbyId($c_id) {
        if (is_numeric($c_id) == false)
            return false;
        $result = array();
        $db = JFactory :: getDBO();
        $query = "SELECT * FROM #__js_job_userfields WHERE id = " . $db->Quote($c_id);
        $db->setQuery($query);
        $result[0] = $db->loadObject();
        $query = "SELECT * FROM #__js_job_userfieldvalues WHERE field = " . $db->Quote($c_id);
        $db->setQuery($query);
        $result[1] = $db->loadObjectList();
        return $result;
    }

    function storeUserFieldData($data, $refid) {
        if ($refid)
            if (is_numeric($refid) == false)
                return false;
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
                return false;
            }
        }
        return true;
    }

    function storeUserField() {
        $db = JFactory::getDBO();
        $row = $this->getTable('userfield');
        $data = JRequest :: get('post');
        $section = $data['section'];

        if (!$row->bind($data)) {
            $this->setError($this->_db->getErrorMsg());
            return false;
        }
        if (!$row->check()) {
            $this->setError($this->_db->getErrorMsg());
            return 2;
        }
        if (!$row->store()) {
            $this->setError($this->_db->getErrorMsg());
            return false;
        }
        // add in field ordering
        if ($data['id'] == '') { // only for new
            if ($data['fieldfor'] == 3) {
                $query = "INSERT INTO #__js_job_fieldsordering
						(field, fieldtitle, ordering, section, fieldfor, published,isvisitorpublished, sys, cannotunpublish)
						VALUES(" . $row->id . ",'" . $data['title'] . "', ( SELECT max(ordering)+1 FROM #__js_job_fieldsordering AS field WHERE fieldfor = " . $data['fieldfor'] . " AND section=" . $section . ")," . $section . "
						," . $data['fieldfor'] . "," . $data['published'] . "," . $data['published'] . " ,0,0)
				";
            } else {
                $query = "INSERT INTO #__js_job_fieldsordering
						(field, fieldtitle, ordering, section, fieldfor, published,isvisitorpublished, sys, cannotunpublish)
						VALUES(" . $row->id . ",'" . $data['title'] . "', ( SELECT max(ordering)+1 FROM #__js_job_fieldsordering AS field WHERE fieldfor = " . $data['fieldfor'] . "), ''
						, " . $data['fieldfor'] . "," . $data['published'] . "," . $data['published'] . " ,0,0)
				";
            }
            $db->setQuery($query);
            if (!$db->query()) {
                return false;
            }
        } elseif ($data['id']) {
            if ($data['fieldfor'] == 3) {
                $query = "SELECT max(ordering)+1 FROM #__js_job_fieldsordering AS field WHERE fieldfor = " . $data['fieldfor'] . " AND section=" . $section;
                $db->setQuery($query);
                $sec_max_ordering = $db->loadResult();
                $query = "UPDATE #__js_job_fieldsordering 
					SET  ordering=" . $sec_max_ordering . ",section=" . $section . " WHERE  fieldfor=" . $data['fieldfor'] . " AND field= " . $data['id'];
                $db->setQuery($query);
                if (!$db->query()) {
                    return false;
                }
            }
        }
        // store values
        $ids = $data['jsIds'];
        $names = $data['jsNames'];
        $values = $data['jsValues'];
        $fieldvaluerow = $this->getTable('userfieldvalue');
        for ($i = 0; $i <= $data['valueCount']; $i++) {
            $fieldvaluedata = array();
            if (isset($ids[$i]))
                $fieldvaluedata['id'] = $ids[$i];
            else
                $fieldvaluedata['id'] = '';
            $fieldvaluedata['field'] = $row->id;
            $fieldvaluedata['fieldtitle'] = $names[$i];
            $fieldvaluedata['fieldvalue'] = $values[$i];
            $fieldvaluedata['ordering'] = $i + 1;
            $fieldvaluedata['sys'] = 0;
            if (!$fieldvaluerow->bind($fieldvaluedata)) {
                $this->setError($this->_db->getErrorMsg());
                return false;
            }
            if (!$fieldvaluerow->store()) {
                $this->setError($this->_db->getErrorMsg());
                return false;
            }
        }
        return true;
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

    function deleteUserField() {
        $cids = JRequest :: getVar('cid', array(0), 'post', 'array');
        $row = $this->getTable('userfield');
        $deleteall = 1;
        foreach ($cids as $cid) {
            if ($this->userFieldCanDelete($cid) == true) {
                if (!$row->delete($cid)) {
                    $this->setError($row->getErrorMsg());
                    return false;
                } else {
                    $db = $this->getDbo();
                    $query = "DELETE fieldvalues FROM `#__js_job_userfieldvalues` AS fieldvalues WHERE fieldvalues.field = " . $cid;
                    $db->setQuery($query);
                    $db->query();
                    $query = "DELETE fieldordering FROM `#__js_job_fieldsordering` AS fieldordering WHERE fieldordering.field = " . $cid;
                    $db->setQuery($query);
                    $db->query();
                }
            } else
                $deleteall++;
        }
        return $deleteall;
    }

    function userFieldCanDelete($field) {
        if (is_numeric($field) === false)
            return false;
        $db = $this->getDBO();

        $query = "SELECT COUNT(id) AS total FROM `#__js_job_userfield_data` WHERE field = " . $field;

        $db->setQuery($query);
        $total = $db->loadResult();

        if ($total > 0)
            return false;
        else
            return true;
    }

}

?>