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

class JSJobsViewCity extends JSView{

    function display($tpl = null) {
        require_once JPATH_COMPONENT_ADMINISTRATOR . '/views/common.php';
//        layout start
        if ($layoutName == 'formcity') {          // cities
            if (isset($_GET['cid'][0]))
                $c_id = $_GET['cid'][0];
            else
                $c_id = '';
            if ($c_id == '') {
                $cids = JRequest :: getVar('cid', array(0), 'post', 'array');
                $c_id = $cids[0];
            }
            if (isset($_SESSION['js_countrycode']))
                $countrycode = $_SESSION['js_countrycode'];
            else
                $countrycode = null;
            if (isset($_SESSION['js_countryid']))
                $countryid = $_SESSION['js_countryid'];
            else
                $countryid = null;
            if (isset($_SESSION['js_statecode']))
                $statecode = $_SESSION['js_statecode'];
            else
                $statecode = null;
            if (isset($_SESSION['js_stateid']))
                $stateid = $_SESSION['js_stateid'];
            else
                $stateid = null;
            //if (isset($_SESSION['js_countycode'])) $countycode = $_SESSION['js_countycode']; else $countycode=null;
            if (is_numeric($c_id) == true)
                $city = $this->getJSModel('city')->getCitybyId($c_id);
            if (isset($city->id))
                $isNew = false;
            $text = $isNew ? JText :: _('ADD') : JText :: _('EDIT');
            JToolBarHelper :: title(JText :: _('JS_CITY') . ': <small><small>[ ' . $text . ' ]</small></small>');
            $this->assignRef('city', $city);
            $this->assignRef('countrycode', $countrycode);
            $this->assignRef('countryid', $countryid);
            $this->assignRef('statecode', $statecode);
            $this->assignRef('stateid', $stateid);
            JToolBarHelper :: save('city.savecity');
            if ($isNew)
                JToolBarHelper :: cancel('city.cancel');
            else
                JToolBarHelper :: cancel('city.cancel', 'Close');
        }elseif ($layoutName == 'cities') {          // cities
            $stateid = JRequest::getVar('sd');
            $countryid = JRequest::getVar('ct');
            $session = JFactory::getSession();
            $session->set('countryid', $countryid);
            $session->set('stateid', $stateid);

            JToolBarHelper :: title(JText::_('JS_CITIES'));

            $form = 'com_jsjobs.counties.list.';
            $searchname = $mainframe->getUserStateFromRequest($form . 'searchname', 'searchname', '', 'string');

            $result = $this->getJSModel('city')->getAllStatesCities($searchname, $stateid, $countryid, $limitstart, $limit);
            $items = $result[0];
            $total = $result[1];
            if (isset($result[2]))
                $this->assignRef('lists', $result[2]);
            $this->assignRef('sd', $stateid);
            $this->assignRef('ct', $countryid);

            if ($total <= $limitstart)
                $limitstart = 0;
            $pagination = new JPagination($total, $limitstart, $limit);
            $this->assignRef('pagination', $pagination);
            JToolBarHelper :: addNew('city.editjobcity');
            JToolBarHelper :: editList('city.editjobcity');
            JToolBarHelper :: publishList('city.publishcities');
            JToolBarHelper :: unpublishList('city.unpublishcities');
            JToolBarHelper :: deleteList(JText::_("JS_ARE_YOU_SURE"),'city.deletecity');
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
