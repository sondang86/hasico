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

class JSJobsControllerJobapply extends JSController{

    function __construct() {
        parent :: __construct();
        $this->registerTask('add', 'edit');
    }


    function actionresume() { //save shortlist candidate
        $user = JFactory::getUser();
        $uid = $user->id;
        $data = JRequest :: get('post');
        $jobid = $data['jobid'];
        $resumeid = $data['resumeid'];
        $msg = "";
        $link = 'index.php?option=com_jsjobs&c=jobapply&view=jobapply&layout=jobappliedresume&oi=' . $jobid;
        $this->setRedirect($link, $msg);
    }

    function display($cachable = false, $urlparams = false) {
        $document = JFactory :: getDocument();
        $viewName = JRequest :: getVar('view', 'jobapply');
        $layoutName = JRequest :: getVar('layout', 'jobapply');
        $viewType = $document->getType();
        $view = $this->getView($viewName, $viewType);
        $jobsharing_model = $this->getModel('Jobsharing', 'JSJobsModel');
        $configuration_model = $this->getModel('Configuration', 'JSJobsModel');
        $jobapply_model = $this->getModel('Jobapply', 'JSJobsModel');
        if (!JError :: isError($jobsharing_model) && !JError::isError($configuration_model) && !JError::isError($jobapply_model)) {
            $view->setModel($jobsharing_model, true);
            $view->setModel($configuration_model);
            $view->setModel($jobapply_model);
        }
        $view->setLayout($layoutName);
        $view->display();
    }

}

?>