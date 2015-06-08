<?php

/**
 * @Copyright Copyright (C) 2009-2011 ... Ahmad Bilal
 * @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * Company:		Buruj Solutions
  + Contact:		www.burujsolutions.com , ahmad@burujsolutions.com
 * Created on:	Jan 11, 2009
  ^
  + Project: 		JS Jobs
 * File Name:	admin/views/application/view.html.php
  ^
 * Description: View class for single record in the admin
  ^
 * History:		NONE
 * 
 */
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');
jimport('joomla.html.pagination');

class JSJobsViewJob extends JSView{

    function display($tpl = null) {
        require_once JPATH_COMPONENT_ADMINISTRATOR . '/views/common.php';
//        layout start
        if ($layoutName == 'formjob') { // jobs  or form job
            if (isset($_GET['cid'][0]))
                $c_id = $_GET['cid'][0];
            else
                $c_id = '';
            if ($c_id == '') {
                $cids = JRequest :: getVar('cid', array(0), 'post', 'array');
                $c_id = $cids[0];
            }
            if (is_numeric($c_id) == true)
                $result = $this->getJSModel('job')->getJobbyId($c_id, $uid);
            $this->assignRef('job', $result[0]);
            $this->assignRef('lists', $result[1]);
            $this->assignRef('userfields', $result[2]);
            $this->assignRef('fieldsordering', $result[3]);
            if (isset($result[4]))
                $this->assignRef('multiselectedit', $result[4]);

            if (isset($result[0]->id))
                $isNew = false;
            $text = $isNew ? JText :: _('ADD') : JText :: _('EDIT');
            JToolBarHelper :: title(JText :: _('JS_JOB') . ': <small><small>[ ' . $text . ' ]</small></small>');

            JToolBarHelper :: save('job.savejob');
            if ($isNew)
                JToolBarHelper :: cancel('job.cancel');
            else
                JToolBarHelper :: cancel('job.cancel', 'Close');
        } elseif ($layoutName == 'job_searchresult') {        //job asearch results
            JToolBarHelper :: title(JText::_('JS_JOB_SEARCHREULTS'));
            JToolBarHelper :: cancel('job.cancel');
            $form = 'com_jsjobs.jobs.list.';            
            $title = $mainframe->getUserStateFromRequest($form . 'title', 'title', '', 'string');
            $jobcategory = $mainframe->getUserStateFromRequest($form . 'jobcategory', 'jobcategory', '', 'string');
            $jobsubcategory = $mainframe->getUserStateFromRequest($form . 'jobsubcategory', 'jobsubcategory', '', 'string');
            $jobtype = $mainframe->getUserStateFromRequest($form . 'jobtype', 'jobtype', '', 'string');
            $jobstatus = $mainframe->getUserStateFromRequest($form . 'jobstatus', 'jobstatus', '', 'string');
            $salaryrangefrom = $mainframe->getUserStateFromRequest($form . 'salaryrangefrom', 'salaryrangefrom', '', 'string');
            $salaryrangeto = $mainframe->getUserStateFromRequest($form . 'salaryrangeto', 'salaryrangeto', '', 'string');
            $salaryrangetype = $mainframe->getUserStateFromRequest($form . 'salaryrangetype', 'salaryrangetype', '', 'string');
            $shift = $mainframe->getUserStateFromRequest($form . 'shift', 'shift', '', 'string');
            $durration = $mainframe->getUserStateFromRequest($form . 'durration', 'durration', '', 'string');
            $startpublishing = $mainframe->getUserStateFromRequest($form . 'startpublishing', 'startpublishing', '', 'string');
            $stoppublishing = $mainframe->getUserStateFromRequest($form . 'stoppublishing', 'stoppublishing', '', 'string');
            $company = $mainframe->getUserStateFromRequest($form . 'jobsearch_company', 'jobsearch_company', '', 'string');
            $city = $mainframe->getUserStateFromRequest($form . 'searchcity', 'searchcity', '', 'string');
            $zipcode = $mainframe->getUserStateFromRequest($form . 'zipcode', 'zipcode', '', 'string');
            $currency = $mainframe->getUserStateFromRequest($form . 'currency', 'currency', '', 'string');
            $longitude = $mainframe->getUserStateFromRequest($form . 'longitude', 'longitude', '', 'string');
            $latitude = $mainframe->getUserStateFromRequest($form . 'latitude', 'latitude', '', 'string');
            $radius = $mainframe->getUserStateFromRequest($form . 'radius', 'radius', '', 'string');
            $radius_length_type = $mainframe->getUserStateFromRequest($form . 'radius_length_type', 'radius_length_type', '', 'string');
            $keywords = $mainframe->getUserStateFromRequest($form . 'keywords', 'keywords', '', 'string');
            $zipcode = $mainframe->getUserStateFromRequest($form . 'zipcode', 'zipcode', '', 'string');
            $result = $this->getJSModel('job')->getJobSearch($title, $jobcategory, $jobsubcategory, $jobtype, $jobstatus, $salaryrangefrom, $salaryrangeto, $salaryrangetype
                    , $shift, $durration, $startpublishing, $stoppublishing
                    , $company, $city, $zipcode, $currency, $longitude, $latitude, $radius, $radius_length_type, $keywords, $limit, $limitstart);
            $items = $result[0];
            $total = $result[1];
            if ($total <= $limitstart)
                $limitstart = 0;
            $pagination = new JPagination($total, $limitstart, $limit);
            $this->assignRef('pagination', $pagination);
            $this->assignRef('listjobconfig', $result[2]);
        }elseif ($layoutName == 'jobqueue') {          // job queue
            JToolBarHelper :: title(JText::_('JS_JOBS_APPROVAL_QUEUE'));
            $form = 'com_jsjobs.jobqueue.list.';
            $searchtitle = $mainframe->getUserStateFromRequest($form . 'searchtitle', 'searchtitle', '', 'string');
            $searchcompany = $mainframe->getUserStateFromRequest($form . 'searchcompany', 'searchcompany', '', 'string');
            $searchjobcategory = $mainframe->getUserStateFromRequest($form . 'searchjobcategory', 'searchjobcategory', '', 'string');
            $searchjobtype = $mainframe->getUserStateFromRequest($form . 'searchjobtype', 'searchjobtype', '', 'string');
            $searchjobstatus = $mainframe->getUserStateFromRequest($form . 'searchjobstatus', 'searchjobstatus', '', 'string');
            $result = $this->getJSModel('job')->getAllUnapprovedJobs($searchtitle, $searchcompany, $searchjobcategory, $searchjobtype, $searchjobstatus, $limitstart, $limit);
            $items = $result[0];
            $total = $result[1];
            $lists = $result[2];
            if ($total <= $limitstart)
                $limitstart = 0;
            $pagination = new JPagination($total, $limitstart, $limit);
            $this->assignRef('pagination', $pagination);
            $this->assignRef('lists', $lists);
        }elseif ($layoutName == 'jobs') {        //jobs
            JToolBarHelper :: title(JText::_('JS_JOBS'));
            JToolBarHelper :: addNew('job.add');
            JToolBarHelper :: editList('job.edit');
            JToolBarHelper :: deleteList(JText::_('JS_ARE_YOU_SURE'),'job.remove');
            JToolBarHelper :: cancel('job.cancel');
            $form = 'com_jsjobs.jobs.list.';
            $searchtitle = $mainframe->getUserStateFromRequest($form . 'searchtitle', 'searchtitle', '', 'string');
            $searchcompany = $mainframe->getUserStateFromRequest($form . 'searchcompany', 'searchcompany', '', 'string');
            $searchjobcategory = $mainframe->getUserStateFromRequest($form . 'searchjobcategory', 'searchjobcategory', '', 'string');
            $searchjobtype = $mainframe->getUserStateFromRequest($form . 'searchjobtype', 'searchjobtype', '', 'string');
            $searchjobstatus = $mainframe->getUserStateFromRequest($form . 'searchjobstatus', 'searchjobstatus', '', 'string');
            $result = $this->getJSModel('job')->getAllJobs($searchtitle, $searchcompany, $searchjobcategory, $searchjobtype, $limitstart, $limit);
            $items = $result[0];
            $total = $result[1];
            $lists = $result[2];
            if ($total <= $limitstart)
                $limitstart = 0;
            $pagination = new JPagination($total, $limitstart, $limit);
            $this->assignRef('pagination', $pagination);
            $this->assignRef('lists', $lists);
        }elseif ($layoutName == 'jobsearch') {        //job search
            JToolBarHelper :: title(JText::_('JS_JOB_SEARCH'));
            $result = $this->getJSModel('job')->getSearchOptions();
            $this->assignRef('searchoptions', $result[0]);
            $this->assignRef('searchjobconfig', $result[1]);
        } elseif ($layoutName == 'view_job') {        //view job
            JToolBarHelper :: title(JText::_('JS_JOB_DETAILS'));
            JToolBarHelper :: cancel('job.cancel');
            $jobid = $_GET['oi'];
            $result = $this->getJSModel('job')->getJobbyIdForView($jobid);
            $this->assignRef('job', $result[0]);
            $this->assignRef('userfields', $result[2]);
            $this->assignRef('fieldsordering', $result[3]);
        }
//        layout end

        $this->assignRef('config', $config);
        $this->assignRef('application', $application);
        $this->assignRef('items', $items);
        $this->assignRef('theme', $theme);
        $this->assignRef('option', $option);
        $this->assignRef('uid', $uid);
        $this->assignRef('msg', $msg);
        $this->assignRef('isjobsharing', $_client_auth_key);

        parent :: display($tpl);
    }

}

?>
