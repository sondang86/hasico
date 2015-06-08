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

class JSJobsModelCompany extends JSModel{

    var $_config = null;
    var $_defaultcurrency = null;
    var $_client_auth_key = null;
    var $_siteurl = null;
    var $_application = null;
    var $_comp_editor = null;

    function __construct() {
        parent :: __construct();
        $this->_client_auth_key = $this->getJSModel('jobsharing')->getClientAuthenticationKey();
        $this->_siteurl = JURI::root();
        $this->_defaultcurrency = $this->getJSModel('currency')->getDefaultCurrency();
        $user = JFactory::getUser();
        $this->_uid = $user->id;
    }

    function getAllCompaniesForSearch($title) {
        $db = JFactory::getDBO();
        $query = "SELECT id, name FROM `#__js_job_companies`";
        $query.= " ORDER BY name ASC ";
        $db->setQuery($query);
        $rows = $db->loadObjectList();
        if ($db->getErrorNum()) {
            echo $db->stderr();
            return false;
        }
        $companies = array();
        if ($title)
            $companies[] = array('value' => JText::_(''), 'text' => $title);
        foreach ($rows as $row) {
            $companies[] = array('value' => $row->id, 'text' => $row->name);
        }
        return $companies;
    }

    function getCompanybyIdForView($companyid) {
        $db = $this->getDBO();
        if (is_numeric($companyid) == false)
            return false;
        $query = "SELECT company.*, cat.cat_title, country.name AS countryname, state.name AS statename
					, city.name AS cityname
		FROM `#__js_job_companies` AS company
		JOIN `#__js_job_categories` AS cat ON company.category = cat.id
		LEFT JOIN `#__js_job_countries` AS country ON company.country = country.id
		LEFT JOIN `#__js_job_states` AS state ON company.state = state.id
		LEFT JOIN `#__js_job_cities` AS city ON company.city = city.id
		WHERE  company.id = " . $companyid;
        $db->setQuery($query);
        $result[0] = $db->loadObject();
        $result[0]->multicity = $this->getJSModel('jsjobs')->getMultiCityDataForView($companyid, 2);
        $result[3] = $this->getJSModel('fieldordering')->getFieldsOrderingforForm(1);
        return $result;
    }

    function getCompanybyId($c_id) {
        if (is_numeric($c_id) == false)
            return false;
        $defaultCategory = $this->getJSModel('common')->getDefaultValue('categories');
        $companyfieldordering = $this->getJSModel('fieldordering')->getFieldsOrderingforForm(1); // company fields
        foreach ($companyfieldordering AS $cfo) {
            switch ($cfo->field) {
                case "jobcategory":
                    $cat_required = ($cfo->required ? 'required' : '');
                    break;
            }
        }

        $db = JFactory :: getDBO();
        $query = "SELECT * FROM #__js_job_companies WHERE id = " . $c_id;

        $db->setQuery($query);
        $company = $db->loadObject();

        $status = array(
            '0' => array('value' => 0, 'text' => JText::_('JS_PENDDING')),
            '1' => array('value' => 1, 'text' => JText::_('JS_APPROVE')),
            '2' => array('value' => -1, 'text' => JText::_('JS_REJECT')),);


        if (isset($company)) {
            $lists['category'] = JHTML::_('select.genericList', $this->getJSModel('category')->getCategories('', ''), 'category', 'class="inputbox ' . $cat_required . '"' . '', 'value', 'text', $company->category);
            $lists['status'] = JHTML::_('select.genericList', $status, 'status', 'class="inputbox required" ' . '', 'value', 'text', $company->status);
            $multi_lists = $this->getJSModel('common')->getMultiSelectEdit($c_id, 2);
        } else {
            if (!isset($this->_config)) {
                $this->_config = $this->getJSModel('configuration')->getConfig();
            }
            $lists['category'] = JHTML::_('select.genericList', $this->getJSModel('category')->getCategories('', ''), 'category', 'class="inputbox ' . $cat_required . '"' . '', 'value', 'text', $defaultCategory);
            $lists['status'] = JHTML::_('select.genericList', $status, 'status', 'class="inputbox required" ' . '', 'value', 'text', '');
        }
        $result[0] = $company;
        $result[1] = $lists;
        $result[2] = $this->getJSModel('customfield')->getUserFieldsforForm(1, $c_id); // company fields, id
        $result[3] = $companyfieldordering;
        if (isset($multi_lists))
            $result[4] = $multi_lists;

        return $result;
    }

