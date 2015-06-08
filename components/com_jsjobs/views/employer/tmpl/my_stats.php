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
 * File Name:	views/employer/tmpl/mycompanies.php
 ^ 
 * Description: template view for my companies
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
if ($this->mystats_allowed == VALIDATE) { // employer
    $isodd = 0;
?>
    <div id="js_main_wrapper">
        <span class="js_controlpanel_section_title"><?php echo JText::_('JS_STATS');?></span>
        <span class="js_job_title"><?php echo JText::_('JS_MY_STATS'); ?></span>
        <div class="js_listing_wrapper">
            <span class="stats_data_title"><?php echo JText::_('JS_COMPANIES'); ?></span>
            <span class="stats_data_value"><?php echo $this->totalcompanies; ?></span>
            <span class="stats_data_title"><?php echo JText::_('JS_JOBS'); ?></span>
            <span class="stats_data_value"><?php echo $this->totaljobs; ?></span>
        </div>            
        <span class="js_job_title"><?php echo JText::_('JS_JOBS'); ?></span>
        <div class="js_listing_wrapper">
            <span class="stats_data_title"><?php echo JText::_('JS_JOBS_ALLOW'); ?></span>
            <span class="stats_data_value">
                    <?php 
                            if($this->ispackagerequired != 1){ 
                                            echo JText::_('JS_UNLIMITED');
                            }elseif($this->jobsallow == -1){ 
                                    echo JText::_('JS_UNLIMITED');
                            }else echo $this->jobsallow; ?>
            </span>
            <span class="stats_data_title"><?php echo JText::_('JS_PUBLISHED_JOBS'); ?></span>
            <span class="stats_data_value">
                    <?php  echo $this->publishedjob; ?>
            </span>
            <span class="stats_data_title"><?php echo JText::_('JS_EXPIRED_JOBS'); ?></span>
            <span class="stats_data_value">
                    <?php  echo $this->expiredjob; ?>
            </span>
            <span class="stats_data_title"><?php echo JText::_('JS_AVAILABLE_JOBS'); ?></span>
            <span class="stats_data_value">
                    <?php 
                            if($this->ispackagerequired != 1){ 
                                    echo JText::_('JS_UNLIMITED');
                            }elseif($this->jobsallow == -1){ 
                                    echo JText::_('JS_UNLIMITED');
                            }else{ 
                                    $available_jobs=$this->jobsallow-$this->totaljobs; 
                                    echo $available_jobs;
                            } 
                    ?>
            </span>
        </div>            
        <span class="js_job_title"><?php echo JText::_('JS_COMPANIES'); ?></span>
        <div class="js_listing_wrapper">
            <span class="stats_data_title"><?php echo JText::_('JS_COMPANIES_ALLOW'); ?></span>
            <span class="stats_data_value">
                    <?php 
                            if($this->ispackagerequired != 1){ 
                                    echo JText::_('JS_UNLIMITED');
                            }elseif($this->companiesallow == -1){
                                    echo JText::_('JS_UNLIMITED');
                            }else echo $this->companiesallow; ?>
            </span>
            <span class="stats_data_title"><?php echo JText::_('JS_PUBLISHED_COMPANIES'); ?></span>
            <span class="stats_data_value"><?php echo $this->totalcompanies; ?></span>				
            <span class="stats_data_title"><?php echo JText::_('JS_EXPIRED_COMPANIES'); ?></span>
            <span class="stats_data_value">
                    <?php  echo '0'; ?>
            </span>
            <span class="stats_data_title"><?php echo JText::_('JS_AVAILABLE_COMPANIES'); ?></span>
            <span class="stats_data_value">
                    <?php 
                            if($this->ispackagerequired != 1){ 
                                    echo JText::_('JS_UNLIMITED');
                            }elseif($this->companiesallow == -1){ 
                                    echo JText::_('JS_UNLIMITED');
                            }else{ 
                                    $available_companies=$this->companiesallow-$this->totalcompanies; 
                                    echo $available_companies;
                            } 
                    ?>
            </span>				
        </div>
<?php
	if($this->ispackagerequired!=1){
		$message = "<strong>".JText::_('JS_PACKAGE_NOT_REQUIRED')."</strong>";?>
			<div id="stats_package_message">
				<?php echo $message; ?>
			</div>
		
	<?php }
} else{ // not allowed job posting
    switch ($this->mystats_allowed){
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
