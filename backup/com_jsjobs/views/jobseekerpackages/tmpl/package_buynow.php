<?php
/**
 * @Copyright Copyright (C) 2009-2011
 * @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
 + Created by:          Ahmad Bilal
 * Company:		Buruj Solutions
 + Contact:		www.burujsolutions.com , ahmad@burujsolutions.com
 * Created on:	May 17, 2010
 ^
 + Project: 		JS Jobs
 * File Name:	views/jobseeker/tmpl/package_buynow.php
 ^ 
 * Description: template view for package buy now
 ^ 
 * History:		NONE
 ^ 
 */
 
defined('_JEXEC') or die('Restricted access');
?>
<!--<div id="jsjobs_main">-->        
<!--<div id="js_menu_wrapper">-->
            <?php
//            if (sizeof($this->jobseekerlinks) != 0){
//                foreach($this->jobseekerlinks as $lnk){ ?>                     
                    <!--<a class="js_menu_link <?php // if($lnk[2] == 'job') echo 'selected'; ?>" href="<?php // echo $lnk[0]; ?>"><?php // echo $lnk[1]; ?></a>-->
                <?php // }
//            }
//            if (sizeof($this->employerlinks) != 0){
//                foreach($this->employerlinks as $lnk)	{ ?>
                    <!--<a class="js_menu_link <?php // if($lnk[2] == 'job') echo 'selected'; ?>" href="<?php // echo $lnk[0]; ?>"><?php // echo $lnk[1]; ?></a>-->
                <?php // }
