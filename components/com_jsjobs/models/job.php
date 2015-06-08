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
 * File Name:	models/jsjobs.php
  ^
 * Description: Model class for jsjobs data
  ^
 * History:		NONE
  ^
 */
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.model');
jimport('joomla.html.html');
$option = JRequest :: getVar('option', 'com_jsjobs');

class JSJobsModelJob extends JSModel {

    var $_uid = null;
    var $_client_auth_key = null;
    var $_siteurl = null;
    var $_defaultcountry = null;
    var $_job = null;
    var $_applications = null;
    var $_application = null;

    function __construct() {
        parent :: __construct();
        $client_auth_key = $this->getJSModel('common')->getClientAuthenticationKey();
        $this->_client_auth_key = $client_auth_key;
        $this->_siteurl = JURI::root();

        $user = JFactory::getUser();
        $this->_uid = $user->id;
    }

    function jobsearch($sh_category, $sh_subcategory, $sh_company, $sh_jobtype, $sh_jobstatus, $sh_shift, $sh_salaryrange, $plugin) {
        $db = JFactory::getDBO();

        // Configurations *********************************************
        $query = "SELECT * FROM `#__js_job_config` WHERE configname = 'date_format' ";
        $db->setQuery($query);
        $configs = $db->loadObjectList();
        foreach ($configs AS $config) {
            if ($config->configname == 'date_format')
                $dateformat = $config->configvalue;
        }
        $firstdash = strpos($dateformat, '-', 0);
        $firstvalue = substr($dateformat, 0, $firstdash);
        $firstdash = $firstdash + 1;
        $seconddash = strpos($dateformat, '-', $firstdash);
        $secondvalue = substr($dateformat, $firstdash, $seconddash - $firstdash);
        $seconddash = $seconddash + 1;
        $thirdvalue = substr($dateformat, $seconddash, strlen($dateformat) - $seconddash);
        $js_dateformat = '%' . $firstvalue . '-%' . $secondvalue . '-%' . $thirdvalue;


        // Categories *********************************************
        if ($sh_category == 1) {
            $query = "SELECT * FROM `#__js_job_categories` WHERE isactive = 1 ORDER BY cat_title ";
            $db->setQuery($query);
            $rows = $db->loadObjectList();
            if (isset($rows)) {
                $jobcategories = array();
                $jobcategories[] = array('value' => JText::_(''), 'text' => JText::_('JS_SELECT_CATEGORY'));
                foreach ($rows as $row)
                    $jobcategories[] = array('value' => JText::_($row->id), 'text' => JText::_($row->cat_title));
            }
            if (isset($plugin) && $plugin == 1)
                $job_categories = JHTML::_('select.genericList', $jobcategories, 'jobcategory', 'class="inputbox" style="width:160px;" ' . 'onChange="plgfj_getsubcategories(\'plgfj_subcategory\', this.value)"', 'value', 'text', '');
            else
                $job_categories = JHTML::_('select.genericList', $jobcategories, 'jobcategory', 'class="inputbox" style="width:160px;" ' . 'onChange="modfj_getsubcategories(\'modfj_subcategory\', this.value)"', 'value', 'text', '');
        }
        // Sub Categories *********************************************
        if ($sh_subcategory == 1) {
            $jobsubcategories = array();
            $jobsubcategories[] = array('value' => JText::_(''), 'text' => JText::_('JS_SELECT_SUB_CATEGORY'));
            $job_subcategories = JHTML::_('select.genericList', $jobsubcategories, 'jobsubcategory', 'class="inputbox" style="width:160px;" ' . '', 'value', 'text', '');
        }

        //Companies *********************************************
        if ($sh_company == 1) {
            $query = "SELECT id, name FROM `#__js_job_companies` ORDER BY name ASC ";
            $db->setQuery($query);
            $rows = $db->loadObjectList();
            if (isset($rows)) {
                $companies = array();
                $companies[] = array('value' => JText::_(''), 'text' => JText::_('JS_SELECT_COMPANY'));
                foreach ($rows as $row)
                    $companies[] = array('value' => $row->id, 'text' => $row->name);
            }
            $search_companies = JHTML::_('select.genericList', $companies, 'company', 'class="inputbox" style="width:160px;" ' . '', 'value', 'text', '');
        }
        //Job Types *********************************************
        if ($sh_jobtype == 1) {
            $query = "SELECT id, title FROM `#__js_job_jobtypes` WHERE isactive = 1 ORDER BY id ASC ";
            $db->setQuery($query);
            $rows = $db->loadObjectList();
            if (isset($rows)) {
                $jobtype = array();
                $jobtype[] = array('value' => JText::_(''), 'text' => JText::_('JS_SELECT_JOB_TYPE'));
                foreach ($rows as $row)
                    $jobtype[] = array('value' => JText::_($row->id), 'text' => JText::_($row->title));
            }
            $job_type = JHTML::_('select.genericList', $jobtype, 'jobtype', 'class="inputbox" style="width:160px;" ' . '', 'value', 'text', '');
        }
        //Job Status *********************************************
        if ($sh_jobstatus == 1) {
            $query = "SELECT id, title FROM `#__js_job_jobstatus` WHERE isactive = 1 ORDER BY id ASC ";
            $db->setQuery($query);
            $rows = $db->loadObjectList();
            if (isset($rows)) {
                $jobstatus = array();
                $jobstatus[] = array('value' => JText::_(''), 'text' => JText::_('JS_SELECT_JOB_STATUS'));
                foreach ($rows as $row)
                    $jobstatus[] = array('value' => JText::_($row->id), 'text' => JText::_($row->title));
            }
            $job_status = JHTML::_('select.genericList', $jobstatus, 'jobstatus', 'class="inputbox" style="width:160px;" ' . '', 'value', 'text', '');
        }

        //Shifts *********************************************
        if ($sh_shift == 1) {
            $query = "SELECT id, title FROM `#__js_job_shifts` WHERE isactive = 1 ORDER BY id ASC ";
            $db->setQuery($query);
            $rows = $db->loadObjectList();
            if (isset($rows)) {
                $shifts = array();
                $shifts[] = array('value' => JText::_(''), 'text' => JText::_('JS_SELECT_JOB_SHIFT'));
                foreach ($rows as $row)
                    $shifts[] = array('value' => JText::_($row->id), 'text' => JText::_($row->title));
            }
            $search_shift = JHTML::_('select.genericList', $shifts, 'shift', 'class="inputbox" style="width:160px;" ' . '', 'value', 'text', '');
        }
        // Salary Rnage *********************************************
        if ($sh_salaryrange == 1) {
            $query = "SELECT * FROM `#__js_job_salaryrange` ORDER BY id ";
            $db->setQuery($query);
            $rows = $db->loadObjectList();
            if (isset($rows)) {
                $salaryrangefrom = array();
                $salaryrangeto = array();
                $salaryrangefrom[] = array('value' => JText::_(''), 'text' => JText::_('JS_FROM'));
                $salaryrangeto[] = array('value' => JText::_(''), 'text' => JText::_('JS_TO'));
                foreach ($rows as $row) {
                    //$salrange = $currency . $row->rangestart.' - '.$currency . $row->rangeend;
                    $salrange = $row->rangestart; //.' - '.$currency . $row->rangeend;
                    $salaryrangefrom[] = array('value' => JText::_($row->id), 'text' => JText::_($salrange));
                    $salaryrangeto[] = array('value' => JText::_($row->id), 'text' => JText::_($salrange));
                }
                $query = "SELECT id, title FROM `#__js_job_salaryrangetypes` WHERE status = 1 ORDER BY id ASC ";
                $db->setQuery($query);
                $rows = $db->loadObjectList();
                $types = array();
                foreach ($rows as $row) {
                    $types[] = array('value' => $row->id, 'text' => $row->title);
                }
            }
            $salaryrangefrom = JHTML::_('select.genericList', $salaryrangefrom, 'salaryrangefrom', 'class="inputbox" ' . 'style="width:40%;"', 'value', 'text', '');
            $salaryrangeto = JHTML::_('select.genericList', $salaryrangeto, 'salaryrangeto', 'class="inputbox" ' . 'style="width:40%;"', 'value', 'text', '');
            $salaryrangetypes = JHTML::_('select.genericList', $types, 'salaryrangetype', 'class="inputbox" ' . 'style="width:40%;"', 'value', 'text', 2);

            // get combo of currencies 
            $currencycombo = $this->getJSModel('currency')->getCurrencyCombo();
        }


        if (isset($js_dateformat))
            $result[0] = $js_dateformat;
        if (isset($currencycombo))
            $result[1] = $currencycombo;
        if (isset($job_categories))
            $result[2] = $job_categories;

        if (isset($search_companies))
            $result[3] = $search_companies;
        if (isset($job_type))
            $result[4] = $job_type;

        if (isset($job_status))
            $result[5] = $job_status;
        if (isset($search_shift))
            $result[6] = $search_shift;
        if (isset($salaryrangefrom))
            $result[7] = $salaryrangefrom;

        if (isset($salaryrangeto))
            $result[8] = $salaryrangeto;
        if (isset($salaryrangetypes))
            $result[9] = $salaryrangetypes;
        if (isset($job_subcategories))
            $result[10] = $job_subcategories;

        return $result;
    }

    function getHotJobs($noofjobs, $theme) {
        $db = JFactory::getDBO();
        $dateformat = $this->getJSModel('configurations')->getConfigValue('date_format');
        $data_directory = $this->getJSModel('configurations')->getConfigValue('data_directory');
        $this->getJSModel('common')->setTheme();
        $curdate = date('Y-m-d');
        if ($this->_client_auth_key != "") {
            $id = "job.serverid AS id";
            $alias = ",CONCAT(job.alias,'-',job.serverid) AS aliasid ";
            $companyaliasid = ", CONCAT(company.alias,'-',company.serverid) AS companyaliasid ";
        } else {
            $id = "job.id AS id";
            $alias = ",CONCAT(job.alias,'-',job.id) AS aliasid ";
            $companyaliasid = ", CONCAT(company.alias,'-',company.id) AS companyaliasid ";
        }
        $query = "SELECT COUNT(apply.jobid) as totalapply, $id, job.title, job.jobcategory, job.created, cat.cat_title
			, company.id AS companyid, company.name AS companyname, jobtype.title AS jobtypetitle,subcat.title AS subcat_title,company.logofilename AS companylogo
			$alias $companyaliasid
			
			FROM `#__js_job_jobs` AS job 
			JOIN `#__js_job_jobapply` AS apply ON job.id = apply.jobid 
			JOIN `#__js_job_categories` AS cat ON job.jobcategory = cat.id 
			LEFT JOIN `#__js_job_subcategories` AS subcat ON job.subcategoryid = subcat.id
			JOIN `#__js_job_jobtypes` AS jobtype ON job.jobtype = jobtype.id 
			LEFT JOIN `#__js_job_companies` AS company ON job.companyid = company.id 
			WHERE job.status = 1 AND DATE(job.startpublishing) <= " . $db->Quote($curdate) . " AND DATE(job.stoppublishing) >= " . $db->Quote($curdate) . "
			GROUP BY apply.jobid ORDER BY totalapply DESC LIMIT {$noofjobs}";
        //echo $query;
        $db->setQuery($query);
        $result[0] = $db->loadObjectList();
        $result[2] = $dateformat;
        $result[3] = $data_directory;
        return $result;
    }


    function getNewestJobs($noofjobs, $theme) {

        $db = JFactory::getDBO();
        $dateformat = $this->getJSModel('configurations')->getConfigValue('date_format');
        $data_directory = $this->getJSModel('configurations')->getConfigValue('data_directory');;
        $this->getJSModel('common')->setTheme();
        $curdate = date('Y-m-d');

        if ($this->_client_auth_key != "") {
            $id = "job.serverid AS id";
            $alias = ",CONCAT(job.alias,'-',job.serverid) AS aliasid ";
            $companyaliasid = ", CONCAT(company.alias,'-',company.serverid) AS companyaliasid ";
        } else {
            $id = "job.id AS id";
            $alias = ",CONCAT(job.alias,'-',job.id) AS aliasid ";
            $companyaliasid = ", CONCAT(company.alias,'-',company.id) AS companyaliasid ";
        }
        $query = "SELECT $id,job.title, job.jobcategory, job.created, cat.cat_title,subcat.title as subcat_title
			, company.id AS companyid, company.name AS companyname,company.logofilename AS companylogo, jobtype.title AS jobtypetitle
			$alias $companyaliasid
			 
			FROM `#__js_job_jobs` AS job 
			JOIN `#__js_job_categories` AS cat ON job.jobcategory = cat.id 
			JOIN `#__js_job_jobtypes` AS jobtype ON job.jobtype = jobtype.id 
			LEFT JOIN `#__js_job_subcategories` AS subcat ON job.subcategoryid = subcat.id 
			LEFT JOIN `#__js_job_companies` AS company ON job.companyid = company.id 
			WHERE job.status = 1 AND DATE(job.startpublishing) <= " . $db->Quote($curdate) . " AND DATE(job.stoppublishing) >= " . $db->Quote($curdate) . "
			ORDER BY created DESC LIMIT {$noofjobs}";
        $db->setQuery($query);
        $result[0] = $db->loadObjectList();
        $result[2] = $dateformat;
        $result[3] = $data_directory;
        return $result;
    }

    function getTopJobs($noofjobs, $theme) {
        $db = JFactory::getDBO();
        $dateformat = $this->getJSModel('configurations')->getConfigValue('date_format');
        $data_directory = $this->getJSModel('configurations')->getConfigValue('data_directory');
        $this->getJSModel('common')->setTheme();
        if ($this->_client_auth_key != "") {
            $id = "job.serverid AS id";
            $alias = ",CONCAT(job.alias,'-',job.serverid) AS aliasid ";
            $companyaliasid = ", CONCAT(company.alias,'-',company.serverid) AS companyaliasid ";
        } else {
            $id = "job.id AS id";
            $alias = ",CONCAT(job.alias,'-',job.id) AS aliasid ";
            $companyaliasid = ", CONCAT(company.alias,'-',company.id) AS companyaliasid ";
        }
        $curdate = date('Y-m-d');
        $query = "SELECT $id, job.title, job.jobcategory, job.created, cat.cat_title
			, company.id AS companyid, company.name AS companyname, jobtype.title AS jobtypetitle,company.logofilename AS companylogo 
			$alias $companyaliasid
			
			FROM `#__js_job_jobs` AS job 
			JOIN `#__js_job_categories` AS cat ON job.jobcategory = cat.id 
			JOIN `#__js_job_jobtypes` AS jobtype ON job.jobtype = jobtype.id 
			LEFT JOIN `#__js_job_companies` AS company ON job.companyid = company.id 
			WHERE job.status = 1 AND DATE(job.startpublishing) <= " . $db->Quote($curdate) . " AND DATE(job.stoppublishing) >= " . $db->Quote($curdate) . "
			ORDER BY job.hits DESC LIMIT {$noofjobs}";
        //echo $query;
        $db->setQuery($query);
        $result[0] = $db->loadObjectList();
        $result[2] = $dateformat;
        $result[3] = $data_directory;
        return $result;
    }

