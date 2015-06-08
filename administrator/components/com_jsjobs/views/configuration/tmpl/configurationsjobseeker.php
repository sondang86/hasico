<?php
/**
 * @Copyright Copyright (C) 2009-2011
 * @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
  + Created by:	Ahmad Bilal
 * Company:		Buruj Solutions
  + Contact:		www.burujsolutions.com , ahmad@burujsolutions.com
 * Created on:	Jan 11, 2009
  ^
  + Project: 		JS Jobs
 * File Name:	admin-----/views/applications/tmpl/jobs.php
  ^
 * Description: Default template for jobs view
  ^
 * History:		NONE
  ^
 */
defined('_JEXEC') or die('Restricted access');
JHTML::_('behavior.formvalidation');

$document = JFactory::getDocument();

if (JVERSION < 3) {
    JHtml::_('behavior.mootools');
    $document->addScript('../components/com_jsjobs/js/jquery.js');
} else {
    JHtml::_('behavior.framework');
    JHtml::_('jquery.framework');
}
$document->addScript('components/com_jsjobs/include/js/jquery_idTabs.js');
$document->addStyleSheet(JURI::root() . 'administrator/components/com_jsjobs/include/css/jsjobsadmin.css');

global $mainframe;
?>
<script language="javascript">
    jQuery(document).ready(function() {
        var value = jQuery("#showapplybutton").val();
        var divsrc = "div#showhideapplybutton";
        if (value == 2) {
            jQuery(divsrc).slideDown("slow");
        }
    });
    function showhideapplybutton(src, value) {
        var divsrc = "div#" + src;
        if (value == 2) {
            jQuery(divsrc).slideDown("slow");
        } else if (value == 1) {
            jQuery(divsrc).slideUp("slow");
            jQuery(divsrc).hide();
        }
        return true;
    }


// for joomla 1.6
    Joomla.submitbutton = function(task) {
        if (task == '') {
            return false;
        } else {
            if (task == 'configuration.save') {
                returnvalue = validate_form(document.adminForm);
            } else
                returnvalue = true;
            if (returnvalue) {
                Joomla.submitform(task);
                return true;
            } else
                return false;
        }
    }
    function validate_form(f)
    {
        if (document.formvalidator.isValid(f)) {
            f.check.value = '<?php if (JVERSION < '3') echo JUtility::getToken();
else echo JSession::getFormToken(); ?>';//send token
        } else {
            alert('<?php echo JText::_('JS_SOME_VALUES_ARE_NOT_ACCEPTABLE_PLEASE_CHECK_ALL_TABS'); ?>');
            return false;
        }
        return true;
    }
</script>

<?php
$ADMINPATH = JPATH_BASE . '\components\com_jsjobs';

$yesno = array(
    '0' => array('value' => 1,
        'text' => JText::_('Yes')),
    '1' => array('value' => 0,
        'text' => JText::_('No')),);

$showhide = array(
    '0' => array('value' => 1,
        'text' => JText::_('Show')),
    '1' => array('value' => 0,
        'text' => JText::_('Hide')),);

$applybutton = array(
    '0' => array('value' => 1,
        'text' => JText::_('JS_ENABLE')),
    '1' => array('value' => 2,
        'text' => JText::_('JS_DISABLE_AND_REDIRECT')),);




$big_field_width = 40;
$med_field_width = 25;
$sml_field_width = 15;
?>

<table width="100%" >
    <tr>
        <td align="left" width="188"  valign="top">
            <table width="100%" style="table-layout:fixed;"><tr><td style="vertical-align:top;">
<?php
include_once('components/com_jsjobs/views/menu.php');
?>
                    </td>
                </tr></table>
        </td>
        <td width="789" valign="top" align="left">
            <div id="jsjobs_info_heading"><?php echo JText::_('JS_JOBSEEKER_CONFIGURATION'); ?></div>	

            <form action="index.php" method="POST" name="adminForm" id="adminForm">
                <input type="hidden" name="check" value="post"/>
                <div id="tabs_wrapper" class="tabs_wrapper">
                    <div class="idTabs">

                        <span><a class="selected" href="#js_generalsetting"><?php echo JText::_('JS_GENERAL_SETTINGS'); ?></a></span> 
                        <span><a  href="#js_visitor"><?php echo JText::_('JS_VISITORS'); ?></a></span> 
                        <span><a  href="#js_jobsearch"><?php echo JText::_('JS_JOB_SEARCH'); ?></a></span> 
                        <span><a  href="#js_memberlinks"><?php echo JText::_('JS_MEMBERS_LINKS'); ?></a></span> 
                        <span><a  href="#js_visitorlinks"><?php echo JText::_('JS_VISITOR_LINKS'); ?></a></span> 
                        <span><a  href="#email"><?php echo JText::_('JS_EMAIL'); ?></a></span> 
                    </div>
                    <div id="js_generalsetting">
                        <fieldset>
                            <legend><?php echo JText::_('JS_GENERAL_SETTINGS'); ?></legend>
                            <table cellpadding="5" cellspacing="1" border="0" width="100%" class="admintable" >
                                <tr>
                                    <td  class="key" width="25%"><?php echo JText::_('JS_PACKAGE_REQUIRED_FOR_JOBSEEKER'); ?></td>
                                    <td ><?php echo JHTML::_('select.genericList', $yesno, 'js_newlisting_requiredpackage', 'class="inputbox" ' . '', 'value', 'text', $this->config['js_newlisting_requiredpackage']);
