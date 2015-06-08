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

class JSJobsControllerHighesteducation extends JSController{

    function __construct() {
        parent :: __construct();
        $this->registerTask('add', 'edit');
    }

    function editjobhighesteducation() {
        JRequest :: setVar('layout', 'formhighesteducation');
        JRequest :: setVar('view', 'highesteducation');
        JRequest :: setVar('c', 'highesteducation');
        $this->display();
    }

    function savejobhighesteducation() {
        $redirect = $this->savehighesteducation('saveclose');
    }

    function savejobhighesteducationsave() {
        $redirect = $this->savehighesteducation('save');
    }

    function savejobhighesteducationandnew() {
        $redirect = $this->savehighesteducation('saveandnew');
    }

    function savehighesteducation($callfrom) {
        $highesteducation_model = $this->getmodel('Highesteducation', 'JSJobsModel');
        $return_value = $highesteducation_model->storeHighestEducation();
        $link = 'index.php?option=com_jsjobs&c=highesteducation&view=highesteducation&layout=highesteducations';
        if (is_array($return_value)) {
            if ($return_value['issharing'] == 1) {
                if ($return_value['return_value'] == false) { // jobsharing return value 
                    $msg = JText::_('JS_HIGHEST_EDUCATION_SAVED');
                    if ($return_value['rejected_value'] != "")
                        $msg = JText::_('JS_HIGHEST_EDUCATION_SAVED_BUT_SHARING_SERVER_NOT_ACCEPT_THE_JOB_OF_THESE_HEIGHEST_EDUCATION_DUE_TO_IMPROPER_NAME');
                    if ($return_value['authentication_value'] != "")
                        $msg = JText::_('JS_HIGHEST_EDUCATION_SAVED_BUT_AUTHENTICATION_FAILED_ON_SHARING_SERVER');
                    if ($return_value['server_responce'] != "")
                        $msg = JText::_('JS_HIGHEST_EDUCATION_SAVED_BUT_PROBLEM_SYNCHRONIZE_WITH_SHARING_SERVER');
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
                $msg = JText::_('JS_HIGHEST_EDUCATION_SAVED');
                if ($callfrom == 'saveclose') {
                    $link = 'index.php?option=com_jsjobs&c=highesteducation&view=highesteducation&layout=highesteducations';
                } elseif ($callfrom == 'save') {
                    $link = 'index.php?option=com_jsjobs&c=highesteducation&view=highesteducation&layout=formhighesteducation&cid[]=' . $return_value[2];
                } elseif ($callfrom == 'saveandnew') {
                    $link = 'index.php?option=com_jsjobs&c=highesteducation&view=highesteducation&layout=formhighesteducation';
                }
                $this->setRedirect($link, $msg);
            } elseif ($return_value == false) {
                $msg = JText::_('JS_ERROR_SAVING_HIGHEST_EDUCATION');
                $this->setRedirect($link, $msg);
            }
        } else {
            if ($return_value == 3) {
                $msg = JText::_('JS_HIGHEST_EDUCATION_ALREADY_EXIST');
                JRequest :: setVar('view', 'highesteducation');
                JRequest :: setVar('hidemainmenu', 1);
                JRequest :: setVar('layout', 'formhighesteducation');
                JRequest :: setVar('msg', $msg);
                $this->display();
            } else {
                $msg = JText::_('JS_ERROR_SAVING_HIGHEST_EDUCATION');
                $this->setRedirect($link, $msg);
            }
        }
    }

    function remove() {
        $highesteducation_model = $this->getmodel('Highesteducation', 'JSJobsModel');
        $returnvalue = $highesteducation_model->deleteHighestEducation();
        if ($returnvalue == 1)
            $msg = JText::_('JS_HIGHEST_EDUCATION_DELETED');
        else
            $msg = $returnvalue - 1 . ' ' . JText::_('JS_ERROR_HIGHEST_EDUCATION_COULD_NOT_DELETE');
        $this->setRedirect('index.php?option=com_jsjobs&c=highesteducation&view=highesteducation&layout=highesteducations', $msg);
    }

    function cancel() {
        $msg = JText::_('OPERATION_CANCELLED');
        $this->setRedirect('index.php?option=com_jsjobs&c=highesteducation&view=highesteducation&layout=highesteducations', $msg);
    }

    function display($cachable = false, $urlparams = false) {
        $document = JFactory :: getDocument();
        $viewName = JRequest :: getVar('view', 'highesteducation');
        $layoutName = JRequest :: getVar('layout', 'highesteducation');
        $viewType = $document->getType();
        $view = $this->getView($viewName, $viewType);
        $jobsharing_model = $this->getModel('Jobsharing', 'JSJobsModel');
        $configuration_model = $this->getModel('Configuration', 'JSJobsModel');
        $highesteducation_model = $this->getModel('Highesteducation', 'JSJobsModel');
        if (!JError :: isError($jobsharing_model) && !JError::isError($configuration_model) && !JError::isError($highesteducation_model)) {
            $view->setModel($jobsharing_model, true);
            $view->setModel($configuration_model, true);
            $view->setModel($highesteducation_model, true);
        }
        $view->setLayout($layoutName);
        $view->display();
    }

}

?>