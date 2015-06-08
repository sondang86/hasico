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

class JSJobsControllerCategory extends JSController{

    function __construct() {
        parent :: __construct();
        $this->registerTask('add', 'edit');
    }

    function deletecategoryandsubcategory() {       // delete category and subcategory
        $category_model = $this->getmodel('Category', 'JSJobsModel');
        $returnvalue = $category_model->deleteCategoryAndSubcategory();
        if ($returnvalue == 1) {
            $msg = JText::_('JS_CATEGORY_AND_SUBCATEGORY_DELETED');
        } else {
            $msg = $returnvalue - 1 . ' ' . JText::_('JS_ERROR_CATEGORY_AND_SUBCATEGORY_COULD_NOT_DELETE');
        }
        $this->setRedirect('index.php?option=com_jsjobs&c=category&view=category&layout=categories', $msg);
    }

    function publishcategories() {
        $cid = JRequest::getVar('cid', array(), '', 'array');
        $id = $cid[0];
        $category_model = $this->getmodel('Category', 'JSJobsModel');
        $return_value = $category_model->categoryChangeStatus($id, 1);
        if ($return_value != 1)
            $msg = JText::_('JS_ERROR_OCCUR');

        $link = 'index.php?option=com_jsjobs&c=category&view=category&layout=categories';
        $this->setRedirect($link, $msg);
    }

    function unpublishcategories() {
        $cid = JRequest::getVar('cid', array(), '', 'array');
        $id = $cid[0];
        $category_model = $this->getmodel('Category', 'JSJobsModel');
        $return_value = $category_model->categoryChangeStatus($id, 0);
        if ($return_value != 1)
            $msg = JText::_('JS_ERROR_OCCUR');

        $link = 'index.php?option=com_jsjobs&c=category&view=category&layout=categories';
        $this->setRedirect($link, $msg);
    }

    function savecategory() {
        $category_model = $this->getmodel('Category', 'JSJobsModel');
        $return_value = $category_model->storeCategory();
        $link = 'index.php?option=com_jsjobs&c=category&view=category&layout=categories';
        if (is_array($return_value)) {
            if ($return_value['return_value'] == false) { // jobsharing return value 
                $msg = JText::_('CATEGORY_SAVED');
                if ($return_value['rejected_value'] != "")
                    $msg = JText::_('JS_CATEGORY_SAVED_BUT_SHARING_SERVER_NOT_ACCEPT_THE_JOB_OF_THESE_CATEGORY_DUE_TO_IMPROPER_NAME');
                if ($return_value['authentication_value'] != "")
                    $msg = JText::_('JS_CATEGORY_SAVED_BUT_AUTHENTICATION_FAILED_ON_SHARING_SERVER');
                if ($return_value['server_responce'] != "")
                    $msg = JText::_('JS_CATEGORY_SAVED_BUT_PROBLEM_SYNCHRONIZE_WITH_SHARING_SERVER');
                $this->setRedirect($link, $msg);
            }elseif ($return_value['return_value'] == true) { // jobsharing return value 
                $msg = JText::_('CATEGORY_SAVED');
                $this->setRedirect($link, $msg);
            }
        } else {
            if ($return_value == 1) {
                $msg = JText::_('CATEGORY_SAVED');
                $link = 'index.php?option=com_jsjobs&c=category&view=category&layout=categories';
                $this->setRedirect($link, $msg);
            } elseif ($return_value == 2) {
                $msg = JText::_('ALL_FIELD_MUST_BE_ENTERD');
                JRequest :: setVar('view', 'category');
                JRequest :: setVar('hidemainmenu', 1);
                JRequest :: setVar('layout', 'formcategory');
                JRequest :: setVar('msg', $msg);

                // Display based on the set variables
                $this->display();
            } elseif ($return_value == 3) {
                $msg = JText::_('CATEGORY_ALREADY_EXIST');
                JRequest :: setVar('view', 'category');
                JRequest :: setVar('hidemainmenu', 1);
                JRequest :: setVar('layout', 'formcategory');
                JRequest :: setVar('msg', $msg);
                $this->display();
            } else {
                $msg = JText::_('ERROR_SAVING_CATEGORY');
                $link = 'index.php?option=com_jsjobs&c=category&view=category&layout=categories';
                $this->setRedirect($link, $msg);
            }
        }
    }

    function edit() {
        JRequest :: setVar('layout', 'formcategory');
        JRequest :: setVar('view', 'category');
        JRequest :: setVar('c', 'category');
        $this->display();
    }

    function remove() {
        $category_model = $this->getmodel('Category', 'JSJobsModel');
        $returnvalue = $category_model->deleteCategory();
        if ($returnvalue == 1) {
            $msg = JText::_('CATEGORY_DELETED');
        } else {
            $msg = $returnvalue - 1 . ' ' . JText::_('ERROR_CATEGORY_COULD_NOT_DELETE');
        }
        $this->setRedirect('index.php?option=com_jsjobs&c=category&view=category&layout=categories', $msg);
    }

    function cancel() {
        $msg = JText::_('OPERATION_CANCELLED');
        $this->setRedirect('index.php?option=com_jsjobs&c=category&view=category&layout=categories', $msg);
    }

    function display($cachable = false, $urlparams = false) {
        $document = JFactory :: getDocument();
        $viewName = JRequest :: getVar('view', 'category');
        $layoutName = JRequest :: getVar('layout', 'category');
        $viewType = $document->getType();
        $view = $this->getView($viewName, $viewType);
        $jobsharing_model = $this->getModel('Jobsharing', 'JSJobsModel');
        $configuration_model = $this->getModel('Configuration', 'JSJobsModel');
        $category_model = $this->getModel('Category', 'JSJobsModel');
        if (!JError :: isError($jobsharing_model) && !JError::isError($configuration_model) && !JError::isError($category_model)) {
            $view->setModel($jobsharing_model, true);
            $view->setModel($configuration_model);
            $view->setModel($category_model);
        }
        $view->setLayout($layoutName);
        $view->display();
    }

}

?>