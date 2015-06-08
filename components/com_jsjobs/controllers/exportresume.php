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

class JSJobsControllerExportResume extends JSController {

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

    function exportallresume() {
        $jobaliasid = JRequest::getVar('bd');
        $common = $this->getmodel('Common', 'JSJobsModel');
        $jobid = $common->parseId($jobaliasid);

        $export = $this->getmodel('Export', 'JSJobsModel');
        $return_value = $export->setAllExport($jobid);
        if ($return_value == true) {
            // Push the report now!
            $msg = JText ::_('JS_RESUME_EXPORT');
            $name = 'export-resumes';
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=" . $name . ".xls");
            header("Pragma: no-cache");
            header("Expires: 0");
            header("Lacation: excel.htm?id=yes");
            print $return_value;
            die();
        } else {
            $msg = JText ::_('JS_RESUME_NOT_EXPORT');
        }
        $link = 'index.php?option=com_jsjobs&c=jobapply&view=jobapply&layout=job_appliedapplications&bd=' . $jobaliasid;
        $this->setRedirect(JRoute::_($link), $msg);
    }

    /* END EXPORT RESUMES */
    function exportresume() {
        $common_model = $this->getModel('Common','JSJobsModel');
        $jobaliasid = JRequest::getVar('bd');
        $jobid = $common_model->parseId($jobaliasid);
        $resumealiasid = JRequest::getVar('rd');
        $resumeid = $common_model->parseId($resumealiasid);
        $export_model = $this->getModel('Export', 'JSJobsModel');

        $return_value = $export_model->setExport($jobid, $resumeid);
        if ($return_value == true) {
            // Push the report now!
            $msg = JText ::_('JS_RESUME_EXPORT');
            $name = 'export-resume';
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=" . $name . ".xls");
            header("Pragma: no-cache");
            header("Expires: 0");
            header("Lacation: excel.htm?id=yes");
            print $return_value;
            die();
        } else {
            //echo $return_value ;
            $msg = JText ::_('JS_RESUME_NOT_EXPORT');
        }
        $link = 'index.php?option=com_jsjobs&c=jobapply&view=jobapply&layout=job_appliedapplications&bd=' . $jobaliasid;
        $this->setRedirect(JRoute::_($link), $msg);
    }
}

?>
    