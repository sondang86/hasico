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
			case 'formcompany':
				if($result[0]){ // for edit form company
					//$pathway->addItem(JText::_('JS_EMPLOYER_C_P'), $commonpath.'&view=employer&layout=controlpanel&Itemid='.$itemid);
					$pathway->addItem(JText::_('JS_MY_COMPANIES'), $commonpath.'&c=company&view=company&layout=mycompanies&Itemid='.$itemid);
					$pathway->addItem(JText::_('JS_COMPNAY_INFO'), '');
				}else{
					$pathway->addItem(JText::_('JS_NEW_COMPANY'), '');
				}
			break;
			case 'mycompanies':
					$pathway->addItem(JText::_('JS_MY_COMPANIES'), '');
			break;
			case 'company_jobs':
				if (!empty($jobs) && $jobs[0]->companyname != '') $ptitle = $jobs[0]->companyname; 
					if(isset($ptitle)) $ptitle =  $ptitle.' '.JText::_('JS_JOBS');
					else $ptitle=JText::_('JS_JOBS');
				$pathway->addItem($ptitle, '');
			break;
			case 'view_company':
				if ($nav == 31){ //my companies
					$pathway->addItem(JText::_('JS_MY_COMPANIES'), $commonpath.'&c=company&view=company&layout=mycompanies&Itemid='.$itemid);
					$pathway->addItem(JText::_('JS_COMPNAY_INFO'), '');
				}elseif ($nav == 32){ //list jobs
					$pathway->addItem(JText::_('JS_JOB_CATEGORIES'), $commonpath.'&c=category&view=category&layout=jobcat&Itemid='.$itemid);
					$pathway->addItem(JText::_('JS_JOBS_LIST_BY_CATEGORY'), $commonpath.'&c=category&view=category&layout=list_jobs&cn=&cat='.$jobcat.'&Itemid='.$itemid);
					$pathway->addItem(JText::_('JS_COMPNAY_INFO'), '');
				}elseif ($nav == 33){ //job search
					$pathway->addItem(JText::_('JS_SEARCH_JOB'), $commonpath.'&c=job&view=job&layout=jobsearch&Itemid='.$itemid);
					$pathway->addItem(JText::_('JS_JOB_SEARCH_RESULT'), $commonpath.'&c=job&view=job&layout=job_searchresults='.$itemid);
					$pathway->addItem(JText::_('JS_COMPNAY_INFO'), '');
				}else if ($nav == 34){ //my applied jobs
					$pathway->addItem(JText::_('JS_MY_APPLIED_JOBS'), $commonpath.'&c=jobapply&view=jobapply&layout=myappliedjobs&Itemid='.$itemid);
					$pathway->addItem(JText::_('JS_COMPNAY_INFO'), '');
				}else if ($nav == 35){ //newest jobs
					$pathway->addItem(JText::_('JS_NEWEST_JOBS'), $commonpath.'&c=job&view=job&layout=listnewestjobs&Itemid='.$itemid);
					$pathway->addItem(JText::_('JS_COMPNAY_INFO'), '');
				}else if ($nav == 36){  //jsmessages jobseeker
					$pathway->addItem(JText::_('JS_MESSAGES'), $commonpath.'&c=message&view=message&layout=jsmessages&Itemid='.$itemid);
					$pathway->addItem(JText::_('JS_COMPNAY_INFO'), '');
				}else if ($nav == 37){  //empmessages employer
					$pathway->addItem(JText::_('JS_MESSAGES'), $commonpath.'&c=message&view=message&layout=empmessages&Itemid='.$itemid);
					$pathway->addItem(JText::_('JS_COMPNAY_INFO'), '');
				}else if ($nav == 38){  //COMPANY JOBS
					$pathway->addItem(JText::_('JS_MESSAGES'), $commonpath.'&c=company&view=company&layout=company_jobs&cd='.$company->aliasid.'&Itemid='.$itemid);
					$pathway->addItem(JText::_('JS_COMPNAY_INFO'), '');

				}else if ($nav == 41){  //My JOBS
					$pathway->addItem(JText::_('JS_MY_JOBS'), $commonpath.'&c=job&view=job&layout=myjobs&Itemid&Itemid='.$itemid);
					$pathway->addItem(JText::_('JS_COMPNAY_INFO'), '');
				}else{
					$pathway->addItem(JText::_('JS_COMPNAY_INFO'), '');
				}
			break;

		}
	}	



?>
