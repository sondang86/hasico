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

class JSJobsControllerSalaryrangetype extends JSController{

    function __construct() {
        parent :: __construct();
        $this->registerTask('add', 'edit');
    }

    function editjobsalaryrangrtype() {
        JRequest :: setVar('layout', 'formsalaryrangetype');
        JRequest :: setVar('view', 'salaryrangetype');
        JRequest :: setVar('c', 'salaryrangetype');
        $this->display();
    }

    function savejobsalaryrangetype() {
        $redirect = $this->savesalaryrangetype('saveclose');
    }

    function savejobsalaryrangetypesave() {
        $redirect = $this->savesalaryrangetype('save');
    }

    function savejobsalaryrangetypeandnew() {
        $redirect = $this->savesalaryrangetype('saveandnew');
    }

    function savesalaryrangetype($callfrom) {
        $salaryrangetype_model = $this->getmodel('Salaryrangetype', 'JSJobsModel');
        $return_value = $salaryrangetype_model->storeSalaryRangeType();
        $link = 'index.php?option=com_jsjobs&c=salaryrangetype&view=salaryrangetype&layout=salaryrangetype';
        if (is_array($return_value)) {
            if ($return_value['issharing'] == 1) {
                if ($return_value['return_value'] == false) { // jobsharing return value 
                    $msg = JText::_('JS_SALARY_RANGE_TYPE_SAVED');
                    if ($return_value['rejected_value'] != "")
                        $msg = JText::_('JS_SALARY_RANGE_TYPE_SAVED_BUT_SHARING_SERVER_NOT_ACCEPT_THE_JOB_OF_THESE_SALARY_RANGE_TYPE_DUE_TO_IMPROPER_NAME');
                    if ($return_value['authentication_value'] != "")
                        $msg = JText::_('JS_SALARY_RANGE_TYPE_SAVED_BUT_AUTHENTICATION_FAILED_ON_SHARING_SERVER');
                    if ($return_value['server_responce'] != "")
                        $msg = JText::_('JS_SALARY_RANGE_TYPE_SAVED_BUT_PROBLEM_SYNCHRONIZE_WITH_SHARING_SERVER');
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
                $msg = JText::_('JS_SALARY_RANGE_TYPE_SAVED');
                if ($callfrom == 'saveclose') {
                    $link = 'index.php?option=com_jsjobs&c=salaryrangetype&view=salaryrangetype&layout=salaryrangetype';
                } elseif ($callfrom == 'save') {
                    $link = 'index.php?option=com_jsjobs&c=salaryrangetype&view=salaryrangetype&layout=formsalaryrangetype&cid[]=' . $return_value[2];
                } elseif ($callfrom == 'saveandnew') {
                    $link = 'index.php?option=com_jsjobs&c=salaryrangetype&view=salaryrangetype&layout=formsalaryrangetype';
                }
                $this->setRedirect($link, $msg);
            } elseif ($return_value == false) {
                $msg = JText::_('JS_ERROR_SAVING_SALARY_RANGE_TYPE');
                $this->setRedirect($link, $msg);
            }
        } else {
            if ($return_value == 3) {
                $msg = JText::_('JS_SALARY_RANGE_TYPE_ALREADY_EXIST');
                JRequest :: setVar('view', 'salaryrangetype');
                JRequest :: setVar('hidemainmenu', 1);
                JRequest :: setVar('layout', 'formsalaryrangetype');
                JRequest :: setVar('msg', $msg);
                $this->display();
            } else {
                $msg = JText::_('JS_ERROR_SAVING_SALARY_RANGE_TYPE');
                $this->setRedirect($link, $msg);
            }
        }
    }

    function cancel() {
        $msg = JText::_('OPERATION_CANCELLED');
        $this->setRedirect('index.php?option=com_jsjobs&c=salaryrangetype&view=salaryrangetype&layout=salaryrangetype', $msg);
    }

    function remove() {
        $salaryrangetype_model = $this->getmodel('Salaryrangetype', 'JSJobsModel');
        $returnvalue = $salaryrangetype_model->deleteSalaryRangeType();
        if ($returnvalue == 1) {
            $msg = JText::_('JS_SALARY_RANGE_TYPE_DELETED');
        } else {
            $msg = $returnvalue - 1 . ' ' . JText::_('JS_ERROR_SALARY_RANGE_TYPE_COULD_NOT_DELETE');
        }
        $this->setRedirect('index.php?option=com_jsjobs&c=salaryrangetype&view=salaryrangetype&layout=salaryrangetype', $msg);
    }

    function display($cachable = false, $urlparams = false) {
        $document = JFactory :: getDocument();
        $viewName = JRequest :: getVar('view', 'salaryrangetype');
        $layoutName = JRequest :: getVar('layout', 'salaryrangetype');
        $viewType = $document->getType();
        $view = $this->getView($viewName, $viewType);
        $jobsharing_model = $this->getModel('Jobsharing', 'JSJobsModel');
        $configuration_model = $this->getModel('Configuration', 'JSJobsModel');
        $salaryrangetype_model = $this->getModel('Salaryrangetype', 'JSJobsModel');
        if (!JError :: isError($jobsharing_model) && !JError::isError($configuration_model) && !JError::isError($salaryrangetype_model)) {
            $view->setModel($jobsharing_model, true);
            $view->setModel($configuration_model);
            $view->setModel($salaryrangetype_model);
        }
        $view->setLayout($layoutName);
        $view->display();
    }

}

?>