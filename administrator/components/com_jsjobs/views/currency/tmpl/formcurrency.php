<?php
/**
 * @Copyright Copyright (C) 2009-2011 ... Ahmad Bilal
 * @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * Company:		Buruj Solutions
 + Contact:		www.burujsolutions.com , ahmad@burujsolutions.com
 * Created on:	Jan 11, 2009
 ^
 + Project: 		JS Jobs
 * File Name:	admin-----/views/application/tmpl/formcategory.php
 * 
 * Description: Form template for a single category
 * 
 * History:		NONE
 * 
 */
defined('_JEXEC') or die('Restricted access'); 
jimport('joomla.html.pane');
JHTML::_('behavior.formvalidation'); 
?>

<script type="text/javascript">
// for joomla 1.6
Joomla.submitbutton = function(task){
        if (task == ''){
                return false;
        }else{
                if (task == 'currency.savejobcurrencysave' || task == 'currency.savejobcurrencyandnew' || task == 'currency.savejobcurrency' ){
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
                f.check.value='<?php if(JVERSION < '3') echo JUtility::getToken(); else echo  JSession::getFormToken(); ?>';//send token
        }
        else {
                alert('<?php echo JText::_( 'JS_SOME_VALUES_ARE_NOT_ACCEPTABLE_PLEASE_RETRY');?>');
				return false;
        }
		return true;
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
	  <tr><td  height="10"></td></tr>	
	<?php
	}
	?>
	 <tr>
        <td width="100%" align="center"><label for="title"><?php echo JText::_('JS_TITLE'); ?> : </label>
		  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input class="inputbox required" type="text" name="title" id="title" size="40" maxlength="255" value="<?php if(isset($this->currency)) echo $this->currency->title; ?>" />
        </td>
      </tr>
	 <tr>
        <td width="100%" align="center"><label for="symbol"><?php echo JText::_('JS_CURRENCY_SYMBOL'); ?> : </label>
		  <input class="inputbox required" type="text" name="symbol" id="symbol" size="40" maxlength="255" value="<?php if(isset($this->currency)) echo $this->currency->symbol; ?>" />
        </td>
      </tr>
	 <tr>
        <td width="100%" align="center"><label for="code"><?php echo JText::_('JS_CODE'); ?> : </label>
		  <input class="inputbox required" type="text" name="code" id="code" size="40" maxlength="255" value="<?php if(isset($this->currency)) echo $this->currency->code; ?>" />
        </td>
      </tr>
      <tr>
        <td align="center"><?php echo JText::_('JS_PUBLISHED'); ?> : 
		  <input type="checkbox" name="status" value="1" <?php if(isset($this->currency)){  if ($this->currency->status == '1') echo 'checked';} ?>/>
		  </td>
      </tr>
	<tr><td  height="20"></td></tr>
	<tr>
		<td  align="center">
		<input type="submit" class="button" name="submit_app" onclick="return validate_form(document.adminForm)" value="<?php echo JText::_('JS_SAVE'); ?>" />
		</td>
	</tr>

    </table>
			<input type="hidden" name="id" value="<?php if(isset($this->currency)) echo $this->currency->id; ?>" />
			<input type="hidden" name="default" value="<?php if(isset($this->currency)) echo $this->currency->default; ?>" />
			<input type="hidden" name="ordering" value="<?php if(isset($this->currency)) echo $this->currency->ordering; ?>" />
			
			<input type="hidden" name="nisactive" value="1" />
			<input type="hidden" name="check" value="" />
			<input type="hidden" name="task" value="currency.savejobcurrency" />
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
