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
 * File Name:	views/employer/tmpl/myjobs.php
  ^
 * Description: template view for my jobs
  ^
 * History:		NONE
  ^
 */
defined('_JEXEC') or die('Restricted access');
$link = 'index.php?option=com_jsjobs&c=job&view=job&layout=myjobs&Itemid=' . $this->Itemid;
?>
<script language="Javascript">
    function confirmdeletejob() {
        return confirm("<?php echo JText::_('JS_ARE_YOU_SURE_DELETE_THE_JOB'); ?>");
    }
</script>
<div id="jsjobs_main">
 
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
<?php if ($this->config['offline'] == '1') { ?>
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
<?php }else { ?>
    <?php
    if($this->myjobs_allowed == VALIDATE){
    if ($this->jobs) {
            if ($this->sortlinks['sortorder'] == 'ASC')
                $img = "components/com_jsjobs/images/sort0.png";
            else
                $img = "components/com_jsjobs/images/sort1.png";
            ?>
    <div id="js_main_wrapper">
    <form action="index.php" method="post" name="adminForm">
        <span class="js_controlpanel_section_title"><?php echo JText::_('JS_MY_JOBS');?></span>
        <div id="sortbylinks">
            <span class="my_job_sbl_links"><a href="<?php echo $link ?>&sortby=<?php echo $this->sortlinks['title']; ?>" class="<?php if ($this->sortlinks['sorton'] == 'title') echo 'selected' ?>"><?php echo JText::_('JS_TITLE'); ?><?php if ($this->sortlinks['sorton'] == 'title') { ?> <img src="<?php echo $img ?>"> <?php } ?></a></span>
            <span class="my_job_sbl_links"><a href="<?php echo $link ?>&sortby=<?php echo $this->sortlinks['category']; ?>" class="<?php if ($this->sortlinks['sorton'] == 'category') echo 'selected' ?>"><?php echo JText::_('JS_CATEGORY'); ?><?php if ($this->sortlinks['sorton'] == 'category') { ?> <img src="<?php echo $img ?>"> <?php } ?></a></span>
            <span class="my_job_sbl_links"><a href="<?php echo $link ?>&sortby=<?php echo $this->sortlinks['jobtype']; ?>" class="<?php if ($this->sortlinks['sorton'] == 'jobtype') echo 'selected' ?>"><?php echo JText::_('JS_JOBTYPE'); ?><?php if ($this->sortlinks['sorton'] == 'jobtype') { ?> <img src="<?php echo $img ?>"> <?php } ?></a></span>
            <span class="my_job_sbl_links"><a href="<?php echo $link ?>&sortby=<?php echo $this->sortlinks['jobstatus']; ?>" class="<?php if ($this->sortlinks['sorton'] == 'jobstatus') echo 'selected' ?>"><?php echo JText::_('JS_JOBSTATUS'); ?><?php if ($this->sortlinks['sorton'] == 'jobstatus') { ?> <img src="<?php echo $img ?>"> <?php } ?></a></span>
            <span class="my_job_sbl_links"><a href="<?php echo $link ?>&sortby=<?php echo $this->sortlinks['company']; ?>" class="<?php if ($this->sortlinks['sorton'] == 'company') echo 'selected' ?>"><?php echo JText::_('JS_COMPANY'); ?><?php if ($this->sortlinks['sorton'] == 'company') { ?> <img src="<?php echo $img ?>"> <?php } ?></a></span>
            <span class="my_job_sbl_links"><a href="<?php echo $link ?>&sortby=<?php echo $this->sortlinks['salaryto']; ?>" class="<?php if ($this->sortlinks['sorton'] == 'salaryto') echo 'selected' ?>"><?php echo JText::_('JS_SALARY_RANGE'); ?><?php if ($this->sortlinks['sorton'] == 'salaryrange') { ?> <img src="<?php echo $img ?>"> <?php } ?></a></span>
            <span class="my_job_sbl_links"><a href="<?php echo $link ?>&sortby=<?php echo $this->sortlinks['created']; ?>" class="<?php if ($this->sortlinks['sorton'] == 'created') echo 'selected' ?>"><?php echo JText::_('JS_CREATED'); ?><?php if ($this->sortlinks['sorton'] == 'created') { ?> <img src="<?php echo $img ?>"> <?php } ?></a></span>
        </div>
        <?php
        $days = $this->config['newdays'];
        $isnew = date("Y-m-d H:i:s", strtotime("-$days days"));
        if (isset($this->jobs)) {
            foreach ($this->jobs as $job) { ?>
        <div class="js_job_main_wrapper">
            <div class="js_job_data_1">
                <span class="js_job_title">
                    <?php
                        $jobaliasid = ($this->isjobsharing != "") ? $job->sjobaliasid : $job->jobaliasid;
                        $link = 'index.php?option=com_jsjobs&c=job&view=job&layout=view_job&nav=19&bd=' . $jobaliasid . '&Itemid=' . $this->Itemid;
                    ?>
                    <a href="<?php echo $link; ?>" class=''><?php echo $job->title; ?></a>
                </span>
                <span class="js_job_posted">
                    <?php
                        if ($this->listjobconfig['lj_created'] == '1') {
                            echo JText::_('JS_CREATED') . ':&nbsp;' . date($this->config['date_format'], strtotime($job->created));
                        }
                    ?>
                </span>
            </div>
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
            </div>
            <div class="js_job_data_area">
                <div class="js_job_data_2">
                    <?php
                    if ($this->listjobconfig['lj_company'] == '1') {
                        echo "<div class='js_job_data_2_wrapper'>";
                        if ($this->config['labelinlisting'] == '1') {
                            echo "<span class=\"js_job_data_2_title\">" . JText::_('JS_COMPANY') . ": </span>";
                        }
                        $companyaliasid = ($this->isjobsharing != "") ? $job->scompanyaliasid : $job->companyaliasid;
                        $jobcategory = ($this->isjobsharing != "") ? $job->sjobcategory : $job->jobcategory;
                        $link = 'index.php?option=com_jsjobs&c=company&view=company&layout=view_company&nav=41&cd=' . $companyaliasid . '&cat=' . $jobcategory . '&Itemid=' . $this->Itemid;
                        ?>
                        <span class="js_job_data_2_value"><a href="<?php echo $link ?>"><?php echo $job->companyname; ?></a></span></div>
                    <?php
                    }
                    if ($this->listjobconfig['lj_category'] == '1') {
                        echo "<div class='js_job_data_2_wrapper'>";
                        if ($this->config['labelinlisting'] == '1') {
                            echo "<span class=\"js_job_data_2_title\">" . JText::_('JS_CATEGORY') . ": </span>";
                        }
                        echo '<span class="js_job_data_2_value">'.$job->cat_title . "</span></div>";
                    }
                    if ($this->listjobconfig['lj_salary'] == '1') {
                        $salary = $job->symbol . $job->rangestart . ' - ' . $job->symbol . $job->rangeend . ' ' . $job->salarytypetitle;
                        if ($job->rangestart) {
                            echo "<div class='js_job_data_2_wrapper'>";
                            if ($this->config['labelinlisting'] == '1') {
                                echo "<span class=\"js_job_data_2_title\">" . JText::_('JS_SALARY') . ": </span>";
                            }
                            echo '<span class="js_job_data_2_value">'.$salary . "</span></div>";
                        }
                    }
                    if ($this->listjobconfig['lj_jobtype'] == '1') {
                        echo "<div class='js_job_data_2_wrapper'>";
                        if ($this->config['labelinlisting'] == '1') {
                            echo "<span class=\"js_job_data_2_title\">" . JText::_('JS_JOB_TYPE') . ": </span>";
                        }
                        echo '<span class="js_job_data_2_value">'.$job->jobtypetitle;
                        if ($this->listjobconfig['lj_jobstatus'] == '1')
                            echo ' - ' . $job->jobstatustitle;
                        echo "</span></div>";
                    }
                    ?>
                    <?php
                    if ($this->listjobconfig['lj_country'] == '1') {

                        echo "<span class=\"js_job_data_location_title\">".JText::_('JS_LOCATION').":&nbsp;</span>";
                        if (isset($job->city) AND !empty($job->city)) {
                            echo "<span class=\"js_job_data_location_value\">".$job->city."</span>";
                        }
                    }
                    ?>
                </div>
                
            </div>
            <div class="js_job_data_3 myjob">
                <div class="js_job_data_3_myjob_no">
                    <?php
                    if ($this->listjobconfig['lj_noofjobs'] == '1') {
                        echo "<span class='js_job_myjob_numbers'>" ;
                            if ($job->noofjobs != 0) {
                                echo $job->noofjobs ." ".JText::_('JS_JOBS');
                            }else{
                                echo  '1'." ".JText::_('JS_JOBS');
                            }
                        echo "</span>";
                    }
                    ?>
                </div>
                <div class="js_job_data_4 myjob">
                <?php
                    if ($job->status == '1') {
                        $show_links = false;
                        if ($this->isjobsharing) {
                            if ($job->serverstatus == "ok")
                                $show_links = true;
                            else
                                $show_links = false;
                        }else {
                            $show_links = true;
                        }
                        if ($show_links) {
                            //check for is gold, featured or both
                            $g_f_job = 0;

                            if (isset($job->visitor) && $job->visitor == 'visitor')
                                $link = 'index.php?option=com_jsjobs&c=job&view=job&layout=formjob_visitor&email=' . $job->contactemail . '&bd=' . $job->jobaliasid . '&Itemid=' . $this->Itemid;
                            else
                                $link = 'index.php?option=com_jsjobs&c=job&view=job&layout=formjob&bd=' . $job->jobaliasid . '&Itemid=' . $this->Itemid;
                            if (isset($job->visitor) && $job->visitor == 'visitor') {
                                if ($this->config['visitor_can_edit_job'] == 1) {
                                    ?>
                                    <a href="<?php echo $link ?>" class="company_icon" title="<?php echo JText::_('JS_EDIT'); ?>"><img width="17" height="17" src="components/com_jsjobs/images/edit.png" /></a>
                                <?php }
                            } else {
                                ?>
                                <a href="<?php echo $link ?>" class="company_icon" title="<?php echo JText::_('JS_EDIT'); ?>"><img width="17" height="17" src="components/com_jsjobs/images/edit.png" /></a>
                            <?php
                            }
                            $jobaliasid = ($this->isjobsharing != "") ? $job->sjobaliasid : $job->jobaliasid;
                            $link = 'index.php?option=com_jsjobs&c=job&view=job&layout=view_job&nav=19&bd=' . $jobaliasid . '&Itemid=' . $this->Itemid;
                            ?>

                            <a href="<?php echo $link ?>" class="company_icon" title="<?php echo JText::_('JS_VIEW'); ?>"><img width="17" height="17" src="components/com_jsjobs/images/view.png" /></a>
                            <?php
                            if (isset($job->visitor) && $job->visitor == 'visitor')
                                $link = 'index.php?option=com_jsjobs&task=job.deletejob&email=' . $job->contactemail . '&bd=' . $job->jobaliasid . '&Itemid=' . $this->Itemid;
                            else
                                $link = 'index.php?option=com_jsjobs&task=job.deletejob&bd=' . $job->jobaliasid . '&Itemid=' . $this->Itemid;
                            ?>
                            <a href="<?php echo $link ?>" class="company_icon" onclick=" return confirmdeletejob();"  title="<?php echo JText::_('JS_DELETE'); ?>"><img width="17" height="17" src="components/com_jsjobs/images/delete.png" /></a>

                        <?php } ?>

                    <?php } ?>
                </div>
                <div class="js_job_data_3_myjob_no">
                    <?php $jobaliasid = ($this->isjobsharing != "") ? $job->sjobaliasid : $job->jobaliasid; ?>		
                    <?php $link = 'index.php?option=com_jsjobs&c=jobapply&view=jobapply&layout=job_appliedapplications&bd='.$jobaliasid.'&Itemid='.$this->Itemid; ?>
                    <a class="applied_resume_button" href="<?php echo $link?>"><?php echo JText::_('JS_RESUME'); echo ' ('.$job->totalapply.')'; ?></a>
                </div>
            </div>
            <?php
            $curdate = date('Y-m-d');
            $startpublishing = date('Y-m-d', strtotime($job->startpublishing));
            $stoppublishing = date('Y-m-d', strtotime($job->stoppublishing));
            if ($job->status == 1) {
                    if ($startpublishing <= $curdate) {
                        if ($stoppublishing >= $curdate) {
                            $jobstatus = "published_txt.png";
                            $jobstatus = JText::_('JS_PUBLISH');
                            $class = "publish";
                            $message = "";
                        } else {
                            $jobstatus = "expired_txt.png";
                            $jobstatus = JText::_('JS_EXPIRED');
                            $class = "expired";
                            $message = "";
                        }
                    } else {
                        $jobstatus = "notpublish_txt.png";
                        $jobstatus = JText::_('JS_NOT_PUBLISH');
                        $class = "notpublish";
                        $message = "";
                    }
            } elseif ($job->status == -1) {
                $jobstatus = "rejected.png";
                $jobstatus = JText::_('JS_REJECTED');
                $class = "rejected";
                $message = "";
            } else {
                $jobstatus = "pending.png";
                $jobstatus = JText::_('JS_PENDDING');
                $class = "pending";
                $message = "";
            }
            ?>
            <div class="js_job_publish <?php echo $class; ?>"><canvas class="goldjob" width="20" height="20"></canvas><?php echo $jobstatus; ?></div>
            <?php
            $g_f_job = 0;
            if ($job->created > $isnew) {
                echo '<div class="js_job_new"><canvas class="newjob" width="20" height="20"></canvas>'.JText::_('JS_NEW').'</div>';
            }
            ?>
            <?php 
                switch($g_f_job){
                    case 1: // Gold job ?>                        
                        <div class="js_job_gold mycompany"><canvas class="goldjob" width="20" height="20"></canvas><?php echo JText::_('JS_GOLD'); ?></div>
            <?php   break;
                }
            ?>            
        </div>    
                <?php
                }
            }
            ?>
                <input type="hidden" name="option" value="<?php echo $this->option; ?>" />
                <input type="hidden" name="task" value="deletejob" />
                <input type="hidden" name="c" value="job" />
                <input type="hidden" id="id" name="id" value="" />
                <input type="hidden" name="boxchecked" value="0" />

            </form>

            <form action="<?php echo JRoute::_('index.php?option=com_jsjobs&c=job&view=job&layout=myjobs&Itemid=' . $this->Itemid); ?>" method="post">
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
    } else { // no result found in this category 
        ?>
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
        switch($this->myjobs_allowed){
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
        case VISITOR_NOT_ALLOWED_TO_EDIT_THEIR_JOBS: ?>
            <div class="js_job_error_messages_wrapper">
                <div class="js_job_messages_image_wrapper">
                    <img class="js_job_messages_image" src="components/com_jsjobs/images/4.png"/>
                </div>
                <div class="js_job_messages_data_wrapper">
                    <span class="js_job_messages_main_text">
                        <?php echo JText::_('JS_VISITOR_NOT_ALLOWED_TO_EDIT_THEIR_JOBS'); ?>
                    </span>
                    <span class="js_job_messages_block_text">
                        <?php echo JText::_('JS_VISITOR_NOT_ALLOWED_TO_EDIT_THEIR_JOBS'); ?>
                    </span>
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
<script type="text/javascript" src="<?php echo JURI::root(); ?>components/com_jsjobs/js/tinybox.js"></script>
<link media="screen" rel="stylesheet" href="<?php echo JURI::root(); ?>components/com_jsjobs/js/style.css" />
</div>
<?php 
$document = JFactory::getDocument();
$document->addScript('components/com_jsjobs/js/canvas_script.js');
?>