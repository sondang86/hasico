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
 * File Name:	views/employer/tmpl/package_details.php
 ^ 
 * Description: template view package detail
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
<?php
if (isset($this->userrole->rolefor)){
        if ($this->userrole->rolefor == 1) // employer
            $allowed = true;
        else
            $allowed = false;
}else { if ($this->config['visitorview_emp_viewpackage'] == 1) $allowed = true; else $allowed = false; } // user not logined
if ($allowed == true) {
		if ( isset($this->package) ){ ?>
    <div id="js_main_wrapper">
        <span class="js_controlpanel_section_title"><?php echo JText::_('JS_PACKAGE_DETAILS');?></span>
        <span class="js_job_title">
            <?php echo '[ '.$this->package->title;
                       $curdate = date('Y-m-d H:i:s');
                            if (($this->package->discountstartdate <= $curdate) && ($this->package->discountenddate >= $curdate)){
                                    if($this->package->discountmessage) echo $this->package->discountmessage;
                            }
            echo '] '.JText::_('JS_PACKAGE_DETAILS');  ?>
        </span>
        <div class="js_listing_wrapper">
                            <span class="stats_data_title"><?php echo JText::_('JS_COMPANIES_ALLOWED'); ?></span>
                            <span class="stats_data_value"><?php if($this->package->companiesallow == -1) echo JText::_('JS_UNLIMITED'); else echo $this->package->companiesallow; ?></span>
                            <span class="stats_data_title"><?php echo JText::_('JS_JOBS_ALLOWED'); ?></span>
                            <span class="stats_data_value"><?php if($this->package->jobsallow == -1) echo JText::_('JS_UNLIMITED'); else echo $this->package->jobsallow; ?></span>
                            <span class="stats_data_title"><?php echo JText::_('JS_VIEW_RESUME_IN_DETAILS'); ?></span>
                            <span class="stats_data_value"><?php if($this->package->viewresumeindetails == -1) echo JText::_('JS_UNLIMITED'); else echo $this->package->viewresumeindetails; ?></span>
                            <span class="stats_data_title"><?php echo JText::_('JS_RESUME_SEARCH'); ?></span>
                            <span class="stats_data_value"><?php if($this->package->resumesearch == 1) echo JText::_('JS_YES'); else echo JText::_('JS_NO'); ?></span>
                            <span class="stats_data_title"><?php echo JText::_('JS_SAVE_RESUME_SEARCH'); ?></span>
                            <span class="stats_data_value"><?php if($this->package->saveresumesearch == 1) echo JText::_('JS_YES'); else echo JText::_('JS_NO'); ?></span>
                            <span class="stats_data_title"><?php echo JText::_('JS_PACKAGE_EXPIRE_IN_DAYS'); ?></span>
                            <span class="stats_data_value"><?php echo $this->package->packageexpireindays; ?></span>
                            <span class="stats_data_title"><?php echo JText::_('JS_PRICE'); ?>:</span>
                            <span class="stats_data_value">
                                    <?php
                                            if ($this->package->price != 0){
                                               $curdate = date('Y-m-d H:i:s');
                                                    if (($this->package->discountstartdate <= $curdate) && ($this->package->discountenddate >= $curdate)){
                                                             if($this->package->discounttype == 2){
                                                                     $discountamount = ($this->package->price * $this->package->discount)/100;
                                                                      $discountamount = $this->package->price - $discountamount;
                                                                     echo $this->package->symbol.$discountamount.' [ '. $this->package->discount .'% '.JText::_('JS_DISCOUNT').' ]';
                                                             }else{
                                                                     $discountamount = $this->package->price - $this->package->discount;
                                                                     echo $this->package->symbol.$discountamount.' [ '. JText::_('JS_DISCOUNT').' : '.$this->package->symbol.$this->package->discount .' ]';
                                                             }
                                                    }else echo $this->package->symbol.$this->package->price;
                                            }else{ echo JText::_('JS_FREE'); } ?>
                            </span>
                            <span class="stats_data_title fullwidth">
                                <?php echo JText::_('JS_DESCRIPTION'); ?>
                            </span>
                            <span class="stats_data_value description">
                                <?php echo $this->package->description; ?>
                            </span>
                            <div class="js_job_apply_button">
                                <?php $link = 'index.php?option=com_jsjobs&c=employerpackages&view=employerpackages&layout=package_buynow&nav=24&gd='.$this->package->id.'&Itemid='.$this->Itemid; ?>
                                <a class="js_job_button" href="<?php echo $link?>" class="pkgLink"><?php echo JText::_('JS_BUY_NOW'); ?></a>
                            </div>
        </div>
    </div>
		<?php
		}
		 ?>	
	<?php
} else{ // not allowed job posting ?>
            <div class="js_job_error_messages_wrapper">
                <div class="js_job_messages_image_wrapper">
                    <img class="js_job_messages_image" src="components/com_jsjobs/images/2.png"/>
                </div>
                <div class="js_job_messages_data_wrapper">
                    <span class="js_job_messages_main_text">
                        <?php echo JText::_('JS_YOU_ARE_NOT_ALLOWED_TO_VIEW'); ?>
                    </span>
                    <span class="js_job_messages_block_text">
                        <?php echo JText::_('JS_YOU_ARE_NOT_ALLOWED_TO_VIEW'); ?>
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
