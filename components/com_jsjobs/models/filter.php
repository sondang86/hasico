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

class JSJobsModelFilter extends JSModel {

    var $_client_auth_key = null;
    var $_siteurl = null;

    function __construct() {
        parent :: __construct();
        $this->_client_auth_key = $this->getJSModel('common')->getClientAuthenticationKey();
        $this->_siteurl = JURI::root();
        $user = JFactory::getUser();
        $this->_uid = $user->id;
    }

    function getUserFilter($u_id) {
        if ($u_id)
            if ((is_numeric($u_id) == false) || ($u_id == 0) || ($u_id == ''))
                return false;
        $db = $this->getDBO();

        $query = "SELECT filter.* FROM `#__js_job_filters` AS filter WHERE filter.uid  = " . $u_id;
        $db->setQuery($query);
        $userfields = $db->loadObject();
        return $userfields;
    }

    function deleteUserFilter() {
        $row = $this->getTable('filter');
        $data = JRequest :: get('post');

        if (!$row->delete($data['id'])) {
            $this->setError($row->getErrorMsg());
            return false;
        }

        return true;
    }

    public function storeFilter() {
        global $resumedata;
        $user = JFactory::getUser();
        $row = $this->getTable('filter');
        $data = JRequest :: get('post');

        $data['uid'] = $user->id;
        $data['status'] = 1;
        if (!$row->bind($data)) {
            $this->setError($this->_db->getErrorMsg());
            return false;
        }
        if ($data['txtfilter_country'] == 'Country')
            $data['txtfilter_country'] = '';
        if ($data['txtfilter_state'] == 'State')
            $data['txtfilter_state'] = '';
        if ($data['txtfilter_county'] == 'County')
            $data['txtfilter_county'] = '';
        if ($data['txtfilter_city'] == 'City')
            $data['txtfilter_city'] = '';

        if ($data['cmbfilter_country'] != '') {
            $row->country = $data['cmbfilter_country'];
            $row->country_istext = 0;
        } elseif ($data['txtfilter_country'] != '') {
            $row->country = $data['txtfilter_country'];
            $row->country_istext = 1;
        }
        if ($data['cmbfilter_state'] != '') {
            $row->state = $data['cmbfilter_state'];
            $row->state_istext = 0;
        } elseif ($data['txtfilter_state'] != '') {
            $row->state = $data['txtfilter_state'];
            $row->state_istext = 1;
        }
        if ($data['cmbfilter_county'] != '') {
            $row->county = $data['cmbfilter_county'];
            $row->county_istext = 0;
        } elseif ($data['txtfilter_county'] != '') {
            $row->county = $data['txtfilter_county'];
            $row->county_istext = 1;
        }
        if ($data['cmbfilter_city'] != '') {
            $row->city = $data['cmbfilter_city'];
            $row->city_istext = 0;
        } elseif ($data['txtfilter_city'] != '') {
            $row->city = $data['txtfilter_city'];
            $row->city_istext = 1;
        }

        $row->category = $data['filter_jobcategory'];
        $row->jobtype = $data['filter_jobtype'];
        $row->salaryrange = $data['filter_jobsalaryrange'];
        $row->heighesteducation = $data['filter_heighesteducation'];

        if (!$row->store()) {
            $this->setError($this->_db->getErrorMsg());
            echo $this->_db->getErrorMsg();
            return false;
        }
        return true;
    }

}
?>


