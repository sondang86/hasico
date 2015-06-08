<?php
/**
 * @Copyright Copyright (C) 2012 ... Ahmad Bilal
 * @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * Company:		Buruj Solutions
  + Contact:		www.burujsolutions.com , ahmad@burujsolutions.com
 * Created on:	April 05, 2012
  ^
  + Project: 		JS Autoz
  ^
 */
defined('_JEXEC') or die('Restricted access');
$document = JFactory::getDocument();
if(JVERSION < 3){
    JHtml::_('behavior.mootools');
    $document->addScript('../components/com_jsjobs/js/jquery.js');
}else{
    JHtml::_('behavior.framework');
    JHtml::_('jquery.framework');
}
$document->addStyleSheet('components/com_jsjobs/include/installer.css');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
?>
<script type="text/javascript">
// for joomla 1.6
    Joomla.submitbutton = function(task) {
        if (task == '') {
            return false;
        } else {
            if (task == 'startinstallation') {
                returnvalue = validate_form(document.adminForm);
            } else
                returnvalue = true;
            if (returnvalue) {
                Joomla.submitform(task);
                return true;
            } else
                return false;
        }
    }

    function validate_form(f)
    {
        if (document.formvalidator.isValid(f)) {
            f.check.value = '<?php if (JVERSION < 3) echo JUtility::getToken();
else echo JSession::getFormToken(); ?>';//send token
        }
        else {
            alert('Some values are not acceptable.  Please retry.');
            return false;
        }
        opendiv();
        return true;
    }
    jQuery(document).ready( function(){
        jQuery(".cb-enable").click(function(){
            var parent = jQuery(this).parents('.switch');
            jQuery('.cb-disable',parent).removeClass('selected');
            jQuery(this).addClass('selected');
            jQuery('.checkbox',parent).attr('checked', true);            
        });
        jQuery(".cb-disable").click(function(){
            var parent = jQuery(this).parents('.switch');
            jQuery('.cb-enable',parent).removeClass('selected');
            jQuery(this).addClass('selected');
            jQuery('.checkbox',parent).attr('checked', false);
        });
        jQuery('label[data-id="sampledata"]').click(function(e){
                e.preventDefault();
                jQuery('div.ahmed_users').show();
        });
        jQuery('label[data-id="sampledata1"]').click(function(e){
                e.preventDefault();
                jQuery('div.ahmed_users').hide();
        });
    });    
