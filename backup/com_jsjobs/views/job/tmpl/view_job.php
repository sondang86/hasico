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
 * File Name:	views/employer/tmpl/view_job.php
 ^ 
 * Description: template view for a job
 ^ 
 * History:		NONE
 ^ 
 */
 
defined('_JEXEC') or die('Restricted access');
$document = JFactory::getDocument();
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
<?php 
	if( isset($this->job)){//job summary table 
            //check which field is enabled or not
            require_once 'jobapply.php';
            $fieldarray = array();
                foreach($this->fieldsordering as $field){
                    $fieldarray[$field->field] = $field->published;
                }
                $section_array = array();
                //requirement section
                if(
                    (isset($fieldarray['heighesteducation']) && $fieldarray['heighesteducation'] == 1) || 
                    (isset($fieldarray['experience']) && $fieldarray['experience'] == 1) || 
                    (isset($fieldarray['workpermit']) && $fieldarray['workpermit'] == 1) || 
                    (isset($fieldarray['requiredtravel']) && $fieldarray['requiredtravel'] == 1)
                    )
                    $section_array['requirement'] = 1;
                else $section_array['requirement'] = 0;
?>
    <div id="js_main_wrapper">
        <span class="js_controlpanel_section_title">
            <?php 
                echo JText::_('JS_JOB_INFO');
                $days = $this->config['newdays'];
                $isnew = date("Y-m-d H:i:s", strtotime("-$days days"));
                if(isset($this->job)){
                    if ($this->job->created > $isnew)
                        echo '<div class="js_job_new"><canvas class="newjob" width="20" height="20"></canvas>'.JText::_('JS_NEW').'</div>';
                }	
            ?>
            
        </span>
        <span class="js_job_title">
            <?php 
                if(isset($this->job)) echo $this->job->title;
            ?>
        </span>
        <span class="js_controlpanel_section_title"><?php echo JText::_('JS_COMPANY_INFORMATION');?></span>
        <div class="js_job_company_logo">
            <?php 
                if(!empty($this->job->companylogo)){
                        if($this->isjobsharing){
                            $logourl = $this->job->companylogo;
                        }else{
                            $logourl = $this->config['data_directory'].'/data/employer/comp_'.$this->job->companyid.'/logo/'.$this->job->companylogo;
                            
                        }
                }else{
                    $logourl = 'components/com_jsjobs/images/blank_logo.png';
                }
            ?>
            <img class="js_job_company_logo" src="<?php echo $logourl; ?>" />
        </div>
        <div class="js_job_company_data">
            <?php if ($this->listjobconfig['lj_company'] == '1') { ?>
                <div class="js_job_data_wrapper">
                    <span class="js_job_data_title"><?php echo JText::_('JS_COMPANY'); ?></span>
                    <span class="js_job_data_value">
                        <?php if (isset($_GET['cat'])) $jobcat = $_GET['cat']; else $jobcat=null;
                        (isset($navcompany) && $navcompany == 41) ? $navlink = "&nav=41": $navlink = "";
                        $link = 'index.php?option=com_jsjobs&c=company&view=company&layout=view_company'.$navlink.'&cd='.$this->job->companyaliasid.'&cat='.$this->job->jobcategory.'&Itemid='.$this->Itemid; ?>
                        <a class="js_job_company_anchor" href="<?php echo $link; ?>">
                            <?php echo $this->job->companyname; ?>
                        </a>
                    </span>
                </div>
            <?php } ?>
            <?php if($this->config['comp_show_url'] == 1) { ?>
                <div class="js_job_data_wrapper">
                    <span class="js_job_data_title"><?php echo JText::_('JS_URL'); ?></span>
                    <span class="js_job_data_value">
                        <a class="js_job_company_anchor" href="<?php echo $this->job->companywebsite;?>">
                            <?php echo $this->job->companywebsite;?>
                        </a>
                    </span>
                </div>
            <?php } ?>
            <?php if ($this->config['comp_name'] == 1) { ?>
                <div class="js_job_data_wrapper">
                    <span class="js_job_data_title"><?php echo JText::_('JS_CONTACTNAME'); ?></span>
                    <span class="js_job_data_value"><?php echo $this->job->companycontactname;?></span>
                </div>
            <?php } ?>
            <?php if ($this->config['comp_email_address'] == 1) { ?>
                <div class="js_job_data_wrapper">
                    <span class="js_job_data_title"><?php echo JText::_('JS_CONTACTEMAIL'); ?></span>
                    <span class="js_job_data_value"><?php echo $this->job->companycontactemail;?></span>
                </div>
            <?php } ?>
            <div class="js_job_data_wrapper">
                <span class="js_job_data_title"><?php echo JText::_('JS_SINCE'); ?></span>
                <span class="js_job_data_value"><?php echo date($this->config['date_format'],strtotime($this->job->companysince));?></span>
            </div>
        </div>
        <span class="js_controlpanel_section_title"><?php echo JText::_('JS_JOB_INFORMATION');?></span>
        <?php if ($this->listjobconfig['lj_jobtype'] == '1') { ?>
            <div class="js_job_data_wrapper">
                <span class="js_job_data_title"><?php echo JText::_('JS_JOBTYPE'); ?></span>
                <span class="js_job_data_value"><?php echo $this->job->jobtypetitle;?></span>
            </div>
        <?php } ?>
        <?php if(isset($fieldarray['duration']) && $fieldarray['duration'] == 1) { ?>
            <div class="js_job_data_wrapper">
                <span class="js_job_data_title"><?php echo JText::_('JS_DURATION'); ?></span>
                <span class="js_job_data_value"><?php echo $this->job->duration;?></span>
            </div>
        <?php } ?>
        <?php if(isset($fieldarray['jobsalaryrange']) && $fieldarray['jobsalaryrange'] == 1) { ?>
            <?php if ( $this->job->hidesalaryrange != 1 ) { // show salary ?>
                    <div class="js_job_data_wrapper">
                        <span class="js_job_data_title"><?php echo JText::_('JS_SALARYRANGE'); ?></span>
                        <span class="js_job_data_value">
                            <?php
                                if ($this->job->salaryfrom) echo JText::_('JS_S_FROM') .' ' .$this->job->symbol. $this->job->salaryfrom;
                                if ($this->job->salaryto) echo ' - ' . JText::_('JS_S_TO'). ' '.$this->job->symbol . $this->job->salaryto;
                                if ($this->job->salarytype) echo ' ' . $this->job->salarytype; 
                            ?>
                        </span>
                    </div>
            <?php } ?>
        <?php } ?>
        <?php if(isset($fieldarray['department']) && $fieldarray['department'] == 1) { ?>
            <div class="js_job_data_wrapper">
                <span class="js_job_data_title"><?php echo JText::_('JS_DEPARTMENT'); ?></span>
                <span class="js_job_data_value"><?php echo $this->job->departmentname;?></span>
            </div>
        <?php } ?>
        <div class="js_job_data_wrapper">
            <span class="js_job_data_title"><?php echo JText::_('JS_CATEGORY'); ?></span>
            <span class="js_job_data_value"><?php echo $this->job->cat_title;?></span>
        </div>
        <?php if(isset($fieldarray['subcategory']) && $fieldarray['subcategory'] == 1) { ?>
            <div class="js_job_data_wrapper">
                <span class="js_job_data_title"><?php echo JText::_('JS_SUB_CATEGORY'); ?></span>
                <span class="js_job_data_value"><?php echo $this->job->subcategory;?></span>
            </div>
        <?php } ?>
        <?php if(isset($fieldarray['jobshift']) && $fieldarray['jobshift'] == 1) { ?>
            <div class="js_job_data_wrapper">
                <span class="js_job_data_title"><?php echo JText::_('JS_SHIFT'); ?></span>
                <span class="js_job_data_value"><?php echo $this->job->shifttitle;?></span>
            </div>
        <?php } ?>
        <?php 
        foreach($this->fieldsordering AS $field){
            if ( $field->published == 1 && is_numeric($field->field)) {
                if($this->isjobsharing!="") {
                    if(is_array($this->userfields)) {
                        for($k = 0; $k < 15;$k++){
                                        $field_title='fieldtitle_'.$k;
                                        $field_value='fieldvalue_'.$k;
                                        echo '<div class="js_job_data_wrapper">
                                                    <span class="js_job_data_title">'.$this->userfields[$field_title].'</span>
                                                    <span class="js_job_data_value">'.$this->userfields[$field_value].'</span>
                                                </div>';
                        }
                    }
                }else{
                        foreach($this->userfields as $ufield){ 
                                if($ufield[0]->published==1 && $ufield[0]->id == $field->field) {
                                        $userfield = $ufield[0];
                                        $i++;
                                        echo '<div class="js_job_data_wrapper">
                                                    <span class="js_job_data_title">'.$userfield->title.'</span>
                                                    <span class="js_job_data_value">';
                                        if ($userfield->type == "checkbox"){
                                                if(isset($ufield[1])){ $fvalue = $ufield[1]->data; $userdataid = $ufield[1]->id;}  else {$fvalue=""; $userdataid = ""; }
                                                if ($fvalue == '1') $fvalue = "True"; else $fvalue = "false";
                                        }elseif ($userfield->type == "select"){
                                                if(isset($ufield[2])){ $fvalue = $ufield[2]->fieldtitle; $userdataid = $ufield[2]->id;} else {$fvalue=""; $userdataid = ""; }
                                        }else{
                                                if(isset($ufield[1])){ $fvalue = $ufield[1]->data; $userdataid = $ufield[1]->id;}  else {$fvalue=""; $userdataid = ""; }
                                        }
                                        echo $fvalue.'</span>
                                                </div>';
                                }
                        }	 

                }
            }	
        }
        ?>
        <div class="js_job_data_wrapper">
            <span class="js_job_data_title"><?php echo JText::_('JS_POSTED'); ?></span>
            <span class="js_job_data_value"><?php echo date($this->config['date_format'],  strtotime($this->job->created));?></span>
        </div>
        <?php if($section_array['requirement'] == 1){ ?>
            <span class="js_controlpanel_section_title"><?php echo JText::_('JS_REQUIRMENTS');?></span>
            <?php if($this->job->iseducationminimax == 1){
                        if($this->job->educationminimax == 1) $title = JText::_('JS_MINIMUM_EDEDUCATION');
                        else $title = JText::_('JS_MAXIMUM_EDEDUCATION');
                        $educationtitle = $this->job->educationtitle;
                    }else {
                        $title = JText::_('JS_EDEDUCATION');
                        $educationtitle = $this->job->mineducationtitle.' - '.$this->job->maxeducationtitle;
                    }
            ?>
            <?php if(isset($fieldarray['heighesteducation']) && $fieldarray['heighesteducation'] == 1){ ?>
                    <div class="js_job_data_wrapper">
                        <span class="js_job_data_title"><?php echo $title; ?></span>
                        <span class="js_job_data_value"><?php echo $educationtitle;?></span>
                    </div>
                    <div class="js_job_data_wrapper">
                        <span class="js_job_data_title"><?php echo JText::_('JS_DEGREE_TITLE'); ?></span>
                        <span class="js_job_data_value"><?php echo $this->job->degreetitle;?></span>
                    </div>
            <?php } ?>
            <?php if($this->job->isexperienceminimax == 1){
                        if($this->job->experienceminimax == 1) $title = JText::_('JS_MINIMUM_EXPERIENCE');
                        else $title = JText::_('JS_MAXIMUM_EXPERIENCE');
                        $experiencetitle = $this->job->experiencetitle;
                    }else {
                        $title = JText::_('JS_EXPERIENCE');
                        $experiencetitle = $this->job->minexperiencetitle.' - '.$this->job->maxexperiencetitle;
                    }
                    if($this->job->experiencetext) $experiencetitle .= ' ('.$this->job->experiencetext.')';
                    ?>
            <?php if(isset($fieldarray['experience']) && $fieldarray['experience'] == 1){ ?>
                    <div class="js_job_data_wrapper">
                        <span class="js_job_data_title"><?php echo $title; ?></span>
                        <span class="js_job_data_value"><?php echo $experiencetitle;?></span>
                    </div>
            <?php } ?>
            <?php if(isset($fieldarray['workpermit']) && $fieldarray['workpermit'] == 1){ ?>
                    <div class="js_job_data_wrapper">
                        <span class="js_job_data_title"><?php echo JText::_('JS_WORK_PERMIT'); ?></span>
                        <span class="js_job_data_value"><?php echo $this->job->workpermitcountry;?></span>
                    </div>
            <?php } ?>
            <?php if(isset($fieldarray['requiredtravel']) && $fieldarray['requiredtravel'] == 1){ 
				switch($this->job->requiredtravel){
					case 1: $requiredtraveltitle = JText::_('JS_NOT_REQUIRED'); break;
					case 2: $requiredtraveltitle = "25%"; break;
					case 3: $requiredtraveltitle = "50%"; break;
					case 4: $requiredtraveltitle = "75%"; break;
					case 5: $requiredtraveltitle = "100%"; break;
				}
			?>
                    <div class="js_job_data_wrapper">
                        <span class="js_job_data_title"><?php echo JText::_('JS_REQUIRED_TRAVEL'); ?></span>
                        <span class="js_job_data_value"><?php echo $requiredtraveltitle;?></span>
                    </div>
            <?php } ?>
        <?php } ?>
        <span class="js_controlpanel_section_title"><?php echo JText::_('JS_JOB_STATUS');?></span>
        <?php if(isset($fieldarray['jobstatus']) && $fieldarray['jobstatus'] == 1){ ?>
            <?php if ($this->listjobconfig['lj_jobstatus'] == '1') { ?>
                <div class="js_job_data_wrapper">
                    <span class="js_job_data_title"><?php echo JText::_('JS_JOBSTATUS'); ?></span>
                    <span class="js_job_data_value"><?php echo $this->job->jobstatustitle;?></span>
                </div>
            <?php } ?>
        <?php } ?>
        <div class="js_job_data_wrapper">
            <span class="js_job_data_title"><?php echo JText::_('JS_START_PUBLISHING'); ?></span>
            <span class="js_job_data_value"><?php echo date($this->config['date_format'],strtotime($this->job->startpublishing));?></span>
        </div>
        <?php if(isset($fieldarray['noofjobs']) && $fieldarray['noofjobs'] == 1){ ?>
            <div class="js_job_data_wrapper">
                <span class="js_job_data_title"><?php echo JText::_('JS_NOOFJOBS'); ?></span>
                <span class="js_job_data_value"><?php echo $this->job->noofjobs; ?></span>
            </div>
        <?php } ?>
        <div class="js_job_data_wrapper">
            <span class="js_job_data_title"><?php echo JText::_('JS_STOP_PUBLISHING'); ?></span>
            <span class="js_job_data_value"><?php echo date($this->config['date_format'],strtotime($this->job->stoppublishing)); ?></span>
        </div>
        <span class="js_controlpanel_section_title"><?php echo JText::_('JS_LOCATION');?></span>            
        <?php if ($this->listjobconfig['lj_city'] == '1') { ?>
            <div class="js_job_full_width_data">
                <?php if($this->job->multicity != '') echo $this->job->multicity; ?>
            </div>
        <?php } ?>
        <?php if(isset($fieldarray['map']) && $fieldarray['map'] == 1){ ?>
            <div class="js_job_full_width_data">
                <div id="map"><div id="map_container"></div></div>
                <input type="hidden" id="longitude" name="longitude" value="<?php if(isset($this->job)) echo $this->job->longitude;?>"/>
                <input type="hidden" id="latitude" name="latitude" value="<?php if(isset($this->job)) echo $this->job->latitude;?>"/>
            </div>
        <?php } ?>
        <?php if(isset($fieldarray['video']) && $fieldarray['video'] == 1){ ?>
            <?php if ($this->job->video) { ?>
                <span class="js_controlpanel_section_title"><?php echo JText::_('JS_VIDEO'); ?></span>
                <div class="js_job_full_width_data">
                    <iframe title="YouTube video player" width="480" height="390" 
                            src="http://www.youtube.com/embed/<?php echo $this->job->video; ?>" frameborder="0" allowfullscreen>
                    </iframe>
                </div>
          <?php } ?>
        <?php } ?>
        <span class="js_controlpanel_section_title"><?php echo JText::_('JS_DESCRIPTION'); ?></span>
        <div class="js_job_full_width_data"><?php echo $this->job->description; ?></div>
        <?php if(isset($fieldarray['agreement']) && $fieldarray['agreement'] == 1){ ?>
                <span class="js_controlpanel_section_title"><?php echo JText::_('JS_AGREEMENT'); ?></span>
                <div class="js_job_full_width_data"><?php echo $this->job->agreement; ?></div>
        <?php } ?>
       <?php if(isset($fieldarray['qualifications']) && $fieldarray['qualifications'] == 1){ ?>
                <span class="js_controlpanel_section_title"><?php echo JText::_('JS_QUALIFICATIONS'); ?></span>
                <div class="js_job_full_width_data"><?php echo $this->job->qualifications; ?></div>
        <?php } ?>
        <?php if(isset($fieldarray['prefferdskills']) && $fieldarray['prefferdskills'] == 1){ ?>
                <span class="js_controlpanel_section_title"><?php echo JText::_('JS_PREFFERD_SKILLS'); ?></span>
                <div class="js_job_full_width_data"><?php echo $this->job->prefferdskills; ?></div>
        <?php } ?>
        <div class="js_job_apply_button">
            <?php $link = 'index.php?option=com_jsjobs&c=jobapply&view=jobapply&layout=job_apply&bd='.$this->job->jobaliasid.'&Itemid='.$this->Itemid; ?>
            <a class="js_job_button" data-jobapply="jobapply" data-jobid="<?php echo $this->job->jobaliasid; ?>" href="#" ><strong><?php echo JText::_('JS_APPLYNOW'); ?></strong></a>		   
        </div>
    </div>
	<?php } else { ?>
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
        <?php } ?>
