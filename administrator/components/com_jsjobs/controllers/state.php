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

class JSJobsControllerState extends JSController{

    function __construct() {
        parent :: __construct();
        $this->registerTask('add', 'edit');
    }

    function editjobstate() {
        JRequest :: setVar('layout', 'formstate');
        JRequest :: setVar('view', 'state');
        JRequest :: setVar('c', 'state');
        $this->display();
    }

    function deletestate() {
        $session = JFactory::getSession();
        $countryid = $session->get('countryid');
        $state_model = $this->getmodel('State', 'JSJobsModel');
        $return_value = $state_model->deleteState();
        if ($return_value == 1) {
            $msg = JText::_('JS_STATE_DELETE');
        } else {
            $msg = $returnvalue - 1 . ' ' . JText::_('JS_STATE_COULD_NOT_DELETE');
        }
        $link = 'index.php?option=com_jsjobs&c=state&view=state&layout=states&ct=' . $countryid;
        $this->setRedirect($link, $msg);
    }

    function publishstates() {
        $ct = JRequest::getVar('ct');
        $state_model = $this->getmodel('State', 'JSJobsModel');
        $return_value = $state_model->publishstates();
        if ($return_value == 1) {
            $msg = JText::_('JS_PUBLISHED');
        } else {
            $msg = JText::_('JS_ERROR_PUBLISHING');
        }

        $link = 'index.php?option=com_jsjobs&c=state&view=state&layout=states&ct=' . $ct;
        $this->setRedirect($link, $msg);
    }

    function unpublishstates() {
        $ct = JRequest::getVar('ct');
        $state_model = $this->getmodel('State', 'JSJobsModel');
        $return_value = $state_model->unpublishstates();
        if ($return_value == 1) {
            $msg = JText::_('JS_UNPUBLISHED');
        } else {
            $msg = JText::_('JS_ERROR_UNPUBLISHING');
        }

        $link = 'index.php?option=com_jsjobs&c=state&view=state&layout=states&ct=' . $ct;
        $this->setRedirect($link, $msg);
    }

    function savestate() {
        $data = JRequest :: get('post');
        $session = JFactory::getSession();
        $countryid = $session->get('countryid');

        $state_model = $this->getmodel('State', 'JSJobsModel');
        $return_value = $state_model->storeState($countryid);
        $link = 'index.php?option=com_jsjobs&c=state&view=state&layout=states&ct=' . $countryid;
        if (is_array($return_value)) {
            if ($return_value['return_value'] == false) { // jobsharing return value 
                $msg = JText::_('JS_STATE_SAVED');
                if ($return_value['rejected_value'] != "")
                    $msg = JText::_('JS_STATE_SAVED_BUT_SHARING_SERVER_NOT_ACCEPT_THE_JOB_OF_THESE_STATE_DUE_TO_IMPROPER_NAME');
                if ($return_value['authentication_value'] != "")
                    $msg = JText::_('JS_STATE_SAVED_BUT_AUTHENTICATION_FAILED_ON_SHARING_SERVER');
                if ($return_value['server_responce'] != "")
                    $msg = JText::_('JS_STATE_SAVED_BUT_PROBLEM_SYNCHRONIZE_WITH_SHARING_SERVER');
                $this->setRedirect($link, $msg);
            }elseif ($return_value['return_value'] == true) { // jobsharing return value 
                $msg = JText::_('JS_STATE_SAVED');
                $this->setRedirect($link, $msg);
            }
        } else {
            if ($return_value == 1) {
                $msg = JText::_('JS_STATE_SAVED');
                $this->setRedirect($link, $msg);
            } elseif ($return_value == 3) {
                $msg = JText::_('JS_STATE_EXIST');
                JRequest :: setVar('view', 'state');
                JRequest :: setVar('hidemainmenu', 1);
                JRequest :: setVar('layout', 'formstate');
                JRequest :: setVar('msg', $msg);
                $this->display();
            } else {
                $msg = JText::_('JS_ERROR_SAVING_STATE');
                $this->setRedirect($link, $msg);
            }
        }
    }

    function cancel() {
        $msg = JText::_('OPERATION_CANCELLED');
        if (isset($_SESSION['js_countrycode']))
            $countrycode = $_SESSION['js_countrycode'];;
        $this->setRedirect('index.php?option=com_jsjobs&c=state&view=state&layout=states&ct=' . $countrycode, $msg);
    }

    function display($cachable = false, $urlparams = false) {
        $document = JFactory :: getDocument();
        $viewName = JRequest :: getVar('view', 'state');
        $layoutName = JRequest :: getVar('layout', 'state');
        $viewType = $document->getType();
        $view = $this->getView($viewName, $viewType);
        $jobsharing_model = $this->getModel('Jobsharing', 'JSJobsModel');
        $configuration_model = $this->getModel('Configuration', 'JSJobsModel');
        $state_model = $this->getModel('State', 'JSJobsModel');
        if (!JError :: isError($jobsharing_model) && !JError::isError($configuration_model) && !JError::isError($state_model)) {
            $view->setModel($jobsharing_model, true);
            $view->setModel($configuration_model);
            $view->setModel($state_model);
        }
        $view->setLayout($layoutName);
        $view->display();
    }

}

?>