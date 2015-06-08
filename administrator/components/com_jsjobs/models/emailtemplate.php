<?php

/**
 * @Copyright Copyright (C) 2009-2010 ... Ahmad Bilal
 * @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * Company:		Al-Barr Technologies
  + Contact:		www.al-barr.com , info@al-barr.com
 * Created on:	Jan 11, 2009
  ^
  + Project: 		Job Posting and Employment Application
 * File Name:	admin-----/models/jsjobs.php
  ^
 * Description: Model for application on admin site
  ^
 * History:		NONE
  ^
 */
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.model');
jimport('joomla.html.html');

class JSJobsModelEmailtemplate extends JSModel{

    var $_config = null;
    var $_defaultcurrency = null;
    var $_client_auth_key = null;
    var $_siteurl = null;

    function __construct() {
        parent :: __construct();
        $this->_client_auth_key = $this->getJSModel('jobsharing')->getClientAuthenticationKey();
        $this->_siteurl = JURI::root();
        $this->_defaultcurrency = $this->getJSModel('currency')->getDefaultCurrency();
        $user = JFactory::getUser();
        $this->_uid = $user->id;
    }

    function getTemplate($tempfor) {
        $db = JFactory :: getDBO();
        switch ($tempfor) {
            case 'ew-cm' : $tempatefor = 'company-new';
                break;
            case 'cm-ap' : $tempatefor = 'company-approval';
                break;
            case 'cm-rj' : $tempatefor = 'company-rejecting';
                break;
            case 'ew-ob' : $tempatefor = 'job-new';
                break;
            case 'ob-ap' : $tempatefor = 'job-approval';
                break;
            case 'ob-rj' : $tempatefor = 'job-rejecting';
                break;
            case 'ap-rs' : $tempatefor = 'applied-resume_status';
                break;
            case 'ew-rm' : $tempatefor = 'resume-new';
                break;
            case 'rm-ap' : $tempatefor = 'resume-approval';
                break;
            case 'ew-ms' : $tempatefor = 'message-email';
                break;
            case 'rm-rj' : $tempatefor = 'resume-rejecting';
                break;
            case 'ba-ja' : $tempatefor = 'jobapply-jobapply';
                break;
            case 'ew-md' : $tempatefor = 'department-new';
                break;
            case 'ew-rp' : $tempatefor = 'employer-buypackage';
                break;
            case 'ew-js' : $tempatefor = 'jobseeker-buypackage';
                break;
            case 'ms-sy' : $tempatefor = 'message-email';
                break;
            case 'jb-at' : $tempatefor = 'job-alert';
                break;
            case 'jb-at-vis' : $tempatefor = 'job-alert-visitor';
                break;
            case 'jb-to-fri' : $tempatefor = 'job-to-friend';
                break;
        }
        $query = "SELECT * FROM #__js_job_emailtemplates WHERE templatefor = " . $db->Quote($tempatefor);
        $db->setQuery($query);
        $template = $db->loadObject();
        return $template;
    }

    function storeEmailTemplate() {
        $row = $this->getTable('emailtemplate');

        $data = JRequest :: get('post');
        $data['body'] = JRequest::getVar('body', '', 'post', 'string', JREQUEST_ALLOWRAW);

        if (!$row->bind($data)) {
            $this->setError($this->_db->getErrorMsg());
            return false;
        }
        if (!$row->store()) {
            $this->setError($this->_db->getErrorMsg());
            return false;
        }

        return true;
    }

