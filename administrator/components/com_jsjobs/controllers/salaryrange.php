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

class JSJobsControllerSalaryrange extends JSController{

    function __construct() {
        parent :: __construct();
        $this->registerTask('add', 'edit');
    }

    function editjobsalaryrange() {
        JRequest :: setVar('layout', 'formsalaryrange');
        JRequest :: setVar('view', 'salaryrange');
        JRequest :: setVar('c', 'salaryrange');
        $this->display();
    }

    function cancel() {
        $msg = JText::_('OPERATION_CANCELLED');
        $this->setRedirect('index.php?option=com_jsjobs&c=salaryrange&view=salaryrange&layout=salaryrange', $msg);
    }

    function remove() {
        $salaryrange_model = $this->getmodel('Salaryrange', 'JSJobsModel');
        $returnvalue = $salaryrange_model->deleteSalaryRange();
        if ($returnvalue == 1) {
            $msg = JText::_('SALARY_RANGE_DELETED');
        } else {
            $msg = $returnvalue - 1 . ' ' . JText::_('ERROR_RANGE_COULD_NOT_DELETE');
        }
        $this->setRedirect('index.php?option=com_jsjobs&c=salaryrange&view=salaryrange&layout=salaryrange', $msg);
    }

    function savejobsalaryrange() {
        $redirect = $this->savesalaryrange('saveclose');
    }

    function savejobsalaryrangesave() {
        $redirect = $this->savesalaryrange('save');
    }

    function savejobsalaryrangeandnew() {
        $redirect = $this->savesalaryrange('saveandnew');
    }

    function savesalaryrange($callfrom) {
        $salaryrange_model = $this->getmodel('Salaryrange', 'JSJobsModel');
        $return_value = $salaryrange_model->storeSalaryRange();
        $link = 'index.php?option=com_jsjobs&c=salaryrange&view=salaryrange&layout=salaryrange';
        if (is_array($return_value)) {
            if ($return_value['issharing'] == 1) {
                if ($return_value['return_value'] == false) { // jobsharing return value 
                    $msg = JText::_('SALARY_RANGE_SAVED');
                    if ($return_value['rejected_value'] != "")
                        $msg = JText::_('SALARY_RANGE_SAVED_BUT_SHARING_SERVER_NOT_ACCEPT_THE_JOB_OF_THESE_SALARYRANGE_DUE_TO_IMPROPER_NAME');
                    if ($return_value['authentication_value'] != "")
                        $msg = JText::_('SALARY_RANGE_SAVED_BUT_AUTHENTICATION_FAILED_ON_SHARING_SERVER');
                    if ($return_value['server_responce'] != "")
                        $msg = JText::_('SALARY_RANGE_SAVED_BUT_PROBLEM_SYNCHRONIZE_WITH_SHARING_SERVER');
                    $this->setRedirect($link, $msg);
                }elseif ($return_value['return_value'] == true) { // jobsharing return value 
                    $redirect = 1;

                    $msg = JText::_('SALARY_RANGE_SAVED');
                    $this->setRedirect($link, $msg);
                }
            } elseif ($return_value['issharing'] == 0) {
                if ($return_value[1] == 1) {
                    $redirect = 1;
                    $msg = JText::_('SALARY_RANGE_SAVED');
                    $link = 'index.php?option=com_jsjobs&c=salaryrange&view=salaryrange&layout=salaryrange';
                    $this->setRedirect($link, $msg);
                } else if ($return_value[1] == 2) {
                    $msg = JText::_('ALL_FIELD_MUST_BE_ENTERD');
                    JRequest :: setVar('view', 'salaryrange');
                    JRequest :: setVar('hidemainmenu', 1);
                    JRequest :: setVar('layout', 'formsalaryrange');
                    JRequest :: setVar('msg', $msg);
                    // Display based on the set variables
                    $this->display();
                }
            }
            if ($redirect == 1) {
                $msg = JText::_('SALARY_RANGE_SAVED');
                if ($callfrom == 'saveclose') {
                    $link = 'index.php?option=com_jsjobs&c=salaryrange&view=salaryrange&layout=salaryrange';
                } elseif ($callfrom == 'save') {
                    $link = 'index.php?option=com_jsjobs&c=salaryrange&view=salaryrange&layout=formsalaryrange&cid[]=' . $return_value[2];
                } elseif ($callfrom == 'saveandnew') {
                    $link = 'index.php?option=com_jsjobs&c=salaryrange&view=salaryrange&layout=formsalaryrange';
                }
                $this->setRedirect($link, $msg);
            } elseif ($return_value == false) {
                $msg = JText::_('JS_ERROR_SAVING_AGE');
                $this->setRedirect($link, $msg);
            }
        } else {
            if ($return_value == 3) {
                $msg = JText::_('RANGE_ALREADY_EXIST');
                JRequest :: setVar('view', 'salaryrange');
                JRequest :: setVar('hidemainmenu', 1);
                JRequest :: setVar('layout', 'formsalaryrange');
                JRequest :: setVar('msg', $msg);
                $this->display();
            } else {
                $msg = JText::_('ERROR_SAVING_RANGE');
                $link = 'index.php?option=com_jsjobs&c=salaryrange&view=salaryrange&layout=salaryrange';
                $this->setRedirect($link, $msg);
            }
        }
    }

    function display($cachable = false, $urlparams = false) {
        $document = JFactory :: getDocument();
        $viewName = JRequest :: getVar('view', 'salaryrange');
        $layoutName = JRequest :: getVar('layout', 'salaryrange');
        $viewType = $document->getType();
        $view = $this->getView($viewName, $viewType);
        $jobsharing_model = $this->getModel('Jobsharing', 'JSJobsModel');
        $configuration_model = $this->getModel('Configuration', 'JSJobsModel');
        $salaryrange_model = $this->getModel('Salaryrange', 'JSJobsModel');
        if (!JError :: isError($jobsharing_model) && !JError::isError($configuration_model) && !JError::isError($salaryrange_model)) {
            $view->setModel($jobsharing_model, true);
            $view->setModel($configuration_model);
            $view->setModel($salaryrange_model);
        }
        $view->setLayout($layoutName);
        $view->display();
    }

}

?>