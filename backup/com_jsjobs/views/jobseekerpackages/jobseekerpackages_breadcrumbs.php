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
			case 'package_buynow':
				if ($nav == 21){
					$pathway->addItem(JText::_('JS_PACKAGES'), $commonpath.'&c=jobseekerpackages&view=jobseekerpackages&layout=packages&Itemid='.$itemid);
					$pathway->addItem(JText::_('JS_PACKAGE_BUY_NOW'), '');
				}elseif ($nav == 22){
					$pathway->addItem(JText::_('JS_PACKAGES'), $commonpath.'&c=jobseekerpackages&view=jobseekerpackages&layout=packages&Itemid='.$itemid);
					$pathway->addItem(JText::_('JS_PACKAGE_DETAILS'), $commonpath.'&c=jobseekerpackages&view=jobseekerpackages&layout=package_details&gd='.$package->id.'&Itemid='.$itemid);
					$pathway->addItem(JText::_('JS_PACKAGE_BUY_NOW'), '');
				}
			break;
			case 'package_details':
					$pathway->addItem(JText::_('JS_PACKAGES'), $commonpath.'&c=jobseekerpackages&view=jobseekerpackages&layout=packages&Itemid='.$itemid);
					$pathway->addItem(JText::_('JS_PACKAGE_DETAILS'), '');
			break;
			case 'packages':
					$pathway->addItem(JText::_('JS_PACKAGES'), '');
			break;
		}
	}	



?>
