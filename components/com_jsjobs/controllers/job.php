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

class JSJobsControllerJob extends JSController {

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

    function savejob() { //save job
        $jobsharing = $this->getModel('jobsharingsite', 'JSJobsModel');
        $uid = JRequest::getString('uid', 'none');
        $Itemid = JRequest::getVar('Itemid');
        $job = $this->getmodel('Job', 'JSJobsModel');
        $return_data = $job->storeJob();
        if ($return_data == 1) {
            $msg = JText :: _('JOB_SAVED');
            $link = 'index.php?option=com_jsjobs&c=job&view=job&layout=myjobs&Itemid=' . $Itemid;
        } else if ($return_data == 2) {
            $msg = JText :: _('JS_FILL_REQ_FIELDS');
            $link = 'index.php?option=com_jsjobs&c=job&view=job&layout=formjob&Itemid=' . $Itemid;
        } else if ($return_data == 11) { // start date not in oldate
            $msg = JText :: _('JS_START_DATE_NOT_OLD_DATE');
            $link = 'index.php?option=com_jsjobs&c=job&view=job&layout=formjob&Itemid=' . $Itemid;
        } else if ($return_data == 12) {
            $msg = JText :: _('JS_START_DATE_NOT_LESS_STOP_DATE');
            $link = 'index.php?option=com_jsjobs&c=job&view=job&layout=formjob&Itemid=' . $Itemid;
        } else {
            $msg = JText :: _('ERROR_SAVING_JOB');
            $link = 'index.php?option=com_jsjobs&c=job&view=job&layout=myjobs&Itemid=' . $Itemid;
        }
        $this->setRedirect(JRoute::_($link), $msg);
    }

    function savejobvisitor() { //save company and job for visitor
        $jobsharing = $this->getModel('jobsharingsite', 'JSJobsModel');
        $uid = JRequest::getString('uid', 'none');
        $Itemid = JRequest::getVar('Itemid');
        $company = $this->getmodel('Company', 'JSJobsModel');
        $return_value = $company->storeCompanyJobForVisitor();
        $link = 'index.php?option=com_jsjobs&c=jsjobs&view=jobseeker&layout=controlpanel&Itemid=' . $Itemid;
        if ($return_value == 1) {
            $msg = JText :: _('JOB_SAVED');
        } elseif ($return_value == 5) {
            $msg = JText :: _('JS_ERROR_LOGO_SIZE_LARGER');
            $link = 'index.php?option=com_jsjobs&c=job&view=job&layout=formjob_visitor&Itemid=' . $Itemid;
        } elseif ($return_value == 6) {
            $msg = JText :: _('JS_COMPANY_FILE_TYPE_ERROR');
            $link = 'index.php?option=com_jsjobs&c=job&view=job&layout=formjob_visitor&Itemid=' . $Itemid;
        } elseif ($return_value == 2) {
            $msg = JText :: _('JS_ERROR_INCORRECT_CAPTCHA_CODE');
            $link = 'index.php?option=com_jsjobs&c=job&view=job&layout=formjob_visitor&Itemid=' . $Itemid;
        } else {
            $msg = JText :: _('ERROR_SAVING_JOB');
        }
        $this->setRedirect(JRoute::_($link), $msg);
    }

    function deletejob() { //delete job
        $user = JFactory::getUser();
        $uid = $user->id;
        $Itemid = JRequest::getVar('Itemid');
        $common = $this->getmodel('Common', 'JSJobsModel');
        $jobid = $common->parseId(JRequest::getVar('bd'));
        $vis_email = JRequest::getVar('email');
        $vis_jobid = $common->parseId(JRequest::getVar('bd'));
        $job = $this->getmodel('Job', 'JSJobsModel');
        $return_value = $job->deleteJob($jobid, $uid, $vis_email, $vis_jobid);
        $jobsharing = $this->getModel('jobsharingsite', 'JSJobsModel');
        if ($return_value == 1) {
            $msg = JText :: _('JS_JOB_DELETED');
        } elseif ($return_value == 2) {
            $msg = JText :: _('JS_JOB_INUSE_CANNOT_DELETE');
        } elseif ($return_value == 3) {
            $msg = JText :: _('JS_NOT_YOUR_JOB');
        } else {
            $msg = JText :: _('JS_ERROR_DELETEING_JOB');
        }
        if (($vis_email == '') || ($jobid == ''))
            $link = 'index.php?option=com_jsjobs&c=job&view=job&layout=myjobs&Itemid=' . $Itemid;
        else
            $link = 'index.php?option=com_jsjobs&c=job&view=job&layout=myjobs&email=' . $vis_email . '&bd=' . $vis_jobid . '&Itemid=' . $Itemid;
        $this->setRedirect(JRoute::_($link), $msg);
    }

    function mailtocandidate() {
        $user = JFactory::getUser();
        $uid = $user->id;
        $email = JRequest::getVar('email');
        $jobapplyid = JRequest::getVar('jobapplyid');
        $jobapply = $this->getmodel('Jobapply', 'JSJobsModel');
        $returnvalue = $jobapply->getMailForm($uid, $email, $jobapplyid);
        echo $returnvalue;
        JFactory::getApplication()->close();
    }


    function sendtocandidate() {
        $val = json_decode(JRequest::getVar('val'), true);
        $emailtemplate = $this->getmodel('Emailtemplate', 'JSJobsModel');
        $returnvalue = $emailtemplate->sendToCandidate($val);
        echo $returnvalue;
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
    