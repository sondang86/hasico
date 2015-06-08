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

class JSJobsViewFieldordering extends JSView{

    function display($tpl = null) {
        require_once JPATH_COMPONENT_ADMINISTRATOR . '/views/common.php';
//        layout start
        if ($layoutName == 'fieldsordering') {          // field ordering
            $fieldfor = JRequest::getVar('ff', 0);
            $session = JFactory::getSession();
            $session->set('fieldfor', $fieldfor);
            $fieldfor = $session->get('fieldfor');

            JToolBarHelper :: publishlist('fieldordering.fieldpublished');
            JToolBarHelper :: unpublishlist('fieldordering.fieldunpublished');
            JToolBarHelper::custom('fieldordering.visitorfieldpublished', 'visitorpublishedbutton', '', 'Visitor Publish', true);
            JToolBarHelper::custom('fieldordering.visitorfieldunpublished', 'visitorunpublishedbutton', '', 'Visitor Unpublish', true);
            JToolBarHelper::custom('fieldordering.fieldrequired', 'required', '', 'Required', true);
            JToolBarHelper::custom('fieldordering.fieldnotrequired', 'notrequired', '', 'Not Required', true);

            if ($fieldfor)
                $_SESSION['fford'] = $fieldfor;
            else
                $fieldfor = $_SESSION['fford'];

            if ($fieldfor == 11 || $fieldfor == 12 || $fieldfor == 13)
                JToolBarHelper :: title(JText::_('JS_VISITOR_FIELDS'));
            else
                JToolBarHelper :: title(JText::_('JS_FIELDS'));

            $result = $this->getJSModel('fieldordering')->getFieldsOrdering($fieldfor, $limitstart, $limit); // 1 for company
            $items = $result[0];
            $total = $result[1];
            if ($total <= $limitstart)
                $limitstart = 0;
            $pagination = new JPagination($total, $limitstart, $limit);
            $this->assignRef('pagination', $pagination);
        }
//        layout end

        $this->assignRef('config', $config);
        $this->assignRef('ff', $fieldfor);
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
