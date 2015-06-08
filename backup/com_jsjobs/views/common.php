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

global $mainframe, $sorton, $sortorder, $option;
$mainframe = JFactory::getApplication();
$user = JFactory::getUser();
$uid = $user->id;
$session = JFactory::getSession();
$config = $session->get('jsjobconfig_dft');
$curuser = $session->get('jsjobcur_usr');
if ($curuser != $uid)
    unset($config);
$session->set('jsjobcur_usr', $uid);

if (isset($config))
    if ($config['testing_mode'] == 1)
        unset($config);
if (!isset($config)) {
    $results = $this->getJSModel('configurations')->getConfig('');
    if ($results) { //not empty
        foreach ($results as $result) {
            $config[$result->configname] = $result->configvalue;
        }
        $session->set('jsjobconfig_dft', $config);
    }
}
$layout = JRequest::getVar('layout');
$itemid = JRequest::getVar('Itemid');
$option = 'com_jsjobs';
$userrole = Array();
$document = JFactory::getDocument();
//$document->addStyleSheet('components/com_jsjobs/css/style_color.php','text/css');
require_once ('components/com_jsjobs/css/style_color.php');
$document->addStyleSheet('components/com_jsjobs/css/style.css','text/css');

//if ($_client_auth_key == "") {
//    $auth_key = $this->getJSModel('common')->getClientAuthenticationKey();
//    $_client_auth_key = $auth_key;
//}

if (empty($_client_auth_key)) {
    $auth_key = $this->getJSModel('common')->getClientAuthenticationKey();
    $_client_auth_key = $auth_key;
}

$needlogin = true;
switch ($layout) {
    case 'controlpanel':
        if ($config['visitorview_emp_conrolpanel'] == 1)
            $needlogin = false;
        break;
    case 'packages':
        if ($config['visitorview_emp_packages'] == 1) {
            if (!$user->guest) {
                $role = $this->getJSModel('userrole')->getUserRole($uid);
                if (!isset($role->rolefor)) {
                    $n_i_l = JRoute::_('index.php?option=com_jsjobs&c=common&view=common&layout=new_injsjobs&Itemid=' . $itemid);
                    $mainframe->redirect($n_i_l);
                }
            }
            $needlogin = false;
            break;
        }
    case 'package_details': if ($config['visitorview_emp_viewpackage'] == 1)
            $needlogin = false; break;
    case 'resumesearch': if ($config['visitorview_emp_resumesearch'] == 1)
            $needlogin = false; break;
    case 'resumesearchresult': if ($config['visitorview_emp_resumesearchresult'] == 1)
            $needlogin = false; break;
    case 'view_company': if ($config['visitorview_emp_viewcompany'] == 1)
            $needlogin = false; break;
    case 'view_job': if ($config['visitorview_emp_viewjob'] == 1)
            $needlogin = false; break;
    case 'myjobs': 
            $needlogin = true; break;
    case 'formjob':
            $needlogin = true; break;
    default : $needlogin = false;
        break;
}
if ($user->guest) { // redirect user if not login
    if ($needlogin) {
        if ($layout == 'package_buynow') {
            $nav = JRequest::getVar('nav');
            $gd = JRequest::getVar('gd');
            if ($nav)
                $_SESSION['nav'] = $nav;
            if ($gd)
                $_SESSION['gd'] = $gd;
        }
        $msg = JText::_('JS_LOGIN_DESCRIPTION');
        $redirectUrl = JRoute::_('index.php?option=com_jsjobs&c=common&view=common&layout=successfullogin&Itemid='.$itemid);
        $redirectUrl = '&amp;return=' . $this->getJSModel('common')->b64ForEncode($redirectUrl);
        $finalUrl = 'index.php?option=com_users&view=login' . $redirectUrl;
        $mainframe->redirect($finalUrl, $msg);
    }
}

