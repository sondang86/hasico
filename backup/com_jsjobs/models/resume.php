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

class JSJobsModelResume extends JSModel {

    var $_uid = null;
    var $_client_auth_key = null;
    var $_siteurl = null;
    var $_application = null;
    var $_empoptions = null;

    function __construct() {
        parent :: __construct();
        $this->_client_auth_key = $this->getJSModel('common')->getClientAuthenticationKey();
        $this->_siteurl = JURI::root();
        $user = JFactory::getUser();
        $this->_uid = $user->id;
    }

    function resumesearch($sh_gender, $sh_nationality, $sh_category, $sh_subcategory, $sh_jobtype, $sh_heighesteducation, $sh_salaryrange, $plugin) {
        $db = JFactory::getDBO();
        // Gender *********************************************
        if ($sh_gender == 1) {
            $genders = array(
                '0' => array('value' => '', 'text' => JText::_('JS_SELECT_GENDER')),
                '1' => array('value' => 1, 'text' => JText::_('JS_MALE')),
                '2' => array('value' => 2, 'text' => JText::_('JS_FEMALE')),);
            $gender = JHTML::_('select.genericList', $genders, 'gender', 'class="inputbox" style="width:160px;" ' . '', 'value', 'text', '');
        }
        // Natinality *********************************************
        if ($sh_nationality == 1) {
            $query = "SELECT * FROM `#__js_job_countries` WHERE enabled = 1 ORDER BY name ASC ";
            $db->setQuery($query);
            $rows = $db->loadObjectList();
            if (isset($rows)) {
                $countries = array();
                $countries[] = array('value' => JText::_(''), 'text' => JText::_('JS_CHOOSE_COUNTRY'));
                foreach ($rows as $row) {
                    $countries[] = array('value' => $row->id, 'text' => JText::_($row->name));
                }
            }
            $nationality = JHTML::_('select.genericList', $countries, 'nationality', 'class="inputbox" style="width:160px;" ' . '', 'value', 'text', '');
        }

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
                $job_categories = JHTML::_('select.genericList', $jobcategories, 'jobcategory', 'class="inputbox" style="width:160px;" ' . 'onChange="plgfj_getsubcategories(\'plgresumefj_subcategory\', this.value)"', 'value', 'text', '');
            else
                $job_categories = JHTML::_('select.genericList', $jobcategories, 'jobcategory', 'class="inputbox" style="width:160px;" ' . 'onChange="modfj_getsubcategories(\'modresumefj_subcategory\', this.value)"', 'value', 'text', '');
        }
        // Sub Categories *********************************************
        if ($sh_subcategory == 1) {
            $jobsubcategories = array();
            $jobsubcategories[] = array('value' => JText::_(''), 'text' => JText::_('JS_SELECT_SUB_CATEGORY'));
            $job_subcategories = JHTML::_('select.genericList', $jobsubcategories, 'jobsubcategory', 'class="inputbox" style="width:160px;" ' . '', 'value', 'text', '');
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
        //Job Heighest Education  *********************************************
        if ($sh_heighesteducation == 1) {
            $query = "SELECT id, title FROM `#__js_job_heighesteducation` WHERE isactive = 1 ORDER BY id ASC ";
            $db->setQuery($query);
            $rows = $db->loadObjectList();
            if (isset($rows)) {
                $heighesteducation = array();
                $heighesteducation[] = array('value' => JText::_(''), 'text' => JText::_('JS_SELECT_HIGHEST_EDUCATION'));
                foreach ($rows as $row)
                    $heighesteducation[] = array('value' => JText::_($row->id), 'text' => JText::_($row->title));
            }
            $heighest_finisheducation = JHTML::_('select.genericList', $heighesteducation, 'heighestfinisheducation', 'class="inputbox" style="width:160px;" ' . '', 'value', 'text', '');
        }

        // Salary Rnage *********************************************
        if ($sh_salaryrange == 1) {
            $query = "SELECT * FROM `#__js_job_salaryrange` ORDER BY 'id' ";
            $db->setQuery($query);
            $rows = $db->loadObjectList();
            if (isset($rows)) {
                $jobsalaryrange = array();
                $jobsalaryrange[] = array('value' => JText::_(''), 'text' => JText::_('JS_SELECT_SALARY_RANGE'));
                foreach ($rows as $row) {
                    $salrange = $row->rangestart . ' - ' . $row->rangeend;
                    $jobsalaryrange[] = array('value' => JText::_($row->id), 'text' => JText::_($salrange));
                }
            }
            $salary_range = JHTML::_('select.genericList', $jobsalaryrange, 'jobsalaryrange', 'class="inputbox" style="width:50%;" ' . '', 'value', 'text', '');
            // currencies 
            $currencycombo = $this->getJSModel('currency')->getCurrencyCombo();
        }
        if (isset($gender))
            $result[0] = $gender;
        if (isset($nationality))
            $result[1] = $nationality;
        if (isset($job_categories))
            $result[2] = $job_categories;
        if (isset($job_type))
            $result[3] = $job_type;
        if (isset($heighest_finisheducation))
            $result[4] = $heighest_finisheducation;
        if (isset($salary_range))
            $result[5] = $salary_range;
        if (isset($currencycombo))
            $result[6] = $currencycombo;
        if (isset($job_subcategories))
            $result[7] = $job_subcategories;
        return $result;
    }

    function getTopResumes($noofresumes, $theme) {

        $db = JFactory::getDBO();
        $dateformat = $this->getJSModel('configurations')->getConfigValue('date_format');
        $data_directory = $this->getJSModel('configurations')->getConfigValue('data_directory');
        $this->getJSModel('common')->setTheme();

        $id = "resume.id AS id";
        $alias = ",CONCAT(resume.alias,'-',resume.id) AS resumealiasid ";
        $query = "SELECT resume.packageid,resume.id AS resumeid,
		 $id, resume.application_title AS applicationtitle, CONCAT(resume.first_name, resume.last_name) AS name 
		, resume.gender, resume.iamavailable AS available, resume.photo, resume.heighestfinisheducation
		, resume.total_experience AS experiencetitle, resume.create_date AS created, resume.address_country, resume.address_state
		, resume.address_county, resume.address_city, cat.cat_title, jobtype.title AS jobtypetitle
		, country.name AS countryname, state.name AS statename,  city.name AS cityname, nationality.name AS nationalityname
		$alias
		 
		FROM `#__js_job_resume` AS resume 
			LEFT JOIN `#__js_job_categories` AS cat ON resume.job_category = cat.id 
			LEFT JOIN `#__js_job_jobtypes` AS jobtype ON resume.jobtype = jobtype.id 
			LEFT JOIN `#__js_job_currencies` AS currency ON currency.id = resume.currencyid 
			LEFT JOIN `#__js_job_heighesteducation` AS highesteducation ON highesteducation.id = resume.heighestfinisheducation
			LEFT JOIN `#__js_job_salaryrange` AS salrange ON salrange.id = resume.jobsalaryrange
            LEFT JOIN `#__js_job_cities` AS city ON city.id=resume.address_city  
            LEFT JOIN `#__js_job_states` AS state ON city.stateid=state.id  
            LEFT JOIN `#__js_job_countries` AS country ON city.countryid=country.id 
            LEFT JOIN `#__js_job_countries` AS nationality ON nationality.id=resume.nationality 
			WHERE resume.status = 1 
			ORDER BY resume.hits DESC LIMIT {$noofresumes}";
        $db->setQuery($query);
        $result[0] = $db->loadObjectList();
        $result[2] = $dateformat;
        $result[3] = $data_directory;
        return $result;
    }

    function getNewestResumes($noofresumes, $theme) {
        $db = JFactory::getDBO();
        $dateformat = $this->getJSModel('configurations')->getConfigValue('date_format');
        $data_directory = $this->getJSModel('configurations')->getConfigValue('data_directory');
        $this->getJSModel('common')->setTheme();

        $id = "resume.id AS id";
        $alias = ",CONCAT(resume.alias,'-',resume.id) AS resumealiasid ";
        $query = "SELECT resume.packageid,resume.id AS resumeid,
		 $id, resume.application_title AS applicationtitle, CONCAT(resume.first_name,' ',resume.last_name) AS name 
		, resume.gender, resume.iamavailable AS available, resume.photo, resume.heighestfinisheducation
		, resume.total_experience AS experiencetitle, resume.create_date AS created, resume.address_country, resume.address_state
		, resume.address_county, resume.address_city, cat.cat_title, jobtype.title AS jobtypetitle
		, country.name AS countryname, state.name AS statename,  city.name AS cityname, nationality.name AS nationalityname
		$alias
		 
		FROM `#__js_job_resume` AS resume 
			LEFT JOIN `#__js_job_categories` AS cat ON resume.job_category = cat.id 
			LEFT JOIN `#__js_job_jobtypes` AS jobtype ON resume.jobtype = jobtype.id 
            LEFT JOIN `#__js_job_cities` AS city ON city.id=resume.address_city  
            LEFT JOIN `#__js_job_states` AS state ON city.stateid=state.id  
            LEFT JOIN `#__js_job_countries` AS country ON city.countryid=country.id 
            LEFT JOIN `#__js_job_countries` AS nationality ON nationality.id=resume.nationality 

			LEFT JOIN `#__js_job_heighesteducation` AS education ON resume.heighestfinisheducation = education.id 
			LEFT JOIN `#__js_job_salaryrange` AS salary ON resume.jobsalaryrange = salary.id 
			LEFT JOIN `#__js_job_currencies` AS currency ON currency.id = resume.currencyid 

			WHERE resume.status = 1 ORDER BY create_date DESC LIMIT {$noofresumes}";
        $db->setQuery($query);
        $resume = $db->loadObjectList();

        $result[0] = $resume;
        $result[2] = $dateformat;
        $result[3] = $data_directory;

        return $result;
    }

