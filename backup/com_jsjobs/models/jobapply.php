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

class JSJobsModelJobApply extends JSModel {

    var $_uid = null;
    var $_client_auth_key = null;
    var $_siteurl = null;

    function __construct() {
        parent :: __construct();
        $this->_client_auth_key = $this->getJSModel('common')->getClientAuthenticationKey();
        $this->_siteurl = JURI::root();
        $user = JFactory::getUser();
        $this->_uid = $user->id;
    }
    
    function applyJob($jobid){
        if(!is_numeric($jobid)) return false;
        $validate = $this->getJSModel('permissions')->checkPermissionsFor('APPLY_JOB');
        if($validate == VALIDATE){
            $uid = JFactory::getUser()->id;
            $db = $this->getDbo();
            $query = "SELECT COUNT(id) FROM `#__js_job_resume` WHERE uid = ".$uid;
            $db->setQuery($query);
            $result = $db->loadResult();
            if($result > 0){
                $jobresult = $this->getJobbyIdforJobApply($jobid);
                $result = $this->getJSModel('resume')->getMyResumes($uid);
                $html = '
                        <div id="js_main_wrapper">
                        <span class="js_job_applynow_heading">'.JText::_('JS_APPLY_NOW').'</span>
                        <div class="js_job_form_field_wrapper">
                            <div class="js_job_form_feild_halfwidth">
                                <div class="js_job_form_field_title">
                                '.JText::_('JS_MY_RESUME').'
                                </div>
                                <div class="js_job_form_field_value">
                                '.$result[0].'
                                </div>
                            </div>
                            <div class="js_job_form_feild_halfwidth">
                                <div class="js_job_form_field_title">
                                '.JText::_('JS_MY_COVER_LETTER').'
                                </div>
                                <div class="js_job_form_field_value">
                                '.$result[2].'
                                </div>
                            </div>
                            <div class="js_job_form_button">
                                <input type="hidden" id="jobapply_jobid" class="jobid" value="'.$jobid.'" />
                                <input type="hidden" id="jobapply_uid" value="'.$uid.'" />
                                <input type="submit" class="js_job_form_button" id="js_job_applynow_button" value="'.JText::_('JS_APPLYNOW').'" />
                                <input type="submit" class="js_job_form_button" id="js_job_applynow_close" value="'.JText::_('JS_CLOSE').'" />
                            </div>
                        </div>
                        <span class="js_controlpanel_section_title">'.JText::_('JS_JOB_INFO').'</span>
                        <div class="js_job_data_wrapper">
                            <span class="js_job_data_title">'.JText::_('JS_TITLE').'</span>
                            <span class="js_job_data_value">'.$jobresult[0]->title.'</span>
                        </div>                            
                        <div class="js_job_data_wrapper">
                            <span class="js_job_data_title">'.JText::_('JS_COMPANY').'</span>
                            <span class="js_job_data_value">'.$jobresult[0]->companyname.'</span>
                        </div>                            
                        <div class="js_job_data_wrapper">
                            <span class="js_job_data_title">'.JText::_('JS_JOBSTATUS').'</span>
                            <span class="js_job_data_value">'.$jobresult[0]->jobstatustitle.'</span>
                        </div>                            
                        <div class="js_job_data_wrapper">
                            <span class="js_job_data_title">'.JText::_('JS_LOCATION').'</span>
                            <span class="js_job_data_value">'.$jobresult[0]->city.'</span>
                        </div>                            
                        <div class="js_job_data_wrapper">
                            <span class="js_job_data_title">'.JText::_('JS_POSTED').'</span>
                            <span class="js_job_data_value">'.date($this->getJSModel('configurations')->getConfigValue('date_format'),  strtotime($jobresult[0]->created)).'</span>
                        </div> 
                        </div>
                        <script type="text/javascript">
                            jQuery("input#js_job_applynow_button").click(function(e){
                                e.preventDefault();
                                var jobid = jQuery("input#jobapply_jobid").val();
                                var uid = jQuery("input#jobapply_uid").val();
                                var cvid = jQuery("select#cvid").val();
                                var coverletterid = jQuery("select#coverletterid").val();
                                jQuery.post("index.php?option=com_jsjobs&task=jobapply.jobapplyajax",{jobid:jobid,cvid:cvid,coverletterid:coverletterid,uid:uid},function(data){
                                   if(data){
                                       jQuery("div#js_jobapply_main_wrapper").html(data);
                                   } 
                                });
                            });
                            jQuery("input#js_job_applynow_close").click(function(e){
                                e.preventDefault();
                                jQuery("div#js_jobapply_main_wrapper").fadeOut();
                                jQuery("div#black_wrapper_jobapply").fadeOut();
                            });
                            jQuery(\'a[data-jobapply="jobapply"]\').click(function(e){
                               e.preventDefault();
                               var jobid = jQuery(this).attr("data-jobid");
                               jQuery.post("index.php?option=com_jsjobs&task=jobapply.applyjob",{jobid:jobid},function(data){
                                if(data){ // data come from the controller
                                     var response=jQuery.parseJSON(data);
                                     if(typeof response ==\'object\')
                                     {
                                       if(response[0] === \'popup\'){
                                         jQuery("div#js_jobapply_main_wrapper").html(response[1]);
                                         jQuery("div#black_wrapper_jobapply").fadeIn();
                                         jQuery("div#js_jobapply_main_wrapper").slideDown("slow");
                                       }else{
                                           window.location = response[1];
                                       }
                                     }
                                     else
                                     {
                                       if(response ===false)
                                       {
                                          //the response was a string "false", parseJSON will convert it to boolean false
                                       }
                                       else
                                       {
                                         //the response was something else
                                       }
                                     }                   
                                }
                               });
                            });
                        </script>
                        ';
                return $html;
            }else{
                $html = '
                            <div id="js_main_wrapper">
                                <span class="js_job_applynow_heading">'.JText::_('JS_APPLY_NOW').'</span>
                                <div class="js_job_error_messages_wrapper">
                                    <div class="js_job_messages_image_wrapper">
                                        <img class="js_job_messages_image" src="components/com_jsjobs/images/6.png"/>
                                    </div>
                                    <div class="js_job_messages_data_wrapper">
                                        <span class="js_job_messages_main_text">
                                            '.JText::_('JS_YOU_DONNOT_HAVE_ANY_RESUME').'
                                        </span>
                                        <span class="js_job_messages_block_text">
                                            '.JText::_('JS_YOU_DONNOT_HAVE_ANY_RESUME_PLEASE_ADD_RESUME_FIRST').'
                                        </span>
                                    </div>
                                </div>
                            </div>
                    ';
                return $html;
            }
        }else{
            switch($validate){
                case NO_PACKAGE:
                    $text1 = JText::_('JS_PACKAGE_NOT_PURCHASED');
                    $text2 = JText::_('JS_PACKAGE_IS_REQUIRED_TO_PERFORM_THIS_ACTION_PLEASE_PURCHASE_PACAKGE_FIRST');
                    $text2 .= '</span><div class="js_job_messages_button_wrapper"><a class="js_job_message_button" href="index.php?option=com_jsjobs&c=employerpackages&view=employerpackages&layout=packages&Itemid='.JRequest::getVar('Itemid').'" >'.JText::_('JS_PACKAGES').'</a></div>';
                    break;
                case EXPIRED_PACKAGE:
                    $text1 = JText::_('JS_YOUR_CURRENT_PACKAGE_EXPIRED');
                    $text2 = JText::_('JS_PACKAGE_IS_REQUIRED_TO_PERFORM_THIS_ACTION_AND_YOUR_CURRENT_PACKAGE_IS_EXPIRED_PLEASE_PURCHASE_NEW_PACKAGE');
                    $text2 .= '</span><div class="js_job_messages_button_wrapper"><a class="js_job_message_button" href="index.php?option=com_jsjobs&c=employerpackages&view=employerpackages&layout=packages&Itemid='.JRequest::getVar('Itemid').'" >'.JText::_('JS_PACKAGES').'</a></div>';
                    break;
                case JOB_APPLY_LIMIT_EXCEEDS:
                    $text1 = JText::_('JS_JOB_APPLY_LIMIT_EXCEEDS');
                    $text2 = JText::_('JS_JOB_APPLY_LIMIT_EXCEEDS_YOU_CANNOT_APPLY_TO_JOB');
                    $text2 .= '</span><div class="js_job_messages_button_wrapper"><a class="js_job_message_button" href="index.php?option=com_jsjobs&c=employerpackages&view=employerpackages&layout=packages&Itemid='.JRequest::getVar('Itemid').'" >'.JText::_('JS_PACKAGES').'</a></div>';
                    break;
                case VISITOR_NOT_ALLOWED_JOBSEEKER_PRIVATE_AREA:
                    $text1 = JText::_('JS_VISITOR_NOT_ALLOWED_TO_APPLY_JOB');
                    $text2 = JText::_('JS_VISITOR_NOT_ALLOWED_TO_APPLY_ANY_JOB').'
                        </span><div class="js_job_messages_button_wrapper"><a class="js_job_message_button" href="index.php?option=com_users&view=login" >'.JText::_('JS_LOGIN').'</a>
                        <a class="js_job_message_button" href="index.php?option=com_jsjobs&c=common&view=common&layout=userregister&userrole=1&Itemid='.JRequest::getVar('Itemid').'" >'.JText::_('JS_REGISTER').'</a>
                            </div>';
                    break;
                case EMPLOYER_NOT_ALLOWED_JOBSEEKER_PRIVATE_AREA:
                    $text1 = JText::_('JS_EMPLOYER_NOT_ALLOWED');
                    $text2 = JText::_('JS_EMPLOYER_NOT_ALLOWED_JOBSEEKER_PRIVATE_AREA');
                    break;
            }
            $html = '
                        <div id="js_main_wrapper">
                            <span class="js_job_applynow_heading">'.JText::_('JS_APPLY_NOW').'</span>
                            <div class="js_job_error_messages_wrapper">
                                <div class="js_job_messages_image_wrapper">
                                    <img class="js_job_messages_image" src="components/com_jsjobs/images/2.png"/>
                                </div>
                                <div class="js_job_messages_data_wrapper">
                                    <span class="js_job_messages_main_text">
                                        '.$text1.'
                                    </span>
                                    <span class="js_job_messages_block_text">
                                        '.$text2.'
                                </div>
                            </div>
                        </div>
                ';
            return $html;
        }
    }

