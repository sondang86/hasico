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
 * File Name:	views/employer/tmpl/controlpanel.php
 ^ 
 * Description: template view for control panel
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
            <!--<a class="js_menu_link <?php // if($lnk[2] == 'controlpanel') echo 'selected'; ?>" href="<?php // echo $lnk[0]; ?>"><?php // echo $lnk[1]; ?></a>-->
        <?php // }
//    }
//    if (sizeof($this->employerlinks) != 0){
//        foreach($this->employerlinks as $lnk)	{ ?>
            <!--<a class="js_menu_link <?php // if($lnk[2] == 'controlpanel') echo 'selected'; ?>" href="<?php // echo $lnk[0]; ?>"><?php // echo $lnk[1]; ?></a>-->
        <?php // }
//    }
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
$userrole = $this->userrole;
$config = $this->config;
$emcontrolpanel = $this->emcontrolpanel;
if (isset($userrole->rolefor)){
        if ($userrole->rolefor == 1) // employer
            $allowed = true;
        else
            $allowed = false;
}else { if ($config['visitorview_emp_conrolpanel'] == 1) $allowed = true; else $allowed = false; } // user not logined
if ($allowed == true) {
?>
    <div id="js_main_wrapper">
        <span class="js_controlpanel_section_title"><?php echo JText::_('JS_MY_STUFF');?></span>
			<?php
			$print = checkLinks('formcompany',$userrole,$config,$emcontrolpanel);
			if($print){ ?>
                <a class="js_controlpanel_link" href="index.php?option=com_jsjobs&c=company&view=company&layout=formcompany&Itemid=<?php echo $this->Itemid; ?>">
                    <img class="js_controlpanel_link_image" src="components/com_jsjobs/images/addcompany.png" alt="New Company" />
                    <div class="js_controlpanel_link_text_wrapper">
                        <span class="js_controlpanel_link_title"><?php echo JText::_('JS_NEW_COMPANY'); ?></span>
                    </div>
                </a>
			<?php }
			$print = checkLinks('mycompanies',$userrole,$config,$emcontrolpanel);
			if($print){ ?>
                <a class="js_controlpanel_link" href="index.php?option=com_jsjobs&c=company&view=company&layout=mycompanies&Itemid=<?php echo $this->Itemid; ?>">
                    <img class="js_controlpanel_link_image" src="components/com_jsjobs/images/mycompanies.png" alt="My Companies" />
                    <div class="js_controlpanel_link_text_wrapper">
                        <span class="js_controlpanel_link_title"><?php echo JText::_('JS_MY_COMPANIES');?></span>
                    </div>
                </a>
			<?php } 
			$print = checkLinks('formjob',$userrole,$config,$emcontrolpanel);
			if($print){ ?>
                <a class="js_controlpanel_link" href="index.php?option=com_jsjobs&c=job&view=job&layout=formjob&Itemid=<?php echo $this->Itemid; ?>">
                    <img class="js_controlpanel_link_image" src="components/com_jsjobs/images/addjob.png" alt="New Job" />
                    <div class="js_controlpanel_link_text_wrapper">
                        <span class="js_controlpanel_link_title"><?php echo JText::_('JS_NEW_JOB');?></span>
                    </div>
                </a>
			<?php }
			$print = checkLinks('myjobs',$userrole,$config,$emcontrolpanel);
			if($print){ ?>
                <a class="js_controlpanel_link" href="index.php?option=com_jsjobs&c=job&view=job&layout=myjobs&Itemid=<?php echo $this->Itemid; ?>">
                    <img class="js_controlpanel_link_image" src="components/com_jsjobs/images/myjobs.png" alt="My Jobs" />
                    <div class="js_controlpanel_link_text_wrapper">
                        <span class="js_controlpanel_link_title"><?php echo JText::_('JS_MY_JOBS');?></span>
                    </div>
                </a>
			<?php }
			$print = checkLinks('formdepartment',$userrole,$config,$emcontrolpanel);
			if($print){ ?>
                <a class="js_controlpanel_link" href="index.php?option=com_jsjobs&c=department&view=department&layout=formdepartment&Itemid=<?php echo $this->Itemid; ?>">
                    <img class="js_controlpanel_link_image" src="components/com_jsjobs/images/adddepartment.png" alt="Form Department" />
                    <div class="js_controlpanel_link_text_wrapper">
                        <span class="js_controlpanel_link_title"><?php echo JText::_('JS_NEW_DEPARTMENT');?></span>
                    </div>
                </a>
			<?php } 
			$print = checkLinks('mydepartment',$userrole,$config,$emcontrolpanel);
			if($print){ ?>
                <a class="js_controlpanel_link" href="index.php?option=com_jsjobs&c=department&view=department&layout=mydepartments&Itemid=<?php echo $this->Itemid; ?>">
                    <img class="js_controlpanel_link_image" src="components/com_jsjobs/images/mydepartments.png" alt="My Department" />
                    <div class="js_controlpanel_link_text_wrapper">
                        <span class="js_controlpanel_link_title"><?php echo JText::_('JS_MY_DEPARTMENTS');?></span>
                    </div>
                </a>
			<?php } 
			if($emcontrolpanel['emploginlogout'] == 1){ 
                            if(isset($userrole->rolefor)){//jobseeker
                                    $link = "index.php?option=com_users&c=users&task=logout&Itemid=".$this->Itemid;
                                    $text = JText::_('JS_LOGOUT');
                                    $icon = "logout.png";
                            }else{
                                    $redirectUrl = JRoute::_('index.php?option=com_jsjobs&c=jobseeker&view=jobseeker&layout=controlpanel&Itemid='.$this->Itemid);
                                    $redirectUrl = '&amp;return=' . $this->getJSModel('common')->b64ForEncode($redirectUrl);
                                    $link = 'index.php?option=com_users&view=login' . $redirectUrl;
                                    $text = JText::_('JS_LOGIN');
                                    $icon = "login.png";
                            }
                            ?>
                <a class="js_controlpanel_link" href="<?php echo $link; ?>">
                    <img class="js_controlpanel_link_image" src="components/com_jsjobs/images/<?php echo $icon;?>" alt="Messages" />
                    <div class="js_controlpanel_link_text_wrapper">
                        <span class="js_controlpanel_link_title"><?php echo $text; ?></span>
                    </div>
                </a>
			<?php } ?>
                <span class="js_controlpanel_section_title"><?php echo JText::_('JS_RESUMES');?></span>        
			<?php
			$print = checkLinks('resumesearch',$userrole,$config,$emcontrolpanel);
			if($print){ ?>
                <a class="js_controlpanel_link" href="index.php?option=com_jsjobs&c=resume&view=resume&layout=resumesearch&Itemid=<?php echo $this->Itemid; ?>">
                    <img class="js_controlpanel_link_image" src="components/com_jsjobs/images/resumesearch.png" alt="Search Resume" />
                    <div class="js_controlpanel_link_text_wrapper">
                        <span class="js_controlpanel_link_title"><?php echo JText::_('JS_SEARCH_RESUME'); ?></span>
                    </div>
                </a>
			<?php } 
			$print = checkLinks('resumesearch',$userrole,$config,$emcontrolpanel);
			if($print){ ?>
                <a class="js_controlpanel_link" href="index.php?option=com_jsjobs&c=resume&view=resume&layout=my_resumesearches&Itemid=<?php echo $this->Itemid; ?>">
                    <img class="js_controlpanel_link_image" src="components/com_jsjobs/images/resumesavesearch.png" alt="Search Resume" />
                    <div class="js_controlpanel_link_text_wrapper">
                        <span class="js_controlpanel_link_title"><?php echo JText::_('JS_RESUME_SAVE_SEARCHES'); ?></span>
                    </div>
                </a>
			<?php } 
			$print = checkLinks('resumesearch',$userrole,$config,$emcontrolpanel);
			if($print){ ?>
                <a class="js_controlpanel_link" href="index.php?option=com_jsjobs&c=resume&view=resume&layout=resumebycategory&Itemid=<?php echo $this->Itemid; ?>">
                    <img class="js_controlpanel_link_image" src="components/com_jsjobs/images/resumebycat.png" alt=" Resume By Category" />
                    <div class="js_controlpanel_link_text_wrapper">
                        <span class="js_controlpanel_link_title"><?php echo JText::_('JS_RESUME_BY_CATEGORY'); ?></span>
                    </div>
                </a>
			<?php } ?>
                <span class="js_controlpanel_section_title"><?php echo JText::_('JS_STATISTICS');?></span>        
			<?php
			$print = checkLinks('packages',$userrole,$config,$emcontrolpanel);
			if($print){ ?>
                <a class="js_controlpanel_link" href="index.php?option=com_jsjobs&c=employerpackages&view=employerpackages&layout=packages&Itemid=<?php echo $this->Itemid; ?>">
                    <img class="js_controlpanel_link_image" src="components/com_jsjobs/images/packages.png" alt=" Packages" />
                    <div class="js_controlpanel_link_text_wrapper">
                        <span class="js_controlpanel_link_title"><?php echo JText::_('JS_PACKAGES'); ?></span>
                    </div>
                </a>
			<?php } 
			$print = checkLinks('purchasehistory',$userrole,$config,$emcontrolpanel);
			if($print){ ?>
                <a class="js_controlpanel_link" href="index.php?option=com_jsjobs&c=purchasehistory&view=purchasehistory&layout=employerpurchasehistory&Itemid=<?php echo $this->Itemid; ?>">
                    <img class="js_controlpanel_link_image" src="components/com_jsjobs/images/purchase_history.png" alt=" Employer Purchase History" />
                    <div class="js_controlpanel_link_text_wrapper">
                        <span class="js_controlpanel_link_title"><?php echo JText::_('JS_PURCHASE_HISTORY'); ?></span>
                    </div>
                </a>
			<?php }
			$print = checkLinks('my_stats',$userrole,$config,$emcontrolpanel);
			if($print){ ?>
                <a class="js_controlpanel_link" href="index.php?option=com_jsjobs&c=employer&view=employer&layout=my_stats&Itemid=<?php echo $this->Itemid; ?>">
                    <img class="js_controlpanel_link_image" src="components/com_jsjobs/images/mystats.png" alt="My Stats" />
                    <div class="js_controlpanel_link_text_wrapper">
                        <span class="js_controlpanel_link_title"><?php echo JText::_('JS_MY_STATS'); ?></span>
                    </div>
                </a>
			<?php } ?>
		</div>
<?php
	if($emcontrolpanel['empexpire_package_message'] == 1){
		$message = '';
		if(!empty($this->packagedetail[0]->packageexpiredays)){
			$days = $this->packagedetail[0]->packageexpiredays - $this->packagedetail[0]->packageexpireindays;
			if($days == 1) $days = $days.' '.JText::_('JS_DAY'); else $days = $days.' '.JText::_('JS_DAYS');
			$message = "<strong><font color='red'>".JText::_('JS_YOUR_PACKAGE').' &quot;'.$this->packagedetail[0]->packagetitle.'&quot; '.JText::_('JS_HAS_EXPIRED').' '.$days.' ' .JText::_('JS_AGO')." <a href='index.php?option=com_jsjobs&c=jobseekerpackages&view=jobseekerpackages&layout=packages&Itemid=$this->Itemid'>".JText::_('JS_EMPLOYER_PACKAGES')."</a></font></strong>";
		} 
		if($message != ''){?>
			<div id="errormessage" class="errormessage">
			<div id="message"><?php echo $message;?></div>
			</div>
<?php 	}
	}?>
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
                        <?php echo JText::_('JS_YOU_ARE_NOT_ALLOWED_TO_VIEW_EMPLOYER_CONTROL_PANEL'); ?>
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
<?php
    function checkLinks($name,$userrole,$config,$emcontrolpanel){
        $print = false;
        if (isset($userrole->rolefor)){
            if ($userrole->rolefor == 1){
                if ($emcontrolpanel[$name] == 1) $print = true;
            }
        }else{
            if($name == 'empmessages') $name = 'vis_emmessages';
            elseif($name == 'empresume_rss') $name = 'vis_resume_rss';
            else $name = 'vis_em'.$name;
            
            if($config[$name] == 1) $print = true;
        }
        return $print;
    }

?>
