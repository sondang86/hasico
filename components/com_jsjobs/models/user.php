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

class JSJobsModelUser extends JSModel {

    var $_uid = null;

    function __construct() {
        parent :: __construct();
        $user = JFactory::getUser();
        $this->_uid = $user->id;
    }
    
    function getUserPackageDetailByUid($uid){
        if(!is_numeric($uid)) return false;
        $userrole = $this->getJSModel('userrole')->getUserRoleByUid($uid);
        if($userrole == 1){ // employer
            
        }elseif($userrole == 2){ // job seeker
            
        }else{ // unknown user
            
        }
    }

}
?>
    