    function getJobAppliedResume($needle_array, $u_id, $jobid, $tab_action, $sortby, $limit, $limitstart) {
        $db = $this->getDBO();
        if (is_numeric($u_id) == false)
            return false;
        if (is_numeric($jobid) == false)
            return false;
        $result = array();
        if ($this->_client_auth_key != "") {
            $fortask = "getjobappliedresume";
            $jsjobsharingobject = $this->getJSModel('jobsharingsite');
            $data['uid'] = $u_id;
            $data['jobid'] = $jobid;
            $data['sortby'] = $sortby;
            $data['limitstart'] = $limitstart;
            $data['limit'] = $limit;
            $data['authkey'] = $this->_client_auth_key;
            $data['siteurl'] = $this->_siteurl;
            $data['tab_action'] = $tab_action;
            if (!empty($needle_array)) {
                $needle_array = json_decode($needle_array, true);
                $data['tab_action'] = "";
            }
            $server_needle_query = "";
            if (isset($needle_array['title']) AND $needle_array['title'] != '')
                $server_needle_query.=" AND job_resume.application_title LIKE '%" . str_replace("'", "", $db->Quote($needle_array['title'])) . "%'";
            if (isset($needle_array['name']) AND $needle_array['name'] != '')
                $server_needle_query.=" AND LOWER(job_resume.first_name) LIKE " . $db->Quote('%' . $needle_array['name'] . '%', false);
            if (isset($needle_array['nationality']) AND $needle_array['nationality'] != '')
                $server_needle_query .= " AND job_resume.nationality = " . $needle_array['nationality'];
            if (isset($needle_array['gender']) AND $needle_array['gender'] != '')
                $server_needle_query .= " AND job_resume.gender = " . $needle_array['gender'];
            if (isset($needle_array['jobtype']) AND $needle_array['jobtype'] != '') {
                $server_jobtype_id = $this->getJSModel('common')->getServerid('jobtypes', $needle_array['jobtype']);
                $server_needle_query .= " AND job_resume.jobtype = " . $server_jobtype_id;
            }
            if (isset($needle_array['currency']) AND $needle_array['currency'] != '') {
                $server_currency_id = $this->getJSModel('common')->getServerid('currencies', $needle_array['currency']);
                $server_needle_query .= " AND job_resume.currencyid = " . $server_currency_id;
            }
            if (isset($needle_array['jobsalaryrange']) AND $needle_array['jobsalaryrange'] != '') {
                $server_jobsalaryrange = $this->getJSModel('common')->getServerid('salaryrange', $needle_array['jobsalaryrange']);
                $server_needle_query .= " AND job_resume.jobsalaryrange = " . $server_jobsalaryrange;
            }
            if (isset($needle_array['heighestfinisheducation']) AND $needle_array['heighestfinisheducation'] != '') {
                $server_heighestfinisheducation = $this->getJSModel('common')->getServerid('heighesteducation', $needle_array['heighestfinisheducation']);
                $server_needle_query .= " AND job_resume.heighestfinisheducation = " . $server_heighestfinisheducation;
            }
            if (isset($needle_array['iamavailable']) AND $needle_array['iamavailable'] != '') {
                $available = ($needle_array['iamavailable'] == "yes") ? 1 : 0;
                $server_needle_query .= " AND job_resume.iamavailable = " . $available;
            }
            if (isset($needle_array['jobcategory']) AND $needle_array['jobcategory'] != '') {
                $server_jobcategory = $this->getJSModel('common')->getServerid('categories', $needle_array['jobcategory']);
                $server_needle_query .= " AND job_resume.job_category = " . $server_jobcategory;
            }
            if (isset($needle_array['jobsubcategory']) AND $needle_array['jobsubcategory'] != '') {
                $server_jobsubcategory = $this->getJSModel('common')->getServerid('subcategories', $needle_array['jobsubcategory']);
                $server_needle_query .= " AND job_resume.job_subcategory = " . $server_jobsubcategory;
            }
            if (isset($needle_array['experience']) AND $needle_array['experience'] != '') {
                $server_needle_query .= " AND job_resume.total_experience LIKE " . $db->Quote($needle_array['experience']);
            }
            if (!empty($server_needle_query)) {
                $data['server_needle_query'] = $server_needle_query;
            }
            $encodedata = json_encode($data);
            $return_server_value = $jsjobsharingobject->serverTask($encodedata, $fortask);
            if (isset($return_server_value['jobappliedresume']) AND $return_server_value['jobappliedresume'] == -1) { // auth fail 
                $logarray['uid'] = $this->_uid;
                $logarray['referenceid'] = $return_server_value['referenceid'];
                $logarray['eventtype'] = $return_server_value['eventtype'];
                $logarray['message'] = $return_server_value['message'];
                $logarray['event'] = "Job Applied Resume";
                $logarray['messagetype'] = "Error";
                $logarray['datetime'] = date('Y-m-d H:i:s');
                $jsjobsharingobject->write_JobSharingLog($logarray);
                $this->_applications = array();
                $total = 0;
                $jobtitle = "";
            } else {
                $parse_data = array();
                foreach ($return_server_value['relationjsondata'] AS $rel_data) {
                    $parse_data[] = (object) $rel_data;
                }
                $this->_applications = $parse_data;
                $total = $return_server_value['total'];
                $jobtitle = $return_server_value['jobtitle'];
            }
        } else {
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
                        ,city.name AS cityname,job.hits AS jobview
                        ,(SELECT COUNT(id) FROM `#__js_job_jobapply` WHERE jobid = job.id) AS totalapply
                        , salary.rangestart, salary.rangeend,education.title AS educationtitle
                        , currency.symbol AS symbol
                        ,dcurrency.symbol AS dsymbol ,dsalary.rangestart AS drangestart, dsalary.rangeend AS drangeend  
                        ,app.institute1_study_area AS education
                        ,app.photo AS photo,app.application_title AS applicationtitle
                        ,CONCAT(app.alias,'-',app.id) resumealiasid, CONCAT(job.alias,'-',job.id) AS jobaliasid
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
                        LEFT JOIN `#__js_job_currencies` AS dcurrency ON dcurrency.id = app.dcurrencyid 
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

            $query.=" ORDER BY  " . $sortby;
            $db->setQuery($query, $limitstart, $limit);
            $this->_applications = $db->loadObjectList();
            $query = "SELECT title FROM `#__js_job_jobs` WHERE id = " . $jobid;
            $db->setQuery($query);
            $jobtitle = $db->loadResult();
        }

        $result[0] = $this->_applications;
        $result[1] = $total;
        $result[2] = $jobtitle;

        return $result;
    }

