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
 * File Name:	views/jobseeker/tmpl/jobsearchresults.php
  ^
 * Description: template view job search results
  ^
 * History:		NONE
  ^
 */
defined('_JEXEC') or die('Restricted access');
$document = JFactory::getDocument();
JHTML::_('behavior.formvalidation');
if (JVERSION < 3) {
    JHtml::_('behavior.mootools');
    $document->addScript('components/com_jsjobs/js/jquery.js');
} else {
    JHtml::_('behavior.framework');
    JHtml::_('jquery.framework');
}


$link = 'index.php?option=com_jsjobs&c=job&view=job&layout=job_searchresults&Itemid=' . $this->Itemid;
?>


<!--SonDang search options added 26/05/2015-->        
<!--Search options-->
<div id="js_main_wrapper">
    <span class="js_controlpanel_section_title">Search Job</span>
    <form action="<?php echo JRoute::_('index.php?option=com_jsjobs&c=job&view=job&layout=job_searchresults&Itemid='. $this->Itemid); ?>" method="post" name="adminForm" id="adminForm" class="jsautoz_form" >
        <input type="hidden" name="isjobsearch" value="1" />
            <div class="fieldwrapper">
                <div class="fieldtitle">
                    <?php echo JText::_('JS_JOB_TITLE'); ?>
                </div>
                <div class="fieldvalue">
                    <input class="inputbox" type="text" name="title" size="40" maxlength="255"  />
                </div>
            </div>
            <div class="fieldwrapper">
                <div class="fieldtitle">
                    <?php echo JText::_('JS_CATEGORIES'); ?>
                </div>
                <div class="fieldvalue">
                    <?php echo $this->job_options[0]['jobcategory']; ?>
                </div>
            </div>
             <div class="fieldwrapper">
                    <div class="fieldtitle">
                        <?php echo JText::_('JS_SUB_CATEGORIES'); ?>
                    </div>
                    <div class="fieldvalue" id="fj_subcategory">
                        <?php echo $this->job_options[0]['jobsubcategory']; ?>
                    </div>
            </div>
            <div class="fieldwrapper">
                    <div class="fieldtitle">
                        <?php echo JText::_('JS_JOBTYPE'); ?>
                    </div>
                    <div class="fieldvalue">
                        <?php echo $this->job_options[0]['jobtype']; ?>
                    </div>
            </div>
            <div class="fieldwrapper">
                    <div class="fieldtitle">
                        <?php echo JText::_('JS_JOBSTATUS'); ?>
                    </div>
                    <div class="fieldvalue">
                        <?php echo $this->job_options[0]['jobstatus']; ?>
                    </div>
            </div>
            <div class="fieldwrapper">
                    <div class="fieldtitle">
                        <?php echo JText::_('JS_COMPANYNAME'); ?>
                    </div>
                    <div class="fieldvalue">
                        <?php echo $this->job_options[0]['companies']; ?>
                    </div>
            </div>
            <div class="fieldwrapper">
                    <input type="submit" id="button" class="button" name="submit_app" onClick="return checkmapcooridnate();" value="<?php echo JText::_('JS_SEARCH_JOB'); ?>" />
            </div>				        

		<input type="hidden" name="view" value="job" />
                <input type="hidden" name="layout" value="job_searchresults" />
		<input type="hidden" name="uid" value="<?php echo $this->uid; ?>" />
		<input type="hidden" name="option" value="<?php echo $this->option; ?>" />
		<input type="hidden" name="task11" value="view" />
    </form>
</div>  
<!--End Search options-->


<?php 
    require_once( 'jobapply.php' );
