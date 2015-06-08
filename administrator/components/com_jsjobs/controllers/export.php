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

class JSJobsControllerExport extends JSController{

    function __construct() {
        parent :: __construct();
        $this->registerTask('add', 'edit');
    }

    function exportallresume() {
        $jobid = JRequest::getVar('bd');
        $export_model = $this->getmodel('Export', 'JSJobsModel');
        $return_value = $export_model->setAllExport($jobid);
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
            JFactory::getApplication()->close();
        } else {
            //echo $return_value ;
            $msg = JText ::_('JS_RESUME_NOT_EXPORT');
        }
        $link = 'index.php?option=com_jsjobs&c=jobapply&view=jobapply&layout=jobappliedresume&oi=' . $jobid;
        $this->setRedirect($link, $msg);
    }

    function exportresume() {
        $jobid = JRequest::getVar('bd');
        $resumeid = JRequest::getVar('rd');
        $export_model = $this->getmodel('Export', 'JSJobsModel');
        $return_value = $export_model->setExport($jobid, $resumeid);
        if ($return_value == true) {
            $msg = JText ::_('JS_RESUME_EXPORT');
            // Push the report now!
            $this->name = 'export-resume';
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=" . $this->name . ".xls");
            header("Pragma: no-cache");
            header("Expires: 0");
            header("Lacation: excel.htm?id=yes");
            print $return_value;
            JFactory::getApplication()->close();
        } else {
            $msg = JText ::_('JS_RESUME_NOT_EXPORT');
        }
        $link = 'index.php?option=com_jsjobs&c=jobapply&view=jobapply&layout=jobappliedresume&oi=' . $jobid;
        $this->setRedirect($link, $msg);
    }

    /* END EXPORT RESUMES */

    function display($cachable = false, $urlparams = false) {
        $document = JFactory :: getDocument();
        $viewName = JRequest :: getVar('view', 'export');
        $layoutName = JRequest :: getVar('layout', 'export');
        $viewType = $document->getType();
        $view = $this->getView($viewName, $viewType);
        $model = $this->getModel('jsjobs', 'JSJobsModel');
        if (!JError :: isError($model)) {
            $view->setModel($model, true);
        }
        $view->setLayout($layoutName);
        $view->display();
    }

}

?>