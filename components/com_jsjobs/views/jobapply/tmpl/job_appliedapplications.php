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
 * File Name:	views/employer/tmpl/job_appliedapplications.php
  ^
 * Description: template view for my job applied application
  ^
 * History:		NONE
  ^
 */
defined('_JEXEC') or die('Restricted access');
JHTML::_('behavior.formvalidation');
$document = JFactory::getDocument();
if (JVERSION < 3) {
    JHtml::_('behavior.mootools');
    $document->addScript('components/com_jsjobs/js/jquery.js');
} else {
    JHtml::_('behavior.framework');
    JHtml::_('jquery.framework');
}


?>
<!--<div id="jsjobs_main">-->
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
    if (isset($this->userrole->rolefor) && $this->userrole->rolefor == 1) {  // employer
        ?>
    <div id="js_main_wrapper">
        <span class="js_controlpanel_section_title">
            <?php echo JText::_('JS_JOB') . "&nbsp;[" . $this->jobtitle . "]" . '&nbsp;&nbsp' . JText::_('APPLICATION_APPLIED');?>
            <?php 
                if(isset($this->resume[0])){ ?>
                    <span class="js_apply_view_job">
                        <?php echo JText::_('JS_JOB_VIEW')." : ".$this->resume[0]->jobview." / ".JText::_('JS_APPLIED')." : ".$this->resume[0]->totalapply;?>
                    </span>
                <?php } ?>
        </span>
        <form action="index.php" method="post" name="adminForm" id="appliedAdminForm" >
            <?php
                if ($this->sortlinks['sortorder'] == 'ASC')
                    $img = "components/com_jsjobs/images/sort0.png";
                else
                    $img = "components/com_jsjobs/images/sort1.png";
                $link = 'index.php?option=com_jsjobs&c=jobapply&view=jobapply&layout=job_appliedapplications&bd=' . $this->jobaliasid . '&ta=' . $this->tabaction . '&Itemid=' . $this->Itemid;
            ?>
            <div id="sortbylinks">
                <span class="job_applied_resume_sbl_links"><a href="<?php echo $link ?>&sortby=<?php echo $this->sortlinks['name']; ?>" class="<?php if ($this->sortlinks['sorton'] == 'name') echo 'selected' ?>"><?php echo JText::_('JS_NAME'); ?><?php if ($this->sortlinks['sorton'] == 'name') { ?> <img src="<?php echo $img ?>"> <?php } ?></a></span>
                <span class="job_applied_resume_sbl_links"><a href="<?php echo $link ?>&sortby=<?php echo $this->sortlinks['category']; ?>" class="<?php if ($this->sortlinks['sorton'] == 'category') echo 'selected' ?>"><?php echo JText::_('JS_CATEGORY'); ?><?php if ($this->sortlinks['sorton'] == 'category') { ?> <img src="<?php echo $img ?>"> <?php } ?></a></span>
                <span class="job_applied_resume_sbl_links"><a href="<?php echo $link ?>&sortby=<?php echo $this->sortlinks['gender']; ?>" class="<?php if ($this->sortlinks['sorton'] == 'gender') echo 'selected' ?>"><?php echo JText::_('JS_GENDER'); ?><?php if ($this->sortlinks['sorton'] == 'gender') { ?> <img src="<?php echo $img ?>"> <?php } ?></a></span>
                <span class="job_applied_resume_sbl_links"><a href="<?php echo $link ?>&sortby=<?php echo $this->sortlinks['available']; ?>" class="<?php if ($this->sortlinks['sorton'] == 'available') echo 'selected' ?>"><?php echo JText::_('JS_AVAILABLE'); ?><?php if ($this->sortlinks['sorton'] == 'available') { ?> <img src="<?php echo $img ?>"> <?php } ?></a></span>
                <span class="job_applied_resume_sbl_links"><a href="<?php echo $link ?>&sortby=<?php echo $this->sortlinks['jobsalaryrange']; ?>" class="<?php if ($this->sortlinks['sorton'] == 'jobsalaryrange') echo 'selected' ?>"><?php echo JText::_('JS_SALARY'); ?><?php if ($this->sortlinks['sorton'] == 'jobsalaryrange') { ?> <img src="<?php echo $img ?>"> <?php } ?></a></span>
                <span class="job_applied_resume_sbl_links"><a href="<?php echo $link ?>&sortby=<?php echo $this->sortlinks['education']; ?>" class="<?php if ($this->sortlinks['sorton'] == 'education') echo 'selected' ?>"><?php echo JText::_('JS_EDUCATION'); ?><?php if ($this->sortlinks['sorton'] == 'education') { ?> <img src="<?php echo $img ?>"> <?php } ?></a></span>
                <span class="job_applied_resume_sbl_links"><a href="<?php echo $link ?>&sortby=<?php echo $this->sortlinks['total_experience']; ?>" class="<?php if ($this->sortlinks['sorton'] == 'total_experience') echo 'selected' ?>"><?php echo JText::_('JS_EXPERIENCE'); ?><?php if ($this->sortlinks['sorton'] == 'total_experience') { ?> <img src="<?php echo $img ?>"> <?php } ?></a></span>
                <span class="job_applied_resume_sbl_links"><a href="<?php echo $link ?>&sortby=<?php echo $this->sortlinks['apply_date']; ?>" class="<?php if ($this->sortlinks['sorton'] == 'apply_date') echo 'selected' ?>"><?php echo JText::_('JS_APPLIED_DATE'); ?><?php if ($this->sortlinks['sorton'] == 'apply_date') { ?> <img src="<?php echo $img ?>"> <?php } ?></a></span>
            </div>
            <div id="jsjobs_appliedapplication_tab_container">
                <a  onclick="tabaction(<?php echo $this->jobid; ?>, '1')" class='<?php if ($this->tabaction == 1) echo 'selected'; ?>'>
                    <?php echo JText::_('JS_INBOX'); ?>
                </a>
                <div id="jsjobs_appliedresume_action_allexport">
                            <?php $exportalllink = 'index.php?option=com_jsjobs&task=exportresume.exportallresume&bd=' . $this->jobaliasid; ?>
                    <a href="<?php echo $exportalllink; ?>" >
                        <span id="jsjobs_appliedresume_action_allexport_text" ><?php echo JText::_('JS_ALL_EXPORT'); ?></span>		
                    </a>

                </div>
            </div>	
            <div id="jsjobs_appliedresume_tab_search" style="display: none;">
                <div id="jsjobs_appliedresume_tab_search_data">
                    <span class="jsjobs_appliedresume_tab_search_data_text">
                        <div class="field">
                            <span class="jsjobs_appliedresume_tab_search_data_title">
                                <?php echo JText::_('JS_APPLICATION_TITLE') . ":"; ?>
                            </span>
                            <span class="jsjobs_appliedresume_tab_search_data_value">
                                <input class="inputbox" type="text" name="title" size="20" maxlength="255"  />
                            </span>
                        </div>
                        <div class="field">
                            <span class="jsjobs_appliedresume_tab_search_data_title">
                                <?php echo JText::_('JS_NAME') . ":"; ?>
                            </span>
                            <span class="jsjobs_appliedresume_tab_search_data_value">
                                <input class="inputbox" type="text" name="name" size="20" maxlength="255"  />
                            </span>
                        </div>
                        <div class="field">
                            <span class="jsjobs_appliedresume_tab_search_data_title">
                                <?php echo JText::_('JS_EXPERIENCE') . ":"; ?>
                            </span>
                            <span class="jsjobs_appliedresume_tab_search_data_value">
                                <input class="inputbox" type="text" name="experience" size="20" maxlength="15"  />
                            </span>
                        </div>
                    </span>
                    <span class="jsjobs_appliedresume_tab_search_data_text">
                        <div class="field">
                            <span class="jsjobs_appliedresume_tab_search_data_title">
                                <?php echo JText::_('JS_NATIONALITY') . ":"; ?>
                            </span>
                            <span class="jsjobs_appliedresume_tab_search_data_value">
                                <?php echo $this->searchoptions['nationality']; ?>
                            </span>
                        </div>
                        <div class="field">
                            <span class="jsjobs_appliedresume_tab_search_data_title">
                                <?php echo JText::_('JS_CATEGORIES') . ":"; ?>
                            </span>
                            <span class="jsjobs_appliedresume_tab_search_data_value">
                                <?php echo $this->searchoptions['jobcategory']; ?>
                            </span>
                        </div>
                        <div class="field">
                            <span class="jsjobs_appliedresume_tab_search_data_title">
                                <?php echo JText::_('JS_SUB_CATEGORIES') . ":"; ?>
                            </span>
                            <span id="fj_subcategory" class="jsjobs_appliedresume_tab_search_data_value">
                                <?php echo $this->searchoptions['jobsubcategory']; ?>
                            </span>
                        </div>
                    </span>
                    <span class="jsjobs_appliedresume_tab_search_data_text">
                        <div class="field">
                            <span class="jsjobs_appliedresume_tab_search_data_title">
                                <?php echo JText::_('JS_GENDER') . ":"; ?>
                            </span>
                            <span class="jsjobs_appliedresume_tab_search_data_value">
                                <?php echo $this->searchoptions['gender']; ?>
                            </span>
                        </div>
                        <div class="field">
                            <span class="jsjobs_appliedresume_tab_search_data_title">
                                <?php echo JText::_('JS_JOBTYPE') . ":"; ?>
                            </span>
                            <span class="jsjobs_appliedresume_tab_search_data_value">
                                <?php echo $this->searchoptions['jobtype']; ?>
                            </span>
                        </div>
                        <div class="field">
                            <span class="jsjobs_appliedresume_tab_search_data_title">
                                <?php echo JText::_('JS_SALARYRANGE') . ":"; ?>
                            </span>
                            <span class="jsjobs_appliedresume_tab_search_data_value">
                                <?php echo $this->searchoptions['currency']; ?><?php echo $this->searchoptions['jobsalaryrange']; ?>
                            </span>
                        </div>
                    </span>
                    <span class="jsjobs_appliedresume_tab_search_data_text">
                        <div class="field">
                            <span class="jsjobs_appliedresume_tab_search_data_title">
                                <?php echo JText::_('JS_HEIGHTESTFINISHEDEDUCATION') . ":"; ?>
                            </span>
                            <span class="jsjobs_appliedresume_tab_search_data_value">
                                <?php echo $this->searchoptions['heighestfinisheducation']; ?>
                            </span>
                        </div>
                        <div class="field">
                            <span class="jsjobs_appliedresume_tab_search_data_title">
                                <?php echo JText::_('JS_I_AM_AVAILABLE') . ":"; ?>
                            </span>
                            <span class="jsjobs_appliedresume_tab_search_data_value">
                                <span style='text-align:center;font-size:11px;padding-left:19%'><?php echo JText::_('JS_YES'); ?></span><input type="radio" name="iamavailable" value="yes" class="radio" <?php if (isset($_POST['iamavailable']) && $_POST['iamavailable'] == 'yes'): ?>checked='checked'<?php endif; ?> /> 
                                <span style='text-align:center;font-size:11px;'><?php echo JText::_('JS_NO'); ?></span><input type="radio" name="iamavailable" value="no"  class="radio" <?php if (isset($_POST['iamavailable']) && $_POST['iamavailable'] == 'no'): ?>checked='checked'<?php endif; ?> /> 					
                            </span>
                        </div>
                        <div class="field">
                            <input type="submit" id="button" class="button" name="submit_app" onclick="jobappliedresumesearch(<?php echo $this->jobid; ?>, '6');" value="<?php echo JText::_('JS_SEARCH_RESUME'); ?>" />
                            <input type="button" id="button" class="button" name="submit_app" onclick="closetabsearch('#jsjobs_appliedresume_tab_search')" value="<?php echo JText::_('JS_CLOSE'); ?>" />
                        </div>
                    </span>
                </div>	
            </div>
        <?php
        if (isset($this->resume)) {
            foreach ($this->resume as $app) { ?>
                <div class="js_job_main_wrapper" id="jsjobs_appliedresume_data_action_message_<?php echo $app->jobapplyid; ?>">
                        <div class="js_job_image_area">
                            <div class="js_job_image_wrapper mycompany">
                                <?php 
                                    $imgsrc = "components/com_jsjobs/images/jsjobs_logo.png";
                                    if (isset($app->photo) && $app->photo!="") {
                                        if ($this->isjobsharing) {
                                            $imgsrc = $app->photo;
                                        } else {
                                            $imgsrc = $this->config['data_directory']."/data/jobseeker/resume_".$app->appid . '/photo/' . $app->photo;
                                        }
                                    } 
                                ?>
                                <img class="js_job_image" src="<?php echo $imgsrc; ?>" />
                            </div>
                            <?php $link = 'index.php?option=com_jsjobs&c=resume&view=resume&layout=view_resume&nav=2&rd=' . $app->resumealiasid . '&bd=' . $app->jobaliasid . '&sortby=' . $this->sortby . '&ta=' . $this->tabaction . '&Itemid=' . $this->Itemid; ?> 
                            <a class="view_resume_button" href="<?php echo $link ?>"><?php echo JText::_('JS_VIEW_RESUME'); ?></a>
                        </div>
                        <div class="js_job_data_area">
                            <div class="js_job_data_1 mycompany">
                                <span class="js_job_title">
                                    <?php echo $app->applicationtitle; ?><br/>
                                    <span class="resume_title_sub_heading" >
                                    <?php echo "( " . JText::_('JS_RESUME_TITLE') . " )"; ?>
                                    </span>
                                </span>
                                <span class="js_job_posted">
                                    <div style='display:block;margin-right: 5px;'>
                                    </div>
                                    <?php echo JText::_('JS_APPLIED_DATE') . ":"; ?>
                                    <span class="resume_applied_sub_heading" > 
                                    <?php echo date($this->config['date_format'], strtotime($app->apply_date)); ?>
                                </span>                                
                            </div>
                            <div class="js_job_data_2 myresume first-child">
                                <div class="js_job_data_2_wrapper">
                                    <span class="js_job_data_2_title"><?php echo JText::_('JS_GENDER') . ":"; ?></span>
                                    <span class="js_job_data_2_value"><?php echo ($app->gender == 1) ? JText::_('JS_MALE') : JText::_('JS_FEMALE'); ?></span>
                                </div>
                                <div class="js_job_data_2_wrapper">
                                    <span class="js_job_data_2_title"><?php echo JText::_('JS_AVAILABLE') . ":"; ?></span>
                                    <span class="js_job_data_2_value"><?php echo ($app->iamavailable == 1) ? JText::_('JS_YES') : JText::_('JS_NO'); ?></span>
                                </div>
                                <div class="js_job_data_2_wrapper">
                                    <span class="js_job_data_2_title"><?php echo JText::_('JS_CATEGORY') . ":"; ?></span>
                                    <span class="js_job_data_2_value"><?php echo $app->cat_title; ?></span>
                                </div>
                                <div class="js_job_data_2_wrapper">
                                    <span class="js_job_data_2_title"><?php echo JText::_('JS_EDUCATION') . ":"; ?></span>
                                    <span class="js_job_data_2_value"><?php echo $app->education; ?></span>
                                </div>
                            </div>
                            <div class="js_job_data_2 myresume">
                                <div class="js_job_data_2_wrapper">
                                    <span class="js_job_data_2_title"><?php echo JText::_('JS_TOTAL_EXPERIENCE') . ":"; ?></span>
                                    <span class="js_job_data_2_value"><?php echo $app->total_experience; ?></span>
                                </div>
                                <div class="js_job_data_2_wrapper">
                                    <span class="js_job_data_2_title"><?php echo JText::_('JS_CURRENT_SALARY') . ":"; ?></span>
                                    <span class="js_job_data_2_value"><?php echo $app->symbol . $app->rangestart . ' - ' . $app->symbol . ' ' . $app->rangeend; ?></span>
                                </div>
                                <div class="js_job_data_2_wrapper">
                                    <span class="js_job_data_2_title"><?php echo JText::_('JS_EXPECTED_SALARY') . ":"; ?></span>
                                    <span class="js_job_data_2_value"><?php echo $app->dsymbol . $app->drangestart . ' - ' . $app->dsymbol . ' ' . $app->drangeend; ?></span>
                                </div>
                                <div class="js_job_data_2_wrapper">
                                    <span class="js_job_data_2_title"><?php echo JText::_('JS_LOCATION') . ":&nbsp;"; ?></span>
                                    <span class="js_job_data_2_value">
                                        <?php
                                        $comma = "";
                                        if ($app->cityname) {
                                            echo $app->cityname;
                                            $comma = 1;
                                        } elseif ($app->address_city) {
                                            echo $app->address_city;
                                            $comma = 1;
                                        }
                                        if ($app->statename) {
                                            if ($comma)
                                                echo', '; echo $app->statename;
                                            $comma = 1;
                                        }
                                        elseif ($app->address_state) {
                                            if ($comma)
                                                echo', '; echo $app->address_state;
                                            $comma = 1;
                                        }
                                        if ($app->countryname) {
                                            if ($comma)
                                                echo', '; echo $app->countryname;
                                            $comma = 1;
                                        }
                                        ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div style="display:inline-block;width:100%;" id="resumeaction_<?php echo $app->jobapplyid; ?>"></div>
                    </div>            
                <?php
            }
        }
        ?>
            <input type="hidden" name="task" id="task" value="saveshortlistcandiate" />
            <input type="hidden" name="c"  value="jobapply" />
            <input type="hidden" name="Itemid" id="Itemid" value="<?php echo $this->Itemid; ?>" />
            <input type="hidden" name="jobid" id="jobid" value="<?php echo $this->jobid; ?>" />
            <input type="hidden" name="resumeid" id="resumeid" value="<?php echo $app->appid; ?>" />
            <input type="hidden" name="id" id="id" value="" />
            <input type="hidden" name="action" id="action" value="" />
            <input type="hidden" name="action_status" id="action_status" value="<?php echo $this->tabaction; ?>" />

            <input type="hidden" name="tab_action" id="tab_action" value="" />
            <input type="hidden" name="view" id="view" value="employer" />
            <input type="hidden" name="layout" id="layout" value="job_appliedapplications" />
            <input type="hidden" name="option" value="<?php echo $this->option; ?>" />

        </form>
        <form action="<?php echo JRoute::_('index.php?option=com_jsjobs&c=jobapply&view=jobapply&layout=job_appliedapplications&bd=' . $this->jobaliasid . '&ta=' . $this->tabaction . '&Itemid=' . $this->Itemid); ?>" method="post">
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
