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

class JSJobsViewEmployerpackages extends JSView{

    function display($tpl = null) {
        require_once JPATH_COMPONENT_ADMINISTRATOR . '/views/common.php';
//        layout start
        if ($layoutName == 'formemployerpackage') {          // employer packages
            if (isset($_GET['cid'][0]))
                $c_id = $_GET['cid'][0];
            else
                $c_id = '';

            if ($c_id == '') {
                $cids = JRequest :: getVar('cid', array(0), 'post', 'array');
                $c_id = $cids[0];
            }
            if (is_numeric($c_id) == true)
                $result = $this->getJSModel('employerpackages')->getEmployerPackagebyId($c_id);
            if (isset($result[0]->id))
                $isNew = false;
            $text = $isNew ? JText :: _('ADD') : JText :: _('EDIT');
            JToolBarHelper :: title(JText :: _('JS_EMPLOYER_PACKAGE') . ': <small><small>[ ' . $text . ' ]</small></small>');
            $this->assignRef('package', $result[0]);
            $this->assignRef('lists', $result[1]);
            $this->assignRef('paymentmethodlink', $paymentmethodlink);
            JToolBarHelper :: save('employerpackages.saveemployerpackage');
            if ($isNew)
                JToolBarHelper :: cancel('employerpackages.cancel');
            else
                JToolBarHelper :: cancel('employerpackages.cancel', 'Close');
        }elseif ($layoutName == 'employerpackages') {        //employer packages
            JToolBarHelper :: title(JText::_('JS_EMPLOYER_PACKAGES'));
            JToolBarHelper :: addNew('employerpackages.add');
            JToolBarHelper :: editList('employerpackages.add');
            JToolBarHelper :: deleteList(JText::_('JS_ARE_YOU_SURE'),'employerpackages.remove');
            $result = $this->getJSModel('employerpackages')->getEmployerPackages($limitstart, $limit);
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