    function getJobSearch($uid, $title, $jobcategory, $jobsubcategory, $jobtype, $jobstatus, $currency, $salaryrangefrom, $salaryrangeto, $salaryrangetype, $shift, $experience, $durration, $startpublishing, $stoppublishing, $company, $city, $zipcode, $longitude, $latitude, $radius, $radius_length_type, $keywords, $sortby, $limit, $limitstart) {

        if (isset($uid))
            if (is_numeric($uid) == false)
                return false;
        if ($jobcategory != '')
            if (is_numeric($jobcategory) == false)
                return false;
        if ($jobsubcategory != '')
            if (is_numeric($jobsubcategory) == false)
                return false;
        if ($jobtype != '')
            if (is_numeric($jobtype) == false)
                return false;
        if ($jobstatus != '')
            if (is_numeric($jobstatus) == false)
                return false;
        if ($salaryrangefrom != '')
            if (is_numeric($salaryrangefrom) == false)
                return false;
        if ($salaryrangeto != '')
            if (is_numeric($salaryrangeto) == false)
                return false;
        if ($salaryrangetype != '')
            if (is_numeric($salaryrangetype) == false)
                return false;
        if ($shift != '')
            if (is_numeric($shift) == false)
                return false;
        if ($company != '')
            if (is_numeric($company) == false)
                return false;
        if ($currency != '')
            if (is_numeric($currency) == false)
                return false;
        if ($city != '')
            if (is_numeric($city) == false)
                return false;

        $db = $this->getDBO();
        if (!isset($this->_config)) {
            $this->_config = $this->getJSModel('configurations')->getConfig('');
        }
        foreach ($this->_config as $conf) {
            if ($conf->configname == 'filter_address_fields_width')
                $address_fields_width = $conf->configvalue;
            if ($conf->configname == 'date_format')
                $dateformat = $conf->configvalue;
        }

        if ($startpublishing != '') {
            if ($dateformat == 'm/d/Y') {
                $arr = explode('/', $startpublishing);
                $startpublishing = $arr[2] . '/' . $arr[0] . '/' . $arr[1];
            } elseif ($dateformat == 'd-m-Y') {
                $arr = explode('-', $startpublishing);
                $startpublishing = $arr[2] . '-' . $arr[1] . '-' . $arr[0];
            }
            $startpublishing = date('Y-m-d', strtotime($startpublishing));
        }
        if ($stoppublishing != '') {
            if ($dateformat == 'm/d/Y') {
                $arr = explode('/', $stoppublishing);
                $stoppublishing = $arr[2] . '/' . $arr[0] . '/' . $arr[1];
            } elseif ($dateformat == 'd-m-Y') {
                $arr = explode('-', $stoppublishing);
                $stoppublishing = $arr[2] . '-' . $arr[1] . '-' . $arr[0];
            }
            $stoppublishing = date('Y-m-d', strtotime($stoppublishing));
        }
        if ($uid) {
            foreach ($this->_config as $conf) {
                if ($conf->configname == 'js_newlisting_requiredpackage')
                    $newlisting_required_package = $conf->configvalue;
            }
            if ($newlisting_required_package == 0) {
                $canview = 1;
            } else {
                $query = "SELECT package.savejobsearch, package.packageexpireindays, payment.created
                            FROM `#__js_job_jobseekerpackages` AS package
                            JOIN `#__js_job_paymenthistory` AS payment ON (payment.packageid = package.id AND payment.packagefor=2)
                            WHERE payment.uid = " . $uid . "
                            AND DATE_ADD(payment.created,INTERVAL package.packageexpireindays DAY) >= CURDATE()
                            AND payment.transactionverified = 1 AND payment.status = 1";
                //echo $query;
                $db->setQuery($query);
                $jobs = $db->loadObjectList();
                $canview = 0;

                foreach ($jobs AS $job) {
                    if ($job->savejobsearch == 1) {
                        $canview = 1;
                        break;
                    }
                    else
                        $canview = 0;
                }
            }
        }
        else
            $canview = 1; // visitor case

        $result = array();
        $searchjobconfig = $this->getJSModel('configurations')->getConfigByFor('searchjob');
        $listjobconfig = $this->getJSModel('configurations')->getConfigByFor('listjob');
        //for radius search
        switch ($radius_length_type) {
            case "m":$radiuslength = 6378137;
                break;
            case "km":$radiuslength = 6378.137;
                break;
            case "mile":$radiuslength = 3963.191;
                break;
            case "nacmiles":$radiuslength = 3441.596;
                break;
        }
        if ($this->_client_auth_key != "") {
            if ($keywords) {// For keyword Search
                $keywords = explode(' ', $keywords);
                $length = count($keywords);
                if ($length <= 5) {// For Limit keywords to 5
                    $i = $length;
                } else {
                    $i = 5;
                }
                for ($j = 0; $j < $i; $j++) {
                    $keys[] = " t.metakeywords Like '%$keywords[$j]%'";
                }
            }
            if ($title != '') {
                $title_keywords = explode(' ', $title);
                $tlength = count($title_keywords);
                if ($tlength <= 5) {// For Limit keywords to 5
                    $r = $tlength;
                } else {
                    $r = 5;
                }
                for ($k = 0; $k < $r; $k++) {
                    $titlekeys[] = " t.title LIKE '%" . str_replace("'", "", $db->Quote($title_keywords[$k])) . "%'";
                }
            }

            $selectdistance = " ";
            if ($longitude != '' && $latitude != '' && $radius != '') {
                $radiussearch = " acos((SIN( PI()* $latitude /180 )*SIN( PI()*t.latitude/180 ))+(cos(PI()* $latitude /180)*COS( PI()*t.latitude/180) *COS(PI()*t.longitude/180-PI()* $longitude /180)))* $radiuslength <= $radius";
                $selectdistance = " ,acos((sin(PI()*$latitude/180)*sin(PI()*t.latitude/180))+(cos(PI()*$latitude/180)*cos(PI()*t.latitude/180)*cose(PI()*t.longitude/180 - PI()*$longitude/180)))*$radiuslength AS distance ";
            }
            $wherequery = '';
            $issalary = '';
            if ($jobcategory != '') {
                $sj_serverjobcategory = $this->getJSModel('common')->getServerid('categories', $jobcategory);
                $wherequery .= " AND t.jobcategory = " . $sj_serverjobcategory;
            }
            if (isset($keys))
                $wherequery .= " AND ( " . implode(' OR ', $keys) . " )";
            if (isset($titlekeys))
                $wherequery .= " AND ( " . implode(' OR ', $titlekeys) . " )";
            if ($jobsubcategory != '') {
                $sj_serverjobsubcategory = $this->getJSModel('common')->getServerid('subcategories', $jobsubcategory);
                $wherequery .= " AND t.subcategoryid = " . $sj_serverjobsubcategory;
            }
            if ($jobtype != '') {
                $sj_serverjobtype = $this->getJSModel('common')->getServerid('jobtypes', $jobtype);
                $wherequery .= " AND t.jobtype = " . $sj_serverjobtype;
            }
            if ($jobstatus != '') {
                $sj_serverjobstatus = $this->getJSModel('common')->getServerid('jobstatus', $jobstatus);
                $wherequery .= " AND t.jobstatus = " . $sj_serverjobstatus;
            }
            if ($salaryrangefrom != '') {
                $query = "SELECT salfrom.rangestart
                    FROM `#__js_job_salaryrange` AS salfrom
                    WHERE salfrom.id = " . $salaryrangefrom;
                $db->setQuery($query);
                $sj_rangestart_value = $db->loadResult();
                $wherequery .= " AND job_salrangefrom.rangestart >= " . $sj_rangestart_value;
                $issalary = 1;
            }
            if ($salaryrangeto != '') {
                $query = "SELECT salto.rangestart
                    FROM `#__js_job_salaryrange` AS salto
                    WHERE salto.id = " . $salaryrangeto;
                $db->setQuery($query);
                $sj_rangeend_value = $db->loadResult();
                $wherequery .= " AND job_salrangeto.rangeend <= " . $sj_rangeend_value;
                $issalary = 1;
            }
            if (($issalary != '') && ($salaryrangetype != '')) {
                $sj_serverjobsalaryrangetype = $this->getJSModel('common')->getServerid('salaryrangetypes', $salaryrangetype);
                $wherequery .= " AND t.salaryrangetype = " . $sj_serverjobsalaryrangetype;
            }
            if ($shift != '') {
                $sj_serverjobshifts = $this->getJSModel('common')->getServerid('shifts', $shift);
                $wherequery .= " AND t.shift = " . $sj_serverjobshifts;
            }
            if ($experience != '') {
                $wherequery .= " AND t.experience LIKE " . $experience;
            }
            if ($durration != '')
                $wherequery .= " AND t.duration LIKE " . $db->Quote($durration);
            if ($startpublishing != '')
                $wherequery .= " AND t.startpublishing >= " . $db->Quote($startpublishing);
            if ($stoppublishing != '')
                $wherequery .= " AND t.stoppublishing <= " . $db->Quote($stoppublishing);
            if ($company != '') {
                $query = "SELECT company.serverid
                    FROM `#__js_job_companies` AS company
                    WHERE company.id = " . $company;
                $db->setQuery($query);
                $sj_serverjobcompany = $db->loadResult();
                $wherequery .= " AND t.companyid = " . $sj_serverjobcompany;
            }

            $server_address = "";
            if ($city != '') {
                $city_value = explode(',', $city);
                $server_city_id = array();
                $lenght = count($city_value);
                //echo '<br> lenght'.$lenght;
                for ($i = 0; $i < $lenght; $i++) {
                    $server_city_id[$i] = $this->getJSModel('common')->getServerid('cities', $city_value[$i]);
                    if ($i == 0)
                        $server_address .= " AND ( job_jobcities.cityid=" . $server_city_id[$i];
                    else
                        $server_address .= " OR job_jobcities.cityid=" . $server_city_id[$i];
                }
                $server_address .= ") AND job_jobcities.jobid=t.id ";
            }
            if ($currency != '') {
                $sj_servercurrency = $this->getJSModel('common')->getServerid('currencies', $currency);
                $wherequery .= " AND t.currencyid = " . $sj_servercurrency;
            }
            if ($zipcode != '')
                $wherequery .= " AND t.zipcode = " . $db->Quote($zipcode);
            if (isset($radiussearch) && $radiussearch != '')
                $wherequery .= " AND $radiussearch";
            $fortask = "getjobsearch";
            $jsjobsharingobject = $this->getJSModel('jobsharingsite');
            $data['limitstart'] = $limitstart;
            $data['limit'] = $limit;
            $data['sortby'] = $sortby;
            $data['wherequery'] = $wherequery;
            $data['server_address'] = $server_address;
            $data['authkey'] = $this->_client_auth_key;
            $data['siteurl'] = $this->_siteurl;
            $encodedata = json_encode($data);
            $return_server_value = $jsjobsharingobject->serverTask($encodedata, $fortask);
            if (isset($return_server_value['jobsearch']) AND $return_server_value['jobsearch'] == -1) { // auth fail 
                $logarray['uid'] = $this->_uid;
                $logarray['referenceid'] = $return_server_value['referenceid'];
                $logarray['eventtype'] = $return_server_value['eventtype'];
                $logarray['message'] = $return_server_value['message'];
                $logarray['event'] = "Search Job";
                $logarray['messagetype'] = "Error";
                $logarray['datetime'] = date('Y-m-d H:i:s');
                $jsjobsharingobject->write_JobSharingLog($logarray);
                $this->_applications = (object) array();
                $total = 0;
            } else {
                $s_search_result = array();
                foreach ($return_server_value['searchjob'] AS $search_job) {
                    $s_search_result[] = (object) $search_job;
                }
                $this->_applications = $s_search_result;
                $total = $return_server_value['total'];
            }
        } else {
            if ($keywords) {// For keyword Search
                $keywords = explode(' ', $keywords);
                $length = count($keywords);
                if ($length <= 5) {// For Limit keywords to 5
                    $i = $length;
                } else {
                    $i = 5;
                }
                for ($j = 0; $j < $i; $j++) {
                    $keys[] = " job.metakeywords Like '%$keywords[$j]%'";
                }
            }
            $selectdistance = " ";
            if ($longitude != '' && $latitude != '' && $radius != '') {
                $radiussearch = " acos((SIN( PI()* $latitude /180 )*SIN( PI()*job.latitude/180 ))+(cos(PI()* $latitude /180)*COS( PI()*job.latitude/180) *COS(PI()*job.longitude/180-PI()* $longitude /180)))* $radiuslength <= $radius";
                $selectdistance = " ,acos((sin(PI()*$latitude/180)*sin(PI()*job.latitude/180))+(cos(PI()*$latitude/180)*cos(PI()*job.latitude/180)*cose(PI()*job.longitude/180 - PI()*$longitude/180)))*$radiuslength AS distance ";
            }
            $wherequery = '';
            $issalary = '';

            if ($title != '') {
                $title_keywords = explode(' ', $title);
                $tlength = count($title_keywords);
                if ($tlength <= 5) {// For Limit keywords to 5
                    $r = $tlength;
                } else {
                    $r = 5;
                }
                for ($k = 0; $k < $r; $k++) {
                    $titlekeys[] = " job.title LIKE '%" . str_replace("'", "", $db->Quote($title_keywords[$k])) . "%'";
                }
            }
            if ($jobcategory != '')
                $wherequery .= " AND job.jobcategory = " . $jobcategory;
            if (isset($keys))
                $wherequery .= " AND ( " . implode(' OR ', $keys) . " )";
            if (isset($titlekeys))
                $wherequery .= " AND ( " . implode(' OR ', $titlekeys) . " )";
            if ($jobsubcategory != '')
                $wherequery .= " AND job.subcategoryid = " . $jobsubcategory;
            if ($jobtype != '')
                $wherequery .= " AND job.jobtype = " . $jobtype;
            if ($jobstatus != '')
                $wherequery .= " AND job.jobstatus = " . $jobstatus;
            if ($salaryrangefrom != '') {
                $query = "SELECT salfrom.rangestart FROM `#__js_job_salaryrange` AS salfrom WHERE salfrom.id = " . $salaryrangefrom;
                $db->setQuery($query);
                $rangestart_value = $db->loadResult();
                $wherequery .= " AND salaryrangefrom.rangestart >= " . $rangestart_value;
                $issalary = 1;
            }
            if ($salaryrangeto != '') {
                $query = "SELECT salto.rangestart FROM `#__js_job_salaryrange` AS salto WHERE salto.id = " . $salaryrangeto;
                $db->setQuery($query);
                $rangeend_value = $db->loadResult();
                $wherequery .= " AND salaryrangeto.rangeend <= " . $rangeend_value;
                $issalary = 1;
            }
            if (($issalary != '') && ($salaryrangetype != '')) {
                $wherequery .= " AND job.salaryrangetype = " . $salaryrangetype;
            }
            if ($shift != '')
                $wherequery .= " AND job.shift = " . $shift;
            if ($experience != '')
                $wherequery .= " AND job.experience LIKE " . $db->Quote($experience);
            if ($durration != '')
                $wherequery .= " AND job.duration LIKE " . $db->Quote($durration);
            if ($startpublishing != '')
                $wherequery .= " AND job.startpublishing >= " . $db->Quote($startpublishing);
            if ($stoppublishing != '')
                $wherequery .= " AND job.stoppublishing <= " . $db->Quote($stoppublishing);
            if ($company != '')
                $wherequery .= " AND job.companyid = " . $company;
            if ($city != '') {
                $city_value = explode(',', $city);
                $lenght = count($city_value);
                for ($i = 0; $i < $lenght; $i++) {
                    if ($i == 0)
                        $wherequery .= " AND ( mjob.cityid=" . $city_value[$i];
                    else
                        $wherequery .= " OR mjob.cityid=" . $city_value[$i];
                }
                $wherequery .= ")";
            }
            if ($zipcode != '')
                $wherequery .= " AND job.zipcode = " . $db->Quote($zipcode);
            if (isset($radiussearch) && $radiussearch != '')
                $wherequery .= " AND $radiussearch";
            $curdate = date('Y-m-d H:i:s');
            $query = "SELECT count(DISTINCT job.id) FROM `#__js_job_jobs` AS job 
					  JOIN `#__js_job_categories` AS cat ON job.jobcategory = cat.id
					  LEFT JOIN `#__js_job_salaryrange` AS salaryrangefrom ON job.salaryrangefrom = salaryrangefrom.id
					  LEFT JOIN `#__js_job_salaryrange` AS salaryrangeto ON job.salaryrangeto = salaryrangeto.id";
            $query .= " LEFT JOIN `#__js_job_jobcities` AS mjob ON mjob.jobid = job.id ";
            $query .= "	WHERE job.status = 1 ";
            if ($startpublishing == '')
                $query .= " AND job.startpublishing <= " . $db->Quote($curdate);
            if ($stoppublishing == '')
                $query .= " AND job.stoppublishing >= " . $db->Quote($curdate);

            $query .= $wherequery;
            $db->setQuery($query);
            $total = $db->loadResult();
            if ($total <= $limitstart)
                $limitstart = 0;
            $query = "SELECT DISTINCT job.*, cat.cat_title, jobtype.title AS jobtypetitle, jobstatus.title AS jobstatustitle
                        , salaryrangefrom.rangestart AS salaryfrom, salaryrangeto.rangestart AS salaryend, salaryrangeto.rangestart AS salaryto
                        ,company.id AS companyid, company.name AS companyname, company.url, salaryrangetype.title AS salaytype";
            $query .= " ,(TO_DAYS( CURDATE() ) - To_days( job.startpublishing ) ) AS jobdays";
            $query .= " ,CONCAT(job.alias,'-',job.id) AS jobaliasid";
            $query .= " ,CONCAT(company.alias,'-',companyid) AS companyaliasid";
            $query .= " ,currency.symbol AS symbol";
            $query .= " ,company.logofilename AS companylogo";

            $query .= "	FROM `#__js_job_jobs` AS job
                        JOIN `#__js_job_categories` AS cat ON job.jobcategory = cat.id
                        JOIN `#__js_job_jobtypes` AS jobtype ON job.jobtype = jobtype.id
                        LEFT JOIN `#__js_job_jobstatus` AS jobstatus ON job.jobstatus = jobstatus.id
                        LEFT JOIN `#__js_job_companies` AS company ON job.companyid = company.id
                        LEFT JOIN `#__js_job_countries` AS country ON job.country = country.id
                        LEFT JOIN `#__js_job_salaryrange` AS salaryrangefrom ON job.salaryrangefrom = salaryrangefrom.id
                        LEFT JOIN `#__js_job_salaryrange` AS salaryrangeto ON job.salaryrangeto = salaryrangeto.id
                        LEFT JOIN `#__js_job_salaryrangetypes` AS salaryrangetype ON job.salaryrangetype = salaryrangetype.id";
            $query .= " LEFT JOIN `#__js_job_jobcities` AS mjob ON mjob.jobid = job.id ";
            $query .= " LEFT JOIN `#__js_job_currencies` AS currency ON currency.id = job.currencyid ";

            $query .= " WHERE job.status = 1";
            if ($startpublishing == '')
                $query .= " AND job.startpublishing <= " . $db->Quote($curdate);
            if ($stoppublishing == '')
                $query .= " AND job.stoppublishing >= " . $db->Quote($curdate);
            if ($currency != '')
                $query .= " AND job.currencyid = " . $currency;
            $query .= $wherequery;
            $query .= " ORDER BY  " . $sortby;
            $db->setQuery($query, $limitstart, $limit);
            $this->_applications = $db->loadObjectList();
            foreach ($this->_applications AS $searchdata) {  // for multicity select 
                $multicitydata = $this->getMultiCityData($searchdata->id);
                if ($multicitydata != "")
                    $searchdata->city = $multicitydata;
            }
        }
        $curdate = date('Y-m-d H:i:s');



        $packageexpiry = $this->getJSModel('purchasehistory')->getJobSeekerPackageExpiry($uid);
        if ($packageexpiry == 1) { //package expire or user not login
            $listjobconfigs = array();
            $listjobconfigs['lj_title'] = $listjobconfig['visitor_lj_title'];
            $listjobconfigs['lj_category'] = $listjobconfig['visitor_lj_category'];
            $listjobconfigs['lj_jobtype'] = $listjobconfig['visitor_lj_jobtype'];
            $listjobconfigs['lj_jobstatus'] = $listjobconfig['visitor_lj_jobstatus'];
            $listjobconfigs['lj_company'] = $listjobconfig['visitor_lj_company'];
            $listjobconfigs['lj_companysite'] = $listjobconfig['visitor_lj_companysite'];
            $listjobconfigs['lj_country'] = $listjobconfig['visitor_lj_country'];
            $listjobconfigs['lj_state'] = $listjobconfig['visitor_lj_state'];
            $listjobconfigs['lj_city'] = $listjobconfig['visitor_lj_city'];
            $listjobconfigs['lj_salary'] = $listjobconfig['visitor_lj_salary'];
            $listjobconfigs['lj_created'] = $listjobconfig['visitor_lj_created'];
            $listjobconfigs['lj_noofjobs'] = $listjobconfig['visitor_lj_noofjobs'];
            $listjobconfigs['lj_description'] = $listjobconfig['visitor_lj_description'];
            $listjobconfigs['lj_shortdescriptionlenght'] = $listjobconfig['lj_shortdescriptionlenght'];
            $listjobconfigs['lj_joblistingstyle'] = $listjobconfig['lj_joblistingstyle'];
        }
        else
            $listjobconfigs = $listjobconfig; // user

        $result[0] = $this->_applications;
        $result[1] = $total;
        $result[2] = $listjobconfigs;
        $result[3] = $searchjobconfig;
        $result[4] = $canview;

        return $result;
    }

