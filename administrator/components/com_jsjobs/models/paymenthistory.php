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

class JSJobsModelPaymenthistory extends JSModel{

    var $_config = null;
    var $_application = null;
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

    function jobseekerPaymentApprove($packageid) {
        if (is_numeric($packageid) == false)
            return false;
        $db = JFactory::getDBO();

        $query = "UPDATE #__js_job_paymenthistory SET transactionverified = 1, status=1 WHERE id = " . $packageid;
        $db->setQuery($query);
        if (!$db->query()) {
            return false;
        }
        return true;
    }

    function jobseekerPaymentReject($packageid) {
        if (is_numeric($packageid) == false)
            return false;
        $db = JFactory::getDBO();

        $query = "UPDATE #__js_job_paymenthistory SET transactionverified = -1 , status= -1 WHERE id = " . $packageid;
        $db->setQuery($query);
        if (!$db->query()) {
            return false;
        }
        return true;
    }

    function employerPaymentApprove($packageid) {
        if (is_numeric($packageid) == false)
            return false;
        $db = JFactory::getDBO();

        $query = "UPDATE #__js_job_paymenthistory SET transactionverified = 1 , status=1 WHERE id = " . $packageid;
        $db->setQuery($query);
        if (!$db->query()) {
            return false;
        }
        return true;
    }

    function employerPaymentReject($packageid) {
        if (is_numeric($packageid) == false)
            return false;
        $db = JFactory::getDBO();

        $query = "UPDATE #__js_job_paymenthistory SET transactionverified = -1  , status= -1 WHERE id = " . $packageid;
        $db->setQuery($query);
        if (!$db->query()) {
            return false;
        }
        return true;
    }

