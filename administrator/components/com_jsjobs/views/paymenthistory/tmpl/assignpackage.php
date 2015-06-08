<?php
/**
 * @Copyright Copyright (C) 2009-2011 ... Ahmad Bilal
 * @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * Company:		Buruj Solutions
 + Contact:		www.burujsolutions.com , ahmad@burujsolutions.com
 * Created on:	Jan 11, 2009
 ^
 + Project: 		JS Jobs
 * File Name:	admin-----/views/application/tmpl/assignpackage.php
 *
 * Description: Form to set package to users
 *
 * History:		NONE
 *
 */

defined('_JEXEC') or die('Restricted access');
jimport('joomla.html.pane');
JHTML::_('behavior.formvalidation');
JHTML::_('behavior.modal');
$document = JFactory::getDocument();
if(JVERSION < 3){
        JHtml::_('behavior.mootools');
        $document->addScript('../components/com_jsjobs/js/jquery.js');
}else{
        JHtml::_('behavior.framework');
        JHtml::_('jquery.framework');
}	
?>

<script type="text/javascript">
// for joomla 1.6
Joomla.submitbutton = function(task){
        if (task == ''){
                return false;
        }else{
                if (task == 'paymenthistory.save'){
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
	<table cellpadding="0" cellspacing="0" border="0" width="100%" class="adminlist">
            <?php
                $td=array('row0','row1');$k=0;
                //$td=array('','');
                $userlink='index.php?option=com_jsjobs&c=user&view=user&layout=users&tmpl=component&task=preview';
            ?>
            <tr class="<?php echo $td[$k];$k=1-$k; ?>">
                <td valign="top" align="right"><label id="usernamemsg" for="username"><?php echo JText::_('JS_USER_NAME'); ?></label><font color="red">*</font> </td>
                <td>
                    <input  class="inputbox required" type="text" name="username" id="username" value="<?php if(isset($this->user)) { echo $this->user->username; }else { echo ""; } ?>" />
                        <a class="modal" rel="{handler: 'iframe', size: {x: 870, y: 350}}" id="" href="<?php echo $userlink; ?>"><?php echo JText::_('JS_SELECT_USER') ?></a>
                </td>
           </tr>
            <tr class="<?php echo $td[$k];$k=1-$k; ?>">
                <td valign="top" align="right"><label id="userpackagemsg" for="packageid"><?php echo JText::_('JS_PACKAGE'); ?></label><font color="red">*</font> </td>
                <td id="package">
                </td>
           </tr>
	<tr><td colspan="2"  height="20"></td></tr>
	<tr>
		<td colspan="2" align="center">
		<input type="submit" class="button" name="submit_app" onclick="return validate_form(document.adminForm)" value="<?php echo JText::_('JS_SAVE'); ?>" />
		</td>
	</tr>

    </table>
			<input type="hidden" name="nisactive" value="1" />
			<input type="hidden" name="check" value="" />
			<input type="hidden" name="task" value="paymenthistory.saveuserpackage" />
			<input type="hidden" name="userrole" id="userrole" value="" />
			<input type="hidden" name="userid" id="userid" value="" />
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
<script language="javascript">
function setuser(username,userid){
    jQuery.post("index.php?option=com_jsjobs&task=userrole.listuserdataforpackage",{val:userid},function(data){
        if(data){
            if(data != false){
                var obj = eval("("+data+")");//return Value
                document.getElementById('package').innerHTML = obj.list;
                document.getElementById('username').value = username;
                document.getElementById('userrole').value = obj.userrole;
                document.getElementById('userid').value = userid;
                window.setTimeout('closeme();', 300);
            }else{
                    alert('<?php echo JText::_('JS_SELECTED_USERS_IS_NOT_THE_USER_OF_JSJOBS_SYSTEM')?>');
            }
        }
    });          
}
function closeme() {
    parent.SqueezeBox.close();
}
</script>
