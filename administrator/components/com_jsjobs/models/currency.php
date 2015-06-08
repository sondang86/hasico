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

class JSJobsModelCurrency extends JSModel{

    var $_config = null;
    var $_defaultcurrency = null;
    var $_client_auth_key = null;
    var $_siteurl = null;

    function __construct() {
        parent :: __construct();
        $this->_client_auth_key = $this->getJSModel('jobsharing')->getClientAuthenticationKey();
        $this->_siteurl = JURI::root();
        $this->_defaultcurrency = $this->getDefaultCurrency();
        $user = JFactory::getUser();
        $this->_uid = $user->id;
    }

    function getCurrencybyId($c_id) {
        if (is_numeric($c_id) == false)
            return false;
        $db = JFactory :: getDBO();
        $query = "SELECT * FROM #__js_job_currencies WHERE id = " . $c_id;
        $db->setQuery($query);
        $currency = $db->loadObject();
        return $currency;
    }

    function getCurrency($title = "") {
        $db = JFactory :: getDBO();
        if (!isset($this->_defaultcurrency))
            $this->_defaultcurrency = $this->getDefaultCurrency();
        $q = "SELECT * FROM `#__js_job_currencies` WHERE status = 1 AND id = " . $this->_defaultcurrency;
        if ($this->_client_auth_key != "")
            $q.=" AND serverid!='' AND serverid!=0";
        $db->setQuery($q);
        $defaultcurrency = $db->loadObject();
        $combobox = array();
        if ($title)
            $combobox[] = array('value' => '', 'text' => $title);
        //$combobox[] = array('value' => $defaultcurrency->id, 'text' => JText::_($defaultcurrency->symbol));

        $q = "SELECT * FROM `#__js_job_currencies` WHERE status = 1 ";
        if ($this->_client_auth_key != "")
            $q.=" AND serverid!='' AND serverid!=0";
        $q.=" ORDER BY ordering ASC";
        $db->setQuery($q);
        $allcurrency = $db->loadObjectList();
        foreach ($allcurrency as $currency) {
            $combobox[] = array('value' => $currency->id, 'text' => JText::_($currency->symbol));
        }

        return $combobox;
    }

    function getDefaultCurrency() {
        $db = JFactory :: getDBO();
        $q = "SELECT currency.id FROM `#__js_job_currencies` currency WHERE currency.default = 1 AND currency.status=1";
        $db->setQuery($q);
        $defaultValue = $db->loadResult();
        if (!$defaultValue) {
            $q = "SELECT id FROM `#__js_job_currencies` WHERE status=1";
            $db->setQuery($q);
            $defaultValue = $db->loadResult();
        }
        return $defaultValue;
    }

    function getDefaultCurrencyValue() {
        $db = JFactory :: getDBO();
        $q = "SELECT symbol FROM `#__js_job_currencies` AS symbol WHERE symbol.default = 1";
        $db->setQuery($q);
        $defaultValue = $db->loadResult();
        if (!$defaultValue) {
            $q = "SELECT symbol FROM `#__js_job_currencies`";
            $db->setQuery($q);
            $defaultValue = $db->loadResult();
        }
        return $defaultValue;
    }

    function getAllCurrencies($limitstart, $limit) {
        $db = JFactory::getDBO();
        $query = "SELECT count(id) FROM `#__js_job_currencies`";
        $db->setQuery($query);
        $total = $db->loadResult();

        if ($total <= $limitstart)
            $limitstart = 0;

        $query = "SELECT * FROM `#__js_job_currencies` ORDER BY ordering ASC ";
        $db->setQuery($query, $limitstart, $limit);
        $currencyresults = $db->loadObjectList();

        $result[0] = $currencyresults;
        $result[1] = $total;

        return $result;
    }

