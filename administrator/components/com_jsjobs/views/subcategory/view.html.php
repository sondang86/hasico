<?php

/**
 * @Copyright Copyright (C) 2009-2011 ... Ahmad Bilal
 * @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * Company:		Buruj Solutions
  + Contact:		www.burujsolutions.com , ahmad@burujsolutions.com
 * Created on:	Jan 11, 2009
  ^
  + Project: 		JS Jobs
 * File Name:	admin/views/application/view.html.php
  ^
 * Description: View class for single record in the admin
  ^
 * History:		NONE
 * 
 */
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');
jimport('joomla.html.pagination');

class JSJobsViewSubcategory extends JSView{

    function display($tpl = null) {
        require_once JPATH_COMPONENT_ADMINISTRATOR . '/views/common.php';
//        layout start
        if ($layoutName == 'formsubcategory') {          // categories
            if (isset($_GET['cid'][0]))
                $c_id = $_GET['cid'][0];
            else
                $c_id = '';

            if ($c_id == '') {
                $cids = JRequest :: getVar('cid', array(0), 'post', 'array');
                $c_id = $cids[0];
            }
            $session = JFactory::getSession();
            $categoryid = $session->get('sub_categoryid');
            $subcategory = $this->getJSModel('subcategory')->getSubCategorybyId($c_id, $categoryid);
            if (isset($subcategory->id))
                $isNew = false;
            $text = $isNew ? JText :: _('ADD') : JText :: _('EDIT');
            JToolBarHelper :: title(JText :: _('SUB_CATEGORY') . ': <small><small>[ ' . $text . ' ]</small></small>');
            $this->assignRef('subcategory', $subcategory);
            $this->assignRef('categoryid', $categoryid);
            JToolBarHelper :: save('subcategory.savesubcategory');
            if ($isNew)
                JToolBarHelper :: cancel('subcategory.cancelsubcategories');
            else
                JToolBarHelper :: cancel('subcategory.cancelsubcategories', 'Close');
        }elseif ($layoutName == 'subcategories') {        //sub categories
            $categoryid = JRequest :: getVar('cd', '');
            $session = JFactory::getSession();
            $session->set('sub_categoryid', $categoryid);
            $result = $this->getJSModel('subcategory')->getSubCategories($categoryid, $limitstart, $limit);
            JToolBarHelper :: title(JText::_('SUB_CATEGORIES') . ' [' . $result[2]->cat_title . ']');
            JToolBarHelper :: addNew('subcategory.editsubcategories');
            JToolBarHelper :: editList('subcategory.editsubcategories');
            JToolBarHelper :: deleteList(JText::_('JS_ARE_YOU_SURE'), 'subcategory.removesubcategory');
            $items = $result[0];
            $total = $result[1];
            if ($total <= $limitstart)
                $limitstart = 0;
            $pagination = new JPagination($total, $limitstart, $limit);
            $this->assignRef('pagination', $pagination);
        }
//        layout end

        $this->assignRef('config', $config);
        $this->assignRef('application', $application);
        $this->assignRef('items', $items);
        $this->assignRef('theme', $theme);
        $this->assignRef('option', $option);
        $this->assignRef('uid', $uid);
        $this->assignRef('msg', $msg);
        $this->assignRef('isjobsharing', $_client_auth_key);

        parent :: display($tpl);
    }

}

?>
