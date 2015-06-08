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

class JSJobsControllerAddressdata extends JSController{

    function __construct() {
        parent :: __construct();
        $this->registerTask('add', 'edit');
    }

    function loadaddressdata() {
        $data = JRequest :: get('post');
        $addressdata_model = $this->getmodel('Addressdata', 'JSJobsModel');
        $return_value = $addressdata_model->loadAddressData();
        $link = 'index.php?option=com_jsjobs&c=addressdata&view=addressdata&layout=loadaddressdata&er=2';
        if ($return_value == 1) {
            $msg = JText::_('JS_ADDRESS_DATA_SAVED');
            $link = 'index.php?option=com_jsjobs&c=addressdata&view=addressdata&layout=loadaddressdata';
        } elseif ($return_value == 3) { // file mismatch
            $msg = JText::_('JS_ADDRESS_DATA_COULD_NOT_SAVE');
        } elseif ($return_value == 3) { // file mismatch
            $msg = JText::_('JS_FILE_TYPE_ERROR');
        } elseif ($return_value == 5) { // state alredy exist 
            $msg = JText::_('JS_STATES_EXIST');
        } elseif ($return_value == 8) { // county alredy exist 
            $msg = JText::_('JS_COUNTIES_EXIST');
        } elseif ($return_value == 11) { // state and county alredy exist 
            $msg = JText::_('JS_STATES_COUNTIES_EXIST');
        } elseif ($return_value == 7) { // city alredy exist 
            $msg = JText::_('JS_CITIES_EXIST');
        } elseif ($return_value == 6) { // state and city alredy exist 
            $msg = JText::_('JS_STATES_CITIES_EXIST');
        } elseif ($return_value == 9) { // county and city alredy exist 
            $msg = JText::_('JS_COUNTIES_CITIES_EXIST');
        } elseif ($return_value == 12) { // state, counnty and city alredy exist 
            $msg = JText::_('JS_STATES_COUNTIES_CITIES_EXIST');
        } else {
            $msg = JText::_('JS_ADDRESS_DATA_COULD_NOT_SAVE');
        }
        $this->setRedirect($link, $msg);
    }

    function display($cachable = false, $urlparams = false) {
        $document = JFactory :: getDocument();
        $viewName = JRequest :: getVar('view', 'addressdata');
        $layoutName = JRequest :: getVar('layout', 'loadaddressdata');
        $viewType = $document->getType();
        $view = $this->getView($viewName, $viewType);
        $jobsharing_model = $this->getModel('Jobsharing', 'JSJobsModel');
        $configuration_model = $this->getModel('Configuration', 'JSJobsModel');
        if (!JError :: isError($jobsharing_model) && !JError::isError($configuration_model)) {
            $view->setModel($jobsharing_model, true);
            $view->setModel($configuration_model);
        }
        $view->setLayout($layoutName);
        $view->display();
    }
}

?>