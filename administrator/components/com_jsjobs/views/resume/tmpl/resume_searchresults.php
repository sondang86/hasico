<?php 
/**
 * @Copyright Copyright (C) 2009-2011 ... Ahmad Bilal
 * @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * Company:		Buruj Solutions
 + Contact:		www.burujsolutions.com , ahmad@burujsolutions.com
 * Created on:	Jan 11, 2009
 ^
 + Project: 		JS Jobs
 * File Name:	admin-----/views/applications/tmpl/resume_searchresults.php
 ^ 
 * Description: Template for users view
 ^ 
 * History:		NONE
 ^ 
 */

defined('_JEXEC') or die('Restricted access'); 
$document = JFactory::getDocument();
$document->addStyleSheet(JURI::root().'administrator/components/com_jsjobs/include/css/jsjobsadmin.css');
if(JVERSION < 3){
	JHtml::_('behavior.mootools');
	$document->addScript('../components/com_jsjobs/js/jquery.js');
}else{
	JHtml::_('behavior.framework');
	JHtml::_('jquery.framework');
}	

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
				<div id="jsjobs_info_heading"><?php echo JText::_('JS_SEARCH_RESUME'); ?></div>

			<form action="index.php?option=com_jsjobs" method="post" name="adminForm" id="adminForm">
				
				<table class="adminlist" cellpadding="1">
					<thead>
						<tr>
							
							<th class="title"><?php echo JText::_('JS_TITLE'); ?></th>
							<th  class="title" ><?php echo JText::_('JS_CATEGORY'); ?></th>
							<th  class="title"><?php echo JText::_('JS_SALARY_RANGE'); ?></th>
							<th  class="title"><?php echo JText::_('JS_JOBTYPE'); ?></th>
							<th  class="title"><?php echo JText::_('JS_EMAIL'); ?></th>
							<th  class="title"><?php echo JText::_('JS_CREATED'); ?></th>
						</tr>
					</thead>
					<tfoot>
						<tr>
							<td colspan="10">
								<?php echo $this->pagination->getListFooter(); ?>
							</td>
						</tr>
					</tfoot>
					<tbody>
					<?php
						$k = 0;
						for ($i=0, $n=count( $this->items ); $i < $n; $i++)
						{
							$row 	= $this->items[$i];
							$resumelink = 'index.php?option=com_jsjobs&c=resume&view=resume&layout=view_resume&rd='.$row->id;
						?>
						<tr class="<?php echo "row$k"; ?>">
						<td><?php if ( $this->searchresumeconfig['search_resume_title'] == '1' ) { ?>
						<a href="<?php echo $resumelink;?>"><?php echo $row->application_title; ?></a>
						<?php } ?></td>
						<td><?php if ( $this->searchresumeconfig['search_resume_category'] == '1' ) echo $row->cat_title; ?></td>
						<td><?php if ( $this->searchresumeconfig['search_resume_salaryrange'] == '1' ) //$salary = $this->config['currency'] . $row->rangestart . ' - ' . $this->config['currency'] . $row->rangeend . ' /month';
						$salary = $row->symbol . $row->rangestart . ' - ' . $row->symbol . $row->rangeend . ' /month';
									echo $salary; ?></td>
						<td><?php if ( $this->searchresumeconfig['search_resume_type'] == '1' )  echo $row->jobtypetitle;?></td>
						<td><?php   echo $row->email_address; ?></td>
						<td><?php   echo date($this->config['date_format'],strtotime($row->create_date)); ?> </td>
						</tr>
						<?php
							$k = 1 - $k;
							}
						?>
					
			</table>

				<input type="hidden" name="option" value="<?php echo $this->option ;  ?>" />
				<input type="hidden" name="c" value="resume" />
				<input type="hidden" name="view" value="resume" />
				<input type="hidden" name="layout" value="resume_searchresult" />
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
