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
 * File Name:	views/application/tmpl/viewjob.php
 ^ 
 * Description: template view for a job
 ^ 
 * History:		NONE
 ^ 
 */
 
defined('_JEXEC') or die('Restricted access');
?>
<div id="jsjobs_main">
<div id="js_menu_wrapper">
    <?php
    if (sizeof($this->jobseekerlinks) != 0){
        foreach($this->jobseekerlinks as $lnk){ ?>                     
            <a class="js_menu_link <?php if($lnk[2] == 'coverletter') echo 'selected'; ?>" href="<?php echo $lnk[0]; ?>"><?php echo $lnk[1]; ?></a>
        <?php }
    }
    if (sizeof($this->employerlinks) != 0){
        foreach($this->employerlinks as $lnk)	{ ?>
            <a class="js_menu_link <?php if($lnk[2] == 'coverletter') echo 'selected'; ?>" href="<?php echo $lnk[0]; ?>"><?php echo $lnk[1]; ?></a>
        <?php }
    }
    ?>
</div>
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
<?php if( isset($this->department)){ ?>
    <div id="js_main_wrapper">
        <span class="js_controlpanel_section_title"><?php echo JText::_('JS_DEPARTMENT_INFO');?></span>
            <div class="js_job_data_wrapper">
                <span class="js_job_data_title"><?php echo JText::_('JS_NAME'); ?></span>
                <span class="js_job_data_value"><?php echo $this->department->name;?></span>
            </div>
            <div class="js_job_data_wrapper">
                <span class="js_job_data_title"><?php echo JText::_('JS_COMPANY'); ?></span>
                <span class="js_job_data_value">
                    <?php
                        $companyaliasid = ($this->isjobsharing != "")?$this->department->scompanyaliasid:$this->department->companyaliasid;
                        $link = 'index.php?option=com_jsjobs&c=company&view=company&layout=view_company&nav=31&cd='.$companyaliasid.'&Itemid='.$this->Itemid; 
                    ?>
                    <a href="<?php echo $link?>"><?php echo $this->department->companyname; ?></a>
                </span>
            </div>
            <span class="js_controlpanel_section_title"><?php echo JText::_('JS_DESCRIPTION'); ?></span>
            <div class="js_job_full_width_data"><?php echo $this->department->description; ?></div>
    </div>
<?php }else { ?>
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
		 
		 }?>
<?php 
}//ol
?>
<!--<div id="jsjobs_footer">-->
    <?php // echo '<table width="100%" style="table-layout:fixed;"> <tr><td height="15"></td></tr> <tr><td style="vertical-align:top;" align="center"> <a class="img" target="_blank" href="http://www.joomsky.com"><img src="http://www.joomsky.com/logo/jsjobscrlogo.png"></a> <br> Copyright &copy; 2008 - '.date('Y').', <span id="themeanchor"> <a class="anchor"target="_blank" href="http://www.joomsky.com">Joom Sky</a></span></td></tr> </table></div>';?>
<!--</div>-->
