<?php 
/**
 * @Copyright Copyright (C) 2009-2014
 * @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
  + Created by:          Ahmad Bilal
 * Company:     Buruj Solutions
  + Contact:        www.burujsolutions.com , ahmad@burujsolutions.com
 * Created on:  Jan 11, 2009
  ^
  + Project:        JS Jobs
  ^
 * History:     NONE
  ^
 */
defined('_JEXEC') or die('Restricted access');
	$commonpath="index.php?option=com_jsjobs";
	$pathway = $mainframe->getPathway();
	if ($config['cur_location'] == 1) {
		switch($layout){
			case 'mydepartments':
					$pathway->addItem(JText::_('JS_MY_DEPARTMENTS'), '');
			break;
			case 'formdepartment':
				if (isset($result)) {
						$pathway->addItem(JText::_('JS_MY_DEPARTMENTS'), $commonpath.'&c=department&view=department&layout=mydepartments&Itemid='.$itemid);
						$pathway->addItem(JText::_('JS_EDIT_DEPARTMENT_INFO'), '');
				} else {
						$pathway->addItem(JText::_('JS_DEPARTMENT'), '');
				}
			break;
			case 'view_department':
					$pathway->addItem(JText::_('JS_MY_DEPARTMENTS'), $commonpath.'&c=department&view=department&layout=mydepartments&Itemid='.$itemid);
					$pathway->addItem(JText::_('JS_VIEW_DEPARTMENT'), '');
			break;
		}
	}	

?>