    function getEmpOptions() {
        if (!$this->_empoptions) {
            $this->_empoptions = array();
            $gender = array(
                '0' => array('value' => 1, 'text' => JText::_('JS_MALE')),
                '1' => array('value' => 2, 'text' => JText::_('JS_FEMALE')),);
            $fieldOrdering = $this->getJSModel('customfields')->getFieldsOrdering(3); // resume fields
            $nationality_required = '';
            $gender_required = '';
            $category_required = '';
            $subcategory_required = '';
            $salary_required = '';
            $workpreference_required = '';
            $education_required = '';
            $expsalary_required = '';
            foreach ($fieldOrdering AS $fo) {
                switch ($fo->field) {
                    case "nationality":
                        $nationality_required = ($fo->required ? 'required' : '');
                        break;
                    case "gender":
                        $gender_required = ($fo->required ? 'required' : '');
                        break;
                    case "category":
                        $category_required = ($fo->required ? 'required' : '');
                        break;
                    case "subcategory":
                        $subcategory_required = ($fo->required ? 'required' : '');
                        break;
                    case "salary":
                        $salary_required = ($fo->required ? 'required' : '');
                        break;
                    case "jobtype":
                        $workpreference_required = ($fo->required ? 'required' : '');
                        break;
                    case "heighesteducation":
                        $education_required = ($fo->required ? 'required' : '');
                        break;
                    case "desiredsalary":
                        $expsalary_required = ($fo->required ? 'required' : '');
                        break;
                }
            }



            $defaultCategory = $this->getJSModel('common')->getDefaultValue('categories');
            $defaultJobtype = $this->getJSModel('common')->getDefaultValue('jobtypes');
            $defaultEducation = $this->getJSModel('common')->getDefaultValue('heighesteducation');
            $defaultSalaryrange = $this->getJSModel('common')->getDefaultValue('salaryrange');
            $defaultSalaryrangeType = $this->getJSModel('common')->getDefaultValue('salaryrangetypes');
            $defaultCurrencies = $this->getJSModel('common')->getDefaultValue('currencies');

            $job_type = $this->getJSModel('jobtype')->getJobType('');
            $heighesteducation = $this->getJSModel('highesteducation')->getHeighestEducation('');
            $job_categories = $this->getJSModel('category')->getCategories('');
            $job_salaryrange = $this->getJSModel('salaryrange')->getJobSalaryRange('', '');
            $job_salaryrangetype = $this->getJSModel('salaryrangetype')->getJobSalaryRangeType(JText::_('JS_SELECT_RANGE_TYPE'));
            $countries = $this->getJSModel('countries')->getCountries('');
            if (isset($this->_application)) {
                $job_subcategories = $this->getJSModel('subcategory')->getSubCategoriesforCombo($this->_application->job_category, '', $this->_application->job_subcategory);
            } else {
                $job_subcategories = $this->getJSModel('subcategory')->getSubCategoriesforCombo($defaultCategory, '', '');
            }
            if (isset($this->_application)) {
                $this->_empoptions['nationality'] = JHTML::_('select.genericList', $countries, 'nationality', 'class="inputbox ' . $nationality_required . ' jsjobs-cbo" ' . '', 'value', 'text', $this->_application->nationality);
                $this->_empoptions['gender'] = JHTML::_('select.genericList', $gender, 'gender', 'class="inputbox ' . $gender_required . ' jsjobs-cbo" ' . '', 'value', 'text', $this->_application->gender);

                $this->_empoptions['job_category'] = JHTML::_('select.genericList', $job_categories, 'job_category', 'class="inputbox ' . $category_required . ' jsjobs-cbo" ' . 'onChange="fj_getsubcategories(\'fj_subcategory\', this.value)"', 'value', 'text', $this->_application->job_category);
                $this->_empoptions['job_subcategory'] = JHTML::_('select.genericList', $job_subcategories, 'job_subcategory', 'class="inputbox ' . $subcategory_required . ' jsjobs-cbo" ' . '', 'value', 'text', $this->_application->job_subcategory);

                $this->_empoptions['jobtype'] = JHTML::_('select.genericList', $job_type, 'jobtype', 'class="inputbox ' . $workpreference_required . ' jsjobs-cbo" ' . '', 'value', 'text', $this->_application->jobtype);
                $this->_empoptions['heighestfinisheducation'] = JHTML::_('select.genericList', $heighesteducation, 'heighestfinisheducation', 'class="inputbox ' . $education_required . ' jsjobs-cbo" ' . '', 'value', 'text', $this->_application->heighestfinisheducation);
                $this->_empoptions['jobsalaryrange'] = JHTML::_('select.genericList', $job_salaryrange, 'jobsalaryrange', 'class="inputbox ' . $salary_required . ' jsjobs-cbo" ' . '', 'value', 'text', $this->_application->jobsalaryrange);
                $this->_empoptions['desired_salary'] = JHTML::_('select.genericList', $job_salaryrange, 'desired_salary', 'class="inputbox ' . $expsalary_required . ' jsjobs-cbo" ' . '', 'value', 'text', $this->_application->desired_salary);
                $this->_empoptions['jobsalaryrangetypes'] = JHTML::_('select.genericList', $job_salaryrangetype, 'jobsalaryrangetype', 'class="inputbox jsjobs-cbo" ' . '', 'value', 'text', $this->_application->jobsalaryrangetype);
                $this->_empoptions['djobsalaryrangetypes'] = JHTML::_('select.genericList', $job_salaryrangetype, 'djobsalaryrangetype', 'class="inputbox jsjobs-cbo" ' . '', 'value', 'text', $this->_application->djobsalaryrangetype);
                $this->_empoptions['currencyid'] = JHTML::_('select.genericList', $this->getJSModel('currency')->getCurrency(), 'currencyid', 'class="inputbox jsjobs-cbo" ' . '', 'value', 'text', $this->_application->currencyid);
                $this->_empoptions['dcurrencyid'] = JHTML::_('select.genericList', $this->getJSModel('currency')->getCurrency(), 'dcurrencyid', 'class="inputbox jsjobs-cbo" ' . '', 'value', 'text', $this->_application->dcurrencyid);

                $address_city = ($this->_application->address_city == "" OR $this->_application->address_city == 0 ) ? -1 : $this->_application->address_city;
                $this->_empoptions['address_city'] = $this->getJSModel('cities')->getAddressDataByCityName('', $address_city);
                $address1_city = ($this->_application->address1_city == "" OR $this->_application->address1_city == 0 ) ? -1 : $this->_application->address1_city;
                $this->_empoptions['address1_city'] = $this->getJSModel('cities')->getAddressDataByCityName('', $address1_city);
                $address2_city = ($this->_application->address2_city == "" OR $this->_application->address2_city == 0 ) ? -1 : $this->_application->address2_city;
                $this->_empoptions['address2_city'] = $this->getJSModel('cities')->getAddressDataByCityName('', $address2_city);
                $institute_city = ($this->_application->institute_city == "" OR $this->_application->institute_city == 0 ) ? -1 : $this->_application->institute_city;
                $this->_empoptions['institute_city'] = $this->getJSModel('cities')->getAddressDataByCityName('', $institute_city);
                $institute1_city = ($this->_application->institute1_city == "" OR $this->_application->institute1_city == 0 ) ? -1 : $this->_application->institute1_city;
                $this->_empoptions['institute1_city'] = $this->getJSModel('cities')->getAddressDataByCityName('', $institute1_city);
                $institute2_city = ($this->_application->institute2_city == "" OR $this->_application->institute2_city == 0 ) ? -1 : $this->_application->institute2_city;
                $this->_empoptions['institute2_city'] = $this->getJSModel('cities')->getAddressDataByCityName('', $institute2_city);
                $institute3_city = ($this->_application->institute3_city == "" OR $this->_application->institute3_city == 0 ) ? -1 : $this->_application->institute3_city;
                $this->_empoptions['institute3_city'] = $this->getJSModel('cities')->getAddressDataByCityName('', $institute3_city);
                $employer_city = ($this->_application->employer_city == "" OR $this->_application->employer_city == 0 ) ? -1 : $this->_application->employer_city;
                $this->_empoptions['employer_city'] = $this->getJSModel('cities')->getAddressDataByCityName('', $employer_city);
                $employer1_city = ($this->_application->employer1_city == "" OR $this->_application->employer1_city == 0 ) ? -1 : $this->_application->employer1_city;
                $this->_empoptions['employer1_city'] = $this->getJSModel('cities')->getAddressDataByCityName('', $employer1_city);
                $employer2_city = ($this->_application->employer2_city == "" OR $this->_application->employer2_city == 0 ) ? -1 : $this->_application->employer2_city;
                $this->_empoptions['employer2_city'] = $this->getJSModel('cities')->getAddressDataByCityName('', $employer2_city);
                $employer3_city = ($this->_application->employer3_city == "" OR $this->_application->employer3_city == 0 ) ? -1 : $this->_application->employer3_city;
                $this->_empoptions['employer3_city'] = $this->getJSModel('cities')->getAddressDataByCityName('', $employer3_city);
                $reference_city = ($this->_application->reference_city == "" OR $this->_application->reference_city == 0 ) ? -1 : $this->_application->reference_city;
                $this->_empoptions['reference_city'] = $this->getJSModel('cities')->getAddressDataByCityName('', $reference_city);
                $reference1_city = ($this->_application->reference1_city == "" OR $this->_application->reference1_city == 0 ) ? -1 : $this->_application->reference1_city;
                $this->_empoptions['reference1_city'] = $this->getJSModel('cities')->getAddressDataByCityName('', $reference1_city);
                $reference2_city = ($this->_application->reference2_city == "" OR $this->_application->reference2_city == 0 ) ? -1 : $this->_application->reference2_city;
                $this->_empoptions['reference2_city'] = $this->getJSModel('cities')->getAddressDataByCityName('', $reference2_city);
                $reference3_city = ($this->_application->reference3_city == "" OR $this->_application->reference3_city == 0 ) ? -1 : $this->_application->reference3_city;
                $this->_empoptions['reference3_city'] = $this->getJSModel('cities')->getAddressDataByCityName('', $reference3_city);
            } else {
                $this->_empoptions['nationality'] = JHTML::_('select.genericList', $countries, 'nationality', 'class="inputbox ' . $nationality_required . ' jsjobs-cbo" ' . '', 'value', 'text', '');
                $this->_empoptions['gender'] = JHTML::_('select.genericList', $gender, 'gender', 'class="inputbox ' . $gender_required . ' jsjobs-cbo" ' . '', 'value', 'text', '');

                $this->_empoptions['job_category'] = JHTML::_('select.genericList', $job_categories, 'job_category', 'class="inputbox ' . $category_required . ' jsjobs-cbo" ' . 'onChange="fj_getsubcategories(\'fj_subcategory\', this.value)"', 'value', 'text', $defaultCategory);
                $this->_empoptions['job_subcategory'] = JHTML::_('select.genericList', $job_subcategories, 'job_subcategory', 'class="inputbox ' . $subcategory_required . ' jsjobs-cbo" ' . '', 'value', 'text', '');

                $this->_empoptions['jobtype'] = JHTML::_('select.genericList', $job_type, 'jobtype', 'class="inputbox ' . $workpreference_required . ' jsjobs-cbo" ' . '', 'value', 'text', $defaultJobtype);
                $this->_empoptions['heighestfinisheducation'] = JHTML::_('select.genericList', $heighesteducation, 'heighestfinisheducation', 'class="inputbox ' . $education_required . ' jsjobs-cbo" ' . '', 'value', 'text', $defaultEducation);
                $this->_empoptions['jobsalaryrange'] = JHTML::_('select.genericList', $job_salaryrange, 'jobsalaryrange', 'class="inputbox ' . $salary_required . ' jsjobs-cbo" ' . '', 'value', 'text', $defaultSalaryrange);
                $this->_empoptions['jobsalaryrangetypes'] = JHTML::_('select.genericList', $job_salaryrangetype, 'jobsalaryrangetype', 'class="inputbox jsjobs-cbo" ' . '', 'value', 'text', $defaultSalaryrangeType);
                $this->_empoptions['djobsalaryrangetypes'] = JHTML::_('select.genericList', $job_salaryrangetype, 'djobsalaryrangetype', 'class="inputbox jsjobs-cbo" ' . '', 'value', 'text', $defaultSalaryrangeType);


                $this->_empoptions['desired_salary'] = JHTML::_('select.genericList', $job_salaryrange, 'desired_salary', 'class="inputbox ' . $expsalary_required . ' jsjobs-cbo" ' . '', 'value', 'text', $defaultSalaryrange);
                $this->_empoptions['currencyid'] = JHTML::_('select.genericList', $this->getJSModel('currency')->getCurrency(), 'currencyid', 'class="inputbox jsjobs-cbo" ' . '', 'value', 'text', $defaultCurrencies);
                $this->_empoptions['dcurrencyid'] = JHTML::_('select.genericList', $this->getJSModel('currency')->getCurrency(), 'dcurrencyid', 'class="inputbox jsjobs-cbo" ' . '', 'value', 'text', $defaultCurrencies);
            }
        }
        return $this->_empoptions;
    }

    function getMyResumesbyUid($u_id, $sortby, $limit, $limitstart) {
        $db = $this->getDBO();
        if (is_numeric($u_id) == false)
            return false;
        $result = array();
        $resumeconfig = $this->getJSModel('configurations')->getConfigByFor('searchresume');
        $query = "SELECT COUNT(id) FROM `#__js_job_resume` WHERE uid  = " . $u_id;
        $db->setQuery($query);
        $total = $db->loadResult();
        if ($total <= $limitstart)
            $limitstart = 0;

        $query = "SELECT resume.* , category.cat_title, jobtype.title AS jobtypetitle, salary.rangestart, salary.rangeend
                    , country.name AS countryname,city.name AS cityname,state.name AS statename
                    , currency.symbol		
                    ,CONCAT(resume.alias,'-',resume.id) AS resumealiasid
                    ,salarytype.title AS salarytype
                    FROM `#__js_job_resume` AS resume
                    LEFT JOIN  `#__js_job_categories` AS category ON	resume.job_category = category.id
                    LEFT JOIN  `#__js_job_salaryrange` AS salary	ON	resume.jobsalaryrange = salary.id
                    LEFT JOIN  `#__js_job_jobtypes` AS jobtype ON resume.jobtype = jobtype.id
                    LEFT JOIN  `#__js_job_salaryrangetypes` AS salarytype ON resume.jobsalaryrangetype = salarytype.id
                    LEFT JOIN `#__js_job_cities` AS city ON resume.address_city= city.id
                    LEFT JOIN `#__js_job_states` AS state ON city.stateid= state.id
                    LEFT JOIN `#__js_job_countries` AS country ON city.countryid = country.id
                    LEFT JOIN `#__js_job_currencies` AS currency ON currency.id= resume.currencyid
                    WHERE resume.uid  = " . $u_id . "
                    ORDER BY " . $sortby;
        $db->setQuery($query);
        $db->setQuery($query, $limitstart, $limit);
        $this->_applications = $db->loadObjectList();

        $result[0] = $this->_applications;
        $result[1] = $total;
        $result[2] = $resumeconfig;

        return $result;
    }

