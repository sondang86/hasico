<?php
/**
 * @Copyright Copyright (C) 2009-2011
 * @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
 + Created by:	Ahmad Bilal
 * Company:		Buruj Solutions
 + Contact:		www.burujsolutions.com , ahmad@burujsolutions.com
 * Created on:	Jan 11, 2009
 ^
 + Project: 		JS Jobs
 * File Name:	admin-----/views/applications/tmpl/jobappliedresumes.php
 ^ 
 * Description: Default template for job applied resumes view
 ^ 
 * History:		NONE
 ^ 
 */
 
defined('_JEXEC') or die('Restricted access');
$document = JFactory::getDocument();
$document->addStyleSheet('components/com_jsjobs/include/css/jsjobsadmin.css');
if(JVERSION < 3){
        JHtml::_('behavior.mootools');
        $document->addScript('../components/com_jsjobs/js/jquery.js');
}else{
        JHtml::_('behavior.framework');
        JHtml::_('jquery.framework');
}	

$status = array(
	'1' => JText::_('JOB_APPROVED'),
	'-1' => JText::_('JOB_REJECTED'));

?>
<script type="text/javascript">
function getjobdetail(src,jobid, resumeid){
    jQuery("#"+src).html("Loading ...");
    jQuery.post("index.php?option=com_jsjobs&task=resume.getresumedetail",{jobid:jobid,resumeid:resumeid},function(data){
        if(data){
            jQuery("#"+src).html(data); //retuen value
        }        
    });
}

function clsjobdetail(src){
        jQuery("#"+src).html("");
}

