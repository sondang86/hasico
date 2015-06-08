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

class JSJobsControllerConfiguration extends JSController{

    function __construct() {
        parent :: __construct();
        $this->registerTask('add', 'edit');
    }
    
    function savetheme(){
        $configuration_model = $this->getmodel('Configuration', 'JSJobsModel');
        $return_value = $configuration_model->storeTheme();
        if ($return_value == 1) {
            $msg = JText::_('JS_THEME_HAS_BEEN_UPDATED');
        } else {
            $msg = JText::_('ERRORCONFIGFILE');
        }
        $link = 'index.php?option=com_jsjobs&c=configuration&view=configuration&layout=themes';
        $this->setRedirect($link, $msg);
    }
    
    function canceltheme(){
        
    }
    
    function save() {
        $layout = JRequest::getVar('layout');
        $configuration_model = $this->getmodel('Configuration', 'JSJobsModel');
        $return_value = $configuration_model->storeConfig();
        if ($return_value == 1) {
            $msg = JText::_('The Configuration Details have been updated');
        } else {
            $msg = JText::_('ERRORCONFIGFILE');
        }
        $this->resetsession();
        $link = 'index.php?option=com_jsjobs&c=configuration&view=configuration&layout='.$layout;
        $this->setRedirect($link, $msg);
    }
    
    function resetsession(){
        $session = JFactory::getSession();
        $session->clear('jsjobconfig_dft');
        $session->clear('jsjobconfig');
        unset($_SESSION['jsjobconfig_dft']);
        unset($_SESSION['jsjobconfig']);
    }
    function makedefaulttheme() { // make default theme
        $cid = JRequest::getVar('cid', array(), '', 'array');
        $defaultid = $cid[0];
        $configuration_model = $this->getmodel('Configuration', 'JSJobsModel');
        $return_value = $configuration_model->makeDefaultTheme($defaultid, 1);
        if ($return_value == 1) {
            $msg = JText :: _('JS_DEFAULT_THEME_SET');
            $this->resetsession();
        } else {
            $msg = JText :: _('JS_ERROR_MAKING_DEFAULT_THEME');
        }
        $link = 'index.php?option=com_jsjobs&c=configuration&view=configuration&layout=themes';
        $this->setRedirect($link, $msg);
    }

    function display($cachable = false, $urlparams = false) {
        $document = JFactory :: getDocument();
        $viewName = JRequest :: getVar('view', 'configuration');
        $layoutName = JRequest :: getVar('layout', 'configuration');
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