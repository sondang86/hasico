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

class JSJobsViewEmailTemplate extends JSView{

    function display($tpl = null) {
        require_once JPATH_COMPONENT_ADMINISTRATOR . '/views/common.php';
//        layout start
        if ($layoutName == 'emailtemplate') {          // email template
            $templatefor = JRequest::getVar('tf');
            switch ($templatefor) {
                case 'ew-cm' : $text = JText::_('JS_NEW_COMPANY');
                    break;
                case 'cm-ap' : $text = JText::_('JS_COMPANY_APPROVAL');
                    break;
                case 'cm-rj' : $text = JText::_('JS_COMPANY_REJECTING');
                    break;
                case 'ew-ob' : $text = JText::_('JS_NEW_JOB');
                    break;
                case 'ob-ap' : $text = JText::_('JS_JOB_APPROVAL');
                    break;
                case 'ob-rj' : $text = JText::_('JS_JOB_REJECTING');
                    break;
                case 'ap-rs' : $text = JText::_('JS_APPLIED_RESUME_STATUS');
                    break;
                case 'ew-rm' : $text = JText::_('JS_NEW_RESUME');
                    break;
                case 'ew-ms' : $text = JText::_('JS_NEW_MESSAGE');
                    break;
                case 'rm-ap' : $text = JText::_('JS_RESUME_APPROVAL');
                    break;
                case 'rm-rj' : $text = JText::_('JS_RESUME_REJECTING');
                    break;
                case 'ba-ja' : $text = JText::_('JS_JOB_APPLY');
                    break;
                case 'ew-md' : $text = JText::_('JS_NEW_DEPARTMENT');
                    break;
                case 'ew-rp' : $text = JText::_('JS_EMPLOYER_BUY_PACKAGE');
                    break;
                case 'ew-js' : $text = JText::_('JS_JOBSEEKER_BUY_PACKAGE');
                    break;
                case 'ms-sy' : $text = JText::_('JS_MESSAGE');
                    break;
                case 'jb-at' : $text = JText::_('JS_JOB_ALERT');
                    break;
                case 'jb-at-vis' : $text = JText::_('JS_EMPLOYER_VISITOR_JOB');
                    break;
                case 'jb-to-fri' : $text = JText::_('JS_JOB_TO_FRIEND');
                    break;
            }
            JToolBarHelper :: title(JText::_('JS_EMAIL_TEMPLATES') . ' <small><small>[' . $text . '] </small></small>');
            JToolBarHelper :: save('emailtemplate.saveemailtemplate');
            $template = $this->getJSModel('emailtemplate')->getTemplate($templatefor);
            $this->assignRef('template', $template);
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
