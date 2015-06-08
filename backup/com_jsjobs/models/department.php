
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
 * File Name:	models/departments.php
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

class JSJobsModelDepartment extends JSModel {

    var $_client_auth_key = null;
    var $_siteurl = null;

    function __construct() {
        parent :: __construct();
        $this->_client_auth_key = $this->getJSModel('common')->getClientAuthenticationKey();
        $this->_siteurl = JURI::root();
        $user = JFactory::getUser();
        $this->_uid = $user->id;
    }

    function listDepartments($val) {
        $db = $this->getDBO();
        if (is_numeric($val) == false)
            return false;
        $query = "SELECT id, name FROM `#__js_job_departments`  WHERE status = 1 AND companyid = " . $val . "
				ORDER BY name ASC";
        $db->setQuery($query);
        $result = $db->loadObjectList();

        if (isset($result)) {
            $return_value = "<select name='departmentid' class='inputbox jsjobs-cbo' >\n";

            foreach ($result as $row) {
                $return_value .= "<option value=\"$row->id\" >$row->name</option> \n";
            }
            $return_value .= "</select>\n";
        }

        return $return_value;
    }

    function getMyDepartments($u_id, $limit, $limitstart) {
        $result = array();
        $db = $this->getDBO();

        if (is_numeric($u_id) == false)
            return false;
        if (($u_id == 0) || ($u_id == ''))
            return false;
        $query = "SELECT count(department.id) 
                        FROM `#__js_job_departments` AS department
                        JOIN `#__js_job_companies` AS company ON company.id = department.companyid
                        WHERE department.uid = " . $u_id;
        $db->setQuery($query);
        $total = $db->loadResult();
        if ($total <= $limitstart)
            $limitstart = 0;

        $query = "SELECT department.*, company.name as companyname
                ,CONCAT(department.alias,'-',department.id) AS aliasid
            FROM `#__js_job_departments` AS department 
            JOIN `#__js_job_companies` AS company ON company.id = department.companyid
            WHERE department.uid = " . $u_id;
        $db->setQuery($query, $limitstart, $limit);
        $result[0] = $db->loadObjectList();
        $result[1] = $total;

        return $result;
    }

    function getDepartmentbyId($departmentid) {
        $db = $this->getDBO();
        if (is_numeric($departmentid) == false)
            return false;
        $query = "SELECT department.*,company.name as companyname 
                ,CONCAT(company.alias,'-',company.id) AS companyaliasid
                ,CONCAT(company.alias,'-',company.serverid) AS scompanyaliasid
        FROM `#__js_job_departments` AS department
        JOIN `#__js_job_companies` AS company ON company.id = department.companyid
        WHERE  department.id = " . $departmentid;
        $db->setQuery($query);
        $department = $db->loadObject();


        return $department;
    }

    function getDepartmentByIdForForm($departmentid, $uid) {
        $db = $this->getDBO();
        if (is_numeric($uid) == false)
            return false;
        if (($departmentid != '') && ($departmentid != 0)) {
            if (is_numeric($departmentid) == false)
                return false;
            $query = "SELECT department.*
            FROM `#__js_job_departments` AS department 
            WHERE department.id = " . $departmentid;

            $db->setQuery($query);
            $department = $db->loadObject();
        }
        $companies = $this->getJSModel('company')->getCompanies($uid);

        if (isset($department)) {
            $lists['companies'] = JHTML::_('select.genericList', $companies, 'companyid', 'class="inputbox required" ' . '', 'value', 'text', $department->companyid);
        } else {
            $lists['companies'] = JHTML::_('select.genericList', $companies, 'companyid', 'class="inputbox required" ' . '', 'value', 'text', '');
        }
        if (isset($department))
            $result[0] = $department;
        $result[1] = $lists;

        return $result;
    }