    function getResumebyId($id, $u_id) {
        $db = $this->getDBO();
        if (is_numeric($u_id) == false)
            return false;
        if (($id != '') && ($id != 0)) {
            if (is_numeric($id) == false)
                return false;
            $query = "SELECT * FROM `#__js_job_resume` WHERE id = " . $id . " AND uid  = " . $u_id;
            $db->setQuery($query);
            $this->_application = $db->loadObject();
            $result[0] = $this->_application;
        }
        if ($u_id != "" AND $u_id != 0)
            $result[3] = $this->getJSModel('customfields')->getFieldsOrdering(3); // resume fields
        else
            $result[3] = $this->getJSModel('customfields')->getFieldsOrdering(16); // resume visitor fields

        $result[2] = $this->getJSModel('customfields')->getUserFields(3, $id); // job fields , ref id
        $session = JFactory::getSession();
        $visitor = $session->get('jsjob_jobapply');
        
        if ($id || $visitor) { // not new
            if (!defined('VALIDATE')) {
                define('VALIDATE', 'VALIDATE');
            }
            $result[4] = VALIDATE;
        } else { // new
            $result[4] = $this->getJSModel('permissions')->checkPermissionsFor('ADD_RESUME');
            $result[5] = $this->getPackageDetailByUid($u_id);
        }

        return $result;
    }

    function getPackageDetailByUid($uid){
        if(!is_numeric($uid)) return false;
        $pacakges[0] = 0;
        $pacakges[1] = 0;
        $db = $this->getDbo();
        $query = "SELECT package.id, payment.id AS paymentid
                   FROM `#__js_job_jobseekerpackages` AS package
                   JOIN `#__js_job_paymenthistory` AS payment ON ( payment.packageid = package.id AND payment.packagefor=2)
                   WHERE payment.uid = " . $uid . " 
                   AND payment.transactionverified = 1 AND payment.status = 1 ORDER BY payment.created DESC";
        $db->setQuery($query);
        $packagedetail = $db->loadObjectList();
        if(!empty($packagedetail)){ // user have pacakge
            foreach($packagedetail AS $package){
                $pacakges[0] = $package->id;
                $pacakges[1] = $package->paymentid;
            }
            return $pacakges;
        }else{ // user have no package
            return $pacakges;
        }
    }
    
    function canAddNewResume($uid) {
        if(!is_numeric($uid)) return false;
        $db = $this->getDbo();
        $query = "SELECT package.id, package.resumeallow, package.packageexpireindays, payment.id AS paymentid, payment.created
                    FROM `#__js_job_jobseekerpackages` AS package
                    JOIN `#__js_job_paymenthistory` AS payment ON (payment.packageid = package.id AND payment.packagefor=2)
                    WHERE payment.uid = " . $uid . "
                    AND DATE_ADD(payment.created,INTERVAL package.packageexpireindays DAY) >= CURDATE()
                    AND payment.transactionverified = 1 AND payment.status = 1";
        $db->setQuery($query);
        $valid_packages = $db->loadObjectList();
        if(empty($valid_packages)){ // User have no valid package
            // check if user have any package or not
            $query = "SELECT package.id, package.resumeallow,package.title AS packagetitle, package.packageexpireindays, payment.id AS paymentid
                        , (TO_DAYS( CURDATE() ) - To_days( payment.created ) ) AS packageexpiredays
                       FROM `#__js_job_jobseekerpackages` AS package
                       JOIN `#__js_job_paymenthistory` AS payment ON ( payment.packageid = package.id AND payment.packagefor=2)
                       WHERE payment.uid = " . $uid . " 
                       AND payment.transactionverified = 1 AND payment.status = 1 ORDER BY payment.created DESC";
            $db->setQuery($query);
            $packagedetail = $db->loadObjectList();
            if(empty($packagedetail)){ // User have no package
                return NO_PACKAGE;
            }else{ // User have packages but are expired
                return EXPIRED_PACKAGE;
            }
        }else{ // user have valid package
            // check is it allow to add new resume
            $unlimited = 0;
            $resumeallow = 0;
            foreach ($valid_packages AS $resume) {
                if ($unlimited == 0) {
                    if ($resume->resumeallow != -1) {
                        $resumeallow = $resume->resumeallow + $resumeallow;
                    } else {
                        $unlimited = 1;
                    }
                }
            }
            if($unlimited == 0){ // user doesn't have unlimited resume package
                if($resumeallow == 0){
                    return RESUME_LIMIT_EXCEEDS;
                }
                //get total resume count
                $query = "SELECT COUNT(resume.id) AS totalresumes FROM `#__js_job_resume` AS resume WHERE resume.uid = " . $uid;
                $db->setQuery($query);
                $totalresume = $db->loadResult();
                if ($resumeallow <= $totalresume) {
                    return RESUME_LIMIT_EXCEEDS;
                }else{
                    return VALIDATE;
                }
            }else{ // user have unlimited resume package
                return VALIDATE;
            }
            
        }
    }

    function getMyResumes($u_id) {

        $db = $this->getDBO();
        if ($u_id)
            if ((is_numeric($u_id) == false) || ($u_id == 0) || ($u_id == ''))
                return false;

        $totalresume = 0;

        $query = "SELECT id, application_title, create_date, status 
		FROM `#__js_job_resume` WHERE status = 1 AND uid = " . $u_id;
        $db->setQuery($query);
        $rows = $db->loadObjectList();
        if ($db->getErrorNum()) {
            echo $db->stderr();
            return false;
        }
        $resumes = array();
        foreach ($rows as $row) {
            $resumes[] = array('value' => $row->id, 'text' => $row->application_title);
            $totalresume++;
        }
        $myresymes = JHTML::_('select.genericList', $resumes, 'cvid', 'class="inputbox required" ' . '', 'value', 'text', '');
        $mycoverletters = $this->getJSModel('coverletter')->getMyCoverLetters($u_id);
        $result[0] = $myresymes;
        $result[1] = $totalresume;
        $result[2] = $mycoverletters[0];
        return $result;
    }

