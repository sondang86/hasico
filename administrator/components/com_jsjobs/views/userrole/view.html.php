<?php

/**
 * @Copyright Copyright (C) 2009-2011 ... Ahmad Bilal
 * @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * Company:		Buruj Solutions
  + Contact:		www.burujsolutions.com , ahmad@burujsolutions.com
 * Created on:	Jan 11, 2009
  ^
  + Project: 		JS Jobs
 * File Name:	admin/views/application/view.html.php
  ^
 * Description: View class for single record in the admin
  ^
 * History:		NONE
 * 
 */
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');
jimport('joomla.html.pagination');

class JSJobsViewUserrole extends JSView{

    function display($tpl = null) {
        require_once JPATH_COMPONENT_ADMINISTRATOR . '/views/common.php';
//        layout start
        if ($layoutName == 'changerole') {       // users - change role
            if (isset($_GET['cid'][0]))
                $c_id = $_GET['cid'][0];
            else
                $c_id = '';

            if ($c_id == '') {
                $cids = JRequest :: getVar('cid', array(0), 'post', 'array');
                $c_id = $cids[0];
            }
            if (is_numeric($c_id) == true)
                $result = $this->getJSModel('userrole')->getChangeRolebyId($c_id);
            $this->assignRef('role', $result[0]);
            $this->assignRef('lists', $result[1]);
            JToolBarHelper :: title(JText :: _('JS_CHANGE_ROLE'));
            JToolBarHelper :: save('userrole.saveuserrole');
            if ($isNew)
                JToolBarHelper :: cancel('userrole.cancel');
            else
                JToolBarHelper :: cancel('userrole.cancel', 'Close');
        }elseif ($layoutName == 'users') {
            JToolBarHelper :: title(JText::_('USERS'));
            JToolBarHelper :: editList('userrole.edit');
            $form = 'com_jsjobs.users.list.';
            $searchname = $mainframe->getUserStateFromRequest($form . 'searchname', 'searchname', '', 'string');
            $searchusername = $mainframe->getUserStateFromRequest($form . 'searchusername', 'searchusername', '', 'string');
            $searchcompany = $mainframe->getUserStateFromRequest($form . 'searchcompany', 'searchcompany', '', 'string');
            $searchresume = $mainframe->getUserStateFromRequest($form . 'searchresume', 'searchresume', '', 'string');
            $searchrole = $mainframe->getUserStateFromRequest($form . 'searchrole', 'searchrole', '', 'string');
            $result = $this->getJSModel('user')->getAllUsers($searchname, $searchusername, $searchcompany, $searchresume, $searchrole, $limitstart, $limit);
            $items = $result[0];
            $total = $result[1];
            $lists = $result[2];
            if ($total <= $limitstart) $limitstart = 0;
            $pagination = new JPagination($total, $limitstart, $limit);
            $this->assignRef('lists', $lists);
        }
//        layout end

        $this->assignRef('config', $config);
        $this->assignRef('application', $application);
        $this->assignRef('pagination', $pagination);
        $this->assignRef('items', $items);
        $this->assignRef('theme', $theme);
        $this->assignRef('option', $option);
        $this->assignRef('uid', $uid);
        $this->assignRef('msg', $msg);
        $this->assignRef('isjobsharing', $_client_auth_key);

        parent :: display($tpl);
    }

}

?>