    function getAllCompanies($searchcompany, $searchjobcategory, $searchcountry, $limitstart, $limit) {
        if ($searchjobcategory)
            if (is_numeric($searchjobcategory) == false)
                return false;
        $db = JFactory :: getDBO();
        $result = array();
        $query = "SELECT COUNT(id) FROM #__js_job_companies AS company WHERE company.status <> 0";
        if ($searchcompany)
            $query .= " AND LOWER(company.name) LIKE " . $db->Quote('%' . $searchcompany . '%', false);
        if ($searchjobcategory)
            $query .= " AND company.category = " . $searchjobcategory;
        if ($searchcountry)
            $query .= " AND company.country = " . $db->Quote($searchcountry);

        $db->setQuery($query);
        $total = $db->loadResult();
        if ($total <= $limitstart)
            $limitstart = 0;

        $query = "SELECT company.*, cat.cat_title 
				FROM #__js_job_companies AS company  
				JOIN #__js_job_categories AS cat ON company.category = cat.id
				WHERE company.status <> 0";
        if ($searchcompany)
            $query .= " AND LOWER(company.name) LIKE " . $db->Quote('%' . $searchcompany . '%', false);
        if ($searchjobcategory)
            $query .= " AND company.category = " . $searchjobcategory;
        if ($searchcountry)
            $query .= " AND company.country = " . $db->Quote($searchcountry);

        $query .= " ORDER BY company.created DESC";


        $db->setQuery($query, $limitstart, $limit);
        $this->_application = $db->loadObjectList();

        $lists = array();
        $job_categories = $this->getJSModel('category')->getCategories(JText::_('JS_SELECT_JOB_CATEGORY'), '');
        $countries = $this->getJSModel('country')->getCountries(JText::_('JS_SELECT_COUNTRY'));
        if ($searchcompany)
            $lists['searchcompany'] = $searchcompany;
        if ($searchjobcategory)
            $lists['jobcategory'] = JHTML::_('select.genericList', $job_categories, 'searchjobcategory', 'class="inputbox" ' . 'onChange="this.form.submit();"', 'value', 'text', $searchjobcategory);
        else
            $lists['jobcategory'] = JHTML::_('select.genericList', $job_categories, 'searchjobcategory', 'class="inputbox" ' . 'onChange="this.form.submit();"', 'value', 'text', '');
        if ($searchcountry)
            $lists['country'] = JHTML::_('select.genericList', $countries, 'searchcountry', 'class="inputbox" ' . 'onChange="document.adminForm.submit();"', 'value', 'text', $searchcountry);
        else
            $lists['country'] = JHTML::_('select.genericList', $countries, 'searchcountry', 'class="inputbox" ' . 'onChange="document.adminForm.submit();"', 'value', 'text', '');

        $result[0] = $this->_application;
        $result[1] = $total;
        $result[2] = $lists;
        return $result;
    }

