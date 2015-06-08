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
			case 'job_apply':
			
				if ($nav == 26){ // list jobs by category
					$pathway->addItem(JText::_('JS_JOB_CATEGORIES'), $commonpath.'&c=category&view=category&layout=jobcat&Itemid='.$itemid);
					$pathway->addItem(JText::_('JS_JOBS_LIST_BY_CATEGORY'), $commonpath.'&c=category&view=category&layout=list_jobs&cat='.$jobresult[0]->jobcategory.'&Itemid='.$itemid);
					$pathway->addItem(JText::_('JS_APPLYNOW'), '');
				}else if ($nav == 28){ // search job result
					$pathway->addItem(JText::_('JS_SEARCH_JOB'), $commonpath.'&c=job&view=job&layout=jobsearch&Itemid='.$itemid);
					$pathway->addItem(JText::_('JS_JOB_SEARCH_RESULT'), $commonpath.'&c=job&view=job&layout=job_searchresults&Itemid='.$itemid);
					$pathway->addItem(JText::_('JS_APPLYNOW'), '');
				}else if ($nav == 25){ // newest jobs
					$pathway->addItem(JText::_('JS_NEWEST_JOBS'), $commonpath.'&c=job&view=job&layout=listnewestjobs&Itemid='.$itemid);
					$pathway->addItem(JText::_('JS_APPLYNOW'), '');
				}else if ($nav == 39){ // company jobs
					$pathway->addItem(JText::_('JS_JOBS'), $commonpath.'&c=company&view=company&layout=company_jobs&cd='. $jobresult[0]->companyid.'&Itemid='.$itemid);
					$pathway->addItem(JText::_('JS_APPLYNOW'), '');
				}else if ($nav == 27){ //list jobs by subcategory
					$pathway->addItem(JText::_('JS_JOB_CATEGORIES'), $commonpath.'&c=job&view=job&layout=list_jobs&cat='.$jobcat.'&Itemid='.$itemid);
					$pathway->addItem(JText::_('JS_JOBS_LIST_BY_CATEGORY'), $commonpath.'&c=category&view=category&layout=jobcat&Itemid='.$itemid);
					$pathway->addItem(JText::_('JS_APPLYNOW'), '');
				}else{
					$pathway->addItem(JText::_('JS_APPLYNOW'), '');
				}
			
			break;
			case 'myappliedjobs':
					$pathway->addItem(JText::_('JS_MY_APPLIED_JOBS'), '');
			break;
			case 'alljobsappliedapplications':
				$pathway->addItem(JText::_('JS_APPLIED_RESUME'), '');
			break;
			case 'job_appliedapplications':
                                $pathway->addItem(JText::_('JS_MY_JOBS'), $commonpath.'&c=job&view=job&layout=myjobs&Itemid='.$itemid);
                                $pathway->addItem(JText::_('JS_JOB_APPLIED_APPLICATIONS'), '');
			break;
			

		}
	}	



?>