; ?></td>
                                    <td  class="key" width="25%"><?php echo JText::_('JS_SHOW_APPLIED_RESUME_STATUS'); ?></td>
                                    <td width="25%"><?php echo JHTML::_('select.genericList', $yesno, 'show_applied_resume_status', 'class="inputbox" ' . '', 'value', 'text', $this->config['show_applied_resume_status']); ?></td>
                                </tr>
                                <tr >
                                    <td  class="key"><?php echo JText::_('JS_RESUME_AUTO_APPROVE'); ?></td>
                                    <td><?php echo JHTML::_('select.genericList', $yesno, 'empautoapprove', 'class="inputbox" ' . '', 'value', 'text', $this->config['empautoapprove']); ?></td>
                                    <td  class="key"><?php echo JText::_('JS_JOB_SEEKER_PHOTO_MAXIMUM_SIZE'); ?></td>
                                    <td><input type="text" name="resume_photofilesize" value="<?php echo $this->config['resume_photofilesize']; ?>" class="inputbox validate-numeric" maxlength="6" size="<?php echo $med_field_width; ?>" /> &nbsp;KB</td>
                                </tr>
                                <tr>
                                    <td class="key" ><?php echo JText::_('JS_JOB_ALERT_FOR_VISITORS'); ?></td>
                                    <td><?php echo JHTML::_('select.genericList', $yesno, 'overwrite_jobalert_settings', 'class="inputbox" ' . '', 'value', 'text', $this->config['overwrite_jobalert_settings']); ?> </td>
                                    <td  class="key" width="25%"><?php echo JText::_('JS_JOB_ALERT_AUTO_APPROVE'); ?></td>
                                    <td ><?php echo JHTML::_('select.genericList', $yesno, 'jobalert_auto_approve', 'class="inputbox" ' . '', 'value', 'text', $this->config['jobalert_auto_approve']);
