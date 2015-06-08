<?php
/**
 * @Copyright Copyright (C) 2009-2011
 * @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
 + Created by:          Ahmad Bilal
 * Company:		Buruj Solutions
 + Contact:		www.burujsolutions.com , ahmad@burujsolutions.com
 * Created on:	May 17, 2010
 ^
 + Project: 		JS Jobs
 * File Name:	views/employer/tmpl/mydepartments.php
 ^
 * Description: template view for my departments
 ^
 * History:		NONE
 ^
 */

 
defined('_JEXEC') or die('Restricted access');
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
if ($this->mydepartment_allowed == VALIDATE) {
if ($this->departments){

?>
    <div id="js_main_wrapper">
        <span class="js_controlpanel_section_title"><?php echo JText::_('JS_MY_DEPARTMENTS');?></span>        
        <form action="index.php" method="post" name="adminForm">
        <?php 
            foreach($this->departments as $department){ ?>
            <div class="js_listing_wrapper">
                <span class="js_coverletter_title">
                    <?php echo $department->name; ?>
                </span>
                <span class="js_coverletter_sub_data">
                    <span class="js_listing_title_child"><span class="js_listing_title_child_title"><?php echo JText::_('JS_COMPANY'); ?>&nbsp;:</span><?php echo $department->companyname; ?></span>
                    <span class="js_listing_title_child"><span class="js_listing_title_child_title"><?php echo JText::_('JS_STATUS'); ?>&nbsp;:</span>
                        <?php if ($department->status == 1) echo '<font color="green">'.JText::_('JS_APPROVED').'</font>'; elseif ($department->status == 0) {echo '<span class="jobstatusmsg"> '. JText::_('JS_PENDDING'). '</span>';} elseif ($department->status == -1) echo '<font color="red"> '. JText::_('JS_REJECTED'). '</font>'; ?>
                    </span>
                </span>
                <?php if ($department->status == 1) { ?>
                    <div class="js_coverletter_button_area sub_data" >
                        <span class="js_coverletter_created"><span class="js_coverletter_created_title"><?php echo JText::_('JS_CREATED'); ?>&nbsp;:</span><?php echo date($this->config['date_format'],strtotime($department->created)); ?></span>
                        <a class="js_listing_icon" href="index.php?option=com_jsjobs&c=department&view=department&layout=formdepartment&pd=<?php echo $department->aliasid; ?>&Itemid=<?php echo $this->Itemid; ?>" title="<?php echo  JText::_('JS_EDIT');  ?>">
                            <img width="15" height="15" src="components/com_jsjobs/images/edit.png" />
                        </a>
                        <a class="js_listing_icon" href="index.php?option=com_jsjobs&c=department&view=department&layout=view_department&pd=<?php echo $department->aliasid; ?>&Itemid=<?php echo $this->Itemid; ?>" title="<?php echo  JText::_('JS_VIEW');  ?>" >
                            <img width="15" height="15" src="components/com_jsjobs/images/view.png" />
                        </a>
                        <a class="js_listing_icon" href="index.php?option=com_jsjobs&task=department.deletedepartment&pd=<?php echo $department->aliasid; ?>&Itemid=<?php echo $this->Itemid; ?>" title="<?php echo  JText::_('JS_DELETE');  ?>">
                            <img width="15" height="15" src="components/com_jsjobs/images/delete.png" />
                        </a>
                    </div>
                <?php } ?>
            </div>
        <?php 
            }
        ?>		
            <input type="hidden" name="option" value="<?php echo $this->option; ?>" />
            <input type="hidden" name="task" value="deletedepartment" />
            <input type="hidden" name="department" value="deletedepartment" />
            <input type="hidden" id="id" name="id" value="" />
	</form>
    </div>


<form action="<?php echo JRoute::_('index.php?option=com_jsjobs&c=department&view=department&layout=mydepartments&Itemid='.$this->Itemid); ?>" method="post">
	<div id="jl_pagination">
		<div id="jl_pagination_pageslink">
			<?php echo $this->pagination->getPagesLinks(); ?>
		</div>
		<div id="jl_pagination_box">
			<?php	
				echo JText::_('JS_DISPLAY_#');
				echo $this->pagination->getLimitBox();
			?>
		</div>
		<div id="jl_pagination_counter">
			<?php echo $this->pagination->getResultsCounter(); ?>
		</div>
	</div>
</form>	
<?php

}else{ // no result found in this category ?>
            <div class="js_job_error_messages_wrapper">
                <div class="js_job_messages_image_wrapper">
                    <img class="js_job_messages_image" src="components/com_jsjobs/images/2.png"/>
                </div>
                <div class="js_job_messages_data_wrapper">
                    <span class="js_job_messages_main_text">
                        <?php echo JText::_('JS_RESULT_NOT_FOUND'); ?>
                    </span>
                    <span class="js_job_messages_block_text">
                        <?php echo JText::_('JS_RESULT_NOT_FOUND'); ?>
                    </span>
                </div>
            </div>
<?php
	
}

} else{ // not allowed 
    switch($this->mydepartment_allowed){
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
