<?php

/**
 * @version		$Id: register.php 1492 2012-02-22 17:40:09Z joomlaworks@gmail.com $
 * @package		K2
 * @author		JoomlaWorks http://www.joomlaworks.net
 * @copyright	Copyright (c) 2006 - 2012 JoomlaWorks Ltd. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

// no direct access
defined('_JEXEC') or die('Restricted access');
jimport( 'joomla.html.parameter' );
JHTML::_('behavior.formvalidation'); 
?>
<div id="jsjobs_main">
<div id="js_menu_wrapper">
    <?php
    if (sizeof($this->jobseekerlinks) != 0){
        foreach($this->jobseekerlinks as $lnk){ ?>                     
            <a class="js_menu_link <?php if($lnk[2] == 'job_categories') echo 'selected'; ?>" href="<?php echo $lnk[0]; ?>"><?php echo $lnk[1]; ?></a>
        <?php }
    }
    if (sizeof($this->employerlinks) != 0){
        foreach($this->employerlinks as $lnk)	{ ?>
            <a class="js_menu_link <?php if($lnk[2] == 'job_categories') echo 'selected'; ?>" href="<?php echo $lnk[0]; ?>"><?php echo $lnk[1]; ?></a>
        <?php }
    }
    ?>
</div>

<?php if ($this->config['offline'] == '1'){ ?>
        <div class="js_job_error_messages_wrapper">
            <div class="js_job_messages_image_wrapper">
                <img class="js_job_messages_image" src="components/com_jsjobs/images/7.png"/>
            </div>
            <div class="js_job_messages_data_wrapper">
                <span class="js_job_messages_main_text">
                    <?php echo JText::_('JS_JOBS_OFFLINE_MODE'); ?>
                </span>
                <span class="js_job_messages_block_text">
                    <?php echo $this->config['offline_text']; ?>
                </span>
            </div>
        </div>
<?php }else{ ?>
    <div id="js_main_wrapper">
        <span class="js_controlpanel_section_title">
            <?php
            if ($this->userrole == 2) {
                echo JText::_('JS_JOBSEEKER_LOGIN');
            } elseif ($this->userrole == 3) {
                echo JText::_('JS_EMPLOYER_LOGIN');
            }
            ?>
        </span>
<form action="<?php echo JRoute::_('index.php?option=com_users&task=user.login'); ?>" method="post" id="loginform" name="loginform">

	<div id="userform" class="userform">
		<table cellpadding="5" cellspacing="0" border="0" width="100%" class="admintable" >
			<tr>
				<td align="right" nowrap>
					<label id="name-lbl" for="name"><?php echo JText::_('JS_USER_NAME'); ?>: </label>* 
				</td>
				<td>
					<input id="username" class="validate-username" type="text" size="25" value="" name="username" >
				</td>
			</tr>
			<tr>
				<td align="right" nowrap>
					<label id="password-lbl" for="password"><?php echo JText::_('JS_PASSWORD'); ?>: </label>* 
				</td>
				<td>
					<input id="password" class="validate-password" type="password" size="25" value="" name="password">
				</td>
			</tr>
			<tr>
				<td colspan="2" align="center">
						<input id="button" class="button validate" type="button" onclick="return checkformlogin();" value="<?php echo JText::_('JS_LOGIN'); ?>"/>
					
						<!--<button  type="submit" class="button validate" onclick="return myValidate(this.loginform);"><?php echo JText::_('JLOGIN'); ?></button>-->
				</td>
			</tr>

		</table>
			<input type="hidden" name="return" value="<?php echo $this->loginreturn; ?>" />
			<?php echo JHtml::_('form.token'); ?>
		</div>	
	</form>
    </div>
<div>
	<ul>
		<li>
			<a href="<?php echo JRoute::_('index.php?option=com_users&view=reset'); ?>">
			<?php echo JText::_('JS_COM_USERS_LOGIN_RESET'); ?></a>
		</li>
		<li>
			<a href="<?php echo JRoute::_('index.php?option=com_users&view=remind'); ?>">
			<?php echo JText::_('JS_COM_USERS_LOGIN_REMIND'); ?></a>
		</li>
		<?php
		$usersConfig = JComponentHelper::getParams('com_users');
		if ($usersConfig->get('allowUserRegistration')) : ?>
		<li>
			<a href="<?php echo JRoute::_('index.php?option=com_jsjobs&view=common&layout=userregister&userrole='.$this->userrole.'&Itemid=0'); ?>">
				<?php echo JText::_('JS_COM_USERS_LOGIN_REGISTER'); ?></a>
		</li>
		<?php endif; ?>
	</ul>
</div>
<script type="text/javascript" language="javascript">
	function checkformlogin(){
		var username = document.getElementById('username').value;
		var password = document.getElementById('password').value;
		if(username!="" && password!=""){
				document.loginform.submit();
		}else{
                alert('<?php echo JText::_( 'JS_FILL_REQ_FIELDS');?>');
		}
	}
</script>	


<?php } //ol ?>
<!--<div id="jsjobs_footer">-->
    <?php // echo '<table width="100%" style="table-layout:fixed;"> <tr><td height="15"></td></tr> <tr><td style="vertical-align:top;" align="center"> <a class="img" target="_blank" href="http://www.joomsky.com"><img src="http://www.joomsky.com/logo/jsjobscrlogo.png"></a> <br> Copyright &copy; 2008 - '.date('Y').', <span id="themeanchor"> <a class="anchor"target="_blank" href="http://www.joomsky.com">Joom Sky</a></span></td></tr> </table></div>';?>
<!--</div>-->

