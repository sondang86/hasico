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
 * File Name:	views/application/tmpl/formresume.php
  ^
 * Description: template for form resume
  ^
 * History:		NONE
  ^
 */
defined('_JEXEC') or die('Restricted access');
jimport('joomla.html.pane');
JHTML :: _('behavior.calendar');
JHTML::_('behavior.formvalidation');
$document = JFactory::getDocument();
$document->addStyleSheet('components/com_jsjobs/css/token-input-jsjobs.css');
$document->addStyleSheet('components/com_jsjobs/css/combobox/chosen.css');
if (JVERSION < 3) {
    JHtml::_('behavior.mootools');
    $document->addScript('components/com_jsjobs/js/jquery.js');
} else {
    JHtml::_('behavior.framework');
    JHtml::_('jquery.framework');
}
$document->addScript('components/com_jsjobs/js/jquery.tokeninput.js');
$document->addScript('administrator/components/com_jsjobs/include/js/jquery_idTabs.js');
$document->addScript('components/com_jsjobs/js/combobox/chosen.jquery.js');
$document->addScript('components/com_jsjobs/js/combobox/prism.js');


if ($this->config['date_format'] == 'm/d/Y')
    $dash = '/';
else
    $dash = '-';
$dateformat = $this->config['date_format'];
$firstdash = strpos($dateformat, $dash, 0);
$firstvalue = substr($dateformat, 0, $firstdash);
$firstdash = $firstdash + 1;
$seconddash = strpos($dateformat, $dash, $firstdash);
$secondvalue = substr($dateformat, $firstdash, $seconddash - $firstdash);
$seconddash = $seconddash + 1;
$thirdvalue = substr($dateformat, $seconddash, strlen($dateformat) - $seconddash);
$js_dateformat = '%' . $firstvalue . $dash . '%' . $secondvalue . $dash . '%' . $thirdvalue;
$js_scriptdateformat = $firstvalue . $dash . $secondvalue . $dash . $thirdvalue;


global $mainframe;
$resume_style = $this->config['resume_style'];
$big_field_width = 40;
$med_field_width = 25;
$sml_field_width = 15;

$section_personal = 1;
$section_basic = 1;
$section_addresses = 0;
$section_sub_address = 0;
$section_sub_address1 = 0;
$section_sub_address2 = 0;
$section_education = 0;
$section_sub_institute = 0;
$section_sub_institute1 = 0;
$section_sub_institute2 = 0;
$section_sub_institute3 = 0;
$section_employer = 0;
$section_sub_employer = 0;
$section_sub_employer1 = 0;
$section_sub_employer2 = 0;
$section_sub_employer3 = 0;
$section_skills = 0;
$section_resumeeditor = 0;
$section_references = 0;


$section_sub_reference = 0;
$section_sub_reference1 = 0;
$section_sub_reference2 = 0;
$section_sub_reference3 = 0;

$section_languages = 0;
$section_sub_language1 = 0;
$section_sub_language2 = 0;
$section_sub_language3 = 0;

foreach ($this->fieldsordering as $field) {
    switch ($field->field) {
        case "section_addresses" : $section_addresses = $field->published;
            break;
        case "section_sub_address" : $section_sub_address = $field->published;
            break;
        case "section_sub_address1" : $section_sub_address1 = $field->published;
            break;
        case "section_sub_address2" : $section_sub_address2 = $field->published;
            break;
        case "section_education" : $section_education = $field->published;
            break;
        case "section_sub_institute" : $section_sub_institute = $field->published;
            break;
        case "section_sub_institute1" : $section_sub_institute1 = $field->published;
            break;
        case "section_sub_institute2" : $section_sub_institute2 = $field->published;
            break;
        case "section_sub_institute3" : $section_sub_institute3 = $field->published;
            break;
        case "section_employer" : $section_employer = $field->published;
            break;
        case "section_sub_employer" : $section_sub_employer = $field->published;
            break;
        case "section_sub_employer1" : $section_sub_employer1 = $field->published;
            break;
        case "section_sub_employer2" : $section_sub_employer2 = $field->published;
            break;
        case "section_sub_employer3" : $section_sub_employer3 = $field->published;
            break;
        case "section_skills" : $section_skills = $field->published;
            break;
        case "section_resumeeditor" : $section_resumeeditor = $field->published;
            break;
        case "section_references" : $section_references = $field->published;
            break;
        case "section_sub_reference" : $section_sub_reference = $field->published;
            break;
        case "section_sub_reference1" : $section_sub_reference1 = $field->published;
            break;
        case "section_sub_reference2" : $section_sub_reference2 = $field->published;
            break;
        case "section_sub_reference3" : $section_sub_reference3 = $field->published;
            break;
        case "section_userfields" : $section_userfields = $field->published;
            break;

        case "section_languages" : $section_languages = $field->published;
            break;
        case "section_sub_language" : $section_sub_language = $field->published;
            break;
        case "section_sub_language1" : $section_sub_language1 = $field->published;
            break;
        case "section_sub_language2" : $section_sub_language2 = $field->published;
            break;
        case "section_sub_language3" : $section_sub_language3 = $field->published;
            break;
    }
}
if ($this->config['captchause'] == 0) {
    JPluginHelper::importPlugin('captcha');
    $dispatcher = JDispatcher::getInstance();
    $dispatcher->trigger('onInit', 'dynamic_recaptcha_1');
}
?>
<!--<div id="jsjobs_main">-->        
<!--<div id="js_menu_wrapper">-->
            <?php
//            if (sizeof($this->jobseekerlinks) != 0){
//                foreach($this->jobseekerlinks as $lnk){ ?>                     
                    <!--<a class="js_menu_link <?php // if($lnk[2] == 'job') echo 'selected'; ?>" href="<?php // echo $lnk[0]; ?>"><?php // echo $lnk[1]; ?></a>-->
                <?php // }
//            }
//            if (sizeof($this->employerlinks) != 0){
//                foreach($this->employerlinks as $lnk)	{ ?>
                    <!--<a class="js_menu_link <?php // if($lnk[2] == 'job') echo 'selected'; ?>" href="<?php // echo $lnk[0]; ?>"><?php // echo $lnk[1]; ?></a>-->
                <?php // }
//            }
            ?>
        <!--</div>-->
