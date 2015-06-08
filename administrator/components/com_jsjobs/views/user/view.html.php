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

class JSJobsViewUser extends JSView{

    function display($tpl = null) {
        require_once JPATH_COMPONENT_ADMINISTRATOR . '/views/common.php';
//        layout start
        if ($layoutName == 'userstate_companies') {          // users
            JToolBarHelper :: title(JText::_('JS_USER_STATS_COMPANIES'));
            JToolBarHelper :: cancel('user.cancel');
            $companyuid = JRequest::getVar('md');
            $result = $this->getJSModel('user')->getUserStatsCompanies($companyuid, $limitstart, $limit);
            $items = $result[0];
            $total = $result[1];
            $this->assignRef('companyuid', $companyuid);
            if ($total <= $limitstart)
                $limitstart = 0;
            $pagination = new JPagination($total, $limitstart, $limit);
            $this->assignRef('pagination', $pagination);
        }elseif ($layoutName == 'userstats') {          // users
            JToolBarHelper :: title(JText::_('JS_USER_STATS'));
            JToolBarHelper :: cancel('user.cancel');
            $form = 'com_jsjobs.users.list.';
            $searchname = $mainframe->getUserStateFromRequest($form . 'searchname', 'searchname', '', 'string');
            $searchusername = $mainframe->getUserStateFromRequest($form . 'searchusername', 'searchusername', '', 'string');
            $result = $this->getJSModel('user')->getUserStats($searchname, $searchusername, $limitstart, $limit);
            $items = $result[0];
            $total = $result[1];
            $lists = $result[2];
            if ($total <= $limitstart)
                $limitstart = 0;
            $pagination = new JPagination($total, $limitstart, $limit);
            $this->assignRef('pagination', $pagination);
            $this->assignRef('lists', $lists);
        }elseif ($layoutName == 'userstate_resumes') {          // users
            JToolBarHelper :: title(JText::_('JS_USER_STATS_RESUMES'));
            JToolBarHelper :: cancel('user.cancel');
            $resumeuid = JRequest::getVar('ruid');
            $result = $this->getJSModel('resume')->getUserStatsResumes($resumeuid, $limitstart, $limit);
            $items = $result[0];
            $total = $result[1];
            if ($total <= $limitstart)
                $limitstart = 0;
            $pagination = new JPagination($total, $limitstart, $limit);
            $this->assignRef('pagination', $pagination);
            $this->assignRef('resumeuid', $resumeuid);
        }elseif ($layoutName == 'userstate_jobs') {          // users
            JToolBarHelper :: title(JText::_('JS_USER_STATS_JOBS'));
            JToolBarHelper :: cancel('user.cancel');
            $jobuid = JRequest::getVar('bd');
            $result = $this->getJSModel('user')->getUserStatsJobs($jobuid, $limitstart, $limit);
            $items = $result[0];
            $total = $result[1];
            if ($total <= $limitstart)
                $limitstart = 0;
            $pagination = new JPagination($total, $limitstart, $limit);
            $this->assignRef('pagination', $pagination);
            $this->assignRef('jobuid', $jobuid);
        }elseif ($layoutName == 'users') {          // users
            JToolBarHelper :: title(JText::_('JS_USERS'));
            JToolBarHelper :: editList('user.edit');
            $form = 'com_jstickets.users.list.';
            $searchname = $mainframe->getUserStateFromRequest($form . 'searchname', 'searchname', '', 'string');
            $searchusername = $mainframe->getUserStateFromRequest($form . 'searchusername', 'searchusername', '', 'string');
            $searchrole = $mainframe->getUserStateFromRequest($form . 'searchrole', 'searchrole', '', 'string');
            $result = $this->getJSModel('user')->getAllUsers($searchname, $searchusername, '', '', $searchrole, $limitstart, $limit);
            $items = $result[0];
            $total = $result[1];
            $lists = $result[2];
            if ($total <= $limitstart)
                $limitstart = 0;
            $pagination = new JPagination($total, $limitstart, $limit);
            $this->assignRef('lists', $lists);
            $this->assignRef('pagination', $pagination);
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
