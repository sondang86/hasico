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

class JSJobsViewEmployerPackages extends JSView {

    function display($tpl = null) {
        require_once(JPATH_COMPONENT . '/views/common.php');
        $viewtype = 'html';
        if ($layout == 'package_buynow') {
            $page_title .= ' - ' . JText::_('JS_BUY_NOW');
            $packageid = JRequest::getVar('gd');
            $result = $this->getJSModel('employerpackages')->getEmployerPackageById($packageid, $uid);
            $this->assignRef('package', $result[0]);
            $this->assignRef('paymentmethod', $paymentmethod);
            $nav = JRequest::getVar('nav', '');
            $this->assignRef('nav', $nav);
            $this->assignRef('idealdata', $ideal_data);
        } elseif ($layout == 'package_details') {
            $page_title .= ' - ' . JText::_('JS_PACKAGE_DETAILS');
            $packageid = JRequest::getVar('gd');
            $result = $this->getJSModel('employerpackages')->getEmployerPackageById($packageid, $uid);
            $this->assignRef('package', $result[0]);
            $this->assignRef('payment_multicompanies', $result[1]);
            $this->assignRef('lists', $result[2]);
        } elseif ($layout == 'packages') {            // my resume searches
            $page_title .= ' - ' . JText::_('JS_PACKAGES');
            $result = $this->getJSModel('employerpackages')->getEmployerPackages($limit, $limitstart);
            $this->assignRef('packages', $result[0]);
            if ($result[1] <= $limitstart)
                $limitstart = 0;
            $pagination = new JPagination($result[1], $limitstart, $limit);
            $this->assignRef('pagination', $pagination);
        }
        
        require_once('employerpackages_breadcrumbs.php');

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