    function getActiveJobsByCompany($uid, $companyid, $city_filter, $cmbfiltercountry, $filterjobcategory, $filterjobsubcategory, $filterjobtype, $sortby, $txtfilterlongitude, $txtfilterlatitude, $txtfilterradius, $cmbfilterradiustype, $limit, $limitstart) {
        $db = $this->getDBO();
        $result = array();
        if (is_numeric($companyid) == false)
            return false;
        if ($filterjobcategory != '')
            if (is_numeric($filterjobcategory) == false)
                return false;
        if ($filterjobtype != '')
            if (is_numeric($filterjobtype) == false)
                return false;

        if (!isset($this->_config)) {
            $this->_config = $this->getJSModel('configurations')->getConfig('');
        }
        foreach ($this->_config as $conf) {
            if ($conf->configname == 'filter_address_fields_width')
                $address_fields_width = $conf->configvalue;
            if ($conf->configname == 'filter_cat_jobtype_fields_width')
                $cat_jobtype_fields_width = $conf->configvalue;
        }
        $listjobconfig = $this->getJSModel('configurations')->getConfigByFor('listjob');
        //for radius search
        switch ($cmbfilterradiustype) {
            case "m":$radiuslength = 6378137;
                break;
            case "km":$radiuslength = 6378.137;
                break;
            case "mile":$radiuslength = 3963.191;
                break;
            case "nacmiles":$radiuslength = 3441.596;
                break;
        }
        if ($this->_client_auth_key != "") {

            $selectdistance = " ";
            if ($txtfilterlongitude != '' && $txtfilterlatitude != '' && $txtfilterradius != '') {
                $radiussearch = " acos((SIN( PI()* $txtfilterlatitude /180 )*SIN( PI()*t.latitude/180 ))+(cos(PI()* $txtfilterlatitude /180)*COS( PI()*t.latitude/180) *COS(PI()*t.longitude/180-PI()* $txtfilterlongitude /180)))* $radiuslength <= $txtfilterradius";
            }

            $wherequery = '';
            $server_address = array();
            if ($city_filter != '') {
                $server_citiy_id = $this->getJSModel('common')->getServerid('cities', $city_filter);
                $server_address['multicityid'] = $server_citiy_id;
                $server_country_id = $this->getJSModel('jobsharingsite')->getSeverCountryid($city_filter);
                if ($server_country_id == false)
                    $cmbfiltercountry = '';
                else
                    $cmbfiltercountry = $server_country_id;
            }else {
                $default_sharing_loc = $this->getJSModel('configurations')->getDefaultSharingLocation($server_address, $cmbfiltercountry);
                if (isset($default_sharing_loc['defaultsharingcity']) AND ($default_sharing_loc['defaultsharingcity'] != '')) {
                    $city_filter = $default_sharing_loc['defaultsharingcity'];
                    $server_address['multicityid'] = $default_sharing_loc['defaultsharingcity'];
                } elseif (isset($default_sharing_loc['defaultsharingstate']) AND ($default_sharing_loc['defaultsharingstate'] != '')) {
                    $server_address['defaultsharingstate'] = $default_sharing_loc['defaultsharingstate'];
                } elseif (isset($default_sharing_loc['filtersharingcountry']) AND ($default_sharing_loc['filtersharingcountry'] != '')) {
                    $server_address['filtersharingcountry'] = $default_sharing_loc['filtersharingcountry'];
                    $cmbfiltercountry = $default_sharing_loc['filtersharingcountry'];
                } elseif (isset($default_sharing_loc['defaultsharingcountry']) AND ($default_sharing_loc['defaultsharingcountry'] != '')) {
                    $server_address['defaultsharingcountry'] = $default_sharing_loc['defaultsharingcountry'];
                    $cmbfiltercountry = $default_sharing_loc['defaultsharingcountry'];
                }
            }

            if ($filterjobtype != '') {
                $serverjobtype = $this->getJSModel('common')->getServerid('jobtypes', $filterjobtype);
                $wherequery .= " AND t.jobtype = " . $serverjobtype;
            }
            if ($filterjobcategory != '') {
                $serverjobcategory = $this->getJSModel('common')->getServerid('categories', $filterjobcategory);
                $wherequery .= " AND t.jobcategory = " . $serverjobcategory;
            }
            if ($filterjobsubcategory != '') {
                $serverjobsubcategory = $this->getJSModel('common')->getServerid('subcategories', $filterjobsubcategory);
                $wherequery .= " AND t.subcategoryid = " . $serverjobsubcategory;
            }
            if (isset($radiussearch))
                $wherequery .= " AND $radiussearch";

            $fortask = "getactivejobsbycompany";
            $jsjobsharingobject = $this->getJSModel('jobsharingsite');
            $data['sortby'] = $sortby;
            $data['companyid'] = $companyid;
            $data['limitstart'] = $limitstart;
            $data['limit'] = $limit;
            $data['wherequery'] = $wherequery;
            $data['server_address'] = $server_address;
            $data['authkey'] = $this->_client_auth_key;
            $data['siteurl'] = $this->_siteurl;
            $encodedata = json_encode($data);
            $return_server_value = $jsjobsharingobject->serverTask($encodedata, $fortask);
            if (isset($return_server_value['activejobsbycompany']) AND $return_server_value['activejobsbycompany'] == -1) { // auth fail 
                $logarray['uid'] = $this->_uid;
                $logarray['referenceid'] = $return_server_value['referenceid'];
                $logarray['eventtype'] = $return_server_value['eventtype'];
                $logarray['message'] = $return_server_value['message'];
                $logarray['event'] = "Jobs By Company";
                $logarray['messagetype'] = "Error";
                $logarray['datetime'] = date('Y-m-d H:i:s');
                $jsjobsharingobject->write_JobSharingLog($logarray);
                $this->_applications = (object) array();
                $total = 0;
            } else {
                $parsedata = array();
                foreach ($return_server_value['jobsbycompany'] AS $data) {
                    $parsedata[] = (object) $data;
                }
                $this->_applications = $parsedata;
                $total = $return_server_value['total'];
            }
        } else {
            $selectdistance = " ";
            if ($txtfilterlongitude != '' && $txtfilterlatitude != '' && $txtfilterradius != '') {
                $radiussearch = " acos((SIN( PI()* $txtfilterlatitude /180 )*SIN( PI()*job.latitude/180 ))+(cos(PI()* $txtfilterlatitude /180)*COS( PI()*job.latitude/180) *COS(PI()*job.longitude/180-PI()* $txtfilterlongitude /180)))* $radiuslength <= $txtfilterradius";
            }
            $wherequery = '';
            if ($city_filter != '')
                $wherequery .= " AND mcity.cityid = " . $city_filter;
            if ($filterjobcategory != '')
                $wherequery .= " AND job.jobcategory = " . $filterjobcategory;
            if ($filterjobsubcategory != '')
                $wherequery .= " AND job.subcategoryid = " . $filterjobsubcategory;
            if ($filterjobtype != '')
                $wherequery .= " AND job.jobtype = " . $filterjobtype;
            if (isset($radiussearch))
                $wherequery .= " AND $radiussearch";

            $curdate = date('Y-m-d H:i:s');



            $query = "SELECT COUNT(job.id) FROM `#__js_job_jobs` AS job
                        JOIN `#__js_job_categories` AS cat ON job.jobcategory = cat.id
                        LEFT JOIN `#__js_job_jobcities` AS mcity ON job.id = mcity.jobid
                        WHERE job.jobcategory  = cat.id AND job.status = 1  AND job.companyid = " . $companyid . " 
                        AND job.startpublishing <= " . $db->Quote($curdate) . " AND job.stoppublishing >= " . $db->Quote($curdate);
            $query .= $wherequery;
            $db->setQuery($query);
            $total = $db->loadResult();

            if ($total <= $limitstart)
                $limitstart = 0;
            $query = "SELECT DISTINCT job.*, cat.cat_title, company.name AS companyname, company.url, jobtype.title AS jobtype, jobstatus.title AS jobstatus
                        , salary.rangestart AS salaryfrom, salary.rangeend, salary.rangestart AS salaryto				
                        ,(TO_DAYS( CURDATE() ) - To_days( job.startpublishing ) ) AS jobdays
                        ,CONCAT(company.alias,'-',company.id) AS aliasid
                        ,CONCAT(job.alias,'-',job.id) AS jobaliasid
                        ,cur.symbol
                        ,CONCAT(company.alias,'-',company.id) AS companyaliasid
                        , salarytype.title AS salaytype
                        FROM `#__js_job_jobs` AS job
                        JOIN `#__js_job_categories` AS cat ON job.jobcategory = cat.id
                        JOIN `#__js_job_companies` AS company ON job.companyid = company.id
                        JOIN `#__js_job_jobtypes` AS jobtype ON job.jobtype = jobtype.id
                        LEFT JOIN `#__js_job_jobstatus` AS jobstatus ON job.jobstatus = jobstatus.id
                        LEFT JOIN `#__js_job_jobcities` AS mcity ON job.id = mcity.jobid
                        LEFT JOIN `#__js_job_salaryrange` AS salary ON job.jobsalaryrange = salary.id 
                        LEFT JOIN `#__js_job_salaryrangetypes` AS salarytype ON job.salaryrangetype = salarytype.id
                        LEFT JOIN `#__js_job_currencies` AS cur ON cur.id = job.currencyid 
                        WHERE job.jobcategory = cat.id AND job.status = 1  AND job.companyid = " . $companyid . " 
                        AND job.startpublishing <= " . $db->Quote($curdate) . " AND job.stoppublishing >= " . $db->Quote($curdate);

            $query .= $wherequery . " ORDER BY  " . $sortby;
            $db->setQuery($query, $limitstart, $limit);
            $this->_applications = $db->loadObjectList();
            foreach ($this->_applications AS $jobdata) {   // for multicity select 
                $multicitydata = $this->getMultiCityData($jobdata->id);
                if ($multicitydata != "")
                    $jobdata->city = $multicitydata;
            }
        }

        $jobtype = $this->getJSModel('jobtype')->getJobType(JText::_('JS_SELECT_JOB_TYPE'));
        $jobstatus = $this->getJSModel('jobstatus')->getJobStatus(JText::_('JS_SELECT_JOB_STATUS'));

        $job_categories = $this->getJSModel('category')->getCategories(JText::_('JS_SELECT_CATEGORY'));
        if ($filterjobcategory == '')
            $categoryid = 1;
        else
            $categoryid = $filterjobcategory;
        $job_subcategories = $this->getJSModel('subcategory')->getSubCategoriesforCombo($categoryid, JText::_('JS_SELECT_CATEGORY'), $value = '');
        $countries = $this->getJSModel('server')->getSharingCountries(JText::_('JS_SELECT_COUNTRY'));

        $filterlists['country'] = JHTML::_('select.genericList', $countries, 'cmbfilter_country', 'class="inputbox"  style="width:' . $address_fields_width . 'px;" ' . '', 'value', 'text', $cmbfiltercountry);
        $filterlists['jobcategory'] = JHTML::_('select.genericList', $job_categories, 'filter_jobcategory', 'class="inputbox" style="width:' . $cat_jobtype_fields_width . 'px;" ' . 'onChange=fj_getsubcategories(\'td_jobsubcategory\',this.value);', 'value', 'text', $filterjobcategory);
        $filterlists['jobsubcategory'] = JHTML::_('select.genericList', $job_subcategories, 'filter_jobsubcategory', 'class="inputbox" style="width:' . $cat_jobtype_fields_width . 'px;"' . '', 'value', 'text', $filterjobsubcategory);
        $filterlists['jobtype'] = JHTML::_('select.genericList', $jobtype, 'filter_jobtype', 'class="inputbox" style="width:' . $cat_jobtype_fields_width . 'px;"' . '', 'value', 'text', $filterjobtype);

        $location = $this->getJSModel('cities')->getAddressDataByCityName('', $city_filter);
        if (isset($location[0]->name))
            $filtervalues['location'] = $location[0]->name;
        else
            $filtervalues['location'] = "";


        $filtervalues['city'] = $city_filter;
        $filtervalues['radius'] = $txtfilterradius;
        $filtervalues['longitude'] = $txtfilterlongitude;
        $filtervalues['latitude'] = $txtfilterlatitude;

        $packageexpiry = $this->getJSModel('purchasehistory')->getJobSeekerPackageExpiry($uid);
        if ($packageexpiry == 1) { //package expire or user not login
            $listjobconfigs = array();
            $listjobconfigs['lj_title'] = $listjobconfig['visitor_lj_title'];
            $listjobconfigs['lj_category'] = $listjobconfig['visitor_lj_category'];
            $listjobconfigs['lj_jobtype'] = $listjobconfig['visitor_lj_jobtype'];
            $listjobconfigs['lj_jobstatus'] = $listjobconfig['visitor_lj_jobstatus'];
            $listjobconfigs['lj_company'] = $listjobconfig['visitor_lj_company'];
            $listjobconfigs['lj_companysite'] = $listjobconfig['visitor_lj_companysite'];
            $listjobconfigs['lj_country'] = $listjobconfig['visitor_lj_country'];
            $listjobconfigs['lj_state'] = $listjobconfig['visitor_lj_state'];
            $listjobconfigs['lj_county'] = $listjobconfig['visitor_lj_county'];
            $listjobconfigs['lj_city'] = $listjobconfig['visitor_lj_city'];
            $listjobconfigs['lj_salary'] = $listjobconfig['visitor_lj_salary'];
            $listjobconfigs['lj_created'] = $listjobconfig['visitor_lj_created'];
            $listjobconfigs['lj_noofjobs'] = $listjobconfig['visitor_lj_noofjobs'];
        }
        else
            $listjobconfigs = $listjobconfig; // user

        $result[0] = $this->_applications;
        $result[1] = $total;
        $result[2] = $filterlists;
        $result[3] = $filtervalues;
        $result[4] = $listjobconfigs;

        return $result;
    }

    function getJobCat() {
        $db = $this->getDBO();
        if (!isset($this->_config)) {
            $this->_config = $this->getJSModel('configurations')->getConfig('');
        }
        foreach ($this->_config as $conf) {
            if ($conf->configname == 'filter_address_fields_width')
                $address_fields_width = $conf->configvalue;
            if ($conf->configname == 'defaultcountry')
                $defaultcountry = $conf->configvalue;
            if ($conf->configname == 'hidecountry')
                $hidecountry = $conf->configvalue;
        }
        if ($this->_client_auth_key != "") {
            $wherequery = "";
            $server_address = "";
            $fortask = "listjobsbycategory";
            $jsjobsharingobject = $this->getJSModel('jobsharingsite');
            $data['wherequery'] = $wherequery;
            $data['server_address'] = $server_address;
            $data['authkey'] = $this->_client_auth_key;
            $data['siteurl'] = $this->_siteurl;
            $encodedata = json_encode($data);
            $return_server_value = $jsjobsharingobject->serverTask($encodedata, $fortask);
            if (isset($return_server_value['jobsbycategory']) AND $return_server_value['jobsbycategory'] == -1) { // auth fail 
                $logarray['uid'] = $this->_uid;
                $logarray['referenceid'] = $return_server_value['referenceid'];
                $logarray['eventtype'] = $return_server_value['eventtype'];
                $logarray['message'] = $return_server_value['message'];
                $logarray['event'] = "List Jobs By Category";
                $logarray['messagetype'] = "Error";
                $logarray['datetime'] = date('Y-m-d H:i:s');
                $jsjobsharingobject->write_JobSharingLog($logarray);
                $this->_applications = array();
            } else {
                $parse_data = array();
                foreach ($return_server_value['listjobbycategory'] AS $data) {
                    $parse_data[] = (object) $data;
                }
                $this->_applications = $parse_data;
            }
        } else {
            $wherequery = '';
            $curdate = date('Y-m-d H:i:s');
            $inquery = " (SELECT COUNT(job.id) from `#__js_job_jobs`  AS job WHERE cat.id = job.jobcategory AND job.status = 1 AND job.startpublishing <= " . $db->Quote($curdate) . " AND job.stoppublishing >= " . $db->Quote($curdate);
            $inquery .= $wherequery . " ) as catinjobs";

            $query = "SELECT  DISTINCT cat.id, cat.cat_title,CONCAT(cat.alias,'-',cat.id) AS categoryaliasid, ";
            $query .= $inquery;
            $query .= " FROM `#__js_job_categories` AS cat 
						LEFT JOIN `#__js_job_jobs` AS job ON cat.id = job.jobcategory
						WHERE cat.isactive = 1 ";
            $query .= " ORDER BY cat.cat_title ";
            //echo $query;
            $db->setQuery($query);
            $this->_applications = $db->loadObjectList();
        }
        $filterlists = "";
        $filtervalues = "";

        $result[0] = $this->_applications;
        $result[1] = '';
        $result[2] = $filterlists;
        $result[3] = $filtervalues;

        return $result;
    }

    function getMyJobsForCombo($uid, $title) {
        if (!is_numeric($uid))
            return $uid;
        $db = JFactory::getDBO();
        $query = "SELECT  id, title FROM `#__js_job_jobs` WHERE jobstatus = 1 AND uid = " . $uid . " ORDER BY title ASC ";
        $db->setQuery($query);
        $rows = $db->loadObjectList();
        if ($db->getErrorNum()) {
            echo $db->stderr();
            return false;
        }
        $jobs = array();
        if ($title)
            $jobs[] = array('value' => JText::_(''), 'text' => $title);
        foreach ($rows as $row) {
            $jobs[] = array('value' => $row->id, 'text' => $row->title);
        }
        return $jobs;
    }

    function getJobDetails($jobid) { // this may not use
        if (is_numeric($jobid) == false)
            return false;

        $db = $this->getDBO();

        $query = "SELECT job.*, cat.cat_title , company.name as companyname, jobtype.title AS jobtypetitle
                ,  shift.title as shifttitle
                , salaryfrom.rangestart AS salaryfrom, salaryto.rangestart AS salaryto
                , salarytype.title AS salarytype
                ,mineducation.title AS mineducationtitle
                , minexperience.title AS minexperiencetitle,agefrom.title AS agefrom,ageto.title AS ageto
                , country.name AS countryname, city.name AS cityname,careerlevel.title AS careerleveltitle
		FROM `#__js_job_jobs` AS job
		JOIN `#__js_job_categories` AS cat ON job.jobcategory = cat.id
		JOIN `#__js_job_companies` AS company ON job.companyid = company.id
		JOIN `#__js_job_jobtypes` AS jobtype ON job.jobtype = jobtype.id
		LEFT JOIN `#__js_job_salaryrange` AS salaryfrom ON job.salaryrangefrom = salaryfrom.id
		LEFT JOIN `#__js_job_salaryrange` AS salaryto ON job.salaryrangeto = salaryto.id
		LEFT JOIN `#__js_job_salaryrangetypes` AS salarytype ON job.salaryrangetype = salarytype.id
		LEFT JOIN `#__js_job_heighesteducation` AS mineducation ON job.mineducationrange = mineducation.id
		LEFT JOIN `#__js_job_experiences` AS minexperience ON job.minexperiencerange = minexperience.id
		LEFT JOIN `#__js_job_shifts` AS shift ON job.shift = shift.id
		LEFT JOIN `#__js_job_countries` AS country ON job.country = country.id
		LEFT JOIN `#__js_job_cities` AS city ON job.city = city.id
		LEFT JOIN `#__js_job_ages` AS ageto ON job.ageto = ageto.id
		LEFT JOIN `#__js_job_ages` AS agefrom ON job.agefrom = agefrom.id
		LEFT JOIN `#__js_job_careerlevels` AS careerlevel ON job.careerlevel = careerlevel.id
		WHERE  job.id = " . $jobid;
        $db->setQuery($query);
        $details = $db->loadObject();

        return $details;
    }

    function getMyJobs($u_id, $sortby, $limit, $limitstart, $vis_email, $jobid) {
        $result = array();
        $db = $this->getDBO();

        if (is_numeric($u_id) == false) return false;
        if (($vis_email == '') || ($jobid == '')) if (($u_id == 0) || ($u_id == ''))return false; //check if not visitor
        $listjobconfig = $this->getJSModel('configurations')->getConfigByFor('listjob');
        
        if ($this->_client_auth_key != "") {
            $fortask = "myjobs";
            $jsjobsharingobject = $this->getJSModel('jobsharingsite');
            $data['vis_email'] = $vis_email;
            $data['jobid'] = $jobid;
            $data['uid'] = $u_id;
            $data['sortby'] = $sortby;
            $data['limitstart'] = $limitstart;
            $data['limit'] = $limit;
            $data['authkey'] = $this->_client_auth_key;
            $data['siteurl'] = $this->_siteurl;
            $encodedata = json_encode($data);
            $return_server_value = $jsjobsharingobject->serverTask($encodedata, $fortask);
            if (isset($return_server_value['myjobs']) AND $return_server_value['myjobs'] == -1) { // auth fail 
                $logarray['uid'] = $this->_uid;
                $logarray['referenceid'] = $return_server_value['referenceid'];
                $logarray['eventtype'] = $return_server_value['eventtype'];
                $logarray['message'] = $return_server_value['message'];
                $logarray['event'] = "My Jobs";
                $logarray['messagetype'] = "Error";
                $logarray['datetime'] = date('Y-m-d H:i:s');
                $jsjobsharingobject->write_JobSharingLog($logarray);
                $this->_applications = array();
                $total = 0;
            } else {
                $parse_data = array();
                if (is_array($return_server_value)){
                        foreach ($return_server_value['relationjsondata'] AS $rel_data) {
                            $parse_data[] = (object) $rel_data;
                        }
                    $this->_applications = $parse_data;
                    $total = $return_server_value['total'];
                }elseif($return_server_value==false) return false;
            }
        } else { 
            //visitor jobs
            if (isset($jobid) && ($jobid != '')) {// if the jobid and email address is valid or not
                $query = "SELECT job.companyid
                                    FROM `#__js_job_jobs` AS job
                                    WHERE job.jobid = " . $db->quote($jobid);

                $db->setQuery($query);
                $companyid = $db->loadResult();
                if (!$companyid)
                    return false;
                $query = "SELECT count(company.id)
                                    FROM `#__js_job_companies` AS company
                                    WHERE company.id = " . $companyid;
                $db->setQuery($query);
                $company = $db->loadResult();
                if ($company == 0)
                    return false; // means no company exist
            }
            if (isset($vis_email) && ($vis_email != '')) {
                $query = "SELECT count(job.id)
                                    FROM `#__js_job_companies` AS company
                                    JOIN `#__js_job_jobs` AS job ON job.companyid = company.id
                                    WHERE company.contactemail = " . $db->quote($vis_email);
            } else {
                $query = "SELECT count(job.id)
                                    FROM `#__js_job_jobs` AS job
                                    WHERE job.uid = " . $u_id;
            }
            $db->setQuery($query);
            $total = $db->loadResult();
            if ($total <= $limitstart)
                $limitstart = 0;

            if ((isset($vis_email) && isset($jobid)) && ($vis_email != '' && $jobid != '')) {
                $select_data=",'visitor' AS visitor,company.contactemail AS contactemail";
                $where_data=" company.contactemail = " . $db->quote($vis_email) ;
            } else {
                $select_data=" ";
                $where_data="job.uid = " . $u_id;

            }
            $query = "SELECT job.*, cat.cat_title
                            , jobtype.title AS jobtypetitle, jobstatus.title AS jobstatustitle,salarytype.title AS salarytypetitle
                            , company.name AS companyname, company.url
                            , salaryfrom.rangestart, salaryto.rangestart AS rangeend, country.name AS countryname
                            ,currency.symbol ,salaryto.rangestart AS salaryto
                            ,CONCAT(job.alias,'-',job.id) AS jobaliasid
                            ,CONCAT(job.alias,'-',job.serverid) AS sjobaliasid
                            ,CONCAT(company.alias,'-',company.id) AS companyaliasid
                            ,CONCAT(company.alias,'-',company.serverid) AS scompanyaliasid
                            ,(SELECT COUNT(id) FROM `#__js_job_jobapply` WHERE jobid = job.id) AS totalapply
                            ,company.logofilename AS companylogo,company.id AS companyid";
            $query.=$select_data;
            $from_data=     "FROM `#__js_job_jobs` AS job
                            JOIN `#__js_job_jobtypes` AS jobtype ON job.jobtype = jobtype.id
                            JOIN `#__js_job_categories` AS cat ON job.jobcategory = cat.id
                            LEFT JOIN `#__js_job_jobstatus` AS jobstatus ON job.jobstatus = jobstatus.id
                            LEFT JOIN `#__js_job_companies` AS company ON job.companyid = company.id
                            LEFT JOIN `#__js_job_salaryrange` AS salaryfrom ON job.salaryrangefrom = salaryfrom.id
                            LEFT JOIN `#__js_job_salaryrange` AS salaryto ON job.salaryrangeto = salaryto.id
                            LEFT JOIN `#__js_job_salaryrangetypes` AS salarytype ON job.salaryrangetype = salarytype.id
                            LEFT JOIN `#__js_job_countries` AS country ON job.country = country.id
                            LEFT JOIN `#__js_job_currencies` AS currency ON currency.id = job.currencyid";
            $query.=$from_data;
            $query.=" WHERE ".$where_data. " ORDER BY  " . $sortby;
            $db->setQuery($query, $limitstart, $limit);
            $this->_applications = $db->loadObjectList();
            foreach ($this->_applications AS $jobdata) {   // for multicity select 
                $multicitydata = $this->getMultiCityData($jobdata->id);
                if ($multicitydata != "")
                    $jobdata->city = $multicitydata;
            }
            
        }
    
        
        $result[0] = $this->_applications;
        $result[1] = $total;
        $result[2] = $listjobconfig;

        return $result;
    }

