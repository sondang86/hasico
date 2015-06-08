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

class JSJobsControllerJobtype extends JSController{

    function __construct() {
        parent :: __construct();
        $this->registerTask('add', 'edit');
    }

    function editjobtype() {
        JRequest :: setVar('layout', 'formjobtype');
        JRequest :: setVar('view', 'jobtype');
        JRequest :: setVar('c', 'jobtype');
        $this->display();
    }

    function savejobtype() {
        $redirect = $this->storejobtype('saveclose');
    }

    function savejobtypesave() {
        $redirect = $this->storejobtype('save');
    }

    function savejobtypeandnew() {
        $redirect = $this->storejobtype('saveandnew');
    }

    function storejobtype($callfrom) {
        $jobtype_model = $this->getmodel('Jobtype', 'JSJobsModel');
        $return_value = $jobtype_model->storeJobType();
        $link = 'index.php?option=com_jsjobs&c=jobtype&view=jobtype&layout=jobtypes';
        if (is_array($return_value)) {
            if ($return_value['issharing'] == 1) {
                if ($return_value['return_value'] == false) { // jobsharing return value 
                    $msg = JText::_('JS_JOB_TYPE_SAVED');
                    if ($return_value['rejected_value'] != "")
                        $msg = JText::_('JS_JOB_TYPE_SAVED_BUT_SHARING_SERVER_NOT_ACCEPT_THE_JOB_OF_THESE_JOB_TYPE_DUE_TO_IMPROPER_NAME');
                    if ($return_value['authentication_value'] != "")
                        $msg = JText::_('JS_JOB_TYPE_SAVED_BUT_AUTHENTICATION_FAILED_ON_SHARING_SERVER');
                    if ($return_value['server_responce'] != "")
                        $msg = JText::_('JS_JOB_TYPE_SAVED_BUT_PROBLEM_SYNCHRONIZE_WITH_SHARING_SERVER');
                    $this->setRedirect($link, $msg);
                }elseif ($return_value == true) { // jobsharing return value 
                    $redirect = 1;
                }
            } elseif ($return_value['issharing'] == 0) {
                if ($return_value[1] == 1) {
                    $redirect = 1;
                }
            }
            if ($redirect == 1) {
                $msg = JText::_('JS_JOB_TYPE_SAVED');
                if ($callfrom == 'saveclose') {
                    $link = 'index.php?option=com_jsjobs&c=jobtype&view=jobtype&layout=jobtypes';
                } elseif ($callfrom == 'save') {
                    $link = 'index.php?option=com_jsjobs&c=jobtype&view=jobtype&layout=formjobtype&cid[]=' . $return_value[2];
                } elseif ($callfrom == 'saveandnew') {
                    $link = 'index.php?option=com_jsjobs&c=jobtype&view=jobtype&layout=formjobtype';
                }
                $this->setRedirect($link, $msg);
            } elseif ($return_value == false) {
                $msg = JText::_('JS_ERROR_SAVING_JOB_TYPE');
                $this->setRedirect($link, $msg);
            }
        } else {
            if ($return_value == 3) {
                $msg = JText::_('JS_JOB_TYPE_ALREADY_EXIST');
                JRequest :: setVar('view', 'jobtype');
                JRequest :: setVar('hidemainmenu', 1);
                JRequest :: setVar('layout', 'formjobtype');
                JRequest :: setVar('msg', $msg);
                $this->display();
            } else {
                $msg = JText::_('JS_ERROR_SAVING_JOB_TYPE');
                $this->setRedirect($link, $msg);
            }
        }
    }

    function remove() {
        $jobtype_model = $this->getmodel('Jobtype', 'JSJobsModel');
        $returnvalue = $jobtype_model->deleteJobType();
        if ($returnvalue == 1)
            $msg = JText::_('JS_JOB_TYPE_DELETED');
        else
            $msg = $returnvalue - 1 . ' ' . JText::_('JS_ERROR_JOB_TYPE_COULD_NOT_DELETE');
        $this->setRedirect('index.php?option=com_jsjobs&c=jobtype&view=jobtype&layout=jobtypes', $msg);
    }

    function cancel() {
        $msg = JText::_('OPERATION_CANCELLED');
        $this->setRedirect('index.php?option=com_jsjobs&c=jobtype&view=jobtype&layout=jobtypes', $msg);
    }

    function display($cachable = false, $urlparams = false) {
        $document = JFactory :: getDocument();
        $viewName = JRequest :: getVar('view', 'jobtype');
        $layoutName = JRequest :: getVar('layout', 'jobtype');
        $viewType = $document->getType();
        $view = $this->getView($viewName, $viewType);
        $jobsharing_model = $this->getModel('Jobsharing', 'JSJobsModel');
        $configuration_model = $this->getModel('Configuration', 'JSJobsModel');
        $jobtype_model = $this->getModel('Jobtype', 'JSJobsModel');
        if (!JError :: isError($jobsharing_model) && !JError::isError($configuration_model) && !JError::isError($jobtype_model)) {
            $view->setModel($jobsharing_model, true);
            $view->setModel($configuration_model);
            $view->setModel($jobtype_model);
        }
        $view->setLayout($layoutName);
        $view->display();
    }

}

?>