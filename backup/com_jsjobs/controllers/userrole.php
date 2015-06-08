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

class JSJobsControllerUserRole extends JSController {

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

    function savenewinjsjobs() { //save new in jsjobs
        $session = JFactory::getSession();
        $uid = JRequest::getString('uid', 'none');
        $Itemid = JRequest::getVar('Itemid');
        $data = JRequest :: get('post');
        $usertype = $data['usertype'];
        $userrole = $this->getmodel('Userrole', 'JSJobsModel');
        $return_value = $userrole->storeNewinJSJobs();
        $_SESSION['jsuserrole'] = null;
        $session = JFactory::getSession();
        $session->set('jsjobconfig_dft', '');
        $session->set('jsjobcur_usr', '');

        if ($usertype == 1) { // employer
            $link = 'index.php?option=com_jsjobs&c=jsjobs&view=jobseeker&layout=controlpanel&Itemid=' . $Itemid;
        } elseif ($usertype == 2) {// job seeker
            $link = 'index.php?option=com_jsjobs&c=jsjobs&view=jobseeker&layout=controlpanel&Itemid=' . $Itemid;
        }

        if ($return_value == 1) {
            $msg = JText :: _('JS_SAVE_SETTINGS');
        } else {
            $msg = JText :: _('JS_ERROR_SAVING_SETTING');
        }
        $this->setRedirect(JRoute::_($link), $msg);
    }

    function checkuserdetail() {
        $val = JRequest::getVar('val');
        $for = JRequest::getVar('fr');
        $common = $this->getmodel('Common', 'JSJobsModel');
        $returnvalue = $common->checkUserDetail($val, $for);
        echo $returnvalue;
        JFactory::getApplication()->close();
    }

}

?>
    