    function storeDepartment() {
        global $resumedata;
        $row = $this->getTable('department');
        $data = JRequest :: get('post');

        if (!empty($data['alias']))
            $departmentalias = $this->getJSModel('common')->removeSpecialCharacter($data['alias']);
        else
            $departmentalias = $this->getJSModel('common')->removeSpecialCharacter($data['name']);

        $departmentalias = strtolower(str_replace(' ', '-', $departmentalias));
        $data['alias'] = $departmentalias;

        if ($data['id'] == '') { // only for new 
            $config = $this->getJSModel('configurations')->getConfigByFor('department');
            $data['status'] = $config['department_auto_approve'];
        }
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
            echo $this->_db->getErrorMsg();
            return false;
        }
        if ($data['id'] == ''){
            $this->getJSModel('adminemail')->sendMailtoAdmin($row->id, $data['uid'], 5); //only for new
        }
        if ($this->_client_auth_key != "") {
            $db = $this->getDBO();
            $query = "SELECT department.* FROM `#__js_job_departments` AS department  
                        WHERE department.id = " . $row->id;
            //echo '<br> SQL '.$query;
            $db->setQuery($query);
            $data_department = $db->loadObject();
            if ($data['id'] != "" AND $data['id'] != 0)
                $data_department->id = $data['id']; // for edit case
            else
                $data_department->id = '';
            $data_department->department_id = $row->id;
            $data_department->authkey = $this->_client_auth_key;
            $data_department->task = 'storedepartment';
            $jsjobsharingobject = $this->getJSModel('jobsharingsite');
            $return_value = $jsjobsharingobject->store_DepartmentSharing($data_department);
            $job_log_object = $this->getJSModel('log');
            $job_log_object->log_Store_DepartmentSharing($return_value);
        }
        return true;
    }

    function deleteDepartment($departmentid, $uid) {
        $db = $this->getDBO();
        $row = $this->getTable('department');
        $data = JRequest :: get('post');
        if ((is_numeric($uid) == false) || ($uid == 0) || ($uid == ''))
            return false;
        if (is_numeric($departmentid) == false)
            return false;
        $serverdepartmentid = 0;
        if ($this->_client_auth_key != "") {
            $query = "SELECT dep.serverid AS id FROM `#__js_job_departments` AS dep  
                        WHERE dep.id = " . $departmentid;
            $db->setQuery($query);
            $s_dep_id = $db->loadResult();
            $serverdepartmentid = $s_dep_id;
        }
        $returnvalue = $this->departmentCanDelete($departmentid, $uid);
        if ($returnvalue == 1) {
            if (!$row->delete($departmentid)) {
                $this->setError($row->getErrorMsg());
                return false;
            }
            if ($serverdepartmentid != 0) {
                $data = array();
                $data['id'] = $serverdepartmentid;
                $data['referenceid'] = $departmentid;
                $data['uid'] = $this->_uid;
                $data['authkey'] = $this->_client_auth_key;
                $data['siteurl'] = $this->_siteurl;
                $data['task'] = 'deletedepartment';
                $jsjobsharingobject = $this->getJSModel('jobsharingsite');
                $return_value = $jsjobsharingobject->delete_DepartmentSharing($data);
                $job_log_object = $this->getJSModel('log');
                $job_log_object->log_Delete_DepartmentSharing($return_value);
            }
        } else
            return $returnvalue; // department can not delete   

        return true;
    }

    function getDepartmentsByCompanyId($companyid, $title) {
        if (!is_numeric($companyid))
            return false;
        $db = JFactory::getDBO();
        $departments = array();
        if ($companyid) {
            $query = "SELECT id, name FROM `#__js_job_departments` WHERE status = 1 AND companyid = " . $companyid;
            if ($this->_client_auth_key != "")
                $query.=" AND serverstatus='ok'";
            $query.=" ORDER BY name ASC ";
            $db->setQuery($query);
            $rows = $db->loadObjectList();
            if ($db->getErrorNum()) {
                echo $db->stderr();
                return false;
            }

            if ($title)
                $departments[] = array('value' => JText::_(''), 'text' => $title);
            foreach ($rows as $row) {
                $departments[] = array('value' => $row->id, 'text' => JText::_($row->name));
            }
        }
        return $departments;
    }

    function departmentCanDelete($departmentid, $uid) {
        if ((is_numeric($uid) == false) || ($uid == 0) || ($uid == ''))
            return false;
        $db = $this->getDBO();
        $result = array();

        $query = "SELECT COUNT(department.id) FROM `#__js_job_departments` AS department  
                    WHERE department.id = " . $departmentid . " AND department.uid = " . $uid;
        //echo '<br> SQL '.$query;
        $db->setQuery($query);
        $comtotal = $db->loadResult();

        if ($comtotal > 0) { // this department is same user
            $query = "SELECT COUNT(job.id) FROM `#__js_job_jobs` AS job  
                        WHERE job.departmentid = " . $departmentid;
            //echo '<br> SQL '.$query;
            $db->setQuery($query);
            $total = $db->loadResult();

            if ($total > 0)
                return 2;
            else
                return 1;
        } else
            return 3; //    this department is not of this user     
    }

}
?>
    