; ?></td>
                                </tr>
                                <tr>
                                    <td class="key" width="25%"><?php echo JText::_('JS_SHOW_APPLY_BUTTON'); ?></td>
                                    <td  width="25%"><?php echo JHTML::_('select.genericList', $applybutton, 'showapplybutton', 'class="inputbox"' . 'onChange="showhideapplybutton(\'showhideapplybutton\', this.value)"', 'value', 'text', $this->config['showapplybutton']); ?></td>
                                    <td nowrap="nowrap">
                                        <div id="showhideapplybutton" style="display:none">
                                            <input type="text" id="apllybuttonshow" name="applybuttonredirecturl" class="inputbox required" value="<?php echo $this->config['applybuttonredirecturl']; ?>" size="<?php echo $big_field_width; ?>" >
                                            <small><?php echo JText::_('JS_AAPLY_NOW_REDIRECT_LINK'); ?></small>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="key" width="25%"><?php echo JText::_('JS_SHOW_GOLD_JOBS_IN_SEARCH_JOBS_RESULT'); ?></td>
                                    <td  width="25%"><?php echo JHTML::_('select.genericList', $yesno, 'showgoldjobsinsearchjobs', 'class="inputbox" ' . '', 'value', 'text', $this->config['showgoldjobsinsearchjobs']); ?></td>
                                    <td><small><?php echo JText::_('JS_GOLD_JOBS_SHOWS_IN_JOBS_SEARCH_RESULT'); ?></small></td>
                                </tr>
                                <tr>
                                    <td class="key" width="25%"><?php echo JText::_('JS_SHOW_FEATURED_JOBS_IN_SEARCH_JOBS_RESULT'); ?></td>
                                    <td  width="25%"><?php echo JHTML::_('select.genericList', $yesno, 'showfeaturedjobsinsearchjobs', 'class="inputbox" ' . '', 'value', 'text', $this->config['showfeaturedjobsinsearchjobs']); ?></td>
                                    <td><small><?php echo JText::_('JS_FEATURED_JOBS_SHOWS_IN_JOBS_SEARCH_RESULTS'); ?></small></td>
                                </tr>
                                <tr >
                                    <td class="key" width="25%"><?php echo JText::_('JS_SHOW_NO_OF_GOLD_JOBS'); ?></td>
                                    <td  width="25%">
                                        <input type="text" name="noofgoldjobsinsearch" value="<?php echo $this->config['noofgoldjobsinsearch']; ?>" class="inputbox validate-numeric" maxlength="6" size="<?php echo $med_field_width; ?>" />
                                    </td>
                                    <td>
                                        <small><?php echo JText::_('JS_SHOW_GOLD_JOB_IN_JOB_SEARCH_RESULT'); ?></small>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="key" width="25%"><?php echo JText::_('JS_SHOW_NO_OF_FEATURED_JOBS'); ?></td>
                                    <td  width="25%">
                                        <input type="text" name="nooffeaturedjobsinsearch" value="<?php echo $this->config['nooffeaturedjobsinsearch']; ?>" class="inputbox validate-numeric" maxlength="6" size="<?php echo $med_field_width; ?>" />
                                    </td>
                                    <td>
                                        <small><?php echo JText::_('JS_SHOW_FEATURED_JOB_IN_JOB_SEARCH_RESULT'); ?></small>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="key" width="25%"><?php echo JText::_('JS_SHOW_LOGIN_LOGOUT_BUTTON'); ?></td>
                                    <td><?php echo JHTML::_('select.genericList', $yesno, 'jobsloginlogout', 'class="inputbox" ' . '', 'value', 'text', $this->config['jobsloginlogout']); ?> </td>
                                    <td>
                                        <small><?php echo JText::_('JS_SHOW_LOGIN_LOGOUT_JOBSEEKER_CONTROLPANEL'); ?></small>
                                    </td>
                                </tr>

                            </table>
                        </fieldset>
                    </div>
                    <div id="js_visitor">
                        <fieldset>
                            <legend><?php echo JText::_('JS_JOBSEEKER'); ?></legend>
                            <table cellpadding="5" cellspacing="1" border="0" width="100%" class="admintable" >
                                <tr>
                                    <td class="key" width="25%"><?php echo JText::_('JS_VISITOR_CAN_APPLY_TO_JOB'); ?></td>
                                    <td  width="25%"><?php echo JHTML::_('select.genericList', $yesno, 'visitor_can_apply_to_job', 'class="inputbox" ' . '', 'value', 'text', $this->config['visitor_can_apply_to_job']); ?></td>
                                    <td  width="25%" class="key"><?php echo JText::_('JS_SHOW_LOGIN_MESSAGE_TO_VISITOR'); ?></td>
                                    <td width="25%"><?php echo JHTML::_('select.genericList', $yesno, 'visitor_show_login_message', 'class="inputbox" ' . '', 'value', 'text', $this->config['visitor_show_login_message']); ?></td>
                                </tr>
                                <tr >
                                    <td class="key" width="25%"><?php echo JText::_('JS_RESUME_CAPTCHA'); ?></td>
                                    <td  width="25%"><?php echo JHTML::_('select.genericList', $yesno, 'resume_captcha', 'class="inputbox" ' . '', 'value', 'text', $this->config['resume_captcha']); ?><br clear="all"/>
                                        <small><?php echo JText::_('JS_SHOW_CAPTCHA_ON_VISITOR_FORM_RESUME'); ?></small></td>
                                    <td class="key" width="25%"><?php echo JText::_('JS_JOB_ALERT_CAPTCHA'); ?></td>
                                    <td  width="25%"><?php echo JHTML::_('select.genericList', $yesno, 'job_alert_captcha', 'class="inputbox" ' . '', 'value', 'text', $this->config['job_alert_captcha']); ?><br clear="all"/>
                                        <small><?php echo JText::_('JS_SHOW_CAPTCHA_ON_VISITOR_JOB_ALERT_FORM'); ?></small></td>
                                </tr>
                            </table>
                        </fieldset>
                        <table  class="adminform">
                            <tr><td allign="center"><strong> <?php echo JText::_('JS_VISITORS_CAN_VIEW'); ?></strong>
                                </td></tr>
                        </table>
                        <fieldset>
                            <legend><?php echo JText::_('JS_JOBSEEKER'); ?></legend>
                            <table cellpadding="5" cellspacing="1" border="0" width="100%" class="admintable" >
                                <tr >
                                    <td class="key" width="25%"><?php echo JText::_('JS_CONTROL_PANEL'); ?></td>
                                    <td  width="25%"><?php echo JHTML::_('select.genericList', $showhide, 'visitorview_js_controlpanel', 'class="inputbox" ' . '', 'value', 'text', $this->config['visitorview_js_controlpanel']); ?></td>
                                    <td  width="25%" class="key"><?php echo JText::_('JS_PACKAGES'); ?></td>
                                    <td width="25%"><?php echo JHTML::_('select.genericList', $showhide, 'visitorview_js_packages', 'class="inputbox" ' . '', 'value', 'text', $this->config['visitorview_js_packages']); ?></td>
                                </tr>
                                <tr>
                                    <td class="key" ><?php echo JText::_('JS_JOB_CATEGORIES'); ?></td>
                                    <td ><?php echo JHTML::_('select.genericList', $showhide, 'visitorview_js_jobcat', 'class="inputbox" ' . '', 'value', 'text', $this->config['visitorview_js_jobcat']); ?></td>
                                    <td class="key"><?php echo JText::_('JS_PACKAGE_DETAIL'); ?></td>
                                    <td><?php echo JHTML::_('select.genericList', $showhide, 'visitorview_js_viewpackage', 'class="inputbox" ' . '', 'value', 'text', $this->config['visitorview_js_viewpackage']); ?></td>
                                </tr>
                                <tr>
                                    <td class="key" ><?php echo JText::_('JS_NEWEST_JOBS'); ?></td>
                                    <td><?php echo JHTML::_('select.genericList', $showhide, 'visitorview_js_newestjobs', 'class="inputbox" ' . '', 'value', 'text', $this->config['visitorview_js_newestjobs']); ?></td>
                                    <td class="key"><?php echo JText::_('JS_LISTJOB'); ?></td>
                                    <td><?php echo JHTML::_('select.genericList', $showhide, 'visitorview_js_listjob', 'class="inputbox" ' . '', 'value', 'text', $this->config['visitorview_js_listjob']); ?></td>
                                </tr>
                                <tr>
                                    <td class="key"><?php echo JText::_('JS_JOB_SEARCH'); ?></td>
                                    <td><?php echo JHTML::_('select.genericList', $showhide, 'visitorview_js_jobsearch', 'class="inputbox" ' . '', 'value', 'text', $this->config['visitorview_js_jobsearch']); ?></td>
                                    <td class="key"><?php echo JText::_('JS_JOB_SEARCHREULTS'); ?></td>
                                    <td><?php echo JHTML::_('select.genericList', $showhide, 'visitorview_js_jobsearchresult', 'class="inputbox" ' . '', 'value', 'text', $this->config['visitorview_js_jobsearchresult']); ?></td>
                                </tr>
                                <tr>
                                    <td class="key"><?php echo JText::_('JS_VIEW_JOB'); ?></td>
                                    <td><?php echo JHTML::_('select.genericList', $showhide, 'visitorview_emp_viewjob', 'class="inputbox" ' . '', 'value', 'text', $this->config['visitorview_emp_viewjob']); ?></td>
                                    <td class="key"><?php echo JText::_('JS_VIEW_COMPANY'); ?></td>
                                    <td><?php echo JHTML::_('select.genericList', $showhide, 'visitorview_emp_viewcompany', 'class="inputbox" ' . '', 'value', 'text', $this->config['visitorview_emp_viewcompany']); ?></td>
                                </tr>
                            </table>
                        </fieldset>
                    </div>
                    <div id="js_jobsearch">
                        <fieldset>
                            <legend><?php echo JText::_('JS_SEARCH_JOB_SEETINGS'); ?></legend>
                            <table cellpadding="5" cellspacing="1" border="0" width="100%" class="admintable" >
                                <tr>
                                    <td class="key" width="25%"><?php echo JText::_('JS_ALLOW_SAVE_SEARCH'); ?></td>
                                    <td width="25%"><?php echo JHTML::_('select.genericList', $yesno, 'search_job_showsave', 'class="inputbox" ' . '', 'value', 'text', $this->config['search_job_showsave']); ?></td>
                                    <td width="25%" class="key"><?php echo JText::_('JS_SHIFT'); ?></td>
                                    <td width="25%"><?php echo JHTML::_('select.genericList', $showhide, 'search_job_shift', 'class="inputbox" ' . '', 'value', 'text', $this->config['search_job_shift']); ?></td>
                                </tr>
                                <tr >
                                    <td class="key" ><?php echo JText::_('JS_TITLE'); ?></td>
                                    <td ><?php echo JHTML::_('select.genericList', $showhide, 'search_job_title', 'class="inputbox" ' . '', 'value', 'text', $this->config['search_job_title']); ?></td>
                                    <td class="key"><?php echo JText::_('JS_DURATION'); ?></td>
                                    <td><?php echo JHTML::_('select.genericList', $showhide, 'search_job_durration', 'class="inputbox" ' . '', 'value', 'text', $this->config['search_job_durration']); ?></td>
                                </tr>
                                <tr >
                                    <td class="key" ><?php echo JText::_('JS_CATEGORY'); ?></td>
                                    <td><?php echo JHTML::_('select.genericList', $showhide, 'search_job_category', 'class="inputbox" ' . '', 'value', 'text', $this->config['search_job_category']); ?></td>
                                    <td class="key"><?php echo JText::_('JS_START_PUBLISHING'); ?></td>
                                    <td align="left" valign="top"><?php echo JHTML::_('select.genericList', $showhide, 'search_job_startpublishing', 'class="inputbox" ' . '', 'value', 'text', $this->config['search_job_startpublishing']); ?></td>
                                </tr>
                                <tr >
                                    <td class="key"><?php echo JText::_('JS_JOBTYPE'); ?></td>
                                    <td><?php echo JHTML::_('select.genericList', $showhide, 'search_job_type', 'class="inputbox" ' . '', 'value', 'text', $this->config['search_job_type']); ?></td>
                                    <td class="key"><?php echo JText::_('JS_STOP_PUBLISHING'); ?></td>
                                    <td><?php echo JHTML::_('select.genericList', $showhide, 'search_job_stoppublishing', 'class="inputbox" ' . '', 'value', 'text', $this->config['search_job_stoppublishing']); ?></td>
                                </tr>
                                <tr >
                                    <td class="key"><?php echo JText::_('JS_JOB_STATUS'); ?></td>
                                    <td><?php echo JHTML::_('select.genericList', $showhide, 'search_job_status', 'class="inputbox" ' . '', 'value', 'text', $this->config['search_job_status']); ?></td>
                                    <td class="key"><?php echo JText::_('JS_COMPANY'); ?></td>
                                    <td><?php echo JHTML::_('select.genericList', $showhide, 'search_job_company', 'class="inputbox" ' . '', 'value', 'text', $this->config['search_job_company']); ?></td>

                                </tr>
                                <tr >
                                    <td class="key"><?php echo JText::_('JS_SALARY_RANGE'); ?></td>
                                    <td><?php echo JHTML::_('select.genericList', $showhide, 'search_job_salaryrange', 'class="inputbox" ' . '', 'value', 'text', $this->config['search_job_salaryrange']); ?></td>
                                    <td class="key"><?php echo JText::_('JS_CITY'); ?></td>
                                    <td><?php echo JHTML::_('select.genericList', $showhide, 'search_job_city', 'class="inputbox" ' . '', 'value', 'text', $this->config['search_job_city']); ?></td>
                                </tr>
                                <tr >
                                    <td class="key" ><?php echo JText::_('JS_SUB_CATEGORY'); ?></td>
                                    <td><?php echo JHTML::_('select.genericList', $showhide, 'search_job_subcategory', 'class="inputbox" ' . '', 'value', 'text', $this->config['search_job_subcategory']); ?></td>
                                    <td class="key"><?php echo JText::_('JS_ZIP_CODE'); ?></td>
                                    <td><?php echo JHTML::_('select.genericList', $showhide, 'search_job_zipcode', 'class="inputbox" ' . '', 'value', 'text', $this->config['search_job_zipcode']); ?></td>
                                </tr>
                                <tr >
                                    <td class="key" ><?php echo JText::_('JS_KEYWORDS'); ?></td>
                                    <td><?php echo JHTML::_('select.genericList', $showhide, 'search_job_keywords', 'class="inputbox" ' . '', 'value', 'text', $this->config['search_job_keywords']); ?></td>
                                    <td class="key"><?php echo JText::_('JS_MAP_COORDINATES'); ?></td>
                                    <td><?php echo JHTML::_('select.genericList', $showhide, 'search_job_coordinates', 'class="inputbox" ' . '', 'value', 'text', $this->config['search_job_coordinates']); ?></td>
                                </tr>
                                <tr >
                                    <td class="key"><?php echo JText::_('JS_COMPANY_SITE'); ?></td>
                                    <td><?php echo JHTML::_('select.genericList', $showhide, 'search_job_companysite', 'class="inputbox" ' . '', 'value', 'text', $this->config['search_job_companysite']); ?></td>
                                </tr>
                            </table>
                        </fieldset>
                    </div>
                    <div id="js_memberlinks">
                        <fieldset>
                            <legend><?php echo JText::_('JS_JOBSEEKER_TOP_LINKS') ?></legend>
                            <table cellpadding="5" cellspacing="1" border="0" width="100%" class="admintable" >
                                <tr >
                                    <td class="key" width="25%"><?php echo JText::_('JS_CONTROL_PANEL'); ?></td>
                                    <td  width="25%"><?php echo JHTML::_('select.genericList', $showhide, 'tmenu_jscontrolpanel', 'class="inputbox" ' . '', 'value', 'text', $this->config['tmenu_jscontrolpanel']);
