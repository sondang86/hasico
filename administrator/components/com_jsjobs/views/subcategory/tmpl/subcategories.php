<?php
/**
 * @Copyright Copyright (C) 2009-2011 ... Ahmad Bilal
 * @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * Company:		Buruj Solutions
 + Contact:		www.burujsolutions.com , ahmad@burujsolutions.com
 * Created on:	Jan 9, 2011
 ^
 + Project: 		JS Jobs
 * File Name:	admin-----/views/applications/tmpl/subcategories.php
 ^ 
 * Description: Default template for sub categories view
 ^ 
 * History:		NONE
 ^ 
 */
 
defined('_JEXEC') or die('Restricted access');
$document = JFactory::getDocument();
$document->addStyleSheet(JURI::root().'administrator/components/com_jsjobs/include/css/jsjobsadmin.css');
$session = JFactory::getSession();
$categoryid = $session->get('sub_categoryid');
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
				<div id="jsjobs_info_heading"><?php echo JText::_('JS_SUB_CATEGORIES'); ?></div>
			<form action="index.php" method="post" name="adminForm" id="adminForm">
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
						<th  width="60%" class="title"><?php echo JText::_('JS_SUBCATEGORY'); ?></th>
						<th><?php echo JText::_('JS_DEFAULT'); ?></th>
						<th><?php echo JText::_('JS_PUBLISHED'); ?></th>
						<th><?php echo JText::_('JS_ORDERING'); ?></th>
					</tr>
				</thead>
			<?php
			jimport('joomla.filter.output');
			$k = 0;
				for ($i=0, $n=count( $this->items ); $i < $n; $i++)
				{
				$row = $this->items[$i];
				$upimg 	= 'uparrow.png';
				$downimg 	= 'downarrow.png';
				$checked = JHTML::_('grid.id', $i, $row->id);
				$link = JFilterOutput::ampReplace('index.php?option='.$this->option.'&task=subcategory.editsubcategories&cid[]='.$row->id);
				?>
				<tr valign="top" class="<?php echo "row$k"; ?>">
					<td>
						<?php echo $checked; ?>
					</td>
					<td>
						<a href="<?php echo $link; ?>">
						<?php echo $row->title; ?></a>
					</td>
					<td align="center">
						<?php if($row->isdefault == 1 ) { ?> 
							<img src="../components/com_jsjobs/images/default.png" width="16" height="16" border="0" alt="Default" />
						<?php }else{ ?>
							<a href="index.php?option=com_jsjobs&c=common&task=makedefault&for=subcategories&id=<?php echo $row->id;?>">
							<img src="../components/com_jsjobs/images/notdefault.png" width="16" height="16" border="0" alt="Not Default" /></a>
						<?php } ?>	
					</td>	
					<td align="center">
						<?php
							if($row->status == 1){ // published ?>
								<a href="javascript:void(0);" onclick="return listItemTask('cb<?php echo $i;?>','subcategory.unpublishsubcategories')">
										<img src="../components/com_jsjobs/images/tick.png" width="16" height="16" border="0" alt="<?php echo JText::_( 'Published' ); ?>" /></a>
							<?php }else{ // published ?>
								<a href="javascript:void(0);" onclick="return listItemTask('cb<?php echo $i;?>','subcategory.publishsubcategories')">
										<img src="../components/com_jsjobs/images/publish_x.png" width="16" height="16" border="0" alt="<?php echo JText::_( 'Unpublishe' ); ?>" /></a>
							<?php } ?>
					</td>
					<td align="center">
						<?php if ($i != 0 ) {  ?>		
							<a href="index.php?option=com_jsjobs&c=common&task=defaultorderingdown&for=subcategories&id=<?php echo $row->id;?>">
							<img src="../components/com_jsjobs/images/<?php echo $upimg;?>" width="16" height="16" border="0" alt="Order Up" /></a>
						<?php } else echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';?>	
						<?php echo $row->ordering; ?>
						<?php if ($i < $n-1) { ?>
							<a href="index.php?option=com_jsjobs&c=common&task=defaultorderingup&for=subcategories&id=<?php echo $row->id;?>">
							<img src="../components/com_jsjobs/images/<?php echo $downimg;?>" width="16" height="16" border="0" alt="Order Down" /></a>
						<?php } ?>	
					</td>
				</tr>
				<?php
				$k = 1 - $k;
			}
			?>
			<tr>
				<td colspan="9" align="right">
					<a href="index.php?option=com_jsjobs&task=subcategory.setorderingsubcategories&cd=<?php echo $categoryid;?>"><?php echo JText::_('JS_SET_ORDERING') ?></a>
				</td>
			</tr>
			<tr>
				<td colspan="9">
					<?php echo $this->pagination->getListFooter(); ?>
				</td>
			</tr>
			</table>
			<input type="hidden" name="option" value="<?php echo $this->option; ?>" />
			<input type="hidden" name="c" value="subcategory" />
			<input type="hidden" name="view" value="subcategory" />
			<input type="hidden" name="layout" value="subcategories" />
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
<script language=Javascript>
	function setordering(catid){
		jQuery.ajax ({
					 type: "POST",
					 url: "index.php?option=com_jsjobs&task=subcategory.setorderingsubcategories&cd="+catid,
					 data: catid,
					 success: function (data) {
							if(data==true) alert('<?php echo JText ::_('JS_ORDERING_SET') ?>'); 
							else alert('<?php echo JText ::_('JS_ERROR_ORDERING_SET') ?>');
					 }
				 });

	}
	
</script>
