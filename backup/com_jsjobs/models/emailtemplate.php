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
 * File Name:	models/emailtemplate.php
  ^
 * Description: Model class for jsjobs data
  ^
 * History:		NONE
  ^
 */
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.model');
jimport('joomla.html.html');
$option = JRequest :: getVar('option', 'com_jsjobs');

class JSJobsModelEmailTemplate extends JSModel {

    var $_client_auth_key = null;
    var $_siteurl = null;

    function __construct() {
        parent :: __construct();
        $this->_client_auth_key = $this->getJSModel('common')->getClientAuthenticationKey();
        $this->_siteurl = JURI::root();
        $user = JFactory::getUser();
        $this->_uid = $user->id;
    }

    function sendToCandidate($data) {
        $senderName = "";
        $senderemail = $data[0];
        $recipient = $data[1];
        $msgBody = $data[3];
        $msgSubject = $data[2];
        $message = JFactory::getMailer();
        $message->addRecipient($recipient); //to email
        $message->setSubject($msgSubject);
        $message->setBody($msgBody);
        $sender = array($senderemail, $senderName);
        $message->setSender($sender);
        $message->IsHTML(true);
        if (!$message->send())
            $sent = $message->sent();
        else
            $sent = true;
        return $sent;
    }

    function sendMail($jobid, $uid, $resumeid) {
        if ($uid)
            if ((is_numeric($uid) == false) || ($uid == 0) || ($uid == ''))
                return false;
        if ($jobid)
            if ((is_numeric($jobid) == false) || ($jobid == 0) || ($jobid == ''))
                return false;
        if ($resumeid)
            if ((is_numeric($resumeid) == false) || ($resumeid == 0) || ($resumeid == ''))
                return false;
        $db = JFactory::getDBO();
        $templatefor = 'jobapply-jobapply';
        $query = "SELECT template.* FROM `#__js_job_emailtemplates` AS template	WHERE template.templatefor = " . $db->Quote($templatefor);
        $db->setQuery($query);
        $template = $db->loadObject();
        $msgSubject = $template->subject;
        $msgBody = $template->body;

        $jobquery = "SELECT company.contactname AS name, company.contactemail AS email, job.title, job.sendemail 
			FROM `#__js_job_companies` AS company
			JOIN `#__js_job_jobs` AS job ON job.companyid = company.id  
			WHERE job.id = " . $jobid;


        $db->setQuery($jobquery);
        $jobuser = $db->loadObject();

        if ($jobuser->sendemail != 0) {
            $userquery = "SELECT CONCAT(first_name,' ',last_name) AS name, email_address AS email FROM `#__js_job_resume`
			WHERE id = " . $db->Quote($resumeid);
            $db->setQuery($userquery);
            $user = $db->loadObject();

            $ApplicantName = $user->name;
            $EmployerEmail = $jobuser->email;
            $EmployerName = $jobuser->name;
            $JobTitle = $jobuser->title;

            $msgSubject = str_replace('{JOBSEEKER_NAME}', $ApplicantName, $msgSubject);
            $msgSubject = str_replace('{EMPLOYER_NAME}', $EmployerName, $msgSubject);
            $msgSubject = str_replace('{JOB_TITLE}', $JobTitle, $msgSubject);
            $msgBody = str_replace('{JOBSEEKER_NAME}', $ApplicantName, $msgBody);
            $msgBody = str_replace('{EMPLOYER_NAME}', $EmployerName, $msgBody);
            $msgBody = str_replace('{JOB_TITLE}', $JobTitle, $msgBody);

            $emailconfig = $this->getJSModel('configurations')->getConfigByFor('email');
            $senderName = $emailconfig['mailfromname'];
            $senderEmail = $emailconfig['mailfromaddress'];
            $check_fields_send = $emailconfig['employer_resume_alert_fields'];

            $message = JFactory::getMailer();
            $message->addRecipient($EmployerEmail); //to email
            $message->setSubject($msgSubject);
            $siteAddress = JURI::base();
            if ($jobuser->sendemail == 2) { // email with attachment
                if ($check_fields_send) {
                    $this->sendJobApplyResumeAlertEmployer($resumeid, $check_fields_send, $EmployerEmail, $msgSubject, $msgBody, $senderEmail, $senderName, $jobid);
                } else {
                    $resumequery = "SELECT resume.id, resume.filename,CONCAT(resume.alias,'-',resume.id) AS aliasid 
                    FROM `#__js_job_resume` AS resume WHERE resume.id = " . $resumeid;

                    $db->setQuery($resumequery);
                    $resume = $db->loadObject();
                    if ($resume->filename != '') {
                        $iddir = 'resume_' . $resume->id;
                        if (!isset($this->_config))
                            $this->getJSModel('configurations')->getConfig('');
                        foreach ($this->_config as $conf) {
                            if ($conf->configname == 'data_directory')
                                $datadirectory = $conf->configvalue;
                        }
                        $path = JPATH_BASE . '/' . $datadirectory;
                        $path = $path . '/data/jobseeker/' . $iddir . '/resume/' . $resume->filename;
                        $message->addAttachment($path);
                    }
                    $app = JApplication::getInstance('site');
                    $router = $app->getRouter();
                    //$newUrl = 'index.php?option=com_jsjobs&c=jsjobs&view=jobseeker&layout=view_resume&nav=6&rd=' . $resume->aliasid . '&bd=' . $jobid;
                    $newUrl = JUri::root().'index.php?option=com_jsjobs&c=jsjobs&view=resume&layout=view_resume&nav=6&rd=' . $resume->aliasid . '&bd=' . $jobid;                    
                    $newUrl = $router->build($newUrl);
                    $parsed_url = $newUrl->toString();
                    $applied_resume_link = '<br><a href="' . $parsed_url . '" target="_blank" >' . JText::_('JS_RESUME') . '</a>';
                    $msgBody = str_replace('{RESUME_LINK}', $applied_resume_link, $msgBody);
                }
            }
            $message->setBody($msgBody);
            $sender = array($senderEmail, $senderName);
            $message->setSender($sender);
            $message->IsHTML(true);
            $sent = $message->send();
            return $sent;
        }
    }




      function getSendEmail() {
      $values = array();
      $values[] = array('value' => 0, 'text' => JText::_('JS_NO'));
      $values[] = array('value' => 1, 'text' => JText::_('JS_YES'));
      $values[] = array('value' => 2, 'text' => JText::_('JS_YES_WITH_RESUME'));
      return $values;
      }
}
?>
    