    function getResumeViewbyId($uid, $jobid, $id, $myresume, $sort = false, $tabaction = false) {
        if ((is_numeric($uid) == false) || ($uid == 0) || ($uid == ''))
            return false;
        if ($jobid)
            if (is_numeric($jobid) == false)
                return false;
        $db = $this->getDBO();
        if ($myresume == 2)
            $resume_issharing_data = 1;
        elseif ($myresume == 7) { //folderresumeview
            $resume_issharing_data = 1;
            $jobid = 0;
        } elseif ($myresume == 6) { //pdf resume
            $resume_issharing_data = 1;
        }
        else
            $resume_issharing_data = 0;
        if ($resume_issharing_data == 1) {
            if ($this->_client_auth_key != "") {
                if ($myresume == 3) {
                    $query = "SELECT id FROM #__js_job_jobs WHERE serverid = " . $jobid;
                    //echo $query;
                    $db->setQuery($query);
                    $server_jobid = $db->loadResult();
                    if ($server_jobid)
                        $jobid = $server_jobid;
                    $query = "SELECT id FROM #__js_job_resume WHERE serverid = " . $id;
                    //echo $query;
                    $db->setQuery($query);
                    $server_resumeid = $db->loadResult();
                    if ($server_resumeid)
                        $id = $server_resumeid;
                }
            }
        }

        if ($myresume == 1) {

            $query = "SELECT COUNT(id) FROM #__js_job_resume WHERE uid = " . $uid . " AND id = " . $id;
            //echo '<br>sql '.$query;
            $db->setQuery($query);
            $total = $db->loadResult();
            if ($total == 0)
                $canview = 0;
            else
                $canview = 1;
        }else {
            if (!isset($this->_config)) {
                $this->_config = $this->getJSModel('configurations')->getConfig('');
            }
            foreach ($this->_config as $conf) {
                if ($conf->configname == 'js_newlisting_requiredpackage')
                    $newlisting_required_package = $conf->configvalue;
            }

            if ($newlisting_required_package == 0) {
                $unlimited = 1;
            } else {
                $query = "SELECT package.viewresumeindetails, package.packageexpireindays, package.resumesearch, payment.created
                            FROM `#__js_job_employerpackages` AS package
                            JOIN `#__js_job_paymenthistory` AS payment ON (payment.packageid = package.id AND payment.packagefor=1)
                            WHERE payment.uid = " . $uid . "
                            AND DATE_ADD(payment.created,INTERVAL package.packageexpireindays DAY) >= CURDATE()
                            AND payment.transactionverified = 1 AND payment.status = 1";
                //echo $query;
                $db->setQuery($query);
                $jobs = $db->loadObjectList();
                $unlimited = 0;
                $canview = 0;
                $resumesearch = 0;
                $viewresumeindetails = 0;

                foreach ($jobs AS $job) {
                    if ($unlimited == 0) {
                        if ($job->viewresumeindetails != -1) {
                            $viewresumeindetails = $viewresumeindetails + $job->viewresumeindetails;
                            $resumesearch = $resumesearch + $job->resumesearch;
                        }
                        else
                            $unlimited = 1;
                    }
                }
            }

            if ($unlimited == 0) {
                if ($viewresumeindetails == 0)
                    $canview = 0; //can not add new job
                if ($jobid != '') {
                    $query = "SELECT SUM(apply.resumeview) AS totalview FROM `#__js_job_jobapply` AS apply WHERE apply.jobid = " . $jobid;
                    //echo $query;
                    $db->setQuery($query);
                    $totalview = $db->loadResult();
                    if ($viewresumeindetails >= $totalview)
                        $canview = 1; //can not add new job
                    else
                        $canview = 0;
                    if ($myresume == 3)
                        $canview = 1; // search resume
                }else {
                    if ($resumesearch > 0)
                        $canview = 1;
                    else
                        $canview = 0;
                }
            }elseif ($unlimited == 1)
                $canview = 1; // unlimited
        }
        if ($canview == 0) { // check already view this resume
            if ($jobid != '') {
                $query = "SELECT resumeview FROM `#__js_job_jobapply` AS apply WHERE apply.jobid = " . $jobid . " AND cvid = " . $id;

                $db->setQuery($query);
                $apply = $db->loadObject();
                if ($apply->resumeview == 1)
                    $canview = 1; //already view this resume
                else
                    $canview = 0;
            }
            else
                $canview = 0;
        }
        if ($canview == 1) {

            if (is_numeric($id) == false)
                return false;
            //echo '<br> Table';

            if ($this->_client_auth_key != "" && $resume_issharing_data == 1) {

                $query = "SELECT serverid FROM #__js_job_jobs WHERE id = " . $jobid;
                //echo $query;
                $db->setQuery($query);
                $_jobid = $db->loadResult();
                //$jobid = $_jobid;

                $query = "SELECT serverid FROM #__js_job_resume WHERE id = " . $id;
                //echo $query;
                $db->setQuery($query);
                $_resumeid = $db->loadResult();
                //$id = $_resumeid;
                $data_resumedetail = array();
                $data_resumedetail['uid'] = $uid;
                $data_resumedetail['jobid'] = $jobid;
                $data_resumedetail['resumeid'] = $id;
                $data_resumedetail['authkey'] = $this->_client_auth_key;
                $data_resumedetail['siteurl'] = $this->_siteurl;
                $fortask = "getresumeviewbyid";
                $jsjobsharingobject = $this->getJSModel('jobsharingsite');
                $encodedata = json_encode($data_resumedetail);
                $return_server_value = $jsjobsharingobject->serverTask($encodedata, $fortask);
                if (isset($return_server_value['resumeviewbyid']) AND $return_server_value['resumeviewbyid'] == -1) { // auth fail 
                    $logarray['uid'] = $this->_uid;
                    $logarray['referenceid'] = $return_server_value['referenceid'];
                    $logarray['eventtype'] = $return_server_value['eventtype'];
                    $logarray['message'] = $return_server_value['message'];
                    $logarray['event'] = "Resume View";
                    $logarray['messagetype'] = "Error";
                    $logarray['datetime'] = date('Y-m-d H:i:s');
                    $jsjobsharingobject->write_JobSharingLog($logarray);
                    $result[0] = (object) array('id' => 0);
                    $result[1] = (object) array();
                    $result[2] = (object) array();
                    $result[3] = $this->getJSModel('customfields')->getFieldsOrdering(3); // resume fields
                    $result[4] = 0; // can view
                    $result[5] = (object) array();
                    $result[6] = array();
                } else {
                    $result[0] = (object) $return_server_value[0];
                    $result[1] = (object) $return_server_value[1];
                    $result[2] = (object) $return_server_value[2];
                    $result[3] = $this->getJSModel('customfields')->getFieldsOrdering(3); // resume fields
                    $result[4] = 1; // can view
                    $result[5] = (object) $return_server_value[5];
                    $resumeuserfields = $return_server_value[6];
                    //$result[6] = json_decode($resumeuserfields['userfields']);
                    $result[6] = json_decode($resumeuserfields['userfields']);
                }
            } else {

                $query = "SELECT app.* , cat.cat_title AS categorytitle, salary.rangestart, salary.rangeend, jobtype.title AS jobtypetitle
                            ,heighesteducation.title AS heighesteducationtitle
                            , nationality_country.name AS nationalitycountry
                            , address_city.name AS address_city2 ,  address_state.name AS address_state2 , address_country.name AS address_country
                            , address1_city.name AS address1_city2 , address1_state.name AS address1_state2 , address1_country.name AS address1_country
                            , address2_city.name AS address2_city2 , address2_state.name AS address2_state2 , address2_country.name AS address2_country
                            , currency.symbol
                            , CONCAT(app.alias,'-',app.id) AS resumealiasid 
							,salarytype.title AS salarytype
                            
                            FROM `#__js_job_resume` AS app
                            LEFT JOIN `#__js_job_categories` AS cat ON app.job_category = cat.id
                            LEFT JOIN `#__js_job_jobtypes` AS jobtype ON app.jobtype = jobtype.id
                            LEFT JOIN `#__js_job_heighesteducation` AS heighesteducation ON app.heighestfinisheducation = heighesteducation.id
                            LEFT JOIN `#__js_job_countries` AS nationality_country ON app.nationality = nationality_country.id
                            LEFT JOIN `#__js_job_salaryrange` AS salary ON app.jobsalaryrange = salary.id
							LEFT JOIN  `#__js_job_salaryrangetypes` AS salarytype ON app.jobsalaryrangetype = salarytype.id
                            LEFT JOIN `#__js_job_cities` AS address_city ON app.address_city = address_city.id
                            LEFT JOIN `#__js_job_states` AS address_state ON address_city.stateid = address_state.id
                            LEFT JOIN `#__js_job_countries` AS address_country ON address_city.countryid = address_country.id
                            LEFT JOIN `#__js_job_cities` AS address1_city ON app.address1_city = address1_city.id
                            LEFT JOIN `#__js_job_states` AS address1_state ON address1_city.stateid = address1_state.id
                            LEFT JOIN `#__js_job_countries` AS address1_country ON address1_city.countryid = address1_country.id
                            LEFT JOIN `#__js_job_cities` AS address2_city ON app.address2_city = address2_city.id
                            LEFT JOIN `#__js_job_states` AS address2_state ON address2_city.stateid = address2_state.id
                            LEFT JOIN `#__js_job_countries` AS address2_country ON address2_city.countryid = address2_country.id
                            LEFT JOIN `#__js_job_currencies` AS currency ON currency.id = app.currencyid

                            WHERE app.id = " . $id;
                $query2 = "SELECT app.id
                            , institute_city.name AS institute_city2 , institute_state.name AS institute_state2 , institute_country.name AS institute_country
                            , institute1_city.name AS institute1_city2 , institute1_state.name AS institute1_state2 , institute1_country.name AS institute1_country
                            , institute2_city.name AS institute2_city2 , institute2_state.name AS institute2_state2 , institute2_country.name AS institute2_country
                            , institute3_city.name AS institute3_city2 , institute3_state.name AS institute3_state2 , institute3_country.name AS institute3_country

                            , employer_city.name AS employer_city2 , employer_state.name AS employer_state2 , employer_country.name AS employer_country
                            , employer1_city.name AS employer1_city2 , employer1_state.name AS employer1_state2 , employer1_country.name AS employer1_country
                            , employer2_city.name AS employer2_city2 , employer2_state.name AS employer2_state2 , employer2_country.name AS employer2_country
                            , employer3_city.name AS employer3_city2 , employer3_state.name AS employer3_state2 , employer3_country.name AS employer3_country

                            FROM `#__js_job_resume` AS app

                            LEFT JOIN `#__js_job_cities` AS institute_city ON app.institute_city = institute_city.id
                            LEFT JOIN `#__js_job_states` AS institute_state ON institute_city.stateid = institute_state.id
                            LEFT JOIN `#__js_job_countries` AS institute_country ON institute_city.countryid = institute_country.id

                            LEFT JOIN `#__js_job_cities` AS institute1_city ON app.institute1_city = institute1_city.id
                            LEFT JOIN `#__js_job_states` AS institute1_state ON institute1_city.stateid = institute1_state.id
                            LEFT JOIN `#__js_job_countries` AS institute1_country ON institute1_city.countryid = institute1_country.id
                            LEFT JOIN `#__js_job_cities` AS institute2_city ON app.institute2_city = institute2_city.id
                            LEFT JOIN `#__js_job_states` AS institute2_state ON institute2_city.stateid = institute2_state.id
                            LEFT JOIN `#__js_job_countries` AS institute2_country ON institute2_city.countryid = institute2_country.id
                            LEFT JOIN `#__js_job_cities` AS institute3_city ON app.institute3_city = institute3_city.id
                            LEFT JOIN `#__js_job_states` AS institute3_state ON institute3_city.stateid = institute3_state.id
                            LEFT JOIN `#__js_job_countries` AS institute3_country ON institute3_city.countryid = institute3_country.id


                            LEFT JOIN `#__js_job_cities` AS employer_city ON app.employer_city = employer_city.id
                            LEFT JOIN `#__js_job_states` AS employer_state ON employer_city.stateid = employer_state.id
                            LEFT JOIN `#__js_job_countries` AS employer_country ON employer_city.countryid = employer_country.id
                            LEFT JOIN `#__js_job_cities` AS employer1_city ON app.employer1_city = employer1_city.id
                            LEFT JOIN `#__js_job_states` AS employer1_state ON employer1_city.stateid = employer1_state.id
                            LEFT JOIN `#__js_job_countries` AS employer1_country ON employer1_city.countryid = employer1_country.id
                            LEFT JOIN `#__js_job_cities` AS employer2_city ON app.employer2_city = employer2_city.id
                            LEFT JOIN `#__js_job_states` AS employer2_state ON employer2_city.stateid = employer2_state.id
                            LEFT JOIN `#__js_job_countries` AS employer2_country ON employer2_city.countryid = employer2_country.id
                            LEFT JOIN `#__js_job_cities` AS employer3_city ON app.employer3_city = employer3_city.id
                            LEFT JOIN `#__js_job_states` AS employer3_state ON employer3_city.stateid = employer3_state.id
                            LEFT JOIN `#__js_job_countries` AS employer3_country ON employer3_city.countryid = employer3_country.id

                            WHERE app.id = " . $id;

                $db->setQuery('SET SQL_BIG_SELECTS=1');
                $db->query();

                $db->setQuery($query);
                $resume = $db->loadObject();

                $db->setQuery($query2);
                $resume2 = $db->loadObject();
                $result[0] = $resume;
                $result[1] = $resume2;
                $result[2] = $this->getResumeViewbyId3($id);
                if ($jobid != '') {
                    $query = "UPDATE `#__js_job_jobapply` SET resumeview = 1 WHERE jobid = " . $jobid . " AND cvid = " . $id;
                    $db->setQuery($query);
                    $db->query();
                }

                $query = "UPDATE `#__js_job_resume` SET hits = hits + 1 WHERE id = " . $id;
                $db->setQuery($query);
                if (!$db->query()) {
                    //return false;
                }
                $coverletter = null;
                if ($jobid != '') {
                    //Select the cover letter id
                    $query = "SELECT cl.coverletterid,cl.apply_date FROM `#__js_job_jobapply` AS cl WHERE cl.jobid = " . $jobid . " AND cl.cvid = " . $id;
                    $db->setQuery($query);
                    $coverletter = $db->loadObject();
                }
                $result[3] = $this->getJSModel('customfields')->getFieldsOrdering(3); // resume fields
                $result[4] = 1; // can view
                $result[5] = $coverletter;
                $fieldfor = 3;
                $resume_userfields = $this->getJSModel('customfields')->getUserFieldsForView($fieldfor, $id); // company fields, id
                $result[6] = $resume_userfields;

                // get the next resume ids for view the next resume when employer come to view the resume
                $cvids = false;
                if ($sort != false && $tabaction != false) {
                    $query = "SELECT apply.cvid 
                                FROM `#__js_job_jobapply` AS apply 
                                JOIN `#__js_job_jobs` AS job ON job.id = apply.jobid
                                JOIN `#__js_job_resume` AS app ON app.id = apply.cvid
                                WHERE apply.jobid = " . $jobid . " AND apply.action_status = " . $tabaction . " ORDER BY " . $sort;
                    $db->setQuery($query);
                    $cvids = $db->loadObjectList();
                }
                $result[8] = $cvids; // for emplyer resume navigations
            }
        } else {
            $result[4] = 0; // can not view
        }
        return $result;
    }

    function getResumeViewbyId3($id) {
        if (is_numeric($id) == false)
            return false;
        $db = $this->getDBO();
        $query = "SELECT app.id
                    , reference_city.name AS reference_city2 , reference_state.name AS reference_state2 , reference_country.name AS reference_country 
                    , reference1_city.name AS reference1_city2 , reference1_state.name AS reference1_state2 , reference1_country.name AS reference1_country 
                    , reference2_city.name AS reference2_city2 , reference2_state.name AS reference2_state2 , reference2_country.name AS reference2_country 
                    , reference3_city.name AS reference3_city2 , reference3_state.name AS reference3_state2 , reference3_country.name AS reference3_country 

                    FROM `#__js_job_resume` AS app 



                    LEFT JOIN `#__js_job_cities` AS reference_city ON app.reference_city = reference_city.id
                    LEFT JOIN `#__js_job_states` AS reference_state ON reference_city.stateid = reference_state.id 
                    LEFT JOIN `#__js_job_countries` AS reference_country ON reference_city.countryid = reference_country.id
                    LEFT JOIN `#__js_job_cities` AS reference1_city ON app.reference1_city = reference1_city.id
                    LEFT JOIN `#__js_job_states` AS reference1_state ON reference1_city.stateid = reference1_state.id 
                    LEFT JOIN `#__js_job_countries` AS reference1_country ON reference1_city.countryid = reference1_country.id
                    LEFT JOIN `#__js_job_cities` AS reference2_city ON app.reference2_city = reference2_city.id
                    LEFT JOIN `#__js_job_states` AS reference2_state ON reference2_city.stateid = reference2_state.id
                    LEFT JOIN `#__js_job_countries` AS reference2_country ON reference2_city.countryid = reference2_country.id
                    LEFT JOIN `#__js_job_cities` AS reference3_city ON app.reference3_city = reference3_city.id
                    LEFT JOIN `#__js_job_states` AS reference3_state ON reference3_city.stateid = reference3_state.id 
                    LEFT JOIN `#__js_job_countries` AS reference3_country ON reference3_city.countryid = reference3_country.id 

                    WHERE app.id = " . $id;
        $db->setQuery($query);
        $resume = $db->loadObject();
        return $resume;
    }

    function deleteResume($resumeid, $uid) {
        $db = $this->getDBO();
        $row = $this->getTable('resume');
        $data = JRequest :: get('post');

        if ((is_numeric($uid) == false) || ($uid == 0) || ($uid == ''))
            return false;
        if (is_numeric($resumeid) == false)
            return false;
        $serverresumeid = 0;
        if ($this->_client_auth_key != "") {
            $query = "SELECT resume.serverid AS id 
						FROM `#__js_job_resume` AS resume
						WHERE resume.id = " . $resumeid;
            $db->setQuery($query);
            $s_resume_id = $db->loadResult();
            $serverresumeid = $s_resume_id;
        }
        $returnvalue = $this->resumeCanDelete($resumeid, $uid);
        if ($returnvalue == 1) {
            if (!$row->delete($resumeid)) {
                $this->setError($row->getErrorMsg());
                return false;
            }
            $this->getJSModel('customfields')->deleteUserFieldData($resumeid);
            if ($serverresumeid != 0) {
                $data = array();
                $data['id'] = $serverresumeid;
                $data['referenceid'] = $resumeid;
                $data['uid'] = $this->_uid;
                $data['authkey'] = $this->_client_auth_key;
                $data['siteurl'] = $this->_siteurl;
                $data['task'] = 'deleteresume';
                $jsjobsharingobject = $this->getJSModel('jobsharingsite');
                $return_value = $jsjobsharingobject->delete_ResumeSharing($data);
                $job_log_object = $this->getJSModel('log');
                $job_log_object->log_Delete_ResumeSharing($return_value);
            }
        }
        else
            return $returnvalue;

        return true;
    }

