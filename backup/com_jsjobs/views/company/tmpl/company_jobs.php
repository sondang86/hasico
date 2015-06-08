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
 * File Name:	views/resume/tmpl/company_jobs.php
 ^ 
 * Description: template view for company jobs
 ^ 
 * History:		NONE
 ^ 
 */
 
defined('_JEXEC') or die('Restricted access');

global $mainframe;

$link = "index.php?option=com_jsjobs&c=company&view=company&layout=company_jobs&cd=". $this->companyid."&Itemid=".$this->Itemid;
if(isset($this->jobs[0]->aliasid)) $link = "index.php?option=com_jsjobs&c=company&view=company&layout=company_jobs&cd=". $this->jobs[0]->aliasid."&Itemid=".$this->Itemid;
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
<div id="jsjobs_main">
<div id="js_menu_wrapper">
    <?php
    if (sizeof($this->jobseekerlinks) != 0){
        foreach($this->jobseekerlinks as $lnk){ ?>                     
            <a class="js_menu_link <?php if($lnk[2] == 'job_categories') echo 'selected'; ?>" href="<?php echo $lnk[0]; ?>"><?php echo $lnk[1]; ?></a>
        <?php }
    }
    if (sizeof($this->employerlinks) != 0){
        foreach($this->employerlinks as $lnk)	{ ?>
            <a class="js_menu_link <?php if($lnk[2] == 'job_categories') echo 'selected'; ?>" href="<?php echo $lnk[0]; ?>"><?php echo $lnk[1]; ?></a>
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
<?php require_once( JPATH_COMPONENT.'/views/job/tmpl/jobapply.php' ); ?>	
<?php if (!empty($this->jobs) && $this->jobs[0]->companyname != '') $ptitle = $this->jobs[0]->companyname; if(isset($ptitle)) $ptitle =  $ptitle.' '.JText::_('JS_JOBS');else $ptitle=JText::_('JS_JOBS'); ?>
    <div id="js_main_wrapper">
        <span class="js_controlpanel_section_title">
            <?php echo $ptitle;  ?>
        </span>
<?php
if ($allowed == true) { 
if (isset($this->jobs)) {
	
	if ($this->sortlinks['sortorder'] == 'ASC')
		$img = "components/com_jsjobs/images/sort0.png";
	else
		$img = "components/com_jsjobs/images/sort1.png";
?>
	<div id="sortbylinks">
		<span class="myapplied_jobs_sbl_links"><a class="<?php if ($this->sortlinks['sorton'] == 'title') echo 'selected'; ?>" href="<?php echo $link?>&sortby=<?php echo $this->sortlinks['title']; ?>"><?php echo JText::_('JS_TITLE'); ?><?php if ($this->sortlinks['sorton'] == 'title') { ?> <img src="<?php echo $img ?>"> <?php } ?></a></span>
		<span class="myapplied_jobs_sbl_links"><a class="<?php if ($this->sortlinks['sorton'] == 'jobtype') echo 'selected'; ?>" href="<?php echo JRoute::_($link.'&sortby='. $this->sortlinks['jobtype']); ?>"><?php echo JText::_('JS_JOBTYPE'); ?><?php if ($this->sortlinks['sorton'] == 'jobtype') { ?> <img src="<?php echo $img ?>"> <?php } ?></a></span>
		<span class="myapplied_jobs_sbl_links"><a class="<?php if ($this->sortlinks['sorton'] == 'jobstatus') echo 'selected'; ?>" href="<?php echo $link?>&sortby=<?php echo $this->sortlinks['jobstatus']; ?>"><?php echo JText::_('JS_JOBSTATUS'); ?><?php if ($this->sortlinks['sorton'] == 'jobstatus') { ?> <img src="<?php echo $img ?>"> <?php } ?></a></span>
		<span class="myapplied_jobs_sbl_links"><a class="<?php if ($this->sortlinks['sorton'] == 'company') echo 'selected'; ?>" href="<?php echo $link?>&sortby=<?php echo $this->sortlinks['company']; ?>"><?php echo JText::_('JS_COMPANY'); ?><?php if ($this->sortlinks['sorton'] == 'company') { ?> <img src="<?php echo $img ?>"> <?php } ?></a></span>
		<span class="myapplied_jobs_sbl_links"><a class="<?php if ($this->sortlinks['sorton'] == 'salaryrange') echo 'selected'; ?>" href="<?php echo $link?>&sortby=<?php echo $this->sortlinks['salaryrange']; ?>"><?php echo JText::_('JS_SALARY_RANGE'); ?><?php if ($this->sortlinks['sorton'] == 'salaryrange') { ?> <img src="<?php echo $img ?>"> <?php } ?></a></span>
		<span class="myapplied_jobs_sbl_links"><a class="<?php if ($this->sortlinks['sorton'] == 'created') echo 'selected'; ?>" href="<?php echo $link?>&sortby=<?php echo $this->sortlinks['created']; ?>"><?php echo JText::_('JS_DATEPOSTED'); ?><?php if ($this->sortlinks['sorton'] == 'created') { ?> <img src="<?php echo $img ?>"> <?php } ?></a></span>
	</div>
<?php
		$days = $this->config['newdays'];
		$isnew = date("Y-m-d H:i:s", strtotime("-$days days"));
		if ( isset($this->jobs) ){
			foreach($this->jobs as $job)	{
                            $comma = '';
                            print_job($job,$this,$isnew,1);
                        } 
                } ?>	
    </div>
				
	<?php $querystring=""; if(isset($this->jobs[0]->aliasid))$querystring='&cd='.$this->jobs[0]->aliasid.'&Itemid='.$this->Itemid;?>
	<form action="<?php echo JRoute::_('index.php?option=com_jsjobs&c=company&view=company&layout=company_jobs'.$querystring); ?>" method="post">
	<div id="jl_pagination">
		<div id="jl_pagination_pageslink">
			<?php $this->pagination->setAdditionalUrlParam('', $querystring);?>			
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
                            $imgsrc = $thisjob->config['data_directory'].'/data/employer/comp_'.$job->companyid.'/logo/'.$job->companylogo;
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
<?php }
$document = JFactory::getDocument();
$document->addScript('components/com_jsjobs/js/canvas_script.js');
?>