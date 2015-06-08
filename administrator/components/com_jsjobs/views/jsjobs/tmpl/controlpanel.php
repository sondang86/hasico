

<?php
/**
 * @Copyright Copyright (C) 2009-2011
 * @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
 + Created by:	Ahmad Bilal
 * Company:		Buruj Solutions
 + Contact:		www.burujsolutions.com , ahmad@burujsolutions.com
 * Created on:	Mar 25, 2009
 ^
 + Project: 		JS Jobs
 * File Name:	views/applications/view.html.php
 ^ 
 * Description: HTML view of all applications 
 ^ 
 * History:		NONE
 ^ 
 */
 
defined('_JEXEC') or die('Restricted access');
$document = JFactory::getDocument();
if(JVERSION < 3){
        JHtml::_('behavior.mootools');
        $document->addScript('../components/com_jsjobs/js/jquery.js');
}else{
        JHtml::_('behavior.framework');
        JHtml::_('jquery.framework');
}	
	$document->addStyleSheet(JURI::root().'administrator/components/com_jsjobs/include/css/jsjobsadmin.css');
	$document->addStyleSheet(JURI::root().'administrator/components/com_jsjobs/include/css/graph.css');
	$document->addScript(JURI::root().'administrator/components/com_jsjobs/include/js/jquery.flot.js');
	$document->addScript(JURI::root().'administrator/components/com_jsjobs/include/js/jquery.flot.time.js');
	$document->addScript('components/com_jsjobs/include/js/jquery_idTabs.js');
	
?>