    function getPaymentReport($buyername, $paymentfor, $searchpaymentstatus, $searchstartdate, $searchenddate, $limitstart, $limit) {
        $db = JFactory :: getDBO();
        $result = array();
        if (!isset($this->_config))
            $this->_config = $this->getJSModel('configuration')->getConfig();
        foreach ($this->_config AS $config) {
            if ($config->configname == 'date_format')
                $dateformat = $config->configvalue;
        }
        $companywherequery = '';
        $ewherequery = '';
        $jwherequery = '';
        $wherequery = '';
        if (!$searchstartdate) {
            $searchstartdate = date('Y-m-d', strtotime(date("Y-m-d") . " -1 month"));
            $searchenddate = date('Y-m-d', strtotime(date("Y-m-d") . " +1 day")); //include today
        } else {
            $searchstartdate = date('Y-m-d', strtotime($searchstartdate));
            $searchenddate = date('Y-m-d', strtotime($searchenddate));
        }

        if ($paymentfor == '')
            $paymentfor = 'both';
        if ($paymentfor == 'both') {
            $clause = " WHERE ";
            if ($searchpaymentstatus) {
                $ewherequery .= $clause . "  epayment.transactionverified = " . $searchpaymentstatus;
                $jwherequery .= $clause . "  jpayment.transactionverified = " . $searchpaymentstatus;
                $clause = " AND ";
            }
            if ($searchstartdate AND $searchenddate) {
                $ewherequery .= $clause . "  epayment.created BETWEEN " . $db->Quote($searchstartdate) . " AND " . $db->Quote($searchenddate);
                $jwherequery .= $clause . "  jpayment.created BETWEEN " . $db->Quote($searchstartdate) . " AND " . $db->Quote($searchenddate);
                $clause = " AND ";
            }
        } else {
            $clause = " WHERE ";
            if ($searchpaymentstatus) {
                $wherequery .= $clause . "  payment.transactionverified = " . $searchpaymentstatus;
                $clause = " AND ";
            }
            if ($searchstartdate AND $searchenddate) {
                $wherequery .= $clause . "  payment.created BETWEEN " . $db->Quote($searchstartdate) . " AND " . $db->Quote($searchenddate);
                $clause = " AND ";
            }
        }
        if ($paymentfor == 'employer') {
            $totalquery = "SELECT COUNT(payment.id)
					FROM #__js_job_paymenthistory AS payment
					JOIN #__js_job_employerpackages AS package ON (payment.packageid = package.id AND payment.packagefor=1)";

            $query = "SELECT payment.uid,payment.packageid,payment.packagetitle, 'Employer' AS packagefor, payment.payer_firstname,payment.paidamount,payment.transactionverified,payment.created,cur.symbol
                                        ,(SELECT company.name FROM #__js_job_companies AS company WHERE payment.uid = company.uid " . $companywherequery . " LIMIT 1 ) AS buyername
					FROM #__js_job_paymenthistory AS payment
					JOIN #__js_job_employerpackages AS package ON (payment.packageid = package.id AND payment.packagefor=1)
					LEFT JOIN #__js_job_currencies AS cur ON cur.id = payment.currencyid
					";

            $totalquery = $totalquery . $wherequery;
            $query = $query . $wherequery . ' ORDER BY payment.created DESC';
        } elseif ($paymentfor == 'jobseeker') {
            $totalquery = "SELECT COUNT(payment.id)
					FROM #__js_job_paymenthistory AS payment
					JOIN #__js_job_jobseekerpackages AS package ON (payment.packageid = package.id AND payment.packagefor=2)";

            $query = "SELECT payment.uid,payment.packageid,payment.packagetitle, 'Job Seeker' AS packagefor,payment.payer_firstname,payment.paidamount,payment.transactionverified,payment.created,cur.symbol
					,(SELECT CONCAT(resume.first_name,' ',resume.last_name) FROM #__js_job_resume AS resume WHERE payment.uid = resume.uid LIMIT 1) AS buyername
                                        FROM #__js_job_paymenthistory AS payment
					JOIN #__js_job_jobseekerpackages AS package ON (payment.packageid = package.id AND payment.packagefor=2)
					LEFT JOIN #__js_job_currencies AS cur ON cur.id = payment.currencyid
					";

            $totalquery = $totalquery . $wherequery;
            $query = $query . $wherequery . ' ORDER BY payment.created DESC';
        } elseif ($paymentfor == 'both') {
            $totalquery = "SELECT
					( SELECT COUNT(epayment.id) FROM `#__js_job_paymenthistory` AS epayment " . $ewherequery . ")
					+ ( SELECT COUNT(jpayment.id) FROM `#__js_job_paymenthistory` AS jpayment " . $jwherequery . ")
					AS total ";

            $query = "SELECT epayment.uid,epayment.packageid,epayment.packagetitle, 'Employer' AS packagefor, epayment.payer_firstname,epayment.paidamount,epayment.transactionverified,epayment.created,ecur.symbol AS symbol
                                        ,(SELECT company.name FROM #__js_job_companies AS company WHERE epayment.uid = company.uid LIMIT 1) AS buyername
					FROM #__js_job_paymenthistory AS epayment
					JOIN #__js_job_employerpackages AS epackage ON epayment.packageid = epackage.id
					LEFT JOIN #__js_job_currencies AS ecur ON ecur.id = epayment.currencyid
					";
            $unionquery = "
                            UNION
                            SELECT jpayment.uid,jpayment.packageid,jpayment.packagetitle, 'Job Seeker' AS packagefor,jpayment.payer_firstname,jpayment.paidamount,jpayment.transactionverified,jpayment.created,jcur.symbol AS symbol
                                        ,(SELECT CONCAT(resume.first_name,' ',resume.last_name) FROM #__js_job_resume AS resume WHERE jpayment.uid = resume.uid LIMIT 1) AS buyername
					FROM #__js_job_paymenthistory AS jpayment
					JOIN #__js_job_jobseekerpackages AS jpackage ON jpayment.packageid = jpackage.id
					LEFT JOIN #__js_job_currencies AS jcur ON jcur.id = jpayment.currencyid
					";
            $query = $query . $ewherequery . $unionquery . $jwherequery . ' ORDER BY created DESC';
        }
        $db->setQuery($totalquery);
        $total = $db->loadResult();

        if ($total <= $limitstart)
            $limitstart = 0;

        $db->setQuery($query, $limitstart, $limit);
        $payments = $db->loadObjectList();

        $lists = array();
        $searchstartdate = date($dateformat, strtotime($searchstartdate));
        $searchenddate = date($dateformat, strtotime($searchenddate));

        if ($buyername)
            $lists['buyername'] = $buyername;
        if ($searchstartdate)
            $lists['searchstartdate'] = $searchstartdate;
        if ($searchenddate)
            $lists['searchenddate'] = $searchenddate;

        $paymentforvalues = array(
            '0' => array('value' => 'both', 'text' => JText::_('JS_BOTH')),
            '1' => array('value' => 'employer', 'text' => JText::_('JS_EMPLOYER')),
            '2' => array('value' => 'jobseeker', 'text' => JText::_('JS_JOBSEEKER')),);

        $lists['paymentfor'] = JHTML::_('select.genericList', $paymentforvalues, 'paymentfor', 'class="inputbox" ' . 'onChange="document.adminForm.submit();"', 'value', 'text', $paymentfor);

        $paymentstatus = array(
            '0' => array('value' => '', 'text' => JText::_('JS_SELECT_PAYMENT_STATUS')),
            '1' => array('value' => 1, 'text' => JText::_('JS_VERIFIED')),
            '2' => array('value' => -1, 'text' => JText::_('JS_NOT_VERIFIED')),);

        if ($searchpaymentstatus)
            $lists['paymentstatus'] = JHTML::_('select.genericList', $paymentstatus, 'searchpaymentstatus', 'class="inputbox" ' . 'onChange="document.adminForm.submit();"', 'value', 'text', $searchpaymentstatus);
        else
            $lists['paymentstatus'] = JHTML::_('select.genericList', $paymentstatus, 'searchpaymentstatus', 'class="inputbox" ' . 'onChange="document.adminForm.submit();"', 'value', 'text', '');

        $result[0] = $payments;
        $result[1] = $total;
        $result[2] = $lists;
        $result[3] = $paymentfor;
        return $result;
    }

    function getPackagePaymentReport($packageid, $paymentfor, $searchpaymentstatus, $searchstartdate, $searchenddate, $limitstart, $limit) {
        $db = JFactory :: getDBO();
        $result = array();
        $companywherequery = '';
        if (!$searchstartdate) {
            $searchstartdate = date('Y-m-d', strtotime(date("Y-m-d") . " -1 month"));
            $searchenddate = date('Y-m-d');
        }
        if ($searchpaymentstatus)
            $wherequery .="  AND  payment.transactionverified = " . $searchpaymentstatus;
        if ($searchstartdate AND $searchenddate)
            $wherequery .="  AND  payment.created BETWEEN " . $db->Quote($searchstartdate) . " AND " . $db->Quote($searchenddate);

        if ($paymentfor == 'Employer') {
            $totalquery = "SELECT COUNT(payment.id)
					FROM #__js_job_paymenthistory AS payment
					JOIN #__js_job_employerpackages AS package ON (payment.packageid = package.id AND payment.packagefor=1)
					WHERE payment.packageid=" . $packageid;

            $query = "SELECT payment.packageid,payment.packagetitle, 'Employer' AS packagefor, payment.payer_firstname,payment.paidamount,payment.transactionverified,payment.created
                                        ,(SELECT company.name FROM #__js_job_companies AS company WHERE payment.uid = company.uid " . $companywherequery . " LIMIT 1 ) AS buyername
					FROM #__js_job_paymenthistory AS payment
					JOIN #__js_job_employerpackages AS package ON (payment.packageid = package.id AND payment.packagefor=1)
					WHERE payment.packageid=" . $packageid;

            $totalquery = $totalquery . $wherequery;
            $query = $query . $wherequery;
        } elseif ($paymentfor == 'Job Seeker') {

            $totalquery = "SELECT COUNT(payment.id)
					FROM #__js_job_paymenthistory AS payment
					JOIN #__js_job_jobseekerpackages AS package ON (payment.packageid = package.id AND payment.packagefor=2)
					WHERE payment.packageid = " . $packageid;

            $query = "SELECT payment.packageid,payment.packagetitle, 'Job Seeker' AS packagefor,payment.payer_firstname,payment.paidamount,payment.transactionverified,payment.created
					,(SELECT CONCAT(resume.first_name,' ',resume.last_name) FROM #__js_job_resume AS resume WHERE payment.uid = resume.uid LIMIT 1) AS buyername
					FROM #__js_job_paymenthistory AS payment
					JOIN #__js_job_jobseekerpackages AS package ON (payment.packageid = package.id AND payment.packagefor=2)
					WHERE payment.packageid = " . $packageid;

            $totalquery = $totalquery . $wherequery;
            $query = $query . $wherequery;
        }

        $db->setQuery($totalquery);
        $total = $db->loadResult();

        if ($total <= $limitstart)
            $limitstart = 0;

        $db->setQuery($query, $limitstart, $limit);
        $payments = $db->loadObjectList();

        $lists = array();

        if ($searchstartdate)
            $lists['searchstartdate'] = $searchstartdate;
        if ($searchenddate)
            $lists['searchenddate'] = $searchenddate;


        $paymentstatus = array(
            '0' => array('value' => '', 'text' => JText::_('JS_SELECT_PAYMENT_STATUS')),
            '1' => array('value' => 1, 'text' => JText::_('JS_VERIFIED')),
            '2' => array('value' => -1, 'text' => JText::_('JS_NOT_VERIFIED')),);

        if ($searchpaymentstatus)
            $lists['paymentstatus'] = JHTML::_('select.genericList', $paymentstatus, 'searchpaymentstatus', 'class="inputbox" ' . 'onChange="document.adminForm.submit();"', 'value', 'text', $searchpaymentstatus);
        else
            $lists['paymentstatus'] = JHTML::_('select.genericList', $paymentstatus, 'searchpaymentstatus', 'class="inputbox" ' . 'onChange="document.adminForm.submit();"', 'value', 'text', '');

        $result[0] = $payments;
        $result[1] = $total;
        $result[2] = $lists;

        return $result;
    }

    function getEmployerPaymentHistory($searchtitle, $searchprice, $searchpaymentstatus, $packagefor, $limitstart, $limit) {
        $db = JFactory :: getDBO();
        $result = array();
        $query = "SELECT COUNT(payment.id)
				FROM #__js_job_paymenthistory AS payment
				JOIN #__js_job_employerpackages AS package ON (payment.packageid = package.id AND payment.packagefor=" . $packagefor . ")";
        $clause = " WHERE ";

        if ($searchtitle) {
            $query .= $clause . "  payment.packagetitle LIKE " . $db->Quote('%' . $searchtitle . '%', false);
            $clause = " AND ";
        }
        if ($searchprice) {
            $query .= $clause . "payment. packageprice LIKE " . $db->Quote('%' . $searchprice . '%', false);
            $clause = " AND ";
        }
        if ($searchpaymentstatus)
            $query .= $clause . "  payment.transactionverified = " . $searchpaymentstatus;

        $db->setQuery($query);
        $total = $db->loadResult();

        if ($total <= $limitstart)
            $limitstart = 0;
        $query = "SELECT payment.*,user.name AS employername,cur.symbol
				FROM #__js_job_paymenthistory AS payment
				JOIN #__js_job_employerpackages AS package ON (payment.packageid = package.id AND payment.packagefor=" . $packagefor . ")
				JOIN #__users AS user ON user.id = payment.uid
				LEFT JOIN #__js_job_currencies AS cur ON cur.id=payment.currencyid
				";

        $clause = " WHERE ";

        if ($searchtitle) {
            $query .= $clause . "  payment.packagetitle LIKE " . $db->Quote('%' . $searchtitle . '%', false);
            $clause = " AND ";
        }
        if ($searchprice) {
            $query .= $clause . "payment. packageprice LIKE " . $db->Quote('%' . $searchprice . '%', false);
            $clause = " AND ";
        }
        if ($searchpaymentstatus)
            $query .= $clause . "  payment.transactionverified = " . $searchpaymentstatus;
        $query .= " ORDER BY payment.created DESC";

        $db->setQuery($query, $limitstart, $limit);
        $packages = $db->loadObjectList();
        $lists = array();
        $paymentstatus = array(
            '0' => array('value' => '', 'text' => JText::_('JS_SELECT_PAYMENT_STATUS')),
            '1' => array('value' => 1, 'text' => JText::_('JS_VERIFIED')),
            '2' => array('value' => -1, 'text' => JText::_('JS_NOT_VERIFIED')),);


        if ($searchtitle)
            $lists['searchtitle'] = $searchtitle;
        if ($searchprice)
            $lists['searchprice'] = $searchprice;
        if ($searchpaymentstatus)
            $lists['paymentstatus'] = JHTML::_('select.genericList', $paymentstatus, 'searchpaymentstatus', 'class="inputbox" ' . 'onChange="document.adminForm.submit();"', 'value', 'text', $searchpaymentstatus);
        else
            $lists['paymentstatus'] = JHTML::_('select.genericList', $paymentstatus, 'searchpaymentstatus', 'class="inputbox" ' . 'onChange="document.adminForm.submit();"', 'value', 'text', '');

        $result[0] = $packages;
        $result[1] = $total;
        $result[2] = $lists;
        return $result;
    }

    function getJobseekerPaymentHistory($searchtitle, $searchprice, $searchpaymentstatus, $packagefor, $limitstart, $limit) {
        $db = JFactory :: getDBO();
        $result = array();
        $query = "SELECT COUNT(payment.id)
				FROM #__js_job_paymenthistory AS payment
				JOIN #__js_job_jobseekerpackages AS package ON (payment.packageid = package.id AND payment.packagefor=" . $packagefor . ")";


        $clause = " WHERE ";
        if ($searchtitle) {
            $query .=$clause . " payment.packagetitle LIKE " . $db->Quote('%' . $searchtitle . '%', false);
            $clause = " AND ";
        }
        if ($searchprice) {
            $query .= $clause . "  payment.packageprice LIKE " . $db->Quote('%' . $searchprice . '%', false);
            $clause = " AND ";
        }
        if ($searchpaymentstatus)
            $query .= $clause . " payment.transactionverified = " . $searchpaymentstatus;

        $db->setQuery($query);
        $total = $db->loadResult();
        if ($total <= $limitstart)
            $limitstart = 0;

        $query = "SELECT payment.*,user.name AS jobseekername,cur.symbol
				  FROM #__js_job_paymenthistory AS payment
				  JOIN #__js_job_jobseekerpackages AS package ON (payment.packageid = package.id AND payment.packagefor=" . $packagefor . ")
				  JOIN #__users AS user ON user.id = payment.uid 
					LEFT JOIN #__js_job_currencies AS cur ON cur.id=payment.currencyid
				  ";

        $clause = "WHERE";
        if ($searchtitle) {
            $query .= $clause . " payment.packagetitle LIKE " . $db->Quote('%' . $searchtitle . '%', false);
            $clause = "AND";
        }
        if ($searchprice) {
            $query .= $clause . "  payment.packageprice LIKE " . $db->Quote('%' . $searchprice . '%', false);
            $clause = "AND";
        }
        if ($searchpaymentstatus)
            $query .= $clause . " payment.transactionverified = " . $searchpaymentstatus;

        $query .= " ORDER BY payment.created DESC";


        $db->setQuery($query, $limitstart, $limit);
        $this->_application = $db->loadObjectList();

        $lists = array();
        $paymentstatus = array(
            '0' => array('value' => '', 'text' => JText::_('JS_SELECT_PAYMENT_STATUS')),
            '1' => array('value' => 1, 'text' => JText::_('JS_VERIFIED')),
            '2' => array('value' => -1, 'text' => JText::_('JS_NOT_VERIFIED')),);


        if ($searchtitle)
            $lists['searchtitle'] = $searchtitle;
        if ($searchprice)
            $lists['searchprice'] = $searchprice;

        if ($searchpaymentstatus)
            $lists['paymentstatus'] = JHTML::_('select.genericList', $paymentstatus, 'searchpaymentstatus', 'class="inputbox" ' . 'onChange="document.adminForm.submit();"', 'value', 'text', $searchpaymentstatus);
        else
            $lists['paymentstatus'] = JHTML::_('select.genericList', $paymentstatus, 'searchpaymentstatus', 'class="inputbox" ' . 'onChange="document.adminForm.submit();"', 'value', 'text', '');

        $result[0] = $this->_application;
        $result[1] = $total;
        $result[2] = $lists;
        return $result;
    }

    function getEmployerPaymentHistorybyId($c_id) {
        if (is_numeric($c_id) == false)
            return false;
        $db = JFactory :: getDBO();


        $query = "SELECT payment.*,package.companiesallow,package.jobsallow,
				package.resumesearch,package.saveresumesearch,package.viewresumeindetails,package.video,package.map,
                                package.shortdetails,package.description,
				user.name AS employername,
				package.price,package.discount,package.discountstartdate,package.discountenddate,
				package.enforcestoppublishjob,package.enforcestoppublishjobvalue,package.enforcestoppublishjobtype,package.packageexpireindays
				FROM #__js_job_paymenthistory AS payment
				JOIN #__js_job_employerpackages AS package ON payment.packageid = package.id
				JOIN #__users AS user ON user.id = payment.uid ";
        $query .="WHERE  payment.id=" . $c_id;

        $db->setQuery($query);
        $package = $db->loadObject();


        $result[0] = $package;


        return $result;
    }

    function getJobseekerPaymentHistorybyId($c_id) {
        if (is_numeric($c_id) == false)
            return false;
        $db = JFactory :: getDBO();
        $query = "SELECT payment.*,payment.payer_itemname2 AS payer_itemname1,package.resumeallow,package.coverlettersallow,package.jobsearch,
				package.savejobsearch,package.applyjobs,package.video,
				package.shortdetails,package.description,package.price,package.discount,package.discountstartdate,package.discountenddate,
				package.packageexpireindays,user.name AS jobseekername
				FROM #__js_job_paymenthistory AS payment
				JOIN #__js_job_jobseekerpackages AS package ON payment.packageid = package.id
				JOIN #__users AS user ON user.id = payment.uid  ";
        $query .=" WHERE payment.id=" . $c_id;
        $db->setQuery($query);
        $package = $db->loadObject();

        $result[0] = $package;

        return $result;
    }

// Payment Package End
// For Combo Sta
    function storeUserPackage() {


        $data = JRequest :: get('post'); // get data from form

        if (is_numeric($data['packageid']) == false)
            return false;
        $db = $this->getDBO();
        $result = array();
        $user = JFactory::getUser();
        $uid = $user->id;
        $row = $this->getTable('paymenthistory');
        if ($data['userrole'] == 1) {
            $tablename = '#__js_job_employerpackages';
            $row->packagefor = 1;
        } elseif ($data['userrole'] == 2) {
            $tablename = '#__js_job_jobseekerpackages';
            $row->packagefor = 2;
        }
        $query = "SELECT package.* FROM `" . $tablename . "` AS package WHERE id = " . $data['packageid'];
        $db->setQuery($query);
        $package = $db->loadObject();
        if (isset($package)) {
            $packageconfig = $this->getJSModel('configuration')->getConfigByFor('package');
            $row->uid = $data['userid'];
            $row->currencyid = $this->_defaultcurrency;
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

                if ($data['userrole'] == 1) {

                    if ($packageconfig['onlyonce_employer_getfreepackage'] == '1') { // can't get free package more then once
                        $query = "SELECT COUNT(package.id) FROM `#__js_job_employerpackages` AS package
							JOIN `#__js_job_paymenthistory` AS payment ON (payment.packageid = package.id AND payment.packagefor=1)
							WHERE package.price = 0 AND payment.uid = " . $data['userid'];
                        $db->setQuery($query);
                        $freepackage = $db->loadResult();
                        if ($freepackage > 0)
                            return 5; // can't get free package more then once
                    }
                }elseif ($data['userrole'] == 2) {

                    if ($packageconfig['onlyonce_jobseeker_getfreepackage'] == '1') { // can't get free package more then once
                        $query = "SELECT COUNT(package.id) FROM `#__js_job_jobseekerpackages` AS package
			                    JOIN `#__js_job_paymenthistory` AS payment ON (payment.packageid = package.id AND payment.packagefor=2)
			                    WHERE package.price = 0 AND payment.uid = " . $data['userid'];
                        $db->setQuery($query);
                        $freepackage = $db->loadResult();
                        if ($freepackage > 0)
                            return 5; // can't get free package more then once
                    }
                }

                $row->transactionverified = 1;
                $row->transactionautoverified = 1;
                $row->status = $packageconfig['jobseeker_freepackage_autoapprove'];
            }
            $row->discountamount = $discountamount;
            $row->paidamount = $paidamount;

            $row->discountmessage = $package->discountmessage;
            //if($data['userrole'] == 2){ // no column in employerpayment history
            $row->packagediscountstartdate = $package->discountstartdate;
            $row->packagediscountenddate = $package->discountenddate;
            //}
            $row->packageexpireindays = $package->packageexpireindays;
            $row->packageshortdetails = $package->shortdetails;
            $row->packagedescription = $package->description;
            $row->created = date('Y-m-d H:i:s');
        }else {
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
        return true;
    }

}
?>