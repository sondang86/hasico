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
 * File Name:	views/employer/tmpl/viewjob.php
 ^ 
 * Description: template view for a company
 ^ 
 * History:		NONE
 ^ 
 */
 
defined('_JEXEC') or die('Restricted access');
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
<?php if(isset($this->company)){ ?>
    <div id="js_main_wrapper">
        <span class="js_controlpanel_section_title"><?php echo JText::_('JS_COMPANY_INFO');?></span>
        <span class="js_job_title">
            <?php echo $this->company->name; ?>
        </span><br/><br/>
        <div class="js_job_company_logo">
            <?php 
                $logourl = 'components/com_jsjobs/images/blank_logo.png';
                if(!empty($this->company->companylogo)){
                    if($this->isjobsharing){
                        $logourl = $this->company->companylogo;
                    }else{
                        $logourl = $this->config['data_directory'].'/data/employer/comp_'.$this->company->id.'/logo/'.$this->company->companylogo;
                    }
                }
            ?>
            <img class="js_job_company_logo" src="<?php echo $logourl; ?>" />
        </div>
        <div class="js_job_company_data">
            <?php 		
                if ($this->company->url) {
                    if($this->config['comp_show_url'] == 1) { ?>
                        <div class="js_job_data_wrapper">
                            <span class="js_job_data_title"><?php echo JText::_('JS_URL'); ?></span>
                            <span class="js_job_data_value">
                                <a class="js_job_company_anchor" target="_blank" href="<?php echo $this->company->url;?>">
                                    <?php echo $this->company->url;?>
                                </a>
                            </span>
                        </div>
            <?php
                    }
                }
                if ($this->config['comp_name'] == 1) { ?>
                        <div class="js_job_data_wrapper">
                            <span class="js_job_data_title"><?php echo JText::_('JS_CONTACTNAME'); ?></span>
                            <span class="js_job_data_value">
                                <?php echo $this->company->contactname; ?>
                            </span>
                        </div>
                <?php
                }
                if ($this->config['comp_email_address'] == 1) { ?>
                        <div class="js_job_data_wrapper">
                            <span class="js_job_data_title"><?php echo JText::_('JS_CONTACTEMAIL'); ?></span>
                            <span class="js_job_data_value">
                                <?php echo $this->company->contactemail; ?>
                            </span>
                        </div>
                <?php
                } ?>
            <div class="js_job_data_wrapper">
                <span class="js_job_data_title"><?php echo JText::_('JS_CONTACTPHONE'); ?></span>
                <span class="js_job_data_value">
                    <?php echo $this->company->contactphone; ?>
                </span>
            </div>
            <div class="js_job_data_wrapper">
                <span class="js_job_data_title"><?php echo JText::_('JS_SINCE'); ?></span>
                <span class="js_job_data_value"><?php echo date($this->config['date_format'],strtotime($this->company->since));?></span>
            </div>
        </div>
        <?php
        if ($this->company->address1) { ?>
            <div class="js_job_data_wrapper">
                <span class="js_job_data_title"><?php echo JText::_('JS_ADDRESS1'); ?></span>
                <span class="js_job_data_value"><?php echo $this->company->address1;?></span>
            </div>
        <?php
        }
        if ($this->company->address2) { ?>
            <div class="js_job_data_wrapper">
                <span class="js_job_data_title"><?php echo JText::_('JS_ADDRESS2'); ?></span>
                <span class="js_job_data_value"><?php echo $this->company->address2;?></span>
            </div>
        <?php
        } ?>
            <div class="js_job_data_wrapper">
                <span class="js_job_data_title"><?php echo JText::_('JS_LOCATION'); ?>:&nbsp;</span>
                <span class="js_job_data_value"><?php if($this->company->multicity != '') echo $this->company->multicity;?></span>
            </div>
        <?php
        $i = 0;
        foreach($this->fieldsordering as $field){ 
                //echo '<br> uf'.$field->field;
                switch ($field->field) {
                        case "jobcategory": ?>
                            <div class="js_job_data_wrapper">
                                <span class="js_job_data_title"><?php echo JText::_('JS_CATEGORIES'); ?></span>
                                <span class="js_job_data_value"><?php echo $this->company->cat_title; ?></span>
                            </div>
                        <?php break;
                        case "contactphone":  ?>
                                <?php if ( $field->published == 1 ) { ?>
                                <div class="js_job_data_wrapper">
                                    <span class="js_job_data_title"><?php echo JText::_('JS_CONTACTPHONE'); ?></span>
                                    <span class="js_job_data_value"><?php echo $this->company->contactphone; ?></span>
                                </div>
                                <?php } ?>
                        <?php break;
                        case "contactfax":  ?>
                                <?php if ( $field->published == 1 ) { ?>
                                <div class="js_job_data_wrapper">
                                    <span class="js_job_data_title"><?php echo JText::_('JS_CONTACTFAX'); ?></span>
                                    <span class="js_job_data_value"><?php echo $this->company->companyfax; ?></span>
                                </div>
                                <?php } ?>
                        <?php break;
                        case "since":  ?>
                                <?php if ( $field->published == 1 ) { ?>
                                <div class="js_job_data_wrapper">
                                    <span class="js_job_data_title"><?php echo JText::_('JS_SINCE'); ?></span>
                                    <span class="js_job_data_value"><?php echo date($this->config['date_format'],strtotime($this->company->since)); ?></span>
                                </div>
                                <?php } ?>
                        <?php break;
                        case "companysize":  ?>
                                <?php if ( $field->published == 1 ) { ?>
                                <div class="js_job_data_wrapper">
                                    <span class="js_job_data_title"><?php echo JText::_('JS_COMPANY_SIZE'); ?></span>
                                    <span class="js_job_data_value"><?php echo $this->company->companysize; ?></span>
                                </div>
                                <?php } ?>
                        <?php break;
                        case "income":  ?>
                                <?php if ( $field->published == 1 ) { ?>
                                <div class="js_job_data_wrapper">
                                    <span class="js_job_data_title"><?php echo JText::_('JS_INCOME'); ?></span>
                                    <span class="js_job_data_value"><?php echo $this->company->income; ?></span>
                                </div>
                                <?php } ?>
                        <?php break;
                        case "description":  ?>
                                <?php if ( $field->published == 1 ) { ?>
                                    <span class="js_controlpanel_section_title"><?php echo JText::_('JS_DESCRIPTION'); ?></span>
                                    <div class="js_job_full_width_data"><?php echo $this->company->description; ?></div>
                                <?php } ?>
                        <?php break;
                        default:
                        if ( $field->published == 1 ) { 
                        }	
                }

        } 
                        if($this->isjobsharing){
                                if(isset($this->userfields)){
                                        foreach($this->userfields as $ufield){
                                                        $isodd = 1 - $isodd; 
                                                        echo '<div class="js_job_data_wrapper">';
                                                        echo '<span class="js_job_data_title">'. $ufield['field_title'] .'</span>';
                                                        echo '<span class="js_job_data_value">'.$ufield['field_value'].'</span>';	
                                                        echo '</div>';
                                        }
                                }
                        }else{
                                        foreach($this->userfields as $ufield){ 
                                                if($ufield[0]->published==1) {
                                                        $userfield = $ufield[0];
                                                        $i++;
                                                        echo '<div class="js_job_data_wrapper">';
                                                        echo '<span class="js_job_data_title">'. $userfield->title .'</span>';
                                                        if ($userfield->type != "select"){
                                                                if(isset($ufield[1])){ $fvalue = $ufield[1]->data; $userdataid = $ufield[1]->id;}  else {$fvalue=""; $userdataid = ""; }
                                                        }elseif ($userfield->type == "select"){
                                                                if(isset($ufield[2])){ $fvalue = $ufield[2]->fieldtitle; $userdataid = $ufield[1]->id;}  else {$fvalue=""; $userdataid = ""; }
                                                        }
                                                        echo '<span class="js_job_data_value">'.$fvalue.'</span>';	
                                                        echo '</div>';
                                                }
                                        }	 


                                }

                        ?>
        <div class="js_job_apply_button">
            <?php 
                if ($this->nav != '31' && $this->nav != '41'){?>
                        <a class="js_job_button" href="index.php?option=com_jsjobs&c=company&view=company&layout=company_jobs&cd=<?php echo $this->company->aliasid; ?>&Itemid=<?php echo $this->Itemid; ?>" ><?php echo JText::_('JS_VIEW_ALL_JOBS'); ?></a>
            <?php } ?>	
        </div>
        

    </div>
	<?php }else { ?>
        <div class="js_job_error_messages_wrapper">
            <div class="js_job_messages_image_wrapper">
                <img class="js_job_messages_image" src="components/com_jsjobs/images/2.png"/>
            </div>
            <div class="js_job_messages_data_wrapper">
                <span class="js_job_messages_main_text">
                    <?php echo JText::_('JS_RESULT_NOT_FOUND'); ?>
                </span>
            </div>
        </div>
	
<?php }
}//ol
?>	
<!--<div id="jsjobs_footer">-->
    <?php // echo '<table width="100%" style="table-layout:fixed;"> <tr><td height="15"></td></tr> <tr><td style="vertical-align:top;" align="center"> <a class="img" target="_blank" href="http://www.joomsky.com"><img src="http://www.joomsky.com/logo/jsjobscrlogo.png"></a> <br> Copyright &copy; 2008 - '.date('Y').', <span id="themeanchor"> <a class="anchor"target="_blank" href="http://www.joomsky.com">Joom Sky</a></span></td></tr> </table></div>';?>
<!--</div>-->
<?php 

function isURL($url = NULL) {
        if($url==NULL) return false;

        $protocol = '(http://|https://)';
        if(ereg($protocol, $url)==true) return true;
        else return false;
}

?>
