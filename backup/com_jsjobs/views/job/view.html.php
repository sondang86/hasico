<?php

/**
 * @Copyright Copyright (C) 2009-2011
 * @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
  + Created by:          Ahmad Bilal
 * Company:		Buruj Solutions
  + Contact:		www.burujsolutions.com , ahmad@burujsolutions.com
 * Created on:	Jan 11, 2009
  ^
  + Project: 		JS Jobs
 * File Name:	views/employer/view.html.php
  ^
 * Description: HTML view class for employer
  ^
 * History:		NONE
  ^
 */
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');
jimport('joomla.html.pagination');

class JSJobsViewJob extends JSView {

    function display($tpl = null) {
        require_once(JPATH_COMPONENT . '/views/common.php');
        $viewtype = 'html';

        if ($layout == 'formjob') {            // form job
            $page_title .= ' - ' . JText::_('JS_JOB_INFO');
            $jobid = $this->getJSModel('common')->parseId(JRequest::getVar('bd', ''));
            $result = $this->getJSModel('job')->getJobforForm($jobid, $uid, '', '');
            if (is_array($result)) {
                $this->assignRef('job', $result[0]);
                $this->assignRef('lists', $result[1]);
                $this->assignRef('userfields', $result[2]);
                $this->assignRef('fieldsordering', $result[3]);
                $this->assignRef('canaddnewjob', $result[4]);
                $this->assignRef('packagedetail', $result[5]);
                $this->assignRef('packagecombo', $result[6]);
                $this->assignRef('isuserhascompany', $result[7]);
                if (isset($result[8]))
                    $this->assignRef('multiselectedit', $result[8]);
                JHTML::_('behavior.formvalidation');
            }elseif ($result == 3) {
				$validate = $this->getJSModel('permissions')->checkPermissionsFor("ADD_JOB"); // can add
                $this->assignRef('canaddnewjob', $validate);
                $this->assignRef('isuserhascompany', $result);
            }
        } elseif ($layout == 'formjob_visitor') {
            if (isset($_GET['email']))
                $companyemail = $_GET['email'];
            $companyemail = JRequest::getVar('email', '');
            if (!isset($companyemail))
                $companyemail = '';

            $vis_jobid = $this->getJSModel('common')->parseId(JRequest::getVar('bd', ''));
            if (!isset($vis_jobid))
                $vis_jobid = '';
            $result = $this->getJSModel('company')->getCompanybyIdforForm('', $uid, 1, $companyemail, $vis_jobid);
            $this->assignRef('company', $result[0]);
            $this->assignRef('companylists', $result[1]);
            $this->assignRef('companyuserfields', $result[2]);
            $this->assignRef('companyfieldsordering', $result[3]);
            $this->assignRef('canaddnewcompany', $result[4]);
            $this->assignRef('companypackagedetail', $result[5]);
            if (isset($result[6]))
                $this->assignRef('vmultiselecteditcompany', $result[6]);
            $result = $this->getJSModel('job')->getJobforForm('', $uid, $vis_jobid, 1);
            $this->assignRef('job', $result[0]);
            $this->assignRef('lists', $result[1]);
            $this->assignRef('userfields', $result[2]);
            $this->assignRef('fieldsordering', $result[3]);
            $this->assignRef('canaddnewjob', $result[4]);
            $this->assignRef('packagedetail', $result[5]);
            $this->assignRef('packagedetail', $result[5]);
            if (isset($result[8]))
                $this->assignRef('vmultiselecteditjob', $result[8]);
            JHTML::_('behavior.formvalidation');
            $result1 = $this->getJSModel('common')->getCaptchaForForm();
            $this->assignRef('captcha', $result1);
        }elseif ($layout == 'myjobs') {        // my jobs
            $page_title .= ' - ' . JText::_('JS_MY_JOBS');
            $myjobs_allowed = $this->getJSModel('permissions')->checkPermissionsFor("MY_JOB");
            if($myjobs_allowed == VALIDATE){
                $sort = JRequest::getVar('sortby', '');
                //visitor jobid
                $vis_email = JRequest::getVar('email', '');
                $jobid = $this->getJSModel('common')->parseId(JRequest::getVar('bd', ''));
                if (isset($sort)) {
                    if ($sort == '')
                        $sort = 'createddesc';
                } else {
                    $sort = 'createddesc';
                }
                $sortby = $this->getJobListOrdering($sort);
                $result = $this->getJSModel('job')->getMyJobs($uid, $sortby, $limit, $limitstart, $vis_email, $jobid);

                $sortlinks = $this->getJobListSorting($sort);
                $sortlinks['sorton'] = $sorton;
                $sortlinks['sortorder'] = $sortorder;
                $this->assignRef('jobs', $result[0]);
                $this->assignRef('listjobconfig', $result[2]);
                if (isset($result[1])) {
                    if ($result[1] <= $limitstart)
                        $limitstart = 0;
                    $pagination = new JPagination($result[1], $limitstart, $limit);
                    $this->assignRef('pagination', $pagination);
                }
                $this->assignRef('sortlinks', $sortlinks);
            }
            $this->assignRef('myjobs_allowed',$myjobs_allowed);
        }elseif ($layout == 'view_job') {                // view job
            $jobid = $this->getJSModel('common')->parseId(JRequest::getVar('bd', ''));
            $result = $this->getJSModel('job')->getJobbyId($jobid);
            $job = $result[0];
            $job_title = $job->title;
            $job_description = $job->description;
            $document->setMetaData('title', $job_title,true);
            $document->setDescription( $job_description);
            $this->assignRef('job', $result[0]);
            $this->assignRef('userfields', $result[2]);
            $this->assignRef('fieldsordering', $result[3]);
            $this->assignRef('listjobconfig', $result[4]);
            $nav = JRequest::getVar('nav', '');
            $this->assignRef('nav', $nav);
            $catid = JRequest::getVar('cat', '');
            $this->assignRef('catid', $catid);
            $jobsubcatid = JRequest::getVar('jobsubcat', '');
            $this->assignRef('jobsubcatid', $jobsubcatid);
            if (isset($job)) {
                $page_title .= ' - ' . $job->title;
                $document->setDescription($job->metadescription);
                $document->setMetadata('keywords', $job->metakeywords);
            }
        } elseif ($layout == 'jobsearch') { // job search 
            $page_title .= ' - ' . JText::_('JS_SEARCH_JOB');
            $myjobsearch_allowed = $this->getJSModel('permissions')->checkPermissionsFor("JOB_SEARCH");
            if($myjobsearch_allowed == VALIDATE){
                $result = $this->getJSModel('jobsearch')->getSearchOptions($uid);
                $this->assignRef('searchoptions', $result[0]);
                $this->assignRef('searchjobconfig', $result[1]);
                $this->assignRef('canview', $result[2]);
            }
            $this->assignRef('myjobsearch_allowed', $myjobsearch_allowed);
        } elseif ($layout == 'job_searchresults') {                // job search results
        
            //Get job category SonDang 26/05/2015
            $job_options = $this->getJSModel('jobsearch')->getSearchOptions($uid);
            $this->assign('job_options', $job_options);            
            //-------------------------//
            
            
            $page_title .= ' - ' . JText::_('JS_JOB_SEARCH_RESULT');
            $sort = JRequest::getVar('sortby', '');
            if (isset($sort)) {
                if ($sort == '')
                    $sort = 'createddesc';
            } else {
                $sort = 'createddesc';
            }
            $sortby = $this->getJobListOrdering($sort);
            $title = $mainframe->getUserStateFromRequest($option.'title','title','','string');
            $jobcategory = $mainframe->getUserStateFromRequest($option.'jobcategory','jobcategory','','string');
            $jobsubcategory = $mainframe->getUserStateFromRequest($option.'jobsubcategory','jobsubcategory','','string');
            $jobtype = $mainframe->getUserStateFromRequest($option.'jobtype','jobtype','','string');
            $jobstatus = $mainframe->getUserStateFromRequest($option.'jobstatus','jobstatus','','string');
            $salaryrangefrom = $mainframe->getUserStateFromRequest($option.'salaryrangefrom','salaryrangefrom','','string');
            $salaryrangeto = $mainframe->getUserStateFromRequest($option.'salaryrangeto','salaryrangeto','','string');
            $salaryrangetype = $mainframe->getUserStateFromRequest($option.'salaryrangetype','salaryrangetype','','string');
            $education = $mainframe->getUserStateFromRequest($option.'education','education','','string');
            $heighestfinisheducation = $mainframe->getUserStateFromRequest($option.'heighestfinisheducation','heighestfinisheducation','','string');
            $shift = $mainframe->getUserStateFromRequest($option.'shift','shift','','string');
            $experience = $mainframe->getUserStateFromRequest($option.'experience','experience','','string');
            $durration = $mainframe->getUserStateFromRequest($option.'durration','durration','','string');
            $startpublishing = $mainframe->getUserStateFromRequest($option.'startpublishing','startpublishing','','string');
            $stoppublishing = $mainframe->getUserStateFromRequest($option.'stoppublishing','stoppublishing','','string');
            $company = $mainframe->getUserStateFromRequest($option.'company','company','','string');
            $city = $mainframe->getUserStateFromRequest($option.'searchcity','searchcity','','string');
            $zipcode = $mainframe->getUserStateFromRequest($option.'zipcode','zipcode','','string');
            $currency = $mainframe->getUserStateFromRequest($option.'currency','currency','','string');
            $longitude = $mainframe->getUserStateFromRequest($option.'longitude','longitude','','string');
            $latitude = $mainframe->getUserStateFromRequest($option.'latitude','latitude','','string');
            $radius = $mainframe->getUserStateFromRequest($option.'radius','radius','','string');
            $radius_length_type = $mainframe->getUserStateFromRequest($option.'radius_length_type','radius_length_type','','string');
            $keywords = $mainframe->getUserStateFromRequest($option.'keywords','keywords','','string');

            $result = $this->getJSModel('job')->getJobSearch($uid, $title, $jobcategory, $jobsubcategory, $jobtype, $jobstatus, $currency, $salaryrangefrom, $salaryrangeto, $salaryrangetype, $shift, $experience, $durration, $startpublishing, $stoppublishing, $company, $city, $zipcode, $longitude, $latitude, $radius, $radius_length_type, $keywords, $sortby, $limit, $limitstart);
            $options = $this->get('Options');
            $sortlinks = $this->getJobListSorting($sort);
            $sortlinks['sorton'] = $sorton;
            $sortlinks['sortorder'] = $sortorder;
            $application = $result[0];
            if ($result[1] <= $limitstart)
                $limitstart = 0;
            $pagination = new JPagination($result[1], $limitstart, $limit);
            $this->assignRef('application', $application);
            $this->assignRef('pagination', $pagination);
            $this->assignRef('listjobconfig', $result[2]);
            $this->assignRef('searchjobconfig', $result[3]);
            $this->assignRef('canview', $result[4]);
            $this->assignRef('sortlinks', $sortlinks);
        }elseif ($layout == 'list_jobs') {            // list jobs
            $catid = '';
            $sort = JRequest::getVar('sortby', '');
            if (isset($sort)) {
                if ($sort == '') {
                    $sort = 'createddesc';
                }
            } else {
                $sort = 'createddesc';
            }
            $sortby = $this->getJobListOrdering($sort);
            $cmbfiltercountry = $mainframe->getUserStateFromRequest($option . 'cmbfilter_country', 'cmbfilter_country', '', 'string');
            $city_filter = $mainframe->getUserStateFromRequest($option . 'txtfilter_city', 'txtfilter_city', '', 'string');
            $txtfilterlongitude = $mainframe->getUserStateFromRequest($option . 'filter_longitude', 'filter_longitude', '', 'string');
            $txtfilterlatitude = $mainframe->getUserStateFromRequest($option . 'filter_latitude', 'filter_latitude', '', 'string');
            $txtfilterradius = $mainframe->getUserStateFromRequest($option . 'filter_radius', 'filter_radius', '', 'string');
            if ($txtfilterlongitude == JText::_('JS_LONGITUDE'))
                $txtfilterlongitude = '';
            if ($txtfilterlatitude == JText::_('JS_LATITTUDE'))
                $txtfilterlatitude = '';
            if ($txtfilterradius == JText::_('JS_COORDINATES_RADIUS'))
                $txtfilterradius = '';

            $filterjobtype = $mainframe->getUserStateFromRequest($option . 'filter_jobtype', 'filter_jobtype', '', 'string');
            $cmbfilterradiustype = '';
            if (isset($_POST['filter_jobcategory']))
                $filterjobcategory = $_POST['filter_jobcategory'];
            else
                $filterjobcategory = '';
            if (isset($_POST['filter_jobsubcategory']))
                $filterjobsubcategory = $_POST['filter_jobsubcategory'];
            else
                $filterjobsubcategory = '';

            if ($_client_auth_key == "") {
                if ($filterjobcategory)
                    $catid = $filterjobcategory;
            }

            $cat_id = $this->getJSModel('common')->parseId(JRequest::getVar('cat', ''));
            if ($catid == 0)
                $catid = $cat_id;
            $result = $this->getJSModel('job')->getJobsbyCategory($uid, $catid, $city_filter, $cmbfiltercountry
                    , $filterjobcategory, $filterjobsubcategory, $filterjobtype
                    , $txtfilterlongitude, $txtfilterlatitude, $txtfilterradius, $cmbfilterradiustype
                    , $sortby, $limit, $limitstart);

            if (isset($result[0]))
                $jobs = $result[0];
            else
                $jobs = false;
            $filterlists = $result[2];
            $filtervalues = $result[3];
            $sortlinks = $this->getJobListSorting($sort);
            $sortlinks['sorton'] = $sorton;
            $sortlinks['sortorder'] = $sortorder;
            if ($result[1] <= $limitstart)
                $limitstart = 0;
            $pagination = new JPagination($result[1], $limitstart, $limit);

            $this->assignRef('pagination', $pagination);
            $this->assignRef('jobs', $jobs);
            $this->assignRef('category', $result[6]);
            $this->assignRef('filterlists', $filterlists);
            $this->assignRef('filtervalues', $filtervalues);
            $this->assignRef('listjobconfig', $result[4]);
            $this->assignRef('subcategories', $result[5]);
            $this->assignRef('sortlinks', $sortlinks);
            $this->assignRef('categoryid', $catid);
            $this->assignRef('companyid', $companyid);
            $this->assignRef('filterid', $filterid);
            $cm = JRequest::getVar('cm', '');
            $this->assignRef('cm', $cm);
            if ($jobs) {
                $page_title .= ' - ' . $jobs[0]->cat_title;
            }
            // Check where use list for fr 
            $listfor = 1;
            $this->assignRef('listfor', $listfor);
        } elseif ($layout == 'listnewestjobs') {            // list newest job
            $page_title .= ' - ' . JText::_('JS_NEWEST_JOBS');
            $listtype = JRequest::getVar('lt'); // for list job by address
            $jobcountry = JRequest::getVar('country', '');
            $jobstate = JRequest::getVar('state', '');
            if ($listtype == 1) {
                $jobcity = JRequest::getVar('city', '');
                $mainframe->setUserState($option . 'txtfilter_city', $jobcity);
            }

            $cmbfiltercountry = $mainframe->getUserStateFromRequest($option . 'cmbfilter_country', 'cmbfilter_country', '', 'string');
            $cmbfilterradiustype = $mainframe->getUserStateFromRequest($option . 'filter_radius_length_type', 'filter_radius_length_type', '', 'string');
            $city_filter = $mainframe->getUserStateFromRequest($option . 'txtfilter_city', 'txtfilter_city', '', 'string');
            $txtfilterlongitude = $mainframe->getUserStateFromRequest($option . 'filter_longitude', 'filter_longitude', '', 'string');
            $txtfilterlatitude = $mainframe->getUserStateFromRequest($option . 'filter_latitude', 'filter_latitude', '', 'string');
            $txtfilterradius = $mainframe->getUserStateFromRequest($option . 'filter_radius', 'filter_radius', '', 'string');

            if ($txtfilterlongitude == JText::_('JS_LONGITUDE'))
                $txtfilterlongitude = '';
            if ($txtfilterlatitude == JText::_('JS_LATITTUDE'))
                $txtfilterlatitude = '';
            if ($txtfilterradius == JText::_('JS_COORDINATES_RADIUS'))
                $txtfilterradius = '';

            $filterjobcategory = $mainframe->getUserStateFromRequest($option . 'filter_jobcategory', 'filter_jobcategory', '', 'string');
            $filterjobsubcategory = $mainframe->getUserStateFromRequest($option . 'filter_jobsubcategory', 'filter_jobsubcategory', '', 'string');
            $filterjobtype = $mainframe->getUserStateFromRequest($option . 'filter_jobtype', 'filter_jobtype', '', 'string');

            $result = $this->getJSModel('job')->getListNewestJobs($uid, $city_filter, $cmbfiltercountry, $filterjobcategory, $filterjobsubcategory, $filterjobtype, $txtfilterlongitude, $txtfilterlatitude, $txtfilterradius, $cmbfilterradiustype, $jobcountry, $jobstate, $limit, $limitstart);
            $jobs = $result[0];
            $filterlists = $result[2];
            $filtervalues = $result[3];

            if ($result[1] <= $limitstart)
                $limitstart = 0;
            $pagination = new JPagination($result[1], $limitstart, $limit);
            $this->assignRef('pagination', $pagination);
            $this->assignRef('listjobconfig', $result[4]);
            $this->assignRef('jobs', $jobs);
            $this->assignRef('filterlists', $filterlists);
            $this->assignRef('filtervalues', $filtervalues);
            $this->assignRef('filterid', $filterid);
        }
		require_once('job_breadcrumbs.php');        
        $document->setTitle($page_title);
        $this->assignRef('userrole', $userrole);
        $this->assignRef('config', $config);
        $this->assignRef('option', $option);
        $this->assignRef('params', $params);
        $this->assignRef('viewtype', $viewtype);
        $this->assignRef('employerlinks', $employerlinks);
        $this->assignRef('jobseekerlinks', $jobseekerlinks);
        $this->assignRef('uid', $uid);
        $this->assignRef('id', $id);
        $this->assignRef('Itemid', $itemid);
        $this->assignRef('isjobsharing', $_client_auth_key);

        parent :: display($tpl);
    }

