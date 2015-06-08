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
 * File Name:	views/jobseeker/tmpl/view_resume.php
 ^ 
 * Description: template for view resume
 ^ 
 * History:		NONE
 ^ 
 */

defined('_JEXEC') or die('Restricted access');
$resume_style = $this->config['resume_style'];
$isodd = 0; 
$big_field_width = 40;
$med_field_width = 25;
$sml_field_width = 15;


$section_personal = 1;
$section_basic = 1;
$section_addresses = 0;
$section_sub_address = 0;
$section_sub_address1 = 0;
$section_sub_address2 = 0;
$section_education = 0;
$section_sub_institute = 0;
$section_sub_institute1 = 0;
$section_sub_institute2 = 0;
$section_sub_institute3 = 0;
$section_employer = 0;
$section_sub_employer = 0;
$section_sub_employer1 = 0;
$section_sub_employer2 = 0;
$section_sub_employer3 = 0;
$section_skills = 0;
$section_resumeeditor = 0;
$section_references = 0;
$section_sub_reference = 0;
$section_sub_reference1 = 0;
$section_sub_reference2 = 0;
$section_sub_reference3 = 0;
$section_languages = 0;
$section_sub_language1 = 0;
$section_sub_language2=0;
$section_sub_language3=0;


if( isset($this->fieldsordering))
foreach($this->fieldsordering as $field){ 
	switch ($field->field){
		case "section_addresses" :	$section_addresses = $field->published;	break;
		case "section_sub_address" :	$section_sub_address = $field->published;	break;
		case "section_sub_address1" :	$section_sub_address1 = $field->published;	break;
		case "section_sub_address2" :	$section_sub_address2 = $field->published;	break;
		case "section_education" :	$section_education = $field->published;	break;
		case "section_sub_institute" :	$section_sub_institute = $field->published;	break;
		case "section_sub_institute1" : $section_sub_institute1 = $field->published; break;
		case "section_sub_institute2" :	$section_sub_institute2 = $field->published; break;
		case "section_sub_institute3" :	$section_sub_institute3 = $field->published; break;
		case "section_employer" :	$section_employer = $field->published; break;
		case "section_sub_employer" :	$section_sub_employer = $field->published; break;
		case "section_sub_employer1" :	$section_sub_employer1 = $field->published;	break;
		case "section_sub_employer2" :	$section_sub_employer2 = $field->published;	break;
		case "section_sub_employer3" :	$section_sub_employer3 = $field->published; break;
		case "section_skills" :	$section_skills = $field->published; break;
		case "section_resumeeditor" :	$section_resumeeditor = $field->published; break;
		case "section_references" :	$section_references = $field->published; break;
		case "section_sub_reference" :	$section_sub_reference = $field->published; break;
		case "section_sub_reference1" :	$section_sub_reference1 = $field->published; break;
		case "section_sub_reference2" :	$section_sub_reference2 = $field->published; break;
		case "section_sub_reference3" :	$section_sub_reference3 = $field->published; break;
		case "section_languages" :	$section_languages = $field->published; break;
		case "section_sub_language" :	$section_sub_language = $field->published; break;
		case "section_sub_language1" :	$section_sub_language1 = $field->published; break;
		case "section_sub_language2" :	$section_sub_language2 = $field->published; break;
		case "section_sub_language3" :	$section_sub_language3 = $field->published; break;
		
	}
}
$document = JFactory::getDocument();
	if(JVERSION < 3){
		JHtml::_('behavior.mootools');
		$document->addScript('components/com_jsjobs/js/jquery.js');
	}else{
		JHtml::_('behavior.framework');
		JHtml::_('jquery.framework');
	}	

$document->addScript('administrator/components/com_jsjobs/include/js/jquery_idTabs.js');

if(!empty($this->cvids)){
    $jobaliasid = $this->jobaliasid;
    $rd = $this->resumeid;
    $nav = $this->nav;// hardcode for the employer resumes navigations.
    $sort = $this->sortby;
    $tabaction = $this->ta;
    $index_cvid = -1;
    foreach($this->cvids AS $key => $cvid){
        if($rd == $cvid->cvid){
            $index_cvid = $key;
            break;
        }
    }    
    if($index_cvid != -1){
        $rd =  $this->cvids[$index_cvid]->cvid;
        if(isset($this->cvids[($index_cvid - 1)]))
            $pre_rd_link = 'index.php?option=com_jsjobs&c=resume&view=resume&layout=view_resume&nav=2&rd='.$this->cvids[($index_cvid - 1)]->cvid.'&bd='.$jobaliasid.'&sortby='.$sort.'&ta='.$tabaction.'&Itemid='.$this->Itemid;

        if(isset($this->cvids[($index_cvid + 1)]))
            $nex_rd_link = 'index.php?option=com_jsjobs&c=resume&view=resume&layout=view_resume&nav=2&rd='.$this->cvids[($index_cvid + 1)]->cvid.'&bd='.$jobaliasid.'&sortby='.$sort.'&ta='.$tabaction.'&Itemid='.$this->Itemid;
    }
   
}
?>
<style type="text/css">
div#outermapdiv{position:relative;float:left; z-index:10000; }
div#map_container{ z-index:1000; position:relative; background:#000; width:100%; height:100%; }
div#map{ height: 300px; left: 22px; position: absolute; overflow:true; top: 0px; visibility: hidden; width: 650px; }
</style>
<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false"></script>
<script type="text/javascript">
  function loadMap() {
		var default_latitude = document.getElementById('latitude').value;
		var default_longitude = document.getElementById('longitude').value;
		
		var latlng = new google.maps.LatLng(default_latitude, default_longitude); zoom=10;
		var myOptions = {
		  zoom: zoom,
		  center: latlng,
		  mapTypeId: google.maps.MapTypeId.ROADMAP
		};
		var map = new google.maps.Map(document.getElementById("map_container"),myOptions);
		var lastmarker = new google.maps.Marker({
			postiion:latlng,
			map:map,
		});
		var marker = new google.maps.Marker({
		  position: latlng, 
		  map: map, 
		});
		marker.setMap(map);
		lastmarker = marker;

	google.maps.event.addListener(map,"click", function(e){
		return false;
	});
//document.getElementById('map_container').innerHTML += "<a href='Javascript hidediv();'><?php echo JText::_('JS_CLOSE_MAP');?></a>";
}
</script>

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
$printform = 1;
	$printform = 1;$canprint = 1;//canprint if the message is already print or not
	if ((isset($this->resume)) &&($this->resume->id != 0)) { // not new form

		if ($this->resume->status == 1) { // Employment Application is actve
			$printform = 1;
		}elseif($this->resume->status == 0){ // not allowed job posting
			$printform = 0;$canprint = 0;?>
        <div class="js_job_error_messages_wrapper">
            <div class="js_job_messages_image_wrapper">
                <img class="js_job_messages_image" src="components/com_jsjobs/images/2.png"/>
            </div>
            <div class="js_job_messages_data_wrapper">
                <span class="js_job_messages_main_text">
                    <?php echo JText::_('JS_RESUME_WAIT_APPROVAL'); ?>
                </span>
                <span class="js_job_messages_block_text">
                    <?php echo JText::_('JS_RESUME_WAIT_APPROVAL'); ?>
                </span>
            </div>
        </div>
		<?php } else{ // not allowed job posting
			$printform = 0;$canprint = 0; ?>
        <div class="js_job_error_messages_wrapper">
            <div class="js_job_messages_image_wrapper">
                <img class="js_job_messages_image" src="components/com_jsjobs/images/2.png"/>
            </div>
            <div class="js_job_messages_data_wrapper">
                <span class="js_job_messages_main_text">
                    <?php echo JText::_('JS_RESUME_REJECT'); ?>
                </span>
                <span class="js_job_messages_block_text">
                    <?php echo JText::_('JS_RESUME_REJECT'); ?>
                </span>
            </div>
        </div>
		<?php }
		if ($this->nav == 1){
			if ($this->resume->uid != $this->uid){ // job seeker can't see other job seeker resume
				$printform = 0;$canprint = 0;?>
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
			<?php }
		}
	}elseif($this->canview == 0){
			$printform = 0;$canprint = 0; ?>
        <div class="js_job_error_messages_wrapper">
            <div class="js_job_messages_image_wrapper">
                <img class="js_job_messages_image" src="components/com_jsjobs/images/2.png"/>
            </div>
            <div class="js_job_messages_data_wrapper">
                <span class="js_job_messages_main_text">
                    <?php echo JText::_('JS_YOU_CAN_NOT_VIEW_RESUME_DETAIL'); ?>
                </span>
                <span class="js_job_messages_block_text">
                    <?php echo JText::_('JS_YOU_CAN_NOT_VIEW_RESUME_DETAIL'); ?>
                </span>
            </div>
        </div>
        <?php }

