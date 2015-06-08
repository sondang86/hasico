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

class JSJobsModelFieldordering extends JSModel{

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

    function getResumeSections($cid) {
        if (is_numeric($cid) === false)
            return false;
        $db = JFactory::getDBO();
        $section = array();
        $query = " SELECT section  
					FROM `#__js_job_fieldsordering`	
					WHERE fieldfor = 3 AND field=" . $cid;
        $db->setQuery($query);
        $sid = $db->loadResult();
        $section[] = array('value' => '', 'text' => JText::_('JS_SELECT_SECTION'));
        $query = " SELECT field,section  
					FROM `#__js_job_fieldsordering`	
					WHERE fieldfor = 3  GROUP BY section asc ";
        $db->setQuery($query);
        $result = $db->loadObjectList();
        foreach ($result AS $res) {
            $section[] = array('value' => $res->section, 'text' => $res->field);
        }
        if ($cid)
            $list = JHTML::_('select.genericList', $section, 'section', 'class="inputbox required" ' . '', 'value', 'text', $sid);
        else
            $list = JHTML::_('select.genericList', $section, 'section', 'class="inputbox required" ' . '', 'value', 'text', '');
        return $list;
    }

    function fieldRequired($cids, $value) {
        $db = JFactory::getDBO();
        foreach ($cids AS $cid) {
            $query = " UPDATE #__js_job_fieldsordering	SET required = " . $value . " WHERE id = " . $cid . " AND sys=0";
            $db->setQuery($query);
            if (!$db->query())
                return false;
        }
        return true;
    }

    function fieldNotRequired($cids, $value) {
        $db = JFactory::getDBO();
        foreach ($cids AS $cid) {
            $query = " UPDATE #__js_job_fieldsordering	SET required = " . $value . " WHERE id = " . $cid . " AND sys=0";
            $db->setQuery($query);
            if (!$db->query())
                return false;
        }
        return true;
    }

    function getFieldsOrdering($fieldfor, $limitstart, $limit) {
        if (is_numeric($fieldfor) == false)
            return false;
        $db = JFactory :: getDBO();
        $result = array();

        $query = 'SELECT COUNT(id) FROM #__js_job_fieldsordering WHERE fieldfor = ' . $fieldfor;
        $db->setQuery($query);
        $total = $db->loadResult();
        if ($total <= $limitstart)
            $limitstart = 0;

        $query = 'SELECT field.* ,userfield.title as userfieldtitle
					FROM #__js_job_fieldsordering AS field
					LEFT JOIN #__js_job_userfields AS userfield ON field.field = userfield.id
					WHERE field.fieldfor = ' . $fieldfor;
        $query .= ' ORDER BY';
        if ($fieldfor == 3)
            $query .=' field.section,';
        $query .= ' field.ordering';
        $db->setQuery($query, $limitstart, $limit);

        $result[0] = $db->loadObjectList();
        $result[1] = $total;
        return $result;
    }

    function getFieldsOrderingforForm($fieldfor) {
        if (is_numeric($fieldfor) == false)
            return false;
        $db = $this->getDBO();
        $query = "SELECT  * FROM `#__js_job_fieldsordering`
					WHERE published = 1 AND fieldfor =  " . $fieldfor . " ORDER BY";
        if ($fieldfor == 3)
            $query.=" section ,";
        $query.=" ordering";
        $db->setQuery($query);
        $fieldordering = $db->loadObjectList();
        return $fieldordering;
    }

    function getResumeUserFields($ff) {
        $result = array();
        $db = JFactory :: getDBO();
        $query = "SELECT * FROM #__js_job_fieldsordering 
					WHERE fieldfor = " . $ff . " 
					AND (field = 'section_userfields' OR field = 'userfield1' OR field = 'userfield2'
					OR field = 'userfield3' OR field = 'userfield4' OR field = 'userfield5' OR field = 'userfield6'
					OR field = 'userfield7' OR field = 'userfield8' OR field = 'userfield9' )";

        $db->setQuery($query);
        $result = $db->loadObjectList();

        return $result;
    }

