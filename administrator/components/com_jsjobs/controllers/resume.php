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

class JSJobsControllerResume extends JSController{

    function __construct() {
        parent :: __construct();
        $this->registerTask('add', 'edit');
    }

    function getresumedetail() {
        $user = JFactory::getUser();
        $uid = $user->id;
        $jobid = JRequest::getVar('jobid');
        $resumeid = JRequest::getVar('resumeid');
        $model = $this->getModel('jsjobs', 'JSJobsModel');
        $resume_model = $this->getmodel('Resume', 'JSJobsModel');
        $returnvalue = $resume_model->getResumeDetail($uid, $jobid, $resumeid);
        echo $returnvalue;
        JFactory::getApplication()->close();
    }

    /* STRAT EXPORT RESUMES */

    function resumeenforcedelete() {
        $jobsharing = $this->getModel('jobsharing', 'JSJobsModel');
        $cid = JRequest::getVar('cid', array(), '', 'array');
        $resumeid = $cid[0];
        $user = JFactory::getUser();
        $uid = $user->id;
        $resume_model = $this->getmodel('Resume', 'JSJobsModel');
        $return_value = $resume_model->resumeEnforceDelete($resumeid, $uid);
        if ($return_value == 1) {
            $msg = JText::_('JS_RESUME_DELETED');
        } elseif ($return_value == 2) {
            $msg = JText::_('JS_ERROR_IN_DELETING_RESUME');
        } elseif ($return_value == 3) {
            $msg = JText::_('JS_THIS_RESUME_IS_NOT_OF_THIS_USER');
        }
        $link = 'index.php?option=com_jsjobs&c=resume&view=resume&layout=empapps';
        $this->setRedirect($link, $msg);
    }

    function empappapprove() {
        $jobsharing = $this->getModel('jobsharing', 'JSJobsModel');
        $cid = JRequest::getVar('cid', array(), '', 'array');
        $appid = $cid[0];
        $resume_model = $this->getmodel('Resume', 'JSJobsModel');
        $return_value = $resume_model->empappApprove($appid);

        if ($return_value == 1) {
            $msg = JText::_('EMP_APP_APPROVED');
        }
        else
            $msg = JText::_('ERROR_IN_APPROVING_EMP_APP');
        $link = 'index.php?option=com_jsjobs&c=resume&view=resume&layout=appqueue';
        $this->setRedirect($link, $msg);
    }

    function empappreject() {
        $jobsharing = $this->getModel('jobsharing', 'JSJobsModel');
        $cid = JRequest::getVar('cid', array(), '', 'array');
        $appid = $cid[0];
        $resume_model = $this->getmodel('Resume', 'JSJobsModel');
        $return_value = $resume_model->empappReject($appid);
        if ($return_value == 1) {
            $msg = JText::_('EMP_APP_REJECTED');
        }
        else
            $msg = JText::_('ERROR_IN_REJECTING_EMP_APP');
        $link = 'index.php?option=com_jsjobs&c=resume&view=resume&layout=appqueue';
        $this->setRedirect($link, $msg);
    }

    function saveresume() {
        $jobsharing = $this->getModel('jobsharing', 'JSJobsModel');
        $resume_model = $this->getmodel('Resume', 'JSJobsModel');
        $return_value = $resume_model->storeResume();
        if ($return_value == 1) {
            $msg = JText::_('EMP_APP_SAVED');
            $link = 'index.php?option=com_jsjobs&c=resume&view=resume&layout=empapps';
            $this->setRedirect($link, $msg);
        } elseif ($return_value == 2) {
            $msg = JText::_('ALL_FIELD_MUST_BE_ENTERD');
            $link = 'index.php?option=com_jsjobs&c=&view=&layout=formemp';
            $this->setRedirect($link, $msg);
        } elseif ($return_value == 6) { // file type mismatch
            $msg = JText :: _('JS_FILE_TYPE_ERROR');
            $link = 'index.php?option=com_jsjobs&c=resume&view=resume&layout=empapps';
            $this->setRedirect($link, $msg);
        } else {
            $msg = JText::_('ERROR_SAVING_EMP_APP');
            $link = 'index.php?option=com_jsjobs&c=resume&view=resume&layout=empapps';
            $this->setRedirect($link, $msg);
        }
    }

    function remove() {
        $resume_model = $this->getmodel('Resume', 'JSJobsModel');
        $returnvalue = $resume_model->deleteResume();
        if ($returnvalue == 1) {
            $msg = JText::_('EMP_APP_DELETED');
        } else {
            $msg = $returnvalue - 1 . ' ' . JText::_('ERROR_EMP_APP_COULD_NOT_DELETE');
        }
        $this->setRedirect('index.php?option=com_jsjobs&c=resume&view=resume&layout=empapps', $msg);
    }

    function cancel() {
        $msg = JText::_('OPERATION_CANCELLED');
        $this->setRedirect('index.php?option=com_jsjobs&c=resume&view=resume&layout=empapps', $msg);
    }

    function edit() {
        JRequest :: setVar('layout', 'formresume');
        JRequest :: setVar('view', 'resume');
        JRequest :: setVar('c', 'resume');
        $this->display();
    }


    function display($cachable = false, $urlparams = false) {
        $document = JFactory :: getDocument();
        $viewName = JRequest :: getVar('view', 'resume');
        $layoutName = JRequest :: getVar('layout', 'resume');
        $viewType = $document->getType();
        $view = $this->getView($viewName, $viewType);
        $jobsharing_model = $this->getModel('Jobsharing', 'JSJobsModel');
        $configuration_model = $this->getModel('Configuration', 'JSJobsModel');
        $resume_model = $this->getModel('Resume', 'JSJobsModel');
        if (!JError :: isError($jobsharing_model) && !JError::isError($configuration_model) && !JError::isError($resume_model)) {
            $view->setModel($jobsharing_model, true);
            $view->setModel($configuration_model);
            $view->setModel($resume_model);
        }
        $view->setLayout($layoutName);
        $view->display();
    }

}

?>