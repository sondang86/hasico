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
 * File Name:	views/jobseeker/tmpl/listnewestjobs.php
 ^ 
 * Description: template view for newest jobs
 ^ 
 * History:		NONE
 ^ 
 */
 
defined('_JEXEC') or die('Restricted access');
$document = JFactory::getDocument();
$link = JRoute::_('index.php?option=com_jsjobs&c=job&view=job&layout=listnewestjobs&Itemid='.$this->Itemid);
$showgoogleadds = $this->config['googleadsenseshowinnewestjobs'];
$afterjobs = $this->config['googleadsenseshowafter'];
$googleclient = $this->config['googleadsenseclient'];
$googleslot = $this->config['googleadsenseslot'];
$googleaddhieght = $this->config['googleadsenseheight'];
$googleaddwidth = $this->config['googleadsensewidth'];
$googleaddcss = $this->config['googleadsensecustomcss'];
if(JVERSION < 3){
        JHtml::_('behavior.mootools');
        $document->addScript('components/com_jsjobs/js/jquery.js');
}else{
        JHtml::_('behavior.framework');
        JHtml::_('jquery.framework');
}	
$document->addScript('components/com_jsjobs/js/jquery.tokeninput.js');
$document->addStyleSheet('components/com_jsjobs/css/token-input-jsjobs.css');
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
<!--Nav bar-->
<!--Temp disable-->
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
        
