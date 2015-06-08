<?php 
/**
 * @Copyright Copyright (C) 2009-2011 ... Ahmad Bilal
 * @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
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
				<div id="jsjobs_info_heading"><?php echo JText::_('JS_USERS'); ?></div>

			<form action="index.php?option=com_jsjobs&c=userrole&view=userrole&layout=users" method="post" name="adminForm" id="adminForm">
			<div id="js_job_filter">
                            <span class="js_job_filter_title"><?php echo JText::_( 'Filter' ); ?></span>
                            <div class="js_job_filter_field_wrapper">
                                <span class="title"><?php echo JText::_( 'JS_NAME' ); ?></span>
                                <input type="text" name="searchname" id="searchname" value="<?php if(isset($this->lists['searchname'])) echo $this->lists['searchname'];?>"  />
                            </div>
                            <div class="js_job_filter_field_wrapper">
                                <span class="title"><?php echo JText::_( 'JS_USERNAME' ); ?></span>
                                <input type="text" name="searchusername" id="searchusername" size="15" value="<?php if(isset($this->lists['searchusername'])) echo $this->lists['searchusername'];?>"  />
                            </div>
                            <div class="js_job_filter_field_wrapper">
                                <span class="title"><?php echo JText::_( 'JS_COMPANY' ); ?></span>
                                <input type="text" name="searchcompany" id="searchcompany" size="15" value="<?php if(isset($this->lists['searchcompany'])) echo $this->lists['searchcompany'];?>"  />
                            </div>
                            <div class="js_job_filter_field_wrapper">
                                <span class="title"><?php echo JText::_( 'JS_RESUME' ); ?></span>
                                <input type="text" name="searchresume" id="searchresume" size="15" value="<?php if(isset($this->lists['searchresume'])) echo $this->lists['searchresume'];?>"  />
                            </div>
                            <div class="js_job_filter_field_wrapper">
                                <span class="title"><?php echo JText::_( 'JS_ROLE' ); ?></span>
                                <input type="text" name="searchrole" id="searchrole" size="15" value="<?php if(isset($this->lists['searchrole'])) echo $this->lists['searchrole'];?>"  />
                            </div>
                            <div class="js_job_filter_field_wrapper">
                                <button onclick="this.form.submit();"><?php echo JText::_('Go'); ?></button>
                                <button onclick="document.getElementById('searchname').value='';document.getElementById('searchusername').value='';document.getElementById('searchcompany').value='';document.getElementById('searchresume').value='';document.getElementById('searchrole').value='';this.form.submit();"><?php echo JText::_('Reset'); ?></button>
                            </div>
			</div>
				<table class="adminlist" cellpadding="1">
					<thead>
						<tr>
							<th width="2%" class="title">
								<?php echo JText::_( 'NUM' ); ?>
							</th>
							<th width="3%" class="title">
								<?php if(JVERSION < '3'){ ?> 
									<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->items); ?>);" />
								<?php }else{ ?>
									<input type="checkbox" name="toggle" value="" onclick="Joomla.checkAll(this);" />
								<?php } ?>
							</th>
							<th width="15%" class="title"><?php echo JText::_('Name'); ?></th>
							<th width="15%" class="title" ><?php echo JText::_('Username'); ?></th>
							<th width="15%" class="title"><?php echo JText::_('JS_COMPANY'); ?></th>
							<th width="15%" class="title"><?php echo JText::_('JS_RESUME'); ?></th>
							<th width="4%" class="title" nowrap="nowrap"><?php echo JText::_('Enabled'); ?></th>
							<th width="10%" class="title"><?php echo JText::_('Group'); ?></th>
							<th width="4%" class="title" nowrap="nowrap"><?php echo JText::_('ID'); ?></th>
							<th width="7%" class="title"><?php echo JText::_('JS_ROLE'); ?></th>
							<th width="15%" class="title"></th>
						</tr>
					</thead>
					<tfoot>
						<tr>
							<td colspan="11">
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
							$img 	= $row->block ? 'publish_x.png' : 'tick.png';
							$task 	= $row->block ? 'unblock' : 'block';
							$alt 	= $row->block ? JText::_( 'Enabled' ) : JText::_( 'Blocked' );
							$link 	= 'index.php?option=com_jsjobs&amp;c=userrole&amp;view=userrole&amp;layout=changerole&amp;cid[]='. $row->id. '';

						?>
						<tr class="<?php echo "row$k"; ?>">
							<td>
								<?php echo $i+1+$this->pagination->limitstart;?>
							</td>
							<td><?php echo JHTML::_('grid.id', $i, $row->id ); ?></td>
							<td><?php echo $row->name; ?></td>
							<td><?php echo $row->username; ?>	</td>
							<td><?php echo  $row->companyname ; ?></td>
							<td><?php echo  $row->first_name.' '.$row->last_name ; ?></td>
							<td align="center">	<img src="../components/com_jsjobs/images/<?php echo $img;?>" width="16" height="16" border="0" alt="<?php echo $alt; ?>" />					</td>
							<td><?php echo JText::_( $row->groupname ); ?>	</td>
							<td><?php echo $row->id; ?>	</td>
							<td align="center"><?php echo $row->roletitle ; ?>
							</td>
							<td align="center"><a href="<?php echo $link; ?>" ><?php echo JText::_('JS_CHANGE_ROLE'); ?></a></td>
							
						</tr>
						<?php
							$k = 1 - $k;
							}
						?>
					</tbody>
				</table>

				<input type="hidden" name="option" value="<?php echo $this->option; ?>" />
				<input type="hidden" name="task" value="view" />
				<input type="hidden" name="boxchecked" value="0" />
				<input type="hidden" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
				<input type="hidden" name="filter_order_Dir" value="<?php echo $this->lists['order_Dir']; ?>" />
				<?php echo JHTML::_( 'form.token' ); ?>
			</form>
		</td>
	</tr>
	<tr>
		<td colspan="2" align="left" width="100%"  valign="top">
			<table width="100%" style="table-layout:fixed;"><tr><td style="vertical-align:top;"><?php echo '<table width="100%" style="table-layout:fixed;"> <tr><td height="15"></td></tr> <tr> <td style="vertical-align:middle;" align="center"> <a href="http://www.joomsky.com" target="_blank"><img src="http://www.joomsky.com/logo/jsjobscrlogo.png" ></a> <br> Copyright &copy; 2008 - '. date('Y') .', <a href="http://www.joomsky.com" target="_blank">Joom Sky</a>  </td> </tr> </table>';  ?></td></tr></table>
		</td>
	</tr>
	
</table>										
