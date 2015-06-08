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
class JSJobsModelCommon extends JSModel{

    var $_config = null;
    var $_defaultcurrency = null;
    var $_client_auth_key = null;
    var $_siteurl = null;
    var $_application = null;
    var $_options = null;

    function __construct() {
        parent :: __construct();
        $this->_client_auth_key = $this->getJSModel('jobsharing')->getClientAuthenticationKey();
        $this->_siteurl = JURI::root();
        $this->_defaultcurrency = $this->getJSModel('currency')->getDefaultCurrency();
        $user = JFactory::getUser();
        $this->_uid = $user->id;
    }

    function removeSpecialCharacter($string) {
        $string = strtolower($string);
        $string = strip_tags($string, "");
        //Strip any unwanted characters
        $string = preg_replace("/[^a-z0-9_\s-]/", "", $string);
        //Clean multiple dashes or whitespaces
        $string = preg_replace("/[\s-]+/", " ", $string);
        //Convert whitespaces and underscore to dash
        $string = preg_replace("/[\s_]/", "-", $string);
        return $string;
    }

    function setDefaultForDefaultTable($id, $for) {
        if (is_numeric($id) == false)
            return false;
        $db = JFactory :: getDBO();
        switch ($for) {
            case "jobtypes":
            case "jobstatus":
            case "shifts":
            case "heighesteducation":
            case "ages":
            case "careerlevels":
            case "experiences":
            case "salaryrange":
            case "salaryrangetypes":
            case "categories":
            case "subcategories":
                $query = "update `#__js_job_" . $for . "` SET isdefault = 0 ";
                $db->setQuery($query);
                $db->Query();
                $query = "UPDATE  `#__js_job_" . $for . "` SET isdefault=1 WHERE id=" . $id;
                $db->setQuery($query);
                if (!$db->Query())
                    return false;
                else
                    return true;
                break;
        }
    }

    function getDefaultValue($table) {
        $db = JFactory :: getDBO();

        switch ($table) {
            case "categories":
            case "jobtypes":
            case "jobstatus":
            case "shifts":
            case "heighesteducation":
            case "ages":
            case "careerlevels":
            case "experiences":
            case "salaryrange":
            case "salaryrangetypes":
            case "subcategories":
                $query = "SELECT id FROM `#__js_job_" . $table . "` WHERE isdefault=1";
                $db->setQuery($query);
                $default_id = $db->loadResult();
                if ($default_id)
                    return $default_id;
                else {
                    $query = "SELECT min(id) AS id FROM `#__js_job_" . $table . "`";
                    $db->setQuery($query);
                    $min_id = $db->loadResult();
                    return $min_id;
                }
            case "currencies":
                $query = "SELECT id FROM `#__js_job_" . $table . "` WHERE `default`=1";
                $db->setQuery($query);
                $default_id = $db->loadResult();
                if ($default_id)
                    return $default_id;
                else {
                    $query = "SELECT min(id) AS id FROM `#__js_job_" . $table . "`";
                    $db->setQuery($query);
                    $min_id = $db->loadResult();
                    return $min_id;
                }
                break;
        }
    }

    function setOrderingUpForDefaultTable($field_id, $for) {
        if (is_numeric($field_id) == false)
            return false;
        $db = JFactory::getDBO();
        $query = "UPDATE #__js_job_" . $for . " AS f1, #__js_job_" . $for . " AS f2
					SET f1.ordering = f1.ordering - 1
					WHERE f1.ordering = f2.ordering + 1
					AND f2.id = " . $field_id;
        $db->setQuery($query);
        if (!$db->query()) {
            return false;
        }
        $query = " UPDATE #__js_job_" . $for . "
					SET ordering = ordering + 1
					WHERE id = " . $field_id;
        $db->setQuery($query);
        if (!$db->query()) {
            return false;
        }
        return true;
    }

