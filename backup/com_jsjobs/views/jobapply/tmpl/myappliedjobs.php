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
 * File Name:	views/jobseeker/tmpl/myappliedjobs.php
 ^ 
 * Description: template view for my applied jobs
 ^ 
 * History:		NONE
 ^ 
 */
 
defined('_JEXEC') or die('Restricted access');
$link = 'index.php?option=com_jsjobs&c=jobapply&view=jobapply&layout=myappliedjobs&Itemid='.$this->Itemid;
?>
<div id="jsjobs_main">
        
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
if($this->myappliedjobs_allowed == VALIDATE){
    if ($this->application){

	if ($this->sortlinks['sortorder'] == 'ASC')
		$img = "components/com_jsjobs/images/sort0.png";
	else
		$img = "components/com_jsjobs/images/sort1.png";
?>
    <div id="js_main_wrapper">
        <span class="js_controlpanel_section_title"><?php echo JText::_('JS_MY_APPLIED_JOBS');?></span>
	<div id="sortbylinks">
		<?php	if($this->listjobconfig['lj_title'] == '1') { ?>				
			<span class="myapplied_jobs_sbl_links"><a class="<?php if ($this->sortlinks['sorton'] == 'title') echo 'selected' ?>" href="<?php echo $link?>&sortby=<?php echo $this->sortlinks['title']; ?>"><?php echo JText::_('JS_TITLE'); ?><?php if ($this->sortlinks['sorton'] == 'title') { ?> <img src="<?php echo $img ?>"> <?php } ?></a></span>
		<?php }
		if($this->listjobconfig['lj_jobtype'] == '1') { ?>				
			<span class="myapplied_jobs_sbl_links"><a class="<?php if ($this->sortlinks['sorton'] == 'jobtype') echo 'selected' ?>" href="<?php echo $link?>&sortby=<?php echo $this->sortlinks['jobtype']; ?>"><?php echo JText::_('JS_JOBTYPE'); ?><?php if ($this->sortlinks['sorton'] == 'jobtype') { ?> <img src="<?php echo $img ?>"> <?php } ?></a></span>
		<?php }
		if($this->listjobconfig['lj_jobstatus'] == '1') { ?>	
			<span class="myapplied_jobs_sbl_links"><a class="<?php if ($this->sortlinks['sorton'] == 'jobstatus') echo 'selected' ?>" href="<?php echo $link?>&sortby=<?php echo $this->sortlinks['jobstatus']; ?>"><?php echo JText::_('JS_JOBSTATUS'); ?><?php if ($this->sortlinks['sorton'] == 'jobstatus') { ?> <img src="<?php echo $img ?>"> <?php } ?></a></span>
		<?php }
		if($this->listjobconfig['lj_company'] == '1') { ?>	
			<span class="myapplied_jobs_sbl_links"><a class="<?php if ($this->sortlinks['sorton'] == 'company') echo 'selected' ?>" href="<?php echo $link?>&sortby=<?php echo $this->sortlinks['company']; ?>"><?php echo JText::_('JS_COMPANY'); ?><?php if ($this->sortlinks['sorton'] == 'company') { ?> <img src="<?php echo $img ?>"> <?php } ?></a></span>
		<?php }
		if($this->listjobconfig['lj_salary'] == '1') { ?>	
			<span class="myapplied_jobs_sbl_links"><a class="<?php if ($this->sortlinks['sorton'] == 'salaryrange') echo 'selected' ?>" href="<?php echo $link?>&sortby=<?php echo $this->sortlinks['salaryrange']; ?>"><?php echo JText::_('JS_SALARY_RANGE'); ?><?php if ($this->sortlinks['sorton'] == 'salaryrange') { ?> <img src="<?php echo $img ?>"> <?php } ?></a></span>
		<?php }
		if($this->listjobconfig['lj_created'] == '1') { ?>	
			<span class="myapplied_jobs_sbl_links"><a class="<?php if ($this->sortlinks['sorton'] == 'created') echo 'selected' ?>" href="<?php echo $link?>&sortby=<?php echo $this->sortlinks['created']; ?>"><?php echo JText::_('JS_DATEPOSTED'); ?><?php if ($this->sortlinks['sorton'] == 'created') { ?> <img src="<?php echo $img ?>"> <?php } ?></a></span>
		<?php } ?>
	</div>
		<?php
		$days = $this->config['newdays'];
		$isnew = date("Y-m-d H:i:s", strtotime("-$days days"));
		if ( isset($this->application) ){
		foreach($this->application as $job) {
                    $comma = ""; ?>
<div class="js_job_main_wrapper">
            <div class="js_job_image_area">
                <div class="js_job_image_wrapper">
                    <?php
                        if(!empty($job->companylogo)){
                            if($this->isjobsharing){
                                $imgsrc = $job->companylogo;
                            }else{
                                $imgsrc = $this->config['data_directory'].'/data/employer/comp_'.$job->companyid.'/logo/'.$job->companylogo;
                            }
                        }else{
                            $imgsrc = 'components/com_jsjobs/images/blank_logo.png';
                        } 
                    ?>
                    <img class="js_job_image" src="<?php echo $imgsrc; ?>" />
                </div>
                <div class="js_job_quick_view_wrapper">
                    <?php 
                    if($this->listjobconfig['lj_noofjobs'] == '1') {
                        if ($job->noofjobs != 0){
                                echo $job->noofjobs." ".JText::_('JS_JOBS');
                        }
                    } ?>
                </div>
            </div>
            <div class="js_job_data_area">
                <div class="js_job_data_1">
                    <span class="js_job_title">
                        <?php $link = 'index.php?option=com_jsjobs&c=job&view=job&layout=view_job&nav=16&bd='.$job->jobaliasid.'&Itemid='.$this->Itemid; ?>
                        <a href="<?php echo $link; ?>" class=''><?php echo $job->title; ?></a>
                    </span>
                    <span class="js_job_posted">
                        <?php
                                echo JText::_('JS_APPLIED_DATE').':&nbsp;'.date($this->config['date_format'],strtotime($job->apply_date));
                        ?>
                    </span>
                </div>
                <div class="js_job_data_2">
                    <?php 
                    if($this->listjobconfig['lj_company'] == '1') {
                            echo "<div class='js_job_data_2_wrapper'>";
                            if($this->config['labelinlisting'] == '1'){
                                    echo "<span class=\"js_job_data_2_title\">".JText::_('JS_COMPANY').": </span>";
                            }
                            $link = 'index.php?option=com_jsjobs&c=company&view=company&layout=view_company&nav=34&cd='.$job->companyaliasid.'&cat='.$job->jobcategory.'&Itemid='.$this->Itemid; 
                            ?>
                            <span class="js_job_data_2_value"><a class="jl_company_a" href="<?php echo $link?>"><?php echo $job->companyname; ?></a></span></div>
                    <?php }
                    if($this->listjobconfig['lj_category'] == '1') { 
                            echo "<div class='js_job_data_2_wrapper'>";
                            if($this->config['labelinlisting'] == '1'){
                                    echo "<span class=\"js_job_data_2_title\">".JText::_('JS_CATEGORY').": </span>";
                            }
                            echo  "<span class=\"js_job_data_2_value\">".$job->cat_title."</span></div>";
                    }
                    if($this->listjobconfig['lj_salary'] == '1') {
                            $salary = $job->symbol . $job->rangestart . ' - ' . $job->symbol . $job->rangeend . ' /month ' ;
                            if($job->rangestart){
                                echo "<div class='js_job_data_2_wrapper'>";
                                    if($this->config['labelinlisting'] == '1'){
                                            echo "<span class=\"js_job_data_2_title\">".JText::_('JS_SALARY').": </span>";
                                    }
                                    echo "<span class=\"js_job_data_2_value\">".$salary."</span></div>";
                            }
                    }
                    if($this->listjobconfig['lj_jobtype'] == '1') {
                            echo "<div class='js_job_data_2_wrapper'>";
                            if($this->config['labelinlisting'] == '1'){
                                    echo "<span class=\"js_job_data_2_title\">".JText::_('JS_JOB_TYPE').": </span>";
                            }
                            echo "<span class=\"js_job_data_2_value\">".$job->jobtypetitle;
                            if($this->listjobconfig['lj_jobstatus'] == '1') echo ' - '.$job->jobstatustitle; 
                            echo "</span></div>";
                    } ?>
            </div>
                <div class="js_job_data_3 myjob">
                    <?php
                    if ($this->listjobconfig['lj_country'] == '1') {

                        echo "<span class=\"js_job_data_location_title\">".JText::_('JS_LOCATION').":&nbsp;</span>";
                        if(isset($job->city) AND  !empty($job->city)) {
                                if(strlen($job->city) > 35){  ?> <span class="js_job_data_location_value"><?php echo JText::_('JS_MULTI_CITY').$job->city; ?></span>
                                <?php }else{ echo "<span class=\"js_job_data_location_value\">".$job->city."</span>";}
                        }		
                    }
                    ?>
                </div>                
                <?php 
                    $g_f_job = 0;
                    if($job->isgold == 1) $g_f_job = 1; // gold job
                    if($job->isfeatured == 1) $g_f_job = 2; // featured job
                    if($job->isgold == 1 && $job->isfeatured == 1) $g_f_job = 3;//gold and featured job
                    switch($g_f_job){
                            case 1: //gold job
                                    echo '<div id="jl_image_gold"></div>';
                            break;
                            case 2: //featured job
                                    echo '<div id="jl_image_featured"></div>';
                            break;
                            case 3: //gold and featured job
                                    echo '<div id="jl_image_gold_featured"></div>';
                            break;
                    }
                    if ($job->created > $isnew) {
                            echo '<div id="jl_image_new"></div>';
                    } 
                ?>
            </div>
</div>
                    <?php }
					} ?>
    </div>
<form action="<?php echo JRoute::_('index.php?option=com_jsjobs&c=jobapply&view=jobapply&layout=myappliedjobs&Itemid='.$this->Itemid); ?>" method="post">
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
}else{
    switch($this->myappliedjobs_allowed){
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
<?php
$document = JFactory::getDocument();
$document->addScript('components/com_jsjobs/js/canvas_script.js');
?>