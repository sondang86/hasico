<?php
/**
 * @Copyright Copyright (C) 2009-2014
 * @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
  + Created by:          Ahmad Bilal
 * Company:     Buruj Solutions
  + Contact:        www.burujsolutions.com , ahmad@burujsolutions.com
 * Created on:  Jan 11, 2009
  ^
  + Project:        JS Jobs
 * File Name:   models/jsjobs.php
  ^
 * Description: Model class for jsjobs data
  ^
 * History:     NONE
  ^
 */

defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.model');
jimport('joomla.html.html');
$option = JRequest :: getVar('option', 'com_jsjobs');

class JSJobsModelCategory extends JSModel {

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

    function getCategories($title) {
        $db = JFactory::getDBO();
        $query = "SELECT id,cat_title FROM `#__js_job_categories` WHERE isactive = 1";
        if ($this->_client_auth_key != "")
            $query.=" AND serverid!='' AND serverid!=0";
        $query.=" ORDER BY ordering ";
        $db->setQuery($query);
        $rows = $db->loadObjectList();
        if ($db->getErrorNum()) {
            echo $db->stderr();
            return false;
        }
        $jobcategories = array();
        if ($title)
            $jobcategories[] = array('value' => JText::_(''), 'text' => $title);

        foreach ($rows as $row) {
            $jobcategories[] = array('value' => $row->id, 'text' => JText::_($row->cat_title));
        }
        return $jobcategories;
    }

    function getJobCategories($theme) {
        $db = JFactory::getDBO();
        $dateformat = $this->getJSModel('configurations')->getConfigValue('date_format');
        $this->getJSModel('common')->setTheme();
        if ($this->_client_auth_key != "") {
            $alias = ", CONCAT(cat.alias,'-',cat.serverid) AS aliasid,";
        } else {
            $alias = ", CONCAT(cat.alias,'-',cat.id) AS aliasid,";
        }
        $curdate = date('Y-m-d');
        $inquery = " (SELECT COUNT(jobs.id) from `#__js_job_jobs` AS jobs 
                        WHERE cat.id = jobs.jobcategory AND jobs.status = 1 
                        AND DATE(jobs.startpublishing) <= " . $db->Quote($curdate) . " AND DATE(jobs.stoppublishing) >= " . $db->Quote($curdate) . " ) as catinjobs";
        $query = "SELECT  DISTINCT cat.id, cat.cat_title $alias";
        $query .= $inquery;
        $query .= " FROM `#__js_job_categories` AS cat 
                    LEFT JOIN `#__js_job_jobs` AS job ON cat.id = job.jobcategory                                                                                                                                                                                                                                                                                                                                                                                    
                    WHERE cat.isactive = 1 ";
        $query .= " ORDER BY cat.cat_title ";
        $db->setQuery($query);
        $result[0] = $db->loadObjectList();
        $result[2] = $dateformat;
        return $result;
    }
    function listSubCategoriesForSearch($val) {
        if (!is_numeric($val)) {
            $rv = false;
            return $rv;
        }
        $db = $this->getDBO();
        $query = "SELECT id, title FROM `#__js_job_subcategories`  WHERE status = 1 AND categoryid = " . $val . " ORDER BY ordering ASC";
        $db->setQuery($query);
        $result = $db->loadObjectList();

        if (isset($result)) {
            $return_value = "<select name='jobsubcategory' class='inputbox jsjobs-cbo' >\n";
            $return_value .= "<option value='' >" . JText::_('JS_SUB_CATEGORY') . "</option> \n";
            foreach ($result as $row) {
                $return_value .= "<option value=\"$row->id\" >$row->title</option> \n";
            }
            $return_value .= "</select>\n";
        }
        return $return_value;
    }

}
?>    
