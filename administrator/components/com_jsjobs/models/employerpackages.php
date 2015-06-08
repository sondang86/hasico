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

class JSJobsModelEmployerPackages extends JSModel{

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

    function storeEmployerPackage() {
        $row = $this->getTable('employerpackage');

        $data = JRequest :: get('post');

        if (!isset($this->_config)) {
            $this->_config = $this->getJSModel('configuration')->getConfig('');
        }
        foreach ($this->_config as $conf) {
            if ($conf->configname == 'date_format')
                $dateformat = $conf->configvalue;
        }


        if ($dateformat == 'm/d/Y') {
            $arr = explode('/', $data['discountstartdate']);
            $data['discountstartdate'] = $arr[2] . '/' . $arr[0] . '/' . $arr[1];
            $arr = explode('/', $data['discountenddate']);
            $data['discountenddate'] = $arr[2] . '/' . $arr[0] . '/' . $arr[1];
        } elseif ($dateformat == 'd-m-Y') {
            $arr = explode('-', $data['discountstartdate']);
            $data['discountstartdate'] = $arr[2] . '-' . $arr[1] . '-' . $arr[0];
            $arr = explode('-', $data['discountenddate']);
            $data['discountenddate'] = $arr[2] . '-' . $arr[1] . '-' . $arr[0];
        }

        $data['discountstartdate'] = date('Y-m-d H:i:s', strtotime($data['discountstartdate']));
        $data['discountenddate'] = date('Y-m-d H:i:s', strtotime($data['discountenddate']));
        if (!$row->bind($data)) {
            $this->setError($this->_db->getErrorMsg());
            return false;
        }
        if (!$row->store()) {
            $this->setError($this->_db->getErrorMsg());
            echo $this->_db->getErrorMsg();
            return false;
        }
        return true;
    }

    function deleteEmployerPackage() {
        $cids = JRequest :: getVar('cid', array(0), 'post', 'array');
        $row = $this->getTable('employerpackage');
        $deleteall = 1;
        foreach ($cids as $cid) {
            if ($this->employerPackageCanDelete($cid) == true) {

                if (!$row->delete($cid)) {
                    $this->setError($row->getErrorMsg());
                    return false;
                }
            } else
                $deleteall++;
        }
        return $deleteall;
    }

    function employerPackageCanDelete($id) {
        if (is_numeric($id) == false)
            return false;
        $db = $this->getDBO();
        $query = "SELECT 
                    (SELECT COUNT(id) FROM `#__js_job_paymenthistory` WHERE packageid = " . $id . " AND packagefor=1 ) AS total";
        $db->setQuery($query);
        $total = $db->loadResult();
        if ($total > 0)
            return false;
        else
            return true;
    }

    function getEmployerPackages($limitstart, $limit) {
        $db = JFactory :: getDBO();
        $result = array();
        $query = "SELECT COUNT(id) FROM #__js_job_employerpackages ";
        $db->setQuery($query);
        $total = $db->loadResult();
        if ($total <= $limitstart)
            $limitstart = 0;

        $query = "SELECT * FROM #__js_job_employerpackages  ORDER BY id ASC";

        $db->setQuery($query, $limitstart, $limit);
        $packages = $db->loadObjectList();

        $result[0] = $packages;
        $result[1] = $total;
        return $result;
    }