$limit = $mainframe->getUserStateFromRequest('global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
$limitstart = $mainframe->getUserStateFromRequest($option . '.limitstart', 'limitstart', 0, 'int');
$limitstart = JRequest::getVar('limitstart', 0);
$params = $mainframe->getPageParameters('com_jsjobs');

if ($curuser != $uid)
    unset($role);
if (!isset($role)) {
    $role = $this->getJSModel('userrole')->getUserRole($uid);
    $userrole = $role;
    if (isset($role)) { //not empty
        $_SESSION['jsuserrole'] = $role;
    } else {
        if ($layout != 'view_job' && $layout != 'new_injsjobs') {
            if (!$user->guest) {
                $mainframe->redirect('index.php?option=com_jsjobs&c=common&view=common&layout=new_injsjobs&Itemid=' . $itemid);
            }
        }
    }
}
if (isset($role->rolefor)) {
    if ($role->rolefor == 1) { // employer
        if ($config['tmenu_emcontrolpanel'] == 1) {
            $link = 'index.php?option=com_jsjobs&c=employer&view=employer&layout=controlpanel&Itemid=' . $itemid;
            $employerlinks [] = array($link, JText::_('JS_CONTROL_PANEL'), 'controlpanel');
        }if ($config['tmenu_emnewjob'] == 1) {
            $link = 'index.php?option=com_jsjobs&c=job&view=job&layout=formjob&Itemid=' . $itemid;
            $employerlinks [] = array($link, JText::_('JS_NEW_JOB'), 'new_job');
        }if ($config['tmenu_emmyjobs'] == 1) {
            $link = 'index.php?option=com_jsjobs&c=job&view=job&layout=myjobs&Itemid=' . $itemid;
            $employerlinks [] = array($link, JText::_('JS_MY_JOBS'), 'my_job');
        }if ($config['tmenu_emmycompanies'] == 1) {
            $link = 'index.php?option=com_jsjobs&c=company&view=company&layout=mycompanies&Itemid=' . $itemid;
            $employerlinks [] = array($link, JText::_('JS_MY_COMPANIES'), 'my_company');
        }if ($config['tmenu_emsearchresume'] == 1) {
            $link = 'index.php?option=com_jsjobs&c=jobapply&view=resume&layout=resumesearch&Itemid=' . $itemid;
            $employerlinks [] = array($link, JText::_('JS_RESUME_SEARCH'), 'applied_resume');
        }
    } else {
        if ($config['tmenu_jscontrolpanel'] == 1) {
            $link = 'index.php?option=com_jsjobs&c=jobseeker&view=jobseeker&layout=controlpanel&Itemid=' . $itemid;
            $jobseekerlinks [] = array($link, JText::_('JS_CONTROL_PANEL'), 'controlpanel');
        }if ($config['tmenu_jsjobcategory'] == 1) {
            $link = 'index.php?option=com_jsjobs&c=category&view=category&layout=jobcat&Itemid=' . $itemid;
            $jobseekerlinks [] = array($link, JText::_('JS_JOB_CATEGORIES'), 'job_categories');
        }if ($config['tmenu_jssearchjob'] == 1) {
            $link = 'index.php?option=com_jsjobs&c=job&view=job&layout=jobsearch&Itemid=' . $itemid;
            $jobseekerlinks [] = array($link, JText::_('JS_SEARCH_JOB'), 'job_search');
        }if ($config['tmenu_jsnewestjob'] == 1) {
            $link = 'index.php?option=com_jsjobs&c=job&view=job&layout=listnewestjobs&Itemid=' . $itemid;
            $jobseekerlinks [] = array($link, JText::_('JS_NEWEST_JOBS'), 'newest_job');
        }if ($config['tmenu_jsmyresume'] == 1) {
            $link = 'index.php?option=com_jsjobs&c=resume&view=resume&layout=myresumes&Itemid=' . $itemid;
            $jobseekerlinks [] = array($link, JText::_('JS_MY_RESUMES'), 'my_resume');
        }
    }
} else { // user not logined
    $layout = $this->getLayout();
    $view = JRequest::getVar('view');
    if($layout == 'jobcat' || $layout == 'userlogin' || $layout == 'userregister' || $layout == 'view_company' || $layout == 'company_jobs' || $layout == 'formcoverletter' || $layout == 'mycoverletters' || $layout == 'view_coverletter' || $layout == 'job_searchresults' || $layout == 'jobapply' || $layout == 'jobsearch' || $layout == 'list_jobs' || $layout == 'listjob_subcategories' || $layout == 'listnewestjobs' || $layout == 'view_job' || $layout == 'jobalertsetting' || $layout == 'jobalertunsubscribe' || $layout == 'myappliedjobs' || $layout == 'my_jobsearches' || ($layout == 'controlpanel' && $view == 'jobseeker') || ($layout == 'my_stats' && $view == 'jobseeker') || ($layout == 'package_buynow' && $view == 'jobseekerpackages') || ($layout == 'package_details' && $view == 'jobseekerpacakges') || ($layout == 'packages' && $view == 'jobseekerpacakges') || $layout == 'send_message' || $layout == 'jsmessages' || $layout == 'norecordfound' || $layout == 'jobseekerpurchasehistory' || $layout == 'formresume' || $layout == 'myresumes' || $layout == 'view_resume' || $layout == 'list_subcategoryjobs'){ // Job seeker
        if ($config['tmenu_vis_jscontrolpanel'] == 1) {
            $link = 'index.php?option=com_jsjobs&c=jobseeker&view=jobseeker&layout=controlpanel&Itemid=' . $itemid;
            $jobseekerlinks [] = array($link, JText::_('JS_CONTROL_PANEL'), 'controlpanel');
        }if ($config['tmenu_vis_jsjobcategory'] == 1) {
            $link = 'index.php?option=com_jsjobs&c=category&view=category&layout=jobcat&Itemid=' . $itemid;
            $jobseekerlinks [] = array($link, JText::_('JS_JOB_CATEGORIES'), 'job_categories');
        }if ($config['tmenu_vis_jssearchjob'] == 1) {
            $link = 'index.php?option=com_jsjobs&c=job&view=job&layout=jobsearch&Itemid=' . $itemid;
            $jobseekerlinks [] = array($link, JText::_('JS_SEARCH_JOB'), 'job_search');
        }if ($config['tmenu_vis_jsnewestjob'] == 1) {
            $link = 'index.php?option=com_jsjobs&c=job&view=job&layout=listnewestjobs&Itemid=' . $itemid;
            $jobseekerlinks [] = array($link, JText::_('JS_NEWEST_JOBS'), 'newest_job');
        }if ($config['tmenu_vis_jsmyresume'] == 1) {
            $link = 'index.php?option=com_jsjobs&c=resume&view=resume&layout=myresumes&Itemid=' . $itemid;
            $jobseekerlinks [] = array($link, JText::_('JS_MY_RESUMES'), 'my_resume');
        }
    }elseif($layout == 'new_injsjobs' || $layout == 'formdepartment' || $layout == 'mydepartments' || $layout == 'view_department' || $layout == 'formcompany' || $layout == 'mycompanies' || ($layout == 'controlpanel' && $view == 'employer') || ($layout == 'my_stats' && $view == 'employer') || ($layout == 'package_buynow' && $view == 'employerpackages') || ($layout == 'package_details' && $view == 'employerpackages') || ($layout == 'packages' && $view == 'employerpackages') || $layout == 'folder_resumes' || $layout == 'formfolder' || $layout == 'myfolders' || $layout == 'viewfolder' || $layout == 'formjob' || $layout == 'formjob_visitor' || $layout == 'myjobs' || $layout == 'job_appliedapplications' || $layout == 'job_apply' || $layout == 'empmessages' || $layout == 'job_messages' || $layout == 'employerpurchasehistory' || $layout == 'listresume_subcategories' || $layout == 'my_resumesearches' || $layout == 'resume_bycategory' || $layout == 'resume_bysubcategory' || $layout == 'resume_print' || $layout == 'resume_searchresults' || $layout == 'resumebycategory' || $layout == 'resumesearch'){ // employer
        if ($config['tmenu_vis_emcontrolpanel'] == 1) {
            $link = 'index.php?option=com_jsjobs&c=employer&view=employer&layout=controlpanel&Itemid=' . $itemid;
            $employerlinks [] = array($link, JText::_('JS_CONTROL_PANEL'), 'controlpanel');
        }if ($config['tmenu_vis_emnewjob'] == 1) {
            $link = 'index.php?option=com_jsjobs&c=job&view=job&layout=formjob&Itemid=' . $itemid;
            $employerlinks [] = array($link, JText::_('JS_NEW_JOB'), 'new_job');
        }if ($config['tmenu_vis_emmyjobs'] == 1) {
            $link = 'index.php?option=com_jsjobs&c=job&view=job&layout=myjobs&Itemid=' . $itemid;
            $employerlinks [] = array($link, JText::_('JS_MY_JOBS'), 'my_job');
        }if ($config['tmenu_vis_emmycompanies'] == 1) {
            $link = 'index.php?option=com_jsjobs&c=company&view=company&layout=mycompanies&Itemid=' . $itemid;
            $employerlinks [] = array($link, JText::_('JS_MY_COMPANIES'), 'my_company');
        }if ($config['tmenu_vis_emsearchresume'] == 1) {
            $link = 'index.php?option=com_jsjobs&c=jobapply&view=resume&layout=resumesearch&Itemid=' . $itemid;
            $employerlinks [] = array($link, JText::_('JS_RESUME_SEARCH'), 'applied_resume');
        }
    }
}
$page_title = $params->get('page_title');
?>