    function getAllUnapprovedCompanies($searchcompany, $searchjobcategory, $searchcountry, $limitstart, $limit) {
        if ($searchjobcategory)
            if (is_numeric($searchjobcategory) == false)
                return false;
        $db = JFactory :: getDBO();
        $result = array();
        $query = "SELECT COUNT(id) FROM #__js_job_companies AS company WHERE company.status = 0";
        if ($searchcompany)
            $query .= " AND LOWER(company.name) LIKE " . $db->Quote('%' . $searchcompany . '%', false);
        if ($searchjobcategory)
            $query .= " AND company.category = " . $searchjobcategory;
        if ($searchcountry)
            $query .= " AND company.country = " . $db->Quote($searchcountry);

        $db->setQuery($query);
        $total = $db->loadResult();
        if ($total <= $limitstart)
            $limitstart = 0;

        $query = "SELECT company.*, cat.cat_title  
				FROM #__js_job_companies AS company  
				JOIN #__js_job_categories AS cat ON company.category = cat.id
				WHERE company.status = 0";
        if ($searchcompany)
            $query .= " AND LOWER(company.name) LIKE " . $db->Quote('%' . $searchcompany . '%', false);
        if ($searchjobcategory)
            $query .= " AND company.category = " . $searchjobcategory;
        if ($searchcountry)
            $query .= " AND company.country = " . $db->Quote($searchcountry);

        $query .= " ORDER BY company.created DESC";

        $db->setQuery($query, $limitstart, $limit);
        $this->_application = $db->loadObjectList();

        $lists = array();


        $job_categories = $this->getJSModel('category')->getCategories(JText::_('JS_SELECT_JOB_CATEGORY'), '');
        $countries = $this->getJSModel('country')->getCountries(JText::_('JS_SELECT_COUNTRY'));
        if ($searchcompany)
            $lists['searchcompany'] = $searchcompany;
        if ($searchjobcategory)
            $lists['jobcategory'] = JHTML::_('select.genericList', $job_categories, 'searchjobcategory', 'class="inputbox" ' . 'onChange="this.form.submit();"', 'value', 'text', $searchjobcategory);
        else
            $lists['jobcategory'] = JHTML::_('select.genericList', $job_categories, 'searchjobcategory', 'class="inputbox" ' . 'onChange="this.form.submit();"', 'value', 'text', '');

        $result[0] = $this->_application;
        $result[1] = $total;
        $result[2] = $lists;
        return $result;
    }

    function getAllCompaniesListing($companyfor, $limitstart, $limit) {
        $db = JFactory :: getDBO();
        $result = array();
        $query = "SELECT COUNT(id) FROM #__js_job_companies AS company WHERE company.status <> 0";
        $db->setQuery($query);
        $total = $db->loadResult();
        if ($total <= $limitstart)
            $limitstart = 0;

        $query = "SELECT company.*, cat.cat_title 
				FROM #__js_job_companies AS company  
				JOIN #__js_job_categories AS cat ON company.category = cat.id
				WHERE company.status <> 0";
        $query .= " ORDER BY company.created DESC";

        $db->setQuery($query, $limitstart, $limit);
        $this->_application = $db->loadObjectList();

        $result[0] = $this->_application;
        $result[1] = $total;

        return $result;
    }

