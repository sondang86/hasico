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

class JSJobsViewCompany extends JSView{

    function display($tpl = null) {
        require_once JPATH_COMPONENT_ADMINISTRATOR . '/views/common.php';
//        layout start
        if ($layoutName == 'formcompany') {  // companies
            if (isset($_GET['cid'][0]))
                $c_id = $_GET['cid'][0];
            else
                $c_id = '';

            if ($c_id == '') {
                $cids = JRequest :: getVar('cid', array(0), 'post', 'array');
                $c_id = $cids[0];
            }
            if (is_numeric($c_id) == true)
                $result = $this->getJSModel('company')->getCompanybyId($c_id);
            $this->assignRef('company', $result[0]);
            $this->assignRef('lists', $result[1]);
            $this->assignRef('userfields', $result[2]);
            $this->assignRef('fieldsordering', $result[3]);
            if (isset($result[4]))
                $this->assignRef('multiselectedit', $result[4]);
            $this->assignRef('uid', $uid);
            if (isset($result[0]->id))
                $isNew = false;
            $text = $isNew ? JText :: _('ADD') : JText :: _('EDIT');
            JToolBarHelper :: title(JText :: _('JS_COMPANY') . ': <small><small>[ ' . $text . ' ]</small></small>');
            JToolBarHelper :: save('company.savecompany');
            if ($isNew)
                JToolBarHelper :: cancel('company.cancel');
            else
                JToolBarHelper :: cancel('company.cancel', 'Close');
        }elseif ($layoutName == 'formcompany') {  // companies
            if (isset($_GET['cid'][0]))
                $c_id = $_GET['cid'][0];
            else
                $c_id = '';

            if ($c_id == '') {
                $cids = JRequest :: getVar('cid', array(0), 'post', 'array');
                $c_id = $cids[0];
            }
            if (is_numeric($c_id) == true)
                $result = $this->getJSModel('company')->getCompanybyId($c_id);
            $this->assignRef('company', $result[0]);
            $this->assignRef('lists', $result[1]);
            $this->assignRef('userfields', $result[2]);
            $this->assignRef('fieldsordering', $result[3]);
            if (isset($result[4]))
                $this->assignRef('multiselectedit', $result[4]);
            $this->assignRef('uid', $uid);
            if (isset($result[0]->id))
                $isNew = false;
            $text = $isNew ? JText :: _('ADD') : JText :: _('EDIT');
            JToolBarHelper :: title(JText :: _('JS_COMPANY') . ': <small><small>[ ' . $text . ' ]</small></small>');
            JToolBarHelper :: save('company.savecompany');
            if ($isNew)
                JToolBarHelper :: cancel('company.cancel');
            else
                JToolBarHelper :: cancel('company.cancel', 'Close');
        }elseif ($layoutName == 'companies') {    //companies
            JToolBarHelper :: title(JText::_('JS_COMPANIES'));
            JToolBarHelper :: addNew('company.add');
            JToolBarHelper :: editList('company.edit');
            JToolBarHelper :: deleteList(JText::_('JS_ARE_YOU_SURE'), 'company.remove');
            JToolBarHelper :: cancel('company.cancel');
            $searchcompany = $mainframe->getUserStateFromRequest($option . 'searchcompany', 'searchcompany', '', 'string');
            $searchjobcategory = $mainframe->getUserStateFromRequest($option . 'searchjobcategory', 'searchjobcategory', '', 'string');
            $searchcountry = $mainframe->getUserStateFromRequest($option . 'searchcountry', 'searchcountry', '', 'string');

            $result = $this->getJSModel('company')->getAllCompanies($searchcompany, $searchjobcategory, $searchcountry, $limitstart, $limit);
            $items = $result[0];
            $total = $result[1];
            $lists = $result[2];
            if ($total <= $limitstart)
                $limitstart = 0;
            $pagination = new JPagination($total, $limitstart, $limit);
            $this->assignRef('pagination', $pagination);
            $this->assignRef('lists', $lists);
        }elseif ($layoutName == 'companiesqueue') {    //companies queue
            JToolBarHelper :: title(JText::_('JS_COMPANIES_QUEUE'));
            $searchcompany = $mainframe->getUserStateFromRequest($option . 'searchcompany', 'searchcompany', '', 'string');
            $searchjobcategory = $mainframe->getUserStateFromRequest($option . 'searchjobcategory', 'searchjobcategory', '', 'string');
            $searchcountry = $mainframe->getUserStateFromRequest($option . 'searchcountry', 'searchcountry', '', 'string');

            $result = $this->getJSModel('company')->getAllUnapprovedCompanies($searchcompany, $searchjobcategory, $searchcountry, $limitstart, $limit);
            $items = $result[0];
            $total = $result[1];
            $lists = $result[2];
            if ($total <= $limitstart)
                $limitstart = 0;
            $pagination = new JPagination($total, $limitstart, $limit);
            $this->assignRef('pagination', $pagination);
            $this->assignRef('lists', $lists);
        }elseif ($layoutName == 'view_company') {        //job search
            JToolBarHelper :: title(JText::_('JS_COMPANY_DETAILS'));
            JToolBarHelper :: cancel('company.cancel');
            $companyid = $_GET['md'];
            $result = $this->getJSModel('company')->getCompanybyIdForView($companyid);
            $this->assignRef('company', $result[0]);
            $this->assignRef('fieldsordering', $result[3]);
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
