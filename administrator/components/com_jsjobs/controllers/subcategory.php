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

class JSJobsControllerSubcategory extends JSController {

    function __construct() {
        parent :: __construct();
        $this->registerTask('add', 'edit');
    }

    function setorderingsubcategories() {
        $data = JRequest::get('post');
        $categoryid = JRequest::getVar('cd');
        $subcategory_model = $this->getmodel('Subcategory', 'JSJobsModel');
        $returnvalue = $subcategory_model->setOrderingSubcategories($categoryid);
        if ($returnvalue == 1)
            $msg = JText ::_('JS_ORDERING_SET_SUCESSFULLY');
        else
            $msg = JText ::_('JS_ERROR_ORDERING_SET');
        $for = "subcategories&cd=" . $categoryid;
        $link = 'index.php?option=com_jsjobs&c=subcategory&view=subcategory&layout=' . $for;
        $this->setRedirect($link, $msg);
    }

    function editsubcategories() {
        JRequest :: setVar('layout', 'formsubcategory');
        JRequest :: setVar('view', 'subcategory');
        JRequest :: setVar('c', 'subcategory');
        $this->display();
    }

    function publishsubcategories() {
        $cid = JRequest::getVar('cid', array(), '', 'array');
        $id = $cid[0];
        $subcategory_model = $this->getmodel('Subcategory', 'JSJobsModel');
        $return_value = $subcategory_model->subCategoryChangeStatus($id, 1);
        if ($return_value != 1)
            $msg = JText::_('JS_ERROR_OCCUR');

        $session = JFactory::getSession();
        $categoryid = $session->set('sub_categoryid');
        $link = 'index.php?option=com_jsjobs&c=subcategory&view=subcategory&layout=subcategories&cd=' . $categoryid;
        $this->setRedirect($link, $msg);
    }

    function unpublishsubcategories() {
        $cid = JRequest::getVar('cid', array(), '', 'array');
        $id = $cid[0];
        $subcategory_model = $this->getmodel('Subcategory', 'JSJobsModel');
        $return_value = $subcategory_model->subCategoryChangeStatus($id, 0);
        if ($return_value != 1)
            $msg = JText::_('JS_ERROR_OCCUR');

        $session = JFactory::getSession();
        $categoryid = $session->set('sub_categoryid');
        $link = 'index.php?option=com_jsjobs&c=subcategory&view=subcategory&layout=subcategories&cd=' . $categoryid;
        $this->setRedirect($link, $msg);
    }

    function removesubcategory() {
        $subcategory_model = $this->getmodel('Subcategory', 'JSJobsModel');
        $returnvalue = $subcategory_model->deleteSubCategory();
        if ($returnvalue == 1)
            $msg = JText::_('CATEGORY_DELETED');
        else
            $msg = $returnvalue - 1 . ' ' . JText::_('ERROR_CATEGORY_COULD_NOT_DELETE');
        $session = JFactory::getSession();
        $categoryid = $session->get('sub_categoryid');
        $this->setRedirect('index.php?option=com_jsjobs&c=subcategory&view=subcategory&layout=subcategories&cd=' . $categoryid, $msg);
    }

    function cancelsubcategories() {
        $msg = JText::_('OPERATION_CANCELLED');
        $session = JFactory::getSession();
        $categoryid = $session->get('sub_categoryid');
        $this->setRedirect('index.php?option=com_jsjobs&c=subcategory&view=subcategory&layout=subcategories&cd=' . $categoryid, $msg);
    }

