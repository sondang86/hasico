<?php
/**
 * @Copyright Copyright (C) 2009-2011
 * @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
 + Created by:	Ahmad Bilal
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
$ADMINPATH = JPATH_BASE .'\components\com_jsjobs';
$document = JFactory::getDocument();
$document->addStyleSheet(JURI::root().'administrator/components/com_jsjobs/include/css/jsjobsadmin.css');
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
				<div id="jsjobs_info_heading"><?php echo JText::_('JS_EMPLOYER_PAYMENT_HISTORY'); ?></div>
			
			<form action="index.php" method="post" name="adminForm" id="adminForm">
			<div id="js_job_filter">
                            <span class="js_job_filter_title"><?php echo JText::_( 'Filter' ); ?></span>
                            <div class="js_job_filter_field_wrapper">
                                <span class="title"><?php echo JText::_( 'JS_TITLE' ); ?></span>
                                <input type="text" name="searchtitle" id="searchtitle" size="15" value="<?php if(isset($this->lists['searchtitle'])) echo $this->lists['searchtitle'];?>" class="text_area" onchange="document.adminForm.submit();" />
                            </div>
                            <div class="js_job_filter_field_wrapper">
                                <span class="title"><?php echo JText::_( 'JS_PRICE' ); ?></span>
                                <input type="text" name="searchprice" id="searchprice" size="15" value="<?php if(isset($this->lists['searchprice'])) echo $this->lists['searchprice'];?>" class="text_area" onchange="document.adminForm.submit();" />
                            </div>
                            <div class="js_job_filter_field_wrapper">
                                <span class="title"><?php echo JText::_( 'JS_STATUS' ); ?></span>
                                <?php echo $this->lists['paymentstatus'];?>
                            </div>
                            <div class="js_job_filter_field_wrapper">
                                <button onclick="this.form.submit();"><?php echo JText::_('Go'); ?></button>
                                <button onclick="document.getElementById('searchtitle').value='';document.getElementById('searchprice').value='';this.form.getElementById('searchpaymentstatus').value='';this.form.submit();"><?php echo JText::_('Reset'); ?></button>
                            </div>
			</div>
			<table class="adminlist" border="0">
				<thead>
					<tr>
						<th width="20">
							<?php if(JVERSION < '3'){ ?> 
								<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->items); ?>);" />
							<?php }else{ ?>
								<input type="checkbox" name="toggle" value="" onclick="Joomla.checkAll(this);" />
							<?php } ?>
						</th>
						<th><?php echo JText::_('JS_TITLE'); ?></th>
						<th><?php echo JText::_('JS_EMPLOYER_NAME'); ?></th>
						<!--<th><?php echo JText::_('JS_COMPANY_NAME'); ?></th>-->
						<th><?php echo JText::_('JS_PRICE'); ?></th>
						<th ><?php echo JText::_('JS_DISCOUNT_AMOUNT'); ?></th>
						<th ><?php echo JText::_('JS_CREATED'); ?></th>
						<th ><?php echo JText::_('JS_PAYMENT_STATUS'); ?></th>
						<th ><?php echo JText::_('JS_VERIFY_PAYMENT'); ?></th>
						
					</tr>
				</thead>
			<?php
			jimport('joomla.filter.output');
			$k = 0;
				$approvetask 	= 'employerpaymentapprove';
				$approveimg 	= 'tick.png';
				$rejecttask 	= 'employerpaymentreject';
				$rejectimg 	= 'publish_x.png';
				$approvealt 	= JText::_( 'Approve' );
				$rejectalt 	= JText::_( 'Reject' );
				
				for ($i=0, $n=count( $this->items ); $i < $n; $i++)
				{
				$row = $this->items[$i];
				$checked = JHTML::_('grid.id', $i, $row->id);
				$link = JFilterOutput::ampReplace('index.php?option='.$this->option.'&task=paymenthistory.edit&cid[]='.$row->id);
				
				?>
				<tr valign="top" class="<?php echo "row$k"; ?>">
					<td>
						<?php echo $checked; ?>
					</td>
					
						
					<td><a href="index.php?option=com_jsjobs&c=paymenthistory&view=paymenthistory&layout=employerpaymentdetails&pk=<?php echo $row->id; ?>"><?php echo $row->packagetitle; ?></a></td>

					<td align="center"><?php echo $row->employername; ?></td>

					<td align="center"><?php echo $row->symbol . $row->packageprice; ?></td>
					<td align="center"><?php if($row->discountamount )echo $row->symbol .$row->discountamount; ?></td>
					<td align="center"><?php echo date($this->config['date_format'],strtotime($row->created)); ?></td>
					<td align="center"><?php if($row->transactionverified == 1) echo JText::_('JS_VERIFIED'); else echo JText::_('JS_NOT_VERIFIED'); ?></td>
					<td style="text-align: center;">
					<a href="javascript:void(0);" onclick="return listItemTask('cb<?php echo $i;?>','paymenthistory.<?php echo $approvetask;?>')">
							<img src="../components/com_jsjobs/images/<?php echo $approveimg;?>" width="16" height="16" border="0" alt="<?php echo $approvealt; ?>" /></a>
							&nbsp;&nbsp; - &nbsp;&nbsp
							<a href="javascript:void(0);" onclick="return listItemTask('cb<?php echo $i;?>','paymenthistory.<?php echo $rejecttask;?>')">
							<img src="../components/com_jsjobs/images/<?php echo $rejectimg;?>" width="16" height="16" border="0" alt="<?php echo $rejectalt; ?>" /></a>

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
			<input type="hidden" name="c" value="paymenthistory" />
			<input type="hidden" name="view" value="paymenthistory" />
			<input type="hidden" name="layout" value="employerpaymenthistory" />
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
