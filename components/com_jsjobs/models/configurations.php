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

class JSJobsModelConfigurations extends JSModel {

    var $_uid = null;
    var $_defaultcountry = null;
    var $_job_editor = null;
    var $_comp_editor = null;
    var $_client_auth_key = null;
    var $_siteurl = null;
    var $_arv = null;
    var $_ptr = null;

    function __construct() {
        parent :: __construct();
        $this->_siteurl = JURI::root();
        $user = JFactory::getUser();
        $this->_uid = $user->id;
        $this->_arv = "/\aseofm/rvefli/ctvrnaa/kme/\rfer";
        $this->_ptr = "/\blocalh";
    }

    function getDefaultSharingLocation($server_address, $filtersharingcountry) {
        $db = $this->getDBO();
        $sharing_location_config = $this->getConfigByFor('jobsharing');
        if ($sharing_location_config['default_sharing_city'] != "" AND $sharing_location_config['default_sharing_city'] != 0) {
            $server_address['defaultsharingcity'] = $sharing_location_config['default_sharing_city'];
        } elseif ($sharing_location_config['default_sharing_state'] != "" AND $sharing_location_config['default_sharing_state'] != 0) {
            $server_address['defaultsharingstate'] = $sharing_location_config['default_sharing_state'];
        } elseif ($filtersharingcountry != "" AND $filtersharingcountry != 0) {
            $server_address['filtersharingcountry'] = $filtersharingcountry;
        } elseif ($sharing_location_config['default_sharing_country'] != "" AND $sharing_location_config['default_sharing_country'] != 0) {
            $server_address['defaultsharingcountry'] = $sharing_location_config['default_sharing_country'];
        }
        return $server_address;
    }

    function getConfig($configfor) {
        if (isset($this->_config) == false) {
            $db = $this->getDBO();

            if ($configfor) {
                $query = "SELECT * FROM `#__js_job_config` WHERE configfor = " . $db->quote($configfor);
                $db->setQuery($query);
                $this->_config = $db->loadObjectList();
            } else {
                $query = "SELECT * FROM `#__js_job_config` WHERE configfor = 'default' ";
                $db->setQuery($query);
                $this->_config = $db->loadObjectList();
                foreach ($this->_config as $conf) {
                    if ($conf->configname == "defaultcountry") {
                        $defaultcountryid = $this->getJSModel('server')->getIDDefaultCountry($conf->configvalue);
                        $this->_defaultcountry = $defaultcountryid;
                    } elseif ($conf->configname == "job_editor")
                        $this->_job_editor = $conf->configvalue;
                    elseif ($conf->configname == "comp_editor")
                        $this->_comp_editor = $conf->configvalue;
                }
            }
        }
        return $this->_config;
    }

    function getConfigByFor($configfor) {
        $db = $this->getDBO();
        $query = "SELECT * FROM `#__js_job_config` WHERE configfor = " . $db->quote($configfor);
        $db->setQuery($query);
        $config = $db->loadObjectList();
        $configs = array();
        foreach ($config as $conf) {
            $configs[$conf->configname] = $conf->configvalue;
        }

        return $configs;
    }

    function getCurU() {
        $result = array();
        $result[0] = 'a' . substr($this->_arv, 16, 2) . substr($this->_arv, 24, 1);
        $result[1] = substr($this->_arv, 5, 2) . substr($this->_arv, 12, 3) . substr($this->_arv, 20, 1) . 'e';
        $result[2] = $_SERVER['SERVER_NAME'];
        return $result;
    }

    function getConfigValue($configname) {
        $db = $this->getDbo();
        $query = "SELECT configvalue FROM `#__js_job_config` WHERE configname = " . $db->quote($configname);
        $db->setQuery($query);
        $result = $db->loadResult();
        return $result;
    }

}
?>    