    function getJobforForm($job_id, $uid, $vis_jobid, $visitor) {
        $db = $this->getDBO();
        if ($visitor != 1) {
            $userrole = $this->getJSModel('userrole')->getUserRoleByUid($uid);
            if($userrole == 1){
                $query = "SELECT count(company.id)
                            FROM `#__js_job_companies` AS company  
                            WHERE company.uid = " . $uid;

                $db->setQuery($query);
                $user_has_company = $db->loadResult();
                if ($user_has_company == 0) {
                    $user_not_company = 3;
                    return $user_not_company;
                }
            }
        }
        if (is_numeric($uid) == false)
            return false;
        $fieldOrdering = $this->getJSModel('customfields')->getFieldsOrdering(2); // job fields       
        $company_required = '';
        $department_required = '';
        $cat_required = '';
        $subcategory_required = '';
        $jobtype_required = '';
        $jobstatus_required = '';
        $education_required = '';
        $jobshift_required = '';
        $jobsalaryrange_required = '';
        $experience_required = '';
        $age_required = '';
        $gender_required = '';
        $careerlevel_required = '';
        $workpermit_required = '';
        $requiredtravel_required = '';
        $sendemail_required = '';
        foreach ($fieldOrdering AS $fo) {
            switch ($fo->field) {
                case "company":
                    $company_required = ($fo->required ? 'required' : '');
                    break;
                case "department":
                    $department_required = ($fo->required ? 'required' : '');
                    break;
                case "jobcategory":
                    $cat_required = ($fo->required ? 'required' : '');
                    break;
                case "subcategory":
                    $subcategory_required = ($fo->required ? 'required' : '');
                    break;
                case "jobtype":
                    $jobtype_required = ($fo->required ? 'required' : '');
                    break;
                case "jobstatus":
                    $jobstatus_required = ($fo->required ? 'required' : '');
                    break;
                case "heighesteducation":
                    $education_required = ($fo->required ? 'required' : '');
                    break;
                case "jobshift":
                    $jobshift_required = ($fo->required ? 'required' : '');
                    break;
                case "jobsalaryrange":
                    $jobsalaryrange_required = ($fo->required ? 'required' : '');
                    break;
                case "experience":
                    $experience_required = ($fo->required ? 'required' : '');
                    break;
                case "age":
                    $age_required = ($fo->required ? 'required' : '');
                    break;
                case "gender":
                    $gender_required = ($fo->required ? 'required' : '');
                    break;
                case "careerlevel":
                    $careerlevel_required = ($fo->required ? 'required' : '');
                    break;
                case "workpermit":
                    $workpermit_required = ($fo->required ? 'required' : '');
                    break;
                case "requiredtravel":
                    $requiredtravel_required = ($fo->required ? 'required' : '');
                    break;
                case "sendemail":
                    $sendemail_required = ($fo->required ? 'required' : '');
                    break;
            }
        }
        if (($job_id != '') && ($job_id != 0)) {
            if (is_numeric($job_id) == false)
                return false;
            $query = "SELECT job.*, cat.cat_title, salary.rangestart, salary.rangeend
			FROM `#__js_job_jobs` AS job 
			JOIN `#__js_job_categories` AS cat ON job.jobcategory = cat.id 
			LEFT JOIN `#__js_job_salaryrange` AS salary ON job.jobsalaryrange = salary.id 
			LEFT JOIN `#__js_job_currencies` AS currency On currency.id = job.currencyid
			WHERE job.id = " . $job_id . " AND job.uid = " . $uid;
            $db->setQuery($query);
            $this->_job = $db->loadObject();
        }
        // Getting data for visitor job
        if (isset($vis_jobid) && ($vis_jobid != '')) {
            $query = "SELECT job.*, cat.cat_title, salary.rangestart, salary.rangeend
			FROM `#__js_job_jobs` AS job
			JOIN `#__js_job_categories` AS cat ON job.jobcategory = cat.id
			LEFT JOIN `#__js_job_salaryrange` AS salary ON job.jobsalaryrange = salary.id
			LEFT JOIN `#__js_job_currencies` AS currency On currency.id = job.currencyid
			WHERE job.jobid = " . $db->quote($vis_jobid);
            $db->setQuery($query);
            $this->_job = $db->loadObject();
        }
        //$countries = $this->countries->getCountries('');
        if (empty($visitor)) {
            $companies = $this->getJSModel('company')->getCompanies($uid);
        }

        $categories = $this->getJSModel('category')->getCategories('');
        if (isset($this->_job)) {
            if (empty($visitor))
                $lists['companies'] = JHTML::_('select.genericList', $companies, 'companyid', 'class="inputbox ' . $company_required . ' jsjobs-cbo" ' . 'onChange="getdepartments(\'department\', this.value)"', 'value', 'text', $this->_job->companyid);
            $lists['departments'] = JHTML::_('select.genericList', $this->getJSModel('department')->getDepartmentsByCompanyId($this->_job->companyid, ''), 'departmentid', 'class="inputbox ' . $department_required . ' jsjobs-cbo" ' . '', 'value', 'text', $this->_job->departmentid);
            $lists['jobcategory'] = JHTML::_('select.genericList', $categories, 'jobcategory', 'class="inputbox ' . $cat_required . ' jsjobs-cbo" ' . 'onChange="fj_getsubcategories(\'fj_subcategory\', this.value)"', 'value', 'text', $this->_job->jobcategory);
            $lists['subcategory'] = JHTML::_('select.genericList', $this->getJSModel('subcategory')->getSubCategoriesforCombo($this->_job->jobcategory, JText::_('JS_SUB_CATEGORY'), ''), 'subcategoryid', 'class="inputbox ' . $subcategory_required . ' jsjobs-cbo" ' . '', 'value', 'text', $this->_job->subcategoryid);
            $lists['jobtype'] = JHTML::_('select.genericList', $this->getJSModel('jobtype')->getJobType(''), 'jobtype', 'class="inputbox ' . $jobtype_required . ' jsjobs-cbo" ' . '', 'value', 'text', $this->_job->jobtype);
            $lists['jobstatus'] = JHTML::_('select.genericList', $this->getJSModel('jobstatus')->getJobStatus(''), 'jobstatus', 'class="inputbox ' . $jobstatus_required . ' jsjobs-cbo" ' . '', 'value', 'text', $this->_job->jobstatus);
            $lists['heighesteducation'] = JHTML::_('select.genericList', $this->getJSModel('highesteducation')->getHeighestEducation(''), 'heighestfinisheducation', 'class="inputbox ' . $education_required . ' jsjobs-cbo" ' . '', 'value', 'text', $this->_job->heighestfinisheducation);
            $lists['shift'] = JHTML::_('select.genericList', $this->getJSModel('shift')->getShift(''), 'shift', 'class="inputbox ' . $jobshift_required . ' jsjobs-cbo" ' . '', 'value', 'text', $this->_job->shift);

            $lists['educationminimax'] = JHTML::_('select.genericList', $this->getJSModel('common')->getMiniMax(''), 'educationminimax', 'class="inputbox jsjobs-cbo" style="width:150px;"' . '', 'value', 'text', $this->_job->educationminimax);
            $lists['education'] = JHTML::_('select.genericList', $this->getJSModel('highesteducation')->getHeighestEducation(''), 'educationid', 'class="inputbox ' . $education_required . ' jsjobs-cbo" style="width:150px;"' . '', 'value', 'text', $this->_job->educationid);
            $lists['minimumeducationrange'] = JHTML::_('select.genericList', $this->getJSModel('highesteducation')->getHeighestEducation(JText::_('JS_MINIMUM')), 'mineducationrange', 'class="inputbox style="width:150px;"' . $education_required . ' jsjobs-cbo" ' . '', 'value', 'text', $this->_job->mineducationrange);
            $lists['maximumeducationrange'] = JHTML::_('select.genericList', $this->getJSModel('highesteducation')->getHeighestEducation(JText::_('JS_MAXIMUM')), 'maxeducationrange', 'class="inputbox style="width:150px;"' . $education_required . ' jsjobs-cbo" ' . '', 'value', 'text', $this->_job->maxeducationrange);

            $lists['salaryrangefrom'] = JHTML::_('select.genericList', $this->getJSModel('salaryrange')->getJobSalaryRange(JText::_('JS_FROM'), 1), 'salaryrangefrom', 'class="inputbox validate-salaryrangefrom style="width:100px;"' . $jobsalaryrange_required . ' jsjobs-cbo" ' . '', 'value', 'text', $this->_job->salaryrangefrom);
            $lists['salaryrangeto'] = JHTML::_('select.genericList', $this->getJSModel('salaryrange')->getJobSalaryRange(JText::_('JS_TO'), 1), 'salaryrangeto', 'class="inputbox validate-salaryrangeto style="width:120px;"' . $jobsalaryrange_required . ' jsjobs-cbo" ' . '', 'value', 'text', $this->_job->salaryrangeto);
            $lists['salaryrangetypes'] = JHTML::_('select.genericList', $this->getJSModel('salaryrangetype')->getSalaryRangeTypes(''), 'salaryrangetype', 'class="inputbox jsjobs-cbo" style="width:100px"' . '', 'value', 'text', $this->_job->salaryrangetype);

            $lists['agefrom'] = JHTML::_('select.genericList', $this->getJSModel('ages')->getAges(JText::_('JS_FROM')), 'agefrom', 'class="inputbox validate-checkagefrom ' . $age_required . ' jsjobs-cbo" ' . 'style="width:100px;"', 'value', 'text', $this->_job->agefrom);
            $lists['ageto'] = JHTML::_('select.genericList', $this->getJSModel('ages')->getAges(JText::_('JS_TO')), 'ageto', 'class="inputbox validate-checkageto ' . $age_required . ' jsjobs-cbo" style="width:100px;"' . '', 'value', 'text', $this->_job->ageto);
            $lists['experienceminimax'] = JHTML::_('select.genericList', $this->getJSModel('common')->getMiniMax(''), 'experienceminimax', 'class="inputbox jsjobs-cbo" ' . '', 'value', 'text', $this->_job->experienceminimax);
            $lists['experience'] = JHTML::_('select.genericList', $this->getJSModel('experience')->getExperiences(JText::_('JS_SELECT')), 'experienceid', 'class="inputbox ' . $experience_required . ' jsjobs-cbo" ' . '', 'value', 'text', $this->_job->experienceid);
            $lists['minimumexperiencerange'] = JHTML::_('select.genericList', $this->getJSModel('experience')->getExperiences(JText::_('JS_MINIMUM')), 'minexperiencerange', 'class="inputbox ' . $experience_required . ' jsjobs-cbo" ' . '', 'value', 'text', $this->_job->minexperiencerange);
            $lists['maximumexperiencerange'] = JHTML::_('select.genericList', $this->getJSModel('experience')->getExperiences(JText::_('JS_MAXIMUM')), 'maxexperiencerange', 'class="inputbox ' . $experience_required . ' jsjobs-cbo" ' . '', 'value', 'text', $this->_job->maxexperiencerange);

            $lists['gender'] = JHTML::_('select.genericList', $this->getJSModel('common')->getGender(JText::_('JS_DOES_NOT_MATTER')), 'gender', 'class="inputbox ' . $gender_required . ' jsjobs-cbo" ' . '', 'value', 'text', $this->_job->gender);
            $lists['careerlevel'] = JHTML::_('select.genericList', $this->getJSModel('careerlevel')->getCareerLevel(JText::_('JS_SELECT')), 'careerlevel', 'class="inputbox ' . $careerlevel_required . ' jsjobs-cbo" ' . '', 'value', 'text', $this->_job->careerlevel);
            $lists['workpermit'] = JHTML::_('select.genericList', $this->getJSModel('countries')->getCountries(JText::_('JS_SELECT')), 'workpermit', 'class="inputbox ' . $workpermit_required . ' jsjobs-cbo" ' . '', 'value', 'text', $this->_job->workpermit);
            $lists['requiredtravel'] = JHTML::_('select.genericList', $this->getJSModel('common')->getRequiredTravel(JText::_('JS_SELECT')), 'requiredtravel', 'class="inputbox ' . $requiredtravel_required . ' jsjobs-cbo" ' . '', 'value', 'text', $this->_job->requiredtravel);
            $lists['sendemail'] = JHTML::_('select.genericList', $this->getJSModel('emailtemplate')->getSendEmail(), 'sendemail', 'class="inputbox ' . $sendemail_required . '" ' . '', 'value', 'text', $this->_job->sendemail);
            $lists['currencyid'] = JHTML::_('select.genericList', $this->getJSModel('currency')->getCurrency(), 'currencyid', 'class="inputbox jsjobs-cbo" style="width:50px;"' . '', 'value', 'text', $this->_job->currencyid);
            $multi_lists = $this->getJSModel('employer')->getMultiSelectEdit($this->_job->id, 1);
        }else {
            $defaultCategory = $this->getJSModel('common')->getDefaultValue('categories');
            $defaultJobtype = $this->getJSModel('common')->getDefaultValue('jobtypes');
            $defaultJobstatus = $this->getJSModel('common')->getDefaultValue('jobstatus');
            $defaultShifts = $this->getJSModel('common')->getDefaultValue('shifts');
            $defaultEducation = $this->getJSModel('common')->getDefaultValue('heighesteducation');
            $defaultSalaryrange = $this->getJSModel('common')->getDefaultValue('salaryrange');
            $defaultSalaryrangeType = $this->getJSModel('common')->getDefaultValue('salaryrangetypes');
            $defaultAge = $this->getJSModel('common')->getDefaultValue('ages');
            $defaultExperiences = $this->getJSModel('common')->getDefaultValue('experiences');
            $defaultCareerlevels = $this->getJSModel('common')->getDefaultValue('careerlevels');
            $defaultCurrencies = $this->getJSModel('common')->getDefaultValue('currencies');

            if (!isset($this->_config)) {
                $this->_config = $this->getJSModel('configurations')->getConfig('');
            }
            if (isset($companies))
                $lists['companies'] = JHTML::_('select.genericList', $companies, 'companyid', 'class="inputbox ' . $company_required . ' jsjobs-cbo" ' . 'onChange="getdepartments(\'department\', this.value)"' . '', 'value', 'text', '');
            if (isset($companies[0]['value']) && $companies[0]['value'] != '')
                $lists['departments'] = JHTML::_('select.genericList', $this->getJSModel('department')->getDepartmentsByCompanyId($companies[0]['value'], ''), 'departmentid', 'class="inputbox ' . $department_required . ' jsjobs-cbo" ' . '', 'value', 'text', '');

            $lists['jobcategory'] = JHTML::_('select.genericList', $categories, 'jobcategory', 'class="inputbox ' . $cat_required . ' jsjobs-cbo" ' . 'onChange="fj_getsubcategories(\'fj_subcategory\', this.value)"', 'value', 'text', $defaultCategory);
            $lists['subcategory'] = JHTML::_('select.genericList', $this->getJSModel('subcategory')->getSubCategoriesforCombo($defaultCategory, JText::_('JS_SUB_CATEGORY'), ''), 'subcategoryid', 'class="inputbox ' . $subcategory_required . ' jsjobs-cbo" ' . '', 'value', 'text', '');
            $lists['jobtype'] = JHTML::_('select.genericList', $this->getJSModel('jobtype')->getJobType(''), 'jobtype', 'class="inputbox ' . $jobtype_required . ' jsjobs-cbo" ' . '', 'value', 'text', $defaultJobtype);
            $lists['jobstatus'] = JHTML::_('select.genericList', $this->getJSModel('jobstatus')->getJobStatus(''), 'jobstatus', 'class="inputbox ' . $jobstatus_required . ' jsjobs-cbo" ' . '', 'value', 'text', $defaultJobstatus);
            $lists['shift'] = JHTML::_('select.genericList', $this->getJSModel('shift')->getShift(''), 'shift', 'class="inputbox ' . $jobshift_required . ' jsjobs-cbo" ' . '', 'value', 'text', $defaultShifts);

            $lists['educationminimax'] = JHTML::_('select.genericList', $this->getJSModel('common')->getMiniMax(''), 'educationminimax', 'class="inputbox jsjobs-cbo" ' . '', 'value', 'text', '');
            $lists['education'] = JHTML::_('select.genericList', $this->getJSModel('highesteducation')->getHeighestEducation(''), 'educationid', 'class="inputbox ' . $education_required . ' jsjobs-cbo" ' . '', 'value', 'text', $defaultEducation);
            $lists['minimumeducationrange'] = JHTML::_('select.genericList', $this->getJSModel('highesteducation')->getHeighestEducation(JText::_('JS_MINIMUM')), 'mineducationrange', 'class="inputbox ' . $education_required . ' jsjobs-cbo" ' . '', 'value', 'text', $defaultEducation);
            $lists['maximumeducationrange'] = JHTML::_('select.genericList', $this->getJSModel('highesteducation')->getHeighestEducation(JText::_('JS_MAXIMUM')), 'maxeducationrange', 'class="inputbox ' . $education_required . ' jsjobs-cbo" ' . '', 'value', 'text', $defaultEducation);


            $lists['salaryrangefrom'] = JHTML::_('select.genericList', $this->getJSModel('salaryrange')->getJobSalaryRange(JText::_('JS_FROM'), 1), 'salaryrangefrom', 'class="inputbox validate-salaryrangefrom ' . $jobsalaryrange_required . ' jsjobs-cbo" style="width:80px;"' . '', 'value', 'text', $defaultSalaryrange);
            $lists['salaryrangeto'] = JHTML::_('select.genericList', $this->getJSModel('salaryrange')->getJobSalaryRange(JText::_('JS_TO'), 1), 'salaryrangeto', 'class="inputbox validate-salaryrangeto ' . $jobsalaryrange_required . ' jsjobs-cbo" style="width:80px;"' . '', 'value', 'text', $defaultSalaryrange);
            $lists['salaryrangetypes'] = JHTML::_('select.genericList', $this->getJSModel('salaryrangetype')->getSalaryRangeTypes(''), 'salaryrangetype', 'class="inputbox jsjobs-cbo" style="width:120px;"' . '', 'value', 'text', $defaultSalaryrangeType);

            $lists['agefrom'] = JHTML::_('select.genericList', $this->getJSModel('ages')->getAges(JText::_('JS_FROM')), 'agefrom', 'class="inputbox validate-checkagefrom ' . $age_required . ' jsjobs-cbo" style="width:100px;"' . '', 'value', 'text', $defaultAge);
            $lists['ageto'] = JHTML::_('select.genericList', $this->getJSModel('ages')->getAges(JText::_('JS_TO')), 'ageto', 'class="inputbox validate-checkageto ' . $age_required . ' jsjobs-cbo" style="width:100px;"' . '', 'value', 'text', $defaultAge);
            $lists['experienceminimax'] = JHTML::_('select.genericList', $this->getJSModel('common')->getMiniMax(''), 'experienceminimax', 'class="inputbox jsjobs-cbo" ' . '', 'value', 'text', '');
            $lists['experience'] = JHTML::_('select.genericList', $this->getJSModel('experience')->getExperiences(JText::_('JS_SELECT')), 'experienceid', 'class="inputbox ' . $experience_required . ' jsjobs-cbo" ' . '', 'value', 'text', $defaultExperiences);
            $lists['minimumexperiencerange'] = JHTML::_('select.genericList', $this->getJSModel('experience')->getExperiences(JText::_('JS_MINIMUM')), 'minexperiencerange', 'class="inputbox ' . $experience_required . ' jsjobs-cbo" ' . '', 'value', 'text', $defaultExperiences);
            $lists['maximumexperiencerange'] = JHTML::_('select.genericList', $this->getJSModel('experience')->getExperiences(JText::_('JS_MAXIMUM')), 'maxexperiencerange', 'class="inputbox ' . $experience_required . ' jsjobs-cbo" ' . '', 'value', 'text', $defaultExperiences);

            $lists['gender'] = JHTML::_('select.genericList', $this->getJSModel('common')->getGender(JText::_('JS_DOES_NOT_MATTER')), 'gender', 'class="inputbox' . $gender_required . ' jsjobs-cbo" ' . '', 'value', 'text', '');
            $lists['careerlevel'] = JHTML::_('select.genericList', $this->getJSModel('careerlevel')->getCareerLevel(JText::_('JS_SELECT')), 'careerlevel', 'class="inputbox ' . $careerlevel_required . ' jsjobs-cbo" ' . '', 'value', 'text', $defaultCareerlevels);
            $lists['workpermit'] = JHTML::_('select.genericList', $this->getJSModel('countries')->getCountries(JText::_('JS_SELECT')), 'workpermit', 'class="inputbox ' . $workpermit_required . ' jsjobs-cbo" ' . '', 'value', 'text', $this->_defaultcountry);
            $lists['requiredtravel'] = JHTML::_('select.genericList', $this->getJSModel('common')->getRequiredTravel(JText::_('JS_SELECT')), 'requiredtravel', 'class="inputbox ' . $requiredtravel_required . ' jsjobs-cbo" ' . '', 'value', 'text', '');
            $lists['sendemail'] = JHTML::_('select.genericList', $this->getJSModel('emailtemplate')->getSendEmail(), 'sendemail', 'class="inputbox ' . $sendemail_required . '" ' . '', 'value', 'text', '$this->_job->sendemail', '');
            $lists['currencyid'] = JHTML::_('select.genericList', $this->getJSModel('currency')->getCurrency(), 'currencyid', 'class="inputbox jsjobs-cbo" style="width:50px;"' . '', 'value', 'text', $defaultCurrencies);
        }

        $result[0] = $this->_job;
        $result[1] = $lists;
        if (isset($visitor) && ($visitor == 1)) {
            if (isset($this->_job))
                $vis_jobid = $this->_job->id;
            $result[2] = $this->getJSModel('customfields')->getUserFields(2, $vis_jobid); // job fields , ref id
        }else {
            $result[2] = $this->getJSModel('customfields')->getUserFields(2, $job_id); // job fields , ref id
        }
        $result[3] = $fieldOrdering; // job fields
        if ($job_id) { // not new
            $canaddreturn = $this->getPackageDetailByUid($uid);
            if (!defined('VALIDATE')) {
                define('VALIDATE', 'VALIDATE');
            }
            $result[4] = VALIDATE;
            if (isset($canaddreturn[2]) AND ($canaddreturn[2] == 1)) {
                $result[5] = $canaddreturn; // handle enforce publishe readonly dates
            } else {
                $result[5] = $this->getPackageDetailByUid($uid); // package id
            }
        } else { // new
            $result[4] = $this->getJSModel('permissions')->checkPermissionsFor("ADD_JOB"); // can add
            $result[5] = $this->getPackageDetailByUid($uid); // package id
        }
        if (isset($uid) && $uid != 0)
            $result[6] = $this->getJSModel('employerpackages')->getAllPackagesByUid($uid, $job_id);
        $result[7] = 1; // for company check when add job

        if (isset($multi_lists) && $multi_lists != "")
            $result[8] = $multi_lists;
        return $result;
    }
    
