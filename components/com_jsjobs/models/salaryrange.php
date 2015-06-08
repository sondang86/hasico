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

class JSJobsModelSalaryRange extends JSModel {

    var $_uid = null;
    var $_client_auth_key = null;
    var $_siteurl = null;
    var $_jobsalaryrange = null;

    function __construct() {
        parent :: __construct();
        $this->_client_auth_key = $this->getJSModel('common')->getClientAuthenticationKey();
        $this->_siteurl = JURI::root();
        $user = JFactory::getUser();
        $this->_uid = $user->id;
    }

    function getJobSalaryRange($title, $jobdata) {
        $db = JFactory::getDBO();
        if (!$this->_jobsalaryrange) {
            $query = "SELECT id, rangestart, rangeend FROM `#__js_job_salaryrange`";
            if ($this->_client_auth_key != "")
                $query.=" WHERE serverid!='' AND serverid!=0";
            $query.=" ORDER BY ordering ASC ";
            $db->setQuery($query);
            $rows = $db->loadObjectList();
            if ($db->getErrorNum()) {
                echo $db->stderr();
                return false;
            }
            $this->_jobsalaryrange = $rows;
        }
        $jobsalaryrange = array();
        if ($title)
            $jobsalaryrange[] = array('value' => JText::_(''), 'text' => $title);

        foreach ($this->_jobsalaryrange as $row) {
            if ($jobdata == 1)
                $salrange = $row->rangestart; //.' - '.$currency . $row->rangeend;
            else
                $salrange = $row->rangestart . ' - ' . $row->rangeend;
            $jobsalaryrange[] = array('value' => $row->id, 'text' => $salrange);
        }
        return $jobsalaryrange;
    }

}
?>
    
