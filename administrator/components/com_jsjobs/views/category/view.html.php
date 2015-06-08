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

class JSJobsViewCategory extends JSView{

    function display($tpl = null) {
        require_once JPATH_COMPONENT_ADMINISTRATOR . '/views/common.php';
// layout start
        if ($layoutName == 'categories') {        //categories
            JToolBarHelper :: title(JText::_('JS_CATEGORIES'));
            JToolBarHelper :: addNew('category.add');
            JToolBarHelper :: editList('category.edit');
            JToolBarHelper :: cancel('category.cancel');
            JToolBarHelper :: deleteList(JText::_('JS_ARE_YOU_SURE'), 'category.deletecategoryandsubcategory', 'Delete Cat & Sub-Cat');
            $sortby = JRequest::getVar('sortby', 'asc');
            $changesort = JRequest::getVar('changesort', '0');
            $form = 'com_jsjobs.countries.list.';
            $searchname = $mainframe->getUserStateFromRequest($form . 'searchname', 'searchname', '', 'string');
            if ($changesort == 1) {
                $sortby = $this->getSortArg($sortby);
            }
            $result = $this->getJSModel('category')->getAllCategories($searchname, $sortby, $limitstart, $limit);
            $items = $result[0];
            $total = $result[1];
            $lists = $result[2];
            if ($total <= $limitstart)
                $limitstart = 0;
            $pagination = new JPagination($total, $limitstart, $limit);
            $this->assignRef('pagination', $pagination);
            $this->assignRef('lists', $lists);
            $this->assignRef('sort', $sortby);
        }elseif ($layoutName == 'formcategory') {
            if (isset($_GET['cid'][0]))
                $c_id = $_GET['cid'][0];
            else
                $c_id = '';

            if ($c_id == '') {
                $cids = JRequest :: getVar('cid', array(0), 'post', 'array');
                $c_id = $cids[0];
            }
            if (is_numeric($c_id) == true AND $c_id != 0)
                $application = $this->getJSModel('category')->getCategorybyId($c_id);
            if (isset($application->id))
                $isNew = false;
            $text = $isNew ? JText :: _('ADD') : JText :: _('EDIT');
            JToolBarHelper :: title(JText :: _('JS_CATEGORY') . ': <small><small>[ ' . $text . ' ]</small></small>');
            JToolBarHelper :: save('category.savecategory');
            if ($isNew)
                JToolBarHelper :: cancel('category.cancel');
            else
                JToolBarHelper :: cancel('category.cancel', 'Close');
        }
// layout end
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
	function getSortArg($sort) {
		if($sort == 'asc') return "desc";
		else return "asc";
	}

}

?>
