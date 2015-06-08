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

class JSJobsViewJobSeeker extends JSView {

    function display($tpl = null) {
        require_once(JPATH_COMPONENT . '/views/common.php');
        $viewtype = 'html';

        if ($layout == 'controlpanel') {
            $jscontrolpanel = $this->getJSModel('configurations')->getConfigByFor('jscontrolpanel');
            if ($uid) {
                $packagedetail = $this->getJSModel('user')->getUserPackageDetailByUid($uid);
                $this->assignRef('packagedetail', $packagedetail);
            }
            $this->assignRef('jscontrolpanel', $jscontrolpanel);
        } elseif ($layout == 'my_stats') {        // my stats
            $page_title .= ' - ' . JText::_('JS_MY_STATS');
            $mystats_allowed = $this->getJSModel('permissions')->checkPermissionsFor("JOBSEEKER_STATS");
            if($mystats_allowed == VALIDATE){
                $result = $this->getJSModel('jobseeker')->getMyStats_JobSeeker($uid);
                $this->assignRef('resumeallow', $result[0]);
                $this->assignRef('totalresume', $result[1]);
                $this->assignRef('coverlettersallow', $result[6]);
                $this->assignRef('totalcoverletters', $result[7]);
                if (isset($result[8])) {
                    $this->assignRef('package', $result[8]);
                    $this->assignRef('packagedetail', $result[9]);
                }
                $this->assignRef('ispackagerequired', $result[10]);
            }
            $this->assignRef('mystats_allowed', $mystats_allowed);
        }
		require_once('jobseeker_breadcrumbs.php');
		
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
}

?>