    function storeCurrency() {
        $row = $this->getTable('currency');
        $returnvalue = 1;
        $data = JRequest :: get('post');
        if ($data['id'] == '') { // only for new
            $result = $this->isCurrencyExist($data['title']);
            if ($result == true)
                $returnvalue = 3;
            else {
                $db = JFactory::getDBO();
                $query = "SELECT max(ordering)+1 AS maxordering FROM #__js_job_currencies";
                $db->setQuery($query);
                $ordering = $db->loadResult();
                $data['ordering'] = $ordering;
                $data['default'] = 0;
            }
        }
        if ($returnvalue == 1) {
            if (!$row->bind($data)) {
                $this->setError($this->_db->getErrorMsg());
                return false;
            }
            if (!$row->store()) {
                $this->setError($this->_db->getErrorMsg());
                return false;
            }
            $server_currencies_data = array();
            if ($this->_client_auth_key != "") {
                $server_currencies_data['id'] = $row->id;
                $server_currencies_data['title'] = $row->title;
                $server_currencies_data['symbol'] = $row->symbol;
                $server_currencies_data['status'] = $row->status;
                $server_currencies_data['default'] = $row->default;
                $server_currencies_data['serverid'] = $row->serverid;
                $server_currencies_data['authkey'] = $this->_client_auth_key;
                $table = "currencies";
                $jobsharing = $this->getJSModel('jobsharing');
                $return_value = $jobsharing->storeDefaultTables($server_currencies_data, $table);
                $return_value['issharing'] = 1;
                $return_value[2] = $row->id;
            } else {
                $return_value['issharing'] = 0;
                $return_value[1] = $returnvalue;
                $return_value[2] = $row->id;
            }
            return $return_value;
        } else {
            return $returnvalue;
        }
    }

    function isCurrencyExist($title) {
        $db = JFactory::getDBO();
        $query = "SELECT COUNT(id) FROM #__js_job_currencies WHERE title = " . $db->Quote($title);
        $db->setQuery($query);
        $result = $db->loadResult();
        if ($result == 0)
            return false;
        else
            return true;
    }

    function deleteCurrency() {
        $cids = JRequest :: getVar('cid', array(0), 'post', 'array');
        $row = $this->getTable('currency');
        $deleteall = 1;
        foreach ($cids as $cid) {
            if ($this->currencyCanDelete($cid) == true) {
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

    function currencyCanDelete($currencyid) {
        if (is_numeric($currencyid) == false)
            return false;
        $db = $this->getDBO();
        $query = " SELECT
                    ( SELECT COUNT(id) FROM `#__js_job_jobs` WHERE currencyid = " . $currencyid . ")
                    + ( SELECT COUNT(id) FROM `#__js_job_resume` WHERE currencyid = " . $currencyid . " OR dcurrencyid = " . $currencyid . ")
                    + ( SELECT COUNT(id) FROM `#__js_job_employerpackages` WHERE currencyid = " . $currencyid . ")
                    + ( SELECT COUNT(id) FROM `#__js_job_jobseekerpackages` WHERE currencyid = " . $currencyid . ")
                    + ( SELECT COUNT(id) FROM `#__js_job_currencies` AS cur WHERE cur.id = " . $currencyid . " AND cur.default =1)
                    AS total ";

        $db->setQuery($query);
        $total = $db->loadResult();
        if ($total > 0)
            return false;
        else
            return true;
    }

    function getCurrencyResumeApplied($title) {
        $db = JFactory :: getDBO();
        $q = "SELECT * FROM `#__js_job_currencies` WHERE status = 1";
        if ($this->_client_auth_key != "")
            $q.=" AND serverid!='' AND serverid!=0";
        $db->setQuery($q);
        $allcurrency = $db->loadObjectList();
        $combobox = array();
        if ($title)
            $combobox[] = array('value' => JText::_(''), 'text' => $title);
        if (!empty($allcurrency)) {
            foreach ($allcurrency as $currency) {
                $combobox[] = array('value' => $currency->id, 'text' => JText::_($currency->symbol));
            }
        }
        return $combobox;
    }

    function makeDefaultCurrency($id, $defaultvalue) {
        if (is_numeric($id) == false)
            return false;
        if (is_numeric($defaultvalue) == false)
            return false;
        $db = $this->getDBO();
        $query = "update `#__js_job_currencies` as currency SET currency.default = 0 ";

        $db->setQuery($query);
        if (!$db->query()) {
            return false;
        }
        $row = $this->getTable('currency');
        $row->id = $id;
        $row->default = $defaultvalue;
        if (!$row->store()) {
            $this->setError($this->_db->getErrorMsg());
            return false;
        }
        return true;
    }

}

?>