</script>
<style>
p.field.switch{display: inline-block;float:right;margin:0px;margin-top:-6px;}
.cb-enable, .cb-disable, .cb-enable span, .cb-disable span { background: url(components/com_jsjobs/views/installer/tmpl/switch.gif) repeat-x; display: block; float: left; }
.cb-enable span, .cb-disable span { line-height: 30px; display: block; background-repeat: no-repeat; font-weight: bold; }
.cb-enable span { background-position: left -90px; padding: 0 10px; }
.cb-disable span { background-position: right -180px;padding: 0 10px; }
.cb-disable.selected { background-position: 0 -30px; }
.cb-disable.selected span { background-position: right -210px; color: #fff; }
.cb-enable.selected { background-position: 0 -60px; }
.cb-enable.selected span { background-position: left -150px; color: #fff; }
.switch label { cursor: pointer; }
.switch input { display: none; }    
</style>
<form action="index.php" method="POST" name="adminForm" id="adminForm" >
    <div class="js_installer_wrapper">
        <div class="js_header_bar"><?php echo JText::_('JS_JOBS_INSTALLATION');?></div>
        <img class="js_progress" src="components/com_jsjobs/include/images/p4.png" />
        <div class="js_message_wrapper">
            <h1><?php echo JText::_('JS_QUICK_CONFIGURATIONS'); ?></h1>
            <div class="js_final_step">
                <?php echo JText::_('JS_ENABLE_JS_JOBS'); ?>
                <p class="field switch">
                    <input type="radio" id="offline" name="offline" value="0" checked />
                    <input type="radio" id="offline" name="offline" value="1" />
                    <label for="radio1" class="cb-enable selected"><span><?php echo JText::_('JS_YES'); ?></span></label>
                    <label for="radio2" class="cb-disable"><span><?php echo JText::_('JS_NO'); ?></span></label>
                </p>
            </div>        
            <div class="js_final_step">
                <?php echo JText::_('JS_EMPLOYER_CAN_REGISTER'); ?>
                <p class="field switch">
                    <input type="radio" id="showemployerlink" name="showemployerlink" value="1" checked />
                    <input type="radio" id="showemployerlink" name="showemployerlink" value="0" />
                    <label for="radio1" class="cb-enable selected"><span><?php echo JText::_('JS_YES'); ?></span></label>
                    <label for="radio2" class="cb-disable"><span><?php echo JText::_('JS_NO'); ?></span></label>
                </p>
            </div>        
            <div class="js_final_step">
                <?php echo JText::_('JS_EMPLOYER_PACKAGE_REQUIRED'); ?>
                <p class="field switch">
                    <input type="radio" id="newlisting_requiredpackage" name="newlisting_requiredpackage" value="1" checked />
                    <input type="radio" id="newlisting_requiredpackage" name="newlisting_requiredpackage" value="0" />
                    <label for="radio1" class="cb-enable selected"><span><?php echo JText::_('JS_YES'); ?></span></label>
                    <label for="radio2" class="cb-disable"><span><?php echo JText::_('JS_NO'); ?></span></label>
                </p>
            </div>        
            <div class="js_final_step">
                <?php echo JText::_('JS_JOBSEEKER_PACKAGE_REQUIRED'); ?>
                <p class="field switch">
                    <input type="radio" id="js_newlisting_requiredpackage" name="js_newlisting_requiredpackage" value="1" checked />
                    <input type="radio" id="js_newlisting_requiredpackage" name="js_newlisting_requiredpackage" value="0" />
                    <label for="radio1" class="cb-enable selected"><span><?php echo JText::_('JS_YES'); ?></span></label>
                    <label for="radio2" class="cb-disable"><span><?php echo JText::_('JS_NO'); ?></span></label>
                </p>
            </div>        
            <h1><?php echo JText::_('JS_SAMPLE_DATA'); ?></h1>
            <div class="js_final_step">
                <?php echo JText::_('JS_INSTALL_SAMPLE_DATA'); ?>
                <p class="field switch">
                    <input type="radio" id="install_sample_data" name="install_sample_data" value="1" checked />
                    <input type="radio" id="install_sample_data" name="install_sample_data" value="0" />
                    <label for="radio1" class="cb-enable selected" data-id="sampledata"><span><?php echo JText::_('JS_YES'); ?></span></label>
                    <label for="radio2" class="cb-disable" data-id="sampledata1"><span><?php echo JText::_('JS_NO'); ?></span></label>
                </p>
                <div class="ahmed_users">
                    <span class="ahmed_users_title"><?php echo JText::_('Sample Data default user information'); ?></span>
                    <div class="ahmed_user_wrapper">
                        <div class="ahmed_user_title">
                            <span class="col1"><?php echo JText::_('Username'); ?></span>
                            <span class="col1"><?php echo JText::_('Password'); ?></span>
                        </div>
                        <div class="ahmed_user_data">
                            <span class="col1"><?php echo JText::_('jsjobs_jobseeker'); ?></span>
                            <span class="col1"><?php echo 'demo'; ?></span>
                        </div>
                        <div class="ahmed_user_data">
                            <span class="col1"><?php echo JText::_('jsjobs_employer'); ?></span>
                            <span class="col1"><?php echo 'demo'; ?></span>
                        </div>
                    </div>
                </div>
            </div>        
            <div class="js_final_step">
                <?php echo JText::_('JS_CREATE_MENU_FOR_JS_JOBS'); ?>
                <p class="field switch">
                    <input type="radio" id="create_menu_link" name="create_menu_link" value="1" checked />
                    <input type="radio" id="create_menu_link" name="create_menu_link" value="0" />
                    <label for="radio1" class="cb-enable selected"><span><?php echo JText::_('JS_YES'); ?></span></label>
                    <label for="radio2" class="cb-disable"><span><?php echo JText::_('JS_NO'); ?></span></label>
                </p>
            </div>        
        <div class="js_button_wrapper">
            <input class="js_next_button" type="submit" value="<?php echo JText::_('JS_FINISH'); ?>" onclick="return validate_form(document.adminForm);" />
        </div>
    </div>
    <input type="hidden" name="check" value="" />
    <input type="hidden" name="c" value="installer" />
    <input type="hidden" name="task" value="completeinstallation" />
    <input type="hidden" name="option" value="<?php echo $this->option; ?>" />
</form>
<table width="100%" style="table-layout:fixed;"><tr><td style="vertical-align:top;">			<?php echo '<table width="100%" style="table-layout:fixed;"> <tr><td height="15"></td></tr> <tr> <td style="vertical-align:middle;" align="center"> <a href="http://www.joomsky.com" target="_blank"><img src="http://www.joomsky.com/logo/jsjobscrlogo.png" ></a> <br> Copyright &copy; 2008 - '. date('Y') .', <a href="http://www.joomsky.com" target="_blank">Joom Sky</a>  </td> </tr> </table>';  ?>	</td></tr></table>