    function storeCompany() {
        $row = $this->getTable('company');
        $data = JRequest :: get('post');
        $filerealpath = "";

        if (!$this->_config)
            $this->_config = $this->getJSModel('configuration')->getConfig('');

        foreach ($this->_config as $conf) {
            if ($conf->configname == 'date_format')
                $dateformat = $conf->configvalue;
        }

        if ($dateformat == 'm/d/Y') {
            $arr = explode('/', $data['since']);
            $data['since'] = $arr[2] . '/' . $arr[0] . '/' . $arr[1];
        } elseif ($dateformat == 'd-m-Y') {
            $arr = explode('-', $data['since']);
            $data['since'] = $arr[2] . '-' . $arr[1] . '-' . $arr[0];
        }
        $data['since'] = date('Y-m-d H:i:s', strtotime($data['since']));

        if (!$this->_comp_editor)
            $this->_config = $this->getJSModel('configuration')->getConfig();
        if ($this->_comp_editor == 1) {
            $data['description'] = JRequest::getVar('description', '', 'post', 'string', JREQUEST_ALLOWRAW);
        }
        $returnvalue = 1;

        if (!empty($data['alias']))
            $companyalias = $this->getJSModel('common')->removeSpecialCharacter($data['alias']);
        else
            $companyalias = $this->getJSModel('common')->removeSpecialCharacter($data['name']);

        $companyalias = strtolower(str_replace(' ', '-', $companyalias));
        $data['alias'] = $companyalias;


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

        $this->getJSModel('customfield')->storeUserFieldData($data, $row->id);

        // For file upload
        $companyid = $row->id;
        $filetypemismatch = 0;
        if ($_FILES['logo']['size'] > 0) { // logo
            $returnvalue = $this->uploadFile($companyid, 1, 0);
            if ($returnvalue == 6)
                $filetypemismatch = 1;
            $filerealpath = $returnvalue;
        }
        if (isset($data['deletelogo']) AND $data['deletelogo'] == 1) { // delete logo
            $returnvalue = $this->uploadFile($companyid, 1, 1);
            if ($returnvalue == 6)
                $filetypemismatch = 1;
        }

        if (isset($_FILES['smalllogo']['size']) AND $_FILES['smalllogo']['size'] > 0) { //small logo
            $returnvalue = $this->uploadFile($companyid, 2, 0);
            if ($returnvalue == 6)
                $filetypemismatch = 1;
        }
        if (isset($data['deletesmalllogo']) AND $data['deletesmalllogo'] == 1) { //delete small logo
            $returnvalue = $this->uploadFile($companyid, 2, 1);
            if ($returnvalue == 6)
                $filetypemismatch = 1;
        }

        if (isset($_FILES['aboutcompany']['size']) AND $_FILES['aboutcompany']['size'] > 0) { //about company
            $returnvalue = $this->uploadFile($companyid, 3, 0);
            if ($returnvalue == 6)
                $filetypemismatch = 1;
        }
        if (isset($data['deleteaboutcompany']) AND $data['deleteaboutcompany'] == 1) { // delete about company
            $returnvalue = $this->uploadFile($companyid, 3, 1);
            if ($returnvalue == 6)
                $filetypemismatch = 1;
        }
        if ($data['city'])
            $storemulticity = $this->storeMultiCitiesCompany($data['city'], $row->id);
        if (isset($storemulticity) AND ($storemulticity == false))
            return false;


        if ($this->_client_auth_key != "") {

            $company_logo = array();

            $db = $this->getDBO();
            $query = "SELECT company.* FROM `#__js_job_companies` AS company  
						WHERE company.id = " . $row->id;

            $db->setQuery($query);
            $data_company = $db->loadObject();
            if ($data['id'] != "" AND $data['id'] != 0)
                $data_company->id = $data['id']; // for edit case
            if ($_FILES['logo']['size'] > 0)
                $company_logo['logofilename'] = $filerealpath;
            $data_company->company_id = $row->id;
            $data_company->authkey = $this->_client_auth_key;
            $data_company->task = 'storecompany';
            $jsjobsharingobject = $this->getJSModel('jobsharing');
            $return_value = $jsjobsharingobject->storeCompanySharing($data_company);
            $jsjobslogobject= $this->getJSModel('log');
            if ($return_value['iscompanystore'] == 0)
                $jsjobslogobject->logStoreCompanySharing($return_value);
            if ($filetypemismatch != 1) {
                if ($_FILES['logo']['size'] > 0)
                    $return_value_company_logo = $jsjobsharingobject->storeCompanyLogoSharing($data_company, $company_logo);
            }
            if (is_array($return_value) AND !empty($return_value) AND is_array($return_value_company_logo) AND !empty($return_value_company_logo)) {
                $company_logo_return_value = (array_merge($return_value, $return_value_company_logo));
                $jsjobslogobject->logStoreCompanySharing($company_logo_return_value);
            } else {
                $jsjobslogobject->logStoreCompanySharing($return_value);
            }
        }
        if ($filetypemismatch == 1)
            return 6;
        return true;
    }

    function storeMultiCitiesCompany($city_id, $companyid) { // city id comma seprated 
        if (is_numeric($companyid) === false)
            return false;
        $db = JFactory::getDBO();
        $query = "SELECT cityid FROM #__js_job_companycities WHERE companyid = " . $companyid;
        $db->setQuery($query);
        $old_cities = $db->loadObjectList();

        $id_array = explode(",", $city_id);
        $row = $this->getTable('companycities');
        $error = array();

        foreach ($old_cities AS $oldcityid) {
            $match = false;
            foreach ($id_array AS $cityid) {
                if ($oldcityid->cityid == $cityid) {
                    $match = true;
                    break;
                }
            }
            if ($match == false) {
                $query = "DELETE FROM #__js_job_companycities WHERE companyid = " . $companyid . " AND cityid=" . $oldcityid->cityid;
                $db->setQuery($query);
                if (!$db->query()) {
                    $err = $this->setError($this->_db->getErrorMsg());
                    $error[] = $err;
                }
            }
        }
        foreach ($id_array AS $cityid) {
            $insert = true;
            foreach ($old_cities AS $oldcityid) {
                if ($oldcityid->cityid == $cityid) {
                    $insert = false;
                    break;
                }
            }
            if ($insert) {
                $row->id = "";
                $row->companyid = $companyid;
                $row->cityid = $cityid;
                if (!$row->store()) {
                    $err = $this->setError($this->_db->getErrorMsg());
                    $error[] = $err;
                }
            }
        }
        if (!empty($error))
            return false;

        return true;
    }