; ?></td>
                                    <td  width="25%" class="key"><?php echo JText::_('JS_JOB_CATEGORIES'); ?></td>
                                    <td  width="25%"><?php echo JHTML::_('select.genericList', $showhide, 'tmenu_jsjobcategory', 'class="inputbox" ' . '', 'value', 'text', $this->config['tmenu_jsjobcategory']);
; ?></td>
                                </tr>
                                <tr>
                                    <td class="key" ><?php echo JText::_('JS_SEARCH_JOB'); ?></td>
                                    <td ><?php echo JHTML::_('select.genericList', $showhide, 'tmenu_jssearchjob', 'class="inputbox" ' . '', 'value', 'text', $this->config['tmenu_jssearchjob']);
; ?></td>
                                    <td class="key"><?php echo JText::_('JS_NEWEST_JOBS'); ?></td>
                                    <td ><?php echo JHTML::_('select.genericList', $showhide, 'tmenu_jsnewestjob', 'class="inputbox" ' . '', 'value', 'text', $this->config['tmenu_jsnewestjob']);
; ?></td>
                                </tr>
                                <tr>
                                    <td class="key" ><?php echo JText::_('JS_MY_RESUMES'); ?></td>
                                    <td ><?php echo JHTML::_('select.genericList', $showhide, 'tmenu_jsmyresume', 'class="inputbox" ' . '', 'value', 'text', $this->config['tmenu_jsmyresume']);
