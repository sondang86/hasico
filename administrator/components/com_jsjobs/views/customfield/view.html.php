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

class JSJobsViewCustomfield extends JSView{

    function display($tpl = null) {
        require_once JPATH_COMPONENT_ADMINISTRATOR . '/views/common.php';
//        layout start
        if ($layoutName == 'formuserfield') {      // user fields
            if (isset($_GET['cid'][0]))
                $c_id = $_GET['cid'][0];
            else
                $c_id = '';
            if ($c_id == '') {
                $cids = JRequest :: getVar('cid', array(0), 'post', 'array');
                $c_id = $cids[0];
            }
            if (is_numeric($c_id) == true)
                $result = $this->getJSModel('customfield')->getUserFieldbyId($c_id);
            $fieldfor = JRequest::getVar('fieldfor');            
            if(empty($fieldfor)) $fieldfor = JRequest::getVar('ff');
            if ($fieldfor == 3)
                $section = $this->getJSModel('fieldordering')->getResumeSections($c_id);
            if (isset($section))
                $this->assignRef('resumesection', $section);
            $this->assignRef('userfield', $result[0]);
            $this->assignRef('fieldvalues', $result[1]);
            $this->assignRef('fieldfor', $fieldfor);
            if (isset($result[0]->id))
                $isNew = false;
            $text = $isNew ? JText :: _('ADD') : JText :: _('EDIT');
            JToolBarHelper :: save('customfield.saveuserfield');
            if ($isNew)
                JToolBarHelper :: cancel('customfield.cancel');
            else
                JToolBarHelper :: cancel('customfield.cancel', 'Close');
        }elseif ($layoutName == 'userfields') {          // user field
            $fieldfor = JRequest::getVar('ff');
            JToolBarHelper :: addNew('customfield.add');
            JToolBarHelper :: editList('customfield.add');
            JToolBarHelper :: deleteList(JText::_('JS_ARE_YOU_SURE'),'customfield.remove');
            JToolBarHelper :: cancel('customfield.cancel');

            if ($fieldfor == 11 || $fieldfor == 12 || $fieldfor == 13)
                JToolBarHelper :: title(JText::_('JS_VISITOR_USER_FIELDS'));
            else
                JToolBarHelper :: title(JText::_('JS_USER_FIELDS'));
            $result = $this->getJSModel('customfield')->getUserFields($fieldfor, $limitstart, $limit); // 1 for company
            $items = $result[0];
            $total = $result[1];
            if ($total <= $limitstart)
                $limitstart = 0;
            $pagination = new JPagination($total, $limitstart, $limit);
            $this->assignRef('fieldfor', $fieldfor);
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