    function resumeCanDelete($resumeid, $uid) {
        if ((is_numeric($uid) == false) || ($uid == 0) || ($uid == ''))
            return false;
        $db = $this->getDBO();

        $query = "SELECT COUNT(resume.id) FROM `#__js_job_resume` AS resume WHERE resume.id = " . $resumeid . " AND resume.uid = " . $uid;
        $db->setQuery($query);
        $resumetotal = $db->loadResult();

        if ($resumetotal > 0) { // this resume is same user
            $query = "SELECT 
                        ( SELECT COUNT(id) FROM `#__js_job_jobapply` WHERE cvid = " . $resumeid . ") 
                        AS total ";
            //echo '<br> SQL '.$query;
            $db->setQuery($query);
            $total = $db->loadResult();

            if ($total > 0)
                return 2;
            else
                return 1;
        }
        else
            return 3; // 	this resume is not of this user		
    }

    function storeResume($jobid) {
        global $resumedata;
        $jobsharing = $this->getJSModel('jobsharingsite');
        $job_log_object = $this->getJSModel('log');
        $row = $this->getTable('resume');
        $resumedata = JRequest :: get('post');
        //	if ( !$resumedata['id'] ){
        if (!$this->_config)
            $this->_config = $this->getJSModel('configurations')->getConfig('');
        foreach ($this->_config as $conf) {
            if ($conf->configname == 'empautoapprove')
                if (!$resumedata['id'])
                    $resumedata['status'] = $conf->configvalue;
            if ($conf->configname == 'resume_photofilesize')
                $photofilesize = $conf->configvalue;
            if ($conf->configname == 'date_format')
                $dateformat = $conf->configvalue;
        }
        //	}
        //spam checking
        $config = $this->getJSModel('configurations')->getConfigByFor('default');
        if ($resumedata['uid'] == 0 && $config['resume_captcha'] == 1) {
            if ($config['captchause'] == 0) {
                JPluginHelper::importPlugin('captcha');
                if (JVERSION < 3)
                    $dispatcher = JDispatcher::getInstance();
                else
                    $dispatcher = JEventDispatcher::getInstance();
                $res = $dispatcher->trigger('onCheckAnswer', $data['recaptcha_response_field']);
                if (!$res[0]) {
                    $result = 8;
                    return $result;
                }
            } else {
                if (!$this->getJSModel('common')->performChecks()) {
                    $result = 8;
                    return $result;
                }
            }
        }


        if ($dateformat == 'm/d/Y') {
            if ($resumedata['date_start'] != '') {
                $arr = explode('/', $resumedata['date_start']);
                $data['date_start'] = $arr[2] . '/' . $arr[0] . '/' . $arr[1];
            }
            if ($resumedata['date_of_birth'] != '') {
                $arr = explode('/', $resumedata['date_of_birth']);
                $resumedata['date_of_birth'] = $arr[2] . '/' . $arr[0] . '/' . $arr[1];
            }
        } elseif ($dateformat == 'd-m-Y') {
            if ($resumedata['date_start'] != '') {
                $arr = explode('-', $resumedata['date_start']);
                $resumedata['date_start'] = $arr[2] . '-' . $arr[1] . '-' . $arr[0];
            }
            if ($resumedata['date_of_birth'] != '') {
                $arr = explode('-', $resumedata['date_of_birth']);
                $resumedata['date_of_birth'] = $arr[2] . '-' . $arr[1] . '-' . $arr[0];
            }
        }
        if ($resumedata['date_start'] != '') {
            $resumedata['date_start'] = date('Y-m-d H:i:s', strtotime($resumedata['date_start']));
        }
        if ($resumedata['date_of_birth'] != '') {
            $resumedata['date_of_birth'] = date('Y-m-d H:i:s', strtotime($resumedata['date_of_birth']));
        }

        $resumedata['resume'] = JRequest::getVar('resume', '', 'post', 'string', JREQUEST_ALLOWRAW);
        $file_size_increase = 0;
        if ($_FILES['photo']['size'] > 0) {
            $uploadfilesize = $_FILES['photo']['size'];
            $uploadfilesize = $uploadfilesize / 1024; //kb
            if ($uploadfilesize > $photofilesize) { // logo
                $file_size_increase = 1;  //return 7 file size error	
            }
        }
        if (isset($resumedata['deleteresumefile']) && ($resumedata['deleteresumefile'] == 1)) {
            $resumedata['filename'] = '';
            $resumedata['filecontent'] = '';
        }
        if (isset($resumedata['deletephoto']) && ($resumedata['deletephoto'] == 1)) {
            $resumedata['photo'] = '';
        }
        if (!empty($resumedata['alias']))
            $resumealias = $this->getJSModel('common')->removeSpecialCharacter($resumedata['alias']);
        else
            $resumealias = $this->getJSModel('common')->removeSpecialCharacter($resumedata['application_title']);

        $resumealias = strtolower(str_replace(' ', '-', $resumealias));
        $resumedata['alias'] = $resumealias;

        if (!$row->bind($resumedata)) {
            $this->setError($this->_db->getErrorMsg());
            return false;
        }

        if (!$row->check()) {
            $this->setError($this->_db->getErrorMsg());
            return 2;
        }

        if (!$row->store()) {
            $this->setError($this->_db->getErrorMsg());
            return false;
        }

        $filemismatch = 0;
        $resumereturnvalue = $this->uploadResume($row->id);
        if (empty($resumereturnvalue) OR $resumereturnvalue == 6) {
            $filemismatch = 1;
        } else {
            $upload_resume_file_real_path = $resumereturnvalue;
        }
        $photomismatch = 0;
        if ($file_size_increase != 1) {
            $returnvalue = $this->uploadPhoto($row->id);
            if (empty($returnvalue) OR $returnvalue == 6) {
                $photomismatch = 1;
            } else {
                $upload_pic_real_path = $returnvalue;
            }
        }
        $this->getJSModel('customfields')->storeUserFieldData($resumedata, $row->id);
        if ($resumedata['id'] == '') {
            $this->getJSModel('adminemail')->sendMailtoAdmin($row->id, $resumedata['uid'], 3); //only for new
        }

        if ($this->_client_auth_key != "") {
            $resume_picture = array();
            $resume_file = array();

            $db = $this->getDBO();
            $query = "SELECT resume.* FROM `#__js_job_resume` AS resume WHERE resume.id = " . $row->id;
            //echo '<br> SQL '.$query;
            $db->setQuery($query);
            $data_resume = $db->loadObject();
            if ($resumedata['id'] != "" AND $resumedata['id'] != 0)
                $data_resume->id = $resumedata['id']; // for edit case
            else
                $data_resume->id = ''; // for new case
            if ($_FILES['photo']['size'] > 0)
                $resume_picture['picfilename'] = $upload_pic_real_path;
            if ($_FILES['resumefile']['size'] > 0)
                $resume_file['resume_file'] = $upload_resume_file_real_path;

            $data_resume->resume_id = $row->id;
            $data_resume->authkey = $this->_client_auth_key;
            $data_resume->task = 'storeresume';
            $jsjobsharingobject = $this->getJSModel('jobsharingsite');
            $return_value = $jsjobsharingobject->store_ResumeSharing($data_resume);
            if ($return_value['isresumestore'] == 0)
                $job_log_object->log_Store_ResumeSharing($return_value);
            $status_resume_pic = "";
            if ($file_size_increase != 1) {
                if ($photomismatch != 1) {
                    if ($_FILES['photo']['size'] > 0)
                        $return_value_resume_pic = $jsjobsharingobject->store_ResumePicSharing($data_resume, $resume_picture);
                    if (isset($return_value_resume_pic)) {
                        if ($return_value_resume_pic['isresumestore'] == 0 OR $return_value_resume_pic == false)
                            $status_resume_pic = -1;
                        else
                            $status_resume_pic = 1;
                    }
                }
            }
            $status_resume_file = "";
            if ($filemismatch != 1) {
                if ($_FILES['resumefile']['size'] > 0)
                    $return_value_resume_file = $jsjobsharingobject->store_ResumeFileSharing($data_resume, $resume_file);
                if (isset($return_value_resume_file)) {
                    if ($return_value_resume_file['isresumestore'] == 0 OR $return_value_resume_file == false)
                        $status_resume_file = -1;
                    else
                        $status_resume_file = 1;
                }
            }

            if (($status_resume_pic == -1 AND $status_resume_file == -1) OR ($filemismatch == 1 AND $photomismatch == 1)) {// file type mismatch 
                $return_value['message'] = "Resume Save But Error Uploading Resume File and Picture";
            } elseif (($status_resume_pic == -1) OR ($photomismatch == 1)) {// file type mismatch 
                $return_value['message'] = "Resume Save But Error Uploading Picture";
            } elseif (($status_resume_file == -1) OR ($filemismatch == 1)) { // file type mismatch 
                $return_value['message'] = "Resume Save But Error Uploading file";
            }
            if ($jobid) { // for visitor case 
                if ($return_value['isresumestore'] == 1) {
                    if ($return_value['status'] == "Resume Edit") {
                        $serverresumestatus = "ok";
                    } elseif ($return_value['status'] == "Resume Add") {
                        $serverresumestatus = "ok";
                    } elseif ($return_data['status'] == "Edit Resume Userfield") {
                        $serverresumestatus = "ok";
                    } elseif ($return_data['status'] == "Add Resume Userfield") {
                        $serverresumestatus = "ok";
                    }
                    $logarray['uid'] = $this->_uid;
                    $logarray['referenceid'] = $return_value['referenceid'];
                    $logarray['eventtype'] = $return_value['eventtype'];
                    $logarray['message'] = $return_value['message'];
                    $logarray['event'] = "Visitor Resume";
                    $logarray['messagetype'] = "Sucessfully";
                    $logarray['datetime'] = date('Y-m-d H:i:s');
                    $jobsharing->write_JobSharingLog($logarray);
                    $jobsharing->Update_ServerStatus($serverresumestatus, $logarray['referenceid'], $return_value['serverid'], $logarray['uid'], 'resume');
                    $resume_update = 1;
                } elseif ($return_value['isresumestore'] == 0) {
                    if ($return_value['status'] == "Data Empty") {
                        $serverresumestatus = "Data not post on server";
                    } elseif ($return_value['status'] == "Resume Saving Error") {
                        $serverresumestatus = "Error Resume Saving";
                    } elseif ($return_value['status'] == "Auth Fail") {
                        $serverresumestatus = "Authentication Fail";
                    } elseif ($return_data['status'] == "Error Save Resume Userfield") {
                        $serverresumestatus = "Error Save Resume Userfield";
                    } elseif ($return_value['status'] == "Improper Resume name") {
                        $serverresumestatus = "Improper Resume name";
                    }
                    $logarray['uid'] = $this->_uid;
                    $logarray['referenceid'] = $return_value['referenceid'];
                    $logarray['eventtype'] = $return_value['eventtype'];
                    $logarray['message'] = $return_value['message'];
                    $logarray['event'] = "Visitor Resume";
                    $logarray['messagetype'] = "Error";
                    $logarray['datetime'] = date('Y-m-d H:i:s');
                    $serverid = 0;
                    $jobsharing->write_JobSharingLog($logarray);
                    $jobsharing->Update_ServerStatus($serverresumestatus, $logarray['referenceid'], $serverid, $logarray['uid'], 'resume');
                    $resume_update = 0;
                }
                if ($resume_update == 1) {
                    return true;
                }else {
                    return false;
                }
            } else {
                $job_log_object->log_Store_ResumeSharing($return_value);
            }
        }
        if ($file_size_increase == 1)
            return 7;
        elseif (($filemismatch == 1) OR ($photomismatch == 1))
            return 6;
        return true;
    }