    function getJobbyIdforJobApply($job_id) {
        $db = $this->getDBO();
        if (is_numeric($job_id) == false)
            return false;
        if ($this->_client_auth_key != "") {

            $fortask = "getjobapplybyidforjobapply";
            $jsjobsharingobject = $this->getJSModel('jobsharingsite');
            $data['jobid'] = $job_id;
            $data['authkey'] = $this->_client_auth_key;
            $data['siteurl'] = $this->_siteurl;
            $encodedata = json_encode($data);
            $return_server_value = $jsjobsharingobject->serverTask($encodedata, $fortask);
            if (isset($return_server_value['jobapplybyid']) AND $return_server_value['jobapplybyid'] == -1) { // auth fail 
                $logarray['uid'] = $this->_uid;
                $logarray['referenceid'] = $return_server_value['referenceid'];
                $logarray['eventtype'] = $return_server_value['eventtype'];
                $logarray['message'] = $return_server_value['message'];
                $logarray['event'] = "Job Apply By Id";
                $logarray['messagetype'] = "Error";
                $logarray['datetime'] = date('Y-m-d H:i:s');
                $jsjobsharingobject->write_JobSharingLog($logarray);
                $this->_application = array();
            } else {
                $this->_application = (object) $return_server_value['relationjsondata'];
            }
        } else {
            $query = "SELECT job.*, cat.cat_title , company.name as companyname, company.url
                        , jobtype.title AS jobtypetitle
                        , jobstatus.title AS jobstatustitle, shift.title as shifttitle
                        , salary.rangestart, salary.rangeend, education.title AS heighesteducationtitle
                        ,CONCAT(company.alias,'-',company.id) AS companyaliasid
                        FROM `#__js_job_jobs` AS job
                        JOIN `#__js_job_categories` AS cat ON job.jobcategory = cat.id
                        JOIN `#__js_job_companies` AS company ON job.companyid = company.id
                        JOIN `#__js_job_jobtypes` AS jobtype ON job.jobtype = jobtype.id
                        LEFT JOIN `#__js_job_jobstatus` AS jobstatus ON job.jobstatus = jobstatus.id
                        LEFT JOIN `#__js_job_salaryrange` AS salary ON job.jobsalaryrange = salary.id
                        LEFT JOIN `#__js_job_heighesteducation` AS education ON job.heighestfinisheducation = education.id
                        LEFT JOIN `#__js_job_shifts` AS shift ON job.shift = shift.id
                        WHERE  job.id = " . $job_id;
            $db->setQuery($query);
            $this->_application = $db->loadObject();
            $this->_application->multicity = $this->getJSModel('employer')->getMultiCityDataForView($job_id, 1);
        }

        $result[0] = $this->_application;
        $result[1] = $this->getJSModel('configurations')->getConfigByFor('listjob'); // company fields

        return $result;
    }