; ?></td>
                                    <td class="key" ><?php echo JText::_('JS_ADD_RESUME'); ?></td>
                                    <td ><?php echo JHTML::_('select.genericList', $showhide, 'tmenu_jsaddresume', 'class="inputbox" ' . '', 'value', 'text', $this->config['tmenu_jsaddresume']);
; ?></td>
                                </tr>
                                <tr>
                                    <td class="key" ><?php echo JText::_('JS_ADD_COVER_LETTER'); ?></td>
                                    <td ><?php echo JHTML::_('select.genericList', $showhide, 'tmenu_jsaddcoverletter', 'class="inputbox" ' . '', 'value', 'text', $this->config['tmenu_jsaddcoverletter']);
; ?></td>
                                    <td ></td>
                                    <td ></td>
                                </tr>
                            </table>
                        </fieldset>
                        <fieldset>
                            <legend><?php echo JText::_('JS_JOBSEEKER_CONTROL_PANEL_LINKS') ?></legend>
                            <table cellpadding="5" cellspacing="1" border="0" width="100%" class="admintable" >
                                <tr >
                                    <td class="key" width="25%"><?php echo JText::_('JS_ADD_RESUME'); ?></td>
                                    <td  width="25%"><?php echo JHTML::_('select.genericList', $showhide, 'formresume', 'class="inputbox" ' . '', 'value', 'text', $this->config['formresume']);
