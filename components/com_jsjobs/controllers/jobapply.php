<?php

/**
 * @Copyright Copyright (C) 2009-2011
 * @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
  + Created by:          Ahmad Bilal
 * Company:		Buruj Solutions
  + Contact:		www.burujsolutions.com , ahmad@burujsolutions.com
 * Created on:	Jan 11, 2009
  ^
  + Project: 		JS Jobs
 * File Name:	controllers/jsjobs.php
  ^
 * Description: Controller class for application data
  ^
 * History:		NONE
  ^
 */
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controller');

class JSJobsControllerJobApply extends JSController {

    var $_router_mode_sef = null;

    function __construct() {
        $app = JFactory::getApplication();
        $user = JFactory::getUser();
        if ($user->guest) { // redirect user if not login
            $link = 'index.php?option=com_user';
            $this->setRedirect($link);
        }
        $router = $app->getRouter();
        if ($router->getMode() == JROUTER_MODE_SEF) {
            $this->_router_mode_sef = 1; // sef true
        } else {
            $this->_router_mode_sef = 2; // sef false
        }

        parent :: __construct();
    }
    
    function applyjob(){
        $visitorapplyjob = 0;
        if(!JFactory::getUser()->guest || $visitorapplyjob == '0'){
            $jobid = JRequest::getVar('jobid',false);
            $jobid = $this->getmodel('Common', 'JSJobsModel')->parseId($jobid);
            $result = $this->getModel('Jobapply','JSJobsModel')->applyJob($jobid);
            $array[0] = 'popup';
            $array[1] = $result;
            print_r(json_encode($array));
        }else{
            $link = 'index.php?option=com_jsjobs&c=jobapply&view=jobapply&layout=job_apply&bd='.JRequest::getVar('jobid',false).'&Itemid='.JRequest::getVar('Itemid',false);
            $array[0] = 'redirect';
            $array[1] = $link;
            print_r(json_encode($array));
        }
        JFactory::getApplication()->close();
    }
    
    function jobapply() {
        $jobsharing = $this->getModel('jobsharingsite', 'JSJobsModel');
        $uid = JRequest::getString('uid', 'none');
        $Itemid = JRequest::getVar('Itemid');
        $jobapply = $this->getmodel('Jobapply', 'JSJobsModel');
        $return_value = $jobapply->jobapply();
        if ($return_value == 1) {
            $msg = JText :: _('APPLICATION_APPLIED');
            $link = 'index.php?option=com_jsjobs&c=jobapply&view=jobapply&layout=myappliedjobs&uid=' . $uid . '&Itemid=' . $Itemid;
        } else if ($return_value == 3) {
            $msg = JText :: _('JS_ALREADY_APPLY_JOB');
            $link = 'index.php?option=com_jsjobs&c=jobapply&view=jobapply&layout=myappliedjobs&Itemid=' . $Itemid;
        } else if ($return_value == 10) {
            $msg = JText :: _('JS_ERROR_APPLYING_JOB_YOUR_JOB_APPLY_LIMIT_EXCEEDS');
            $link = 'index.php?option=com_jsjobs&c=jobapply&view=jobapply&layout=myappliedjobs&Itemid=' . $Itemid;
        } else {
            $msg = JText :: _('ERROR_APPLING_APPLICATION');
            $link = 'index.php?option=com_jsjobs&c=jobapply&view=jobapply&layout=myappliedjobs&uid=' . $uid . '&Itemid=' . $Itemid;
        }
        $this->setRedirect(JRoute::_($link), $msg);
    }

    function jobapplyajax() {
        $uid = JRequest::getString('uid', 'none');
        $jobapply = $this->getmodel('Jobapply', 'JSJobsModel');
        $return_value = $jobapply->jobapply();
        if ($return_value == 1) {
            $msg = JText :: _('APPLICATION_APPLIED');
        } else if ($return_value == 3) {
            $msg = JText :: _('JS_ALREADY_APPLY_JOB');
        } else if ($return_value == 10) {
            $msg = JText :: _('JS_ERROR_APPLYING_JOB_YOUR_JOB_APPLY_LIMIT_EXCEEDS');
        } else {
            $msg = JText :: _('ERROR_APPLING_APPLICATION');
        }
        echo $msg;
        JFactory::getApplication()->close();
    }


    function display($cachable = false, $urlparams = false) {
        $document = JFactory :: getDocument();
        $viewName = JRequest :: getVar('view', 'resume');
        $layoutName = JRequest :: getVar('layout', 'jobcat');
        $viewType = $document->getType();
        $view = $this->getView($viewName, $viewType);
        $view->setLayout($layoutName);
        $view->display();
    }

}
?>    


