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

class JSJobsControllerCoverLetter extends JSController {

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

    function savecoverletter() { //save cover letter
        $jobsharing = $this->getModel('jobsharingsite', 'JSJobsModel');
        $uid = JRequest::getString('uid', 'none');
        $Itemid = JRequest::getVar('Itemid');
        $coverletter = $this->getmodel('Coverletter', 'JSJobsModel');
        $return_value = $coverletter->storeCoverLetter();

        if ($return_value == 1) {
            $msg = JText :: _('JS_COVER_LETTER_SAVED');
            $link = 'index.php?option=com_jsjobs&c=coverletter&view=coverletter&layout=mycoverletters&Itemid=' . $Itemid;
        } else if ($return_value == 2) {
            $msg = JText :: _('JS_FILL_REQ_FIELDS');
            $link = 'index.php?option=com_jsjobs&c=coverletter&view=coverletter&layout=formcoverletter&Itemid=' . $Itemid;
        } else {
            $msg = JText :: _('JS_ERROR_SAVING_COVER_LETTER');
            $link = 'index.php?option=com_jsjobs&c=coverletter&view=coverletter&layout=formcoverletter&Itemid=' . $Itemid;
        }
        $this->setRedirect($link, $msg);
    }

    function deletecoverletter() { //delete cover letter
        $user = JFactory::getUser();
        $uid = $user->id;
        $Itemid = JRequest::getVar('Itemid');
        $id = JRequest::getVar('cl', '');
        $common = $this->getmodel('Common', 'JSJobsModel');
        $coverletterid = $common->parseId($id);
        $coverletter = $this->getmodel('Coverletter', 'JSJobsModel');
        $return_value = $coverletter->deleteCoverLetter($coverletterid, $uid);
        $jobsharing = $this->getModel('jobsharingsite', 'JSJobsModel');
        if ($return_value == 1) {
            $msg = JText :: _('JS_COVER_LETTER_DELETED');
        } elseif ($return_value == 2) {
            $msg = JText :: _('JS_NOT_YOUR_COVER_LETTER');
        } else {
            $msg = JText :: _('JS_ERROR_DELETEING_COVER_LETTER');
        }
        $link = 'index.php?option=com_jsjobs&c=coverletter&view=coverletter&layout=mycoverletters&Itemid=' . $Itemid;
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
    