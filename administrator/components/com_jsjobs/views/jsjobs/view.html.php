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

class JSJobsViewJsjobs extends JSView{

    function display($tpl = null) {
        require_once JPATH_COMPONENT_ADMINISTRATOR.'/views/common.php';
        if ($layoutName == 'controlpanel') {        //control panel
            JToolBarHelper :: title('JS Jobs');
            $ck = $this->getJSModel('configuration')->getCheckCronKey();
            if ($ck == false) {
                $this->getJSModel('configuration')->genearateCronKey();
            }
            $ck = $this->getJSModel('configuration')->getCronKey(md5(date('Y-m-d')));
            $this->assignRef('ck', $ck);
            $today_stats = $this->getJSModel('jsjobs')->getTodayStats();
            $topjobs = $this->getJSModel('job')->getTopJobs();
            $this->assignRef('today_stats', $today_stats);
            $this->assignRef('topjobs', $topjobs);
        } elseif ($layoutName == 'jsjobsstats') {          // users
            JToolBarHelper :: title(JText::_('JS_JOBS_STATS'));
            $result = $this->getJSModel('jsjobs')->getJSJobsStats();
            $this->assignRef('companies', $result[0]);
            $this->assignRef('jobs', $result[1]);
            $this->assignRef('resumes', $result[2]);
            $this->assignRef('totalpaidamount', $result[9]);
            $this->assignRef('totalemployer', $result[10]);
            $this->assignRef('totaljobseeker', $result[11]);
        } elseif ($layoutName == 'info') {
            JToolBarHelper :: title(JText::_('Information'));
        } elseif ($layoutName == 'themes') {    //Themes
            JToolBarHelper :: title(JText::_('JS_THEMES'));
            JToolBarHelper :: cancel('jsjobs.cancel');
        } elseif ($layoutName == 'updates') {          // roles
            JToolBarHelper :: title(JText::_('JS_JOB_UPDATE'));
            $configur = $this->getJSModel('configuration')->getConfigur();
            $this->assignRef('configur', $configur);
            $count_config = $this->getJSModel('configuration')->getCountConfig();
            $this->assignRef('count_config', $count_config);
        }
//        layout end

        $this->assignRef('config', $config);
        $this->assignRef('application', $application);
        $this->assignRef('theme', $theme);
        $this->assignRef('option', $option);
        $this->assignRef('uid', $uid);
        $this->assignRef('msg', $msg);
        $this->assignRef('isjobsharing', $_client_auth_key);

        parent :: display($tpl);
    }

}

?>
