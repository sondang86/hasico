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

class JSJobsViewJobsharing extends JSView{

    function display($tpl = null) {
        require_once JPATH_COMPONENT_ADMINISTRATOR . '/views/common.php';
//        layout start
        if ($layoutName == 'jobshare') {        //resume search
            JToolBarHelper :: title(JText::_('JS_JOB_SHARING_SERVICE'));
            $session = JFactory::getSession();
            $synchronizedata = $session->get('synchronizedatamessage');
            $session->clear('synchronizedatamessage');
            $empty = 'empty';
            $this->assignRef('result', $empty);
            if ($synchronizedata != "") {
                $this->assignRef('result', $synchronizedata);
            }
        } elseif ($layoutName == 'jobsharelog') {        //resume search
            JToolBarHelper :: title(JText::_('JS_JOB_SHARE_LOG'));
            $searchuid = $mainframe->getUserStateFromRequest($option . 'searchuid', 'searchuid', '', 'string');
            $searchusername = $mainframe->getUserStateFromRequest($option . 'searchusername', 'searchusername', '', 'string');
            $searchrefnumber = $mainframe->getUserStateFromRequest($option . 'searchrefnumber', 'searchrefnumber', '', 'string');
            $searchstartdate = $mainframe->getUserStateFromRequest($option . 'searchstartdate', 'searchstartdate', '', 'string');
            $searchenddate = $mainframe->getUserStateFromRequest($option . 'searchenddate', 'searchenddate', '', 'string');

            $result = $this->getJSModel('sharingservicelog')->getAllSharingServiceLog($searchuid, $searchusername, $searchrefnumber, $searchstartdate, $searchenddate, $limitstart, $limit);
            $this->assignRef('servicelog', $result[0]);
            $this->assignRef('lists', $result[2]);
            $total = $result[1];
            if ($total <= $limitstart)
                $limitstart = 0;
            $pagination = new JPagination($total, $limitstart, $limit);
            $this->assignRef('pagination', $pagination);
        }
//        layout end

        $this->assignRef('config', $config);
        $this->assignRef('application', $application);
        $this->assignRef('theme', $theme);
        $this->assignRef('option', $option);
        $this->assignRef('uid', $uid);
        $this->assignRef('msg', $msg);
        $this->assignRef('isjobsharing', $_client_auth_key);

        parent :: display($tpl);
    }

}

?>
