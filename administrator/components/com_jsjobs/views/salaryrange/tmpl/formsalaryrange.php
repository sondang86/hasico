<?php
/**
 * @Copyright Copyright (C) 2009-2011 ... Ahmad Bilal
 * @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * Company:		Buruj Solutions
 + Contact:		www.burujsolutions.com , ahmad@burujsolutions.com
 * Created on:	Jan 11, 2009
 ^
 + Project: 		JS Jobs
 * File Name:	admin-----/views/application/tmpl/formsalaryrange.php
 ^ 
 * Description: Form template for a salary range
 ^ 
 * History:		NONE
 ^ 
 */
 
defined('_JEXEC') or die('Restricted access'); 
jimport('joomla.html.pane');

JHTML::_('behavior.formvalidation');  
?>

<script type="text/javascript">
window.addEvent('domready', function(){
   document.formvalidator.setHandler('salarayrangestart', function(value) {
			if(isNaN(value)) return false;
			var rangeend = document.getElementById("rangeend").value;
			var rvalue=parseInt(rangeend);
			if(value > rvalue ){
				return false;
			}
			return true;
   });
});	

window.addEvent('domready', function(){
   document.formvalidator.setHandler('salarayrangeend', function(value) {
			if(isNaN(value)) return false;
			var rangestart = document.getElementById("rangestart").value;
			var rsvalue=parseInt(rangestart);
			if(value < rsvalue ){
				return false;
			}
			return true;
   });
});	
	
	
	
// for joomla 1.6
Joomla.submitbutton = function(task){
        if (task == ''){
                return false;
        }else{
                if (task == 'salaryrange.savejobsalaryrangesave' || task == 'salaryrange.savejobsalaryrangeandnew' || task == 'salaryrange.savejobsalaryrange' ){
                    returnvalue = validate_form(document.adminForm);
                }else returnvalue  = true;
                if (returnvalue){
                        Joomla.submitform(task);
                        return true;
                }else return false;
        }
}
function validate_form(f)
{
        if (document.formvalidator.isValid(f)) {
                f.check.value='<?php if(JVERSION < 3) echo JUtility::getToken(); else echo  JSession::getFormToken(); ?>';//send token
        }
        else {
			var msg = new Array();
                msg.push('<?php echo JText::_( 'JS_SOME_VALUES_ARE_NOT_ACCEPTABLE_PLEASE_RETRY');?>');
			var element_rangestart = document.getElementById('rangestart');                
			if(hasClass(element_rangestart,'invalid')){
					msg.push('<?php echo JText::_('JS_SALARY_RANGE_START_MUST_BE_LESS_THEN_SALARY_RANGE_END'); ?>');
            }
			var element_rangeend = document.getElementById('rangeend');                
			if(hasClass(element_rangeend,'invalid')){
					msg.push('<?php echo JText::_('JS_SALARY_RANGE_END_MUST_BE_GREATER_THEN_SALARY_RANGE_START'); ?>');
            }
            alert (msg.join('\n'));			
			return false;
        }
		return true;
}
function hasClass(el, selector) {
   var className = " " + selector + " ";
  
   if ((" " + el.className + " ").replace(/[\n\t]/g, " ").indexOf(className) > -1) {
    return true;
   }
   return false;
  }

</script>
<table width="100%" >
	<tr>
		<td align="left" width="175"  valign="top">
			<table width="100%" ><tr><td style="vertical-align:top;">
			<?php
			include_once('components/com_jsjobs/views/menu.php');
			?>
			</td>
			</tr></table>
		</td>
		<td width="100%" valign="top" align="left">
	<form action="index.php" method="POST" name="adminForm" id="adminForm" >
	<table cellpadding="0" cellspacing="0" border="0" width="100%" class="adminlist">
	<?php
	if($this->msg != ''){
	?>
	 <tr>
        <td align="center"><font color="red"><strong><?php echo JText::_($this->msg); ?></strong></font></td>
      </tr>
	  <tr><td height="10"></td></tr>	
	<?php
	}
	?>
	 <tr>
        <td width="100%" align="center"><?php echo JText::_('JS_SALARY_RANGE_START'); ?> : 
		  &nbsp;&nbsp;&nbsp;<input class="inputbox required validate-salarayrangestart" type="text" name="rangestart" id="rangestart" size="40" maxlength="255" value="<?php if(isset($this->application)) echo $this->application->rangestart; ?>" />
        </td>
      </tr>
	 <tr>
        <td align="center"><?php echo JText::_('JS_SALARY_RANGE_END'); ?> : 
		  &nbsp;&nbsp;&nbsp;<input class="inputbox required validate-salarayrangeend" type="text" name="rangeend" id="rangeend" size="40" maxlength="255" value="<?php  if(isset($this->application)) echo $this->application->rangeend; ?>" />
        </td>
      </tr>
      <tr>
        <td align="center"><?php echo JText::_('JS_PUBLISHED'); ?> : 
		  &nbsp;&nbsp;&nbsp;<input type="checkbox" name="status" value="1" <?php if(isset($this->application))  {if ($this->application->status == '1') echo 'checked';} ?>/>
		  </td>
      </tr>
      
	<tr><td height="20"></td></tr>
	<tr>
		<td align="center">
		<input type="submit" name="submit_app" onclick="return validate_form(document.adminForm)" value="<?php echo JText::_('JS_SAVE_SALARY_RANGE'); ?>" />
		</td>
	</tr>

    </table>
			<input type="hidden" name="id" value="<?php if(isset($this->application)) echo $this->application->id; ?>" />
			<input type="hidden" name="isdefault" value="<?php if(isset($this->application)) echo $this->application->isdefault; ?>" />
			<input type="hidden" name="ordering" value="<?php if(isset($this->application)) echo $this->application->ordering; ?>" />
			
			<input type="hidden" name="check" value="" />
			<input type="hidden" name="task" value="salaryrange.savejobsalaryrange" />
			<input type="hidden" name="option" value="<?php echo $this->option; ?>" />

			
	
  </form>
		</td>
	</tr>
	<tr>
		<td colspan="2" align="left" width="100%"  valign="top">
			<table width="100%" style="table-layout:fixed;"><tr><td style="vertical-align:top;"><?php echo '<table width="100%" style="table-layout:fixed;"> <tr><td height="15"></td></tr> <tr> <td style="vertical-align:middle;" align="center"> <a href="http://www.joomsky.com" target="_blank"><img src="http://www.joomsky.com/logo/jsjobscrlogo.png" ></a> <br> Copyright &copy; 2008 - '. date('Y') .', <a href="http://www.joomsky.com" target="_blank">Joom Sky</a>  </td> </tr> </table>';  ?></td></tr></table>
		</td>
	</tr>
	
</table>				
