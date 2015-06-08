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

class JSJobsControllerCurrency extends JSController{

    function __construct() {
        parent :: __construct();
        $this->registerTask('add', 'edit');
    }

    function editjobcurrency() {
        JRequest :: setVar('layout', 'formcurrency');
        JRequest :: setVar('view', 'currency');
        JRequest :: setVar('c', 'currency');
        $this->display();
    }

    function savejobcurrency() {
        $redirect = $this->savecurrency('saveclose');
    }

    function savejobcurrencysave() {
        $redirect = $this->savecurrency('save');
    }

    function savejobcurrencyandnew() {
        $redirect = $this->savecurrency('saveandnew');
    }

    function savecurrency($callfrom) {
        $currency_model = $this->getmodel('Currency', 'JSJobsModel');
        $return_value = $currency_model->storeCurrency();
        $link = 'index.php?option=com_jsjobs&c=currency&view=currency&layout=currency';
        if (is_array($return_value)) {
            if ($return_value['issharing'] == 1) {
                if ($return_value['return_value'] == false) { // jobsharing return value 
                    $msg = JText::_('JS_CURRENCY_SAVED');
                    if ($return_value['rejected_value'] != "")
                        $msg = JText::_('JS_CURRENCY_SAVED_BUT_SHARING_SERVER_NOT_ACCEPT_THE_JOB_OF_THESE_CURRENCY_DUE_TO_IMPROPER_NAME');
                    if ($return_value['authentication_value'] != "")
                        $msg = JText::_('JS_CURRENCY_SAVED_BUT_AUTHENTICATION_FAILED_ON_SHARING_SERVER');
                    if ($return_value['server_responce'] != "")
                        $msg = JText::_('JS_CURRENCY_SAVED_BUT_PROBLEM_SYNCHRONIZE_WITH_SHARING_SERVER');
                    $this->setRedirect($link, $msg);
                }elseif ($return_value['return_value'] == true) { // jobsharing return value 
                    $redirect = 1;
                }
            } elseif ($return_value['issharing'] == 0) {
                if ($return_value[1] == 1) {
                    $redirect = 1;
                }
            }
            if ($redirect == 1) {
                $msg = JText::_('JS_CURRENCY_SAVED');
                if ($callfrom == 'saveclose') {
                    $link = 'index.php?option=com_jsjobs&c=currency&view=currency&layout=currency';
                } elseif ($callfrom == 'save') {
                    $link = 'index.php?option=com_jsjobs&c=currency&view=currency&layout=formcurrency&cid[]=' . $return_value[2];
                } elseif ($callfrom == 'saveandnew') {
                    $link = 'index.php?option=com_jsjobs&c=currency&view=currency&layout=formcurrency';
                }
                $this->setRedirect($link, $msg);
            } elseif ($return_value == false) {
                $msg = JText::_('JS_ERROR_SAVING_CURRENCY');
                $this->setRedirect($link, $msg);
            }
        } else {
            if ($return_value == 3) {
                $msg = JText::_('JS_CURRENCY_ALREADY_EXIST');
                JRequest :: setVar('view', 'currency');
                JRequest :: setVar('hidemainmenu', 1);
                JRequest :: setVar('layout', 'formcurrency');
                JRequest :: setVar('msg', $msg);
                $this->display();
            } else {
                $msg = JText::_('JS_ERROR_SAVING_CURRENCY');
                $this->setRedirect($link, $msg);
            }
        }
    }

    function makedefaultcurrency() { // make default currency
        $cid = JRequest::getVar('cid', array(), '', 'array');
        $defaultid = $cid[0];
        $currency_model = $this->getmodel('Currency', 'JSJobsModel');
        $return_value = $currency_model->makeDefaultCurrency($defaultid, 1);
        if ($return_value == 1) {
            $msg = JText :: _('JS_DEFAULT_CURRENCY_SAVED');
        } else {
            $msg = JText :: _('JS_ERROR_MAKING_DEFAULT_CURRENCY');
        }
        $link = 'index.php?option=com_jsjobs&c=currency&view=currency&layout=currency';
        $this->setRedirect($link, $msg);
    }

    function remove() {
        $currency_model = $this->getmodel('Currency', 'JSJobsModel');
        $returnvalue = $currency_model->deleteCurrency();
        if ($returnvalue == 1) {
            $msg = JText::_('CURRENCY_DELETED');
        } else {
            $msg = $returnvalue - 1 . ' ' . JText::_('ERROR_CURRENCY_COULD_NOT_DELETE');
        }
        $this->setRedirect('index.php?option=com_jsjobs&c=currency&view=currency&layout=currency', $msg);
    }

    function cancel() {
        $msg = JText::_('OPERATION_CANCELLED');
        $this->setRedirect('index.php?option=com_jsjobs&c=currency&view=currency&layout=currency', $msg);
    }

    function display($cachable = false, $urlparams = false) {
        $document = JFactory :: getDocument();
        $viewName = JRequest :: getVar('view', 'currency');
        $layoutName = JRequest :: getVar('layout', 'currency');
        $viewType = $document->getType();
        $view = $this->getView($viewName, $viewType);
        $jobsharing_model = $this->getModel('Jobsharing', 'JSJobsModel');
        $configuration_model = $this->getModel('Configuration', 'JSJobsModel');
        $currency_model = $this->getModel('Currency', 'JSJobsModel');
        if (!JError :: isError($jobsharing_model) && !JError::isError($configuration_model) && !JError::isError($currency_model)) {
            $view->setModel($jobsharing_model, true);
            $view->setModel($configuration_model);
            $view->setModel($currency_model);
        }
        $view->setLayout($layoutName);
        $view->display();
    }

}

?>