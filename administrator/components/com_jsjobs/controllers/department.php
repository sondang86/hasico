<?php

/**
 * @Copyright Copyright (C) 2010- ... Ahmad Bilal
 * @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * Company:		Al-Barr Technologies
  + Contact:		www.al-barr.com , info@al-barr.com
 * Created on:	Jan 11, 2009
  ^
  + Project: 		JS Jobs
 * File Name:	admin-----/controllers/jsjobs.php
  ^
 * Description: Controller class for admin site
  ^
 * History:		NONE
  ^
 */
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.controller');

class JSJobsControllerDepartment extends JSController{

    function __construct() {
        parent :: __construct();
        $this->registerTask('add', 'edit');
    }

    function departmentapprove() {
        $jobsharing = $this->getModel('jobsharing', 'JSJobsModel');
        $cid = JRequest::getVar('cid', array(), '', 'array');
        $departmentid = $cid[0];
        $department_model = $this->getmodel('Department', 'JSJobsModel');
        $return_value = $department_model->departmentApprove($departmentid);
        if ($return_value == 1) {
            $msg = JText::_('JS_DEPARTMENT_APPROVED');
        } else {
            $msg = JText::_('JS_ERROR_IN_APPROVING_DEPARTMENT');
        }
        $link = 'index.php?option=com_jsjobs&c=department&view=department&layout=departmentqueue';
        $this->setRedirect($link, $msg);
    }

    function departmentreject() {
        $jobsharing = $this->getModel('jobsharing', 'JSJobsModel');
        $cid = JRequest::getVar('cid', array(), '', 'array');
        $departmentid = $cid[0];
        $department_model = $this->getmodel('Department', 'JSJobsModel');
        $return_value = $department_model->departmentReject($departmentid);
        if ($return_value == 1) {
            $msg = JText::_('JS_DEPARTMENT_REJECTED');
        } else {
            $msg = JText::_('JS_ERROR_IN_REJECTING_DEPARTMENT');
        }
        $link = 'index.php?option=com_jsjobs&c=department&view=department&layout=departmentqueue';
        $this->setRedirect($link, $msg);
    }

    function savedepatrment() {
        $jobsharing = $this->getModel('jobsharing', 'JSJobsModel');
        $department_model = $this->getmodel('Department', 'JSJobsModel');
        $return_value = $department_model->storeDepartment();
        if ($return_value == 1) {
            $msg = JText::_('DEPARTMENT_SAVED');
        } else {
            $msg = JText::_('ERROR_SAVING_DEPARTMENT');
        }
        $link = 'index.php?option=com_jsjobs&c=department&view=department&layout=departments';
        $this->setRedirect($link, $msg);
    }

    function listdepartments() {
        $val = JRequest::getVar('val');
        $department_model = $this->getmodel('Department', 'JSJobsModel');
        $returnvalue = $department_model->listDepartments($val);
        echo $returnvalue;
        JFactory::getApplication()->close();
    }

    function edit() {
        JRequest :: setVar('layout', 'formdepartment');
        JRequest :: setVar('view', 'department');
        JRequest :: setVar('c', 'department');
        $this->display();
    }

    function remove() {
        $department_model = $this->getmodel('Department', 'JSJobsModel');
        $returnvalue = $department_model->deleteDepartment();
        if ($returnvalue == 1) {
            $msg = JText::_('DEPARTMENT_DELETED');
        } else {
            $msg = $returnvalue - 1 . ' ' . JText::_('DEPARTMENT_COULD_NOT_DELETE');
        }
        $this->setRedirect('index.php?option=com_jsjobs&c=department&view=department&layout=departments', $msg);
    }

    function cancel() {
        $msg = JText::_('OPERATION_CANCELLED');
        $this->setRedirect('index.php?option=com_jsjobs&c=department&view=department&layout=departments', $msg);
    }

    function display($cachable = false, $urlparams = false) {
        $document = JFactory :: getDocument();
        $viewName = JRequest :: getVar('view', 'department');
        $layoutName = JRequest :: getVar('layout', 'department');
        $viewType = $document->getType();
        $view = $this->getView($viewName, $viewType);
        $jobsharing_model = $this->getModel('Jobsharing', 'JSJobsModel');
        $configuration_model = $this->getModel('Configuration', 'JSJobsModel');
        $department_model = $this->getModel('Department', 'JSJobsModel');
        if (!JError :: isError($jobsharing_model) && !JError::isError($configuration_model) && !JError::isError($department_model)) {
            $view->setModel($jobsharing_model, true);
            $view->setModel($configuration_model);
            $view->setModel($department_model);
        }
        $view->setLayout($layoutName);
        $view->display();
    }

}

?>