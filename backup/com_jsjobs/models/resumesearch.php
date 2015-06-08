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

class JSJobsModelResumesearch extends JSModel {

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

    function deleteResumeSearch($searchid, $uid) {

        $db = $this->getDBO();
        $row = $this->getTable('resumesearch');
        if ((is_numeric($uid) == false) || ($uid == 0) || ($uid == ''))
            return false;
        if (is_numeric($searchid) == false)
            return false;

        $query = "SELECT COUNT(search.id) FROM `#__js_job_resumesearches` AS search  
					WHERE search.id = " . $searchid . " AND search.uid = " . $uid;
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

    function getResumeSearchebyId($id) {
        $db = $this->getDBO();
        if (is_numeric($id) == false)
            return false;
        $query = "SELECT search.* 
                    FROM `#__js_job_resumesearches` AS search
                    WHERE search.id  = " . $id;
        $db->setQuery($query);
        return $db->loadObject();
    }

    function storeResumeSearch($data) {
        global $resumedata;
        $row = $this->getTable('resumesearch');
        $data['date_start'] = date('Y-m-d H:i:s', strtotime($data['date_start']));
        if (!$row->bind($data)) {
            $this->setError($this->_db->getErrorMsg());
            return false;
        }
        $returnvalue = $this->canAddNewResumeSearch($data['uid']);

        if ($returnvalue == 0)
            return 3; //not allowed save new search
        if (!$row->store()) {
            $this->setError($this->_db->getErrorMsg());
            echo $this->_db->getErrorMsg();
            return false;
        }
        return true;
    }

    function canAddNewResumeSearch($uid) {
        if ((is_numeric($uid) == false) || ($uid == 0) || ($uid == ''))
            return false;
        if (!isset($this->_config)) {
            $this->_config = $this->getJSModel('configurations')->getConfig('');
        }
        foreach ($this->_config as $conf) {
            if ($conf->configname == 'newlisting_requiredpackage')
                $newlisting_required_package = $conf->configvalue;
        }

        if ($newlisting_required_package == 0) {
            return 1;
        } else {
            $db = $this->getDBO();
            $query = "SELECT COUNT(search.id) AS totalsearches, role.savesearchresume
			FROM `#__js_job_roles` AS role
			JOIN `#__js_job_userroles` AS userrole ON userrole.role = role.id
			LEFT JOIN `#__js_job_resumesearches` AS search ON userrole.uid = search.uid 
			WHERE userrole.uid = " . $uid . " GROUP BY role.savesearchresume ";

            $db->setQuery($query);
            $resume = $db->loadObject();
            if ($resume) {
                if ($resume->savesearchresume == -1)
                    return 1;
                else {
                    if ($resume->totalsearch < $resume->savesearchresume)
                        return 1;
                    else
                        return 0;
                }
            }
            return 0;
        }
    }

}
?>
    