    function setOrderingDownForDefaultTable($field_id, $for) {
        if (is_numeric($field_id) == false)
            return false;
        $db = JFactory::getDBO();
        $query = "UPDATE #__js_job_" . $for . " AS f1, #__js_job_" . $for . " AS f2
					SET f1.ordering = f1.ordering + 1 
					WHERE f1.ordering = f2.ordering - 1
					AND f2.id = " . $field_id;
        $db->setQuery($query);
        $result = $db->query();
        if (!$result) {
            return false;
        }
        $query = " UPDATE #__js_job_" . $for . "
					SET ordering = ordering - 1
					WHERE id = " . $field_id;
        $db->setQuery($query);
        if (!$db->query()) {
            return false;
        }
        return true;
    }

    function getMultiSelectEdit($id, $for) {
        if (!is_numeric($id))
            return false;
        $db = JFactory::getDbo();
        $config = $this->getJSModel('configuration')->getConfigByFor('default');
        $query = "SELECT city.id AS id, concat(city.name";
        switch ($config['defaultaddressdisplaytype']) {
            case 'csc'://City, State, Country
                $query .= " ,', ', (IF(state.name is not null,state.name,'')),IF(state.name is not null,', ',''),country.name)";
                break;
            case 'cs'://City, State
                $query .= " ,', ', (IF(state.name is not null,state.name,'')))";
                break;
            case 'cc'://City, Country
                $query .= " ,', ', country.name)";
                break;
            case 'c'://city by default select for each case
                $query .= ")";
                break;
        }
        $query .= " AS name ";
        switch ($for) {
            case 1:
                $query .= " FROM `#__js_job_jobcities` AS mcity";
                break;
            case 2:
                $query .= " FROM `#__js_job_companycities` AS mcity";
                break;
        }
        $query .=" JOIN `#__js_job_cities` AS city on city.id=mcity.cityid
		  JOIN `#__js_job_countries` AS country on city.countryid=country.id
		  LEFT JOIN `#__js_job_states` AS state on city.stateid=state.id";
        switch ($for) {
            case 1:
                $query .= " WHERE mcity.jobid = $id AND country.enabled = 1 AND city.enabled = 1";
                break;
            case 2:
                $query .= " WHERE mcity.companyid = $id AND country.enabled = 1 AND city.enabled = 1";
                break;
            case 3:
                $query .= " WHERE mcity.alertid = $id AND country.enabled = 1 AND city.enabled = 1";
                break;
        }

        $db->setQuery($query);
        $result = $db->loadObjectList();
        $json_array = json_encode($result);
        if (empty($json_array))
            return null;
        else
            return $json_array;
    }

    function getPaymentStatus($title) {
        $db = JFactory::getDBO();
        $AppRej = array();
        if ($title)
            $AppRej[] = array('value' => '', 'text' => $title);

        $AppRej[] = array('value' => 1, 'text' => JText::_('JS_VERIFIED'));
        $AppRej[] = array('value' => -1, 'text' => JText::_('JS_NOT_VERIFIED'));

        return $AppRej;
    }

    function getRequiredTravel($title) {
        $requiredtravel = array();
        if ($title)
            $requiredtravel[] = array('value' => '', 'text' => $title);
        $requiredtravel[] = array('value' => 1, 'text' => JText::_('JS_NOT_REQUIRED'));
        $requiredtravel[] = array('value' => 2, 'text' => JText::_('JS_25_PER'));
        $requiredtravel[] = array('value' => 3, 'text' => JText::_('JS_50_PER'));
        $requiredtravel[] = array('value' => 4, 'text' => JText::_('JS_75_PER'));
        $requiredtravel[] = array('value' => 5, 'text' => JText::_('JS_100_PER'));
        return $requiredtravel;
    }

    function getMiniMax($title) {
        $minimax = array();
        if ($title)
            $minimax[] = array('value' => JText::_(''), 'text' => $title);
        $minimax[] = array('value' => 1, 'text' => JText::_('JS_MINIMUM'));
        $minimax[] = array('value' => 2, 'text' => JText::_('JS_MAXIMUM'));

        return $minimax;
    }

    function getGender($title) {
        $gender = array();
        if ($title)
            $gender[] = array('value' => '', 'text' => $title);
        $gender[] = array('value' => 1, 'text' => JText::_('JS_MALE'));
        $gender[] = array('value' => 2, 'text' => JText::_('JS_FEMALE'));
        return $gender;
    }