<?php
}//ol
?>
<!--<div id="jsjobs_footer">-->
    <?php // echo '<table width="100%" style="table-layout:fixed;"> <tr><td height="15"></td></tr> <tr><td style="vertical-align:top;" align="center"> <a class="img" target="_blank" href="http://www.joomsky.com"><img src="http://www.joomsky.com/logo/jsjobscrlogo.png"></a> <br> Copyright &copy; 2008 - '.date('Y').', <span id="themeanchor"> <a class="anchor"target="_blank" href="http://www.joomsky.com">Joom Sky</a></span></td></tr> </table></div>';?>
<!--</div>-->
<style type="text/css">
div#map_container{ width:100%; height:350px; }
</style>
<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false"></script>
<script type="text/javascript">
window.onload = loadMap();
  function loadMap() {
		var latedit=[];
		var longedit=[];
		var longitude = document.getElementById('longitude').value;
		var latitude = document.getElementById('latitude').value;
		latedit=latitude.split(",");
		longedit=longitude.split(",");
		if(latedit != '' && longedit != ''){ 
			for (var i = 0; i < latedit.length; i++) {
				var latlng = new google.maps.LatLng(latedit[i], longedit[i]); zoom = 4;
				var myOptions = {
				  zoom: zoom,
				  center: latlng,
				  mapTypeId: google.maps.MapTypeId.ROADMAP
				};
				if(i==0) var map = new google.maps.Map(document.getElementById("map_container"),myOptions);
				/*var lastmarker = new google.maps.Marker({
					postiion:latlng,
					map:map,
				});*/
					var marker = new google.maps.Marker({
					  position: latlng, 
					  zoom: zoom,
					  map: map, 
					  visible: true,					  
					});
					marker.setMap(map);
			}			
		}
}
	window.onload = function() {
		
		if(document.getElementById('jobseeker_fb_comments') != null){
			var myFrame = document.getElementById('jobseeker_fb_comments');
			if(myFrame != null)
			myFrame.src='http://www.facebook.com/plugins/comments.php?href='+location.href;
		}
		if(document.getElementById('employer_fb_comments') != null){
			var myFrame = document.getElementById('employer_fb_comments');
			if(myFrame != null)
			myFrame.src='http://www.facebook.com/plugins/comments.php?href='+location.href;
		}
	}
</script>
<?php
$document = JFactory::getDocument();
$document->addScript('components/com_jsjobs/js/canvas_script.js');
?>