    function getPackageDetailByUid($uid){
        if (is_numeric($uid) == false)
            return false;
        $db = $this->getDbo();
        $query = "SELECT payment.id AS paymentid, package.id, package.jobsallow, package.enforcestoppublishjob, package.enforcestoppublishjobvalue, package.enforcestoppublishjobtype
                    FROM #__js_job_paymenthistory AS payment
                    JOIN #__js_job_employerpackages AS package ON (package.id = payment.packageid AND payment.packagefor=1)
                    WHERE uid = " . $uid . "
                    AND payment.transactionverified = 1 AND payment.status = 1 ";

        $db->setQuery($query);
        $packages = $db->loadObjectList();
        if(!empty($packages)){
            foreach ($packages AS $package) {
                $packagedetail[0] = $package->id;
                $packagedetail[1] = $package->paymentid;
                $packagedetail[2] = $package->enforcestoppublishjob;
                $packagedetail[3] = $package->enforcestoppublishjobvalue;
                $packagedetail[4] = $package->enforcestoppublishjobtype;
            }
        }else{
            $packagedetail[0] = 0;
            $packagedetail[1] = 0;
            $packagedetail[2] = 0;
            $packagedetail[3] = 0;
            $packagedetail[4] = 0;
        }
        return $packagedetail;
    }

    function canAddNewJob($uid) {
        $db = $this->getDBO();
        if ($uid)
            if (is_numeric($uid) == false)
                return false;
        $query = "SELECT package.id, package.jobsallow, package.packageexpireindays, payment.id AS paymentid, payment.created
                    , package.enforcestoppublishjob, package.enforcestoppublishjobvalue, package.enforcestoppublishjobtype
                   FROM `#__js_job_employerpackages` AS package
                   JOIN `#__js_job_paymenthistory` AS payment ON (payment.packageid = package.id AND payment.packagefor=1)
                   WHERE payment.uid = " . $uid . "
                   AND DATE_ADD(payment.created,INTERVAL package.packageexpireindays DAY) >= CURDATE()
                   AND payment.transactionverified = 1 AND payment.status = 1";

        $db->setQuery($query);
        $valid_packages = $db->loadObjectList();
        if(empty($valid_packages)){ // user have no valid package
            $query = "SELECT package.id, package.jobsallow,package.title AS packagetitle, package.packageexpireindays, payment.id AS paymentid
                        , package.enforcestoppublishjob, package.enforcestoppublishjobvalue, package.enforcestoppublishjobtype
                        , (TO_DAYS( CURDATE() ) - To_days( payment.created ) ) AS packageexpiredays
                       FROM `#__js_job_employerpackages` AS package
                       JOIN `#__js_job_paymenthistory` AS payment ON (payment.packageid = package.id AND payment.packagefor=1)
                       WHERE payment.uid = " . $uid . " 
                       AND payment.transactionverified = 1 AND payment.status = 1 ORDER BY payment.created DESC";

            $db->setQuery($query);
            $packagedetail = $db->loadObjectList();
            if(empty($packagedetail)){ // User have no package
                return NO_PACKAGE;
            }else{ // User have packages but are expired
                return EXPIRED_PACKAGE;
            }
        }else{ // user have valid pacakge
            $unlimited = 0;
            $jobsallow = "";
            foreach ($valid_packages AS $job) {
                if ($unlimited == 0) {
                    if ($job->jobsallow != -1) {
                        $jobsallow = $job->jobsallow + $jobsallow;
                    } else {
                        $unlimited = 1;
                    }
                }
            }
            if ($unlimited == 0) { // user doesnot have the unlimited job package
                if ($jobsallow == 0) {
                    return JOB_LIMIT_EXCEEDS;
                } //can not add new job
                $query = "SELECT COUNT(jobs.id) AS totaljobs
				FROM `#__js_job_jobs` AS jobs
				WHERE jobs.uid = " . $uid;

                $db->setQuery($query);
                $totlajob = $db->loadResult();

                if ($jobsallow <= $totlajob) {
                    return JOB_LIMIT_EXCEEDS;
                }else{
                    return VALIDATE;
                }
            }else{ // user have unlimited job package
                return VALIDATE;
            }
        }
    }


    function getJobbyId($job_id) {
        $db = $this->getDBO();
        if (is_numeric($job_id) == false)
            return false;
        if ($this->_client_auth_key != "") {
            $fortask = "viewjobbyid";
            $jsjobsharingobject = $this->getJSModel('jobsharingsite');
            $data['jobid'] = $job_id;
            $data['authkey'] = $this->_client_auth_key;
            $data['siteurl'] = $this->_siteurl;
            $encodedata = json_encode($data);
            $return_server_value = $jsjobsharingobject->serverTask($encodedata, $fortask);
            if (isset($return_server_value['viewjobbyid']) AND $return_server_value['viewjobbyid'] == -1) { // auth fail 
                $logarray['uid'] = $this->_uid;
                $logarray['referenceid'] = $return_server_value['referenceid'];
                $logarray['eventtype'] = $return_server_value['eventtype'];
                $logarray['message'] = $return_server_value['message'];
                $logarray['event'] = "View Job By Id";
                $logarray['messagetype'] = "Error";
                $logarray['datetime'] = date('Y-m-d H:i:s');
                $jsjobsharingobject->write_JobSharingLog($logarray);
                $this->_applications = array();
                $job_userfields = array();
            } else {
                $relation_data_array = json_decode($return_server_value['relationjsondata']);
                $job_userfields_array = "";
                if (isset($return_server_value['userfields']))
                    $job_userfields_array = json_decode($return_server_value['userfields'], true);
                $parsedata = array();
                $parsedata = (object) $relation_data_array;
                $this->_application = $parsedata;
                $job_userfields = $job_userfields_array;
            }
        }else {

            $query = "SELECT job.*, cat.cat_title, subcat.title as subcategory, company.name as companyname, jobtype.title AS jobtypetitle
                        , jobstatus.title AS jobstatustitle, shift.title as shifttitle, company.url as companywebsite, company.contactname AS companycontactname, company.contactemail AS companycontactemail,company.since AS companysince,company.logofilename AS companylogo
                        , department.name AS departmentname, company.id companyid
                        , salaryfrom.rangestart AS salaryfrom, salaryto.rangestart AS salaryto, salarytype.title AS salarytype
                        , education.title AS educationtitle ,mineducation.title AS mineducationtitle, maxeducation.title AS maxeducationtitle
                        , experience.title AS experiencetitle ,minexperience.title AS minexperiencetitle, maxexperience.title AS maxexperiencetitle
                        , currency.symbol
                        ,CONCAT(job.alias,'-',job.id) AS jobaliasid
                        ,CONCAT(company.alias,'-',company.id) AS companyaliasid
						, workpermit.name as workpermitcountry
			FROM `#__js_job_jobs` AS job
			JOIN `#__js_job_categories` AS cat ON job.jobcategory = cat.id
			LEFT JOIN `#__js_job_subcategories` AS subcat ON job.subcategoryid = subcat.id
			JOIN `#__js_job_companies` AS company ON job.companyid = company.id
			JOIN `#__js_job_jobtypes` AS jobtype ON job.jobtype = jobtype.id
			LEFT JOIN `#__js_job_jobstatus` AS jobstatus ON job.jobstatus = jobstatus.id
			LEFT JOIN `#__js_job_departments` AS department ON job.departmentid = department.id
			LEFT JOIN `#__js_job_salaryrange` AS salaryfrom ON job.salaryrangefrom = salaryfrom.id
			LEFT JOIN `#__js_job_salaryrange` AS salaryto ON job.salaryrangeto = salaryto.id
			LEFT JOIN `#__js_job_salaryrangetypes` AS salarytype ON job.salaryrangetype = salarytype.id
			LEFT JOIN `#__js_job_heighesteducation` AS education ON job.educationid = education.id
			LEFT JOIN `#__js_job_heighesteducation` AS mineducation ON job.mineducationrange = mineducation.id
			LEFT JOIN `#__js_job_heighesteducation` AS maxeducation ON job.maxeducationrange = maxeducation.id
			LEFT JOIN `#__js_job_experiences` AS experience ON job.experienceid = experience.id
			LEFT JOIN `#__js_job_experiences` AS minexperience ON job.minexperiencerange = minexperience.id
			LEFT JOIN `#__js_job_experiences` AS maxexperience ON job.maxexperiencerange = maxexperience.id
			LEFT JOIN `#__js_job_shifts` AS shift ON job.shift = shift.id
			LEFT JOIN `#__js_job_currencies` AS currency ON currency.id = job.currencyid
			LEFT JOIN `#__js_job_countries` AS workpermit ON workpermit.id = job.workpermit
			WHERE  job.id = " . $job_id;

            $db->setQuery($query);
            $this->_application = $db->loadObject();
            $this->_application->multicity = $this->getJSModel('employer')->getMultiCityDataForView($job_id, 1);

            $query = "UPDATE `#__js_job_jobs` SET hits = hits + 1 WHERE id = " . $job_id;

            $db->setQuery($query);
            if (!$db->query()) {
                //return false;
            }
            $job_userfields = $this->getJSModel('customfields')->getUserFieldsForView(2, $job_id); // company fields, id
        }
        $result[0] = $this->_application;
        $result[2] = $job_userfields; // job userfields
        $result[3] = $this->getJSModel('customfields')->getFieldsOrdering(2); // company fields
        $result[4] = $this->getJSModel('configurations')->getConfigByFor('listjob'); // company fields

        return $result;
    }

    function storeJob() { //store job
        $row = $this->getTable('job');
        $data = JRequest :: get('post');
        $curdate = date('Y-m-d H:i:s');
        $db = $this->getDBO();

        if (isset($this_config) == false)
            $this->_config = $this->getJSModel('configurations')->getConfig('');
        foreach ($this->_config as $conf) {
            if ($conf->configname == 'jobautoapprove')
                $configvalue = $conf->configvalue;
            if ($conf->configname == 'date_format')
                $dateformat = $conf->configvalue;
            if ($conf->configname == 'system_timeout')
                $systemtimeout = $conf->configvalue;
        }
        if ($data['id'] == '') { // only for new job
            $data['status'] = $configvalue;
        }

        if (($data['enforcestoppublishjob'] == 1)) {
            if ($data['enforcestoppublishjobtype'] == 1) {
                if ($dateformat == 'm/d/Y')
                    $data['stoppublishing'] = date("m/d/Y", strtotime(date("m/d/Y", strtotime($data['startpublishing'])) . " +" . $data['enforcestoppublishjobvalue'] . " day"));
                else
                    $data['stoppublishing'] = date("Y-m-d", strtotime(date("Y-m-d", strtotime($data['startpublishing'])) . " +" . $data['enforcestoppublishjobvalue'] . " day"));
            } elseif ($data['enforcestoppublishjobtype'] == 2) {
                if ($dateformat == 'm/d/Y')
                    $data['stoppublishing'] = date("m/d/Y", strtotime(date("m/d/Y", strtotime($data['startpublishing'])) . " +" . $data['enforcestoppublishjobvalue'] . " week"));
                else
                    $data['stoppublishing'] = date("Y-m-d", strtotime(date("Y-m-d", strtotime($data['startpublishing'])) . " +" . $data['enforcestoppublishjobvalue'] . " week"));
            } elseif ($data['enforcestoppublishjobtype'] == 3) {
                if ($dateformat == 'm/d/Y')
                    $data['stoppublishing'] = date("m/d/Y", strtotime(date("m/d/Y", strtotime($data['startpublishing'])) . " +" . $data['enforcestoppublishjobvalue'] . " month"));
                else
                    $data['stoppublishing'] = date("Y-m-d", strtotime(date("Y-m-d", strtotime($data['startpublishing'])) . " +" . $data['enforcestoppublishjobvalue'] . " month"));
            }
        }
        //echo '<br>brfore'.$data['startpublishing'];
        //echo '<br>brfore'.$data['stoppublishing'];
        if ($dateformat == 'm/d/Y') {
            $arr = explode('/', $data['startpublishing']);
            $data['startpublishing'] = $arr[2] . '/' . $arr[0] . '/' . $arr[1];
            $arr = explode('/', $data['stoppublishing']);
            $data['stoppublishing'] = $arr[2] . '/' . $arr[0] . '/' . $arr[1];
        } elseif ($dateformat == 'd-m-Y' OR $dateformat == 'Y-m-d') {
            $arr = explode('-', $data['startpublishing']);
            $data['startpublishing'] = $arr[2] . '-' . $arr[1] . '-' . $arr[0];
            $arr = explode('-', $data['stoppublishing']);
            $data['stoppublishing'] = $arr[2] . '-' . $arr[1] . '-' . $arr[0];
        }
        //echo '<br>after '.$data['startpublishing'];
        //echo '<br>after'.$data['stoppublishing'];

        $data['startpublishing'] = date('Y-m-d H:i:s', strtotime($data['startpublishing']));
        $data['stoppublishing'] = date('Y-m-d H:i:s', strtotime($data['stoppublishing']));

        //echo '<br>final '.$data['startpublishing'];
        //echo '<br>final'.$data['stoppublishing'];
        //exit;
        // add time
        $spdate = explode("-", $data['startpublishing']);
        if ($spdate[2])
            $spdate[2] = explode(' ', $spdate[2]);
        $spdate[2] = $spdate[2][0];

        $curtime = explode(":", date('H:i:s'));

        $datetime = mktime($curtime[0], $curtime[1], $curtime[2], $spdate[1], $spdate[2], $spdate[0]);
        $data['startpublishing'] = date('Y-m-d H:i:s', $datetime);

        //time offset
        $data['startpublishing'] = date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s", strtotime($data['startpublishing'])) . $systemtimeout));

        $data['description'] = JRequest::getVar('description', '', 'post', 'string', JREQUEST_ALLOWRAW);
        $data['qualifications'] = JRequest::getVar('qualifications', '', 'post', 'string', JREQUEST_ALLOWRAW);
        $data['prefferdskills'] = JRequest::getVar('prefferdskills', '', 'post', 'string', JREQUEST_ALLOWRAW);
        $data['agreement'] = JRequest::getVar('agreement', '', 'post', 'string', JREQUEST_ALLOWRAW);

        // random generated jobid
        if (!empty($data['alias']))
            $jobalias = $this->getJSModel('common')->removeSpecialCharacter($data['alias']);
        else
            $jobalias = $this->getJSModel('common')->removeSpecialCharacter($data['title']);

        $jobalias = strtolower(str_replace(' ', '-', $jobalias));
        $data['alias'] = $jobalias;
        $data['jobid'] = $this->getJobId();

        if (!$row->bind($data)) {
            $this->setError($this->_db->getErrorMsg());
            echo $this->_db->getErrorMsg();
            return false;
        }

        $check_return = $row->check();

        if ($check_return != 1) {
            $this->setError($this->_db->getErrorMsg());
            echo $this->_db->getErrorMsg();
            return $check_return;
        }

        if (!$row->store()) {
            $this->setError($this->_db->getErrorMsg());
            echo $this->_db->getErrorMsg();
            return false;
        }

        if ($data['city'])
            $storemulticity = $this->storeMultiCitiesJob($data['city'], $row->id);
        if (isset($storemulticity) AND ($storemulticity == false))
            return false;
        $this->getJSModel('customfields')->storeUserFieldData($data, $row->id);


        if ($data['id'] == '') { // only for new job
            $this->getJSModel('adminemail')->sendMailtoAdmin($row->id, $data['uid'], 2);
            if ($data['status'] == 1) { // if job approved
            }
        }

        if ($this->_client_auth_key != "") {
            $query = "SELECT job.* FROM `#__js_job_jobs` AS job  
						WHERE job.id = " . $row->id;
            $db->setQuery($query);
            $data_job = $db->loadObject();
            if ($data['id'] != "" AND $data['id'] != 0)
                $data_job->id = $data['id']; // for edit case
            else
                $data_job->id = ''; // for new case
            $data_job->job_id = $row->id;
            $data_job->authkey = $this->_client_auth_key;

            $data_job->task = 'storejob';
            $jsjobsharingobject = $this->getJSModel('jobsharingsite');
            $return_value = $jsjobsharingobject->store_JobSharing($data_job);
            $this->getJSModel('jobtemp')->updateJobTemp();
            $job_log_object = $this->getJSModel('log');
            $job_log_object->log_Store_JobSharing($return_value);
        }
        return true;
    }