; ?></td>
                                    <td  width="25%" class="key"><?php echo JText::_('JS_JOBS_BY_CATEGORIES'); ?></td>
                                    <td  width="25%"><?php echo JHTML::_('select.genericList', $showhide, 'jobcat', 'class="inputbox" ' . '', 'value', 'text', $this->config['jobcat']);
; ?></td>
                                </tr>
                                <tr>
                                    <td class="key" ><?php echo JText::_('JS_MY_RESUMES'); ?></td>
                                    <td ><?php echo JHTML::_('select.genericList', $showhide, 'myresumes', 'class="inputbox" ' . '', 'value', 'text', $this->config['myresumes']);
; ?></td>
                                    <td class="key"><?php echo JText::_('JS_NEWEST_JOBS'); ?></td>
                                    <td ><?php echo JHTML::_('select.genericList', $showhide, 'listnewestjobs', 'class="inputbox" ' . '', 'value', 'text', $this->config['listnewestjobs']);
; ?></td>
                                </tr>
                                <tr>
                                    <td class="key" ><?php echo JText::_('JS_ADD_COVER_LETTER'); ?></td>
                                    <td ><?php echo JHTML::_('select.genericList', $showhide, 'formcoverletter', 'class="inputbox" ' . '', 'value', 'text', $this->config['formcoverletter']);
; ?></td>
                                    <td class="key"><?php echo JText::_('JS_MY_APPLIED_JOBS'); ?></td>
                                    <td ><?php echo JHTML::_('select.genericList', $showhide, 'myappliedjobs', 'class="inputbox" ' . '', 'value', 'text', $this->config['myappliedjobs']);
; ?></td>
                                </tr>
                                <tr>
                                    <td class="key"><?php echo JText::_('JS_MY_COVER_LETTERS'); ?></td>
                                    <td ><?php echo JHTML::_('select.genericList', $showhide, 'mycoverletters', 'class="inputbox" ' . '', 'value', 'text', $this->config['mycoverletters']);
; ?></td>
                                    <td class="key"><?php echo JText::_('JS_SEARCH_JOB'); ?></td>
                                    <td ><?php echo JHTML::_('select.genericList', $showhide, 'jobsearch', 'class="inputbox" ' . '', 'value', 'text', $this->config['jobsearch']);
; ?></td>
                                </tr>
                                <tr>
                                    <td class="key"><?php echo JText::_('JS_PACKAGES'); ?></td>
                                    <td ><?php echo JHTML::_('select.genericList', $showhide, 'jspackages', 'class="inputbox" ' . '', 'value', 'text', $this->config['jspackages']);
; ?></td>
                                    <td class="key"><?php echo JText::_('JS_JOB_SAVE_SEARCHES'); ?></td>
                                    <td ><?php echo JHTML::_('select.genericList', $showhide, 'my_jobsearches', 'class="inputbox" ' . '', 'value', 'text', $this->config['my_jobsearches']);
; ?></td>
                                </tr>
                                <tr>
                                    <td class="key"><?php echo JText::_('JS_PURCHASE_HISTORY'); ?></td>
                                    <td ><?php echo JHTML::_('select.genericList', $showhide, 'jspurchasehistory', 'class="inputbox" ' . '', 'value', 'text', $this->config['jspurchasehistory']);
; ?></td>
                                    <td class="key"><?php echo JText::_('JS_MY_STATS'); ?></td>
                                    <td ><?php echo JHTML::_('select.genericList', $showhide, 'jsmy_stats', 'class="inputbox" ' . '', 'value', 'text', $this->config['jsmy_stats']);
; ?></td>
                                </tr>
                                <tr>
                                    <td class="key"><?php echo JText::_('JS_JOB_ALERT'); ?></td>
                                    <td ><?php echo JHTML::_('select.genericList', $showhide, 'jobalertsetting', 'class="inputbox" ' . '', 'value', 'text', $this->config['jobalertsetting']);
; ?></td>
                                    <td class="key"><?php echo JText::_('JS_MESSAGES'); ?></td>
                                    <td ><?php echo JHTML::_('select.genericList', $showhide, 'jsmessages', 'class="inputbox" ' . '', 'value', 'text', $this->config['jsmessages']);
; ?></td>
                                </tr>
                                <tr>
                                    <td class="key"><?php echo JText::_('JS_JOBS_RSS'); ?></td>
                                    <td ><?php echo JHTML::_('select.genericList', $showhide, 'jsjob_rss', 'class="inputbox" ' . '', 'value', 'text', $this->config['jsjob_rss']);
