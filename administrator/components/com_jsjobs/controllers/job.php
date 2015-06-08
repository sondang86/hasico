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

class JSJobsControllerJob extends JSController{

    function __construct() {
        parent :: __construct();
        $this->registerTask('add', 'edit');
    }

    function jobenforcedelete() {
        $jobsharing = $this->getModel('jobsharing', 'JSJobsModel');
        $cid = JRequest::getVar('cid', array(), '', 'array');
        $jobid = $cid[0];
        $user = JFactory::getUser();
        $uid = $user->id;
        $job_model = $this->getmodel('Job', 'JSJobsModel');
        $returnvalue = $job_model->jobEnforceDelete($jobid, $uid);
        if ($returnvalue == 1) {
            $msg = JText::_('JS_JOB_DELETED');
        } elseif ($returnvalue == 2) {
            $msg = JText::_('JS_ERROR_IN_DELETING_JOB');
        } elseif ($returnvalue == 3) {
            $msg = JText::_('JS_THIS_JOB_IS_NOT_OF_THIS_USER');
        }
        $link = 'index.php?option=com_jsjobs&c=job&view=job&layout=jobs';
        $this->setRedirect($link, $msg);
    }

    function jobapprove() {
        $jobsharing = $this->getModel('jobsharing', 'JSJobsModel');
        $cid = JRequest::getVar('cid', array(), '', 'array');
        $jobid = $cid[0];
        $job_model = $this->getmodel('Job', 'JSJobsModel');
        $return_value = $job_model->jobApprove($jobid);
        if ($return_value == 1) {
            $msg = JText::_('JOB_APPROVED');
        }
        else
            $msg = JText::_('ERROR_IN_APPROVING_JOB');
        $link = 'index.php?option=com_jsjobs&c=job&view=job&layout=jobqueue';
        $this->setRedirect($link, $msg);
    }

    function jobreject() {
        $jobsharing = $this->getModel('jobsharing', 'JSJobsModel');
        $cid = JRequest::getVar('cid', array(), '', 'array');
        $jobid = $cid[0];
        $job_model = $this->getmodel('Job', 'JSJobsModel');
        $return_value = $job_model->jobReject($jobid);
        if ($return_value == 1) {
            $msg = JText::_('JOB_REJECTED');
        }
        else
            $msg = JText::_('ERROR_IN_REJECTING_JOB');
        $link = 'index.php?option=com_jsjobs&c=job&view=job&layout=jobqueue';
        $this->setRedirect($link, $msg);
    }

    function savejob() {
        $jobsharing = $this->getModel('jobsharing', 'JSJobsModel');
        $job_model = $this->getmodel('Job', 'JSJobsModel');
        $return_data = $job_model->storeJob();
        if ($return_data == 1) {
            $msg = JText::_('JOB_POST_SAVED');
            $link = 'index.php?option=com_jsjobs&c=job&view=job&layout=jobs';
            $this->setRedirect($link, $msg);
        } else if ($return_data == 2) {
            $msg = JText::_('ALL_FIELD_MUST_BE_ENTERD');
            $link = 'index.php?option=com_jsjobs&c=job&view=job&layout=formjob';
            $this->setRedirect($link, $msg);
        } elseif ($return_data == 12) {
            $msg = JText::_('JS_DESCRIPTION_MUST_BE_ENTERD');
            $link = 'index.php?option=com_jsjobs&c=job&view=job&layout=formjob';
            $this->setRedirect($link, $msg);
        } else {
            $msg = JText::_($return_data . 'ERROR_SAVING_JOB');
            $link = 'index.php?option=com_jsjobs&c=job&view=job&layout=jobs';
            $this->setRedirect($link, $msg);
        }
    }

    function edit() {
        JRequest :: setVar('c', 'job');
        JRequest :: setVar('view', 'job');
        JRequest :: setVar('layout', 'formjob');
        $this->display();
    }

    function cancel() {
        $msg = JText::_('OPERATION_CANCELLED');
        $this->setRedirect('index.php?option=com_jsjobs&c=job&view=job&layout=jobs', $msg);
    }

    function remove() {
        $job_model = $this->getmodel('Job', 'JSJobsModel');
        $returnvalue = $job_model->deleteJob();
        if ($returnvalue == 1) {
            $msg = JText::_('JOB_DELETED');
        } else {
            $msg = $returnvalue - 1 . ' ' . JText::_('JOB_COULD_NOT_DELETE');
        }
        $this->setRedirect('index.php?option=com_jsjobs&c=job&view=job&layout=jobs', $msg);
    }

    function display($cachable = false, $urlparams = false) {
        $document = JFactory :: getDocument();
        $viewName = JRequest :: getVar('view', 'job');
        $layoutName = JRequest :: getVar('layout', 'job');
        $viewType = $document->getType();
        $view = $this->getView($viewName, $viewType);
        $jobsharing_model = $this->getModel('Jobsharing', 'JSJobsModel');
        $configuration_model = $this->getModel('Configuration', 'JSJobsModel');
        $job_model = $this->getModel('Job', 'JSJobsModel');
        if (!JError :: isError($jobsharing_model) && !JError::isError($configuration_model) && !JError::isError($job_model)) {
            $view->setModel($jobsharing_model, true);
            $view->setModel($configuration_model);
            $view->setModel($job_model);
        }
        $view->setLayout($layoutName);
        $view->display();
    }

}

?>