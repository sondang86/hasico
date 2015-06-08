<?php

/**
 * @Copyright Copyright (C) 2009-2010 ... Ahmad Bilal
 * @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * Company:		Al-Barr Technologies
  + Contact:		www.al-barr.com , info@al-barr.com
 * Created on:	Jan 11, 2009
  ^
  + Project: 		Job Posting and Employment Application
 * File Name:	admin-----/models/jsjobs.php
  ^
 * Description: Model for application on admin site
  ^
 * History:		NONE
  ^
 */
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.model');
jimport('joomla.html.html');

class JSJobsModelJob extends JSModel {

    var $_config = null;
    var $_defaultcurrency = null;
    var $_client_auth_key = null;
    var $_siteurl = null;
    var $_application = null;
    var $_searchoptions = null;
    var $_job = null;
    var $_job_editor = null;
    var $_defaultcountry = null;

    function __construct() {
        parent :: __construct();
        $this->_client_auth_key = $this->getJSModel('jobsharing')->getClientAuthenticationKey();
        $this->_siteurl = JURI::root();
        $this->_defaultcurrency = $this->getJSModel('currency')->getDefaultCurrency();
        $user = JFactory::getUser();
        $this->_uid = $user->id;
    }

    function getTopJobs() {
        $db = JFactory :: getDBO();
        $result = array();
        $query = "SELECT job.id,job.title AS jobtitle,company.name AS companyname,cat.cat_title AS cattile,job.stoppublishing,
		salaryfrom.rangestart AS salaryfrom, salaryto.rangestart AS salaryto,currency.symbol 
		FROM `#__js_job_jobs` AS job
		JOIN `#__js_job_categories` AS cat ON job.jobcategory = cat.id
		JOIN `#__js_job_companies` AS company ON job.companyid = company.id
		LEFT JOIN `#__js_job_salaryrange` AS salaryfrom ON job.salaryrangefrom = salaryfrom.id
		LEFT JOIN `#__js_job_salaryrange` AS salaryto ON job.salaryrangeto = salaryto.id
	    LEFT JOIN `#__js_job_currencies` AS currency ON currency.id = job.currencyid ORDER BY job.created desc LIMIT 5";
        $db->setQuery($query);
        $jobs = $db->loadObjectList();
        return $jobs;
    }

