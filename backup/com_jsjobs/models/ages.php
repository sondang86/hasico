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

class JSJobsModelAges extends JSModel {

    var $_uid = null;
    var $_ages = null;
    var $_client_auth_key = null;
    var $_siteurl = null;

    function __construct() { // clean it.
        parent :: __construct();
        $this->_client_auth_key= $this->getJSModel('common')->getClientAuthenticationKey();
        $this->_siteurl = JURI::root();
        $user = JFactory::getUser();
        $this->_uid = $user->id;
    }

    function getAges($title) {
        if (!$this->_ages) {// make problem with age from, age to
            $db = JFactory::getDBO();
            $query = "SELECT id, title FROM `#__js_job_ages` WHERE status = 1";
            if ($this->_client_auth_key != "")
                $query.=" AND serverid != '' AND serverid != 0";
            $query.=" ORDER BY ordering ASC ";
            $db->setQuery($query);
            $rows = $db->loadObjectList();
            if ($db->getErrorNum()) {
                echo $db->stderr();
                return false;
            }
            $this->_ages = $rows;
        }
        $ages = array();
        if ($title)
            $ages[] = array('value' => JText::_(''), 'text' => $title);
        foreach ($this->_ages as $row) {
            $ages[] = array('value' => $row->id, 'text' => JText::_($row->title));
        }
        return $ages;
    }

}
?>	
