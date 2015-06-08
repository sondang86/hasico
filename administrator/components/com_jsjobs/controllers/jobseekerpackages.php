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

class JSJobsControllerJobseekerpackages extends JSController{

    function __construct() {
        parent :: __construct();
        $this->registerTask('add', 'edit');
    }

    function savejobseekerpackage() {
        $jobseekerpackages_model = $this->getmodel('Jobseekerpackages', 'JSJobsModel');
        $return_value = $jobseekerpackages_model->storeJobSeekerPackage();
        if ($return_value == 1) {
            $msg = JText::_('PACKAGE_SAVED');
            $link = 'index.php?option=com_jsjobs&c=jobseekerpackages&view=jobseekerpackages&layout=jobseekerpackages';
            $this->setRedirect($link, $msg);
        } else {
            $msg = JText::_('ERROR_SAVING_PACKAGE');
            $link = 'index.php?option=com_jsjobs&c=jobseekerpackages&view=jobseekerpackages&layout=jobseekerpackages';
            $this->setRedirect($link, $msg);
        }
    }

    function edit() {
        JRequest :: setVar('layout', 'formjobseekerpackage');
        JRequest :: setVar('view', 'jobseekerpackages');
        JRequest :: setVar('c', 'jobseekerpackages');
        $this->display();
        
    }

    function remove() {
        $jobseekerpackages_model = $this->getmodel('Jobseekerpackages', 'JSJobsModel');
        $returnvalue = $jobseekerpackages_model->deleteJobSeekerPackage();
        if ($returnvalue == 1) {
            $msg = JText::_('PACKAGE_DELETED');
        } else {
            $msg = $returnvalue . '' . $returnvalue - 1 . ' ' . JText::_('PACKAGE_COULD_NOT_DELETE');
        }
        $this->setRedirect('index.php?option=com_jsjobs&c=jobseekerpackages&view=jobseekerpackages&layout=jobseekerpackages', $msg);
    }

    function cancel() {
        $msg = JText::_('OPERATION_CANCELLED');
        $this->setRedirect('index.php?option=com_jsjobs&c=jobseekerpackages&view=jobseekerpackages&layout=jobseekerpackages', $msg);
    }

    function display($cachable = false, $urlparams = false) {
        $document = JFactory :: getDocument();
        $viewName = JRequest :: getVar('view', 'jobseekerpackages');
        $layoutName = JRequest :: getVar('layout', 'jobseekerpackages');
        $viewType = $document->getType();
        $view = $this->getView($viewName, $viewType);
        $jobsharing_model = $this->getModel('Jobsharing', 'JSJobsModel');
        $configuration_model = $this->getModel('Configuration', 'JSJobsModel');
        $jobseekerpackages_model = $this->getModel('Jobseekerpackages', 'JSJobsModel');
        if (!JError :: isError($jobsharing_model) && !JError::isError($configuration_model) && !JError::isError($jobseekerpackages_model)) {
            $view->setModel($jobsharing_model, true);
            $view->setModel($configuration_model);
            $view->setModel($jobseekerpackages_model);
        }
        $view->setLayout($layoutName);
        $view->display();
    }

}

?>