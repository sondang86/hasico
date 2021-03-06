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
 * File Name:	views/employer/tmpl/mycompanies.php
 ^ 
 * Description: template view for my companies
 ^ 
 * History:		NONE
 ^ 
 */
 
 defined('_JEXEC') or die('Restricted access');
?>
<script language=Javascript>
    function confirmdeletecompany(){
        return confirm("<?php echo JText::_('JS_ARE_YOU_SURE_DELETE_THE_COMPANY'); ?>");
    }
</script>
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
if($this->mycompany_allowed == VALIDATE){
if ($this->companies){
?>
    <div id="js_main_wrapper">
        <span class="js_controlpanel_section_title"><?php echo JText::_('JS_MY_COMPANIES');?></span>
        <form action="index.php" method="post" name="adminForm">
        <?php 
            foreach($this->companies AS $company){
                $g_f_company = 0;
        ?>
        <div class="js_job_main_wrapper">
            <div class="js_job_image_area">
                <div class="js_job_image_wrapper mycompany">
                    <?php
                        if(!empty($company->logofilename)){
                            $imgsrc = $this->config['data_directory'].'/data/employer/comp_'.$company->id.'/logo/'.$company->logofilename;
                        }else{
                            $imgsrc = 'components/com_jsjobs/images/blank_logo.png';
                        } 
                    ?>
                    <img class="js_job_image" src="<?php echo $imgsrc; ?>" />
                </div>
            </div>
            <div class="js_job_data_area">
                <div class="js_job_data_1 mycompany">
                    <span class="js_job_title"><?php echo $company->name;?></span>
                    <span class="js_job_posted"><?php echo JText::_('JS_CREATED').': '.date($this->config['date_format'],  strtotime($company->created)); ?></span>
                </div>
                <div class="js_job_data_2">
                    <div class='js_job_data_2_wrapper'>
                        <span class="js_job_data_2_title"><?php echo JText::_('JS_CATEGORY').":"; ?></span>
                        <span class="js_job_data_2_value"><?php echo  $company->cat_title; ?></span>
                    </div>
                    <div class="js_job_data_2_wrapper">
                        <span class="js_job_data_2_title"><?php echo JText::_('JS_STATUS').":"; ?></span>
                        <span class="js_job_data_2_value"><?php if ($company->status == 1) echo '<font color="green">'.JText::_('JS_APPROVED').'</font>'; elseif ($company->status == 0) {echo '<span class="jobstatusmsg"> '. JText::_('JS_PENDDING'). '</span>';} elseif ($company->status == -1) echo '<font color="red"> '. JText::_('JS_REJECTED'). '</font>'; ?></span>
                    </div>
                </div>
                <div class="js_job_data_3 mycompany">
                    <span class="js_job_data_location_title"><?php echo JText::_('JS_LOCATION'); ?>:&nbsp;</span>
                    <?php 
                            if(isset($company->city) AND  !empty($company->city)) { ?>
                                <span class="js_job_data_location_value">
                                <?php 
                                    if(strlen($company->multicity) > 35){
                                        echo JText::_('JS_MULTI_CITY').$company->city;
                                    }else{ 
                                        echo $company->cityname;
                                    }
                                ?>
                                    </span>
                            <?php }		
                    ?>
                </div>
                <div class="js_job_data_4 mycompany">
                    <a class="company_icon" href="index.php?option=com_jsjobs&c=company&view=company&layout=formcompany&cd=<?php echo $company->aliasid."&Itemid=".$this->Itemid; ?>"  title="<?php echo JText::_('JS_EDIT'); ?>">
                        <img class="icon" width="15" height="15" src="components/com_jsjobs/images/edit.png" />
                    </a>                    
                    <?php 
                        $companyid = ($this->isjobsharing != "")?$company->saliasid:$company->aliasid;
                        $com_view_link="index.php?option=com_jsjobs&c=company&view=company&layout=view_company&nav=31&cd=".$companyid."&Itemid=".$this->Itemid;
                    ?>
                    <a class="company_icon" href="<?php echo $com_view_link; ?>"  title="<?php echo JText::_('JS_VIEW'); ?>">
                        <img class="icon"width="15" height="15" src="components/com_jsjobs/images/view.png" />
                    </a>
                    <a class="company_icon" href="index.php?option=com_jsjobs&task=company.deletecompany&cd=<?php echo $company->aliasid; ?>&Itemid=<?php echo $this->Itemid;?>" onclick=" return confirmdeletecompany();"  title="<?php echo JText::_('JS_DELETE'); ?>">
                        <img class="icon"width="15" height="15" src="components/com_jsjobs/images/delete.png" />
                    </a>
                </div>
            </div>
        </div>    
    <?php    
        }
    ?>
            <input type="hidden" name="option" value="<?php echo $this->option; ?>" />
            <input type="hidden" name="task" value="deletecompany" />
            <input type="hidden" name="c" value="company" />
            <input type="hidden" id="id" name="id" value="" />
	</form>
    </div>

<form action="<?php echo JRoute::_('index.php?option=com_jsjobs&c=company&view=company&layout=mycompanies&Itemid='.$this->Itemid); ?>" method="post">
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
    switch($this->mycompany_allowed){
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
        case VISITOR_NOT_ALLOWED_EMPLOYER_PRIVATE_AREA: ?>
            <div class="js_job_error_messages_wrapper">
                <div class="js_job_messages_image_wrapper">
                    <img class="js_job_messages_image" src="components/com_jsjobs/images/4.png"/>
                </div>
                <div class="js_job_messages_data_wrapper">
                    <span class="js_job_messages_main_text">
                        <?php echo JText::_('JS_VISITOR_NOT_ALLOWED'); ?>
                    </span>
                    <span class="js_job_messages_block_text">
                        <?php echo JText::_('JS_VISITOR_NOT_ALLOWED_EMPLOYER_PRIVATE_AREA'); ?>
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
}  //ol
?>	
<!--<div id="jsjobs_footer">-->
    <?php // echo '<table width="100%" style="table-layout:fixed;"> <tr><td height="15"></td></tr> <tr><td style="vertical-align:top;" align="center"> <a class="img" target="_blank" href="http://www.joomsky.com"><img src="http://www.joomsky.com/logo/jsjobscrlogo.png"></a> <br> Copyright &copy; 2008 - '.date('Y').', <span id="themeanchor"> <a class="anchor"target="_blank" href="http://www.joomsky.com">Joom Sky</a></span></td></tr> </table></div>';?>
<!--</div>-->
<?php 
$document = JFactory::getDocument();
$document->addScript('components/com_jsjobs/js/canvas_script.js');
?>