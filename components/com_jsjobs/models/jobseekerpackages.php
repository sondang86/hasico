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

class JSJobsModelJobSeekerPackages extends JSModel {

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

    function getJobSeekerPackageById($packageid) {
        if (is_numeric($packageid) == false)
            return false;

        $db = $this->getDBO();
        $query = "SELECT package.* ,cur.symbol
                    FROM `#__js_job_jobseekerpackages` AS package 
                    LEFT JOIN `#__js_job_currencies` AS cur ON cur.id=package.currencyid
                    WHERE package.id = " . $packageid;
        $db->setQuery($query);
        $package = $db->loadObject();
        return $package;
    }

    function getJobSeekerPackages($limit, $limitstart) {
        $db = $this->getDBO();
        $result = array();

        $query = "SELECT COUNT(id) FROM `#__js_job_jobseekerpackages` WHERE status = 1";
        $db->setQuery($query);
        $total = $db->loadResult();

        if ($total <= $limitstart)
            $limitstart = 0;

        $query = "SELECT package.* ,cur.symbol FROM `#__js_job_jobseekerpackages` AS package  LEFT JOIN `#__js_job_currencies` AS cur ON cur.id=package.currencyid WHERE package.status = 1";
        $db->setQuery($query, $limitstart, $limit);
        $packages = $db->loadObjectList();

        $result[0] = $packages;
        $result[1] = $total;

        return $result;
    }

}
?>
    