//            }
            ?>
        <!--</div>-->
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
<?php
if (isset($this->userrole->rolefor) && $this->userrole->rolefor == 2) { // job seeker


?>
    <form action="index.php" method="post" name="adminForm" id="adminForm" >
    <?php 
    if ( isset($this->package) ){ ?>
        <div id="js_main_wrapper">
            <span class="js_controlpanel_section_title"><?php echo JText::_('JS_BUY_NOW');?></span>
            <span class="js_job_title">
                <?php 
                    echo $this->package->title;
                    $curdate = date('Y-m-d H:i:s');
                    if (($this->package->discountstartdate <= $curdate) && ($this->package->discountenddate >= $curdate)){
                        if($this->package->discountmessage) echo $this->package->discountmessage;
                    }
                ?>
            </span>
            <div class="js_listing_wrapper">
                <span class="stats_data_title"><?php echo JText::_('JS_RESUME_ALLOWED'); ?></span>
                <span class="stats_data_value"><?php if($this->package->resumeallow == -1) echo JText::_('JS_UNLIMITED'); else echo $this->package->resumeallow; ?></span>
                <span class="stats_data_title"><?php echo JText::_('JS_COVERLETTERS_ALLOWED'); ?></span>
                <span class="stats_data_value"><?php if($this->package->coverlettersallow == -1) echo JText::_('JS_UNLIMITED'); else echo $this->package->coverlettersallow; ?></span>
                <span class="stats_data_title"><?php echo JText::_('JS_JOB_SEARCH'); ?></span>
                <span class="stats_data_value"><?php if($this->package->jobsearch == 1) echo JText::_('JS_YES'); else echo JText::_('JS_NO'); ?></span>
                <span class="stats_data_title"><?php echo JText::_('JS_SAVE_JOB_SEARCH'); ?></span>
                <span class="stats_data_value"><?php if($this->package->savejobsearch == 1) echo JText::_('JS_YES'); else echo JText::_('JS_NO'); ?></span>
                <span class="stats_data_title"><?php echo JText::_('JS_APPLY_JOBS'); ?></span>
                <span class="stats_data_value"><?php if($this->package->applyjobs == -1) echo JText::_('JS_UNLIMITED'); else echo $this->package->applyjobs; ?></span>
                <span class="stats_data_title"><?php echo JText::_('JS_PACKAGE_EXPIRE_IN_DAYS'); ?></span>
                <span class="stats_data_value"><?php echo $this->package->packageexpireindays; ?></span>
                <span class="stats_data_title"><?php echo JText::_('JS_PRICE'); ?></span>
                <span class="stats_data_value">
                    <?php
                        if ($this->package->price != 0){
                           $curdate = date('Y-m-d H:i:s');
                            if (($this->package->discountstartdate <= $curdate) && ($this->package->discountenddate >= $curdate)){
                                 if($this->package->discounttype == 2){
                                     $discountamount = ($this->package->price * $this->package->discount)/100;
                                      $discountamount = $this->package->price - $discountamount;
                                     echo $this->package->symbol.$discountamount.' [ '. $this->package->discount .'% '.JText::_('JS_DISCOUNT').' ]';
                                 }else{
                                     $discountamount = $this->package->price - $this->package->discount;
                                     echo $this->package->symbol.$discountamount.' [ '. JText::_('JS_DISCOUNT').' : '.$this->package->symbol.$this->package->discount .' ]';
                                 }
                            }else { echo  $this->package->symbol.$this->package->price;$discountamount = 1;}
                        }else{ echo JText::_('JS_FREE'); } 
                    ?>
                </span>
                <span class="stats_data_title fullwidth"><?php echo JText::_('JS_DESCRIPTION'); ?></span>
                <span class="stats_data_value description"><?php echo $this->package->description; ?></span>
            </div>
        </div>
        
<?php if (($this->package->price == 0) || ($discountamount == 0) ){
$showpaymentmethod = false;
}else{
$showpaymentmethod = true;
    }
if($showpaymentmethod == true){ ?>
        <div id="js_main_wrapper">
            <span class="js_job_title"><?php echo JText::_('JS_PAYMENT_METHODS');?></span>
            <?php
            if(isset($this->paymentmethod)){
                    $n = 1; //for the first child padding;
                    foreach($this->paymentmethod AS $key=>$paymethod) {
                            $methodname = 'isenabled_'.$key;
                            if($key=='ideal'){
                                    $partner_id=$this->idealdata['ideal']['partnerid_ideal'];
                                    $ideal_testmode=$this->idealdata['ideal']['testmode_ideal'];
                                    $idealhelperclasspath = "components/com_jsjobs/classes/ideal/Payment.php";
                                    include_once($idealhelperclasspath);
                                    $idealhelperobject = new Mollie_iDEAL_Payment($partner_id);
                                    if($ideal_testmode==1) $bank_array = $idealhelperobject->getBanks();
                            }
                            if($paymethod[$methodname] == 1){ ?>
            <div class="js_listing_wrapper paymentmethod <?php if($n == 1) echo 'first-child';?>">
                <span class="payment_method_title">
                    <?php echo $paymethod['title_'.$key]; ?>
                    <?php if($key=='ideal') { ?>
                            <select name="bank_id">
                                    <option value=''><?php echo JText::_('JS_SELECT_BANK') ?></option>
                                    <?php if(isset($bank_array) AND (is_array($bank_array))){
                                                     foreach ($bank_array as $bank_id => $bank_name) { ?>
                                                    <option value="<?php echo htmlspecialchars($bank_id) ?>"><?php echo htmlspecialchars($bank_name) ?></option>
                                            <?php } 
                                     }else { ?>
                                                    <option value="0"><?php echo JText::_('JS_NO_BANK_FOUND') ?></option>
                                    <?php } ?>
                            </select>
                    <?php  } ?>
                </span>
                <span class="payment_method_button"><input class="js_job_button" rel="button" type="button" onclick="setpaymentmethods('<?php echo $key ; ?>')" name="submit_app" value="<?php echo JText::_('JS_BUY_NOW'); ?>" /></span>
            </div>
                    <?php 
                    $n = $n +1;
                            }
                    }
            }?>
        </div>			

<?php }elseif($showpaymentmethod == false){?>
        <div id="js_main_wrapper">
            <div class="js_listing_wrapper paymentmethod text-center">
                <input class="js_job_button" type="button" rel="button" onclick="setpaymentmethods('free')" name="submit_app" value="<?php echo JText::_('JS_BUY_NOW'); ?>" />
            </div>
        </div>
<?php } ?>

    <?php
    }
		 ?>	
			
			<input type="hidden" name="task" value="savejobseekerpayment" />
			<input type="hidden" name="c" value="purchasehistory" />
			<input type="hidden" name="Itemid" id="Itemid" value="<?php echo $this->Itemid; ?>" />
			<input type="hidden" name="packageid" value="<?php if(isset($this->package)) echo $this->package->id; ?>" />
			<input type="hidden" name="option" value="<?php echo $this->option; ?>" />
			<input type="hidden" name="uid" value="<?php echo $this->uid; ?>" />

			<input type="hidden" name="packagefor" id="packagefor" value="2"  />
			<input type="hidden" name="paymentmethod" id="paymentmethod"  />
			<input type="hidden" name="paymentmethodid" id="paymentmethodid"  />
			
	</form>
	<?php
} else{ // not allowed job posting ?>
        <div class="js_job_error_messages_wrapper">
            <div class="js_job_messages_image_wrapper">
                <img class="js_job_messages_image" src="components/com_jsjobs/images/2.png"/>
            </div>
            <div class="js_job_messages_data_wrapper">
                <span class="js_job_messages_main_text">
                    <?php echo JText::_('JS_YOU_ARE_NOT_ALLOWED_TO_VIEW'); ?>
                </span>
                <span class="js_job_messages_block_text">
                    <?php echo JText::_('JS_YOU_ARE_NOT_ALLOWED_TO_VIEW'); ?>
                </span>
            </div>
        </div>
<?php
}	
}//ol
?>	
<!--<div id="jsjobs_footer">-->
    <?php // echo '<table width="100%" style="table-layout:fixed;"> <tr><td height="15"></td></tr> <tr><td style="vertical-align:top;" align="center"> <a class="img" target="_blank" href="http://www.joomsky.com"><img src="http://www.joomsky.com/logo/jsjobscrlogo.png"></a> <br> Copyright &copy; 2008 - '.date('Y').', <span id="themeanchor"> <a class="anchor"target="_blank" href="http://www.joomsky.com">Joom Sky</a></span></td></tr> </table></div>';?>
<!--</div>-->
<script type="text/javascript">
function setpaymentmethods(paymethod){
var paymethodvalue = document.getElementById('paymentmethod').value=paymethod;
//alert(paymethodvalue);
document.adminForm.submit();
}
</script>
