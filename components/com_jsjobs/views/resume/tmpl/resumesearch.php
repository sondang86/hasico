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
 * File Name:	views/employer/tmpl/jobsearch.php
 ^ 
 * Description: template for job search
 ^ 
 * History:		NONE
 ^ 
 */

defined('_JEXEC') or die('Restricted access');
jimport('joomla.html.pane');
$document = JFactory::getDocument();
$document->addScript( JURI::base() . '/includes/js/joomla.javascript.js');
$document->addStyleSheet('components/com_jsjobs/css/combobox/chosen.css');
JHTML :: _('behavior.calendar');
if(JVERSION < 3){
        JHtml::_('behavior.mootools');
        $document->addScript('components/com_jsjobs/js/jquery.js');
}else{
        JHtml::_('behavior.framework');
        JHtml::_('jquery.framework');
}	
$document->addScript('components/com_jsjobs/js/combobox/chosen.jquery.js');
$document->addScript('components/com_jsjobs/js/combobox/prism.js');

$width_big = 40;
$width_med = 25;
$width_sml = 15;
?>
<!--<div id="jsjobs_main">-->
<!--<div id="js_menu_wrapper">-->
    <?php
//    if (sizeof($this->jobseekerlinks) != 0){
//        foreach($this->jobseekerlinks as $lnk){ ?>                     
            <!--<a class="js_menu_link <?php // if($lnk[2] == 'job_categories') echo 'selected'; ?>" href="<?php // echo $lnk[0]; ?>"><?php // echo $lnk[1]; ?></a>-->
        <?php // }
//    }
//    if (sizeof($this->employerlinks) != 0){
//        foreach($this->employerlinks as $lnk)	{ ?>
            <!--<a class="js_menu_link <?php // if($lnk[2] == 'job_categories') echo 'selected'; ?>" href="<?php // echo $lnk[0]; ?>"><?php // echo $lnk[1]; ?></a>-->
        <?php // }