    function getMyAppliedJobs($u_id, $sortby, $limit, $limitstart) {
        $db = $this->getDBO();
        if ($u_id)
            if ((is_numeric($u_id) == false) || ($u_id == 0) || ($u_id == ''))
                return false;
        $result = array();
        $listjobconfig = $this->getJSModel('configurations')->getConfigByFor('listjob');

        if ($this->_client_auth_key != "") {
            $fortask = "myappliedjobs";
            $jsjobsharingobject = $this->getJSModel('jobsharingsite');
            $data['uid'] = $u_id;
            $data['sortby'] = $sortby;
            $data['limitstart'] = $limitstart;
            $data['limit'] = $limit;
            $data['authkey'] = $this->_client_auth_key;
            $data['siteurl'] = $this->_siteurl;
            $encodedata = json_encode($data);
            $return_server_value = $jsjobsharingobject->serverTask($encodedata, $fortask);
            if (isset($return_server_value['getmyappliedjobs']) AND $return_server_value['getmyappliedjobs'] == -1) { // auth fail 
                $logarray['uid'] = $this->_uid;
                $logarray['referenceid'] = $return_server_value['referenceid'];
                $logarray['eventtype'] = $return_server_value['eventtype'];
                $logarray['message'] = $return_server_value['message'];
                $logarray['event'] = "Applied Jobs";
                $logarray['messagetype'] = "Error";
                $logarray['datetime'] = date('Y-m-d H:i:s');
                $jsjobsharingobject->write_JobSharingLog($logarray);
                $this->_applications = array();
                $total = 0;
            } else {
                $parse_data = array();
                if (is_array($return_server_value))
                    foreach ($return_server_value['relationjsondata'] AS $rel_data) {
                        $parse_data[] = (object) $rel_data;
                    }
                $this->_applications = $parse_data;
                $total = $return_server_value['total'];
            }
        } else {
            $query = "SELECT COUNT(job.id) FROM `#__js_job_jobs` AS job, `#__js_job_jobapply` AS apply  
			WHERE apply.jobid = job.id AND apply.uid = " . $u_id;
            $db->setQuery($query);
            $total = $db->loadResult();
            if ($total <= $limitstart)
                $limitstart = 0;

            $query = "SELECT job.*, cat.cat_title, apply.apply_date, jobtype.title AS jobtypetitle, jobstatus.title AS jobstatustitle
                        , salaryfrom.rangestart,salaryto.rangeend, salaryto.rangeend AS salaryto,company.logofilename as companylogo
                        ,company.id AS companyid, company.name AS companyname, company.url,salarytype.title AS salaytype
                        ,CONCAT(job.alias,'-',job.id) AS jobaliasid
                        ,CONCAT(company.alias,'-',companyid) AS companyaliasid
                        ,cur.symbol,apply.action_status AS resumestatus
                        FROM `#__js_job_jobs` AS job
                        JOIN `#__js_job_categories` AS cat ON job.jobcategory = cat.id 
                        JOIN `#__js_job_jobapply` AS apply ON apply.jobid = job.id 
                        JOIN `#__js_job_jobtypes` AS jobtype ON job.jobtype = jobtype.id 
                        LEFT JOIN `#__js_job_jobstatus` AS jobstatus ON job.jobstatus = jobstatus.id 
                        LEFT JOIN `#__js_job_companies` AS company ON job.companyid = company.id 
                        LEFT JOIN `#__js_job_salaryrange` AS salaryfrom ON job.salaryrangefrom = salaryfrom.id
                        LEFT JOIN `#__js_job_salaryrange` AS salaryto ON job.salaryrangeto = salaryto.id
                        LEFT JOIN `#__js_job_salaryrangetypes` AS salarytype ON job.salaryrangetype = salarytype.id
                        LEFT JOIN `#__js_job_currencies` AS cur ON cur.id = job.currencyid
                        WHERE apply.uid = " . $u_id . " ORDER BY  " . $sortby;

            $db->setQuery($query, $limitstart, $limit);
            $this->_applications = $db->loadObjectList();
            foreach ($this->_applications AS $jobdata) {   // for multicity select 
                $multicitydata = $this->getJSModel('job')->getMultiCityData($jobdata->id);
                if ($multicitydata != "")
                    $jobdata->city = $multicitydata;
            }
        }

        $result[0] = $this->_applications;
        $result[1] = $total;
        $result[2] = $listjobconfig;

        return $result;
    }

