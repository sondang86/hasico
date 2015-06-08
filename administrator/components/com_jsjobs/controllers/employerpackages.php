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

class JSJobsControllerEmployerpackages extends JSController{

    function __construct() {
        parent :: __construct();
        $this->registerTask('add', 'edit');
    }

    function saveemployerpackage() {
        $employerpackages_model = $this->getmodel('Employerpackages', 'JSJobsModel');
        $return_value = $employerpackages_model->storeEmployerPackage();
        if ($return_value == 1) {
            $msg = JText::_('PACKAGE_SAVED');
            $link = 'index.php?option=com_jsjobs&c=employerpackages&view=employerpackages&layout=employerpackages';
            $this->setRedirect($link, $msg);
        } else {
            $msg = JText::_('ERROR_SAVING_PACKAGE');
            $link = 'index.php?option=com_jsjobs&c=employerpackages&view=employerpackages&layout=employerpackages';
            $this->setRedirect($link, $msg);
        }
    }

    function remove() {
        $employerpackages_model = $this->getmodel('Employerpackages', 'JSJobsModel');
        $returnvalue = $employerpackages_model->deleteEmployerPackage();
        if ($returnvalue == 1) {
            $msg = JText::_('PACKAGE_DELETED');
        } else {
            $msg = $returnvalue . '' . $returnvalue - 1 . ' ' . JText::_('PACKAGE_COULD_NOT_DELETE');
        }
        $this->setRedirect('index.php?option=com_jsjobs&c=employerpackages&view=employerpackages&layout=employerpackages', $msg);
    }

    function cancel() {
        $msg = JText::_('OPERATION_CANCELLED');
        $this->setRedirect('index.php?option=com_jsjobs&c=employerpackages&view=employerpackages&layout=employerpackages', $msg);
    }

    function edit() {
        JRequest :: setVar('layout', 'formemployerpackage');
        JRequest :: setVar('view', 'employerpackages');
        JRequest :: setVar('c', 'employerpackages');
        $this->display();
    }

    function display($cachable = false, $urlparams = false) {
        $document = JFactory :: getDocument();
        $viewName = JRequest :: getVar('view', 'employerpackages');
        $layoutName = JRequest :: getVar('layout', 'employerpackages');
        $viewType = $document->getType();
        $view = $this->getView($viewName, $viewType);
        $jobsharing_model = $this->getModel('Jobsharing', 'JSJobsModel');
        $configuration_model = $this->getModel('Configuration', 'JSJobsModel');
        $employerpackages_model = $this->getModel('Employerpackages', 'JSJobsModel');
        if (!JError :: isError($jobsharing_model) && !JError::isError($configuration_model) && !JError::isError($employerpackages_model)) {
            $view->setModel($jobsharing_model, true);
            $view->setModel($configuration_model);
            $view->setModel($employerpackages_model);
        }

        $view->setLayout($layoutName);
        $view->display();
    }

}

?>