    function storeMultiCitiesJob($city_id, $jobid) { // city id comma seprated 
        $db = JFactory::getDBO();
        if (!is_numeric($jobid))
            return false;
        $query = "SELECT cityid FROM #__js_job_jobcities WHERE jobid = " . $jobid;
        $db->setQuery($query);
        $old_cities = $db->loadObjectList();
        $id_array = explode(",", $city_id);
        $row = $this->getTable('jobcities');
        $error = array();
        foreach ($old_cities AS $oldcityid) {
            $match = false;
            foreach ($id_array AS $cityid) {
                if ($oldcityid->cityid == $cityid) {
                    $match = true;
                    break;
                }
            }
            if ($match == false) {
                $query = "DELETE FROM #__js_job_jobcities WHERE jobid = " . $jobid . " AND cityid=" . $oldcityid->cityid;
                $db->setQuery($query);
                if (!$db->query()) {
                    $err = $this->setError($this->_db->getErrorMsg());
                    $error[] = $err;
                }
            }
        }
        foreach ($id_array AS $cityid) {
            $insert = true;
            foreach ($old_cities AS $oldcityid) {
                if ($oldcityid->cityid == $cityid) {
                    $insert = false;
                    break;
                }
            }
            if ($insert) {
                $row->id = "";
                $row->jobid = $jobid;
                $row->cityid = $cityid;
                if (!$row->store()) {
                    $err = $this->setError($this->_db->getErrorMsg());
                    $error[] = $err;
                }
            }
        }
        if (!empty($error))
            return false;

        return true;
    }

    function deleteJob($jobid, $uid, $vis_email, $vis_jobid) {
        $db = $this->getDBO();
        $row = $this->getTable('job');
        $serverjodid = 0;
        if (($vis_email == '') || ($vis_jobid == '')) { // if jobseeker try to delete their job
            if ((is_numeric($uid) == false) || ($uid == 0) || ($uid == ''))
                return false;
            if (is_numeric($jobid) == false)
                return false;
            if ($this->_client_auth_key != "") {
                $query = "SELECT job.serverid AS id 
								FROM `#__js_job_jobs` AS job
								WHERE job.id = " . $jobid;
                $db->setQuery($query);
                $s_job_id = $db->loadResult();
                $serverjodid = $s_job_id;
            }
        } else {
            if ($this->_client_auth_key != "") {
                $query = "SELECT job.serverid AS id FROM `#__js_job_jobs` AS job
							JOIN `#__js_job_companies` AS company ON company.id = job.companyid AND company.contactemail = " . $db->quote($vis_email) . "
							WHERE job.jobid = " . $db->quote($vis_jobid);
                $db->setQuery($query);
                $s_job_id = $db->loadResult();
                $serverjodid = $s_job_id;
            }
        }
        $returnvalue = $this->jobCanDelete($jobid, $uid, $vis_email, $vis_jobid);
        if ($returnvalue == 1) {
            if (($vis_email == '') || ($vis_jobid == '')) { // if jobseeker try to delete their job
                if (!$row->delete($jobid)) {
                    $this->setError($row->getErrorMsg());
                    return false;
                }
                $this->getJSModel('customfields')->deleteUserFieldData($jobid);
            } else {
                $query = "SELECT job.id AS id FROM `#__js_job_jobs` AS job
						JOIN `#__js_job_companies` AS company ON company.id = job.companyid AND company.contactemail = " . $db->quote($vis_email) . "
						WHERE job.jobid = " . $db->quote($vis_jobid);
                $db->setQuery($query);
                $jobid = $db->loadResult();
                $query = "DELETE FROM `#__js_job_jobs` WHERE jobid = " . $db->quote($jobid);
                $db->setQuery($query);
                if (!$db->query()) {
                    return false;
                }
                $this->getJSModel('customfields')->deleteUserFieldData($jobid);
            }
            $query = "DELETE FROM `#__js_job_jobcities` WHERE jobid = " . $jobid;
            $db->setQuery($query);
            if (!$db->query()) {
                return false;
            }
            if ($serverjodid != 0) {
                $data = array();
                $data['id'] = $serverjodid;
                $data['referenceid'] = $jobid;
                $data['uid'] = $this->_uid;
                $data['authkey'] = $this->_client_auth_key;
                $data['siteurl'] = $this->_siteurl;
                $data['task'] = 'deletejob';
                $jsjobsharingobject = $this->getJSModel('jobsharingsite');
                $return_value = $jsjobsharingobject->delete_JobSharing($data);
                $this->getJSModel('jobtemp')->updateJobTemp();
                $job_log_object = $this->getJSModel('log');
                $job_log_object->log_Delete_JobSharing($return_value);
            }
        }
        else
            return $returnvalue;

        return true;
    }

    function jobCanDelete($jobid, $uid, $vis_email, $vis_jobid) {
        if (is_numeric($uid) == false)
            return false;
        $db = $this->getDBO();
        if ($jobid)
            if (is_numeric($jobid) == false)
                return false;
        if ((isset($vis_email) && $vis_email != '') && (isset($vis_jobid) && $vis_jobid != '')) {
            $query = "SELECT COUNT(job.id) FROM `#__js_job_jobs` AS job
                                JOIN `#__js_job_companies` AS company ON company.id = job.companyid AND company.contactemail = " . $db->quote($vis_email) . "
                                WHERE job.jobid = " . $db->quote($vis_jobid);
        } else {
            $query = "SELECT COUNT(job.id) FROM `#__js_job_jobs` AS job
                                WHERE job.id = " . $jobid . " AND job.uid = " . $uid;
        }
        $db->setQuery($query);
        $jobtotal = $db->loadResult();

        if ($jobtotal > 0) { // this job is same user
            $query = "SELECT COUNT(apply.id) FROM `#__js_job_jobapply` AS apply
                                    WHERE apply.jobid = " . $jobid;

            $query = "SELECT
                                    ( SELECT COUNT(id) FROM `#__js_job_jobapply` WHERE jobid = " . $jobid . ")
                                    AS total ";
            $db->setQuery($query);
            $total = $db->loadResult();

            if ($total > 0)
                return 2;
            else
                return 1;
        }
        else
            return 3; // 	this job is not of this user		
    }

    function getMultiCityData($jobid) {
        if (is_numeric($jobid) === false)
            return false;
        $db = $this->getDBO();
        $query = "select mjob.*,city.id AS cityid,city.name AS cityname ,state.name AS statename,country.name AS countryname
                    from #__js_job_jobcities AS mjob
                    LEFT join #__js_job_cities AS city on mjob.cityid=city.id  
                    LEFT join #__js_job_states AS state on city.stateid=state.id  
                    LEFT join #__js_job_countries AS country on city.countryid=country.id 
                    WHERE mjob.jobid=" . $jobid;
        $db->setQuery($query);
        $data = $db->loadObjectList();
        if (is_array($data) AND !empty($data)) {
            $i = 0;
            $multicitydata = "";
            foreach ($data AS $multicity) {
                $last_index = count($data) - 1;
                if ($i == $last_index)
                    $multicitydata.=$multicity->cityname;
                else
                    $multicitydata.=$multicity->cityname . " ,";
                $i++;
            }
            if ($multicitydata != "") {
                $multicity = (strlen($multicitydata) > 35) ? substr($multicitydata, 0, 35) . '...' : $multicitydata;
                return $multicity;
            }
            else
                return;
        }
    }

    function getJobId() {
        $db = $this->getDBO();
        $query = "Select jobid from `#__js_job_jobs`";
        do {

            $jobid = "";
            $length = 9;
            $possible = "2346789bcdfghjkmnpqrtvwxyzBCDFGHJKLMNPQRTVWXYZ";
            // we refer to the length of $possible a few times, so let's grab it now
            $maxlength = strlen($possible);
            // check for length overflow and truncate if necessary
            if ($length > $maxlength) {
                $length = $maxlength;
            }
            // set up a counter for how many characters are in the password so far
            $i = 0;
            // add random characters to $password until $length is reached
            while ($i < $length) {
                // pick a random character from the possible ones
                $char = substr($possible, mt_rand(0, $maxlength - 1), 1);
                // have we already used this character in $password?

                if (!strstr($jobid, $char)) {
                    if ($i == 0) {
                        if (ctype_alpha($char)) {
                            $jobid .= $char;
                            $i++;
                        }
                    } else {
                        $jobid .= $char;
                        $i++;
                    }
                }
            }
            $db->setQuery($query);
            $rows = $db->loadObjectList();
            foreach ($rows as $row) {
                if ($jobid == $row->jobid)
                    $match = 'Y';
                else
                    $match = 'N';
            }
        }while ($match == 'Y');
        return $jobid;
    }

    function getJobsbyCategory($uid, $cat_id, $city_filter, $cmbfiltercountry, $filterjobcategory, $filterjobsubcategory, $filterjobtype, $txtfilterlongitude, $txtfilterlatitude, $txtfilterradius, $cmbfilterradiustype, $sortby, $limit, $limitstart) {
        $db = $this->getDBO();
        $result = array();
        if (is_numeric($cat_id) == false)
            return false;
        if ($filterjobtype != '')
            if (is_numeric($filterjobtype) == false)
                return false;
        $curdate = date('Y-m-d H:i:s');
        if (!isset($this->_config)) {
            $this->_config = $this->getJSModel('configurations')->getConfig('');
        }
        foreach ($this->_config as $conf) {
            if ($conf->configname == 'filter_address_fields_width')
                $address_fields_width = $conf->configvalue;
            if ($conf->configname == 'filter_cat_jobtype_fields_width')
                $cat_jobtype_fields_width = $conf->configvalue;
            if ($conf->configname == 'defaultcountry')
                $defaultcountry = $conf->configvalue;
            if ($conf->configname == 'hidecountry')
                $hidecountry = $conf->configvalue;
        }

        $listjobconfig = $this->getJSModel('configurations')->getConfigByFor('listjob');
        //for radius search
        switch ($cmbfilterradiustype) {
            case "m":$radiuslength = 6378137;
                break;
            case "km":$radiuslength = 6378.137;
                break;
            case "mile":$radiuslength = 3963.191;
                break;
            case "nacmiles":$radiuslength = 3441.596;
                break;
        }
        if ($this->_client_auth_key != "") {
            $selectdistance = " ";
            if ($txtfilterlongitude != '' && $txtfilterlatitude != '' && $txtfilterradius != '') {
                $radiussearch = " acos((SIN( PI()* $txtfilterlatitude /180 )*SIN( PI()*t.latitude/180 ))+(cos(PI()* $txtfilterlatitude /180)*COS( PI()*t.latitude/180) *COS(PI()*t.longitude/180-PI()* $txtfilterlongitude /180)))* $radiuslength <= $txtfilterradius";
            }

            $wherequery = '';
            $server_address = array();

            if ($city_filter != '') {
                $server_citiy_id = $this->getJSModel('common')->getServerid('cities', $city_filter);
                $server_address['multicityid'] = $server_citiy_id;
                $server_country_id = $this->getJSModel('jobsharingsite')->getSeverCountryid($city_filter);
                if ($server_country_id == false)
                    $cmbfiltercountry = '';
                else
                    $cmbfiltercountry = $server_country_id;
            }else {
                $default_sharing_loc = $this->getJSModel('configurations')->getDefaultSharingLocation($server_address, $cmbfiltercountry);
                if (isset($default_sharing_loc['defaultsharingcity']) AND ($default_sharing_loc['defaultsharingcity'] != '')) {
                    $city_filter = $default_sharing_loc['defaultsharingcity'];
                    $server_address['multicityid'] = $default_sharing_loc['defaultsharingcity'];
                } elseif (isset($default_sharing_loc['defaultsharingstate']) AND ($default_sharing_loc['defaultsharingstate'] != '')) {
                    $server_address['defaultsharingstate'] = $default_sharing_loc['defaultsharingstate'];
                } elseif (isset($default_sharing_loc['filtersharingcountry']) AND ($default_sharing_loc['filtersharingcountry'] != '')) {
                    $server_address['filtersharingcountry'] = $default_sharing_loc['filtersharingcountry'];
                    $cmbfiltercountry = $default_sharing_loc['filtersharingcountry'];
                } elseif (isset($default_sharing_loc['defaultsharingcountry']) AND ($default_sharing_loc['defaultsharingcountry'] != '')) {
                    $server_address['defaultsharingcountry'] = $default_sharing_loc['defaultsharingcountry'];
                    $cmbfiltercountry = $default_sharing_loc['defaultsharingcountry'];
                }
            }
            if ($filterjobtype != '') {
                $serverjobtype = $this->getJSModel('common')->getServerid('jobtypes', $filterjobtype);
                $wherequery .= " AND t.jobtype = " . $serverjobtype;
            }
            if ($filterjobcategory != '') {
                $serverjobcategory = $this->getJSModel('common')->getServerid('categories', $filterjobcategory);
                $wherequery .= " AND t.jobcategory = " . $serverjobcategory;
            }
            if ($filterjobsubcategory != '') {
                $serverjobsubcategory = $this->getJSModel('common')->getServerid('subcategories', $filterjobsubcategory);
                $wherequery .= " AND t.subcategoryid = " . $serverjobsubcategory;
            }
            if (isset($radiussearch))
                $wherequery .= " AND $radiussearch";
            $data['cat_id'] = $cat_id;
            $data['limitstart'] = $limitstart;
            $data['limit'] = $limit;
            $data['wherequery'] = $wherequery;
            $data['server_address'] = $server_address;
            $data['authkey'] = $this->_client_auth_key;
            $data['siteurl'] = $this->_siteurl;
            $data['sortby'] = $sortby;

            if ($listjobconfig['subcategories'] == 1) {
                $fortask = "jobscategoryofsubcategories";
                $jsjobsharingobject = $this->getJSModel('jobsharingsite');
                $encodedata = json_encode($data);
                $listsubcategory = array();
                $return_server_value_subcat = $jsjobsharingobject->serverTask($encodedata, $fortask);
                foreach ($return_server_value_subcat['listjobbysubcategory'] AS $d_subcategory) {
                    $listsubcategory[] = (object) $d_subcategory;
                }
                $subcategories = $listsubcategory;
            }

            $fortask = "getjobsbycategory";
            $jsjobsharingobject = $this->getJSModel('jobsharingsite');
            $encodedata = json_encode($data);
            $return_server_value = $jsjobsharingobject->serverTask($encodedata, $fortask);
            if (isset($return_server_value['jobsbycategory']) AND $return_server_value['jobsbycategory'] == -1) { // auth fail 
                $logarray['uid'] = $this->_uid;
                $logarray['referenceid'] = $return_server_value['referenceid'];
                $logarray['eventtype'] = $return_server_value['eventtype'];
                $logarray['message'] = $return_server_value['message'];
                $logarray['event'] = "Jobs By Category";
                $logarray['messagetype'] = "Error";
                $logarray['datetime'] = date('Y-m-d H:i:s');
                $jsjobsharingobject->write_JobSharingLog($logarray);
                $jobs = (object) array();
                $total = 0;
            } else {
                $parsedata_jobsbycategory = array();
                $total = $return_server_value['total'];
                if ($total != 0) {
                    foreach ($return_server_value['jobsbycategory'] AS $data) {
                        $parsedata_jobsbycategory[] = (object) $data;
                    }
                    $jobs = $parsedata_jobsbycategory;
                } else {
                    $category = (object) $return_server_value['category'];
                }
            }
        } else {
            $selectdistance = " ";
            if ($txtfilterlongitude != '' && $txtfilterlatitude != '' && $txtfilterradius != '') {
                $radiussearch = " acos((SIN( PI()* $txtfilterlatitude /180 )*SIN( PI()*job.latitude/180 ))+(cos(PI()* $txtfilterlatitude /180)*COS( PI()*job.latitude/180) *COS(PI()*job.longitude/180-PI()* $txtfilterlongitude /180)))* $radiuslength <= $txtfilterradius";
            }
            $wherequery = '';

            if ($city_filter != '')
                $wherequery .= " AND mjob.cityid =" . $city_filter;

            if ($filterjobsubcategory != '')
                $wherequery .= " AND job.subcategoryid = " . $filterjobsubcategory;
            if ($filterjobtype != '')
                $wherequery .= " AND job.jobtype = " . $filterjobtype;
            if (isset($radiussearch))
                $wherequery .= " AND $radiussearch";


            // sub categories query
            if ($listjobconfig['subcategories'] == 1) {
                $inquery = " (SELECT COUNT(job.id) from `#__js_job_jobs`  AS job WHERE subcat.id = job.subcategoryid AND job.status = 1 AND job.startpublishing <= " . $db->Quote($curdate) . " AND job.stoppublishing >= " . $db->Quote($curdate);
                $inquery .= $wherequery . " ) as jobsinsubcat";

                $query = "SELECT  DISTINCT subcat.id, subcat.title,CONCAT(subcat.alias,'-',subcat.id) AS subcategoryaliasid, ";
                $query .= $inquery;
                $query .= " FROM `#__js_job_subcategories` AS subcat
                            LEFT JOIN `#__js_job_jobs`  AS job ON subcat.id = job.subcategoryid
							LEFT JOIN `#__js_job_jobcities` AS mjob ON job.id = mjob.jobid                            
                            WHERE subcat.status = 1 AND categoryid = " . $cat_id;
                $query .= " ORDER BY subcat.title ";
                $db->setQuery($query);
                $subcategories = $db->loadObjectList();
            }

            $query = "SELECT COUNT(DISTINCT job.id) FROM `#__js_job_jobs` AS job
                        JOIN `#__js_job_categories` AS cat ON job.jobcategory = cat.id
                        LEFT JOIN `#__js_job_jobcities` AS mjob ON mjob.jobid = job.id 
                        WHERE job.jobcategory = cat.id AND job.status = 1  AND cat.id = " . $cat_id . " 
                        AND job.startpublishing <= " . $db->Quote($curdate) . " AND job.stoppublishing >= " . $db->Quote($curdate);
            $query .= $wherequery;
            $db->setQuery($query);
            $total = $db->loadResult();

            if ($total <= $limitstart)
                $limitstart = 0;
            if ($total != 0) {
                $query = "SELECT DISTINCT job.*, cat.cat_title, jobtype.title AS jobtype, jobstatus.title AS jobstatus
                            , company.id AS companyid, company.name AS companyname, company.url,company.logofilename AS companylogo
                            , salaryfrom.rangestart AS salaryfrom, salaryto.rangestart AS salaryto, salarytype.title AS salaytype
                            ,currency.symbol
                            ,(TO_DAYS( CURDATE() ) - To_days( job.startpublishing ) ) AS jobdays
                            ,CONCAT(cat.alias,'-',cat.id) AS categoryaliasid
                            ,CONCAT(job.alias,'-',job.id) AS jobaliasid
                            ,CONCAT(company.alias,'-',companyid) AS companyaliasid
                            FROM `#__js_job_jobs` AS job
                            JOIN `#__js_job_categories` AS cat ON job.jobcategory = cat.id
                            JOIN `#__js_job_jobtypes` AS jobtype ON job.jobtype = jobtype.id
                            LEFT JOIN `#__js_job_jobstatus` AS jobstatus ON job.jobstatus = jobstatus.id
                            LEFT JOIN `#__js_job_jobcities` AS mjob ON job.id = mjob.jobid
                            LEFT JOIN `#__js_job_companies` AS company ON job.companyid = company.id
                            LEFT JOIN `#__js_job_salaryrange` AS salaryfrom ON job.salaryrangefrom = salaryfrom.id
                            LEFT JOIN `#__js_job_salaryrange` AS salaryto ON job.salaryrangeto = salaryto.id
                            LEFT JOIN `#__js_job_salaryrangetypes` AS salarytype ON job.salaryrangetype = salarytype.id
                            LEFT JOIN `#__js_job_currencies` AS currency ON currency.id = job.currencyid
                            WHERE job.status = 1  AND cat.id = " . $cat_id . "
                            AND job.startpublishing <= " . $db->Quote($curdate) . " AND job.stoppublishing >= " . $db->Quote($curdate);

                $query .= $wherequery . " ORDER BY  " . $sortby;
                $db->setQuery($query, $limitstart, $limit);
                $jobs = $db->loadObjectList();
                foreach ($jobs AS $jobdata) {   // for multicity select 
                    $multicitydata = $this->getMultiCityData($jobdata->id);
                    if ($multicitydata != "")
                        $jobdata->city = $multicitydata;
                }
            }else {
                $query = "SELECT cat.cat_title
                            FROM `#__js_job_categories` AS cat
                            WHERE cat.id = " . $cat_id;
                $db->setQuery($query);
                $category = $db->loadObject();
            }
        }

        $jobtype = $this->getJSModel('jobtype')->getJobType(JText::_('JS_SELECT_JOB_TYPE'));
        $jobstatus = $this->getJSModel('jobstatus')->getJobStatus(JText::_('JS_SELECT_JOB_STATUS'));
        $heighesteducation = $this->getJSModel('highesteducation')->getHeighestEducation(JText::_('JS_SELECT_EDUCATION'));

        $job_categories = $this->getJSModel('category')->getCategories(JText::_('JS_SELECT_CATEGORY'));
        if ($cat_id == 0 || $cat_id == '')
            $flt_jobcatid = 1;
        else {
            if ($this->_client_auth_key != '') {
                $flt_jobcatid = $this->getJSModel('common')->getClientId('categories', $cat_id);
            }
            else
                $flt_jobcatid = $cat_id;
        }
        $job_subcategories = $this->getJSModel('subcategory')->getSubCategoriesforCombo($flt_jobcatid, JText::_('JS_SELECT_CATEGORY'), $value = '');
        $job_salaryrange = $this->getJSModel('salaryrange')->getJobSalaryRange(JText::_('JS_SELECT_SALARY'), '');
        $countries = $this->getJSModel('server')->getSharingCountries(JText::_('JS_SELECT_COUNTRY'));

        $filterlists['country'] = JHTML::_('select.genericList', $countries, 'cmbfilter_country', 'class="inputbox"  style="width:' . $address_fields_width . 'px;" ' . '', 'value', 'text', $cmbfiltercountry);

        $filterlists['jobcategory'] = JHTML::_('select.genericList', $job_categories, 'filter_jobcategory', 'class="inputbox" style="width:' . $cat_jobtype_fields_width . 'px;" ' . 'onChange="fj_getsubcategories(\'td_jobsubcategory\',this.value);"', 'value', 'text', $flt_jobcatid);
        $filterlists['jobsubcategory'] = JHTML::_('select.genericList', $job_subcategories, 'filter_jobsubcategory', 'class="inputbox" style="width:' . $cat_jobtype_fields_width . 'px;" ' . '', 'value', 'text', $filterjobsubcategory);
        $filterlists['jobtype'] = JHTML::_('select.genericList', $jobtype, 'filter_jobtype', 'class="inputbox"  style="width:' . $cat_jobtype_fields_width . 'px;"' . '', 'value', 'text', $filterjobtype);

        $location = $this->getJSModel('cities')->getAddressDataByCityName('', $city_filter);
        if (isset($location[0]->name))
            $filtervalues['location'] = $location[0]->name;
        else
            $filtervalues['location'] = "";

        $filtervalues['city'] = $city_filter;
        $filtervalues['radius'] = $txtfilterradius;
        $filtervalues['longitude'] = $txtfilterlongitude;
        $filtervalues['latitude'] = $txtfilterlatitude;

        $packageexpiry = $this->getJSModel('purchasehistory')->getJobSeekerPackageExpiry($uid);
        if ($packageexpiry == 1) { //package expire or user not login
            $listjobconfigs = array();
            $listjobconfigs['lj_title'] = $listjobconfig['visitor_lj_title'];
            $listjobconfigs['lj_category'] = $listjobconfig['visitor_lj_category'];
            $listjobconfigs['lj_jobtype'] = $listjobconfig['visitor_lj_jobtype'];
            $listjobconfigs['lj_jobstatus'] = $listjobconfig['visitor_lj_jobstatus'];
            $listjobconfigs['lj_company'] = $listjobconfig['visitor_lj_company'];
            $listjobconfigs['lj_companysite'] = $listjobconfig['visitor_lj_companysite'];
            $listjobconfigs['lj_country'] = $listjobconfig['visitor_lj_country'];
            $listjobconfigs['lj_state'] = $listjobconfig['visitor_lj_state'];
            $listjobconfigs['lj_city'] = $listjobconfig['visitor_lj_city'];
            $listjobconfigs['lj_salary'] = $listjobconfig['visitor_lj_salary'];
            $listjobconfigs['lj_created'] = $listjobconfig['visitor_lj_created'];
            $listjobconfigs['lj_noofjobs'] = $listjobconfig['visitor_lj_noofjobs'];
            $listjobconfigs['subcategories'] = $listjobconfig['subcategories'];
            $listjobconfigs['subcategories_all'] = $listjobconfig['subcategories_all'];
            $listjobconfigs['subcategories_colsperrow'] = $listjobconfig['subcategories_colsperrow'];
            $listjobconfigs['subcategoeis_max_hight'] = $listjobconfig['subcategoeis_max_hight'];
            $listjobconfigs['lj_description'] = $listjobconfig['visitor_lj_description'];
            $listjobconfigs['lj_shortdescriptionlenght'] = $listjobconfig['lj_shortdescriptionlenght'];
            $listjobconfigs['lj_joblistingstyle'] = $listjobconfig['lj_joblistingstyle'];
        }
        else
            $listjobconfigs = $listjobconfig; // user

        if (isset($jobs))
            $result[0] = $jobs;
        $result[1] = $total;
        $result[2] = $filterlists;
        $result[3] = $filtervalues;
        $result[4] = $listjobconfigs;
        if(!isset($subcategories)) $subcategories="";
        $result[5] = $subcategories;
        if (isset($category))
            $result[6] = $category;

        return $result;
    }

