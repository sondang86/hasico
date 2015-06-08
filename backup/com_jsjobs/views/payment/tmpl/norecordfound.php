<?php
/**
 * @Copyright Copyright (C) 2012 ... Ahmad Bilal
 * @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * Company:		Buruj Solutions
 + Contact:		www.burujsolutions.com , ahmad@burujsolutions.com
 * Created on:	April 05, 2012
 ^
 + Project: 		JS Jobs
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
    <div id="js_main_wrapper">
        <span class="js_controlpanel_section_title"><?php echo JText::_('JS_NO_RECORD_FOUND');?></span>
        <div id="jsjobs_norecordfoundwrapper">
            <div id="jsjobs_norecordfoundupperdiv">
                <span id="jsjobs_norecordfoundtextimage">
                    <?php echo JText::_('JS_ERROR'); ?>
                </span>
            </div>
            <div id="jsjobs_norecordfoundlowerdiv">
                <?php echo JText::_('JS_NO_RECORD_FOUND_FOR_YOUR_REQUEST'); ?>
            </div>
        </div>
    </div>
<?php		

}//ol
?>	
<!--<div id="jsjobs_footer">-->
    <?php // echo '<table width="100%" style="table-layout:fixed;"> <tr><td height="15"></td></tr> <tr><td style="vertical-align:top;" align="center"> <a class="img" target="_blank" href="http://www.joomsky.com"><img src="http://www.joomsky.com/logo/jsjobscrlogo.png"></a> <br> Copyright &copy; 2008 - '.date('Y').', <span id="themeanchor"> <a class="anchor"target="_blank" href="http://www.joomsky.com">Joom Sky</a></span></td></tr> </table></div>';?>
<!--</div>-->
