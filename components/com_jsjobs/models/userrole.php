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

class JSJobsModelUserRole extends JSModel {

    var $_uid = null;
    var $_client_auth_key = null;
    var $_siteurl = null;
    var $_config = null;

    function __construct() {
        parent :: __construct();
        $this->_config = $this->getJSModel('configurations')->getConfig('');
        $this->_client_auth_key = $this->getJSModel('common')->getClientAuthenticationKey();
        $this->_siteurl = JURI::root();
        $user = JFactory::getUser();
        $this->_uid = $user->id;
    }

    function getUserType($u_id) {
        $db = $this->getDBO();
        if (is_numeric($u_id) == false)
            return false;
        $query = "SELECT userrole.*, role.rolefor 
                    FROM `#__js_job_userroles` AS userrole
                    JOIN `#__js_job_roles` AS role ON userrole.role = role.id
                    WHERE  uid  = " . $u_id;
        $db->setQuery($query);
        $result[0] = $db->loadObject();

        $usertype = array(
            '0' => array('value' => 1, 'text' => JText::_('JS_EMPLOYER')),
            '1' => array('value' => 2, 'text' => JText::_('JS_JOB_SEEKER')),);

        if (isset($result[0]))
            $lists['usertype'] = JHTML::_('select.genericList', $usertype, 'usertype', 'class="inputbox" ' . '', 'value', 'text', $result[0]->rolefor);
        else
            $lists['usertype'] = JHTML::_('select.genericList', $usertype, 'usertype', 'class="inputbox" ' . '', 'value', 'text', 1);
        $result[1] = $lists;

        return $result;
    }

    function addUser($usertype, $uid) { // call from jsjobs_register plugin
        $db = JFactory::getDBO();
        $roleconfig = $this->getJSModel('configurations')->getConfigByFor('default');
        if ($this->getJSModel('employer')->userCanRegisterAsEmployer() != true)
            $usertype = 2; // enforce job seeker
        $created = date('Y-m-d H:i:s');
        $query = "INSERT INTO #__js_job_userroles (uid,role,dated) VALUES (" . $uid . ", " . $usertype . ", '" . $created . "')";
        $db->setQuery($query);
        $db->query();

        $result = $this->getJSModel('purchasehistory')->assignDefaultPackage($usertype, $uid);
        $result1 = $this->assignDefaultGroup($usertype, $uid);
    }

    function assignDefaultGroup($usertype, $uid) {
        if (is_numeric($uid) == false)
            return false;
        $db = $this->getDBO();
        if (!$this->_config)
            $this->_config = $this->getJSModel('configurations')->getConfig('');
        foreach ($this->_config as $conf) {
            if ($conf->configname == 'jobseeker_defaultgroup')
                $jobseeker_defaultgroup = $conf->configvalue;
            if ($conf->configname == 'employer_defaultgroup')
                $employer_defaultgroup = $conf->configvalue;
        }
        if ($usertype == 1) { //employer
            if ($employer_defaultgroup) {
                $alreadyassign = $this->getJSModel('common')->checkAssignGroup($uid, $employer_defaultgroup);
                if ($alreadyassign == false) {
                    $query = "INSERT INTO `#__user_usergroup_map` (user_id,group_id) VALUES (" . $uid . ", " . $employer_defaultgroup . ")";
                    $db->setQuery($query);
                    $db->query();
                }
            }
        } else { // job seeker
            if ($jobseeker_defaultgroup) {
                $alreadyassign = $this->getJSModel('common')->checkAssignGroup($uid, $jobseeker_defaultgroup);
                if ($alreadyassign == false) {
                    $query = "INSERT INTO `#__user_usergroup_map` (user_id,group_id) VALUES (" . $uid . ", " . $jobseeker_defaultgroup . ")";
                    $db->setQuery($query);
                    $db->query();
                }
            }
        }
        return true;
    }

    function storeNewinJSJobs() {
        global $resumedata;
        $row = $this->getTable('userrole');
        $data = JRequest :: get('post');
        $data['dated'] = date('Y-m-d H:i:s');
        $uid = $data['uid'];
        $usertype = $data['usertype'];
        if ($this->getJSModel('employer')->userCanRegisterAsEmployer() != true)
            $usertype = 2; // enforce job seeker

        if ($data['id'])
            return false; // can not edit
        $data['role'] = $usertype;
        if (!$row->bind($data)) {
            $this->setError($this->_db->getErrorMsg());
            echo $this->_db->getErrorMsg();
            return false;
        }
        if (!$row->check()) {
            $this->setError($this->_db->getErrorMsg());
            echo $this->_db->getErrorMsg();
            return 2;
        }
        if (!$row->store()) {

            $this->setError($this->_db->getErrorMsg());
            echo $this->_db->getErrorMsg();
            return false;
        }
        $result = $this->getJSModel('purchasehistory')->assignDefaultPackage($usertype, $uid);
        $result1 = $this->assignDefaultGroup($usertype, $uid);
        return true;
    }

    function getUserRole($u_id) {
        $false = false;
        $role = false;
        if ((is_numeric($u_id) == false) || ($u_id == 0) || ($u_id == ''))
            return $false;
        $db = $this->getDBO();
        if ($u_id != 0) {
            $query = "SELECT userrole.*, role.* 
					FROM `#__js_job_userroles` AS userrole
					JOIN  `#__js_job_roles` AS role ON	userrole.role = role.id
					WHERE userrole.uid  = " . $u_id;
            $db->setQuery($query);
            $role = $db->loadObject();
        }
        return $role;
    }
    
    function getUserRoleByUid($uid){
        $role = null;
        if ((is_numeric($uid) == false) || ($uid == 0) || ($uid == ''))
            return $role;
        $db = $this->getDbo();
        $query = "SELECT userroles.role
                    FROM `#__js_job_userroles` AS userroles
                    WHERE userroles.uid = ".$uid;
        $db->setQuery($query);
        $role = $db->loadResult();
        return $role;
    }

}
?>
    