    function getJobsState($defaultcountry, $theme) {

        $db = JFactory::getDBO();
        $config = $this->getJSModel('configurations')->getConfig();
        $dateformat = $config[1];
        $default_country = $config[3];
        $this->getJSModel('common')->setTheme();

        $curdate = date('Y-m-d');
        $inquery = " (SELECT COUNT(job.id) from `#__js_job_jobs` AS job WHERE state.code = job.state AND job.status = 1 AND DATE(job.startpublishing) <= " . $db->Quote($curdate) . " AND DATE(job.stoppublishing) >= " . $db->Quote($curdate) . " ) as jobsbystate";
        $query = "SELECT  DISTINCT state.id, state.name,state.code, state.countrycode, ";
        $query .= $inquery;
        $query .= " FROM `#__js_job_states` AS state 
                    LEFT JOIN `#__js_job_jobs`  AS job ON state.code = job.state                                                                                                                                                                                                                                                                                                                                                                                    
                    WHERE state.enabled = " . $db->Quote('Y');
        if ($defaultcountry)
            $query .= " AND state.countrycode = " . $db->quote($default_country);
        $query .= " ORDER BY state.name ";
        $db->setQuery($query);

        $states = $db->loadObjectList();
        $query2 = "SELECT job.state, job.country, count(job.id) AS jobsbystate FROM `#__js_job_jobs` AS job WHERE job.status = 1 AND DATE(job.startpublishing) <= " . $db->Quote($curdate) . " AND DATE(job.stoppublishing) >= " . $db->Quote($curdate) . " AND job.state != '' ";
        if ($defaultcountry)
            $query2 .= " AND job.country = " . $db->quote($default_country);
        $query2 .= " AND NOT EXISTS ( SELECT id FROM `#__js_job_states` WHERE code = job.state) ";
        $query2 .= " GROUP BY job.state";

        $db->setQuery($query2);
        $states2 = $db->loadObjectList();

        $result[0] = $states;
        $result[1] = $states2;
        $result[2] = $trclass;

        return $result;
    }

    function getListNewestJobs($uid, $city_filter, $cmbfiltercountry, $filterjobcategory, $filterjobsubcategory, $filterjobtype, $txtfilterlongitude, $txtfilterlatitude, $txtfilterradius, $cmbfilterradiustype, $jobcountry, $jobstate, $limit, $limitstart) {
        if ($uid)
            if ((is_numeric($uid) == false) || ($uid == 0) || ($uid == ''))
                return false;
        if ($filterjobtype != '')
            if (is_numeric($filterjobtype) == false)
                return false;
        if ($filterjobcategory != '')
            if (is_numeric($filterjobcategory) == false)
                return false;
        $db = $this->getDBO();
        $result = array();
        if (!isset($this->_config)) {
            $this->_config = $this->getJSModel('configurations')->getConfig('');
        }
        foreach ($this->_config as $conf) {
            if ($conf->configname == 'filter_address_fields_width')
                $address_fields_width = $conf->configvalue;
            if ($conf->configname == 'filter_cat_jobtype_fields_width')
                $cat_jobtype_fields_width = $conf->configvalue;
            if ($conf->configname == 'defaultcountry')
                $defaultcountry = $conf->configvalue;
            if ($conf->configname == 'hidecountry')
                $hidecountry = $conf->configvalue;
        }
        $radiuslength = '';
        switch ($cmbfilterradiustype) {
            case "m":$radiuslength = 6378137;
                break;
            case "km":$radiuslength = 6378.137;
                break;
            case "mile":$radiuslength = 3963.191;
                break;
            case "nacmiles":$radiuslength = 3441.596;
                break;
        }
        $curdate = date('Y-m-d H:i:s');
        $variables['txtfilterlongitude'] = $txtfilterlongitude;
        $variables['txtfilterlatitude'] = $txtfilterlatitude;
        $variables['txtfilterradius'] = $txtfilterradius;
        $variables['radiuslength'] = $radiuslength;
        $variables['city_filter'] = $city_filter;
        $variables['cmbfilter_country'] = $cmbfiltercountry;
        $variables['jobstate'] = $jobstate;
        $variables['jobcountry'] = $jobcountry;
        $variables['filterjobtype'] = $filterjobtype;
        $variables['filterjobcategory'] = $filterjobcategory;
        $variables['filterjobsubcategory'] = $filterjobsubcategory;
        $variables['limitstart'] = $limitstart;
        $variables['limit'] = $limit;

        if ($this->_client_auth_key == "") {
            $return = $this->getLocalJobs($variables);
            $this->_applications = $return['jobs'];
            $total = $return['total'];
        } else { // job sharing listing 
            $session = JFactory::getSession();
            if ($_POST) {
                $checkfilterdefaultvalue = 0;
                if (isset($_POST['filter_jobcategory']) AND $_POST['filter_jobcategory'] != "")
                    $checkfilterdefaultvalue = 1;
                if (isset($_POST['filter_jobsubcategory']) AND $_POST['filter_jobsubcategory'] != "")
                    $checkfilterdefaultvalue = 1;
                if (isset($_POST['filter_jobtype']) AND $_POST['filter_jobtype'] != "")
                    $checkfilterdefaultvalue = 1;
                if (isset($_POST['filter_longitude']) AND $_POST['filter_longitude'] != "")
                    $checkfilterdefaultvalue = 1;
                if (isset($_POST['filter_latitude']) AND $_POST['filter_latitude'] != "")
                    $checkfilterdefaultvalue = 1;
                if (isset($_POST['filter_radius']) AND $_POST['filter_radius'] != "")
                    $checkfilterdefaultvalue = 1;
                if (isset($_POST['cmbfilter_country']) AND $_POST['cmbfilter_country'] != "")
                    $checkfilterdefaultvalue = 1;
                if (isset($_POST['txtfilter_city']) AND $_POST['txtfilter_city'] != "")
                    $checkfilterdefaultvalue = 1;
                $postfilter = ($checkfilterdefaultvalue == 0 ? "" : 1);
            }
            else
                $postfilter = "";

            if ((empty($postfilter)) AND ($city_filter == "") AND ($cmbfiltercountry == "") AND ($filterjobcategory == "") AND ($filterjobsubcategory == "") AND ($filterjobtype == "") AND ($txtfilterlongitude == "") AND ($txtfilterlatitude == "") AND ($txtfilterradius == "") AND ($jobcountry == "") AND ($jobstate == "")) {   // filter is null 
                if ($limitstart < 100) { // within 100
                    $default_sharing_loc = $this->getJSModel('configurations')->getDefaultSharingLocation('', '');
                    if (isset($default_sharing_loc['defaultsharingcity']) AND ($default_sharing_loc['defaultsharingcity'] != '')) {
                        $variables['city_filter'] = $default_sharing_loc['defaultsharingcity'];
                    } elseif (isset($default_sharing_loc['defaultsharingstate']) AND ($default_sharing_loc['defaultsharingstate'] != '')) {
                        $variables['jobstate'] = $default_sharing_loc['defaultsharingstate'];
                    } elseif (isset($default_sharing_loc['filtersharingcountry']) AND ($default_sharing_loc['filtersharingcountry'] != '')) {
                        $variables['jobcountry'] = $default_sharing_loc['filtersharingcountry'];
                    } elseif (isset($default_sharing_loc['defaultsharingcountry']) AND ($default_sharing_loc['defaultsharingcountry'] != '')) {
                        $variables['jobcountry'] = $default_sharing_loc['defaultsharingcountry'];
                    }
                    $data = $this->getJSModel('server')->getJobsFromServerAndFill($variables);
                    $this->_applications = $data['jobs'];
                    $total = $data['total'];
                } else { // above 100
                    $data = $this->getJSModel('server')->getJobsFromServerFilter($variables);
                    $this->_applications = $data['jobs'];
                    $total = $data['total'];
                }
            } else { // filter is not null
                $data = $this->getJSModel('server')->getJobsFromServerFilter($variables);
                $this->_applications = $data['jobs'];
                $total = $data['total'];
            }
        }


        $jobtype = $this->getJSModel('jobtype')->getJobType(JText::_('JS_SELECT_JOB_TYPE'));
        $jobstatus = $this->getJSModel('jobstatus')->getJobStatus(JText::_('JS_SELECT_JOB_STATUS'));
        $heighesteducation = $this->getJSModel('highesteducation')->getHeighestEducation(JText::_('JS_SELECT_EDUCATION'));

        $job_categories = $this->getJSModel('category')->getCategories(JText::_('JS_SELECT_CATEGORY'));
        if ($filterjobcategory == '')
            $categoryid = 1;
        else
            $categoryid = $filterjobcategory;
        $job_subcategories = $this->getJSModel('subcategory')->getSubCategoriesforCombo($categoryid, JText::_('JS_SUB_CATEGORY'), $value = '');
        $job_salaryrange = $this->getJSModel('salaryrange')->getJobSalaryRange(JText::_('JS_SELECT_SALARY'), '');
        $countries = $this->getJSModel('server')->getSharingCountries(JText::_('JS_SELECT_COUNTRY'));

        $filterlists['country'] = JHTML::_('select.genericList', $countries, 'cmbfilter_country', 'class="inputbox"  style="width:' . $cat_jobtype_fields_width . 'px;" ' . '', 'value', 'text', $cmbfiltercountry);
        $filterlists['jobcategory'] = JHTML::_('select.genericList', $job_categories, 'filter_jobcategory', 'class="inputbox" style="width:' . $cat_jobtype_fields_width . 'px;" ' . 'onChange=fj_getsubcategories(\'td_jobsubcategory\',this.value);', 'value', 'text', $filterjobcategory);
        $filterlists['jobsubcategory'] = JHTML::_('select.genericList', $job_subcategories, 'filter_jobsubcategory', 'class="inputbox" style="width:' . $cat_jobtype_fields_width . 'px;" ' . '', 'value', 'text', $filterjobsubcategory);
        $filterlists['jobtype'] = JHTML::_('select.genericList', $jobtype, 'filter_jobtype', 'class="inputbox" style="width:' . $cat_jobtype_fields_width . 'px;"  ' . '', 'value', 'text', $filterjobtype);

        $location = $this->getJSModel('cities')->getAddressDataByCityName('', $city_filter);
        if (isset($location[0]->name))
            $filtervalues['location'] = $location[0]->name;
        else
            $filtervalues['location'] = "";

        $filtervalues['city'] = $city_filter;
        $filtervalues['radius'] = $txtfilterradius;
        $filtervalues['longitude'] = $txtfilterlongitude;
        $filtervalues['latitude'] = $txtfilterlatitude;

        $listjobconfig = $this->getJSModel('configurations')->getConfigByFor('listjob');

        $packageexpiry = $this->getJSModel('purchasehistory')->getJobSeekerPackageExpiry($uid);
        if ($packageexpiry == 1) { //package expire or user not login
            $listjobconfigs = array();
            $listjobconfigs['lj_title'] = $listjobconfig['visitor_lj_title'];
            $listjobconfigs['lj_category'] = $listjobconfig['visitor_lj_category'];
            $listjobconfigs['lj_jobtype'] = $listjobconfig['visitor_lj_jobtype'];
            $listjobconfigs['lj_jobstatus'] = $listjobconfig['visitor_lj_jobstatus'];
            $listjobconfigs['lj_company'] = $listjobconfig['visitor_lj_company'];
            $listjobconfigs['lj_companysite'] = $listjobconfig['visitor_lj_companysite'];
            $listjobconfigs['lj_country'] = $listjobconfig['visitor_lj_country'];
            $listjobconfigs['lj_state'] = $listjobconfig['visitor_lj_state'];
            $listjobconfigs['lj_city'] = $listjobconfig['visitor_lj_city'];
            $listjobconfigs['lj_salary'] = $listjobconfig['visitor_lj_salary'];
            $listjobconfigs['lj_created'] = $listjobconfig['visitor_lj_created'];
            $listjobconfigs['lj_noofjobs'] = $listjobconfig['visitor_lj_noofjobs'];
            $listjobconfigs['lj_description'] = $listjobconfig['visitor_lj_description'];
            $listjobconfigs['lj_shortdescriptionlenght'] = $listjobconfig['lj_shortdescriptionlenght'];
            $listjobconfigs['lj_joblistingstyle'] = $listjobconfig['lj_joblistingstyle'];
        }
        else
            $listjobconfigs = $listjobconfig; // user

        $result[0] = $this->_applications;
        $result[1] = $total;
        $result[2] = $filterlists;
        $result[3] = $filtervalues;
        $result[4] = $listjobconfigs;

        return $result;
    }

