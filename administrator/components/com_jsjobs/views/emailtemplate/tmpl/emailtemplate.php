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
 * File Name:	admin-----/views/application/tmpl/emailtemplate.php
  ^
 * Description: Form template for a job
  ^
 * History:		NONE
  ^
 */
defined('_JEXEC') or die('Restricted access');
jimport('joomla.html.pane');

$editor = JFactory::getEditor();
JHTML::_('behavior.calendar');
JHTML::_('behavior.formvalidation');
$document = JFactory::getDocument();
$document->addStyleSheet(JURI::root() . 'administrator/components/com_jsjobs/include/css/jsjobsadmin.css');
if (JVERSION < 3) {
    JHtml::_('behavior.mootools');
    $document->addScript('../components/com_jsjobs/js/jquery.js');
} else {
    JHtml::_('behavior.framework');
    JHtml::_('jquery.framework');
}
?>

<script language="javascript">
// for joomla 1.6
    Joomla.submitbutton = function(task) {
        if (task == '') {
            return false;
        } else {
            if (task == 'emailtemplate.save') {
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
        }
        else {
            alert('<?php echo JText::_('JS_SOME_VALUES_ARE_NOT_ACCEPTABLE_PLEASE_RETRY'); ?>');
            return false;
        }
        return true;
    }
</script>

<table width="100%" >
    <tr>
        <td align="left" width="175"  valign="top">
            <table width="100%" ><tr><td style="vertical-align:top;">
                        <?php
                        include_once('components/com_jsjobs/views/menu.php');
                        ?>
                    </td>
                </tr></table>
        </td>
        <td width="100%" valign="top" align="left">

            <div id="jsjobs_info_heading"><?php echo JText::_('JS_EMAIL_TEMPLATES'); ?></div>

            <form action="index.php" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data" >
                <input type="hidden" name="check" value="post"/>
            <div id="js_job_wrapper" style="background:none;">
                <div class="js_formwrapper">
                    <div class="js_subject"><label id="subjectmsg" for="subject"><?php echo JText::_('JS_SUBJECT'); ?></label>&nbsp;<font color="red">*</font></div>
                    <div class="js_subject_field"><input class="inputbox required" type="text" name="subject" id="subject" size="135" maxlength="255" value="<?php if (isset($this->template)) echo $this->template->subject; ?>" /></div>
                </div>
                <span class="js_job_controlpanelheading"><?php echo JText::_('JS_BODY'); ?>&nbsp;<font color="red">*</font></span>
                <div class="js_formwrapper">
                    <div class="js_sec_70">
                        <?php
                        $editor = JFactory::getEditor();
                        if (isset($this->template))
                            echo $editor->display('body', $this->template->body, '550', '300', '60', '20', false);
                        else
                            echo $editor->display('body', '', '550', '300', '60', '20', false);
                        ?>	
                    </div>
                    <div class="js_sec_30">
                        <span class="js_job_controlpanelheading"><?php echo JText::_('JS_PARAMETERS'); ?></span>
                        <table  cellpadding="5" cellspacing="0" border="0" width="100%" class="adminform">                           
                            <?php if (($this->template->templatefor == 'company-approval' ) || ($this->template->templatefor == 'company-rejecting' )) { ?>
                                <tr><td>{COMPANY_NAME} :  <?php echo JText::_('JS_COMPANY_NAME'); ?></td></tr>
                                <tr><td>{EMPLOYER_NAME} :  <?php echo JText::_('JS_EMPLOYER_NAME'); ?></td>	</tr>
                                <tr><td>{COMPANY_LINK} :  <?php echo JText::_('JS_EMPLOYER_LINK'); ?></td>	</tr>
                            <?php } elseif (($this->template->templatefor == 'job-approval' ) || ($this->template->templatefor == 'job-rejecting' )) { ?>
                                <tr><td>{JOB_TITLE} :  <?php echo JText::_('JS_JOB_TITLE'); ?></td></tr>
                                <tr><td>{EMPLOYER_NAME} :  <?php echo JText::_('JS_EMPLOYER_NAME'); ?></td>	</tr>
                                <tr><td>{JOB_LINK} :  <?php echo JText::_('JS_JOB_LINK'); ?></td>	</tr>
                            <?php } elseif (($this->template->templatefor == 'resume-approval' ) || ($this->template->templatefor == 'resume-rejecting' )) { ?>										
                                <tr><td>{RESUME_TITLE} :  <?php echo JText::_('JS_RESUME_TITLE'); ?></td></tr>
                                <tr><td>{JOBSEEKER_NAME} :  <?php echo JText::_('JS_JOBSEEKER_NAME'); ?></td>	</tr>
                                <tr><td>{RESUME_LINK} :  <?php echo JText::_('JS_RESUME_LINK'); ?></td>	</tr>
                            <?php } elseif ($this->template->templatefor == 'company-new') { ?>										
                                <tr><td>{COMPANY_NAME} :  <?php echo JText::_('JS_COMPANY_NAME'); ?></td></tr>
                                <tr><td>{EMPLOYER_NAME} :  <?php echo JText::_('JS_EMPLOYER_NAME'); ?></td>	</tr>
                                <tr><td>{COMPANY_LINK} :  <?php echo JText::_('JS_EMPLOYER_LINK'); ?></td>	</tr>
                            <?php } elseif ($this->template->templatefor == 'job-new') { ?>										
                                <tr><td>{JOB_TITLE} :  <?php echo JText::_('JS_JOB_TITLE'); ?></td></tr>
                                <tr><td>{EMPLOYER_NAME} :  <?php echo JText::_('JS_EMPLOYER_NAME'); ?></td>	</tr>
                                <tr><td>{JOB_LINK} :  <?php echo JText::_('JS_JOB_LINK'); ?></td>	</tr>
                            <?php } elseif ($this->template->templatefor == 'resume-new') { ?>										
                                <tr><td>{RESUME_TITLE} :  <?php echo JText::_('JS_RESUME_TITLE'); ?></td></tr>
                                <tr><td>{JOBSEEKER_NAME} :  <?php echo JText::_('JS_JOBSEEKER_NAME'); ?></td>	</tr>
                                <tr><td>{RESUME_LINK} :  <?php echo JText::_('JS_RESUME_LINK'); ?></td>	</tr>
                            <?php } elseif ($this->template->templatefor == 'message-email') { ?>
                                <tr><td>{RESUME_TITLE} :  <?php echo JText::_('JS_RESUME_TITLE'); ?></td></tr>
                                <tr><td>{JOBSEEKER_NAME} :  <?php echo JText::_('JS_JOBSEEKER_NAME'); ?></td>	</tr>
                            <?php } elseif ($this->template->templatefor == 'department-new') { ?>										
                                <tr><td>{DEPARTMENT_TITLE} :  <?php echo JText::_('JS_DEPARTMENT_TITLE'); ?></td></tr>
                                <tr><td>{COMPANY_NAME} :  <?php echo JText::_('JS_COMPANY_NAME'); ?></td></tr>
                                <tr><td>{EMPLOYER_NAME} :  <?php echo JText::_('JS_EMPLOYER_NAME'); ?></td>	</tr>
                            <?php } elseif ($this->template->templatefor == 'employer-buypackage') { ?>										
                                <tr><td>{PACKAGE_NAME} :  <?php echo JText::_('JS_PACKAGE_TITLE'); ?></td></tr>
                                <tr><td>{EMPLOYER_NAME} :  <?php echo JText::_('JS_EMPLOYER_NAME'); ?></td>	</tr>
                                <tr><td>{PACKAGE_PRICE} :  <?php echo JText::_('JS_PACKAGE_PRICE'); ?></td>	</tr>
                                <tr><td>{PACKAGE_LINK} :  <?php echo JText::_('JS_PACKAGE_LINK'); ?></td>	</tr>

                            <?php } elseif ($this->template->templatefor == 'jobseeker-buypackage') { ?>										
                                <tr><td>{PACKAGE_NAME} :  <?php echo JText::_('JS_PACKAGE_TITLE'); ?></td></tr>
                                <tr><td>{JOBSEEKER_NAME} :  <?php echo JText::_('JS_JOBSEEKER_NAME'); ?></td>	</tr>
                                <tr><td>{PACKAGE_PRICE} :  <?php echo JText::_('JS_PACKAGE_PRICE'); ?></td>	</tr>
                                <tr><td>{PACKAGE_LINK} :  <?php echo JText::_('JS_PACKAGE_LINK'); ?></td>	</tr>
                            <?php } elseif ($this->template->templatefor == 'jobapply-jobapply') { ?>										
                                <tr><td>{EMPLOYER_NAME} :  <?php echo JText::_('JS_EMPLOYER_NAME'); ?></td>	</tr>
                                <tr><td>{JOBSEEKER_NAME} :  <?php echo JText::_('JS_JOBSEEKER_NAME'); ?></td>	</tr>
                                <tr><td>{JOB_TITLE} :  <?php echo JText::_('JS_JOB_TITLE'); ?></td></tr>
                                <tr><td>{RESUME_LINK} :  <?php echo JText::_('JS_RESUME_LINK'); ?></td>	</tr>
                            <?php } elseif ($this->template->templatefor == 'message-email') { ?>
                                <tr><td>{NAME} :  <?php echo JText::_('JS_NAME'); ?></td>	</tr>
                                <tr><td>{SENDER_NAME} :  <?php echo JText::_('JS_SENDER_NAME'); ?></td>	</tr>
                                <tr><td>{JOB_TITLE} :  <?php echo JText::_('JS_JOB_TITLE'); ?></td></tr>
                                <tr><td>{COMPANY_NAME} :  <?php echo JText::_('JS_COMPANY_NAME'); ?></td></tr>
                                <tr><td>{RESUME_TITLE} :  <?php echo JText::_('JS_RESUME_TITLE'); ?></td></tr>
                            <?php } elseif ($this->template->templatefor == 'job-alert') { ?>
                                <tr><td>{JOBSEEKER_NAME} :  <?php echo JText::_('JS_JOBSEEKER_NAME'); ?></td>	</tr>
                                <tr><td>{JOBS_INFO} :  <?php echo JText::_('JS_SHOW_JOBS'); ?></td>	</tr>
                            <?php } elseif ($this->template->templatefor == 'job-alert-visitor') { ?>
                                <tr><td>{JOB_TITLE} :  <?php echo JText::_('JS_JOB_TITLE'); ?></td></tr>
                                <tr><td>{COMPANY_NAME} :  <?php echo JText::_('JS_COMPANY_NAME'); ?></td>	</tr>
                                <tr><td>{JOB_CATEGORY} :  <?php echo JText::_('JS_JOB_CATEGORY'); ?></td>	</tr>
                                <tr><td>{JOB_STATUS} :  <?php echo JText::_('JS_JOB_STATUS'); ?></td>	</tr>
                                <tr><td>{CONTACT_NAME} :  <?php echo JText::_('JS_CONTACT_NAME'); ?></td>	</tr>
                                <tr><td>{JOB_LINK} :  <?php echo JText::_('JS_JOB_LINK'); ?></td>	</tr>
                            <?php } elseif ($this->template->templatefor == 'job-to-friend') { ?>
                                <tr><td>{SENDER_NAME} :  <?php echo JText::_('JS_SENDER_NAME'); ?></td></tr>
                                <tr><td>{SITE_NAME} :  <?php echo JText::_('JS_SITE_NAME'); ?></td></tr>
                                <tr><td>{JOB_TITLE} :  <?php echo JText::_('JS_JOB_TITLE'); ?></td></tr>
                                <tr><td>{JOB_CATEGORY} :  <?php echo JText::_('JS_JOB_CATEGORY'); ?></td>	</tr>
                                <tr><td>{COMPANY_NAME} :  <?php echo JText::_('JS_COMPANY_NAME'); ?></td>	</tr>
                                <tr><td>{CLICK_HERE_TO_VISIT} :  <?php echo JText::_('JS_CLICK_HERE_TO_VISIT'); ?></td>	</tr>
                                <tr><td>{SENDER_MESSAGE} :  <?php echo JText::_('JS_SENDER_MESSAGE'); ?></td>	</tr>
                            <?php } elseif ($this->template->templatefor == 'applied-resume_status') { ?>
                                <tr><td>{JOBSEEKER_NAME} :  <?php echo JText::_('JS_JOBSEEKER_NAME'); ?></td></tr>
                                <tr><td>{RESUME_STATUS} :  <?php echo JText::_('JS_APPLIED_RESUME_STATUS'); ?></td></tr>
                                <tr><td>{JOB_TITLE} :  <?php echo JText::_('JS_JOB_TITLE'); ?></td></tr>
                                <tr><td>{STATUS} :  <?php echo JText::_('JS_RESUME_APPLY_STATUS'); ?></td></tr>
                            <?php } ?>
                        </table>
                    </div>
                </div>
            </div>
                <?php
                if (isset($this->template)) {
                    if (($this->template->created == '0000-00-00 00:00:00') || ($this->template->created == ''))
                        $curdate = date('Y-m-d H:i:s');
                    else
                        $curdate = $this->template->created;
                }
                else
                    $curdate = date('Y-m-d H:i:s');
                ?>
                <input type="hidden" name="created" value="<?php echo $curdate; ?>" />
                <input type="hidden" name="view" value="jobposting" />
                <input type="hidden" name="uid" value="<?php echo $this->uid; ?>" />
                <input type="hidden" name="id" value="<?php echo $this->template->id; ?>" />
                <input type="hidden" name="templatefor" value="<?php echo $this->template->templatefor; ?>" />
                <input type="hidden" name="option" value="<?php echo $this->option; ?>" />
                <input type="hidden" name="task" value="emailtemplate.saveemailtemplate" />
                <input type="hidden" name="Itemid" id="Itemid" value="<?php echo $this->Itemid; ?>" />



            </form>

        </td>
    </tr>
    <tr>
        <td colspan="2" align="left" width="100%"  valign="top">
			<table width="100%" style="table-layout:fixed;"><tr><td style="vertical-align:top;">			<?php echo '<table width="100%" style="table-layout:fixed;"> <tr><td height="15"></td></tr> <tr> <td style="vertical-align:middle;" align="center"> <a href="http://www.joomsky.com" target="_blank"><img src="http://www.joomsky.com/logo/jsjobscrlogo.png" ></a> <br> Copyright &copy; 2008 - '. date('Y') .', <a href="http://www.joomsky.com" target="_blank">Joom Sky</a>  </td> </tr> </table>';  ?>	</td></tr></table>
        </td>
    </tr>

</table>				
