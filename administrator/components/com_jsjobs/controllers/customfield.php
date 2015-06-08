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

class JSJobsControllerCustomfield extends JSController{

    function __construct() {
        parent :: __construct();
        $this->registerTask('add', 'edit');
    }

    function deleteuserfieldoption() {
        $option_id = JRequest::getVar('id');
        $customfield_model = $this->getmodel('Customfield', 'JSJobsModel');
        $returnvalue = $customfield_model->deleteUserFieldOptionValue($option_id);
        echo $returnvalue;
        JFactory::getApplication()->close();
    }

    function deleteuserfield() {
        $fieldfor = JRequest::getVar('fieldfor');
        $customfield_model = $this->getmodel('Customfield', 'JSJobsModel');
        $return_value = $customfield_model->deleteUserField();
        if ($return_value == 1) {
            $msg = JText::_('JS_USER_FIELD_DELETE');
        } else {
            $msg = $returnvalue - 1 . ' ' . JText::_('JS_USER_FIELD_COULD_NOT_DELETE');
        }
        $link = 'index.php?option=com_jsjobs&c=customfield&view=customfield&layout=userfields&ff='.$fieldfor;
        $this->setRedirect($link, $msg);
    }

    function saveuserfield() {
        $customfield_model = $this->getmodel('Customfield', 'JSJobsModel');
        $return_value = $customfield_model->storeUserField();
        $fieldfor = JRequest::getVar('fieldfor');
        if ($return_value == 1) {
            $msg = JText::_('USER_FIELD_SAVED');
            $link = 'index.php?option=com_jsjobs&c=customfield&view=customfield&layout=userfields&ff='.$fieldfor;
            $this->setRedirect($link, $msg);
        } else if ($return_value == 2) {
            $msg = JText::_('ALL_FIELD_MUST_BE_ENTERD');
            JRequest :: setVar('hidemainmenu', 1);
            JRequest :: setVar('msg', $msg);
            // Display based on the set variables
            $this->edit();
        } else {
            $msg = JText::_('ERROR_SAVING_USER_FIELD');
            $link = 'index.php?option=com_jsjobs&c=customfield&view=customfield&layout=formuserfield&ff='.$fieldfor;
            $this->setRedirect($link, $msg);
        }
    }

    function edit() {
        $fieldfor = JRequest::getVar('fieldfor');
        JRequest :: setVar('layout', 'formuserfield');
        JRequest :: setVar('view', 'customfield');
        JRequest :: setVar('c', 'customfield');
        JRequest :: setVar('fieldfor', $fieldfor);
        $this->display();
    }

    function remove() {
        $this->deleteuserfield();
    }

    function cancel() {
        $msg = JText::_('OPERATION_CANCELLED');
        $fieldfor = JRequest::getVar('fieldfor');
        $this->setRedirect('index.php?option=com_jsjobs&c=customfield&view=customfield&layout=userfields&ff='.$fieldfor, $msg);
    }

    function display($cachable = false, $urlparams = false) {
        $document = JFactory :: getDocument();
        $viewName = JRequest :: getVar('view', 'customfield');
        $layoutName = JRequest :: getVar('layout', 'customfield');
        $viewType = $document->getType();
        $view = $this->getView($viewName, $viewType);
        $jobsharing_model = $this->getModel('Jobsharing', 'JSJobsModel');
        $configuration_model = $this->getModel('Configuration', 'JSJobsModel');
        $customfield_model = $this->getModel('Customfield', 'JSJobsModel');
        $fieldordering_model = $this->getModel('Fieldordering', 'JSJobsModel');
        if (!JError :: isError($jobsharing_model) && !JError::isError($configuration_model) && !JError::isError($customfield_model) && !JError::isError($fieldordering_model)) {
            $view->setModel($jobsharing_model, true);
            $view->setModel($configuration_model);
            $view->setModel($customfield_model);
            $view->setModel($fieldordering_model);
        }
        $view->setLayout($layoutName);
        $view->display();
    }

}

?>