<?php if ($this->config['offline'] == '1') { ?>
        <div class="js_job_error_messages_wrapper">
            <div class="js_job_messages_image_wrapper">
                <img class="js_job_messages_image" src="components/com_jsjobs/images/7.png"/>
            </div>
            <div class="js_job_messages_data_wrapper">
                <span class="js_job_messages_main_text">
                    <?php echo JText::_('JS_JOBS_OFFLINE_MODE'); ?>
                </span>
                <span class="js_job_messages_block_text">
                    <?php echo $this->config['offline_text']; ?>
                </span>
            </div>
        </div>
<?php }else { ?>
    <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false"></script>
    <script language="javascript">

        function validate_dateofbirth() {
            var date_of_birth_make = new Array();
            var split_date_of_birth_value = new Array();

            f = document.adminForm;
            var returnvalue = true;
            var today = new Date();
            today.setHours(0, 0, 0, 0);

            var date_of_birth_string = document.getElementById("date_of_birth").value;

            var format_type = document.getElementById("j_dateformat").value;
            if (format_type == 'd-m-Y') {
                split_date_of_birth_value = date_of_birth_string.split('-');

                date_of_birth_make['year'] = split_date_of_birth_value[2];
                date_of_birth_make['month'] = split_date_of_birth_value[1];
                date_of_birth_make['day'] = split_date_of_birth_value[0];


            } else if (format_type == 'm/d/Y') {

                split_date_of_birth_value = date_of_birth_string.split('/');

                date_of_birth_make['year'] = split_date_of_birth_value[2];
                date_of_birth_make['month'] = split_date_of_birth_value[0];
                date_of_birth_make['day'] = split_date_of_birth_value[1];

            } else if (format_type == 'Y-m-d') {

                split_date_of_birth_value = date_of_birth_string.split('-');

                date_of_birth_make['year'] = split_date_of_birth_value[0];
                date_of_birth_make['month'] = split_date_of_birth_value[1];
                date_of_birth_make['day'] = split_date_of_birth_value[2];

            }

            var date_of_birth = new Date(date_of_birth_make['year'], date_of_birth_make['month'] - 1, date_of_birth_make['day']);

            if (date_of_birth >= today) {
                jQuery("#date_of_birth").addClass("invalid");
                alert('<?php echo JText::_('JS_DATE_OF_BIRTH_MUST_BE_LESS_THEN_TODAY'); ?>');
                returnvalue = false;
            }
            return returnvalue;

        }

        function validate_startdate() {
            f = document.adminForm;
            var returnvalue = true;
            var date_start_make = new Array();
            var split_start_value = new Array();

            var isedit = document.getElementById("id");
            if (isedit.value != "" && isedit.value != 0) {
                return true;
            } else {
                var today = new Date();
                today.setHours(0, 0, 0, 0);


                var start_string = document.getElementById("date_start").value;
                var format_type = document.getElementById("j_dateformat").value;
                if (format_type == 'd-m-Y') {
                    split_start_value = start_string.split('-');

                    date_start_make['year'] = split_start_value[2];
                    date_start_make['month'] = split_start_value[1];
                    date_start_make['day'] = split_start_value[0];


                } else if (format_type == 'm/d/Y') {
                    split_start_value = start_string.split('/');
                    date_start_make['year'] = split_start_value[2];
                    date_start_make['month'] = split_start_value[0];
                    date_start_make['day'] = split_start_value[1];


                } else if (format_type == 'Y-m-d') {

                    split_start_value = start_string.split('-');

                    date_start_make['year'] = split_start_value[0];
                    date_start_make['month'] = split_start_value[1];
                    date_start_make['day'] = split_start_value[2];
                }

                var date_can_start = new Date(date_start_make['year'], date_start_make['month'] - 1, date_start_make['day']);

                if (date_can_start < today) {
                    jQuery("#date_start").addClass("invalid");
                    alert('<?php echo JText::_('JS_DATE_START_MUST_BE_GREATER_THEN_TODAY'); ?>');
                    returnvalue = false;
                }
                return returnvalue;
            }

        }

        function myValidate(f) {
            var msg = new Array();
            var iamavailable_obj = document.getElementById("iamavailable-required");
            if (typeof iamavailable_obj !== 'undefined' && iamavailable_obj !== null) {
                var iamavailable_required_val = document.getElementById("iamavailable-required").value;
                if (iamavailable_required_val != '') {
                    var checked_iamavailable = jQuery('input[name=iamavailable]:checkbox:checked').length;
                    if (checked_iamavailable == 0) {
                        msg.push('<?php echo JText::_('JS_PLEASE_CHECK_I_AM_AVAILABL'); ?>');
                        alert(msg.join('\n'));
                        return false;
                    }
                }
            }
            var searchable_obj = document.getElementById("searchable-required");
            if (typeof searchable_obj !== 'undefined' && searchable_obj !== null) {
                var searchable_required_val = document.getElementById("searchable-required").value;
                if (searchable_required_val != '') {
                    var checked_searchable = jQuery('input[name=searchable]:checkbox:checked').length;
                    if (checked_searchable == 0) {
                        msg.push('<?php echo JText::_('JS_PLEASE_CHECK_SEARCHABLE'); ?>');
                        alert(msg.join('\n'));
                        return false;
                    }
                }
            }
            var photo_obj = document.getElementById('resume-photo-required');
            if (typeof photo_obj !== 'undefined' && photo_obj !== null) {
                var photo_required = document.getElementById('resume-photo-required').value;
                if (photo_required != '') {
                    var photo_value = document.getElementById('photo').value;
                    if (photo_value == '') {
                        var photofile_value = document.getElementById('resume-photofilename').value;
                        if (photofile_value == '') {
                            msg.push('<?php echo JText::_('JS_PLEASE_SELECT_PHOTO'); ?>');
                            alert(msg.join('\n'));
                            return false;
                        }
                    }
                }
            }
            var resume_file_obj = document.getElementById('resume-file-required');
            if (typeof resume_file_obj !== 'undefined' && resume_file_obj !== null) {
                var resume_file_required = document.getElementById('resume-file-required').value;
                if (resume_file_required != '') {
                    var resumefile_value = document.getElementById('resumefile').value;
                    if (resumefile_value == '') {
                        var resumefilename_value = document.getElementById('resume-filename').value;
                        if (resumefilename_value == '') {
                            msg.push('<?php echo JText::_('JS_PLEASE_SELECT_RESUME_FILE'); ?>');
                            alert(msg.join('\n'));
                            return false;
                        }
                    }
                }
            }
            var dateofbirth_obj = document.getElementById("date-of-birth-required");
            if (typeof dateofbirth_obj !== 'undefined' && dateofbirth_obj !== null) {
                var dateofbirth_required = document.getElementById('date-of-birth-required').value;
                if (dateofbirth_required != '') {
                    var dateofbirth_value = document.getElementById('date_of_birth').value;
                    if (dateofbirth_value == '') {
                        jQuery("#date_of_birth").addClass("invalid");
                        msg.push('<?php echo JText::_('JS_PLEASE_ENTER_DATE_OF_BIRTH'); ?>');
                        alert(msg.join('\n'));
                        return false;
                    }
                }
            }
            var call_date_of_birth = jQuery("#date_of_birth").val();
            if (typeof call_date_of_birth != 'undefined') {
                var dob_return = validate_dateofbirth();
                if (dob_return == false)
                    return false;
            }
            var datestart_obj = document.getElementById("date_start-required");
            if (typeof datestart_obj !== 'undefined' && datestart_obj !== null) {
                var datestart_required = document.getElementById('date_start-required').value;
                if (datestart_required != '') {
                    var datestartvalue_required = document.getElementById('date_start').value;
                    if (datestartvalue_required == '') {
                        jQuery("#date_start").addClass("invalid");
                        msg.push('<?php echo JText::_('JS_PLEASE_ENTER_DATE_YOU_CAN_START'); ?>');
                        alert(msg.join('\n'));
                        return false;
                    }
                }
            }
            var call_date_start = jQuery("#date_start").val();
            if (typeof call_date_start != 'undefined') {
                var startdate_return = validate_startdate();
                if (startdate_return == false)
                    return false;
            }

            if (document.formvalidator.isValid(f)) {
                f.check.value = '<?php if (JVERSION < 3) echo JUtility::getToken(); else echo JSession::getFormToken(); ?>';//send token
            } else {
                msg.push('<?php echo JText::_('JS_SOME_VALUES_ARE_NOT_ACCEPTABLE_PLEASE_RETRY'); ?>');
                alert(msg.join('\n'));
                return false;
            }
            return true;
        }
        function hasClass(el, selector) {
            var className = " " + selector + " ";

            if ((" " + el.className + " ").replace(/[\n\t]/g, " ").indexOf(className) > -1) {
                return true;
            }
            return false;
        }

    </script>
<?php 
if ($this->canaddnewresume == VALIDATE) { // add new resume, in edit case always 1
                    ?>
        <div id="js_main_wrapper">
            <span class="js_controlpanel_section_title"><?php echo JText::_('JS_RESUME_FORM');?></span>

            <form action="index.php" method="post" name="adminForm" id="adminForm" class="jsautoz_form" enctype="multipart/form-data" onSubmit="return myValidate(this);">
                <div id="rabs_wrapper">
                    <div class="idTabs">
                        <span><a class="selected" href="#personal_info_data"><?php echo JText::_('JS_PERSONAL'); ?></a></span> 
                        <?php if ($section_addresses) { ?>
                            <span><a href="#addresses_data"><?php echo JText::_('JS_ADDRESSES'); ?></a></span> 
            <?php } ?>	
            <?php if ($section_education) { ?>
                            <span><a href="#education_data"><?php echo JText::_('JS_EDUCATIONS'); ?></a></span> 
            <?php } ?>	
            <?php if ($section_employer) { ?>
                            <span><a href="#employer_data"><?php echo JText::_('JS_EMPLOYERS'); ?></a></span> 
                        <?php } ?>	
                        <?php if ($section_skills) { ?>
                            <span><a href="#skills_data"><?php echo JText::_('JS_SKILLS'); ?></a></span> 
                        <?php } ?>	
            <?php if ($section_resumeeditor) { ?>
                            <span><a href="#resume_editor_data"><?php echo JText::_('JS_RESUME_EDITOR'); ?></a></span> 
                                <?php } ?>	
            <?php if ($section_references) { ?>
                            <span><a href="#references_data"><?php echo JText::_('JS_REFERENCES'); ?></a></span> 
            <?php } ?>	
            <?php if ($section_languages) { ?>
                            <span><a href="#languages_data"><?php echo JText::_('JS_LANGUAGES'); ?></a></span> 
                        <?php } ?>	
                    </div>
                        <?php
                        $i = 0;
                        foreach ($this->fieldsordering as $field) {
                            switch ($field->field) {
                                case "section_personal":
                                    ?>
                                <div id="personal_info_data">
                                    <div class="fieldwrapper rs_sectionheadline">
                                    <?php echo JText::_('JS_PERSONAL_INFORMATION'); ?>
                                    </div>				        
                                    <?php break;
                                case "applicationtitle": $applicationtitle_required = ($field->required ? 'required' : '');
                                    ?>
                                    <div class="fieldwrapper">
                                        <div class="fieldtitle">
                                            <label id="application_titlemsg" for="application_title"><?php echo JText::_('JS_APPLICATION_TITLE'); ?></label><?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?></font>:
                                        </div>
                                        <div class="fieldvalue">
                                            <input class="inputbox <?php echo $applicationtitle_required; ?>" type="text" name="application_title" id="application_title" size="<?php echo $med_field_width; ?>" maxlength="250" value = "<?php if (isset($this->resume)) echo $this->resume->application_title; ?>" />
                                        </div>
                                    </div>				        
                                    <?php break;
                                case "firstname": $firstname_required = ($field->required ? 'required' : '');
                                    ?>
                                    <div class="fieldwrapper">
                                        <div class="fieldtitle">
                                            <label id="first_namemsg" for="first_name"><?php echo JText::_('JS_FIRST_NAME'); ?></label><?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?></font>:
                                        </div>
                                        <div class="fieldvalue">
                                            <input class="inputbox <?php echo $firstname_required; ?>" type="text" name="first_name" id="first_name" size="<?php echo $med_field_width; ?>" maxlength="250" value = "<?php if (isset($this->resume)) echo $this->resume->first_name; ?>" />
                                        </div>
                                    </div>				        
                                    <?php break;
                                case "middlename":
                                    ?>
                                            <?php if ($field->published == 1) {
                                                $middlename_required = ($field->required ? 'required' : ''); ?>
                                        <div class="fieldwrapper">
                                            <div class="fieldtitle">
                            <?php echo JText::_('JS_MIDDLE_NAME'); ?>:<?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                            </div>
                                            <div class="fieldvalue">
                                                <input class="inputbox <?php echo $middlename_required; ?>" type="text" name="middle_name" id="middle_name" size="<?php echo $med_field_width; ?>" maxlength="250" value = "<?php if (isset($this->resume)) echo $this->resume->middle_name; ?>" />
                                            </div>
                                        </div>				        
                                    <?php } ?>
                        <?php break;
                    case "lastname": $lastname_required = ($field->required ? 'required' : '');
                        ?>
                                    <div class="fieldwrapper">
                                        <div class="fieldtitle">
                                            <label id="last_namemsg" for="last_name"><?php echo JText::_('JS_LAST_NAME'); ?></label><?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>:
                                        </div>
                                        <div class="fieldvalue">
                                            <input class="inputbox <?php echo $lastname_required; ?>" type="text" name="last_name" id="last_name" size="<?php echo $med_field_width; ?>" maxlength="250" value = "<?php if (isset($this->resume)) echo $this->resume->last_name; ?>" />
                                        </div>
                                    </div>				        
                                    <?php break;
                                case "emailaddress": $email_required = ($field->required ? 'required' : '');
                                    ?>
                                    <div class="fieldwrapper">
                                        <div class="fieldtitle">
                                            <label id="email_addressmsg" for="email_address"><?php echo JText::_('JS_EMAIL_ADDRESS'); ?></label><?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>:
                                        </div>
                                        <div class="fieldvalue">
                                            <input class="inputbox <?php echo $email_required; ?> validate-email" type="text" name="email_address" id="email_address" size="<?php echo $med_field_width; ?>" maxlength="250" value = "<?php if (isset($this->resume)) echo $this->resume->email_address; ?>" />
                                        </div>
                                    </div>				        
                                    <?php break;
                                case "homephone":
                                    ?>
                                            <?php if ($field->published == 1) {
                                                $homephone_required = ($field->required ? 'required' : ''); ?>
                                        <div class="fieldwrapper">
                                            <div class="fieldtitle">
                            <?php echo JText::_('JS_HOME_PHONE'); ?><?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>:
                                            </div>
                                            <div class="fieldvalue">
                                                <input class="inputbox <?php echo $homephone_required; ?>" type="text" name="home_phone" id="home_phone" size="<?php echo $sml_field_width; ?>" maxlength="20" value = "<?php if (isset($this->resume)) echo $this->resume->home_phone; ?>" />
                                            </div>
                                        </div>				        
                                    <?php } ?>	
                                    <?php break;
                                case "workphone":
                                    ?>
                                            <?php if ($field->published == 1) {
                                                $workphone_required = ($field->required ? 'required' : ''); ?>
                                        <div class="fieldwrapper">
                                            <div class="fieldtitle">
                            <?php echo JText::_('JS_WORK_PHONE'); ?><?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>:
                                            </div>
                                            <div class="fieldvalue">
                                                <input class="inputbox <?php echo $workphone_required; ?>" type="text" name="work_phone" id="work_phone" size="<?php echo $sml_field_width; ?>" maxlength="20" value = "<?php if (isset($this->resume)) echo $this->resume->work_phone; ?>" />
                                            </div>
                                        </div>				        
                                    <?php } ?>	
                        <?php break;
                    case "cell":
                        ?>
                        <?php if ($field->published == 1) {
                            $cell_required = ($field->required ? 'required' : ''); ?>
                                        <div class="fieldwrapper">
                                            <div class="fieldtitle">
                            <?php echo JText::_('JS_CELL'); ?>:<?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                            </div>
                                            <div class="fieldvalue">
                                                <input class="inputbox <?php echo $cell_required; ?>"  type="text" name="cell" id="cell" size="<?php echo $sml_field_width; ?>" maxlength="20" value = "<?php if (isset($this->resume)) echo $this->resume->cell; ?>" />
                                            </div>
                                        </div>				        
                        <?php } ?>	
                        <?php break;
                    case "gender":
                        ?>
                                    <?php if ($field->published == 1) { ?>
                                        <div class="fieldwrapper">
                                            <div class="fieldtitle">
                                        <?php echo JText::_('JS_GENDER'); ?>:<?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                            </div>
                                            <div class="fieldvalue">
                                                <?php echo $this->resumelists['gender']; ?>
                                            </div>
                                        </div>				        
                                            <?php } ?>	
                        <?php break;
                    case "Iamavailable":
                        ?>
                                    <?php if ($field->published == 1) {
                                        $iamavailable_required = ($field->required ? 'required' : ''); ?>
                                        <div class="fieldwrapper">
                                            <div class="fieldtitle">
                                                <?php echo JText::_('JS_I_AM_AVAILABLE'); ?><?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                            </div>
                                            <div class="fieldvalue">
                                                <input type='checkbox' name='iamavailable' id='iamavailable' value='1' <?php if (isset($this->resume)) echo ($this->resume->iamavailable == 1) ? "checked='checked'" : ""; ?> />
                                                <input type='hidden' id='iamavailable-required' name="iamavailable-required" value="<?php echo $iamavailable_required; ?>">
                                            </div>
                                        </div>				        
                                            <?php } ?>	
                                            <?php break;
                                        case "searchable":
                                            ?>
                        <?php if ($field->published == 1) {
                            $searchable_required = ($field->required ? 'required' : ''); ?>
                                        <div class="fieldwrapper">
                                            <div class="fieldtitle">
                                        <?php echo JText::_('JS_SEARCHABLE'); ?><?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                            </div>
                                            <div class="fieldvalue">
                                                <input type='checkbox' name='searchable' id="searchable" value='1' <?php if (isset($this->resume)) {
                                echo ($this->resume->searchable == 1) ? "checked='checked'" : "";
                            }
                            else echo "checked='checked'"; ?> />
                                                <input type='hidden' id='searchable-required' name="searchable-required" value="<?php echo $searchable_required; ?>">
                                            </div>
                                        </div>				        
                                            <?php } ?>	
                                            <?php break;
                                        case "photo":
                                            ?>
                                            <?php if ($field->published == 1) {
                                                $photo_required = ($field->required ? 'required' : ''); ?>
                                        <div class="fieldwrapper">
                                            <div class="fieldtitle">
                                        <?php echo JText::_('JS_PHOTO'); ?>:<?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                            </div>
                                            <div class="fieldvalue">
                                            <?php if (isset($this->resume))
                                                if ($this->resume->photo != '') {
                                                    ?>
                                                        <img src="<?php echo $this->config['data_directory'] ?>/data/jobseeker/resume_<?php echo $this->resume->id . '/photo/' . $this->resume->photo; ?>" />
                                                        <input type='checkbox' name='deletephoto' value='1'><?php echo JText::_('JS_DELETE_PHOTO'); ?>
                                            <?php } ?>				
                                                <input type="file" class="inputbox" name="photo" id="photo" size="20" maxlenght='30'/><small><?php echo JText::_('JS_FILE_TYPE') . ' (' . JText::_('JS_GIF') . ' , ' . JText::_('JS_JPG') . ' , ' . JText::_('JS_JPEG') . ' , ' . JText::_('JS_PNG') . ' )'; ?></small>
                                                <br><small><?php echo JText::_('JS_WIDTH'); ?> : 150px; <?php echo JText::_('JS_HEIGHT'); ?> : 150px</small>
                                                <br><small><?php echo JText::_('JS_MAXIMUM_FILE_SIZE') . ' (' . $this->config['resume_photofilesize']; ?>KB)</small>
                                                <input type='hidden' id='resume-photo-required' name="resume-photo-required" value="<?php echo $photo_required; ?>">
                                                <input type='hidden' id='resume-photofilename' value="<?php if (isset($this->resume->photo)) echo $this->resume->photo;
                            else echo ""; ?>">
                                            </div>
                                        </div>				        
                                    <?php } ?>
                                    <?php break;
                                case "nationality":
                                    ?>
                        <?php if ($field->published == 1) { ?>
                                        <div class="fieldwrapper">
                                            <div class="fieldtitle">
                            <?php echo JText::_('JS_NATIONALITY_COUNTRY'); ?>:<?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                            </div>
                                            <div class="fieldvalue">
                            <?php echo $this->resumelists['nationality']; ?>
                                            </div>
                                        </div>				        
                                    <?php } ?>
                                    <?php break;
                                case "fileupload":
                                    ?>
                                            <?php if ($field->published == 1) {
                                                $file_required = ($field->required ? 'required' : ''); ?>
                                        <div class="fieldwrapper">
                                            <div class="fieldtitle">
                                                <?php echo JText::_('JS_RESUME_FILE'); ?>:<?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                            </div>
                                            <div class="fieldvalue">
                                                <strong><?php echo JText::_('JS_ALSO_RESUME_FILE'); ?></strong>
                                        <?php if (isset($this->resume))
                                            if ($this->resume->filename != '') {
                                                ?>
                                                        <input type='checkbox' name='deleteresumefile' value='1'><?php echo JText::_('JS_DELETE_RESUME_FILE') . '[' . $this->resume->filename . ']'; ?>
                                            <?php } ?>				
                                                <input type="file" class="inputbox" name="resumefile" id="resumefile" size="20" maxlenght='30'/><small><?php echo JText::_('JS_FILE_TYPE') . ' (' . JText::_('JS_TXT') . ' , ' . JText::_('JS_DOC') . ' , ' . JText::_('JS_DOCX') . ' , ' . JText::_('JS_PDF') . ' , ' . JText::_('JS_OPT') . ' , ' . JText::_('JS_RTF') . ' )'; ?></small>
                                                <input type='hidden' maxlenght=''/>
                                                <input type='hidden' id='resume-file-required' name="resume-photo-required" value="<?php echo $file_required; ?>">
                                                <input type='hidden' id='resume-filename' value="<?php if (isset($this->resume->filename)) echo $this->resume->filename;
                            else echo ""; ?>">
                                            </div>
                                        </div>				        
                                            <?php } ?>	
                        <?php
                        break;
                    case "date_of_birth":
                        if ($field->published == 1) {
                            $dateofbirth_required = ($field->required ? 'required' : '');
                            $startdatevalue = '';
                            if (isset($this->resume))
                                $startdatevalue = date($this->config['date_format'], strtotime($this->resume->date_of_birth));
                            ?>
                                        <div class="fieldwrapper">
                                            <div class="fieldtitle">
                                                <?php echo JText::_('JS_DATE_OF_BIRTH'); ?>:<?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                            </div>
                                            <div class="fieldvalue">
                                        <?php
                                        if ((isset($this->resume)) && ($this->resume->date_of_birth != "0000-00-00 00:00:00")) {
                                            echo JHTML::_('calendar', date($this->config['date_format'], strtotime($this->resume->date_of_birth)), 'date_of_birth', 'date_of_birth', $js_dateformat, array('class' => 'inputbox validate-validatedateofbirth', 'size' => '10', 'maxlength' => '19'));
                                        }
                                        else
                                            echo JHTML::_('calendar', '', 'date_of_birth', 'date_of_birth', $js_dateformat, array('class' => 'inputbox validate-validatedateofbirth', 'size' => '10', 'maxlength' => '19'));
                                        ?>
                                                <input type='hidden' id='date-of-birth-required' name="date-of-birth-required" value="<?php echo $dateofbirth_required; ?>">
                                            </div>
                                        </div>				        
                        <?php } ?>		
                                    <?php break;
                                case "section_basic":
                                    ?>
                                    <div class="fieldwrapper rs_sectionheadline">
                                    <?php echo JText::_('JS_BASIC_INFORMATION'); ?>
                                    </div>				        
                                            <?php
                                            break;
                                        case "category":
                                            if ($field->published == 1) {
                                                ?>
                                        <div class="fieldwrapper">
                                            <div class="fieldtitle">
                                        <?php echo JText::_('JS_CATEGORY'); ?>:<?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                            </div>
                                            <div class="fieldvalue">
                                        <?php echo $this->resumelists['job_category']; ?>
                                            </div>
                                        </div>				        
                                            <?php } ?>
                        <?php
                        break;
                    case "subcategory":
                        if ($field->published == 1) {
                            ?>
                                        <div class="fieldwrapper">
                                            <div class="fieldtitle">
                                        <?php echo JText::_('JS_SUB_CATEGORY'); ?>:<?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                            </div>
                                            <div class="fieldvalue" id="fj_subcategory">
                                        <?php echo $this->resumelists['job_subcategory']; ?>
                                            </div>
                                        </div>				        
                                            <?php } ?>	
                                            <?php
                                            break;
                                        case "salary":
                                            if ($field->published == 1) {
                                                ?>
                                        <div class="fieldwrapper">
                                            <div class="fieldtitle">
                            <?php echo JText::_('JS_DESIRED_SALARY'); ?>:<?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                            </div>
                                            <div class="fieldvalue">
                                        <?php echo $this->resumelists['currencyid']; ?>
                                        <?php echo $this->resumelists['jobsalaryrange']; ?>
                                        <?php echo $this->resumelists['jobsalaryrangetypes']; ?>
                                            </div>
                                        </div>				        
                        <?php } ?>	
                        <?php
                        break;
                    case "desiredsalary":
                        if ($field->published == 1) {
                            ?>
                                        <div class="fieldwrapper">
                                            <div class="fieldtitle">
                                        <?php echo JText::_('JS_EXPECTED_SALARY'); ?>:<?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                            </div>
                                            <div class="fieldvalue">
                                        <?php echo $this->resumelists['dcurrencyid']; ?>
                                        <?php echo $this->resumelists['desired_salary']; ?>
                                        <?php echo $this->resumelists['djobsalaryrangetypes']; ?>
                                            </div>
                                        </div>				        
                                    <?php } ?>	
                                    <?php
                                    break;
                                case "jobtype":
                                    if ($field->published == 1) {
                                        ?>
                                        <div class="fieldwrapper">
                                            <div class="fieldtitle">
                                        <?php echo JText::_('JS_WORK_PREFERENCE'); ?>:<?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                            </div>
                                            <div class="fieldvalue">
                                        <?php echo $this->resumelists['jobtype']; ?>
                                            </div>
                                        </div>				        
                                    <?php } ?>	
                                    <?php
                                    break;
                                case "heighesteducation":
                                    if ($field->published == 1) {
                                        ?>
                                        <div class="fieldwrapper">
                                            <div class="fieldtitle">
                                        <?php echo JText::_('JS_HEIGHTESTFINISHEDEDUCATION'); ?>:<?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                            </div>
                                            <div class="fieldvalue">
                                        <?php echo $this->resumelists['heighestfinisheducation']; ?>
                                            </div>
                                        </div>				        
                                    <?php } ?>	
                                    <?php
                                    break;
                                case "totalexperience":
                                    if ($field->published == 1) {
                                        $total_experience_required = ($field->required ? 'required' : '');
                                        ?>
                                        <div class="fieldwrapper">
                                            <div class="fieldtitle">
                                        <?php echo JText::_('JS_TOTAL_EXPERIENCE'); ?>:<?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                            </div>
                                            <div class="fieldvalue">
                                                <input class="inputbox <?php echo $total_experience_required; ?>" type="text" name="total_experience" id="total_experience" size="<?php echo $sml_field_width; ?>" maxlength="20" value = "<?php if (isset($this->resume)) echo $this->resume->total_experience; ?>" />
                                            </div>
                                        </div>				        
                                    <?php } ?>	
                                    <?php
                                    break;
                                case "keywords":
                                    if ($field->published == 1) {
                                        $keywords_required = ($field->required ? 'required' : '');
                                        ?>
                                        <div class="fieldwrapper">
                                            <div class="fieldtitle">
                                        <?php echo JText::_('JS_KEYWORDS'); ?>:<?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                            </div>
                                            <div class="fieldvalue">
                                                <input class="inputbox <?php echo $keywords_required; ?>" type="text" name="keywords" id="keywords" size="40"  value = "<?php if (isset($this->resume)) echo $this->resume->keywords; ?>" />
                                            </div>
                                        </div>				        
                                    <?php } ?>	
                                    <?php break;
                                case "startdate":
                                    ?>
                                    <?php
                                    if ($field->published == 1) {
                                        $startdate_required = ($field->required ? 'required' : '');
                                        $startdatevalue = '';
                                        if (isset($this->resume))
                                            $startdatevalue = date($this->config['date_format'], strtotime($this->resume->date_start));
                                        ?>
                                        <div class="fieldwrapper">
                                            <div class="fieldtitle">
                                        <?php echo JText::_('JS_DATE_CAN_START'); ?>:<?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                            </div>
                                            <div class="fieldvalue">
                                        <?php
                                        if ((isset($this->resume)) && ($this->resume->date_start != "0000-00-00 00:00:00")) {
                                            echo JHTML::_('calendar', date($this->config['date_format'], strtotime($this->resume->date_start)), 'date_start', 'date_start', $js_dateformat, array('class' => 'inputbox validate-validatestartdate', 'size' => '10', 'maxlength' => '19'));
                                        }
                                        else
                                            echo JHTML::_('calendar', '', 'date_start', 'date_start', $js_dateformat, array('class' => 'inputbox validate-validatestartdate', 'size' => '10', 'maxlength' => '19'));
                                        ?>
                                                <input type='hidden' id='date_start-required' name="date_start-required" value="<?php echo $startdate_required; ?>">
                                            </div>
                                        </div>				        
                        <?php } ?>	
                                    <?php
                                    break;
                                case "video":
                                    if ($field->published == 1) {
                                        $video_required = ($field->required ? 'required' : '');
                                        ?>
                                        <div class="fieldwrapper">
                                            <div class="fieldtitle">
                                                <label id="videomsg" for="video"><?php echo JText::_('JS_VIDEO'); ?><?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?></label>
                                            </div>
                                            <div class="fieldvalue">
                                                <input class="inputbox <?php echo $video_required; ?>" type="text" name="video" id="video" size="40" maxlength="255" value="<?php if (isset($this->resume)) echo $this->resume->video; ?>" /><?php echo JText::_('JS_YOUTUBE_VIDEO_ID'); ?>
                                            </div>
                                        </div>				        
                                    <?php } ?>	
                                    <?php
                                    break;
                                case "section_userfields":
                                default:
                                    foreach ($this->userfields as $ufield) {
                                        if ($field->published == 1) {
                                            if ($field->field == $ufield[0]->id) {
                                                $userfield = $ufield[0];
                                                $i++;
                                                echo '<div class="fieldwrapper">';
                                                if ($userfield->required == 1) {
                                                    echo '  <div class="fieldtitle">
                                                                                            <label id="' . $userfield->name . '"msg for=' . $userfield->name . '>' . $userfield->title . '</label>&nbsp;<font color="red">*</font>
                                                                                        </div>';
                                                    if ($userfield->type == 'emailaddress')
                                                        $cssclass = "class ='inputbox required validate-email' ";
                                                    else
                                                        $cssclass = "class ='inputbox required' ";
                                                }else {
                                                    echo '<div class="fieldtitle">'
                                                    . $userfield->title .
                                                    '</div>';
                                                    if ($userfield->type == 'emailaddress')
                                                        $cssclass = "class ='inputbox validate-email' ";
                                                    else
                                                        $cssclass = "class='inputbox' ";
                                                }
                                                echo '<div class="fieldvalue">';

                                                $readonly = $userfield->readonly ? ' readonly="readonly"' : '';
                                                $maxlength = $userfield->maxlength ? 'maxlength="' . $userfield->maxlength . '"' : '';
                                                if (isset($ufield[1])) {
                                                    $fvalue = $ufield[1]->data;
                                                    $userdataid = $ufield[1]->id;
                                                } else {
                                                    $fvalue = "";
                                                    $userdataid = "";
                                                }
                                                echo '<input type="hidden" id="userfields_' . $i . '_id" name="userfields_' . $i . '_id"  value="' . $userfield->id . '"  />';
                                                echo '<input type="hidden" id="userdata_' . $i . '_id" name="userdata_' . $i . '_id"  value="' . $userdataid . '"  />';
                                                switch ($userfield->type) {
                                                    case 'text':
                                                        echo '<input type="text" id="userfields_' . $i . '" name="userfields_' . $i . '" size="' . $userfield->size . '" value="' . $fvalue . '" ' . $cssclass . $maxlength . $readonly . ' />';
                                                        break;
                                                    case 'emailaddress':
                                                        echo '<input type="text" id="userfields_' . $i . '" name="userfields_' . $i . '" size="' . $userfield->size . '" value="' . $fvalue . '" ' . $cssclass . $maxlength . $readonly . ' />';
                                                        break;
                                                    case 'date':
                                                        $userfieldid = 'userfields_' . $i;
                                                        $userfieldid = "'" . $userfieldid . "'";
                                                        echo JHTML::_('calendar', $fvalue, 'userfields_' . $i, 'userfields_' . $i, $js_dateformat, array('class' => 'inputbox', 'size' => '10', 'maxlength' => '19'));
                                                        break;
                                                    case 'textarea':
                                                        echo '<textarea name="userfields_' . $i . '" id="userfields_' . $i . '_field" cols="' . $userfield->cols . '" rows="' . $userfield->rows . '" ' . $readonly . '>' . $fvalue . '</textarea>';
                                                        break;
                                                    case 'checkbox':
                                                        echo '<input type="checkbox" name="userfields_' . $i . '" id="userfields_' . $i . '_field" value="1" ' . 'checked="checked"' . '/>';
                                                        break;
                                                    case 'select':
                                                        $htm = '<select name="userfields_' . $i . '" id="userfields_' . $i . '" >';
                                                        if (isset($ufield[2])) {
                                                            foreach ($ufield[2] as $opt) {
                                                                if ($opt->id == $fvalue)
                                                                    $htm .= '<option value="' . $opt->id . '" selected="yes">' . $opt->fieldtitle . ' </option>';
                                                                else
                                                                    $htm .= '<option value="' . $opt->id . '">' . $opt->fieldtitle . ' </option>';
                                                            }
                                                        }
                                                        $htm .= '</select>';
                                                        echo $htm;
                                                }
                                                echo '</div></div>';
                                            }
                                        }
                                    }
                                    echo '<input type="hidden" id="userfields_total" name="userfields_total"  value="' . $i . '"  />';
                                    ?> 
                        <?php break;
                    case "section_addresses":
                        ?>
                                </div>
                                <div id="addresses_data">
                                    <?php if (($section_addresses == 1) && ($section_sub_address == 1)) { ?>
                                        <div class="fieldwrapper rs_sectionheadline">
                                        <?php echo JText::_('JS_ADDRESS'); ?>
                                        </div>				        
                                        <?php } ?>
                                        <?php
                                        break;
                                    case "address_city":
                                        if ($field->published == 1) {
                                            $address_city_required = ($field->required ? 'required' : '');
                                            if (($section_addresses == 1) && ($section_sub_address == 1)) {
                                                ?>
                                            <div class="fieldwrapper">
                                                <div class="fieldtitle">
                                                    <?php echo JText::_('JS_CITY'); ?>:<?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                                </div>
                                                <div class="fieldvalue" id="raddress_city">
                                                    <input class="inputbox <?php echo $address_city_required; ?>" type="text" name="address_city" id="address_city" size="40" maxlength="100" value="" />
                                                    <input class="inputbox" type="hidden" name="addresscityforedit" id="addresscityforedit" size="40" maxlength="100" value="<?php if (isset($this->resume->address_city)) echo $this->resumelists['address_city']; ?>" />
                                                </div>
                                            </div>				        
                                        <?php }
                                    }
                                    ?>
                                    <?php
                                    break;
                                case "address_zipcode":
                                    if ($field->published == 1) {
                                        $address_zipcode_required = ($field->required ? 'required' : '');
                                        if (($section_addresses == 1) && ($section_sub_address == 1)) {
                                            ?>
                                            <div class="fieldwrapper">
                                                <div class="fieldtitle">
                                <?php echo JText::_('JS_ZIPCODE'); ?>:<?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                                </div>
                                                <div class="fieldvalue">
                                                    <input class="inputbox <?php echo $address_zipcode_required; ?> validate-numeric" type="text" name="address_zipcode" id="address_zipcode" size="<?php echo $sml_field_width; ?>" maxlength="20" value = "<?php if (isset($this->resume)) echo $this->resume->address_zipcode; ?>" />
                                                </div>
                                            </div>				        
                                        <?php }
                                    }
                                    ?>
                                            <?php
                                            break;
                                        case "address_address":
                                            if ($field->published == 1) {
                                                $address_address_required = ($field->required ? 'required' : '');
                                                if (($section_addresses == 1) && ($section_sub_address == 1)) {
                                                    ?>
                                            <div class="fieldwrapper">
                                                <div class="fieldtitle">
                                            <?php echo JText::_('JS_ADDRESS'); ?>:<?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                                </div>
                                                <div class="fieldvalue">
                                                    <input class="inputbox <?php echo $address_address_required; ?>" type="text" name="address" id="address" size="<?php echo $big_field_width; ?>" maxlength="250" value = "<?php if (isset($this->resume)) echo $this->resume->address; ?>" />
                                                </div>
                                            </div>				        
                                            <?php }
                                        }
                                        ?>
                                    <?php
                                    break;
                                case "address_location"://longitude and latitude 
                                    if ($field->published == 1) {
                                        $address_location_required = ($field->required ? 'required' : '');
                                        if (($section_addresses == 1) && ($section_sub_address == 1)) {
                                            ?>
                                            <div class="fieldwrapper">
                                                <div class="fieldtitle">
                                <?php echo JText::_('JS_LOCATION'); ?>:<?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                                </div>
                                                <div class="fieldvalue">
                                                    <div id="outermapdiv">
                                                        <div id="map" style="width:<?php echo $this->config['mapwidth']; ?>px; height:<?php echo $this->config['mapheight']; ?>px">
                                                            <div id="closetag"><a href="Javascript: hidediv();"><?php echo JText::_('X'); ?></a></div>
                                                            <div id="map_container"></div>
                                                        </div>
                                                    </div>
                                                    <input  class="inputbox <?php echo $address_location_required; ?>" type="text" id="longitude" name="longitude" size="25" value = "<?php if (isset($this->resume->longitude)) echo $this->resume->longitude; ?>" />
                                                    <input  class="inputbox <?php echo $address_location_required; ?>" type="text" id="latitude" name="latitude" size="25" value = "<?php if (isset($this->resume->latitude)) echo $this->resume->latitude; ?>" />
                                                    <span id="anchor"><a class="anchor" href="Javascript: showdiv();loadMap();"><?php echo JText::_('JS_MAP'); ?></a></span>
                                                </div>
                                            </div>				        
                            <?php }
                        }
                        ?>
                                    <?php break;
                                case "section_sub_address1":
                                    ?>
                                    <?php if (($section_addresses == 1) && ($section_sub_address1 == 1)) { ?>
                                        <div class="fieldwrapper rs_sectionheadline">
                                        <?php echo JText::_('JS_ADDRESS1'); ?>
                                        </div>				        
                                            <?php } ?>
                                            <?php
                                            break;
                                        case "address1_city":
                                            if ($field->published == 1) {
                                                $address1_city_required = ($field->required ? 'required' : '');
                                                if (($section_addresses == 1) && ($section_sub_address1 == 1)) {
                                                    ?>
                                            <div class="fieldwrapper">
                                                <div class="fieldtitle">
                                            <?php echo JText::_('JS_CITY'); ?>:<?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                                </div>
                                                <div class="fieldvalue" id="raddress1_city">
                                                    <input class="inputbox <?php echo $address1_city_required; ?>" type="text" name="address1_city" id="address1_city" size="40" maxlength="100" value="" />
                                                    <input class="inputbox" type="hidden" name="address1cityforedit" id="address1cityforedit" size="40" maxlength="100" value="<?php if (isset($this->resume->address1_city)) echo $this->resumelists['address1_city']; ?>" />
                                                </div>
                                            </div>				        
                            <?php }
                        }
                        ?>
                        <?php
                        break;
                    case "address1_zipcode":
                        if ($field->published == 1) {
                            $address1_zipcode_required = ($field->required ? 'required' : '');
                            if (($section_addresses == 1) && ($section_sub_address1 == 1)) {
                                ?>
                                            <div class="fieldwrapper">
                                                <div class="fieldtitle">
                                            <?php echo JText::_('JS_ZIPCODE'); ?>:<?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                                </div>
                                                <div class="fieldvalue">
                                                    <input class="inputbox <?php echo $address1_zipcode_required; ?> validate-numeric" type="text" name="address1_zipcode" id="address1_zipcode" size="<?php echo $sml_field_width; ?>" maxlength="20" value = "<?php if (isset($this->resume)) echo $this->resume->address1_zipcode; ?>" />
                                                </div>
                                            </div>				        
                            <?php }
                        }
                        ?>
                        <?php
                        break;
                    case "address1_address":
                        if ($field->published == 1) {
                            $address1_address_required = ($field->required ? 'required' : '');
                            if (($section_addresses == 1) && ($section_sub_address1 == 1)) {
                                ?>
                                            <div class="fieldwrapper">
                                                <div class="fieldtitle">
                                            <?php echo JText::_('JS_ADDRESS'); ?>:<?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                                </div>
                                                <div class="fieldvalue">
                                                    <input class="inputbox <?php echo $address1_address_required; ?>" type="text" name="address1" id="address1" size="<?php echo $big_field_width; ?>" maxlength="250" value = "<?php if (isset($this->resume)) echo $this->resume->address1; ?>" />
                                                </div>
                                            </div>				        
                            <?php }
                        }
                        ?>
                                    <?php break;
                                case "section_sub_address2":
                                    ?>
                                    <?php if (($section_addresses == 1) && ($section_sub_address2 == 1)) { ?>
                                        <div class="fieldwrapper rs_sectionheadline">
                                        <?php echo JText::_('JS_ADDRESS2'); ?>
                                        </div>				        
                        <?php } ?>
                                            <?php
                                            break;
                                        case "address2_city":
                                            if ($field->published == 1) {
                                                $address2_city_required = ($field->required ? 'required' : '');
                                                if (($section_addresses == 1) && ($section_sub_address2 == 1)) {
                                                    ?>
                                            <div class="fieldwrapper">
                                                <div class="fieldtitle">
                                            <?php echo JText::_('JS_CITY'); ?>:<?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                                </div>
                                                <div class="fieldvalue" id="raddress2_city">
                                                    <input class="inputbox <?php echo $address2_city_required; ?>" type="text" name="address2_city" id="address2_city" size="40" maxlength="100" value="" />
                                                    <input class="inputbox" type="hidden" name="address2cityforedit" id="address2cityforedit" size="40" maxlength="100" value="<?php if (isset($this->resume->address2_city)) echo $this->resumelists['address2_city']; ?>" />
                                                </div>
                                            </div>				        
                            <?php }
                        }
                        ?>
                        <?php
                        break;
                    case "address2_zipcode":
                        if ($field->published == 1) {
                            $address2_zipcode_required = ($field->required ? 'required' : '');
                            if (($section_addresses == 1) && ($section_sub_address2 == 1)) {
                                ?>
                                            <div class="fieldwrapper">
                                                <div class="fieldtitle">
                                                <?php echo JText::_('JS_ZIPCODE'); ?>:<?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                                </div>
                                                <div class="fieldvalue">
                                                    <input class="inputbox <?php echo $address2_zipcode_required; ?> validate-numeric" type="text" name="address2_zipcode" id="address2_zipcode" size="<?php echo $sml_field_width; ?>" maxlength="20" value = "<?php if (isset($this->resume)) echo $this->resume->address2_zipcode; ?>" />
                                                </div>
                                            </div>				        
                                        <?php }
                                    }
                                    ?>
                                            <?php
                                            break;
                                        case "address2_address":
                                            if ($field->published == 1) {
                                                $address2_address_required = ($field->required ? 'required' : '');
                                                if (($section_addresses == 1) && ($section_sub_address2 == 1)) {
                                                    ?>
                                            <div class="fieldwrapper">
                                                <div class="fieldtitle">
                                            <?php echo JText::_('JS_ADDRESS'); ?>:<?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                                </div>
                                                <div class="fieldvalue">
                                                    <input class="inputbox <?php echo $address2_address_required; ?>" type="text" name="address2" id="address2" size="<?php echo $big_field_width; ?>" maxlength="250" value = "<?php if (isset($this->resume)) echo $this->resume->address2; ?>" />
                                                </div>
                                            </div>				        
                            <?php }
                        }
                        ?>
                        <?php break;
                    case "section_education":
                        ?>
                                </div>	
                                <div id="education_data">
                                    <?php if (($section_education == 1) && ($section_sub_institute == 1)) { ?>
                                        <div class="fieldwrapper rs_sectionheadline">
                                        <?php echo JText::_('JS_HIGH_SCHOOL'); ?>
                                        </div>				        
                                            <?php } ?>
                                            <?php
                                            break;
                                        case "institute_institute":
                                            if ($field->published == 1) {
                                                $institute_institute_required = ($field->required ? 'required' : '');
                                                if (($section_education == 1) && ($section_sub_institute == 1)) {
                                                    ?>
                                            <div class="fieldwrapper">
                                                <div class="fieldtitle">
                                            <?php echo JText::_('JS_SCH_COL_UNI'); ?>:<?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                                </div>
                                                <div class="fieldvalue">
                                                    <input class="inputbox <?php echo $institute_institute_required; ?>" type="text" name="institute" id="institute" size="<?php echo $med_field_width; ?>" maxlength="250" value = "<?php if (isset($this->resume)) echo $this->resume->institute; ?>" />
                                                </div>
                                            </div>				        
                            <?php } ?>
                        <?php } ?>
                        <?php
                        break;
                    case "institute_certificate":
                        if ($field->published == 1) {
                            $institute_certificate_required = ($field->required ? 'required' : '');
                            if (($section_education == 1) && ($section_sub_institute == 1)) {
                                ?>
                                            <div class="fieldwrapper">
                                                <div class="fieldtitle">
                                                <?php echo JText::_('JS_CRT_DEG_OTH'); ?>:<?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                                </div>
                                                <div class="fieldvalue">
                                                    <input class="inputbox <?php echo $institute_certificate_required; ?>" type="text" name="institute_certificate_name" id="institute_certificate_name" size="<?php echo $sml_field_width; ?>" maxlength="20" value = "<?php if (isset($this->resume)) echo $this->resume->institute_certificate_name; ?>" />
                                                </div>
                                            </div>				        
                                        <?php } ?>
                                    <?php } ?>
                        <?php
                        break;
                    case "institute_study_area":
                        if ($field->published == 1) {
                            $institute_study_area_required = ($field->required ? 'required' : '');
                            if (($section_education == 1) && ($section_sub_institute == 1)) {
                                ?>
                                            <div class="fieldwrapper">
                                                <div class="fieldtitle">
                                            <?php echo JText::_('JS_AREA_OF_STUDY'); ?>:<?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                                </div>
                                                <div class="fieldvalue">
                                                    <input class="inputbox <?php echo $institute_study_area_required; ?>" type="text" name="institute_study_area" id="institute_study_area" size="<?php echo $sml_field_width; ?>" maxlength="20" value = "<?php if (isset($this->resume)) echo $this->resume->institute_study_area; ?>" />
                                                </div>
                                            </div>				        
                                                <?php }
                                            }
                                            ?>
                        <?php
                        break;
                    case "institute_city":
                        if ($field->published == 1) {
                            $institute_city_required = ($field->required ? 'required' : '');
                            ?>
                                        <?php if (($section_education == 1) && ($section_sub_institute == 1)) { ?>
                                            <div class="fieldwrapper">
                                                <div class="fieldtitle">
                                            <?php echo JText::_('JS_CITY'); ?>:<?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                                </div>
                                                <div class="fieldvalue" id="rinstitute_city">
                                                    <input class="inputbox <?php echo $institute_city_required; ?>" type="text" name="institute_city" id="institute_city" size="40" maxlength="100" value="" />
                                                    <input class="inputbox" type="hidden" name="institutecityforedit" id="institutecityforedit" size="40" maxlength="100" value="<?php if (isset($this->resume->institute_city)) echo $this->resumelists['institute_city']; ?>" />
                                                </div>
                                            </div>				        
                            <?php }
                        }
                        ?>
                                    <?php break;
                                case "section_sub_institute1":
                                    ?>
                                    <?php if (($section_education == 1) && ($section_sub_institute1 == 1)) { ?>
                                        <div class="fieldwrapper rs_sectionheadline">
                            <?php echo JText::_('JS_UNIVERSITY'); ?>
                                        </div>				        
                                            <?php } ?>
                        <?php
                        break;
                    case "institute1_institute":
                        if ($field->published == 1) {
                            $institute1_institute_required = ($field->required ? 'required' : '');
                            if (($section_education == 1) && ($section_sub_institute1 == 1)) {
                                ?>
                                            <div class="fieldwrapper">
                                                <div class="fieldtitle">
                                            <?php echo JText::_('JS_SCH_COL_UNI'); ?>:<?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                                </div>
                                                <div class="fieldvalue">
                                                    <input class="inputbox <?php echo $institute1_institute_required; ?>" type="text" name="institute1" id="institute1" size="<?php echo $med_field_width; ?>" maxlength="250" value = "<?php if (isset($this->resume)) echo $this->resume->institute1; ?>" />
                                                </div>
                                            </div>				        
                                        <?php }
                                    }
                                    ?>
                                    <?php
                                    break;
                                case "institute1_certificate":
                                    if ($field->published == 1) {
                                        $institute1_certificate_required = ($field->required ? 'required' : '');
                                        if (($section_education == 1) && ($section_sub_institute1 == 1)) {
                                            ?>
                                            <div class="fieldwrapper">
                                                <div class="fieldtitle">
                                <?php echo JText::_('JS_CRT_DEG_OTH'); ?>:<?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                                </div>
                                                <div class="fieldvalue">
                                                    <input class="inputbox <?php echo $institute1_certificate_required; ?>" type="text" name="institute1_certificate_name" id="institute1_certificate_name" size="<?php echo $sml_field_width; ?>" maxlength="20" value = "<?php if (isset($this->resume)) echo $this->resume->institute1_certificate_name; ?>" />
                                                </div>
                                            </div>				        
                                        <?php }
                                    }
                                    ?>
                                            <?php
                                            break;
                                        case "institute1_study_area":
                                            if ($field->published == 1) {
                                                $institute1_study_area_required = ($field->required ? 'required' : '');
                                                ?>
                                        <?php if (($section_education == 1) && ($section_sub_institute1 == 1)) { ?>
                                            <div class="fieldwrapper">
                                                <div class="fieldtitle">
                                            <?php echo JText::_('JS_AREA_OF_STUDY'); ?>:<?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                                </div>
                                                <div class="fieldvalue">
                                                    <input class="inputbox <?php echo $institute1_study_area_required; ?>" type="text" name="institute1_study_area" id="institute1_study_area" size="<?php echo $sml_field_width; ?>" maxlength="20" value = "<?php if (isset($this->resume)) echo $this->resume->institute1_study_area; ?>" />
                                                </div>
                                            </div>				        
                                                <?php }
                                            }
                                            ?>
                        <?php
                        break;
                    case "institute1_city":
                        if ($field->published == 1) {
                            $institute1_city_required = ($field->required ? 'required' : '');
                            if (($section_education == 1) && ($section_sub_institute1 == 1)) {
                                ?>
                                            <div class="fieldwrapper">
                                                <div class="fieldtitle">
                                <?php echo JText::_('JS_CITY'); ?>:<?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                                </div>
                                                <div class="fieldvalue" id="rinstitute1_city">
                                                    <input class="inputbox <?php echo $institute1_city_required; ?>" type="text" name="institute1_city" id="institute1_city" size="40" maxlength="100" value="" />
                                                    <input class="inputbox" type="hidden" name="institute1cityforedit" id="institute1cityforedit" size="40" maxlength="100" value="<?php if (isset($this->resume->institute1_city)) echo $this->resumelists['institute1_city']; ?>" />
                                                </div>
                                            </div>				        
                                        <?php }
                                    }
                                    ?>
                                    <?php break;
                                case "section_sub_institute2":
                                    ?>
                                    <?php if (($section_education == 1) && ($section_sub_institute2 == 1)) { ?>
                                        <div class="fieldwrapper rs_sectionheadline">
                                                <?php echo JText::_('JS_GRADE_SCHOOL'); ?>
                                        </div>				        
                        <?php } ?>
                        <?php
                        break;
                    case "institute2_institute":
                        if ($field->published == 1) {
                            $institute2_institute_required = ($field->required ? 'required' : '');
                            if (($section_education == 1) && ($section_sub_institute2 == 1)) {
                                ?>
                                            <div class="fieldwrapper">
                                                <div class="fieldtitle">
                                            <?php echo JText::_('JS_SCH_COL_UNI'); ?>:<?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                                </div>
                                                <div class="fieldvalue">
                                                    <input class="inputbox <?php echo $institute2_institute_required; ?>" type="text" name="institute2" id="institute2" size="<?php echo $med_field_width; ?>" maxlength="250" value = "<?php if (isset($this->resume)) echo $this->resume->institute2; ?>" />
                                                </div>
                                            </div>				        
                            <?php }
                        }
                        ?>
                                    <?php
                                    break;
                                case "institute2_certificate":
                                    if ($field->published == 1) {
                                        $institute2_certificate_required = ($field->required ? 'required' : '');
                                        if (($section_education == 1) && ($section_sub_institute2 == 1)) {
                                            ?>
                                            <div class="fieldwrapper">
                                                <div class="fieldtitle">
                                <?php echo JText::_('JS_CRT_DEG_OTH'); ?>:<?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                                </div>
                                                <div class="fieldvalue">
                                                    <input class="inputbox <?php echo $institute2_certificate_required; ?>" type="text" name="institute2_certificate_name" id="institute2_certificate_name" size="<?php echo $sml_field_width; ?>" maxlength="20" value = "<?php if (isset($this->resume)) echo $this->resume->institute2_certificate_name; ?>" />
                                                </div>
                                            </div>				        
                                        <?php }
                                    }
                                    ?>
                                    <?php
                                    break;
                                case "institute2_study_area":
                                    if ($field->published == 1) {
                                        $institute2_study_area_required = ($field->required ? 'required' : '');
                                        if (($section_education == 1) && ($section_sub_institute2 == 1)) {
                                            ?>
                                            <div class="fieldwrapper">
                                                <div class="fieldtitle">
                                            <?php echo JText::_('JS_AREA_OF_STUDY'); ?>:<?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                                </div>
                                                <div class="fieldvalue">
                                                    <input class="inputbox <?php echo $institute2_study_area_required; ?>" type="text" name="institute2_study_area" id="institute2_study_area" size="<?php echo $sml_field_width; ?>" maxlength="20" value = "<?php if (isset($this->resume)) echo $this->resume->institute2_study_area; ?>" />
                                                </div>
                                            </div>				        
                                        <?php }
                                    }
                                    ?>
                                            <?php
                                            break;
                                        case "institute2_city":
                                            if ($field->published == 1) {
                                                $institute2_city_required = ($field->required ? 'required' : '');
                                                if (($section_education == 1) && ($section_sub_institute2 == 1)) {
                                                    ?>
                                            <div class="fieldwrapper">
                                                <div class="fieldtitle">
                                            <?php echo JText::_('JS_CITY'); ?>:<?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                                </div>
                                                <div class="fieldvalue" id="rinstitute2_city">
                                                    <input class="inputbox <?php echo $institute2_city_required; ?>" type="text" name="institute2_city" id="institute2_city" size="40" maxlength="100" value="" />
                                                    <input class="inputbox" type="hidden" name="institute2cityforedit" id="institute2cityforedit" size="40" maxlength="100" value="<?php if (isset($this->resume->institute2_city)) echo $this->resumelists['institute2_city']; ?>" />
                                                </div>
                                            </div>				        
                            <?php }
                        }
                        ?>
                        <?php break;
                    case "section_sub_institute3":
                        ?>
                                    <?php if (($section_education == 1) && ($section_sub_institute3 == 1)) { ?>
                                        <div class="fieldwrapper rs_sectionheadline">
                                        <?php echo JText::_('JS_OTHER_SCHOOL'); ?>
                                        </div>				        
                                    <?php } ?>
                        <?php
                        break;
                    case "institute3_institute":
                        if ($field->published == 1) {
                            $institute3_institute_required = ($field->required ? 'required' : '');
                            if (($section_education == 1) && ($section_sub_institute3 == 1)) {
                                ?>
                                            <div class="fieldwrapper">
                                                <div class="fieldtitle">
                                            <?php echo JText::_('JS_SCH_COL_UNI'); ?>:<?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                                </div>
                                                <div class="fieldvalue">
                                                    <input class="inputbox <?php echo $institute3_institute_required; ?>" type="text" name="institute3" id="institute3" size="<?php echo $med_field_width; ?>" maxlength="250" value = "<?php if (isset($this->resume)) echo $this->resume->institute3; ?>" />
                                                </div>
                                            </div>				        
                                                <?php }
                                            }
                                            ?>
                        <?php
                        break;
                    case "institute3_certificate":
                        if ($field->published == 1) {
                            $institute3_certificate_required = ($field->required ? 'required' : '');
                            if (($section_education == 1) && ($section_sub_institute3 == 1)) {
                                ?>
                                            <div class="fieldwrapper">
                                                <div class="fieldtitle">
                                                <?php echo JText::_('JS_CRT_DEG_OTH'); ?>:<?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                                </div>
                                                <div class="fieldvalue">
                                                    <input class="inputbox <?php echo $institute3_certificate_required; ?>" type="text" name="institute3_certificate_name" id="institute3_certificate_name" size="<?php echo $sml_field_width; ?>" maxlength="20" value = "<?php if (isset($this->resume)) echo $this->resume->institute3_certificate_name; ?>" />
                                                </div>
                                            </div>				        
                                        <?php }
                                    }
                                    ?>
                                            <?php
                                            break;
                                        case "institute3_study_area":
                                            if ($field->published == 1) {
                                                $institute3_study_area_required = ($field->required ? 'required' : '');
                                                if (($section_education == 1) && ($section_sub_institute3 == 1)) {
                                                    ?>
                                            <div class="fieldwrapper">
                                                <div class="fieldtitle">
                                            <?php echo JText::_('JS_AREA_OF_STUDY'); ?>:<?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                                </div>
                                                <div class="fieldvalue">
                                                    <input class="inputbox <?php echo $institute3_study_area_required; ?>" type="text" name="institute3_study_area" id="institute3_study_area" size="<?php echo $sml_field_width; ?>" maxlength="20" value = "<?php if (isset($this->resume)) echo $this->resume->institute3_study_area; ?>" />
                                                </div>
                                            </div>				        
                                                <?php }
                                            }
                                            ?>
                        <?php
                        break;
                    case "institute3_city":
                        if ($field->published == 1) {
                            $institute3_city_required = ($field->required ? 'required' : '');
                            if (($section_education == 1) && ($section_sub_institute3 == 1)) {
                                ?>
                                            <div class="fieldwrapper">
                                                <div class="fieldtitle">
                                <?php echo JText::_('JS_CITY'); ?>:<?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                                </div>
                                                <div class="fieldvalue" id="rinstitute3_city">
                                                    <input class="inputbox <?php echo $institute3_city_required; ?>" type="text" name="institute3_city" id="institute3_city" size="40" maxlength="100" value="" />
                                                    <input class="inputbox" type="hidden" name="institute3cityforedit" id="institute3cityforedit" size="40" maxlength="100" value="<?php if (isset($this->resume->institute3_city)) echo $this->resumelists['institute3_city']; ?>" />
                                                </div>
                                            </div>				        
                                        <?php }
                                    }
                                    ?>
                                    <?php break;
                                case "section_employer":
                                    ?>
                                </div>	
                                <div id="employer_data">
                                            <?php if (($section_employer == 1) && ($section_sub_employer == 1)) { ?>
                                        <div class="fieldwrapper rs_sectionheadline">
                            <?php echo JText::_('JS_RECENT_EMPLOYER'); ?>
                                        </div>				        
                        <?php } ?>
                        <?php
                        break;
                    case "employer_employer":
                        if ($field->published == 1) {
                            $employer_employer_required = ($field->required ? 'required' : '');
                            if (($section_employer == 1) && ($section_sub_employer == 1)) {
                                ?>
                                            <div class="fieldwrapper">
                                                <div class="fieldtitle">
                                                    <?php echo JText::_('JS_EMPLOYER'); ?>:<?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                                </div>
                                                <div class="fieldvalue">
                                                    <input class="inputbox <?php echo $employer_employer_required; ?>" type="text" name="employer" id="employer" size="<?php echo $med_field_width; ?>" maxlength="250" value = "<?php if (isset($this->resume)) echo $this->resume->employer; ?>" />
                                                </div>
                                            </div>				        
                                        <?php }
                                    }
                                    ?>
                                    <?php
                                    break;
                                case "employer_position":
                                    if ($field->published == 1) {
                                        $employer_position_required = ($field->required ? 'required' : '');
                                        if (($section_employer == 1) && ($section_sub_employer == 1)) {
                                            ?>
                                            <div class="fieldwrapper">
                                                <div class="fieldtitle">
                                <?php echo JText::_('JS_POSITION'); ?>:<?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                                </div>
                                                <div class="fieldvalue">
                                                    <input class="inputbox <?php echo $employer_position_required; ?>" type="text" name="employer_position" id="employer_position" size="<?php echo $med_field_width; ?>" maxlength="250" value = "<?php if (isset($this->resume)) echo $this->resume->employer_position; ?>" />
                                                </div>
                                            </div>				        
                                        <?php }
                                    }
                                    ?>
                        <?php
                        break;
                    case "employer_resp":
                        if ($field->published == 1) {
                            $employer_resp_required = ($field->required ? 'required' : '');
                            if (($section_employer == 1) && ($section_sub_employer == 1)) {
                                ?>
                                            <div class="fieldwrapper">
                                                <div class="fieldtitle">
                                            <?php echo JText::_('JS_RESPONSIBILITIES'); ?>:<?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                                </div>
                                                <div class="fieldvalue">
                                                    <input class="inputbox <?php echo $employer_resp_required; ?>" type="text" name="employer_resp" id="employer_resp" size="<?php echo $med_field_width; ?>" maxlength="250" value = "<?php if (isset($this->resume)) echo $this->resume->employer_resp; ?>" />
                                                </div>
                                            </div>				        
                                                <?php } ?>
                                            <?php } ?>
                        <?php
                        break;
                    case "employer_pay_upon_leaving":
                        if ($field->published == 1) {
                            $employer_pay_upon_leaving_required = ($field->required ? 'required' : '');
                            if (($section_employer == 1) && ($section_sub_employer == 1)) {
                                ?>
                                            <div class="fieldwrapper">
                                                <div class="fieldtitle">
                                            <?php echo JText::_('JS_PAY_UPON_LEAVING'); ?>:<?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                                </div>
                                                <div class="fieldvalue">
                                                    <input class="inputbox <?php echo $employer_pay_upon_leaving_required; ?>" type="text" name="employer_pay_upon_leaving" id="employer_pay_upon_leaving" size="<?php echo $med_field_width; ?>" maxlength="250" value = "<?php if (isset($this->resume)) echo $this->resume->employer_pay_upon_leaving; ?>" />
                                                </div>
                                            </div>				        
                            <?php }
                        }
                        ?>
                        <?php
                        break;
                    case "employer_supervisor":
                        if ($field->published == 1) {
                            $employer_supervisor_required = ($field->required ? 'required' : '');
                            if (($section_employer == 1) && ($section_sub_employer == 1)) {
                                ?>
                                            <div class="fieldwrapper">
                                                <div class="fieldtitle">
                                                    <?php echo JText::_('JS_SUPERVISOR'); ?>:<?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                                </div>
                                                <div class="fieldvalue">
                                                    <input class="inputbox <?php echo $employer_supervisor_required; ?>" type="text" name="employer_supervisor" id="employer_supervisor" size="<?php echo $med_field_width; ?>" maxlength="250" value = "<?php if (isset($this->resume)) echo $this->resume->employer_supervisor; ?>" />
                                                </div>
                                            </div>				        
                                        <?php }
                                    }
                                    ?>
                                    <?php
                                    break;
                                case "employer_from_date":
                                    if ($field->published == 1) {
                                        $employer_from_date_required = ($field->required ? 'required' : '');
                                        if (($section_employer == 1) && ($section_sub_employer == 1)) {
                                            ?>
                                            <div class="fieldwrapper">
                                                <div class="fieldtitle">
                                <?php echo JText::_('JS_FROM_DATE'); ?>:<?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                                </div>
                                                <div class="fieldvalue">
                                                    <input class="inputbox <?php echo $employer_from_date_required; ?>" type="text" name="employer_from_date" id="employer_from_date" size="<?php echo $sml_field_width; ?>" maxlength="20" value = "<?php if (isset($this->resume)) echo $this->resume->employer_from_date; ?>" />
                                                </div>
                                            </div>				        
                                        <?php }
                                    }
                                    ?>
                        <?php
                        break;
                    case "employer_to_date":
                        if ($field->published == 1) {
                            $employer_to_date_required = ($field->required ? 'required' : '');
                            if (($section_employer == 1) && ($section_sub_employer == 1)) {
                                ?>
                                            <div class="fieldwrapper">
                                                <div class="fieldtitle">
                                            <?php echo JText::_('JS_TO_DATE'); ?>:<?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                                </div>
                                                <div class="fieldvalue">
                                                    <input class="inputbox <?php echo $employer_to_date_required; ?>" type="text" name="employer_to_date" id="employer_to_date" size="<?php echo $sml_field_width; ?>" maxlength="20" value = "<?php if (isset($this->resume)) echo $this->resume->employer_to_date; ?>" />
                                                </div>
                                            </div>				        
                                        <?php }
                                    }
                                    ?>
                                    <?php
                                    break;
                                case "employer_leave_reason":
                                    if ($field->published == 1) {
                                        $employer_leave_reason_required = ($field->required ? 'required' : '');
                                        if (($section_employer == 1) && ($section_sub_employer == 1)) {
                                            ?>
                                            <div class="fieldwrapper">
                                                <div class="fieldtitle">
                                <?php echo JText::_('JS_LEAVING_REASON'); ?>:<?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                                </div>
                                                <div class="fieldvalue">
                                                    <input class="inputbox <?php echo $employer_leave_reason_required; ?>" type="text" name="employer_leave_reason" id="employer_leave_reason" size="<?php echo $med_field_width; ?>" maxlength="250" value = "<?php if (isset($this->resume)) echo $this->resume->employer_leave_reason; ?>" />
                                                </div>
                                            </div>				        
                                        <?php }
                                    }
                                    ?>
                                            <?php
                                            break;
                                        case "employer_city":
                                            if ($field->published == 1) {
                                                $employer_city_required = ($field->required ? 'required' : '');
                                                if (($section_employer == 1) && ($section_sub_employer == 1)) {
                                                    ?>
                                            <div class="fieldwrapper">
                                                <div class="fieldtitle">
                                            <?php echo JText::_('JS_CITY'); ?>:<?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                                </div>
                                                <div class="fieldvalue" id="remployer_city">
                                                    <input class="inputbox <?php echo $employer_city_required; ?>" type="text" name="employer_city" id="employer_city" size="40" maxlength="100" value="" />
                                                    <input class="inputbox" type="hidden" name="employercityforedit" id="employercityforedit" size="40" maxlength="100" value="<?php if (isset($this->resume->employer_city)) echo $this->resumelists['employer_city']; ?>" />
                                                </div>
                                            </div>				        
                            <?php }
                        }
                        ?>
                        <?php
                        break;
                    case "employer_zip":
                        if ($field->published == 1) {
                            $employer_zip_required = ($field->required ? 'required' : '');
                            if (($section_employer == 1) && ($section_sub_employer == 1)) {
                                ?>
                                            <div class="fieldwrapper">
                                                <div class="fieldtitle">
                                                    <?php echo JText::_('JS_ZIPCODE'); ?>:<?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                                </div>
                                                <div class="fieldvalue">
                                                    <input class="inputbox <?php echo $employer_zip_required; ?>" type="text" name="employer_zip" id="employer_zip" size="<?php echo $sml_field_width; ?>" maxlength="20" value = "<?php if (isset($this->resume)) echo $this->resume->employer_zip; ?>" />
                                                </div>
                                            </div>				        
                                        <?php }
                                    }
                                    ?>
                                    <?php
                                    break;
                                case "employer_address":
                                    if ($field->published == 1) {
                                        $employer_address_required = ($field->required ? 'required' : '');
                                        if (($section_employer == 1) && ($section_sub_employer == 1)) {
                                            ?>
                                            <div class="fieldwrapper">
                                                <div class="fieldtitle">
                                <?php echo JText::_('JS_ADDRESS'); ?>:<?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                                </div>
                                                <div class="fieldvalue">
                                                    <input class="inputbox <?php echo $employer_address_required; ?>" type="text" name="employer_address" id="employer_address" size="<?php echo $big_field_width; ?>" maxlength="250" value = "<?php if (isset($this->resume)) echo $this->resume->employer_address; ?>" />
                                                </div>
                                            </div>				        
                                        <?php }
                                    }
                                    ?>	
                        <?php
                        break;
                    case "employer_phone":
                        if ($field->published == 1) {
                            $employer_phone_required = ($field->required ? 'required' : '');
                            if (($section_employer == 1) && ($section_sub_employer == 1)) {
                                ?>
                                            <div class="fieldwrapper">
                                                <div class="fieldtitle">
                                            <?php echo JText::_('JS_PHONE'); ?>:<?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                                </div>
                                                <div class="fieldvalue">
                                                    <input class="inputbox <?php echo $employer_phone_required; ?>" type="text" name="employer_phone" id="employer_phone" size="<?php echo $sml_field_width; ?>" maxlength="20" value = "<?php if (isset($this->resume)) echo $this->resume->employer_phone; ?>" />
                                                </div>
                                            </div>				        
                                                <?php }
                                            }
                                            ?>
                        <?php break;
                    case "section_sub_employer1":
                        ?>
                                    <?php if (($section_employer == 1) && ($section_sub_employer1 == 1)) { ?>
                                        <div class="fieldwrapper rs_sectionheadline">
                                        <?php echo JText::_('JS_PRIOR_EMPLOYER_1'); ?>
                                        </div>				        
                                    <?php } ?>
                                    <?php
                                    break;
                                case "employer1_employer":
                                    if ($field->published == 1) {
                                        $employer1_employer_required = ($field->required ? 'required' : '');
                                        if (($section_employer == 1) && ($section_sub_employer1 == 1)) {
                                            ?>
                                            <div class="fieldwrapper">
                                                <div class="fieldtitle">
                                            <?php echo JText::_('JS_EMPLOYER'); ?>:<?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                                </div>
                                                <div class="fieldvalue">
                                                    <input class="inputbox <?php echo $employer1_employer_required; ?>" type="text" name="employer1" id="employer1" size="<?php echo $med_field_width; ?>" maxlength="250" value = "<?php if (isset($this->resume)) echo $this->resume->employer1; ?>" />
                                                </div>
                                            </div>				        
                                        <?php }
                                    }
                                    ?>
                                            <?php
                                            break;
                                        case "employer1_position":
                                            if ($field->published == 1) {
                                                $employer1_position_required = ($field->required ? 'required' : '');
                                                if (($section_employer == 1) && ($section_sub_employer1 == 1)) {
                                                    ?>
                                            <div class="fieldwrapper">
                                                <div class="fieldtitle">
                                            <?php echo JText::_('JS_POSITION'); ?>:<?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                                </div>
                                                <div class="fieldvalue">
                                                    <input class="inputbox <?php echo $employer1_position_required; ?>" type="text" name="employer1_position" id="employer1_position" size="<?php echo $med_field_width; ?>" maxlength="250" value = "<?php if (isset($this->resume)) echo $this->resume->employer1_position; ?>" />
                                                </div>
                                            </div>				        
                                                <?php }
                                            }
                                            ?>
                        <?php
                        break;
                    case "employer1_resp":
                        if ($field->published == 1) {
                            $employer1_resp_required = ($field->required ? 'required' : '');
                            if (($section_employer == 1) && ($section_sub_employer1 == 1)) {
                                ?>
                                            <div class="fieldwrapper">
                                                <div class="fieldtitle">
                                <?php echo JText::_('JS_RESPONSIBILITIES'); ?>:<?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                                </div>
                                                <div class="fieldvalue">
                                                    <input class="inputbox <?php echo $employer1_resp_required; ?>" type="text" name="employer1_resp" id="employer1_resp" size="<?php echo $med_field_width; ?>" maxlength="250" value = "<?php if (isset($this->resume)) echo $this->resume->employer1_resp; ?>" />
                                                </div>
                                            </div>				        
                            <?php }
                        }
                        ?>
                                    <?php
                                    break;
                                case "employer1_pay_upon_leaving":
                                    if ($field->published == 1) {
                                        $employer1_pay_upon_leaving_required = ($field->required ? 'required' : '');
                                        if (($section_employer == 1) && ($section_sub_employer1 == 1)) {
                                            ?>
                                            <div class="fieldwrapper">
                                                <div class="fieldtitle">
                                <?php echo JText::_('JS_PAY_UPON_LEAVING'); ?>:<?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                                </div>
                                                <div class="fieldvalue">
                                                    <input class="inputbox <?php echo $employer1_pay_upon_leaving_required; ?>" type="text" name="employer1_pay_upon_leaving" id="employer1_pay_upon_leaving" size="<?php echo $med_field_width; ?>" maxlength="250" value = "<?php if (isset($this->resume)) echo $this->resume->employer1_pay_upon_leaving; ?>" />
                                                </div>
                                            </div>				        
                                        <?php }
                                    }
                                    ?>
                                        <?php
                                        break;
                                    case "employer1_supervisor":
                                        if ($field->published == 1) {
                                            $employer1_supervisor_required = ($field->required ? 'required' : '');
                                            if (($section_employer == 1) && ($section_sub_employer1 == 1)) {
                                                ?>
                                            <div class="fieldwrapper">
                                                <div class="fieldtitle">
                                                    <?php echo JText::_('JS_SUPERVISOR'); ?>:<?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                                </div>
                                                <div class="fieldvalue">
                                                    <input class="inputbox <?php echo $employer1_supervisor_required; ?>" type="text" name="employer1_supervisor" id="employer1_supervisor" size="<?php echo $med_field_width; ?>" maxlength="250" value = "<?php if (isset($this->resume)) echo $this->resume->employer1_supervisor; ?>" />
                                                </div>
                                            </div>				        
                                        <?php }
                                    }
                                    ?>
                                    <?php
                                    break;
                                case "employer1_from_date":
                                    if ($field->published == 1) {
                                        $employer1_from_date_required = ($field->required ? 'required' : '');
                                        if (($section_employer == 1) && ($section_sub_employer1 == 1)) {
                                            ?>
                                            <div class="fieldwrapper">
                                                <div class="fieldtitle">
                                <?php echo JText::_('JS_FROM_DATE'); ?>:<?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                                </div>
                                                <div class="fieldvalue">
                                                    <input class="inputbox <?php echo $employer1_from_date_required; ?>" type="text" name="employer1_from_date" id="employer1_from_date" size="<?php echo $sml_field_width; ?>" maxlength="20" value = "<?php if (isset($this->resume)) echo $this->resume->employer1_from_date; ?>" />
                                                </div>
                                            </div>				        
                                        <?php }
                                    }
                                    ?>
                        <?php
                        break;
                    case "employer1_to_date":
                        if ($field->published == 1) {
                            $employer1_to_date_required = ($field->required ? 'required' : '');
                            if (($section_employer == 1) && ($section_sub_employer1 == 1)) {
                                ?>
                                            <div class="fieldwrapper">
                                                <div class="fieldtitle">
                                            <?php echo JText::_('JS_TO_DATE'); ?>:<?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                                </div>
                                                <div class="fieldvalue">
                                                    <input class="inputbox <?php echo $employer1_to_date_required; ?>" type="text" name="employer1_to_date" id="employer1_to_date" size="<?php echo $sml_field_width; ?>" maxlength="20" value = "<?php if (isset($this->resume)) echo $this->resume->employer1_to_date; ?>" />
                                                </div>
                                            </div>				        
                                                <?php }
                                            }
                                            ?>
                        <?php
                        break;
                    case "employer1_leave_reason":
                        if ($field->published == 1) {
                            $employer1_leave_reason_required = ($field->required ? 'required' : '');
                            if (($section_employer == 1) && ($section_sub_employer1 == 1)) {
                                ?>
                                            <div class="fieldwrapper">
                                                <div class="fieldtitle">
                                            <?php echo JText::_('JS_LEAVING_REASON'); ?>:<?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                                </div>
                                                <div class="fieldvalue">
                                                    <input class="inputbox <?php echo $employer1_leave_reason_required; ?>" type="text" name="employer1_leave_reason" id="employer1_leave_reason" size="<?php echo $med_field_width; ?>" maxlength="250" value = "<?php if (isset($this->resume)) echo $this->resume->employer1_leave_reason; ?>" />
                                                </div>
                                            </div>				        
                            <?php }
                        }
                        ?>
                                    <?php
                                    break;
                                case "employer1_city":
                                    if ($field->published == 1) {
                                        $employer1_city_required = ($field->required ? 'required' : '');
                                        if (($section_employer == 1) && ($section_sub_employer1 == 1)) {
                                            ?>
                                            <div class="fieldwrapper">
                                                <div class="fieldtitle">
                                <?php echo JText::_('JS_CITY'); ?>:<?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                                </div>
                                                <div class="fieldvalue" id="remployer1_city">
                                                    <input class="inputbox <?php echo $employer1_city_required; ?>" type="text" name="employer1_city" id="employer1_city" size="40" maxlength="100" value="" />
                                                    <input class="inputbox" type="hidden" name="employer1cityforedit" id="employer1cityforedit" size="40" maxlength="100" value="<?php if (isset($this->resume->employer1_city)) echo $this->resumelists['employer1_city']; ?>" />
                                                </div>
                                            </div>				        
                                        <?php }
                                    }
                                    ?>
                                    <?php
                                    break;
                                case "employer1_zip":
                                    if ($field->published == 1) {
                                        $employer1_zip_required = ($field->required ? 'required' : '');
                                        if (($section_employer == 1) && ($section_sub_employer1 == 1)) {
                                            ?>
                                            <div class="fieldwrapper">
                                                <div class="fieldtitle">
                                            <?php echo JText::_('JS_ZIPCODE'); ?>:<?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                                </div>
                                                <div class="fieldvalue">
                                                    <input class="inputbox <?php echo $employer1_zip_required; ?>" type="text" name="employer1_zip" id="employer1_zip" size="<?php echo $sml_field_width; ?>" maxlength="20" value = "<?php if (isset($this->resume)) echo $this->resume->employer1_zip; ?>" />
                                                </div>
                                            </div>				        
                            <?php }
                        }
                        ?>
                        <?php
                        break;
                    case "employer1_address":
                        if ($field->published == 1) {
                            $employer1_address_required = ($field->required ? 'required' : '');
                            if (($section_employer == 1) && ($section_sub_employer1 == 1)) {
                                ?>
                                            <div class="fieldwrapper">
                                                <div class="fieldtitle">
                                            <?php echo JText::_('JS_ADDRESS'); ?>:<?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                                </div>
                                                <div class="fieldvalue">
                                                    <input class="inputbox <?php echo $employer1_address_required; ?>" type="text" name="employer1_address" id="employer1_address" size="<?php echo $big_field_width; ?>" maxlength="250" value = "<?php if (isset($this->resume)) echo $this->resume->employer1_address; ?>" />
                                                </div>
                                            </div>				        
                            <?php }
                        }
                        ?>	
                        <?php
                        break;
                    case "employer1_phone":
                        if ($field->published == 1) {
                            $employer1_phone_required = ($field->required ? 'required' : '');
                            if (($section_employer == 1) && ($section_sub_employer1 == 1)) {
                                ?>
                                            <div class="fieldwrapper">
                                                <div class="fieldtitle">
                                                    <?php echo JText::_('JS_PHONE'); ?>:<?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                                </div>
                                                <div class="fieldvalue">
                                                    <input class="inputbox <?php echo $employer1_phone_required; ?>" type="text" name="employer1_phone" id="employer1_phone" size="<?php echo $sml_field_width; ?>" maxlength="20" value = "<?php if (isset($this->resume)) echo $this->resume->employer1_phone; ?>" />
                                                </div>
                                            </div>				        
                                        <?php }
                                    }
                                    ?>
                                    <?php break;
                                case "section_sub_employer2":
                                    ?>
                                    <?php if (($section_employer == 1) && ($section_sub_employer2 == 1)) { ?>
                                        <div class="fieldwrapper rs_sectionheadline">
                                                <?php echo JText::_('JS_PRIOR_EMPLOYER_2'); ?>
                                        </div>				        
                        <?php } ?>
                        <?php
                        break;
                    case "employer2_employer":
                        if ($field->published == 1) {
                            $employer2_employer_required = ($field->required ? 'required' : '');
                            if (($section_employer == 1) && ($section_sub_employer2 == 1)) {
                                ?>
                                            <div class="fieldwrapper">
                                                <div class="fieldtitle">
                                            <?php echo JText::_('JS_EMPLOYER'); ?>:<?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                                </div>
                                                <div class="fieldvalue">
                                                    <input class="inputbox <?php echo $employer2_employer_required; ?>" type="text" name="employer2" id="employer2" size="<?php echo $med_field_width; ?>" maxlength="250" value = "<?php if (isset($this->resume)) echo $this->resume->employer2; ?>" />
                                                </div>
                                            </div>				        
                            <?php }
                        }
                        ?>
                                    <?php
                                    break;
                                case "employer2_position":
                                    if ($field->published == 1) {
                                        $employer2_position_required = ($field->required ? 'required' : '');
                                        if (($section_employer == 1) && ($section_sub_employer2 == 1)) {
                                            ?>
                                            <div class="fieldwrapper">
                                                <div class="fieldtitle">
                                            <?php echo JText::_('JS_POSITION'); ?>:<?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                                </div>
                                                <div class="fieldvalue">
                                                    <input class="inputbox <?php echo $employer2_position_required; ?>" type="text" name="employer2_position" id="employer2_position" size="<?php echo $med_field_width; ?>" maxlength="250" value = "<?php if (isset($this->resume)) echo $this->resume->employer2_position; ?>" />
                                                </div>
                                            </div>				        
                                                <?php }
                                            }
                                            ?>
                        <?php
                        break;
                    case "employer2_resp":
                        if ($field->published == 1) {
                            $employer2_resp_required = ($field->required ? 'required' : '');
                            if (($section_employer == 1) && ($section_sub_employer2 == 1)) {
                                ?>
                                            <div class="fieldwrapper">
                                                <div class="fieldtitle">
                                <?php echo JText::_('JS_RESPONSIBILITIES'); ?>:<?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                                </div>
                                                <div class="fieldvalue">
                                                    <input class="inputbox" type="text" name="employer2_resp" id="employer2_resp" size="<?php echo $med_field_width; ?>" maxlength="250" value = "<?php if (isset($this->resume)) echo $this->resume->employer2_resp; ?>" />
                                                </div>
                                            </div>				        
                            <?php }
                        }
                        ?>
                                    <?php
                                    break;
                                case "employer2_pay_upon_leaving":
                                    if ($field->published == 1) {
                                        $employer2_pay_upon_leaving_required = ($field->required ? 'required' : '');
                                        if (($section_employer == 1) && ($section_sub_employer2 == 1)) {
                                            ?>
                                            <div class="fieldwrapper">
                                                <div class="fieldtitle">
                                <?php echo JText::_('JS_PAY_UPON_LEAVING'); ?>:<?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                                </div>
                                                <div class="fieldvalue">
                                                    <input class="inputbox <?php echo $employer2_pay_upon_leaving_required; ?>" type="text" name="employer2_pay_upon_leaving" id="employer2_pay_upon_leaving" size="<?php echo $med_field_width; ?>" maxlength="250" value = "<?php if (isset($this->resume)) echo $this->resume->employer2_pay_upon_leaving; ?>" />
                                                </div>
                                            </div>				        
                                        <?php }
                                    }
                                    ?>
                                    <?php
                                    break;
                                case "employer2_supervisor":
                                    if ($field->published == 1) {
                                        $employer2_supervisor_required = ($field->required ? 'required' : '');
                                        if (($section_employer == 1) && ($section_sub_employer2 == 1)) {
                                            ?>
                                            <div class="fieldwrapper">
                                                <div class="fieldtitle">
                                            <?php echo JText::_('JS_SUPERVISOR'); ?>:<?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                                </div>
                                                <div class="fieldvalue">
                                                    <input class="inputbox <?php echo $employer2_supervisor_required; ?>" type="text" name="employer2_supervisor" id="employer2_supervisor" size="<?php echo $med_field_width; ?>" maxlength="250" value = "<?php if (isset($this->resume)) echo $this->resume->employer2_supervisor; ?>" />
                                                </div>
                                            </div>				        
                                            <?php }
                                        }
                                        ?>
                                    <?php
                                    break;
                                case "employer2_from_date":
                                    if ($field->published == 1) {
                                        $employer2_from_date_required = ($field->required ? 'required' : '');
                                        if (($section_employer == 1) && ($section_sub_employer2 == 1)) {
                                            ?>
                                            <div class="fieldwrapper">
                                                <div class="fieldtitle">
                                            <?php echo JText::_('JS_FROM_DATE'); ?>:<?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                                </div>
                                                <div class="fieldvalue">
                                                    <input class="inputbox <?php echo $employer2_from_date_required; ?>" type="text" name="employer2_from_date" id="employer2_from_date" size="<?php echo $sml_field_width; ?>" maxlength="20" value = "<?php if (isset($this->resume)) echo $this->resume->employer2_from_date; ?>" />
                                                </div>
                                            </div>				        
                                        <?php }
                                    }
                                    ?>
                                    <?php
                                    break;
                                case "employer2_to_date":
                                    if ($field->published == 1) {
                                        $employer2_to_date_required = ($field->required ? 'required' : '');
                                        if (($section_employer == 1) && ($section_sub_employer2 == 1)) {
                                            ?>
                                            <div class="fieldwrapper">
                                                <div class="fieldtitle">
                                                    <?php echo JText::_('JS_TO_DATE'); ?>:<?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                                </div>
                                                <div class="fieldvalue">
                                                    <input class="inputbox <?php echo $employer2_to_date_required; ?>" type="text" name="employer2_to_date" id="employer2_to_date" size="<?php echo $sml_field_width; ?>" maxlength="20" value = "<?php if (isset($this->resume)) echo $this->resume->employer2_to_date; ?>" />
                                                </div>
                                            </div>				        
                                        <?php }
                                    }
                                    ?>
                                    <?php
                                    break;
                                case "employer2_leave_reason":
                                    if ($field->published == 1) {
                                        $employer2_leave_reason_required = ($field->required ? 'required' : '');
                                        if (($section_employer == 1) && ($section_sub_employer2 == 1)) {
                                            ?>
                                            <div class="fieldwrapper">
                                                <div class="fieldtitle">
                                <?php echo JText::_('JS_LEAVING_REASON'); ?>:<?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                                </div>
                                                <div class="fieldvalue">
                                                    <input class="inputbox <?php echo $employer2_leave_reason_required; ?>" type="text" name="employer2_leave_reason" id="employer2_leave_reason" size="<?php echo $med_field_width; ?>" maxlength="250" value = "<?php if (isset($this->resume)) echo $this->resume->employer2_leave_reason; ?>" />
                                                </div>
                                            </div>				        
                                        <?php }
                                    }
                                    ?>
                        <?php
                        break;
                    case "employer2_city":
                        if ($field->published == 1) {
                            $employer2_city_required = ($field->required ? 'required' : '');
                            if (($section_employer == 1) && ($section_sub_employer2 == 1)) {
                                ?>
                                            <div class="fieldwrapper">
                                                <div class="fieldtitle">
                                            <?php echo JText::_('JS_CITY'); ?>:<?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                                </div>
                                                <div class="fieldvalue" id="remployer2_city">
                                                    <input class="inputbox <?php echo $employer2_city_required; ?>" type="text" name="employer2_city" id="employer2_city" size="40" maxlength="100" value="" />
                                                    <input class="inputbox" type="hidden" name="employer2cityforedit" id="employer2cityforedit" size="40" maxlength="100" value="<?php if (isset($this->resume->employer2_city)) echo $this->resumelists['employer2_city']; ?>" />
                                                </div>
                                            </div>				        
                                                <?php }
                                            }
                                            ?>
                        <?php
                        break;
                    case "employer2_zip":
                        if ($field->published == 1) {
                            $employer2_zip_required = ($field->required ? 'required' : '');
                            if (($section_employer == 1) && ($section_sub_employer2 == 1)) {
                                ?>
                                            <div class="fieldwrapper">
                                                <div class="fieldtitle">
                                <?php echo JText::_('JS_ZIPCODE'); ?>:<?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                                </div>
                                                <div class="fieldvalue">
                                                    <input class="inputbox <?php echo $employer2_zip_required; ?>" type="text" name="employer2_zip" id="employer2_zip" size="<?php echo $sml_field_width; ?>" maxlength="20" value = "<?php if (isset($this->resume)) echo $this->resume->employer2_zip; ?>" />
                                                </div>
                                            </div>				        
                            <?php }
                        }
                        ?>
                                    <?php
                                    break;
                                case "employer2_address":
                                    if ($field->published == 1) {
                                        $employer2_address_required = ($field->required ? 'required' : '');
                                        if (($section_employer == 1) && ($section_sub_employer2 == 1)) {
                                            ?>
                                            <div class="fieldwrapper">
                                                <div class="fieldtitle">
                                <?php echo JText::_('JS_ADDRESS'); ?>:<?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                                </div>
                                                <div class="fieldvalue">
                                                    <input class="inputbox <?php echo $employer2_address_required; ?>" type="text" name="employer2_address" id="employer2_address" size="<?php echo $big_field_width; ?>" maxlength="250" value = "<?php if (isset($this->resume)) echo $this->resume->employer2_address; ?>" />
                                                </div>
                                            </div>				        
                                        <?php }
                                    }
                                    ?>	
                                    <?php
                                    break;
                                case "employer2_phone":
                                    if ($field->published == 1) {
                                        $employer2_phone_required = ($field->required ? 'required' : '');
                                        if (($section_employer == 1) && ($section_sub_employer2 == 1)) {
                                            ?>
                                            <div class="fieldwrapper">
                                                <div class="fieldtitle">
                                            <?php echo JText::_('JS_PHONE'); ?>:<?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                                </div>
                                                <div class="fieldvalue">
                                                    <input class="inputbox <?php echo $employer2_phone_required; ?>" type="text" name="employer2_phone" id="employer2_phone" size="<?php echo $sml_field_width; ?>" maxlength="20" value = "<?php if (isset($this->resume)) echo $this->resume->employer2_phone; ?>" />
                                                </div>
                                            </div>				        
                                            <?php }
                                        }
                                        ?>
                                    <?php break;
                                case "section_sub_employer3":
                                    ?>
                                    <?php if (($section_employer == 1) && ($section_sub_employer3 == 1)) { ?>
                                        <div class="fieldwrapper rs_sectionheadline">
                                                <?php echo JText::_('JS_PRIOR_EMPLOYER_3'); ?>
                                        </div>				        
                        <?php } ?>
                        <?php
                        break;
                    case "employer3_employer":
                        if ($field->published == 1) {
                            $employer3_employer_required = ($field->required ? 'required' : '');
                            if (($section_employer == 1) && ($section_sub_employer3 == 1)) {
                                ?>
                                            <div class="fieldwrapper">
                                                <div class="fieldtitle">
                                            <?php echo JText::_('JS_EMPLOYER'); ?>:<?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                                </div>
                                                <div class="fieldvalue">
                                                    <input class="inputbox <?php echo $employer3_employer_required; ?>" type="text" name="employer3" id="employer3" size="<?php echo $med_field_width; ?>" maxlength="250" value = "<?php if (isset($this->resume)) echo $this->resume->employer3; ?>" />
                                                </div>
                                            </div>				        
                            <?php }
                        }
                        ?>
                                    <?php
                                    break;
                                case "employer3_position":
                                    if ($field->published == 1) {
                                        $employer3_position_required = ($field->required ? 'required' : '');
                                        if (($section_employer == 1) && ($section_sub_employer3 == 1)) {
                                            ?>
                                            <div class="fieldwrapper">
                                                <div class="fieldtitle">
                                                    <?php echo JText::_('JS_POSITION'); ?>:<?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                                </div>
                                                <div class="fieldvalue">
                                                    <input class="inputbox <?php echo $employer3_position_required; ?>" type="text" name="employer3_position" id="employer3_position" size="<?php echo $med_field_width; ?>" maxlength="250" value = "<?php if (isset($this->resume)) echo $this->resume->employer3_position; ?>" />
                                                </div>
                                            </div>				        
                                        <?php }
                                    }
                                    ?>
                                    <?php
                                    break;
                                case "employer3_resp":
                                    if ($field->published == 1) {
                                        $employer3_resp_required = ($field->required ? 'required' : '');
                                        if (($section_employer == 1) && ($section_sub_employer3 == 1)) {
                                            ?>
                                            <div class="fieldwrapper">
                                                <div class="fieldtitle">
                                <?php echo JText::_('JS_RESPONSIBILITIES'); ?>:<?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                                </div>
                                                <div class="fieldvalue">
                                                    <input class="inputbox <?php echo $employer3_resp_required; ?>" type="text" name="employer3_resp" id="employer3_resp" size="<?php echo $med_field_width; ?>" maxlength="250" value = "<?php if (isset($this->resume)) echo $this->resume->employer3_resp; ?>" />
                                                </div>
                                            </div>				        
                                        <?php }
                                    }
                                    ?>
                                            <?php
                                            break;
                                        case "employer3_pay_upon_leaving":
                                            if ($field->published == 1) {
                                                $employer3_pay_upon_leaving_required = ($field->required ? 'required' : '');
                                                if (($section_employer == 1) && ($section_sub_employer3 == 1)) {
                                                    ?>
                                            <div class="fieldwrapper">
                                                <div class="fieldtitle">
                                            <?php echo JText::_('JS_PAY_UPON_LEAVING'); ?>:<?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                                </div>
                                                <div class="fieldvalue">
                                                    <input class="inputbox <?php echo $employer3_pay_upon_leaving_required; ?>" type="text" name="employer3_pay_upon_leaving" id="employer3_pay_upon_leaving" size="<?php echo $med_field_width; ?>" maxlength="250" value = "<?php if (isset($this->resume)) echo $this->resume->employer3_pay_upon_leaving; ?>" />
                                                </div>
                                            </div>				        
                                                <?php }
                                            }
                                            ?>
                        <?php
                        break;
                    case "employer3_supervisor":
                        if ($field->published == 1) {
                            $employer3_supervisor_required = ($field->required ? 'required' : '');
                            if (($section_employer == 1) && ($section_sub_employer3 == 1)) {
                                ?>
                                            <div class="fieldwrapper">
                                                <div class="fieldtitle">
                                <?php echo JText::_('JS_SUPERVISOR'); ?>:<?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                                </div>
                                                <div class="fieldvalue">
                                                    <input class="inputbox <?php echo $employer3_supervisor_required; ?>" type="text" name="employer3_supervisor" id="employer3_supervisor" size="<?php echo $med_field_width; ?>" maxlength="250" value = "<?php if (isset($this->resume)) echo $this->resume->employer3_supervisor; ?>" />
                                                </div>
                                            </div>				        
                            <?php }
                        }
                        ?>
                                    <?php
                                    break;
                                case "employer3_from_date":
                                    if ($field->published == 1) {
                                        $employer3_from_date_required = ($field->required ? 'required' : '');
                                        if (($section_employer == 1) && ($section_sub_employer3 == 1)) {
                                            ?>
                                            <div class="fieldwrapper">
                                                <div class="fieldtitle">
                                            <?php echo JText::_('JS_FROM_DATE'); ?>:<?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                                </div>
                                                <div class="fieldvalue">
                                                    <input class="inputbox <?php echo $employer3_from_date_required; ?>" type="text" name="employer3_from_date" id="employer3_from_date" size="<?php echo $sml_field_width; ?>" maxlength="20" value = "<?php if (isset($this->resume)) echo $this->resume->employer3_from_date; ?>" />
                                                </div>
                                            </div>				        
                            <?php }
                        }
                        ?>
                        <?php
                        break;
                    case "employer3_to_date":
                        if ($field->published == 1) {
                            $employer3_to_date_required = ($field->required ? 'required' : '');
                            if (($section_employer == 1) && ($section_sub_employer3 == 1)) {
                                ?>
                                            <div class="fieldwrapper">
                                                <div class="fieldtitle">
                                                    <?php echo JText::_('JS_TO_DATE'); ?>:<?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                                </div>
                                                <div class="fieldvalue">
                                                    <input class="inputbox <?php echo $employer3_to_date_required; ?>" type="text" name="employer3_to_date" id="employer3_to_date" size="<?php echo $sml_field_width; ?>" maxlength="20" value = "<?php if (isset($this->resume)) echo $this->resume->employer3_to_date; ?>" />
                                                </div>
                                            </div>				        
                            <?php }
                        }
                        ?>
                                    <?php
                                    break;
                                case "employer3_leave_reason":
                                    if ($field->published == 1) {
                                        $employer3_leave_reason_required = ($field->required ? 'required' : '');
                                        if (($section_employer == 1) && ($section_sub_employer3 == 1)) {
                                            ?>
                                            <div class="fieldwrapper">
                                                <div class="fieldtitle">
                                <?php echo JText::_('JS_LEAVING_REASON'); ?>:<?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                                </div>
                                                <div class="fieldvalue">
                                                    <input class="inputbox <?php echo $employer3_leave_reason_required; ?>" type="text" name="employer3_leave_reason" id="employer3_leave_reason" size="<?php echo $med_field_width; ?>" maxlength="250" value = "<?php if (isset($this->resume)) echo $this->resume->employer3_leave_reason; ?>" />
                                                </div>
                                            </div>				        
                                        <?php }
                                    }
                                    ?>
                                    <?php
                                    break;
                                case "employer3_city":
                                    if ($field->published == 1) {
                                        $employer3_city_required = ($field->required ? 'required' : '');
                                        if (($section_employer == 1) && ($section_sub_employer3 == 1)) {
                                            ?>
                                            <div class="fieldwrapper">
                                                <div class="fieldtitle">
                                            <?php echo JText::_('JS_CITY'); ?>:<?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                                </div>
                                                <div class="fieldvalue" id="remployer3_city">
                                                    <input class="inputbox <?php echo $employer3_city_required; ?>" type="text" name="employer3_city" id="employer3_city" size="40" maxlength="100" value="" />
                                                    <input class="inputbox" type="hidden" name="employer3cityforedit" id="employer3cityforedit" size="40" maxlength="100" value="<?php if (isset($this->resume->employer3_city)) echo $this->resumelists['employer3_city']; ?>" />
                                                </div>
                                            </div>				        
                                                <?php }
                                            }
                                            ?>
                        <?php
                        break;
                    case "employer3_zip":
                        if ($field->published == 1) {
                            $employer3_zip_required = ($field->required ? 'required' : '');
                            if (($section_employer == 1) && ($section_sub_employer3 == 1)) {
                                ?>
                                            <div class="fieldwrapper">
                                                <div class="fieldtitle">
                                            <?php echo JText::_('JS_ZIPCODE'); ?>:<?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                                </div>
                                                <div class="fieldvalue">
                                                    <input class="inputbox <?php echo $employer3_zip_required; ?>" type="text" name="employer3_zip" id="employer3_zip" size="<?php echo $sml_field_width; ?>" maxlength="20" value = "<?php if (isset($this->resume)) echo $this->resume->employer3_zip; ?>" />
                                                </div>
                                            </div>				        
                            <?php }
                        }
                        ?>
                                    <?php
                                    break;
                                case "employer3_address":
                                    if ($field->published == 1) {
                                        $employer3_address_required = ($field->required ? 'required' : '');
                                        if (($section_employer == 1) && ($section_sub_employer3 == 1)) {
                                            ?>
                                            <div class="fieldwrapper">
                                                <div class="fieldtitle">
                                <?php echo JText::_('JS_ADDRESS'); ?>:<?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                                </div>
                                                <div class="fieldvalue">
                                                    <input class="inputbox <?php echo $employer3_address_required; ?>" type="text" name="employer3_address" id="employer3_address" size="<?php echo $big_field_width; ?>" maxlength="250" value = "<?php if (isset($this->resume)) echo $this->resume->employer3_address; ?>" />
                                                </div>
                                            </div>				        
                                        <?php }
                                    }
                                    ?>	
                                    <?php
                                    break;
                                case "employer3_phone":
                                    if ($field->published == 1) {
                                        $employer3_phone_required = ($field->required ? 'required' : '');
                                        if (($section_employer == 1) && ($section_sub_employer3 == 1)) {
                                            ?>
                                            <div class="fieldwrapper">
                                                <div class="fieldtitle">
                                <?php echo JText::_('JS_PHONE'); ?>:<?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                                </div>
                                                <div class="fieldvalue">
                                                    <input class="inputbox <?php echo $employer3_phone_required; ?>" type="text" name="employer3_phone" id="employer3_phone" size="<?php echo $sml_field_width; ?>" maxlength="20" value = "<?php if (isset($this->resume)) echo $this->resume->employer3_phone; ?>" />
                                                </div>
                                            </div>				        
                            <?php }
                        }
                        ?>
                                    <?php break;
                                case "section_skills":
                                    ?>
                                </div>	
                                <div id="skills_data">
                                    <div class="fieldwrapper rs_sectionheadline">
                                            <?php echo JText::_('JS_SKILLS'); ?>
                                    </div>				        
                        <?php
                        break;
                    case "driving_license":
                        if ($field->published == 1) {
                            $driving_license_required = ($field->required ? 'required' : '');
                            if ($section_skills == 1) {
                                ?>
                                            <div class="fieldwrapper">
                                                <div class="fieldtitle">
                                            <?php echo JText::_('JS_HAVE_DRIVING_LICENSE'); ?>:<?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                                </div>
                                                <div class="fieldvalue">
                                                    <input class="inputbox <?php echo $driving_license_required; ?>" type="text" name="driving_license" id="driving_license" size="<?php echo $med_field_width; ?>" maxlength="250" value = "<?php if (isset($this->resume)) echo $this->resume->driving_license; ?>" />
                                                </div>
                                            </div>				        
                            <?php }
                        }
                        ?>
                        <?php
                        break;
                    case "license_no":
                        if ($field->published == 1) {
                            $license_no_required = ($field->required ? 'required' : '');
                            if ($section_skills == 1) {
                                ?>
                                            <div class="fieldwrapper">
                                                <div class="fieldtitle">
                                                    <?php echo JText::_('JS_YSE_LICENSE_NO'); ?>:<?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                                </div>
                                                <div class="fieldvalue">
                                                    <input class="inputbox <?php echo $license_no_required; ?>" type="text" name="license_no" id="license_no" size="<?php echo $med_field_width; ?>" maxlength="250" value = "<?php if (isset($this->resume)) echo $this->resume->license_no; ?>" />
                                                </div>
                                            </div>				        
                                        <?php }
                                    }
                                    ?>
                                    <?php
                                    break;
                                case "license_country":
                                    if ($field->published == 1) {
                                        $license_country_required = ($field->required ? 'required' : '');
                                        if ($section_skills == 1) {
                                            ?>
                                            <div class="fieldwrapper">
                                                <div class="fieldtitle">
                                <?php echo JText::_('JS_YSE_LICENSE_COUNTRY'); ?>:<?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                                </div>
                                                <div class="fieldvalue">
                                                    <input class="inputbox <?php echo $license_country_required; ?>" type="text" name="license_country" id="license_country" size="<?php echo $med_field_width; ?>" maxlength="250" value = "<?php if (isset($this->resume)) echo $this->resume->license_country; ?>" />
                                                </div>
                                            </div>				        
                                        <?php }
                                    }
                                    ?>
                        <?php
                        break;
                    case "skills":
                        if ($field->published == 1) {
                            $skills_required = ($field->required ? 'required' : '');
                            if ($section_skills == 1) {
                                ?>
                                            <div class="fieldwrapper">
                                                <div class="fieldtitle">
                                            <?php echo JText::_('JS_SKILLS'); ?>:<?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                                </div>
                                                <div class="fieldvalue">
                                                    <textarea class="inputbox <?php echo $skills_required; ?>" name="skills" id="skills" cols="60" rows="9"><?php if (isset($this->resume)) echo $this->resume->skills; ?></textarea>
                                                </div>
                                            </div>				        
                                                <?php }
                                            }
                                            ?>
                        <?php break;
                    case "section_resumeeditor":
                        ?>
                                </div>	
                                <div id="resume_editor_data">
                                    <div class="fieldwrapper rs_sectionheadline">
                                    <?php echo JText::_('JS_RESUME'); ?>
                                    </div>				        
                                    <?php break;
                                case "editor":
                                    ?>
                                    <?php if ($section_resumeeditor == 1) { ?>
                                        <div class="fieldwrapper">
                                            <?php
                                            $editor = JFactory::getEditor();
                                            if (isset($this->resume))
                                                echo $editor->display('resume', $this->resume->resume, '100%', '100%', '60', '20', false);
                                            else
                                                echo $editor->display('resume', '', '100%', '100%', '60', '20', false);
                                            ?>
                                        </div>				        
                        <?php } ?>
                                            <?php break;
                                        case "section_references":
                                            ?>
                                </div>	
                                <div id="references_data">
                        <?php if (($section_references == 1) && ($section_sub_reference == 1)) { ?>
                                        <div class="fieldwrapper rs_sectionheadline">
                                        <?php echo JText::_('JS_REFERENCE1'); ?>
                                        </div>				        
                                    <?php } ?>

                                    <?php
                                    break;
                                case "reference_name":
                                    if ($field->published == 1) {
                                        $reference_name_required = ($field->required ? 'required' : '');
                                        if (($section_references == 1) && ($section_sub_reference == 1)) {
                                            ?>
                                            <div class="fieldwrapper">
                                                <div class="fieldtitle">
                                            <?php echo JText::_('JS_NAME'); ?>:<?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                                </div>
                                                <div class="fieldvalue">
                                                    <input class="inputbox <?php echo $reference_name_required; ?>" type="text" name="reference_name" id="reference_name" size="<?php echo $med_field_width; ?>" maxlength="20" value = "<?php if (isset($this->resume)) echo $this->resume->reference_name; ?>" />
                                                </div>
                                            </div>				        
                                        <?php }
                                    }
                                    ?>
                                            <?php
                                            break;
                                        case "reference_city":
                                            if ($field->published == 1) {
                                                $reference_city_required = ($field->required ? 'required' : '');
                                                if (($section_references == 1) && ($section_sub_reference == 1)) {
                                                    ?>
                                            <div class="fieldwrapper">
                                                <div class="fieldtitle">
                                            <?php echo JText::_('JS_CITY'); ?>:<?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                                </div>
                                                <div class="fieldvalue" id="rreference_city">
                                                    <input class="inputbox <?php echo $reference_city_required; ?>" type="text" name="reference_city" id="reference_city" size="40" maxlength="100" value="" />
                                                    <input class="inputbox" type="hidden" name="referencecityforedit" id="referencecityforedit" size="40" maxlength="100" value="<?php if (isset($this->resume->reference_city)) echo $this->resumelists['reference_city']; ?>" />
                                                </div>
                                            </div>				        
                            <?php }
                        }
                        ?>
                                    <?php
                                    break;
                                case "reference_zipcode":
                                    if ($field->published == 1) {
                                        $reference_zipcode_required = ($field->required ? 'required' : '');
                                        if (($section_references == 1) && ($section_sub_reference == 1)) {
                                            ?>
                                            <div class="fieldwrapper">
                                                <div class="fieldtitle">
                                                    <?php echo JText::_('JS_ZIPCODE'); ?>:<?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                                </div>
                                                <div class="fieldvalue">
                                                    <input class="inputbox <?php echo $reference_zipcode_required; ?>" type="text" name="reference_zipcode" id="reference_zipcode" size="<?php echo $sml_field_width; ?>" maxlength="250" value = "<?php if (isset($this->resume)) echo $this->resume->reference_zipcode; ?>" />
                                                </div>
                                            </div>				        
                                        <?php }
                                    }
                                    ?>	
                                    <?php
                                    break;
                                case "reference_address":
                                    if ($field->published == 1) {
                                        $reference_address_required = ($field->required ? 'required' : '');
                                        if (($section_references == 1) && ($section_sub_reference == 1)) {
                                            ?>
                                            <div class="fieldwrapper">
                                                <div class="fieldtitle">
                                            <?php echo JText::_('JS_ADDRESS'); ?>:<?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                                </div>
                                                <div class="fieldvalue">
                                                    <input class="inputbox <?php echo $reference_address_required; ?>" type="text" name="reference_address" id="reference_address" size="<?php echo $big_field_width; ?>" maxlength="250" value = "<?php if (isset($this->resume)) echo $this->resume->reference_address; ?>" />
                                                </div>
                                            </div>				        
                            <?php }
                        }
                        ?>
                                    <?php
                                    break;
                                case "reference_phone":
                                    if ($field->published == 1) {
                                        $reference_phone_required = ($field->required ? 'required' : '');
                                        if (($section_references == 1) && ($section_sub_reference == 1)) {
                                            ?>
                                            <div class="fieldwrapper">
                                                <div class="fieldtitle">
                                                    <?php echo JText::_('JS_PHONE'); ?>:<?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                                </div>
                                                <div class="fieldvalue">
                                                    <input class="inputbox <?php echo $reference_phone_required; ?>" type="text" name="reference_phone" id="reference_phone" size="<?php echo $med_field_width; ?>" maxlength="20" value = "<?php if (isset($this->resume)) echo $this->resume->reference_phone; ?>" />
                                                </div>
                                            </div>				        
                                        <?php }
                                    }
                                    ?>
                                    <?php
                                    break;
                                case "reference_relation":
                                    if ($field->published == 1) {
                                        $reference_relation_required = ($field->required ? 'required' : '');
                                        if (($section_references == 1) && ($section_sub_reference == 1)) {
                                            ?>
                                            <div class="fieldwrapper">
                                                <div class="fieldtitle">
                                <?php echo JText::_('JS_RELATION'); ?>:<?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                                </div>
                                                <div class="fieldvalue">
                                                    <input class="inputbox <?php echo $reference_relation_required; ?>" type="text" name="reference_relation" id="reference_relation" size="<?php echo $med_field_width; ?>" maxlength="20" value = "<?php if (isset($this->resume)) echo $this->resume->reference_relation; ?>" />
                                                </div>
                                            </div>				        
                                        <?php }
                                    }
                                    ?>
                                            <?php
                                            break;
                                        case "reference_years":
                                            if ($field->published == 1) {
                                                $reference_years_required = ($field->required ? 'required' : '');
                                                if (($section_references == 1) && ($section_sub_reference == 1)) {
                                                    ?>
                                            <div class="fieldwrapper">
                                                <div class="fieldtitle">
                                            <?php echo JText::_('JS_YEARS'); ?>:<?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                                </div>
                                                <div class="fieldvalue">
                                                    <input class="inputbox <?php echo $reference_years_required; ?>" type="text" name="reference_years" id="reference_years" size="<?php echo $sml_field_width; ?>" maxlength="20" value = "<?php if (isset($this->resume)) echo $this->resume->reference_years; ?>" />
                                                </div>
                                            </div>				        
                                                <?php }
                                            }
                                            ?>
                        <?php break;
                    case "section_sub_reference1":
                        ?>
                                    <?php if (($section_references == 1) && ($section_sub_reference1 == 1)) { ?>
                                        <div class="fieldwrapper rs_sectionheadline">
                                        <?php echo JText::_('JS_REFERENCE2'); ?>
                                        </div>				        
                                    <?php } ?>
                                        <?php
                                        break;
                                    case "reference1_name":
                                        if ($field->published == 1) {
                                            $reference1_name_required = ($field->required ? 'required' : '');
                                            if (($section_references == 1) && ($section_sub_reference1 == 1)) {
                                                ?>
                                            <div class="fieldwrapper">
                                                <div class="fieldtitle">
                                <?php echo JText::_('JS_NAME'); ?>:<?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                                </div>
                                                <div class="fieldvalue">
                                                    <input class="inputbox <?php echo $reference1_name_required; ?>" type="text" name="reference1_name" id="reference1_name" size="<?php echo $med_field_width; ?>" maxlength="20" value = "<?php if (isset($this->resume)) echo $this->resume->reference1_name; ?>" />
                                                </div>
                                            </div>				        
                            <?php }
                        }
                        ?>	
                                    <?php
                                    break;
                                case "reference1_city":
                                    if ($field->published == 1) {
                                        $reference1_city_required = ($field->required ? 'required' : '');
                                        if (($section_references == 1) && ($section_sub_reference1 == 1)) {
                                            ?>
                                            <div class="fieldwrapper">
                                                <div class="fieldtitle">
                                <?php echo JText::_('JS_CITY'); ?>:<?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                                </div>
                                                <div class="fieldvalue" id="rreference1_city">
                                                    <input class="inputbox <?php echo $reference1_city_required; ?>" type="text" name="reference1_city" id="reference1_city" size="40" maxlength="100" value="" />
                                                    <input class="inputbox" type="hidden" name="reference1cityforedit" id="reference1cityforedit" size="40" maxlength="100" value="<?php if (isset($this->resume->reference1_city)) echo $this->resumelists['reference1_city']; ?>" />
                                                </div>
                                            </div>				        
                                        <?php }
                                    }
                                    ?>	
                        <?php
                        break;
                    case "reference1_zipcode":
                        if ($field->published == 1) {
                            $reference1_zipcode_required = ($field->required ? 'required' : '');
                            if (($section_references == 1) && ($section_sub_reference1 == 1)) {
                                ?>
                                            <div class="fieldwrapper">
                                                <div class="fieldtitle">
                                            <?php echo JText::_('JS_ZIPCODE'); ?>:<?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                                </div>
                                                <div class="fieldvalue">
                                                    <input class="inputbox <?php echo $reference1_zipcode_required; ?>" type="text" name="reference1_zipcode" id="reference1_zipcode" size="<?php echo $sml_field_width; ?>" maxlength="250" value = "<?php if (isset($this->resume)) echo $this->resume->reference1_zipcode; ?>" />
                                                </div>
                                            </div>				        
                                                <?php }
                                            }
                                            ?>	
                        <?php
                        break;
                    case "reference1_address":
                        if ($field->published == 1) {
                            $reference1_address_required = ($field->required ? 'required' : '');
                            if (($section_references == 1) && ($section_sub_reference1 == 1)) {
                                ?>
                                            <div class="fieldwrapper">
                                                <div class="fieldtitle">
                                            <?php echo JText::_('JS_ADDRESS'); ?>:<?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                                </div>
                                                <div class="fieldvalue">
                                                    <input class="inputbox <?php echo $reference1_address_required; ?>" type="text" name="reference1_address" id="reference1_address" size="<?php echo $big_field_width; ?>" maxlength="250" value = "<?php if (isset($this->resume)) echo $this->resume->reference1_address; ?>" />
                                                </div>
                                            </div>				        
                            <?php }
                        }
                        ?>	
                                    <?php
                                    break;
                                case "reference1_phone":
                                    if ($field->published == 1) {
                                        $reference1_phone_required = ($field->required ? 'required' : '');
                                        if (($section_references == 1) && ($section_sub_reference1 == 1)) {
                                            ?>
                                            <div class="fieldwrapper">
                                                <div class="fieldtitle">
                                            <?php echo JText::_('JS_PHONE'); ?>:<?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                                </div>
                                                <div class="fieldvalue">
                                                    <input class="inputbox <?php echo $reference1_phone_required; ?>" type="text" name="reference1_phone" id="reference1_phone" size="<?php echo $med_field_width; ?>" maxlength="20" value = "<?php if (isset($this->resume)) echo $this->resume->reference1_phone; ?>" />
                                                </div>
                                            </div>				        
                                                <?php }
                                            }
                                            ?>	
                        <?php
                        break;
                    case "reference1_relation":
                        if ($field->published == 1) {
                            $reference1_relation_required = ($field->required ? 'required' : '');
                            if (($section_references == 1) && ($section_sub_reference1 == 1)) {
                                ?>
                                            <div class="fieldwrapper">
                                                <div class="fieldtitle">
                                            <?php echo JText::_('JS_RELATION'); ?>:<?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                                </div>
                                                <div class="fieldvalue">
                                                    <input class="inputbox <?php echo $reference1_relation_required; ?>" type="text" name="reference1_relation" id="reference1_relation" size="<?php echo $med_field_width; ?>" maxlength="20" value = "<?php if (isset($this->resume)) echo $this->resume->reference1_relation; ?>" />
                                                </div>
                                            </div>				        
                            <?php }
                        }
                        ?>	
                                    <?php
                                    break;
                                case "reference1_years":
                                    if ($field->published == 1) {
                                        $reference1_years_required = ($field->required ? 'required' : '');
                                        if (($section_references == 1) && ($section_sub_reference1 == 1)) {
                                            ?>
                                            <div class="fieldwrapper">
                                                <div class="fieldtitle">
                                <?php echo JText::_('JS_YEARS'); ?>:<?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                                </div>
                                                <div class="fieldvalue">
                                                    <input class="inputbox <?php echo $reference1_years_required; ?>" type="text" name="reference1_years" id="reference1_years" size="<?php echo $sml_field_width; ?>" maxlength="20" value = "<?php if (isset($this->resume)) echo $this->resume->reference1_years; ?>" />
                                                </div>
                                            </div>				        
                                        <?php }
                                    }
                                    ?>
                                    <?php break;
                                case "section_sub_reference2":
                                    ?>
                                            <?php if (($section_references == 1) && ($section_sub_reference2 == 1)) { ?>
                                        <div class="fieldwrapper rs_sectionheadline">
                            <?php echo JText::_('JS_REFERENCE3'); ?>
                                        </div>				        
                        <?php } ?>	
                        <?php
                        break;
                    case "reference2_name":
                        if ($field->published == 1) {
                            $reference2_name_required = ($field->required ? 'required' : '');
                            ?>
                                        <?php if (($section_references == 1) && ($section_sub_reference2 == 1)) { ?>
                                            <div class="fieldwrapper">
                                                <div class="fieldtitle">
                                                    <?php echo JText::_('JS_NAME'); ?>:<?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                                </div>
                                                <div class="fieldvalue">
                                                    <input class="inputbox <?php echo $reference2_name_required; ?>" type="text" name="reference2_name" id="reference2_name" size="<?php echo $med_field_width; ?>" maxlength="20" value = "<?php if (isset($this->resume)) echo $this->resume->reference2_name; ?>" />
                                                </div>
                                            </div>				        
                                        <?php }
                                    }
                                    ?>	
                                    <?php
                                    break;
                                case "reference2_city":
                                    if ($field->published == 1) {
                                        $reference2_city_required = ($field->required ? 'required' : '');
                                        if (($section_references == 1) && ($section_sub_reference2 == 1)) {
                                            ?>
                                            <div class="fieldwrapper">
                                                <div class="fieldtitle">
                                    <?php echo JText::_('JS_CITY'); ?>:<?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                                </div>
                                                <div class="fieldvalue" id="rreference2_city">
                                                    <input class="inputbox <?php echo $reference2_city_required; ?>" type="text" name="reference2_city" id="reference2_city" size="40" maxlength="100" value="" />
                                                    <input class="inputbox" type="hidden" name="reference2cityforedit" id="reference2cityforedit" size="40" maxlength="100" value="<?php if (isset($this->resume->reference2_city)) echo $this->resumelists['reference2_city']; ?>" />
                                                </div>
                                            </div>				        
                            <?php }
                        }
                        ?>	
                            <?php
                            break;
                        case "reference2_zipcode":
                            if ($field->published == 1) {
                                $reference2_zipcode_required = ($field->required ? 'required' : '');
                                if (($section_references == 1) && ($section_sub_reference2 == 1)) {
                                    ?>
                                            <div class="fieldwrapper">
                                                <div class="fieldtitle">
                                    <?php echo JText::_('JS_ZIPCODE'); ?>:<?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                                </div>
                                                <div class="fieldvalue">
                                                    <input class="inputbox <?php echo $reference2_zipcode_required; ?>" type="text" name="reference2_zipcode" id="reference2_zipcode" size="<?php echo $sml_field_width; ?>" maxlength="250" value = "<?php if (isset($this->resume)) echo $this->resume->reference2_zipcode; ?>" />
                                                </div>
                                            </div>				        
                            <?php }
                        }
                        ?>	
                            <?php
                            break;
                        case "reference2_address":
                            if ($field->published == 1) {
                                $reference2_address_required = ($field->required ? 'required' : '');
                                if (($section_references == 1) && ($section_sub_reference2 == 1)) {
                                    ?>
                                            <div class="fieldwrapper">
                                                <div class="fieldtitle">
                                    <?php echo JText::_('JS_ADDRESS'); ?>:<?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                                </div>
                                                <div class="fieldvalue">
                                                    <input class="inputbox <?php echo $reference2_address_required; ?>" type="text" name="reference2_address" id="reference2_address" size="<?php echo $big_field_width; ?>" maxlength="250" value = "<?php if (isset($this->resume)) echo $this->resume->reference2_address; ?>" />
                                                </div>
                                            </div>				        
                            <?php }
                        }
                        ?>	
                        <?php
                        break;
                    case "reference2_phone":
                        if ($field->published == 1) {
                            $reference2_phone_required = ($field->required ? 'required' : '');
                            if (($section_references == 1) && ($section_sub_reference2 == 1)) {
                                ?>
                                            <div class="fieldwrapper">
                                                <div class="fieldtitle">
                                <?php echo JText::_('JS_PHONE'); ?>:<?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                                </div>
                                                <div class="fieldvalue">
                                                    <input class="inputbox <?php echo $reference2_phone_required; ?>" type="text" name="reference2_phone" id="reference2_phone" size="<?php echo $med_field_width; ?>" maxlength="20" value = "<?php if (isset($this->resume)) echo $this->resume->reference2_phone; ?>" />
                                                </div>
                                            </div>				        
                            <?php }
                        }
                        ?>	
                        <?php
                        break;
                    case "reference2_relation":
                        if ($field->published == 1) {
                            $reference2_relation_required = ($field->required ? 'required' : '');
                            if (($section_references == 1) && ($section_sub_reference2 == 1)) {
                                ?>
                                            <div class="fieldwrapper">
                                                <div class="fieldtitle">
                                <?php echo JText::_('JS_RELATION'); ?>:<?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                                </div>
                                                <div class="fieldvalue">
                                                    <input class="inputbox <?php echo $reference2_relation_required; ?>" type="text" name="reference2_relation" id="reference2_relation" size="<?php echo $med_field_width; ?>" maxlength="20" value = "<?php if (isset($this->resume)) echo $this->resume->reference2_relation; ?>" />
                                                </div>
                                            </div>				        
                            <?php }
                        }
                        ?>	
                        <?php
                        break;
                    case "reference2_years":
                        if ($field->published == 1) {
                            $reference2_years_required = ($field->required ? 'required' : '');
                            if (($section_references == 1) && ($section_sub_reference2 == 1)) {
                                ?>
                                            <div class="fieldwrapper">
                                                <div class="fieldtitle">
                                <?php echo JText::_('JS_YEARS'); ?>:<?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                                </div>
                                                <div class="fieldvalue">
                                                    <input class="inputbox <?php echo $reference2_years_required; ?>" type="text" name="reference2_years" id="reference2_years" size="<?php echo $sml_field_width; ?>" maxlength="20" value = "<?php if (isset($this->resume)) echo $this->resume->reference2_years; ?>" />
                                                </div>
                                            </div>				        
                            <?php }
                        }
                        ?>
                        <?php break;
                    case "section_sub_reference3":
                        ?>
                        <?php if (($section_references == 1) && ($section_sub_reference3 == 1)) { ?>
                                        <div class="fieldwrapper rs_sectionheadline">
                            <?php echo JText::_('JS_REFERENCE4'); ?>
                                        </div>				        
                        <?php } ?>	
                        <?php
                        break;
                    case "reference3_name":
                        if ($field->published == 1) {
                            $reference3_name_required = ($field->required ? 'required' : '');
                            if (($section_references == 1) && ($section_sub_reference3 == 1)) {
                                ?>
                                            <div class="fieldwrapper">
                                                <div class="fieldtitle">
                                <?php echo JText::_('JS_NAME'); ?>:<?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                                </div>
                                                <div class="fieldvalue">
                                                    <input class="inputbox <?php echo $reference3_name_required; ?>" type="text" name="reference3_name" id="reference3_name" size="<?php echo $med_field_width; ?>" maxlength="20" value = "<?php if (isset($this->resume)) echo $this->resume->reference3_name; ?>" />
                                                </div>
                                            </div>				        
                            <?php }
                        }
                        ?>	
                        <?php
                        break;
                    case "reference3_city":
                        if ($field->published == 1) {
                            $reference3_city_required = ($field->required ? 'required' : '');
                            if (($section_references == 1) && ($section_sub_reference3 == 1)) {
                                ?>
                                            <div class="fieldwrapper">
                                                <div class="fieldtitle">
                                <?php echo JText::_('JS_CITY'); ?>:<?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                                </div>
                                                <div class="fieldvalue" id="rreference3_city">
                                                    <input class="inputbox <?php echo $reference3_city_required; ?>" type="text" name="reference3_city" id="reference3_city" size="40" maxlength="100" value="" />
                                                    <input class="inputbox" type="hidden" name="reference3cityforedit" id="reference3cityforedit" size="40" maxlength="100" value="<?php if (isset($this->resume->reference3_city)) echo $this->resumelists['reference3_city']; ?>" />
                                                </div>
                                            </div>				        
                            <?php }
                        }
                        ?>	
                        <?php
                        break;
                    case "reference3_zipcode":
                        if ($field->published == 1) {
                            $reference3_zipcode_required = ($field->required ? 'required' : '');
                            if (($section_references == 1) && ($section_sub_reference3 == 1)) {
                                ?>
                                            <div class="fieldwrapper">
                                                <div class="fieldtitle">
                                <?php echo JText::_('JS_ZIPCODE'); ?>:<?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                                </div>
                                                <div class="fieldvalue">
                                                    <input class="inputbox <?php echo $reference3_zipcode_required; ?>" type="text" name="reference3_zipcode" id="reference3_zipcode" size="<?php echo $sml_field_width; ?>" maxlength="250" value = "<?php if (isset($this->resume)) echo $this->resume->reference3_zipcode; ?>" />
                                                </div>
                                            </div>				        
                            <?php }
                        }
                        ?>	
                        <?php
                        break;
                    case "reference3_address":
                        if ($field->published == 1) {
                            $reference3_address_required = ($field->required ? 'required' : '');
                            if (($section_references == 1) && ($section_sub_reference3 == 1)) {
                                ?>
                                            <div class="fieldwrapper">
                                                <div class="fieldtitle">
                                <?php echo JText::_('JS_ADDRESS'); ?>:<?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                                </div>
                                                <div class="fieldvalue">
                                                    <input class="inputbox <?php echo $reference3_address_required; ?>" type="text" name="reference3_address" id="reference3_address" size="<?php echo $big_field_width; ?>" maxlength="250" value = "<?php if (isset($this->resume)) echo $this->resume->reference3_address; ?>" />
                                                </div>
                                            </div>				        
                            <?php }
                        }
                        ?>	
                        <?php
                        break;
                    case "reference3_phone":
                        if ($field->published == 1) {
                            $reference3_phone_required = ($field->required ? 'required' : '');
                            if (($section_references == 1) && ($section_sub_reference3 == 1)) {
                                ?>
                                            <div class="fieldwrapper">
                                                <div class="fieldtitle">
                                <?php echo JText::_('JS_PHONE'); ?>:<?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                                </div>
                                                <div class="fieldvalue">
                                                    <input class="inputbox <?php echo $reference3_phone_required; ?>" type="text" name="reference3_phone" id="reference3_phone" size="<?php echo $med_field_width; ?>" maxlength="20" value = "<?php if (isset($this->resume)) echo $this->resume->reference3_phone; ?>" />
                                                </div>
                                            </div>				        
                            <?php }
                        }
                        ?>	
                        <?php
                        break;
                    case "reference3_relation":
                        if ($field->published == 1) {
                            $reference3_relation_required = ($field->required ? 'required' : '');
                            if (($section_references == 1) && ($section_sub_reference3 == 1)) {
                                ?>
                                            <div class="fieldwrapper">
                                                <div class="fieldtitle">
                                <?php echo JText::_('JS_RELATION'); ?>:<?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                                </div>
                                                <div class="fieldvalue">
                                                    <input class="inputbox <?php echo $reference3_relation_required; ?>" type="text" name="reference3_relation" id="reference3_relation" size="<?php echo $med_field_width; ?>" maxlength="20" value = "<?php if (isset($this->resume)) echo $this->resume->reference3_relation; ?>" />
                                                </div>
                                            </div>				        
                            <?php }
                        }
                        ?>	
                        <?php
                        break;
                    case "reference3_years":
                        if ($field->published == 1) {
                            $reference3_years_required = ($field->required ? 'required' : '');
                            if (($section_references == 1) && ($section_sub_reference3 == 1)) {
                                ?>
                                            <div class="fieldwrapper">
                                                <div class="fieldtitle">
                                <?php echo JText::_('JS_YEARS'); ?>:<?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                                </div>
                                                <div class="fieldvalue">
                                                    <input class="inputbox <?php echo $reference3_years_required; ?>" type="text" name="reference3_years" id="reference3_years" size="<?php echo $sml_field_width; ?>" maxlength="20" value = "<?php if (isset($this->resume)) echo $this->resume->reference3_years; ?>" />
                                                </div>
                                            </div>				        
                            <?php }
                        }
                        ?>	
                        <?php
                        break;
                    case "section_languages":
                        ?>
                                </div>	
                                <div id="languages_data">
                        <?php if (($section_languages == 1) && ($section_sub_language == 1)) { ?>
                                        <div class="fieldwrapper rs_sectionheadline">
                            <?php echo JText::_('JS_LANGUAGE1'); ?>
                                        </div>				        
                        <?php } ?>

                        <?php
                        break;
                    case "language_name":
                        if ($field->published == 1) {
                            $language_name_required = ($field->required ? 'required' : '');
                            if (($section_languages == 1) && ($section_sub_language == 1)) {
                                ?>
                                            <div class="fieldwrapper">
                                                <div class="fieldtitle">
                                <?php echo JText::_('JS_LANGUAGE_NAME'); ?>:<?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                                </div>
                                                <div class="fieldvalue">
                                                    <input class="inputbox <?php echo $language_name_required; ?>" type="text" name="language" id="language" size="<?php echo $med_field_width; ?>" maxlength="20" value = "<?php if (isset($this->resume)) echo $this->resume->language; ?>" />
                                                </div>
                                            </div>				        
                            <?php }
                        }
                        ?>
                        <?php
                        break;
                    case "language_reading":
                        if ($field->published == 1) {
                            $language_reading_required = ($field->required ? 'required' : '');
                            if (($section_languages == 1) && ($section_sub_language == 1)) {
                                ?>
                                            <div class="fieldwrapper">
                                                <div class="fieldtitle">
                                <?php echo JText::_('JS_LANGUAGE_READ'); ?><?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                                </div>
                                                <div class="fieldvalue">
                                                    <input class="inputbox <?php echo $language_reading_required; ?>" type="text" name="language_reading" id="language_reading" size="<?php echo $med_field_width; ?>" maxlength="20" value = "<?php if (isset($this->resume)) echo $this->resume->language_reading; ?>" />
                                                </div>
                                            </div>				        
                            <?php }
                        }
                        ?>
                        <?php
                        break;
                    case "language_writing":
                        if ($field->published == 1) {
                            $language_writing_required = ($field->required ? 'required' : '');
                            if (($section_languages == 1) && ($section_sub_language == 1)) {
                                ?>
                                            <div class="fieldwrapper">
                                                <div class="fieldtitle">
                                <?php echo JText::_('JS_LANGUAGE_WRITE'); ?><?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                                </div>
                                                <div class="fieldvalue">
                                                    <input class="inputbox <?php echo $language_writing_required; ?>" type="text" name="language_writing" id="language_writing" size="<?php echo $med_field_width; ?>" maxlength="20" value = "<?php if (isset($this->resume)) echo $this->resume->language_writing; ?>" />
                                                </div>
                                            </div>				        
                            <?php }
                        }
                        ?>
                        <?php
                        break;
                    case "language_understading":
                        if ($field->published == 1) {
                            $language_understading_required = ($field->required ? 'required' : '');
                            if (($section_languages == 1) && ($section_sub_language == 1)) {
                                ?>
                                            <div class="fieldwrapper">
                                                <div class="fieldtitle">
                                <?php echo JText::_('JS_LANGUAGE_UNDERSTAND'); ?><?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                                </div>
                                                <div class="fieldvalue">
                                                    <input class="inputbox <?php echo $language_understading_required; ?>" type="text" name="language_understanding" id="language_understanding" size="<?php echo $med_field_width; ?>" maxlength="100" value = "<?php if (isset($this->resume)) echo $this->resume->language_understanding; ?>" />
                                                </div>
                                            </div>				        
                            <?php }
                        }
                        ?>
                        <?php
                        break;
                    case "language_where_learned":
                        if ($field->published == 1) {
                            $language_where_learned_required = ($field->required ? 'required' : '');
                            if (($section_languages == 1) && ($section_sub_language == 1)) {
                                ?>
                                            <div class="fieldwrapper">
                                                <div class="fieldtitle">
                                <?php echo JText::_('JS_LANGUAGE_LEARN_INSTITUTE'); ?><?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                                </div>
                                                <div class="fieldvalue">
                                                    <input class="inputbox <?php echo $language_where_learned_required; ?>" type="text" name="language_where_learned" id="language_where_learned" size="<?php echo $med_field_width; ?>" maxlength="100" value = "<?php if (isset($this->resume)) echo $this->resume->language_where_learned; ?>" />
                                                </div>
                                            </div>				        
                            <?php }
                        }
                        ?>
                        <?php break;
                    case "section_sub_language1":
                        ?>
                        <?php if (($section_languages == 1) && ($section_sub_language1 == 1)) { ?>
                                        <div class="fieldwrapper rs_sectionheadline">
                            <?php echo JText::_('JS_LANGUAGE2'); ?>
                                        </div>				        
                        <?php } ?>

                        <?php
                        break;
                    case "language1_name":
                        if ($field->published == 1) {
                            $language1_name_required = ($field->required ? 'required' : '');
                            if (($section_languages == 1) && ($section_sub_language1 == 1)) {
                                ?>
                                            <div class="fieldwrapper">
                                                <div class="fieldtitle">
                                <?php echo JText::_('JS_LANGUAGE_NAME'); ?>:<?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                                </div>
                                                <div class="fieldvalue">
                                                    <input class="inputbox <?php echo $language1_name_required; ?>" type="text" name="language1" id="language1" size="<?php echo $med_field_width; ?>" maxlength="20" value = "<?php if (isset($this->resume)) echo $this->resume->language1; ?>" />
                                                </div>
                                            </div>				        
                            <?php }
                        }
                        ?>
                        <?php
                        break;
                    case "language1_reading":
                        if ($field->published == 1) {
                            $language1_reading_required = ($field->required ? 'required' : '');
                            if (($section_languages == 1) && ($section_sub_language1 == 1)) {
                                ?>
                                            <div class="fieldwrapper">
                                                <div class="fieldtitle">
                                <?php echo JText::_('JS_LANGUAGE_READ'); ?><?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                                </div>
                                                <div class="fieldvalue">
                                                    <input class="inputbox <?php echo $language1_reading_required; ?>" type="text" name="language1_reading" id="language1_reading" size="<?php echo $med_field_width; ?>" maxlength="20" value = "<?php if (isset($this->resume)) echo $this->resume->language1_reading; ?>" />
                                                </div>
                                            </div>				        
                            <?php }
                        }
                        ?>
                        <?php
                        break;
                    case "language1_writing":
                        if ($field->published == 1) {
                            $language1_writing_required = ($field->required ? 'required' : '');
                            if (($section_languages == 1) && ($section_sub_language1 == 1)) {
                                ?>
                                            <div class="fieldwrapper">
                                                <div class="fieldtitle">
                                <?php echo JText::_('JS_LANGUAGE_WRITE'); ?><?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                                </div>
                                                <div class="fieldvalue">
                                                    <input class="inputbox <?php echo $language1_writing_required; ?>" type="text" name="language1_writing" id="language1_writing" size="<?php echo $med_field_width; ?>" maxlength="20" value = "<?php if (isset($this->resume)) echo $this->resume->language1_writing; ?>" />
                                                </div>
                                            </div>				        
                            <?php }
                        }
                        ?>
                        <?php
                        break;
                    case "language1_understading":
                        if ($field->published == 1) {
                            $language1_understading_required = ($field->required ? 'required' : '');
                            if (($section_languages == 1) && ($section_sub_language1 == 1)) {
                                ?>
                                            <div class="fieldwrapper">
                                                <div class="fieldtitle">
                                <?php echo JText::_('JS_LANGUAGE_UNDERSTAND'); ?><?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                                </div>
                                                <div class="fieldvalue">
                                                    <input class="inputbox <?php echo $language1_understading_required; ?>" type="text" name="language1_understanding" id="language1_understanding" size="<?php echo $med_field_width; ?>" maxlength="100" value = "<?php if (isset($this->resume)) echo $this->resume->language1_understanding; ?>" />
                                                </div>
                                            </div>				        
                            <?php }
                        }
                        ?>
                        <?php
                        break;
                    case "language1_where_learned":
                        if ($field->published == 1) {
                            $language1_where_learned_required = ($field->required ? 'required' : '');
                            ?>
                            <?php if (($section_languages == 1) && ($section_sub_language1 == 1)) { ?>
                                            <div class="fieldwrapper">
                                                <div class="fieldtitle">
                                <?php echo JText::_('JS_LANGUAGE_LEARN_INSTITUTE'); ?><?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                                </div>
                                                <div class="fieldvalue">
                                                    <input class="inputbox <?php echo $language1_where_learned_required; ?>" type="text" name="language1_where_learned" id="language1_where_learned" size="<?php echo $med_field_width; ?>" maxlength="100" value = "<?php if (isset($this->resume)) echo $this->resume->language1_where_learned; ?>" />
                                                </div>
                                            </div>				        
                            <?php }
                        }
                        ?>
                        <?php break;
                    case "section_sub_language2":
                        ?>
                        <?php if (($section_languages == 1) && ($section_sub_language2 == 1)) { ?>
                                        <div class="fieldwrapper rs_sectionheadline">
                            <?php echo JText::_('JS_LANGUAGE3'); ?>
                                        </div>				        
                        <?php } ?>

                        <?php
                        break;
                    case "language2_name":
                        if ($field->published == 1) {
                            $language2_name_required = ($field->required ? 'required' : '');
                            if (($section_languages == 1) && ($section_sub_language2 == 1)) {
                                ?>
                                            <div class="fieldwrapper">
                                                <div class="fieldtitle">
                                <?php echo JText::_('JS_LANGUAGE_NAME'); ?>:<?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                                </div>
                                                <div class="fieldvalue">
                                                    <input class="inputbox <?php echo $language2_name_required; ?>" type="text" name="language2" id="language2" size="<?php echo $med_field_width; ?>" maxlength="20" value = "<?php if (isset($this->resume)) echo $this->resume->language2; ?>" />
                                                </div>
                                            </div>				        
                            <?php }
                        }
                        ?>
                        <?php
                        break;
                    case "language2_reading":
                        if ($field->published == 1) {
                            $language2_reading_required = ($field->required ? 'required' : '');
                            if (($section_languages == 1) && ($section_sub_language2 == 1)) {
                                ?>
                                            <div class="fieldwrapper">
                                                <div class="fieldtitle">
                                <?php echo JText::_('JS_LANGUAGE_READ'); ?><?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                                </div>
                                                <div class="fieldvalue">
                                                    <input class="inputbox <?php echo $language2_reading_required; ?>" type="text" name="language2_reading" id="language2_reading" size="<?php echo $med_field_width; ?>" maxlength="20" value = "<?php if (isset($this->resume)) echo $this->resume->language2_reading; ?>" />
                                                </div>
                                            </div>				        
                            <?php }
                        }
                        ?>
                        <?php
                        break;
                    case "language2_writing":
                        if ($field->published == 1) {
                            $language2_writing_required = ($field->required ? 'required' : '');
                            if (($section_languages == 1) && ($section_sub_language2 == 1)) {
                                ?>
                                            <div class="fieldwrapper">
                                                <div class="fieldtitle">
                                <?php echo JText::_('JS_LANGUAGE_WRITE'); ?><?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                                </div>
                                                <div class="fieldvalue">
                                                    <input class="inputbox <?php echo $language2_writing_required; ?>" type="text" name="language2_writing" id="language2_writing" size="<?php echo $med_field_width; ?>" maxlength="20" value = "<?php if (isset($this->resume)) echo $this->resume->language2_writing; ?>" />
                                                </div>
                                            </div>				        
                            <?php }
                        }
                        ?>
                        <?php
                        break;
                    case "language2_understading":
                        if ($field->published == 1) {
                            $language2_understading_required = ($field->required ? 'required' : '');
                            if (($section_languages == 1) && ($section_sub_language2 == 1)) {
                                ?>
                                            <div class="fieldwrapper">
                                                <div class="fieldtitle">
                                <?php echo JText::_('JS_LANGUAGE_UNDERSTAND'); ?><?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                                </div>
                                                <div class="fieldvalue">
                                                    <input class="inputbox <?php echo $language2_understading_required; ?>" type="text" name="language2_understanding" id="language2_understanding" size="<?php echo $med_field_width; ?>" maxlength="100" value = "<?php if (isset($this->resume)) echo $this->resume->language2_understanding; ?>" />
                                                </div>
                                            </div>				        
                            <?php }
                        }
                        ?>
                        <?php
                        break;
                    case "language2_where_learned":
                        if ($field->published == 1) {
                            $language2_where_learned_required = ($field->required ? 'required' : '');
                            if (($section_languages == 1) && ($section_sub_language2 == 1)) {
                                ?>
                                            <div class="fieldwrapper">
                                                <div class="fieldtitle">
                                <?php echo JText::_('JS_LANGUAGE_LEARN_INSTITUTE'); ?><?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                                </div>
                                                <div class="fieldvalue">
                                                    <input class="inputbox <?php echo $language2_where_learned_required; ?>" type="text" name="language2_where_learned" id="language2_where_learned" size="<?php echo $med_field_width; ?>" maxlength="100" value = "<?php if (isset($this->resume)) echo $this->resume->language2_where_learned; ?>" />
                                                </div>
                                            </div>				        
                            <?php
                            }
                        }
                        break;
                    case "section_sub_language3":
                        ?>
                        <?php if (($section_languages == 1) && ($section_sub_language3 == 1)) { ?>
                                        <div class="fieldwrapper rs_sectionheadline">
                            <?php echo JText::_('JS_LANGUAGE4'); ?>
                                        </div>				        
                        <?php } ?>

                        <?php
                        break;
                    case "language3_name":
                        if ($field->published == 1) {
                            $language3_name_required = ($field->required ? 'required' : '');
                            if (($section_languages == 1) && ($section_sub_language3 == 1)) {
                                ?>
                                            <div class="fieldwrapper">
                                                <div class="fieldtitle">
                                <?php echo JText::_('JS_LANGUAGE_NAME'); ?>:<?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                                </div>
                                                <div class="fieldvalue">
                                                    <input class="inputbox <?php echo $language3_name_required; ?>" type="text" name="language3" id="language3" size="<?php echo $med_field_width; ?>" maxlength="20" value = "<?php if (isset($this->resume)) echo $this->resume->language3; ?>" />
                                                </div>
                                            </div>				        
                            <?php }
                        }
                        ?>
                        <?php
                        break;
                    case "language3_reading":
                        if ($field->published == 1) {
                            $language3_reading_required = ($field->required ? 'required' : '');
                            if (($section_languages == 1) && ($section_sub_language3 == 1)) {
                                ?>
                                            <div class="fieldwrapper">
                                                <div class="fieldtitle">
                                <?php echo JText::_('JS_LANGUAGE_READ'); ?><?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                                </div>
                                                <div class="fieldvalue">
                                                    <input class="inputbox <?php echo $language3_reading_required; ?>" type="text" name="language3_reading" id="language3_reading" size="<?php echo $med_field_width; ?>" maxlength="20" value = "<?php if (isset($this->resume)) echo $this->resume->language3_reading; ?>" />
                                                </div>
                                            </div>				        
                            <?php }
                        }
                        ?>
                        <?php
                        break;
                    case "language3_writing":
                        if ($field->published == 1) {
                            $language3_writing_required = ($field->required ? 'required' : '');
                            if (($section_languages == 1) && ($section_sub_language3 == 1)) {
                                ?>
                                            <div class="fieldwrapper">
                                                <div class="fieldtitle">
                                <?php echo JText::_('JS_LANGUAGE_WRITE'); ?><?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                                </div>
                                                <div class="fieldvalue">
                                                    <input class="inputbox <?php echo $language3_writing_required; ?>" type="text" name="language3_writing" id="language3_writing" size="<?php echo $med_field_width; ?>" maxlength="20" value = "<?php if (isset($this->resume)) echo $this->resume->language3_writing; ?>" />
                                                </div>
                                            </div>				        
                            <?php }
                        }
                        ?>
                        <?php
                        break;
                    case "language3_understading":
                        if ($field->published == 1) {
                            $language3_understading_required = ($field->required ? 'required' : '');
                            if (($section_languages == 1) && ($section_sub_language3 == 1)) {
                                ?>
                                            <div class="fieldwrapper">
                                                <div class="fieldtitle">
                                <?php echo JText::_('JS_LANGUAGE_UNDERSTAND'); ?><?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                                </div>
                                                <div class="fieldvalue">
                                                    <input class="inputbox <?php echo $language3_understading_required; ?>" type="text" name="language3_understanding" id="language3_understanding" size="<?php echo $med_field_width; ?>" maxlength="100" value = "<?php if (isset($this->resume)) echo $this->resume->language3_understanding; ?>" />
                                                </div>
                                            </div>				        
                            <?php }
                        }
                        ?>
                        <?php
                        break;
                    case "language3_where_learned":
                        if ($field->published == 1) {
                            $language3_where_learned_required = ($field->required ? 'required' : '');
                            if (($section_languages == 1) && ($section_sub_language3 == 1)) {
                                ?>
                                            <div class="fieldwrapper">
                                                <div class="fieldtitle">
                                <?php echo JText::_('JS_LANGUAGE_LEARN_INSTITUTE'); ?><?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                                </div>
                                                <div class="fieldvalue">
                                                    <input class="inputbox <?php echo $language3_where_learned_required; ?>" type="text" name="language3_where_learned" id="language3_where_learned" size="<?php echo $med_field_width; ?>" maxlength="100" value = "<?php if (isset($this->resume)) echo $this->resume->language3_where_learned; ?>" />
                                                </div>
                                            </div>				        
                            <?php }
                        }
                        ?>
                        <?php
                        break;
                }
            }
            ?>	
                    </div>	<!-- Language bar ending div -->
                </div>	
            <?php
            if (isset($this->visitor['visitor'])) {
                if ($this->config['resume_captcha'] == 1 && $this->visitor['visitor'] == 1) {
                    if ($this->config['captchause'] == 1) {
                        ?>
                            <div class="fieldwrapper">
                                <div class="fieldtitle">
                                    <label id="captchamsg" for="captcha"><?php echo JText::_('JS_CAPTCHA'); ?></label><?php if ($field->required == 1) {
                            echo '&nbsp;<font color="red">*</font>';
                        } ?>
                                </div>
                                <div class="fieldvalue">
                        <?php echo $this->captcha; ?>
                                </div>
                            </div>				        
                        <?php } else {
                        ?>
                            <div class="fieldwrapper">
                                <div class="fieldtitle">
                                    <label id="captchamsg" for="captcha"><?php echo JText::_('JS_CAPTCHA'); ?></label><?php if ($field->required == 1) {
                            echo '&nbsp;<font color="red">*</font>';
                        } ?>
                                </div>
                                <div class="fieldvalue">
                                    <div id="dynamic_recaptcha_1"></div>
                                </div>
                            </div>				        
                    <?php
                    }
                }
            }
            ?>
                <div class="fieldwrapper">
                    <input type="button" id="button" class="button" name="perv_tab" value="" style="float:left;"/>
                    <input type="button" id="button" class="button" name="next_tab" value=""  style="float:right;"/>
                </div>				        
                <div class="fieldwrapper">
                    <input type="submit" id="button" class="button"  name="save_app" value="<?php echo JText::_('JS_SAVE_RESUME'); ?>" />
                </div>				        
            <?php
            if (isset($this->resume)) {
                if (($this->resume->create_date == '0000-00-00 00:00:00') || ($this->resume->create_date == ''))
                    $curdate = date('Y-m-d H:i:s');
                else
                    $curdate = $this->resume->create_date;
            }
            else
                $curdate = date('Y-m-d H:i:s');
            ?>
                <input type="hidden" name="create_date" value="<?php echo $curdate; ?>" />
                <input type="hidden" id="id" name="id" value="<?php if (isset($this->resume)) echo $this->resume->id; ?>" />
                <input type="hidden" name="layout" value="empview" />
                <input type="hidden" name="uid" value="<?php echo $this->uid; ?>" />
                <input type="hidden" name="option" value="<?php echo $this->option; ?>" />
                <input type="hidden" name="task" value="saveresume" />
                <input type="hidden" name="c" value="resume" />
                <input type="hidden" name="check" value="" />
                <input type="hidden" name="Itemid" value="<?php echo $this->Itemid; ?>" />
                <input type="hidden" name="j_dateformat" id="j_dateformat" value="<?php echo $js_scriptdateformat; ?>" />
            <?php if (isset($this->packagedetail[0])) echo '<input type="hidden" name="packageid" value="' . $this->packagedetail[0] . '" />'; ?>
            <?php if (isset($this->packagedetail[1])) echo '<input type="hidden" name="paymenthistoryid" value="' . $this->packagedetail[1] . '" />'; ?>
                <input type="hidden" id="default_longitude" name="default_longitude" value="<?php echo $this->config['default_longitude']; ?>"/>
                <input type="hidden" id="default_latitude" name="default_latitude" value="<?php echo $this->config['default_latitude']; ?>"/>

                <script language=Javascript>
    jQuery(document).ready(function(){
        var spanobject = jQuery("div.idTabs span");
        var pervbutton = jQuery('input[name="perv_tab"]');
        var nextbutton = jQuery('input[name="next_tab"]');
        var pervtab = jQuery(spanobject).children("a");
        var nexttab = jQuery(spanobject).next().children("a");
        function selectedTab(){
            var selectedtab = jQuery('div.idTabs span a.selected');
            return selectedtab;
        }
        function changeButtonText(){
            var span = jQuery(selectedTab()).parent('span');
            var firsttab = jQuery(spanobject).children("a");
            if(
                    jQuery(span).prev().children('a').length > 0 &&
                    (firsttab.attr("href") != jQuery(span).prev().children('a').attr("href") || jQuery(span).prev().children('a').attr("href") != jQuery('input[name="perv_tab"]').attr("data-tabid"))
                ){
                jQuery('input[name="perv_tab"]').val("<<  "+jQuery(span).prev().children('a').html()).attr('data-tabid',jQuery(span).prev().children('a').attr("href"));
            }
            var lasttab = jQuery(spanobject).last("a");
            if(
                    jQuery(span).next().children('a').length > 0 &&
                    lasttab.attr("href") != jQuery(span).next().children('a').attr("href")
                ){
                jQuery('input[name="next_tab"]').val(jQuery(span).next().children('a').html()+"  >>").attr('data-tabid',jQuery(span).next().children('a').attr("href"));
            }
            
        }
        function changeClick(){
            if(jQuery('div.idTabs span a.selected').attr("href") == jQuery('div.idTabs span').children('a').attr("href") && jQuery('div.idTabs span').children('a').attr("href") == jQuery('input[name="perv_tab"]').attr("href")){
                jQuery('input[name="perv_tab"]').attr('disabled','disabled');
            }else{
                jQuery('input[name="perv_tab"]').removeAttr('disabled');
            }
            if(jQuery('div.idTabs span a.selected').attr("href") == jQuery('div.idTabs span').last('a').attr("href") && jQuery('div.idTabs span').last('a').attr("href") == jQuery('input[name="next_tab"]').attr("href")){
                jQuery('input[name="next_tab"]').attr('disabled','disabled');
            }else{
                jQuery('input[name="next_tab"]').removeAttr('disabled');
            }
        }
        changeClick();
        jQuery(pervbutton).val("<<  "+pervtab.html()).attr('data-tabid',pervtab.attr("href")).click(function(e){
            e.preventDefault();
            var firsttab = jQuery(spanobject).children("a");
            var requesttab = jQuery('div.idTabs span a[href="'+jQuery(this).attr("data-tabid")+'"]');
            var selectedtab = selectedTab();
            if(firsttab.html() != selectedtab.html()){
                jQuery(requesttab).click();
                changeButtonText();
                changeClick();
            }
        });
        jQuery(nextbutton).val(nexttab.html()+"  >>").attr('data-tabid',nexttab.attr("href")).click(function(e){
            e.preventDefault();
            var lasttab = jQuery(spanobject).last("a");
            var requesttab = jQuery('div.idTabs span a[href="'+jQuery(this).attr("data-tabid")+'"]');
            if(lasttab.html() != requesttab.html()){
                jQuery(requesttab).click();
                changeButtonText();
                changeClick();
            }
        });
        jQuery("div.idTabs span a").click(function(){
            changeButtonText();
        });
        
    
    });
                    function dochange(curscr, myname, nextname, src, val) {
                        jQuery("#"+curscr).html("Loading ...");
                        jQuery.post("index.php?option=com_jsjobs&task=listempaddressdata",{name:curscr,myname:myname,nextname:nextname,data:src,val:val},function(data){
                            if(data){
                                jQuery("#"+curscr).html(data);
                                cleanFields(curscr);
                            }
                        });
                    }

                    function cleanFields(curscr) {
                        switch (curscr) {
                            case "address_state":
                                cityhtml = "<input class='inputbox' type='text' name='address_city' size='40' maxlength='100'  />";
                                document.getElementById('address_city').innerHTML = cityhtml; //retuen value
                                break;
                            case "address1_state":
                                document.getElementById('address1_city').innerHTML = "<input class='inputbox' type='text' name='address1_city' size='40' maxlength='100'  />";
                                break;
                            case "address2_state":
                                document.getElementById('address2_city').innerHTML = "<input class='inputbox' type='text' name='address2_city' size='40' maxlength='100'  />";
                                break;
                            case "institute_state":
                                cityhtml = "<input class='inputbox' type='text' name='institute_city' size='40' maxlength='100'  />";
                                document.getElementById('institute_city').innerHTML = cityhtml; //retuen value
                                break;
                            case "institute1_state":
                                cityhtml = "<input class='inputbox' type='text' name='institute1_city' size='40' maxlength='100'  />";
                                document.getElementById('institute1_city').innerHTML = cityhtml; //retuen value
                                break;
                            case "institute2_state":
                                cityhtml = "<input class='inputbox' type='text' name='institute2_city' size='40' maxlength='100'  />";
                                document.getElementById('institute2_city').innerHTML = cityhtml; //retuen value
                                break;
                            case "institute3_state":
                                cityhtml = "<input class='inputbox' type='text' name='institute3_city' size='40' maxlength='100'  />";
                                document.getElementById('institute3_city').innerHTML = cityhtml; //retuen value
                                break;
                            case "employer_state":
                                document.getElementById('employer_city').innerHTML = "<input class='inputbox' type='text' name='employer_city' size='40' maxlength='100'  />";
                                break;
                            case "employer1_state":
                                document.getElementById('employer1_city').innerHTML = "<input class='inputbox' type='text' name='employer1_city' size='40' maxlength='100'  />";
                                break;
                            case "employer2_state":
                                document.getElementById('employer2_city').innerHTML = "<input class='inputbox' type='text' name='employer2_city' size='40' maxlength='100'  />";
                                break;
                            case "employer3_state":
                                document.getElementById('employer3_city').innerHTML = "<input class='inputbox' type='text' name='employer3_city' size='40' maxlength='100'  />";
                                break;
                            case "reference_state":
                                document.getElementById('reference_city').innerHTML = "<input class='inputbox' type='text' name='reference_city' size='40' maxlength='100'  />";
                                break;
                            case "reference1_state":
                                document.getElementById('reference1_city').innerHTML = "<input class='inputbox' type='text' name='reference1_city' size='40' maxlength='100'  />";
                                break;
                            case "reference2_state":
                                document.getElementById('reference2_city').innerHTML = "<input class='inputbox' type='text' name='reference2_city' size='40' maxlength='100'  />";
                                break;
                            case "reference3_state":
                                document.getElementById('reference3_city').innerHTML = "<input class='inputbox' type='text' name='reference3_city' size='40' maxlength='100'  />";
                                break;
                        }
                    }
                    function hideshowtables(table_id) {
                        hideall();
                        document.getElementById(table_id).style.display = "block";
                    }
                    function hideall() {
                        document.getElementById('personal_info_data').style.display = "none";
                        document.getElementById('addresses_data').style.display = "none";
                        document.getElementById('education_data').style.display = "none";
                        document.getElementById('employer_data').style.display = "none";
                        document.getElementById('skills_data').style.display = "none";
                        document.getElementById('resume_editor_data').style.display = "none";
                        document.getElementById('references_data').style.display = "none";
                        document.getElementById('languages_data').style.display = "none";
                    }
            <?php if ($resume_style == 'sliding') { ?>
                        hideshowtables('personal_info_data');
            <?php } ?>

                    function fj_getsubcategories(src, val) {
                        jQuery("#" + src).html("Loading ...");
                        jQuery.post('index.php?option=com_jsjobs&c=subcategory&task=listsubcategories', {val: val}, function(data) {
                            if (data) {
                                jQuery("#" + src).html(data);
                                jQuery("#" + src + " select.jsjobs-cbo").chosen();
                            } else {
                                alert('<?php echo JText::_('JS_ERROR_WHILE_GETTING_SUBCATEGORIES'); ?>');
                            }
                        });
                    }
                </script>



            </form>
        </div>
            <?php } else { // can not add new resume 
                switch($this->canaddnewresume){
        case NO_PACKAGE: ?>
            <div class="js_job_error_messages_wrapper">
                <div class="js_job_messages_image_wrapper">
                    <img class="js_job_messages_image" src="components/com_jsjobs/images/2.png"/>
                </div>
                <div class="js_job_messages_data_wrapper">
                    <span class="js_job_messages_main_text">
                        <?php echo JText::_('JS_PACKAGE_NOT_PURCHASED'); ?>
                    </span>
                    <span class="js_job_messages_block_text">
                        <?php echo JText::_('JS_PACKAGE_IS_REQUIRED_TO_PERFORM_THIS_ACTION_PLEASE_PURCHASE_PACAKGE_FIRST'); ?>
                    </span>
                    <div class="js_job_messages_button_wrapper">
                        <a class="js_job_message_button" href="index.php?option=com_jsjobs&c=jobseekerpackages&view=jobseekerpackages&layout=packages&Itemid=<?php echo $itemid; ?>" ><?php echo JText::_('JS_PACKAGES'); ?></a>
                    </div>
                </div>
            </div>
        <?php break;
        case EXPIRED_PACKAGE: ?>
            <div class="js_job_error_messages_wrapper">
                <div class="js_job_messages_image_wrapper">
                    <img class="js_job_messages_image" src="components/com_jsjobs/images/3.png"/>
                </div>
                <div class="js_job_messages_data_wrapper">
                    <span class="js_job_messages_main_text">
                        <?php echo JText::_('JS_YOUR_CURRENT_PACKAGE_EXPIRED'); ?>
                    </span>
                    <span class="js_job_messages_block_text">
                        <?php echo JText::_('JS_PACKAGE_IS_REQUIRED_TO_PERFORM_THIS_ACTION_AND_YOUR_CURRENT_PACKAGE_IS_EXPIRED_PLEASE_PURCHASE_NEW_PACKAGE'); ?>
                    </span>
                    <div class="js_job_messages_button_wrapper">
                        <a class="js_job_message_button" href="index.php?option=com_jsjobs&c=jobseekerpackages&view=jobseekerpackages&layout=packages&Itemid=<?php echo $itemid; ?>" ><?php echo JText::_('JS_PACKAGES'); ?></a>
                    </div>
                </div>
            </div>
        <?php break;
        case RESUME_LIMIT_EXCEEDS: ?>
            <div class="js_job_error_messages_wrapper">
                <div class="js_job_messages_image_wrapper">
                    <img class="js_job_messages_image" src="components/com_jsjobs/images/3.png"/>
                </div>
                <div class="js_job_messages_data_wrapper">
                    <span class="js_job_messages_main_text">
                        <?php echo JText::_('JS_RESUME_LIMIT_EXCEEDS'); ?>
                    </span>
                    <span class="js_job_messages_block_text">
                        <?php echo JText::_('JS_RESUME_LIMIT_EXCEEDS_YOU_CANNOT_ADD_NEW_RESUME_PURCHASE_NEW_PACAKGE_AND_THEN_ADD_NEW_RESUME'); ?>
                    </span>
                    <div class="js_job_messages_button_wrapper">
                        <a class="js_job_message_button" href="index.php?option=com_jsjobs&c=jobseekerpackages&view=jobseekerpackages&layout=packages&Itemid=<?php echo $itemid; ?>" ><?php echo JText::_('JS_PACKAGES'); ?></a>
                    </div>
                </div>
            </div>
        <?php break;
        case EMPLOYER_NOT_ALLOWED_JOBSEEKER_PRIVATE_AREA: ?>
            <div class="js_job_error_messages_wrapper">
                <div class="js_job_messages_image_wrapper">
                    <img class="js_job_messages_image" src="components/com_jsjobs/images/3.png"/>
                </div>
                <div class="js_job_messages_data_wrapper">
                    <span class="js_job_messages_main_text">
                        <?php echo JText::_('JS_EMPLOYER_NOT_ALLOWED'); ?>
                    </span>
                    <span class="js_job_messages_block_text">
                        <?php echo JText::_('JS_EMPLOYER_NOT_ALLOWED_JOBSEEKER_PRIVATE_AREA'); ?>
                    </span>
                </div>
            </div>
        <?php break;
        case USER_ROLE_NOT_SELECTED: ?>
            <div class="js_job_error_messages_wrapper">
                <div class="js_job_messages_image_wrapper">
                    <img class="js_job_messages_image" src="components/com_jsjobs/images/1.png"/>
                </div>
                <div class="js_job_messages_data_wrapper">
                    <span class="js_job_messages_main_text">
                        <?php echo JText::_('JS_USER_ROLE_NOT_SELECTED'); ?>
                    </span>
                    <span class="js_job_messages_block_text">
                        <?php echo JText::_('JS_USER_ROLE_NOT_SELECTED_PLEASE_SELECT_ROLE_FIRST'); ?>
                    </span>
                    <div class="js_job_messages_button_wrapper">
                        <a class="js_job_message_button" href="index.php?option=com_jsjobs&c=common&view=common&layout=new_injsjobs&Itemid=<?php echo $itemid; ?>" ><?php echo JText::_('JS_SELECT_ROLE'); ?></a>
                    </div>
                </div>
            </div>
        <?php break;
        case VISITOR_NOT_ALLOWED_JOBSEEKER_PRIVATE_AREA: ?>
            <div class="js_job_error_messages_wrapper">
                <div class="js_job_messages_image_wrapper">
                    <img class="js_job_messages_image" src="components/com_jsjobs/images/4.png"/>
                </div>
                <div class="js_job_messages_data_wrapper">
                    <span class="js_job_messages_main_text">
                        <?php echo JText::_('JS_VISITOR_NOT_ALLOWED'); ?>
                    </span>
                    <span class="js_job_messages_block_text">
                        <?php echo JText::_('JS_VISITOR_NOT_ALLOWED_JOBSEEKER_PRIVATE_AREA'); ?>
                    </span>
                    <div class="js_job_messages_button_wrapper">
                        <a class="js_job_message_button" href="index.php?option=com_users&view=login" ><?php echo JText::_('JS_LOGIN'); ?></a>
                        <a class="js_job_message_button" href="index.php?option=com_jsjobs&c=common&view=common&layout=userregister&userrole=1&Itemid=<?php echo $itemid; ?>" ><?php echo JText::_('JS_REGISTER'); ?></a>
                    </div>
                </div>
            </div>
        <?php break;
                    
                }
        }
}//ol
?>		
<!--<div id="jsjobs_footer">-->
    <?php // echo '<table width="100%" style="table-layout:fixed;"> <tr><td height="15"></td></tr> <tr><td style="vertical-align:top;" align="center"> <a class="img" target="_blank" href="http://www.joomsky.com"><img src="http://www.joomsky.com/logo/jsjobscrlogo.png"></a> <br> Copyright &copy; 2008 - '.date('Y').', <span id="themeanchor"> <a class="anchor"target="_blank" href="http://www.joomsky.com">Joom Sky</a></span></td></tr> </table></div>';?>
