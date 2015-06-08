<?php
/**
 * @Copyright Copyright (C) 2009-2011
 * @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * Created by:	Ahmad Bilal
 * Company:		Buruj Solutions
 * Contact:		www.burujsolutions.com , ahmad@burujsolutions.com
 * Created on:	Mar 25, 2009
 *
 * Project: 		JS Jobs
 * File Name:	views/applications/view.html.php
 * 
 * Description: HTML view of all applications 
 * 
 * History:		NONE
 * 
 */
defined('_JEXEC') or die('Restricted access');
$document = JFactory::getDocument();
$document->addStyleSheet(JURI::root() . 'administrator/components/com_jsjobs/include/css/jsjobsadmin.css');
?>

<table width="100%">
    <tr>
        <td align="left" width="150" valign="top">
            <table width="100%"><tr><td style="vertical-align:top;">
                        <?php
                        include_once('components/com_jsjobs/views/menu.php');
                        ?>
                    </td>
                </tr></table>
        </td>
        <td width="100%" valign="top">
            <div id="jsjobs_info_heading"><?php echo JText::_('JS_JOB_SHARE'); ?></div>
            <form action="index.php" method="post" name="jobserverserialnumber" id="jobserverserialnumber" method="post" style="margin: 0px;">
                <div id="jsjobs_jobsharing_graybar"><?php echo JText::_('SERVER_SERIAL_NUMBER'); ?></div>
                <div id="jsjobs_jobsharing_wrapper">
                    <?php echo JText::_('PLEASE_TYPE_YOUR_SERVER_SERIAL_NUMBER_AND');?><span id="jsjobs_jobsharing_redinfo"><?php echo JText::_('SUBMIT');?></span>
                    <input type="text" name="server_serialnumber" id="server_serialnumber" />
                    <input type="submit" value="<?php echo JText::_('SUBMIT');?>" id="jsjobs_sharing_serverkeybutton" />
                    <div id="jsjobs_messagebox"><span id="jsjobs_messageboxtopcorner"></span>
                        <?php echo JText::_('PLEASE_ENTER_YOUR_JS_JOBS_SERVER_SERIAL_NUMBER'); ?><br/>
                        <?php echo JText::_('SERIAL_NUMBER_IS_PROVIDED_TO_YOU_IN_JOOMSKY_WEBSITE_LINK'); ?>&nbsp;<a href="">http://www.joomsky.com</a><br/>
                        <?php echo JText::_('INSERT_SERIAL_NUMBER_HERE_AND_SUBMIT_THEN_GOTO_JOOMSKY_AGAIN_AND_VERFIY_YOUR_SITE'); ?><br/>
                    </div>
                </div>
                <input type="hidden" name="c" value="jsjobs" />
                <input type="hidden" name="option" value="com_jsjobs" />
                <input type="hidden" name="task" value="saveserverserailnumber" />
            </form>
            <form action="index.php" method="post" name="jobShare" id="jobShare" method="post">
                <div id="jsjobs_jobsharing_subscribe_wrapper">
                    <div id="jsjobs_jobsharing_graybar"><?php echo JText::_('SHARING_SUBSCRIBE'); ?></div>
                    <div id="jsjobs_jobsharing_subscribe_righttext">
                        <span id="jsjobs_jobsharing_subscribe_righttext_heading"><?php echo JText::_('SHARING_SERVICES'); ?></span>
                        <span id="jsjobs_jobsharing_subscribe_righttext_heading_bottom"><?php echo JText::_('SUBSCRIBE_AND_UNSUBSCRIBE_SHARING_SERVICES'); ?></span>
                    </div>
                </div>
                <div id="jsjobs_jobsharing_subscribe_button_wrapper">
                    <span id="jsjobs_jobsharing_subscribetitle">
                        <?php 
                            echo JText::_('YOUR_SHARING_SERVICE');
                            if ($this->isjobsharing) {
                                echo '<span id="jsjobs_jobsharing_subscribe_text" class="subscribe">'.JText::_('SUBSCIRBED').'</span>';
                            }else{
                                echo '<span id="jsjobs_jobsharing_subscribe_text" class="unsubscribe">'.JText::_('UNSUBSCIRBED').'</span>';
                            }
                        ?>
                    </span>
                    <div id="jsjobs_jobsharing_wrapper">
                        <span id="jsjobs_jobsharing_subscribeone"><?php echo JText::_('AUTHENTICATION_KEY');?>&nbsp;:&nbsp;</span>
                        <?php
                            if ($this->isjobsharing) {
                                echo '<input style="float:left;" type="button" onclick="unsubscribejobsharing();" value="'.JText::_('UNSUBSCIRBED').'" id="jsjobs_sharing_serverkeybutton"  />';
                            }else{
                                echo '<input style="float:left;"type="text" id="server_serialnumber" name="authenticationkey" placeholder="'.JText::_('ENTER_THE_KEY').'" id="jsjobs_sharing_subcribe_authkey" />';
                                echo '<input style="float:left;margin-top:3px;"type="button" id="jsjobs_sharing_serverkeybutton" onclick="submitjobform();" value="'.JText::_('SUBSCIRBED').'" />';
                            }
                        ?>
                        <div id="jsjobs_messagebox"><span id="jsjobs_messageboxtopcorner"></span>
                            <?php echo JText::_('GET_AUTHENTICATION_KEY_FROM_JOOMSKY_MY_PRODUCT_AREA_HERE_LINK'); ?><br/>&nbsp;<a href="">http://www.joomsky.com</a><br/>
                            <?php echo JText::_('INSERT_YOUR_AUTHENTICATION_KEY_HERE_AND_PRESS_SUBSCRIBE_TO_JOB_SHARING_SERVICES'); ?>
                            <?php echo JText::_('IF_YOU_WANT_TO_UNSUBSCRIBE_THEN_AFTER_SUBSCRIBE_YOU_ARE_ABLE_TO_UNSUBSCRIBE'); ?><br/>
                        </div>
                    </div>
                </div>
                <div id="jobsharingwait" style="display:none"> 
                    <img src="components/com_jsjobs/include/images/loading.gif" height="32" width="32"></img>
                </div>
                <p id="jobsharingmessage" style="display:none"> <?php echo JText::_("PLEASE_WAIT_YOUR_SYSTEM_SYNCHRONIZE_WITH_SERVER"); ?></p>
                <?php if($this->result!='empty') ?><p id="jobsharingmessageresult" style="display:block"> <?php if($this->result!='empty') echo $this->result;?></p>
                
                
                <input type="hidden" id="task" name="task" value="jobsharing.requestjobsharing">
                <input type="hidden" name="ip" id="ip" value="<?php echo $_SERVER["REMOTE_ADDR"]; ?>">
                <input type="hidden" name="domain" id="domain" value="<?php echo $_SERVER["HTTP_HOST"]; ?>">
                <input type="hidden" name="siteurl" id="siteurl" value="<?php echo JURI::	root(); ?>">
                <?php if(isset($this->isjobsharing) AND ($this->isjobsharing!='')) ?> <input type="hidden" name="authkey" id="authkey" value="<?php echo $this->isjobsharing; ?>">
                <input type="hidden" name="option" value="com_jsjobs">

            </form>	
        </td>
    </tr>
    <tr>
        <td colspan="2" align="left" width="100%"  valign="top">
            <table width="100%" style="table-layout:fixed;"><tr><td style="vertical-align:top;">			<?php echo '<table width="100%" style="table-layout:fixed;"> <tr><td height="15"></td></tr> <tr> <td style="vertical-align:middle;" align="center"> <a href="http://www.joomsky.com" target="_blank"><img src="http://www.joomsky.com/logo/jsjobscrlogo.png" ></a> <br> Copyright &copy; 2008 - '. date('Y') .', <a href="http://www.joomsky.com" target="_blank">Joom Sky</a>  </td> </tr> </table>';  ?>	</td></tr></table>
        </td>
    </tr>

</table>	
<script type="text/javascript">
    function submitjobform() {
        document.getElementById('task').value = "jobsharing.requestjobsharing"; //retuen value
        document.getElementById('jobsharingwait').style.display = "block"; //retuen value
        document.getElementById('jobsharingmessage').style.display = "block"; //retuen value
        document.jobShare.submit();
    }
    function unsubscribejobsharing() {
        document.getElementById('task').value = "jobsharing.unsubscribejobsharing"; //retuen value
        document.jobShare.submit();
    }
</script>








