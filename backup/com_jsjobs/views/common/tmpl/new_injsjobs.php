<?php
/**
 * @Copyright Copyright (C) 2009-2011
 * @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
  + Created by:          Ahmad Bilal
 * Company:		Buruj Solutions
  + Contact:		www.burujsolutions.com , ahmad@burujsolutions.com
 * Created on:	Jal 08, 2009
  ^
  + Project: 		JS Jobs
 * File Name:	views/jobseeker/tmpl/new_injsjobs.php
  ^
 * Description: template view for new in JS Jobs
  ^
 * History:		NONE
  ^
 */
defined('_JEXEC') or die('Restricted access');
if ($this->config['showemployerlink'] == 0) { // user can not register as a employer
    $usertypeid = '';
    if ($this->usertype)
        $usertypeid = $this->usertype->id;
    echo '<form action="index.php" method="POST" name="adminForm">';

    echo '<input type="hidden" name="usertype" value="2" />'; //2 for job seeker
    echo '<input type="hidden" name="dated" value="' . date('Y-m-d H:i:s') . '" />';
    echo '<input type="hidden" name="uid" value="' . $this->uid . '" />';
    echo '<input type="hidden" name="id" value="' . $usertypeid . '" />';
    echo '<input type="hidden" name="option" value="' . $this->option . '" />';
    echo '<input type="hidden" name="task" value="savenewinjsjobs" />';
    echo '<input type="hidden" name="c" value="userrole" />';
    echo '<script language=Javascript>';
    echo 'document.adminForm.submit();';
    echo '</script>';

    echo '</form>';
}
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
<?php }else { ?>
    <div id="js_main_wrapper">
        <span class="js_controlpanel_section_title"><?php echo JText::_('JS_WELCOME_JSJOBS');?></span>
    <?php
    if ($this->config['showemployerlink'] == 1) { // ask user role
        ?>
        <form action="index.php" method="POST" name="adminForm">

            <table cellpadding="0" cellspacing="0" border="0" width="100%" >
                <tr>
                    <td align="center" colspan="2">
                        <strong><?php echo JText::_('JS_WELCOME_JSJOBS_TEXT'); ?>  </strong>
                    </td>
                </tr>	
                <tr><td height="15" colspan="2"></td></tr>	
                <tr>
                    <td width="50%" align="right">
        <?php echo JText::_('JS_SELECT_ROLE'); ?> :&nbsp;
                    </td>
                    <td width="50%"> <?php echo $this->lists['usertype']; ?>
                    </td>
                </tr>		
                <tr><td height="15" colspan="2"></td></tr>	
                <tr>
                    <td align="center" colspan="2">
                        <input id="button" type="submit" class="button" name="submit_app" onclick="document.adminForm.submit();" value="<?php echo JText::_('JS_SUBMIT'); ?>" />
                    </td>
                </tr>	
            </table>
            <input type="hidden" name="date" value="<?php echo date('Y-m-d H:i:s'); ?>" />
            <input type="hidden" name="uid" value="<?php echo $this->uid; ?>" />
            <input type="hidden" name="id" value="<?php if ($this->usertype) echo $this->usertype->id; ?>" />
            <input type="hidden" name="option" value="<?php echo $this->option; ?>" />
            <input type="hidden" name="task" value="savenewinjsjobs" />
            <input type="hidden" name="c" value="userrole" />
            <input type="hidden" name="Itemid" value="<?php $this->Itemid ?>" />
        </form>	
    </div>
    <?php }else { // user can not register as a employer  ?>
        <div width="100%" align="center">
            <br><br><h1>Please wait ...</h1>
        </div>

    <?php
    }
}//ol
?>		
<!--<div id="jsjobs_footer">-->
    <?php // echo '<table width="100%" style="table-layout:fixed;"> <tr><td height="15"></td></tr> <tr><td style="vertical-align:top;" align="center"> <a class="img" target="_blank" href="http://www.joomsky.com"><img src="http://www.joomsky.com/logo/jsjobscrlogo.png"></a> <br> Copyright &copy; 2008 - '.date('Y').', <span id="themeanchor"> <a class="anchor"target="_blank" href="http://www.joomsky.com">Joom Sky</a></span></td></tr> </table></div>';?>
<!--</div>-->
