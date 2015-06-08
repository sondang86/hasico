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

class JSJobsControllerExperience extends JSController{

    function __construct() {
        parent :: __construct();
        $this->registerTask('add', 'edit');
    }

    function editjobexperience() {
        JRequest :: setVar('layout', 'formexperience');
        JRequest :: setVar('view', 'experience');
        JRequest :: setVar('c', 'experience');
        $this->display();
    }

    function savejobexperience() {
        $redirect = $this->saveexperience('saveclose');
    }

    function savejobexperiencesave() {
        $redirect = $this->saveexperience('save');
    }

    function savejobexperienceandnew() {
        $redirect = $this->saveexperience('saveandnew');
    }

    function saveexperience($callfrom) {
        $experience_model = $this->getmodel('Experience', 'JSJobsModel');
        $return_value = $experience_model->storeExperience();
        $link = 'index.php?option=com_jsjobs&c=experience&view=experience&layout=experience';
        if (is_array($return_value)) {
            if ($return_value['issharing'] == 1) {
                if ($return_value['return_value'] == false) { // jobsharing return value 
                    $msg = JText::_('JS_EXPERIENCE_SAVED');
                    if ($return_value['rejected_value'] != "")
                        $msg = JText::_('JS_EXPERIENCE_SAVED_BUT_SHARING_SERVER_NOT_ACCEPT_THE_JOB_OF_THESE_EXPERIENCE_DUE_TO_IMPROPER_NAME');
                    if ($return_value['authentication_value'] != "")
                        $msg = JText::_('JS_EXPERIENCE_SAVED_BUT_AUTHENTICATION_FAILED_ON_SHARING_SERVER');
                    if ($return_value['server_responce'] != "")
                        $msg = JText::_('JS_EXPERIENCE_SAVED_BUT_PROBLEM_SYNCHRONIZE_WITH_SHARING_SERVER');
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
                $msg = JText::_('JS_EXPERIENCE_SAVED');
                if ($callfrom == 'saveclose') {
                    $link = 'index.php?option=com_jsjobs&c=experience&view=experience&layout=experience';
                } elseif ($callfrom == 'save') {
                    $link = 'index.php?option=com_jsjobs&c=experience&view=experience&layout=formexperience&cid[]=' . $return_value[2];
                } elseif ($callfrom == 'saveandnew') {
                    $link = 'index.php?option=com_jsjobs&c=experience&view=experience&layout=formexperience';
                }
                $this->setRedirect($link, $msg);
            } elseif ($return_value == false) {
                $msg = JText::_('JS_ERROR_SAVING_EXPERIENCE');
                $this->setRedirect($link, $msg);
            }
        } else {
            if ($return_value == 3) {
                $msg = JText::_('JS_EXPERIENCE_ALREADY_EXIST');
                JRequest :: setVar('view', 'experience');
                JRequest :: setVar('hidemainmenu', 1);
                JRequest :: setVar('layout', 'formexperience');
                JRequest :: setVar('msg', $msg);
                $this->display();
            } else {
                $msg = JText::_('JS_ERROR_SAVING_EXPERIENCE');
                $this->setRedirect($link, $msg);
            }
        }
    }

    function remove() {
            $experience_model = $this->getmodel('Experience', 'JSJobsModel');
            $returnvalue = $experience_model->deleteExperience();
            if ($returnvalue == 1)
                $msg = JText::_('JS_EXPERIENCE_DELETED');
            else
                $msg = $returnvalue - 1 . ' ' . JText::_('JS_ERROR_EXPERIENCE_COULD_NOT_DELETE');
            $this->setRedirect('index.php?option=com_jsjobs&c=experience&view=experience&layout=experience', $msg);
    }

    function cancel() {
        $msg = JText::_('OPERATION_CANCELLED');
        $this->setRedirect('index.php?option=com_jsjobs&c=experience&view=experience&layout=experience', $msg);
    }

    function display($cachable = false, $urlparams = false) {
        $document = JFactory :: getDocument();
        $viewName = JRequest :: getVar('view', 'experience');
        $layoutName = JRequest :: getVar('layout', 'experience');
        $viewType = $document->getType();
        $view = $this->getView($viewName, $viewType);
        $jobsharing_model = $this->getModel('Jobsharing', 'JSJobsModel');
        $configuration_model = $this->getModel('Configuration', 'JSJobsModel');
        $experience_model = $this->getModel('Experience', 'JSJobsModel');
        if (!JError :: isError($jobsharing_model) && !JError::isError($configuration_model) && !JError::isError($experience_model)) {
            $view->setModel($jobsharing_model, true);
            $view->setModel($configuration_model);
            $view->setModel($experience_model);
        }
        $view->setLayout($layoutName);
        $view->display();
    }

}

?>