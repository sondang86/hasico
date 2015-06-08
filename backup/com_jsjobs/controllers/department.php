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
 * File Name:	controllers/jsjobs.php
  ^
 * Description: Controller class for application data
  ^
 * History:		NONE
  ^
 */
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controller');

class JSJobsControllerDepartment extends JSController {

    var $_router_mode_sef = null;

    function __construct() {
        $app = JFactory::getApplication();
        $user = JFactory::getUser();
        if ($user->guest) { // redirect user if not login
            $link = 'index.php?option=com_user';
            $this->setRedirect($link);
        }
        $router = $app->getRouter();
        if ($router->getMode() == JROUTER_MODE_SEF) {
            $this->_router_mode_sef = 1; // sef true
        } else {
            $this->_router_mode_sef = 2; // sef false
        }
        parent :: __construct();
    }

    function savedepartment() { //save department
        $jobsharing = $this->getModel('jobsharingsite', 'JSJobsModel');
        $uid = JRequest::getString('uid', 'none');
        $Itemid = JRequest::getVar('Itemid');
        $department = $this->getmodel('Department', 'JSJobsModel');
        $return_value = $department->storeDepartment();
        if ($return_value == 1) {
            $msg = JText :: _('JS_DEPARTMENT_SAVED');
        } else if ($return_value == 2) {
            $msg = JText :: _('JS_FILL_REQ_FIELDS');
        } else {
            $msg = JText :: _('JS_ERROR_SAVING_DEPARTMENT');
        }
        $link = 'index.php?option=com_jsjobs&c=department&view=department&layout=mydepartments&Itemid=' . $Itemid;
        $this->setRedirect(JRoute::_($link), $msg);
    }

    function deletedepartment() { //delete department
        $user = JFactory::getUser();
        $uid = $user->id;
        $Itemid = JRequest::getVar('Itemid');
        $common = $this->getmodel('Common', 'JSJobsModel');
        $departmentid = $common->parseId(JRequest::getVar('pd', ''));
        $department = $this->getmodel('Department', 'JSJobsModel');
        $return_value = $department->deleteDepartment($departmentid, $uid);
        $jobsharing = $this->getModel('jobsharingsite', 'JSJobsModel');
        if ($return_value == 1) {
            $msg = JText :: _('JS_DEPARTMENT_DELETED');
        } elseif ($return_value == 2) {
            $msg = JText :: _('JS_DEPARTMENT_CANNOT_DELETE');
        } elseif ($return_value == 3) {
            $msg = JText :: _('JS_NOT_YOUR_DEPARTMENT');
        } else {
            $msg = JText :: _('JS_ERROR_DELETING_DEPARTMENT');
        }
        $link = 'index.php?option=com_jsjobs&c=department&view=department&layout=mydepartments&Itemid=' . $Itemid;
        $this->setRedirect(JRoute::_($link), $msg);
    }

    function listdepartments() {
        $val = JRequest::getVar('val');
        $depatments = $this->getmodel('Department', 'JSJobsModel');
        $returnvalue = $depatments->listDepartments($val);
        echo $returnvalue;
        JFactory::getApplication()->close();
    }

    function display($cachable = false, $urlparams = false) {
        $document = JFactory :: getDocument();
        $viewName = JRequest :: getVar('view', 'resume');
        $viewName = JRequest :: getVar('view', 'department');
        $layoutName = JRequest :: getVar('layout', 'formdepartment');
        $viewType = $document->getType();
        $view = $this->getView($viewName, $viewType);
        $view->setLayout($layoutName);
        $view->display();
    }

}

?>