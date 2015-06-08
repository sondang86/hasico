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
 * File Name:	admin-----/views/applications/tmpl/jobstatus.php
 ^ 
 * Description: Default template for job status
 ^ 
 * History:		NONE
 ^ 
 */
 
defined('_JEXEC') or die('Restricted access');
$document = JFactory::getDocument();
$document->addStyleSheet(JURI::root().'administrator/components/com_jsjobs/include/css/jsjobsadmin.css');
$status = array(
	'1' => JText::_('JS_APPROVED'),
	'-1' => JText::_('JS_REJECTED'));
JHTML::_('behavior.calendar');
	if($this->config['date_format']=='m/d/Y') $dash = '/';else $dash = '-';

	$dateformat = $this->config['date_format'];
	$firstdash = strpos($dateformat,$dash,0);
	$firstvalue = substr($dateformat, 0,$firstdash);
	$firstdash = $firstdash + 1;
	$seconddash = strpos($dateformat,$dash,$firstdash);
	$secondvalue = substr($dateformat, $firstdash,$seconddash-$firstdash);
	$seconddash = $seconddash + 1;
	$thirdvalue = substr($dateformat, $seconddash,strlen($dateformat)-$seconddash);
	$js_dateformat = '%'.$firstvalue.$dash.'%'.$secondvalue.$dash.'%'.$thirdvalue;

