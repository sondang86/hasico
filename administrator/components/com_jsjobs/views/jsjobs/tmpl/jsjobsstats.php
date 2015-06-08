<?php
/**
 * @Copyright Copyright (C) 2009-2011
 * @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
 + Created by:	Ahmad Bilal
 * Company:		Buruj Solutions
 + Contact:		www.burujsolutions.com , ahmad@burujsolutions.com
 * Created on:	Sep 21, 2010
 ^
 + Project: 		JS Jobs
 * File Name:	admin-----/views/applications/tmpl/jsjobsstats.php
 ^ 
 * Description: JS Jobs stats
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
		<td width="100%" valign="top" cellpadding="0" cellspacing="0" >
			<div id="jsjobs_info_heading"><?php echo JText::_('JS_JOBS_STATS'); ?></div>	
			<table id="jsjobsstats_data_table" class="adminlist" cellpadding="0" cellspacing="0" border="0">
				<thead>
					<tr>
						<th width="50%"></th>
						<th width="25%"><?php echo JText::_('JS_TOTAL'); ?></th>
						<th width="25%"><?php echo JText::_('JS_ACTIVE'); ?></th>
					</tr>
				</thead>
				<tr class="row0">
                                    <td><strong><?php echo JText::_('JS_COMPANIES'); ?></strong></td>
                                    <td><strong><?php if(isset($this->companies->totalcompanies)) echo $this->companies->totalcompanies; ?></strong></td>
                                    <td><strong><?php if(isset($this->companies->activecompanies)) echo $this->companies->activecompanies; ?></strong></td>
				</tr>
				<tr class="row1">
                                    <td><strong>Jobs</strong></td>
                                    <td><strong><?php if(isset($this->jobs->totaljobs)) echo $this->jobs->totaljobs; ?></strong></td>
                                    <td><strong><?php if(isset($this->jobs->activejobs)) echo $this->jobs->activejobs; ?></strong></td>
				</tr>
				<tr class="row0">
                                    <td><strong>Resumes</strong></td>
                                    <td><strong><?php if(isset($this->resumes->totalresumes)) echo $this->resumes->totalresumes; ?></strong></td>
                                    <td><strong><?php if(isset($this->resumes->activeresumes)) echo $this->resumes->activeresumes; ?></strong></td>
				</tr>
				<tr class="row1">
                                    <td><strong>Gold Companies</strong></td>
                                    <td><strong>0</strong></td>
                                    <td><strong>0</strong></td>
				</tr>
				<tr class="row0">
                                    <td><strong>Featured Companies</strong></td>
                                    <td><strong>0</strong></td>
                                    <td><strong>0</strong></td>
				</tr>
				<tr class="row1">
                                    <td><strong>Gold Jobs</strong></td>
                                    <td><strong>0</strong></td>
                                    <td><strong>0</strong></td>
				</tr>
				<tr class="row0">
                                    <td><strong>Featured Jobs</strong></td>
                                    <td><strong>0</strong></td>
                                    <td><strong>0</strong></td>
				</tr>
				<tr class="row1">
                                    <td><strong>Gold Resumes</strong></td>
                                    <td><strong>0</strong></td>
                                    <td><strong>0</strong></td>
				</tr>
				<tr class="row0">
									<td><strong>Featured Resumes</strong></td>
                                    <td><strong>0</strong></td>
                                    <td><strong>0</strong></td>
				</tr>
				<tr class="row1">
									<td><strong>Employer</strong></td>
                                    <td><strong><?php if(isset($this->totalemployer->totalemployer)) echo $this->totalemployer->totalemployer; ?></strong></td>
                                    <td><strong><?php  echo '-'; ?></strong></td>
				</tr>
				<tr class="row0">
									<td><strong>Jobseeker</strong></td>
                                    <td><strong><?php if(isset($this->totaljobseeker->totaljobseeker)) echo $this->totaljobseeker->totaljobseeker; ?></strong></td>
                                    <td><strong><?php  echo '-'; ?></strong></td>
				</tr>
		
			</table>
		</td>
	</tr>
	<tr>
		<td colspan="2" align="left" width="100%"  valign="top">
			<table width="100%" style="table-layout:fixed;"><tr><td style="vertical-align:top;"><?php echo '<table width="100%" style="table-layout:fixed;"> <tr><td height="15"></td></tr> <tr> <td style="vertical-align:middle;" align="center"> <a href="http://www.joomsky.com" target="_blank"><img src="http://www.joomsky.com/logo/jsjobscrlogo.png" ></a> <br> Copyright &copy; 2008 - '. date('Y') .', <a href="http://www.joomsky.com" target="_blank">Joom Sky</a>  </td> </tr> </table>';  ?></td></tr></table>
		</td>
	</tr>
	
</table>							
