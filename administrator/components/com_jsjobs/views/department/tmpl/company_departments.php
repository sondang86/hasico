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
 * File Name:	admin-----/views/applications/tmpl/users.php
 ^ 
 * Description: Template for users view
 ^ 
 * History:		NONE
 ^ 
 */

defined('_JEXEC') or die('Restricted access'); 
$document = JFactory::getDocument();
$document->addStyleSheet(JURI::root().'administrator/components/com_jsjobs/include/css/jsjobsadmin.css');
$status = array(
	'0' => JText::_('JS_PENDING'),
	'1' => JText::_('JS_APPROVED'),
	'-1' => JText::_('JS_REJECTED'));
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
				<div id="jsjobs_info_heading"><?php echo JText::_('JS_DEPARTMENTS'); ?></div>

			<form action="index.php?option=com_jsjobs" method="post" name="adminForm" id="adminForm">
				<table>
				<tr>
					<td width="100%">
						<strong><?php echo JText::_( 'Filter' ); ?></strong>
					</td>
					<td nowrap>
						<?php echo JText::_( 'JS_DEPARTMENT' ); ?>:
						<input type="text" name="searchdepartment" id="searchdepartment" size="15" value="<?php if(isset($this->lists['searchdepartment'])) echo $this->lists['searchdepartment'];?>" class="text_area" onchange="document.adminForm.submit();" />
					&nbsp;</td>
					<td nowrap >
						<?php echo JText::_( 'JS_COMPANY' ); ?>:
						<input type="text" name="searchcompany" id="searchcompany" size="15" value="<?php if(isset($this->lists['searchcompany'])) echo $this->lists['searchcompany'];?>" class="text_area" onchange="document.adminForm.submit();" />
						<button onclick="this.form.submit();"><?php echo JText::_( 'Go' ); ?></button>
					&nbsp;</td>
					
					<td>
						<button onclick="document.getElementById('searchdepartment').value='';document.getElementById('searchcompany').value='';this.form.submit();"><?php echo JText::_( 'Reset' ); ?></button>
					</td>
				</tr>
			</table>
				<table class="adminlist" cellpadding="1">
					<thead>
						<tr>
							<th width="2%" class="title">
								<?php echo JText::_( 'NUM' ); ?>
							</th>
						<th><?php echo JText::_('JS_DEPARTMENTNAME'); ?></th>
						<th><?php echo JText::_('JS_COMPANYNAME'); ?></th>
						<th><?php echo JText::_('CREATED');?></th>
						<th><?php echo JText::_('JS_STATUS'); ?></th>
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

						?>
						<tr class="<?php echo "row$k"; ?>">
							<td>
								<?php echo $i+1+$this->pagination->limitstart;?>
							</td>
							<td>
						<?php echo $row->name; ?>
						</td>
						<td style="text-align: center;">
							<?php echo $row->companyname; ?>
						</td>
						<td style="text-align: center;">
						<?php echo date( $this->config['date_format'],strtotime($row->created)); ?>
						</td>
						<td style="text-align: center;">
						<?php 
							if($row->status == 1) echo "<font color='green'>".$status[$row->status]."</font>";
							else echo "<font color='red'>".$status[$row->status]."</font>";
						?>
						</td>
						</tr>
						<?php
							$k = 1 - $k;
							}
						?>
					</tbody>
				</table>

				<input type="hidden" name="option" value="<?php echo $this->option; ?>" />
				<input type="hidden" name="md" value="<?php echo $this->companyid; ?>" />
				<input type="hidden" name="c" value="company" />
				<input type="hidden" name="view" value="company" />
				<input type="hidden" name="layout" value="company_departments" />
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

