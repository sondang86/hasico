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

class JSJobsModelCities extends JSModel {

    var $_uid = null;
    var $_client_auth_key = null;
    var $_siteurl = null; //A

    function __construct() {
        parent :: __construct();
        $this->_client_auth_key = $this->getJSModel('common')->getClientAuthenticationKey();
        $this->_siteurl = JURI::root();
        $user = JFactory::getUser();
        $this->_uid = $user->id;
    }

    function getCities($stateid, $title) {
        $db = JFactory::getDBO();
        if (empty($stateid))
            $stateid = 0;
        if (is_string($stateid))
            $stateid = $db->Quote($stateid);
        $query = "SELECT * FROM `#__js_job_cities` WHERE enabled = 'Y' AND stateid = " . $stateid;

        if ($this->_client_auth_key != "")
            $query.=" AND serverid!='' AND serverid!=0";
        $query.=" ORDER BY name ASC ";
        $db->setQuery($query);
        $rows = $db->loadObjectList();
        if ($db->getErrorNum()) {
            echo $db->stderr();
            return false;
        }
        $cities = array();
        if ($title)
            $cities[] = array('value' => JText::_(''), 'text' => $title);
        else
            $cities[] = array('value' => JText::_(''), 'text' => JText::_('JS_CHOOSE_CITY'));

        foreach ($rows as $row) {
            $cities[] = array('value' => $row->id, 'text' => JText::_($row->name));
        }
        return $cities;
    }

    function getJobsCity($showonlycityhavejobs = 0, $theme, $noofrecord = 20) {
        $db = JFactory::getDBO();
        $dateformat = $this->getJSModel('configurations')->getConfigValue('date_format');
        $this->getJSModel('common')->setTheme();
        $curdate = date('Y-m-d H:i:s');
        $havingquery = "";
        if ($showonlycityhavejobs == 1) {
            $havingquery = " HAVING totaljobsbycity > 0 ";
        }
        $cityid = "city.id AS cityid,";
        $query = "SELECT $cityid city.name AS cityname, COUNT(mcity.id) AS totaljobsbycity
                    FROM `#__js_job_cities` AS city
                    LEFT JOIN `#__js_job_countries` AS country ON country.id = city.countryid 
                    LEFT JOIN `#__js_job_jobcities` AS mcity ON mcity.cityid = city.id
                    LEFT JOIN `#__js_job_jobs` AS job ON job.id = mcity.jobid 
                    WHERE country.enabled = 1 AND job.status=1 AND job.stoppublishing >= CURDATE() 
                    GROUP BY cityid $havingquery ORDER BY totaljobsbycity DESC, cityname ASC";

        $db->setQuery($query, 0, $noofrecord);
        $result1 = $db->loadObjectList();

        $result[0] = $result1;
        $result[2] = $dateformat;
        return $result;
    }

    function getAddressDataByCityName($cityname, $id = 0) {
        $db = JFactory::getDbo();
        $config = $this->getJSModel('configurations')->getConfigByFor('default');
        $query = "SELECT concat(city.name";
        switch ($config['defaultaddressdisplaytype']) {
            case 'csc'://City, State, Country
                $query .= " ,', ', (IF(state.name is not null,state.name,'')),IF(state.name is not null,', ',''),country.name)";
                break;
            case 'cs'://City, State
                $query .= " ,', ', (IF(state.name is not null,state.name,'')))";
                break;
            case 'cc'://City, Country
                $query .= " ,', ', country.name)";
                break;
            case 'c'://city by default select for each case
                $query .= ")";
                break;
        }
        $query .= " AS name, city.id AS id
                          FROM `#__js_job_cities` AS city  
                          JOIN `#__js_job_countries` AS country on city.countryid=country.id
                          LEFT JOIN `#__js_job_states` AS state on city.stateid=state.id";
        if ($id == 0)
            $query .= " WHERE city.name LIKE " . $db->quote($cityname . '%') . " AND country.enabled = 1 AND city.enabled = 1 LIMIT ".$this->getJSModel('configurations')->getConfigValue("number_of_cities_for_autocomplete");
        else {
            $query .= " WHERE city.id = $id AND country.enabled = 1 AND city.enabled = 1";
        }
        $db->setQuery($query);

        $result = $db->loadObjectList();
        if (empty($result))
            return null;
        else
            return $result;
    }

}
?>    
