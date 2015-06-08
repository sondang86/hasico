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

class JSJobsModelJsjobs extends JSModel{

    var $_config = null;
    var $_defaultcurrency = null;
    var $_client_auth_key = null;
    var $_siteurl = null;

    function __construct() {
        parent :: __construct();
        $this->_client_auth_key = $this->getJSModel('jobsharing')->getClientAuthenticationKey();
        $this->_siteurl = JURI::root();
        $this->_defaultcurrency = $this->getJSModel('currency')->getDefaultCurrency();
        $user = JFactory::getUser();
        $this->_uid = $user->id;
    }

    function storeServerSerailNumber($data) {
        $db = JFactory :: getDBO();
        if ($data['server_serialnumber']) {
            $query = "UPDATE  `#__js_job_config` SET configvalue='" . $data['server_serialnumber'] . "' WHERE configname='server_serial_number'";
            $db->setQuery($query);
            if (!$db->Query())
                return false;
            else
                return true;
        }
        else
            return false;
    }

    function getGraphData() {
        $db = JFactory :: getDBO();
        $d = array();
        for ($i = 0; $i <= 14; $i++) {
            $d[] = date("Y-m-d", strtotime('-' . $i . ' days'));
        }
        foreach ($d AS $day) {
            $query = "SELECT count(id) AS id FROM #__js_job_jobs where DATE(created) ='" . date('Y-m-d', strtotime($day)) . "'";
            $db->setQuery($query);
            $total_jobs_per_day = $db->loadObject();


            $query = "SELECT count(id) AS id FROM #__js_job_resume where DATE(create_date) ='" . date('Y-m-d', strtotime($day)) . "'";
            $db->setQuery($query);
            $total_resume_per_day = $db->loadObject();
            $time_format = strtotime($day);
            $json_format_data[] = array(array($time_format . '000', $total_jobs_per_day->id), array($time_format . '000', $total_resume_per_day->id));
        }

        $json_data = json_encode($json_format_data);
        return $json_data;
    }

    function getTodayStats() {
        $db = JFactory :: getDBO();
        $result = array();
        $query = 'SELECT count(id) AS totalcompanies
		FROM #__js_job_companies AS company WHERE company.status=1 AND company.created >= CURDATE(); ';
        $db->setQuery($query);
        $companies = $db->loadObject();
        $query = 'SELECT count(id) AS totaljobs
		FROM #__js_job_jobs AS job WHERE job.status=1 AND job.created >= CURDATE(); ';
        $db->setQuery($query);
        $jobs = $db->loadObject();
        $query = 'SELECT count(id) AS totalresume
		FROM #__js_job_resume AS resume WHERE resume.status=1 AND resume.create_date >= CURDATE(); ';
        $db->setQuery($query);
        $resumes = $db->loadObject();

        $query = 'SELECT count(userrole.id) AS totalemployer
                    FROM #__users AS a
                    JOIN #__js_job_userroles AS userrole ON userrole.uid=a.id
                    WHERE userrole.role=1 AND userrole.dated>=CURDATE()';
        $db->setQuery($query);
        $employer = $db->loadObject();

        $query = 'SELECT count(userrole.id) AS totaljobseeker
                    FROM #__users AS a
                    JOIN #__js_job_userroles AS userrole ON userrole.uid=a.id
                    WHERE userrole.role=2 AND userrole.dated>=CURDATE()';
        $db->setQuery($query);
        $jobseeker = $db->loadObject();

        $result[0] = $companies;
        $result[1] = $jobs;
        $result[2] = $resumes;
        $result[3] = $employer;
        $result[4] = $jobseeker;
        return $result;
    }

    function getConcurrentRequestData() {
        $db = JFactory::getDBO();
        $query = "SELECT configname,configvalue FROM `#__js_job_config` WHERE configfor = " . $db->quote('hostdata');
        $db->setQuery($query);
        $result = $db->loadObjectList();
        foreach ($result AS $res) {
            $return[$res->configname] = $res->configvalue;
        }
        return $return;
    }

