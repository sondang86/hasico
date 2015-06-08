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

class JSJobsControllerJobstatus extends JSController{

    function __construct() {
        parent :: __construct();
        $this->registerTask('add', 'edit');
    }

    function edijobstatus() {
        JRequest :: setVar('layout', 'formjobstatus');
        JRequest :: setVar('view', 'jobstatus');
        JRequest :: setVar('c', 'jobstatus');
        $this->display();
    }

    function savejobstatus() {
        $redirect = $this->storejobStatus('saveclose');
    }

    function savejobstatussave() {
        $redirect = $this->storejobStatus('save');
    }

    function savejobstatusandnew() {
        $redirect = $this->storejobStatus('saveandnew');
    }

    function storejobStatus($callfrom) {
        $jobstatus_model = $this->getmodel('Jobstatus', 'JSJobsModel');
        $return_value = $jobstatus_model->storeJobStatus();
        $link = 'index.php?option=com_jsjobs&c=jobstatus&view=jobstatus&layout=jobstatus';
        if (is_array($return_value)) {
            if ($return_value['issharing'] == 1) {
                if ($return_value['return_value'] == false) { // jobsharing return value 
                    $msg = JText::_('JS_JOB_STATUS_SAVED');
                    if ($return_value['rejected_value'] != "")
                        $msg = JText::_('JS_JOB_STATUS_SAVED_BUT_SHARING_SERVER_NOT_ACCEPT_THE_JOB_OF_THESE_JOB_STATUS_DUE_TO_IMPROPER_NAME');
                    if ($return_value['authentication_value'] != "")
                        $msg = JText::_('JS_JOB_STATUS_SAVED_BUT_AUTHENTICATION_FAILED_ON_SHARING_SERVER');
                    if ($return_value['server_responce'] != "")
                        $msg = JText::_('JS_JOB_STATUS_SAVED_BUT_PROBLEM_SYNCHRONIZE_WITH_SHARING_SERVER');
                    $this->setRedirect($link, $msg);
                }elseif ($return_value['return_value'] == true) { // jobsharing return value 
                    $redirect = 1;
                }
            } elseif ($return_value['issharing'] == 0) {
                if ($return_value[1] == 1) {
                    $redirect = 1;
                }
            }
            if ($redirect == 1) {
                $msg = JText::_('JS_JOB_STATUS_SAVED');
                if ($callfrom == 'saveclose') {
                    $link = 'index.php?option=com_jsjobs&c=jobstatus&view=jobstatus&layout=jobstatus';
                } elseif ($callfrom == 'save') {
                    $link = 'index.php?option=com_jsjobs&c=jobstatus&view=jobstatus&layout=formjobstatus&cid[]=' . $return_value[2];
                } elseif ($callfrom == 'saveandnew') {
                    $link = 'index.php?option=com_jsjobs&c=jobstatus&view=jobstatus&layout=formjobstatus';
                }
                $this->setRedirect($link, $msg);
            } elseif ($return_value == false) {
                $msg = JText::_('JS_ERROR_SAVING_JOB_STATUS');
                $this->setRedirect($link, $msg);
            }
        } else {
            if ($return_value == 3) {
                $msg = JText::_('JS_JOB_STATUS_ALREADY_EXIST');
                JRequest :: setVar('view', 'jobstatus');
                JRequest :: setVar('hidemainmenu', 1);
                JRequest :: setVar('layout', 'formjobstatus');
                JRequest :: setVar('msg', $msg);
                $this->display();
            } else {
                $msg = JText::_('JS_ERROR_SAVING_JOB_STATUS');
                $this->setRedirect($link, $msg);
            }
        }
    }

    function remove() {
        $jobstatus_model = $this->getmodel('Jobstatus', 'JSJobsModel');
        $returnvalue = $jobstatus_model->deleteJobStatus();
        if ($returnvalue == 1)
            $msg = JText::_('JS_JOB_STATUS_DELETED');
        else
            $msg = $returnvalue - 1 . ' ' . JText::_('JS_ERROR_JOB_STATUS_COULD_NOT_DELETE');
        $this->setRedirect('index.php?option=com_jsjobs&c=jobstatus&view=jobstatus&layout=jobstatus', $msg);
    }

    function cancel() {
        $msg = JText::_('OPERATION_CANCELLED');
        $this->setRedirect('index.php?option=com_jsjobs&c=jobstatus&view=jobstatus&layout=jobstatus', $msg);
    }

    function display($cachable = false, $urlparams = false) {
        $document = JFactory :: getDocument();
        $viewName = JRequest :: getVar('view', 'jobstatus');
        $layoutName = JRequest :: getVar('layout', 'jobstatus');
        $viewType = $document->getType();
        $view = $this->getView($viewName, $viewType);
        $jobsharing_model = $this->getModel('Jobsharing', 'JSJobsModel');
        $configuration_model = $this->getModel('Configuration', 'JSJobsModel');
        $jobstatus_model = $this->getModel('Jobstatus', 'JSJobsModel');
        if (!JError :: isError($jobsharing_model) && !JError::isError($configuration_model) && !JError::isError($jobstatus_model)) {
            $view->setModel($jobsharing_model, true);
            $view->setModel($configuration_model);
            $view->setModel($jobstatus_model);
        }
        $view->setLayout($layoutName);
        $view->display();
    }

}

?>