    function getUidByCompanyId($companyid) {
        if (!is_numeric($companyid))
            return false;
        $db = $this->getDbo();
        $query = "SELECT uid FROM `#__js_job_companies` WHERE id = $companyid";
        $db->setQuery($query);
        $uid = $db->loadResult();
        return $uid;
    }

    function deleteCompany() {
        $db = JFactory::getDBO();
        $cids = JRequest :: getVar('cid', array(0), 'post', 'array');
        $row = $this->getTable('company');
        $deleteall = 1;
        foreach ($cids as $cid) {
            $servercompanyid = 0;
            if ($this->_client_auth_key != "") {
                $query = "SELECT company.serverid AS serverid FROM `#__js_job_companies` AS company  WHERE company.id = " . $cid;
                $db->setQuery($query);
                $c_s_id = $db->loadResult();
                if ($c_s_id)
                    $servercompanyid = $c_s_id;
            }
            if ($this->companyCanDelete($cid) == true) {
                if (!$row->delete($cid)) {
                    $this->setError($row->getErrorMsg());
                    return false;
                }
                $query = "DELETE FROM `#__js_job_companycities` WHERE companyid = " . $cid;
                $db->setQuery($query);
                if (!$db->query()) {
                    return false;
                }
                $this->getJSModel('customfield')->deleteUserFieldData($cid);
                if ($servercompanyid != 0) {
                    $data = array();
                    $data['id'] = $servercompanyid;
                    $data['referenceid'] = $cid;
                    $data['uid'] = $this->_uid;
                    $data['authkey'] = $this->_client_auth_key;
                    $data['siteurl'] = $this->_siteurl;
                    $data['task'] = 'deletecompany';
                    $jsjobsharingobject = $this->getJSModel('jobsharing');
                    $return_value = $jsjobsharingobject->deleteCompanySharing($data);
                    $jsjobslogobject= $this->getJSModel('log');
                    $jsjobslogobject->logDeleteCompanySharing($return_value);
                }
            } else
                $deleteall++;
        }
        return $deleteall;
    }

    function companyCanDelete($companyid) {
        if (is_numeric($companyid) == false)
            return false;
        $db = $this->getDBO();

        $query = "SELECT 
                    ( SELECT COUNT(id) FROM `#__js_job_jobs` WHERE companyid = " . $companyid . ") 
                    + ( SELECT COUNT(id) FROM `#__js_job_departments` WHERE companyid = " . $companyid . ")
                    AS total ";
        $db->setQuery($query);
        $total = $db->loadResult();
        if ($total > 0)
            return false;
        else
            return true;
    }

    function companyEnforceDelete($companyid, $uid) {
        if (is_numeric($companyid) == false)
            return false;
        $db = $this->getDBO();
        $servercompanyid = 0;
        if ($this->_client_auth_key != "") {
            $query = "SELECT company.serverid AS serverid FROM `#__js_job_companies` AS company  WHERE company.id = " . $companyid;
            $db->setQuery($query);
            $c_s_id = $db->loadResult();
            if ($c_s_id)
                $servercompanyid = $c_s_id;
        }
        $query = "DELETE  company,job,department,companycity,userfielddata
						 FROM `#__js_job_companies` AS company
						 LEFT JOIN `#__js_job_companycities` AS companycity ON company.id=companycity.companyid
						 LEFT JOIN `#__js_job_jobs` AS job ON company.id=job.companyid
						 LEFT JOIN `#__js_job_departments` AS department ON company.id=department.companyid
						 LEFT JOIN `#__js_job_userfield_data` AS userfielddata ON company.id=userfielddata.referenceid
						 WHERE company.id = " . $companyid;
        //echo '<br> SQL '.$query;
        $db->setQuery($query);
        if (!$db->query()) {
            return 2; //error while delete company
        }
        $this->getJSModel('customfield')->deleteUserFieldData($companyid);
        if ($servercompanyid != 0) {
            $data = array();
            $data['id'] = $servercompanyid;
            $data['referenceid'] = $cid;
            $data['uid'] = $this->_uid;
            $data['authkey'] = $this->_client_auth_key;
            $data['siteurl'] = $this->_siteurl;
            $data['task'] = 'deletecompany';
            $data['enforcedeletecompany'] = 1;
            $jsjobsharingobject = $this->getJSModel('jobsharing');
            $return_value = $jsjobsharingobject->deleteCompanySharing($data);
            $jsjobslogobject= $this->getJSModel('log');
            $jsjobslogobject->logDeleteCompanySharingEnforce($return_value);
        }
        return 1;
    }