    function jobapply() {
        $row = $this->getTable('jobapply');
        $data = JRequest :: get('post');
        $data['apply_date'] = date('Y-m-d H:i:s');
        $db = JFactory::getDBO();
        if ($this->_client_auth_key != "") {
            $query = "SELECT id FROM #__js_job_jobs WHERE serverid = " . $data['jobid'];
            $db->setQuery($query);
            $result = $db->loadResult();
            if ($result){ //localy store
                    $localjobid=$result;// result as local job id
                    $data['jobid']=$localjobid;
                    $val_return=(int) $this->validateJobApply($data,$localjobid);
                    if($val_return==3) return 3;

                    // new function store data with row object 
                    $row=$this->storeRowObject($data,$row,$localjobid);
                    if($row==false) return false;

                    // local jobapply id 
                    $data['jobapply_id'] = $row->id;
            } 
			// send to server 
            $job_log_object = $this->getJSModel('log');
            $jsjobsharingobject = $this->getJSModel('jobsharingsite');
            $query = "select resume.serverid AS resumeserverid 
                            From `#__js_job_resume` AS resume
                            WHERE resume.id=" . $data['cvid'];
            //echo 'query'.$query;
            $db->setQuery($query);
            $resume_serverid = $db->loadResult();
            if ($resume_serverid) $data['cvid'] = $resume_serverid;
            else $data['cvid'] = 0;
            if(isset($localjobid) && $localjobid!=''){
                $query = "select job.serverid AS jobserverid 
                                From `#__js_job_jobs` AS job
                                WHERE job.id=" . $localjobid;
                //echo 'query'.$query;
                $db->setQuery($query);
                $job_serverid = $db->loadResult();
                if ($job_serverid) $data['jobid'] = $job_serverid;
            }
            if ($data['coverletterid'] != "" AND $data['coverletterid'] != 0) {
                $query = "select coverletter.serverid AS coverletterserverid  From `#__js_job_coverletters` AS coverletter WHERE coverletter.id=" . $data['coverletterid'];
                $db->setQuery($query);
                $coverletter_serverid = $db->loadResult();
                if ($coverletter_serverid) $data['coverletterid'] = $coverletter_serverid;
                else $data['coverletterid'] = 0;
            }else $data['coverletterid'] = 0;
            $data['isownjob'] = (isset($localjobid))?1:0;
            $data['task'] = ($data['isownjob']==1)?'storeownjobapply':'storeserverjobapply';
            $data['jobapply_id'] = isset($data['jobapply_id'])?$data['jobapply_id']:0;
            // store on server direct 
            $data['authkey'] = $this->_client_auth_key;
            $data['task'] = 'storeownjobapply';
            $return_value = $jsjobsharingobject->store_JobapplySharing($data);
            $job_log_object->log_Store_JobapplySharing($return_value);
        } else {
            $val_return = (int) $this->validateJobApply($data, $data['jobid']);
            if ($val_return == 3)
                return 3;
            $row = $this->storeRowObject($data, $row, $data['jobid']);
            if ($row == false)
                return false;
        }
        return true;
    }

