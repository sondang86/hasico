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
 * File Name:	models/jsjobs.php
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

class JSJobsModelAdminEmail extends JSModel {

    var $_uid = null;
    var $_client_auth_key = null;
    var $_siteurl = null;

    function __construct() { // clean constructor.
        parent :: __construct();
        $this->_client_auth_key = $this->getJSModel('common')->getClientAuthenticationKey();
        $this->_siteurl = JURI::root();
        $user = JFactory::getUser();
        $this->_uid = $user->id;
    }

    function sendMailtoAdmin($id, $uid, $for) {
        $db = JFactory::getDBO();
        if ((is_numeric($id) == false) || ($id == 0) || ($id == ''))
            return false;
        if ($uid)
            if ((is_numeric($uid) == false) || ($uid == 0) || ($uid == ''))
                return false;
        $emailconfig = $this->getJSModel('configurations')->getConfigByFor('email');
        $senderName = $emailconfig['mailfromname'];
        $senderEmail = $emailconfig['mailfromaddress'];
        $adminEmail = $emailconfig['adminemailaddress'];
        $newCompany = $emailconfig['email_admin_new_company'];
        $newJob = $emailconfig['email_admin_new_job'];
        $newResume = $emailconfig['email_admin_new_resume'];
        $jobApply = $emailconfig['email_admin_job_apply'];
        $newDepartment = $emailconfig['email_admin_new_department'];
        $newEmployerPackage = $emailconfig['email_admin_employer_package_purchase'];
        $newJobSeekerPackage = $emailconfig['email_admin_jobseeker_package_purchase'];
        switch ($for) {
            case 1: // new company
                $templatefor = 'company-new';
                $issendemail = $newCompany;
                break;
            case 2: // new job
                $templatefor = 'job-new';
                $issendemail = $newJob;
                break;
            case 3: // new resume
                $templatefor = 'resume-new';
                $issendemail = $newResume;
                break;
            case 4: // job apply
                $templatefor = 'jobapply-jobapply';
                $issendemail = $jobApply;
                break;
            case 5: // new department
                $templatefor = 'department-new';
                $issendemail = $newDepartment;
                break;
            case 6: // new employer package
                $templatefor = 'employer-buypackage';
                $issendemail = $newEmployerPackage;
                break;
            case 7: // new job seeker package
                $templatefor = 'jobseeker-buypackage';
                $issendemail = $newJobSeekerPackage;
                break;
        }
        if ($issendemail == 1) {
            $query = "SELECT template.* FROM `#__js_job_emailtemplates` AS template WHERE template.templatefor = " . $db->Quote($templatefor);
            $db->setQuery($query);
            $template = $db->loadObject();
            $msgSubject = $template->subject;
            $msgBody = $template->body;

            switch ($for) {
                case 1: // new company
                    $jobquery = "SELECT company.name AS companyname, company.id AS id, company.contactname AS name, company.contactemail AS email 
                                FROM `#__js_job_companies` AS company
                                WHERE company.uid = " . $uid . "  AND company.id = " . $id;
                    $db->setQuery($jobquery);
                    $user = $db->loadObject();
                    $EmployerEmail = $user->email;
                    $EmployerName = $user->name;
                    $CompanyName = $user->companyname;

                    $msgSubject = str_replace('{COMPANY_NAME}', $CompanyName, $msgSubject);
                    $msgSubject = str_replace('{EMPLOYER_NAME}', $EmployerName, $msgSubject);
                    $msgBody = str_replace('{COMPANY_NAME}', $CompanyName, $msgBody);
                    $msgBody = str_replace('{EMPLOYER_NAME}', $EmployerName, $msgBody);
                    $path = JURI::root();
                    $path .= 'administrator/index.php?option=com_jsjobs&view=applications&layout=view_company&cd=' . $user->id;
                    $companylink = '<br><a href="' . $path . '" target="_blank" >' . JText::_('JS_COMPANY') . '</a>';
                    $msgBody = str_replace('{COMPANY_LINK}', $companylink, $msgBody);

                    break;
                case 2: // new job
                    $jobquery = "SELECT job.title, company.contactname AS name, company.contactemail AS email ,job.id AS id
                                FROM `#__js_job_jobs` AS job
                                JOIN `#__js_job_companies` AS company ON company.id = job.companyid
                                WHERE job.uid = " . $uid . "  AND job.id = " . $id;
                    $db->setQuery($jobquery);
                    $user = $db->loadObject();
                    $EmployerEmail = $user->email;
                    $EmployerName = $user->name;
                    $JobTitle = $user->title;

                    $msgSubject = str_replace('{JOB_TITLE}', $JobTitle, $msgSubject);
                    $msgSubject = str_replace('{EMPLOYER_NAME}', $EmployerName, $msgSubject);
                    $msgBody = str_replace('{JOB_TITLE}', $JobTitle, $msgBody);
                    $msgBody = str_replace('{EMPLOYER_NAME}', $EmployerName, $msgBody);
                    $path = JURI::root();
                    $path .= 'administrator/index.php?option=com_jsjobs&view=applications&layout=view_job&oi=' . $user->id;
                    $joblink = '<br><a href="' . $path . '" target="_blank" >' . JText::_('JS_JOB') . '</a>';
                    $msgBody = str_replace('{JOB_LINK}', $joblink, $msgBody);

                    break;
                case 3: // new resume
                    if ($uid) {
                        $jobquery = "SELECT resume.application_title ,resume.id, concat(resume.first_name,' ',resume.last_name) AS name, resume.email_address as email
                                    FROM `#__js_job_resume` AS resume
                                    WHERE resume.uid = " . $uid . "  AND resume.id = " . $id;
                    } else {
                        $jobquery = "SELECT resume.application_title, 'Guest' AS name, resume.email_address AS email ,resume.id FROM `#__js_job_resume` AS resume WHERE resume.id = " . $id;
                    }

                    $db->setQuery($jobquery);
                    $user = $db->loadObject();
                    $EmployerEmail = $user->email;
                    $JobSeekerName = $user->name;
                    $ApplicationTitle = $user->application_title;

                    $msgSubject = str_replace('{RESUME_TITLE}', $ApplicationTitle, $msgSubject);
                    $msgSubject = str_replace('{JOBSEEKER_NAME}', $JobSeekerName, $msgSubject);
                    $msgBody = str_replace('{RESUME_TITLE}', $ApplicationTitle, $msgBody);
                    $msgBody = str_replace('{JOBSEEKER_NAME}', $JobSeekerName, $msgBody);

                    $path = JURI::root();
                    $path .= 'administrator/index.php?option=com_jsjobs&view=application&layout=view_resume&rd=' . $user->id;
                    $resumelink = '<br><a href="' . $path . '" target="_blank" >' . JText::_('JS_RESUME') . '</a>';
                    $msgBody = str_replace('{RESUME_LINK}', $resumelink, $msgBody);


                    break;
                case 4: // Function Added 

                    $jobquery = "SELECT job.title, employer.contactname AS employername, employer.contactemail AS employeremail,concat(jobseeker.first_name,' ',jobseeker.last_name) AS jobseekername
                                FROM `#__js_job_jobs` AS job
                                JOIN `#__js_job_companies` AS employer ON employer.id = job.companyid
                                JOIN `#__js_job_resume` AS jobseeker ON jobseeker.uid = " . $uid . "
                                WHERE job.id = " . $id;


                    $db->setQuery($jobquery);
                    $user = $db->loadObject();
                    $EmployerEmail = $user->employeremail;
                    $EmployerName = $user->employername;
                    $JobseekerName = $user->jobseekername;
                    $JobTitle = $user->title;

                    $msgSubject = str_replace('{JOB_TITLE}', $JobTitle, $msgSubject);
                    $msgSubject = str_replace('{EMPLOYER_NAME}', $EmployerName, $msgSubject);
                    $msgSubject = str_replace('{JOBSEEKER_NAME}', $JobseekerName, $msgSubject);
                    $msgBody = str_replace('{JOB_TITLE}', $JobTitle, $msgBody);
                    $msgBody = str_replace('{EMPLOYER_NAME}', $EmployerName, $msgBody);
                    $msgBody = str_replace('{JOBSEEKER_NAME}', $JobseekerName, $msgBody);
                    break;
                case 5: // new department
                    $jobquery = "SELECT department.name AS departmentname, company.name AS companyname, company.contactname as name,company.contactemail as email
                                FROM `#__js_job_departments` AS department
                                JOIN `#__js_job_companies` AS company ON company.id = department.companyid
                                WHERE department.uid = " . $uid . "  AND department.id = " . $id;

                    $db->setQuery($jobquery);
                    $user = $db->loadObject();
                    $EmployerEmail = $user->email;
                    $EmployerName = $user->name;
                    $CompanyName = $user->companyname;
                    $DepartmentTitle = $user->departmentname;

                    $msgSubject = str_replace('{COMPANY_NAME}', $CompanyName, $msgSubject);
                    $msgSubject = str_replace('{DEPARTMENT_NAME}', $DepartmentTitle, $msgSubject);
                    $msgSubject = str_replace('{EMPLOYER_NAME}', $EmployerName, $msgSubject);
                    $msgBody = str_replace('{COMPANY_NAME}', $CompanyName, $msgBody);
                    $msgBody = str_replace('{DEPARTMENT_NAME}', $DepartmentTitle, $msgBody);
                    $msgBody = str_replace('{EMPLOYER_NAME}', $EmployerName, $msgBody);
                    break;
                case 6: // new employer package purchase
                    $jobquery = "SELECT package.title, package.price, user.name, user.email,package.id,cur.symbol AS currency
                                FROM `#__users` AS user
                                JOIN `#__js_job_paymenthistory` AS payment ON payment.uid = user.id
                                JOIN `#__js_job_employerpackages` AS package ON package.id = payment.packageid
                                LEFT JOIN `#__js_job_currencies` AS cur ON package.currencyid = cur.id
                                WHERE user.id = " . $uid . "  AND payment.id = " . $id . " AND payment.packagefor=1 ";

                    $db->setQuery($jobquery);
                    $user = $db->loadObject();
                    $EmployerEmail = $user->email;
                    $EmployerName = $user->name;
                    $PackageTitle = $user->title;
                    $packagePrice = $user->price;

                    $msgSubject = str_replace('{PACKAGE_NAME}', $PackageTitle, $msgSubject);
                    $msgSubject = str_replace('{EMPLOYER_NAME}', $EmployerName, $msgSubject);
                    $msgBody = str_replace('{PACKAGE_NAME}', $PackageTitle, $msgBody);
                    $msgBody = str_replace('{EMPLOYER_NAME}', $EmployerName, $msgBody);
                    $msgBody = str_replace('{CURRENCY}', $user->currency, $msgBody);
                    $msgBody = str_replace('{PACKAGE_PRICE}', $packagePrice, $msgBody);
                    $path = JURI::root();
                    $path .= 'administrator/index.php?option=com_jsjobs&task=view&layout=employerpaymentdetails&pk=' . $user->id;
                    $epacklink = '<br><a href="' . $path . '" target="_blank" >' . JText::_('JS_PACKAGE_DETAIL') . '</a>';
                    $msgBody = str_replace('{PACKAGE_LINK}', $epacklink, $msgBody);
                    break;
                case 7: // new job seeker package purchase
                    $jobquery = "SELECT package.title, package.price, user.name, user.email,package.id ,cur.symbol AS currency
                                FROM `#__users` AS user
                                JOIN `#__js_job_paymenthistory` AS payment ON payment.uid = user.id 
                                JOIN `#__js_job_jobseekerpackages` AS package ON package.id = payment.packageid
                                LEFT JOIN `#__js_job_currencies` AS cur ON package.currencyid = cur.id
                                WHERE user.id = " . $uid . "  AND payment.id = " . $id . " AND payment.packagefor=2 ";

                    $db->setQuery($jobquery);
                    $user = $db->loadObject();
                    $JobSeekerEmail = $user->email;
                    $JobSeekerName = $user->name;
                    $PackageTitle = $user->title;
                    $packagePrice = $user->price;

                    $msgSubject = str_replace('{PACKAGE_NAME}', $PackageTitle, $msgSubject);
                    $msgSubject = str_replace('{JOBSEEKER_NAME}', $JobSeekerName, $msgSubject);
                    $msgBody = str_replace('{PACKAGE_NAME}', $PackageTitle, $msgBody);
                    $msgBody = str_replace('{JOBSEEKER_NAME}', $JobSeekerName, $msgBody);
                    $msgBody = str_replace('{CURRENCY}', $user->currency, $msgBody);
                    $msgBody = str_replace('{PACKAGE_PRICE}', $packagePrice, $msgBody);
                    $path = JURI::root();
                    $path .= 'administrator/index.php?option=com_jsjobs&task=view&layout=jobseekerpaymentdetails&pk=' . $user->id;
                    $jpacklink = '<br><a href="' . $path . '" target="_blank" >' . JText::_('JS_PACKAGE_DETAIL') . '</a>';
                    $msgBody = str_replace('{PACKAGE_LINK}', $epacklink, $msgBody);
                    break;
            }
            $message = JFactory::getMailer();
            $message->addRecipient($adminEmail); //to email
            $message->setSubject($msgSubject);
            $siteAddress = JURI::base();
            $message->setBody($msgBody);
            $sender = array($senderEmail, $senderName);
            $message->setSender($sender);
            $message->IsHTML(true);
            $sent = $message->send();
            return $sent;
        }
        return true;
    }

}

?>
