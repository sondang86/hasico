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

class JSJobsModelResume extends JSModel{

    var $_config = null;
    var $_defaultcurrency = null;
    var $_client_auth_key = null;
    var $_siteurl = null;
    var $_empoptions = null;
    var $_application = null;

    function __construct() {
        parent :: __construct();
        $this->_client_auth_key = $this->getJSModel('jobsharing')->getClientAuthenticationKey();
        $this->_siteurl = JURI::root();
        $this->_defaultcurrency = $this->getJSModel('currency')->getDefaultCurrency();
        $user = JFactory::getUser();
        $this->_uid = $user->id;
    }

    function getResumeSearch($uid, $title, $name, $nationality, $gender, $iamavailable, $jobcategory, $jobtype, $jobstatus, $jobsalaryrange, $education
    , $experience, $limit, $limitstart, $currency, $zipcode) {
        if ($gender != '')
            if (is_numeric($gender) == false)
                return false;
        if ($iamavailable != '')
            if (is_numeric($iamavailable) == false)
                return false;
        if ($jobcategory != '')
            if (is_numeric($jobcategory) == false)
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
        $db = $this->getDBO();
        $result = array();
        $searchresumeconfig = $this->getJSModel('configuration')->getConfigByFor('searchresume');

        $wherequery = '';
        if ($title != '')
            $wherequery .= " AND resume.application_title LIKE '%" . str_replace("'", "", $db->Quote($title)) . "%'";
        if ($name != '') {
            $wherequery .= " AND (";
            $wherequery .= " LOWER(resume.first_name) LIKE " . $db->Quote('%' . $name . '%', false);
            $wherequery .= " OR LOWER(resume.last_name) LIKE " . $db->Quote('%' . $name . '%', false);
            $wherequery .= " OR LOWER(resume.middle_name) LIKE " . $db->Quote('%' . $name . '%', false);
            $wherequery .= " )";
        }

        if ($nationality != '')
            $wherequery .= " AND resume.nationality = " . $db->Quote($nationality);
        if ($gender != '')
            $wherequery .= " AND resume.gender = " . $gender;
        if ($iamavailable != '')
            $wherequery .= " AND resume.iamavailable = " . $iamavailable;
        if ($jobcategory != '')
            $wherequery .= " AND resume.job_category = " . $jobcategory;
        if ($jobtype != '')
            $wherequery .= " AND resume.jobtype = " . $jobtype;
        if ($jobsalaryrange != '')
            $wherequery .= " AND resume.jobsalaryrange = " . $jobsalaryrange;
        if ($education != '')
            $wherequery .= " AND resume.heighestfinisheducation = " . $education;
        if ($experience != '')
            $wherequery .= " AND resume.total_experience LIKE " . $db->Quote($experience);
        if ($currency != '')
            $wherequery .= " AND resume.currencyid =" . $currency;
        if ($zipcode != '')
            $wherequery .= " AND resume.address_zipcode =" . $zipcode;

        $query = "SELECT count(resume.id) 
				FROM `#__js_job_resume` AS resume 
				LEFT JOIN `#__js_job_categories` AS cat ON resume.job_category = cat.id
				WHERE resume.status = 1 ";
        $query .= $wherequery;
        $db->setQuery($query);
        $total = $db->loadResult();

        if ($total <= $limitstart)
            $limitstart = 0;
        $query = "SELECT resume.*, cat.cat_title, jobtype.title AS jobtypetitle
				, salary.rangestart, salary.rangeend , currency.symbol
				,salarytype.title AS salarytype
				FROM `#__js_job_resume` AS resume
				LEFT JOIN `#__js_job_categories` AS cat ON resume.job_category = cat.id
				LEFT JOIN `#__js_job_jobtypes` AS jobtype ON resume.jobtype = jobtype.id
				LEFT JOIN `#__js_job_currencies` AS currency ON currency.id = resume.currencyid 	 		
				LEFT JOIN `#__js_job_salaryrange` AS salary ON resume.jobsalaryrange = salary.id
				LEFT JOIN  `#__js_job_salaryrangetypes` AS salarytype ON resume.jobsalaryrangetype = salarytype.id ";
        $query .= "WHERE resume.status = 1 ";
        $query .= $wherequery;
        $db->setQuery($query, $limitstart, $limit);

        $result[0] = $db->loadObjectList();
        $result[1] = $total;
        $result[2] = $searchresumeconfig;

        return $result;
    }

    function getResumeSearchOptions() {
        $db = $this->getDBO();
        $searchresumeconfig = $this->getJSModel('configuration')->getConfigByFor('searchresume');

        $gender = array(
            '0' => array('value' => '', 'text' => JText::_('JS_SEARCH_ALL')),
            '1' => array('value' => 1, 'text' => JText::_('JS_MALE')),
            '2' => array('value' => 2, 'text' => JText::_('JS_FEMALE')),);

        $nationality = $this->getJSModel('country')->getCountries(JText::_('JS_SEARCH_ALL'));
        $job_type = $this->getJSModel('jobtype')->getJobType(JText::_('JS_SEARCH_ALL'));
        $heighesteducation = $this->getJSModel('highesteducation')->getHeighestEducation(JText::_('JS_SEARCH_ALL'));
        $job_categories = $this->getJSModel('category')->getCategories(JText::_('JS_SEARCH_ALL'), '');
        $job_subcategories = $this->getJSModel('subcategory')->getSubCategoriesforCombo($job_categories[1]['value'], JText::_('JS_SEARCH_ALL'), '');
        $job_salaryrange = $this->getJSModel('salaryrange')->getJobSalaryRange(JText::_('JS_SEARCH_ALL'), '');

        $searchoptions['nationality'] = JHTML::_('select.genericList', $nationality, 'nationality', 'class="inputbox" ' . '', 'value', 'text', '');
        $searchoptions['jobcategory'] = JHTML::_('select.genericList', $job_categories, 'jobcategory', 'class="inputbox" ' . 'onChange="fj_getsubcategories(\'fj_subcategory\', this.value)"', 'value', 'text', '');
        $searchoptions['jobsubcategory'] = JHTML::_('select.genericList', $job_subcategories, 'jobcategory', 'class="inputbox" ' . '', 'value', 'text', '');
        $searchoptions['jobsalaryrange'] = JHTML::_('select.genericList', $job_salaryrange, 'jobsalaryrange', 'class="inputbox" ' . '', 'value', 'text', '');
        $searchoptions['jobtype'] = JHTML::_('select.genericList', $job_type, 'jobtype', 'class="inputbox" ' . '', 'value', 'text', '');
        $searchoptions['heighestfinisheducation'] = JHTML::_('select.genericList', $heighesteducation, 'heighestfinisheducation', 'class="inputbox" ' . '', 'value', 'text', '');
        $searchoptions['gender'] = JHTML::_('select.genericList', $gender, 'gender', 'class="inputbox" ' . '', 'value', 'text', '');
        $searchoptions['currency'] = JHTML::_('select.genericList', $this->getJSModel('currency')->getCurrency(JText::_('JS_SEARCH_ALL')), 'currency', 'class="inputbox" ' . '', 'value', 'text', '');
        $result = array();
        $result[0] = $searchoptions;
        $result[1] = $searchresumeconfig;

        return $result;
    }

