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
				<div id="jsjobs_info_heading"><?php echo JText::_('JS_USER_STATS'); ?></div>

			<form action="index.php?option=com_jsjobs" method="post" name="adminForm" id="adminForm">
			<div id="js_job_filter">
                            <span class="js_job_filter_title"><?php echo JText::_( 'Filter' ); ?></span>
                            <div class="js_job_filter_field_wrapper">
                                <span class="title"><?php echo JText::_( 'JS_NAME' ); ?></span>
                                <input type="text" name="searchname" id="searchname" value="<?php if(isset($this->lists['searchname'])) echo $this->lists['searchname'];?>" class="text_area" onchange="document.adminForm.submit();" />
                            </div>
                            <div class="js_job_filter_field_wrapper">
                                <span class="title"><?php echo JText::_( 'JS_USERNAME' ); ?></span>
                                <input type="text" name="searchusername" id="searchusername" size="15" value="<?php if(isset($this->lists['searchusername'])) echo $this->lists['searchusername'];?>" class="text_area" onchange="document.adminForm.submit();" />
                            </div>
                            <div class="js_job_filter_field_wrapper">
                                <button onclick="this.form.submit();"><?php echo JText::_('Go'); ?></button>
                                <button onclick="document.getElementById('searchname').value='';document.getElementById('searchusername').value='';this.form.submit();"><?php echo JText::_('Reset'); ?></button>
                            </div>
			</div>
				<table class="adminlist" cellpadding="1">
					<thead>
						<tr>
							<th width="2%" class="title">
								<?php echo JText::_( 'NUM' ); ?>
							</th>
							<th class="title"><?php echo JText::_('Name'); ?></th>
							<th  class="title" ><?php echo JText::_('Username'); ?></th>
							<th  class="title" ><?php echo JText::_('JS_COMPANY'); ?></th>
							<th  class="title" ><?php echo JText::_('JS_RESUME'); ?></th>
							<th  class="title"><?php echo JText::_('JS_COMPANIES'); ?></th>
							<th  class="title" nowrap="nowrap"><?php echo JText::_('JS_JOBS'); ?></th>
							<th  class="title" nowrap="nowrap"><?php echo JText::_('JS_RESUMES'); ?></th>
							
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
							<td><?php echo $row->name; ?></td>
							<td><?php echo $row->username; ?>	</td>
							<td><?php echo $row->companyname; ?>	</td>
							<td><?php echo $row->resumename; ?>	</td>

                                                            <?php if($row->rolefor == 1){ // employer ?>
                                                                <td align="center"><a href="index.php?option=com_jsjobs&c=user&view=user&layout=userstate_companies&md=<?php echo $row->id; ?>"><strong><?php echo  $row->companies ; ?></strong></a></td>
                                                                <td align="center"><a href="index.php?option=com_jsjobs&c=user&view=user&layout=userstate_jobs&bd=<?php echo $row->id; ?>"><strong><?php echo  $row->jobs ; ?></a></strong></td>
                                                                <td align="center"><strong>-</strong></td>
                                                            <?php }elseif($row->rolefor == 2){ //jobseeker ?>
                                                                <td align="center"><strong>-</strong></td>
                                                                <td align="center"><strong>-</strong></td>
                                                                <td align="center"><a href="index.php?option=com_jsjobs&c=user&view=user&layout=userstate_resumes&ruid=<?php echo $row->id; ?>"><strong><?php echo  $row->resumes ; ?></a></strong></td>
                                                            <?php }else{ ?>
                                                                <td align="center"><strong>-</strong></td>
                                                                <td align="center"><strong>-</strong></td>
                                                                <td align="center"><strong>-</strong></td>
                                                            <?php } ?>

						</tr>
						<?php
							$k = 1 - $k;
							}
						?>
					</tbody>
				</table>

				<input type="hidden" name="option" value="<?php echo $this->option; ?>" />
				<input type="hidden" name="view" value="user" />
				<input type="hidden" name="layout" value="userstats" />
				<input type="hidden" name="task" value="view" />
				<input type="hidden" name="boxchecked" value="0" />
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
