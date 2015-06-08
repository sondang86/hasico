<?php
/**
 * @Copyright Copyright (C) 2009-2011 ... Ahmad Bilal
 * @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * Company:		Buruj Solutions
 + Contact:		www.burujsolutions.com , ahmad@burujsolutions.com
 * Created on:	Sep 21, 2010
 ^
 + Project: 		JS Jobs
 * File Name:	admin-----/views/applications/tmpl/paymentreport.php
 ^ 
 * Description: Default template for payment report
 ^ 
 * History:		NONE
 ^ 
 */
 
defined('_JEXEC') or die('Restricted access');
$document = JFactory::getDocument();
$document->addStyleSheet(JURI::root().'administrator/components/com_jsjobs/include/css/jsjobsadmin.css');
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
				<div id="jsjobs_info_heading"><?php echo JText::_('JS_PAYMENT_REPORT'); ?></div>
			
			<form action="index.php" method="post" name="adminForm" id="adminForm">
			<div id="js_job_filter">
                            <span class="js_job_filter_title"><?php echo JText::_( 'Filter' ); ?></span>
                            <div class="js_job_filter_field_wrapper">
                                <span class="title"><?php echo JText::_( 'JS_PAYMENT_FOR' ); ?></span>
                                <?php echo $this->lists['paymentfor'];?>
                            </div>
                            <div class="js_job_filter_field_wrapper">
                                <span class="title"><?php echo JText::_( 'JS_STATUS' ); ?></span>
                                <?php echo $this->lists['paymentstatus'];?>
                            </div>
                            <div class="js_job_filter_field_wrapper">
                                <span class="title"><?php echo JText::_( 'JS_START' ); ?></span>
                                <?php echo JHTML::_('calendar', '','prsearchstartdate', 'prsearchstartdate',$js_dateformat,array('class'=>'inputbox', 'size'=>'10',  'maxlength'=>'19')); ?>
                            </div>
                            <div class="js_job_filter_field_wrapper">
                                <span class="title"><?php echo JText::_( 'JS_END' ); ?></span>
                                <?php echo JHTML::_('calendar', '','prsearchenddate', 'prsearchenddate',$js_dateformat,array('class'=>'inputbox', 'size'=>'10',  'maxlength'=>'19')); ?>
                            </div>
                            <div class="js_job_filter_field_wrapper">
                                <button onclick="this.form.submit();"><?php echo JText::_('Go'); ?></button>
                                <button onclick="this.form.getElementById('searchpaymentstatus').value='';document.getElementById('prsearchstartdate').value='';document.getElementById('prsearchenddate').value='';this.form.getElementById('paymentfor').value='both';this.form.submit();"><?php echo JText::_('Reset'); ?></button>
                            </div>
			</div>
			<table class="adminlist" border="0">
				<thead>
					<tr>
						<th><?php echo JText::_('JS_PACKAGE'); ?></th>
						<th width="10%"><?php echo JText::_('JS_PACKAGE_FOR'); ?></th>
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
				
				?>
				<tr valign="top" class="<?php echo "row$k"; ?>">
					<td><?php echo $row->packagetitle; ?></td>
					<td align="center"><?php echo $row->packagefor; ?></td>
					<td align="center">
                                            <?php if($row->packagefor == 'Employer'){ ?>
                                                <a href="index.php?option=com_jsjobs&c=user&view=user&layout=userstate_companies&md=<?php echo $row->uid; ?>"><?php echo $row->buyername; ?></a>
                                            <?php }else if($row->packagefor == 'Job Seeker'){ ?>
                                                <a href="index.php?option=com_jsjobs&c=user&view=user&layout=userstate_resumes&ruid=<?php echo $row->uid; ?>"><?php echo $row->buyername; ?></a>
                                            <?php } ?>
                                        </td>
					<td align="center"><?php echo $row->payer_firstname; ?></td>
					<td align="center"><?php if($row->paidamount )echo $row->symbol .$row->paidamount; ?></td>
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
			<input type="hidden" name="layout" value="payment_report" />
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
