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

class JSJobsViewSalaryrange extends JSView{

    function display($tpl = null) {
        require_once JPATH_COMPONENT_ADMINISTRATOR . '/views/common.php';
//        layout start
        if ($layoutName == 'formsalaryrange') {       // salary range
            if (isset($_GET['cid'][0]))
                $c_id = $_GET['cid'][0];
            else
                $c_id = '';
            if ($c_id == '') {
                $cids = JRequest :: getVar('cid', array(0), 'post', 'array');
                $c_id = $cids[0];
            }
            if (is_numeric($c_id) == true AND $c_id != 0)
                $application = $this->getJSModel('salaryrange')->getSalaryRangebyId($c_id);
            // get configurations
            $config = Array();
            $results = $this->getJSModel('configuration')->getConfig();
            if ($results) { //not empty
                foreach ($results as $result) {
                    $config[$result->configname] = $result->configvalue;
                }
            }
            $this->assignRef('config', $config);

            if (isset($application->id))
                $isNew = false;
            $text = $isNew ? JText :: _('ADD') : JText :: _('EDIT');
            JToolBarHelper :: title(JText :: _('JS_SALARY_RANGE') . ': <small><small>[ ' . $text . ' ]</small></small>');
            JToolBarHelper::apply('salaryrange.savejobsalaryrangesave', 'SAVE');
            JToolBarHelper :: save2new('salaryrange.savejobsalaryrangeandnew');
            JToolBarHelper :: save('salaryrange.savejobsalaryrange');
            if ($isNew)
                JToolBarHelper :: cancel('salaryrange.cancel');
            else
                JToolBarHelper :: cancel('salaryrange.cancel', 'Close');
        }elseif ($layoutName == 'salaryrange') {         // salary range
            JToolBarHelper :: title(JText::_('JS_SALARY_RANGE'));
            JToolBarHelper :: addNew('salaryrange.editjobsalaryrange');
            JToolBarHelper :: editList('salaryrange.editjobsalaryrange');
            JToolBarHelper :: deleteList(JText::_('JS_ARE_YOU_SURE'),'salaryrange.remove');
            $result = $this->getJSModel('salaryrange')->getAllSalaryRange($limitstart, $limit);
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