    function storeResumeUserFields() {
        $db = JFactory::getDBO();
        $data = JRequest :: get('post');
        $fieldvaluerow = $this->getTable('fieldsordering');

        $userfields = $data['userfield'];
        $titles = $data['title'];
        $fieldfor = $data['fieldfor'];
        $publisheds = $data['published'];
        $requireds = $data['required'];
        $id = $data['id'];
        for ($i = 0; $i <= 9; $i++) {

            $fieldvaluedata = array();
            $fieldvaluedata['id'] = $id[$i];
            $fieldvaluedata['field'] = $userfields[$i];

            $fieldvaluedata['fieldtitle'] = $titles[$i];
            $fieldvaluedata['ordering'] = 21 + $i;
            $fieldvaluedata['section'] = 1000;
            $fieldvaluedata['fieldfor'] = $fieldfor;
            $fieldvaluedata['published'] = $publisheds[$i];
            $fieldvaluedata['sys'] = 0;
            $fieldvaluedata['cannotunpublish'] = 0;
            $fieldvaluedata['required'] = $requireds[$i];

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

    function fieldPublished($cid, $value) {
        $return = true;
        foreach ($cid as $field_id) {
            if(!is_numeric($field_id)) return false;
            $db = JFactory::getDBO();
            $query = " UPDATE #__js_job_fieldsordering
                                            SET published = " . $value . "
                                            WHERE cannotunpublish = 0 AND id = " . $field_id;
            $db->setQuery($query);
            if (!$db->query()) {
                $return = false;
            }
        }
        return $return;
    }

    function visitorFieldPublished($cids, $value) {
        $db = JFactory::getDBO();
        foreach ($cids AS $cid) {
            $query = " UPDATE #__js_job_fieldsordering	SET isvisitorpublished = " . $value . "	WHERE cannotunpublish = 0 AND id = " . $cid;
            $db->setQuery($query);
            if (!$db->query()) {
                return false;
            }
        }
        return true;
    }

    function fieldOrderingUp($field_id) {
        if (is_numeric($field_id) == false)
            return false;
        $db = JFactory::getDBO();
        $query = "UPDATE #__js_job_fieldsordering AS f1, #__js_job_fieldsordering AS f2
					SET f1.ordering = f1.ordering - 1
					WHERE f1.ordering = f2.ordering + 1
					AND f1.fieldfor = f2.fieldfor
					AND f2.id = " . $field_id . " ; ";
        $db->setQuery($query);
        if (!$db->query()) {
            return false;
        }

        $query = " UPDATE #__js_job_fieldsordering
					SET ordering = ordering + 1
					WHERE id = " . $field_id . ";"
        ;
        $db->setQuery($query);
        if (!$db->query()) {
            return false;
        }
        return true;
    }

    function fieldOrderingDown($field_id) {
        if (is_numeric($field_id) == false)
            return false;
        $db = JFactory::getDBO();
        $query = "UPDATE #__js_job_fieldsordering AS f1, #__js_job_fieldsordering AS f2
					SET f1.ordering = f1.ordering + 1
					WHERE f1.ordering = f2.ordering - 1
					AND f1.fieldfor = f2.fieldfor
					AND f2.id = " . $field_id . " ; ";

        $db->setQuery($query);
        if (!$db->query()) {
            return false;
        }

        $query = " UPDATE #__js_job_fieldsordering
					SET ordering = ordering - 1
					WHERE id = " . $field_id . ";";
        $db->setQuery($query);
        if (!$db->query()) {
            return false;
        }
        return true;
    }

    function publishunpublishfields($call) {
        ($call == 1) ? $publishunpublish = 1 : $publishunpublish = 0;
        $cids = JRequest::getVar('cid');
        $db = $this->getDbo();
        foreach ($cids AS $cid) {
            $query = "UPDATE `#__js_job_fieldsordering` SET published = " . $publishunpublish . " WHERE cannotunpublish = 0 AND id = " . $cid;
            $db->setQuery($query);
            if (!$db->query())
                return false;
        }
        return true;
    }

}

?>