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

class JSJobsControllerResumesearch extends JSController {

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

    function saveresumesearch() { //save resume search
        $session = JFactory::getSession();
        $uid = JRequest::getString('uid', 'none');
        $Itemid = JRequest::getVar('Itemid');
        $data = JRequest :: get('post');
        $user = JFactory::getUser();
        $data['uid'] = $user->id;
        $data['application_title'] = $_SESSION['resumesearch_title'];
        $data['nationality'] = $_SESSION['resumesearch_nationality'];
        $data['gender'] = $_SESSION['resumesearch_gender'];
        $data['iamavailable'] = $_SESSION['resumesearch_iamavailable'];
        $data['category'] = $_SESSION['resumesearch_jobcategory'];
        $data['jobtype'] = $_SESSION['resumesearch_jobtype'];
        $data['salaryrange'] = $_SESSION['resumesearch_jobsalaryrange'];
        $data['education'] = $_SESSION['resumesearch_heighestfinisheducation'];
        $data['experience'] = $_SESSION['resumesearch_experience'];
        $data['created'] = date('Y-m-d H:i:s');
        $data['status'] = 1;
        $resumesearch = $this->getmodel('Resumesearch', 'JSJobsModel');
        $return_value = $resumesearch->storeResumeSearch($data);

        if ($return_value == 1) {
            $msg = JText :: _('JS_SEARCH_SAVED');
        } elseif ($return_value == 3) {
            $msg = JText :: _('JS_LIMIT_EXCEED_OR_ADMIN_BLOCK_THIS');
        } else {
            $msg = JText :: _('JS_ERROR_SAVING_SEARCH');
        }
        $link = 'index.php?option=com_jsjobs&c=resume&view=resume&layout=resume_searchresults&Itemid=' . $Itemid;
        $this->setRedirect(JRoute::_($link), $msg);
    }

    function deleteresumesearch() { //delete resume search
        $session = JFactory::getSession();
        $user = JFactory::getUser();
        $uid = $user->id;
        $Itemid = JRequest::getVar('Itemid');
        $data = JRequest :: get('post');
        $link = 'index.php?option=com_jsjobs&c=resume&view=resume&layout=my_resumesearches&Itemid=' . $Itemid;
        $searchid = JRequest::getVar('rs');
        $resumesearch = $this->getmodel('Resumesearch', 'JSJobsModel');
        $return_value = $resumesearch->deleteResumeSearch($searchid, $uid);

        if ($return_value == 1) {
            $msg = JText :: _('JS_SEARCH_DELETED');
        } elseif ($return_value == 2) {
            $msg = JText :: _('JS_NOT_YOUR_SEARCH');
        } else {
            $msg = JText :: _('JS_ERROR_DELETING_SEARCH');
        }
        $this->setRedirect(JRoute::_($link), $msg);
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
    