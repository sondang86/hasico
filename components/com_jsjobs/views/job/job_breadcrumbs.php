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
			case 'formjob':
				if($result[0]){ // for edit form job
					$pathway->addItem(JText::_('JS_MY_JOBS'), $commonpath.'&c=job&view=job&layout=myjobs&Itemid='.$itemid);
					$pathway->addItem(JText::_('JS_EDIT_JOB_INFO'), '');
				}else{
					$pathway->addItem(JText::_('JS_NEW_JOB_INFO'), '');
				}
			break;
			case 'formjob_visitor':
				if (isset($result[0])) {
						$pathway->addItem(JText::_('JS_MY_COMPANIES'), $commonpath.'&c=company&view=company&layout=mycompanies&Itemid='.$itemid);
						$pathway->addItem(JText::_('JS_COMPNAY_INFO'), '');
				} else {
						$pathway->addItem(JText::_('JS_NEW_JOB_INFO'), '');
				}
			break;
			case 'myjobs':
				$pathway->addItem(JText::_('JS_MY_JOBS'), '');
			break;
			case 'view_job':
				if ($nav == 19){ //my jobs
					$navcompany = 41;
					$pathway->addItem(JText::_('JS_MY_JOBS'), $commonpath.'&c=job&view=job&layout=myjobs&Itemid='.$itemid);
					$pathway->addItem(JText::_('JS_VIEW_JOB'), '');
				}else if ($nav == 13){ //job cat
					$pathway->addItem(JText::_('JS_JOB_CATEGORIES'), $commonpath.'&c=category&view=category&layout=jobcat&Itemid='.$itemid);
					$pathway->addItem(JText::_('JS_JOBS_LIST_BY_CATEGORY'), $commonpath.'&c=category&view=category&layout=list_jobs&cat='.$job->jobcategory.'&Itemid='.$itemid);
					$pathway->addItem(JText::_('JS_VIEW_JOB'), '');
				}else if ($nav == 14){ //job subcat
					$pathway->addItem(JText::_('JS_JOB_CATEGORIES'), $commonpath.'&c=category&view=category&layout=jobcat&Itemid='.$itemid);
					$pathway->addItem(JText::_('JS_JOBS_LIST_BY_CATEGORY'), $commonpath.'&c=category&view=category&layout=list_jobs&cat='.$catid.'&Itemid='.$itemid);
					$pathway->addItem(JText::_('JS_JOBS_LIST_BY_SUBCATEGORY'), $commonpath.'&c=category&view=category&layout=list_subcategoryjobs&cat='.$catid.'&jobsubcat='.$jobsubcatid.'&Itemid='.$itemid);
					$pathway->addItem(JText::_('JS_VIEW_JOB'), '');
				}else if ($nav == 17){ //job search
					$pathway->addItem(JText::_('JS_SEARCH_JOB'), $commonpath.'&c=job&view=job&layout=jobsearch&Itemid='.$itemid);
					$pathway->addItem(JText::_('JS_JOB_SEARCH_RESULT'), $commonpath.'&c=job&view=job&layout=job_searchresults&Itemid='.$itemid);
					$pathway->addItem(JText::_('JS_VIEW_JOB'), '');
				}else if ($nav == 16){ //my applied jobs
					$pathway->addItem(JText::_('JS_MY_APPLIED_JOBS'), $commonpath.'&c=jobapply&view=jobapply&layout=myappliedjobs&Itemid='.$itemid);
					$pathway->addItem(JText::_('JS_VIEW_JOB'), '');
				}else if ($nav == 15){ //newest jobs
					$pathway->addItem(JText::_('JS_NEWEST_JOBS'), $commonpath.'&c=job&view=job&layout=listnewestjobs&Itemid='.$itemid);
					$pathway->addItem(JText::_('JS_VIEW_JOB'), '');
				}else if ($nav == 20){ //company jobs jobs
					$pathway->addItem(JText::_('JS_NEWEST_JOBS'), $commonpath.'&c=company&view=company&layout=company_jobs&cd='.$result[0]->companyid.'&Itemid='.$itemid);
					$pathway->addItem(JText::_('JS_VIEW_JOB'), '');
				}else{
					$pathway->addItem(JText::_('JS_VIEW_JOB'), '');
				}
			break;
			case 'jobsearch':
					$pathway->addItem(JText::_('JS_SEARCH_JOB'), '');
			break;
			case 'job_searchresults':
					$pathway->addItem(JText::_('JS_SEARCH_JOB'), $commonpath.'&c=job&view=job&layout=jobsearch&Itemid='.$itemid);
					$pathway->addItem(JText::_('JS_JOB_SEARCH_RESULT'), '');
			break;
			case 'list_jobs':
					$pathway->addItem(JText::_('JS_JOB_CATEGORIES'), $commonpath.'&c=category&view=category&layout=jobcat&Itemid='.$itemid);
					$pathway->addItem(JText::_('JS_JOBS_LIST_BY_CATEGORY'), '');
			break;
			case 'listnewestjobs':
					$pathway->addItem(JText::_('JS_NEWEST_JOBS'), '');
			break;

		}
	}	



?>
