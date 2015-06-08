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
			case 'formresume':
				if ($nav == 29) { //my resume 
					$pathway->addItem(JText::_('JS_MY_RESUME'), $commonpath.'&c=resume&view=resume&layout=myresumes&Itemid='.$itemid);
					$pathway->addItem(JText::_('JS_RESUME_FORM'), '');
				} else {
					$pathway->addItem(JText::_('JS_RESUME_FORM'), '');
				}
			break;
			case 'resumesearch':
					$pathway->addItem(JText::_('JS_SEARCH_RESUME'), '');
			break;
			case 'myresumes':
					$pathway->addItem(JText::_('JS_MY_RESUME'), '');
			break;
			case 'my_resumesearches':
					$pathway->addItem(JText::_('JS_RESUME_SAVE_SEARCHES'), '');
			break;
			case 'resumebycategory':
					$pathway->addItem(JText::_('JS_RESUME_BY_CATEGORY'), '');
			break;
			case 'resume_bycategory':
					$pathway->addItem(JText::_('JS_RESUME_BY_CATEGORY'), $commonpath.'&c=resume&view=resume&layout=resumebycategory&Itemid='.$itemid);
					$pathway->addItem(JText::_('JS_RESUME_BY_CATEGORY'), '');
			break;
			case 'resume_bysubcategory':
					$pathway->addItem(JText::_('JS_RESUME_BY_CATEGORY'), $commonpath.'&c=resume&view=resume&layout=resumebycategory&Itemid='.$itemid);
					$pathway->addItem(JText::_('JS_SUB_CATEGORY'), '');
			break;
			case 'resume_searchresults':
					$pathway->addItem(JText::_('JS_SEARCH_RESUME'), $commonpath.'&c=resume&view=resume&layout=resumesearch&Itemid='.$itemid);
					$pathway->addItem(JText::_('JS_RESUME_SEARCH_RESULT'), '');
			break;
			case 'view_resume':
				if ($nav == 1){ //my resume 
					$pathway->addItem(JText::_('JS_MY_RESUME'), $commonpath.'&c=resume&view=resume&layout=myresumes&Itemid='.$itemid);
					$pathway->addItem(JText::_('JS_VIEW_RESUME'), '');
				}elseif ($nav == 2){ //view resume
                                        $pathway->addItem(JText::_('JS_MY_JOBS'), $commonpath.'&c=job&view=job&layout=myjobs&Itemid='.$itemid);
					$pathway->addItem(JText::_('JS_JOB_APPLIED_APPLICATIONS'), $commonpath.'&c=jobapply&view=jobapply&layout=job_appliedapplications&bd='.$jobaliasid.'&Itemid='.$itemid);
					$pathway->addItem(JText::_('JS_VIEW_EMP_APP'), '');
				}elseif ($nav == 3){ //search resume
					$pathway->addItem(JText::_('JS_SEARCH_RESUME'), $commonpath.'&c=resume&view=resume&layout=resumesearch&Itemid='.$itemid);
					$pathway->addItem(JText::_('JS_RESUME_SEARCH_RESULT'), $commonpath.'&c=resume&view=resume&layout=resume_searchresults&Itemid='.$itemid);
					$pathway->addItem(JText::_('JS_VIEW_RESUME'), '');
				}elseif ($nav == 7){ //folder resume
					$pathway->addItem(JText::_('JS_MY_FOLDERS'), $commonpath.'&c=folder&view=folder&layout=myfolders&Itemid='.$itemid);
					$pathway->addItem(JText::_('JS_VIEW_FOLDER_RESUME'), $commonpath.'&c=folder&view=folder&layout=folder_resumes&fd='.$folderid.'&Itemid='.$itemid);
					$pathway->addItem(JText::_('JS_VIEW_RESUME'), '');
				}elseif ($nav == 4){ //resume by category 
					$pathway->addItem(JText::_('JS_RESUME_BY_CATEGORY'), $commonpath.'&c=resume&view=resume&layout=resumebycategory&Itemid='.$itemid);
					$pathway->addItem(JText::_('JS_RESUME_BY_CATEGORY'), $commonpath.'&c=resume&view=resume&layout=resume_bycategory&cat='.$catid.'&Itemid='.$itemid);
					$pathway->addItem(JText::_('JS_VIEW_RESUME'), '');
				}elseif ($nav == 5){ //resume by category 
					$pathway->addItem(JText::_('JS_RESUME_BY_CATEGORY'), $commonpath.'&c=resume&view=resume&layout=resumebycategory&Itemid='.$itemid);
					$pathway->addItem(JText::_('JS_RESUME_BY_CATEGORY'), $commonpath.'&c=resume&view=resume&layout=resume_bycategory&cat='.$catid.'&Itemid='.$itemid);
					$pathway->addItem(JText::_('JS_VIEW_RESUME'), '');
				}elseif ($nav == 6){ //resume rss
					$pathway->addItem(JText::_('JS_VIEW_RESUME'), '');
				}
			break;
			case 'viewresumesearch':
			break;
		}
	}	

?>
