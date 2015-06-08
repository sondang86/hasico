<?php
/**
 * @Copyright Copyright (C) 2009-2011
 * @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
 + Created by:          Ahmad Bilal
 * Company:		Buruj Solutions
 + Contact:		www.burujsolutions.com , ahmad@burujsolutions.com
 * Created on:	Oct 10, 2010
 ^
 + Project: 		JS Jobs
 * File Name:	views/employer/tmpl/my_stats.php
 ^ 
 * Description: template view for my stats
 ^ 
 * History:		NONE
 ^ 
 */
 
defined('_JEXEC') or die('Restricted access');
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
<?php
    if ($this->config['offline'] == '1'){ ?>
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
if ($this->mystats_allowed == VALIDATE) {
    $isodd =1;
    $print = 1;
    if(isset($this->package) && $this->package == false) $print= 0;
?>
    <div id="js_main_wrapper">
        <span class="js_controlpanel_section_title"><?php echo JText::_('JS_STATS');?></span>
        <span class="js_job_title"><?php echo JText::_('JS_MY_STATS'); ?></span>
        <div class="js_listing_wrapper">
            <span class="stats_data_title"><?php echo JText::_('JS_RESUMES'); ?></span>
            <span class="stats_data_value"><?php echo $this->totalresume; ?></span>
            <span class="stats_data_title last-child"><?php echo JText::_('JS_COVER_LETTERS'); ?></span>
            <span class="stats_data_value last-child"><?php echo $this->totalcoverletters; ?></span>
        </div>
        <span class="js_job_title"><?php echo JText::_('JS_PACKAGE_HISTORY'); ?></span>
        <div class="js_listing_wrapper">
            <span class="stats_data_title"><?php echo JText::_('JS_RESUMES_ALLOW'); ?></span>
            <span class="stats_data_value">
                <?php 
                    if($this->ispackagerequired != 1){ 
                            echo JText::_('JS_UNLIMITED');
                    }elseif($this->resumeallow== -1){ 
                            echo JText::_('JS_UNLIMITED');
                    }else echo $this->resumeallow; 
                ?>
            </span>
            <span class="stats_data_title"><?php echo JText::_('JS_COVER_LETTERS_ALLOW'); ?></span>
            <span class="stats_data_value">
                <?php 
                    if($this->ispackagerequired != 1){ 
                            echo JText::_('JS_UNLIMITED');
                    }elseif($this->coverlettersallow== -1){
                            echo JText::_('JS_UNLIMITED');
                    }else echo $this->coverlettersallow; ?>
            </span>
            <span class="stats_data_title"><?php echo JText::_('JS_AVAILABLE_RESUMES'); ?></span>
            <span class="stats_data_value">
                <?php 
                    if($this->ispackagerequired != 1){ 
                        echo JText::_('JS_UNLIMITED');
                    }elseif($this->resumeallow == -1){ 
                        echo JText::_('JS_UNLIMITED');
                    }else{ 
                        $available_resume=$this->resumeallow-$this->totalresume; 
                        echo $available_resume;
                    } 
                ?>
            </span>
            <span class="stats_data_title last-child"><?php echo JText::_('JS_AVAILABLE_COVER_LETTERS'); ?></span>
            <span class="stats_data_value last-child">
                <?php 
                    if($this->ispackagerequired != 1){ 
                        echo JText::_('JS_UNLIMITED');
                    }elseif($this->coverlettersallow == -1){ 
                        echo JText::_('JS_UNLIMITED');
                    }else{ 
                        $available_coverletters=$this->coverlettersallow-$this->totalcoverletters; 
                        echo $available_coverletters;
                    } 
                ?>
            </span>
        </div>        
    </div>
<?php
	if($this->ispackagerequired!=1){
		$message = "<strong>".JText::_('JS_PACKAGE_NOT_REQUIRED')."</strong>";?>
			<div id="stats_package_message">
				<?php echo $message; ?>
			</div>
		
	<?php }else{
		if($print == 0){
			$message = '';
			$j_p_link=JRoute::_('index.php?option=com_jsjobs&c=jobseekerpackages&view=jobseekerpackages&layout=packages&Itemid='.$this->Itemid);
		if(empty($this->packagedetail[0]->id)){
				$message = "<strong><font color='orangered'>".JText::_('JS_JOB_NO_PACKAGE')." <a href=".$j_p_link.">".JText::_('JS_JOBSEEKER_PACKAGES')."</a></font></strong>";
			}else{
				$days = $this->packagedetail[0]->packageexpiredays - $this->packagedetail[0]->packageexpireindays;
				if($days == 1) $days = $days.' '.JText::_('JS_DAY'); else $days = $days.' '.JText::_('JS_DAYS');
				$message = "<strong><font color='red'>".JText::_('JS_YOUR_PACKAGE').' &quot;'.$this->packagedetail[0]->packagetitle.'&quot; '.JText::_('JS_HAS_EXPIRED').' '.$days.' ' .JText::_('JS_AGO')." <a href=".$j_p_link.">".JText::_('JS_JOBSEEKER_PACKAGES')."</a></font></strong>";
			} ?>
			<?php if($message != ''){ ?>
                            <div class="js_job_error_messages_wrapper">
                                <div class="js_job_messages_image_wrapper">
                                    <img class="js_job_messages_image" src="components/com_jsjobs/images/2.png"/>
                                </div>
                                <div class="js_job_messages_data_wrapper">
                                    <span class="js_job_messages_main_text">
                                        <?php echo $message; ?>
                                    </span>
                                    <span class="js_job_messages_block_text">
                                        <?php echo $message; ?>
                                    </span>
                                </div>
                            </div>
			<?php } 
		}
	}
} else{
    switch ($this->mystats_allowed){
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