<?php 
require_once( 'jobapply.php' );
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
if ($allowed == true) {
if (isset($this->jobs)) {
    $days = $this->config['newdays'];
    $isnew = date("Y-m-d H:i:s", strtotime("-$days days"));
?>
    <div id="js_main_wrapper">
        <span class="js_controlpanel_section_title"><?php echo JText::_('JS_NEWEST_JOBS');?></span>
        <div class="js_job_filter_wrapper">
            <form action="<?php echo JRoute::_($link);?>" method="post" id="adminForm" name="adminForm">
                <?php require_once( 'job_filters.php' ); ?>
            </form>
        </div>
<?php                    
    if ( isset($this->jobs) ){
        $noofjobs = 1;
        foreach($this->jobs as $job) {
            $comma = "";
            print_job($job,$this,$isnew,1);
            if($showgoogleadds == 1){
                if($noofjobs%$afterjobs==0) { ?>
                    <table cellpadding="0" cellspacing="0" border="0" width="100%" style="<?php echo $googleaddcss;?>">
                            <tr>
                                    <td>
                                            <script type="text/javascript">
                                                    google_ad_client = "<?php echo $googleclient; ?>";
                                                    google_ad_slot = "<?php echo $googleslot; ?>";
                                                    google_ad_width = "<?php echo $googleaddwidth; ?>";
                                                    google_ad_height = "<?php echo $googleaddhieght; ?>";
                                            </script>
                                            <script type="text/javascript"
                                                    src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
                                            </script>
                                    </td>
                            </tr>
                    </table>
    <?php   
                } $noofjobs++; 
            }
        } 
    } ?>
    </div>
      
	<form action="<?php echo JRoute::_('index.php?option=com_jsjobs&c=job&view=job&layout=listnewestjobs&Itemid='.$this->Itemid); ?>" method="post">
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
<?php 
function print_job($job,$thisjob,$isnew,$jobtype = 1){ ?>
        <div class="js_job_main_wrapper">
            <div class="js_job_data_1">
                <span class="js_job_title">
                    <?php $link = 'index.php?option=com_jsjobs&c=job&view=job&layout=view_job&nav=15&bd='.$job->jobaliasid.'&Itemid='.$thisjob->Itemid; ?>
                    <a class="js_job_title" href="<?php echo $link?>"><?php echo $job->title;?></a>
                </span>
                <span class="js_job_posted">
                    <?php 
                        if($job->jobdays == 0) echo JText::_('JS_POSTED').': '.JText::_('JS_TODAY');
                        else echo JText::_('JS_POSTED').': '.$job->jobdays.' '.JText::_('JS_DAYS_AGO');
                    ?>
                </span>
            </div>
            <div class="js_job_image_area">
                <div class="js_job_image_wrapper">
                    <?php
                        if(!empty($job->companylogo)){
                            if(isset($job->localcompanyid))
                            $imgsrc = $thisjob->config['data_directory'].'/data/employer/comp_'.$job->localcompanyid.'/logo/'.$job->companylogo;
                            if($jobtype==1){
                                if($thisjob->isjobsharing){
                                    $imgsrc = $job->companylogo;
                                }else{
                                    $imgsrc = $thisjob->config['data_directory'].'/data/employer/comp_'.$job->companyid.'/logo/'.$job->companylogo;
                                }
                            }
                        }else{
                            $imgsrc = 'components/com_jsjobs/images/blank_logo.png';
                        } 
                    ?>
                    <img class="js_job_image" src="<?php echo $imgsrc; ?>" />
                </div>
            </div>
            <div class="js_job_data_area">
                <div class="js_job_data_2">
                    <?php if($thisjob->listjobconfig['lj_company'] == '1') { ?>
                            <div class="js_job_data_2_wrapper">
                                <?php if($thisjob->config['labelinlisting'] == '1'){ ?>
                                    <span class="js_job_data_2_title"><?php echo JText::_('JS_COMPANY').":"; ?></span>
                                <?php }
                                $link = 'index.php?option=com_jsjobs&c=company&view=company&layout=view_company&nav=35&cd='.$job->companyaliasid.'&cat='.$job->jobcategory.'&Itemid='.$thisjob->Itemid; 
                                ?>
                                <span class="js_job_data_2_value"><a class="js_job_data_2_company_link" href="<?php echo $link?>"><?php echo $job->companyname; ?></a></span>
                            </div>
                    <?php } ?>
                    <?php if($thisjob->listjobconfig['lj_category'] == '1') { ?>
                            <div class='js_job_data_2_wrapper'>
                                <?php if($thisjob->config['labelinlisting'] == '1'){ ?>
                                        <span class="js_job_data_2_title"><?php echo JText::_('JS_CATEGORY').":"; ?></span>
                                <?php } ?>
                                <span class="js_job_data_2_value"><?php echo  $job->cat_title; ?></span>
                            </div>
                    <?php } ?>
                    <?php if($thisjob->listjobconfig['lj_salary'] == '1') {
                             $salary = $job->symbol . $job->salaryfrom . ' - ' . $job->symbol . $job->salaryto . ' ' . $job->salaytype;
                            if($job->salaryfrom){ ?>
                                    <div class="js_job_data_2_wrapper">
                                        <?php if($thisjob->config['labelinlisting'] == '1'){ ?>
                                                <span class="js_job_data_2_title"><?php echo JText::_('JS_SALARY').":"; ?></span>
                                        <?php } ?>
                                        <span class="js_job_data_2_value"><?php echo $salary; ?></span>
                                    </div>
                            <?php }
                    }
                    if($thisjob->listjobconfig['lj_jobtype'] == '1') { ?>
                            <div class="js_job_data_2_wrapper">
                                <?php if($thisjob->config['labelinlisting'] == '1'){ ?>
                                        <span class="js_job_data_2_title"><?php echo JText::_('JS_JOB_TYPE').":"; ?></span>
                                <?php } ?>
                                <span class="js_job_data_2_value"><?php echo $job->jobtype;if($thisjob->listjobconfig['lj_jobstatus'] == '1') echo ' - '.$job->jobstatus; ?></span>
                            </div>
                    <?php } ?>
                </div>
                <div class="js_job_data_3">
                    <span class="js_job_data_location_title"><?php echo JText::_('JS_LOCATION'); ?>:&nbsp;</span>
                    <?php 
                        if($thisjob->listjobconfig['lj_city'] == '1') {
                            if(isset($job->city) AND  !empty($job->city)) { ?>
                                <span class="js_job_data_location_value">
                                <?php 
                                    if(strlen($job->city) > 35){
                                        echo JText::_('JS_MULTI_CITY').$job->city;
                                    }else{ 
                                        echo $job->city;
                                    }
                                ?>
                                    </span>
                            <?php }		
                        }
                    ?>
                    <div class="js_job_data_4">
                        <?php 
                            $link = 'index.php?option=com_jsjobs&c=jobapply&view=jobapply&layout=job_apply&nav=25&bd='.$job->jobaliasid.'&Itemid='.$thisjob->Itemid;
                        ?>
                        <a href="Javascript: void(0);" class="js_job_data_button" data-jobapply="jobapply" data-jobid="<?php echo $job->jobaliasid; ?>" ><?php echo JText::_('JS_APPLYNOW'); ?></a>
                    </div>
                </div>
            </div>
            <?php 
                switch($jobtype){
                    case 1: // Normal Job ?>                        
            <?php   break;
                }
            ?>            
            <?php if ($job->created > $isnew) { ?>
                    <div class="js_job_new"><canvas class="newjob" width="20" height="20"></canvas><?php echo JText::_('JS_NEW'); ?></div>
            <?php } ?>
            <?php 
                if($thisjob->listjobconfig['lj_noofjobs'] == '1') { 
                    if ($job->noofjobs != 0){ ?>
                        <div class="js_job_number"><canvas class="newjob" width="20" height="20"></canvas><?php echo $job->noofjobs.' '.JText::_('JOBS'); ?></div>
            <?php   } 
                } ?>
        </div>    
<?php } ?>
<?php 
$document = JFactory::getDocument();
$document->addScript('components/com_jsjobs/js/canvas_script.js');
?>