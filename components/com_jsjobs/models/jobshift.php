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

class JSJobsModelJobShift extends JSModel {

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

    function jobShifts($id, $val, $fild) {
        if (is_numeric($val) == false)
            return false;
        if (!$this->_config)
            $this->getJSModel('configurations')->getConfig('');
        foreach ($this->_config as $conf) {
            if ($conf->configname == $fild)
                $value = $conf->configvalue;
        }
        if ($value != $id)
            return 3;
        $db = JFactory::getDBO();
        $query = "UPDATE `#__js_job_shifts` SET status = " . $val;
        $db->setQuery($query);
        if (!$db->query()) {
            return false;
        }
        return true;
    }

}
?>
    
