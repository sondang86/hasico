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

class JSJobsViewJobapply extends JSView{

    function display($tpl = null) {
        require_once JPATH_COMPONENT_ADMINISTRATOR . '/views/common.php';
//        layout start
        if ($layoutName == 'jobappliedresume') {        //job applied resume
            JToolBarHelper :: title(JText::_('JS_APPLIED_RESUME'));
            $jobid = JRequest::getVar('oi');
            $tab_action = JRequest::getVar('ta', '');
            $session = JFactory::getSession();
            $needle_array = $session->get('jsjobappliedresumefilter');
            if (empty($tab_action))
                $tab_action = 1;

            $form = 'com_jsjobs.jobappliedresume.list.';
            $result = $this->getJSModel('jobapply')->getJobAppliedResume($needle_array, $tab_action, $jobid, $limitstart, $limit);
            $items = $result[0];
            $total = $result[1];
            if ($total <= $limitstart)
                $limitstart = 0;
            $pagination = new JPagination($total, $limitstart, $limit);
            $this->assignRef('pagination', $pagination);
            $this->assignRef('oi', $jobid);
            $this->assignRef('tabaction', $tab_action);
            $this->assignRef('searchoptions', $result1[0]); // for advance search tab 
            $session->clear('jsjobappliedresumefilter');
        }elseif ($layoutName == 'appliedresumes') {        //applied resumes
            JToolBarHelper :: title(JText::_('JS_APPLIED_RESUME'));
            $form = 'com_jsjobs.appliedresumes.list.';
            $searchtitle = $mainframe->getUserStateFromRequest($form . 'searchtitle', 'searchtitle', '', 'string');
            $searchcompany = $mainframe->getUserStateFromRequest($form . 'searchcompany', 'searchcompany', '', 'string');
            $searchjobcategory = $mainframe->getUserStateFromRequest($form . 'searchjobcategory', 'searchjobcategory', '', 'string');
            $searchjobtype = $mainframe->getUserStateFromRequest($form . 'searchjobtype', 'searchjobtype', '', 'string');
            $searchjobstatus = $mainframe->getUserStateFromRequest($form . 'searchjobstatus', 'searchjobstatus', '', 'string');
            $result = $this->getJSModel('jobapply')->getAppliedResume($searchtitle, $searchcompany, $searchjobcategory, $searchjobtype, $searchjobstatus, $limitstart, $limit);
            $items = $result[0];
            $total = $result[1];
            $lists = $result[2];
            if ($total <= $limitstart)
                $limitstart = 0;
            $pagination = new JPagination($total, $limitstart, $limit);
            $this->assignRef('pagination', $pagination);
            $this->assignRef('lists', $lists);
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
