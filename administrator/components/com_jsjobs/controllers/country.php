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

class JSJobsControllerCountry extends JSController{

    function __construct() {
        parent :: __construct();
        $this->registerTask('add', 'edit');
    }

    function editjobcountry() {
        JRequest :: setVar('layout', 'formcountry');
        JRequest :: setVar('view', 'country');
        JRequest :: setVar('c', 'country');
        $this->display();
    }

    function deletecountry() {
        $country_model = $this->getmodel('Country', 'JSJobsModel');
        $return_value = $country_model->deleteCountry();
        if ($return_value == 1) {
            $msg = JText::_('JS_COUNTRY_DELETE');
        } else {
            $msg = $returnvalue - 1 . ' ' . JText::_('JS_COUNTRY_COULD_NOT_DELETE');
        }
        $link = 'index.php?option=com_jsjobs&c=country&view=country&layout=countries';
        $this->setRedirect($link, $msg);
    }

    function publishcountries() {
        $country_model = $this->getmodel('Country', 'JSJobsModel');
        $return_value = $country_model->publishcountries();
        if ($return_value == 1) {
            $msg = JText::_('JS_PUBLISHED');
        } else {
            $msg = JText::_('JS_ERROR_PUBLISHING');
        }
        $link = 'index.php?option=com_jsjobs&c=country&view=country&layout=countries';
        $this->setRedirect($link, $msg);
    }

    function unpublishcountries() {
        $country_model = $this->getmodel('Country', 'JSJobsModel');
        $return_value = $country_model->unpublishcountries();
        if ($return_value == 1) {
            $msg = JText::_('JS_UNPUBLISHED');
        } else {
            $msg = JText::_('JS_ERROR_UNPUBLISHING');
        }
        $link = 'index.php?option=com_jsjobs&c=country&view=country&layout=countries';
        $this->setRedirect($link, $msg);
    }

    function savecountry() {
        $data = JRequest :: get('post');
        $country_model = $this->getmodel('Country', 'JSJobsModel');
        $return_value = $country_model->storeCountry();
        $link = 'index.php?option=com_jsjobs&c=country&view=country&layout=countries';
        if (is_array($return_value)) {
            if ($return_value['return_value'] == false) { // jobsharing return value 
                $msg = JText::_('JS_COUNTRY_SAVED');
                if ($return_value['rejected_value'] != "")
                    $msg = JText::_('JS_COUNTRY_SAVED_BUT_SHARING_SERVER_NOT_ACCEPT_THE_JOB_OF_THESE_COUNTRY_DUE_TO_IMPROPER_NAME');
                if ($return_value['authentication_value'] != "")
                    $msg = JText::_('JS_COUNTRY_SAVED_BUT_AUTHENTICATION_FAILED_ON_SHARING_SERVER');
                if ($return_value['server_responce'] != "")
                    $msg = JText::_('JS_COUNTRY_SAVED_PROBLEM_SYNCHRONIZE_WITH_SHARING_SERVER');
                $this->setRedirect($link, $msg);
            }elseif ($return_value['return_value'] == true) { // jobsharing return value 
                $msg = JText::_('JS_COUNTRY_SAVED');
                $this->setRedirect($link, $msg);
            }
        } else {
            if ($return_value == 1) {
                $msg = JText::_('JS_COUNTRY_SAVED');
                $this->setRedirect($link, $msg);
            } elseif ($return_value == 3) {
                $msg = JText::_('JS_COUNTRY_EXIST');
                JRequest :: setVar('view', 'country');
                JRequest :: setVar('hidemainmenu', 1);
                JRequest :: setVar('layout', 'formcountry');
                JRequest :: setVar('msg', $msg);
                $this->display();
            } else {
                $msg = JText::_('JS_ERROR_SAVING_COUNTRY');
                $this->setRedirect($link, $msg);
            }
        }
    }

    function cancel() {
        $msg = JText::_('OPERATION_CANCELLED');
        $this->setRedirect('index.php?option=com_jsjobs&c=country&view=country&layout=countries', $msg);
    }

    function display($cachable = false, $urlparams = false) {
        $document = JFactory :: getDocument();
        $viewName = JRequest :: getVar('view', 'country');
        $layoutName = JRequest :: getVar('layout', 'country');
        $viewType = $document->getType();
        $view = $this->getView($viewName, $viewType);
        $jobsharing_model = $this->getModel('Jobsharing', 'JSJobsModel');
        $configuration_model = $this->getModel('Configuration', 'JSJobsModel');
        $country_model = $this->getModel('Country', 'JSJobsModel');
        if (!JError :: isError($jobsharing_model) && !JError::isError($configuration_model) && !JError::isError($country_model)) {
            $view->setModel($jobsharing_model, true);
            $view->setModel($configuration_model);
            $view->setModel($country_model);
        }
        $view->setLayout($layoutName);
        $view->display();
    }

}

?>