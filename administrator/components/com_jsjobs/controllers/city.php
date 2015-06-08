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

class JSJobsControllerCity extends JSController{

    function __construct() {
        parent :: __construct();
        $this->registerTask('add', 'edit');
    }

    function editjobcity() {
        JRequest :: setVar('layout', 'formcity');
        JRequest :: setVar('view', 'city');
        JRequest :: setVar('c', 'city');
        $this->display();
    }

    function deletecity() {
        $session = JFactory::getSession();
        $countryid = $session->get('countryid');
        $stateid = $session->get('stateid');
        $city_model = $this->getmodel('City', 'JSJobsModel');
        $return_value = $city_model->deleteCity();
        if ($return_value == 1) {
            $msg = JText::_('JS_CITY_DELETE');
        } else {
            $msg = $returnvalue - 1 . ' ' . JText::_('JS_CITY_COULD_NOT_DELETE');
        }
        $link = 'index.php?option=com_jsjobs&c=city&view=city&layout=cities&ct=' . $countryid . '&sd=' . $stateid;
        $this->setRedirect($link, $msg);
    }

    function publishcities() {
        $session = JFactory::getSession();
        $country = $session->get('countryid');
        $stateid = $session->get('stateid');
        $city_model = $this->getmodel('City', 'JSJobsModel');
        $return_value = $city_model->publishcities();
        if ($return_value == 1) {
            $msg = JText::_('JS_PUBLISHED');
        } else {
            $msg = JText::_('JS_ERROR_PUBLISHING');
        }

        $link = 'index.php?option=com_jsjobs&c=city&view=city&layout=cities&sd=' . $stateid . '&ct=' . $country;
        $this->setRedirect($link, $msg);
    }

    function unpublishcities() {
        $session = JFactory::getSession();
        $country = $session->get('countryid');
        $stateid = $session->get('stateid');
        $city_model = $this->getmodel('City', 'JSJobsModel');
        $return_value = $city_model->unpublishcities();
        if ($return_value == 1) {
            $msg = JText::_('JS_UNPUBLISHED');
        } else {
            $msg = JText::_('JS_ERROR_UNPUBLISHING');
        }

        $link = 'index.php?option=com_jsjobs&c=city&view=city&layout=cities&sd=' . $stateid . '&ct=' . $country;
        $this->setRedirect($link, $msg);
    }

    function savecity() {
        $session = JFactory::getSession();
        $countryid = $session->get('countryid');
        $stateid = $session->get('stateid');
        $data = JRequest :: get('post');

        $city_model = $this->getmodel('City', 'JSJobsModel');
        $return_value = $city_model->storeCity($countryid, $stateid);
        $link = 'index.php?option=com_jsjobs&c=city&view=city&layout=cities&ct=' . $countryid . '&sd=' . $stateid;
        if (is_array($return_value)) {
            if ($return_value['return_value'] == false) { // jobsharing return value 
                $msg = JText::_('JS_CITY_SAVED');
                if ($return_value['rejected_value'] != "")
                    $msg = JText::_('JS_CITY_SAVED_BUT_SHARING_SERVER_NOT_ACCEPT_THE_JOB_OF_THESE_CITY_DUE_TO_IMPROPER_NAME');
                if ($return_value['authentication_value'] != "")
                    $msg = JText::_('JS_CITY_SAVED_BUT_AUTHENTICATION_FAILED_ON_SHARING_SERVER');
                if ($return_value['server_responce'] != "")
                    $msg = JText::_('JS_CITY_SAVED_BUT_PROBLEM_SYNCHRONIZE_WITH_SHARING_SERVER');
                $this->setRedirect($link, $msg);
            }elseif ($return_value['return_value'] == true) { // jobsharing return value 
                $msg = JText::_('JS_CITY_SAVED');
                $this->setRedirect($link, $msg);
            }
        } else {
            if ($return_value == 1) {
                $msg = JText::_('JS_CITY_SAVED');
                $this->setRedirect($link, $msg);
            } elseif ($return_value == 3) {
                $msg = JText::_('JS_CITY_EXIST');
                JRequest :: setVar('view', 'city');
                JRequest :: setVar('hidemainmenu', 1);
                JRequest :: setVar('layout', 'formcity');
                JRequest :: setVar('msg', $msg);
                $this->display();
            } else {
                $msg = JText::_('JS_ERROR_SAVING_CITY');
                $this->setRedirect($link, $msg);
            }
        }
    }

    function cancel() {
        $msg = JText::_('OPERATION_CANCELLED');
        $session = JFactory::getSession();
        $countrycode = $session->get('countryid');
        $this->setRedirect('index.php?option=com_jsjobs&c=city&view=city&layout=cities&ct=' . $countrycode, $msg);
    }

    function display($cachable = false, $urlparams = false) {
        $document = JFactory :: getDocument();
        $viewName = JRequest :: getVar('view', 'city');
        $layoutName = JRequest :: getVar('layout', 'city');
        $viewType = $document->getType();
        $view = $this->getView($viewName, $viewType);
        $jobsharing_model = $this->getModel('Jobsharing', 'JSJobsModel');
        $configuration_model = $this->getModel('Configuration', 'JSJobsModel');
        $city_model = $this->getModel('City', 'JSJobsModel');
        if (!JError :: isError($jobsharing_model) && !JError::isError($configuration_model) && !JError::isError($city_model)) {
            $view->setModel($jobsharing_model, true);
            $view->setModel($configuration_model);
            $view->setModel($city_model);
        }
        $view->setLayout($layoutName);
        $view->display();
    }

}

?>