    function sendMailtoVisitor($jobid) {
        if ($jobid)
            if ((is_numeric($jobid) == false) || ($jobid == 0) || ($jobid == ''))
                return false;
        $db = JFactory::getDBO();
        $templatefor = 'job-alert-visitor';

        $query = "SELECT template.* FROM `#__js_job_emailtemplates` AS template	WHERE template.templatefor = " . $db->Quote($templatefor);
        $db->setQuery($query);
        $template = $db->loadObject();
        $msgSubject = $template->subject;
        $msgBody = $template->body;
        $jobquery = "SELECT job.title, job.jobstatus,job.jobid AS jobid, company.name AS companyname, cat.cat_title AS cattitle,job.sendemail,company.contactemail,company.contactname
                              FROM `#__js_job_jobs` AS job
                              JOIN `#__js_job_companies` AS company ON company.id = job.companyid
                              JOIN `#__js_job_categories` AS cat ON cat.id = job.jobcategory
                              WHERE job.id = " . $jobid;
        $db->setQuery($jobquery);
        $jobuser = $db->loadObject();
        if ($jobuser->jobstatus == 1) {

            $CompanyName = $jobuser->companyname;
            $JobCategory = $jobuser->cattitle;
            $JobTitle = $jobuser->title;
            if ($jobuser->jobstatus == 1)
                $JobStatus = JText::_('JS_APPROVED');
            else
                $JobStatus = JText::_('JS_WAITING_FOR_APPROVEL');
            $EmployerEmail = $jobuser->contactemail;
            $ContactName = $jobuser->contactname;

            $msgSubject = str_replace('{COMPANY_NAME}', $CompanyName, $msgSubject);
            $msgSubject = str_replace('{CONTACT_NAME}', $ContactName, $msgSubject);
            $msgSubject = str_replace('{JOB_CATEGORY}', $JobCategory, $msgSubject);
            $msgSubject = str_replace('{JOB_TITLE}', $JobTitle, $msgSubject);
            $msgSubject = str_replace('{JOB_STATUS}', $JobStatus, $msgSubject);
            $msgBody = str_replace('{COMPANY_NAME}', $CompanyName, $msgBody);
            $msgBody = str_replace('{CONTACT_NAME}', $ContactName, $msgBody);
            $msgBody = str_replace('{JOB_CATEGORY}', $JobCategory, $msgBody);
            $msgBody = str_replace('{JOB_TITLE}', $JobTitle, $msgBody);
            $msgBody = str_replace('{JOB_STATUS}', $JobStatus, $msgBody);

            $config = $this->getJSModel('configuration')->getConfigByFor('default');
            if ($config['visitor_can_edit_job'] == 1) {
                $path = JURI::base();
                $path .= 'index.php?option=com_jsjobs&view=employer&layout=formjob_visitor&email=' . $jobuser->contactemail . '&jobid=' . $jobuser->jobid;
                $text = '<br><a href="' . $path . '" target="_blank" >' . JText::_('JS_CLICK_HERE_TO_EDIT_JOB') . '</a>';
                $msgBody .= $text;
            }

            $emailconfig = $this->getJSModel('configuration')->getConfigByFor('email');
            $senderName = $emailconfig['mailfromname'];
            $senderEmail = $emailconfig['mailfromaddress'];

            $message = JFactory::getMailer();
            $message->addRecipient($EmployerEmail); //to email

            $message->setSubject($msgSubject);
            $siteAddress = JURI::base();
            $message->setBody($msgBody);
            $sender = array($senderEmail, $senderName);
            $message->setSender($sender);
            $message->IsHTML(true);
            $sent = $message->send();
            return $sent;
        }
    }

