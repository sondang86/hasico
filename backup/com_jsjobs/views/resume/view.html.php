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

class JSJobsViewResume extends JSView {

    function display($tpl = null) {
        require_once(JPATH_COMPONENT . '/views/common.php');
        $viewtype = 'html';

        if ($layout == 'formresume') {            // form resume
            $page_title .= ' - ' . JText::_('JS_RESUME_FORM');
            $resumeid = $this->getJSModel('common')->parseId(JRequest::getVar('rd', ''));
            $resume_model = $this->getJSModel('resume');
			$result = $resume_model->getResumebyId($resumeid, $uid);
            $resumelists = $resume_model->getEmpOptions();
            if (!$uid) {
                $session = JFactory::getSession();
                $visitor = $session->get('jsjob_jobapply');
                $session->clear('jsjob_jobapply');
                $this->assignRef('visitor', $visitor);
            }
            $this->assignRef('resume', $result[0]);
            $this->assignRef('userfields', $result[2]);
            $this->assignRef('fieldsordering', $result[3]);
            $this->assignRef('canaddnewresume', $result[4]);
            $this->assignRef('packagedetail', $result[5]);
            $this->assignRef('resumelists', $resumelists);
            $nav = JRequest::getVar('nav', '');
            $this->assignRef('nav', $nav);
            JHTML::_('behavior.formvalidation');
            if (!$uid) {
                $result1 = $this->getJSModel('common')->getCaptchaForForm();
                $this->assignRef('captcha', $result1);
            }
        } elseif ($layout == 'resumesearch') {           // resume search
            $page_title .= ' - ' . JText::_('JS_RESUME_SEARCH');
            $result = $this->getJSModel('resume')->getResumeSearchOptions();
            $this->assignRef('searchoptions', $result[0]);
            $this->assignRef('searchresumeconfig', $result[1]);
            $this->assignRef('canview', $result[2]);
        } elseif ($layout == 'myresumes') {            // my resumes
            $page_title .= ' - ' . JText::_('JS_MY_RESUMES');
            $myresume_allowed = $this->getJSModel('permissions')->checkPermissionsFor("MY_RESUME");
            if($myresume_allowed == VALIDATE){
                $sort = JRequest::getVar('sortby', '');
                if (isset($sort)) {
                    if ($sort == '') {
                        $sort = 'createddesc';
                    }
                } else {
                    $sort = 'createddesc';
                }
                $sortby = $this->getResumeListOrdering($sort);
                $result = $this->getJSModel('resume')->getMyResumesbyUid($uid, $sortby, $limit, $limitstart);
                $this->assignRef('resumes', $result[0]);
                $this->assignRef('resumestyle', $result[2]);
                if ($result[1] <= $limitstart)
                    $limitstart = 0;
                $pagination = new JPagination($result[1], $limitstart, $limit);
                $this->assignRef('pagination', $pagination);
                $sortlinks = $this->getResumeListSorting($sort);
                $sortlinks['sorton'] = $sorton;
                $sortlinks['sortorder'] = $sortorder;
                $this->assignRef('sortlinks', $sortlinks);
            }
            $this->assignRef('myresume_allowed',$myresume_allowed);
        } elseif ($layout == 'my_resumesearches') {            // my resume searches
            $page_title .= ' - ' . JText::_('JS_RESUME_SAVE_SEARCHES');
            $myresumesearch_allowed = $this->getJSModel('permissions')->checkPermissionsFor("RESUME_SAVE_SEARCH");
            if($myresumesearch_allowed == VALIDATE){
                $result = $this->getJSModel('resume')->getMyResumeSearchesbyUid($uid, $limit, $limitstart);
                $this->assignRef('jobsearches', $result[0]);
                if ($result[1] <= $limitstart)
                    $limitstart = 0;
                $pagination = new JPagination($result[1], $limitstart, $limit);
                $this->assignRef('pagination', $pagination);
            }
            $this->assignRef('myresumesearch_allowed', $myresumesearch_allowed);
        } elseif ($layout == 'resumebycategory') {      // Resume By category
            $result = $this->getJSModel('resume')->getResumeByCategory($uid);
            $this->assignRef('categories', $result[0]);
            $this->assignRef('canview', $result[1]);
        } elseif ($layout == 'resume_bycategory') {                // resume by category
            $page_title .= ' - ' . JText::_('JS_RESUME_BY_CATEGORY');
            $sort = JRequest::getVar('sortby', '');
            if (isset($sort)) {
                if ($sort == '') {
                    $sort = 'create_datedesc';
                }
            } else {
                $sort = 'create_datedesc';
            }
            $jobcategory = $this->getJSModel('common')->parseId(JRequest::getVar('cat', ''));

            $sortby = $this->getResumeListOrdering($sort);

            $result = $this->getJSModel('resume')->getResumeByCategoryId($uid, $jobcategory, $sortby, $limit, $limitstart);
            $options = $this->get('Options');
            $sortlinks = $this->getResumeListSorting($sort);
            $sortlinks['sorton'] = $sorton;
            $sortlinks['sortorder'] = $sortorder;
            if ($result[1] <= $limitstart)
                $limitstart = 0;
            $pagination = new JPagination($result[1], $limitstart, $limit);
            $this->assignRef('pagination', $pagination);
            $this->assignRef('resumes', $result[0]);
            $this->assignRef('searchresumeconfig', $result[2]);
            $this->assignRef('categoryname', $result[3]);
            $this->assignRef('catid', $result[4]);
            $this->assignRef('subcategories', $result[5]);

            $this->assignRef('sortlinks', $sortlinks);
        }elseif ($layout == 'resume_bysubcategory') {                // resume by category
            $page_title .= ' - ' . JText::_('JS_RESUME_BY_SUBCATEGORY');
            $sort = JRequest::getVar('sortby', '');
            if (isset($sort)) {
                if ($sort == '') {
                    $sort = 'create_datedesc';
                }
            } else {
                $sort = 'create_datedesc';
            }
            $jobsubcategory = $this->getJSModel('common')->parseId(JRequest::getVar('resumesubcat', ''));
            $sortby = $this->getResumeListOrdering($sort);

            $result = $this->getJSModel('resume')->getResumeBySubCategoryId($uid, $jobsubcategory, $sortby, $limit, $limitstart);
            $options = $this->get('Options');
            $sortlinks = $this->getResumeListSorting($sort);
            $sortlinks['sorton'] = $sorton;
            $sortlinks['sortorder'] = $sortorder;
            if ($result[1] <= $limitstart)
                $limitstart = 0;
            $pagination = new JPagination($result[1], $limitstart, $limit);
            $this->assignRef('pagination', $pagination);
            if (isset($result[0]))
                $this->assignRef('resume', $result[0]);
            if (isset($result[2]))
                $this->assignRef('subcategorytitle', $result[2]);
            $this->assignRef('resumesubcategory', $jobsubcategory);
            $this->assignRef('sortlinks', $sortlinks);
        }elseif ($layout == 'viewresumesearch') {            // view resume seach
            $page_title .= ' - ' . JText::_('JS_VIEW_RESUME_SEARCH');
            $id = JRequest::getVar('rs', '');
            $search = $this->getJSModel('resumesearch')->getResumeSearchebyId($id);
            if (isset($search)) {
                $mainframe->setUserState($option.'title',$search->application_title);
                if ($search->nationality != 0)
                    $mainframe->setUserState($option.'nationality',$search->nationality);
                if ($search->gender != 0)
                    $mainframe->setUserState($option.'gender',$search->gender);
                if ($search->iamavailable != 0)
                    $mainframe->setUserState($option.'iamavailable',$search->iamavailable);
                if ($search->category != 0)
                    $mainframe->setUserState($option.'category',$search->category);
                if ($search->jobtype != 0)
                    $mainframe->setUserState($option.'jobtype',$search->jobtype);
                if ($search->salaryrange != 0)
                    $mainframe->setUserState($option.'salaryrange',$search->salaryrange);
                if ($search->education != 0)
                    $mainframe->setUserState($option.'education',$search->education);
                $mainframe->setUserState($option.'experience',$search->experience);
                $mainframe->setUserState($option.'name','');
                $mainframe->setUserState($option.'jobsubcategory','');
                $mainframe->setUserState($option.'currency','');
                $mainframe->setUserState($option.'zipcode','');
                $mainframe->setUserState($option.'keywords','');
            }
            $mainframe->redirect(JRoute::_('index.php?option=com_jsjobs&c=resume&view=resume&layout=resume_searchresults&Itemid=' . $itemid));
        }elseif ($layout == 'resume_searchresults') {                // resume search results
            $page_title .= ' - ' . JText::_('JS_RESUME_SEARCH_RESULT');
            $sort = JRequest::getVar('sortby', '');
            if (isset($sort)) {
                if ($sort == '') {
                    $sort = 'create_datedesc';
                }
            } else {
                $sort = 'create_datedesc';
            }
            $sortby = $this->getResumeListOrdering($sort);
            if ($limit != '') {
                $_SESSION['limit'] = $limit;
            } else if ($limit == '') {
                $limit = $_SESSION['limit'];
            }
            $title = $mainframe->getUserStateFromRequest($option.'title','title','','string');
            $name = $mainframe->getUserStateFromRequest($option.'name','name','','string');
            $nationality = $mainframe->getUserStateFromRequest($option.'nationality','nationality','','string');
            $gender = $mainframe->getUserStateFromRequest($option.'gender','gender','','string');
            $iamavailable = $mainframe->getUserStateFromRequest($option.'iamavailable','iamavailable','','string');
            $jobcategory = $mainframe->getUserStateFromRequest($option.'jobcategory','jobcategory','','string');
            $jobsubcategory = $mainframe->getUserStateFromRequest($option.'jobsubcategory','jobsubcategory','','string');
            $jobtype = $mainframe->getUserStateFromRequest($option.'jobtype','jobtype','','string');
            $jobsalaryrange = $mainframe->getUserStateFromRequest($option.'jobsalaryrange','jobsalaryrange','','string');
            $education = $mainframe->getUserStateFromRequest($option.'education','education','','string');
            $experience = $mainframe->getUserStateFromRequest($option.'experience','experience','','string');
            $currency = $mainframe->getUserStateFromRequest($option.'currency','currency','','string');
            $zipcode = $mainframe->getUserStateFromRequest($option.'zipcode','zipcode','','string');
            $keywords = $mainframe->getUserStateFromRequest($option.'keywords','keywords','','string');
            $jobstatus = '';

            $result = $this->getJSModel('resume')->getResumeSearch($uid, $title, $name, $nationality, $gender, $iamavailable, $jobcategory, $jobsubcategory, $jobtype, $jobstatus, $currency, $jobsalaryrange, $education, $experience, $sortby, $limit, $limitstart, $zipcode, $keywords);
            if ($result != false) {
                $options = $this->get('Options');
                $sortlinks = $this->getResumeListSorting($sort);
                $sortlinks['sorton'] = $sorton;
                $sortlinks['sortorder'] = $sortorder;
                if ($result[1] <= $limitstart)
                    $limitstart = 0;
                $pagination = new JPagination($result[1], $limitstart, $limit);
                $this->assignRef('pagination', $pagination);
                $this->assignRef('resumes', $result[0]);
                $this->assignRef('searchresumeconfig', $result[2]);
                $this->assignRef('canview', $result[3]);
                $this->assignRef('sortlinks', $sortlinks);
                $true = true;
                $this->assignRef('result', $true);
            }else {
                $this->assignRef('result', $result);
            }
        } else if (($layout == 'resume_download') || ($layout == 'resume_view')) { // resume view & download
            $empid = $_GET['rq'];
            $application = $this->getJSModel('employer')->getEmpApplicationbyid($empid);
        } elseif (($layout == 'view_resume') or ($layout == 'resume_print')) {          // view resume
            if (isset($_GET['id']))
                $empid = $_GET['id'];
            else
                $empid = '';
            if ($empid != '') {
                $application = $this->getJSModel('employer')->getEmpApplicationbyid($empid);
            } else {
                $resumeid = $this->getJSModel('common')->parseId(JRequest::getVar('rd', ''));
                $myresume = JRequest::getVar('nav', '');
                $jobid = $this->getJSModel('common')->parseId(JRequest::getVar('bd', ''));
                $folderid = JRequest::getVar('fd', '');
                $catid = JRequest::getVar('cat', '');
                $resumesubcat = JRequest::getVar('resumesubcat', '');
                if ($jobid == '0')
                    $jobid = '';
                $sortvalue = $sort = JRequest::getVar('sortby', false);
                if ($sort != false)
                    $sort = $this->getEmpListOrdering($sort);
                $tabaction = JRequest::getVar('ta', false);
                $result = $this->getJSModel('resume')->getResumeViewbyId($uid, $jobid, $resumeid, $myresume, $sort, $tabaction);
                $this->assignRef('resume', $result[0]);
                $this->assignRef('resume2', $result[1]);
                $this->assignRef('resume3', $result[2]);
                $this->assignRef('fieldsordering', $result[3]);
                $this->assignRef('canview', $result[4]);
                $this->assignRef('coverletter', $result[5]); // for new feature coverletter
                $this->assignRef('userfields', $result[6]);
                $this->assignRef('cvids', $result[8]); // for employer resumes navigations
                $nav = JRequest::getVar('nav', '');
                $this->assignRef('nav', $nav);
                $jobaliasid = JRequest::getVar('bd', '');
                if (!$jobid)
                    $jobid = 0;
                $this->assignRef('bd', $jobid);
                $this->assignRef('jobaliasid', $jobaliasid);
                $this->assignRef('resumeid', $resumeid);
                $this->assignRef('sortby', $sortvalue);
                $this->assignRef('ta', $tabaction);
                $this->assignRef('fd', $folderid);
                $this->assignRef('ms', $myresume);
                $this->assignRef('catid', $catid);
                $this->assignRef('subcatid', $resumesubcat);
            }
        }
		require_once('resume_breadcrumbs.php');
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

    function getResumeListSorting($sort) {
        $sortlinks['application_title'] = $this->getSortArg("application_title", $sort);
        $sortlinks['jobtype'] = $this->getSortArg("jobtype", $sort);
        $sortlinks['salaryrange'] = $this->getSortArg("salaryrange", $sort);
        $sortlinks['created'] = $this->getSortArg("created", $sort);

        return $sortlinks;
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

    function getResumeListOrdering($sort) {
        global $sorton, $sortorder;
        switch ($sort) {
            case "application_titledesc": $ordering = "resume.application_title DESC";
                $sorton = "application_title";
                $sortorder = "DESC";
                break;
            case "application_titleasc": $ordering = "resume.application_title ASC";
                $sorton = "application_title";
                $sortorder = "ASC";
                break;
            case "jobtypedesc": $ordering = "resume.jobtype DESC";
                $sorton = "jobtype";
                $sortorder = "DESC";
                break;
            case "jobtypeasc": $ordering = "resume.jobtype ASC";
                $sorton = "jobtype";
                $sortorder = "ASC";
                break;
            case "salaryrangedesc": $ordering = "salary.rangeend DESC";
                $sorton = "salaryrange";
                $sortorder = "DESC";
                break;
            case "salaryrangeasc": $ordering = "salary.rangestart ASC";
                $sorton = "salaryrange";
                $sortorder = "ASC";
                break;
            case "createddesc": $ordering = "resume.create_date DESC";
                $sorton = "created";
                $sortorder = "DESC";
                break;
            case "createdasc": $ordering = "resume.create_date ASC";
                $sorton = "created";
                $sortorder = "ASC";
                break;
            default: $ordering = "resume.id DESC";
        }
        return $ordering;
    }

    function getEmpListOrdering($sort) {
        global $sorton, $sortorder;
        switch ($sort) {
            case "namedesc": $ordering = "app.first_name DESC";
                $sorton = "name";
                $sortorder = "DESC";
                break;
            case "nameasc": $ordering = "app.first_name ASC";
                $sorton = "name";
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
            case "jobtypedesc": $ordering = "app.jobtype DESC";
                $sorton = "jobtype";
                $sortorder = "DESC";
                break;
            case "jobtypeasc": $ordering = "app.jobtype ASC";
                $sorton = "jobtype";
                $sortorder = "ASC";
                break;
            case "jobsalaryrangedesc": $ordering = "salary.rangestart DESC";
                $sorton = "jobsalaryrange";
                $sortorder = "DESC";
                break;
            case "jobsalaryrangeasc": $ordering = "salary.rangestart ASC";
                $sorton = "jobsalaryrange";
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
            case "emaildesc": $ordering = "app.email_address DESC";
                $sorton = "email";
                $sortorder = "DESC";
                break;
            case "emailasc": $ordering = "app.email_address ASC";
                $sorton = "email";
                $sortorder = "ASC";
                break;
            case "availabledesc": $ordering = "app.iamavailable DESC";
                $sorton = "available";
                $sortorder = "DESC";
                break;
            case "availableasc": $ordering = "app.iamavailable ASC";
                $sorton = "available";
                $sortorder = "ASC";
                break;
            case "educationdesc": $ordering = "app.heighestfinisheducation DESC";
                $sorton = "education";
                $sortorder = "DESC";
                break;
            case "educationasc": $ordering = "app.heighestfinisheducation ASC";
                $sorton = "education";
                $sortorder = "ASC";
                break;
            default: $ordering = "job.id DESC";
        }
        return $ordering;
    }

}

?>