<table width="100%">
	<tr>
		<td align="left" width="150" valign="top">
			<table width="100%"><tr><td style="vertical-align:top;">
			<?php
			include_once('components/com_jsjobs/views/menu.php');
			?>
			</td>
			</tr></table>
		</td>
		<td width="100%" valign="top">
                    <div id="js_job_wrapper">
                        <div class="job_sharing_wrapper">
                            <div class="left_side">
                                <?php 
                                if($this->isjobsharing){
                                    $img = 'on.png';
                                }else{
                                    $img = 'off.png';
                                }
                               ?>
                                <img src="components/com_jsjobs/include/images/<?php echo $img; ?>" />
                                <span class="job_sharing_text">
                                    <?php 
                                        echo JText::_('YOUR_JOB_SHARING_IS').'&nbsp;';
                                        if($this->isjobsharing){
                                            echo JText::_('JS_ENABLE');
                                        }else{
                                            echo '<a href="index.php?option=com_jsjobs&c=jobsharing&view=jobsharing&layout=jobshare">'.JText::_('JS_DISABLE').'</a>';
                                        }
                                    ?>
                                </span>
                            </div>
                            <div class="right_side">
                                <?php
                                    $url = 'http://www.joomsky.com/jsjobssys/getlatestversion.php';
                                    $pvalue = "dt=".date('Y-m-d');
                                    if  (in_array  ('curl', get_loaded_extensions())) {
                                        $ch = curl_init();
                                        curl_setopt($ch,CURLOPT_URL,$url);
                                        curl_setopt($ch,CURLOPT_POST,8);
                                        curl_setopt($ch,CURLOPT_POSTFIELDS,$pvalue);
                                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
                                        curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
                                        $curl_errno = curl_errno($ch);
                                        $curl_error = curl_error($ch);
                                        $result = curl_exec($ch);
                                        curl_close($ch);
                                        if($result == $this->config['versioncode']){ ?>
                                            <img src="components/com_jsjobs/include/images/latestversion.png" height="35" width="35" title="<?php echo JText::_('YOUR_SYSTEM_IS_UP_TO_DATE'); ?>">
                                            <?php echo JText::_('YOUR_SYSTEM_IS_UP_TO_DATE'); ?>
                                            </a>
                                        <?php	
                                        }elseif($result){ ?>
                                            <img src="components/com_jsjobs/include/images/newversion.png" height="35" width="35" title="<?php echo JText::_('NEW_VERSION_AVAILABLE'); ?>">
                                            <?php echo JText::_('NEW_VERSION_AVAILABLE'); ?>
                                        <?php			
                                        }else{ ?>
                                            <img src="components/com_jsjobs/include/images/unableconnect.png" height="35" width="35" title="<?php echo JText::_('UNABLE_CONNECT_TO_SERVER'); ?>">
                                            <?php echo JText::_('UNABLE_TO_CONNECT'); ?>
                                        <?php			
                                        }
                                    }else{ ?>
                                        <img src="components/com_jsjobs/include/images/unableconnect.png" height="35" width="35" title="<?php echo JText::_('UNABLE_CONNECT_TO_SERVER'); ?>">
                                        <?php echo JText::_('UNABLE_TO_CONNECT'); ?>
                                    <?php			
                                    }
                                ?>
                            </div>
                        </div>
                        <span class="js_job_controlpanelheading"><?php echo JText::_('JS_CONTROL_PANEL'); ?></span>
                        <div id="cp_graph">
                            <div id="cp_graph_data">
                                <div id="content">
                                    <div class="demo-container">
                                        <div id="placeholder" class="demo-placeholder"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <span class="js_job_controlpanelheading"><?php echo JText::_('JS_TODAY_STATS_OVERVIEW'); ?></span>
                        <div class="default_items_wrapper">
                            <div id="cp_statsoverview">
                                <div class="cp_statsoverview_details one">
                                    <span id="cp_statsoverview_a_j_image"></span>
                                    <span class="cp_statsoverview_text"><?php echo JText::_('JS_JOBS'); ?></span>
                                    <span class="cp_statsoverview_text_count"><?php echo $this->today_stats[1]->totaljobs; ?></span>
                                </div>
                                <div class="cp_statsoverview_details two">
                                    <span id="cp_statsoverview_s_j_image"></span>
                                    <span class="cp_statsoverview_text"><?php echo JText::_('JS_COMPANIES'); ?></span>
                                    <span class="cp_statsoverview_text_count"><?php echo $this->today_stats[0]->totalcompanies; ?></span>
                                </div>
                                <div class="cp_statsoverview_details three">
                                    <span id="cp_statsoverview_h_j_image"></span>
                                    <span class="cp_statsoverview_text"><?php echo JText::_('JS_RESUME'); ?></span>
                                    <span class="cp_statsoverview_text_count"><?php echo $this->today_stats[2]->totalresume; ?></span>
                                </div>
                                <div class="cp_statsoverview_details four">
                                    <span id="cp_statsoverview_sl_j_image"></span>
                                    <span class="cp_statsoverview_text"><?php echo JText::_('JS_JOBSEEKER'); ?></span>
                                    <span class="cp_statsoverview_text_count"><?php echo $this->today_stats[4]->totaljobseeker; ?></span>
                                </div>
                                <div class="cp_statsoverview_details five">
                                    <span id="cp_statsoverview_r_j_image"></span>
                                    <span class="cp_statsoverview_text"><?php echo JText::_('JS_EMPLOYER'); ?></span>
                                    <span class="cp_statsoverview_text_count"><?php echo $this->today_stats[3]->totalemployer; ?></span>
                                </div>
                            </div>
                        </div>	
                        <span class="js_job_controlpanelheading"><?php echo JText::_('JS_QUICK_ACCESS'); ?></span>
                        <div class="default_items_wrapper">
                            <a class="job_icon_wrapper c1" href="index.php?option=com_jsjobs&c=company&view=company&layout=companies">
                                <img src="components/com_jsjobs/include/images/company.png" />
                                <span class="icon_text"><?php echo JText::_('JS_COMPANIES'); ?></span>
                            </a>
                            <a class="job_icon_wrapper c2" href="index.php?option=com_jsjobs&c=job&view=job&layout=jobs">
                                <img src="components/com_jsjobs/include/images/jobs.png" />
                                <span class="icon_text"><?php echo JText::_('JS_JOBS'); ?></span>
                            </a>
                            <a class="job_icon_wrapper c3" href="index.php?option=com_jsjobs&c=resume&view=resume&layout=resumesearch">
                                <img src="components/com_jsjobs/include/images/resume_search.png" />
                                <span class="icon_text" ><?php echo JText::_('JS_RESUME_SEARCH'); ?></span>
                            </a>
                            <a class="job_icon_wrapper c4" href="index.php?option=com_jsjobs&c=resume&view=resume&layout=empapps">
                                <img src="components/com_jsjobs/include/images/resume.png" />
                                <span class="icon_text"><?php echo JText::_('JS_RESUME'); ?></span>
                            </a>
                            <a class="job_icon_wrapper c5" href="index.php?option=com_jsjobs&c=paymenthistory&view=paymenthistory&layout=payment_report">
                                <img src="components/com_jsjobs/include/images/payment_report.png" />
                                <span class="icon_text"><?php echo JText::_('JS_PAYMENT_REPORT'); ?></span>
                            </a>
                            <a class="job_icon_wrapper c6" href="index.php?option=com_jsjobs&c=job&view=job&layout=jobsearch">
                                <img src="components/com_jsjobs/include/images/job_search.png" />
                                <span class="icon_text"><?php echo JText::_('JS_JOB_SEARCH'); ?></span>
                            </a>
                            <a class="job_icon_wrapper c1" href="index.php?option=com_jsjobs&c=user&view=user&layout=userstats">
                                <img src="components/com_jsjobs/include/images/stats.png" />
                                <span class="icon_text"><?php echo JText::_('JS_USER_STATS'); ?></span>
                            </a>
                        </div>
                        <span class="js_job_controlpanelheading"><?php echo JText::_('JS_LATEST_JOBS'); ?></span>
                        <table id="cp_jobs_data_table"  cellspacing="0" cellpadding="0">
                                <tr>
                                    <th class="cp_jobs_data_th" ><?php echo JText::_('JS_JOB_TITLE'); ?></th>
                                    <th class="cp_jobs_data_th"><?php echo JText::_('JS_COMPANY_NAME'); ?></th>
                                    <th class="cp_jobs_data_th"><?php echo JText::_('JS_CATEGORY'); ?></th>
                                    <th class="cp_jobs_data_th"><?php echo JText::_('JS_SALARY'); ?></th>
                                    <th class="cp_jobs_data_th"><?php echo JText::_('JS_STOP_PUBLISHING'); ?></th>
                                </tr>
                                <?php foreach($this->topjobs AS $tj){ ?>
                                        <tr>
                                            <td><a href="index.php?option=com_jsjobs&c=job&view=job&layout=view_job&oi=<?php echo $tj->id ; ?>"><?php echo $tj->jobtitle; ?></a></td>
                                            <td><?php echo $tj->companyname; ?></td>
                                            <td><?php echo $tj->cattile; ?></td>
                                            <td><?php if($tj->salaryfrom) echo $tj->symbol.$tj->salaryfrom; ?><?php  if($tj->salaryto) echo $tj->symbol.$tj->salaryto; ?></td>
                                            <td><?php echo  date('D, d M Y',strtotime($tj->stoppublishing));?></td>
                                        <tr>
                                <?php } ?>
                        </table>
                        <span class="js_job_controlpanelheading"><?php echo JText::_('JS_CONFIGURATION'); ?></span>
                        <div class="default_items_wrapper">
                            <a class="job_icon_wrapper c1" href="index.php?option=com_jsjobs&c=configuration&view=configuration&layout=configurations">
                                <img src="components/com_jsjobs/include/images/genrel.png" />
                                <span class="icon_text"><?php echo JText::_('JS_GENERAL'); ?></span>
                            </a>
                            <a class="job_icon_wrapper c2" href="index.php?option=com_jsjobs&c=configuration&view=configuration&layout=configurationsemployer">
                                <img src="components/com_jsjobs/include/images/employer.png" />
                                <span class="icon_text"><?php echo JText::_('JS_EMPLOYER'); ?></span>
                            </a>
                            <a class="job_icon_wrapper c7" href="index.php?option=com_jsjobs&c=configuration&view=configuration&layout=configurationsjobseeker">
                                <img src="components/com_jsjobs/include/images/jobseeker.png" />
                                <span class="icon_text"><?php echo JText::_('JS_JOBSEEKER'); ?></span>
                            </a>
                            <a class="job_icon_wrapper c6" href="index.php?option=com_jsjobs&view=jsjobs&layout=proversion">
                                <img src="components/com_jsjobs/include/images/thems.png" />
                                <span class="icon_text"><?php echo JText::_('JS_THEMES'); ?></span>
                            </a>
                        </div>
                        <span class="js_job_controlpanelheading"><?php echo JText::_('JS_INFORMATION'); ?></span>
                        <div class="default_items_wrapper">
                            <a class="job_icon_wrapper c8" href="index.php?option=com_jsjobs&c=jsjobs&view=jsjobs&layout=info">
                                <img src="components/com_jsjobs/include/images/about.png" />
                                <span class="icon_text"><?php echo JText::_('JS_ABOUT'); ?></span>
                            </a>
                            <a class="job_icon_wrapper c9" href="index.php?option=com_jsjobs&c=jsjobs&view=jsjobs&layout=updates">
                                <img src="components/com_jsjobs/include/images/remove_footer.png" />
                                <span class="icon_text"><?php echo JText::_('JS_REMOVE_FOOTER'); ?></span>
                            </a>
                            <a class="job_icon_wrapper c5" href="index.php?option=com_jsjobs&c=jsjobs&view=jsjobs&layout=updates">
                                <img src="components/com_jsjobs/include/images/updates.png" />
                                <span class="icon_text"><?php echo JText::_('JS_UPDATES'); ?></span>
                            </a>
                        </div>
                        <span class="js_job_controlpanelheading"><?php echo JText::_('JS_SUPPORT'); ?></span>
                        <div class="default_items_wrapper">
                            <a class="job_icon_wrapper c1" href="http://www.joomsky.com/jsjobssys/forum.php"  target="_blank">
                                <img src="components/com_jsjobs/include/images/forum.png" />
                                <span class="icon_text"><?php echo JText::_('JS_FORUM'); ?></span>
                            </a>
                            <a class="job_icon_wrapper c2" href="http://www.joomsky.com/jsjobssys/documentation.php" target="_blank">
                                <img src="components/com_jsjobs/include/images/docomotation.png" />
                                <span class="icon_text"><?php echo JText::_('JS_DOCUMENTATION'); ?></span>
                            </a>
                            <a class="job_icon_wrapper c4" href="http://www.joomsky.com/jsjobssys/ticket.php" target="_blank">
                                <img src="components/com_jsjobs/include/images/ticket.png" />
                                <span class="icon_text"><?php echo JText::_('JS_OPEN_A_TICKET'); ?></span>
                            </a>
                            <a class="job_icon_wrapper c9" href="http://www.joomsky.com/jsjobssys/ticket.php" target="_blank">
                                <img src="components/com_jsjobs/include/images/support.png" />
                                <span class="icon_text"><?php echo JText::_('JS_SUPPORT'); ?></span>
                            </a>
                        </div>
                        <span class="js_job_controlpanelheading"><?php echo JText::_('JS_MAKE_A_REVIEW'); ?></span>
                        <div id="cp_wraper">
                            <div class="cp_sub_heading_bar">
                                    <img src="components/com_jsjobs/include/images/makereview.png" />
                                    <span class="cp_sub_heading_bar_text" ><a href="http://extensions.joomla.org/extensions/ads-a-affiliates/jobs-a-recruitment/7550" target="_blank"><?php echo JText::_('JS_MAKE_A_REVIEW'); ?></a></span>
                            </div>
                            <div id="cp_makereview">
                                    <div id="review">
                                        <?php echo JText::_('JS_REVIEW_AT_JED'); ?>&nbsp;<a href="http://extensions.joomla.org/extensions/ads-a-affiliates/jobs-a-recruitment/7550" target="_blank"><span id="review_text"><?php echo JText::_('JS_JOOMLA_EXTENSIONS_DIRECTORY'); ?></span></a>
                                    </div>
                            </div>
                        </div>
                    </div>
		</td>
	</tr>
	<tr>
		<td colspan="2" align="left" width="100%"  valign="top">
			<table width="100%" style="table-layout:fixed;"><tr><td style="vertical-align:top;"><?php echo '<table width="100%" style="table-layout:fixed;"> <tr><td height="15"></td></tr> <tr> <td style="vertical-align:middle;" align="center"> <a href="http://www.joomsky.com" target="_blank"><img src="http://www.joomsky.com/logo/jsjobscrlogo.png" ></a> <br> Copyright &copy; 2008 - '. date('Y') .', <a href="http://www.joomsky.com" target="_blank">Joom Sky</a>  </td> </tr> </table>';  ?></td></tr></table>
		</td>
	</tr>
	
