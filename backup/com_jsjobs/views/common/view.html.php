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

class JSJobsViewCommon extends JSView {

    function display($tpl = null) {
        require_once(JPATH_COMPONENT . '/views/common.php');
        $viewtype = 'html';
        if ($layout == 'successfullogin') {
            if (isset($_SESSION['jsjobs_option'])) {
                $jsoption = $_SESSION['jsjobs_option'];
                unset($_SESSION['jsjobs_option']);
            }
            if (isset($_SESSION['jsjobs_view'])) {
                $jsview = $_SESSION['jsjobs_view'];
                unset($_SESSION['jsjobs_view']);
            }
            if (isset($_SESSION['jsjobs_red_layout'])) {
                $jslayout = $_SESSION['jsjobs_red_layout'];
                unset($_SESSION['jsjobs_red_layout']);
            }
            if (isset($_SESSION['jsjobs_comp_url'])) {
                $compurl = $_SESSION['jsjobs_comp_url'];
                unset($_SESSION['jsjobs_comp_url']);
            }
            if ($jslayout == 'successfullogin')
                $jslayout = 'controlpanel';
            if ($jsoption == '')
                $jsoption = JRequest::getVar('option');
            if ($jsoption == '')
                $jsoption = 'com_jsjobs';
            if ($jsoption == 'com_jsjobs') {
                if ($compurl != '') {
                    $mainframe->redirect($compurl);
                } elseif ($jsview != '') {
                    if ($jslayout == 'package_buynow') {
                        if (isset($_SESSION['nav']))
                            $mainframe->redirect('index.php?option=com_jsjobs&c=&view=&layout=' . $jslayout . '&nav=' . $_SESSION['nav'] . '&gd=' . $_SESSION['gd'] . '&Itemid=' . $itemid);
                        else
                            $mainframe->redirect('index.php?option=com_jsjobs&c=&view=&layout=' . $jslayout . '&gd=' . $_SESSION['gd'] . '&Itemid=' . $itemid);
                        unset($_SESSION['gd']);
                        unset($_SESSION['nav']);
                    }elseif ($jslayout == 'job_apply') {
                        $mainframe->redirect('index.php?option=com_jsjobs&c=jobapply&view=jobapply&layout=' . $jslayout . '&nav=' . $_SESSION['nav'] . '&bd=' . $_SESSION['bd'] . '&Itemid=' . $itemid);
                        unset($_SESSION['nav']);
                        unset($_SESSION['bd']);
                    } else {
                        $mainframe->redirect('index.php?option=com_jsjobs&c=&view=&layout=' . $jslayout . '&Itemid=' . $itemid);
                    }
                } else { //get role of this user
                    if (isset($role->rolefor)) {
                        if ($role->rolefor == 1) { // employer
                            $mainframe->redirect('index.php?option=com_jsjobs&c=jobseeker&view=jobseeker&layout=controlpanel&Itemid=' . $itemid);
                        } elseif ($role->rolefor == 2) { // jobseeker
                            $mainframe->redirect('index.php?option=com_jsjobs&c=jobseeker&view=jobseeker&layout=controlpanel&Itemid=' . $itemid);
                        }
                    }
                }
            }
            $result = $this->getJSModel('purchasehistory')->getEmployerPurchaseHistory($uid, $limit, $limitstart);
            $this->assignRef('packages', $result[0]);
            if ($result[1] <= $limitstart)
                $limitstart = 0;
            $pagination = new JPagination($result[1], $limitstart, $limit);
            $this->assignRef('pagination', $pagination);
        }elseif ($layout == 'new_injsjobs') {            // new in jsjobs
            $page_title .= ' - ' . JText::_('JS_WELCOME_JSJOBS');
            $result = $this->getJSModel('userrole')->getUserType($uid);
            $this->assignRef('usertype', $result[0]);
            $this->assignRef('lists', $result[1]);
        } elseif ($layout == 'userlogin') {
            $role = JRequest::getVar('ur');
            $return = JRequest::getVar('return');
            $this->assignRef('userrole', $role);
            $this->assignRef('loginreturn', $return);
        } elseif ($layout == 'userregister') {
            if (!$uid) {
                $mainframe->redirect('index.php?option=com_users&view=registration&Itemid=' . $itemid);
            } else {
                $mainframe->redirect('index.php?option=com_users&view=profile&Itemid=' . $itemid);
            }
        }

        $document->setTitle($page_title);
        $this->assignRef('userrole', $role);
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