; ?></td>
                                    <td class="key"><?php echo JText::_('JS_EXPIRE_PACKAGE_MESSAGE'); ?></td>
                                    <td ><?php echo JHTML::_('select.genericList', $showhide, 'jsexpire_package_message', 'class="inputbox" ' . '', 'value', 'text', $this->config['jsexpire_package_message']);
; ?></td>
                                </tr>
                                <tr>
                                    <td class="key"><?php echo JText::_('JS_JOBSEEKER_REGISTRATION'); ?></td>
                                    <td ><?php echo JHTML::_('select.genericList', $showhide, 'jsregister', 'class="inputbox" ' . '', 'value', 'text', $this->config['jsregister']);
; ?></td>
                                    <td></td><td></td>
                                </tr>
                            </table>
                        </fieldset>
                    </div>
                    <div id="js_visitorlinks">
                        <fieldset>
                            <legend><?php echo JText::_('JS_JOBSEEKER_TOP_LINKS') ?></legend>
                            <table cellpadding="5" cellspacing="1" border="0" width="100%" class="admintable" >
                                <tr >
                                    <td class="key" width="25%"><?php echo JText::_('JS_CONTROL_PANEL'); ?></td>
                                    <td  width="25%"><?php echo JHTML::_('select.genericList', $showhide, 'tmenu_vis_jscontrolpanel', 'class="inputbox" ' . '', 'value', 'text', $this->config['tmenu_vis_jscontrolpanel']);
; ?></td>
                                    <td  width="25%" class="key"><?php echo JText::_('JS_JOB_CATEGORIES'); ?></td>
                                    <td  width="25%"><?php echo JHTML::_('select.genericList', $showhide, 'tmenu_vis_jsjobcategory', 'class="inputbox" ' . '', 'value', 'text', $this->config['tmenu_vis_jsjobcategory']);
; ?></td>
                                </tr>
                                <tr>
                                    <td class="key" ><?php echo JText::_('JS_SEARCH_JOB'); ?></td>
                                    <td ><?php echo JHTML::_('select.genericList', $showhide, 'tmenu_vis_jssearchjob', 'class="inputbox" ' . '', 'value', 'text', $this->config['tmenu_vis_jssearchjob']);
; ?></td>
                                    <td class="key"><?php echo JText::_('JS_NEWEST_JOBS'); ?></td>
                                    <td ><?php echo JHTML::_('select.genericList', $showhide, 'tmenu_vis_jsnewestjob', 'class="inputbox" ' . '', 'value', 'text', $this->config['tmenu_vis_jsnewestjob']);
; ?></td>
                                </tr>
                                <tr>
                                    <td class="key" ><?php echo JText::_('JS_MY_RESUMES'); ?></td>
                                    <td ><?php echo JHTML::_('select.genericList', $showhide, 'tmenu_vis_jsmyresume', 'class="inputbox" ' . '', 'value', 'text', $this->config['tmenu_vis_jsmyresume']);
; ?></td>
                                </tr>
                                <tr>
                                </tr>
                            </table>
                        </fieldset>
                        <fieldset>
                            <legend><?php echo JText::_('JS_JOBSEEKER_CONTROL_PANEL_LINKS') ?></legend>
                            <table cellpadding="5" cellspacing="1" border="0" width="100%" class="admintable" >
                                <tr >
                                    <td class="key" width="25%"><?php echo JText::_('JS_ADD_RESUME'); ?></td>
                                    <td  width="25%"><?php echo JHTML::_('select.genericList', $showhide, 'vis_jsformresume', 'class="inputbox" ' . '', 'value', 'text', $this->config['vis_jsformresume']);
; ?></td>
                                    <td  width="25%" class="key"><?php echo JText::_('JS_JOBS_BY_CATEGORIES'); ?></td>
                                    <td  width="25%"><?php echo JHTML::_('select.genericList', $showhide, 'vis_jsjobcat', 'class="inputbox" ' . '', 'value', 'text', $this->config['vis_jsjobcat']);
; ?></td>
                                </tr>
                                <tr>
                                    <td class="key" ><?php echo JText::_('JS_MY_RESUMES'); ?></td>
                                    <td ><?php echo JHTML::_('select.genericList', $showhide, 'vis_jsmyresumes', 'class="inputbox" ' . '', 'value', 'text', $this->config['vis_jsmyresumes']);
; ?></td>
                                    <td class="key"><?php echo JText::_('JS_NEWEST_JOBS'); ?></td>
                                    <td ><?php echo JHTML::_('select.genericList', $showhide, 'vis_jslistnewestjobs', 'class="inputbox" ' . '', 'value', 'text', $this->config['vis_jslistnewestjobs']);
; ?></td>
                                </tr>
                                <tr>
                                    <td class="key" ><?php echo JText::_('JS_ADD_COVER_LETTER'); ?></td>
                                    <td ><?php echo JHTML::_('select.genericList', $showhide, 'vis_jsformcoverletter', 'class="inputbox" ' . '', 'value', 'text', $this->config['vis_jsformcoverletter']);
; ?></td>
                                    <td class="key"><?php echo JText::_('JS_MY_APPLIED_JOBS'); ?></td>
                                    <td ><?php echo JHTML::_('select.genericList', $showhide, 'vis_jsmyappliedjobs', 'class="inputbox" ' . '', 'value', 'text', $this->config['vis_jsmyappliedjobs']);
