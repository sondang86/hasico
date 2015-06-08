<?php
/**
 * @Copyright Copyright (C) 2009-2011 ... Ahmad Bilal
 * @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * Company:		Buruj Solutions
 + Contact:		www.burujsolutions.com , ahmad@burujsolutions.com
 * Created on:	Jan 9, 2011
 ^
 + Project: 		JS Jobs
 * File Name:	admin-----/views/application/tmpl/formsubcategory.php
 * 
 * Description: Form template for a single sub category
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
                if (task == 'subcategory.savesubcategory'){
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
	<table cellpadding="0" cellspacing="0" border="0" width="100%" class="adminform">
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
        <tr class="row0">
            <td width="20%" align="right"><?php echo JText::_('JS_CATEGORY'); ?></td>
            <td width="60%"><strong><?php if(isset($this->subcategory)) echo $this->subcategory->cat_title; ?></strong>
            </td>
        </tr>
        <tr class="row1">
            <td width="20%" align="right"><label id="titlemsg" for="title"><?php echo JText::_('JS_CATEGORY_TITLE'); ?></label>&nbsp;<font color="red">*</font></td>
            <td width="60%"><input class="inputbox required" type="text" name="title" id="title" size="40" maxlength="255" value="<?php if(isset($this->subcategory->title)) echo $this->subcategory->title; ?>" />
            </td>
        </tr>
        <tr class="row0">
            <td align="right"><label id="statusmsg" for="status"><?php echo JText::_('JS_PUBLISHED'); ?></label>&nbsp;<font color="red">*</font></td>
            <td ><input type="checkbox" name="status" value="1" <?php if(isset($this->subcategory->status))  {if ($this->subcategory->status == 1) echo 'checked';} ?> />
            </td>
        </tr>
	<tr><td  height="10"></td></tr>
	<tr class="row1">
		<td colspan="2" align="center">
		<input type="submit" class="button" name="submit_app" onclick="return validate_form(document.adminForm)" value="<?php echo JText::_('JS_SAVE'); ?>" />
		</td>
	</tr>

    </table>
			<input type="hidden" name="id" value="<?php if(isset($this->subcategory)) if(isset($this->subcategory->id)) echo $this->subcategory->id; ?>" />
			<input type="hidden" name="categoryid" value="<?php if(isset($this->subcategory)) if($this->subcategory->categoryid)echo $this->subcategory->categoryid; else echo $this->categoryid; else echo $this->categoryid; ?>" />
			<input type="hidden" name="isdefault" value="<?php if(isset($this->subcategory)) echo $this->subcategory->isdefault; ?>" />
			<input type="hidden" name="ordering" value="<?php if(isset($this->subcategory)) echo $this->subcategory->ordering; ?>" />
			
			<input type="hidden" name="task" value="subcategory.savesubcategory" />
			<input type="hidden" name="option" value="<?php echo $this->option; ?>" />
                        <input type="hidden" name="check" value="post"/>

			
	
  </form>
		</td>
	</tr>
	<tr>
		<td colspan="2" align="left" width="100%"  valign="top">
			<table width="100%" style="table-layout:fixed;"><tr><td style="vertical-align:top;"><?php echo '<table width="100%" style="table-layout:fixed;"> <tr><td height="15"></td></tr> <tr> <td style="vertical-align:middle;" align="center"> <a href="http://www.joomsky.com" target="_blank"><img src="http://www.joomsky.com/logo/jsjobscrlogo.png" ></a> <br> Copyright &copy; 2008 - '. date('Y') .', <a href="http://www.joomsky.com" target="_blank">Joom Sky</a>  </td> </tr> </table>';  ?></td></tr></table>
		</td>
	</tr>
	
</table>				