</script>
<table width="100%" >
	<tr>
		<td align="left" width="175"  valign="top">
			<table width="100%"><tr><td style="vertical-align:top;">
			<?php
			include_once('components/com_jsjobs/views/menu.php');
			?>
			</td>
			</tr></table>
		</td>
		<td width="100%" valign="top">

			<form action="index.php" method="post" name="adminForm" id="adminForm">
			<div id="jsjobs_appliedapplication_tab_container">
				<a  onclick="tabaction(<?php echo $this->oi; ?>,'1')">
					<span class='<?php if($this->tabaction==1) {echo 'jsjobs_appliedapplication_tab_selected';}else{echo '';} ?>' id='jsjobs_appliedapplication_tab' >
					<?php echo JText::_('JS_INBOX'); ?>
					</span>
				</a>
				<div id="jsjobs_appliedresume_action_allexport">
					<?php  $exportalllink='index.php?option=com_jsjobs&c=jsjobs&task=export.exportallresume&bd='.$this->oi;?>
					<a href="<?php echo $exportalllink; ?>" >
						<img src="../components/com_jsjobs/images/exportall.png"  />			
						<span id="jsjobs_appliedresume_action_allexport_text" ><?php echo JText::_('JS_ALL_EXPORT'); ?></span>		
					</a>
					
				</div>
				
			</div>	
		<div id="jsjobs_appliedresume_tab_search" style="display: none;">
		</div>
			
			<?php
			jimport('joomla.filter.output');
			$k = 0;
			$count = 0;
			for ($i=0, $n=count( $this->items ); $i < $n; $i++)
				{
					$count++;
					$row = $this->items[$i];
					$link = JFilterOutput::ampReplace('index.php?option='.$this->option.'&task=jobapply.edit&cid[]='.$row->id);
					$resumelink = 'index.php?option=com_jsjobs&c=resume&view=resume&layout=view_resume&rd='.$row->appid.'&oi='.$this->oi;
					$plink = 'index.php?option=com_jsjobs&c=resume&view=resume&layout=resumeprint&rd='.$row->appid.'&oi='.$this->oi;
					$exportlink='index.php?option=com_jsjobs&task=export.exportresume&bd='.$this->oi.'&rd='.$row->appid;
			?>
			<div id="jsjobs_appliedapplication_container" class="<?php echo "row$k";?>" data-containerid="container_<?echo $row->jobapplyid;?>">
				<div id="jsjobs_appliedresume_container">
					<div id="jsjobs_appliedresume_top">
						<table id="jsjobs_appliedresume_container_table" cellpadding="1" cellspacing="0" border="0" width="100%">
							<tr>
								<td nowrap="nowrap">
									<span id="jsjobs_appliedresume_applicantname" class="<?php if ($row->resumeview == 0) echo 'bold'; ?>"> 
										<?php echo $row->applicationtitle; ?>
										<span id="jsjobs_appliedresume_applicanttitle" > 
													<?php echo "( ".JText::_('JS_RESUME_TITLE')." )"; ?>
										</span>
									</span>
								</td>
								<td nowrap="nowrap">
									<span id="jsjobs_appliedresume_applieddate" > 
										<?php echo JText::_('JS_APPLIED_DATE').":"; ?>
										<span id="jsjobs_appliedresume_applieddate_value" > 
											<?php echo date($this->config['date_format'],strtotime($row->apply_date)); ?>
										</span>
									</span>
								</td>
								<td >
									<div style='float:right;'>
									</div>
								</td>
							</tr>
						</table>	
					</div>	
					<div id="jsjobs_appliedresume_data">
						<table cellpadding="1" cellspacing="0" border="0" width="100%">
							<tr>
								<td >
									<div id="jsjobs_appliedresume_data_detail">
										<span id="jsjobs_appliedresume_data_detail_applicantsummery" > 
											<?php echo JText::_('JS_CURRENT_SALARY').":"; ?>
											<span id="jsjobs_appliedresume_data_detail_applicantsummery_value" > 
												<?php echo $row->symbol . $row->rangestart . ' - ' . $row->symbol.' '. $row->rangeend; ?>
											</span>
										</span>
										<span id="jsjobs_appliedresume_data_detail_applicantsummery" > 
											<?php echo JText::_('JS_TOTAL_EXPERIENCE').":"; ?>
											<span id="jsjobs_appliedresume_data_detail_applicantsummery_value" > 
												<?php echo $row->total_experience;?>
											</span>
										</span>
										<span id="jsjobs_appliedresume_data_detail_applicantsummery" > 
											<?php echo JText::_('JS_EXPECTED_SALARY').":"; ?>
											<span id="jsjobs_appliedresume_data_detail_applicantsummery_value" > 
												<?php echo $row->dsymbol . $row->drangestart . ' - ' . $row->dsymbol.' '. $row->drangeend; ?>
											</span>
										</span>
										<span id="jsjobs_appliedresume_data_detail_applicantsummery" > 
											<?php echo JText::_('JS_EDUCATION').":"; ?>
											<span id="jsjobs_appliedresume_data_detail_applicantsummery_value" > 
												<?php echo $row->education; ?>
											</span>
										</span>
										<span id="jsjobs_appliedresume_data_detail_applicantsummery" > 
											<?php echo JText::_('JS_LOCATION').":"; ?>
											<span id="jsjobs_appliedresume_data_detail_applicantlocation_value" > 
													<?php
														$comma="";
														if ($row->cityname) { echo $row->cityname; $comma = 1; }
														elseif ($row->address_city) { echo $row->address_city; $comma = 1; }
														//if ($row->countyname) { if($comma) echo', '; echo $row->countyname; $comma = 1; }
														//elseif ($row->address_county) { if($comma) echo', '; echo $row->address_county; $comma = 1; }
														if ($row->statename) { if($comma) echo', '; echo $row->statename; $comma = 1; }
														elseif ($row->address_state) { if($comma) echo', '; echo $row->address_state; $comma = 1; }
														if ($row->countryname) { if($comma) echo', '; echo $row->countryname; $comma = 1; }
													 ?>
											</span>
										</span>
									</div>
								</td>
								<td style="width:12%" >
									<?php if($row->photo) { ?>
										<img  width='75px' height='75px' src="<?php echo "../".$this->config['data_directory'];?>/data/jobseeker/resume_<?php echo $row->appid.'/photo/'.$row->photo; ?>"  />
									<?php }else{ ?>
										<img  src="../components/com_jsjobs/images/jsjobs_logo.png" width='75px' height='75px' />
									<?php } ?>
									
								</td>
							</tr>
						</table>
					</div>	
					<div id="resumedetail_<?php echo $row->appid; ?>"></div>
					<div id="jsjobs_appliedresume_data_comments_bottom">
						<span id="jsjobs_appliedresume_data_comments" >
							<span id="jsjobs_appliedresume_data_comments_title">
								<?php echo JText::_('JS_NOTES')."::";?>
							</span>
							<?php echo  $row->comments; ?>
						</span>
						<span id="jsjobs_appliedresime_data_comments_link">
							
							<?php 
								$resumelink = 'index.php?option=com_jsjobs&c=resume&view=resume&layout=view_resume&rd='.$row->appid.'&oi='.$this->oi;
							
							?> 
							<a id="button" class="button minpad" href="<?php echo $resumelink;?>"><?php echo JText::_('JS_VIEW_RESUME');?></a>
						</span>
						<div id="jsjobs_appliedresume_data_action_message_<?php echo $row->jobapplyid; ?>" class="jsjobs_appliedresume_data_action_message" style="display: none;">
							<span id="resumeactionmessage_<?php echo $row->jobapplyid; ?>" ></span>
						</div>
					</div>	
					
					
				<div id="resumeaction_<?php echo $row->jobapplyid; ?>"></div>
					
				</div>
			</div>
				<?php
				$k = 1 - $k;
			}
			?>
			
			<div><?php echo $this->pagination->getListFooter(); ?></div>
			<input type="hidden" name="option" value="<?php echo $this->option; ?>" />
			<input type="hidden" name="c"  id="c" value="jobapply" />
			<input type="hidden" name="view"  id="view" value="jobapply" />
			<input type="hidden" name="layout"  id="layout" value="jobappliedresume" />
			<input type="hidden" name="task"  id="task" value="actionresume" />
			<input type="hidden" name="jobid" id="jobid" value="<?php echo $this->oi; ?>" />
			<input type="hidden" name="oi" id="oi" value="<?php echo $this->oi; ?>" />
			<input type="hidden" name="resumeid" id="resumeid" value="<?php echo $row->appid; ?>" />
			<input type="hidden" name="id" id="id" value="" />
			<input type="hidden" name="action" id="action" value="" />
			<input type="hidden" name="action_status" id="action_status" value="" />
			<input type="hidden" name="tab_action" id="tab_action" value="" />
			
			<input type="hidden" name="boxchecked" value="0" />
			</form>
			<div style="float:left;">			<?php echo '<table width="100%" style="table-layout:fixed;"> <tr><td height="15"></td></tr> <tr> <td style="vertical-align:middle;" align="center"> <a href="http://www.joomsky.com" target="_blank"><img src="http://www.joomsky.com/logo/jsjobscrlogo.png" ></a> <br> Copyright &copy; 2008 - '. date('Y') .', <a href="http://www.joomsky.com" target="_blank">Joom Sky</a>  </td> </tr> </table>';  ?>	</div>
	
</table>