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
 * File Name:	views/employer/tmpl/jobsearchresults.php
 ^ 
 * Description: template view job search results
 ^ 
 * History:		NONE
 ^ 
 */
 
defined('_JEXEC') or die('Restricted access');
$link = 'index.php?option=com_jsjobs&c=resume&view=resume&layout=resume_searchresults&Itemid='.$this->Itemid;
?>
<!--<div id="jsjobs_main">-->
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
if($this->result != false){
if ($this->resumes){

if ($this->userrole->rolefor == 1) { // employer

	if ($this->sortlinks['sortorder'] == 'ASC')
		$img = "components/com_jsjobs/images/sort0.png";
	else
		$img = "components/com_jsjobs/images/sort1.png";

?>
    <div id="js_main_wrapper">
        <span class="js_controlpanel_section_title"><?php echo JText::_('JS_RESUME_SEARCH_RESULT');  ?></span>
        <?php 
        if($this->result != false)
        if (isset($this->searchresumeconfig['search_resume_showsave']) AND ($this->searchresumeconfig['search_resume_showsave'] == 1)) { ?>
                <div id="savesearch_form">
                    <form action="index.php" method="post" name="adminForm" id="adminForm" >
                        <div class="js_label">
                            <?php echo JText::_('JS_SEARCH_NAME'); ?>
                        </div>
                        <div class="js_input_field">
                            <input class="inputbox required" type="text" name="searchname" size="20" maxlength="30"  />
                        </div>
                        <div class="js_button_field">
                            <input type="submit" id="button" class="button validate" value="<?php echo JText::_('JS_SAVE'); ?>">
                        </div>
                        <input type="hidden" name="option" value="<?php echo $this->option; ?>" />
                        <input type="hidden" name="task" value="saveresumesearch" />
                        <input type="hidden" name="c" value="resumesearch" />
                    </form>	
                </div>
        <?php } ?>

	<div id="sortbylinks">
		<span class="my_resume_sbl_links"><a class="<?php if ($this->sortlinks['sorton'] == 'application_title') echo 'selected'; ?>" href="<?php echo $link?>&sortby=<?php echo $this->sortlinks['application_title']; ?>"><?php echo JText::_('JS_TITLE'); ?><?php if ($this->sortlinks['sorton'] == 'application_title') { ?> <img src="<?php echo $img ?>"> <?php } ?></a></span>
		<span class="my_resume_sbl_links"><a class="<?php if ($this->sortlinks['sorton'] == 'jobtype') echo 'selected'; ?>" href="<?php echo $link?>&sortby=<?php echo $this->sortlinks['jobtype']; ?>"><?php echo JText::_('JS_JOBTYPE'); ?><?php if ($this->sortlinks['sorton'] == 'jobtype') { ?> <img src="<?php echo $img ?>"> <?php } ?></a></span>
		<span class="my_resume_sbl_links"><a class="<?php if ($this->sortlinks['sorton'] == 'salaryrange') echo 'selected'; ?>" href="<?php echo $link?>&sortby=<?php echo $this->sortlinks['salaryrange']; ?>"><?php echo JText::_('JS_SALARY_RANGE'); ?><?php if ($this->sortlinks['sorton'] == 'salaryrange') { ?> <img src="<?php echo $img ?>"> <?php } ?></a></span>
		<span class="my_resume_sbl_links"><a class="<?php if ($this->sortlinks['sorton'] == 'created') echo 'selected'; ?>" href="<?php echo $link?>&sortby=<?php echo $this->sortlinks['created']; ?>"><?php echo JText::_('JS_DATEPOSTED'); ?><?php if ($this->sortlinks['sorton'] == 'created') { ?> <img src="<?php echo $img ?>"> <?php } ?></a></span>
	</div>

<?php
		foreach($this->resumes as $resume)	{
                $comma = ""; ?>
                    <div class="js_job_main_wrapper">
                        <div class="js_job_image_area">
                            <div class="js_job_image_wrapper mycompany">
                                <?php 
                                    if($resume->photo != '') {
                                        $imgsrc = $this->config['data_directory']."/data/jobseeker/resume_".$resume->id."/photo/".$resume->photo;
                                    }else{
                                        $imgsrc = "components/com_jsjobs/images/jsjobs_logo.png";
                                    } 
                                ?>
                                <img class="js_job_image" src="<?php echo $imgsrc; ?>" />
                            </div>
                        </div>
                        <div class="js_job_data_area">
                            <div class="js_job_data_2 myresume first-child">
                                <div class='js_job_data_2_wrapper'>
                                    <?php echo $resume->first_name.' '.$resume->last_name; ?>
                                </div>
                                <div class='js_job_data_2_wrapper'>
                                    (<?php echo $resume->application_title; ?>)
                                </div>
                                <div class='js_job_data_2_wrapper'>
                                    <?php echo $resume->email_address; ?>
                                </div>
                                <div class='js_job_data_2_wrapper'>
                                    <?php $link = 'index.php?option=com_jsjobs&c=resume&view=resume&layout=view_resume&nav=3&rd='.$resume->resumealiasid.'&Itemid='.$this->Itemid; ?>
                                    <a class="js_job_data_area_button" href="<?php echo $link?>"><?php echo JText::_('JS_VIEW'); ?></a>
                                </div>
                            </div>
                            <div class="js_job_data_2 myresume">
                                <div class="js_job_data_2_wrapper">
                                    <span class="js_job_data_2_title"><?php echo JText::_('JS_TOTAL_EXPERIENCE').":"; ?></span>
                                    <span class="js_job_data_2_value">
                                        <?php
                                            if(!empty($resume->total_experience)) echo $resume->total_experience;
                                            else echo JText::_('JS_NO_WORK_EXPERIENCE');
                                        ?>
                                    </span>
                                </div>
                                <div class="js_job_data_2_wrapper">
                                    <span class="js_job_data_2_title"><?php echo JText::_('JS_CATEGORY').":"; ?></span>
                                    <span class="js_job_data_2_value"><?php echo $resume->cat_title; ?></span>
                                </div>
                                <div class="js_job_data_2_wrapper">
                                    <span class="js_job_data_2_title"><?php echo JText::_('JS_SALARY').":"; ?></span>
                                    <span class="js_job_data_2_value">
                                        <?php 
                                            $salary = $resume->symbol. $resume->rangestart . ' - ' . $resume->symbol . $resume->rangeend .' '. $resume->salarytype;
                                            echo $salary;
                                        ?>
                                    </span>
                                </div>
                                <div class="js_job_data_2_wrapper">
                                    <span class="js_job_data_2_title"><?php echo JText::_('JS_JOB_TYPE').":"; ?></span>
                                    <span class="js_job_data_2_value"><?php echo $resume->jobtypetitle; ?></span>
                                </div>
                            </div>
                            <div class="js_job_data_3 myresume">
                                <?php
                                        $address = '';
                                        $comma='';
                                        if($resume->cityname != ''){
                                                $address = $comma.$resume->cityname; $comma = " ," ;
                                        }elseif($resume->employer_city != ''){
                                                $address .= $comma.$resume->employer_city; $comma = " ," ;
                                        }

                                        if($resume->statename != ''){
                                                $address .= $comma.$resume->statename; $comma = " ," ;
                                        }elseif($resume->employer_state != ''){
                                                $address .= $comma.$resume->employer_state; $comma = " ,";
                                        }

                                        if($resume->countryname != '') $address .= $comma.$resume->countryname;

                                ?>
                                <span class="js_job_data_2_title"><?php echo JText::_('JS_ADDRESS').":"; ?></span>
                                <span class="js_job_data_2_value"><?php echo $address; ?></span>
                                <?php 
                                    echo "<span class='js_job_data_2_created_myresume'>".JText::_('JS_CREATED').": ";
                                    echo date($this->config['date_format'],strtotime($resume->create_date))."</span>";
                                ?>
                            </div>
                        </div>
                    </div> 
		<?php 
		}
		 ?>
    </div>
	<form action="<?php echo JRoute::_('index.php?option=com_jsjobs&c=resume&view=resume&layout=resume_searchresults&Itemid='.$this->Itemid); ?>" method="post">
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
<?php } 
}else{ // not allowed in package ?>
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
<?php } ?>	


<script language="javascript">
//showsavesearch(0); 
</script>
<?php 
}//ol
?>
<!--<div id="jsjobs_footer">-->
    <?php // echo '<table width="100%" style="table-layout:fixed;"> <tr><td height="15"></td></tr> <tr><td style="vertical-align:top;" align="center"> <a class="img" target="_blank" href="http://www.joomsky.com"><img src="http://www.joomsky.com/logo/jsjobscrlogo.png"></a> <br> Copyright &copy; 2008 - '.date('Y').', <span id="themeanchor"> <a class="anchor"target="_blank" href="http://www.joomsky.com">Joom Sky</a></span></td></tr> </table></div>';?>
<!--</div>-->
<script type="text/javascript" language="javascript">
	function setLayoutSize(){
		var totalwidth = document.getElementById("rl_maindiv").offsetWidth;
		var per_width = (totalwidth*0.23)-10;
		var totalimagesdiv = document.getElementsByName("rl_imagediv").length;
		for(var i = 0;i<totalimagesdiv;i++){
			document.getElementsByName("rl_imagediv")[i].style.minWidth = per_width+"px";
			document.getElementsByName("rl_imagediv")[i].style.width = per_width+"px";
		}
		var totalimages = document.getElementsByName("rl_image").length;
		for(var i = 0;i<totalimages;i++){
			//document.getElementsByName("rl_image")[i].style.minWidth = per_width+"px";
			document.getElementsByName("rl_image")[i].style.width = per_width+"px";
			document.getElementsByName("rl_image")[i].style.maxWidth = per_width+"px";
		}
	}
	setLayoutSize();
</script>
