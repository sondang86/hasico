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

class JSJobsViewAge extends JSView{

    function display($tpl = null) {
        require_once JPATH_COMPONENT_ADMINISTRATOR.'/views/common.php';
//        layout statr
        if ($layoutName == 'ages') {        //job types
            JToolBarHelper :: title(JText::_('JS_JOB_AGES'));
            JToolBarHelper :: addNew('age.editjobage');
            JToolBarHelper :: editList('age.editjobage');
            JToolBarHelper :: deleteList(JText::_('JS_ARE_YOU_SURE'),'age.remove');
            $result = $this->getJSModel('age')->getAllAges($limitstart, $limit);
            $items = $result[0];
            $total = $result[1];
            if ($total <= $limitstart)
                $limitstart = 0;
            $pagination = new JPagination($total, $limitstart, $limit);
            $this->assignRef('pagination', $pagination);
        }elseif ($layoutName == 'formages') {          // jobtypes
            if (isset($_GET['cid'][0]))
                $c_id = $_GET['cid'][0];
            else
                $c_id = '';

            if ($c_id == '') {
                $cids = JRequest :: getVar('cid', array(0), 'post', 'array');
                $c_id = $cids[0];
            }
            if (is_numeric($c_id) == true AND $c_id != 0)
                $application = $this->getJSModel('age')->getJobAgesbyId($c_id);
            if (isset($application->id))
                $isNew = false;
            $text = $isNew ? JText :: _('ADD') : JText :: _('EDIT');
            JToolBarHelper :: title(JText :: _('JS_JOB_AGES') . ': <small><small>[ ' . $text . ' ]</small></small>');
            JToolBarHelper::apply('age.savejobagesave', 'SAVE');
            JToolBarHelper :: save2new('age.savejobageandnew');
            JToolBarHelper :: save('age.savejobage');
            if ($isNew)
                JToolBarHelper :: cancel('age.cancel');
            else
                JToolBarHelper :: cancel('age.cancel', 'Close');
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