?>
<table width="100%">
	<tr>
		<td align="left" width="175" valign="top">
			<table width="100%"><tr><td style="vertical-align:top;">
			<?php
			include_once('components/com_jsjobs/views/menu.php');
			?>
			</td>
			</tr></table>
		</td>
		<td width="100%" valign="top">
				<div id="jsjobs_info_heading"><?php echo JText::_('JS_JOB_SHARE_LOG'); ?></div>
			
			<form action="index.php" method="post" name="adminForm" id="adminForm">
			<div id="js_job_filter">
                            <span class="js_job_filter_title"><?php echo JText::_( 'Filter' ); ?></span>
                            <div class="js_job_filter_field_wrapper">
                                <span class="title"><?php echo JText::_( 'JS_UID' ); ?></span>
                                <input type="text" name="searchuid" id="searchuid" size="15" value="<?php if(isset($this->lists['uid'])) echo $this->lists['uid'];?>" class="text_area" style="width:30px;" />
                            </div>
                            <div class="js_job_filter_field_wrapper">
                                <span class="title"><?php echo JText::_( 'JS_REF_NUMBER' ); ?></span>
                                <input type="text" name="searchrefnumber" id="searchrefnumber" size="15" value="<?php if(isset($this->lists['refnumber'])) echo $this->lists['refnumber'];?>" class="text_area"  style="width:30px;" />
                            </div>
                            <div class="js_job_filter_field_wrapper">
                                <span class="title"><?php echo JText::_( 'JS_USER_NAME' ); ?></span>
                                <input type="text" name="searchusername" id="searchusername" size="15" value="<?php if(isset($this->lists['username'])) echo $this->lists['username'];?>" class="text_area"  style="width:150px;" />						
                            </div>
                            <div class="js_job_filter_field_wrapper">
                                <span class="title"><?php echo JText::_( 'JS_START' ); ?></span>
                                <?php
                                    $startdate = !empty($this->lists['startdate']) ? date(str_replace('%', '', $js_dateformat),  strtotime($this->lists['startdate'])) : '';
                                    echo JHTML::_('calendar', $startdate,'searchstartdate', 'searchstartdate',$js_dateformat,array('class'=>'inputbox', 'style'=>'width:80px;',  'maxlength'=>'19'));
                                 ?>
                            </div>
                            <div class="js_job_filter_field_wrapper">
                                <span class="title"><?php echo JText::_( 'JS_END' ); ?></span>
                                <?php
                                    $enddate = !empty($this->lists['enddate']) ? date(str_replace('%', '', $js_dateformat), strtotime($this->lists['enddate'])) : '';
                                    echo JHTML::_('calendar', $enddate, 'searchenddate', 'searchenddate', $js_dateformat, array('class' => 'inputbox', 'style' => 'width:80px;', 'maxlength' => '19'));
                                ?>
                            </div>
                            <div class="js_job_filter_field_wrapper">
                                <button onclick="document.adminForm.submit();"><?php echo JText::_('Go'); ?></button>
                                <button onclick="document.getElementById('searchuid').value='';document.getElementById('searchusername').value='';document.getElementById('searchrefnumber').value='';this.form.getElementById('searchstartdate').value='';this.form.getElementById('searchenddate').value='';this.form.submit();"><?php echo JText::_('Reset'); ?></button>
                            </div>
			</div>
			<table class="adminlist" border="0">
			<?php
			jimport('joomla.filter.output');
			$k = 0;
				for ($i=0, $n=count( $this->servicelog); $i < $n; $i++)
				{
				$row = $this->servicelog[$i];
				?>
				<tr valign="top" class="<?php echo "row$k"; ?>">
					<td>
                                            <div id="log_wrapper" class="<?php echo "row$k"; ?>">
                                                <span id="log_two_col"><?php echo JText::_('JS_UID');?>&nbsp;:<span id="log_three_col_value"><?php echo $row->uid;?></span></span>
                                                <span id="log_two_col"><?php echo JText::_('JS_USER_NAME');?>&nbsp;:<span id="log_three_col_value"><?php echo $row->username;?></span></span>
                                                <span id="log_two_col"><?php echo JText::_('JS_REF_NUMBER');?>&nbsp;:<span id="log_three_col_value"><?php echo $row->referenceid;?></span></span>
                                                <span id="log_two_col"><?php echo JText::_('EVENT');?>&nbsp;:<span id="log_three_col_value"><?php echo $row->event;?></span></span>
                                                <span id="log_two_col"><?php echo JText::_('EVENT_TYPE');?>&nbsp;:<span id="log_three_col_value"><?php echo $row->eventtype;?></span></span>
                                                <span id="log_two_col"><?php echo JText::_('DATE');?>&nbsp;:<span id="log_three_col_value"><?php echo date(str_replace('%', '', $js_dateformat),strtotime($row->datetime));?></span></span>
                                                <span id="log_message"><?php echo JText::_('MESSAGE');?>&nbsp;:<span id="log_message_value"><?php echo $row->message;?></span></span>                                                
                                            </div>
					</td>
				</tr>
				<?php
				$k = 1 - $k;
			}
			?>
			<tr>
				<td colspan="9">
					<?php echo $this->pagination->getListFooter(); ?>
				</td>
			</tr>
			</table>
			<input type="hidden" name="option" value="<?php echo $this->option; ?>" />
                        <input type="hidden" name="c" value="jobsharing" />
                        <input type="hidden" name="view" value="jobsharing" />
                        <input type="hidden" name="layout" value="jobsharelog" />
			<input type="hidden" name="task" value="" />
			<input type="hidden" name="boxchecked" value="0" />
			</form>
		</td>
	</tr>
	<tr>
		<td colspan="2" align="left" width="100%"  valign="top">
			<table width="100%" style="table-layout:fixed;"><tr><td style="vertical-align:top;"><?php echo '<table width="100%" style="table-layout:fixed;"> <tr><td height="15"></td></tr> <tr> <td style="vertical-align:middle;" align="center"> <a href="http://www.joomsky.com" target="_blank"><img src="http://www.joomsky.com/logo/jsjobscrlogo.png" ></a> <br> Copyright &copy; 2008 - '. date('Y') .', <a href="http://www.joomsky.com" target="_blank">Joom Sky</a>  </td> </tr> </table>';  ?></td></tr></table>
		</td>
	</tr>
	
</table>							