    function uploadResume($id) {

        if (is_numeric($id) == false)
            return false;
        $row = $this->getTable('resume');
        global $resumedata;
        $db = JFactory::getDBO();
        $iddir = 'resume_' . $id;
        if (!isset($this->_config))
            $this->_config = $this->getJSModel('configurations')->getConfig('');

        foreach ($this->_config as $conf) {
            if ($conf->configname == 'data_directory')
                $datadirectory = $conf->configvalue;
            if ($conf->configname == 'document_file_type')
                $document_file_types = $conf->configvalue;
        }
        if ($_FILES['resumefile']['size'] > 0) {
            $file_name = $_FILES['resumefile']['name']; // file name
            $file_tmp = $_FILES['resumefile']['tmp_name']; // actual location
            $file_size = $_FILES['resumefile']['size']; // file size
            $file_type = $_FILES['resumefile']['type']; // mime type of file determined by php
            $file_error = $_FILES['resumefile']['error']; // any error!. get reason here

            if (!empty($file_tmp)) { // only MS office and text file is accepted.
                $check_document_extension = $this->getJSModel('common')->checkDocumentFileExtensions($file_name, $file_tmp, $document_file_types);
                if ($check_document_extension == 6) {
                    $row->load($id);
                    $row->filename = "";
                    $row->filetype = "";
                    $row->filesize = "";
                    if (!$row->store()) {
                        $this->setError($this->_db->getErrorMsg());
                    }
                    return $check_document_extension;
                } else {
                    $row->load($id);
                    $row->filename = $file_name;
                    $row->filetype = $file_type;
                    $row->filesize = $file_size;
                    if (!$row->store()) {
                        $this->setError($this->_db->getErrorMsg());
                    }
                }
            }

            $path = JPATH_BASE . '/' . $datadirectory;
            if (!file_exists($path)) { // creating resume directory
                $this->getJSModel('common')->makeDir($path);
            }
            $path = $path . '/data';
            if (!file_exists($path)) { // create user directory
                $this->getJSModel('common')->makeDir($path);
            }
            $path = $path . '/jobseeker';
            if (!file_exists($path)) { // create user directory
                $this->getJSModel('common')->makeDir($path);
            }
            $userpath = $path . '/' . $iddir;
            if (!file_exists($userpath)) { // create user directory
                $this->getJSModel('common')->makeDir($userpath);
            }
            $userpath = $path . '/' . $iddir . '/resume';
            if (!file_exists($userpath)) { // create user directory
                $this->getJSModel('common')->makeDir($userpath);
            }
            $files = glob($userpath . '/*.*');
            array_map('unlink', $files);  //delete all file in user directory

            move_uploaded_file($file_tmp, $userpath . '/' . $file_name);
            return $userpath . '/' . $file_name;
            return 1;
        } else {
            if ($resumedata['deleteresumefile'] == 1) {
                $path = JPATH_BASE . '/' . $datadirectory . '/data/jobseeker';
                //$path =JPATH_BASE.'/components/com_jsjobs/data/jobseeker';
                $userpath = $path . '/' . $iddir . '/resume';
                $files = glob($userpath . '/*.*');
                array_map('unlink', $files);
                $row->load($id);
                $row->filename = "";
                $row->filetype = "";
                $row->filesize = "";
                if (!$row->store()) {
                    $this->setError($this->_db->getErrorMsg());
                }
            } else {
                
            }
            return 1;
        }
    }

    function uploadPhoto($id) {
        if (is_numeric($id) == false)
            return false;
        $row = $this->getTable('resume');

        global $resumedata;
        $db = JFactory::getDBO();
        $iddir = 'resume_' . $id;
        if (!isset($this->_config))
            $this->_config = $this->getJSModel('configurations')->getConfig('');

        foreach ($this->_config as $conf) {
            if ($conf->configname == 'data_directory')
                $datadirectory = $conf->configvalue;
            if ($conf->configname == 'image_file_type')
                $image_file_types = $conf->configvalue;
        }
        if ($_FILES['photo']['size'] > 0) {
            $file_name = $_FILES['photo']['name']; // file name
            $file_tmp = $_FILES['photo']['tmp_name']; // actual location
            $file_size = $_FILES['photo']['size']; // file size
            $file_type = $_FILES['photo']['type']; // mime type of file determined by php
            $file_error = $_FILES['photo']['error']; // any error!. get reason here

            if (!empty($file_tmp)) {
                $check_image_extension = $this->getJSModel('common')->checkImageFileExtensions($file_name, $file_tmp, $image_file_types);
                if ($check_image_extension == 6) {
                    $row->load($id);
                    $row->photo = "";
                    if (!$row->store()) {
                        $this->setError($this->_db->getErrorMsg());
                    }
                    return $check_image_extension;
                } else {
                    $row->load($id);
                    $row->photo = $file_name;
                    if (!$row->store()) {
                        $this->setError($this->_db->getErrorMsg());
                    }
                }
            }

            $path = JPATH_BASE . '/' . $datadirectory;
            if (!file_exists($path)) { // creating resume directory
                $this->getJSModel('common')->makeDir($path);
            }
            $path = $path . '/data';
            if (!file_exists($path)) { // creating resume directory
                $this->getJSModel('common')->makeDir($path);
            }
            $path = $path . '/jobseeker';
            if (!file_exists($path)) { // creating resume directory
                $this->getJSModel('common')->makeDir($path);
            }
            $userpath = $path . '/' . $iddir;
            if (!file_exists($userpath)) { // create user directory
                $this->getJSModel('common')->makeDir($userpath);
            }
            $userpath = $path . '/' . $iddir . '/photo';
            if (!file_exists($userpath)) { // create user directory
                $this->getJSModel('common')->makeDir($userpath);
            }
            $files = glob($userpath . '/*.*');
            array_map('unlink', $files);  //delete all file in user directory

            move_uploaded_file($file_tmp, $userpath . '/' . $file_name);
            return $userpath . '/' . $file_name;
            return 1;
        } else {
            if ($resumedata['deletephoto'] == 1) {
                $path = JPATH_BASE . '/' . $datadirectory . '/data/jobseeker';
                $userpath = $path . '/' . $iddir . '/photo';
                $files = glob($userpath . '/*.*');
                array_map('unlink', $files);
                $row->load($id);
                $row->photo = "";
                if (!$row->store()) {
                    $this->setError($this->_db->getErrorMsg());
                }
            } else {
                
            }
            return 1;
        }
    }

    function getResumeDetail($uid, $jobid, $resumeid) {
        if ((is_numeric($uid) == false) || ($uid == 0) || ($uid == ''))
            return false;
        if (is_numeric($jobid) == false)
            return false;
        if (is_numeric($resumeid) == false)
            return false;

        $db = $this->getDBO();
        $db = JFactory::getDBO();
        $canview = 0;
        if ($this->_client_auth_key != "") {
            $query = "SELECT id FROM #__js_job_jobs 
					WHERE serverid = " . $jobid;
            $db->setQuery($query);
            $server_jobid = $db->loadResult();
            $jobid = $server_jobid;

            $query = "SELECT id FROM #__js_job_resume 
					WHERE serverid = " . $resumeid;
            $db->setQuery($query);
            $localresumeid = $db->loadResult();
            if($localresumeid) $resumeid = $localresumeid;
        }

        $query = "SELECT apply.resumeview FROM `#__js_job_jobapply` AS apply
                WHERE apply.jobid = " . $jobid . " AND apply.cvid = " . $resumeid;
        $db->setQuery($query);
        $alreadyview = $db->loadObject();

        if ($alreadyview->resumeview == 1)
            $canview = 1; //already view this resume
        if ($canview == 0) {
            if (!isset($this->_config)) {
                $this->_config = $this->getJSModel('configurations')->getConfig('');
            }
            foreach ($this->_config as $conf) {
                if ($conf->configname == 'newlisting_requiredpackage')
                    $newlisting_required_package = $conf->configvalue;
            }

            if ($newlisting_required_package == 0) {
                $canview = 1;
            } else {
                $query = "SELECT package.viewresumeindetails, package.packageexpireindays, payment.created
							FROM `#__js_job_employerpackages` AS package
							JOIN `#__js_job_paymenthistory` AS payment ON (payment.packageid = package.id AND payment.packagefor=1 )
							WHERE payment.uid = " . $uid . "
							AND DATE_ADD(payment.created,INTERVAL package.packageexpireindays DAY) >= CURDATE()";
                //echo $query;
                $db->setQuery($query);
                $jobs = $db->loadObjectList();
                $unlimited = 0;
                $viewresumeindetails = 0;
                foreach ($jobs AS $job) {
                    if ($unlimited == 0) {
                        if ($job->viewresumeindetails != -1) {
                            $viewresumeindetails = $viewresumeindetails + $job->viewresumeindetails;
                        }
                        else
                            $unlimited = 1;
                    }
                }
                if ($unlimited == 0) {
                    if ($viewresumeindetails == 0)
                        $canview = 0; //can not add new job
                    $query = "SELECT SUM(apply.resumeview) AS totalview
									FROM `#__js_job_jobapply` AS apply
									WHERE apply.jobid = " . $jobid;
                    $db->setQuery($query);
                    $totalview = $db->loadResult();

                    if ($viewresumeindetails <= $totalview)
                        $canview = 0; //can not add new job
                    else
                        $canview = 1;
                }elseif ($unlimited == 1)
                    $canview = 1; // unlimited
            }
        }
        if ($canview == 1) {

            $query = "UPDATE `#__js_job_jobapply` SET resumeview = 1 WHERE jobid = " . $jobid . " AND cvid = " . $resumeid;
            $db->setQuery($query);
            $db->query();

            if ($this->_client_auth_key != "") {
                $query = "SELECT serverid FROM #__js_job_jobs WHERE id = " . $jobid;
                $db->setQuery($query);
                $_jobid = $db->loadResult();
                $jobid = $_jobid;
                if($localresumeid){
                    $query = "SELECT serverid FROM #__js_job_resume WHERE id = " . $localresumeid;
                    $db->setQuery($query);
                    $_resumeid = $db->loadResult();
                    $resumeid = $_resumeid;
                }
                $data_resumedetail = array();
                $data_resumedetail['uid'] = $uid;
                $data_resumedetail['jobid'] = $jobid;
                $data_resumedetail['resumeid'] = $resumeid;
                $data_resumedetail['authkey'] = $this->_client_auth_key;
                $data_resumedetail['siteurl'] = $this->_siteurl;
                $fortask = "getresumedetail";
                $jsjobsharingobject = $this->getJSModel('jobsharingsite');
                $encodedata = json_encode($data_resumedetail);
                $return_server_value = $jsjobsharingobject->serverTask($encodedata, $fortask);
                if (isset($return_server_value['resumedetails']) AND $return_server_value['resumedetails'] == -1) { // auth fail 
                    $logarray['uid'] = $this->_uid;
                    $logarray['referenceid'] = $return_server_value['referenceid'];
                    $logarray['eventtype'] = $return_server_value['eventtype'];
                    $logarray['message'] = $return_server_value['message'];
                    $logarray['event'] = "Resume Details";
                    $logarray['messagetype'] = "Error";
                    $logarray['datetime'] = date('Y-m-d H:i:s');
                    $jsjobsharingobject->write_JobSharingLog($logarray);
                    //$resume = (object) array('name'=>'','decription'=>'','created'=>'');
                } else {
                    $resume = (object) $return_server_value['relationjsondata'];
					$jobapplyid=$return_server_value['jobapplyid'];
                }
            } else {
                $query = "SELECT  app.iamavailable
										, app.id AS appid, app.first_name, app.last_name, app.email_address 
										,app.jobtype,app.gender,app.institute,app.institute_study_area ,app.address_state ,app.address_city
										,app.total_experience, app.jobsalaryrange
										, salary.rangestart, salary.rangeend,education.title AS educationtitle
										,currency.symbol
										FROM `#__js_job_resume` AS app
										LEFT JOIN `#__js_job_heighesteducation` AS  education  ON app.heighestfinisheducation=education.id
										LEFT OUTER JOIN  `#__js_job_salaryrange` AS salary	ON	app.jobsalaryrange=salary.id
										LEFT JOIN `#__js_job_currencies` AS  currency  ON app.currencyid=currency.id

						WHERE app.id = " . $resumeid;

                // ,app.address_county,county.name AS countyname LEFT JOIN `#__js_job_counties` AS county ON app.address_county  = county.id
                $db->setQuery($query);
                $resume = $db->loadObject();
                $query = "SELECT apply.id FROM `#__js_job_jobapply` AS apply
                        WHERE apply.jobid = " . $jobid . " AND apply.cvid = " . $resumeid;
                $db->setQuery($query);
                $jobapplyid = $db->loadResult();
                
            }
            $fieldsordering = $this->getJSModel('customfields')->getFieldsOrdering(3); // resume fields ordering
            if (isset($resume)) {
                $trclass = array('odd', 'even');
                $i = 0; // for odd and even rows
                $return_value = "<div id='resumedetail'>\n";
                $return_value .= "<div id='resumedetailclose'><input type='button' id='button' class='close_button' onclick='clsjobdetail(\"resumeaction_$jobapplyid\")' value='X'> </div>\n";
                foreach ($fieldsordering AS $field) {
                    switch ($field->field) {
                        case 'heighesteducation':
                            if ($field->published == 1) {
                                $return_value .= "<div id='resumedetail_data'>\n";
                                $return_value .= "<span id='resumedetail_data_title' >" . JText::_('JS_EDUCATION') . "</span>\n";
                                $return_value .= "<span id='resumedetail_data_value' >" . $resume->educationtitle . "</span>\n";
                                $return_value .= "</div>\n";
                            }
                            break;
                        case 'institute_institute':
                            if ($field->published == 1) {
                                $return_value .= "<div id='resumedetail_data'>\n";
                                $return_value .= "<span id='resumedetail_data_title' >" . JText::_('JS_INSTITUTE') . "</span>\n";
                                $return_value .= "<span id='resumedetail_data_value' >" . $resume->institute . "</span>\n";
                                $return_value .= "</div>\n";
                            }
                            break;
                        case 'institute_study_area':
                            if ($field->published == 1) {
                                $return_value .= "<div id='resumedetail_data'>\n";
                                $return_value .= "<span id='resumedetail_data_title' >" . JText::_('JS_STUDY_AREA') . "</span>\n";
                                $return_value .= "<span id='resumedetail_data_value' >" . $resume->institute_study_area . "</span>\n";
                                $return_value .= "</div>\n";
                            }
                            break;
                        case 'totalexperience':
                            if ($field->published == 1) {
                                $return_value .= "<div id='resumedetail_data'>\n";
                                $return_value .= "<span id='resumedetail_data_title' >" . JText::_('JS_EXPERIENCE') . "</span>\n";
                                $return_value .= "<span id='resumedetail_data_value' >" . $resume->total_experience . "</span>\n";
                                $return_value .= "</div>\n";
                            }
                            break;
                        case 'Iamavailable':
                            if ($field->published == 1) {
                                $return_value .= "<div id='resumedetail_data'>\n";
                                $return_value .= "<span id='resumedetail_data_title' >" . JText::_('JS_I_AM_AVAILABLE') . "</span>\n";
                                if ($resume->iamavailable == 1)
                                    $return_value .= "<span id='resumedetail_data_value' >" . JText::_('JS_YES') . "</span>\n";
                                else
                                    $return_value .= "<span id='resumedetail_data_value' >" . JText::_('JS_NO') . "</span>\n";
                                $return_value .= "</div>\n";
                            }
                            break;
                        case 'salary':
                            if ($field->published == 1) {
                                $return_value .= "<div id='resumedetail_data'>\n";
                                $return_value .= "<span id='resumedetail_data_title' >" . JText::_('JS_CURRENT_SALARY') . "</span>\n";
                                //$currentsalary=$resume->symbol . $resume->rangestart . ' - ' . $resume->symbol.' '. $resume->rangeend; 
                                //$currentsalary="4000";
                                $return_value .= "<span id='resumedetail_data_value' >" . $resume->symbol . $resume->rangestart . ' - ' . $resume->symbol . ' ' . $resume->rangeend . "</span>\n";
                                $return_value .= "</div>\n";
                            }
                            break;
                    }
                }

                $return_value .= "</div>\n";
            }
        } else {
            $return_value = "<div id='resumedetail'>\n";
            $return_value .= "<tr><td>\n";
            $return_value .= "<table cellpadding='0' cellspacing='0' border='0' width='100%'>\n";
            $return_value .= "<tr class='odd'>\n";
            $return_value .= "<td ><b>" . JText::_('JS_YOU_CAN_NOT_VIEW_RESUME_DETAIL') . "</b></td>\n";
            $return_value .= "<td width='20'><input type='button' class='button' onclick='clsjobdetail(\"resumedetail_$resume->appid\")' value=" . JText::_('JS_CLOSE') . "> </td>\n";
            $return_value .= "</tr>\n";
            $return_value .= "</table>\n";
            $return_value .= "</div>\n";
        }

        return $return_value;
    }

