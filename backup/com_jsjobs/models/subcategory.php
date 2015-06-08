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
 * File Name:	models/jsjobs.php
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

class JSJobsModelSubCategory extends JSModel {

    var $_uid = null;
    var $_client_auth_key = null;
    var $_siteurl = null;

    function __construct() {
        parent :: __construct();
        $this->_client_auth_key = $this->getJSModel('common')->getClientAuthenticationKey();
        $this->_siteurl = JURI::root();
        $user = JFactory::getUser();
        $this->_uid = $user->id;
    }

    function listFilterSubCategories($val) {
        if (is_numeric($val) === false)
            return false;
        $db = $this->getDBO();
        $query = "SELECT id, title FROM `#__js_job_subcategories`  WHERE status = 1 AND categoryid = " . $val . " ORDER BY title ASC";
        $db->setQuery($query);
        $result = $db->loadObjectList();

        if (isset($result)) {
            $return_value = "<select name='filter_jobsubcategory' id='filter_jobsubcategory'  class='inputbox' >\n";
            $return_value .= "<option value='' >" . JText::_('JS_SUB_CATEGORY') . "</option> \n";
            foreach ($result as $row) {
                $return_value .= "<option value=\"$row->id\" >$row->title</option> \n";
            }
            $return_value .= "</select>\n";
        }
        return $return_value;
    }

    function listSubCategories($val) {
        if (!is_numeric($val))
            return false;
        $db = $this->getDBO();
        $query = "SELECT id, title FROM `#__js_job_subcategories`  WHERE status = 1 AND categoryid = " . $val . " ORDER BY ordering ASC";
        $db->setQuery($query);
        $result = $db->loadObjectList();
        if (isset($result)) {
            $return_value = "<select name='subcategoryid'  class='inputbox jsjobs-cbo' >\n";
            $return_value .= "<option value='' >" . JText::_('JS_SUB_CATEGORY') . "</option> \n";
            foreach ($result as $row) {
                $return_value .= "<option value=\"$row->id\" >$row->title</option> \n";
            }
            $return_value .= "</select>\n";
        }
        return $return_value;
    }

    function listSubCategoriesForSearch($val) {
        if (!is_numeric($val)) {
            $rv = false;
            return $rv;
        }
        $db = $this->getDBO();
        $query = "SELECT id, title FROM `#__js_job_subcategories`  WHERE status = 1 AND categoryid = " . $val . " ORDER BY ordering ASC";
        $db->setQuery($query);
        $result = $db->loadObjectList();

        if (isset($result)) {
            $return_value = "<select name='jobsubcategory' class='inputbox jsjobs-cbo' >\n";
            $return_value .= "<option value='' >" . JText::_('JS_SUB_CATEGORY') . "</option> \n";
            foreach ($result as $row) {
                $return_value .= "<option value=\"$row->id\" >$row->title</option> \n";
            }
            $return_value .= "</select>\n";
        }
        return $return_value;
    }

    function getSubCategoriesforCombo($categoryid, $title, $value) {
        if (!is_numeric($categoryid))
            return false;
        $db = JFactory::getDBO();
        $query = "SELECT id, title FROM `#__js_job_subcategories` WHERE status = 1 AND categoryid = " . $categoryid;
        if ($this->_client_auth_key != "")
            $query.=" AND serverid!='' AND serverid!=0";
        $query.=" ORDER BY ordering ";
        $db->setQuery($query);
        $rows = $db->loadObjectList();
        if ($db->getErrorNum()) {
            echo $db->stderr();
            return false;
        }
        $subcategories = array();
        if ($title)
            $subcategories[] = array('value' => JText::_($value), 'text' => JText::_($title));
        foreach ($rows as $row) {
            $subcategories[] = array('value' => $row->id, 'text' => JText::_($row->title));
        }
        return $subcategories;
    }

}
?>
    
