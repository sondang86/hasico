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

class JSJobsModelStates extends JSModel {

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

    function getJobsStates($showonlystatehavejobs = 0, $theme, $noofrecord = 20) {
        $db = JFactory::getDBO();
        $dateformat = $this->getJSModel('configurations')->getConfigValue('date_format');
        $this->getJSModel('common')->setTheme();
        $curdate = date('Y-m-d');
        $havingquery = "";
        if ($showonlystatehavejobs == 1) {
            $havingquery = " HAVING totaljobsbystate > 0 ";
        }
        $stateid = "state.id AS stateid,";
        $query = "SELECT $stateid state.name AS statename,COUNT(DISTINCT job.id) AS totaljobsbystate
					FROM `#__js_job_states` AS state
					LEFT JOIN `#__js_job_cities` AS city ON state.id = city.stateid 
					LEFT JOIN `#__js_job_countries` AS country ON country.id = city.countryid 
					LEFT JOIN `#__js_job_jobcities` AS mcity ON mcity.cityid = city.id
					LEFT JOIN `#__js_job_jobs` AS job ON (job.id = mcity.jobid AND job.status =1 AND job.stoppublishing>=CURDATE() )
					WHERE country.enabled = 1  
					GROUP BY stateid $havingquery ORDER BY totaljobsbystate DESC, cityname ASC";
        $db->setQuery($query, 0, $noofrecord);
        $result1 = $db->loadObjectList();

        $result[0] = $result1;
        $result[2] = $dateformat;
        return $result;
    }

    function getStates($countryid, $title) {
        $db = JFactory::getDBO();
        if (is_numeric($countryid) === false)
            return false;
        if (empty($countryid))
            $countryid = 0;
        $query = "SELECT * FROM `#__js_job_states` WHERE enabled = 'Y' AND countryid = " . $countryid;
        if ($this->_client_auth_key != "")
            $query.=" AND serverid!='' AND serverid!=0";
        $query.=" ORDER BY name ASC ";
        $db->setQuery($query);
        $rows = $db->loadObjectList();
        if ($db->getErrorNum()) {
            echo $db->stderr();
            return false;
        }
        $states = array();
        if ($title)
            $states[] = array('value' => JText::_(''), 'text' => $title);
        else
            $states[] = array('value' => JText::_(''), 'text' => JText::_('JS_CHOOSE_STATE'));

        foreach ($rows as $row) {
            $states[] = array('value' => $row->id,
                'text' => JText::_($row->name));
        }
        return $states;
    }

}
?>


