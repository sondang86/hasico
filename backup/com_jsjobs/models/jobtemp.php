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

class JSJobsModelJobTemp extends JSModel {

    var $_uid = null;
    var $_client_auth_key = null;
    var $_siteurl = null;

    function __construct() {
        parent :: __construct();
        $this->_client_auth_key = $this->getJSModel('common')->getClientAuthenticationKey();
        $user = JFactory::getUser();
        $this->_uid = $user->id;
    }

    function updateJobTemp() {
        $db = $this->getDBO();
        $session = JFactory::getSession();
        $JConfig = new JConfig();
        $db_prefix = $JConfig->dbprefix;
        $update_request = "UPDATE #__js_job_jobs_temp_time as time1 ,(select max(id) AS id from #__js_job_jobs_temp_time ) time2 set is_request =is_request+1  where time1.id = time2.id";
        $db->setQuery($update_request);
        $db->query();
        $query1 = "SELECT jobtemptime.* FROM `#__js_job_jobs_temp_time` AS jobtemptime";
        $db->setQuery($query1);
        $time_data1 = $db->loadObject();
        if ($time_data1->is_request > 1) {
            return true;
        }

        $temp_job = $this->getTable('jobtemp');
        $fortask = "insertnewestjobsfromserver";
        $jsjobsharingobject = $this->getJSModel('jobsharingsite');
        $data['limitstart'] = 0;
        $data['limit'] = 100;
        $data['authkey'] = $this->_client_auth_key;
        $data['siteurl'] = $this->_siteurl;
        $encodedata = json_encode($data);
        $return_server_value = $jsjobsharingobject->serverTask($encodedata, $fortask);
        if ((is_array($return_server_value)) AND (!empty($return_server_value))) {
            if (isset($return_server_value['isjobinsert']) AND $return_server_value['isjobinsert'] == -1) { // auth fail 
                $logarray['uid'] = $this->_uid;
                $logarray['referenceid'] = $return_server_value['referenceid'];
                $logarray['eventtype'] = $return_server_value['eventtype'];
                $logarray['message'] = $return_server_value['message'];
                $logarray['event'] = "get newest jobs";
                $logarray['messagetype'] = "Error";
                $logarray['datetime'] = date('Y-m-d H:i:s');
                $jsjobsharingobject->write_JobSharingLog($logarray);
                $this->_applications = array();
                $total = 0;
                $update_request1 = "UPDATE #__js_job_jobs_temp_time as time1 ,(select max(id) AS id from #__js_job_jobs_temp_time ) time2 set is_request =0  where time1.id = time2.id";
                $db->setQuery($update_request1);
                $db->query();
            } else {
                $session->set('totalserverjobs', $return_server_value['total']);
                $job_temp_in_use = 0;
                $open_table_query = 'SHOW OPEN TABLES WHERE In_use > 0';
                $db->setQuery($open_table_query);
                $open_tble_data = $db->loadObjectList();
                if (!empty($open_tble_data)) {
                    foreach ($open_tble_data AS $table) {
                        if (($table->Table == $db_prefix . "js_job_jobs_temp") AND ($table->In_use > 0)) {
                            $job_temp_in_use = 1;
                            break;
                        }
                    }
                }
                if ($job_temp_in_use == 1) {
                    $i = 2;
                    while ($i <= 10) {
                        sleep($i);
                        $open_table_query1 = 'SHOW OPEN TABLES WHERE In_use = 0';
                        $db->setQuery($open_table_query1);
                        $open_tble_data1 = $db->loadObjectList();
                        if (!empty($open_tble_data1)) {
                            foreach ($open_tble_data1 AS $table1) {
                                if (($table1->Table == $db_prefix . "js_job_jobs_temp") AND ($table1->In_use = 0)) {
                                    $job_temp_in_use = 2;
                                    break;
                                }
                            }
                        }
                        $i = $i + 2;
                    }
                }
                $lockquery = 'LOCK TABLES ' . $db_prefix . 'js_job_jobs_temp WRITE';
                $db->setQuery($lockquery);
                $db->query();

                $query = "DELETE FROM `#__js_job_jobs_temp`";
                $db->setQuery($query);
                $db->query();
                foreach ($return_server_value['newestjobsforinsert'] AS $sjobs) {
                    $sjobs['localid'] = '';
                    if (!$temp_job->bind($sjobs)) {
                        $this->setError($this->_db->getErrorMsg());
                    }
                    if (!$temp_job->check()) {
                        $this->setError($this->_db->getErrorMsg());
                    }
                    if (!$temp_job->store()) {
                        $this->setError($this->_db->getErrorMsg());
                    }
                }
                $unlickquery = 'UNLOCK TABLES';
                $db->setQuery($unlickquery);
                $db->query();
                $lastcalltime1 = date("Y-m-d H:i:s");
                $expiretime1 = date("Y-m-d H:i:s", strtotime("+5 min"));
                $temp_time = "DELETE FROM `#__js_job_jobs_temp_time`";
                $db->setQuery($temp_time);
                $db->query();
                $insert_time_query1 = "INSERT INTO `#__js_job_jobs_temp_time` (lastcalltime,expiretime,is_request)
						VALUES(" . $db->quote($lastcalltime1) . "," . $db->quote($expiretime1) . ",0)";
                $db->setQuery($insert_time_query1);
                $db->query();
                $update_request1 = "UPDATE #__js_job_jobs_temp_time as time1 ,(select max(id) AS id from #__js_job_jobs_temp_time ) time2 set is_request =0  where time1.id = time2.id";
                $db->setQuery($update_request1);
                $db->query();
            }
        }
    }

}

?>