//    }
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
<?php
if ($this->canview == VALIDATE) {
?>
    <div id="js_main_wrapper">
        <span class="js_controlpanel_section_title"><?php echo JText::_('JS_SEARCH_RESUME');?></span>
<form action="<?php echo JRoute::_('index.php?option=com_jsjobs&c=resume&view=resume&layout=resume_searchresults&Itemid='.$this->Itemid); ?>" method="post" name="adminForm" id="adminForm" class="jsautoz_form" >
      <?php if ( $this->searchresumeconfig['search_resume_title'] == '1' ) { ?>
                        <div class="fieldwrapper">
                            <div class="fieldtitle">
                                <?php echo JText::_('JS_APPLICATION_TITLE'); ?>
                            </div>
                            <div class="fieldvalue">
                                <input class="inputbox" type="text" name="title" size="40" maxlength="255"  />
                            </div>
                        </div>				        
       <?php } ?>
      <?php if ( $this->searchresumeconfig['search_resume_name'] == '1' ) { ?>
                        <div class="fieldwrapper">
                            <div class="fieldtitle">
                                <?php echo JText::_('JS_NAME'); ?>
                            </div>
                            <div class="fieldvalue">
                                <input class="inputbox" type="text" name="name" size="40" maxlength="255"  />
                            </div>
                        </div>				        
       <?php } ?>
	      <?php if ( $this->searchresumeconfig['search_resume_nationality'] == '1' ) { ?>
                        <div class="fieldwrapper">
                            <div class="fieldtitle">
                                <?php echo JText::_('JS_NATIONALITY'); ?>
                            </div>
                            <div class="fieldvalue">
                                <?php echo $this->searchoptions['nationality']; ?>
                            </div>
                        </div>				        
       <?php } ?>
      <?php if ( $this->searchresumeconfig['search_resume_gender'] == '1' ) { ?>
                        <div class="fieldwrapper">
                            <div class="fieldtitle">
                                <?php echo JText::_('JS_GENDER');  ?>
                            </div>
                            <div class="fieldvalue">
                                <?php echo $this->searchoptions['gender'];	?>
                            </div>
                        </div>				        
       <?php } ?>
      <?php if ( $this->searchresumeconfig['search_resume_available'] == '1' ) { ?>
                        <div class="fieldwrapper">
                            <div class="fieldtitle">
                                <?php echo JText::_('JS_I_AM_AVAILABLE'); ?>
                            </div>
                            <div class="fieldvalue">
                                <input type='checkbox' name='iamavailable' value='1' <?php if(isset($this->resume)) echo ($this->resume->iamavailable == 1) ? "checked='checked'" : ""; ?> />
                            </div>
                        </div>				        
 	  <?php } ?>
      <?php if ( $this->searchresumeconfig['search_resume_category'] == '1' ) { ?>
                        <div class="fieldwrapper">
                            <div class="fieldtitle">
                                <?php echo JText::_('JS_CATEGORIES'); ?>
                            </div>
                            <div class="fieldvalue">
                                <?php echo $this->searchoptions['jobcategory']; ?>
                            </div>
                        </div>				        
	   <?php } ?>
      <?php if ( $this->searchresumeconfig['search_resume_subcategory'] == '1' ) { ?>
                        <div class="fieldwrapper">
                            <div class="fieldtitle">
                                <?php echo JText::_('JS_SUB_CATEGORIES'); ?>
                            </div>
                            <div class="fieldvalue" id="fj_subcategory">
                                <?php echo $this->searchoptions['jobsubcategory']; ?>
                            </div>
                        </div>				        
	   <?php } ?>
      <?php if ( $this->searchresumeconfig['search_resume_type'] == '1' ) { ?>
                        <div class="fieldwrapper">
                            <div class="fieldtitle">
                                <?php echo JText::_('JS_JOBTYPE'); ?>
                            </div>
                            <div class="fieldvalue">
                                <?php echo $this->searchoptions['jobtype']; ?>
                            </div>
                        </div>				        
	  <?php } ?>
      <?php if ( $this->searchresumeconfig['search_resume_salaryrange'] == '1' ) { ?>
                        <div class="fieldwrapper">
                            <div class="fieldtitle">
                                <?php echo JText::_('JS_SALARYRANGE'); ?>
                            </div>
                            <div class="fieldvalue">
                                <?php echo $this->searchoptions['currency'];  ?><?php echo $this->searchoptions['jobsalaryrange']; ?>
                            </div>
                        </div>				        
       <?php } ?>
      <?php if ( $this->searchresumeconfig['search_resume_heighesteducation'] == '1' ) { ?>
                        <div class="fieldwrapper">
                            <div class="fieldtitle">
                                <?php echo JText::_('JS_HEIGHTESTFINISHEDEDUCATION'); ?>
                            </div>
                            <div class="fieldvalue">
                                <?php echo $this->searchoptions['heighestfinisheducation']; ?>
                            </div>
                        </div>				        
       <?php } ?>
      <?php if ( $this->searchresumeconfig['search_resume_experience'] == '1' ) { ?>
                        <div class="fieldwrapper">
                            <div class="fieldtitle">
                                <?php echo JText::_('JS_EXPERIENCE'); ?>
                            </div>
                            <div class="fieldvalue">
                                <input class="inputbox" type="text" name="experience" size="10" maxlength="15"  />
                            </div>
                        </div>				        
      <?php } ?>
      <?php if ( $this->searchresumeconfig['search_resume_zipcode'] == '1' ) { ?>
                        <div class="fieldwrapper">
                            <div class="fieldtitle">
                                <?php echo JText::_('JS_ZIPCODE'); ?>
                            </div>
                            <div class="fieldvalue">
                                <input class="inputbox" type="text" name="zipcode" size="10" maxlength="15"  />
                            </div>
                        </div>				        
      <?php } ?>
      <?php if ( $this->searchresumeconfig['search_resume_keywords'] == '1' ) { ?>
                        <div class="fieldwrapper">
                            <div class="fieldtitle">
                                <?php echo JText::_('JS_KEYWORDS'); ?>
                            </div>
                            <div class="fieldvalue">
                                <input class="inputbox" type="text" name="keywords" size="40"   />
                            </div>
                        </div>				        
      <?php } ?>
                        <div class="fieldwrapper">
                            <input type="submit" id="button" class="button" name="submit_app" onclick="document.adminForm.submit();" value="<?php echo JText::_('JS_SEARCH_RESUME'); ?>" />
                        </div>				        
			<input type="hidden" name="isresumesearch" value="1" />
			<input type="hidden" name="view" value="resume" />
			<input type="hidden" name="layout" value="resume_searchresults" />
			<input type="hidden" name="uid" value="<?php echo $this->uid; ?>" />
			<input type="hidden" name="option" value="<?php echo $this->option; ?>" />
			<input type="hidden" name="task11" value="view" />
			
		  
<script language="javascript">
function fj_getsubcategories(src, val){
        jQuery("#"+src).html("Loading ...");
        jQuery.post('index.php?option=com_jsjobs&c=subcategory&task=listsubcategoriesForSearch',{val:val},function(data){
            if(data){
                jQuery("#"+src).html(data);
				jQuery("#"+src+" select.jsjobs-cbo").chosen();
            }else{
				jQuery("#"+src).html('<?php echo '<input type="text" name="jobsubcategory" value="">'; ?>');
            }
        });
	
}
</script>


		</form>
    </div>
<?php

}else{
    switch ($this->canview){
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
                        <a class="js_job_message_button" href="index.php?option=com_jsjobs&c=employerpackages&view=employerpackages&layout=packages&Itemid=<?php echo $itemid; ?>" ><?php echo JText::_('JS_PACKAGES'); ?></a>
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
                        <a class="js_job_message_button" href="index.php?option=com_jsjobs&c=employerpackages&view=employerpackages&layout=packages&Itemid=<?php echo $itemid; ?>" ><?php echo JText::_('JS_PACKAGES'); ?></a>
                    </div>
                </div>
            </div>
        <?php break;
        case RESUME_SEARCH_NOT_ALLOWED_IN_PACAKGE: ?>
            <div class="js_job_error_messages_wrapper">
                <div class="js_job_messages_image_wrapper">
                    <img class="js_job_messages_image" src="components/com_jsjobs/images/3.png"/>
                </div>
                <div class="js_job_messages_data_wrapper">
                    <span class="js_job_messages_main_text">
                        <?php echo JText::_('JS_RESUME_SEARCH_NOT_ALLOWED_IN_PACAKGE'); ?>
                    </span>
                    <span class="js_job_messages_block_text">
                        <?php echo JText::_('JS_RESUME_SEARCH_NOT_ALLOWED_IN_PACAKGE_PLEASE_PURCHASE_NEW_PACKAGE'); ?>
                    </span>
                    <div class="js_job_messages_button_wrapper">
                        <a class="js_job_message_button" href="index.php?option=com_jsjobs&c=employerpackages&view=employerpackages&layout=packages&Itemid=<?php echo $itemid; ?>" ><?php echo JText::_('JS_PACKAGES'); ?></a>
                    </div>
                </div>
            </div>
        <?php break;
        case JOBSEEKER_NOT_ALLOWED_EMPLOYER_PRIVATE_AREA: ?>
            <div class="js_job_error_messages_wrapper">
                <div class="js_job_messages_image_wrapper">
                    <img class="js_job_messages_image" src="components/com_jsjobs/images/4.png"/>
                </div>
                <div class="js_job_messages_data_wrapper">
                    <span class="js_job_messages_main_text">
                        <?php echo JText::_('JS_JOBSEEKER_NOT_ALLOWED'); ?>
                    </span>
                    <span class="js_job_messages_block_text">
                        <?php echo JText::_('JS_JOBSEEKER_NOT_ALLOWED_EMPLOYER_PRIVATE_AREA'); ?>
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
        case VISITOR_NOT_ALLOWED_EMPLOYER_PRIVATE_AREA: ?>
            <div class="js_job_error_messages_wrapper">
                <div class="js_job_messages_image_wrapper">
                    <img class="js_job_messages_image" src="components/com_jsjobs/images/4.png"/>
                </div>
                <div class="js_job_messages_data_wrapper">
                    <span class="js_job_messages_main_text">
                        <?php echo JText::_('JS_VISITOR_NOT_ALLOWED'); ?>
                    </span>
                    <span class="js_job_messages_block_text">
                        <?php echo JText::_('JS_VISITOR_NOT_ALLOWED_EMPLOYER_PRIVATE_AREA'); ?>
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
<script type="text/javascript" language="javascript">
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
						   
	});
	
</script>
