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

class JSJobsModelPackageHistory extends JSModel {

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

    function storeJobSeekerPackageHistory($referenceid, $autoassign, $data) {
        global $resumedata;
        $row = $this->getTable('jobseekerpaymenthistory');
        if ($autoassign == 0)
            $data = JRequest :: get('post'); // get data from form

        if (is_numeric($data['packageid']) == false)
            return false;
        if (is_numeric($data['uid']) == false)
            return false;
        $db = $this->getDBO();
        $result = array();
        $query = "SELECT package.* FROM `#__js_job_jobseekerpackages` AS package WHERE id = " . $data['packageid'];
        $db->setQuery($query);
        $package = $db->loadObject();
        if (isset($package)) {
            $packageconfig = $this->getJSModel('configurations')->getConfigByFor('package');
            $row->uid = $data['uid'];
            $row->packageid = $package->id;
            $row->packagetitle = $package->title;
            $row->packageprice = $package->price;
            $paidamount = $package->price;
            $discountamount = 0;

            if ($package->price != 0) {
                $curdate = date('Y-m-d H:i:s');
                if (($package->discountstartdate <= $curdate) && ($package->discountenddate >= $curdate)) {
                    if ($package->discounttype == 1) { //%
                        $discountamount = ($package->price * $package->discount) / 100;
                        $paidamount = $package->price - $discountamount;
                    } else { // amount
                        $discountamount = $package->discount;
                        $paidamount = $package->price - $package->discount;
                    }
                }
                $row->transactionverified = 0;
                $row->transactionautoverified = 0;
                $row->status = 1;
            } else {
                if ($packageconfig['onlyonce_jobseeker_getfreepackage'] == '1') { // can't get free package more then once
                    $query = "SELECT COUNT(package.id) FROM `#__js_job_jobseekerpackages` AS package
                                    JOIN `#__js_job_jobseekerpaymenthistory` AS payment ON payment.packageid = package.id
                                    WHERE package.price = 0 AND payment.uid = " . $data['uid'];
                    $db->setQuery($query);
                    $freepackage = $db->loadResult();
                    if ($freepackage > 0)
                        return 5; // can't get free package more then once
                }
                $row->transactionverified = 1;
                $row->transactionautoverified = 1;
                $row->status = $packageconfig['jobseeker_freepackage_autoapprove'];
            }
            $row->discountamount = $discountamount;
            $row->paidamount = $paidamount;

            $row->discountmessage = $package->discountmessage;
            $row->packagestartdate = $package->discountstartdate;
            $row->packageenddate = $package->discountenddate;
            $row->resumeallow = $package->resumeallow;
            $row->coverlettersallow = $package->coverlettersallow;
            $row->applyjobs = $package->applyjobs;
            $row->jobsearch = $package->jobsearch;
            $row->savejobsearch = $package->savejobsearch;
            $row->video = $package->video;
            $row->packageexpireindays = $package->packageexpireindays;
            $row->packageshortdetails = $package->shortdetails;
            $row->packagedescription = $package->description;
            $row->created = date('Y-m-d H:i:s');
            $row->referenceid = $referenceid;
        }else {
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
        $this->getJSModel('adminemail')->sendMailtoAdmin($row->id, $data['uid'], 7);
        return true;
    }

    function getJobSeekerPackageInfoById($packageid) {
        if (is_numeric($packageid) == false)
            return false;
        $db = $this->getDBO();


        $query = "SELECT package.* FROM `#__js_job_jobseekerpackages` AS package WHERE id = " . $packageid;
        $db->setQuery($query);
        $package = $db->loadObject();

        return $package;
    }

    function storePackageHistory($autoassign, $data) {
        $row = $this->getTable('paymenthistory');

        if ($autoassign == 0)
            $data = JRequest :: get('post'); // get data from form

        if (is_numeric($data['packageid']) == false)
            return false;
        if (is_numeric($data['uid']) == false)
            return false;
        $db = $this->getDBO();
        $result = array();

        if ($data['packagefor'] == 1)
            $query = "SELECT package.* FROM `#__js_job_employerpackages` AS package WHERE id = " . $data['packageid'];
        elseif ($data['packagefor'] == 2)
            $query = "SELECT package.* FROM `#__js_job_jobseekerpackages` AS package WHERE id = " . $data['packageid'];
        $db->setQuery($query);
        $package = $db->loadObject();
        if (isset($package)) {
            $packageconfig = $this->getJSModel('configurations')->getConfigByFor('package');
            $row->uid = $data['uid'];
            $row->packageid = $data['packageid'];

            $row->packagetitle = $package->title;
            $row->packageprice = $package->price;
            $paidamount = $package->price;
            $discountamount = 0;
            $currency = "SELECT currency.id FROM `#__js_job_currencies` AS currency WHERE `default` = 1 AND status=1 ";
            $db->setQuery($currency);
            $c_id = $db->loadResult();
            $row->currencyid = $c_id;
            $row->packagefor = $data['packagefor'];
            if ($package->price != 0) {
                $curdate = date('Y-m-d H:i:s');
                if (($package->discountstartdate <= $curdate) && ($package->discountenddate >= $curdate)) {
                    if ($package->discounttype == 2) { //%
                        $discountamount = ($package->price * $package->discount) / 100;
                        $paidamount = $package->price - $discountamount;
                    } else { // amount
                        $discountamount = $package->discount;
                        $paidamount = $package->price - $package->discount;
                    }
                }
                $row->transactionverified = 0;
                $row->transactionautoverified = 0;
                $row->status = 1;
            } else { //free
                $packagefor = 0;
                if ($data['packagefor'] == 1) {
                    $query = "SELECT COUNT(package.id) FROM `#__js_job_employerpackages` AS package";
                    if ($packageconfig['onlyonce_employer_getfreepackage'] == 1)
                        $packagefor = 1;
                    $row->status = $packageconfig['employer_freepackage_autoapprove'];
                }elseif ($data['packagefor'] == 2) {
                    $query = "SELECT COUNT(package.id) FROM `#__js_job_jobseekerpackages` AS package";
                    if ($packageconfig['onlyonce_jobseeker_getfreepackage'] == 1)
                        $packagefor = 1;
                    $row->status = $packageconfig['jobseeker_freepackage_autoapprove'];
                }
                if ($packagefor == 1) { // can't get free package more then once
                    $query .=" JOIN `#__js_job_paymenthistory` AS payment ON payment.packageid = package.id
                                    WHERE package.price = 0 AND payment.uid = " . $data['uid'] . " AND payment.packagefor=" . $data['packagefor'];
                    $db->setQuery($query);
                    $freepackage = $db->loadResult();
                    if ($freepackage > 0)
                        return 'cantgetpackagemorethenone'; // can't get free package more then once
                }
                $row->transactionverified = 1;
                $row->transactionautoverified = 1;
            }
            $row->discountamount = $discountamount;
            $row->paidamount = $paidamount;
            $row->discountmessage = $package->discountmessage;
            $row->packagediscountstartdate = $package->discountstartdate;
            $row->packagediscountenddate = $package->discountenddate;
            $row->packageexpireindays = $package->packageexpireindays;
            $row->packageshortdetails = $package->shortdetails;
            $row->packagedescription = $package->description;
            $row->created = date('Y-m-d H:i:s');
        }else {
            return false;
        }

        if (!$row->check()) {
            echo $this->setError($this->_db->getErrorMsg());
            return false;
        }
        if (!$row->store()) {
            $this->setError($this->_db->getErrorMsg());
            echo $this->_db->getErrorMsg();
            return false;
        }
        if ($data['packagefor'] == 1)
            $this->getJSModel('adminemail')->sendMailtoAdmin($row->id, $data['uid'], 6);
        elseif ($data['packagefor'] == 2)
            $this->getJSModel('adminemail')->sendMailtoAdmin($row->id, $data['uid'], 7);

        $orderid = $row->id;
        return $orderid;
    }

}
?>    