    function savesubcategory() {
        $subcategory_model = $this->getmodel('Subcategory', 'JSJobsModel');
        $return_value = $subcategory_model->storeSubCategory();
        $session = JFactory::getSession();
        $categoryid = $session->get('sub_categoryid');
        $link = 'index.php?option=com_jsjobs&c=subcategory&view=subcategory&layout=subcategories&cd=' . $categoryid;
        if (is_array($return_value)) {
            if ($return_value['return_value'] == false) { // jobsharing return value 
                $msg = JText::_('CATEGORY_SAVED');
                if ($return_value['rejected_value'] != "")
                    $msg = JText::_('JS_SUBCATEGORY_SAVED_BUT_SHARING_SERVER_NOT_ACCEPT_THE_JOB_OF_THESE_SUBCATEGORY_DUE_TO_IMPROPER_NAME');
                if ($return_value['authentication_value'] != "")
                    $msg = JText::_('JS_SUBCATEGORY_SAVED_BUT_AUTHENTICATION_FAILED_ON_SHARING_SERVER');
                if ($return_value['server_responce'] != "")
                    $msg = JText::_('JS_SUBCATEGORY_SAVED_BUT_PROBLEM_SYNCHRONIZE_WITH_SHARING_SERVER');
                $this->setRedirect($link, $msg);
            }elseif ($return_value['return_value'] == true) { // jobsharing return value 
                $msg = JText::_('CATEGORY_SAVED');
                $this->setRedirect($link, $msg);
            }
        } else {
            if ($return_value == 1) {
                $msg = JText::_('CATEGORY_SAVED');
                $link = 'index.php?option=com_jsjobs&c=subcategory&view=subcategory&layout=subcategories&cd=' . $categoryid;
                $this->setRedirect($link, $msg);
            } else if ($return_value == 2) {
                $msg = JText::_('ALL_FIELD_MUST_BE_ENTERD');
                JRequest :: setVar('view', 'subcategory');
                JRequest :: setVar('hidemainmenu', 1);
                JRequest :: setVar('layout', 'formsubcategory');
                JRequest :: setVar('msg', $msg);
                // Display based on the set variables
                $this->display(); //parent :: display();
            } else if ($return_value == 3) {
                $msg = JText::_('CATEGORY_ALREADY_EXIST');
                JRequest :: setVar('view', 'subcategory');
                JRequest :: setVar('hidemainmenu', 1);
                JRequest :: setVar('layout', 'formsubcategory');
                JRequest :: setVar('msg', $msg);
                $this->display(); //parent :: display();
            } else {
                $msg = JText::_('ERROR_SAVING_CATEGORY');
                $link = 'index.php?option=com_jsjobs&c=subcategory&view=subcategory&layout=subcategories&cd=' . $categoryid;
                $this->setRedirect($link, $msg);
            }
        }
    }

    function listsubcategories() {
        $val = JRequest::getVar('val');
        $subcategory_model = $this->getmodel('Subcategory', 'JSJobsModel');
        $returnvalue = $subcategory_model->listSubCategories($val);
        echo $returnvalue;
        JFactory::getApplication()->close();
    }

    function listsubcategoriesforsearch() {
        $val = JRequest::getVar('val');
        $model = $this->getModel('subcategory', 'JSJobsModel');
        $returnvalue = $model->listSubCategoriesForSearch($val);
        echo $returnvalue;
        JFactory::getApplication()->close();
    }

    function display($cachable = false, $urlparams = false) {
        $document = JFactory :: getDocument();
        $viewName = JRequest :: getVar('view', 'subcategory');
        $layoutName = JRequest :: getVar('layout', 'subcategory');
        $viewType = $document->getType();
        $view = $this->getView($viewName, $viewType);
        $jobsharing_model = $this->getModel('Jobsharing', 'JSJobsModel');
        $configuration_model = $this->getModel('Configuration', 'JSJobsModel');
        $subcategory_model = $this->getModel('Subcategory', 'JSJobsModel');
        if (!JError :: isError($jobsharing_model) && !JError::isError($configuration_model) && !JError::isError($subcategory_model)) {
            $view->setModel($jobsharing_model, true);
            $view->setModel($configuration_model);
            $view->setModel($subcategory_model);
        }
        $view->setLayout($layoutName);
        $view->display();
    }

}

?>