    function getCompany($title) {
        $db = JFactory::getDBO();
        $query = "SELECT id, name FROM `#__js_job_companies` WHERE status = 1 ORDER BY id ASC ";
        $db->setQuery($query);
        $rows = $db->loadObjectList();
        if ($db->getErrorNum()) {
            echo $db->stderr();
            return false;
        }
        $companies = array();
        if ($title)
            $companies[] = array('value' => '', 'text' => $title);

        foreach ($rows as $row) {
            $companies[] = array('value' => $row->id, 'text' => $row->name);
        }
        return $companies;
    }

    function uploadFile($id, $action, $isdeletefile) {
        $db = JFactory::getDBO();
        $row = $this->getTable('company');
        $str = JPATH_BASE;
        $base = substr($str, 0, strlen($str) - 14); //remove administrator
        if (!isset($this->_config))
            $this->_config = $this->getJSModel('configuration')->getConfig();
        foreach ($this->_config as $conf) {
            if ($conf->configname == 'data_directory')
                $datadirectory = $conf->configvalue;
            if ($conf->configname == 'image_file_type')
                $image_file_types = $conf->configvalue;
        }
        $path = $base . '/' . $datadirectory;
        if (!file_exists($path)) { // create user directory
            $this->getJSModel('common')->makeDir($path);
        }
        $isupload = false;
        $path = $path . '/data';
        if (!file_exists($path)) { // create user directory
            $this->getJSModel('common')->makeDir($path);
        }
        $path = $path . '/employer';
        if (!file_exists($path)) { // create user directory
            $this->getJSModel('common')->makeDir($path);
        }

        $isupload = false;
        if ($action == 1) { //Company logo
            if ($_FILES['logo']['size'] > 0) {
                $file_name = $_FILES['logo']['name']; // file name
                $file_tmp = $_FILES['logo']['tmp_name']; // actual location

                if ($file_name != '' AND $file_tmp != "") {
                    $check_image_extension = $this->getJSModel('common')->checkImageFileExtensions($file_name, $file_tmp, $image_file_types);
                    if ($check_image_extension == 6) {
                        $row->load($id);
                        $row->logofilename = "";
                        $row->logoisfile = -1;
                        if (!$row->store()) {
                            $this->setError($this->_db->getErrorMsg());
                        }
                        return $check_image_extension;
                    } else {
                        $row->load($id);
                        $row->logofilename = $file_name;
                        $row->logoisfile = 1;
                        if (!$row->store()) {
                            $this->setError($this->_db->getErrorMsg());
                        }
                    }
                    $userpath = $path . '/comp_' . $id;
                    if (!file_exists($userpath)) { // create user directory
                        $this->getJSModel('common')->makeDir($userpath);
                    }
                    $userpath = $userpath . '/logo';
                    if (!file_exists($userpath)) { // create logo directory
                        $this->getJSModel('common')->makeDir($userpath);
                    }
                    $isupload = true;
                }
            }
        } elseif ($action == 2) { //Company small logo
            if ($_FILES['smalllogo']['size'] > 0) {
                $file_name = $_FILES['smalllogo']['name']; // file name
                $file_tmp = $_FILES['smalllogo']['tmp_name']; // actual location

                if ($file_name != '' AND $file_tmp != "") {
                    $check_image_extension = $this->getJSModel('common')->checkImageFileExtensions($file_name, $file_tmp, $image_file_types);
                    if ($check_image_extension == 6) {
                        $row->load($id);
                        $row->smalllogofilename = "";
                        $row->smalllogoisfile = -1;
                        if (!$row->store()) {
                            $this->setError($this->_db->getErrorMsg());
                        }
                        return $check_image_extension;
                    } else {
                        $row->load($id);
                        $row->smalllogofilename = $file_name;
                        $row->smalllogoisfile = 1;
                        if (!$row->store()) {
                            $this->setError($this->_db->getErrorMsg());
                        }
                    }

                    $userpath = $path . '/comp_' . $id;
                    if (!file_exists($userpath)) { // create user directory
                        $this->getJSModel('common')->makeDir($userpath);
                    }
                    $userpath = $userpath . '/smalllogo';
                    if (!file_exists($userpath)) { // create logo directory
                        $this->getJSModel('common')->makeDir($userpath);
                    }
                    $isupload = true;
                }
            }
        } elseif ($action == 3) { //About Company
            if ($_FILES['aboutcompany']['size'] > 0) {
                $file_name = $_FILES['aboutcompany']['name']; // file name
                $file_tmp = $_FILES['aboutcompany']['tmp_name']; // actual location

                if ($file_name != '' AND $file_tmp != "") {
                    $check_image_extension = $this->getJSModel('common')->checkImageFileExtensions($file_name, $file_tmp, $image_file_types);
                    if ($check_image_extension == 6) {
                        $row->load($id);
                        $row->aboutcompanyfilename = "";
                        $row->aboutcompanyisfile = -1;
                        if (!$row->store()) {
                            $this->setError($this->_db->getErrorMsg());
                        }
                        return $check_image_extension;
                    } else {
                        $row->load($id);
                        $row->aboutcompanyfilename = $file_name;
                        $row->aboutcompanyisfile = 1;
                        if (!$row->store()) {
                            $this->setError($this->_db->getErrorMsg());
                        }
                    }

                    $userpath = $path . '/comp_' . $id;
                    if (!file_exists($userpath)) { // create user directory
                        $this->getJSModel('common')->makeDir($userpath);
                    }
                    $userpath = $userpath . '/aboutcompany';
                    if (!file_exists($userpath)) { // create logo directory
                        $this->getJSModel('common')->makeDir($userpath);
                    }
                    $isupload = true;
                }
            }
        }

        if ($isupload) {
            $files = glob($userpath . '/*.*');
            array_map('unlink', $files);  //delete all file in directory

            move_uploaded_file($file_tmp, $userpath . '/' . $file_name);
            return $userpath . '/' . $file_name;
            return 1;
        } else { // DELETE FILES
            if ($action == 1) { // company logo
                if ($isdeletefile == 1) {
                    $userpath = $path . '/comp_' . $id . '/logo';
                    $files = glob($userpath . '/*.*');
                    array_map('unlink', $files); // delete all file in the direcoty 
                    $row->load($id);
                    $row->logofilename = "";
                    $row->logoisfile = -1;
                    if (!$row->store()) {
                        $this->setError($this->_db->getErrorMsg());
                    }
                }
            } elseif ($action == 2) { // company small logo
                if ($isdeletefile == 1) {
                    $userpath = $path . '/comp_' . $id . '/smalllogo';
                    $files = glob($userpath . '/*.*');
                    array_map('unlink', $files); // delete all file in the direcoty 
                    $row->load($id);
                    $row->smalllogofilename = "";
                    $row->smalllogoisfile = -1;
                    if (!$row->store()) {
                        $this->setError($this->_db->getErrorMsg());
                    }
                }
            } elseif ($action == 3) { // about company 
                if ($isdeletefile == 1) {
                    $userpath = $path . '/comp_' . $id . '/aboutcompany';
                    $files = glob($userpath . '/*.*');
                    array_map('unlink', $files); // delete all file in the direcoty 
                    $row->load($id);
                    $row->aboutcompanyfilename = "";
                    $row->aboutcompanyisfile = -1;
                    if (!$row->store()) {
                        $this->setError($this->_db->getErrorMsg());
                    }
                }
            }
            return 1;
        }
    }

