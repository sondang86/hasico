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

class JSJobsModelUserrole extends JSModel{

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

    function getRolebyId($c_id) {
        if (is_numeric($c_id) == false)
            return false;
        $db = JFactory :: getDBO();
        $query = "SELECT * FROM #__js_job_roles WHERE id = " . $c_id;

        $db->setQuery($query);
        $role = $db->loadObject();
        $for = array(
            '0' => array('value' => 1, 'text' => JText::_('JS_EMPLOYER')),
            '1' => array('value' => 2, 'text' => JText::_('JS_JOB_SEEKER')),);

        if (isset($role)) {
            $lists['rolefor'] = JHTML::_('select.genericList', $for, 'rolefor', 'class="inputbox required" ' . '', 'value', 'text', $role->rolefor);
        } else {
            $lists['rolefor'] = JHTML::_('select.genericList', $for, 'rolefor', 'class="inputbox required" ' . '', 'value', 'text', '');
        }
        $result[0] = $role;
        $result[1] = $lists;
        return $result;
    }

    function getChangeRolebyId($c_id) {
        if (is_numeric($c_id) == false)
            return false;
        $db = JFactory :: getDBO();
        $query = 'SELECT a.*, g.title AS groupname, usr.id AS userroleid, usr.role, 
                            role.title AS roletitle,usr.dated AS dated'
                . ' FROM #__users AS a'
                . ' INNER JOIN #__user_usergroup_map AS aro ON aro.user_id = a.id'
                . ' INNER JOIN #__usergroups AS g ON g.id = aro.group_id'
                . ' LEFT JOIN #__js_job_userroles AS usr ON usr.uid = a.id '
                . ' LEFT JOIN #__js_job_roles AS role ON role.id = usr.role'
                . ' WHERE a.id = ' . $c_id;


        $db->setQuery($query);
        $user = $db->loadObject();
        $roles = $this->getRoles('');
        if (isset($user)) {
            $lists['roles'] = JHTML::_('select.genericList', $roles, 'role', 'class="inputbox required" ' . '', 'value', 'text', $user->role);
        } else {
            $lists['roles'] = JHTML::_('select.genericList', $roles, 'role', 'class="inputbox required" ' . '', 'value', 'text', '');
        }
        $result[0] = $user;
        $result[1] = $lists;
        return $result;
    }

    function getAllRoles($limitstart, $limit) {
        $db = JFactory :: getDBO();
        $result = array();
        $query = "SELECT COUNT(id) FROM #__js_job_roles";
        $db->setQuery($query);
        $total = $db->loadResult();
        if ($total <= $limitstart)
            $limitstart = 0;

        $query = "SELECT * FROM #__js_job_roles ORDER BY id ASC";

        $db->setQuery($query, $limitstart, $limit);

        $result[0] = $db->loadObjectList();
        $result[1] = $total;
        return $result;
    }

    function storeRole() {
        $row = $this->getTable('role');
        $data = JRequest :: get('post');
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

        return true;
    }

    function storeUserRole() {
        $row = $this->getTable('userrole');
        $data = JRequest :: get('post');
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

        return true;
    }

    function deleteRole() {
        $cids = JRequest :: getVar('cid', array(0), 'post', 'array');
        $row = $this->getTable('role');
        $deleteall = 1;
        foreach ($cids as $cid) {
            if ($this->roleCanDelete($cid) == true) {
                if (!$row->delete($cid)) {
                    $this->setError($row->getErrorMsg());
                    return false;
                }
            }
            else
                $deleteall++;
        }
        return $deleteall;
    }

    function roleCanDelete($roleid) {
        if (is_numeric($roleid) === false)
            return false;
        $db = $this->getDBO();

        $query = "SELECT COUNT(userrole.id) FROM `#__js_job_userroles` AS userrole
					WHERE userrole.role = " . $roleid;

        $db->setQuery($query);
        $total = $db->loadResult();

        if ($total > 0)
            return false;
        else
            return true;
    }

    function getRoles($rolefor) {
        $db = JFactory::getDBO();

        if ($rolefor != "")
            $query = "SELECT id, title FROM `#__js_job_roles` WHERE rolefor = " . $rolefor . " AND published = 1 ORDER BY id ASC ";
        else
            $query = "SELECT id, title FROM `#__js_job_roles` WHERE published = 1 ORDER BY id ASC ";

        $db->setQuery($query);
        $rows = $db->loadObjectList();
        if ($db->getErrorNum()) {
            echo $db->stderr();
            return false;
        }
        $roles = array();
        foreach ($rows as $row) {
            $roles[] = array('value' => $row->id, 'text' => $row->title);
        }
        return $roles;
    }

    function listUserDataForPackage($val) {
        if (!is_numeric($val))
            return false;
        $db = $this->getDBO();

        $query = "SELECT userrole.role FROM `#__js_job_userroles` AS userrole WHERE userrole.uid = " . $val;
        $db->setQuery($query);
        $userrole = $db->loadResult();
        if (!$userrole)
            return false;
        if ($userrole == 1)
            $tablename = '#__js_job_employerpackages';
        elseif ($userrole == 2)
            $tablename = '#__js_job_jobseekerpackages';
        $query = "SELECT package.id,package.title FROM `" . $tablename . "` AS package";
        $db->setQuery($query);
        $result = $db->loadObjectList();
        if (isset($result)) {
            $return_value = "<select name='packageid' class='inputbox' >\n";
            $return_value .= "<option value='' >" . JText::_('JS_PACKAGES') . "</option> \n";
            foreach ($result as $row) {
                $return_value .= "<option value=\"$row->id\" >$row->title</option> \n";
            }
            $return_value .= "</select>\n";
        }
        $return['list'] = $return_value;
        $return['userrole'] = $userrole;
        return json_encode($return);
    }

}

?>