    function validateJobApply(&$data, $localjobid) {
        $db = $this->getDbo();
        $query = "SELECT job.raf_gender AS filter_gender,
							job.raf_education AS filter_education,	
							job.raf_category AS filter_category,job.raf_subcategory AS filter_subcategory,
							job.raf_location AS filter_location	
							FROM #__js_job_jobs AS job 
				WHERE job.id = " . $localjobid;
        $db->setQuery($query);
        $apply_filter_values = $db->loadObject();
        $data['action_status'] = 1;
        if ($apply_filter_values) {
            $jobquery = "SELECT job.gender,job.educationid,job.jobcategory,job.subcategoryid,job.city
					FROM #__js_job_jobs AS job 
					WHERE job.id = " . $localjobid;
            $db->setQuery($jobquery);
            $job = $db->loadObject();

            $resumequery = "SELECT resume.gender,resume.heighestfinisheducation,resume.job_category,resume.job_subcategory,resume.address_city
					FROM #__js_job_resume AS resume
					WHERE resume.id = " . $data['cvid'];
            $db->setQuery($resumequery);
            $resume = $db->loadObject();
            if ($apply_filter_values->filter_gender == 1) {
                if ($job->gender == $resume->gender)
                    $data['action_status'] = 1;
                else
                    $data['action_status'] = 2;
            }
            if ($data['action_status'] != 2) {
                if ($apply_filter_values->filter_education == 1) {
                    if ($job->educationid == $resume->heighestfinisheducation)
                        $data['action_status'] = 1;
                    else
                        $data['action_status'] = 2;
                }
            }
            if ($data['action_status'] != 2) {
                if ($apply_filter_values->filter_category == 1) {
                    if ($job->jobcategory == $resume->job_category)
                        $data['action_status'] = 1;
                    else
                        $data['action_status'] = 2;
                }
            }
            if ($data['action_status'] != 2) {
                if ($apply_filter_values->filter_subcategory == 1) {
                    if ($job->subcategoryid == $resume->job_subcategory)
                        $data['action_status'] = 1;
                    else
                        $data['action_status'] = 2;
                }
            }
            if ($data['action_status'] != 2) {
                if ($apply_filter_values->filter_location == 1) {
                    $joblocation = explode(',', $job->city);
                    if (in_array($resume->address_city, $joblocation)) {
                        $data['action_status'] = 1;
                    }
                    else
                        $data['action_status'] = 2;
                }
            }
        }
        $result = $this->jobApplyValidation($data['uid'], $localjobid);
        if ($result == true) {
            return 3;
        }
        return true;
    }

