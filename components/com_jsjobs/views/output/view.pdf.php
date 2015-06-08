<?php

/**
 * @Copyright Copyright (C) 2009-2011
 * @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
  + Created by:          Ahmad Bilal
 * Company:		Buruj Solutions
  + Contact:		www.burujsolutions.com , ahmad@burujsolutions.com
 * Created on:	Jan 11, 2010
  ^
  + Project: 		JS Jobs
 * File Name:	views/employer/view.html.php
  ^
 * Description: HTML view class for employer
  ^
 * History:		NONE
  ^
 */
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');

class JSJobsViewOutput extends JSView {

    function display($tpl = NULL) {
        require_once(JPATH_COMPONENT . '/views/common.php');
        $viewtype = 'pdf';
        $cur_layout = 'resumepdf';

        if ($cur_layout == 'resumepdf') {
            $resumeid = $this->getJSModel('common')->parseId(JRequest::getVar('rd', ''));
            $jobid = $this->getJSModel('common')->parseId(JRequest::getVar('bd', ''));
            $myresume = JRequest::getVar('ms', '6');
            if (is_numeric($resumeid) == true)
                $result = $this->getJSModel('resume')->getResumeViewbyId($uid, $jobid, $resumeid, $myresume);
            sleep(10);
            $this->assignRef('resume', $result[0]);
            $this->assignRef('resume2', $result[1]);
            $this->assignRef('resume3', $result[2]);
            $this->assignRef('ms', $myresume);
            $this->assignRef('fieldsordering', $result[3]);
            $this->assignRef('isjobsharing', $_client_auth_key);
        }

        $document = JFactory::getDocument();
        $document->setTitle($result[0]->first_name . ' ' . $result[0]->last_name . ' ' . JText::_('JS_RESUME'));
        $this->assignRef('config', $config);
        parent :: display();
    }

}

?>
