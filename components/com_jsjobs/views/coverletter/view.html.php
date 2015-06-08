<?php

/**
 * @Copyright Copyright (C) 2009-2011
 * @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
  + Created by:          Ahmad Bilal
 * Company:		Buruj Solutions
  + Contact:		www.burujsolutions.com , ahmad@burujsolutions.com
 * Created on:	Jan 11, 2009
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
jimport('joomla.html.pagination');

class JSJobsViewCoverLetter extends JSView {

    function display($tpl = null) {
        require_once(JPATH_COMPONENT . '/views/common.php');
        $viewtype = 'html';

        if ($layout == 'formcoverletter') {            // form cover letter
            $page_title .= ' - ' . JText::_('JS_COVER_LETTER_FORM');
            if (isset($_GET['cl']))
                $letterid = $_GET['cl'];
            else
                $letterid = null;
            $letterid = $this->getJSModel('common')->parseId(JRequest::getVar('cl', ''));
            $result = $this->getJSModel('coverletter')->getCoverLetterbyId($letterid, $uid);
            $this->assignRef('coverletter', $result[0]);
            $this->assignRef('canaddnewcoverletter', $result[4]);
            JHTML::_('behavior.formvalidation');
        } elseif ($layout == 'mycoverletters') {            // my cover letters
            $page_title .= ' - ' . JText::_('JS_MY_COVER_LETTERS');
            $mycoverletter_allowed = $this->getJSModel('permissions')->checkPermissionsFor("MY_COVER_LETTER");
            if($mycoverletter_allowed == VALIDATE){
                $result = $this->getJSModel('coverletter')->getMyCoverLettersbyUid($uid, $limit, $limitstart);
                $this->assignRef('coverletters', $result[0]);
                if ($result[1] <= $limitstart)
                    $limitstart = 0;
                $pagination = new JPagination($result[1], $limitstart, $limit);
                $this->assignRef('pagination', $pagination);
            }
            $this->assignRef('mycoverletter_allowed', $mycoverletter_allowed);
        }elseif ($layout == 'view_coverletter') {            // view cover letter
            $page_title .= ' - ' . JText::_('JS_VIEW_COVER_LETTER');
            $letterid = $this->getJSModel('common')->parseId(JRequest::getVar('cl', ''));
            $result = $this->getJSModel('coverletter')->getCoverLetterbyId($letterid, null);
            $this->assignRef('coverletter', $result[0]);
            $nav = JRequest::getVar('nav', '');
            $this->assignRef('nav', $nav);
            $jobaliasid = JRequest::getVar('bd', '');
            $this->assignRef('jobaliasid', $jobaliasid);
            $resumealiasid = JRequest::getVar('rd', '');
            $this->assignRef('resumealiasid', $resumealiasid);
        }
        require_once('coverletter_breadcrumbs.php');
        $document->setTitle($page_title);
        $this->assignRef('userrole', $userrole);
        $this->assignRef('config', $config);
        $this->assignRef('option', $option);
        $this->assignRef('params', $params);
        $this->assignRef('viewtype', $viewtype);
        $this->assignRef('employerlinks', $employerlinks);
        $this->assignRef('jobseekerlinks', $jobseekerlinks);
        $this->assignRef('uid', $uid);
        $this->assignRef('id', $id);
        $this->assignRef('Itemid', $itemid);
        $this->assignRef('isjobsharing', $_client_auth_key);

        parent :: display($tpl);
    }
}

?>