if ($this->config['offline'] == '1') { ?>
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
    <script language="javascript">
        function myValidate(f) {
            if (document.formvalidator.isValid(f)) {
            }
            else {
                alert('Search name is not acceptable.  Please retry.');
                return false;
            }
            return true;
        }

    </script>
    <?php
    if ($this->application) {

        if (isset($this->userrole->rolefor)) {
            if ($this->userrole->rolefor != '') {
                if ($this->userrole->rolefor == 2) // job seeker
                    $allowed = true;
                elseif ($this->userrole->rolefor == 1) {
                    if ($this->config['employerview_js_controlpanel'] == 1)
                        $allowed = true;
                    else
                        $allowed = false;
                }
            }else {
                $allowed = true;
            }
        } else
            $allowed = true; // user not logined
        if ($allowed == true) {

            if ($this->sortlinks['sortorder'] == 'ASC')
                $img = "components/com_jsjobs/images/sort0.png";
            else
                $img = "components/com_jsjobs/images/sort1.png";
            ?>
    <div id="js_main_wrapper">
        <span class="js_controlpanel_section_title"><?php echo JText::_('JS_JOB_SEARCH_RESULT'); ?></span>
        <?php
            if ($this->canview == 1) {
                if ($this->searchjobconfig['search_job_showsave'] == 1) {
                    if (($this->uid) && ($this->userrole->rolefor)) { ?>
                        <div id="savesearch_form">
                            <form action="index.php" method="post" name="adminForm" id="adminForm" onsubmit="return myValidate(this);">
                                <div class="js_label">
                                    <?php echo JText::_('JS_SAVE_THIS_SEARCH'); ?>
                                </div>
                                <div class="js_input_field">
                                    <input class="inputbox required" type="text" name="searchname" size="20" maxlength="30"  />
                                </div>
                                <div class="js_button_field">
                                    <input type="submit" id="button" class="button validate" value="<?php echo JText::_('JS_SAVE'); ?>">
                                </div>
                                <input type="hidden" name="option" value="<?php echo $this->option; ?>" />
                                <input type="hidden" name="task" value="savejobsearch" />
                                <input type="hidden" name="c" value="jobsearch" />
                            </form>	
                        </div>
            <?php }
                }
            } ?>
            <div id="sortbylinks">
                <?php if ($this->listjobconfig['lj_title'] == '1') { ?>				
                    <span class="my_job_sbl_links"><a class="<?php if ($this->sortlinks['sorton'] == 'title') echo 'selected'; ?>" href="<?php echo $link ?>&sortby=<?php echo $this->sortlinks['title']; ?>"><?php echo JText::_('JS_TITLE'); ?><?php if ($this->sortlinks['sorton'] == 'title') { ?> <img src="<?php echo $img ?>"> <?php } ?></a></span>
                <?php }
                if ($this->listjobconfig['lj_category'] == '1') {
                    ?>	
                    <span class="my_job_sbl_links"><a class="<?php if ($this->sortlinks['sorton'] == 'category') echo 'selected'; ?>" href="<?php echo $link ?>&sortby=<?php echo $this->sortlinks['category']; ?>"><?php echo JText::_('JS_CATEGORY'); ?><?php if ($this->sortlinks['sorton'] == 'category') { ?> <img src="<?php echo $img ?>"> <?php } ?></a></span>
                <?php }
                if ($this->listjobconfig['lj_jobtype'] == '1') {
                    ?>	
                    <span class="my_job_sbl_links"><a class="<?php if ($this->sortlinks['sorton'] == 'jobtype') echo 'selected'; ?>" href="<?php echo $link ?>&sortby=<?php echo $this->sortlinks['jobtype']; ?>"><?php echo JText::_('JS_JOBTYPE'); ?><?php if ($this->sortlinks['sorton'] == 'jobtype') { ?> <img src="<?php echo $img ?>"> <?php } ?></a></span>
                <?php }
                if ($this->listjobconfig['lj_jobstatus'] == '1') {
                    ?>	
                    <span class="my_job_sbl_links"><a class="<?php if ($this->sortlinks['sorton'] == 'jobstatus') echo 'selected'; ?>" href="<?php echo $link ?>&sortby=<?php echo $this->sortlinks['jobstatus']; ?>"><?php echo JText::_('JS_JOBSTATUS'); ?><?php if ($this->sortlinks['sorton'] == 'jobstatus') { ?> <img src="<?php echo $img ?>"> <?php } ?></a></span>
                <?php }
                if ($this->listjobconfig['lj_company'] == '1') {
                    ?>
                    <span class="my_job_sbl_links"><a class="<?php if ($this->sortlinks['sorton'] == 'company') echo 'selected'; ?>" href="<?php echo $link ?>&sortby=<?php echo $this->sortlinks['company']; ?>"><?php echo JText::_('JS_COMPANY'); ?><?php if ($this->sortlinks['sorton'] == 'company') { ?> <img src="<?php echo $img ?>"> <?php } ?></a></span>
            <?php
            }
            if ($this->listjobconfig['lj_salary'] == '1') {
                ?>	
                    <span class="my_job_sbl_links"><a class="<?php if ($this->sortlinks['sorton'] == 'salaryrange') echo 'selected'; ?>" href="<?php echo $link ?>&sortby=<?php echo $this->sortlinks['salaryrange']; ?>"><?php echo JText::_('JS_SALARY_RANGE'); ?><?php if ($this->sortlinks['sorton'] == 'salaryrange') { ?> <img src="<?php echo $img ?>"> <?php } ?></a></span>
            <?php }
            if ($this->listjobconfig['lj_created'] == '1') {
                ?>	
                    <span class="my_job_sbl_links"><a class="<?php if ($this->sortlinks['sorton'] == 'created') echo 'selected'; ?>" href="<?php echo $link ?>&sortby=<?php echo $this->sortlinks['created']; ?>"><?php echo JText::_('JS_DATEPOSTED'); ?><?php if ($this->sortlinks['sorton'] == 'created') { ?> <img src="<?php echo $img ?>"> <?php } ?></a></span>
                    <?php } ?>
            </div>
            <?php
                    $days = $this->config['newdays'];
                    $isnew = date("Y-m-d H:i:s", strtotime("-$days days"));
                    //for Gold Job
                    if (isset($this->goldjobs) && !empty($this->goldjobs)) {
                        foreach ($this->goldjobs as $job) {
                            $comma = "";
                            print_job($job,$this,$isnew,2);
                        }
                    }
                    //for Featured Job
                    if (isset($this->featuredjobs) && !empty($this->featuredjobs)) {
                        foreach ($this->featuredjobs as $job) {
                            $comma = "";
                            print_job($job,$this,$isnew,3);
                        }
                    }
                    if (isset($this->application)) {
                        foreach ($this->application as $job) {
                            $comma = "";
                            print_job($job,$this,$isnew,1);
                        }
            }
            ?>

            <form action="<?php echo JRoute::_('index.php?option=com_jsjobs&c=job&view=job&layout=job_searchresults&Itemid=' . $this->Itemid); ?>" method="post">
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
            <?php } else { // not allowed job posting 
            ?>
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
    ?>	


    <script language="javascript">
        showsavesearch(0);
    </script>
    <?php
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
                    <?php $link = 'index.php?option=com_jsjobs&c=job&view=job&layout=view_job&nav=17&bd='.$job->jobaliasid.'&Itemid='.$thisjob->Itemid; ?>
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
                            if($thisjob->isjobsharing){
                                $imgsrc = $job->companylogo;
                                
                            }else{
                                $imgsrc = $thisjob->config['data_directory'].'/data/employer/comp_'.$job->companyid.'/logo/'.$job->companylogo;
                                
                            }
                        }else{
                            $imgsrc = 'components/com_jsjobs/images/blank_logo.png';
                        } 
                    ?>
                    <img class="js_job_image" src="<?php echo $imgsrc; ?>" />
                </div>
                <div class="js_job_quick_view_wrapper">
                </div>
            </div>
            <div class="js_job_data_area">
                <div class="js_job_data_2">
                    <?php if($thisjob->listjobconfig['lj_company'] == '1') { ?>
                            <div class="js_job_data_2_wrapper">
                                <?php if($thisjob->config['labelinlisting'] == '1'){ ?>
                                    <span class="js_job_data_2_title"><?php echo JText::_('JS_COMPANY').":"; ?></span>
                                <?php }
                                $link = 'index.php?option=com_jsjobs&c=company&view=company&layout=view_company&nav=33&cd='.$job->companyaliasid.'&cat='.$job->jobcategory.'&Itemid='.$thisjob->Itemid; 
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
                                <span class="js_job_data_2_value"><?php echo $job->jobtypetitle;if($thisjob->listjobconfig['lj_jobstatus'] == '1') echo ' - '.$job->jobstatustitle; ?></span>
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