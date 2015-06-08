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

class JSJobsModelJobSearch extends JSModel {

    var $_uid = null;
    var $_client_auth_key = null;
    var $_siteurl = null;
    var $_config = null;
    var $_searchoptions = null;

    function __construct() {
        parent :: __construct();
        $this->_client_auth_key = $this->getJSModel('common')->getClientAuthenticationKey();
        $this->_siteurl = JURI::root();
        $user = JFactory::getUser();
        $this->_uid = $user->id;
    }

    function deleteJobSearch($searchid, $uid) {
        $db = $this->getDBO();
        $row = $this->getTable('jobsearch');

        if ((is_numeric($uid) == false) || ($uid == 0) || ($uid == ''))
            return false;
        if (is_numeric($searchid) == false)
            return false;

        $query = "SELECT COUNT(search.id) FROM `#__js_job_jobsearches` AS search WHERE search.id = " . $searchid . " AND search.uid = " . $uid;
        $db->setQuery($query);
        $searchtotal = $db->loadResult();

        if ($searchtotal > 0) { // this search is same user
            if (!$row->delete($searchid)) {
                $this->setError($row->getErrorMsg());
                return false;
            }
        } else
            return 2;

        return true;
    }

    function getMyJobSearchesbyUid($u_id, $limit, $limitstart) {
        if ((is_numeric($u_id) == false) || ($u_id == 0) || ($u_id == ''))
            return false;
        $db = $this->getDBO();
        $result = array();
        $query = "SELECT COUNT(id) FROM `#__js_job_jobsearches` WHERE uid  = " . $u_id;
        $db->setQuery($query);
        $total = $db->loadResult();
        if ($total <= $limitstart)
            $limitstart = 0;

        $query = "SELECT search.* FROM `#__js_job_jobsearches` AS search WHERE search.uid  = " . $u_id;
        $db->setQuery($query);
        $db->setQuery($query, $limitstart, $limit);

        $result[0] = $db->loadObjectList();
        $result[1] = $total;

        return $result;
    }

    function getJobSearchebyId($id) {
        $db = $this->getDBO();
        if (is_numeric($id) == false)
            return false;
        $query = "SELECT search.* FROM `#__js_job_jobsearches` AS search WHERE search.id  = " . $id;
        $db->setQuery($query);
        return $db->loadObject();
    }

    function storeJobSearch($data) {
        global $resumedata;
        $row = $this->getTable('jobsearch');

        if (!$row->bind($data)) {
            $this->setError($this->_db->getErrorMsg());
            return false;
        }
        $returnvalue = $this->canAddNewJobSearch($data['uid']);
        if ($returnvalue == 0)
            return 3; //not allowed save new search
        if (!$row->store()) {
            $this->setError($this->_db->getErrorMsg());
            echo $this->_db->getErrorMsg();
            return false;
        }
        return true;
    }

