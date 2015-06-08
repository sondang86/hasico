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

class JSJobsControllerPaymenthistory extends JSController{

    function __construct() {
        parent :: __construct();
        $this->registerTask('add', 'edit');
    }

    function jobseekerpaymentapprove() {
        $cid = JRequest::getVar('cid', array(), '', 'array');
        $packageid = $cid[0];
        $paymenthistory_model = $this->getmodel('Paymenthistory', 'JSJobsModel');
        $return_value = $paymenthistory_model->jobseekerPaymentApprove($packageid);
        if ($return_value == 1) {
            $msg = JText::_('JS_PAYMENT_APPROVED');
        }
        else
            $msg = JText::_('JS_ERROR_IN_APPROVING_PAYMENT');

        $link = 'index.php?option=com_jsjobs&c=paymenthistory&view=paymenthistory&layout=jobseekerpaymenthistory';
        $this->setRedirect($link, $msg);
    }

    function jobseekerpaymentereject() {
        $cid = JRequest::getVar('cid', array(), '', 'array');
        $packageid = $cid[0];
        $paymenthistory_model = $this->getmodel('Paymenthistory', 'JSJobsModel');
        $return_value = $paymenthistory_model->jobseekerPaymentReject($packageid);
        if ($return_value == 1) {
            $msg = JText::_('JS_PAYMENT_REJECTED');
        }
        else
            $msg = JText::_('JS_ERROR_IN_REJECTING_PAYMENT');

        $link = 'index.php?option=com_jsjobs&c=paymenthistory&view=paymenthistory&layout=jobseekerpaymenthistory';
        $this->setRedirect($link, $msg);
    }

    function employerpaymentapprove() {
        $cid = JRequest::getVar('cid', array(), '', 'array');
        $packageid = $cid[0];
        $paymenthistory_model = $this->getmodel('Paymenthistory', 'JSJobsModel');
        $return_value = $paymenthistory_model->employerPaymentApprove($packageid);
        if ($return_value == 1) {
            $msg = JText::_('JS_PAYMENT_APPROVED');
        } else {
            $msg = JText::_('JS_ERROR_IN_APPROVING_PAYMENT');
        }

        $link = 'index.php?option=com_jsjobs&c=paymenthistory&view=paymenthistory&layout=employerpaymenthistory';
        $this->setRedirect($link, $msg);
    }

    function employerpaymentreject() {
        $cid = JRequest::getVar('cid', array(), '', 'array');
        $packageid = $cid[0];
        $paymenthistory_model = $this->getmodel('Paymenthistory', 'JSJobsModel');
        $return_value = $paymenthistory_model->employerPaymentReject($packageid);
        if ($return_value == 1) {
            $msg = JText::_('JS_PAYMENT_REJECTED');
        }
        else
            $msg = JText::_('JS_ERROR_IN_REJECTING_PAYMENT');

        $link = 'index.php?option=com_jsjobs&c=paymenthistory&view=paymenthistory&layout=employerpaymenthistory';
        $this->setRedirect($link, $msg);
    }

    function saveuserpackage() {
        $userrole = JRequest::getVar('userrole');
        $paymenthistory_model = $this->getmodel('Paymenthistory', 'JSJobsModel');
        $return_value = $paymenthistory_model->storeUserPackage();
        if ($return_value == 1) {
            $msg = JText::_('JS_PACKAGE_ASSIGN_TO_USER');
        } elseif ($return_value == 5) {
            $msg = JText::_('JS_CANNOT_ASSIGN_FREE_PACKAGE_MORE_THEN_ONCE');
        } else {
            $msg = JText::_('JS_ERROR_PACKAGE_CANNOT_ASSIGN_TO_USER');
        }
        if ($userrole == 1)
            $link = 'index.php?option=com_jsjobs&c=paymenthistory&view=paymenthistory&layout=employerpaymenthistory';
        else
            $link = 'index.php?option=com_jsjobs&c=paymenthistory&view=paymenthistory&layout=jobseekerpaymenthistory';

        $this->setRedirect($link, $msg);
    }

    function edit() {
        JRequest :: setVar('layout', 'assignpackage');
        JRequest :: setVar('view', 'paymenthistory');
        JRequest :: setVar('c', 'paymenthistory');
        $this->display();
    }

    function cancelemployerpaymenthistory() {
        $msg = JText::_('OPERATION_CANCELLED');
        $this->setRedirect('index.php?option=com_jsjobs&c=paymenthistory&view=paymenthistory&layout=employerpaymenthistory', $msg);
    }

    function canceljobseekerpaymenthistory() {
        $msg = JText::_('OPERATION_CANCELLED');
        $this->setRedirect('index.php?option=com_jsjobs&c=paymenthistory&view=paymenthistory&layout=jobseekerpaymenthistory', $msg);
    }

    function display($cachable = false, $urlparams = false) {
        $document = JFactory :: getDocument();
        $viewName = JRequest :: getVar('view', 'paymenthistory');
        $layoutName = JRequest :: getVar('layout', 'paymenthistory');
        $viewType = $document->getType();
        $view = $this->getView($viewName, $viewType);
        $jobsharing_model = $this->getModel('Jobsharing', 'JSJobsModel');
        $configuration_model = $this->getModel('Configuration', 'JSJobsModel');
        $paymenthistory_model = $this->getModel('Paymenthistory', 'JSJobsModel');
        if (!JError :: isError($jobsharing_model) && !JError::isError($configuration_model) && !JError::isError($paymenthistory_model)) {
            $view->setModel($jobsharing_model, true);
            $view->setModel($configuration_model);
            $view->setModel($paymenthistory_model);
        }
        $view->setLayout($layoutName);
        $view->display();
    }

}

?>