if($canprint == 1)
if ($printform == 1) {
	if(isset($this->resume)){
?>
    <div id="js_main_wrapper">
        <span class="js_controlpanel_section_title"><?php echo JText::_('JS_VIEW_RESUME');?></span>
            <?php if (($this->nav == 2) || ($this->nav == 3) || ($this->nav == 5)) { ?>
        <span class="js_controlpanel_section_title">
                <span class="js_resume_prev"><a href="<?php if(isset($pre_rd_link)) echo $pre_rd_link;else echo '#'; ?>" <?php if(!isset($pre_rd_link)) echo 'onclick="return false"'; ?> ><?php echo "<<&nbsp;&nbsp;".JText::_('JS_PREVIOUS_RESUME'); ?></a></span>
                <span class="js_resume_next"><a href="<?php if(isset($nex_rd_link)) echo $nex_rd_link;else echo '#'; ?>" <?php if(!isset($nex_rd_link)) echo 'onclick="return false"'; ?> ><?php echo JText::_('JS_NEXT_RESUME')."&nbsp;&nbsp;>>"; ?></a></span>
                <?php  $jobid = $this->jobaliasid; ?>
                <a class="js_resume_pdf_link" target="_blank" href="index.php?option=com_jsjobs&c=resume&view=output&layout=resumepdf&format=pdf&rd=<?php echo $this->resume->resumealiasid; ?>&bd=<?php echo $this->jobaliasid; ?>&ms=<?php echo $this->ms; ?>">
                    <img src="components/com_jsjobs/images/pdf.png" width="24" height="24" />
                </a>
        </span>
            <?php } ?>
			<div id="tabs_wrapper" class="tabs_wrapper">
			<div class="idTabs">
				<span><a class="selected" href="#personal_info_data"><?php echo JText::_('JS_PERSONAL');?></a></span> 
				<?php if($section_addresses) { ?><span><a href="#addresses_data"><?php echo JText::_('JS_ADDRESSES');?></a></span>  <?php } ?>
				<?php if($section_education) { ?><span><a href="#education_data"><?php echo JText::_('JS_EDUCATIONS');?></a></span> <?php } ?>
				<?php if($section_employer) { ?><span><a href="#employer_data"><?php echo JText::_('JS_EMPLOYERS');?></a></span>  <?php } ?>
				<?php if($section_skills) { ?><span><a href="#skills_data"><?php echo JText::_('JS_SKILLS');?></a></span>  <?php } ?>
				<?php if($section_resumeeditor) { ?><span><a href="#resume_editor_data"><?php echo JText::_('JS_RESUME_EDITOR');?></a></span>  <?php } ?>
				<?php if($section_references) { ?><span><a href="#references_data"><?php echo JText::_('JS_REFERENCES');?></a></span>  <?php } ?>
				<?php if($section_languages) { ?><span><a href="#languages_data"><?php echo JText::_('JS_LANGUAGES');?></a></span>  <?php } ?>
			</div>
			<?php
				$trclass = array("odd", "even");
				$i = 0;
				foreach($this->fieldsordering as $field){ 
					switch ($field->field) {
						case "section_personal": ?>
                                                        <div id="personal_info_data">
                                                            <span class="js_controlpanel_section_title personal">
                                                                <?php echo JText::_('JS_PERSONAL_INFORMATION'); ?>
                                                            </span>				        
						<?php break;
						case "applicationtitle": $isodd = 1 - $isodd; ?>
                                                            <div class="fieldwrapper view">
                                                                <div class="fieldtitle">
                                                                    <?php echo JText::_('JS_APPLICATION_TITLE'); ?>:
                                                                </div>
                                                                <div class="fieldvalue">
                                                                    <?php if (isset($this->resume)) echo $this->resume->application_title;?>
                                                                </div>
                                                            </div>				        
						<?php break;
						case "firstname":  $isodd = 1 - $isodd; ?>
                                                            <div class="fieldwrapper view">
                                                                <div class="fieldtitle">
                                                                    <?php echo JText::_('JS_FIRST_NAME'); ?>:
                                                                </div>
                                                                <div class="fieldvalue">
                                                                    <?php if (isset($this->resume)) echo $this->resume->first_name;?>
                                                                </div>
                                                            </div>				        
						<?php break;
						case "middlename":  $isodd = 1 - $isodd; ?>
						<?php if ( $field->published == 1 ) { ?>
                                                            <div class="fieldwrapper view">
                                                                <div class="fieldtitle">
                                                                    <?php echo JText::_('JS_MIDDLE_NAME'); ?>:
                                                                </div>
                                                                <div class="fieldvalue">
                                                                    <?php if (isset($this->resume)) echo $this->resume->middle_name;?>
                                                                </div>
                                                            </div>				        
						<?php } ?>
						<?php break;
						case "lastname":  $isodd = 1 - $isodd; ?>
                                                            <div class="fieldwrapper view">
                                                                <div class="fieldtitle">
                                                                    <?php echo JText::_('JS_LAST_NAME'); ?>:
                                                                </div>
                                                                <div class="fieldvalue">
                                                                    <?php if (isset($this->resume)) echo $this->resume->last_name;?>
                                                                </div>
                                                            </div>				        
						<?php break;
						case "emailaddress":  $isodd = 1 - $isodd; ?>
                                                            <div class="fieldwrapper view">
                                                                <div class="fieldtitle">
                                                                    <?php echo JText::_('JS_EMAIL_ADDRESS'); ?>:
                                                                </div>
                                                                <div class="fieldvalue">
                                                                    <?php if (isset($this->resume)) echo $this->resume->email_address;?>
                                                                </div>
                                                            </div>				        
						<?php break;
						case "homephone":  $isodd = 1 - $isodd; ?>
                                                            <div class="fieldwrapper view">
                                                                <div class="fieldtitle">
                                                                    <?php echo JText::_('JS_HOME_PHONE'); ?>:
                                                                </div>
                                                                <div class="fieldvalue">
                                                                    <?php if (isset($this->resume)) echo $this->resume->home_phone;?>
                                                                </div>
                                                            </div>				        
						<?php break;
						case "workphone":  $isodd = 1 - $isodd; ?>
                                                            <div class="fieldwrapper view">
                                                                <div class="fieldtitle">
                                                                    <?php echo JText::_('JS_WORK_PHONE'); ?>:
                                                                </div>
                                                                <div class="fieldvalue">
                                                                    <?php if (isset($this->resume)) echo $this->resume->work_phone;?>
                                                                </div>
                                                            </div>				        
						<?php break;
						case "cell":  $isodd = 1 - $isodd; ?>
                                                            <div class="fieldwrapper view">
                                                                <div class="fieldtitle">
                                                                    <?php echo JText::_('JS_CELL'); ?>:
                                                                </div>
                                                                <div class="fieldvalue">
                                                                    <?php if (isset($this->resume)) echo $this->resume->cell;?>
                                                                </div>
                                                            </div>				        
						<?php break;
						case "gender":  $isodd = 1 - $isodd; ?>
                                                            <div class="fieldwrapper view">
                                                                <div class="fieldtitle">
                                                                    <?php echo JText::_('JS_GENDER');  ?>:
                                                                </div>
                                                                <div class="fieldvalue">
                                                                    <?php if(isset($this->resume)) echo ($this->resume->gender == 1) ? JText::_('JS_MALE') : JText::_('JS_FEMALE'); ?>
                                                                </div>
                                                            </div>				        
						<?php break;
						case "Iamavailable":  $isodd = 1 - $isodd; ?>
                                                            <div class="fieldwrapper view">
                                                                <div class="fieldtitle">
                                                                    <?php echo JText::_('JS_I_AM_AVAILABLE'); ?>
                                                                </div>
                                                                <div class="fieldvalue">
                                                                    <?php if(isset($this->resume)) echo ($this->resume->iamavailable == 1) ? JText::_('JS_A_YES') : JText::_('JS_A_NO'); ?>
                                                                </div>
                                                            </div>				        
					<?php break;
					case "photo":  $isodd = 1 - $isodd; ?>
                                                        <?php if (isset($this->resume))
                                                            if($this->resume->photo != '') {?>
                                                            <div class="resume_photo">
                                                                <div style="max-width: 150px;max-height: 150px;">
                                                                <?php 
                                                                    if($this->isjobsharing){ 
                                                                        if($this->nav==2) {?>
                                                                                <img  height="150" width="150" src="<?php echo $this->resume->image_path; ?>"  />
                                                                        <?php }else { ?>
                                                                                <img  height="150" width="150" src="<?php echo $this->config['data_directory'];?>/data/jobseeker/resume_<?php echo $this->resume->id.'/photo/'.$this->resume->photo; ?>"  />
                                                                        <?php } ?>	
                                                                    <?php }else{ ?>   
                                                                            <img  height="150" width="150" src="<?php echo $this->config['data_directory'];?>/data/jobseeker/resume_<?php echo $this->resume->id.'/photo/'.$this->resume->photo; ?>"  />
                                                                    <?php } ?>	
                                                                </div>
                                                            </div>				        
                                                        <?php } ?>
						<?php break;
						case "nationality":  $isodd = 1 - $isodd; ?>
                                                            <div class="fieldwrapper view">
                                                                <div class="fieldtitle">
                                                                    <?php echo JText::_('JS_NATIONALITY_COUNTRY');  ?>:
                                                                </div>
                                                                <div class="fieldvalue">
                                                                    <?php echo $this->resume->nationalitycountry; ?>
                                                                </div>
                                                            </div>				        
						<?php break;
						case "section_basic": ?>
                                                            <span class="js_controlpanel_section_title">
                                                                <?php echo JText::_('JS_BASIC_INFORMATION'); ?>
                                                            </span>				        
						<?php break;
						case "category":  $isodd = 1 - $isodd; ?>
                                                            <div class="fieldwrapper view">
                                                                <div class="fieldtitle">
                                                                    <?php echo JText::_('JS_CATEGORY');  ?>:
                                                                </div>
                                                                <div class="fieldvalue">
                                                                    <?php echo $this->resume->categorytitle; ?>
                                                                </div>
                                                            </div>				        
						<?php break;
						case "salary":  $isodd = 1 - $isodd; ?>
                                                            <div class="fieldwrapper view">
                                                                <div class="fieldtitle">
                                                                    <?php echo JText::_('JS_DESIRED_SALARY'); ?>:
                                                                </div>
                                                                <div class="fieldvalue">
                                                                    <?php  echo $this->resume->symbol.$this->resume->rangestart.' - '.$this->resume->symbol.$this->resume->rangeend .' '. $this->resume->salarytype; ?>
                                                                </div>
                                                            </div>				        
						<?php break;
						case "jobtype":  $isodd = 1 - $isodd; ?>
                                                            <div class="fieldwrapper view">
                                                                <div class="fieldtitle">
                                                                    <?php echo JText::_('JS_WORK_PREFERENCE'); ?>:
                                                                </div>
                                                                <div class="fieldvalue">
                                                                    <?php echo $this->resume->jobtypetitle; ?>
                                                                </div>
                                                            </div>				        
						<?php break;
						case "heighesteducation":  $isodd = 1 - $isodd; ?>
                                                            <div class="fieldwrapper view">
                                                                <div class="fieldtitle">
                                                                    <?php echo JText::_('JS_HEIGHTESTFINISHEDEDUCATION'); ?>:
                                                                </div>
                                                                <div class="fieldvalue">
                                                                    <?php echo $this->resume->heighesteducationtitle; ?>
                                                                </div>
                                                            </div>				        
						<?php break;
						case "totalexperience":  $isodd = 1 - $isodd; ?>
                                                            <div class="fieldwrapper view">
                                                                <div class="fieldtitle">
                                                                    <?php echo JText::_('JS_TOTAL_EXPERIENCE'); ?>:
                                                                </div>
                                                                <div class="fieldvalue">
                                                                    <?php if (isset($this->resume)) echo $this->resume->total_experience;?>
                                                                </div>
                                                            </div>				        
						<?php break;
						case "startdate":  $isodd = 1 - $isodd; ?>
                                                            <div class="fieldwrapper view">
                                                                <div class="fieldtitle">
                                                                    <?php echo JText::_('JS_DATE_CAN_START'); ?>:
                                                                </div>
                                                                <div class="fieldvalue">
                                                                    <?php 
                                                                        if (isset($this->resume) && $this->resume->date_start != '0000-00-00 00:00:00') 
                                                                        echo date($this->config['date_format'],strtotime($this->resume->date_start));
                                                                    ?>
                                                                </div>
                                                            </div>				        
					<?php break;
						case "date_of_birth":  $isodd = 1 - $isodd; ?>
                                                            <div class="fieldwrapper view">
                                                                <div class="fieldtitle">
                                                                    <?php echo JText::_('JS_DATE_OF_BIRTH'); ?>:
                                                                </div>
                                                                <div class="fieldvalue">
									<?php 
                                                                            if (isset($this->resume) && $this->resume->date_of_birth != '0000-00-00 00:00:00')
                                                                            echo date($this->config['date_format'],strtotime($this->resume->date_of_birth));
                                                                        ?>
                                                                </div>
                                                            </div>				        
					<?php break;
					case "video": $isodd = 1 - $isodd;
						if (!empty($this->resume->video)) { ?>
                                                            <div class="fieldwrapper view">
                                                                <div class="fieldtitle">
                                                                    <?php echo JText::_('JS_VIDEO'); ?>
                                                                </div>
                                                                <div class="fieldvalue">
                                                                        <iframe title="YouTube video player" width="380" height="290" 
                                                                                src="http://www.youtube.com/embed/<?php echo $this->resume->video; ?>" frameborder="0" allowfullscreen>
                                                                        </iframe>
                                                                </div>
                                                            </div>				        
					  <?php } 
					  break;
					  case "section_userfields": 
                                                default: ?>
			<?php				
				
				if($this->isjobsharing!="") {
					if(is_object($this->userfields)) {
						for($k = 0; $k < 15;$k++){
								$isodd = 1 - $isodd; 
								$field_title='fieldtitle_'.$k;
								$field_value='fieldvalue_'.$k;
						if(!empty($this->userfields->$field_title) && $this->userfields->$field_title != null) {
                                                                echo ' <div class="fieldwrapper view">
                                                                            <div class="fieldtitle">'.$this->userfields->$field_title.':</div>
                                                                            <div class="fieldvalue">'.$this->userfields->$field_value.'</div>
                                                                        </div>';				        
                                                }
                                                }
					}
				}else{
					foreach($this->userfields as $ufield){
						if($ufield[0]->published==1 && $field->field == $ufield[0]->id) {
							$isodd = 1 - $isodd; 
							$userfield = $ufield[0];
							$i++;
                                                        echo ' <div class="fieldwrapper view">
                                                                    <div class="fieldtitle">
                                                                        '.$userfield->title.':
                                                                    </div>';
							if ($userfield->type == "checkbox"){
								if(isset($ufield[1])){ $fvalue = $ufield[1]->data; $userdataid = $ufield[1]->id;}  else {$fvalue=""; $userdataid = ""; }
								if ($fvalue == '1') $fvalue = "True"; else $fvalue = "false";
							}elseif ($userfield->type == "select"){
								if(isset($ufield[2])){ $fvalue = $ufield[2]->fieldtitle; $userdataid = $ufield[2]->id;} else {$fvalue=""; $userdataid = ""; }
							}else{
								if(isset($ufield[1])){ $fvalue = $ufield[1]->data; $userdataid = $ufield[1]->id;}  else {$fvalue=""; $userdataid = ""; }
							}
                                                        echo '      <div class="fieldvalue">
                                                                        '.$fvalue.'
                                                                    </div>
                                                                </div>';				        
						}
					
				}
			}	
		
		?>
					<?php break;
					
						case "section_addresses": ?>
							</div>	
                                                        <div id="addresses_data" >
                                                            <?php  if (($section_addresses == 1) && ($section_sub_address == 1)) { ?>
                                                                        <span class="js_controlpanel_section_title">
                                                                            <?php echo JText::_('JS_ADDRESS'); ?>
                                                                        </span>				        
                                                            <?php } ?>
					<?php break;
						case "address_country":  $isodd = 1 - $isodd; ?>
							<?php  if (($section_addresses == 1) && ($section_sub_address == 1)) { ?>
                                                            <div class="fieldwrapper view">
                                                                <div class="fieldtitle">
                                                                    <?php echo JText::_('JS_COUNTRY'); ?>
                                                                </div>
                                                                <div class="fieldvalue">
                                                                    <?php echo $this->resume->address_country; ?>
                                                                </div>
                                                            </div>				        
							<?php } ?>
					<?php break;
						case "address_state":  $isodd = 1 - $isodd; ?>
							<?php  if (($section_addresses == 1) && ($section_sub_address == 1)) { ?>
                                                            <div class="fieldwrapper view">
                                                                <div class="fieldtitle">
                                                                    <?php echo JText::_('JS_STATE'); ?>:
                                                                </div>
                                                                <div class="fieldvalue">
                                                                    <?php if ($this->resume->address_state2 !='') echo $this->resume->address_state2; else echo $this->resume->address_state;?>
                                                                </div>
                                                            </div>				        
							<?php } ?>
					<?php break;
						case "address_city":  $isodd = 1 - $isodd; ?>
							<?php  if (($section_addresses == 1) && ($section_sub_address == 1)) { ?>
                                                            <div class="fieldwrapper view">
                                                                <div class="fieldtitle">
                                                                    <?php echo JText::_('JS_CITY'); ?>:
                                                                </div>
                                                                <div class="fieldvalue">
                                                                    <?php if ($this->resume->address_city2 !='') echo $this->resume->address_city2; else echo $this->resume->address_city;?>
                                                                </div>
                                                            </div>				        
							<?php } ?>
					<?php break;
						case "address_zipcode":  $isodd = 1 - $isodd; ?>
							<?php  if (($section_addresses == 1) && ($section_sub_address == 1)) { ?>
                                                            <div class="fieldwrapper view">
                                                                <div class="fieldtitle">
                                                                    <?php echo JText::_('JS_ZIPCODE'); ?>:
                                                                </div>
                                                                <div class="fieldvalue">
                                                                    <?php if (isset($this->resume)) echo $this->resume->address_zipcode;?>
                                                                </div>
                                                            </div>				        
							<?php } ?>
					<?php break;
						case "address_address":  $isodd = 1 - $isodd; ?>
							<?php  if (($section_addresses == 1) && ($section_sub_address == 1)) { ?>
                                                            <div class="fieldwrapper view">
                                                                <div class="fieldtitle">
                                                                    <?php echo JText::_('JS_ADDRESS'); ?>:
                                                                </div>
                                                                <div class="fieldvalue">
                                                                    <?php if (isset($this->resume)) echo $this->resume->address;?>
                                                                </div>
                                                            </div>				        
							<?php } ?>
					<?php break;
						case "address_location":  $isodd = 1 - $isodd; ?>
							<?php  if (($section_addresses == 1) && ($section_sub_address == 1)) { ?>
                                                            <div class="fieldwrapper view">
                                                                <div class="fieldtitle">
                                                                    <?php echo JText::_('JS_ADDRESS_LOCATION'); ?>:
                                                                </div>
                                                                <div class="fieldvalue">
									<input id="longitude" type="hidden" name="longitude" value="<?php echo $this->resume->longitude;?>" />
									<input id="latitude" type="hidden" name="latitude" value="<?php echo $this->resume->latitude;?>" />
									<div id="outermapdiv">
										<div id="map" style="width:<?php echo $this->config['mapwidth'];?>px; height:<?php echo $this->config['mapheight'];?>px">
											<div id="closetag"><a href="Javascript: hidediv();"><?php echo JText::_('X');?></a></div>
											<div id="map_container"></div>
										</div>
									</div>
                                                                </div>
                                                            </div>				        
							<?php echo "<script language='javascript'>loadMap();</script>";} ?>
					<?php break;
						case "section_sub_address1":  ?>
							<?php  if (($section_addresses == 1) && ($section_sub_address1 == 1)) { ?>
                                                            <span class="js_controlpanel_section_title">
                                                                <?php echo JText::_('JS_ADDRESS1'); ?>
                                                            </span>				        
							<?php } ?>
					<?php break;
						case "address1_country":  $isodd = 1 - $isodd; ?>
							<?php  if (($section_addresses == 1) && ($section_sub_address1 == 1)) { ?>
                                                            <div class="fieldwrapper view">
                                                                <div class="fieldtitle">
                                                                    <?php echo JText::_('JS_COUNTRY'); ?>
                                                                </div>
                                                                <div class="fieldvalue">
                                                                    <?php echo $this->resume->address1_country; ?>
                                                                </div>
                                                            </div>				        
							<?php } ?>
					<?php break;
						case "address1_state":  $isodd = 1 - $isodd; ?>
							<?php  if (($section_addresses == 1) && ($section_sub_address1 == 1)) { ?>
                                                            <div class="fieldwrapper view">
                                                                <div class="fieldtitle">
                                                                    <?php echo JText::_('JS_STATE'); ?>:
                                                                </div>
                                                                <div class="fieldvalue">
                                                                    <?php if ($this->resume->address1_state2 !='') echo $this->resume->address1_state2; else echo $this->resume->address1_state;?>
                                                                </div>
                                                            </div>				        
							<?php } ?>
					<?php break;
						case "address1_city":  $isodd = 1 - $isodd; ?>
							<?php  if (($section_addresses == 1) && ($section_sub_address1 == 1)) { ?>
                                                            <div class="fieldwrapper view">
                                                                <div class="fieldtitle">
                                                                    <?php echo JText::_('JS_CITY'); ?>:
                                                                </div>
                                                                <div class="fieldvalue">
                                                                    <?php if ($this->resume->address1_city2 !='') echo $this->resume->address1_city2; else echo $this->resume->address1_city;?>
                                                                </div>
                                                            </div>				        
							<?php } ?>
					<?php break;
						case "address1_zipcode":  $isodd = 1 - $isodd; ?>
							<?php  if (($section_addresses == 1) && ($section_sub_address1 == 1)) { ?>
                                                            <div class="fieldwrapper view">
                                                                <div class="fieldtitle">
                                                                    <?php echo JText::_('JS_ZIPCODE'); ?>:
                                                                </div>
                                                                <div class="fieldvalue">
                                                                    <?php if (isset($this->resume)) echo $this->resume->address1_zipcode;?>
                                                                </div>
                                                            </div>				        
							<?php } ?>
					<?php break;
						case "address1_address":  $isodd = 1 - $isodd; ?>
							<?php  if (($section_addresses == 1) && ($section_sub_address1 == 1)) { ?>
                                                            <div class="fieldwrapper view">
                                                                <div class="fieldtitle">
                                                                    <?php echo JText::_('JS_ADDRESS'); ?>:
                                                                </div>
                                                                <div class="fieldvalue">
                                                                    <?php if (isset($this->resume)) echo $this->resume->address1;?>
                                                                </div>
                                                            </div>				        
							<?php } ?>
					<?php break;
						case "section_sub_address2":  ?>
							<?php  if (($section_addresses == 1) && ($section_sub_address2 == 1)) { ?>
                                                            <span class="js_controlpanel_section_title">
                                                                <?php echo JText::_('JS_ADDRESS2'); ?>
                                                            </span>				        
							<?php } ?>
					<?php break;
						case "address2_country":  $isodd = 1 - $isodd; ?>
							<?php  if (($section_addresses == 1) && ($section_sub_address2 == 1)) { ?>
                                                            <div class="fieldwrapper view">
                                                                <div class="fieldtitle">
                                                                    <?php echo JText::_('JS_COUNTRY'); ?>
                                                                </div>
                                                                <div class="fieldvalue">
                                                                    <?php echo $this->resume->address2_country; ?>
                                                                </div>
                                                            </div>				        
							<?php } ?>
					<?php break;
						case "address2_state":  $isodd = 1 - $isodd; ?>
							<?php  if (($section_addresses == 1) && ($section_sub_address2 == 1)) { ?>
                                                            <div class="fieldwrapper view">
                                                                <div class="fieldtitle">
                                                                    <?php echo JText::_('JS_STATE'); ?>:
                                                                </div>
                                                                <div class="fieldvalue">
                                                                    <?php if ($this->resume->address2_state2 !='') echo $this->resume->address2_state2; else echo $this->resume->address2_state;?>
                                                                </div>
                                                            </div>				        
							<?php } ?>
					<?php break;
						case "address2_city":  $isodd = 1 - $isodd; ?>
							<?php  if (($section_addresses == 1) && ($section_sub_address2 == 1)) { ?>
                                                            <div class="fieldwrapper view">
                                                                <div class="fieldtitle">
                                                                    <?php echo JText::_('JS_CITY'); ?>:
                                                                </div>
                                                                <div class="fieldvalue">
                                                                    <?php if ($this->resume->address2_city2 !='') echo $this->resume->address2_city2; else echo $this->resume->address2_city;?>
                                                                </div>
                                                            </div>				        
							<?php } ?>
					<?php break;
						case "address2_zipcode":  $isodd = 1 - $isodd; ?>
							<?php  if (($section_addresses == 1) && ($section_sub_address2 == 1)) { ?>
                                                            <div class="fieldwrapper view">
                                                                <div class="fieldtitle">
                                                                    <?php echo JText::_('JS_ZIPCODE'); ?>:
                                                                </div>
                                                                <div class="fieldvalue">
                                                                    <?php if (isset($this->resume)) echo $this->resume->address2_zipcode;?>
                                                                </div>
                                                            </div>				        
							<?php } ?>
					<?php break;
						case "address2_address":  $isodd = 1 - $isodd; ?>
							<?php  if (($section_addresses == 1) && ($section_sub_address2 == 1)) { ?>
                                                            <div class="fieldwrapper view">
                                                                <div class="fieldtitle">
                                                                    <?php echo JText::_('JS_ADDRESS'); ?>:
                                                                </div>
                                                                <div class="fieldvalue">
                                                                    <?php if (isset($this->resume)) echo $this->resume->address2;?>
                                                                </div>
                                                            </div>				        
							<?php } ?>
					<?php break;
						case "section_education": ?>
							</div>
                                                        <div id="education_data">
                                                            <?php  if (($section_education == 1) && ($section_sub_institute == 1)) { ?>
                                                                        <span class="js_controlpanel_section_title">
                                                                            <?php echo JText::_('JS_HIGH_SCHOOL'); ?>
                                                                        </span>				        
                                                            <?php } ?>
					<?php break;
						case "institute_institute":  $isodd = 1 - $isodd; ?>
							<?php  if (($section_education == 1) && ($section_sub_institute == 1)) { ?>
                                                                    <div class="fieldwrapper view">
                                                                        <div class="fieldtitle">
                                                                            <?php echo JText::_('JS_SCH_COL_UNI'); ?>:
                                                                        </div>
                                                                        <div class="fieldvalue">
                                                                            <?php if (isset($this->resume)) echo $this->resume->institute;?>
                                                                        </div>
                                                                    </div>				        
							<?php } ?>
					<?php break;
						case "institute_certificate":  $isodd = 1 - $isodd; ?>
							<?php  if (($section_education == 1) && ($section_sub_institute == 1)) { ?>
                                                                    <div class="fieldwrapper view">
                                                                        <div class="fieldtitle">
                                                                            <?php echo JText::_('JS_CRT_DEG_OTH'); ?>:
                                                                        </div>
                                                                        <div class="fieldvalue">
                                                                            <?php if (isset($this->resume)) echo $this->resume->institute_certificate_name;?>
                                                                        </div>
                                                                    </div>				        
							<?php } ?>
					<?php break;
						case "institute_study_area":  $isodd = 1 - $isodd; ?>
							<?php  if (($section_education == 1) && ($section_sub_institute == 1)) { ?>
                                                                    <div class="fieldwrapper view">
                                                                        <div class="fieldtitle">
                                                                            <?php echo JText::_('JS_AREA_OF_STUDY'); ?>:
                                                                        </div>
                                                                        <div class="fieldvalue">
                                                                            <?php if (isset($this->resume)) echo $this->resume->institute_study_area;?>
                                                                        </div>
                                                                    </div>				        
							<?php } ?>
					<?php break;
						case "institute_country":  $isodd = 1 - $isodd; ?>
							<?php  if (($section_education == 1) && ($section_sub_institute == 1)) { ?>
                                                                    <div class="fieldwrapper view">
                                                                        <div class="fieldtitle">
                                                                            <?php echo JText::_('JS_COUNTRY'); ?>:
                                                                        </div>
                                                                        <div class="fieldvalue">
                                                                            <?php echo $this->resume2->institute_country; ?>
                                                                        </div>
                                                                    </div>				        
							<?php } ?>
					<?php break;
						case "institute_state":  $isodd = 1 - $isodd; ?>
							<?php  if (($section_education == 1) && ($section_sub_institute == 1)) { ?>
                                                                    <div class="fieldwrapper view">
                                                                        <div class="fieldtitle">
                                                                            <?php echo JText::_('JS_STATE'); ?>:
                                                                        </div>
                                                                        <div class="fieldvalue">
                                                                            <?php if ($this->resume2->institute_state2 !='') echo $this->resume2->institute_state2; else echo $this->resume->institute_state;?>
                                                                        </div>
                                                                    </div>				        
							<?php } ?>
					<?php break;
						case "institute_city":  $isodd = 1 - $isodd; ?>
							<?php  if (($section_education == 1) && ($section_sub_institute == 1)) { ?>
                                                                    <div class="fieldwrapper view">
                                                                        <div class="fieldtitle">
                                                                            <?php echo JText::_('JS_CITY'); ?>:
                                                                        </div>
                                                                        <div class="fieldvalue">
                                                                            <?php if ($this->resume2->institute_city2 !='') echo $this->resume2->institute_city2; else echo $this->resume->institute_city;?>
                                                                        </div>
                                                                    </div>				        
							<?php } ?>

					<?php break;
						case "section_sub_institute1":  ?>
							<?php  if (($section_education == 1) && ($section_sub_institute1 == 1)) { ?>
                                                                        <span class="js_controlpanel_section_title">
                                                                            <?php echo JText::_('JS_UNIVERSITY'); ?>
                                                                        </span>				        
							<?php } ?>
					<?php break;
						case "institute1_institute":  $isodd = 1 - $isodd; ?>
							<?php  if (($section_education == 1) && ($section_sub_institute1 == 1)) { ?>
                                                                    <div class="fieldwrapper view">
                                                                        <div class="fieldtitle">
                                                                            <?php echo JText::_('JS_SCH_COL_UNI'); ?>:
                                                                        </div>
                                                                        <div class="fieldvalue">
                                                                            <?php if (isset($this->resume)) echo $this->resume->institute1;?>
                                                                        </div>
                                                                    </div>				        
							<?php } ?>
					<?php break;
						case "institute1_certificate":  $isodd = 1 - $isodd; ?>
							<?php  if (($section_education == 1) && ($section_sub_institute1 == 1)) { ?>
                                                                    <div class="fieldwrapper view">
                                                                        <div class="fieldtitle">
                                                                            <?php echo JText::_('JS_CRT_DEG_OTH'); ?>:
                                                                        </div>
                                                                        <div class="fieldvalue">
                                                                            <?php if (isset($this->resume)) echo $this->resume->institute1_certificate_name;?>
                                                                        </div>
                                                                    </div>				        
							<?php } ?>
					<?php break;
						case "institute1_study_area":  $isodd = 1 - $isodd; ?>
							<?php  if (($section_education == 1) && ($section_sub_institute1 == 1)) { ?>
                                                                    <div class="fieldwrapper view">
                                                                        <div class="fieldtitle">
                                                                            <?php echo JText::_('JS_AREA_OF_STUDY'); ?>:
                                                                        </div>
                                                                        <div class="fieldvalue">
                                                                            <?php if (isset($this->resume)) echo $this->resume->institute1_study_area;?>
                                                                        </div>
                                                                    </div>				        
							<?php } ?>
					<?php break;
						case "institute1_country":  $isodd = 1 - $isodd; ?>
							<?php  if (($section_education == 1) && ($section_sub_institute1 == 1)) { ?>
                                                                    <div class="fieldwrapper view">
                                                                        <div class="fieldtitle">
                                                                            <?php echo JText::_('JS_COUNTRY'); ?>:
                                                                        </div>
                                                                        <div class="fieldvalue">
                                                                            <?php echo $this->resume2->institute1_country; ?>
                                                                        </div>
                                                                    </div>				        
							<?php } ?>
					<?php break;
						case "institute1_state":  $isodd = 1 - $isodd; ?>
							<?php  if (($section_education == 1) && ($section_sub_institute1 == 1)) { ?>
                                                                    <div class="fieldwrapper view">
                                                                        <div class="fieldtitle">
                                                                            <?php echo JText::_('JS_STATE'); ?>:
                                                                        </div>
                                                                        <div class="fieldvalue">
                                                                            <?php if ($this->resume2->institute1_state2 !='') echo $this->resume2->institute1_state2; else echo $this->resume->institute1_state;?>
                                                                        </div>
                                                                    </div>				        
							<?php } ?>
					<?php break;
						case "institute1_city":  $isodd = 1 - $isodd; ?>
							<?php  if (($section_education == 1) && ($section_sub_institute1 == 1)) { ?>
                                                                    <div class="fieldwrapper view">
                                                                        <div class="fieldtitle">
                                                                            <?php echo JText::_('JS_CITY'); ?>:
                                                                        </div>
                                                                        <div class="fieldvalue">
                                                                            <?php if ($this->resume2->institute1_city2 !='') echo $this->resume2->institute1_city2; else echo $this->resume->institute1_city;?>
                                                                        </div>
                                                                    </div>				        
							<?php } ?>
					<?php break;
						case "section_sub_institute2": ?>
							<?php  if (($section_education == 1) && ($section_sub_institute2 == 1)) { ?>
                                                                    <span class="js_controlpanel_section_title">
                                                                        <?php echo JText::_('JS_GRADE_SCHOOL'); ?>
                                                                    </span>				        
							<?php } ?>
					<?php break;
						case "institute2_institute":  $isodd = 1 - $isodd; ?>
							<?php  if (($section_education == 1) && ($section_sub_institute2 == 1)) { ?>
                                                                    <div class="fieldwrapper view">
                                                                        <div class="fieldtitle">
                                                                            <?php echo JText::_('JS_SCH_COL_UNI'); ?>:
                                                                        </div>
                                                                        <div class="fieldvalue">
                                                                            <?php if (isset($this->resume)) echo $this->resume->institute2;?>
                                                                        </div>
                                                                    </div>				        
							<?php } ?>
					<?php break;
						case "institute2_certificate":  $isodd = 1 - $isodd; ?>
							<?php  if (($section_education == 1) && ($section_sub_institute2 == 1)) { ?>
                                                                    <div class="fieldwrapper view">
                                                                        <div class="fieldtitle">
                                                                            <?php echo JText::_('JS_CRT_DEG_OTH'); ?>:
                                                                        </div>
                                                                        <div class="fieldvalue">
                                                                            <?php if (isset($this->resume)) echo $this->resume->institute2_certificate_name;?>
                                                                        </div>
                                                                    </div>				        
							<?php } ?>
					<?php break;
						case "institute2_study_area":  $isodd = 1 - $isodd; ?>
							<?php  if (($section_education == 1) && ($section_sub_institute2 == 1)) { ?>
                                                                    <div class="fieldwrapper view">
                                                                        <div class="fieldtitle">
                                                                            <?php echo JText::_('JS_AREA_OF_STUDY'); ?>:
                                                                        </div>
                                                                        <div class="fieldvalue">
                                                                            <?php if (isset($this->resume)) echo $this->resume->institute2_study_area;?>
                                                                        </div>
                                                                    </div>				        
							<?php } ?>
					<?php break;
						case "institute2_country":  $isodd = 1 - $isodd; ?>
							<?php  if (($section_education == 1) && ($section_sub_institute2 == 1)) { ?>
                                                                    <div class="fieldwrapper view">
                                                                        <div class="fieldtitle">
                                                                            <?php echo JText::_('JS_COUNTRY'); ?>:
                                                                        </div>
                                                                        <div class="fieldvalue">
                                                                            <?php echo $this->resume2->institute2_country; ?>
                                                                        </div>
                                                                    </div>				        
							<?php } ?>
					<?php break;
						case "institute2_state":  $isodd = 1 - $isodd; ?>
							<?php  if (($section_education == 1) && ($section_sub_institute2 == 1)) { ?>
                                                                    <div class="fieldwrapper view">
                                                                        <div class="fieldtitle">
                                                                            <?php echo JText::_('JS_STATE'); ?>:
                                                                        </div>
                                                                        <div class="fieldvalue">
                                                                            <?php if ($this->resume2->institute2_state2 !='') echo $this->resume2->institute2_state2; else echo $this->resume->institute2_state;?>
                                                                        </div>
                                                                    </div>				        
							<?php } ?>
					<?php break;
						case "institute2_city":  $isodd = 1 - $isodd; ?>
							<?php  if (($section_education == 1) && ($section_sub_institute2 == 1)) { ?>
                                                                    <div class="fieldwrapper view">
                                                                        <div class="fieldtitle">
                                                                            <?php echo JText::_('JS_CITY'); ?>:
                                                                        </div>
                                                                        <div class="fieldvalue">
                                                                            <?php if ($this->resume2->institute2_city2 !='') echo $this->resume2->institute2_city2; else echo $this->resume->institute2_city;?>
                                                                        </div>
                                                                    </div>				        
							<?php } ?>
					<?php break;
						case "section_sub_institute3": ?>
							<?php  if (($section_education == 1) && ($section_sub_institute3 == 1)) { ?>
                                                                    <span class="js_controlpanel_section_title">
                                                                        <?php echo JText::_('JS_OTHER_SCHOOL'); ?>
                                                                    </span>				        
							<?php } ?>
					<?php break;
						case "institute3_institute":  $isodd = 1 - $isodd; ?>
							<?php  if (($section_education == 1) && ($section_sub_institute3 == 1)) { ?>
                                                                    <div class="fieldwrapper view">
                                                                        <div class="fieldtitle">
                                                                            <?php echo JText::_('JS_SCH_COL_UNI'); ?>:
                                                                        </div>
                                                                        <div class="fieldvalue">
                                                                            <?php if (isset($this->resume)) echo $this->resume->institute3;?>
                                                                        </div>
                                                                    </div>				        
							<?php } ?>
					<?php break;
						case "institute3_certificate":  $isodd = 1 - $isodd; ?>
							<?php  if (($section_education == 1) && ($section_sub_institute3 == 1)) { ?>
                                                                    <div class="fieldwrapper view">
                                                                        <div class="fieldtitle">
                                                                            <?php echo JText::_('JS_CRT_DEG_OTH'); ?>:
                                                                        </div>
                                                                        <div class="fieldvalue">
                                                                            <?php if (isset($this->resume)) echo $this->resume->institute3_certificate_name;?>
                                                                        </div>
                                                                    </div>				        
							<?php } ?>
					<?php break;
						case "institute3_study_area":  $isodd = 1 - $isodd; ?>
							<?php  if (($section_education == 1) && ($section_sub_institute3 == 1)) { ?>
                                                                    <div class="fieldwrapper view">
                                                                        <div class="fieldtitle">
                                                                            <?php echo JText::_('JS_AREA_OF_STUDY'); ?>:
                                                                        </div>
                                                                        <div class="fieldvalue">
                                                                            <?php if (isset($this->resume)) echo $this->resume->institute3_study_area;?>
                                                                        </div>
                                                                    </div>				        
							<?php } ?>
					<?php break;
						case "institute3_country":  $isodd = 1 - $isodd; ?>
							<?php  if (($section_education == 1) && ($section_sub_institute3 == 1)) { ?>
                                                                    <div class="fieldwrapper view">
                                                                        <div class="fieldtitle">
                                                                            <?php echo JText::_('JS_COUNTRY'); ?>:
                                                                        </div>
                                                                        <div class="fieldvalue">
                                                                            <?php echo $this->resume2->institute3_country; ?>
                                                                        </div>
                                                                    </div>				        
							<?php } ?>
					<?php break;
						case "institute3_state":  $isodd = 1 - $isodd; ?>
							<?php  if (($section_education == 1) && ($section_sub_institute3 == 1)) { ?>
                                                                    <div class="fieldwrapper view">
                                                                        <div class="fieldtitle">
                                                                            <?php echo JText::_('JS_STATE'); ?>:
                                                                        </div>
                                                                        <div class="fieldvalue">
                                                                            <?php if ($this->resume2->institute3_state2 !='') echo $this->resume2->institute3_state2; else echo $this->resume->institute3_state;?>
                                                                        </div>
                                                                    </div>				        
							<?php } ?>
					<?php break;
						case "institute3_city":  $isodd = 1 - $isodd; ?>
							<?php  if (($section_education == 1) && ($section_sub_institute3 == 1)) { ?>
                                                                    <div class="fieldwrapper view">
                                                                        <div class="fieldtitle">
                                                                            <?php echo JText::_('JS_CITY'); ?>:
                                                                        </div>
                                                                        <div class="fieldvalue">
                                                                            <?php if ($this->resume2->institute3_city2 !='') echo $this->resume2->institute3_city2; else echo $this->resume->institute3_city;?>
                                                                        </div>
                                                                    </div>				        
							<?php } ?>
					<?php break;
						case "section_employer": ?>
							</div>
                                                        <div id="employer_data">
                                                            <?php  if (($section_employer == 1) && ($section_sub_employer == 1)) { ?>
                                                                    <span class="js_controlpanel_section_title">
                                                                        <?php echo JText::_('JS_RECENT_EMPLOYER'); ?>
                                                                    </span>				        
                                                            <?php } ?>
					<?php break;
						case "employer_employer":  $isodd = 1 - $isodd; ?>
							<?php  if (($section_employer == 1) && ($section_sub_employer == 1)) { ?>
                                                                    <div class="fieldwrapper view">
                                                                        <div class="fieldtitle">
                                                                            <?php echo JText::_('JS_EMPLOYER'); ?>:
                                                                        </div>
                                                                        <div class="fieldvalue">
                                                                            <?php if (isset($this->resume)) echo $this->resume->employer;?>
                                                                        </div>
                                                                    </div>				        
							<?php } ?>
					<?php break;
						case "employer_position":  $isodd = 1 - $isodd; ?>
							<?php  if (($section_employer == 1) && ($section_sub_employer == 1)) { ?>
                                                                    <div class="fieldwrapper view">
                                                                        <div class="fieldtitle">
                                                                            <?php echo JText::_('JS_POSITION'); ?>:
                                                                        </div>
                                                                        <div class="fieldvalue">
                                                                            <?php if (isset($this->resume)) echo $this->resume->employer_position;?>
                                                                        </div>
                                                                    </div>				        
							<?php } ?>
					<?php break;
						case "employer_resp":  $isodd = 1 - $isodd; ?>
							<?php  if (($section_employer == 1) && ($section_sub_employer == 1)) { ?>
                                                                    <div class="fieldwrapper view">
                                                                        <div class="fieldtitle">
                                                                            <?php echo JText::_('JS_RESPONSIBILITIES'); ?>:
                                                                        </div>
                                                                        <div class="fieldvalue">
                                                                            <?php if (isset($this->resume)) echo $this->resume->employer_resp;?>
                                                                        </div>
                                                                    </div>				        
							<?php } ?>
					<?php break;
						case "employer_pay_upon_leaving":  $isodd = 1 - $isodd; ?>
							<?php  if (($section_employer == 1) && ($section_sub_employer == 1)) { ?>
                                                                    <div class="fieldwrapper view">
                                                                        <div class="fieldtitle">
                                                                            <?php echo JText::_('JS_PAY_UPON_LEAVING'); ?>:
                                                                        </div>
                                                                        <div class="fieldvalue">
                                                                            <?php if (isset($this->resume)) echo $this->resume->employer_pay_upon_leaving;?>
                                                                        </div>
                                                                    </div>				        
							<?php } ?>
					<?php break;
						case "employer_supervisor":  $isodd = 1 - $isodd; ?>
							<?php  if (($section_employer == 1) && ($section_sub_employer == 1)) { ?>
                                                                    <div class="fieldwrapper view">
                                                                        <div class="fieldtitle">
                                                                            <?php echo JText::_('JS_SUPERVISOR'); ?>:
                                                                        </div>
                                                                        <div class="fieldvalue">
                                                                            <?php if (isset($this->resume)) echo $this->resume->employer_supervisor;?>
                                                                        </div>
                                                                    </div>				        
							<?php } ?>
					<?php break;
						case "employer_from_date":  $isodd = 1 - $isodd; ?>
							<?php  if (($section_employer == 1) && ($section_sub_employer == 1)) { ?>
                                                                    <div class="fieldwrapper view">
                                                                        <div class="fieldtitle">
                                                                            <?php echo JText::_('JS_FROM_DATE'); ?>:
                                                                        </div>
                                                                        <div class="fieldvalue">
                                                                            <?php if (isset($this->resume)) echo $this->resume->employer_from_date;?>
                                                                        </div>
                                                                    </div>				        
							<?php } ?>
					<?php break;
						case "employer_to_date":  $isodd = 1 - $isodd; ?>
							<?php  if (($section_employer == 1) && ($section_sub_employer == 1)) { ?>
                                                                    <div class="fieldwrapper view">
                                                                        <div class="fieldtitle">
                                                                            <?php echo JText::_('JS_TO_DATE'); ?>:
                                                                        </div>
                                                                        <div class="fieldvalue">
                                                                            <?php if (isset($this->resume)) echo $this->resume->employer_to_date;?>
                                                                        </div>
                                                                    </div>				        
							<?php } ?>
					<?php break;
						case "employer_leave_reason":  $isodd = 1 - $isodd; ?>
							<?php  if (($section_employer == 1) && ($section_sub_employer == 1)) { ?>
                                                                    <div class="fieldwrapper view">
                                                                        <div class="fieldtitle">
                                                                            <?php echo JText::_('JS_LEAVING_REASON'); ?>:
                                                                        </div>
                                                                        <div class="fieldvalue">
                                                                            <?php if (isset($this->resume)) echo $this->resume->employer_leave_reason;?>
                                                                        </div>
                                                                    </div>				        
							<?php } ?>
					<?php break;
						case "employer_country":  $isodd = 1 - $isodd; ?>
							<?php  if (($section_employer == 1) && ($section_sub_employer == 1)) { ?>
                                                                    <div class="fieldwrapper view">
                                                                        <div class="fieldtitle">
                                                                            <?php echo JText::_('JS_COUNTRY'); ?>:
                                                                        </div>
                                                                        <div class="fieldvalue">
                                                                            <?php echo $this->resume2->employer_country; ?>
                                                                        </div>
                                                                    </div>				        
							<?php } ?>
					<?php break;
						case "employer_state":  $isodd = 1 - $isodd; ?>
							<?php  if (($section_employer == 1) && ($section_sub_employer == 1)) { ?>
                                                                    <div class="fieldwrapper view">
                                                                        <div class="fieldtitle">
                                                                            <?php echo JText::_('JS_STATE'); ?>:
                                                                        </div>
                                                                        <div class="fieldvalue">
                                                                            <?php if ($this->resume2->employer_state2 !='') echo $this->resume2->employer_state2; else echo $this->resume->employer_state;?>
                                                                        </div>
                                                                    </div>				        
							<?php } ?>
					<?php break;
						case "employer_city":  $isodd = 1 - $isodd; ?>
							<?php  if (($section_employer == 1) && ($section_sub_employer == 1)) { ?>
                                                                    <div class="fieldwrapper view">
                                                                        <div class="fieldtitle">
                                                                            <?php echo JText::_('JS_CITY'); ?>:
                                                                        </div>
                                                                        <div class="fieldvalue">
                                                                            <?php if ($this->resume2->employer_city2 !='') echo $this->resume2->employer_city2; else echo $this->resume->employer_city;?>
                                                                        </div>
                                                                    </div>				        
							<?php } ?>
					<?php break;
						case "employer_zip":  $isodd = 1 - $isodd; ?>
							<?php  if (($section_employer == 1) && ($section_sub_employer == 1)) { ?>
                                                                    <div class="fieldwrapper view">
                                                                        <div class="fieldtitle">
                                                                            <?php echo JText::_('JS_ZIPCODE'); ?>:
                                                                        </div>
                                                                        <div class="fieldvalue">
                                                                            <?php if (isset($this->resume)) echo $this->resume->employer_zip;?>
                                                                        </div>
                                                                    </div>				        
							<?php } ?>
					<?php break;
						case "employer_address":  $isodd = 1 - $isodd; ?>
							<?php  if (($section_employer == 1) && ($section_sub_employer == 1)) { ?>
                                                                    <div class="fieldwrapper view">
                                                                        <div class="fieldtitle">
                                                                            <?php echo JText::_('JS_ADDRESS'); ?>:
                                                                        </div>
                                                                        <div class="fieldvalue">
                                                                            <?php if (isset($this->resume)) echo $this->resume->employer_address;?>
                                                                        </div>
                                                                    </div>				        
						<?php } ?>	
					<?php break;
						case "employer_phone":  $isodd = 1 - $isodd; ?>
							<?php  if (($section_employer == 1) && ($section_sub_employer == 1)) { ?>
                                                                    <div class="fieldwrapper view">
                                                                        <div class="fieldtitle">
                                                                            <?php echo JText::_('JS_PHONE'); ?>:
                                                                        </div>
                                                                        <div class="fieldvalue">
                                                                            <?php if (isset($this->resume)) echo $this->resume->employer_phone;?>
                                                                        </div>
                                                                    </div>				        
							<?php } ?>


					<?php break;
						case "section_sub_employer1": ?>
							<?php  if (($section_employer == 1) && ($section_sub_employer1 == 1)) { ?>
                                                            <span class="js_controlpanel_section_title">
                                                                <?php echo JText::_('JS_PRIOR_EMPLOYER_1'); ?>
                                                            </span>				        
							<?php } ?>
					<?php break;
						case "employer1_employer":  $isodd = 1 - $isodd; ?>
							<?php  if (($section_employer == 1) && ($section_sub_employer1 == 1)) { ?>
                                                                    <div class="fieldwrapper view">
                                                                        <div class="fieldtitle">
                                                                            <?php echo JText::_('JS_EMPLOYER'); ?>:
                                                                        </div>
                                                                        <div class="fieldvalue">
                                                                            <?php if (isset($this->resume)) echo $this->resume->employer1;?>
                                                                        </div>
                                                                    </div>				        
							<?php } ?>
					<?php break;
						case "employer1_position":  $isodd = 1 - $isodd; ?>
							<?php  if (($section_employer == 1) && ($section_sub_employer1 == 1)) { ?>
                                                                    <div class="fieldwrapper view">
                                                                        <div class="fieldtitle">
                                                                            <?php echo JText::_('JS_POSITION'); ?>:
                                                                        </div>
                                                                        <div class="fieldvalue">
                                                                            <?php if (isset($this->resume)) echo $this->resume->employer1_position;?>
                                                                        </div>
                                                                    </div>				        
							<?php } ?>
					<?php break;
						case "employer1_resp":  $isodd = 1 - $isodd; ?>
							<?php  if (($section_employer == 1) && ($section_sub_employer1 == 1)) { ?>
                                                                    <div class="fieldwrapper view">
                                                                        <div class="fieldtitle">
                                                                            <?php echo JText::_('JS_RESPONSIBILITIES'); ?>:
                                                                        </div>
                                                                        <div class="fieldvalue">
                                                                            <?php if (isset($this->resume)) echo $this->resume->employer1_resp;?>
                                                                        </div>
                                                                    </div>				        
							<?php } ?>
					<?php break;
						case "employer1_pay_upon_leaving":  $isodd = 1 - $isodd; ?>
							<?php  if (($section_employer == 1) && ($section_sub_employer1 == 1)) { ?>
                                                                    <div class="fieldwrapper view">
                                                                        <div class="fieldtitle">
                                                                            <?php echo JText::_('JS_PAY_UPON_LEAVING'); ?>:
                                                                        </div>
                                                                        <div class="fieldvalue">
                                                                            <?php if (isset($this->resume)) echo $this->resume->employer1_pay_upon_leaving;?>
                                                                        </div>
                                                                    </div>				        
							<?php } ?>
					<?php break;
						case "employer1_supervisor":  $isodd = 1 - $isodd; ?>
							<?php  if (($section_employer == 1) && ($section_sub_employer1 == 1)) { ?>
                                                                    <div class="fieldwrapper view">
                                                                        <div class="fieldtitle">
                                                                            <?php echo JText::_('JS_SUPERVISOR'); ?>:
                                                                        </div>
                                                                        <div class="fieldvalue">
                                                                            <?php if (isset($this->resume)) echo $this->resume->employer1_supervisor;?>
                                                                        </div>
                                                                    </div>				        
							<?php } ?>
					<?php break;
						case "employer1_from_date":  $isodd = 1 - $isodd; ?>
							<?php  if (($section_employer == 1) && ($section_sub_employer1 == 1)) { ?>
                                                                    <div class="fieldwrapper view">
                                                                        <div class="fieldtitle">
                                                                            <?php echo JText::_('JS_FROM_DATE'); ?>:
                                                                        </div>
                                                                        <div class="fieldvalue">
                                                                            <?php if (isset($this->resume)) echo $this->resume->employer1_from_date;?>
                                                                        </div>
                                                                    </div>				        
							<?php } ?>
					<?php break;
						case "employer1_to_date":  $isodd = 1 - $isodd; ?>
							<?php  if (($section_employer == 1) && ($section_sub_employer1 == 1)) { ?>
                                                                    <div class="fieldwrapper view">
                                                                        <div class="fieldtitle">
                                                                            <?php echo JText::_('JS_TO_DATE'); ?>:
                                                                        </div>
                                                                        <div class="fieldvalue">
                                                                            <?php if (isset($this->resume)) echo $this->resume->employer1_to_date;?>
                                                                        </div>
                                                                    </div>				        
							<?php } ?>
					<?php break;
						case "employer1_leave_reason":  $isodd = 1 - $isodd; ?>
							<?php  if (($section_employer == 1) && ($section_sub_employer1 == 1)) { ?>
                                                                    <div class="fieldwrapper view">
                                                                        <div class="fieldtitle">
                                                                            <?php echo JText::_('JS_LEAVING_REASON'); ?>:
                                                                        </div>
                                                                        <div class="fieldvalue">
                                                                            <?php if (isset($this->resume)) echo $this->resume->employer1_leave_reason;?>
                                                                        </div>
                                                                    </div>				        
							<?php } ?>
					<?php break;
						case "employer1_country":  $isodd = 1 - $isodd; ?>
							<?php  if (($section_employer == 1) && ($section_sub_employer1 == 1)) { ?>
                                                                    <div class="fieldwrapper view">
                                                                        <div class="fieldtitle">
                                                                            <?php echo JText::_('JS_COUNTRY'); ?>:
                                                                        </div>
                                                                        <div class="fieldvalue">
                                                                            <?php echo $this->resume2->employer1_country; ?>
                                                                        </div>
                                                                    </div>				        
							<?php } ?>
					<?php break;
						case "employer1_state":  $isodd = 1 - $isodd; ?>
							<?php  if (($section_employer == 1) && ($section_sub_employer1 == 1)) { ?>
                                                                    <div class="fieldwrapper view">
                                                                        <div class="fieldtitle">
                                                                            <?php echo JText::_('JS_STATE'); ?>:
                                                                        </div>
                                                                        <div class="fieldvalue">
                                                                            <?php if ($this->resume2->employer1_state2 !='') echo $this->resume2->employer1_state2; else echo $this->resume->employer1_state;?>
                                                                        </div>
                                                                    </div>				        
							<?php } ?>
					<?php break;
						case "employer1_city":  $isodd = 1 - $isodd; ?>
							<?php  if (($section_employer == 1) && ($section_sub_employer1 == 1)) { ?>
                                                                    <div class="fieldwrapper view">
                                                                        <div class="fieldtitle">
                                                                            <?php echo JText::_('JS_CITY'); ?>:
                                                                        </div>
                                                                        <div class="fieldvalue">
                                                                            <?php if ($this->resume2->employer1_city2 !='') echo $this->resume2->employer1_city2; else echo $this->resume->employer1_city;?>
                                                                        </div>
                                                                    </div>				        
							<?php } ?>
					<?php break;
						case "employer1_zip":  $isodd = 1 - $isodd; ?>
							<?php  if (($section_employer == 1) && ($section_sub_employer1 == 1)) { ?>
                                                                    <div class="fieldwrapper view">
                                                                        <div class="fieldtitle">
                                                                            <?php echo JText::_('JS_ZIPCODE'); ?>:
                                                                        </div>
                                                                        <div class="fieldvalue">
                                                                            <?php if (isset($this->resume)) echo $this->resume->employer1_zip;?>
                                                                        </div>
                                                                    </div>				        
							<?php } ?>
					<?php break;
						case "employer1_address":  $isodd = 1 - $isodd; ?>
							<?php  if (($section_employer == 1) && ($section_sub_employer1 == 1)) { ?>
                                                                    <div class="fieldwrapper view">
                                                                        <div class="fieldtitle">
                                                                            <?php echo JText::_('JS_ADDRESS'); ?>:
                                                                        </div>
                                                                        <div class="fieldvalue">
                                                                            <?php if (isset($this->resume)) echo $this->resume->employer1_address;?>
                                                                        </div>
                                                                    </div>				        
						<?php } ?>	
					<?php break;
						case "employer1_phone":  $isodd = 1 - $isodd; ?>
							<?php  if (($section_employer == 1) && ($section_sub_employer1 == 1)) { ?>
                                                                    <div class="fieldwrapper view">
                                                                        <div class="fieldtitle">
                                                                            <?php echo JText::_('JS_PHONE'); ?>:
                                                                        </div>
                                                                        <div class="fieldvalue">
                                                                            <?php if (isset($this->resume)) echo $this->resume->employer1_phone;?>
                                                                        </div>
                                                                    </div>				        
							<?php } ?>
					<?php break;
						case "section_sub_employer2": ?>
							<?php  if (($section_employer == 1) && ($section_sub_employer2 == 1)) { ?>
                                                                    <span class="js_controlpanel_section_title">
                                                                        <?php echo JText::_('JS_PRIOR_EMPLOYER_2'); ?>
                                                                    </span>				        
							<?php } ?>
					<?php break;
						case "employer2_employer":  $isodd = 1 - $isodd; ?>
							<?php  if (($section_employer == 1) && ($section_sub_employer2 == 1)) { ?>
                                                                    <div class="fieldwrapper view">
                                                                        <div class="fieldtitle">
                                                                            <?php echo JText::_('JS_EMPLOYER'); ?>:
                                                                        </div>
                                                                        <div class="fieldvalue">
                                                                            <?php if (isset($this->resume)) echo $this->resume->employer2;?>
                                                                        </div>
                                                                    </div>				        
							<?php } ?>
					<?php break;
						case "employer2_position":  $isodd = 1 - $isodd; ?>
							<?php  if (($section_employer == 1) && ($section_sub_employer2 == 1)) { ?>
                                                                    <div class="fieldwrapper view">
                                                                        <div class="fieldtitle">
                                                                            <?php echo JText::_('JS_POSITION'); ?>:
                                                                        </div>
                                                                        <div class="fieldvalue">
                                                                            <?php if (isset($this->resume)) echo $this->resume->employer2_position;?>
                                                                        </div>
                                                                    </div>				        
							<?php } ?>
					<?php break;
						case "employer2_resp":  $isodd = 1 - $isodd; ?>
							<?php  if (($section_employer == 1) && ($section_sub_employer2 == 1)) { ?>
                                                                    <div class="fieldwrapper view">
                                                                        <div class="fieldtitle">
                                                                            <?php echo JText::_('JS_RESPONSIBILITIES'); ?>:
                                                                        </div>
                                                                        <div class="fieldvalue">
                                                                            <?php if (isset($this->resume)) echo $this->resume->employer2_resp;?>
                                                                        </div>
                                                                    </div>				        
							<?php } ?>
					<?php break;
						case "employer2_pay_upon_leaving":  $isodd = 1 - $isodd; ?>
							<?php  if (($section_employer == 1) && ($section_sub_employer2 == 1)) { ?>
                                                                    <div class="fieldwrapper view">
                                                                        <div class="fieldtitle">
                                                                            <?php echo JText::_('JS_PAY_UPON_LEAVING'); ?>:
                                                                        </div>
                                                                        <div class="fieldvalue">
                                                                            <?php if (isset($this->resume)) echo $this->resume->employer2_pay_upon_leaving;?>
                                                                        </div>
                                                                    </div>				        
							<?php } ?>
					<?php break;
						case "employer2_supervisor":  $isodd = 1 - $isodd; ?>
							<?php  if (($section_employer == 1) && ($section_sub_employer2 == 1)) { ?>
                                                                    <div class="fieldwrapper view">
                                                                        <div class="fieldtitle">
                                                                            <?php echo JText::_('JS_SUPERVISOR'); ?>:
                                                                        </div>
                                                                        <div class="fieldvalue">
                                                                            <?php if (isset($this->resume)) echo $this->resume->employer2_supervisor;?>
                                                                        </div>
                                                                    </div>				        
							<?php } ?>
					<?php break;
						case "employer2_from_date":  $isodd = 1 - $isodd; ?>
							<?php  if (($section_employer == 1) && ($section_sub_employer2 == 1)) { ?>
                                                                    <div class="fieldwrapper view">
                                                                        <div class="fieldtitle">
                                                                            <?php echo JText::_('JS_FROM_DATE'); ?>:
                                                                        </div>
                                                                        <div class="fieldvalue">
                                                                            <?php if (isset($this->resume)) echo $this->resume->employer2_from_date;?>
                                                                        </div>
                                                                    </div>				        
							<?php } ?>
					<?php break;
						case "employer2_to_date":  $isodd = 1 - $isodd; ?>
							<?php  if (($section_employer == 1) && ($section_sub_employer2 == 1)) { ?>
                                                                    <div class="fieldwrapper view">
                                                                        <div class="fieldtitle">
                                                                            <?php echo JText::_('JS_TO_DATE'); ?>:
                                                                        </div>
                                                                        <div class="fieldvalue">
                                                                            <?php if (isset($this->resume)) echo $this->resume->employer2_to_date;?>
                                                                        </div>
                                                                    </div>				        
							<?php } ?>
					<?php break;
						case "employer2_leave_reason":  $isodd = 1 - $isodd; ?>
							<?php  if (($section_employer == 1) && ($section_sub_employer2 == 1)) { ?>
                                                                    <div class="fieldwrapper view">
                                                                        <div class="fieldtitle">
                                                                            <?php echo JText::_('JS_LEAVING_REASON'); ?>:
                                                                        </div>
                                                                        <div class="fieldvalue">
                                                                            <?php if (isset($this->resume)) echo $this->resume->employer2_leave_reason;?>
                                                                        </div>
                                                                    </div>				        
							<?php } ?>
					<?php break;
						case "employer2_country":  $isodd = 1 - $isodd; ?>
							<?php  if (($section_employer == 1) && ($section_sub_employer2 == 1)) { ?>
                                                                    <div class="fieldwrapper view">
                                                                        <div class="fieldtitle">
                                                                            <?php echo JText::_('JS_COUNTRY'); ?>:
                                                                        </div>
                                                                        <div class="fieldvalue">
                                                                            <?php echo $this->resume2->employer2_country; ?>
                                                                        </div>
                                                                    </div>				        
							<?php } ?>
					<?php break;
						case "employer2_state":  $isodd = 1 - $isodd; ?>
							<?php  if (($section_employer == 1) && ($section_sub_employer2 == 1)) { ?>
                                                                    <div class="fieldwrapper view">
                                                                        <div class="fieldtitle">
                                                                            <?php echo JText::_('JS_STATE'); ?>:
                                                                        </div>
                                                                        <div class="fieldvalue">
                                                                            <?php if ($this->resume2->employer2_state2 !='') echo $this->resume2->employer2_state2; else echo $this->resume->employer2_state;?>
                                                                        </div>
                                                                    </div>				        
							<?php } ?>
					<?php break;
						case "employer2_city":  $isodd = 1 - $isodd; ?>
							<?php  if (($section_employer == 1) && ($section_sub_employer2 == 1)) { ?>
                                                                    <div class="fieldwrapper view">
                                                                        <div class="fieldtitle">
                                                                            <?php echo JText::_('JS_CITY'); ?>:
                                                                        </div>
                                                                        <div class="fieldvalue">
                                                                            <?php if ($this->resume2->employer2_city2 !='') echo $this->resume2->employer2_city2; else echo $this->resume->employer2_city;?>
                                                                        </div>
                                                                    </div>				        
							<?php } ?>
					<?php break;
						case "employer2_zip":  $isodd = 1 - $isodd; ?>
							<?php  if (($section_employer == 1) && ($section_sub_employer2 == 1)) { ?>
                                                                    <div class="fieldwrapper view">
                                                                        <div class="fieldtitle">
                                                                            <?php echo JText::_('JS_ZIPCODE'); ?>:
                                                                        </div>
                                                                        <div class="fieldvalue">
                                                                            <?php if (isset($this->resume)) echo $this->resume->employer2_zip;?>
                                                                        </div>
                                                                    </div>				        
							<?php } ?>
					<?php break;
						case "employer2_address":  $isodd = 1 - $isodd; ?>
							<?php  if (($section_employer == 1) && ($section_sub_employer2 == 1)) { ?>
                                                                    <div class="fieldwrapper view">
                                                                        <div class="fieldtitle">
                                                                            <?php echo JText::_('JS_ADDRESS'); ?>:
                                                                        </div>
                                                                        <div class="fieldvalue">
                                                                            <?php if (isset($this->resume)) echo $this->resume->employer2_address;?>
                                                                        </div>
                                                                    </div>				        
						<?php } ?>	
				<?php break;
						case "employer2_phone":  $isodd = 1 - $isodd; ?>
							<?php  if (($section_employer == 1) && ($section_sub_employer2 == 1)) { ?>
                                                                    <div class="fieldwrapper view">
                                                                        <div class="fieldtitle">
                                                                            <?php echo JText::_('JS_PHONE'); ?>:
                                                                        </div>
                                                                        <div class="fieldvalue">
                                                                            <?php if (isset($this->resume)) echo $this->resume->employer2_phone;?>
                                                                        </div>
                                                                    </div>				        
							<?php } ?>
					<?php break;
						case "section_sub_employer3": ?>
							<?php  if (($section_employer == 1) && ($section_sub_employer3 == 1)) { ?>
                                                                    <span class="js_controlpanel_section_title">
                                                                        <?php echo JText::_('JS_PRIOR_EMPLOYER_3'); ?>
                                                                    </span>				        
							<?php } ?>
					<?php break;
						case "employer3_employer":  $isodd = 1 - $isodd; ?>
							<?php  if (($section_employer == 1) && ($section_sub_employer3 == 1)) { ?>
                                                                    <div class="fieldwrapper view">
                                                                        <div class="fieldtitle">
                                                                            <?php echo JText::_('JS_EMPLOYER'); ?>:
                                                                        </div>
                                                                        <div class="fieldvalue">
                                                                            <?php if (isset($this->resume)) echo $this->resume->employer3;?>
                                                                        </div>
                                                                    </div>				        
							<?php } ?>
					<?php break;
						case "employer3_position":  $isodd = 1 - $isodd; ?>
							<?php  if (($section_employer == 1) && ($section_sub_employer3 == 1)) { ?>
                                                                    <div class="fieldwrapper view">
                                                                        <div class="fieldtitle">
                                                                            <?php echo JText::_('JS_POSITION'); ?>:
                                                                        </div>
                                                                        <div class="fieldvalue">
                                                                            <?php if (isset($this->resume)) echo $this->resume->employer3_position;?>
                                                                        </div>
                                                                    </div>				        
							<?php } ?>
					<?php break;
						case "employer3_resp":  $isodd = 1 - $isodd; ?>
							<?php  if (($section_employer == 1) && ($section_sub_employer3 == 1)) { ?>
                                                                    <div class="fieldwrapper view">
                                                                        <div class="fieldtitle">
                                                                            <?php echo JText::_('JS_RESPONSIBILITIES'); ?>:
                                                                        </div>
                                                                        <div class="fieldvalue">
                                                                            <?php if (isset($this->resume)) echo $this->resume->employer3_resp;?>
                                                                        </div>
                                                                    </div>				        
							<?php } ?>
					<?php break;
						case "employer3_pay_upon_leaving":  $isodd = 1 - $isodd; ?>
							<?php  if (($section_employer == 1) && ($section_sub_employer3 == 1)) { ?>
                                                                    <div class="fieldwrapper view">
                                                                        <div class="fieldtitle">
                                                                            <?php echo JText::_('JS_PAY_UPON_LEAVING'); ?>:
                                                                        </div>
                                                                        <div class="fieldvalue">
                                                                            <?php if (isset($this->resume)) echo $this->resume->employer3_pay_upon_leaving;?>
                                                                        </div>
                                                                    </div>				        
							<?php } ?>
					<?php break;
						case "employer3_supervisor":  $isodd = 1 - $isodd; ?>
							<?php  if (($section_employer == 1) && ($section_sub_employer3 == 1)) { ?>
                                                                    <div class="fieldwrapper view">
                                                                        <div class="fieldtitle">
                                                                            <?php echo JText::_('JS_SUPERVISOR'); ?>:
                                                                        </div>
                                                                        <div class="fieldvalue">
                                                                            <?php if (isset($this->resume)) echo $this->resume->employer3_supervisor;?>
                                                                        </div>
                                                                    </div>				        
							<?php } ?>
					<?php break;
						case "employer3_from_date":  $isodd = 1 - $isodd; ?>
							<?php  if (($section_employer == 1) && ($section_sub_employer3 == 1)) { ?>
                                                                    <div class="fieldwrapper view">
                                                                        <div class="fieldtitle">
                                                                            <?php echo JText::_('JS_FROM_DATE'); ?>:
                                                                        </div>
                                                                        <div class="fieldvalue">
                                                                            <?php if (isset($this->resume)) echo $this->resume->employer3_from_date;?>
                                                                        </div>
                                                                    </div>				        
							<?php } ?>
					<?php break;
						case "employer3_to_date":  $isodd = 1 - $isodd; ?>
							<?php  if (($section_employer == 1) && ($section_sub_employer3 == 1)) { ?>
                                                                    <div class="fieldwrapper view">
                                                                        <div class="fieldtitle">
                                                                            <?php echo JText::_('JS_TO_DATE'); ?>:
                                                                        </div>
                                                                        <div class="fieldvalue">
                                                                            <?php if (isset($this->resume)) echo $this->resume->employer3_to_date;?>
                                                                        </div>
                                                                    </div>				        
							<?php } ?>
					<?php break;
						case "employer3_leave_reason":  $isodd = 1 - $isodd; ?>
							<?php  if (($section_employer == 1) && ($section_sub_employer3 == 1)) { ?>
                                                                    <div class="fieldwrapper view">
                                                                        <div class="fieldtitle">
                                                                            <?php echo JText::_('JS_LEAVING_REASON'); ?>:
                                                                        </div>
                                                                        <div class="fieldvalue">
                                                                            <?php if (isset($this->resume)) echo $this->resume->employer3_leave_reason;?>
                                                                        </div>
                                                                    </div>				        
							<?php } ?>
					<?php break;
						case "employer3_country":  $isodd = 1 - $isodd; ?>
							<?php  if (($section_employer == 1) && ($section_sub_employer3 == 1)) { ?>
                                                                    <div class="fieldwrapper view">
                                                                        <div class="fieldtitle">
                                                                            <?php echo JText::_('JS_COUNTRY'); ?>:
                                                                        </div>
                                                                        <div class="fieldvalue">
                                                                            <?php echo $this->resume2->employer3_country; ?>
                                                                        </div>
                                                                    </div>				        
							<?php } ?>
					<?php break;
						case "employer3_state":  $isodd = 1 - $isodd; ?>
							<?php  if (($section_employer == 1) && ($section_sub_employer3 == 1)) { ?>
                                                                    <div class="fieldwrapper view">
                                                                        <div class="fieldtitle">
                                                                            <?php echo JText::_('JS_STATE'); ?>:
                                                                        </div>
                                                                        <div class="fieldvalue">
                                                                            <?php if ($this->resume2->employer3_state2 !='') echo $this->resume2->employer3_state2; else echo $this->resume->employer3_state;?>
                                                                        </div>
                                                                    </div>				        
							<?php } ?>
					<?php break;
						case "employer3_city":  $isodd = 1 - $isodd; ?>
							<?php  if (($section_employer == 1) && ($section_sub_employer3 == 1)) { ?>
                                                                    <div class="fieldwrapper view">
                                                                        <div class="fieldtitle">
                                                                            <?php echo JText::_('JS_CITY'); ?>:
                                                                        </div>
                                                                        <div class="fieldvalue">
                                                                            <?php if ($this->resume2->employer3_city2 !='') echo $this->resume2->employer3_city2; else echo $this->resume->employer3_city;?>
                                                                        </div>
                                                                    </div>				        
							<?php } ?>
					<?php break;
						case "employer3_zip":  $isodd = 1 - $isodd; ?>
							<?php  if (($section_employer == 1) && ($section_sub_employer3 == 1)) { ?>
                                                                    <div class="fieldwrapper view">
                                                                        <div class="fieldtitle">
                                                                            <?php echo JText::_('JS_ZIPCODE'); ?>:
                                                                        </div>
                                                                        <div class="fieldvalue">
                                                                            <?php if (isset($this->resume)) echo $this->resume->employer3_zip;?>
                                                                        </div>
                                                                    </div>				        
							<?php } ?>
					<?php break;
						case "employer3_address":  $isodd = 1 - $isodd; ?>
							<?php  if (($section_employer == 1) && ($section_sub_employer3 == 1)) { ?>
                                                                    <div class="fieldwrapper view">
                                                                        <div class="fieldtitle">
                                                                            <?php echo JText::_('JS_ADDRESS'); ?>:
                                                                        </div>
                                                                        <div class="fieldvalue">
                                                                            <?php if (isset($this->resume)) echo $this->resume->employer3_address;?>
                                                                        </div>
                                                                    </div>				        
						<?php } ?>	
					<?php break;
						case "employer3_phone":  $isodd = 1 - $isodd; ?>
							<?php  if (($section_employer == 1) && ($section_sub_employer3 == 1)) { ?>
                                                                    <div class="fieldwrapper view">
                                                                        <div class="fieldtitle">
                                                                            <?php echo JText::_('JS_PHONE'); ?>:
                                                                        </div>
                                                                        <div class="fieldvalue">
                                                                            <?php if (isset($this->resume)) echo $this->resume->employer3_phone;?>
                                                                        </div>
                                                                    </div>				        
							<?php } ?>
							

					<?php break;
						case "section_skills": ?>
							</div>
                                                        <div id="skills_data">
                                                            <span class="js_controlpanel_section_title">
                                                                <?php echo JText::_('JS_SKILLS'); ?>
                                                            </span>				        
					<?php break;
						case "driving_license":  $isodd = 1 - $isodd; ?>
							<?php  if ($section_skills == 1) { ?>
                                                                    <div class="fieldwrapper view">
                                                                        <div class="fieldtitle">
                                                                            <?php echo JText::_('JS_HAVE_DRIVING_LICENSE'); ?>:
                                                                        </div>
                                                                        <div class="fieldvalue">
                                                                            <?php if (isset($this->resume)) echo $this->resume->driving_license; ?>
                                                                        </div>
                                                                    </div>				        
							<?php } ?>
					<?php break;
						case "license_no":  $isodd = 1 - $isodd; ?>
							<?php  if ($section_skills == 1) { ?>
                                                                    <div class="fieldwrapper view">
                                                                        <div class="fieldtitle">
                                                                            <?php echo JText::_('JS_YSE_LICENSE_NO'); ?>:
                                                                        </div>
                                                                        <div class="fieldvalue">
                                                                            <?php if (isset($this->resume)) echo $this->resume->license_no;?>
                                                                        </div>
                                                                    </div>				        
							<?php } ?>
					<?php break;
						case "license_country":  $isodd = 1 - $isodd; ?>
							<?php  if ($section_skills == 1) { ?>
                                                                    <div class="fieldwrapper view">
                                                                        <div class="fieldtitle">
                                                                            <?php echo JText::_('JS_YSE_LICENSE_COUNTRY'); ?>:
                                                                        </div>
                                                                        <div class="fieldvalue">
                                                                            <?php if (isset($this->resume)) echo $this->resume->license_country;?>
                                                                        </div>
                                                                    </div>				        
							<?php } ?>
					<?php break;
						case "skills":  $isodd = 1 - $isodd; ?>
							<?php  if ($section_skills == 1) { ?>
                                                                    <div class="fieldwrapper view">
                                                                        <div class="fieldtitle">
                                                                            <?php echo JText::_('JS_SKILLS'); ?>:
                                                                        </div>
                                                                        <div class="fieldvalue">
                                                                            <?php if(isset($this->resume)) echo $this->resume->skills; ?>
                                                                        </div>
                                                                    </div>				        
							<?php } ?>
										
										
					<?php break;
						case "section_resumeeditor": ?>
							</div>	
                                                        <div id="resume_editor_data" >
                                                            <span class="js_controlpanel_section_title">
                                                                <?php echo JText::_('JS_RESUME'); ?>
                                                            </span>				        
					<?php break;
						case "editor": ?>
							<?php  if ($section_resumeeditor == 1) { ?>
                                                                    <div class="fieldwrapper view">
                                                                        <?php echo $this->resume->resume; ?>
                                                                    </div>				        
							<?php } ?>
					<?php break;
						case "fileupload": ?>
							<?php  if ($section_resumeeditor == 1) { ?>
								<?php if (isset($this->resume)) 
											if($this->resume->filename != '') {?>
                                                                                            <div class="fieldwrapper view">
                                                                                                <div class="fieldtitle">
                                                                                                    <?php echo JText::_('JS_RESUME_FILE'); ?>
                                                                                                </div>
												<?php 
												if($this->isjobsharing){
													if($this->nav==2){
														$link = $this->resume->file_url; 
													}else{
                                                                                                            $link = $this->config['data_directory'].'/data/jobseeker/resume_'.$this->resume->id.'/resume/'.$this->resume->filename;
													}
												}else{
													$link = $this->config['data_directory'].'/data/jobseeker/resume_'.$this->resume->id.'/resume/'.$this->resume->filename;
													
												}
													?>
                                                                                                <div class="fieldvalue">
                                                                                                    <span id="button"><img src="components/com_jsjobs/images/resumedownload.png" width='17'/>&nbsp;<a class="button minpad" href="<?php echo $link ?>"><?php echo JText::_('JS_DOWNLOAD'); ?></a></span>
                                                                                                </div>
                                                                                            </div>				        
								<?php } ?>				
							<?php } ?>
						
						
					<?php break;
						case "section_references": ?>
							</div>
                                                        <div id="references_data">
                                                            <?php  if (($section_references == 1) && ($section_sub_reference == 1)) { ?>
                                                                        <span class="js_controlpanel_section_title">
                                                                            <?php echo JText::_('JS_REFERENCE1'); ?>
                                                                        </span>				        
                                                            <?php } ?>
							
					<?php break;
						case "reference_name":  $isodd = 1 - $isodd; ?>
							<?php  if (($section_references == 1) && ($section_sub_reference == 1)) { ?>
                                                                    <div class="fieldwrapper view">
                                                                        <div class="fieldtitle">
                                                                            <?php echo JText::_('JS_NAME'); ?>:
                                                                        </div>
                                                                        <div class="fieldvalue">
                                                                            <?php if (isset($this->resume)) echo $this->resume->reference_name;?>
                                                                        </div>
                                                                    </div>				        
							<?php } ?>
					<?php break;
						case "reference_country":  $isodd = 1 - $isodd; ?>
							<?php  if (($section_references == 1) && ($section_sub_reference == 1)) { ?>
                                                                    <div class="fieldwrapper view">
                                                                        <div class="fieldtitle">
                                                                            <?php echo JText::_('JS_COUNTRY'); ?>
                                                                        </div>
                                                                        <div class="fieldvalue">
                                                                            <?php echo $this->resume3->reference_country; ?>
                                                                        </div>
                                                                    </div>				        
							<?php } ?>
					<?php break;
						case "reference_state":  $isodd = 1 - $isodd; ?>
							<?php  if (($section_references == 1) && ($section_sub_reference == 1)) { ?>
                                                                    <div class="fieldwrapper view">
                                                                        <div class="fieldtitle">
                                                                            <?php echo JText::_('JS_STATE'); ?>:
                                                                        </div>
                                                                        <div class="fieldvalue">
                                                                            <?php if ($this->resume3->reference_state2 !='') echo $this->resume3->reference_state2; else echo $this->resume->reference_state;?>
                                                                        </div>
                                                                    </div>				        
							<?php } ?>
					<?php break;
						case "reference_city":  $isodd = 1 - $isodd; ?>
							<?php  if (($section_references == 1) && ($section_sub_reference == 1)) { ?>
                                                                    <div class="fieldwrapper view">
                                                                        <div class="fieldtitle">
                                                                            <?php echo JText::_('JS_CITY'); ?>:
                                                                        </div>
                                                                        <div class="fieldvalue">
                                                                            <?php if ($this->resume3->reference_city2 !='') echo $this->resume3->reference_city2; else echo $this->resume->reference_city;?>
                                                                        </div>
                                                                    </div>				        
							<?php } ?>
					<?php break;
						case "reference_zipcode":  $isodd = 1 - $isodd; ?>
							<?php  if (($section_references == 1) && ($section_sub_reference == 1)) { ?>
                                                                    <div class="fieldwrapper view">
                                                                        <div class="fieldtitle">
                                                                            <?php echo JText::_('JS_ZIPCODE'); ?>:
                                                                        </div>
                                                                        <div class="fieldvalue">
                                                                            <?php if (isset($this->resume)) echo $this->resume->reference_zipcode;?>
                                                                        </div>
                                                                    </div>				        
						<?php } ?>	
					<?php break;
						case "reference_address":  $isodd = 1 - $isodd; ?>
							<?php  if (($section_references == 1) && ($section_sub_reference == 1)) { ?>
                                                                    <div class="fieldwrapper view">
                                                                        <div class="fieldtitle">
                                                                            <?php echo JText::_('JS_ADDRESS'); ?>:
                                                                        </div>
                                                                        <div class="fieldvalue">
                                                                            <?php if (isset($this->resume)) echo $this->resume->reference_address;?>
                                                                        </div>
                                                                    </div>				        
							<?php } ?>
					<?php break;
						case "reference_phone":  $isodd = 1 - $isodd; ?>
							<?php  if (($section_references == 1) && ($section_sub_reference == 1)) { ?>
                                                                    <div class="fieldwrapper view">
                                                                        <div class="fieldtitle">
                                                                            <?php echo JText::_('JS_PHONE'); ?>:
                                                                        </div>
                                                                        <div class="fieldvalue">
                                                                            <?php if (isset($this->resume)) echo $this->resume->reference_phone;?>
                                                                        </div>
                                                                    </div>				        
							<?php } ?>
					<?php break;
						case "reference_relation":  $isodd = 1 - $isodd; ?>
							<?php  if (($section_references == 1) && ($section_sub_reference == 1)) { ?>
                                                                    <div class="fieldwrapper view">
                                                                        <div class="fieldtitle">
                                                                            <?php echo JText::_('JS_RELATION'); ?>:
                                                                        </div>
                                                                        <div class="fieldvalue">
                                                                            <?php if (isset($this->resume)) echo $this->resume->reference_relation;?>
                                                                        </div>
                                                                    </div>				        
							<?php } ?>
					<?php break;
						case "reference_years":  $isodd = 1 - $isodd; ?>
							<?php  if (($section_references == 1) && ($section_sub_reference == 1)) { ?>
                                                                    <div class="fieldwrapper view">
                                                                        <div class="fieldtitle">
                                                                            <?php echo JText::_('JS_YEARS'); ?>:
                                                                        </div>
                                                                        <div class="fieldvalue">
                                                                            <?php if (isset($this->resume)) echo $this->resume->reference_years;?>
                                                                        </div>
                                                                    </div>				        
							<?php } ?>
					<?php break;
						case "section_sub_reference1": ?>
							<?php  if (($section_references == 1) && ($section_sub_reference1 == 1)) { ?>
                                                                        <span class="js_controlpanel_section_title">
                                                                            <?php echo JText::_('JS_REFERENCE2'); ?>
                                                                        </span>				        
							<?php } ?>
					<?php break;
						case "reference1_name":  $isodd = 1 - $isodd; ?>
							<?php  if (($section_references == 1) && ($section_sub_reference1 == 1)) { ?>
                                                                    <div class="fieldwrapper view">
                                                                        <div class="fieldtitle">
                                                                            <?php echo JText::_('JS_NAME'); ?>:
                                                                        </div>
                                                                        <div class="fieldvalue">
                                                                            <?php if (isset($this->resume)) echo $this->resume->reference1_name;?>
                                                                        </div>
                                                                    </div>				        
						<?php } ?>	
					<?php break;
						case "reference1_country":  $isodd = 1 - $isodd; ?>
							<?php  if (($section_references == 1) && ($section_sub_reference1 == 1)) { ?>
                                                                    <div class="fieldwrapper view">
                                                                        <div class="fieldtitle">
                                                                            <?php echo JText::_('JS_COUNTRY'); ?>
                                                                        </div>
                                                                        <div class="fieldvalue">
                                                                            <?php echo $this->resume3->reference1_country; ?>
                                                                        </div>
                                                                    </div>				        
						<?php } ?>	
					<?php break;
						case "reference1_state":  $isodd = 1 - $isodd; ?>
							<?php  if (($section_references == 1) && ($section_sub_reference1 == 1)) { ?>
                                                                    <div class="fieldwrapper view">
                                                                        <div class="fieldtitle">
                                                                            <?php echo JText::_('JS_STATE'); ?>:
                                                                        </div>
                                                                        <div class="fieldvalue">
                                                                            <?php if ($this->resume3->reference1_state2 !='') echo $this->resume3->reference1_state2; else echo $this->resume->reference1_state;?>
                                                                        </div>
                                                                    </div>				        
						<?php } ?>	
					<?php break;
						case "reference1_city":  $isodd = 1 - $isodd; ?>
							<?php  if (($section_references == 1) && ($section_sub_reference1 == 1)) { ?>
                                                                    <div class="fieldwrapper view">
                                                                        <div class="fieldtitle">
                                                                            <?php echo JText::_('JS_CITY'); ?>:
                                                                        </div>
                                                                        <div class="fieldvalue">
                                                                            <?php if ($this->resume3->reference1_city2 !='') echo $this->resume3->reference1_city2; else echo $this->resume->reference1_city;?>
                                                                        </div>
                                                                    </div>				        
						<?php } ?>	
					<?php break;
						case "reference1_zipcode":  $isodd = 1 - $isodd; ?>
							<?php  if (($section_references == 1) && ($section_sub_reference1 == 1)) { ?>
                                                                    <div class="fieldwrapper view">
                                                                        <div class="fieldtitle">
                                                                            <?php echo JText::_('JS_ZIPCODE'); ?>:
                                                                        </div>
                                                                        <div class="fieldvalue">
                                                                            <?php if (isset($this->resume)) echo $this->resume->reference1_zipcode;?>
                                                                        </div>
                                                                    </div>				        
						<?php } ?>	
					<?php break;
						case "reference1_address":  $isodd = 1 - $isodd; ?>
							<?php  if (($section_references == 1) && ($section_sub_reference1 == 1)) { ?>
                                                                    <div class="fieldwrapper view">
                                                                        <div class="fieldtitle">
                                                                            <?php echo JText::_('JS_ADDRESS'); ?>:
                                                                        </div>
                                                                        <div class="fieldvalue">
                                                                            <?php if (isset($this->resume)) echo $this->resume->reference1_address;?>
                                                                        </div>
                                                                    </div>				        
						<?php } ?>	
					<?php break;
						case "reference1_phone":  $isodd = 1 - $isodd; ?>
							<?php  if (($section_references == 1) && ($section_sub_reference1 == 1)) { ?>
                                                                    <div class="fieldwrapper view">
                                                                        <div class="fieldtitle">
                                                                            <?php echo JText::_('JS_PHONE'); ?>:
                                                                        </div>
                                                                        <div class="fieldvalue">
                                                                            <?php if (isset($this->resume)) echo $this->resume->reference1_phone;?>
                                                                        </div>
                                                                    </div>				        
						<?php } ?>	
					<?php break;
						case "reference1_relation":  $isodd = 1 - $isodd; ?>
							<?php  if (($section_references == 1) && ($section_sub_reference1 == 1)) { ?>
                                                                    <div class="fieldwrapper view">
                                                                        <div class="fieldtitle">
                                                                            <?php echo JText::_('JS_RELATION'); ?>:
                                                                        </div>
                                                                        <div class="fieldvalue">
                                                                            <?php if (isset($this->resume)) echo $this->resume->reference1_relation;?>
                                                                        </div>
                                                                    </div>				        
						<?php } ?>	
					<?php break;
						case "reference1_years":  $isodd = 1 - $isodd; ?>
							<?php  if (($section_references == 1) && ($section_sub_reference1 == 1)) { ?>
                                                                    <div class="fieldwrapper view">
                                                                        <div class="fieldtitle">
                                                                            <?php echo JText::_('JS_YEARS'); ?>:
                                                                        </div>
                                                                        <div class="fieldvalue">
                                                                            <?php if (isset($this->resume)) echo $this->resume->reference1_years;?>
                                                                        </div>
                                                                    </div>				        
							<?php } ?>
					<?php break;
						case "section_sub_reference2": ?>
							<?php  if (($section_references == 1) && ($section_sub_reference2 == 1)) { ?>
                                                                    <span class="js_controlpanel_section_title">
                                                                        <?php echo JText::_('JS_REFERENCE3'); ?>
                                                                    </span>				        
						<?php } ?>	
					<?php break;
						case "reference2_name":  $isodd = 1 - $isodd; ?>
							<?php  if (($section_references == 1) && ($section_sub_reference2 == 1)) { ?>
                                                                    <div class="fieldwrapper view">
                                                                        <div class="fieldtitle">
                                                                            <?php echo JText::_('JS_NAME'); ?>:
                                                                        </div>
                                                                        <div class="fieldvalue">
                                                                            <?php if (isset($this->resume)) echo $this->resume->reference2_name;?>
                                                                        </div>
                                                                    </div>				        
						<?php } ?>	
					<?php break;
						case "reference2_country":  $isodd = 1 - $isodd; ?>
							<?php  if (($section_references == 1) && ($section_sub_reference2 == 1)) { ?>
                                                                    <div class="fieldwrapper view">
                                                                        <div class="fieldtitle">
                                                                            <?php echo JText::_('JS_COUNTRY'); ?>
                                                                        </div>
                                                                        <div class="fieldvalue">
                                                                            <?php echo $this->resume3->reference2_country; ?>
                                                                        </div>
                                                                    </div>				        
						<?php } ?>	
					<?php break;
						case "reference2_state":  $isodd = 1 - $isodd; ?>
							<?php  if (($section_references == 1) && ($section_sub_reference2 == 1)) { ?>
                                                                    <div class="fieldwrapper view">
                                                                        <div class="fieldtitle">
                                                                            <?php echo JText::_('JS_STATE'); ?>:
                                                                        </div>
                                                                        <div class="fieldvalue">
                                                                            <?php if ($this->resume3->reference2_state2 !='') echo $this->resume3->reference2_state2; else echo $this->resume->reference2_state;?>
                                                                        </div>
                                                                    </div>				        
						<?php } ?>	
					<?php break;
						case "reference2_city":  $isodd = 1 - $isodd; ?>
							<?php  if (($section_references == 1) && ($section_sub_reference2 == 1)) { ?>
                                                                    <div class="fieldwrapper view">
                                                                        <div class="fieldtitle">
                                                                            <?php echo JText::_('JS_CITY'); ?>:
                                                                        </div>
                                                                        <div class="fieldvalue">
                                                                            <?php if ($this->resume3->reference2_city2 !='') echo $this->resume3->reference2_city2; else echo $this->resume->reference2_city;?>
                                                                        </div>
                                                                    </div>				        
						<?php } ?>	
					<?php break;
						case "reference2_zipcode":  $isodd = 1 - $isodd; ?>
							<?php  if (($section_references == 1) && ($section_sub_reference2 == 1)) { ?>
                                                                    <div class="fieldwrapper view">
                                                                        <div class="fieldtitle">
                                                                            <?php echo JText::_('JS_ZIPCODE'); ?>:
                                                                        </div>
                                                                        <div class="fieldvalue">
                                                                            <?php if (isset($this->resume)) echo $this->resume->reference2_zipcode;?>
                                                                        </div>
                                                                    </div>				        
						<?php } ?>	
					<?php break;
						case "reference2_address":  $isodd = 1 - $isodd; ?>
							<?php  if (($section_references == 1) && ($section_sub_reference2 == 1)) { ?>
                                                                    <div class="fieldwrapper view">
                                                                        <div class="fieldtitle">
                                                                            <?php echo JText::_('JS_ADDRESS'); ?>:
                                                                        </div>
                                                                        <div class="fieldvalue">
                                                                            <?php if (isset($this->resume)) echo $this->resume->reference2_address;?>
                                                                        </div>
                                                                    </div>				        
						<?php } ?>	
					<?php break;
						case "reference2_phone":  $isodd = 1 - $isodd; ?>
							<?php  if (($section_references == 1) && ($section_sub_reference2 == 1)) { ?>
                                                                    <div class="fieldwrapper view">
                                                                        <div class="fieldtitle">
                                                                            <?php echo JText::_('JS_PHONE'); ?>:
                                                                        </div>
                                                                        <div class="fieldvalue">
                                                                            <?php if (isset($this->resume)) echo $this->resume->reference2_phone;?>
                                                                        </div>
                                                                    </div>				        
						<?php } ?>	
					<?php break;
						case "reference2_relation":  $isodd = 1 - $isodd; ?>
							<?php  if (($section_references == 1) && ($section_sub_reference2 == 1)) { ?>
                                                                    <div class="fieldwrapper view">
                                                                        <div class="fieldtitle">
                                                                            <?php echo JText::_('JS_RELATION'); ?>:
                                                                        </div>
                                                                        <div class="fieldvalue">
                                                                            <?php if (isset($this->resume)) echo $this->resume->reference2_relation;?>
                                                                        </div>
                                                                    </div>				        
						<?php } ?>	
					<?php break;
						case "reference2_years":  $isodd = 1 - $isodd; ?>
							<?php  if (($section_references == 1) && ($section_sub_reference2 == 1)) { ?>
                                                                    <div class="fieldwrapper view">
                                                                        <div class="fieldtitle">
                                                                            <?php echo JText::_('JS_YEARS'); ?>:
                                                                        </div>
                                                                        <div class="fieldvalue">
                                                                            <?php if (isset($this->resume)) echo $this->resume->reference2_years;?>
                                                                        </div>
                                                                    </div>				        
							<?php } ?>
					<?php break;
						case "section_sub_reference3": ?>
							<?php  if (($section_references == 1) && ($section_sub_reference3 == 1)) { ?>
                                                                    <span class="js_controlpanel_section_title">
                                                                        <?php echo JText::_('JS_REFERENCE4'); ?>
                                                                    </span>				        
						<?php } ?>	
					<?php break;
						case "reference3_name":  $isodd = 1 - $isodd; ?>
							<?php  if (($section_references == 1) && ($section_sub_reference3 == 1)) { ?>
                                                                    <div class="fieldwrapper view">
                                                                        <div class="fieldtitle">
                                                                            <?php echo JText::_('JS_NAME'); ?>:
                                                                        </div>
                                                                        <div class="fieldvalue">
                                                                            <?php if (isset($this->resume)) echo $this->resume->reference3_name;?>
                                                                        </div>
                                                                    </div>				        
						<?php } ?>	
					<?php break;
						case "reference3_country":  $isodd = 1 - $isodd; ?>
							<?php  if (($section_references == 1) && ($section_sub_reference3 == 1)) { ?>
                                                                    <div class="fieldwrapper view">
                                                                        <div class="fieldtitle">
                                                                            <?php echo JText::_('JS_COUNTRY'); ?>
                                                                        </div>
                                                                        <div class="fieldvalue">
                                                                            <?php echo $this->resume3->reference3_country; ?>
                                                                        </div>
                                                                    </div>				        
						<?php } ?>	
					<?php break;
						case "reference3_state":  $isodd = 1 - $isodd; ?>
							<?php  if (($section_references == 1) && ($section_sub_reference3 == 1)) { ?>
                                                                    <div class="fieldwrapper view">
                                                                        <div class="fieldtitle">
                                                                            <?php echo JText::_('JS_STATE'); ?>:
                                                                        </div>
                                                                        <div class="fieldvalue">
                                                                            <?php if ($this->resume3->reference3_state2 !='') echo $this->resume3->reference3_state2; else echo $this->resume->reference3_state;?>
                                                                        </div>
                                                                    </div>				        
						<?php } ?>	
					<?php break;
						case "reference3_city":  $isodd = 1 - $isodd; ?>
							<?php  if (($section_references == 1) && ($section_sub_reference3 == 1)) { ?>
                                                                    <div class="fieldwrapper view">
                                                                        <div class="fieldtitle">
                                                                            <?php echo JText::_('JS_CITY'); ?>:
                                                                        </div>
                                                                        <div class="fieldvalue">
                                                                            <?php if ($this->resume3->reference3_city2 !='') echo $this->resume3->reference3_city2; else echo $this->resume->reference3_city;?>
                                                                        </div>
                                                                    </div>				        
						<?php } ?>	
					<?php break;
						case "reference3_zipcode":  $isodd = 1 - $isodd; ?>
							<?php  if (($section_references == 1) && ($section_sub_reference3 == 1)) { ?>
                                                                    <div class="fieldwrapper view">
                                                                        <div class="fieldtitle">
                                                                            <?php echo JText::_('JS_ZIPCODE'); ?>:
                                                                        </div>
                                                                        <div class="fieldvalue">
                                                                            <?php if (isset($this->resume)) echo $this->resume->reference3_zipcode;?>
                                                                        </div>
                                                                    </div>				        
						<?php } ?>	
					<?php break;
						case "reference3_address":  $isodd = 1 - $isodd; ?>
							<?php  if (($section_references == 1) && ($section_sub_reference3 == 1)) { ?>
                                                                    <div class="fieldwrapper view">
                                                                        <div class="fieldtitle">
                                                                            <?php echo JText::_('JS_ADDRESS'); ?>:
                                                                        </div>
                                                                        <div class="fieldvalue">
                                                                            <?php if (isset($this->resume)) echo $this->resume->reference3_address;?>
                                                                        </div>
                                                                    </div>				        
						<?php } ?>	
					<?php break;
						case "reference3_phone":  $isodd = 1 - $isodd; ?>
							<?php  if (($section_references == 1) && ($section_sub_reference3 == 1)) { ?>
                                                                    <div class="fieldwrapper view">
                                                                        <div class="fieldtitle">
                                                                            <?php echo JText::_('JS_PHONE'); ?>:
                                                                        </div>
                                                                        <div class="fieldvalue">
                                                                            <?php if (isset($this->resume)) echo $this->resume->reference3_phone;?>
                                                                        </div>
                                                                    </div>				        
						<?php } ?>	
					<?php break;
						case "reference3_relation":  $isodd = 1 - $isodd; ?>
							<?php  if (($section_references == 1) && ($section_sub_reference3 == 1)) { ?>
                                                                    <div class="fieldwrapper view">
                                                                        <div class="fieldtitle">
                                                                            <?php echo JText::_('JS_RELATION'); ?>:
                                                                        </div>
                                                                        <div class="fieldvalue">
                                                                            <?php if (isset($this->resume)) echo $this->resume->reference3_relation;?>
                                                                        </div>
                                                                    </div>				        
						<?php } ?>	
					<?php break;
						case "reference3_years":  $isodd = 1 - $isodd; ?>
							<?php  if (($section_references == 1) && ($section_sub_reference3 == 1)) { ?>
                                                                    <div class="fieldwrapper view">
                                                                        <div class="fieldtitle">
                                                                            <?php echo JText::_('JS_YEARS'); ?>:
                                                                        </div>
                                                                        <div class="fieldvalue">
                                                                            <?php if (isset($this->resume)) echo $this->resume->reference3_years;?>
                                                                        </div>
                                                                    </div>				        
						<?php } 	
						break;	
						case "section_languages": ?>
							</div>	
                                                        <div id="languages_data">
                                                            <?php  if (($section_languages == 1) && ($section_sub_language == 1)) { ?>
                                                                        <span class="js_controlpanel_section_title">
                                                                            <?php echo JText::_('JS_LANGUAGE1'); ?>
                                                                        </span>				        
                                                            <?php } ?>
							
					<?php break;
						case "language_name": ?>
							<?php  if (($section_languages == 1) && ($section_sub_language == 1)) { ?>
                                                                    <div class="fieldwrapper view">
                                                                        <div class="fieldtitle">
                                                                            <?php echo JText::_('JS_LANGUAGE_NAME'); ?>:
                                                                        </div>
                                                                        <div class="fieldvalue">
                                                                            <?php if (isset($this->resume)) echo $this->resume->language;?>
                                                                        </div>
                                                                    </div>				        
							<?php } ?>
					<?php break;
						case "language_reading": ?>
							<?php  if (($section_languages == 1) && ($section_sub_language == 1)) { ?>
                                                                    <div class="fieldwrapper view">
                                                                        <div class="fieldtitle">
                                                                            <?php echo JText::_('JS_LANGUAGE_READ'); ?>
                                                                        </div>
                                                                        <div class="fieldvalue">
                                                                            <?php if (isset($this->resume)) echo $this->resume->language_reading;?>
                                                                        </div>
                                                                    </div>				        
							<?php } ?>
					<?php break;
						case "language_writing": ?>
							<?php  if (($section_languages == 1) && ($section_sub_language == 1)) { ?>
                                                                    <div class="fieldwrapper view">
                                                                        <div class="fieldtitle">
                                                                            <?php echo JText::_('JS_LANGUAGE_WRITE'); ?>
                                                                        </div>
                                                                        <div class="fieldvalue">
                                                                            <?php if (isset($this->resume)) echo $this->resume->language_writing;?>
                                                                        </div>
                                                                    </div>				        
							<?php } ?>
					<?php break;
						case "language_understading": ?>
							<?php  if (($section_languages == 1) && ($section_sub_language == 1)) { ?>
                                                                    <div class="fieldwrapper view">
                                                                        <div class="fieldtitle">
                                                                            <?php echo JText::_('JS_LANGUAGE_UNDERSTAND'); ?>
                                                                        </div>
                                                                        <div class="fieldvalue">
                                                                            <?php if (isset($this->resume)) echo $this->resume->language_understanding;?>
                                                                        </div>
                                                                    </div>				        
							<?php } ?>
					<?php break;
						case "language_where_learned": ?>
							<?php  if (($section_languages == 1) && ($section_sub_language == 1)) { ?>
                                                                    <div class="fieldwrapper view">
                                                                        <div class="fieldtitle">
                                                                            <?php echo JText::_('JS_LANGUAGE_LEARN_INSTITUTE'); ?>
                                                                        </div>
                                                                        <div class="fieldvalue">
                                                                            <?php if (isset($this->resume)) echo $this->resume->language_where_learned;?>
                                                                        </div>
                                                                    </div>				        
							<?php } ?>
					<?php break;
					case "section_sub_language1": ?>
							<?php  if (($section_languages == 1) && ($section_sub_language1 == 1)) { ?>
                                                                    <span class="js_controlpanel_section_title">
                                                                        <?php echo JText::_('JS_LANGUAGE2'); ?>
                                                                    </span>				        
							<?php } ?>

					<?php break;
						case "language1_name": ?>
							<?php  if (($section_languages == 1) && ($section_sub_language1 == 1)) { ?>
                                                                    <div class="fieldwrapper view">
                                                                        <div class="fieldtitle">
                                                                            <?php echo JText::_('JS_LANGUAGE_NAME'); ?>:
                                                                        </div>
                                                                        <div class="fieldvalue">
                                                                            <?php if (isset($this->resume)) echo $this->resume->language1;?>
                                                                        </div>
                                                                    </div>				        
							<?php } ?>
					<?php break;
						case "language1_reading": ?>
							<?php  if (($section_languages == 1) && ($section_sub_language1 == 1)) { ?>
                                                                    <div class="fieldwrapper view">
                                                                        <div class="fieldtitle">
                                                                            <?php echo JText::_('JS_LANGUAGE_READ'); ?>
                                                                        </div>
                                                                        <div class="fieldvalue">
                                                                            <?php if (isset($this->resume)) echo $this->resume->language1_reading;?>
                                                                        </div>
                                                                    </div>				        
							<?php } ?>
					<?php break;
						case "language1_writing": ?>
							<?php  if (($section_languages == 1) && ($section_sub_language1 == 1)) { ?>
                                                                    <div class="fieldwrapper view">
                                                                        <div class="fieldtitle">
                                                                            <?php echo JText::_('JS_LANGUAGE_WRITE'); ?>
                                                                        </div>
                                                                        <div class="fieldvalue">
                                                                            <?php if (isset($this->resume)) echo $this->resume->language1_writing;?>
                                                                        </div>
                                                                    </div>				        
							<?php } ?>
					<?php break;
						case "language1_understading": ?>
							<?php  if (($section_languages == 1) && ($section_sub_language1 == 1)) { ?>
                                                                    <div class="fieldwrapper view">
                                                                        <div class="fieldtitle">
                                                                            <?php echo JText::_('JS_LANGUAGE_UNDERSTAND'); ?>
                                                                        </div>
                                                                        <div class="fieldvalue">
                                                                            <?php if (isset($this->resume)) echo $this->resume->language1_understanding;?>
                                                                        </div>
                                                                    </div>				        
							<?php } ?>
					<?php break;
						case "language1_where_learned": ?>
							<?php  if (($section_languages == 1) && ($section_sub_language1 == 1)) { ?>
                                                                    <div class="fieldwrapper view">
                                                                        <div class="fieldtitle">
                                                                            <?php echo JText::_('JS_LANGUAGE_LEARN_INSTITUTE'); ?>
                                                                        </div>
                                                                        <div class="fieldvalue">
                                                                            <?php if (isset($this->resume)) echo $this->resume->language1_where_learned;?>
                                                                        </div>
                                                                    </div>				        
							<?php } ?>
					<?php break;
					case "section_sub_language2": ?>
							<?php  if (($section_languages == 1) && ($section_sub_language2 == 1)) { ?>
                                                                    <span class="js_controlpanel_section_title">
                                                                        <?php echo JText::_('JS_LANGUAGE3'); ?>
                                                                    </span>				        
							<?php } ?>

					<?php break;
						case "language2_name": ?>
							<?php  if (($section_languages == 1) && ($section_sub_language2 == 1)) { ?>
                                                                    <div class="fieldwrapper view">
                                                                        <div class="fieldtitle">
                                                                            <?php echo JText::_('JS_LANGUAGE_NAME'); ?>:
                                                                        </div>
                                                                        <div class="fieldvalue">
                                                                            <?php if (isset($this->resume)) echo $this->resume->language2;?>
                                                                        </div>
                                                                    </div>				        
							<?php } ?>
					<?php break;
						case "language2_reading": ?>
							<?php  if (($section_languages == 1) && ($section_sub_language2 == 1)) { ?>
                                                                    <div class="fieldwrapper view">
                                                                        <div class="fieldtitle">
                                                                            <?php echo JText::_('JS_LANGUAGE_READ'); ?>:
                                                                        </div>
                                                                        <div class="fieldvalue">
                                                                            <?php if (isset($this->resume)) echo $this->resume->language2_reading;?>
                                                                        </div>
                                                                    </div>				        
							<?php } ?>
					<?php break;
						case "language2_writing": ?>
							<?php  if (($section_languages == 1) && ($section_sub_language2 == 1)) { ?>
                                                                    <div class="fieldwrapper view">
                                                                        <div class="fieldtitle">
                                                                            <?php echo JText::_('JS_LANGUAGE_WRITE'); ?>
                                                                        </div>
                                                                        <div class="fieldvalue">
                                                                            <?php if (isset($this->resume)) echo $this->resume->language2_writing;?>
                                                                        </div>
                                                                    </div>				        
							<?php } ?>
					<?php break;
						case "language2_understading": ?>
							<?php  if (($section_languages == 1) && ($section_sub_language2 == 1)) { ?>
                                                                    <div class="fieldwrapper view">
                                                                        <div class="fieldtitle">
                                                                            <?php echo JText::_('JS_LANGUAGE_UNDERSTAND'); ?>
                                                                        </div>
                                                                        <div class="fieldvalue">
                                                                            <?php if (isset($this->resume)) echo $this->resume->language2_understanding;?>
                                                                        </div>
                                                                    </div>				        
							<?php } ?>
					<?php break;
						case "language2_where_learned": ?>
							<?php  if (($section_languages == 1) && ($section_sub_language2 == 1)) { ?>
                                                                    <div class="fieldwrapper view">
                                                                        <div class="fieldtitle">
                                                                            <?php echo JText::_('JS_LANGUAGE_LEARN_INSTITUTE'); ?>
                                                                        </div>
                                                                        <div class="fieldvalue">
                                                                            <?php if (isset($this->resume)) echo $this->resume->language2_where_learned;?>
                                                                        </div>
                                                                    </div>				        
							<?php } 
					break;		
					case "section_sub_language3": ?>
							<?php  if (($section_languages == 1) && ($section_sub_language3 == 1)) { ?>
                                                                    <span class="js_controlpanel_section_title">
                                                                        <?php echo JText::_('JS_LANGUAGE4'); ?>
                                                                    </span>				        
							<?php } ?>

					<?php break;
						case "language3_name": ?>
							<?php  if (($section_languages == 1) && ($section_sub_language3 == 1)) { ?>
                                                                    <div class="fieldwrapper view">
                                                                        <div class="fieldtitle">
                                                                            <?php echo JText::_('JS_LANGUAGE_NAME'); ?>:
                                                                        </div>
                                                                        <div class="fieldvalue">
                                                                            <?php if (isset($this->resume)) echo $this->resume->language3;?>
                                                                        </div>
                                                                    </div>				        
							<?php } ?>
					<?php break;
						case "language3_reading": ?>
							<?php  if (($section_languages == 1) && ($section_sub_language3 == 1)) { ?>
                                                                    <div class="fieldwrapper view">
                                                                        <div class="fieldtitle">
                                                                            <?php echo JText::_('JS_LANGUAGE_READ'); ?>
                                                                        </div>
                                                                        <div class="fieldvalue">
                                                                            <?php if (isset($this->resume)) echo $this->resume->language3_reading;?>
                                                                        </div>
                                                                    </div>				        
							<?php } ?>
					<?php break;
						case "language3_writing": ?>
							<?php  if (($section_languages == 1) && ($section_sub_language3 == 1)) { ?>
                                                                    <div class="fieldwrapper view">
                                                                        <div class="fieldtitle">
                                                                            <?php echo JText::_('JS_LANGUAGE_WRITE'); ?>
                                                                        </div>
                                                                        <div class="fieldvalue">
                                                                            <?php if (isset($this->resume)) echo $this->resume->language3_writing;?>
                                                                        </div>
                                                                    </div>				        
							<?php } ?>
					<?php break;
						case "language3_understading": ?>
							<?php  if (($section_languages == 1) && ($section_sub_language3 == 1)) { ?>
                                                                    <div class="fieldwrapper view">
                                                                        <div class="fieldtitle">
                                                                            <?php echo JText::_('JS_LANGUAGE_UNDERSTAND'); ?>
                                                                        </div>
                                                                        <div class="fieldvalue">
                                                                            <?php if (isset($this->resume)) echo $this->resume->language3_understanding;?>
                                                                        </div>
                                                                    </div>				        
							<?php } ?>
					<?php break;
						case "language3_where_learned": ?>
							<?php  if (($section_languages == 1) && ($section_sub_language3 == 1)) { ?>
                                                                    <div class="fieldwrapper view">
                                                                        <div class="fieldtitle">
                                                                            <?php echo JText::_('JS_LANGUAGE_LEARN_INSTITUTE'); ?>
                                                                        </div>
                                                                        <div class="fieldvalue">
                                                                            <?php if (isset($this->resume)) echo $this->resume->language3_where_learned;?>
                                                                        </div>
                                                                    </div>				        
							<?php } ?>
					<?php break;
					
				 } ?>	
			<?php } ?>	
							
                                                        </div>	
                            <div class="fieldwrapper">
                                <input type="button" id="button" class="button left" name="perv_tab" value="" />
                                <input type="button" id="button" class="button right" name="next_tab" value="" />
                            </div>
                        </div>	
    </div>
			<?php 
				if(isset($this->resume)) {
					if (($this->resume->create_date=='0000-00-00 00:00:00') || ($this->resume->create_date==''))
						$curdate = date('Y-m-d H:i:s');
					else  
						$curdate = $this->resume->create_date;
				}else
					$curdate = date('Y-m-d H:i:s');
				
			?>
<?php
	}else { ?>
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
<script language=Javascript>
    jQuery(document).ready(function(){
        var spanobject = jQuery("div.idTabs span");
        var pervbutton = jQuery('input[name="perv_tab"]');
        var nextbutton = jQuery('input[name="next_tab"]');
        var pervtab = jQuery(spanobject).children("a");
        var nexttab = jQuery(spanobject).next().children("a");
        function selectedTab(){
            var selectedtab = jQuery('div.idTabs span a.selected');
            return selectedtab;
        }
        function changeButtonText(){
            var span = jQuery(selectedTab()).parent('span');
            var firsttab = jQuery(spanobject).children("a");
            if(
                    jQuery(span).prev().children('a').length > 0 &&
                    (firsttab.attr("href") != jQuery(span).prev().children('a').attr("href") || jQuery(span).prev().children('a').attr("href") != jQuery('input[name="perv_tab"]').attr("data-tabid"))
                ){
                jQuery('input[name="perv_tab"]').val("<<  "+jQuery(span).prev().children('a').html()).attr('data-tabid',jQuery(span).prev().children('a').attr("href"));
            }
            var lasttab = jQuery(spanobject).last("a");
            if(
                    jQuery(span).next().children('a').length > 0 &&
                    lasttab.attr("href") != jQuery(span).next().children('a').attr("href")
                ){
                jQuery('input[name="next_tab"]').val(jQuery(span).next().children('a').html()+"  >>").attr('data-tabid',jQuery(span).next().children('a').attr("href"));
            }
            
        }
        function changeClick(){
            if(jQuery('div.idTabs span a.selected').attr("href") == jQuery('div.idTabs span').children('a').attr("href") && jQuery('div.idTabs span').children('a').attr("href") == jQuery('input[name="perv_tab"]').attr("href")){
                jQuery('input[name="perv_tab"]').attr('disabled','disabled');
            }else{
                jQuery('input[name="perv_tab"]').removeAttr('disabled');
            }
            if(jQuery('div.idTabs span a.selected').attr("href") == jQuery('div.idTabs span').last('a').attr("href") && jQuery('div.idTabs span').last('a').attr("href") == jQuery('input[name="next_tab"]').attr("href")){
                jQuery('input[name="next_tab"]').attr('disabled','disabled');
            }else{
                jQuery('input[name="next_tab"]').removeAttr('disabled');
            }
        }
        changeClick();
        jQuery(pervbutton).val("<<  "+pervtab.html()).attr('data-tabid',pervtab.attr("href")).click(function(e){
            e.preventDefault();
            var firsttab = jQuery(spanobject).children("a");
            var requesttab = jQuery('div.idTabs span a[href="'+jQuery(this).attr("data-tabid")+'"]');
            var selectedtab = selectedTab();
            if(firsttab.html() != selectedtab.html()){
                jQuery(requesttab).click();
                changeButtonText();
                changeClick();
            }
        });
        jQuery(nextbutton).val(nexttab.html()+"  >>").attr('data-tabid',nexttab.attr("href")).click(function(e){
            e.preventDefault();
            var lasttab = jQuery(spanobject).last("a");
            var requesttab = jQuery('div.idTabs span a[href="'+jQuery(this).attr("data-tabid")+'"]');
            if(lasttab.html() != requesttab.html()){
                jQuery(requesttab).click();
                changeButtonText();
                changeClick();
            }
        });
        
        jQuery("div.idTabs span a").click(function(){
            changeButtonText();
        });
        
    });

	function hideshowtables(table_id){
			hideall();
			document.getElementById(table_id).style.display = "block";

	}
	function hideall(){
		document.getElementById('personal_info_data').style.display = "none";
		document.getElementById('addresses_data').style.display = "none";
		document.getElementById('education_data').style.display = "none";
		document.getElementById('employer_data').style.display = "none";
		document.getElementById('skills_data').style.display = "none";
		document.getElementById('resume_editor_data').style.display = "none";
		document.getElementById('references_data').style.display = "none";
		document.getElementById('languages_data').style.display = "none";
	}
//window.onLoad=dochange('country', -1);         // value in first dropdown
<?php if($resume_style == 'sliding'){ ?>
	hideshowtables('personal_info_data');
<?php } ?>

</script>