    function getResumeViewbyId($id) {
        if (is_numeric($id) == false)
            return false;
        $db = $this->getDBO();
        $status = array(
            '0' => array('value' => 0, 'text' => JText::_('JS_PENDDING')),
            '1' => array('value' => 1, 'text' => JText::_('JS_APPROVE')),
            '2' => array('value' => -1, 'text' => JText::_('JS_REJECT')),);
        $lists['status'] = JHTML::_('select.genericList', $status, 'status', 'class="inputbox required" ' . '', 'value', 'text', '');
        $query = "SELECT app.* , cat.cat_title AS categorytitle, salary.rangestart, salary.rangeend, jobtype.title AS jobtypetitle
				,heighesteducation.title AS heighesteducationtitle
				, nationality_country.name AS nationalitycountry
				, address_city.name AS address_city2 , address_state.name AS address_state2 , address_country.name AS address_country
				, address1_city.name AS address1_city2 , address1_state.name AS address1_state2 , address1_country.name AS address1_country
				, address2_city.name AS address2_city2 , address2_state.name AS address2_state2 , address2_country.name AS address2_country
				, currency.symbol as symbol	
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
        $result[3] = $this->getJSModel('fieldordering')->getFieldsOrderingforForm(3); // resume fields
        $result[4] = $lists;
        $resume_userfields = $this->getJSModel('customfield')->getUserFieldsForView(3, $id); // resume fields, id
        $result[6] = $resume_userfields;
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

    function getUserStatsResumes($resumeuid, $limitstart, $limit) {
        if (is_numeric($resumeuid) == false)
            return false;
        $db = JFactory :: getDBO();
        $result = array();

        $query = 'SELECT COUNT(resume.id) FROM #__js_job_resume AS resume WHERE resume.uid = ' . $resumeuid;
        $db->setQuery($query);
        $total = $db->loadResult();
        if ($total <= $limitstart)
            $limitstart = 0;

        $query = 'SELECT resume.id,resume.application_title,resume.first_name,resume.last_name,cat.cat_title,resume.create_date,resume.status
                    FROM #__js_job_resume AS resume
                    LEFT JOIN #__js_job_categories AS cat ON cat.id=resume.job_category
                    WHERE resume.uid = ' . $resumeuid;
        $query .= ' ORDER BY resume.first_name';
        $db->setQuery($query, $limitstart, $limit);
        $result[0] = $db->loadObjectList();
        $result[1] = $total;
        return $result;
    }

    function getEmpAppbyId($c_id) {
        if (is_numeric($c_id) == false)
            return false;
        $db = JFactory :: getDBO();
        $query = "SELECT * FROM #__js_job_resume WHERE id = " . $c_id;

        $db->setQuery($query);
        $this->_application = $db->loadObject();

        $result[0] = $this->_application;
        $result[2] = $this->getJSModel('customfield')->getUserFieldsforForm(3, $c_id); // job fields , ref id
        $result[3] = $this->getJSModel('fieldordering')->getFieldsOrderingforForm(3); // resume fields
        return $result;
    }

    function getAllEmpAppsListing($limitstart, $limit) {
        $db = JFactory :: getDBO();
        $result = array();
        $query = "SELECT COUNT(app.id) 
				FROM `#__js_job_resume` AS app 
				LEFT JOIN `#__js_job_categories` AS cat ON app.job_category = cat.id
				LEFT JOIN `#__js_job_salaryrange` AS salary ON app.jobsalaryrange = salary.id 
				LEFT JOIN `#__js_job_jobtypes` AS jobtype ON app.jobtype = jobtype.id 
				LEFT JOIN `#__js_job_currencies` AS currency ON app.currencyid=currency.id 
				WHERE app.status <> 0";

        $db->setQuery($query);
        $total = $db->loadResult();
        if ($total <= $limitstart)
            $limitstart = 0;

        $query = "SELECT app.id, app.application_title,app.first_name, app.last_name, app.jobtype, 
				app.jobsalaryrange, app.create_date, app.status, cat.cat_title, salary.rangestart, salary.rangeend
				, jobtype.title AS jobtypetitle
				,currency.symbol AS symbol
				FROM `#__js_job_resume` AS app 
				LEFT JOIN `#__js_job_categories` AS cat ON app.job_category = cat.id
				LEFT JOIN `#__js_job_salaryrange` AS salary ON app.jobsalaryrange = salary.id 
				LEFT JOIN `#__js_job_jobtypes` AS jobtype ON app.jobtype = jobtype.id 
				LEFT JOIN `#__js_job_currencies` AS currency ON app.currencyid=currency.id 
				WHERE app.status <> 0";
        $query .= " ORDER BY app.create_date DESC";

        $db->setQuery($query, $limitstart, $limit);
        $this->_application = $db->loadObjectList();

        $result[0] = $this->_application;
        $result[1] = $total;
        return $result;
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
        $canview = 1;

        if ($canview == 1) {

            $query = "UPDATE `#__js_job_jobapply` SET resumeview = 1 WHERE jobid = " . $jobid . " AND cvid = " . $resumeid;
            $db->setQuery($query);
            $db->query();

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

            $db->setQuery($query);
            $resume = $db->loadObject();

            $fieldsordering = $this->getJSModel('fieldordering')->getFieldsOrderingforForm(3); // resume fields ordering
            if (isset($resume)) {
                $trclass = array('row0', 'row1');
                $i = 0; // for odd and even rows
                $return_value = "<div id='resumedetail'>\n";
                $return_value .= "<div id='resumedetailclose'><input type='button' id='button' class='close_button' onclick='clsjobdetail(\"resumedetail_$resume->appid\")' value='X'> </div>\n";
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

    function getAllEmpApps($searchtitle, $searchname, $searchjobcategory, $searchjobtype, $searchjobsalaryrange, $limitstart, $limit) {
        if ($searchjobcategory)
            if (is_numeric($searchjobcategory) == false)
                return false;
        if ($searchjobtype)
            if (is_numeric($searchjobtype) == false)
                return false;
        if ($searchjobsalaryrange)
            if (is_numeric($searchjobsalaryrange) == false)
                return false;
        $db = JFactory :: getDBO();
        $result = array();
        $query = "SELECT COUNT(id) FROM #__js_job_resume AS app WHERE app.status <> 0";
        if ($searchtitle)
            $query .= " AND LOWER(app.application_title) LIKE " . $db->Quote('%' . $searchtitle . '%', false);
        if ($searchname) {
            $query .= " AND (";
            $query .= " LOWER(app.first_name) LIKE " . $db->Quote('%' . $searchname . '%', false);
            $query .= " OR LOWER(app.last_name) LIKE " . $db->Quote('%' . $searchname . '%', false);
            $query .= " OR LOWER(app.middle_name) LIKE " . $db->Quote('%' . $searchname . '%', false);
            $query .= " )";
        }
        if ($searchjobcategory)
            $query .= " AND app.job_category = " . $searchjobcategory;
        if ($searchjobtype)
            $query .= " AND app.jobtype = " . $searchjobtype;
        if ($searchjobsalaryrange)
            $query .= " AND app.jobsalaryrange = " . $searchjobsalaryrange;
        $db->setQuery($query);
        $total = $db->loadResult();
        if ($total <= $limitstart)
            $limitstart = 0;

        $query = "SELECT app.id, app.application_title,app.first_name, app.last_name, app.jobtype,
				app.jobsalaryrange, app.create_date, app.status, cat.cat_title, salary.rangestart, salary.rangeend , currency.symbol
				, jobtype.title AS jobtypetitle
			FROM #__js_job_resume AS app 
			LEFT JOIN #__js_job_categories AS cat ON app.job_category = cat.id
			LEFT JOIN #__js_job_jobtypes AS jobtype	ON app.jobtype = jobtype.id
			LEFT JOIN #__js_job_salaryrange AS salary ON app.jobsalaryrange = salary.id
			LEFT JOIN #__js_job_currencies AS currency ON currency.id = app.currencyid
			WHERE app.status <> 0  ";

        if ($searchtitle)
            $query .= " AND LOWER(app.application_title) LIKE " . $db->Quote('%' . $searchtitle . '%', false);
        if ($searchname) {
            $query .= " AND (";
            $query .= " LOWER(app.first_name) LIKE " . $db->Quote('%' . $searchname . '%', false);
            $query .= " OR LOWER(app.last_name) LIKE " . $db->Quote('%' . $searchname . '%', false);
            $query .= " OR LOWER(app.middle_name) LIKE " . $db->Quote('%' . $searchname . '%', false);
            $query .= " )";
        }
        if ($searchjobcategory)
            $query .= " AND app.job_category = " . $searchjobcategory;
        if ($searchjobtype)
            $query .= " AND app.jobtype = " . $searchjobtype;
        if ($searchjobsalaryrange)
            $query .= " AND app.jobsalaryrange = " . $searchjobsalaryrange;

        $query .= " ORDER BY app.create_date DESC";

        $db->setQuery($query, $limitstart, $limit);
        $this->_application = $db->loadObjectList();

        $lists = array();

        $job_type = array(
            '0' => array('value' => '', 'text' => JText::_('JS_SELECT_JOB_TYPE')),
            '1' => array('value' => JText::_(1), 'text' => JText::_('JS_JOBTYPE_FULLTIME')),
            '2' => array('value' => JText::_(2), 'text' => JText::_('JS_JOBTYPE_PARTTIME')),
            '3' => array('value' => JText::_(3), 'text' => JText::_('JS_JOBTYPE_INTERNSHIP')),);


        $job_categories = $this->getJSModel('category')->getCategories(JText::_('JS_SELECT_JOB_CATEGORY'), '');
        $job_salaryrange = $this->getJSModel('salaryrange')->getJobSalaryRange(JText::_('JS_SELECT_SALARY_RANGE'), '');

        if ($searchtitle)
            $lists['searchtitle'] = $searchtitle;
        if ($searchname)
            $lists['searchname'] = $searchname;
        if ($searchjobcategory)
            $lists['jobcategory'] = JHTML::_('select.genericList', $job_categories, 'searchjobcategory', 'class="inputbox" ' . 'onChange="this.form.submit();"' . 'style="width:115px"', 'value', 'text', $searchjobcategory);
        else
            $lists['jobcategory'] = JHTML::_('select.genericList', $job_categories, 'searchjobcategory', 'class="inputbox" ' . 'onChange="this.form.submit();"' . 'style="width:115px"', 'value', 'text', '');
        if ($searchjobtype)
            $lists['jobtype'] = JHTML::_('select.genericList', $job_type, 'searchjobtype', 'class="inputbox" ' . 'onChange="document.adminForm.submit();"', 'value', 'text', $searchjobtype);
        else
            $lists['jobtype'] = JHTML::_('select.genericList', $job_type, 'searchjobtype', 'class="inputbox" ' . 'onChange="document.adminForm.submit();"', 'value', 'text', '');
        if ($searchjobsalaryrange)
            $lists['jobsalaryrange'] = JHTML::_('select.genericList', $job_salaryrange, 'searchjobsalaryrange', 'class="inputbox" ' . 'onChange="document.adminForm.submit();"', 'value', 'text', $searchjobsalaryrange);
        else
            $lists['jobsalaryrange'] = JHTML::_('select.genericList', $job_salaryrange, 'searchjobsalaryrange', 'class="inputbox" ' . 'onChange="document.adminForm.submit();"', 'value', 'text', '');

        $result[0] = $this->_application;
        $result[1] = $total;
        $result[2] = $lists;
        return $result;
    }

    function getAllUnapprovedEmpApps($searchtitle, $searchname, $searchjobcategory, $searchjobtype, $searchjobsalaryrange, $limitstart, $limit) {
        if ($searchjobcategory)
            if (is_numeric($searchjobcategory) == false)
                return false;
        if ($searchjobtype)
            if (is_numeric($searchjobtype) == false)
                return false;
        if ($searchjobsalaryrange)
            if (is_numeric($searchjobsalaryrange) == false)
                return false;
        $db = JFactory :: getDBO();
        $result = array();
        $query = "SELECT COUNT(id) FROM #__js_job_resume AS app WHERE status = 0";
        if ($searchtitle)
            $query .= " AND LOWER(app.application_title) LIKE " . $db->Quote('%' . $searchtitle . '%', false);
        if ($searchname) {
            $query .= " AND (";
            $query .= " LOWER(app.first_name) LIKE " . $db->Quote('%' . $searchname . '%', false);
            $query .= " OR LOWER(app.last_name) LIKE " . $db->Quote('%' . $searchname . '%', false);
            $query .= " OR LOWER(app.middle_name) LIKE " . $db->Quote('%' . $searchname . '%', false);
            $query .= " )";
        }
        if ($searchjobcategory)
            $query .= " AND app.job_category = " . $searchjobcategory;
        if ($searchjobtype)
            $query .= " AND app.jobtype = " . $searchjobtype;
        if ($searchjobsalaryrange)
            $query .= " AND app.jobsalaryrange = " . $searchjobsalaryrange;
        $db->setQuery($query);
        $total = $db->loadResult();
        if ($total <= $limitstart)
            $limitstart = 0;

        $query = "SELECT app.id, app.application_title,app.first_name, app.last_name, app.jobtype,
				app.jobsalaryrange, app.create_date, cat.cat_title , salary.rangestart, salary.rangeend
				, jobtype.title AS jobtypetitle,currency.symbol
				FROM `#__js_job_resume` AS app 
				LEFT JOIN `#__js_job_categories` AS cat ON app.job_category = cat.id 
				LEFT JOIN `#__js_job_salaryrange` AS salary ON app.jobsalaryrange = salary.id
				LEFT JOIN `#__js_job_jobtypes` AS jobtype ON app.jobtype= jobtype.id  
				LEFT JOIN `#__js_job_currencies` AS currency ON app.currencyid= currency.id 
				WHERE app.status = 0 ";
        if ($searchtitle)
            $query .= " AND LOWER(app.application_title) LIKE " . $db->Quote('%' . $searchtitle . '%', false);
        if ($searchname) {
            $query .= " AND (";
            $query .= " LOWER(app.first_name) LIKE " . $db->Quote('%' . $searchname . '%', false);
            $query .= " OR LOWER(app.last_name) LIKE " . $db->Quote('%' . $searchname . '%', false);
            $query .= " OR LOWER(app.middle_name) LIKE " . $db->Quote('%' . $searchname . '%', false);
            $query .= " )";
        }
        if ($searchjobcategory)
            $query .= " AND app.job_category = " . $searchjobcategory;
        if ($searchjobtype)
            $query .= " AND app.jobtype = " . $searchjobtype;
        if ($searchjobsalaryrange)
            $query .= " AND app.jobsalaryrange = " . $searchjobsalaryrange;

        $query .= " ORDER BY app.create_date DESC";

        $db->setQuery($query, $limitstart, $limit);
        $this->_application = $db->loadObjectList();

        $lists = array();

        $job_type = array(
            '0' => array('value' => '', 'text' => JText::_('JS_SELECT_JOB_TYPE')),
            '1' => array('value' => JText::_(1), 'text' => JText::_('JS_JOBTYPE_FULLTIME')),
            '2' => array('value' => JText::_(2), 'text' => JText::_('JS_JOBTYPE_PARTTIME')),
            '3' => array('value' => JText::_(3), 'text' => JText::_('JS_JOBTYPE_INTERNSHIP')),);


        $job_categories = $this->getJSModel('category')->getCategories(JText::_('JS_SELECT_JOB_CATEGORY'), '');
        $job_salaryrange = $this->getJSModel('salaryrange')->getJobSalaryRange(JText::_('JS_SELECT_SALARY_RANGE'), '');

        if ($searchtitle)
            $lists['searchtitle'] = $searchtitle;
        if ($searchname)
            $lists['searchname'] = $searchname;
        if ($searchjobcategory)
            $lists['jobcategory'] = JHTML::_('select.genericList', $job_categories, 'searchjobcategory', 'class="inputbox" ' . 'onChange="this.form.submit();"' . 'style="width:115px"', 'value', 'text', $searchjobcategory);
        else
            $lists['jobcategory'] = JHTML::_('select.genericList', $job_categories, 'searchjobcategory', 'class="inputbox" ' . 'onChange="this.form.submit();"' . 'style="width:115px"', 'value', 'text', '');
        if ($searchjobtype)
            $lists['jobtype'] = JHTML::_('select.genericList', $job_type, 'searchjobtype', 'class="inputbox" ' . 'onChange="document.adminForm.submit();"', 'value', 'text', $searchjobtype);
        else
            $lists['jobtype'] = JHTML::_('select.genericList', $job_type, 'searchjobtype', 'class="inputbox" ' . 'onChange="document.adminForm.submit();"', 'value', 'text', '');
        if ($searchjobsalaryrange)
            $lists['jobsalaryrange'] = JHTML::_('select.genericList', $job_salaryrange, 'searchjobsalaryrange', 'class="inputbox" ' . 'onChange="document.adminForm.submit();"', 'value', 'text', $searchjobsalaryrange);
        else
            $lists['jobsalaryrange'] = JHTML::_('select.genericList', $job_salaryrange, 'searchjobsalaryrange', 'class="inputbox" ' . 'onChange="document.adminForm.submit();"', 'value', 'text', '');

        $result[0] = $this->_application;
        $result[1] = $total;
        $result[2] = $lists;
        return $result;
    }

    function storeResume() {
        $row = $this->getTable('resume');

        $data = JRequest :: get('post');

        if (!$this->_config)
            $this->_config = $this->getJSModel('configuration')->getConfig('');
        foreach ($this->_config as $conf) {
            if ($conf->configname == 'date_format')
                $dateformat = $conf->configvalue;
        }


        if ($dateformat == 'm/d/Y') {
            $arr = explode('/', $data['date_start']);
            $data['date_start'] = $arr[2] . '/' . $arr[0] . '/' . $arr[1];
            $arr = explode('/', $data['date_of_birth']);
            $data['date_of_birth'] = $arr[2] . '/' . $arr[0] . '/' . $arr[1];
        } elseif ($dateformat == 'd-m-Y') {
            $arr = explode('-', $data['date_start']);
            $data['date_start'] = $arr[2] . '-' . $arr[1] . '-' . $arr[0];
            $arr = explode('-', $data['date_of_birth']);
            $data['date_of_birth'] = $arr[2] . '-' . $arr[1] . '-' . $arr[0];
        }

        $data['date_start'] = date('Y-m-d H:i:s', strtotime($data['date_start']));
        $data['date_of_birth'] = date('Y-m-d H:i:s', strtotime($data['date_of_birth']));

        $data['resume'] = JRequest::getVar('resume', '', 'post', 'string', JREQUEST_ALLOWRAW);


        if (isset($data['deleteresumefile']) && ($data['deleteresumefile'] == 1)) {
            $data['filename'] = '';
            $data['filecontent'] = '';
        }
        if (isset($data['deletephoto']) && ($data['deletephoto'] == 1)) {
            $data['photo'] = '';
        }


        if (!empty($data['alias']))
            $resumealias = $this->getJSModel('common')->removeSpecialCharacter($data['alias']);
        else
            $resumealias = $this->getJSModel('common')->removeSpecialCharacter($data['application_title']);

        $resumealias = strtolower(str_replace(' ', '-', $resumealias));
        $data['alias'] = $resumealias;

        if (!$row->bind($data)) {
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
            if ($returnvalue == 6)
                $filemismatch = 1;;
        }else {
            $upload_resume_file_real_path = $resumereturnvalue;
        }
        $returnvalue = $this->uploadPhoto($row->id);
        $photomismatch = 0;
        if (empty($returnvalue) OR $returnvalue == 6) {
            if ($returnvalue == 6)
                $photomismatch = 1;
        }else {
            $upload_pic_real_path = $returnvalue;
        }
        $this->getJSModel('customfield')->storeUserFieldData($data, $row->id);
        if ($this->_client_auth_key != "") {
            $resume_picture = array();
            $resume_file = array();

            $db = $this->getDBO();
            $query = "SELECT resume.* FROM `#__js_job_resume` AS resume  
						WHERE resume.id = " . $row->id;

            $db->setQuery($query);
            $data_resume = $db->loadObject();
            if ($resumedata['id'] != "" AND $resumedata['id'] != 0)
                $data_resume->id = $resumedata['id']; // for edit case
            if ($_FILES['photo']['size'] > 0)
                $resume_picture['picfilename'] = $upload_pic_real_path;
            if ($_FILES['resumefile']['size'] > 0)
                $resume_file['resume_file'] = $upload_resume_file_real_path;

            $data_resume->resume_id = $row->id;
            $data_resume->authkey = $this->_client_auth_key;
            $data_resume->task = 'storeresume';
            $jsjobsharingobject = $this->getJSModel('jobsharing');
            $jsjobslogobject = $this->getJSModel('log');
            $return_value = $jsjobsharingobject->storeResumeSharing($data_resume);
            if ($return_value['isresumestore'] == 0)
                $jsjobslogobject->logStoreResumeSharing($return_value);
            $status_resume_pic = "";
            if ($photomismatch != 1) {
                if ($_FILES['photo']['size'] > 0)
                    $return_value_resume_pic = $jsjobsharingobject->storeResumePicSharing($data_resume, $resume_picture);
                if (isset($return_value_resume_pic)) {
                    if ($return_value_resume_pic['isresumestore'] == 0 OR $return_value_resume_pic == false)
                        $status_resume_pic = -1;
                    else
                        $status_resume_pic = 1;
                }
            }

            $status_resume_file = "";
            if ($filemismatch != 1) {
                if ($_FILES['resumefile']['size'] > 0)
                    $return_value_resume_file = $jsjobsharingobject->storeResumeFileSharing($data_resume, $resume_file);
                if (isset($return_value_resume_file)) {
                    if ($return_value_resume_file['isresumestore'] == 0 OR $return_value_resume_file == false)
                        $status_resume_file = -1;
                    else
                        $status_resume_file = 1;
                }
            }
            if (($status_resume_pic == -1 AND $status_resume_file == -1) OR ($filemismatch == 1 AND $photomismatch == 1)) {
                $return_value['message'] = "Resume Save But Error Uploading Resume File and Picture";
            } elseif (($status_resume_pic == -1) OR ($photomismatch == 1)) {
                $return_value['message'] = "Resume Save But Error Uploading Picture";
            } elseif (($status_resume_file == -1) OR ($filemismatch == 1)) {
                $return_value['message'] = "Resume Save But Error Uploading file";
            }
            $jsjobslogobject->logStoreResumeSharing($return_value);
        }

        if (($filemismatch == 1) OR ($photomismatch == 1))
            return 6;
        return true;
    }

    function uploadResume($id) {
        if (is_numeric($id) == false)
            return false;
        $row = $this->getTable('resume');
        global $resumedata;
        $db = JFactory::getDBO();
        $str = JPATH_BASE;
        $base = substr($str, 0, strlen($str) - 14); //remove administrator
        $resumequery = "SELECT * FROM `#__js_job_resume` WHERE uid = " . $db->Quote($u_id);
        $iddir = 'resume_' . $id;
        if (!isset($this->_config))
            $this->_config = $this->getJSModel('configuration')->getConfig();
        foreach ($this->_config as $conf) {
            if ($conf->configname == 'data_directory')
                $datadirectory = $conf->configvalue;
            if ($conf->configname == 'document_file_type')
                $document_file_types = $conf->configvalue;
        }
        $path = $base . '/' . $datadirectory;

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

                if (!file_exists($path)) { // creating main directory
                    $this->getJSModel('common')->makeDir($path);
                }
                $path = $path . '/data';
                if (!file_exists($path)) { // creating data directory
                    $this->getJSModel('common')->makeDir($path);
                }
                $path = $path . '/jobseeker';
                if (!file_exists($path)) { // creating jobseeker directory
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
                    $path = $path . '/data/jobseeker';
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
    }

    function uploadPhoto($id) {
        if (is_numeric($id) == false)
            return false;
        $row = $this->getTable('resume');
        global $resumedata;
        $db = JFactory::getDBO();
        $str = JPATH_BASE;
        $base = substr($str, 0, strlen($str) - 14); //remove administrator
        if (!isset($this->_config))
            $this->_config = $this->getJSModel('configuration')->getConfig();
        foreach ($this->_config as $conf) {
            if ($conf->configname == 'data_directory')
                $datadirectory = $conf->configvalue;
            if ($conf->configname == 'image_file_type')
                $image_file_types = $conf->configvalue;
        }
        $path = $base . '/' . $datadirectory;

        $resumequery = "SELECT * FROM `#__js_job_resume`
		WHERE uid = " . $db->Quote($u_id);
        $iddir = 'resume_' . $id;
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

            if (!file_exists($path)) { // creating main directory
                $this->getJSModel('common')->makeDir($path);
            }
            $path = $path . '/data';
            if (!file_exists($path)) { // creating data directory
                $this->getJSModel('common')->makeDir($path);
            }
            $path = $path . '/jobseeker';
            if (!file_exists($path)) { // creating jobseeker directory
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
            if ($resumedata['deleteresumefile'] == 1) {
                $path = $path . '/data/jobseeker';
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

    function deleteResume() {
        $db = $this->getDBO();
        $cids = JRequest :: getVar('cid', array(0), 'post', 'array');
        $row = $this->getTable('resume');
        $deleteall = 1;
        foreach ($cids as $cid) {
            $juid = 0; // jobseeker uid
            $serverresumeid = 0;
            if ($this->_client_auth_key != "") {
                $query = "SELECT resume.serverid AS id,resume.uid AS uid FROM `#__js_job_resume` AS resume WHERE resume.id = " . $cid;
                $db->setQuery($query);
                $data = $db->loadObject();
                $serverresumeid = $data->id;
                $juid = $data->uid;
            }
            if ($this->resumeCanDelete($cid) == true) {
                if (!$row->delete($cid)) {
                    $this->setError($row->getErrorMsg());
                    return false;
                }
                $this->getJSModel('customfield')->deleteUserFieldData($cid);
                if ($serverresumeid != 0) {
                    $data = array();
                    $data['id'] = $serverresumeid;
                    $data['referenceid'] = $cid;
                    $data['uid'] = $juid;
                    $data['authkey'] = $this->_client_auth_key;
                    $data['siteurl'] = $this->_siteurl;
                    $data['task'] = 'deleteresume';
                    $jsjobsharingobject = $this->getJSModel('jobsharing');
                    $return_value = $jsjobsharingobject->deleteResumeSharing($data);
                    $jsjobslogobject = $this->getJSModel('log');
                    $jsjobslogobject->logDeleteResumeSharing($return_value);
                }
            } else
                $deleteall++;
        }
        return $deleteall;
    }

    function deleteEmpApp() {
        $cids = JRequest :: getVar('cid', array(0), 'post', 'array');
        $row = $this->getTable('empapp');

        foreach ($cids as $cid) {
            if (!$row->delete($cid)) {
                $this->setError($row->getErrorMsg());
                return false;
            }
        }

        return true;
    }

    function resumeCanDelete($resumeid) {
        if (is_numeric($resumeid) == false)
            return false;
        $db = $this->getDBO();
        $query = "SELECT
                    ( SELECT COUNT(id) FROM `#__js_job_jobapply` WHERE cvid = " . $resumeid . ")
                    AS total ";
        $db->setQuery($query);
        $total = $db->loadResult();

        if ($total > 0)
            return false;
        else
            return true;
    }

    function resumeEnforceDelete($resumeid, $uid) {
        if ($uid)
            if ((is_numeric($uid) == false) || ($uid == 0) || ($uid == ''))
                return false;
        if (is_numeric($resumeid) == false)
            return false;
        $db = $this->getDBO();
        $juid = 0; // jobseeker uid
        $serverresumeid = 0;
        if ($this->_client_auth_key != "") {
            $query = "SELECT resume.serverid AS id,resume.uid AS uid FROM `#__js_job_resume` AS resume WHERE resume.id = " . $resumeid;
            $db->setQuery($query);
            $data = $db->loadObject();
            $serverresumeid = $data->id;
            $juid = $data->uid;
        }
        $query = "DELETE  resume,apply
                    FROM `#__js_job_resume` AS resume
                    LEFT JOIN `#__js_job_jobapply` AS apply ON resume.id=apply.cvid
                    WHERE resume.id = " . $resumeid;

        $db->setQuery($query);
        if (!$db->query()) {
            return 2; //error while delete resume
        }
        $this->getJSModel('customfield')->deleteUserFieldData($resumeid);
        if ($serverresumeid != 0) {
            $data = array();
            $data['id'] = $serverresumeid;
            $data['referenceid'] = $cid;
            $data['uid'] = $juid;
            $data['authkey'] = $this->_client_auth_key;
            $data['siteurl'] = $this->_siteurl;
            $data['enforcedeleteresume'] = 1;
            $data['task'] = 'deleteresume';
            $jsjobsharingobject = $this->getJSModel('jobsharing');
            $return_value = $jsjobsharingobject->deleteResumeSharing($data);
            $jsjobslogobject = $this->getJSModel('log');
            $jsjobslogobject->logDeleteResumeSharingEnforce($return_value);
        }
        return 1;
    }


// Payment System End;
// Payment Package Cofunction 
    function empappApprove($app_id) {
        if (is_numeric($app_id) == false)
            return false;
        $db = JFactory::getDBO();

        $query = "UPDATE #__js_job_resume SET status = 1 WHERE id = " . $db->Quote($app_id);
        $db->setQuery($query);
        if (!$db->query()) {
            return false;
        }
        $this->getJSModel('emailtemplate')->sendMail(3, 1, $app_id);
        if ($this->_client_auth_key != "") {
            $data_resume_approve = array();
            $query = "SELECT serverid FROM #__js_job_resume WHERE id = " . $app_id;
            $db->setQuery($query);
            $serverresumeid = $db->loadResult();
            $data_resume_approve['id'] = $serverresumeid;
            $data_resume_approve['resume_id'] = $app_id;
            $data_resume_approve['authkey'] = $this->_client_auth_key;
            $fortask = "resumeapprove";
            $server_json_data_array = json_encode($data_resume_approve);
            $jsjobsharingobject = $this->getJSModel('jobsharing');
            $return_server_value = $jsjobsharingobject->serverTask($server_json_data_array, $fortask);
            $return_value = json_decode($return_server_value, true);
            $jsjobslogobject = $this->getJSModel('log');
            $jsjobslogobject->logEmpappApprove($return_value);
        }
        return true;
    }

    function empappReject($app_id) {
        if (is_numeric($app_id) == false)
            return false;
        $db = JFactory::getDBO();

        $query = "UPDATE #__js_job_resume SET status = -1 WHERE id = " . $db->Quote($app_id);
        $db->setQuery($query);
        if (!$db->query()) {
            return false;
        }
        $this->getJSModel('emailtemplate')->sendMail(3, -1, $app_id);
        if ($this->_client_auth_key != "") {
            $data_resume_reject = array();
            $query = "SELECT serverid FROM #__js_job_resume WHERE id = " . $app_id;
            $db->setQuery($query);
            $serverresumeid = $db->loadResult();
            $data_resume_reject['id'] = $serverresumeid;
            $data_resume_reject['resume_id'] = $app_id;
            $data_resume_reject['authkey'] = $this->_client_auth_key;
            $fortask = "resumereject";
            $server_json_data_array = json_encode($data_resume_reject);
            $jsjobsharingobject = $this->getJSModel('jobsharing');
            $return_server_value = $jsjobsharingobject->serverTask($server_json_data_array, $fortask);
            $return_value = json_decode($return_server_value, true);
            $jsjobslogobject = $this->getJSModel('jobsharing');
            $jsjobslogobject->logEmpappReject($return_value);
        }
        return true;
    }

    function getEmpOptions() {
        if (!$this->_empoptions) {
            $this->_empoptions = array();

            $gender = array(
                '0' => array('value' => 1, 'text' => JText::_('JS_MALE')),
                '1' => array('value' => 2, 'text' => JText::_('JS_FEMALE')),);

            $status = array(
                '0' => array('value' => 0, 'text' => JText::_('JS_PENDDING')),
                '1' => array('value' => 1, 'text' => JText::_('JS_APPROVE')),
                '2' => array('value' => -1, 'text' => JText::_('JS_REJECT')),);

            $job_type = $this->getJSModel('jobtype')->getJobType('');
            $heighesteducation = $this->getJSModel('highesteducation')->getHeighestEducation('');
            $job_categories = $this->getJSModel('category')->getCategories('', '');
            $job_salaryrange = $this->getJSModel('salaryrange')->getJobSalaryRange('', '');
            $countries = $this->getJSModel('country')->getCountries('');
            if (isset($this->_application)) {
                $job_subcategories = $this->getJSModel('subcategory')->getSubCategoriesforCombo($this->_application->job_category, '', $this->_application->job_subcategory);
            } else {
                $job_subcategories = $this->getJSModel('subcategory')->getSubCategoriesforCombo($job_categories[0]['value'], '', '');
            }

            if (isset($this->_application)) {
                $this->_empoptions['nationality'] = JHTML::_('select.genericList', $countries, 'nationality', 'class="inputbox" ' . '', 'value', 'text', $this->_application->nationality);
                $this->_empoptions['gender'] = JHTML::_('select.genericList', $gender, 'gender', 'class="inputbox" ' . '', 'value', 'text', $this->_application->gender);

                $this->_empoptions['job_category'] = JHTML::_('select.genericList', $job_categories, 'job_category', 'class="inputbox" ' . 'onChange="fj_getsubcategories(\'fj_subcategory\', this.value)"', 'value', 'text', $this->_application->job_category);
                $this->_empoptions['job_subcategory'] = JHTML::_('select.genericList', $job_subcategories, 'job_subcategory', 'class="inputbox" ' . '', 'value', 'text', $this->_application->job_subcategory);

                $this->_empoptions['jobtype'] = JHTML::_('select.genericList', $job_type, 'jobtype', 'class="inputbox" ' . '', 'value', 'text', $this->_application->jobtype);
                $this->_empoptions['heighestfinisheducation'] = JHTML::_('select.genericList', $heighesteducation, 'heighestfinisheducation', 'class="inputbox" ' . '', 'value', 'text', $this->_application->heighestfinisheducation);
                $this->_empoptions['jobsalaryrange'] = JHTML::_('select.genericList', $job_salaryrange, 'jobsalaryrange', 'class="inputbox" ' . '', 'value', 'text', $this->_application->jobsalaryrange);
                $this->_empoptions['status'] = JHTML::_('select.genericList', $status, 'status', 'class="inputbox required" ' . '', 'value', 'text', $this->_application->status);
                $this->_empoptions['currencyid'] = JHTML::_('select.genericList', $this->getJSModel('currency')->getCurrency(), 'currencyid', 'class="inputbox required" ' . '', 'value', 'text', $this->_application->currencyid);
                $address_city = ($this->_application->address_city == "" OR $this->_application->address_city == 0 ) ? -1 : $this->_application->address_city;
                $this->_empoptions['address_city'] = $this->getJSModel('city')->getAddressDataByCityName('', $address_city);
                $address1_city = ($this->_application->address1_city == "" OR $this->_application->address1_city == 0 ) ? -1 : $this->_application->address1_city;
                $this->_empoptions['address1_city'] = $this->getJSModel('city')->getAddressDataByCityName('', $address1_city);
                $address2_city = ($this->_application->address2_city == "" OR $this->_application->address2_city == 0 ) ? -1 : $this->_application->address2_city;
                $this->_empoptions['address2_city'] = $this->getJSModel('city')->getAddressDataByCityName('', $address2_city);
                $institute_city = ($this->_application->institute_city == "" OR $this->_application->institute_city == 0 ) ? -1 : $this->_application->institute_city;
                $this->_empoptions['institute_city'] = $this->getJSModel('city')->getAddressDataByCityName('', $institute_city);
                $institute1_city = ($this->_application->institute1_city == "" OR $this->_application->institute1_city == 0 ) ? -1 : $this->_application->institute1_city;
                $this->_empoptions['institute1_city'] = $this->getJSModel('city')->getAddressDataByCityName('', $institute1_city);
                $institute2_city = ($this->_application->institute2_city == "" OR $this->_application->institute2_city == 0 ) ? -1 : $this->_application->institute2_city;
                $this->_empoptions['institute2_city'] = $this->getJSModel('city')->getAddressDataByCityName('', $institute2_city);
                $institute3_city = ($this->_application->institute3_city == "" OR $this->_application->institute3_city == 0 ) ? -1 : $this->_application->institute3_city;
                $this->_empoptions['institute3_city'] = $this->getJSModel('city')->getAddressDataByCityName('', $institute3_city);
                $employer_city = ($this->_application->employer_city == "" OR $this->_application->employer_city == 0 ) ? -1 : $this->_application->employer_city;
                $this->_empoptions['employer_city'] = $this->getJSModel('city')->getAddressDataByCityName('', $employer_city);
                $employer1_city = ($this->_application->employer1_city == "" OR $this->_application->employer1_city == 0 ) ? -1 : $this->_application->employer1_city;
                $this->_empoptions['employer1_city'] = $this->getJSModel('city')->getAddressDataByCityName('', $employer1_city);
                $employer2_city = ($this->_application->employer2_city == "" OR $this->_application->employer2_city == 0 ) ? -1 : $this->_application->employer2_city;
                $this->_empoptions['employer2_city'] = $this->getJSModel('city')->getAddressDataByCityName('', $employer2_city);
                $employer3_city = ($this->_application->employer3_city == "" OR $this->_application->employer3_city == 0 ) ? -1 : $this->_application->employer3_city;
                $this->_empoptions['employer3_city'] = $this->getJSModel('city')->getAddressDataByCityName('', $employer3_city);
                $reference_city = ($this->_application->reference_city == "" OR $this->_application->reference_city == 0 ) ? -1 : $this->_application->reference_city;
                $this->_empoptions['reference_city'] = $this->getJSModel('city')->getAddressDataByCityName('', $reference_city);
                $reference1_city = ($this->_application->reference1_city == "" OR $this->_application->reference1_city == 0 ) ? -1 : $this->_application->reference1_city;
                $this->_empoptions['reference1_city'] = $this->getJSModel('city')->getAddressDataByCityName('', $reference1_city);
                $reference2_city = ($this->_application->reference2_city == "" OR $this->_application->reference2_city == 0 ) ? -1 : $this->_application->reference2_city;
                $this->_empoptions['reference2_city'] = $this->getJSModel('city')->getAddressDataByCityName('', $reference2_city);
                $reference3_city = ($this->_application->reference3_city == "" OR $this->_application->reference3_city == 0 ) ? -1 : $this->_application->reference3_city;
                $this->_empoptions['reference3_city'] = $this->getJSModel('city')->getAddressDataByCityName('', $reference3_city);
            } else {
                $this->_empoptions['nationality'] = JHTML::_('select.genericList', $countries, 'nationality', 'class="inputbox" ' . '', 'value', 'text', '');
                $this->_empoptions['gender'] = JHTML::_('select.genericList', $gender, 'gender', 'class="inputbox" ' . '', 'value', 'text', '');

                $this->_empoptions['job_category'] = JHTML::_('select.genericList', $job_categories, 'job_category', 'class="inputbox" ' . 'onChange="fj_getsubcategories(\'fj_subcategory\', this.value)"', 'value', 'text', '');
                $this->_empoptions['job_subcategory'] = JHTML::_('select.genericList', $job_subcategories, 'job_subcategory', 'class="inputbox" ' . '', 'value', 'text', '');


                $this->_empoptions['jobtype'] = JHTML::_('select.genericList', $job_type, 'jobtype', 'class="inputbox" ' . '', 'value', 'text', '');
                $this->_empoptions['heighestfinisheducation'] = JHTML::_('select.genericList', $heighesteducation, 'heighestfinisheducation', 'class="inputbox" ' . '', 'value', 'text', '');
                $this->_empoptions['jobsalaryrange'] = JHTML::_('select.genericList', $job_salaryrange, 'jobsalaryrange', 'class="inputbox" ' . '', 'value', 'text', '');
                $this->_empoptions['status'] = JHTML::_('select.genericList', $status, 'status', 'class="inputbox required" ' . '', 'value', 'text', '');
                $this->_empoptions['currencyid'] = JHTML::_('select.genericList', $this->getJSModel('currency')->getCurrency(), 'currencyid', 'class="inputbox required" ' . '', 'value', 'text', '');
            }
        }
        return $this->_empoptions;
    }

}
?>