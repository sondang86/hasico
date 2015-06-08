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

class JSJobsControllerUserrole extends JSController{

    function __construct() {
        parent :: __construct();
        $this->registerTask('add', 'edit');
    }

    function saverole() {
        $userrole_model = $this->getModel('Userrole', 'JSJobsModel');
        $return_value = $userrole_model->storeRole();
        if ($return_value == 1) {
            $msg = JText::_('ROLE_SAVED');
            $link = 'index.php?option=com_jsjobs&task=view&layout=roles';
            $this->setRedirect($link, $msg);
        } else {
            $msg = JText::_('ERROR_SAVING_ROLE');
            $link = 'index.php?option=com_jsjobs&task=view&layout=roles';
            $this->setRedirect($link, $msg);
        }

        $link = 'index.php?option=com_jsjobs&c=application&layout=roles';
    }

    function saveuserrole() {
        $userrole_model = $this->getModel('Userrole', 'JSJobsModel');
        $return_value = $userrole_model->storeUserRole();
        if ($return_value == 1) {
            $msg = JText::_('ROLE_SAVED');
            $link = 'index.php?option=com_jsjobs&c=userrole&view=userrole&layout=users';
            $this->setRedirect($link, $msg);
        } else {
            $msg = JText::_('ERROR_SAVING_ROLE');
            $link = 'index.php?option=com_jsjobs&c=userrole&view=userrole&layout=users';
            $this->setRedirect($link, $msg);
        }
    }

    function listuserdataforpackage() {
        $val = JRequest::getVar('val');
        $userrole_model = $this->getModel('Userrole', 'JSJobsModel');
        $returnvalue = $userrole_model->listUserDataForPackage($val);
        echo $returnvalue;
        JFactory::getApplication()->close();
    }

    function edit() {
        JRequest::setVar('layout', 'changerole');
        JRequest::setVar('view', 'userrole');
        JRequest::setVar('c', 'userrole');
        $this->display();
    }
    
    function cancel() {
        $msg = JText::_('OPERATION_CANCELLED');
        $this->setRedirect('index.php?option=com_jsjobs&c=userrole&view=userrole&layout=users', $msg);
    }

    function display($cachable = false, $urlparams = false) {
        $document = JFactory :: getDocument();
        $viewName = JRequest :: getVar('view', 'userrole');
        $layoutName = JRequest :: getVar('layout', 'userrole');
        $viewType = $document->getType();
        $view = $this->getView($viewName, $viewType);
        $jobsharing_model = $this->getModel('Jobsharing', 'JSJobsModel');
        $configuration_model = $this->getModel('Configuration', 'JSJobsModel');
        $userrole_model = $this->getModel('Userrole', 'JSJobsModel');
        $user_model = $this->getModel('User', 'JSJobsModel');
        if (!JError :: isError($jobsharing_model) && !JError::isError($configuration_model) && !JError::isError($userrole_model) && !JError::isError($user_model)) {
            $view->setModel($jobsharing_model, true);
            $view->setModel($configuration_model);
            $view->setModel($userrole_model);
            $view->setModel($user_model);
        }
        $view->setLayout($layoutName);
        $view->display();
    }

}

?>