    function canAddNewJobSearch($uid) {
        if ((is_numeric($uid) == false) || ($uid == 0) || ($uid == ''))
            return false;
        $db = $this->getDBO();
        if (!isset($this->_config)) {
            $this->_config = $this->getJSModel('configurations')->getConfig('');
        }
        foreach ($this->_config as $conf) {
            if ($conf->configname == 'js_newlisting_requiredpackage')
                $newlisting_required_package = $conf->configvalue;
        }

        if ($newlisting_required_package == 0) {
            return 1;
        } else {
            $query = "SELECT package.savejobsearch
			FROM `#__js_job_paymenthistory` AS payment
			JOIN `#__js_job_jobseekerpackages` AS package ON package.id = payment.packageid
			WHERE payment.uid = " . $uid . " AND payment.packagefor = 2";
            $db->setQuery($query);
            $jobs = $db->loadObjectList();
            if ($jobs) {
                foreach($jobs AS $job){
                    if($job->savejobsearch == 1)
                        return 1;
                }
                return 0;
            }
            return 0;
        }
    }
    function getSearchOptions($uid) {
        if ($uid)
            if ((is_numeric($uid) == false) || ($uid == 0) || ($uid == ''))
                return false;
        $db = $this->getDBO();

        $searchjobconfig = $this->getJSModel('configurations')->getConfigByFor('searchjob');

        if (!$this->_searchoptions) {
            $defaultCategory = $this->getJSModel('common')->getDefaultValue('categories');
            $defaultJobtype = $this->getJSModel('common')->getDefaultValue('jobtypes');
            $defaultJobstatus = $this->getJSModel('common')->getDefaultValue('jobstatus');
            $defaultShifts = $this->getJSModel('common')->getDefaultValue('shifts');
            $defaultEducation = $this->getJSModel('common')->getDefaultValue('heighesteducation');
            $defaultSalaryrange = $this->getJSModel('common')->getDefaultValue('salaryrange');
            $defaultSalaryrangeType = $this->getJSModel('common')->getDefaultValue('salaryrangetypes');
            $defaultCurrencies = $this->getJSModel('common')->getDefaultValue('currencies');

            $this->_searchoptions = array();
            $companies = $this->getJSModel('company')->getAllCompanies(JText::_('JS_SELECT_COMPANY'));
            $job_type = $this->getJSModel('jobtype')->getJobType(JText::_('JS_SELECT_JOB_TYPE'));
            $jobstatus = $this->getJSModel('jobstatus')->getJobStatus(JText::_('JS_SELECT_JOB_STATUS'));
            $heighesteducation = $this->getJSModel('highesteducation')->getHeighestEducation(JText::_('JS_SELECT_HIGHEST_EDUCATION'));
            $job_categories = $this->getJSModel('category')->getCategories(JText::_('JS_SELECT_CATEGORY'));
            $job_subcategories = $this->getJSModel('subcategory')->getSubCategoriesforCombo($defaultCategory, JText::_('JS_SELECT_SUB_CATEGORY'), '');
            $job_salaryrange = $this->getJSModel('salaryrange')->getJobSalaryRange(JText::_('JS_SELECT_SALARY_RANGE'), '');
            $shift = $this->getJSModel('shift')->getShift(JText::_('JS_SELECT_JOB_SHIFT'));
            $currencies = $this->getJSModel('currency')->getCurrency(JText::_('JS_ALL'));
            $this->_searchoptions['educationminimax'] = JHTML::_('select.genericList', $this->getJSModel('common')->getMiniMax(''), 'educationminimax', 'class="inputbox jsjobs-cbo" ' . '', 'value', 'text', '');
            $this->_searchoptions['education'] = JHTML::_('select.genericList', $this->getJSModel('highesteducation')->getHeighestEducation(''), 'educationid', 'class="inputbox jsjobs-cbo" ' . '', 'value', 'text', '');
            $this->_searchoptions['jobsalaryrange'] = JHTML::_('select.genericList', $job_salaryrange, 'jobsalaryrange', 'class="inputbox jsjobs-cbo" ' . '', 'value', 'text', '');
            $this->_searchoptions['salaryrangefrom'] = JHTML::_('select.genericList', $this->getJSModel('salaryrange')->getJobSalaryRange(JText::_('JS_FROM'), 1), 'salaryrangefrom', 'class="inputbox jsjobs-cbo" style="width:80px;"' . '', 'value', 'text', '');
            $this->_searchoptions['salaryrangeto'] = JHTML::_('select.genericList', $this->getJSModel('salaryrange')->getJobSalaryRange(JText::_('JS_TO'), 1), 'salaryrangeto', 'class="inputbox jsjobs-cbo" style="width:80px;"' . '', 'value', 'text', '');
            $this->_searchoptions['salaryrangetypes'] = JHTML::_('select.genericList', $this->getJSModel('salaryrangetype')->getSalaryRangeTypes(''), 'salaryrangetype', 'class="inputbox jsjobs-cbo" style="width:120px;"' . '', 'value', 'text', '');
            $this->_searchoptions['companies'] = JHTML::_('select.genericList', $companies, 'company', 'class="inputbox jsjobs-cbo" ' . '', 'value', 'text', '');
            $this->_searchoptions['jobcategory'] = JHTML::_('select.genericList', $job_categories, 'jobcategory', 'class="inputbox jsjobs-cbo" ' . 'onChange="fj_getsubcategories(\'fj_subcategory\', this.value)"', 'value', 'text', '');
            $this->_searchoptions['jobsubcategory'] = JHTML::_('select.genericList', $job_subcategories, 'jobsubcategory', 'class="inputbox jsjobs-cbo" ' . '', 'value', 'text', '');
            $this->_searchoptions['jobstatus'] = JHTML::_('select.genericList', $jobstatus, 'jobstatus', 'class="inputbox jsjobs-cbo" ' . '', 'value', 'text', '');
            $this->_searchoptions['jobtype'] = JHTML::_('select.genericList', $job_type, 'jobtype', 'class="inputbox jsjobs-cbo" ' . '', 'value', 'text', '');
            $this->_searchoptions['heighestfinisheducation'] = JHTML::_('select.genericList', $heighesteducation, 'heighestfinisheducation', 'class="inputbox jsjobs-cbo" ' . '', 'value', 'text', '');
            $this->_searchoptions['shift'] = JHTML::_('select.genericList', $shift, 'shift', 'class="inputbox jsjobs-cbo" ' . '', 'value', 'text', '');
            $this->_searchoptions['currency'] = JHTML::_('select.genericList', $currencies, 'currency', 'class="inputbox jsjobs-cbo" style="width:50px;"' . '', 'value', 'text', '');
            $result = array();
            $result[0] = $this->_searchoptions;
            $result[1] = $searchjobconfig;
        }
        
        return $result;
    }
    
    function canJobSearch($uid){
        if ($uid)
            if ((is_numeric($uid) == false) || ($uid == ''))
                return false;
        $db = $this->getDbo();
        if ($uid == 0) { //guest
            $canview = 1;
        } else {
            $query = "SELECT package.jobsearch, package.packageexpireindays, payment.created
                    FROM `#__js_job_jobseekerpackages` AS package
                    JOIN `#__js_job_paymenthistory` AS payment ON (payment.packageid = package.id AND payment.packagefor=2)
                    WHERE payment.uid = " . $uid . "
                    AND DATE_ADD(payment.created,INTERVAL package.packageexpireindays DAY) >= CURDATE()
                    AND payment.transactionverified = 1 AND payment.status = 1";
            //echo $query;
            $db->setQuery($query);
            $jobs = $db->loadObjectList();
            $canview = 0;
            if (empty($jobs))
                $canview = 1; // for those who not get any role

            foreach ($jobs AS $job) {
                if ($job->jobsearch == 1) {
                    $canview = 1;
                    break;
                } else {
                    $canview = 0;
                }
            }
        }
        if($canview == 1){
            return VALIDATE;
        }else{
            return JOB_SEARCH_NOT_ALLOWED_IN_PACKAGE;
        }
    }
}
?>
    