    function companyApprove($company_id) {
        if (is_numeric($company_id) == false)
            return false;
        $db = JFactory::getDBO();

        $query = "UPDATE #__js_job_companies SET status = 1 WHERE id = " . $company_id;
        $db->setQuery($query);
        if (!$db->query())
            return false;
        $company_approve_email = $this->getJSModel('emailtemplate')->sendMail(1, 1, $company_id);
        if ($this->_client_auth_key != "") {
            $data_company_approve = array();
            $query = "SELECT serverid FROM #__js_job_companies WHERE id = " . $company_id;
            $db->setQuery($query);
            $servercompanyid = $db->loadResult();
            $data_company_approve['id'] = $servercompanyid;
            $data_company_approve['company_id'] = $company_id;
            $data_company_approve['authkey'] = $this->_client_auth_key;
            $fortask = "companyapprove";
            $server_json_data_array = json_encode($data_company_approve);
            $jsjobsharingobject = $this->getJSModel('jobsharing');
            $return_server_value = $jsjobsharingobject->serverTask($server_json_data_array, $fortask);
            $return_value = json_decode($return_server_value, true);
            $jsjobslogobject= $this->getJSModel('log');
            $jsjobslogobject->logCompanyApprove($return_value);
        }
        return true;
    }

    function companyReject($company_id) {
        if (is_numeric($company_id) == false)
            return false;
        $db = JFactory::getDBO();

        $query = "UPDATE #__js_job_companies SET status = -1 WHERE id = " . $company_id;
        $db->setQuery($query);
        if (!$db->query()) {
            return false;
        }
        $company_reject_email = $this->getJSModel('emailtemplate')->sendMail(1, -1, $company_id);
        if ($this->_client_auth_key != "") {
            $data_company_reject = array();
            $query = "SELECT serverid FROM #__js_job_companies WHERE id = " . $company_id;
            $db->setQuery($query);
            $servercompanyid = $db->loadResult();
            $data_company_reject['id'] = $servercompanyid;
            $data_company_reject['company_id'] = $company_id;
            $data_company_reject['authkey'] = $this->_client_auth_key;
            $fortask = "companyreject";
            $server_json_data_array = json_encode($data_company_reject);
            $jsjobsharingobject = $this->getJSModel('jobsharing');
            $return_server_value = $jsjobsharingobject->serverTask($server_json_data_array, $fortask);
            $return_value = json_decode($return_server_value, true);
            $jsjobslogobject = $this->getJSModel('log');
            $jsjobslogobject->logCompanyReject($return_value);
        }
        return true;
    }