    function getSendEmail() {
        $values = array();
        $values[] = array('value' => 0, 'text' => JText::_('JS_NO'));
        $values[] = array('value' => 1, 'text' => JText::_('JS_YES'));
        $values[] = array('value' => 2, 'text' => JText::_('JS_YES_WITH_RESUME'));
        return $values;
    }

    function checkImageFileExtensions($file_name, $file_tmp, $image_extension_allow) {
        $allow_image_extension = explode(',', $image_extension_allow);
        if ($file_name != '' AND $file_tmp != "") {
            $ext = $this->getExtension($file_name);
            $ext = strtolower($ext);
            if (in_array($ext, $allow_image_extension))
                return 1;
            else
                return 6; //file type mistmathc
        }
    }

    function checkDocumentFileExtensions($file_name, $file_tmp, $document_extension_allow) {
        $allow_document_extension = explode(',', $document_extension_allow);
        if ($file_name != '' AND $file_tmp != "") {
            $ext = $this->getExtension($file_name);
            $ext = strtolower($ext);
            if (in_array($ext, $allow_document_extension))
                return 1;
            else
                return 6; //file type mistmathc
        }
    }

    function getOptions() {
        if (!$this->_options) {
            $this->_options = array();
            $job_type = array(
                '0' => array('value' => JText::_(1),
                    'text' => JText::_('JS_JOBTYPE_FULLTIME')),
                '1' => array('value' => JText::_(2),
                    'text' => JText::_('JS_JOBTYPE_PARTTIME')),
                '3' => array('value' => JText::_(3),
                    'text' => JText::_('JS_JOBTYPE_INTERNSHIP')),);


            $heighesteducation = array(
                '0' => array('value' => JText::_(1),
                    'text' => JText::_('JS_JOBEDUCATION_UNIVERSITY')),
                '1' => array('value' => JText::_(2),
                    'text' => JText::_('JS_JOBEDUCATION_COLLEGE')),
                '2' => array('value' => JText::_(2),
                    'text' => JText::_('JS_JOBEDUCATION_HIGH_SCHOOL')),
                '3' => array('value' => JText::_(3),
                    'text' => JText::_('JS_JOBEDUCATION_NO_SCHOOL')),);

            $jobstatus = array(
                '0' => array('value' => JText::_(1),
                    'text' => JText::_('JS_JOBSTATUS_SOURCING')),
                '1' => array('value' => JText::_(2),
                    'text' => JText::_('JS_JOBSTATUS_INTERVIEWING')),
                '2' => array('value' => JText::_(3),
                    'text' => JText::_('JS_JOBSTATUS_CLOSED')),
                '3' => array('value' => JText::_(4),
                    'text' => JText::_('JS_JOBSTATUS_FINALISTS')),
                '4' => array('value' => JText::_(5),
                    'text' => JText::_('JS_JOBSTATUS_PENDING')),
                '5' => array('value' => JText::_(6),
                    'text' => JText::_('JS_JOBSTATUS_HOLD')),);


            $job_categories = $this->getJSModel('category')->getCategories('', '');
            $job_salaryrange = $this->getJSModel('salaryrange')->getJobSalaryRange('', '');
            $countries = $this->getJSModel('country')->getCountries('');
            if (isset($this->_application))
                $states = $this->getStates($this->_application->country);
            if (isset($this->_application))
                $counties = $this->getCounties($this->_application->state);
            if (isset($this->_application))
                $cities = $this->getCities($this->_application->county);
            if (isset($this->_application)) {
                $this->_options['jobcategory'] = JHTML::_('select.genericList', $job_categories, 'jobcategory', 'class="inputbox" ' . '', 'value', 'text', $this->_application->jobcategory);
                $this->_options['jobsalaryrange'] = JHTML::_('select.genericList', $job_salaryrange, 'jobsalaryrange', 'class="inputbox" ' . '', 'value', 'text', $this->_application->jobsalaryrange);
                $this->_options['country'] = JHTML::_('select.genericList', $countries, 'country', 'class="inputbox" ' . 'onChange="dochange(\'state\', this.value)"', 'value', 'text', $this->_application->country);
                if (isset($states[1]))
                    if ($states[1] != '')
                        $this->_options['state'] = JHTML::_('select.genericList', $states, 'state', 'class="inputbox" ' . 'onChange="dochange(\'county\', this.value)"', 'value', 'text', $this->_application->state);
                if (isset($counties[1]))
                    if ($counties[1] != '')
                        $this->_options['county'] = JHTML::_('select.genericList', $counties, 'county', 'class="inputbox" ' . 'onChange="dochange(\'city\', this.value)"', 'value', 'text', $this->_application->county);
                if (isset($cities[1]))
                    if ($cities[1] != '')
                        $this->_options['city'] = JHTML::_('select.genericList', $cities, 'city', 'class="inputbox" ' . '', 'value', 'text', $this->_application->city);
                $this->_options['jobstatus'] = JHTML::_('select.genericList', $jobstatus, 'jobstatus', 'class="inputbox" ' . '', 'value', 'text', $this->_application->jobstatus);
                $this->_options['jobtype'] = JHTML::_('select.genericList', $job_type, 'jobtype', 'class="inputbox" ' . '', 'value', 'text', $this->_application->jobtype);
                $this->_options['heighestfinisheducation'] = JHTML::_('select.genericList', $heighesteducation, 'heighestfinisheducation', 'class="inputbox" ' . '', 'value', 'text', $this->_application->heighestfinisheducation);
            }else {
                $this->_options['jobcategory'] = JHTML::_('select.genericList', $job_categories, 'jobcategory', 'class="inputbox" ' . '', 'value', 'text', '');
                $this->_options['jobsalaryrange'] = JHTML::_('select.genericList', $job_salaryrange, 'jobsalaryrange', 'class="inputbox" ' . '', 'value', 'text', '');
                $this->_options['country'] = JHTML::_('select.genericList', $countries, 'country', 'class="inputbox" ' . 'onChange="dochange(\'state\', this.value)"', 'value', 'text', '');
                if (isset($states[1]))
                    if ($states[1] != '')
                        $this->_options['state'] = JHTML::_('select.genericList', $states, 'state', 'class="inputbox" ' . 'onChange="dochange(\'county\', this.value)"', 'value', 'text', '');
                if (isset($counties[1]))
                    if ($counties[1] != '')
                        $this->_options['county'] = JHTML::_('select.genericList', $counties, 'county', 'class="inputbox" ' . 'onChange="dochange(\'city\', this.value)"', 'value', 'text', '');
                if (isset($cities[1]))
                    if ($cities[1] != '')
                        $this->_options['city'] = JHTML::_('select.genericList', $cities, 'city', 'class="inputbox" ' . '', 'value', 'text', '');
                $this->_options['jobstatus'] = JHTML::_('select.genericList', $jobstatus, 'jobstatus', 'class="inputbox" ' . '', 'value', 'text', '');
                $this->_options['jobtype'] = JHTML::_('select.genericList', $job_type, 'jobtype', 'class="inputbox" ' . '', 'value', 'text', '');
                $this->_options['heighestfinisheducation'] = JHTML::_('select.genericList', $heighesteducation, 'heighestfinisheducation', 'class="inputbox" ' . '', 'value', 'text', '');
            }
        }
        return $this->_options;
    }

    function getExtension($str) {

        $i = strrpos($str, ".");
        if (!$i) {
            return "";
        }
        $l = strlen($str) - $i;
        $ext = substr($str, $i + 1, $l);
        return $ext;
    }

    function makeDir($path) {
        if (!file_exists($path)) { // create directory
            mkdir($path, 0755);
            $ourFileName = $path . '/index.html';
            $ourFileHandle = fopen($ourFileName, 'w') or die("can't open file");
            fclose($ourFileHandle);
        }
    }

    function getJobtempModelFrontend() {
        $componentPath = JPATH_SITE . '/components/com_jsjobs';
        require_once $componentPath . '/models/jobtemp.php';
        $jobtemp_model = new JSJobsModelJobtemp();
        return $jobtemp_model;
    }

}

?>