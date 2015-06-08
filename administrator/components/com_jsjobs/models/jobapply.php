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

class JSJobsModelJobapply extends JSModel{

    var $_config = null;
    var $_defaultcurrency = null;
    var $_client_auth_key = null;
    var $_siteurl = null;
    var $_application = null;

    function __construct() {
        parent :: __construct();
        $this->_client_auth_key = $this->getJSModel('jobsharing')->getClientAuthenticationKey();
        $this->_siteurl = JURI::root();
        $this->_defaultcurrency = $this->getJSModel('currency')->getDefaultCurrency();
        $user = JFactory::getUser();
        $this->_uid = $user->id;
    }

    function getAppliedResume($searchtitle, $searchcompany, $searchjobcategory, $searchjobtype, $searchjobstatus, $limitstart, $limit) {
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
        $query = "SELECT COUNT(job.id) FROM #__js_job_jobs AS job
		JOIN `#__js_job_companies` AS company ON job.companyid = company.id
		WHERE job.status <> 0";
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
				, ( SELECT COUNT(id) FROM `#__js_job_jobapply` WHERE jobid = job.id) AS totalresume
				FROM `#__js_job_jobs` AS job 
				JOIN `#__js_job_categories` AS cat ON job.jobcategory = cat.id
				JOIN `#__js_job_jobtypes` AS jobtype ON job.jobtype = jobtype.id 
				JOIN `#__js_job_companies` AS company ON job.companyid = company.id
				LEFT JOIN `#__js_job_jobstatus` AS jobstatus ON job.jobstatus = jobstatus.id 
				WHERE job.status <> 0";
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


    function sendToCandidate($data) {
        $senderName = "";
        $senderemail = $data[0];
        $recipient = $data[1];
        $msgBody = $data[3];
        $msgSubject = $data[2];
        $message = JFactory::getMailer();
        $message->addRecipient($recipient); //to email
        $message->setSubject($msgSubject);
        $message->setBody($msgBody);
        $sender = array($senderemail, $senderName);
        $message->setSender($sender);
        $message->IsHTML(true);
        if (!$message->send())
            $sent = $message->sent();
        else
            $sent = JText::_('JS_MAIL_SEND_SUCCESSFULLY');
        return $sent;
    }

    function getJobAppliedResume($needle_array, $tab_action, $jobid, $limitstart, $limit) {
        if (is_numeric($jobid) == false)
            return false;
        $db = JFactory :: getDBO();
        $result = array();
        if (!empty($needle_array)) {
            $needle_array = json_decode($needle_array, true);
            $tab_action = "";
        }
        $query = "SELECT COUNT(job.id)
		FROM `#__js_job_jobs` AS job
		   , `#__js_job_jobapply` AS apply  
		   , `#__js_job_resume` AS app  
		   
		WHERE apply.jobid = job.id AND apply.cvid = app.id AND apply.jobid = " . $jobid;
        if ($tab_action)
            $query.=" AND apply.action_status=" . $tab_action;
        if (isset($needle_array['title']) AND $needle_array['title'] != '')
            $query.=" AND app.application_title LIKE '%" . str_replace("'", "", $db->Quote($needle_array['title'])) . "%'";
        if (isset($needle_array['name']) AND $needle_array['name'] != '')
            $query.=" AND LOWER(app.first_name) LIKE " . $db->Quote('%' . $needle_array['name'] . '%', false);
        if (isset($needle_array['nationality']) AND $needle_array['nationality'] != '')
            $query .= " AND app.nationality = " . $needle_array['nationality'];
        if (isset($needle_array['gender']) AND $needle_array['gender'] != '')
            $query .= " AND app.gender = " . $needle_array['gender'];
        if (isset($needle_array['jobtype']) AND $needle_array['jobtype'] != '')
            $query .= " AND app.jobtype = " . $needle_array['jobtype'];
        if (isset($needle_array['currency']) AND $needle_array['currency'] != '')
            $query .= " AND app.currencyid = " . $needle_array['currency'];
        if (isset($needle_array['jobsalaryrange']) AND $needle_array['jobsalaryrange'] != '')
            $query .= " AND app.jobsalaryrange = " . $needle_array['jobsalaryrange'];
        if (isset($needle_array['heighestfinisheducation']) AND $needle_array['heighestfinisheducation'] != '')
            $query .= " AND app.heighestfinisheducation = " . $needle_array['heighestfinisheducation'];
        if (isset($needle_array['iamavailable']) AND $needle_array['iamavailable'] != '') {
            $available = ($needle_array['iamavailable'] == "yes") ? 1 : 0;
            $query .= " AND app.iamavailable = " . $available;
        }
        if (isset($needle_array['jobcategory']) AND $needle_array['jobcategory'] != '')
            $query .= " AND app.job_category = " . $needle_array['jobcategory'];
        if (isset($needle_array['jobsubcategory']) AND $needle_array['jobsubcategory'] != '')
            $query .= " AND app.job_subcategory = " . $needle_array['jobsubcategory'];
        if (isset($needle_array['experience']) AND $needle_array['experience'] != '')
            $query .= " AND app.total_experience LIKE " . $db->Quote($needle_array['experience']);


        $db->setQuery($query);
        $total = $db->loadResult();
        if ($total <= $limitstart)
            $limitstart = 0;

        $query = "SELECT apply.comments,apply.id AS jobapplyid ,job.id,job.agefrom,job.ageto, cat.cat_title ,apply.apply_date, apply.resumeview, jobtype.title AS jobtypetitle,app.iamavailable
					, app.id AS appid, app.first_name, app.last_name, app.email_address, app.jobtype,app.gender
					, app.total_experience, app.jobsalaryrange
					, app.address_city, app.address_county, app.address_state ,app.id as resumeid
					, country.name AS countryname,state.name AS statename
					,city.name AS cityname
					, salary.rangestart, salary.rangeend,education.title AS educationtitle
					, currency.symbol AS symbol
					,dcurrency.symbol AS dsymbol ,dsalary.rangestart AS drangestart, salary.rangeend AS drangeend  
					,app.institute1_study_area AS education
					,app.photo AS photo,app.application_title AS applicationtitle
					FROM `#__js_job_jobs` AS job
					JOIN `#__js_job_jobtypes` AS jobtype ON job.jobtype = jobtype.id
					JOIN `#__js_job_categories` AS cat ON job.jobcategory = cat.id
					JOIN `#__js_job_jobapply` AS apply  ON apply.jobid = job.id 
					JOIN `#__js_job_resume` AS app ON apply.cvid = app.id 
					LEFT JOIN `#__js_job_heighesteducation` AS  education  ON app.heighestfinisheducation=education.id
					LEFT OUTER JOIN  `#__js_job_salaryrange` AS salary	ON	app.jobsalaryrange=salary.id
					LEFT OUTER JOIN  `#__js_job_salaryrange` AS dsalary ON app.desired_salary=dsalary.id 
					LEFT JOIN `#__js_job_cities` AS city ON app.address_city = city.id
					LEFT JOIN `#__js_job_countries` AS country ON city.countryid  = country.id
					LEFT JOIN `#__js_job_states` AS state ON city.stateid = state.id
					LEFT JOIN `#__js_job_currencies` AS currency ON currency.id = app.currencyid
					LEFT JOIN `#__js_job_currencies` AS dcurrency ON dcurrency.id = app.desired_salary 
					
			WHERE apply.jobid = " . $jobid;
        if ($tab_action)
            $query.=" AND apply.action_status=" . $tab_action;
        if (isset($needle_array['title']) AND $needle_array['title'] != '')
            $query.=" AND app.application_title LIKE '%" . str_replace("'", "", $db->Quote($needle_array['title'])) . "%'";
        if (isset($needle_array['name']) AND $needle_array['name'] != '')
            $query.=" AND LOWER(app.first_name) LIKE " . $db->Quote('%' . $needle_array['name'] . '%', false);
        if (isset($needle_array['nationality']) AND $needle_array['nationality'] != '')
            $query .= " AND app.nationality = " . $needle_array['nationality'];
        if (isset($needle_array['gender']) AND $needle_array['gender'] != '')
            $query .= " AND app.gender = " . $needle_array['gender'];
        if (isset($needle_array['jobtype']) AND $needle_array['jobtype'] != '')
            $query .= " AND app.jobtype = " . $needle_array['jobtype'];
        if (isset($needle_array['currency']) AND $needle_array['currency'] != '')
            $query .= " AND app.currencyid = " . $needle_array['currency'];
        if (isset($needle_array['jobsalaryrange']) AND $needle_array['jobsalaryrange'] != '')
            $query .= " AND app.jobsalaryrange = " . $needle_array['jobsalaryrange'];
        if (isset($needle_array['heighestfinisheducation']) AND $needle_array['heighestfinisheducation'] != '')
            $query .= " AND app.heighestfinisheducation = " . $needle_array['heighestfinisheducation'];
        if (isset($needle_array['iamavailable']) AND $needle_array['iamavailable'] != '') {
            $available = ($needle_array['iamavailable'] == "yes") ? 1 : 0;
            $query .= " AND app.iamavailable = " . $available;
        }
        if (isset($needle_array['jobcategory']) AND $needle_array['jobcategory'] != '')
            $query .= " AND app.job_category = " . $needle_array['jobcategory'];
        if (isset($needle_array['jobsubcategory']) AND $needle_array['jobsubcategory'] != '')
            $query .= " AND app.job_subcategory = " . $needle_array['jobsubcategory'];
        if (isset($needle_array['experience']) AND $needle_array['experience'] != '')
            $query .= " AND app.total_experience LIKE " . $db->Quote($needle_array['experience']);

        $query .= " ORDER BY apply.apply_date DESC";


        $db->setQuery($query, $limitstart, $limit);
        $this->_application = $db->loadObjectList();

        $result[0] = $this->_application;
        $result[1] = $total;
        return $result;
    }


}

?>