</table>	
<script type="text/javascript">
	jQuery(document).ready(function(){
		date_x_axises = new Array();
		data_count =new Array();
	jQuery.ajax({
	      url:"index.php?option=com_jsjobs&task=jsjobs.getgraphdata",  
	      success:function(data1) {
			var result=jQuery.parseJSON(data1);
			jQuery(result).each(function (key,val){
				date_x_axises.push(val[0]);
				data_count.push(val[1]);
			});

		var plot = jQuery.plot("#placeholder", [
			{ data: date_x_axises, label: "Jobs"},
			{ data: data_count, label: "Resume"}
		], {
			xaxis: {
				mode: "time",
				ticks: 15,
				labelWidth: 10,
				tickLength: 10,
			},
			selection: {
				mode: "x"
			},
			series: {
				lines: {
					show: true,
				},
				points: {
					show: true
				},
				shadowSize: 0
			},
			grid: {
				hoverable: true,
				clickable: true
			}
		});
		
		jQuery("<div id='tooltip'></div>").css({
			position: "absolute",
			display: "none",
			border: "1px solid #fdd",
			padding: "2px",
			"background-color": "#fee",
			opacity: 0.80
		}).appendTo("body");

		
		jQuery("#placeholder").bind("plothover", function (event, pos, item) {


			if (jQuery("#enableTooltip")) {
				if (item) {
					var x = item.datapoint[0].toFixed(2)/1000,
						y = item.datapoint[1].toFixed();
						var tool_tip_date = new Date(x * 1000);
						//var label_date = new Date(tool_tip_date);
						var dateString = tool_tip_date.toDateString();
					jQuery("#tooltip").html(item.series.label + " of " + dateString + " = " + y)
						.css({top: item.pageY+5, left: item.pageX+5})
						.fadeIn(200);
				} else {
					jQuery("#tooltip").hide();
				}
			}
		});
	  }
   });
		
});

</script>
