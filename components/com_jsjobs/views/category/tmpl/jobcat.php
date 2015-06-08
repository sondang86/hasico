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
 * File Name:	views/jobseeker/tmpl/jobcat.php
 ^ 
 * Description: template view for job categories 
 ^ 
 * History:		NONE
 ^ 
 */
 
defined('_JEXEC') or die('Restricted access');
if (isset($this->userrole->rolefor)){
	if ($this->userrole->rolefor != ''){
		if ($this->userrole->rolefor == 2) // job seeker
			$allowed = true;
		elseif($this->userrole->rolefor == 1){
                    if($this->config['employerview_js_controlpanel'] == 1)
			$allowed = true;
                    else
                        $allowed = false;
                }
	}else{
		$allowed = true;
	}
}else $allowed = true; // user not logined
?>
<!--<div id="jsjobs_main">-->
        <!--<div id="js_menu_wrapper">-->
            <?php
//            if (sizeof($this->jobseekerlinks) != 0){
//                foreach($this->jobseekerlinks as $lnk){ ?>                     
                    <!--<a class="js_menu_link <?php // if($lnk[2] == 'job_categories') echo 'selected'; ?>" href="<?php // echo $lnk[0]; ?>"><?php // echo $lnk[1]; ?></a>-->
                <?php // }
//            }
//            if (sizeof($this->employerlinks) != 0){
//                foreach($this->employerlinks as $lnk)	{ ?>
                    <!--<a class="js_menu_link <?php // if($lnk[2] == 'job_categories') echo 'selected'; ?>" href="<?php // echo $lnk[0]; ?>"><?php // echo $lnk[1]; ?></a>-->
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
<?php
if ($allowed == true) { 
?>
    <div id="js_main_wrapper">
        
        <span class="js_controlpanel_section_title"><?php echo JText::_('JS_JOB_CATEGORY');?></span>
        
        <?php 
        $noofcols =$this->config['categories_colsperrow'];
        $colwidth = round(100 / $noofcols);
        if ( isset($this->application) ){
                foreach($this->application as $category)	{
                    $lnks = 'index.php?option=com_jsjobs&c=job&view=job&layout=list_jobs&cat='. $category->categoryaliasid .'&Itemid='.$this->Itemid; ?>
                    <span class="js_column_layout" style="width:<?php echo $colwidth-2; ?>%;" ><a href="<?php echo $lnks; ?>" ><?php echo JText::_($category->cat_title); ?> (<?php echo $category->catinjobs; ?>)</a></span>
                <?php
                }

        }
         ?>
    </div>
<?php
} else{ // not allowed job posting ?>
            <div class="js_job_error_messages_wrapper">
                <div class="js_job_messages_image_wrapper">
                    <img class="js_job_messages_image" src="components/com_jsjobs/images/2.png"/>
                </div>
                <div class="js_job_messages_data_wrapper">
                    <span class="js_job_messages_main_text">
                        <?php echo JText::_('EA_YOU_ARE_NOT_ALLOWED_TO_VIEW'); ?>
                    </span>
                    <span class="js_job_messages_block_text">
                        <?php echo JText::_('EA_YOU_ARE_NOT_ALLOWED_TO_VIEW'); ?>
                    </span>
                </div>
            </div>
<?php

}
}//ol
?>
<!--<div id="jsjobs_footer">-->
    <?php // echo '<table width="100%" style="table-layout:fixed;"> <tr><td height="15"></td></tr> <tr><td style="vertical-align:top;" align="center"> <a class="img" target="_blank" href="http://www.joomsky.com"><img src="http://www.joomsky.com/logo/jsjobscrlogo.png"></a> <br> Copyright &copy; 2008 - '.date('Y').', <span id="themeanchor"> <a class="anchor"target="_blank" href="http://www.joomsky.com">Joom Sky</a></span></td></tr> </table></div>';?>
<!--</div>-->
