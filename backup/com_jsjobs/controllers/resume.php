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

class JSJobsControllerResume extends JSController {

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

    function saveresume() {
        $jobsharing = $this->getModel('jobsharingsite', 'JSJobsModel');
        $session = JFactory::getSession();
        $user = JFactory::getUser();
        $uid = $user->id;
        $Itemid = JRequest::getVar('Itemid');

        if ($uid) {
            $resume = $this->getmodel('Resume', 'JSJobsModel');
            $return_value = $resume->storeResume('');
        } else {
            $visitor = $session->get('jsjob_jobapply');
            $resume = $this->getmodel('Resume', 'JSJobsModel');
            $return_value = $resume->storeResume($visitor['bd']);
        }
        if ($return_value == 1) {
            $msg = JText :: _('EMP_APP_SAVED');
            if ($uid)
                $link = 'index.php?option=com_jsjobs&c=resume&view=resume&layout=myresumes&Itemid=' . $Itemid;
            else {
                $visitor['visitor'] = '';
                $visitor['bd'] = '';
                $session->set('jsjob_jobapply', $visitor);
                $link = 'index.php?option=com_jsjobs&c=jsjobs&view=jobseeker&layout=controlpanel&Itemid=' . $Itemid;
            }
        } else if ($return_value == 2) {
            $msg = JText :: _('JS_FILL_REQ_FIELDS');
            $link = 'index.php?option=com_jsjobs&c=resume&view=resume&layout=formresume&Itemid=' . $Itemid;
        } else if ($return_value == 6) { // file type mismatch
            $msg = JText :: _('JS_FILE_TYPE_ERROR');
            $link = 'index.php?option=com_jsjobs&c=resume&view=resume&layout=myresumes&Itemid=' . $Itemid;
        } else if ($return_value == 7) { // photo file size 
            $msg = JText :: _('JS_ERROR_PHOTO_SIZE_LARGER');
            $link = 'index.php?option=com_jsjobs&c=resume&view=resume&layout=formresume&Itemid=' . $Itemid;
        } else if ($return_value == 8) { // captcha error 
            $msg = JText :: _('JS_ERROR_INCORRECT_CAPTCHA_CODE');
            $link = 'index.php?option=com_jsjobs&c=resume&view=resume&layout=formresume&Itemid=' . $Itemid;
        } else if ($return_value == 3) {
            $msg = JText :: _('JS_ALREADY_APPLY_JOB');
            $link = 'index.php?option=com_jsjobs&c=jsjobs&view=jobseeker&layout=controlpanel&Itemid=' . $Itemid;
        } else {
            $msg = JText :: _('ERROR_SAVING_EMP_APP');
            $link = 'index.php?option=com_jsjobs&c=resume&view=resume&layout=myresumes&uid=' . $uid . '&Itemid=' . $Itemid;
        }
        $this->setRedirect(JRoute::_($link), $msg);
    }

    function deleteresume() { //delete resume
        $session = JFactory::getSession();
        $user = JFactory::getUser();
        $uid = $user->id;
        $Itemid = JRequest::getVar('Itemid');
        $common = $this->getmodel('Common', 'JSJobsModel');
        $resumeid = $common->parseId(JRequest::getVar('rd', ''));
        $resume = $this->getmodel('Resume', 'JSJobsModel');
        $return_value = $resume->deleteResume($resumeid, $uid);
        $jobsharing = $this->getModel('jobsharingsite', 'JSJobsModel');
        if ($return_value == 1) {
            $msg = JText :: _('JS_RESUME_DELETED');
        } elseif ($return_value == 2) {
            $msg = JText :: _('JS_RESUME_INUSE_CANNOT_DELETE');
        } elseif ($return_value == 3) {
            $msg = JText :: _('JS_NOT_YOUR_RESUME');
        } else {
            $msg = JText :: _('JS_ERROR_DELETEING_RESUME');
        }
        $link = 'index.php?option=com_jsjobs&c=resume&view=resume&layout=myresumes&Itemid=' . $Itemid;
        $this->setRedirect(JRoute::_($link), $msg);
    }

    function getresumedetail() {
        $user = JFactory::getUser();
        $uid = $user->id;
        $jobid = JRequest::getVar('jobid');
        $resumeid = JRequest::getVar('resumeid');
        $resume = $this->getmodel('Resume', 'JSJobsModel');
        $returnvalue = $resume->getResumeDetail($uid, $jobid, $resumeid);
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
    