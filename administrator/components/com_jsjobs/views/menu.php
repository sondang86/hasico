<?php
/**
 * @Copyright Copyright (C) 2010- ... Ahmad Bilal
 * @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * Company:		Al-Barr Technologies
 * Contact:		www.al-barr.com , info@al-barr.com
 * Created on:	Jan 11, 2009
 *
 * Project: 		JS Jobs
 */
defined('_JEXEC') or die('Restricted access');

$document = JFactory::getDocument();
if(JVERSION < 3){
	JHtml::_('behavior.mootools');
	$document->addScript('../components/com_jsjobs/js/jquery.js');
}else{
	JHtml::_('behavior.framework');
	JHtml::_('jquery.framework');
}	
$document->addStyleSheet('components/com_jsjobs/include/css/menu.css');
$document->addScript('components/com_jsjobs/include/js/menu.js');
$layout = $this->getLayout();
$ff = JRequest::getVar('ff',0);
if($ff == 0) $ff = JRequest::getVar('fieldfor',0);
$fd = JRequest::getVar('fd',0);
switch($layout){
    case "controlpanel": case "jobtypes": case "formjobtype": case "jobstatus": case "formjobstatus": case "shifts": case "formshift": case "highesteducations": case "formhighesteducation": case "ages": case "formages": case "careerlevels": case "formcareerlevels": case "experience": case "formexperience": case "info": case "updates": case "jsjobsstats": case "currency": case "formcurrency": $tab = 0; break;
    case "jobshare": case "jobsharelog": $tab = 1; break;
    case "configurations": case "configurationsemployer": case "configurationsjobseeker": case "paymentmethodconfig": case "themes": $tab = 2; break;
    case "companies": case "view_company": case "formcompany": case "companiesqueue": case "goldcompanies": case "addtogoldcompanies": case "featuredcompanies": case "addtofeaturedcompanies": $tab = 3; break;
    case "departments": case "formdepartment": case "company_departments": case "departmentqueue": $tab = 4; break;
    case "jobqueue": case "view_job": case "jobappliedresume": case "job_searchresult": case "jobs": case "formjob": case "appliedresumes": case "goldjobs": case "featuredjobs": case "jobsearch": case "jobalert": case "formjobalert": $tab = 5; break;
    case "empapps": case "formresume": case "appqueue": case "goldresumes": case "featuredresumes": case "resumesearch": case "resume_searchresults": $tab = 6; break;
    case "employerpackages": case "formemployerpackage": case "jobseekerpackages": case "formjobseekerpackage": $tab = 7; break;
    case "employerpaymenthistory": case "employerpaymentdetails": case "jobseekerpaymenthistory": case "jobseekerpaymentdetails": case "payment_report": $tab = 8; break;
    case "messages": case "message_history": case "formmessage": case "messagesqueue": $tab = 9; break;
    case "folders": case "formfolder": case "folder_resumes": case "foldersqueue": $tab = 10; break;
    case "categories": case "formcategory": case "subcategories": case "formsubcategory": $tab = 11; break;
    case "salaryrange": case "formsalaryrange": case "salaryrangetype": case "formsalaryrangetype": $tab = 12; break;
    case "users": case "changerole": case "userstats": $tab = 13; break; case "emailtemplate": $tab = 14; break;
    case "countries": case "formcountry": case "states": case "formstate": case "cities": case "formcity": case "loadaddressdata": $tab = 15; break;
    case "view_resume": if($fd == 0) $tab = 6; else $tab = 10; break;
    case "userfields": case "fieldsordering": case "formuserfield": if(($layout == 'userfields' || $layout == 'formuserfield' || $layout == 'fieldsordering') && $ff == 2) $tab = 5; elseif(($layout == 'userfields' || $layout = 'formuserfield') && $ff == 1) $tab = 3; elseif(($layout == 'userfields' || $layout = 'formuserfield') && $ff == 3) $tab = 6; break;
    default: $tab = 0; break;
}

?>


<script type="text/javascript">
    jQuery(document).ready(function() {
        var myAccordion = new jQuery.Zebra_Accordion('.Zebra_Accordion', {
            'collapsible':  false,
            'show' : <?php echo $tab; ?>
            
        });
    });
</script>

<div style="width:225px;display:inline-block;">
    <img src="components/com_jsjobs/include/images/jsjobs_logo.png" style="width:225px;">
