<?php
/**
 * @Copyright Copyright (C) 2009-2011 ... Ahmad Bilal
 * @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * Company:		Buruj Solutions
 + Contact:		www.burujsolutions.com , ahmad@burujsolutions.com
 * Created on:	Jun 05, 2009
 ^
 + Project: 		JS Jobs
 * File Name:	admin-----/views/applications/tmpl/employerpackages.php
 ^ 
 * Description: Default template for employer packages
 ^ 
 * History:		NONE
 ^ 
 */
 
defined('_JEXEC') or die('Restricted access');
JHTML::_('behavior.calendar');
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
			<form action="index.php" method="post" name="adminForm" id="adminForm">
			<table>
				<tr>
					<td width="100%">
						<strong><?php echo JText::_( 'Filter' ); ?></strong>
					</td>
					<td>
						<?php echo $this->lists['paymentstatus'];?>
					</td>&nbsp;
					<td nowrap>
					<?php echo JText::_( 'JS_START' ); ?>:
					<input type="text" name="searchstartdate" id="searchstartdate" value="<?php if(isset($this->lists['searchstartdate'])) echo $this->lists['searchstartdate'];?>" class="text_area" onchange="document.adminForm.submit();" />
					<input class="button" value="..." onclick="return showCalendar('searchstartdate','%Y-%m-%d');" type="reset">
					</td>&nbsp;
					</td>
					<td nowrap>
					<?php echo JText::_( 'JS_END' ); ?>:
					<input type="text" name="searchenddate" id="searchenddate" value="<?php if(isset($this->lists['searchenddate'])) echo $this->lists['searchenddate'];?>" class="text_area" onchange="document.adminForm.submit();" />
					<input class="button" value="..." onclick="return showCalendar('searchenddate','%Y-%m-%d');" type="reset">					
					</td>&nbsp;
					</td>
					<td>
						<button onclick="this.form.submit();"><?php echo JText::_( 'Go' ); ?></button>
					</td>&nbsp;
					
					<td>
						<button onclick="this.form.getElementById('searchpaymentstatus').value='';document.getElementById('searchstartdate').value='';document.getElementById('searchenddate').value='';this.form.submit();"><?php echo JText::_( 'Reset' ); ?></button>
					</td>
				</tr>
			</table>
			
			
			<table class="adminlist" border="0">
				<thead>
					<tr>
						<th><?php echo JText::_('JS_TITLE'); ?></th>
						<th><?php echo JText::_('JS_PACKAGE_FOR'); ?></th>
						<th><?php echo JText::_('JS_NAME'); ?></th>
						<th><?php echo JText::_('JS_PAYER_NAME'); ?></th>
						<th><?php echo JText::_('JS_PAID_AMOUNT'); ?></th>
						<th><?php echo JText::_('JS_PAYMENT_STATUS'); ?></th>
						<th ><?php echo JText::_('JS_CREATED'); ?></th>
						
						
						
					</tr>
				</thead>
			<?php
			jimport('joomla.filter.output');
			$k = 0;
				
				
				for ($i=0, $n=count( $this->items ); $i < $n; $i++)
				{
				$row = $this->items[$i];
				$checked = JHTML::_('grid.id', $i, $row->id);
				$link = JFilterOutput::ampReplace('index.php?option='.$this->option.'&task=paymenthistory.edit&cid[]='.$row->id);
				
				?>
				<tr valign="top" class="<?php echo "row$k"; ?>">
					
					<td><?php echo $row->packagetitle; ?></td>
					<td align="center"><?php echo $row->packagefor; ?></td>
					<td align="center"><?php echo $row->buyername; ?></td>
					<td align="center"><?php echo $row->payer_firstname; ?></td>
					<td align="center"><?php if($row->paidamount )echo $this->config['currency'] .$row->paidamount; ?></td>
					<td align="center"><?php if($row->transactionverified == 1) echo JText::_('JS_VERIFIED'); else echo JText::_('JS_NOT_VERIFIED'); ?></td>
					<td align="center"><?php echo date($this->config['date_format'],strtotime($row->created)); ?></td>
					
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
			<input type="hidden" name="c" value="paymenthistory" />
			<input type="hidden" name="view" value="paymenthistory" />
			<input type="hidden" name="layout" value="package_paymentreport" />
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
