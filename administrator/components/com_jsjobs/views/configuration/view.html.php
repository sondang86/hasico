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

class JSJobsViewConfiguration extends JSView{

    function display($tpl = null) {
        require_once JPATH_COMPONENT_ADMINISTRATOR . '/views/common.php';
//        layout start
        if ($layoutName == 'configurations' || $layoutName == 'configurationsemployer' || $layoutName == 'configurationsjobseeker') {
            if ($layoutName == 'configurations')
                $ptitle = JText::_('JS_CONFIGURATIONS');
            elseif ($layoutName == 'configurationsemployer')
                $ptitle = JText::_('JS_EMPLOYER_CONFIGURATIONS');
            else
                $ptitle = JText::_('JS_JOBSEEKER_CONFIGURATIONS');
            JToolBarHelper :: title($ptitle);
            JToolBarHelper :: save('configuration.save');
            $result = $this->getJSModel('configuration')->getConfigurationsForForm();
            $this->assignRef('lists', $result[1]);
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