    function getResumeSearch($uid, $title, $name, $nationality, $gender, $iamavailable, $jobcategory, $jobsubcategory, $jobtype, $jobstatus, $currency, $jobsalaryrange, $education, $experience, $sortby, $limit, $limitstart, $zipcode, $keywords) {
        $db = $this->getDBO();

        if (is_numeric($uid) == false)
            return false;
        if (($uid == 0) || ($uid == ''))
            return false;
        if (!isset($this->_config)) {
            $this->_config = $this->getJSModel('configurations')->getConfig('');
        }
        foreach ($this->_config as $conf) {
            if ($conf->configname == 'newlisting_requiredpackage')
                $newlisting_required_package = $conf->configvalue;
        }
        if ($newlisting_required_package == 0) {
            $cansearch = -1;
        } else {
            $query = "SELECT  package.resumesearch
                        FROM `#__js_job_employerpackages` AS package
                        JOIN `#__js_job_paymenthistory` AS payment ON (payment.packageid = package.id AND payment.packagefor=1)
                        WHERE payment.uid = " . $uid . "
                        AND DATE_ADD(payment.created,INTERVAL package.packageexpireindays DAY) >= CURDATE()
                        AND payment.transactionverified = 1 AND payment.status = 1";
            $db->setQuery($query);
            $results = $db->loadObjectList();
            $cansearch = 0;
            foreach ($results AS $result) {
                if ($result->resumesearch != -1) {
                    $cansearch += $result->resumesearch;
                }
            }
            if ($cansearch == 0) {
                $result = false;
                return $result;
            }
        }

        if ($gender != '')
            if (is_numeric($gender) == false)
                return false;
        if ($iamavailable != '')
            if (is_numeric($iamavailable) == false)
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
        if ($jobsalaryrange != '')
            if (is_numeric($jobsalaryrange) == false)
                return false;
        if ($education != '')
            if (is_numeric($education) == false)
                return false;
        if ($currency != '')
            if (is_numeric($currency) == false)
                return false;
        if ($zipcode != '')
            if (is_numeric($zipcode) == false)
                return false;


        if ($newlisting_required_package == 0) {
            $canview = 1;
        } else {

            $query = "SELECT package.saveresumesearch, package.packageexpireindays, payment.created
			FROM `#__js_job_employerpackages` AS package
			JOIN `#__js_job_paymenthistory` AS payment ON (payment.packageid = package.id AND payment.packagefor=1)
			WHERE payment.uid = " . $uid . "
			AND DATE_ADD(payment.created,INTERVAL package.packageexpireindays DAY) >= CURDATE()";
            $db->setQuery($query);
            $jobs = $db->loadObjectList();
            $canview = 0;
            foreach ($jobs AS $job) {
                if ($job->saveresumesearch == 1) {
                    $canview = 1;
                    break;
                }
                else
                    $canview = 0;
            }
        }

        $result = array();
        $searchresumeconfig = $this->getJSModel('configurations')->getConfigByFor('searchresume');
        $wherequery = '';

        if ($title != '') { // For title  Search
            $titlekeywords = explode(' ', $title);
            $length = count($titlekeywords);
            if ($length <= 5) {// For Limit keywords to 5
                $i = $length;
            } else {
                $i = 5;
            }
            for ($j = 0; $j < $i; $j++) {
                $titlekeys[] = " resume.application_title Like '%$titlekeywords[$j]%'";
            }
        }
        if (isset($titlekeys))
            $wherequery .= " AND ( " . implode(' OR ', $titlekeys) . " )";

        if ($keywords != '') { // For title  Search
            $keywords = explode(' ', $keywords);
            $length = count($keywords);
            if ($length <= 5) {// For Limit keywords to 5
                $i = $length;
            } else {
                $i = 5;
            }
            for ($j = 0; $j < $i; $j++) {
                $keys[] = " resume.keywords Like '%$keywords[$j]%'";
            }
        }
        if (isset($keys))
            $wherequery .= " AND ( " . implode(' OR ', $keys) . " )";

        if ($name != '') {
            $wherequery .= " AND (";
            $wherequery .= " LOWER(resume.first_name) LIKE " . $db->Quote('%' . $name . '%', false);
            $wherequery .= " OR LOWER(resume.last_name) LIKE " . $db->Quote('%' . $name . '%', false);
            $wherequery .= " OR LOWER(resume.middle_name) LIKE " . $db->Quote('%' . $name . '%', false);
            $wherequery .= " )";
        }

        if ($nationality != '')
            $wherequery .= " AND resume.nationality = " . $nationality;
        if ($gender != '')
            $wherequery .= " AND resume.gender = " . $gender;
        if ($iamavailable != '')
            $wherequery .= " AND resume.iamavailable = " . $iamavailable;
        if ($jobcategory != '')
            $wherequery .= " AND resume.job_category = " . $jobcategory;
        if ($jobsubcategory != '')
            $wherequery .= " AND resume.job_subcategory = " . $jobsubcategory;
        if ($jobtype != '')
            $wherequery .= " AND resume.jobtype = " . $jobtype;
        if ($jobsalaryrange != '')
            $wherequery .= " AND resume.jobsalaryrange = " . $jobsalaryrange;
        if ($education != '')
            $wherequery .= " AND resume.heighestfinisheducation = " . $education;
        if ($currency != '')
            $wherequery .= " AND resume.currencyid = " . $currency;
        if ($experience != '')
            $wherequery .= " AND resume.total_experience LIKE " . $db->Quote($experience);


        if ($zipcode != '')
            $wherequery .= " AND resume.address_zipcode =" . $zipcode;

        $query = "SELECT count(resume.id) 
                    FROM `#__js_job_resume` AS resume 
                    LEFT JOIN `#__js_job_categories` AS cat ON resume.job_category = cat.id
                    WHERE resume.status = 1 AND resume.searchable = 1  ";
        $query .= $wherequery;
        $db->setQuery($query);
        $total = $db->loadResult();
        if ($total <= $limitstart)
            $limitstart = 0;

        $query = "SELECT  resume.*, cat.cat_title, jobtype.title AS jobtypetitle
                    , salary.rangestart, salary.rangeend , country.name AS countryname
                    , city.name AS cityname,state.name AS statename
                    , currency.symbol as symbol	
                    ,CONCAT(resume.alias,'-',resume.id) AS resumealiasid
                    ,salarytype.title AS salarytype
                    FROM `#__js_job_resume` AS resume
                    LEFT JOIN `#__js_job_categories` AS cat ON resume.job_category = cat.id
                    LEFT JOIN `#__js_job_jobtypes` AS jobtype ON resume.jobtype = jobtype.id
                    LEFT JOIN `#__js_job_salaryrange` AS salary ON resume.jobsalaryrange = salary.id
                    LEFT JOIN  `#__js_job_salaryrangetypes` AS salarytype ON resume.jobsalaryrangetype = salarytype.id
                    LEFT JOIN `#__js_job_cities` AS city ON resume.address_city= city.id
                    LEFT JOIN `#__js_job_countries` AS country ON city.countryid = country.id
                    LEFT JOIN `#__js_job_states` AS state ON city.stateid = state.id
                    LEFT JOIN `#__js_job_currencies` AS currency ON currency.id = resume.currencyid";
        $query .=" WHERE resume.status = 1 AND resume.searchable = 1";
        $query .= $wherequery;
        $query .= " ORDER BY  " . $sortby;
        $db->setQuery($query, $limitstart, $limit);

        $result[0] = $db->loadObjectList();
        $result[1] = $total;
        $result[2] = $searchresumeconfig;
        $result[3] = $canview;

        return $result;
    }

    function getResumeBySubCategoryId($uid, $jobsubcategory, $sortby, $limit, $limitstart) {
        $db = $this->getDBO();

        if (is_numeric($uid) == false)
            return false;
        if (is_numeric($jobsubcategory) == false)
            return false;
        if (($uid == 0) || ($uid == ''))
            return false;
        $result = array();

        $query = "SELECT count(resume.id) 
                    FROM `#__js_job_resume` AS resume
                    LEFT JOIN `#__js_job_subcategories` AS subcat ON resume.job_subcategory=subcat.id
                    WHERE subcat.id = " . $jobsubcategory . " AND resume.status = 1 AND resume.searchable = 1  ";

        $db->setQuery($query);
        $total = $db->loadResult();
        if ($total <= $limitstart)
            $limitstart = 0;
        if ($total != 0) {

            $query = "SELECT  resume.*,cat.id as cat_id,cat.cat_title, subcat.title as subcategory,jobtype.title AS jobtypetitle
                        , salary.rangestart, salary.rangeend , country.name AS countryname
                        , city.name AS cityname,state.name AS statename
                        , currency.symbol as symbol	
                        ,CONCAT(subcat.alias,'-',subcat.id) AS aliasid
                        ,CONCAT(resume.alias,'-',resume.id) AS resumealiasid
						,salarytype.title AS salarytype
                        
                        FROM `#__js_job_resume` AS resume
                        LEFT JOIN `#__js_job_categories` AS cat ON resume.job_category = cat.id
                        LEFT JOIN `#__js_job_subcategories` AS subcat ON resume.job_subcategory =" . $jobsubcategory . " 
                        LEFT JOIN `#__js_job_jobtypes` AS jobtype ON resume.jobtype = jobtype.id
                        LEFT JOIN `#__js_job_salaryrange` AS salary ON resume.jobsalaryrange = salary.id
						LEFT JOIN  `#__js_job_salaryrangetypes` AS salarytype ON resume.jobsalaryrangetype = salarytype.id
                        LEFT JOIN `#__js_job_cities` AS city ON resume.address_city= city.id
                        LEFT JOIN `#__js_job_countries` AS country ON city.countryid = country.id
                        LEFT JOIN `#__js_job_states` AS state ON city.stateid = state.id
                        LEFT JOIN `#__js_job_currencies` AS currency ON currency.id = resume.currencyid ";
            $query .= " WHERE subcat.id = " . $jobsubcategory . " AND resume.status = 1 AND resume.searchable = 1";
            $query .= " ORDER BY  " . $sortby;

            $db->setQuery($query, $limitstart, $limit);
            $resumebysubcategorydata = $db->loadObjectList();
        } else {
            $query = "SELECT cat.id as cat_id, cat.cat_title, subcat.title as subcategory
                        FROM `#__js_job_categories` AS cat
                        JOIN `#__js_job_subcategories` AS subcat ON subcat.categoryid = cat.id
                        WHERE subcat.id = " . $jobsubcategory;
            $db->setQuery($query);
            $subcategorydata = $db->loadObject();
        }

        if (isset($resumebysubcategorydata))
            $result[0] = $resumebysubcategorydata;
        if (isset($subcategorydata))
            $result[2] = $subcategorydata;
        $result[1] = $total;
        return $result;
    }