    function canApplyJob($uid) {
        if (!is_numeric($uid))
            return false;
        $db = $this->getDbo();
        $query = "SELECT package.applyjobs "
                . "FROM `#__js_job_paymenthistory` AS paymenthistory "
                . "JOIN `#__js_job_jobseekerpackages` AS package ON package.id = paymenthistory.packageid "
                . "WHERE paymenthistory.uid = " . $uid . " AND paymenthistory.transactionverified = 1 
                    AND DATE_ADD(paymenthistory.created,INTERVAL package.packageexpireindays DAY) >= CURDATE()";
        $db->setQuery($query);
        $result = $db->loadObjectList();
        if(empty($result)){
            $query = "SELECT package.applyjobs "
                    . "FROM `#__js_job_paymenthistory` AS paymenthistory "
                    . "JOIN `#__js_job_jobseekerpackages` AS package ON package.id = paymenthistory.packageid "
                    . "WHERE paymenthistory.uid = " . $uid . " AND paymenthistory.transactionverified = 1 ";
            $db->setQuery($query);
            $result = $db->loadObjectList();
            if(empty($result)){ // User have no package
                return NO_PACKAGE;
            }else{ // User have packages but are expired
                return EXPIRED_PACKAGE;
            }
        }else{
            $countapplyjob = 0;
            foreach ($result AS $package) {
                if ($package->applyjobs == '-1') {
                    return VALIDATE;
                } else {
                    $countapplyjob += $package->applyjobs;
                }
            }
            $query = "SELECT COUNT(id) FROM `#__js_job_jobapply` WHERE uid = " . $uid;
            $db->setQuery($query);
            $totalappliedjob = $db->loadResult();
            if ($countapplyjob > $totalappliedjob)
                return VALIDATE;
            else
                return JOB_APPLY_LIMIT_EXCEEDS;
        }
    }


    function jobApplyValidation($u_id, $jobid) {
        if ((is_numeric($u_id) == false) || ($u_id == 0) || ($u_id == ''))
            return false;
        if (is_numeric($jobid) == false)
            return false;
        $db = JFactory::getDBO();

        $query = "SELECT COUNT(id) FROM `#__js_job_jobapply` 
		WHERE uid = " . $u_id . " AND jobid = " . $jobid;
        //echo '<br>sql '.$query;
        $db->setQuery($query);
        $result = $db->loadResult();
        //echo '<br>r'.$result;
        if ($result == 0)
            return false;
        else
            return true;
    }


    function getJobsAppliedResume($u_id, $sortby, $limit, $limitstart) {
        $db = $this->getDBO();
        if ($u_id)
            if ((is_numeric($u_id) == false) || ($u_id == 0) || ($u_id == ''))
                return false;
        $result = array();
        if ($this->_client_auth_key != "") {
            $fortask = "alljobsappliedapplications";
            $jsjobsharingobject = $this->getJSModel('jobsharingsite');
            $data['uid'] = $u_id;
            $data['sortby'] = $sortby;
            $data['limitstart'] = $limitstart;
            $data['limit'] = $limit;
            $data['authkey'] = $this->_client_auth_key;
            $data['siteurl'] = $this->_siteurl;
            $encodedata = json_encode($data);
            $return_server_value = $jsjobsharingobject->serverTask($encodedata, $fortask);
            if (isset($return_server_value['alljobsappliedresume']) AND $return_server_value['alljobsappliedresume'] == -1) { // auth fail 
                $logarray['uid'] = $this->_uid;
                $logarray['referenceid'] = $return_server_value['referenceid'];
                $logarray['eventtype'] = $return_server_value['eventtype'];
                $logarray['message'] = $return_server_value['message'];
                $logarray['event'] = "All Applied Resume on Jobs";
                $logarray['messagetype'] = "Error";
                $logarray['datetime'] = date('Y-m-d H:i:s');
                $jsjobsharingobject->write_JobSharingLog($logarray);
                $this->_applications = array();
                $total = 0;
            } else {
                $parse_data = array();
                foreach ($return_server_value['relationjsondata'] AS $rel_data) {
                    $parse_data[] = (object) $rel_data;
                }
                $this->_applications = $parse_data;
                $total = $return_server_value['total'];
            }
        } else {
            $query = "SELECT COUNT(job.id)
			FROM `#__js_job_jobs` AS job, `#__js_job_categories` AS cat 
			WHERE job.jobcategory = cat.id AND job.uid= " . $u_id;
            $db->setQuery($query);
            $total = $db->loadResult();

            //$limit = $limit ? $limit : 5;
            if ($total <= $limitstart)
                $limitstart = 0;

            $query = "SELECT DISTINCT job.*, cat.cat_title , company.name ,jobtype.title AS jobtypetitle, jobstatus.title AS jobstatustitle
					, (SELECT COUNT(apply.id) FROM `#__js_job_jobapply` AS apply WHERE apply.jobid = job.id ) as appinjob
					,CONCAT(job.alias,'-',job.id) AS jobaliasid,company.id AS companid,company.logo AS companylogo
					FROM `#__js_job_jobs` AS job
					JOIN `#__js_job_categories` AS cat ON job.jobcategory = cat.id
					JOIN `#__js_job_jobtypes` AS jobtype ON job.jobtype = jobtype.id
					LEFT JOIN `#__js_job_jobstatus` AS jobstatus ON job.jobstatus = jobstatus.id
					JOIN `#__js_job_companies` AS company ON job.companyid = company.id
				WHERE job.uid= " . $u_id . " ORDER BY  " . $sortby;
            $db->setQuery($query, $limitstart, $limit);
            $this->_applications = $db->loadObjectList();
        }


        $result[0] = $this->_applications;
        $result[1] = $total;

        return $result;
    }

