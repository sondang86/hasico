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
 * File Name:	views/employer/view.html.php
  ^
 * Description: HTML view class for employer
  ^
 * History:		NONE
  ^
 */
defined('_JEXEC') or die('Restricted access');
global $_client_auth_key;
$_M_configuration = $this->getModel('configuration');
$_M_jobsharing = $this->getModel('jobsharing');
$msg = JRequest :: getVar('msg');
$option = 'com_jsjobs';
$mainframe = JFactory::getApplication();

if ($_client_auth_key == "") {
    $_client_auth_key = $_M_jobsharing->getClientAuthenticationKey();
}

$layoutName = JRequest :: getVar('layout', '');
if ($layoutName == '')
    $layoutName = $this->getLayout();
$limit = $mainframe->getUserStateFromRequest('global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
$limitstart = JREQUEST::getVar('limitstart', 0, 'int');
$isNew = true;
$user = JFactory::getUser();
$uid = $user->id;
// get configurations
$config = Array();
if ($_M_configuration->isTestMode()) {
    $config = null;
} else {
    if (isset($_SESSION['jsjobconfig']))
        $config = $_SESSION['jsjobconfig'];
    else
        $config = null;
}
if (sizeof($config) == 0) {
    $results = $_M_configuration->getConfig();
    foreach ($results as $result) {
        $config[$result->configname] = $result->configvalue;
    }
    $_SESSION['jsjobconfig'] = $config;
}

$theme['title'] = 'jppagetitle';
$theme['heading'] = 'pageheadline';
$theme['sectionheading'] = 'sectionheadline';
$theme['sortlinks'] = 'sortlnks';
$theme['odd'] = 'odd';
$theme['even'] = 'even';
?>