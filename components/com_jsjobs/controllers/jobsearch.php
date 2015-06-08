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

class JSJobsControllerJobsearch extends JSController {

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

    function savejobsearch() { //save job search
        $uid = JRequest::getString('uid', 'none');
        $Itemid = JRequest::getVar('Itemid');
        $data = JRequest :: get('post');
        $user = JFactory::getUser();
        $data['uid'] = $user->id;
        $mainframe = JFactory::getApplication();
        $option = 'com_jsjobs';
        $data['jobtitle'] = $mainframe->getUserStateFromRequest($option.'title','title','','string');
        $data['category'] = $mainframe->getUserStateFromRequest($option.'jobcategory','jobcategory','','string');
        $data['jobsubcategory'] = $mainframe->getUserStateFromRequest($option.'jobsubcategory','jobsubcategory','','string');
        $data['jobtype'] = $mainframe->getUserStateFromRequest($option.'jobtype','jobtype','','string');
        $data['jobstatus'] = $mainframe->getUserStateFromRequest($option.'jobstatus','jobstatus','','string');
        $data['salaryrange'] = $mainframe->getUserStateFromRequest($option.'salaryrangefrom','salaryrangefrom','','string');
        $data['salaryrange'] = $mainframe->getUserStateFromRequest($option.'salaryrangeto','salaryrangeto','','string');
        $data['salaryrangetype'] = $mainframe->getUserStateFromRequest($option.'salaryrangetype','salaryrangetype','','string');
        $data['education'] = $mainframe->getUserStateFromRequest($option.'education','education','','string');
        $data['heighesteducation'] = $mainframe->getUserStateFromRequest($option.'heighestfinisheducation','heighestfinisheducation','','string');
        $data['shift'] = $mainframe->getUserStateFromRequest($option.'shift','shift','','string');
        $data['experience'] = $mainframe->getUserStateFromRequest($option.'experience','experience','','string');
        $data['durration'] = $mainframe->getUserStateFromRequest($option.'durration','durration','','string');
        $data['startpublishing'] = $mainframe->getUserStateFromRequest($option.'startpublishing','startpublishing','','string');
        $data['stoppublishing'] = $mainframe->getUserStateFromRequest($option.'stoppublishing','stoppublishing','','string');
        $data['company'] = $mainframe->getUserStateFromRequest($option.'jobsearch_company','jobsearch_company','','string');
        $data['city'] = $mainframe->getUserStateFromRequest($option.'searchcity','searchcity','','string');
        $data['zipcode'] = $mainframe->getUserStateFromRequest($option.'zipcode','zipcode','','string');
        $data['currency'] = $mainframe->getUserStateFromRequest($option.'currency','currency','','string');
        $data['longitude'] = $mainframe->getUserStateFromRequest($option.'longitude','longitude','','string');
        $data['latitude'] = $mainframe->getUserStateFromRequest($option.'latitude','latitude','','string');
        $data['radius'] = $mainframe->getUserStateFromRequest($option.'radius','radius','','string');
        $data['radius_length_type'] = $mainframe->getUserStateFromRequest($option.'radius_length_type','radius_length_type','','string');
        $data['keywords'] = $mainframe->getUserStateFromRequest($option.'keywords','keywords','','string');

        $data['created'] = date('Y-m-d H:i:s');
        $data['status'] = 1;
        $jobsearch = $this->getmodel('Jobsearch', 'JSJobsModel');
        $option = 'com_jsjobs';
        $return_value = $jobsearch->storeJobSearch($data);

        if ($return_value == 1) {
            $msg = JText :: _('JS_SEARCH_SAVED');
        } elseif ($return_value == 3) {
            $msg = JText :: _('JS_LIMIT_EXCEED_OR_ADMIN_BLOCK_THIS');
        } else {
            $msg = JText :: _('JS_ERROR_SAVING_SEARCH');
        }
        $link = 'index.php?option=com_jsjobs&c=job&view=job&layout=job_searchresults&Itemid=' . $Itemid;
        $this->setRedirect(JRoute::_($link), $msg);
    }

    function deletejobsearch() { //delete job search
        $user = JFactory::getUser();
        $uid = $user->id;
        $Itemid = JRequest::getVar('Itemid');
        $data = JRequest :: get('post');
        $link = 'index.php?option=com_jsjobs&c=jobsearch&view=jobsearch&layout=my_jobsearches&Itemid=' . $Itemid;
        $searchid = JRequest::getVar('js');
        $jobsearch = $this->getmodel('Jobsearch', 'JSJobsModel');
        $return_value = $jobsearch->deleteJobSearch($searchid, $uid);

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