    function storeRowObject($data, $row, $localjobid = false) {
        if (!$row->bind($data)) {
            $this->setError($this->_db->getErrorMsg());
            return false;
        }

        if (!$row->check()) {
            $this->setError($this->_db->getErrorMsg());
            return false;
        }

        if (!$row->store()) {
            $this->setError($this->_db->getErrorMsg());
            return false;
        }
        if ($localjobid != false) {
            if ($data['action_status'] == 1)
                $emailrerurn = $this->getJSModel('emailtemplate')->sendMail($localjobid, $data['uid'], $data['cvid']);

            $configmail = $this->getJSModel('configurations')->getConfigByFor('email');
            if ($configmail['email_admin_job_apply'] == 1)
                $emailrerurn = $this->getJSModel('adminemail')->sendMailtoAdmin($localjobid, $data['uid'], 4);
        }

        return $row;
    }

    function getMailForm($uid, $email, $jobapplyid) {
        if ((is_numeric($uid) == false) || ($uid == 0) || ($uid == ''))
            return false;
        $jobseeker_email = $email;
        $return_value = "<div  id='resumeactioncandidate'>\n";
        $return_value.= "<table id='resumeactioncandidatetable' cellpadding='0' cellspacing='0' border='0' width='100%'>\n";
        $return_value .= "<tr >\n";
        $return_value .= "<td width='20%' valign='top' ><b>" . JText::_('JS_JOBSEEKER') . ":</b></td>\n";
        $return_value .= "<td width='50%' align='left'>\n";
        $return_value .= "<input name='jsmailaddress' id='jsmailaddress' value='$jobseeker_email' readonly='readonly'/>\n";
        $return_value .= "</td>\n";
        $return_value .= "</tr>\n";
        $return_value .= "<tr >\n";
        $return_value .= "<td width='20%' valign='top' ><b>" . JText::_('JS_SUBJECT_LINE') . ":</b></td>\n";
        $return_value .= "<td width='50%' align='left'>\n";
        $return_value .= "<input type='text' name='jssubject' id='jssubject'/>\n";
        $return_value .= "</td>\n";
        $return_value .= "<tr >\n";
        $return_value .= "<td width='20%' valign='top' ><b>" . JText::_('JS_EMAIL_SENDER') . ":</b></td>\n";
        $return_value .= "<td width='50%' align='left'>\n";
        $return_value .= "<input name='emmailaddress' id='emmailaddress' class='email validate'/>\n";
        $return_value .= "</td>\n";
        $return_value .= "</tr>\n";
        $return_value .= "</table>\n";
        $return_value .= "</div>\n";
        $return_value .= "<div id='resumeactioncandidatecomments'>\n";
        $return_value.= "<table id='resumeactioncandidatecommentstable' cellpadding='0' cellspacing='0' border='0' width='100%'>\n";
        $return_value .= "<tr >\n";
        $return_value .= "<td width='335' align='center'>\n";
        $return_value .= "<textarea name='candidatemessage' id='candidatemessage' rows='5' cols='38'></textarea>\n";
        $return_value .= "</td>\n";
        $return_value .= "<td align='left' ><input type='button' class='button' onclick='sendmailtocandidate(" . $jobapplyid . ")' value='" . JText::_('JS_SEND') . "'> </td>\n";
        $return_value .= "</tr>\n";
        $return_value .= "</table>\n";
        $return_value .= "</table>\n";

        $return_value .= "</div>\n";

        return $return_value;
    }


}
?>
    
