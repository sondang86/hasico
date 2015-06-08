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
			case 'formcoverletter':
                            if(isset($result[0])){
                		$pathway->addItem(JText::_('JS_MY_COVER_LETTERS'), $commonpath.'&c=coverletter&view=coverletter&layout=mycoverletters&Itemid='.$itemid);
                            }
                            $pathway->addItem(JText::_('JS_COVER_LETTER_FORM'), '');
			break;
			case 'mycoverletters':
					$pathway->addItem(JText::_('JS_MY_COVER_LETTERS'), '');
			break;
			case 'view_coverletter':
				if ($nav == 8){ //my cover letters 
						$pathway->addItem(JText::_('JS_MY_COVER_LETTERS'), $commonpath.'&c=coverletter&view=coverletter&layout=mycoverletters&Itemid='.$itemid);
						$pathway->addItem(JText::_('JS_VIEW_COVER_LETTER'), '');
 				}elseif ($nav == 10){ //view cover letters - search
                                                $pathway->addItem(JText::_('JS_MY_JOBS'), $commonpath.'&c=job&view=job&layout=myjobs&Itemid='.$itemid);
						//$pathway->addItem(JText::_('JS_APPLIED_RESUME'), $commonpath.'&c=jobapply&view=jobapply&layout=alljobsappliedapplications&Itemid='.$itemid); b/c layout deleted
						$pathway->addItem(JText::_('JS_JOB_APPLIED_APPLICATIONS'), $commonpath.'&c=jobapply&view=jobapply&layout=job_appliedapplications&bd='.$jobaliasid.'&Itemid='.$itemid);
						$pathway->addItem(JText::_('JS_VIEW_RESUME'), $commonpath.'&c=resume&view=resume&layout=view_resume&nav=2&rd='.$resumealiasid.'&bd='.$jobaliasid.'&Itemid='.$itemid);
						$pathway->addItem(JText::_('JS_VIEW_COVER_LETTER'), '');
 				}elseif ($nav == 40){ //view cover letters - search
						$pathway->addItem(JText::_('JS_SEARCH_RESUME'), $commonpath.'&c=resume&view=resume&layout=resumesearch&Itemid='.$itemid);
						$pathway->addItem(JText::_('JS_RESUME_SEARCH_RESULT'), $commonpath.'&c=resume&view=resume&layout=resume_searchresults&Itemid='.$itemid);
						$pathway->addItem(JText::_('JS_VIEW_COVER_LETTER'), '');
 				}
			break;
		}
	}	

?>