    function getMultiCityData($jobid) {
        if (!is_numeric($jobid))
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
                $mc = JText::_('JS_MULTI_CITY');
                $multicity = (strlen($multicitydata) > 35) ? $mc . substr($multicitydata, 0, 35) . '...' : $multicitydata;
                return $multicity;
            }
            else
                return;
        }
    }

    function getSearchOptions() {
        $searchjobconfig = $this->getJSModel('configuration')->getConfigByFor('searchjob');

        if (!$this->_searchoptions) {
            $this->_searchoptions = array();
            $companies = $this->getJSModel('company')->getAllCompaniesForSearch(JText::_('JS_SEARCH_ALL'));
            $job_type = $this->getJSModel('jobtype')->getJobType(JText::_('JS_SEARCH_ALL'));
            $jobstatus = $this->getJSModel('jobstatus')->getJobStatus(JText::_('JS_SEARCH_ALL'));
            $heighesteducation = $this->getJSModel('highesteducation')->getHeighestEducation(JText::_('JS_SEARCH_ALL'));
            $job_categories = $this->getJSModel('category')->getCategories(JText::_('JS_SEARCH_ALL'), '');
            $job_subcategories = $this->getJSModel('subcategory')->getSubCategoriesforCombo($job_categories[1]['value'], JText::_('JS_SEARCH_ALL'), '');
            $job_salaryrange = $this->getJSModel('salaryrange')->getJobSalaryRange(JText::_('JS_SEARCH_ALL'), '');
            $shift = $this->getJSModel('shift')->getShift(JText::_('JS_SEARCH_ALL'));
            $countries = $this->getJSModel('country')->getCountries('');

            if (!isset($this->_config)) {
                $this->_config = $this->getJSModel('configuration')->getConfig();
            }
            if (isset($this->_defaultcountry))
                $states = $this->getJSModel('state')->getStates($this->_defaultcountry);
            $this->_searchoptions['country'] = JHTML::_('select.genericList', $countries, 'country', 'class="inputbox required" ' . 'onChange="dochange(\'state\', this.value)"', 'value', 'text', $this->_defaultcountry);
            if (isset($states[1]))
                if ($states[1] != '')
                    $this->_searchoptions['state'] = JHTML::_('select.genericList', $states, 'state', 'class="inputbox" ' . 'onChange="dochange(\'city\', this.value)"', 'value', 'text', '');
            if (isset($cities[1]))
                if ($cities[1] != '')
                    $this->_searchoptions['city'] = JHTML::_('select.genericList', $cities, 'city', 'class="inputbox" ' . '', 'value', 'text', '');
            $this->_searchoptions['companies'] = JHTML::_('select.genericList', $companies, 'company', 'class="inputbox" ' . '', 'value', 'text', '');
            $this->_searchoptions['jobcategory'] = JHTML::_('select.genericList', $job_categories, 'jobcategory', 'class="inputbox" ' . 'onChange="fj_getsubcategories(\'fj_subcategory\', this.value)"', 'value', 'text', '');
            $this->_searchoptions['jobsubcategory'] = JHTML::_('select.genericList', $job_subcategories, 'jobsubcategory', 'class="inputbox" ' . '', 'value', 'text', '');
            $this->_searchoptions['jobsalaryrange'] = JHTML::_('select.genericList', $job_salaryrange, 'jobsalaryrange', 'class="inputbox" ' . 'style="width:150px;"', 'value', 'text', '');
            $this->_searchoptions['salaryrangefrom'] = JHTML::_('select.genericList', $this->getJSModel('salaryrange')->getSalaryRange(JText::_('JS_FROM')), 'salaryrangefrom', 'class="inputbox" ' . 'style="width:150px;"', 'value', 'text', '');
            $this->_searchoptions['salaryrangeto'] = JHTML::_('select.genericList', $this->getJSModel('salaryrange')->getSalaryRange(JText::_('JS_TO')), 'salaryrangeto', 'class="inputbox" ' . 'style="width:150px;"', 'value', 'text', '');
            $this->_searchoptions['salaryrangetypes'] = JHTML::_('select.genericList', $this->getJSModel('salaryrangetype')->getSalaryRangeTypes(''), 'salaryrangetype', 'class="inputbox" ' . 'style="width:150px;"', 'value', 'text', 2);
            $this->_searchoptions['jobstatus'] = JHTML::_('select.genericList', $jobstatus, 'jobstatus', 'class="inputbox" ' . '', 'value', 'text', '');
            $this->_searchoptions['jobtype'] = JHTML::_('select.genericList', $job_type, 'jobtype', 'class="inputbox" ' . '', 'value', 'text', '');
            $this->_searchoptions['heighestfinisheducation'] = JHTML::_('select.genericList', $heighesteducation, 'heighestfinisheducation', 'class="inputbox" ' . '', 'value', 'text', '');
            $this->_searchoptions['shift'] = JHTML::_('select.genericList', $shift, 'shift', 'class="inputbox" ' . '', 'value', 'text', '');
            $this->_searchoptions['currency'] = JHTML::_('select.genericList', $this->getJSModel('currency')->getCurrency(), 'currency', 'class="inputbox" ' . 'style="width:150px;"', 'value', 'text', '');
        }
        $result = array();
        $result[0] = $this->_searchoptions;
        $result[1] = $searchjobconfig;
        return $result;
    }

    function getJobbyIdForView($job_id) {
        $db = $this->getDBO();
        if (is_numeric($job_id) == false)
            return false;

        $query = "SELECT job.*, cat.cat_title , company.name as companyname, jobtype.title AS jobtypetitle
				, jobstatus.title AS jobstatustitle, shift.title as shifttitle
				, department.name AS departmentname
				, salaryfrom.rangestart AS salaryfrom, salaryto.rangestart AS salaryto, salarytype.title AS salarytype
				, education.title AS educationtitle ,mineducation.title AS mineducationtitle, maxeducation.title AS maxeducationtitle
				, experience.title AS experiencetitle ,minexperience.title AS minexperiencetitle, maxexperience.title AS maxexperiencetitle
				,currency.symbol 
				
		FROM `#__js_job_jobs` AS job
		JOIN `#__js_job_categories` AS cat ON job.jobcategory = cat.id
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
		WHERE  job.id = " . $job_id;
        $db->setQuery($query);
        $this->_application = $db->loadObject();
        $this->_application->multicity = $this->getJSModel('jsjobs')->getMultiCityDataForView($job_id, 1);

        $result[0] = $this->_application;
        $result[2] = $this->getJSModel('customfield')->getUserFieldsForView(2, $job_id); // company fields, id
        $result[3] = $this->getJSModel('fieldordering')->getFieldsOrderingforForm(2); // company fields

        return $result;
    }

    function getJobbyId($c_id, $uid) {
        if ($uid)
            if ((is_numeric($uid) == false) || ($uid == 0) || ($uid == ''))
                return false;
        if (is_numeric($c_id) == false)
            return false;
        $fieldsordering = $this->getJSModel('fieldordering')->getFieldsOrderingforForm(2); // job fields       
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
        foreach ($fieldsordering AS $fo) {
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
        $db = JFactory :: getDBO();

        $query = "SELECT job.*, cat.cat_title, salary.rangestart, salary.rangeend
			FROM `#__js_job_jobs` AS job
			JOIN `#__js_job_categories` AS cat ON job.jobcategory = cat.id
			LEFT JOIN `#__js_job_salaryrange` AS salary ON job.jobsalaryrange = salary.id
			LEFT JOIN `#__js_job_currencies` AS currency ON currency.id = job.currencyid 
			WHERE job.id = " . $c_id;

        $db->setQuery($query);
        $this->_job = $db->loadObject();

        $status = array(
            '0' => array('value' => 0, 'text' => JText::_('JS_PENDDING')),
            '1' => array('value' => 1, 'text' => JText::_('JS_APPROVE')),
            '2' => array('value' => -1, 'text' => JText::_('JS_REJECT')),);
        $companies = $this->getJSModel('company')->getCompanies($uid);
        $departments = $this->getJSModel('department')->getDepartment($uid);
        $categories = $this->getJSModel('category')->getCategories('', '');

        if (isset($this->_job)) {

            $lists['companies'] = JHTML::_('select.genericList', $companies, 'companyid', 'class="inputbox ' . $company_required . '" ' . 'onChange="getdepartments(\'department\', this.value)"', 'value', 'text', $this->_job->companyid);
            $lists['departments'] = JHTML::_('select.genericList', $this->getJSModel('department')->getDepartmentsByCompanyId($this->_job->companyid, ''), 'departmentid', 'class="inputbox ' . $department_required . '" ' . '', 'value', 'text', $this->_job->departmentid);
            $lists['jobcategory'] = JHTML::_('select.genericList', $categories, 'jobcategory', 'class="inputbox ' . $cat_required . '"' . 'onChange="fj_getsubcategories(\'fj_subcategory\', this.value)"', 'value', 'text', $this->_job->jobcategory);
            $lists['subcategory'] = JHTML::_('select.genericList', $this->getJSModel('subcategory')->getSubCategoriesforCombo($this->_job->jobcategory, JText::_('JS_SUB_CATEGORY'), ''), 'subcategoryid', 'class="inputbox ' . $subcategory_required . '"' . '', 'value', 'text', $this->_job->subcategoryid);
            $lists['jobtype'] = JHTML::_('select.genericList', $this->getJSModel('jobtype')->getJobType(''), 'jobtype', 'class="inputbox ' . $jobtype_required . '"' . '', 'value', 'text', $this->_job->jobtype);
            $lists['jobstatus'] = JHTML::_('select.genericList', $this->getJSModel('jobstatus')->getJobStatus(''), 'jobstatus', 'class="inputbox ' . $jobstatus_required . '"' . '', 'value', 'text', $this->_job->jobstatus);
            $lists['educationminimax'] = JHTML::_('select.genericList', $this->getJSModel('common')->getMiniMax(''), 'educationminimax', 'class="inputbox" ' . '', 'value', 'text', $this->_job->educationminimax);
            $lists['education'] = JHTML::_('select.genericList', $this->getJSModel('highesteducation')->getHeighestEducation(''), 'educationid', 'class="inputbox ' . $education_required . '"' . '', 'value', 'text', $this->_job->educationid);
            $lists['minimumeducationrange'] = JHTML::_('select.genericList', $this->getJSModel('highesteducation')->getHeighestEducation(JText::_('JS_MINIMUM')), 'mineducationrange', 'class="inputbox ' . $education_required . '"' . '', 'value', 'text', $this->_job->mineducationrange);
            $lists['maximumeducationrange'] = JHTML::_('select.genericList', $this->getJSModel('highesteducation')->getHeighestEducation(JText::_('JS_MAXIMUM')), 'maxeducationrange', 'class="inputbox ' . $education_required . '"' . '', 'value', 'text', $this->_job->maxeducationrange);

            $lists['shift'] = JHTML::_('select.genericList', $this->getJSModel('shift')->getShift(''), 'shift', 'class="inputbox ' . $jobshift_required . '"' . '', 'value', 'text', $this->_job->shift);
            $lists['salaryrangefrom'] = JHTML::_('select.genericList', $this->getJSModel('salaryrange')->getSalaryRange(JText::_('JS_FROM')), 'salaryrangefrom', 'class="inputbox validate-salaryrangefrom ' . $jobsalaryrange_required . '"' . '', 'value', 'text', $this->_job->salaryrangefrom);
            $lists['salaryrangeto'] = JHTML::_('select.genericList', $this->getJSModel('salaryrange')->getSalaryRange(JText::_('JS_TO')), 'salaryrangeto', 'class="inputbox validate-salaryrangeto ' . $jobsalaryrange_required . '" ' . '', 'value', 'text', $this->_job->salaryrangeto);
            $lists['salaryrangetypes'] = JHTML::_('select.genericList', $this->getJSModel('salaryrangetype')->getSalaryRangeTypes(''), 'salaryrangetype', 'class="inputbox" ' . '', 'value', 'text', $this->_job->salaryrangetype);

            $lists['experienceminimax'] = JHTML::_('select.genericList', $this->getJSModel('common')->getMiniMax(''), 'experienceminimax', 'class="inputbox" ' . '', 'value', 'text', $this->_job->experienceminimax);
            $lists['experience'] = JHTML::_('select.genericList', $this->getJSModel('experience')->getExperiences(JText::_('JS_SELECT')), 'experienceid', 'class="inputbox ' . $experience_required . '" ' . '', 'value', 'text', $this->_job->experienceid);
            $lists['minimumexperiencerange'] = JHTML::_('select.genericList', $this->getJSModel('experience')->getExperiences(JText::_('JS_MINIMUM')), 'minexperiencerange', 'class="inputbox ' . $experience_required . '"' . '', 'value', 'text', $this->_job->minexperiencerange);
            $lists['maximumexperiencerange'] = JHTML::_('select.genericList', $this->getJSModel('experience')->getExperiences(JText::_('JS_MAXIMUM')), 'maxexperiencerange', 'class="inputbox ' . $experience_required . '"' . '', 'value', 'text', $this->_job->maxexperiencerange);

            $lists['agefrom'] = JHTML::_('select.genericList', $this->getJSModel('age')->getAges(JText::_('JS_FROM')), 'agefrom', 'class="inputbox validate-checkagefrom ' . $age_required . '"' . '', 'value', 'text', $this->_job->agefrom);
            $lists['ageto'] = JHTML::_('select.genericList', $this->getJSModel('age')->getAges(JText::_('JS_TO')), 'ageto', 'class="inputbox validate-checkageto ' . $age_required . '"' . '', 'value', 'text', $this->_job->ageto);

            $lists['gender'] = JHTML::_('select.genericList', $this->getJSModel('common')->getGender(JText::_('JS_DOES_NOT_MATTER')), 'gender', 'class="inputbox ' . $gender_required . '"' . '', 'value', 'text', $this->_job->gender);

            $lists['careerlevel'] = JHTML::_('select.genericList', $this->getJSModel('careerlevel')->getCareerLevels(JText::_('JS_SELECT')), 'careerlevel', 'class="inputbox ' . $careerlevel_required . '"' . '', 'value', 'text', $this->_job->careerlevel);
            $lists['workpermit'] = JHTML::_('select.genericList', $this->getJSModel('country')->getCountries(JText::_('JS_SELECT')), 'workpermit', 'class="inputbox ' . $workpermit_required . '" ' . '', 'value', 'text', $this->_job->workpermit);
            $lists['requiredtravel'] = JHTML::_('select.genericList', $this->getJSModel('common')->getRequiredTravel(JText::_('JS_SELECT')), 'requiredtravel', 'class="inputbox ' . $requiredtravel_required . '" ' . '', 'value', 'text', $this->_job->requiredtravel);

            $lists['status'] = JHTML::_('select.genericList', $status, 'status', 'class="inputbox required" ' . '', 'value', 'text', $this->_job->status);
            $lists['sendemail'] = JHTML::_('select.genericList', $this->getJSModel('common')->getSendEmail(), 'sendemail', 'class="inputbox ' . $sendemail_required . '" ' . '', 'value', 'text', $this->_job->sendemail);
            $lists['currencyid'] = JHTML::_('select.genericList', $this->getJSModel('currency')->getCurrency(), 'currencyid', 'class="inputbox " ' . '', 'value', 'text', $this->_job->currencyid);
            $multi_lists = $this->getJSModel('common')->getMultiSelectEdit($this->_job->id, 1);
        } else {

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
                $this->_config = $this->getJSModel('configuration')->getConfig();
            }
            $lists['companies'] = JHTML::_('select.genericList', $companies, 'companyid', 'class="inputbox ' . $company_required . '" ' . 'onChange="getdepartments(\'department\', this.value)"' . '', 'value', 'text', '');
            if (isset($companies[0]['value']))
                $lists['departments'] = JHTML::_('select.genericList', $this->getJSModel('department')->getDepartmentsByCompanyId($companies[0]['value'], ''), 'departmentid', 'class="inputbox ' . $department_required . '"' . '', 'value', 'text', '');
            $lists['jobcategory'] = JHTML::_('select.genericList', $categories, 'jobcategory', 'class="inputbox ' . $cat_required . '"' . 'onChange="fj_getsubcategories(\'fj_subcategory\', this.value)"', 'value', 'text', $defaultCategory);
            $lists['subcategory'] = JHTML::_('select.genericList', $this->getJSModel('subcategory')->getSubCategoriesforCombo($defaultCategory, JText::_('JS_SUB_CATEGORY'), ''), 'subcategoryid', 'class="inputbox ' . $subcategory_required . '"' . '', 'value', 'text', '');
            $lists['jobtype'] = JHTML::_('select.genericList', $this->getJSModel('jobtype')->getJobType(''), 'jobtype', 'class="inputbox ' . $jobtype_required . '"' . '', 'value', 'text', $defaultJobtype);
            $lists['jobstatus'] = JHTML::_('select.genericList', $this->getJSModel('jobstatus')->getJobStatus(''), 'jobstatus', 'class="inputbox ' . $jobstatus_required . '"' . '', 'value', 'text', $defaultJobstatus);

            $lists['educationminimax'] = JHTML::_('select.genericList', $this->getJSModel('common')->getMiniMax(''), 'educationminimax', 'class="inputbox" ' . '', 'value', 'text', '');
            $lists['education'] = JHTML::_('select.genericList', $this->getJSModel('highesteducation')->getHeighestEducation(''), 'educationid', 'class="inputbox ' . $education_required . '"' . '', 'value', 'text', $defaultEducation);
            $lists['minimumeducationrange'] = JHTML::_('select.genericList', $this->getJSModel('highesteducation')->getHeighestEducation(JText::_('JS_MINIMUM')), 'mineducationrange', 'class="inputbox ' . $education_required . '"' . '', 'value', 'text', $defaultEducation);
            $lists['maximumeducationrange'] = JHTML::_('select.genericList', $this->getJSModel('highesteducation')->getHeighestEducation(JText::_('JS_MAXIMUM')), 'maxeducationrange', 'class="inputbox ' . $education_required . '"' . '', 'value', 'text', $defaultEducation);
            $lists['shift'] = JHTML::_('select.genericList', $this->getJSModel('shift')->getShift(''), 'shift', 'class="inputbox ' . $jobshift_required . '"' . '', 'value', 'text', $defaultShifts);

            $lists['salaryrangefrom'] = JHTML::_('select.genericList', $this->getJSModel('salaryrange')->getSalaryRange(JText::_('JS_FROM')), 'salaryrangefrom', 'class="inputbox validate-salaryrangefrom ' . $jobsalaryrange_required . '" ' . '', 'value', 'text', $defaultSalaryrange);
            $lists['salaryrangeto'] = JHTML::_('select.genericList', $this->getJSModel('salaryrange')->getSalaryRange(JText::_('JS_TO')), 'salaryrangeto', 'class="inputbox validate-salaryrangeto ' . $jobsalaryrange_required . '" ' . '', 'value', 'text', $defaultSalaryrange);
            $lists['salaryrangetypes'] = JHTML::_('select.genericList', $this->getJSModel('salaryrangetype')->getSalaryRangeTypes(''), 'salaryrangetype', 'class="inputbox" ' . '', 'value', 'text', $defaultSalaryrangeType);


            $lists['experienceminimax'] = JHTML::_('select.genericList', $this->getJSModel('common')->getMiniMax(''), 'experienceminimax', 'class="inputbox" ' . '', 'value', 'text', '');
            $lists['experience'] = JHTML::_('select.genericList', $this->getJSModel('experience')->getExperiences(JText::_('JS_SELECT')), 'experienceid', 'class="inputbox ' . $experience_required . '" ' . '', 'value', 'text', $defaultExperiences);
            $lists['minimumexperiencerange'] = JHTML::_('select.genericList', $this->getJSModel('experience')->getExperiences(JText::_('JS_MINIMUM')), 'minexperiencerange', 'class="inputbox ' . $experience_required . '"' . '', 'value', 'text', $defaultExperiences);
            $lists['maximumexperiencerange'] = JHTML::_('select.genericList', $this->getJSModel('experience')->getExperiences(JText::_('JS_MAXIMUM')), 'maxexperiencerange', 'class="inputbox ' . $experience_required . '"' . '', 'value', 'text', $defaultExperiences);

            $lists['agefrom'] = JHTML::_('select.genericList', $this->getJSModel('age')->getAges(JText::_('JS_FROM')), 'agefrom', 'class="inputbox validate-checkagefrom ' . $age_required . '"' . '', 'value', 'text', $defaultAge);
            $lists['ageto'] = JHTML::_('select.genericList', $this->getJSModel('age')->getAges(JText::_('JS_TO')), 'ageto', 'class="inputbox validate-checkageto ' . $age_required . '"' . '', 'value', 'text', $defaultAge);

            $lists['gender'] = JHTML::_('select.genericList', $this->getJSModel('common')->getGender(JText::_('JS_DOES_NOT_MATTER')), 'gender', 'class="inputbox ' . $gender_required . '" ' . '', 'value', 'text', '');
            $lists['careerlevel'] = JHTML::_('select.genericList', $this->getJSModel('careerlevel')->getCareerLevels(JText::_('JS_SELECT')), 'careerlevel', 'class="inputbox ' . $careerlevel_required . '"' . '', 'value', 'text', $defaultCareerlevels);
            $lists['workpermit'] = JHTML::_('select.genericList', $this->getJSModel('country')->getCountries(JText::_('JS_SELECT')), 'workpermit', 'class="inputbox ' . $workpermit_required . '" ' . '', 'value', 'text', $this->_defaultcountry);
            $lists['requiredtravel'] = JHTML::_('select.genericList', $this->getJSModel('common')->getRequiredTravel(JText::_('JS_SELECT')), 'requiredtravel', 'class="inputbox ' . $requiredtravel_required . '"' . '', 'value', 'text', '');

            $lists['status'] = JHTML::_('select.genericList', $status, 'status', 'class="inputbox required" ' . '', 'value', 'text', '');
            $lists['sendemail'] = JHTML::_('select.genericList', $this->getJSModel('common')->getSendEmail(), 'sendemail', 'class="inputbox ' . $sendemail_required . '"' . '', 'value', 'text', '$this->_job->sendemail', '');
            $lists['currencyid'] = JHTML::_('select.genericList', $this->getJSModel('currency')->getCurrency(), 'currencyid', 'class="inputbox " ' . '', 'value', 'text', $defaultCurrencies);
        }

        $result[0] = $this->_job;
        $result[1] = $lists;
        $result[2] = $this->getJSModel('customfield')->getUserFieldsforForm(2, $c_id); // job fields, refid
        $result[3] = $fieldsordering;
        if (isset($multi_lists) && $multi_lists != "")
            $result[4] = $multi_lists;
        return $result;
    }

    function getAllJobs($searchtitle, $searchcompany, $searchjobcategory, $searchjobtype, $limitstart, $limit) {
        if ($searchjobcategory)
            if (is_numeric($searchjobcategory) == false)
                return false;
        if ($searchjobtype)
            if (is_numeric($searchjobtype) == false)
                return false;
        $this->checkCall();

        $db = JFactory :: getDBO();
        $result = array();
        $query = "SELECT COUNT(job.id) FROM `#__js_job_jobs` AS job
					LEFT JOIN `#__js_job_companies` AS company ON job.companyid = company.id 
					WHERE job.status <> 0";
        if ($searchtitle)
            $query .= " AND LOWER(job.title) LIKE " . $db->Quote('%' . $searchtitle . '%', false);
        if ($searchcompany)
            $query .= " AND LOWER(company.name) LIKE " . $db->Quote('%' . $searchcompany . '%', false);
        if ($searchjobcategory)
            $query .= " AND job.jobcategory = " . $searchjobcategory;
        if ($searchjobtype)
            $query .= " AND job.jobtype = " . $searchjobtype;


        $db->setQuery($query);
        $total = $db->loadResult();
        if ($total <= $limitstart)
            $limitstart = 0;

        $query = "SELECT job.*, cat.cat_title, jobtype.title AS jobtypetitle, company.name AS companyname  
				FROM `#__js_job_jobs` AS job 
				JOIN `#__js_job_categories` AS cat ON job.jobcategory = cat.id
				JOIN `#__js_job_jobtypes` AS jobtype ON job.jobtype = jobtype.id 
				LEFT JOIN `#__js_job_companies` AS company ON job.companyid = company.id 
				WHERE job.status <> 0";
        if ($searchtitle)
            $query .= " AND LOWER(job.title) LIKE " . $db->Quote('%' . $searchtitle . '%', false);
        if ($searchcompany)
            $query .= " AND LOWER(company.name) LIKE " . $db->Quote('%' . $searchcompany . '%', false);
        if ($searchjobcategory)
            $query .= " AND job.jobcategory = " . $searchjobcategory;
        if ($searchjobtype)
            $query .= " AND job.jobtype = " . $searchjobtype;

        $query .= " ORDER BY job.created DESC";


        $db->setQuery($query, $limitstart, $limit);
        $this->_application = $db->loadObjectList();

        $lists = array();

        $job_type = $this->getJSModel('jobtype')->getJobType(JText::_('JS_SELECT_JOB_TYPE'));

        $job_categories = $this->getJSModel('category')->getCategories(JText::_('JS_SELECT_JOB_CATEGORY'), '');
        if ($searchtitle)
            $lists['searchtitle'] = $searchtitle;
        if ($searchcompany)
            $lists['searchcompany'] = $searchcompany;
        if ($searchjobcategory)
            $lists['jobcategory'] = JHTML::_('select.genericList', $job_categories, 'searchjobcategory', 'class="inputbox" ' . 'onChange="this.form.submit();"' . 'style="width:115px"', 'value', 'text', $searchjobcategory);
        else
            $lists['jobcategory'] = JHTML::_('select.genericList', $job_categories, 'searchjobcategory', 'class="inputbox" ' . 'onChange="this.form.submit();"' . 'style="width:115px"', 'value', 'text', '');
        if ($searchjobtype)
            $lists['jobtype'] = JHTML::_('select.genericList', $job_type, 'searchjobtype', 'class="inputbox" ' . 'onChange="document.adminForm.submit();"', 'value', 'text', $searchjobtype);
        else
            $lists['jobtype'] = JHTML::_('select.genericList', $job_type, 'searchjobtype', 'class="inputbox" ' . 'onChange="document.adminForm.submit();"', 'value', 'text', '');

        $result[0] = $this->_application;
        $result[1] = $total;
        $result[2] = $lists;
        return $result;
    }

    function getAllJobListings($jobfor, $limitstart, $limit) {
        $db = JFactory :: getDBO();
        $result = array();
        $query = "SELECT COUNT(job.id) FROM `#__js_job_jobs` AS job
					LEFT JOIN `#__js_job_companies` AS company ON job.companyid = company.id 
					WHERE job.status <> 0";
        $db->setQuery($query);
        $total = $db->loadResult();
        if ($total <= $limitstart)
            $limitstart = 0;

        $query = "SELECT job.*, cat.cat_title, jobtype.title AS jobtypetitle, company.name AS companyname  
				FROM `#__js_job_jobs` AS job 
				JOIN `#__js_job_categories` AS cat ON job.jobcategory = cat.id
				JOIN `#__js_job_jobtypes` AS jobtype ON job.jobtype = jobtype.id 
				LEFT JOIN `#__js_job_companies` AS company ON job.companyid = company.id 
				WHERE job.status <> 0";

        $query .= " ORDER BY job.created DESC";
        $db->setQuery($query, $limitstart, $limit);
        $this->_application = $db->loadObjectList();

        $lists = array();
        $result[0] = $this->_application;
        $result[1] = $total;
        return $result;
    }

    function getAllUnapprovedJobs($searchtitle, $searchcompany, $searchjobcategory, $searchjobtype, $searchjobstatus, $limitstart, $limit) {
        if ($searchjobcategory)
            if (is_numeric($searchjobcategory) == false)
                return false;
        if ($searchjobtype)
            if (is_numeric($searchjobtype) == false)
                return false;
        if ($searchjobstatus)
            if (is_numeric($searchjobstatus) == false)
                return false;
        $db = JFactory :: getDBO();
        $result = array();
        $query = "SELECT COUNT(job.id) FROM `#__js_job_jobs` AS job
					LEFT JOIN `#__js_job_companies` AS company ON job.companyid = company.id
					WHERE job.status = 0";
        if ($searchtitle)
            $query .= " AND LOWER(job.title) LIKE " . $db->Quote('%' . $searchtitle . '%', false);
        if ($searchcompany)
            $query .= " AND LOWER(company.name) LIKE " . $db->Quote('%' . $searchcompany . '%', false);
        if ($searchjobcategory)
            $query .= " AND job.jobcategory = " . $searchjobcategory;
        if ($searchjobtype)
            $query .= " AND job.jobtype = " . $searchjobtype;
        if ($searchjobstatus)
            $query .= " AND job.jobstatus = " . $searchjobstatus;

        $db->setQuery($query);
        $total = $db->loadResult();
        if ($total <= $limitstart)
            $limitstart = 0;

        $query = "SELECT job.*, cat.cat_title, jobtype.title AS jobtypetitle, jobstatus.title AS jobstatustitle, company.name AS companyname
				FROM `#__js_job_jobs` AS job
				JOIN `#__js_job_categories` AS cat ON job.jobcategory = cat.id
				JOIN `#__js_job_jobtypes` AS jobtype ON job.jobtype = jobtype.id
				LEFT JOIN `#__js_job_jobstatus` AS jobstatus ON job.jobstatus = jobstatus.id
				LEFT JOIN `#__js_job_companies` AS company ON job.companyid = company.id
				WHERE  job.status = 0 ";
        if ($searchtitle)
            $query .= " AND LOWER(job.title) LIKE " . $db->Quote('%' . $searchtitle . '%', false);
        if ($searchcompany)
            $query .= " AND LOWER(company.name) LIKE " . $db->Quote('%' . $searchcompany . '%', false);
        if ($searchjobcategory)
            $query .= " AND job.jobcategory = " . $searchjobcategory;
        if ($searchjobtype)
            $query .= " AND job.jobtype = " . $searchjobtype;
        if ($searchjobstatus)
            $query .= " AND job.jobstatus = " . $searchjobstatus;

        $query .= " ORDER BY job.created DESC";

        $db->setQuery($query, $limitstart, $limit);
        $this->_application = $db->loadObjectList();

        $lists = array();

        $job_type = $this->getJSModel('jobtype')->getJobType(JText::_('JS_SELECT_JOB_TYPE'));
        $jobstatus = $this->getJSModel('jobstatus')->getJobStatus(JText::_('JS_SELECT_JOB_STATUS'));

        $job_categories = $this->getJSModel('category')->getCategories(JText::_('JS_SELECT_JOB_CATEGORY'), '');
        if ($searchtitle)
            $lists['searchtitle'] = $searchtitle;
        if ($searchcompany)
            $lists['searchcompany'] = $searchcompany;
        if ($searchjobcategory)
            $lists['jobcategory'] = JHTML::_('select.genericList', $job_categories, 'searchjobcategory', 'class="inputbox" ' . 'onChange="this.form.submit();"' . 'style="width:115px"', 'value', 'text', $searchjobcategory);
        else
            $lists['jobcategory'] = JHTML::_('select.genericList', $job_categories, 'searchjobcategory', 'class="inputbox" ' . 'onChange="this.form.submit();"' . 'style="width:115px"', 'value', 'text', '');
        if ($searchjobtype)
            $lists['jobtype'] = JHTML::_('select.genericList', $job_type, 'searchjobtype', 'class="inputbox" ' . 'onChange="document.adminForm.submit();"', 'value', 'text', $searchjobtype);
        else
            $lists['jobtype'] = JHTML::_('select.genericList', $job_type, 'searchjobtype', 'class="inputbox" ' . 'onChange="document.adminForm.submit();"', 'value', 'text', '');
        if ($searchjobstatus)
            $lists['jobstatus'] = JHTML::_('select.genericList', $jobstatus, 'searchjobstatus', 'class="inputbox" ' . 'onChange="document.adminForm.submit();"' . 'style="width:115px"', 'value', 'text', $searchjobstatus);
        else
            $lists['jobstatus'] = JHTML::_('select.genericList', $jobstatus, 'searchjobstatus', 'class="inputbox" ' . 'onChange="document.adminForm.submit();"' . 'style="width:115px"', 'value', 'text', '');

        $result[0] = $this->_application;
        $result[1] = $total;
        $result[2] = $lists;
        return $result;
    }

    function storeJob() {
        $row = $this->getTable('job');
        $data = JRequest :: get('post');
        $db = $this->getDBO();

        if (isset($this_config) == false)
            $this->_config = $this->getJSModel('configuration')->getConfig('');
        foreach ($this->_config as $conf) {
            if ($conf->configname == 'date_format')
                $dateformat = $conf->configvalue;
            if ($conf->configname == 'system_timeout')
                $systemtimeout = $conf->configvalue;
        }
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

        $data['startpublishing'] = date('Y-m-d H:i:s', strtotime($data['startpublishing']));
        $data['stoppublishing'] = date('Y-m-d H:i:s', strtotime($data['stoppublishing']));


        $spdate = explode("-", $data['startpublishing']);
        if ($spdate[2])
            $spdate[2] = explode(' ', $spdate[2]);
        $spdate[2] = $spdate[2][0];

        $curtime = explode(":", date('H:i:s'));

        $datetime = mktime($curtime[0], $curtime[1], $curtime[2], $spdate[1], $spdate[2], $spdate[0]);

        $data['startpublishing'] = date('Y-m-d H:i:s', $datetime);
        //time offset
        $data['startpublishing'] = date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s", strtotime($data['startpublishing'])) . $systemtimeout));

        if (!empty($data['alias']))
            $jobalias = $this->getJSModel('common')->removeSpecialCharacter($data['alias']);
        else
            $jobalias = $this->getJSModel('common')->removeSpecialCharacter($data['title']);

        $jobalias = strtolower(str_replace(' ', '-', $jobalias));
        $data['alias'] = $jobalias;

            $data['description'] = JRequest::getVar('description', '', 'post', 'string', JREQUEST_ALLOWRAW);
            $data['qualifications'] = JRequest::getVar('qualifications', '', 'post', 'string', JREQUEST_ALLOWRAW);
            $data['prefferdskills'] = JRequest::getVar('prefferdskills', '', 'post', 'string', JREQUEST_ALLOWRAW);
            $data['agreement'] = JRequest::getVar('agreement', '', 'post', 'string', JREQUEST_ALLOWRAW);
        $data['uid'] = $this->getJSModel('company')->getUidByCompanyId($data['companyid']); // Uid must be the same as the company owner id
        if ($data['id'] == '') {
            $data['jobid'] = $this->getJobId();
            $data['created'] = date('Y-m-d H:i:s');
        }
        if (!$row->bind($data)) {
            $this->setError($this->_db->getErrorMsg());
            echo $this->_db->getErrorMsg();
            return false;
        }
        $check_return = $row->check();

        if ($check_return != 1) {
            $this->setError($this->_db->getErrorMsg());
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
        $this->getJSModel('customfield')->storeUserFieldData($data, $row->id);

        if ($this->_client_auth_key != "") {
            $query = "SELECT job.* FROM `#__js_job_jobs` AS job  
						WHERE job.id = " . $row->id;

            $db->setQuery($query);
            $data_job = $db->loadObject();
            if ($data['id'] != "" AND $data['id'] != 0)
                $data_job->id = $data['id']; // for edit case
            $data_job->job_id = $row->id;
            $data_job->authkey = $this->_client_auth_key;
            $data_job->task = 'storejob';
            $jsjobsharingobject = $this->getJSModel('jobsharing');
            $return_value = $jsjobsharingobject->storeJobSharing($data_job);
            $jobtemp = $this->getJSModel('common')->getJobtempModelFrontend();
            $jobtemp->updateJobTemp();
            $jsjobslogobject = $this->getJSModel('log');
            $jsjobslogobject->logStoreJobSharing($return_value);
        }
        return true;
    }

    function storeMultiCitiesJob($city_id, $jobid) { // city id comma seprated 
        if (is_numeric($jobid) === false)
            return false;
        $db = JFactory::getDBO();
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

    function deleteJob() {
        $db = JFactory::getDBO();
        $cids = JRequest :: getVar('cid', array(0), 'post', 'array');
        $row = $this->getTable('job');
        $deleteall = 1;
        foreach ($cids as $cid) {
            $serverjodid = 0;
            if ($this->_client_auth_key != "") {
                $query = "SELECT job.serverid AS id FROM `#__js_job_jobs` AS job WHERE job.id = " . $cid;
                $db->setQuery($query);
                $s_job_id = $db->loadResult();
                $serverjodid = $s_job_id;
            }
            if ($this->jobCanDelete($cid) == true) {
                if (!$row->delete($cid)) {
                    $this->setError($row->getErrorMsg());
                    return false;
                }
                $query = "DELETE FROM `#__js_job_jobcities` WHERE jobid = " . $cid;
                $db->setQuery($query);
                if (!$db->query()) {
                    return false;
                }
                $this->getJSModel('customfield')->deleteUserFieldData($cid);
                if ($serverjodid != 0) {
                    $data = array();
                    $data['id'] = $serverjodid;
                    $data['referenceid'] = $cid;
                    $data['uid'] = $this->_uid;
                    $data['authkey'] = $this->_client_auth_key;
                    $data['siteurl'] = $this->_siteurl;
                    $data['task'] = 'deletejob';
                    $jsjobsharingobject = $this->getJSModel('jobsharing');
                    $return_value = $jsjobsharingobject->deleteJobSharing($data);
                    $jobtemp = $this->getJSModel('common')->getJobtempModelFrontend();
                    $jobtemp->updateJobTemp();
                    $jsjobslogobject = $this->getJSModel('log');
                    $jsjobslogobject->logDeleteJobSharing($return_value);
                }
            }
            else
                $deleteall++;
        }
        return $deleteall;
    }

    function jobCanDelete($jobid) {
        if (is_numeric($jobid) == false)
            return false;
        $db = $this->getDBO();
        $query = "SELECT
                    ( SELECT COUNT(id) FROM `#__js_job_jobapply` WHERE jobid = " . $jobid . ")
                    AS total ";
        $db->setQuery($query);
        $total = $db->loadResult();
        if ($total > 0)
            return false;
        else
            return true;
    }

    function jobEnforceDelete($jobid, $uid) {
        if ($uid)
            if ((is_numeric($uid) == false) || ($uid == 0) || ($uid == ''))
                return false;
        if (is_numeric($jobid) == false)
            return false;
        $serverjodid = 0;
        if ($this->_client_auth_key != "") {
            $query = "SELECT job.serverid AS id FROM `#__js_job_jobs` AS job WHERE job.id = " . $jobid;
            $db->setQuery($query);
            $s_job_id = $db->loadResult();
            $serverjodid = $s_job_id;
        }

        $db = $this->getDBO();
        $query = "DELETE  job,apply,jobcity
                    FROM `#__js_job_jobs` AS job
                    LEFT JOIN `#__js_job_jobapply` AS apply ON job.id=apply.jobid
                    LEFT JOIN `#__js_job_jobcities` AS jobcity ON job.id=jobcity.jobid
                    WHERE job.id = " . $jobid;

        $db->setQuery($query);
        if (!$db->query()) {
            return 2; //error while delete job
        }
        $this->getJSModel('customfield')->deleteUserFieldData($jobid);
        if ($serverjodid != 0) {
            $data = array();
            $data['id'] = $serverjodid;
            $data['referenceid'] = $jobid;
            $data['uid'] = $this->_uid;
            $data['authkey'] = $this->_client_auth_key;
            $data['siteurl'] = $this->_siteurl;
            $data['enforcedeletejob'] = 1;
            $data['task'] = 'deletejob';
            $jsjobsharingobject = $this->getJSModel('jobsharing');
            $return_value = $jsjobsharingobject->deleteJobSharing($data);
            $jsjobslogobject = $this->getJSModel('log');
            $jsjobslogobject->logDeleteJobSharingEnforce($return_value);
        }
        return 1;
    }

    function checkCall() {
        $db = JFactory::getDBO();
        $query = "UPDATE `#__js_job_config` SET configvalue = configvalue+1 WHERE configname = " . $db->quote('jsjobupdatecount');
        $db->setQuery($query);
        $db->query();
        $query = "SELECT configvalue AS jsjobupdatecount FROM `#__js_job_config` WHERE configname = " . $db->quote('jsjobupdatecount');
        $db->setQuery($query);
        $result = $db->loadResult();
        if ($result >= 100)
            $this->getJSModel('jsjobs')->concurrentrequestdata();
    }

    function jobApprove($job_id) {
        if (is_numeric($job_id) == false)
            return false;
        $db = JFactory::getDBO();

        $query = "UPDATE #__js_job_jobs SET status = 1 WHERE id = " . $db->Quote($job_id);
        $db->setQuery($query);
        if (!$db->query()) {
            return false;
        }
        $this->getJSModel('emailtemplate')->sendMail(2, 1, $job_id);
        $this->getJSModel('emailtemplate')->sendMail(4, 1, $job_id);

        if ($this->_client_auth_key != "") {
            $data_job_approve = array();
            $query = "SELECT serverid FROM #__js_job_jobs WHERE id = " . $job_id;
            $db->setQuery($query);
            $serverjobid = $db->loadResult();
            $data_job_approve['id'] = $serverjobid;
            $data_job_approve['job_id'] = $job_id;
            $data_job_approve['authkey'] = $this->_client_auth_key;
            $fortask = "jobapprove";
            $server_json_data_array = json_encode($data_job_approve);
            $jsjobsharingobject = $this->getJSModel('jobsharing');
            $return_server_value = $jsjobsharingobject->serverTask($server_json_data_array, $fortask);
            $return_value = json_decode($return_server_value, true);
            $jsjobslogobject = $this->getJSModel('log');
            $jsjobslogobject->logJobApprove($return_value);
        }
        return true;
        //register_sfunction jobReject($job_id) {
        if (is_numeric($job_id) == false)
            return false;
        $db = JFactory::getDBO();

        $query = "UPDATE #__js_job_jobs SET status = -1 WHERE id = " . $db->Quote($job_id);
        $db->setQuery($query);
        if (!$db->query()) {
            return false;
        }
        $this->getJSModel('emailtemplate')->sendMail(2, -1, $job_id);
        if ($this->_client_auth_key != "") {
            $data_job_reject = array();
            $query = "SELECT serverid FROM #__js_job_jobs WHERE id = " . $job_id;
            $db->setQuery($query);
            $serverjobid = $db->loadResult();
            $data_job_reject['id'] = $serverjobid;
            $data_job_reject['job_id'] = $job_id;
            $data_job_reject['authkey'] = $this->_client_auth_key;
            $fortask = "jobreject";
            $server_json_data_array = json_encode($data_job_reject);
            $jsjobsharingobject = $this->getJSModel('jobsharing');
            $return_server_value = $jsjobsharingobject->serverTask($server_json_data_array, $fortask);
            $return_value = json_decode($return_server_value, true);
            $jsjobslogobject = $this->getJSModel('log');
            $jsjobslogobject->logJobReject($return_value);
        }
        return true;
    }

    function getJobId() {
        $db = $this->getDBO();
        $query = "Select jobid from `#__js_job_jobs`";
        do {

            $jobid = "";
            $length = 9;
            $possible = "2346789bcdfghjkmnpqrtvwxyzBCDFGHJKLMNPQRTVWXYZ!@#";
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

    function getJobSearch($title, $jobcategory, $jobsubcategory, $jobtype, $jobstatus, $salaryrangefrom, $salaryrangeto, $salaryrangetype, $shift, $durration, $startpublishing, $stoppublishing, $company, $city, $zipcode, $currency, $longitude, $latitude, $radius, $radius_length_type, $keywords, $limit, $limitstart) {
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
        $result = array();
        $db = $this->getDBO();
        if (!isset($this->_config)) {
            $this->_config = $this->getJSModel('configuration')->getConfig('');
        }
        foreach ($this->_config as $conf) {
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
        $listjobconfig = $this->getJSModel('configuration')->getConfigByFor('listjob');
        $issalary = '';
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
            $query = "SELECT salfrom.rangestart
			FROM `#__js_job_salaryrange` AS salfrom
			WHERE salfrom.id = " . $salaryrangefrom;
            $db->setQuery($query);
            $rangestart_value = $db->loadResult();
            $wherequery .= " AND salaryrangefrom.rangestart >= " . $rangestart_value;
            $issalary = 1;
        }
        if ($salaryrangeto != '') {
            $query = "SELECT salto.rangestart
			FROM `#__js_job_salaryrange` AS salto
			WHERE salto.id = " . $salaryrangeto;
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

        $curdate = date('Y-m-d');
        $query = "SELECT count(DISTINCT job.id) FROM `#__js_job_jobs` AS job 
					JOIN `#__js_job_categories` AS cat ON job.jobcategory = cat.id
					LEFT JOIN `#__js_job_salaryrange` AS salaryrangefrom ON job.salaryrangefrom = salaryrangefrom.id
					LEFT JOIN `#__js_job_salaryrange` AS salaryrangeto ON job.salaryrangeto = salaryrangeto.id";
        $query .= " LEFT JOIN `#__js_job_jobcities` AS mjob ON mjob.jobid = job.id ";

        $query .= " LEFT JOIN `#__js_job_currencies` AS currency ON currency.id = job.currencyid ";
        $query .= "	WHERE job.status = 1 ";
        if ($startpublishing == '')
            $query .= " AND DATE(job.startpublishing) <= " . $db->Quote($curdate);
        if ($stoppublishing == '')
            $query .= " AND DATE(job.stoppublishing) >= " . $db->Quote($curdate);
        $query .= $wherequery;
        $db->setQuery($query);
        $total = $db->loadResult();
        if ($total <= $limitstart)
            $limitstart = 0;
        $limitstart = 0;

        $query = "SELECT DISTINCT job.*, cat.cat_title, jobtype.title AS jobtypetitle, jobstatus.title AS jobstatustitle
				, salaryrangefrom.rangestart AS salaryfrom, salaryrangeto.rangeend AS salaryend 
				, company.name AS companyname, company.url
				FROM `#__js_job_jobs` AS job
				JOIN `#__js_job_categories` AS cat ON job.jobcategory = cat.id
				JOIN `#__js_job_jobtypes` AS jobtype ON job.jobtype = jobtype.id
				LEFT JOIN `#__js_job_jobstatus` AS jobstatus ON job.jobstatus = jobstatus.id
				LEFT JOIN `#__js_job_companies` AS company ON job.companyid = company.id
				LEFT JOIN `#__js_job_salaryrange` AS salaryrangefrom ON job.salaryrangefrom = salaryrangefrom.id
				LEFT JOIN `#__js_job_salaryrange` AS salaryrangeto ON job.salaryrangeto = salaryrangeto.id";
        $query .= " LEFT JOIN `#__js_job_jobcities` AS mjob ON mjob.jobid = job.id ";
        $query .= " LEFT JOIN `#__js_job_currencies` AS currency ON currency.id = job.currencyid ";
        $query .= " WHERE  job.status = 1 ";
        if ($startpublishing == '')
            $query .= " AND DATE(job.startpublishing) <= " . $db->Quote($curdate);
        if ($stoppublishing == '')
            $query .= " AND DATE(job.stoppublishing) >= " . $db->Quote($curdate);
        if ($currency != '')
            $query.= " AND currency.id = job.currencyid ";

        $query .= $wherequery;
        $db->setQuery($query, $limitstart, $limit);
        $this->_applications = $db->loadObjectList();
        foreach ($this->_applications AS $searchdata) {  // for multicity select 
            $multicitydata = $this->getMultiCityData($searchdata->id);
            if ($multicitydata != "")
                $searchdata->city = $multicitydata;
        }
        $result[0] = $this->_applications;
        $result[1] = $total;
        $result[2] = $listjobconfig;

        return $result;
    }
    function jobReject($job_id) {
        if (is_numeric($job_id) == false)
            return false;
        $db = & JFactory::getDBO();

        $query = "UPDATE #__js_job_jobs SET status = -1 WHERE id = " . $db->Quote($job_id);
        $db->setQuery($query);
        if (!$db->query()) {
            return false;
        }
        $this->getJSModel('emailtemplate')->sendMail(2, -1, $job_id);
        if ($this->_client_auth_key != "") {
            $data_job_reject = array();
            $query = "SELECT serverid FROM #__js_job_jobs WHERE id = " . $job_id;
            $db->setQuery($query);
            $serverjobid = $db->loadResult();
            $data_job_reject['id'] = $serverjobid;
            $data_job_reject['job_id'] = $job_id;
            $data_job_reject['authkey'] = $this->_client_auth_key;
            $fortask = "jobreject";
            $server_json_data_array = json_encode($data_job_reject);
            $jsjobsharingobject = new JSJobsModelJobSharing;
            $return_server_value = $jsjobsharingobject->serverTask($server_json_data_array, $fortask);
            return json_decode($return_server_value, true);
        } else {
            return true;
        }
    }

}

?>