    function getEmployerPackagebyId($c_id) {
        if (is_numeric($c_id) == false)
            return false;
        $db = JFactory :: getDBO();
        $query = "SELECT * FROM #__js_job_employerpackages WHERE id = " . $c_id;
        $db->setQuery($query);
        $package = $db->loadObject();
        $status = array(
            '0' => array('value' => 0, 'text' => JText::_('JS_UNPUBLISHED')),
            '1' => array('value' => 1, 'text' => JText::_('JS_PUBLISHED')),);
        $unpublishjobtype = array(
            '0' => array('value' => 1, 'text' => JText::_('JS_DAYS')),
            '1' => array('value' => 2, 'text' => JText::_('JS_WEEKS')),
            '2' => array('value' => 3, 'text' => JText::_('JS_MONTHS')),);
        $type = array(
            '0' => array('value' => 1, 'text' => JText::_('Amount')),
            '1' => array('value' => 2, 'text' => JText::_('%')),);

        $yesNo = array(
            '0' => array('value' => 1, 'text' => JText::_('yes')),
            '1' => array('value' => 0, 'text' => JText::_('No')),);

        if (isset($package)) {
            $lists['status'] = JHTML::_('select.genericList', $status, 'status', 'class="inputbox required" ' . '', 'value', 'text', $package->status);
            $lists['unpublishjobtype'] = JHTML::_('select.genericList', $unpublishjobtype, 'enforcestoppublishjobtype', 'class="inputbox required" ' . '', 'value', 'text', $package->enforcestoppublishjobtype);
            $lists['type'] = JHTML::_('select.genericList', $type, 'discounttype', 'class="inputbox required" ' . '', 'value', 'text', $package->discounttype);
            $lists['resumesearch'] = JHTML::_('select.genericList', $yesNo, 'resumesearch', 'class="inputbox required" ' . '', 'value', 'text', $package->resumesearch);
            $lists['saveresumesearch'] = JHTML::_('select.genericList', $yesNo, 'saveresumesearch', 'class="inputbox required" ' . '', 'value', 'text', $package->saveresumesearch);
            $lists['messages'] = JHTML::_('select.genericList', $yesNo, 'messageallow', 'class="inputbox required" ' . '', 'value', 'text', $package->messageallow);
            $lists['currency'] = JHTML::_('select.genericList', $this->getJSModel('currency')->getCurrency(), 'currencyid', 'class="inputbox" ' . '', 'value', 'text', $package->currencyid);
        } else {
            $lists['status'] = JHTML::_('select.genericList', $status, 'status', 'class="inputbox required" ' . '', 'value', 'text', '');
            $lists['unpublishjobtype'] = JHTML::_('select.genericList', $unpublishjobtype, 'unpublishjobtype', 'class="inputbox required" ' . '', 'value', 'text', '');
            $lists['type'] = JHTML::_('select.genericList', $type, 'discounttype', 'class="inputbox required" ' . '', 'value', 'text', '');
            $lists['resumesearch'] = JHTML::_('select.genericList', $yesNo, 'resumesearch', 'class="inputbox required" ' . '', 'value', 'text', '');
            $lists['saveresumesearch'] = JHTML::_('select.genericList', $yesNo, 'saveresumesearch', 'class="inputbox required" ' . '', 'value', 'text', '');
            $lists['messages'] = JHTML::_('select.genericList', $yesNo, 'messageallow', 'class="inputbox required" ' . '', 'value', 'text', '');
            $lists['currency'] = JHTML::_('select.genericList', $this->getJSModel('currency')->getCurrency(), 'currencyid', 'class="inputbox" ' . '', 'value', 'text', '');
        }

        $result[0] = $package;
        $result[1] = $lists;

        return $result;
    }

    function getEmployerPackageForCombo($title) {
        $db = JFactory::getDBO();
        $query = "SELECT id, title FROM `#__js_job_employerpackages` WHERE status = 1 ORDER BY id ASC ";
        $db->setQuery($query);
        $rows = $db->loadObjectList();
        if ($db->getErrorNum()) {
            echo $db->stderr();
            return false;
        }
        $packages = array();
        if ($title)
            $packages[] = array('value' => '', 'text' => $title);

        foreach ($rows as $row) {
            $packages[] = array('value' => $row->id, 'text' => $row->title);
        }
        return $packages;
    }

    function getFreeEmployerPackageForCombo($title) {
        $db = JFactory::getDBO();
        $query = "SELECT id, title FROM `#__js_job_employerpackages` WHERE status = 1 AND price = 0 ORDER BY id ASC ";
        $db->setQuery($query);
        $rows = $db->loadObjectList();
        if ($db->getErrorNum()) {
            echo $db->stderr();
            return false;
        }
        $packages = array();
        if ($title)
            $packages[] = array('value' => '', 'text' => $title);

        foreach ($rows as $row) {
            $packages[] = array('value' => $row->id, 'text' => $row->title);
        }
        return $packages;
    }

}
?>