</div>
<dl class="Zebra_Accordion">
    <dt><img src="components/com_jsjobs/include/images/menu/admin.png" /><?php echo JText::_('JS_ADMIN'); ?></dt>
    <dd>
        <a href="index.php?option=com_jsjobs&c=jsjobs&view=jsjobs&layout=controlpanel"><?php echo JText::_('JS_CONTROL_PANEL'); ?></a>
        <a href="index.php?option=com_jsjobs&c=jobtype&view=jobtype&layout=jobtypes"><?php echo JText::_('JS_JOB_TYPES'); ?></a>
        <a href="index.php?option=com_jsjobs&c=jobstatus&view=jobstatus&layout=jobstatus"><?php echo JText::_('JS_JOB_STATUS'); ?></a>
        <a href="index.php?option=com_jsjobs&c=shift&view=shift&layout=shifts"><?php echo JText::_('JS_SHIFTS'); ?></a>
        <a href="index.php?option=com_jsjobs&c=highesteducation&view=highesteducation&layout=highesteducations"><?php echo JText::_('JS_HIGHEST_EDUCATIONS'); ?></a>
        <a href="index.php?option=com_jsjobs&c=age&view=age&layout=ages"><?php echo JText::_('JS_AGES'); ?></a>
        <a href="index.php?option=com_jsjobs&c=careerlevel&view=careerlevel&layout=careerlevels"><?php echo JText::_('JS_CAREER_LEVELS'); ?></a>
        <a href="index.php?option=com_jsjobs&c=experience&view=experience&layout=experience"><?php echo JText::_('JS_EXPERIENCE'); ?></a>
        <a href="index.php?option=com_jsjobs&c=jsjobs&view=jsjobs&layout=info"><?php echo JText::_('JS_INFORMATION'); ?></a>
        <a href="index.php?option=com_jsjobs&c=jsjobs&view=jsjobs&layout=updates"><?php echo JText::_('JS_JOB_UPDATE'); ?></a>
        <a href="index.php?option=com_jsjobs&c=jsjobs&view=jsjobs&layout=jsjobsstats"><?php echo JText::_('JS_JOBS_STATS'); ?></a>
        <a href="index.php?option=com_jsjobs&c=currency&view=currency&layout=currency"><?php echo JText::_('JS_CURRENCY'); ?></a>
    </dd>
    <dt><img src="components/com_jsjobs/include/images/menu/shearing.png" /><?php echo JText::_('SHARING_SERVICE'); ?></dt>
    <dd>
        <a href="index.php?option=com_jsjobs&c=jobsharing&view=jobsharing&layout=jobshare"><?php echo JText::_('JS_JOB_SHARE'); ?></a>
        <a href="index.php?option=com_jsjobs&c=jobsharing&view=jobsharing&layout=jobsharelog"><?php echo JText::_('JS_JOB_SHARE_LOG'); ?></a>
    </dd>
    <dt><img src="components/com_jsjobs/include/images/menu/configration.png" /><?php echo JText::_('JS_CONFIGURATIONS'); ?></dt>
    <dd>
        <a href="index.php?option=com_jsjobs&c=configuration&view=configuration&layout=configurations"><?php echo JText::_('JS_GENERAL'); ?></a>
        <a href="index.php?option=com_jsjobs&c=configuration&view=configuration&layout=configurationsemployer"><?php echo JText::_('JS_EMPLOYER'); ?></a>
        <a href="index.php?option=com_jsjobs&c=configuration&view=configuration&layout=configurationsjobseeker"><?php echo JText::_('JS_JOBSEEKER'); ?></a>
        <a href="index.php?option=com_jsjobs&c=jsjobs&view=jsjobs&layout=proversion"><?php echo JText::_('PAYMENT_METHODS_CONFIGURATION'); ?></a>
        <a href="index.php?option=com_jsjobs&c=jsjobs&view=jsjobs&layout=proversion"><?php echo JText::_('JS_THEMES'); ?></a>
    </dd>
    <dt><img src="components/com_jsjobs/include/images/menu/company.png" /><?php echo JText::_('JS_COMPANIES'); ?></dt>
    <dd>
        <a href="index.php?option=com_jsjobs&c=company&view=company&layout=companies"><?php echo JText::_('JS_COMPANIES'); ?></a>
        <a href="index.php?option=com_jsjobs&c=company&view=company&layout=companiesqueue"><?php echo JText::_('JS_APPROVAL_QUEUE'); ?></a>
        <a href="index.php?option=com_jsjobs&c=jsjobs&view=jsjobs&layout=proversion"><?php echo JText::_('JS_GOLD_COMPANIES'); ?></a>
        <a href="index.php?option=com_jsjobs&c=jsjobs&view=jsjobs&layout=proversion"><?php echo JText::_('JS_FEATURED_COMPANIES'); ?></a>
        <a href="index.php?option=com_jsjobs&c=customfield&view=customfield&layout=userfields&ff=1"><?php echo JText::_('JS_USER_FIELDS'); ?></a>
        <a href="index.php?option=com_jsjobs&c=fieldordering&view=fieldordering&layout=fieldsordering&ff=1"><?php echo JText::_('JS_FIELDS'); ?></a>
    </dd>
    <dt><img src="components/com_jsjobs/include/images/menu/departments.png" /><?php echo JText::_('JS_DEPARTMENTS'); ?></dt>
    <dd>
        <a href="index.php?option=com_jsjobs&c=department&view=department&layout=departments"><?php echo JText::_('JS_DEPARTMENTS'); ?></a>
        <a href="index.php?option=com_jsjobs&c=department&view=department&layout=departmentqueue"><?php echo JText::_('JS_APPROVAL_QUEUE'); ?></a>
    </dd>
    <dt><img src="components/com_jsjobs/include/images/menu/jobs.png" /><?php echo JText::_('JS_JOBS'); ?></dt>
    <dd>
        <a href="index.php?option=com_jsjobs&c=job&view=job&layout=jobs"><?php echo JText::_('JS_JOBS'); ?></a>
        <a href="index.php?option=com_jsjobs&c=job&view=job&layout=jobqueue"><?php echo JText::_('JS_APPROVAL_QUEUE'); ?></a>
        <a href="index.php?option=com_jsjobs&c=jobapply&view=jobapply&layout=appliedresumes"><?php echo JText::_('JS_APPLIED_RESUME'); ?></a>
        <a href="index.php?option=com_jsjobs&c=jsjobs&view=jsjobs&layout=proversion"><?php echo JText::_('JS_GOLD_JOBS'); ?></a>
        <a href="index.php?option=com_jsjobs&c=jsjobs&view=jsjobs&layout=proversion"><?php echo JText::_('JS_FEATURED_JOBS'); ?></a>
        <a href="index.php?option=com_jsjobs&c=customfield&view=customfield&layout=userfields&ff=2"><?php echo JText::_('JS_USER_FIELDS'); ?></a>
        <a href="index.php?option=com_jsjobs&c=fieldordering&view=fieldordering&layout=fieldsordering&ff=2"><?php echo JText::_('JS_FIELDS'); ?></a>
        <a href="index.php?option=com_jsjobs&c=job&view=job&layout=jobsearch"><?php echo JText::_('JS_SEARCH'); ?></a>
        <a href="index.php?option=com_jsjobs&c=jsjobs&view=jsjobs&layout=proversion"><?php echo JText::_('JS_JOB_ALERT'); ?></a>
    </dd>
    <dt><img src="components/com_jsjobs/include/images/menu/resume.png" /><?php echo JText::_('JS_RESUME'); ?></dt>
    <dd>
        <a href="index.php?option=com_jsjobs&c=resume&view=resume&layout=empapps"><?php echo JText::_('JS_RESUME'); ?></a>
        <a href="index.php?option=com_jsjobs&c=resume&view=resume&layout=appqueue"><?php echo JText::_('JS_APPROVAL_QUEUE'); ?></a>
        <a href="index.php?option=com_jsjobs&c=jsjobs&view=jsjobs&layout=proversion"><?php echo JText::_('JS_GOLD_RESUME'); ?></a>
        <a href="index.php?option=com_jsjobs&c=jsjobs&view=jsjobs&layout=proversion"><?php echo JText::_('JS_FEATURED_RESUME'); ?></a>
        <a href="index.php?option=com_jsjobs&c=customfield&view=customfield&layout=userfields&ff=3"><?php echo JText::_('JS_USER_FIELDS'); ?></a>
        <a href="index.php?option=com_jsjobs&c=fieldordering&view=fieldordering&layout=fieldsordering&ff=3"><?php echo JText::_('JS_FIELDS'); ?></a>
        <a href="index.php?option=com_jsjobs&c=resume&view=resume&layout=resumesearch"><?php echo JText::_('JS_SEARCH'); ?></a>
    </dd>
    <dt><img src="components/com_jsjobs/include/images/menu/packages.png" /><?php echo JText::_('JS_PACKAGES'); ?></dt>
    <dd>
        <a href="index.php?option=com_jsjobs&c=employerpackages&view=employerpackages&layout=employerpackages"><?php echo JText::_('JS_EMPLOYER_PACKAGES'); ?></a>
        <a href="index.php?option=com_jsjobs&c=jobseekerpackages&view=jobseekerpackages&layout=jobseekerpackages"><?php echo JText::_('JS_JOBSEEKER_PACKAGES'); ?></a>
    </dd>
    <dt><img src="components/com_jsjobs/include/images/menu/payment.png" /><?php echo JText::_('JS_PAYMENTS'); ?></dt>
    <dd>
        <a href="index.php?option=com_jsjobs&c=paymenthistory&view=paymenthistory&layout=employerpaymenthistory"><?php echo JText::_('JS_EMPLOYER_HISTORY'); ?></a>
        <a href="index.php?option=com_jsjobs&c=paymenthistory&view=paymenthistory&layout=jobseekerpaymenthistory"><?php echo JText::_('JS_JOBSEEKER_HISTORY'); ?></a>
        <a href="index.php?option=com_jsjobs&c=paymenthistory&view=paymenthistory&layout=payment_report"><?php echo JText::_('JS_PAYMENT_REPORT'); ?></a>
    </dd>
    <dt><img src="components/com_jsjobs/include/images/menu/mail.png" /><?php echo JText::_('JS_MESSAGES'); ?></dt>
    <dd>
        <a href="index.php?option=com_jsjobs&c=jsjobs&view=jsjobs&layout=proversion"><?php echo JText::_('JS_MESSAGES'); ?></a>
        <a href="index.php?option=com_jsjobs&c=jsjobs&view=jsjobs&layout=proversion"><?php echo JText::_('JS_APPROVAL_QUEUE'); ?></a>
    </dd>
    <dt><img src="components/com_jsjobs/include/images/menu/folder.png" /><?php echo JText::_('JS_FOLDERS'); ?></dt>
    <dd>
        <a href="index.php?option=com_jsjobs&c=jsjobs&view=jsjobs&layout=proversion"><?php echo JText::_('JS_FOLDERS'); ?></a>
        <a href="index.php?option=com_jsjobs&c=jsjobs&view=jsjobs&layout=proversion"><?php echo JText::_('JS_APPROVAL_QUEUE'); ?></a>
    </dd>
    <dt><img src="components/com_jsjobs/include/images/menu/category.png" /><?php echo JText::_('JS_CATEGORIES'); ?></dt>
    <dd>
        <a href="index.php?option=com_jsjobs&c=category&view=category&layout=categories"><?php echo JText::_('JS_CATEGORIES'); ?></a>
    </dd>
    <dt><img src="components/com_jsjobs/include/images/menu/salary_range.png" /><?php echo JText::_('JS_SALARYRANGE'); ?></dt>
    <dd>
        <a href="index.php?option=com_jsjobs&c=salaryrange&view=salaryrange&layout=salaryrange"><?php echo JText::_('JS_SALARYRANGE'); ?></a>
        <a href="index.php?option=com_jsjobs&c=salaryrangetype&view=salaryrangetype&layout=salaryrangetype"><?php echo JText::_('JS_SALARY_RANGE_TYPES'); ?></a>
    </dd>
    <dt><img src="components/com_jsjobs/include/images/menu/staff.png" /><?php echo JText::_('JS_USER_ROLES'); ?></dt>
    <dd>
        <a href="index.php?option=com_jsjobs&c=userrole&view=userrole&layout=users"><?php echo JText::_('JS_USERS'); ?></a>
        <a href="index.php?option=com_jsjobs&c=user&view=user&layout=userstats"><?php echo JText::_('JS_USER_STATS'); ?></a>
    </dd>
    <dt><img src="components/com_jsjobs/include/images/menu/email_tempeltes.png" /><?php echo JText::_('JS_EMAIL_TEMPLATES'); ?></dt>
    <dd>
        <a href="index.php?option=com_jsjobs&c=emailtemplate&view=emailtemplate&layout=emailtemplate&tf=ew-cm"><?php echo JText::_('JS_NEW_COMPANY'); ?></a>
        <a href="index.php?option=com_jsjobs&c=emailtemplate&view=emailtemplate&layout=emailtemplate&tf=cm-ap"><?php echo JText::_('JS_COMPANY_APPROVAL'); ?></a>
        <a href="index.php?option=com_jsjobs&c=emailtemplate&view=emailtemplate&layout=emailtemplate&tf=cm-rj"><?php echo JText::_('JS_COMPANY_REJECTING'); ?></a>
        <a href="index.php?option=com_jsjobs&c=emailtemplate&view=emailtemplate&layout=emailtemplate&tf=ew-ob"><?php echo JText::_('JS_NEW_JOB'); ?></a>
        <a href="index.php?option=com_jsjobs&c=emailtemplate&view=emailtemplate&layout=emailtemplate&tf=ob-ap"><?php echo JText::_('JS_JOB_APPROVAL'); ?></a>
        <a href="index.php?option=com_jsjobs&c=emailtemplate&view=emailtemplate&layout=emailtemplate&tf=ob-rj"><?php echo JText::_('JS_JOB_REJECTING'); ?></a>
        <a href="index.php?option=com_jsjobs&c=emailtemplate&view=emailtemplate&layout=emailtemplate&tf=ap-rs"><?php echo JText::_('JS_APPLIED_RESUME_STATUS'); ?></a>
        <a href="index.php?option=com_jsjobs&c=emailtemplate&view=emailtemplate&layout=emailtemplate&tf=ew-rm"><?php echo JText::_('JS_NEW_RESUME'); ?></a>
        <a href="index.php?option=com_jsjobs&c=emailtemplate&view=emailtemplate&layout=emailtemplate&tf=ew-ms"><?php echo JText::_('JS_NEW_MESSAGE'); ?></a>
        <a href="index.php?option=com_jsjobs&c=emailtemplate&view=emailtemplate&layout=emailtemplate&tf=rm-ap"><?php echo JText::_('JS_RESUME_APPROVAL'); ?></a>
        <a href="index.php?option=com_jsjobs&c=emailtemplate&view=emailtemplate&layout=emailtemplate&tf=rm-rj"><?php echo JText::_('JS_RESUME_REJECTING'); ?></a>
        <a href="index.php?option=com_jsjobs&c=emailtemplate&view=emailtemplate&layout=emailtemplate&tf=ba-ja"><?php echo JText::_('JS_JOB_APPLY'); ?></a>
        <a href="index.php?option=com_jsjobs&c=emailtemplate&view=emailtemplate&layout=emailtemplate&tf=ew-md"><?php echo JText::_('JS_NEW_DEPARTMENT'); ?></a>
        <a href="index.php?option=com_jsjobs&c=emailtemplate&view=emailtemplate&layout=emailtemplate&tf=ew-rp"><?php echo JText::_('JS_NEW_EMPLOYER_PACKAGE'); ?></a>
        <a href="index.php?option=com_jsjobs&c=emailtemplate&view=emailtemplate&layout=emailtemplate&tf=ew-js"><?php echo JText::_('JS_NEW_JOBSEEKER_PACKAGE'); ?></a>
        <a href="index.php?option=com_jsjobs&c=jsjobs&view=jsjobs&layout=proversion"><?php echo JText::_('JS_MESSAGE'); ?></a>
        <a href="index.php?option=com_jsjobs&c=jsjobs&view=jsjobs&layout=proversion"><?php echo JText::_('JS_JOB_ALERT'); ?></a>
        <a href="index.php?option=com_jsjobs&c=jsjobs&view=jsjobs&layout=proversion"><?php echo JText::_('JS_EMPLOYER_VISITOR_JOB'); ?></a>
        <a href="index.php?option=com_jsjobs&c=jsjobs&view=jsjobs&layout=proversion"><?php echo JText::_('JS_JOB_TO_FRIEND'); ?></a>
    </dd>
    <dt><img src="components/com_jsjobs/include/images/menu/countries.png" /><?php echo JText::_('JS_COUNTRIES'); ?></dt>
    <dd>
        <a href="index.php?option=com_jsjobs&c=country&view=country&layout=countries"><?php echo JText::_('JS_COUNTRIES'); ?></a>
        <a href="index.php?option=com_jsjobs&c=addressdata&view=addressdata&layout=loadaddressdata"><?php echo JText::_('JS_LOAD_ADDRESS_DATA'); ?></a>
    </dd>
</dl>