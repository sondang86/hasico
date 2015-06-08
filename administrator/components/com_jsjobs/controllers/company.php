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

class JSJobsControllerCompany extends JSController{

    function __construct() {
        parent :: __construct();
        $this->registerTask('add', 'edit');
    }

    function companyenforcedelete() {
        $jobsharing = $this->getModel('jobsharing', 'JSJobsModel');
        $cid = JRequest::getVar('cid', array(), '', 'array');
        $companyid = $cid[0];
        $user = JFactory::getUser();
        $uid = $user->id;
        $company_model = $this->getmodel('Company', 'JSJobsModel');
        $return_value = $company_model->companyEnforceDelete($companyid, $uid);
        if ($return_value == 1) {
            $msg = JText::_('JS_COMPANY_DELETED');
        } elseif ($return_value == 2) {
            $msg = JText::_('JS_ERROR_IN_DELETING_COMPANY');
        } elseif ($return_value == 3) {
            $msg = JText::_('JS_THIS_COMPANY_IS_NOT_OF_THIS_USER');
        }
        $link = 'index.php?option=com_jsjobs&c=company&view=company&layout=companies';
        $this->setRedirect($link, $msg);
    }

    function companyapprove() {
        $jobsharing = $this->getModel('jobsharing', 'JSJobsModel');
        $cid = JRequest::getVar('cid', array(), '', 'array');
        $companyid = $cid[0];
        $company_model = $this->getmodel('Company', 'JSJobsModel');
        $return_value = $company_model->companyApprove($companyid);
        if ($return_value == 1) {
            $msg = JText::_('JS_COMPANY_APPROVED');
        }
        else
            $msg = JText::_('JS_ERROR_IN_APPROVING_COMPANY');
        $link = 'index.php?option=com_jsjobs&c=company&view=company&layout=companiesqueue';
        $this->setRedirect($link, $msg);
    }

    function companyreject() {
        $jobsharing = $this->getModel('jobsharing', 'JSJobsModel');
        $cid = JRequest::getVar('cid', array(), '', 'array');
        $companyid = $cid[0];
        $company_model = $this->getmodel('Company', 'JSJobsModel');
        $return_value = $company_model->companyReject($companyid);
        if ($return_value == 1) {
            $msg = JText::_('JS_COMPANY_REJECTED');
        }
        else
            $msg = JText::_('JS_ERROR_IN_REJECTING_COMPANY');
        $link = 'index.php?option=com_jsjobs&c=company&view=company&layout=companiesqueue';
        $this->setRedirect($link, $msg);
    }

    function savecompany() {
        $jobsharing = $this->getModel('jobsharing', 'JSJobsModel');
        $company_model = $this->getmodel('Company', 'JSJobsModel');
        $return_value = $company_model->storeCompany();
        if ($return_value == 1) {
            $msg = JText::_('COMPANY_SAVED');
        } elseif ($return_value == 6) {
            $msg = JText::_('JS_COMPANY_FILE_TYPE_ERROR');
        } else {
            $msg = JText::_('ERROR_SAVING_COMPANY');
        }
        $link = 'index.php?option=com_jsjobs&c=company&view=company&layout=companies';
        $this->setRedirect($link, $msg);
    }

    function remove() {
        $company_model = $this->getmodel('Company', 'JSJobsModel');
        $returnvalue = $company_model->deleteCompany();
        if ($returnvalue == 1) {
            $msg = JText::_('COMPANY_DELETED');
        } else {
            $msg = $returnvalue - 1 . ' ' . JText::_('COMPANY_COULD_NOT_DELETE');
        }
        $this->setRedirect('index.php?option=com_jsjobs&c=company&view=company&layout=companies', $msg);
    }

    function cancel() {
        $msg = JText::_('OPERATION_CANCELLED');
        $this->setRedirect('index.php?option=com_jsjobs&c=company&view=company&layout=companies', $msg);
    }

    function edit() {
        JRequest :: setVar('layout', 'formcompany');
        JRequest :: setVar('view', 'company');
        JRequest :: setVar('c', 'company');
        $this->display();
    }


    function display($cachable = false, $urlparams = false) {
        $document = JFactory :: getDocument();
        $viewName = JRequest :: getVar('view', 'company');
        $layoutName = JRequest :: getVar('layout', 'companies');
        $viewType = $document->getType();
        $view = $this->getView($viewName, $viewType);
        $jobsharing_model = $this->getModel('Jobsharing', 'JSJobsModel');
        $configuration_model = $this->getModel('Configuration', 'JSJobsModel');
        $company_model = $this->getModel('Company', 'JSJobsModel');
        if (!JError :: isError($jobsharing_model) && !JError::isError($configuration_model) && !JError::isError($company_model)) {
            $view->setModel($jobsharing_model, true);
            $view->setModel($configuration_model);
            $view->setModel($company_model);
        }
        $view->setLayout($layoutName);
        $view->display();
    }

}

?>