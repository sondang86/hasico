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

class JSJobsViewJobstatus extends JSView{

    function display($tpl = null) {
        require_once JPATH_COMPONENT_ADMINISTRATOR . '/views/common.php';
//        layout start
        if ($layoutName == 'formjobstatus') {          // job status
            if (isset($_GET['cid'][0]))
                $c_id = $_GET['cid'][0];
            else
                $c_id = '';

            if ($c_id == '') {
                $cids = JRequest :: getVar('cid', array(0), 'post', 'array');
                $c_id = $cids[0];
            }
            if (is_numeric($c_id) == true AND $c_id != 0)
                $application = $this->getJSModel('jobstatus')->getJobStatusbyId($c_id);
            if (isset($application->id))
                $isNew = false;
            $text = $isNew ? JText :: _('ADD') : JText :: _('EDIT');
            JToolBarHelper :: title(JText :: _('JS_JOB_STATUS') . ': <small><small>[ ' . $text . ' ]</small></small>');
            JToolBarHelper::apply('jobstatus.savejobstatussave', 'SAVE');
            JToolBarHelper :: save2new('jobstatus.savejobstatusandnew');
            JToolBarHelper :: save('jobstatus.savejobstatus');
            if ($isNew)
                JToolBarHelper :: cancel('jobstatus.cancel');
            else
                JToolBarHelper :: cancel('jobstatus.cancel', 'Close');
        }elseif ($layoutName == 'jobstatus') {        //job status
            JToolBarHelper :: title(JText::_('JS_JOB_STATUS'));
            JToolBarHelper :: addNew('jobstatus.edijobstatus');
            JToolBarHelper :: editList('jobstatus.edijobstatus');
            JToolBarHelper :: deleteList(JText::_('JS_ARE_YOU_SURE'),'jobstatus.remove');
            $result = $this->getJSModel('jobstatus')->getAllJobStatus($limitstart, $limit);
            $items = $result[0];
            $total = $result[1];
            if ($total <= $limitstart)
                $limitstart = 0;
            $pagination = new JPagination($total, $limitstart, $limit);
            $this->assignRef('pagination', $pagination);
        }
//        layout end

        $this->assignRef('config', $config);
        $this->assignRef('application', $application);
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