; ?></td>
                                </tr>
                                <tr>
                                    <td class="key"><?php echo JText::_('JS_MY_COVER_LETTERS'); ?></td>
                                    <td ><?php echo JHTML::_('select.genericList', $showhide, 'vis_jsmycoverletters', 'class="inputbox" ' . '', 'value', 'text', $this->config['vis_jsmycoverletters']);
; ?></td>
                                    <td class="key"><?php echo JText::_('JS_SEARCH_JOB'); ?></td>
                                    <td ><?php echo JHTML::_('select.genericList', $showhide, 'vis_jsjobsearch', 'class="inputbox" ' . '', 'value', 'text', $this->config['vis_jsjobsearch']);
; ?></td>
                                </tr>
                                <tr>
                                    <td class="key"><?php echo JText::_('JS_PACKAGES'); ?></td>
                                    <td ><?php echo JHTML::_('select.genericList', $showhide, 'vis_jspackages', 'class="inputbox" ' . '', 'value', 'text', $this->config['vis_jspackages']);
; ?></td>
                                    <td class="key"><?php echo JText::_('JS_JOB_SAVE_SEARCHES'); ?></td>
                                    <td ><?php echo JHTML::_('select.genericList', $showhide, 'vis_jsmy_jobsearches', 'class="inputbox" ' . '', 'value', 'text', $this->config['vis_jsmy_jobsearches']);
; ?></td>
                                </tr>
                                <tr>
                                    <td class="key"><?php echo JText::_('JS_PURCHASE_HISTORY'); ?></td>
                                    <td ><?php echo JHTML::_('select.genericList', $showhide, 'vis_jspurchasehistory', 'class="inputbox" ' . '', 'value', 'text', $this->config['vis_jspurchasehistory']);
; ?></td>
                                    <td class="key"><?php echo JText::_('JS_MY_STATS'); ?></td>
                                    <td ><?php echo JHTML::_('select.genericList', $showhide, 'vis_jsmy_stats', 'class="inputbox" ' . '', 'value', 'text', $this->config['vis_jsmy_stats']);
; ?></td>
                                </tr>
                                <tr>
                                    <td class="key"><?php echo JText::_('JS_JOB_ALERT'); ?></td>
                                    <td ><?php echo JHTML::_('select.genericList', $showhide, 'vis_jsjobalertsetting', 'class="inputbox" ' . '', 'value', 'text', $this->config['vis_jsjobalertsetting']);
; ?></td>
                                    <td class="key"><?php echo JText::_('JS_MESSAGES'); ?></td>
                                    <td ><?php echo JHTML::_('select.genericList', $showhide, 'vis_jsmessages', 'class="inputbox" ' . '', 'value', 'text', $this->config['vis_jsmessages']);
; ?></td>
                                </tr>
                                <tr>
                                    <td class="key"><?php echo JText::_('JS_JOBS_RSS'); ?></td>
                                    <td ><?php echo JHTML::_('select.genericList', $showhide, 'vis_job_rss', 'class="inputbox" ' . '', 'value', 'text', $this->config['vis_job_rss']);
; ?></td>
                                    <td></td><td></td>
                                </tr>
                            </table>
                        </fieldset>
                    </div>

                    <div id="email">
                        <fieldset>
                            <legend><?php echo JText::_('JS_APPLIED_RESUME_ALERT'); ?></legend>
                            <table cellpadding="5" cellspacing="1" border="0" width="100%" class="admintable" >
                                <tr>
                                    <td class="key" width="25%"><?php echo JText::_('JS_APPLIED_RESUME_STATUS'); ?></td>
                                    <td width="25%"><?php echo JHTML::_('select.genericList', $yesno, 'jobseeker_resume_applied_status', 'class="inputbox" ' . '', 'value', 'text', $this->config['jobseeker_resume_applied_status']); ?></td>
                                    <td><small><?php echo JText::_('JS_APPLIED_RESUME_STATUS_UPDATE_SEND_MAIL_TO_JOBSEEKER'); ?></small></td>
                                </tr>
                            </table>
                        </fieldset>
                    </div>

                </div>                                    
                <input type="hidden" name="layout" value="configurationsjobseeker" />
                <input type="hidden" name="task" value="configuration.saveconf" />
                <input type="hidden" name="notgeneralbuttonsubmit" value="1" />
                <input type="hidden" name="option" value="<?php echo $this->option; ?>" />


            </form>

        </td>
    </tr>
    <tr>
        <td colspan="2" align="left"  valign="top">
			<table width="100%" style="table-layout:fixed;"><tr><td style="vertical-align:top;">			<?php echo '<table width="100%" style="table-layout:fixed;"> <tr><td height="15"></td></tr> <tr> <td style="vertical-align:middle;" align="center"> <a href="http://www.joomsky.com" target="_blank"><img src="http://www.joomsky.com/logo/jsjobscrlogo.png" ></a> <br> Copyright &copy; 2008 - '. date('Y') .', <a href="http://www.joomsky.com" target="_blank">Joom Sky</a>  </td> </tr> </table>';  ?>	</td></tr></table>
        </td>
    </tr>

</table>
