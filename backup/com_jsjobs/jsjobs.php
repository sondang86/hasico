<?php

/**
 * @Copyright Copyright (C) 2009-2011
 * @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
  + Created by:          Ahmad Bilal
 * Company:		Buruj Solutions
  + Contact:		www.burujsolutions.com , ahmad@burujsolutions.com
 * Created on:	Jan 11, 2009
  ^
  + Project: 		Job Posting and Employment Application
 * File Name:	controllers/application.php
  ^
 * Description: Entry point for the component (jobsnapps)
  ^
 * History:		NONE
  ^
 * @package com_jsjobs
  ^
 * You should have received a copy of the GNU General Public License along with this program;
  ^
 * 
 * */
defined('_JEXEC') or die('Restricted access');


// requires the default controller 
require_once (JPATH_COMPONENT . '/JSApplication.php');
require_once (JPATH_COMPONENT . '/controller.php');
/*
  Checking if a controller was set, if so let's included it
 */
$task = JRequest :: getCmd('task');
$c = '';
if (strstr($task, '.')) {
    $array = explode('.', $task);
    $c = $array[0];
    $task = $array[1];
} else {
    $c = JRequest :: getCmd('c', 'jsjobs');
    $task = JRequest :: getCmd('task', 'display');
}

if ($c != '') {
    $path = JPATH_COMPONENT . '/controllers/' . $c . '.php';
    jimport('joomla.filesystem.file');

    if (JFile :: exists($path)) {
        require_once ($path);
    } else {
        JError :: raiseError('500', JText :: _('Unknown controller: <br>' . $c . ':' . $path));
    }
}
$controllername = 'JSJobsController' . $c;
$controller = new $controllername();
$controller->execute($task);
$controller->redirect();
?>