    function sendMail($for, $action, $id) {
        //action			1 = job approved, 2 = job reject 6, resume approved, 7 resume reject
        $db = JFactory::getDBO();
        $app = JApplication::getInstance('site');
        $router = $app->getRouter();
        $siteAddress = JURI::root();

        if ($for == 1) { //company
            if ($action == 1) { // company approved
                $templatefor = 'company-approval';
            } elseif ($action == -1) { //company reject
                $templatefor = 'company-rejecting';
            }
        } elseif ($for == 2) { //job
            if ($action == 1) { // job approved
                $templatefor = 'job-approval';
            } elseif ($action == -1) { // job reject
                $templatefor = 'job-rejecting';
            }
        } elseif ($for == 3) { // resume
            if ($action == 1) { //resume approved
                $templatefor = 'resume-approval';
            } elseif ($action == -1) { // resume reject
                $templatefor = 'resume-rejecting';
            }
        } elseif ($for == 4) {// visitor job
            if ($action == 1) { //resume approved
                $templatefor = 'job-alert-visitor';
            } elseif ($action == -1) { // resume reject
                $templatefor = 'job-alert-visitor';
            }
        }

        $query = "SELECT template.* FROM `#__js_job_emailtemplates` AS template	WHERE template.templatefor = " . $db->Quote($templatefor);
        $db->setQuery($query);
        $template = $db->loadObject();
        $msgSubject = $template->subject;
        $msgBody = $template->body;

        if ($for == 1) { //company
            $query = "SELECT company.name, company.contactname, company.contactemail,CONCAT(company.alias,'-',company.id) AS aliasid 
				FROM `#__js_job_companies` AS company
				WHERE company.id = " . $id;

            $db->setQuery($query);
            $company = $db->loadObject();

            $Name = $company->contactname;
            $Email = $company->contactemail;
            $companyName = $company->name;

            $msgSubject = str_replace('{COMPANY_NAME}', $companyName, $msgSubject);
            $msgSubject = str_replace('{EMPLOYER_NAME}', $Name, $msgSubject);
            $msgBody = str_replace('{COMPANY_NAME}', $companyName, $msgBody);
            $msgBody = str_replace('{EMPLOYER_NAME}', $Name, $msgBody);
            if ($action == 1) {
                $newUrl = 'index.php?option=com_jsjobs&c=jsjobs&view=employer&layout=view_company&vm=1&md=' . $company->aliasid;
                $newUrl = $router->build($newUrl);
                $parsed_url = $newUrl->toString();
                $parsed_url = str_replace('/administrator', '', $parsed_url);
                $companylink = '<br><a href="' . $parsed_url . '" target="_blank" >' . JText::_('JS_COMPANY') . '</a>';
                $msgBody = str_replace('{COMPANY_LINK}', $companylink, $msgBody);
            }
        } elseif ($for == 2) { //job
            $query = "SELECT job.title, company.contactname, company.contactemail,CONCAT(job.alias,'-',job.id) AS aliasid
						FROM `#__js_job_jobs` AS job
						JOIN `#__js_job_companies` AS company ON job.companyid = company.id
				WHERE job.id = " . $id;
            $db->setQuery($query);
            $job = $db->loadObject();

            $Name = $job->contactname;
            $Email = $job->contactemail;
            $jobTitle = $job->title;
            $msgSubject = str_replace('{JOB_TITLE}', $jobTitle, $msgSubject);
            $msgSubject = str_replace('{EMPLOYER_NAME}', $Name, $msgSubject);
            $msgBody = str_replace('{JOB_TITLE}', $jobTitle, $msgBody);
            $msgBody = str_replace('{EMPLOYER_NAME}', $Name, $msgBody);
            if ($action == 1) {
                $newUrl = 'index.php?option=com_jsjobs&c=jsjobs&view=employer&layout=view_job&vj=1&oi=' . $job->aliasid;
            } else {
                $newUrl = 'index.php?option=com_jsjobs&c=jsjobs&view=employer&layout=myjobs';
            }
            $newUrl = $router->build($newUrl);
            $parsed_url = $newUrl->toString();
            $parsed_url = str_replace('/administrator', '', $parsed_url);
            $joblink = '<br><a href="' . $parsed_url . '" target="_blank" >' . JText::_('JS_JOB') . '</a>';
            $msgBody = str_replace('{JOB_LINK}', $joblink, $msgBody);
        } elseif ($for == 3) { // resume
            $query = "SELECT app.application_title, app.first_name, app.middle_name, app.last_name, app.email_address,CONCAT(app.alias,'-',app.id) AS aliasid 
						FROM `#__js_job_resume` AS app
						WHERE app.id = " . $id;

            $db->setQuery($query);
            $app = $db->loadObject();

            $Name = $app->first_name;
            if ($app->middle_name)
                $Name .= " " . $app->middle_name;
            if ($app->last_name)
                $Name .= " " . $app->last_name;
            $Email = $app->email_address;
            $resumeTitle = $app->application_title;
            $msgSubject = str_replace('{RESUME_TITLE}', $resumeTitle, $msgSubject);
            $msgSubject = str_replace('{JOBSEEKER_NAME}', $Name, $msgSubject);
            $msgBody = str_replace('{RESUME_TITLE}', $resumeTitle, $msgBody);
            $msgBody = str_replace('{JOBSEEKER_NAME}', $Name, $msgBody);
            if ($action == 1) {
                $newUrl = 'index.php?option=com_jsjobs&c=jsjobs&view=jobseeker&layout=view_resume&vm=1&rd=' . $app->aliasid;
            } else {
                $newUrl = 'index.php?option=com_jsjobs&c=jsjobs&view=jobseeker&layout=myresumes';
            }
            $newUrl = $router->build($newUrl);
            $parsed_url = $newUrl->toString();
            $parsed_url = str_replace('/administrator', '', $parsed_url);
            $resumelink = '<br><a href="' . $parsed_url . '" target="_blank" >' . JText::_('JS_RESUME') . '</a>';
            $msgBody = str_replace('{RESUME_LINK}', $resumelink, $msgBody);
        } elseif ($for == 4) {
            $jobquery = "SELECT job.title, job.jobstatus,job.jobid AS jobid, company.name AS companyname, cat.cat_title AS cattitle,job.sendemail,company.contactemail,company.contactname
                                      FROM `#__js_job_jobs` AS job
                                      JOIN `#__js_job_companies` AS company ON company.id = job.companyid
                                      JOIN `#__js_job_categories` AS cat ON cat.id = job.jobcategory
                                      WHERE job.id = " . $id;
            $db->setQuery($jobquery);
            $jobuser = $db->loadObject();

            $CompanyName = $jobuser->companyname;
            $JobCategory = $jobuser->cattitle;
            $JobTitle = $jobuser->title;
            if ($jobuser->jobstatus == 1)
                $JobStatus = JText::_('JS_APPROVED');
            else
                $JobStatus = JText::_('JS_WAITING_FOR_APPROVEL');
            $Email = $jobuser->contactemail;
            $ContactName = $jobuser->contactname;


            $msgSubject = str_replace('{COMPANY_NAME}', $CompanyName, $msgSubject);
            $msgSubject = str_replace('{CONTACT_NAME}', $ContactName, $msgSubject);
            $msgSubject = str_replace('{JOB_CATEGORY}', $JobCategory, $msgSubject);
            $msgSubject = str_replace('{JOB_TITLE}', $JobTitle, $msgSubject);
            $msgSubject = str_replace('{JOB_STATUS}', $JobStatus, $msgSubject);
            $msgBody = str_replace('{COMPANY_NAME}', $CompanyName, $msgBody);
            $msgBody = str_replace('{CONTACT_NAME}', $ContactName, $msgBody);
            $msgBody = str_replace('{JOB_CATEGORY}', $JobCategory, $msgBody);
            $msgBody = str_replace('{JOB_TITLE}', $JobTitle, $msgBody);
            $msgBody = str_replace('{JOB_STATUS}', $JobStatus, $msgBody);

            $config = $this->getJSModel('configuration')->getConfigByFor('default');
            if ($config['visitor_can_edit_job'] == 1) {
                $path = JURI::base();
                $path .= 'index.php?option=com_jsjobs&view=employer&layout=formjob_visitor&email=' . $jobuser->contactemail . '&jobid=' . $jobuser->jobid;
                $text = '<br><a href="' . $path . '" target="_blank" >' . JText::_('JS_CLICK_HERE_TO_EDIT_JOB') . '</a>';
                $msgBody .= $text;
            }
        }


        if (!$this->_config)
            $this->_config = $this->getJSModel('configuration')->getConfig();
        foreach ($this->_config as $conf) {
            if ($conf->configname == 'mailfromname')
                $senderName = $conf->configvalue;
            if ($conf->configname == 'mailfromaddress')
                $senderEmail = $conf->configvalue;
        }

        $message = JFactory::getMailer();
        $message->addRecipient($Email); //to email
        $message->setSubject($msgSubject);
        $message->setBody($msgBody);
        $sender = array($senderEmail, $senderName);
        $message->setSender($sender);
        $message->IsHTML(true);
        $sent = $message->send();


        return true;
    }

}

?>