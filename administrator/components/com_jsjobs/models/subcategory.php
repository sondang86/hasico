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

class JSJobsModelSubcategory extends JSModel {

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

    function setOrderingSubcategories($categoryid) {
        if (is_numeric($categoryid) == false)
            return false;
        $db = JFactory::getDBO();
        $query = "UPDATE #__js_job_subcategories AS sub
					SET sub.ordering = 0
					WHERE sub.categoryid = " . $categoryid;
        $db->setQuery($query);
        if (!$db->query()) {
            return false;
        }
        $query = " SELECT * FROM #__js_job_subcategories WHERE categoryid = " . $categoryid . " ORDER BY id ASC";
        $db->setQuery($query);
        $subcatbycat = $db->loadObjectList();
        $i = 0;
        foreach ($subcatbycat AS $d) {
            $i++;
            $query = " UPDATE #__js_job_subcategories SET ordering = " . $i . "	WHERE id = " . $d->id;
            $db->setQuery($query);
            if (!$db->query()) {
                return false;
            }
        }
        return true;
    }

    function getSubCategorybyId($c_id, $categoryid) {
        if ($c_id)
            if (is_numeric($c_id) == false)
                return false;
        if ($categoryid)
            if (is_numeric($categoryid) == false)
                return false;
        $db = JFactory :: getDBO();
        if ($c_id) {
            $query = "SELECT subcategory.*,category.cat_title FROM #__js_job_subcategories AS subcategory
						JOIN #__js_job_categories AS category ON category.id = subcategory.categoryid
						WHERE subcategory.id = " . $c_id;
        } elseif ($categoryid) {
            $query = "SELECT category.cat_title ,category.id AS categoryid FROM #__js_job_categories AS category WHERE category.id = " . $categoryid;
        }
        $db->setQuery($query);
        $subcategory = $db->loadObject();
        return $subcategory;
    }

    function getSubCategories($categoryid, $limitstart, $limit) {
        if (is_numeric($categoryid) == false)
            return false;
        $db = JFactory :: getDBO();
        $result = array();
        $query = "SELECT COUNT(id) FROM #__js_job_subcategories WHERE categoryid = " . $categoryid;
        $db->setQuery($query);
        $total = $db->loadResult();

        if ($total <= $limitstart)
            $limitstart = 0;
        $query = "SELECT subcategory.*,category.cat_title 
							FROM #__js_job_subcategories AS subcategory
                            JOIN #__js_job_categories AS category ON category.id = subcategory.categoryid 
                            WHERE subcategory.categoryid = " . $categoryid . " ORDER BY ordering ASC";

        $db->setQuery($query, $limitstart, $limit);
        $subcategories = $db->loadObjectList();

        $query = "SELECT cat_title FROM #__js_job_categories WHERE id = " . $categoryid;
        $db->setQuery($query);
        $category = $db->loadObject();

        $result[0] = $subcategories;
        $result[1] = $total;
        $result[2] = $category;
        return $result;
    }

    function storeSubCategory() {
        $row = $this->getTable('subcategory');

        $data = JRequest :: get('post');
        if (!empty($data['alias']))
            $s_c_alias = $this->getJSModel('common')->removeSpecialCharacter($data['alias']);
        else
            $s_c_alias = $this->getJSModel('common')->removeSpecialCharacter($data['title']);

        $s_c_alias = strtolower(str_replace(' ', '-', $s_c_alias));
        $data['alias'] = $s_c_alias;
        if ($data['id'] == '') { // only for new
            $result = $this->isSubCategoryExist($data['title'], $data['categoryid']);
            if ($result == true)
                return 3;
            else {
                $db = JFactory::getDBO();
                $query = "SELECT max(ordering)+1 AS maxordering FROM #__js_job_subcategories where categoryid=" . $data['categoryid'];
                $db->setQuery($query);
                $ordering = $db->loadResult();
                $data['ordering'] = $ordering;
                $data['isdefault'] = 0;
            }
        }



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
        $server_subcategory_data = array();
        if ($this->_client_auth_key != "") {
            $server_subcategory_data['id'] = $row->id;
            if ($row->categoryid != "" AND $row->categoryid != 0) {
                $db = JFactory::getDBO();
                $query = "SELECT cat.serverid AS servercatid FROM  #__js_job_categories AS cat WHERE cat.id = " . $row->categoryid;
                $db->setQuery($query);
                $servercatid = $db->loadResult();
                if ($servercatid)
                    $server_category_id = $servercatid;
                else
                    $server_category_id = 0;
            }
            $server_subcategory_data['categoryid'] = $server_category_id;
            $server_subcategory_data['title'] = $row->title;
            $server_subcategory_data['alias'] = $row->alias;
            $server_subcategory_data['status'] = $row->status;
            $server_subcategory_data['serverid'] = $row->serverid;
            $server_subcategory_data['authkey'] = $this->_client_auth_key;

            $table = "subcategories";
            $jobsharing = $this->getJSModel('jobsharing');

            $return_value = $jobsharing->storeDefaultTables($server_subcategory_data, $table);
            return $return_value;
        }else {
            return true;
        }
    }