    function getResumeByCategoryId($uid, $jobcategory, $sortby, $limit, $limitstart) {
        $db = $this->getDBO();

        if (is_numeric($uid) == false)
            return false;
        if (is_numeric($jobcategory) == false)
            return false;
        if (($uid == 0) || ($uid == ''))
            return false;
        $searchresumeconfig = $this->getJSModel('configurations')->getConfigByFor('searchresume');
        $result = array();
        $query = "SELECT count(resume.id) 
						FROM `#__js_job_resume` AS resume
						LEFT JOIN `#__js_job_categories` AS cat ON resume.job_category = cat.id
						WHERE cat.id = " . $jobcategory . " AND resume.status = 1 AND resume.searchable = 1  ";
        $db->setQuery($query);
        $total = $db->loadResult();
        if ($total <= $limitstart)
            $limitstart = 0;

        $query = "SELECT  resume.*, cat.cat_title, jobtype.title AS jobtypetitle
                    , salary.rangestart, salary.rangeend , country.name AS countryname
                    , city.name AS cityname,state.name AS statename
                    , currency.symbol as symbol	
                    ,CONCAT(cat.alias,'-',cat.id) AS aliasid
                    ,CONCAT(resume.alias,'-',resume.id) AS resumealiasid
                    ,salarytype.title AS salarytype
                    
                    FROM `#__js_job_resume` AS resume
                    LEFT JOIN `#__js_job_categories` AS cat ON resume.job_category = cat.id
                    LEFT JOIN `#__js_job_jobtypes` AS jobtype ON resume.jobtype = jobtype.id
                    LEFT JOIN `#__js_job_salaryrange` AS salary ON resume.jobsalaryrange = salary.id
                    LEFT JOIN  `#__js_job_salaryrangetypes` AS salarytype ON resume.jobsalaryrangetype = salarytype.id
                    LEFT JOIN `#__js_job_cities` AS city ON resume.address_city = city.id
                    LEFT JOIN `#__js_job_countries` AS country ON city.countryid = country.id
                    LEFT JOIN `#__js_job_states` AS state ON city.stateid = state.id
                    LEFT JOIN `#__js_job_currencies` AS currency ON currency.id = resume.currencyid ";
        $query .= " WHERE cat.id = " . $jobcategory . " AND resume.status = 1 AND resume.searchable = 1";
        $query .= " ORDER BY  " . $sortby;
        $db->setQuery($query, $limitstart, $limit);
        $resume = $db->loadObjectList();

        if ($searchresumeconfig['resume_subcategories'] == 1) {
            $inquery = " (SELECT COUNT(resume.id) from `#__js_job_resume` AS resume WHERE subcat.id = resume.job_subcategory AND resume.status = 1 AND resume.searchable = 1 ) as resumeinsubcat";

            $query = "SELECT  DISTINCT subcat.id, subcat.title,CONCAT(subcat.alias,'-',subcat.id) AS aliasid, ";
            $query .= $inquery;
            $query .= " FROM `#__js_job_subcategories` AS subcat
                        LEFT JOIN `#__js_job_resume` AS resume ON subcat.id = resume.job_subcategory
                        LEFT JOIN `#__js_job_cities` AS city ON resume.address_city = city.id
                        LEFT JOIN `#__js_job_countries` AS country ON city.countryid = country.id
                        LEFT JOIN `#__js_job_states` AS state ON city.stateid = state.id
                        WHERE subcat.status = 1 AND categoryid = " . $jobcategory;
            $query .= " ORDER BY subcat.title ";

            $db->setQuery($query);
            $resumesubcategory = $db->loadObjectList();
        }

        //for categroy title
        $query = "SELECT cat_title FROM `#__js_job_categories` WHERE id = " . $jobcategory;
        $db->setQuery($query);
        $cat_title = $db->loadResult();

        $result[0] = $resume;
        $result[1] = $total;
        $result[2] = $searchresumeconfig;
        $result[3] = $cat_title;
        $result[4] = $jobcategory;
        $result[5] = $resumesubcategory;
        return $result;
    }

    function getMyResumeSearchesbyUid($u_id, $limit, $limitstart) {
        $db = $this->getDBO();
        if ((is_numeric($u_id) == false) || ($u_id == 0) || ($u_id == ''))
            return false;
        $result = array();
        $query = "SELECT COUNT(id) FROM `#__js_job_resumesearches` WHERE uid  = " . $u_id;
        $db->setQuery($query);
        $total = $db->loadResult();

        if ($total <= $limitstart)
            $limitstart = 0;

        $query = "SELECT search.* 
					FROM `#__js_job_resumesearches` AS search
					WHERE search.uid  = " . $u_id;
        $db->setQuery($query);
        $db->setQuery($query, $limitstart, $limit);

        $result[0] = $db->loadObjectList();
        $result[1] = $total;

        return $result;
    }
    
    function canSearchResume($uid){
        if(!is_numeric($uid)) return false;
        $db = $this->getDBO();
        $query = "SELECT package.resumesearch, package.packageexpireindays, payment.created
                    FROM `#__js_job_employerpackages` AS package
                    JOIN `#__js_job_paymenthistory` AS payment ON (payment.packageid = package.id AND payment.packagefor=1)
                    WHERE payment.uid = " . $uid . "
                    AND DATE_ADD(payment.created,INTERVAL package.packageexpireindays DAY) >= CURDATE()
                    AND payment.transactionverified = 1 AND payment.status = 1";

        $db->setQuery($query);
        $valid_packages = $db->loadObjectList();
        if(empty($valid_packages)){ // user have no valid package
            $query = "SELECT package.resumesearch, package.packageexpireindays, payment.created
                        FROM `#__js_job_employerpackages` AS package
                        JOIN `#__js_job_paymenthistory` AS payment ON (payment.packageid = package.id AND payment.packagefor=1)
                        WHERE payment.uid = " . $uid . "
                        AND payment.transactionverified = 1 AND payment.status = 1";

            $db->setQuery($query);
            $packages = $db->loadObjectList();
            if(empty($pacakges)){
                return NO_PACKAGE;
            }else{
                return EXPIRED_PACKAGE;
            }
        }else{ // user have valid pacakge
            $canview = RESUME_SEARCH_NOT_ALLOWED_IN_PACAKGE;
            foreach ($valid_packages AS $job) {
                if ($job->resumesearch == 1) {
                    $canview = VALIDATE;
                    break;
                }
            }
            return $canview;
        }
    }

    function getResumeSearchOptions() {
        $db = $this->getDBO();
        $canview = $this->getJSModel('permissions')->checkPermissionsFor("RESUME_SEARCH");
        if ($canview == VALIDATE) {
            $searchresumeconfig = $this->getJSModel('configurations')->getConfigByFor('searchresume');
            $gender = array(
                '0' => array('value' => '', 'text' => JText::_('JS_SELECT_GENDER')),
                '1' => array('value' => 1, 'text' => JText::_('JS_MALE')),
                '2' => array('value' => 2, 'text' => JText::_('JS_FEMALE')),);
            $defaultCategory = $this->getJSModel('common')->getDefaultValue('categories');
            $defaultJobtype = $this->getJSModel('common')->getDefaultValue('jobtypes');
            $defaultEducation = $this->getJSModel('common')->getDefaultValue('heighesteducation');
            $defaultSalaryrange = $this->getJSModel('common')->getDefaultValue('salaryrange');
            $defaultCurrencies = $this->getJSModel('common')->getDefaultValue('currencies');



            $nationality = $this->getJSModel('countries')->getCountries(JText::_('JS_SELECT_NATIONALITY'));
            $job_type = $this->getJSModel('jobtype')->getJobType(JText::_('JS_SELECT_JOB_TYPE'));
            $heighesteducation = $this->getJSModel('highesteducation')->getHeighestEducation(JText::_('JS_SELECT_HIGHEST_EDUCATION'));
            $job_categories = $this->getJSModel('category')->getCategories(JText::_('JS_SELECT_CATEGORY'));
            $job_subcategories = $this->getJSModel('subcategory')->getSubCategoriesforCombo($defaultCategory, JText::_('JS_SELECT_SUB_CATEGORY'), '');
            $job_salaryrange = $this->getJSModel('salaryrange')->getJobSalaryRange(JText::_('JS_SELECT_SALARY_RANGE'), '');
            $currencies = $this->getJSModel('currency')->getCurrency(JText::_('JS_SELECT_CURRENCY'));

            $searchoptions['nationality'] = JHTML::_('select.genericList', $nationality, 'nationality', 'class="inputbox jsjobs-cbo" ' . '', 'value', 'text', '');
            $searchoptions['jobcategory'] = JHTML::_('select.genericList', $job_categories, 'jobcategory', 'class="inputbox jsjobs-cbo" ' . 'onChange="fj_getsubcategories(\'fj_subcategory\', this.value)"', 'value', 'text', $defaultCategory);
            $searchoptions['jobsubcategory'] = JHTML::_('select.genericList', $job_subcategories, 'jobsubcategory', 'class="inputbox jsjobs-cbo" ' . '', 'value', 'text', '');
            $searchoptions['jobsalaryrange'] = JHTML::_('select.genericList', $job_salaryrange, 'jobsalaryrange', 'class="inputbox jsjobs-cbo" style="width:120px;"' . '', 'value', 'text', $defaultSalaryrange);
            $searchoptions['jobtype'] = JHTML::_('select.genericList', $job_type, 'jobtype', 'class="inputbox jsjobs-cbo" ' . '', 'value', 'text', $defaultJobtype);
            $searchoptions['heighestfinisheducation'] = JHTML::_('select.genericList', $heighesteducation, 'heighestfinisheducation', 'class="inputbox jsjobs-cbo" ' . '', 'value', 'text', $defaultEducation);
            $searchoptions['gender'] = JHTML::_('select.genericList', $gender, 'gender', 'class="inputbox jsjobs-cbo" ' . '', 'value', 'text', '');
            $searchoptions['currency'] = JHTML::_('select.genericList', $currencies, 'currency', 'class="inputbox jsjobs-cbo" style="width:50px;"' . '', 'value', 'text', $defaultCurrencies);
            $result = array();
            $result[0] = $searchoptions;
            $result[1] = $searchresumeconfig;
            $result[2] = $canview;
        } else {
            $result[2] = $canview;
        }
        return $result;
    }

    function getResumeByCategory($uid) {
        $db = $this->getDbo();
        $canview = $this->getJSModel('permissions')->checkPermissionsFor("RESUME_SEARCH");
        if ($canview == VALIDATE) {
            $query = "SELECT DISTINCT cat.id AS catid, cat.cat_title AS cattitle, 
                        (SELECT COUNT(id) FROM `#__js_job_resume` WHERE job_category = cat.id  AND status=1 AND searchable=1 ) AS total
                        ,CONCAT(cat.alias,'-',cat.id) AS aliasid
                        FROM `#__js_job_categories` AS cat
                        WHERE cat.isactive = 1";

            $db->setQuery($query);
            $result = $db->loadObjectList();
            $return[0] = $result;
            $return[1] = $canview;
            return $return;
        }else{
            $return[0] = null;
            $return[1] = $canview;
            return $return;
        }
            
    }


}
?>
    