    function getCompanies($uid) {
        if ($uid)
            if ((is_numeric($uid) == false) || ($uid == 0) || ($uid == ''))
                return false;
        $db = JFactory::getDBO();
        $query = "SELECT id, name FROM `#__js_job_companies` WHERE status = 1 ORDER BY name ASC ";
        $db->setQuery($query);
        $rows = $db->loadObjectList();
        if ($db->getErrorNum()) {
            echo $db->stderr();
            return false;
        }
        $companies = array();
        if (!empty($rows)) {
            foreach ($rows as $row) {
                $companies[] = array('value' => $row->id, 'text' => $row->name);
            }
        } else {
            $companies[] = array('value' => '', 'text' => '');
        }
        return $companies;
    }

    function getCompaniesbyJobId($jobid) {
        if (is_numeric($jobid) == false)
            return false;
        $db = JFactory::getDBO();
        $query = "SELECT company.id, company.name
                FROM `#__js_job_companies` AS company
                JOIN `#__js_job_jobs` AS job ON company.uid = job.uid
                WHERE job.id = " . $jobid . " ORDER BY name ASC ";
        $db->setQuery($query);
        $rows = $db->loadObjectList();
        if ($db->getErrorNum()) {
            echo $db->stderr();
            return false;
        }
        $companies = array();
        foreach ($rows as $row) {
            $companies[] = array('value' => JText::_($row->id),
                'text' => JText::_($row->name));
        }
        return $companies;
    }

}

?>