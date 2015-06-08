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

class JSJobsControllerFieldordering extends JSController{

    function __construct() {
        parent :: __construct();
        $this->registerTask('add', 'edit');
    }

    function fieldrequired() {
        $input = JFactory::getApplication()->input;
        $cid = $input->post->get('cid', array(), 'array');
        $session = JFactory::getSession();
        $fieldfor = $session->get('fieldfor');
        $fieldordering_model = $this->getmodel('Fieldordering', 'JSJobsModel');
        $return_value = $fieldordering_model->fieldRequired($cid, 1); //required
        $link = 'index.php?option=com_jsjobs&c=fieldordering&view=fieldordering&layout=fieldsordering&ff=' . $fieldfor;
        $msg = JText :: _('JS_REQUIRED');
        $this->setRedirect($link, $msg);
    }

    function fieldnotrequired() {
        $input = JFactory::getApplication()->input;
        $cid = $input->post->get('cid', array(), 'array');
        $session = JFactory::getSession();
        $fieldfor = $session->get('fieldfor');
        $fieldordering_model = $this->getmodel('Fieldordering', 'JSJobsModel');
        $return_value = $fieldordering_model->fieldNotRequired($cid, 0); // notrequired
        $link = 'index.php?option=com_jsjobs&c=fieldordering&view=fieldordering&layout=fieldsordering&ff=' . $fieldfor;
        $msg = JText :: _('JS_NOT_REQUIRED');
        $this->setRedirect($link, $msg);
    }

    function fieldpublished() {
        $session = JFactory::getSession();
        $fieldfor = $session->get('fieldfor');
        $cid = JRequest::getVar('cid', array(), '', 'array');
        $fieldordering_model = $this->getmodel('Fieldordering', 'JSJobsModel');
        $return_value = $fieldordering_model->fieldPublished($cid, 1); //published
        $link = 'index.php?option=com_jsjobs&c=fieldordering&view=fieldordering&layout=fieldsordering&ff=' . $fieldfor;
        $msg = JText :: _('JS_PUBLISHED');
        $this->setRedirect($link, $msg);
    }

    function visitorfieldpublished() {
        $session = JFactory::getSession();
        $fieldfor = $session->get('fieldfor');
        $input = JFactory::getApplication()->input;
        $cid = $input->post->get('cid', array(), 'array');
        $fieldordering_model = $this->getmodel('Fieldordering', 'JSJobsModel');
        $return_value = $fieldordering_model->visitorFieldPublished($cid, 1); // unpublished
        $link = 'index.php?option=com_jsjobs&c=fieldordering&view=fieldordering&layout=fieldsordering&ff=' . $fieldfor;
        $msg = JText :: _('JS_PUBLISHED');
        $this->setRedirect($link, $msg);
    }

    function fieldunpublished() {
        $session = JFactory::getSession();
        $fieldfor = $session->get('fieldfor');
        $cid = JRequest::getVar('cid', array(), '', 'array');
        $fieldordering_model = $this->getmodel('Fieldordering', 'JSJobsModel');
        $return_value = $fieldordering_model->fieldPublished($cid, 0); // unpublished
        $link = 'index.php?option=com_jsjobs&c=fieldordering&view=fieldordering&layout=fieldsordering&ff=' . $fieldfor;
        $msg = JText :: _('JS_UNPUBLISHED');
        $this->setRedirect($link, $msg);
    }

    function visitorfieldunpublished() {
        $session = JFactory::getSession();
        $fieldfor = $session->get('fieldfor');
        $input = JFactory::getApplication()->input;
        $cid = $input->post->get('cid', array(), 'array');
        $fieldordering_model = $this->getmodel('Fieldordering', 'JSJobsModel');
        $return_value = $fieldordering_model->visitorFieldPublished($cid, 0); // unpublished
        $link = 'index.php?option=com_jsjobs&c=fieldordering&view=fieldordering&layout=fieldsordering&ff=' . $fieldfor;
        $msg = JText :: _('JS_UNPUBLISHED');
        $this->setRedirect($link, $msg);
    }

    function fieldorderingup() {
        $session = JFactory::getSession();
        $fieldfor = $session->get('fieldfor');
        $cid = JRequest::getVar('cid', array(), '', 'array');
        $fieldid = $cid[0];
        $fieldordering_model = $this->getmodel('Fieldordering', 'JSJobsModel');
        $return_value = $fieldordering_model->fieldOrderingUp($fieldid);
        $link = 'index.php?option=com_jsjobs&c=fieldordering&view=fieldordering&layout=fieldsordering&ff=' . $fieldfor;
        $this->setRedirect($link, $msg);
    }

    function fieldorderingdown() {
        $session = JFactory::getSession();
        $fieldfor = $session->get('fieldfor');
        $cid = JRequest::getVar('cid', array(), '', 'array');
        $fieldid = $cid[0];
        $fieldordering_model = $this->getmodel('Fieldordering', 'JSJobsModel');
        $return_value = $fieldordering_model->fieldOrderingDown($fieldid);
        $link = 'index.php?option=com_jsjobs&c=fieldordering&view=fieldordering&layout=fieldsordering&ff=' . $fieldfor;
        $this->setRedirect($link, $msg);
    }

    function publishunpublishfields($call) {
        $ff = JRequest::getVar('ff');
        $fieldordering_model = $this->getmodel('Fieldordering', 'JSJobsModel');
        $return_value = $fieldordering_model->publishunpublishfields($call);
        if ($return_value == 1) {
            $msg = JText::_('JS_PUBLISHED');
        } else {
            $msg = JText::_('JS_ERROR_PUBLISHING');
        }
        $link = 'index.php?option=com_jsjobs&c=fieldordering&view=fieldordering&layout=fieldsordering&ff=' . $ff;
        $this->setRedirect($link, $msg);
    }

    function saveresumeuserfields() {
        $data = JRequest :: get('post');
        $fieldfor = $data['fieldfor'];
        $fieldordering_model = $this->getmodel('Fieldordering', 'JSJobsModel');
        $return_value = $fieldordering_model->storeResumeUserFields();
        if ($return_value == 1)
            $msg = JText::_('RESUME_USER_FIELD_SAVED');
        else
            $msg = JText::_('ERROR_SAVING_RESUME_USER_FIELD');

        $link = 'index.php?option=com_jsjobs&c=resume&view=resume&layout=formresumeuserfield&ff=' . $fieldfor;
        $this->setRedirect($link, $msg);
    }

    function display($cachable = false, $urlparams = false) {
        $document = JFactory :: getDocument();
        $viewName = JRequest :: getVar('view', 'fieldordering');
        $layoutName = JRequest :: getVar('layout', 'fieldordering');
        $viewType = $document->getType();
        $view = $this->getView($viewName, $viewType);
        $jobsharing_model = $this->getModel('Jobsharing', 'JSJobsModel');
        $configuration_model = $this->getModel('Configuration', 'JSJobsModel');
        $fieldordering_model = $this->getModel('Fieldordering', 'JSJobsModel');
        if (!JError :: isError($jobsharing_model) && !JError::isError($configuration_model) && !JError::isError($fieldordering_model)) {
            $view->setModel($jobsharing_model, true);
            $view->setModel($configuration_model);
            $view->setModel($fieldordering_model);
        }
        $view->setLayout($layoutName);
        $view->display();
    }

}

?>