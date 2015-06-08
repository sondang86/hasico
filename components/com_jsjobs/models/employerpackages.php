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

class JSJobsModelEmployerPackages extends JSModel {

    var $_client_auth_key = null;
    var $_siteurl = null;

    function __construct() {
        parent :: __construct();
        $this->_client_auth_key = $this->getJSModel('common')->getClientAuthenticationKey();
        $this->_siteurl = JURI::root();
        $user = JFactory::getUser();
        $this->_uid = $user->id;
    }

    function getEmployerPackageInfoById($packageid) {
        if (is_numeric($packageid) == false)
            return false;
        $db = $this->getDBO();
        $query = "SELECT package.* FROM `#__js_job_employerpackages` AS package WHERE id = " . $packageid;

        $db->setQuery($query);
        $package = $db->loadObject();

        return $package;
    }

    function getEmployerPackages($limit, $limitstart) {
        $db = $this->getDBO();
        $result = array();

        $query = "SELECT COUNT(id) FROM `#__js_job_employerpackages` WHERE status = 1";
        $db->setQuery($query);
        $total = $db->loadResult();

        if ($total <= $limitstart)
            $limitstart = 0;

        $query = "SELECT package.*,cur.symbol
				FROM `#__js_job_employerpackages` AS package 
				LEFT JOIN `#__js_job_currencies` AS cur ON cur.id=package.currencyid
		WHERE package.status = 1";
        $db->setQuery($query, $limitstart, $limit);
        $packages = $db->loadObjectList();

        $result[0] = $packages;
        $result[1] = $total;

        return $result;
    }

    function getEmployerPackageById($packageid, $uid) {
        if (is_numeric($packageid) == false)
            return false;
        if ($uid)
            if ((is_numeric($uid) == false) || ($uid == 0) || ($uid == ''))
                return false;
        $db = $this->getDBO();
        $result = array();
        $query = "SELECT package.* ,cur.symbol
			FROM `#__js_job_employerpackages` AS package 
			LEFT JOIN `#__js_job_currencies` AS cur ON cur.id=package.currencyid
			WHERE package.id = " . $packageid;
        $db->setQuery($query);
        $package = $db->loadObject();
        $result[0] = $package;
        return $result;
    }

    function getAllPackagesByUid($uid, $job_id) {
        if (!is_numeric($uid))
            return false;
        $db = $this->getDbo();
        $query = "SELECT payment.id AS paymentid, payment.packagetitle AS packagetitle, package.id AS packageid, package.jobsallow, package.enforcestoppublishjob, package.enforcestoppublishjobvalue, package.enforcestoppublishjobtype
                        , (SELECT COUNT(id) FROM #__js_job_jobs WHERE packageid = package.id AND paymenthistoryid = payment.id AND uid = " . $uid . ") AS jobavail
                        FROM #__js_job_paymenthistory AS payment
                        JOIN #__js_job_employerpackages AS package ON (package.id = payment.packageid AND payment.packagefor=1)
                        WHERE uid = " . $uid . "
                        AND DATE_ADD(payment.created,INTERVAL package.packageexpireindays DAY) >= CURDATE()
                        AND payment.transactionverified = 1 AND payment.status = 1";

        $db->setQuery($query);
        $result = $db->loadObjectList();
        $count = count($result); //check packages more then once or not
        if (isset($job_id) && $job_id != '') {
            $query = "SELECT packageid,paymenthistoryid FROM `#__js_job_jobs` WHERE id = " . $job_id;
            $db->setQuery($query);
            $job = $db->loadObject();
        }
        if ($count > 1) {

            $packagecombo = '<select id="package" class="inputbox " name="package" onChange="Javascript: changeDate(this.value);">';
            $packagecombo .= "<option value=''>" . JText::_('JS_SELECT_PACKAGE') . "</option>";

            foreach ($result AS $package) {
                if ($package->jobsallow != -1)
                    $jobleft = ($package->jobsallow - $package->jobavail) . ' ' . JText::_('JS_JOBS_LEFT');
                else
                    $jobleft = JText::_('JS_UNLIMITED_JOBS');
                if ($package->enforcestoppublishjob == 1) {
                    switch ($package->enforcestoppublishjobtype) {
                        case 1:$timetype = JText::_('JS_DAYS');
                            break;
                        case 2:$timetype = JText::_('JS_WEEKS');
                            break;
                        case 3:$timetype = JText::_('JS_MONTHS');
                            break;
                    }
                    $jobduration = $package->enforcestoppublishjobvalue . ' ' . $timetype;
                } else {
                    $jobduration = JText::_('JS_MANAUL_SELECT');
                }
                $title = '"' . $package->packagetitle . '"  ' . $jobleft . ', ' . JText::_('JS_JOB_DURATION') . ' ' . $jobduration;
                if (isset($job) && $job->packageid == $package->packageid) {
                    $packagecombo .= "<option value='$package->packageid' selected=\"selected\">$title</option>";
                    $combobox[] = array('value' => $package->packageid, 'text' => $title);
                } else {
                    $packagecombo .= "<option value='$package->packageid'>$title</option>";
                    $combobox[] = array('value' => $package->packageid, 'text' => $title);
                }
                $packagedetail["$package->packageid"] = $package;
            }
            $packagecombo .= "</select>";
            if (isset($job_id) && $job_id != '') {
                $lists['packages'] = JHTML::_('select.genericList', $combobox, 'multipackage', 'class="inputbox "' . 'onChange="changeDate(this.value)"' . '', 'value', 'text', $job->packageid);
            } else {
                $lists['packages'] = JHTML::_('select.genericList', $combobox, 'multipackage', 'class="inputbox "' . 'onChange="changeDate(this.value)"' . '', 'value', 'text', '');
            }

            //$lists['packages'] = JHTML::_('select.genericList', $combobox, 'multipackage', 'class="inputbox validate-selectpackage"'. '', 'value', 'text','' );

            $return[0] = $packagecombo;
            //$return[0] = $lists;
            $return[1] = $packagedetail;
        } elseif ($count == 1)
            $return = false;
        elseif ($count == 0)
            $return = 2; //no package
        return $return;
    }

}
?>


