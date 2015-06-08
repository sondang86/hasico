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

class JSJobsViewCompany extends JSView {

    function display($tpl = null) {
        require_once(JPATH_COMPONENT . '/views/common.php');
        $viewtype = 'html';

        if ($layout == 'company_jobs') {
            $sort = JRequest::getVar('sortby', '');
            if (isset($sort)) {
                if ($sort == '')
                    $sort = 'createddesc';
            } else {
                $sort = 'createddesc';
            }
            $sortby = $this->getJobListOrdering($sort);

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

            $filterjobtype = $mainframe->getUserStateFromRequest($option . 'filter_jobtype', 'filter_jobtype', '', 'string');

            if (isset($_POST['filter_jobcategory']))
                $filterjobcategory = $_POST['filter_jobcategory'];
            else
                $filterjobcategory = '';

            if (isset($_POST['filter_jobsubcategory']))
                $filterjobsubcategory = $_POST['filter_jobsubcategory'];
            else
                $filterjobsubcategory = '';

            $companyid = $this->getJSModel('common')->parseId(JRequest::getVar('cd', ''));
            $result = $this->getJSModel('job')->getActiveJobsByCompany($uid, $companyid, $city_filter, $cmbfiltercountry, $filterjobcategory, $filterjobsubcategory, $filterjobtype, $sortby, $txtfilterlongitude, $txtfilterlatitude, $txtfilterradius, $cmbfilterradiustype, $limit, $limitstart);

            $jobs = $result[0];
            if ($result[1] <= $limitstart)
                $limitstart = 0;
            $filterlists = $result[2];
            $filtervalues = $result[3];

            $this->assignRef('listjobconfig', $result[4]);
            $this->assignRef('jobs', $jobs);
            $sortlinks = $this->getJobListSorting($sort);
            $sortlinks['sorton'] = $sorton;
            $sortlinks['sortorder'] = $sortorder;
            $pagination = new JPagination($result[1], $limitstart, $limit);
            $this->assignRef('pagination', $pagination);
            $this->assignRef('filterlists', $filterlists);
            $this->assignRef('filtervalues', $filtervalues);
            $this->assignRef('sortlinks', $sortlinks);
            $this->assignRef('companyid', $companyid);
            if (!empty($jobs)) {
                $page_title .= ' - ' . $jobs[0]->companyname . ' ' . JText::_('JS_JOBS');
            }
        } elseif ($layout == 'mycompanies') {        // my companies
            $page_title .= ' - ' . JText::_('JS_MY_COMPANIES');
            $mycompany_allowed = $this->getJSModel('permissions')->checkPermissionsFor("MY_COMPANY");
            if($mycompany_allowed == VALIDATE){
                $result = $this->getJSModel('company')->getMyCompanies($uid, $limit, $limitstart);
                $companies = $result[0];
                $this->assignRef('companies', $companies);
                if ($result[1] <= $limitstart)
                    $limitstart = 0;
                $pagination = new JPagination($result[1], $limitstart, $limit);
                $this->assignRef('pagination', $pagination);
            }
            $this->assignRef('mycompany_allowed',$mycompany_allowed);
        }elseif ($layout == 'view_company') {                // view company
            $companyid = $this->getJSModel('common')->parseId(JRequest::getVar('cd', ''));
            $result = $this->getJSModel('company')->getCompanybyId($companyid);
            $company = $result[0];
            $company_title = $company->name;
            $company_description = $company->description;
            $document->setMetaData('title', $company_title,true);
            $document->setDescription( $company_description);
            $this->assignRef('company', $company);
            $this->assignRef('userfields', $result[2]);
            $this->assignRef('fieldsordering', $result[3]);
            $nav = JRequest::getVar('nav', '');
            $this->assignRef('nav', $nav);
            $jobcat = JRequest::getVar('cat', '');
            $this->assignRef('jobcat', $jobcat);
            if (isset($company)) {
                $page_title .= ' - ' . $company->name;
            }
        } elseif ($layout == 'formcompany') {           // form company
            $page_title .= ' - ' . JText::_('JS_COMPANY_INFO');

            $companyid = $this->getJSModel('common')->parseId(JRequest::getVar('cd', ''));
            if (!isset($companyid))
                $companyid = '';
            $result = $this->getJSModel('company')->getCompanybyIdforForm($companyid, $uid, '', '', '');
            $this->assignRef('company', $result[0]);
            $this->assignRef('lists', $result[1]);
            $this->assignRef('userfields', $result[2]);
            $this->assignRef('fieldsordering', $result[3]);
            $this->assignRef('canaddnewcompany', $result[4]);
            $this->assignRef('packagedetail', $result[5]);
            if (isset($result[6]))
                $this->assignRef('multiselectedit', $result[6]);
            JHTML::_('behavior.formvalidation');
        }
		require_once('company_breadcrumbs.php');        
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

    function getJobListSorting($sort) {
        $sortlinks['title'] = $this->getSortArg("title", $sort);
        $sortlinks['category'] = $this->getSortArg("category", $sort);
        $sortlinks['jobtype'] = $this->getSortArg("jobtype", $sort);
        $sortlinks['jobstatus'] = $this->getSortArg("jobstatus", $sort);
        $sortlinks['company'] = $this->getSortArg("company", $sort);
        $sortlinks['salaryto'] = $this->getSortArg("salaryto", $sort);
        $sortlinks['salaryrange'] = $this->getSortArg("salaryrange", $sort);
        $sortlinks['country'] = $this->getSortArg("country", $sort);
        $sortlinks['created'] = $this->getSortArg("created", $sort);
        $sortlinks['apply_date'] = $this->getSortArg("apply_date", $sort);

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
