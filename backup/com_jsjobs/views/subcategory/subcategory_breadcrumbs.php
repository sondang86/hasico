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
			case 'list_subcategoryjobs':
					$pathway->addItem(JText::_('JS_JOB_CATEGORIES'), $commonpath.'&c=category&view=category&layout=jobcat&Itemid='.$itemid);
					$pathway->addItem(JText::_('JS_JOBS_LIST_BY_CATEGORY'), $commonpath.'&c=job&view=job&layout=list_jobs&cat='.$jobs[0]->cat_id.'&Itemid='.$itemid);
					$pathway->addItem(JText::_('JS_SUB_CATEGORY'), '');
			break;
		}
	}	

?>