    function getLocalJobs($variables) {
        $db = JFactory::getDbo();
        $selectdistance = " ";
        if ($variables['txtfilterlongitude'] != '' && $variables['txtfilterlatitude'] != '' && $variables['txtfilterradius'] != '') {
            $radiussearch = " acos((SIN( PI()* " . $variables['txtfilterlatitude'] . " /180 )*SIN( PI()*job.latitude/180 ))+(cos(PI()* " . $variables['txtfilterlatitude'] . " /180)*COS( PI()*job.latitude/180) *COS(PI()*job.longitude/180-PI()* " . $variables['txtfilterlongitude'] . " /180)))* " . $variables['radiuslength'] . " <= " . $variables['txtfilterradius'];
        }

        $wherequery = '';

        if ($variables['filterjobtype'] != '')
            $wherequery .= " AND job.jobtype = " . $variables['filterjobtype'];
        if ($variables['filterjobcategory'] != '')
            $wherequery .= " AND job.jobcategory = " . $variables['filterjobcategory'];
        if ($variables['filterjobsubcategory'] != '')
            $wherequery .= " AND job.subcategoryid = " . $variables['filterjobsubcategory'];
        if ($variables['city_filter'] != '')
            $wherequery .= " AND mcity.cityid = " . $variables['city_filter'];
        if ($variables['jobcountry']) {
            $wherequery.=" AND city.countryid=" . $variables['jobcountry'];
        }
        if ($variables['jobstate']) {
            $wherequery.=" AND city.stateid=" . $variables['jobstate'];
        }
        if (isset($radiussearch))
            $wherequery .= " AND $radiussearch";

        $curdate = date('Y-m-d H:i:s');
        $query = "SELECT COUNT(DISTINCT job.id) FROM `#__js_job_jobs` AS job
                        LEFT JOIN `#__js_job_jobcities` AS mcity ON job.id = mcity.jobid
                        LEFT JOIN `#__js_job_cities` AS city ON city.id = mcity.cityid 
                        WHERE job.status = 1
                        AND job.startpublishing <= " . $db->Quote($curdate) . " AND job.stoppublishing >= " . $db->Quote($curdate);
        $query .= $wherequery;
        $db->setQuery($query);
        $total = $db->loadResult();
        if ($total <= $variables['limitstart'])
            $variables['limitstart'] = 0;

        $query = "SELECT DISTINCT job.*, cat.cat_title, jobtype.title AS jobtype, jobstatus.title AS jobstatus
                        , company.id AS companyid, company.name AS companyname, company.url, company.logofilename AS companylogo 
                        , salaryfrom.rangestart AS salaryfrom, salaryto.rangestart AS salaryto, salarytype.title AS salaytype
                        , currency.symbol
                        ,(TO_DAYS( CURDATE() ) - To_days( job.startpublishing ) ) AS jobdays
                        ,CONCAT(job.alias,'-',job.id) AS jobaliasid
                        ,CONCAT(company.alias,'-',company.id) AS companyaliasid
                        FROM `#__js_job_jobs` AS job
                        JOIN `#__js_job_categories` AS cat ON job.jobcategory = cat.id
                        JOIN `#__js_job_jobtypes` AS jobtype ON job.jobtype = jobtype.id
                        LEFT JOIN `#__js_job_jobstatus` AS jobstatus ON job.jobstatus = jobstatus.id
                        LEFT JOIN `#__js_job_jobcities` AS mcity ON job.id = mcity.jobid
                        LEFT JOIN `#__js_job_cities` AS city ON city.id = mcity.cityid
                        LEFT JOIN `#__js_job_companies` AS company ON job.companyid = company.id 
                        LEFT JOIN `#__js_job_salaryrange` AS salaryfrom ON job.salaryrangefrom = salaryfrom.id
                        LEFT JOIN `#__js_job_salaryrange` AS salaryto ON job.salaryrangeto = salaryto.id
                        LEFT JOIN `#__js_job_salaryrangetypes` AS salarytype ON job.salaryrangetype = salarytype.id
                        LEFT JOIN `#__js_job_currencies` AS currency ON job.currencyid = currency.id 
                        WHERE job.status = 1  
                        AND job.startpublishing <= " . $db->Quote($curdate) . " AND job.stoppublishing >= " . $db->Quote($curdate);

        $query .= $wherequery . " ORDER BY  job.startpublishing DESC";
        //echo $query;
        $db->setQuery($query, $variables['limitstart'], $variables['limit']);
        $this->_applications = $db->loadObjectList();
        foreach ($this->_applications AS $jobdata) {   // for multicity select 
            $multicitydata = $this->getMultiCityData($jobdata->id);
            if ($multicitydata != "")
                $jobdata->city = $multicitydata;
        }
        $data['jobs'] = $this->_applications;
        $data['total'] = $total;
        return $data;
    }

    function getJobsbySubCategory($uid, $subcat_id, $city_filter, $cmbfiltercountry
    , $filterjobcategory, $filterjobsubcategory, $filterjobtype
    , $txtfilterlongitude, $txtfilterlatitude, $txtfilterradius, $cmbfilterradiustype
    , $sortby, $limit, $limitstart) {

        $db = $this->getDBO();
        $result = array();
        if (is_numeric($subcat_id) == false)
            return false;
        if ($filterjobtype != '')
            if (is_numeric($filterjobtype) == false)
                return false;

        if (!isset($this->_config)) {
            $this->_config = $this->getJSModel('configurations')->getConfig('');
        }
        foreach ($this->_config as $conf) {
            if ($conf->configname == 'filter_address_fields_width')
                $address_fields_width = $conf->configvalue;
            if ($conf->configname == 'filter_cat_jobtype_fields_width')
                $cat_jobtype_fields_width = $conf->configvalue;
        }
        $listjobconfig = $this->getJSModel('configurations')->getConfigByFor('listjob');
        //for radius search
        switch ($cmbfilterradiustype) {
            case "m":$radiuslength = 6378137;
                break;
            case "km":$radiuslength = 6378.137;
                break;
            case "mile":$radiuslength = 3963.191;
                break;
            case "nacmiles":$radiuslength = 3441.596;
                break;
        }
        $curdate = date('Y-m-d H:i:s');
        if ($this->_client_auth_key != "") {
            $selectdistance = " ";
            if ($txtfilterlongitude != '' && $txtfilterlatitude != '' && $txtfilterradius != '') {
                $radiussearch = " acos((SIN( PI()* $txtfilterlatitude /180 )*SIN( PI()*t.latitude/180 ))+(cos(PI()* $txtfilterlatitude /180)*COS( PI()*t.latitude/180) *COS(PI()*t.longitude/180-PI()* $txtfilterlongitude /180)))* $radiuslength <= $txtfilterradius";
            }

            $wherequery = '';
            $server_address = array();
            if ($city_filter != '') {
                $server_citiy_id = $this->getJSModel('common')->getServerid('cities', $city_filter);
                $server_address['multicityid'] = $server_citiy_id;
                $server_country_id = $this->getJSModel('common')->getSeverCountryid($city_filter);
                if ($server_country_id == false)
                    $cmbfiltercountry = '';
                else
                    $cmbfiltercountry = $server_country_id;
            }else {
                $default_sharing_loc = $this->getJSModel('configurations')->getDefaultSharingLocation($server_address, $cmbfiltercountry);
                //$server_address=$default_sharing_loc;
                if (isset($default_sharing_loc['defaultsharingcity']) AND ($default_sharing_loc['defaultsharingcity'] != '')) {
                    $city_filter = $default_sharing_loc['defaultsharingcity'];
                    $server_address['multicityid'] = $default_sharing_loc['defaultsharingcity'];
                } elseif (isset($default_sharing_loc['defaultsharingstate']) AND ($default_sharing_loc['defaultsharingstate'] != '')) {
                    $server_address['defaultsharingstate'] = $default_sharing_loc['defaultsharingstate'];
                } elseif (isset($default_sharing_loc['filtersharingcountry']) AND ($default_sharing_loc['filtersharingcountry'] != '')) {
                    $server_address['filtersharingcountry'] = $default_sharing_loc['filtersharingcountry'];
                    $cmbfiltercountry = $default_sharing_loc['filtersharingcountry'];
                } elseif (isset($default_sharing_loc['defaultsharingcountry']) AND ($default_sharing_loc['defaultsharingcountry'] != '')) {
                    $server_address['defaultsharingcountry'] = $default_sharing_loc['defaultsharingcountry'];
                    $cmbfiltercountry = $default_sharing_loc['defaultsharingcountry'];
                }
            }


            if ($filterjobtype != '') {
                $serverjobtype = $this->getJSModel('common')->getServerid('jobtypes', $filterjobtype);
                $wherequery .= " AND t.jobtype = " . $serverjobtype;
            }
            if ($filterjobcategory != '') {
                $serverjobcategory = $this->getJSModel('common')->getServerid('categories', $filterjobcategory);
                $wherequery .= " AND t.jobcategory = " . $serverjobcategory;
            }
            if ($filterjobsubcategory != '') {
                $serverjobsubcategory = $this->getJSModel('common')->getServerid('subcategories', $filterjobsubcategory);
                $wherequery .= " AND t.subcategoryid = " . $serverjobsubcategory;
            }
            if (isset($radiussearch))
                $wherequery .= " AND $radiussearch";
            $data['subcat_id'] = $subcat_id;
            $data['server_address'] = $server_address;
            $data['limitstart'] = $limitstart;
            $data['limit'] = $limit;
            $data['wherequery'] = $wherequery;
            $data['sortby'] = $sortby;
            $data['authkey'] = $this->_client_auth_key;
            $data['siteurl'] = $this->_siteurl;

            $fortask = "getjobsbysubcategory";
            $jsjobsharingobject = $this->getJSModel('jobsharingsite');
            $encodedata = json_encode($data);
            $return_server_value = $jsjobsharingobject->serverTask($encodedata, $fortask);
            if (isset($return_server_value['jobsbysubcategory']) AND $return_server_value['jobsbysubcategory'] == -1) { // auth fail 
                $logarray['uid'] = $this->_uid;
                $logarray['referenceid'] = $return_server_value['referenceid'];
                $logarray['eventtype'] = $return_server_value['eventtype'];
                $logarray['message'] = $return_server_value['message'];
                $logarray['event'] = "Jobs By Subcategory";
                $logarray['messagetype'] = "Error";
                $logarray['datetime'] = date('Y-m-d H:i:s');
                $jsjobsharingobject->write_JobSharingLog($logarray);
                $this->_applications = (object) array();
            } else {
                $parsedata_jobsbysubcategory = array();
                $total = $return_server_value['total'];

                foreach ($return_server_value['jobsbysubcategory'] AS $data) {
                    $parsedata_jobsbysubcategory[] = (object) $data;
                }
                $this->_applications = $parsedata_jobsbysubcategory;
            }
        } else {
            $selectdistance = " ";
            if ($txtfilterlongitude != '' && $txtfilterlatitude != '' && $txtfilterradius != '') {
                $radiussearch = " acos((SIN( PI()* $txtfilterlatitude /180 )*SIN( PI()*job.latitude/180 ))+(cos(PI()* $txtfilterlatitude /180)*COS( PI()*job.latitude/180) *COS(PI()*job.longitude/180-PI()* $txtfilterlongitude /180)))* $radiuslength <= $txtfilterradius";
            }
            $wherequery = '';
            if ($city_filter != '')
                $wherequery .= " AND mjob.cityid= " . $city_filter;

            if ($filterjobtype != '')
                $wherequery .= " AND job.jobtype = " . $filterjobtype;
            if (isset($radiussearch))
                $wherequery .= " AND $radiussearch";


            $query = "SELECT COUNT(DISTINCT job.id) FROM `#__js_job_jobs` AS job
                        JOIN `#__js_job_categories` AS cat ON job.jobcategory = cat.id
                        JOIN `#__js_job_subcategories` AS subcat ON job.subcategoryid = subcat.id
                        LEFT JOIN `#__js_job_jobcities` AS mjob ON job.id = mjob.jobid
                        WHERE job.status = 1  AND subcat.id = " . $subcat_id . "
                        AND job.startpublishing <= " . $db->Quote($curdate) . " AND job.stoppublishing >= " . $db->Quote($curdate);
            $query .= $wherequery;
            $db->setQuery($query);
            $total = $db->loadResult();

            if ($total <= $limitstart)
                $limitstart = 0;

            if ($total != 0) {
                $query = "SELECT DISTINCT job.*, cat.id as cat_id,cat.cat_title, subcat.title as subcategory, jobtype.title AS jobtype, jobstatus.title AS jobstatus,subcat.id AS subcatid
                            , company.id AS companyid, company.name AS companyname, company.url
                            , salaryfrom.rangestart AS salaryfrom, salaryto.rangestart AS salaryto, salarytype.title AS salaytype
                            ,currency.symbol
                            ,(TO_DAYS( CURDATE() ) - To_days( job.startpublishing ) ) AS jobdays
                            ,CONCAT(subcat.alias,'-',subcat.id) AS subcategoryaliasid
                            ,CONCAT(job.alias,'-',job.id) AS jobaliasid
                            ,CONCAT(company.alias,'-',company.id) AS companyaliasid
                            ,company.logofilename AS companylogo

                            FROM `#__js_job_jobs` AS job
                            JOIN `#__js_job_categories` AS cat ON job.jobcategory = cat.id
                            LEFT JOIN `#__js_job_subcategories` AS subcat ON job.subcategoryid = subcat.id
                            JOIN `#__js_job_jobtypes` AS jobtype ON job.jobtype = jobtype.id
                            LEFT JOIN `#__js_job_jobstatus` AS jobstatus ON job.jobstatus = jobstatus.id
                            LEFT JOIN `#__js_job_jobcities` AS mjob ON job.id = mjob.jobid
                            LEFT JOIN `#__js_job_companies` AS company ON job.companyid = company.id
                            LEFT JOIN `#__js_job_salaryrange` AS salaryfrom ON job.salaryrangefrom = salaryfrom.id
                            LEFT JOIN `#__js_job_salaryrange` AS salaryto ON job.salaryrangeto = salaryto.id
                            LEFT JOIN `#__js_job_salaryrangetypes` AS salarytype ON job.salaryrangetype = salarytype.id
                            LEFT JOIN `#__js_job_currencies` AS currency ON currency.id = job.currencyid
                            WHERE job.status = 1  AND subcat.id = " . $subcat_id . "
                            AND job.startpublishing <= " . $db->Quote($curdate) . " AND job.stoppublishing >= " . $db->Quote($curdate);

                $query .= $wherequery . " ORDER BY  " . $sortby;
            } else {
                $query = "SELECT cat.id as cat_id, cat.cat_title, subcat.title as subcategory,subcat.id AS subcatid
                            FROM `#__js_job_categories` AS cat
                            JOIN `#__js_job_subcategories` AS subcat ON subcat.categoryid = cat.id
                            WHERE subcat.id = " . $subcat_id;
            }
            $db->setQuery($query, $limitstart, $limit);
            $this->_applications = $db->loadObjectList();
            foreach ($this->_applications AS $jobdata) {   // for multicity select 
                if (isset($jobdata->id))
                    $multicitydata = $this->getMultiCityData($jobdata->id);
                if (isset($multicitydata) && $multicitydata != "")
                    $jobdata->city = $multicitydata;
            }
        }

        $jobtype = $this->getJSModel('jobtype')->getJobType(JText::_('JS_SELECT_JOB_TYPE'));
        $jobstatus = $this->getJSModel('jobstatus')->getJobStatus(JText::_('JS_SELECT_JOB_STATUS'));

        $row = $this->getTable('subcategory');
        $row->load($subcat_id);
        $categoryid = $row->categoryid;
        if (!empty($categoryid)) {
            if ($this->_client_auth_key != '') {
                $categoryid = $this->getJSModel('common')->getClientId('categories', $categoryid);
            }
            else
                $categoryid = $categoryid;
        }
        else
            $categoryid = $filterjobcategory;


        if ($subcat_id == 0 || $subcat_id == '')
            $subcat_id = 1;
        else {
            if ($this->_client_auth_key != '') {
                $ssubcatid = $this->getJSModel('common')->getClientId('subcategories', $subcat_id);
                $subcat_id = $ssubcatid;
            }
            else
                $subcat_id = $subcat_id;
        }

        $job_categories = $this->getJSModel('category')->getCategories(JText::_('JS_SELECT_CATEGORY'));
        $job_subcategories = $this->getJSModel('subcategory')->getSubCategoriesforCombo($categoryid, JText::_('JS_SELECT_CATEGORY'), $value = '');
        $countries = $this->getJSModel('server')->getSharingCountries(JText::_('JS_SELECT_COUNTRY'));

        $filterlists['country'] = JHTML::_('select.genericList', $countries, 'cmbfilter_country', 'class="inputbox"  style="width:' . $address_fields_width . 'px;" ' . '', 'value', 'text', $cmbfiltercountry);
        $filterlists['jobcategory'] = JHTML::_('select.genericList', $job_categories, 'filter_jobcategory', 'class="inputbox" style="width:' . $cat_jobtype_fields_width . 'px;" ' . 'onChange=fj_getsubcategories(\'td_jobsubcategory\',this.value);', 'value', 'text', $categoryid);
        $filterlists['jobsubcategory'] = JHTML::_('select.genericList', $job_subcategories, 'filter_jobsubcategory', 'class="inputbox" style="width:' . $cat_jobtype_fields_width . 'px;" ' . '', 'value', 'text', $subcat_id);
        $filterlists['jobtype'] = JHTML::_('select.genericList', $jobtype, 'filter_jobtype', 'class="inputbox" style="width:' . $cat_jobtype_fields_width . 'px;" ' . '', 'value', 'text', $filterjobtype);

        $location = $this->getJSModel('cities')->getAddressDataByCityName('', $city_filter);
        if (isset($location[0]->name))
            $filtervalues['location'] = $location[0]->name;
        else
            $filtervalues['location'] = "";

        $filtervalues['city'] = $city_filter;
        $filtervalues['radius'] = $txtfilterradius;
        $filtervalues['longitude'] = $txtfilterlongitude;
        $filtervalues['latitude'] = $txtfilterlatitude;

        $packageexpiry = $this->getJSModel('purchasehistory')->getJobSeekerPackageExpiry($uid);
        if ($packageexpiry == 1) { //package expire or user not login
            $listjobconfigs = array();
            $listjobconfigs['lj_title'] = $listjobconfig['visitor_lj_title'];
            $listjobconfigs['lj_category'] = $listjobconfig['visitor_lj_category'];
            $listjobconfigs['lj_jobtype'] = $listjobconfig['visitor_lj_jobtype'];
            $listjobconfigs['lj_jobstatus'] = $listjobconfig['visitor_lj_jobstatus'];
            $listjobconfigs['lj_company'] = $listjobconfig['visitor_lj_company'];
            $listjobconfigs['lj_companysite'] = $listjobconfig['visitor_lj_companysite'];
            $listjobconfigs['lj_country'] = $listjobconfig['visitor_lj_country'];
            $listjobconfigs['lj_state'] = $listjobconfig['visitor_lj_state'];
            $listjobconfigs['lj_city'] = $listjobconfig['visitor_lj_city'];
            $listjobconfigs['lj_salary'] = $listjobconfig['visitor_lj_salary'];
            $listjobconfigs['lj_created'] = $listjobconfig['visitor_lj_created'];
            $listjobconfigs['lj_noofjobs'] = $listjobconfig['visitor_lj_noofjobs'];
            $listjobconfigs['subcategories'] = $listjobconfig['subcategories'];
            $listjobconfigs['subcategories_all'] = $listjobconfig['subcategories_all'];
            $listjobconfigs['subcategories_colsperrow'] = $listjobconfig['subcategories_colsperrow'];
            $listjobconfigs['subcategoeis_max_hight'] = $listjobconfig['subcategoeis_max_hight'];
            $listjobconfigs['lj_description'] = $listjobconfig['visitor_lj_description'];
            $listjobconfigs['lj_shortdescriptionlenght'] = $listjobconfig['lj_shortdescriptionlenght'];
            $listjobconfigs['lj_joblistingstyle'] = $listjobconfig['lj_joblistingstyle'];
        }
        else
            $listjobconfigs = $listjobconfig; // user

        $result[0] = $this->_applications;
        $result[1] = $total;
        $result[2] = $filterlists;
        $result[3] = $filtervalues;
        $result[4] = $listjobconfigs;

        return $result;
    }
    
}
?>