    function subCategoryChangeStatus($id, $status) {
        if (is_numeric($id) == false)
            return false;
        if (is_numeric($status) == false)
            return false;

        $row = $this->getTable('subcategory');
        $row->id = $id;
        $row->status = $status;
        if (!$row->store()) {
            $this->setError($this->_db->getErrorMsg());
            return false;
        }
        return true;
    }

    function deleteSubCategory() {
        $cids = JRequest :: getVar('cid', array(0), 'post', 'array');
        $row = $this->getTable('subcategory');
        $deleteall = 1;
        foreach ($cids as $cid) {
            if ($this->subCategoryCanDelete($cid) == true) {
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

    function subCategoryCanDelete($categoryid) {
        if (is_numeric($categoryid) == false)
            return false;
        $db = $this->getDBO();

        $query = "SELECT
                    ( SELECT COUNT(id) FROM `#__js_job_companies` WHERE category = " . $categoryid . ")
                    + ( SELECT COUNT(id) FROM `#__js_job_jobs` WHERE jobcategory = " . $categoryid . ")
                    + ( SELECT COUNT(id) FROM `#__js_job_resume` WHERE job_category = " . $categoryid . ")
                    + ( SELECT COUNT(id) FROM `#__js_job_subcategories` WHERE id = " . $categoryid . " AND isdefault = 1)
                    AS total ";

        $db->setQuery($query);
        $total = $db->loadResult();

        if ($total > 0)
            return false;
        else
            return true;
    }

    function listSubCategories($val) {
        if (is_numeric($val) === false)
            return false;
        $db = $this->getDBO();

        $query = "SELECT id, title FROM `#__js_job_subcategories` WHERE status = 1 AND categoryid = " . $val . " ORDER BY title ASC";
        $db->setQuery($query);
        $result = $db->loadObjectList();

        if (isset($result)) {
            $return_value = "<select name='subcategoryid' class='inputbox' >\n";
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
        $query.= " ORDER BY ordering ";
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

    function isSubCategoryExist($title, $categoryid) {
        $db = JFactory::getDBO();

        $query = "SELECT COUNT(id) FROM #__js_job_subcategories WHERE categoryid=" . $categoryid . " AND title = " . $db->Quote($title);
        $db->setQuery($query);
        $result = $db->loadResult();
        if ($result == 0)
            return false;
        else
            return true;
    }

    function listSubCategoriesForSearch($val) {
        if (is_numeric($val) === false)
            return false;
        $db = $this->getDBO();

        $query = "SELECT id, title FROM `#__js_job_subcategories` WHERE status = 1 AND categoryid = " . $val . " ORDER BY title ASC";
        $db->setQuery($query);
        $result = $db->loadObjectList();

        if (isset($result)) {
            $return_value = "<select name='jobsubcategory' class='inputbox' >\n";
            $return_value .= "<option value='' >" . JText::_('JS_SUB_CATEGORY') . "</option> \n";
            foreach ($result as $row) {
                $return_value .= "<option value=\"$row->id\" >$row->title</option> \n";
            }
            $return_value .= "</select>\n";
        }
        return $return_value;
    }

}

?>