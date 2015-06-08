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

class JSJobsControllerEmailtemplate extends JSController{

    function __construct() {
        parent :: __construct();
        $this->registerTask('add', 'edit');
    }

    function saveemailtemplate() {
        $data = JRequest :: get('post');
        $templatefor = $data['templatefor'];
        $emailtemplate_model = $this->getmodel('Emailtemplate', 'JSJobsModel');
        $return_value = $emailtemplate_model->storeEmailTemplate();
        switch ($templatefor) {
            case 'company-new' : $tempfor = 'ew-cm';
                break;
            case 'company-approval' : $tempfor = 'cm-ap';
                break;
            case 'company-rejecting' : $tempfor = 'cm-rj';
                break;
            case 'job-new' : $tempfor = 'ew-ob';
                break;
            case 'job-approval' : $tempfor = 'ob-ap';
                break;
            case 'job-rejecting' : $tempfor = 'ob-rj';
                break;
            case 'resume-new' : $tempfor = 'ew-rm';
                break;
            case 'message-email' : $tempfor = 'ew-ms';
                break;
            case 'resume-approval' : $tempfor = 'rm-ap';
                break;
            case 'resume-rejecting' : $tempfor = 'rm-rj';
                break;
            case 'applied-resume_status' : $tempfor = 'ap-rs';
                break;
            case 'jobapply-jobapply' : $tempfor = 'ba-ja';
                break;
            case 'department-new' : $tempfor = 'ew-md';
                break;
            case 'employer-buypackage' : $tempfor = 'ew-rp';
                break;
            case 'jobseeker-buypackage' : $tempfor = 'ew-js';
                break;
            case 'job-alert' : $tempfor = 'jb-at';
                break;
            case 'job-alert-visitor' : $tempfor = 'jb-at-vis';
                break;
            case 'job-to-friend' : $tempfor = 'jb-to-fri';
                break;
        }
        if ($return_value == 1) {
            $msg = JText::_('JS_EMAIL_TEMPATE_SAVED');
            $link = 'index.php?option=com_jsjobs&c=emailtemplate&view=emailtemplate&layout=emailtemplate&tf=' . $tempfor;
            $this->setRedirect($link, $msg);
        } else {
            $msg = JText::_('ERROR_SAVING_EMAIL_TEMPLATE');
            $link = 'index.php?option=com_jsjobs&c=emailtemplate&view=emailtemplate&layout=emailtemplate&tf=' . $tempfor;
            $this->setRedirect($link, $msg);
        }
    }

    function display($cachable = false, $urlparams = false) {
        $document = JFactory :: getDocument();
        $viewName = JRequest :: getVar('view', 'emailtemplate');
        $layoutName = JRequest :: getVar('layout', 'emailtemplate');
        $viewType = $document->getType();
        $view = $this->getView($viewName, $viewType);
        $jobsharing_model = $this->getModel('Jobsharing', 'JSJobsModel');
        $configuration_model = $this->getModel('Configuration', 'JSJobsModel');
        $emailtemplate_model = $this->getModel('Emailtemplate', 'JSJobsModel');
        if (!JError :: isError($jobsharing_model) && !JError::isError($configuration_model) && !JError::isError($emailtemplate_model)) {
            $view->setModel($jobsharing_model, true);
            $view->setModel($configuration_model);
            $view->setModel($emailtemplate_model);
        }
        $view->setLayout($layoutName);
        $view->display();
    }

}

?>