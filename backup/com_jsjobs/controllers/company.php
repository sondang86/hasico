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

class JSJobsControllerCompany extends JSController {

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

    function savecompany() { //save company
        $jobsharing = $this->getModel('jobsharingsite', 'JSJobsModel');
        $uid = JRequest::getString('uid', 'none');
        $Itemid = JRequest::getVar('Itemid');
        $company = $this->getmodel('Company', 'JSJobsModel');
        $return_value = $company->storeCompany();
        $link = 'index.php?option=com_jsjobs&c=company&view=company&layout=mycompanies&Itemid=' . $Itemid;

        if ($return_value == 1) {
            $msg = JText :: _('COMPANY_SAVED');
        } else if ($return_value == 2) {
            $msg = JText :: _('JS_FILL_REQ_FIELDS');
            $link = 'index.php?option=com_jsjobs&c=company&view=company&layout=formcompany&Itemid=' . $Itemid;
        } else if ($return_value == 6) {
            $msg = JText :: _('JS_COMPANY_FILE_TYPE_ERROR');
        } else if ($return_value == 5) {
            $msg = JText :: _('JS_ERROR_LOGO_SIZE_LARGER');
            $link = 'index.php?option=com_jsjobs&c=company&view=company&layout=formcompany&Itemid=' . $Itemid;
        } else {
            $msg = JText :: _('ERROR_SAVING_COMPANY');
            $link = 'index.php?option=com_jsjobs&c=company&view=company&layout=formcompany&Itemid=' . $Itemid;
        }
        $this->setRedirect(JRoute::_($link), $msg);
    }

    function deletecompany() { //delete company
        $jobsharing = $this->getModel('jobsharingsite', 'JSJobsModel');
        $user = JFactory::getUser();
        $uid = $user->id;
        $Itemid = JRequest::getVar('Itemid');
        $common = $this->getmodel('Common', 'JSJobsModel');
        $companyid = $common->parseId(JRequest::getVar('cd', ''));
        $company = $this->getmodel('Company', 'JSJobsModel');
        $return_value = $company->deleteCompany($companyid, $uid);
        if ($return_value == 1) {
            $msg = JText :: _('JS_COMPANY_DELETED');
        } elseif ($return_value == 2) {
            $msg = JText :: _('JS_COMPANY_CANNOT_DELETE');
        } elseif ($return_value == 3) {
            $msg = JText :: _('JS_NOT_YOUR_COMPANY');
        } else {
            $msg = JText :: _('JS_ERROR_DELETING_COMPANY');
        }
        $link = 'index.php?option=com_jsjobs&c=company&view=company&layout=mycompanies&Itemid=' . $Itemid;
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
    