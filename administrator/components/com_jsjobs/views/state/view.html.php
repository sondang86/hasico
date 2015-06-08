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

class JSJobsViewState extends JSView{

    function display($tpl = null) {
        require_once JPATH_COMPONENT_ADMINISTRATOR . '/views/common.php';
//        layout start
        if ($layoutName == 'formstate') {          // states
            if (isset($_GET['cid'][0]))
                $c_id = $_GET['cid'][0];
            else
                $c_id = '';
            if ($c_id == '') {
                $cids = JRequest :: getVar('cid', array(0), 'post', 'array');
                $c_id = $cids[0];
            }
            //if (isset($_SESSION['js_countrycode'])) $countrycode = $_SESSION['js_countrycode']; else $countrycode=null;
            if (is_numeric($c_id) == true)
                $state = $this->getJSModel('state')->getStatebyId($c_id);
            if (isset($state->id))
                $isNew = false;
            $text = $isNew ? JText :: _('ADD') : JText :: _('EDIT');
            JToolBarHelper :: title(JText :: _('JS_STATE') . ': <small><small>[ ' . $text . ' ]</small></small>');
            $this->assignRef('state', $state);

            JToolBarHelper :: save('state.savestate');
            if ($isNew)
                JToolBarHelper :: cancel('state.cancel');
            else
                JToolBarHelper :: cancel('state.cancel', 'Close');
        } elseif ($layoutName == 'states') {          // states
            $countryid = JRequest::getVar('ct');
            $session = JFactory::getSession();
            if (!$countryid)
                $countryid = $session->set('countryid');
            $session->set('countryid', $countryid);
            JToolBarHelper :: title(JText::_('JS_STATES'));
            JToolBarHelper :: addNew('state.editjobstate');
            JToolBarHelper :: editList('state.editjobstate');
            JToolBarHelper :: deleteList(JText::_('JS_ARE_YOU_SURE'),'state.deletestate');

            $form = 'com_jsjobs.states.list.';
            $searchname = $mainframe->getUserStateFromRequest($form . 'searchname', 'searchname', '', 'string');

            $result = $this->getJSModel('state')->getAllCountryStates($searchname, $countryid, $limitstart, $limit);
            $items = $result[0];
            $total = $result[1];
            if (isset($result[2]))
                $this->assignRef('lists', $result[2]);
            $this->assignRef('ct', $countryid);
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
