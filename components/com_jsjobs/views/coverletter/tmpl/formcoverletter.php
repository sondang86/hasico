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
 * File Name:	views/jobseeker/tmpl/formcoverletter.php
 ^ 
 * Description: template for form cover letter
 ^ 
 * History:		NONE
 ^ 
 */

defined('_JEXEC') or die('Restricted access');
$big_field_width = 40;
$med_field_width = 25;
$sml_field_width = 15;
JHTML::_('behavior.formvalidation'); 
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
<?php if ($this->config['offline'] == '1'){ ?>
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
<?php }else{ ?>
<script language="javascript">
function myValidate(f) {
        if (document.formvalidator.isValid(f)) {
                f.check.value='<?php if(JVERSION < 3) echo JUtility::getToken(); else echo  JSession::getFormToken(); ?>';//send token
        }else {
                alert('<?php echo JText::_( 'JS_SOME_VALUES_ARE_NOT_ACCEPTABLE_PLEASE_RETRY');?>');
				return false;
        }
		return true;
}

</script>
<?php
if ($this->canaddnewcoverletter == VALIDATE) { // add new coverletter, in edit case always 1
?>
    <div id="js_main_wrapper">
        <span class="js_controlpanel_section_title"><?php echo JText::_('JS_COVER_LETTER_FORM');?></span>
		<form action="index.php" method="post" name="adminForm" id="adminForm" class="form-validate jsautoz_form" onSubmit="return myValidate(this);">
                        <div class="fieldwrapper">
                            <div class="fieldtitle">
                                <label id="titlemsg" for="title"><?php echo JText::_('JS_TITLE'); ?></label>&nbsp;<font color="red">*</font>:
                            </div>
                            <div class="fieldvalue">
                                <input class="inputbox required" type="text" name="title" id="title" size="<?php echo $big_field_width; ?>" maxlength="250" value = "<?php if (isset($this->coverletter)) echo $this->coverletter->title;?>" />
                            </div>
                        </div>				        
                        <div class="fieldwrapper">
                            <div class="fieldtitle">
                                <label id="descriptionmsg" for="description"><?php echo JText::_('JS_DESCRIPTION'); ?></label>&nbsp;<font color="red">*</font>:
                            </div>
                            <div class="fieldvalue">
                                <textarea class="inputbox required" name="description" id="description" cols="60" rows="9"><?php if(isset($this->coverletter)) echo $this->coverletter->description; ?></textarea>
                            </div>
                        </div>				        
                        <div class="fieldwrapper">
                            <input type="submit" id="button" class="button" value="<?php echo JText::_('JS_SAVE_COVER_LETTER'); ?>"/>
                        </div>				        
			<?php 
				if(isset($this->coverletter)) {
					if (($this->coverletter->created=='0000-00-00 00:00:00') || ($this->coverletter->created==''))
						$curdate = date('Y-m-d H:i:s');
					else  
						$curdate = $this->coverletter->created;
				}else
					$curdate = date('Y-m-d H:i:s');
				
			?>
			<input type="hidden" name="created" value="<?php echo $curdate; ?>" />
			<input type="hidden" name="id" value="<?php if (isset($this->coverletter)) echo $this->coverletter->id; ?>" />
			<input type="hidden" name="layout" value="empview" />
			<input type="hidden" name="uid" value="<?php echo $this->uid; ?>" />
			<input type="hidden" name="option" value="<?php echo $this->option; ?>" />
			<input type="hidden" name="task" value="savecoverletter" />
			<input type="hidden" name="c" value="coverletter" />
			<input type="hidden" name="check" value="" />
			<input type="hidden" name="Itemid" value="<?php echo $this->Itemid; ?>" />
			<?php if(isset($this->packagedetail[0])) echo '<input type="hidden" name="packageid" value="'.$this->packagedetail[0].'" />';?>
			<?php if(isset($this->packagedetail[1])) echo '<input type="hidden" name="paymenthistoryid" value="'.$this->packagedetail[1].'" />'; ?>

		
		
		</form>
    </div>
		
<?php
} else{ // can not add new coverletter 
    switch ($this->canaddnewcoverletter){
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
        case COVER_LETTER_LIMIT_EXCEEDS: ?>
            <div class="js_job_error_messages_wrapper">
                <div class="js_job_messages_image_wrapper">
                    <img class="js_job_messages_image" src="components/com_jsjobs/images/3.png"/>
                </div>
                <div class="js_job_messages_data_wrapper">
                    <span class="js_job_messages_main_text">
                        <?php echo JText::_('JS_COVERLETTER_LIMIT_EXCEEDS'); ?>
                    </span>
                    <span class="js_job_messages_block_text">
                        <?php echo JText::_('JS_COVERLETTER_LIMIT_EXCEEDS_YOU_CANNOT_ADD_NEW_COVERLETTER_PURCHASE_NEW_PACAKGE_AND_THEN_ADD_NEW_COVERLETTER'); ?>
                    </span>
                    <div class="js_job_messages_button_wrapper">
                        <a class="js_job_message_button" href="index.php?option=com_jsjobs&c=jobseekerpackages&view=jobseekerpackages&layout=packages&Itemid=<?php echo $itemid; ?>" ><?php echo JText::_('JS_PACKAGES'); ?></a>
                    </div>
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