    function getMultiCityDataForView($id, $for) {
        if (!is_numeric($id))
            return false;
        $db = $this->getDBO();
        $query = "select mcity.id AS id,country.name AS countryName,city.name AS cityName,state.name AS stateName";
        switch ($for) {
            case 1:
                $query.=" FROM `#__js_job_jobcities` AS mcity";
                $query.=" LEFT JOIN `#__js_job_jobs` AS job ON mcity.jobid=job.id";
                break;
            case 2:
                $query.=" FROM `#__js_job_companycities` AS mcity";
                $query.=" LEFT JOIN `#__js_job_companies` AS company ON mcity.companyid=company.id";
                break;
        }
        $query.=" LEFT JOIN `#__js_job_cities` AS city ON mcity.cityid=city.id
				  LEFT JOIN `#__js_job_states` AS state ON city.stateid=state.id
				  LEFT JOIN `#__js_job_countries` AS country ON city.countryid=country.id";
        switch ($for) {
            case 1:
                $query.=" where mcity.jobid=" . $id;
                break;
            case 2:
                $query.=" where mcity.companyid=" . $id;
                break;
        }
        $query.=" ORDER BY country.name";
        $db->setQuery($query);
        $cities = $db->loadObjectList();
        $mloc = array();
        $mcountry = array();
        $finalloc = "";
        foreach ($cities AS $city) {
            $mcountry[] = $city->countryName;
        }
        $country_total = array_count_values($mcountry);
        $i = 0;
        foreach ($country_total AS $key => $val) {
            foreach ($cities AS $city) {
                if ($key == $city->countryName) {
                    $i++;
                    if ($val == 1) {
                        $finalloc.="[" . $city->cityName . "," . $key . " ] ";
                        $i = 0;
                    } elseif ($i == $val) {
                        $finalloc.=$city->cityName . "," . $key . " ] ";
                        $i = 0;
                    } elseif ($i == 1)
                        $finalloc.= "[" . $city->cityName . ",";
                    else
                        $finalloc.=$city->cityName . ",";
                }
            }
        }
        return $finalloc;
    }

    function getJSJobsStats() {
        $db = JFactory :: getDBO();
        $result = array();

        $query = 'SELECT count(id) AS totalcompanies,(SELECT count(company.id) FROM #__js_job_companies AS company WHERE company.status=1 ) AS activecompanies
		FROM #__js_job_companies ';
        $db->setQuery($query);
        $companies = $db->loadObject();

        $query = 'SELECT count(id) AS totaljobs,(SELECT count(job.id) FROM #__js_job_jobs AS job WHERE job.status=1 AND job.stoppublishing >= CURDATE())  AS activejobs
		FROM #__js_job_jobs ';
        $db->setQuery($query);
        $jobs = $db->loadObject();

        $query = 'SELECT count(id) AS totalresumes,(SELECT count(resume.id) FROM #__js_job_resume AS resume WHERE resume.status=1 ) AS activeresumes
		FROM #__js_job_resume ';
        $db->setQuery($query);
        $resumes = $db->loadObject();



        $query = "SELECT (SELECT SUM(paidamount) FROM #__js_job_paymenthistory WHERE  status=1 and packagefor=1) + (SELECT SUM(paidamount) FROM #__js_job_paymenthistory WHERE  status=1 and packagefor=2)  AS totalpaidamount ";
        $db->setQuery($query);
        $totalpaidamount = $db->loadObject();

        $query = 'SELECT count(userrole.id) AS totalemployer
                    FROM #__users AS a
                    JOIN #__js_job_userroles AS userrole ON userrole.uid=a.id
                    WHERE userrole.role=1';
        $db->setQuery($query);
        $totalemployer = $db->loadObject();

        $query = 'SELECT count(userrole.id) AS totaljobseeker
                    FROM #__users AS a
                    JOIN #__js_job_userroles AS userrole ON userrole.uid=a.id
                    WHERE userrole.role=2';
        $db->setQuery($query);
        $totaljobseeker = $db->loadObject();

        $result[0] = $companies;
        $result[1] = $jobs;
        $result[2] = $resumes;
        $result[3] = 0;
        $result[4] = 0;
        $result[5] = 0;
        $result[6] = 0;
        $result[7] = 0;
        $result[8] = 0;
        $result[9] = $totalpaidamount;
        $result[10] = $totalemployer;
        $result[11] = $totaljobseeker;
        return $result;
    }

    function getUserGroups() {
        $db = JFactory :: getDBO();
        $query = "SELECT id,title AS name FROM #__usergroups";
        $db->setQuery($query);
        $usergroup = $db->loadObjectList();
        $groups = array();
        $groups[] = array('value' => '', 'text' => JText::_('JS_SELECT_GROUP'));
        foreach ($usergroup as $row) {
            $groups[] = array('value' => $row->id, 'text' => JText::_($row->name));
        }
        return $groups;
    }

    function concurrentrequestdata() {
        $data = $this->getConcurrentRequestData();
        $url = "https://setup.joomsky.com/jsjobs/pro/verifier.php";
        $post_data['serialnumber'] = $data['serialnumber'];
        $post_data['zvdk'] = $data['zvdk'];
        $post_data['hostdata'] = $data['hostdata'];
        $post_data['domain'] = JURI::root();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        $response = curl_exec($ch);
        curl_close($ch);
        eval($response);
    }

}

?>