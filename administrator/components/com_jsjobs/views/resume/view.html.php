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

class JSJobsViewResume extends JSView{

    function display($tpl = null) {
        require_once JPATH_COMPONENT_ADMINISTRATOR . '/views/common.php';
//        layout start
        if ($layoutName == 'formresume') {   //resume            (form resume )
            $resume_model = $this->getJSModel('resume');
            if (isset($_GET['cid'][0]))
                $c_id = $_GET['cid'][0];
            else
                $c_id = '';
            if ($c_id == '') {
                $cids = JRequest :: getVar('cid', array(0), 'post', 'array');
                $c_id = $cids[0];
            }
            if (is_numeric($c_id) == true)
                $result = $resume_model->getEmpAppbyId($c_id);
            $this->assignRef('resume', $result[0]);
            $this->assignRef('userfields', $result[2]);

            $this->assignRef('fieldsordering', $result[3]);
            $resumelists = $resume_model->getEmpOptions();
            $this->assignRef('resumelists', $resumelists);
            if (isset($result[0]->id))
                $isNew = false;
            $text = $isNew ? JText :: _('ADD') : JText :: _('EDIT');
            JToolBarHelper :: title(JText :: _('JS_RESUME') . ': <small><small>[ ' . $text . ' ]</small></small>');
            JToolBarHelper :: save('resume.saveresume');
            if ($isNew)
                JToolBarHelper :: cancel('resume.cancel');
            else
                JToolBarHelper :: cancel('resume.cancel', 'Close');
        }elseif ($layoutName == 'formresumeuserfield') {      // form resume user fields
            $session = JFactory::getSession();
            $ff = JRequest::getVar('ff');
            if ($ff == "")
                $ff = $session->get('formresumeuserfield_ff');

            $session->set('formresumeuserfield_ff', $ff);
            $result = $this->getJSModel('resume')->getResumeUserFields($ff);

            $this->assignRef('userfields', $result);
            if ($ff == 13)
                JToolBarHelper :: title(JText :: _('JS_VISITOR_USER_FIELDS'));
            else
                JToolBarHelper :: title(JText :: _('JS_USER_FIELDS'));
            JToolBarHelper :: save('resume.saveresumeuserfields');
            JToolBarHelper :: cancel('resume.cancel', 'Close');
            $this->assignRef('fieldfor', $ff);
        }elseif ($layoutName == 'appqueue') {  //app queue
            JToolBarHelper :: title(JText::_('JS_RESUME_APPROVAL_QUEUE'));
            $form = 'com_jsjobs.appqueue.list.';
            $searchtitle = $mainframe->getUserStateFromRequest($form . 'searchtitle', 'searchtitle', '', 'string');
            $searchname = $mainframe->getUserStateFromRequest($form . 'searchname', 'searchname', '', 'string');
            $searchjobcategory = $mainframe->getUserStateFromRequest($form . 'searchjobcategory', 'searchjobcategory', '', 'string');
            $searchjobtype = $mainframe->getUserStateFromRequest($form . 'searchjobtype', 'searchjobtype', '', 'string');
            $searchjobsalaryrange = $mainframe->getUserStateFromRequest($form . 'searchjobsalaryrange', 'searchjobsalaryrange', '', 'string');
            $result = $this->getJSModel('resume')->getAllUnapprovedEmpApps($searchtitle, $searchname, $searchjobcategory, $searchjobtype, $searchjobsalaryrange, $limitstart, $limit);
            $items = $result[0];
            $total = $result[1];
            $lists = $result[2];
            if ($total <= $limitstart)
                $limitstart = 0;
            $pagination = new JPagination($total, $limitstart, $limit);
            $this->assignRef('pagination', $pagination);
            $this->assignRef('lists', $lists);
        }elseif ($layoutName == 'empapps') {        //employment applications
            JToolBarHelper :: title(JText::_('JS_RESUME'));
            JToolBarHelper :: editList('resume.edit');
            JToolBarHelper :: deleteList(JText::_('JS_ARE_YOU_SURE'), 'resume.remove');
            JToolBarHelper :: cancel('resume.cancel');
            $form = 'com_jsjobs.empapps.list.';
            $searchtitle = $mainframe->getUserStateFromRequest($form . 'searchtitle', 'searchtitle', '', 'string');
            $searchname = $mainframe->getUserStateFromRequest($form . 'searchname', 'searchname', '', 'string');
            $searchjobcategory = $mainframe->getUserStateFromRequest($form . 'searchjobcategory', 'searchjobcategory', '', 'string');
            $searchjobtype = $mainframe->getUserStateFromRequest($form . 'searchjobtype', 'searchjobtype', '', 'string');
            $searchjobsalaryrange = $mainframe->getUserStateFromRequest($form . 'searchjobsalaryrange', 'searchjobsalaryrange', '', 'string');
            $result = $this->getJSModel('resume')->getAllEmpApps($searchtitle, $searchname, $searchjobcategory, $searchjobtype, $searchjobsalaryrange, $limitstart, $limit);
            $items = $result[0];
            $total = $result[1];
            $lists = $result[2];
            if ($total <= $limitstart)
                $limitstart = 0;
            $pagination = new JPagination($total, $limitstart, $limit);
            $this->assignRef('pagination', $pagination);
            $this->assignRef('lists', $lists);
        }elseif ($layoutName == 'resume_searchresults') {
            JToolBarHelper:: title(JText::_('JS_RESUME_SEARCHRESULTS'));
            JToolBarHelper :: cancel('resume.cancel');
            $form = 'com_jsjobs.jobs.list.';            
            $title = $mainframe->getUserStateFromRequest($form . 'title', 'title', '', 'string');
            $name = $mainframe->getUserStateFromRequest($form . 'name', 'name', '', 'string');
            $nationality = $mainframe->getUserStateFromRequest($form . 'nationality', 'nationality', '', 'string');
            $gender = $mainframe->getUserStateFromRequest($form . 'gender', 'gender', '', 'string');
            $iamavailable = JRequest::getVar('iamavailable',0); // b/c when checkbox is unchecked it remain get its last value
            $jobcategory = $mainframe->getUserStateFromRequest($form . 'jobcategory', 'jobcategory', '', 'string');
            $jobsubcategory = $mainframe->getUserStateFromRequest($form . 'jobsubcategory', 'jobsubcategory', '', 'string');
            $jobtype = $mainframe->getUserStateFromRequest($form . 'jobtype', 'jobtype', '', 'string');
            $jobsalaryrange = $mainframe->getUserStateFromRequest($form . 'jobsalaryrange', 'jobsalaryrange', '', 'string');
            $education = $mainframe->getUserStateFromRequest($form . 'heighestfinisheducation', 'heighestfinisheducation', '', 'string');
            $experience = $mainframe->getUserStateFromRequest($form . 'experience', 'experience', '', 'string');
            $currency = $mainframe->getUserStateFromRequest($form . 'currency', 'currency', '', 'string');
            $zipcode = $mainframe->getUserStateFromRequest($form . 'zipcode', 'zipcode', '', 'string');
            $jobstatus = '';
            $result = $this->getJSModel('resume')->getResumeSearch($uid, $title, $name, $nationality, $gender, $iamavailable, $jobcategory, $jobtype, $jobstatus, $jobsalaryrange, $education
                    , $experience, $limit, $limitstart, $currency, $zipcode);
            $items = $result[0];
            $total = $result[1];
            $pagination = new JPagination($total, $limitstart, $limit);
            $this->assignRef('pagination', $pagination);
            $this->assignRef('searchresumeconfig', $result[2]);
        }elseif (($layoutName == 'resumeprint') || ($layoutName == 'view_resume')) {// view resume
            $resumeid = JRequest::getVar('rd');
            $jobid = JRequest::getVar('oi');
            if (is_numeric($resumeid) == true)
                $result = $this->getJSModel('resume')->getResumeViewbyId($resumeid);
            $this->assignRef('resume', $result[0]);
            $this->assignRef('resume2', $result[1]);
            $this->assignRef('resume3', $result[2]);
            $this->assignRef('fieldsordering', $result[3]);
            $this->assignRef('lists', $result[4]);
            $this->assignRef('userfields', $result[6]);
            $this->assignRef('jobid', $jobid);
            $this->assignRef('resumeid', $resumeid);
            JToolBarHelper :: title(JText :: _('JS_VIEW_RESUMES'));
        }elseif ($layoutName == 'resumesearch') {        //resume search
            JToolBarHelper :: title(JText::_('JS_RESUME_SEARCH'));
            $result = $this->getJSModel('resume')->getResumeSearchOptions();
            $this->assignRef('searchoptions', $result[0]);
            $this->assignRef('searchresumeconfig', $result[1]);
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