<!--</div>-->
<style type="text/css">
    div#outermapdiv{ width:100%; min-width:370px; position:relative }
    div#map_container{ z-index:1000; position:relative; background:#000; width:100%; height:100%; }
    div#map{ height: 300px; left: 5px; position: absolute; overflow:true; top: 0px; visibility: hidden; width: 100%; }
</style>
<script type="text/javascript">

    jQuery(document).ready(function() {
        jQuery("select.jsjobs-cbo").chosen();
        jQuery("input.jsjobs-inputbox").button()
                .css({
            'width': '192px',
            'border': '1px solid #A9ABAE',
            'cursor': 'text',
            'margin': '0',
            'padding': '4px'
        });
        var cityname = jQuery("#addresscityforedit").val();
        if (cityname != "") {
            jQuery("#address_city").tokenInput("<?php echo JURI::root() . "index.php?option=com_jsjobs&c=cities&task=getaddressdatabycityname"; ?>", {
                theme: "jsjobs",
                preventDuplicates: true,
                hintText: "<?php echo JText::_('TYPE_IN_A_SEARCH_TERM'); ?>",
                noResultsText: "<?php echo JText::_('NO_RESULTS'); ?>",
                searchingText: "<?php echo JText::_('SEARCHING...'); ?>",
                tokenLimit: 1,
                prePopulate: [
                    {id: "<?php if (isset($this->resume->address_city)) echo $this->resume->address_city; ?>", name: "<?php if (isset($this->resumelists['address_city'][0]->name)) echo $this->resumelists['address_city'][0]->name; ?>"}
                ]
            });
        } else {
            jQuery("#address_city").tokenInput("<?php echo JURI::root() . "index.php?option=com_jsjobs&c=cities&task=getaddressdatabycityname"; ?>", {
                theme: "jsjobs",
                preventDuplicates: true,
                hintText: "<?php echo JText::_('TYPE_IN_A_SEARCH_TERM'); ?>",
                noResultsText: "<?php echo JText::_('NO_RESULTS'); ?>",
                searchingText: "<?php echo JText::_('SEARCHING...'); ?>",
                tokenLimit: 1,
            });
        }
        var address1city = jQuery("#address1cityforedit").val();
        if (address1city != "") {
            jQuery("#address1_city").tokenInput("<?php echo JURI::root() . "index.php?option=com_jsjobs&c=cities&task=getaddressdatabycityname"; ?>", {
                theme: "jsjobs",
                preventDuplicates: true,
                hintText: "<?php echo JText::_('TYPE_IN_A_SEARCH_TERM'); ?>",
                noResultsText: "<?php echo JText::_('NO_RESULTS'); ?>",
                searchingText: "<?php echo JText::_('SEARCHING...'); ?>",
                tokenLimit: 1,
                prePopulate: [
                    {id: "<?php if (isset($this->resume->address1_city)) echo $this->resume->address1_city; ?>", name: "<?php if (isset($this->resumelists['address1_city'][0]->name)) echo $this->resumelists['address1_city'][0]->name; ?>"}
                ]
            });
        } else {
            jQuery("#address1_city").tokenInput("<?php echo JURI::root() . "index.php?option=com_jsjobs&c=cities&task=getaddressdatabycityname"; ?>", {
                theme: "jsjobs",
                preventDuplicates: true,
                hintText: "<?php echo JText::_('TYPE_IN_A_SEARCH_TERM'); ?>",
                noResultsText: "<?php echo JText::_('NO_RESULTS'); ?>",
                searchingText: "<?php echo JText::_('SEARCHING...'); ?>",
                tokenLimit: 1,
            });
        }
        var address2city = jQuery("#address2cityforedit").val();
        if (address2city != "") {
            jQuery("#address2_city").tokenInput("<?php echo JURI::root() . "index.php?option=com_jsjobs&c=cities&task=getaddressdatabycityname"; ?>", {
                theme: "jsjobs",
                preventDuplicates: true,
                hintText: "<?php echo JText::_('TYPE_IN_A_SEARCH_TERM'); ?>",
                noResultsText: "<?php echo JText::_('NO_RESULTS'); ?>",
                searchingText: "<?php echo JText::_('SEARCHING...'); ?>",
                tokenLimit: 1,
                prePopulate: [
                    {id: "<?php if (isset($this->resume->address2_city)) echo $this->resume->address2_city; ?>", name: "<?php if (isset($this->resumelists['address2_city'][0]->name)) echo $this->resumelists['address2_city'][0]->name; ?>"}
                ]
            });
        } else {
            jQuery("#address2_city").tokenInput("<?php echo JURI::root() . "index.php?option=com_jsjobs&c=cities&task=getaddressdatabycityname"; ?>", {
                theme: "jsjobs",
                preventDuplicates: true,
                hintText: "<?php echo JText::_('TYPE_IN_A_SEARCH_TERM'); ?>",
                noResultsText: "<?php echo JText::_('NO_RESULTS'); ?>",
                searchingText: "<?php echo JText::_('SEARCHING...'); ?>",
                tokenLimit: 1,
            });
        }
        var institute_city = jQuery("#institutecityforedit").val();
        if (institute_city != "") {
            jQuery("#institute_city").tokenInput("<?php echo JURI::root() . "index.php?option=com_jsjobs&c=cities&task=getaddressdatabycityname"; ?>", {
                theme: "jsjobs",
                preventDuplicates: true,
                hintText: "<?php echo JText::_('TYPE_IN_A_SEARCH_TERM'); ?>",
                noResultsText: "<?php echo JText::_('NO_RESULTS'); ?>",
                searchingText: "<?php echo JText::_('SEARCHING...'); ?>",
                tokenLimit: 1,
                prePopulate: [
                    {id: "<?php if (isset($this->resume->institute_city)) echo $this->resume->institute_city; ?>", name: "<?php if (isset($this->resumelists['institute_city'][0]->name)) echo $this->resumelists['institute_city'][0]->name; ?>"}
                ]
            });
        } else {
            jQuery("#institute_city").tokenInput("<?php echo JURI::root() . "index.php?option=com_jsjobs&c=cities&task=getaddressdatabycityname"; ?>", {
                theme: "jsjobs",
                preventDuplicates: true,
                hintText: "<?php echo JText::_('TYPE_IN_A_SEARCH_TERM'); ?>",
                noResultsText: "<?php echo JText::_('NO_RESULTS'); ?>",
                searchingText: "<?php echo JText::_('SEARCHING...'); ?>",
                tokenLimit: 1,
            });
        }
        var institute1_city = jQuery("#institute1cityforedit").val();
        if (institute1_city != "") {
            jQuery("#institute1_city").tokenInput("<?php echo JURI::root() . "index.php?option=com_jsjobs&c=cities&task=getaddressdatabycityname"; ?>", {
                theme: "jsjobs",
                preventDuplicates: true,
                hintText: "<?php echo JText::_('TYPE_IN_A_SEARCH_TERM'); ?>",
                noResultsText: "<?php echo JText::_('NO_RESULTS'); ?>",
                searchingText: "<?php echo JText::_('SEARCHING...'); ?>",
                tokenLimit: 1,
                prePopulate: [
                    {id: "<?php if (isset($this->resume->institute1_city)) echo $this->resume->institute1_city; ?>", name: "<?php if (isset($this->resumelists['institute1_city'][0]->name)) echo $this->resumelists['institute1_city'][0]->name; ?>"}
                ]
            });
        } else {
            jQuery("#institute1_city").tokenInput("<?php echo JURI::root() . "index.php?option=com_jsjobs&c=cities&task=getaddressdatabycityname"; ?>", {
                theme: "jsjobs",
                preventDuplicates: true,
                hintText: "<?php echo JText::_('TYPE_IN_A_SEARCH_TERM'); ?>",
                noResultsText: "<?php echo JText::_('NO_RESULTS'); ?>",
                searchingText: "<?php echo JText::_('SEARCHING...'); ?>",
                tokenLimit: 1,
            });
        }
        var institute2_city = jQuery("#institute2cityforedit").val();
        if (institute2_city != "") {
            jQuery("#institute2_city").tokenInput("<?php echo JURI::root() . "index.php?option=com_jsjobs&c=cities&task=getaddressdatabycityname"; ?>", {
                theme: "jsjobs",
                preventDuplicates: true,
                hintText: "<?php echo JText::_('TYPE_IN_A_SEARCH_TERM'); ?>",
                noResultsText: "<?php echo JText::_('NO_RESULTS'); ?>",
                searchingText: "<?php echo JText::_('SEARCHING...'); ?>",
                tokenLimit: 1,
                prePopulate: [
                    {id: "<?php if (isset($this->resume->institute2_city)) echo $this->resume->institute2_city; ?>", name: "<?php if (isset($this->resumelists['institute2_city'][0]->name)) echo $this->resumelists['institute2_city'][0]->name; ?>"}
                ]
            });
        } else {
            jQuery("#institute2_city").tokenInput("<?php echo JURI::root() . "index.php?option=com_jsjobs&c=cities&task=getaddressdatabycityname"; ?>", {
                theme: "jsjobs",
                preventDuplicates: true,
                hintText: "<?php echo JText::_('TYPE_IN_A_SEARCH_TERM'); ?>",
                noResultsText: "<?php echo JText::_('NO_RESULTS'); ?>",
                searchingText: "<?php echo JText::_('SEARCHING...'); ?>",
                tokenLimit: 1,
            });
        }
        var institute3_city = jQuery("#institute3cityforedit").val();
        if (institute2_city != "") {
            jQuery("#institute3_city").tokenInput("<?php echo JURI::root() . "index.php?option=com_jsjobs&c=cities&task=getaddressdatabycityname"; ?>", {
                theme: "jsjobs",
                preventDuplicates: true,
                hintText: "<?php echo JText::_('TYPE_IN_A_SEARCH_TERM'); ?>",
                noResultsText: "<?php echo JText::_('NO_RESULTS'); ?>",
                searchingText: "<?php echo JText::_('SEARCHING...'); ?>",
                tokenLimit: 1,
                prePopulate: [
                    {id: "<?php if (isset($this->resume->institute3_city)) echo $this->resume->institute3_city; ?>", name: "<?php if (isset($this->resumelists['institute3_city'][0]->name)) echo $this->resumelists['institute3_city'][0]->name; ?>"}
                ]
            });
        } else {
            jQuery("#institute3_city").tokenInput("<?php echo JURI::root() . "index.php?option=com_jsjobs&c=cities&task=getaddressdatabycityname"; ?>", {
                theme: "jsjobs",
                preventDuplicates: true,
                hintText: "<?php echo JText::_('TYPE_IN_A_SEARCH_TERM'); ?>",
                noResultsText: "<?php echo JText::_('NO_RESULTS'); ?>",
                searchingText: "<?php echo JText::_('SEARCHING...'); ?>",
                tokenLimit: 1,
            });
        }
        var employer_city = jQuery("#employercityforedit").val();
        if (employer_city != "") {
            jQuery("#employer_city").tokenInput("<?php echo JURI::root() . "index.php?option=com_jsjobs&c=cities&task=getaddressdatabycityname"; ?>", {
                theme: "jsjobs",
                preventDuplicates: true,
                hintText: "<?php echo JText::_('TYPE_IN_A_SEARCH_TERM'); ?>",
                noResultsText: "<?php echo JText::_('NO_RESULTS'); ?>",
                searchingText: "<?php echo JText::_('SEARCHING...'); ?>",
                tokenLimit: 1,
                prePopulate: [
                    {id: "<?php if (isset($this->resume->employer_city)) echo $this->resume->employer_city; ?>", name: "<?php if (isset($this->resumelists['employer_city'][0]->name)) echo $this->resumelists['employer_city'][0]->name; ?>"}
                ]
            });
        } else {
            jQuery("#employer_city").tokenInput("<?php echo JURI::root() . "index.php?option=com_jsjobs&c=cities&task=getaddressdatabycityname"; ?>", {
                theme: "jsjobs",
                preventDuplicates: true,
                hintText: "<?php echo JText::_('TYPE_IN_A_SEARCH_TERM'); ?>",
                noResultsText: "<?php echo JText::_('NO_RESULTS'); ?>",
                searchingText: "<?php echo JText::_('SEARCHING...'); ?>",
                tokenLimit: 1,
            });
        }
        var employer1_city = jQuery("#employer1cityforedit").val();
        if (employer1_city != "") {
            jQuery("#employer1_city").tokenInput("<?php echo JURI::root() . "index.php?option=com_jsjobs&c=cities&task=getaddressdatabycityname"; ?>", {
                theme: "jsjobs",
                preventDuplicates: true,
                hintText: "<?php echo JText::_('TYPE_IN_A_SEARCH_TERM'); ?>",
                noResultsText: "<?php echo JText::_('NO_RESULTS'); ?>",
                searchingText: "<?php echo JText::_('SEARCHING...'); ?>",
                tokenLimit: 1,
                prePopulate: [
                    {id: "<?php if (isset($this->resume->employer1_city)) echo $this->resume->employer1_city; ?>", name: "<?php if (isset($this->resumelists['employer1_city'][0]->name)) echo $this->resumelists['employer1_city'][0]->name; ?>"}
                ]
            });
        } else {
            jQuery("#employer1_city").tokenInput("<?php echo JURI::root() . "index.php?option=com_jsjobs&c=cities&task=getaddressdatabycityname"; ?>", {
                theme: "jsjobs",
                preventDuplicates: true,
                hintText: "<?php echo JText::_('TYPE_IN_A_SEARCH_TERM'); ?>",
                noResultsText: "<?php echo JText::_('NO_RESULTS'); ?>",
                searchingText: "<?php echo JText::_('SEARCHING...'); ?>",
                tokenLimit: 1,
            });
        }
        var employer2_city = jQuery("#employer2cityforedit").val();
        if (employer2_city != "") {
            jQuery("#employer2_city").tokenInput("<?php echo JURI::root() . "index.php?option=com_jsjobs&c=cities&task=getaddressdatabycityname"; ?>", {
                theme: "jsjobs",
                preventDuplicates: true,
                hintText: "<?php echo JText::_('TYPE_IN_A_SEARCH_TERM'); ?>",
                noResultsText: "<?php echo JText::_('NO_RESULTS'); ?>",
                searchingText: "<?php echo JText::_('SEARCHING...'); ?>",
                tokenLimit: 1,
                prePopulate: [
                    {id: "<?php if (isset($this->resume->employer2_city)) echo $this->resume->employer2_city; ?>", name: "<?php if (isset($this->resumelists['employer2_city'][0]->name)) echo $this->resumelists['employer2_city'][0]->name; ?>"}
                ]
            });
        } else {
            jQuery("#employer2_city").tokenInput("<?php echo JURI::root() . "index.php?option=com_jsjobs&c=cities&task=getaddressdatabycityname"; ?>", {
                theme: "jsjobs",
                preventDuplicates: true,
                hintText: "<?php echo JText::_('TYPE_IN_A_SEARCH_TERM'); ?>",
                noResultsText: "<?php echo JText::_('NO_RESULTS'); ?>",
                searchingText: "<?php echo JText::_('SEARCHING...'); ?>",
                tokenLimit: 1,
            });
        }
        var employer3_city = jQuery("#employer3cityforedit").val();
        if (employer3_city != "") {
            jQuery("#employer3_city").tokenInput("<?php echo JURI::root() . "index.php?option=com_jsjobs&c=cities&task=getaddressdatabycityname"; ?>", {
                theme: "jsjobs",
                preventDuplicates: true,
                hintText: "<?php echo JText::_('TYPE_IN_A_SEARCH_TERM'); ?>",
                noResultsText: "<?php echo JText::_('NO_RESULTS'); ?>",
                searchingText: "<?php echo JText::_('SEARCHING...'); ?>",
                tokenLimit: 1,
                prePopulate: [
                    {id: "<?php if (isset($this->resume->employer3_city)) echo $this->resume->employer3_city; ?>", name: "<?php if (isset($this->resumelists['employer3_city'][0]->name)) echo $this->resumelists['employer3_city'][0]->name; ?>"}
                ]
            });
        } else {
            jQuery("#employer3_city").tokenInput("<?php echo JURI::root() . "index.php?option=com_jsjobs&c=cities&task=getaddressdatabycityname"; ?>", {
                theme: "jsjobs",
                preventDuplicates: true,
                hintText: "<?php echo JText::_('TYPE_IN_A_SEARCH_TERM'); ?>",
                noResultsText: "<?php echo JText::_('NO_RESULTS'); ?>",
                searchingText: "<?php echo JText::_('SEARCHING...'); ?>",
                tokenLimit: 1,
            });
        }
        var reference_city = jQuery("#referencecityforedit").val();
        if (reference_city != "") {
            jQuery("#reference_city").tokenInput("<?php echo JURI::root() . "index.php?option=com_jsjobs&c=cities&task=getaddressdatabycityname"; ?>", {
                theme: "jsjobs",
                preventDuplicates: true,
                hintText: "<?php echo JText::_('TYPE_IN_A_SEARCH_TERM'); ?>",
                noResultsText: "<?php echo JText::_('NO_RESULTS'); ?>",
                searchingText: "<?php echo JText::_('SEARCHING...'); ?>",
                tokenLimit: 1,
                prePopulate: [
                    {id: "<?php if (isset($this->resume->reference_city)) echo $this->resume->reference_city; ?>", name: "<?php if (isset($this->resumelists['reference_city'][0]->name)) echo $this->resumelists['reference_city'][0]->name; ?>"}
                ]
            });
        } else {
            jQuery("#reference_city").tokenInput("<?php echo JURI::root() . "index.php?option=com_jsjobs&c=cities&task=getaddressdatabycityname"; ?>", {
                theme: "jsjobs",
                preventDuplicates: true,
                hintText: "<?php echo JText::_('TYPE_IN_A_SEARCH_TERM'); ?>",
                noResultsText: "<?php echo JText::_('NO_RESULTS'); ?>",
                searchingText: "<?php echo JText::_('SEARCHING...'); ?>",
                tokenLimit: 1,
            });
        }
        var reference1_city = jQuery("#reference1cityforedit").val();
        if (reference1_city != "") {
            jQuery("#reference1_city").tokenInput("<?php echo JURI::root() . "index.php?option=com_jsjobs&c=cities&task=getaddressdatabycityname"; ?>", {
                theme: "jsjobs",
                preventDuplicates: true,
                hintText: "<?php echo JText::_('TYPE_IN_A_SEARCH_TERM'); ?>",
                noResultsText: "<?php echo JText::_('NO_RESULTS'); ?>",
                searchingText: "<?php echo JText::_('SEARCHING...'); ?>",
                tokenLimit: 1,
                prePopulate: [
                    {id: "<?php if (isset($this->resume->reference1_city)) echo $this->resume->reference1_city; ?>", name: "<?php if (isset($this->resumelists['reference1_city'][0]->name)) echo $this->resumelists['reference1_city'][0]->name; ?>"}
                ]
            });
        } else {
            jQuery("#reference1_city").tokenInput("<?php echo JURI::root() . "index.php?option=com_jsjobs&c=cities&task=getaddressdatabycityname"; ?>", {
                theme: "jsjobs",
                preventDuplicates: true,
                hintText: "<?php echo JText::_('TYPE_IN_A_SEARCH_TERM'); ?>",
                noResultsText: "<?php echo JText::_('NO_RESULTS'); ?>",
                searchingText: "<?php echo JText::_('SEARCHING...'); ?>",
                tokenLimit: 1,
            });
        }
        var reference2_city = jQuery("#reference2cityforedit").val();
        if (reference2_city != "") {
            jQuery("#reference2_city").tokenInput("<?php echo JURI::root() . "index.php?option=com_jsjobs&c=cities&task=getaddressdatabycityname"; ?>", {
                theme: "jsjobs",
                preventDuplicates: true,
                hintText: "<?php echo JText::_('TYPE_IN_A_SEARCH_TERM'); ?>",
                noResultsText: "<?php echo JText::_('NO_RESULTS'); ?>",
                searchingText: "<?php echo JText::_('SEARCHING...'); ?>",
                tokenLimit: 1,
                prePopulate: [
                    {id: "<?php if (isset($this->resume->reference2_city)) echo $this->resume->reference2_city; ?>", name: "<?php if (isset($this->resumelists['reference2_city'][0]->name)) echo $this->resumelists['reference2_city'][0]->name; ?>"}
                ]
            });
        } else {
            jQuery("#reference2_city").tokenInput("<?php echo JURI::root() . "index.php?option=com_jsjobs&c=cities&task=getaddressdatabycityname"; ?>", {
                theme: "jsjobs",
                preventDuplicates: true,
                hintText: "<?php echo JText::_('TYPE_IN_A_SEARCH_TERM'); ?>",
                noResultsText: "<?php echo JText::_('NO_RESULTS'); ?>",
                searchingText: "<?php echo JText::_('SEARCHING...'); ?>",
                tokenLimit: 1,
            });
        }
        var reference3_city = jQuery("#reference3cityforedit").val();
        if (reference3_city != "") {
            jQuery("#reference3_city").tokenInput("<?php echo JURI::root() . "index.php?option=com_jsjobs&c=cities&task=getaddressdatabycityname"; ?>", {
                theme: "jsjobs",
                preventDuplicates: true,
                hintText: "<?php echo JText::_('TYPE_IN_A_SEARCH_TERM'); ?>",
                noResultsText: "<?php echo JText::_('NO_RESULTS'); ?>",
                searchingText: "<?php echo JText::_('SEARCHING...'); ?>",
                tokenLimit: 1,
                prePopulate: [
                    {id: "<?php if (isset($this->resume->reference3_city)) echo $this->resume->reference3_city; ?>", name: "<?php if (isset($this->resumelists['reference3_city'][0]->name)) echo $this->resumelists['reference3_city'][0]->name; ?>"}
                ]
            });
        } else {
            jQuery("#reference3_city").tokenInput("<?php echo JURI::root() . "index.php?option=com_jsjobs&c=cities&task=getaddressdatabycityname"; ?>", {
                theme: "jsjobs",
                preventDuplicates: true,
                hintText: "<?php echo JText::_('TYPE_IN_A_SEARCH_TERM'); ?>",
                noResultsText: "<?php echo JText::_('NO_RESULTS'); ?>",
                searchingText: "<?php echo JText::_('SEARCHING...'); ?>",
                tokenLimit: 1,
            });
        }




    });

    function loadMap() {
        var default_latitude = document.getElementById('default_latitude').value;
        var default_longitude = document.getElementById('default_longitude').value;

        var latitude = document.getElementById('latitude').value;
        var longitude = document.getElementById('longitude').value;

        if ((latitude != '') && (longitude != '')) {
            default_latitude = latitude;
            default_longitude = longitude;
        }
        var latlng = new google.maps.LatLng(default_latitude, default_longitude);
        zoom = 10;
        var myOptions = {
            zoom: zoom,
            center: latlng,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        var map = new google.maps.Map(document.getElementById("map_container"), myOptions);
        var lastmarker = new google.maps.Marker({
            postiion: latlng,
            map: map,
        });
        var marker = new google.maps.Marker({
            position: latlng,
            map: map,
        });
        marker.setMap(map);
        lastmarker = marker;
        document.getElementById('latitude').value = marker.position.lat();
        document.getElementById('longitude').value = marker.position.lng();

        google.maps.event.addListener(map, "click", function(e) {
            var latLng = new google.maps.LatLng(e.latLng.lat(), e.latLng.lng());
            geocoder = new google.maps.Geocoder();
            geocoder.geocode({'latLng': latLng}, function(results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    if (lastmarker != '')
                        lastmarker.setMap(null);
                    var marker = new google.maps.Marker({
                        position: results[0].geometry.location,
                        map: map,
                    });
                    marker.setMap(map);
                    lastmarker = marker;
                    document.getElementById('latitude').value = marker.position.lat();
                    document.getElementById('longitude').value = marker.position.lng();

                } else {
                    alert("Geocode was not successful for the following reason: " + status);
                }
            });
        });
//document.getElementById('map_container').innerHTML += "<a href='Javascript hidediv();'><?php echo JText::_('JS_CLOSE_MAP'); ?></a>";
    }
    function showdiv() {
        document.getElementById('map').style.visibility = 'visible';
    }
    function hidediv() {
        document.getElementById('map').style.visibility = 'hidden';
    }
</script>
