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

class JSJobsControllerCommon extends JSController{

    function __construct() {
        parent :: __construct();
        $this->registerTask('add', 'edit');
    }

    function makedefault() { //set default for default tables 
        $id = JRequest::getVar('id');
        $for = JRequest::getVar('for');
        $common_model = $this->getmodel('Common', 'JSJobsModel');
        $returnvalue = $common_model->setDefaultForDefaultTable($id, $for);
        $msg = "";
        switch ($for) {
            case "jobtypes":
                if ($returnvalue == 1) $msg = JText ::_('JS_DEFAULT_JOBTYPE_SAVED');
                else $msg = JText ::_('JS_ERROR_MAKING_DEFAULT_JOBTYPE');
                break;
            case "jobstatus":
                if ($returnvalue == 1) $msg = JText ::_('JS_DEFAULT_JOBSTATUS_SAVED');
                else $msg = JText ::_('JS_ERROR_MAKING_DEFAULT_JOBSTATUS');
                break;
            case "shifts":
                if ($returnvalue == 1) $msg = JText ::_('JS_DEFAULT_SHIFT_SAVED');
                else $msg = JText ::_('JS_ERROR_MAKING_DEFAULT_SHIFT');
                break;
            case "heighesteducation":
                $for = "highesteducations";
                if ($returnvalue == 1) $msg = JText ::_('JS_DEFAULT_HEIGHESTEDUCATION_SAVED');
                else $msg = JText ::_('JS_ERROR_MAKING_DEFAULT_HEIGHESTEDUCATION');
                break;
            case "ages":
                if ($returnvalue == 1) $msg = JText ::_('JS_DEFAULT_AGE_SAVED');
                else $msg = JText ::_('JS_ERROR_MAKING_DEFAULT_AGE');
                break;
            case "careerlevels":
                if ($returnvalue == 1) $msg = JText ::_('JS_DEFAULT_CAREERLEVELS_SAVED');
                else $msg = JText ::_('JS_ERROR_MAKING_DEFAULT_CAREERLEVELS');
                break;
            case "experiences":
                $for = "experience";
                if ($returnvalue == 1) $msg = JText ::_('JS_DEFAULT_EXPERIENCE_SAVED');
                else $msg = JText ::_('JS_ERROR_MAKING_DEFAULT_EXPERIENCE');
                break;
            case "salaryrange":
                if ($returnvalue == 1) $msg = JText ::_('JS_DEFAULT_SALARYRANGE_SAVED');
                else $msg = JText ::_('JS_ERROR_MAKING_DEFAULT_SALARYRANGE');
                break;
            case "salaryrangetypes":
                $for = "salaryrangetype";
                if ($returnvalue == 1) $msg = JText ::_('JS_DEFAULT_SALARYRANGE_TYPE_SAVED');
                else $msg = JText ::_('JS_ERROR_MAKING_DEFAULT_SALARYRANGE_TYPE');
                break;
            case "categories":
                if ($returnvalue == 1) $msg = JText ::_('JS_DEFAULT_CATEGORY_SAVED');
                else $msg = JText ::_('JS_ERROR_MAKING_DEFAULT_CATEGORY');
                break;
            case "subcategories":
            case "subcategory":
                $session = JFactory::getSession();
                $categoryid = $session->get('sub_categoryid');
                $for = "subcategories&cd=" . $categoryid;
                $layoutfor = 'subcategories';
                if ($returnvalue == 1) $msg = JText ::_('JS_DEFAULT_SUBCATEGORY_SAVED');
                else $msg = JText ::_('JS_ERROR_MAKING_DEFAULT_SUBCATEGORY');
                break;
        }
        if(isset($layoutfor) && $layoutfor == 'subcategories') $object = $this->getControllerViewByLayout('subcategories');
        else $object = $this->getControllerViewByLayout($for);
        $link = 'index.php?option=com_jsjobs&c=' . $object['c'] . '&view=' . $object['view'] . '&layout=' . $for;
        $this->setRedirect($link, $msg);
    }

    function getControllerViewByLayout($for) {
        switch ($for) {
            case 'jobtypes' : $object['view'] = $object['c'] = "jobtype"; break;
            case 'shifts' : $object['view'] = $object['c'] = "shift"; break;
            case 'heighesteducations' : $object['view'] = "highesteducation"; $object['c'] = "highesteducation"; break;
            case 'highesteducations' : $object['view'] = "highesteducation"; $object['c'] = "highesteducation"; break;
            case 'ages' : $object['view'] = $object['c'] = "age"; break;
            case 'careerlevels' : $object['view'] = $object['c'] = "careerlevel"; break;
            case 'salaryrangetypes' : $object['view'] = $object['c'] = "salaryrangetype"; break;
            case 'categories' : $object['view'] = $object['c'] = "category"; break;
            case 'subcategories' : case 'subcategory' : $object['view'] = $object['c'] = "subcategory"; break;
            default : $object['view'] = $object['c'] = $for; break;
        }
        return $object;
    }

    function defaultorderingup() {
        $id = JRequest::getVar('id');
        $for = JRequest::getVar('for');
        $common_model = $this->getmodel('Common', 'JSJobsModel');
        $returnvalue = $common_model->setOrderingUpForDefaultTable($id, $for);
        if ($for == "heighesteducation")
            $for = "highesteducations";
        elseif ($for == "experiences")
            $for = "experience";
        elseif ($for == "currencies")
            $for = "currency";
        elseif ($for == "salaryrangetypes")
            $for = "salaryrangetype";
        elseif ($for == "subcategories") {
            $session = JFactory::getSession();
            $categoryid = $session->get('sub_categoryid');
            $for = "subcategories&cd=" . $categoryid;
            $layout = 'subcategories';
        }
        if(isset($layout) && $layout == 'subcategories') $object = $this->getControllerViewByLayout('subcategories');
        else $object = $this->getControllerViewByLayout($for);
        $link = 'index.php?option=com_jsjobs&c='.$object['c'].'&view='.$object['view'].'&layout=' . $for;
        $this->setRedirect($link, $msg);
    }

    function defaultorderingdown() {
        $id = JRequest::getVar('id');
        $for = JRequest::getVar('for');
        $common_model = $this->getmodel('Common', 'JSJobsModel');
        $returnvalue = $common_model->setOrderingDownForDefaultTable($id, $for);
        if ($for == "heighesteducation")
            $for = "highesteducations";
        elseif ($for == "experiences")
            $for = "experience";
        elseif ($for == "currencies")
            $for = "currency";
        elseif ($for == "salaryrangetypes")
            $for = "salaryrangetype";
        elseif ($for == "subcategories") {
            $session = JFactory::getSession();
            $categoryid = $session->get('sub_categoryid');
            $for = "subcategories&cd=" . $categoryid;
            $layout = 'subcategories';
        }
        if(isset($layout) && $layout == 'subcategories') $object = $this->getControllerViewByLayout('subcategories');
        else $object = $this->getControllerViewByLayout($for);
        $link = 'index.php?option=com_jsjobs&c='.$object['c'].'&view='.$object['view'].'&layout=' . $for;
        $this->setRedirect($link, $msg);
    }

    function display($cachable = false, $urlparams = false) {
        $document = JFactory :: getDocument();
        $viewName = JRequest :: getVar('view', 'common');
        $layoutName = JRequest :: getVar('layout', 'common');
        $viewType = $document->getType();
        $view = $this->getView($viewName, $viewType);
        $model = $this->getModel('jsjobs', 'JSJobsModel');
        if (!JError :: isError($model)) {
            $view->setModel($model, true);
        }
        $view->setLayout($layoutName);
        $view->display();
    }

}

?>