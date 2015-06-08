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

class JSJobsViewDepartment extends JSView{

    function display($tpl = null) {
        require_once JPATH_COMPONENT_ADMINISTRATOR . '/views/common.php';
//        layout start
        if ($layoutName == 'formdepartment') {
            if (isset($_GET['cid'][0]))
                $c_id = $_GET['cid'][0];
            else
                $c_id = '';
            if ($c_id == '') {
                $cids = JRequest :: getVar('cid', array(0), 'post', 'array');
                $c_id = $cids[0];
            }
            if (is_numeric($c_id) == true)
                $result = $this->getJSModel('department')->getDepartmentById($c_id, $uid);
            if (isset($result[0]->id))
                $isNew = false;
            $text = $isNew ? JText :: _('ADD') : JText :: _('EDIT');
            JToolBarHelper :: title(JText :: _('JS_DEPARTMENT') . ': <small><small>[ ' . $text . ' ]</small></small>');
            $this->assignRef('department', $result[0]);
            $this->assignRef('lists', $result[1]);
            $this->assignRef('uid', $uid);
            JToolBarHelper :: save('department.savedepatrment');
            if ($isNew)
                JToolBarHelper :: cancel('department.cancel');
            else
                JToolBarHelper :: cancel('department.cancel', 'Close');
        }elseif ($layoutName == 'company_departments') {        //employer packages
            JToolBarHelper :: title(JText::_('JS_COMPANY_DEPARTMENTS'));
            JToolBarHelper :: cancel('department.cancel');
            $companyid = JRequest::getVar('md');
            $_SESSION['companyid'] = $companyid;
            $searchcompany = $mainframe->getUserStateFromRequest($option . 'searchcompany', 'searchcompany', '', 'string');
            $searchdepartment = $mainframe->getUserStateFromRequest($option . 'searchdepartment', 'searchdepartment', '', 'string');
            $result = $this->getJSModel('department')->getCompanyDepartments($companyid, $searchcompany, $searchdepartment, $limitstart, $limit);
            $items = $result[0];
            $total = $result[1];
            if (isset($result[2]))
                $lists = $result[2];
            if ($total <= $limitstart)
                $limitstart = 0;
            $pagination = new JPagination($total, $limitstart, $limit);
            $this->assignRef('pagination', $pagination);
            if (isset($lists))
                $this->assignRef('lists', $lists);
            $this->assignRef('companyid', $companyid);
        }elseif ($layoutName == 'departmentqueue') {    //companies queue
            JToolBarHelper :: title(JText::_('JS_DEPARTMENT_QUEUE'));
            $searchcompany = $mainframe->getUserStateFromRequest($option . 'searchcompany', 'searchcompany', '', 'string');
            $searchdepartment = $mainframe->getUserStateFromRequest($option . 'searchdepartment', 'searchdepartment', '', 'string');
            $result = $this->getJSModel('department')->getAllUnapprovedDepartments($searchcompany, $searchdepartment, $limitstart, $limit);
            $items = $result[0];
            $total = $result[1];
            $lists = $result[2];
            if ($total <= $limitstart)
                $limitstart = 0;
            $pagination = new JPagination($total, $limitstart, $limit);
            $this->assignRef('pagination', $pagination);
            $this->assignRef('lists', $lists);
        }elseif ($layoutName == 'departments') {        //employer packages
            JToolBarHelper :: title(JText::_('JS_DEPARTMENTS'));
            JToolBarHelper :: addNew('department.add');
            JToolBarHelper :: editList('department.edit');
            JToolBarHelper :: deleteList(JText::_("JS_ARE_YOU_SURE"),'department.remove');
            $searchcompany = $mainframe->getUserStateFromRequest($option . 'searchcompany', 'searchcompany', '', 'string');
            $searchdepartment = $mainframe->getUserStateFromRequest($option . 'searchdepartment', 'searchdepartment', '', 'string');
            $result = $this->getJSModel('department')->getDepartments($searchcompany, $searchdepartment, $limitstart, $limit);
            $items = $result[0];
            $total = $result[1];
            $lists = $result[2];
            if ($total <= $limitstart)
                $limitstart = 0;
            $pagination = new JPagination($total, $limitstart, $limit);
            $this->assignRef('pagination', $pagination);
            $this->assignRef('lists', $lists);
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