    function getSortArg($type, $sort) {
        $mat = array();
        if (preg_match("/(\w+)(asc|desc)/i", $sort, $mat)) {
            if ($type == $mat[1]) {
                return ( $mat[2] == "asc" ) ? "{$type}desc" : "{$type}asc";
            } else {
                return $type . $mat[2];
            }
        }
        return "iddesc";
    }

    function getJobListSorting($sort) {
        $sortlinks['title'] = $this->getSortArg("title", $sort);
        $sortlinks['category'] = $this->getSortArg("category", $sort);
        $sortlinks['jobtype'] = $this->getSortArg("jobtype", $sort);
        $sortlinks['jobstatus'] = $this->getSortArg("jobstatus", $sort);
        $sortlinks['company'] = $this->getSortArg("company", $sort);
        $sortlinks['salaryrange'] = $this->getSortArg("salaryto", $sort);
        $sortlinks['country'] = $this->getSortArg("country", $sort);
        $sortlinks['created'] = $this->getSortArg("created", $sort);
        $sortlinks['apply_date'] = $this->getSortArg("apply_date", $sort);

        return $sortlinks;
    }

    function getJobListOrdering($sort) {
        global $sorton, $sortorder;
        switch ($sort) {
            case "titledesc": $ordering = "job.title DESC";
                $sorton = "title";
                $sortorder = "DESC";
                break;
            case "titleasc": $ordering = "job.title ASC";
                $sorton = "title";
                $sortorder = "ASC";
                break;
            case "categorydesc": $ordering = "cat.cat_title DESC";
                $sorton = "category";
                $sortorder = "DESC";
                break;
            case "categoryasc": $ordering = "cat.cat_title ASC";
                $sorton = "category";
                $sortorder = "ASC";
                break;
            case "jobtypedesc": $ordering = "job.jobtype DESC";
                $sorton = "jobtype";
                $sortorder = "DESC";
                break;
            case "jobtypeasc": $ordering = "job.jobtype ASC";
                $sorton = "jobtype";
                $sortorder = "ASC";
                break;
            case "jobstatusdesc": $ordering = "job.jobstatus DESC";
                $sorton = "jobstatus";
                $sortorder = "DESC";
                break;
            case "jobstatusasc": $ordering = "job.jobstatus ASC";
                $sorton = "jobstatus";
                $sortorder = "ASC";
                break;
            case "companydesc": $ordering = "job.company DESC";
                $sorton = "company";
                $sortorder = "DESC";
                break;
            case "companyasc": $ordering = "job.company ASC";
                $sorton = "company";
                $sortorder = "ASC";
                break;
            case "salarytoasc": $ordering = "salaryto ASC";
                $sorton = "salaryrange";
                $sortorder = "ASC";
                break;
            case "salarytodesc": $ordering = "salaryto DESC";
                $sorton = "salaryrange";
                $sortorder = "DESC";
                break;
            case "salaryrangedesc": $ordering = "salary.rangeend DESC";
                $sorton = "salaryrange";
                $sortorder = "DESC";
                break;
            case "salaryrangeasc": $ordering = "salary.rangestart ASC";
                $sorton = "salaryrange";
                $sortorder = "ASC";
                break;
            case "countrydesc": $ordering = "country.name DESC";
                $sorton = "country";
                $sortorder = "DESC";
                break;
            case "countryasc": $ordering = "country.name ASC";
                $sorton = "country";
                $sortorder = "ASC";
                break;
            case "createddesc": $ordering = "job.created DESC";
                $sorton = "created";
                $sortorder = "DESC";
                break;
            case "createdasc": $ordering = "job.created ASC";
                $sorton = "created";
                $sortorder = "ASC";
                break;
            case "apply_datedesc": $ordering = "apply.apply_date DESC";
                $sorton = "apply_date";
                $sortorder = "DESC";
                break;
            case "apply_dateasc": $ordering = "apply.apply_date ASC";
                $sorton = "apply_date";
                $sortorder = "ASC";
                break;
            default: $ordering = "job.id DESC";
        }
        return $ordering;
    }
}

?>
