<?php
/**
 * @Copyright Copyright (C) 2009-2011
 * @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
  + Created by:	Ahmad Bilal
 * Company:		Buruj Solutions
  + Contact:		www.burujsolutions.com , ahmad@burujsolutions.com
 * Created on:	Jan 11, 2009
  ^
  + Project: 		JS Jobs
 * File Name:	admin-----/views/application/tmpl/info.php
  ^
 * Description: JS Jobs Information
  ^
 * History:		NONE
  ^
 */
defined('_JEXEC') or die('Restricted access');
JRequest :: setVar('layout', 'info');
$_SESSION['cur_layout'] = 'info';
$document = JFactory::getDocument();
$document->addStyleSheet(JURI::root() . 'administrator/components/com_jsjobs/include/css/jsjobsadmin.css');

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
        <td width="100%" valign="top">
            <form action="index.php" method="POST" name="adminForm">

                <table cellpadding="2" cellspacing="4" border="1" width="100%" class="adminform">
                    <tr align="left" height="250" valign="middle" align="center" class="adminform">
                        <td align="left" valign="middle" style="text-align:center">
                            <div id="pro_wrap">
                                <div id="pro_text">
                                    <?php echo JText::_('Feature available in JS Jobs Pro version'); ?><span id="img"></span>
                                </div>
                                <div id="pro_feature_wrap">
                                    <div id="pro_feature_text">
                                        <a href="" ><?php echo JText::_('JS Jobs Pro Features'); ?></a>
                                    </div>
                                    <div id="pro_featureWrap">
                                        <div id="pro_feature_1" class="leftalign">
                                            <img src="components/com_jsjobs/include/images/pro_gold.png" alt=""/>
                                            <span class="title"><?php echo JText::_('Gold Jobs'); ?></span>
                                            <span class="text"><?php echo JText::_('Employer can add their jobs to Gold according to their package, and Administrator can show the Gold jobs to top of jobs listing.'); ?></span>
                                        </div>
                                        <div id="pro_feature_2" class="rightalign">
                                            <img src="components/com_jsjobs/include/images/pro_featured.png" alt=""/>
                                            <span class="title"><?php echo JText::_('Featured Jobs'); ?></span>
                                            <span class="text"><?php echo JText::_('Employer can also add their job to Featured according to their package, and also a jobs can be Gold as well as Featured also, Administrator can also show the Featured jobs to top of jobs listing.'); ?></span>
                                        </div>
                                    </div>
                                    <div id="pro_featureWrap">
                                        <div id="pro_feature_3" class="leftalign">
                                            <img src="components/com_jsjobs/include/images/pro_edit.png" alt=""/>
                                            <span class="title"><?php echo JText::_('Visitor can edit Job'); ?></span>
                                            <span class="text"><?php echo JText::_('Not only the Visitor just can add job, edit their job also.'); ?></span>
                                        </div>
                                        <div id="pro_feature_4" class="rightalign">
                                            <img src="components/com_jsjobs/include/images/pro_shortlist.png" alt=""/>
                                            <span class="title"><?php echo JText::_('Shortlist Applid Resume'); ?></span>
                                            <span class="text"><?php echo JText::_('Employer can shortlist applied resume. He can review and rate also. (Registerd User)'); ?></span>
                                        </div>
                                    </div>
                                    <div id="pro_featureWrap">
                                        <div id="pro_feature_5" class="leftalign">
                                            <img src="components/com_jsjobs/include/images/pro_visitor_can_apply job.png" alt=""/>
                                            <span class="title"><?php echo JText::_('Visitor can Apply to Job'); ?></span>
                                            <span class="text"><?php echo JText::_('Visitor can apply to any job.'); ?></span>
                                        </div>
                                        <div id="pro_feature_6" class="rightalign">
                                            <img src="components/com_jsjobs/include/images/pro_reviewrat.png" alt=""/>
                                            <span class="title"><?php echo JText::_('Review and Rating'); ?></span>
                                            <span class="text"><?php echo JText::_('Employer can comments on applied resume. It will help employer to shortlist candidates'); ?></span>
                                        </div>
                                    </div>
                                    <div id="pro_featureWrap">
                                        <div id="pro_feature_7" class="leftalign">
                                            <img src="components/com_jsjobs/include/images/pro_dealer.png" alt=""/>
                                            <span class="title"><?php echo JText::_('Tell a Friend'); ?></span>
                                            <span class="text"><?php echo JText::_('Job seeker can tell a friend about job. JS Jobs send email to friend.'); ?></span>
                                        </div>
                                        <div id="pro_feature_8" class="rightalign">
                                            <img src="components/com_jsjobs/include/images/pro_message.png" alt=""/>
                                            <span class="title"><?php echo JText::_('Messages'); ?></span>
                                            <span class="text"><?php echo JText::_('Employer and Job Seeker can also communicate to each other with the messages, If employer is interested in vehicle he can message the Seller for further information or deal.'); ?></span>
                                        </div>
                                    </div>
                                    <div id="pro_featureWrap">
                                        <div id="pro_feature_9" class="leftalign">
                                            <img src="components/com_jsjobs/include/images/pro_google_adsense.png" alt=""/>
                                            <span class="title"><?php echo JText::_('Google Adsense'); ?></span>
                                            <span class="text"><?php echo JText::_('Administrator can publish the google adsense in jobs listing, that after how many jobs that ads will show.'); ?></span>
                                        </div>
                                        <div id="pro_feature_10" class="rightalign">
                                            <img src="components/com_jsjobs/include/images/pro_package.png" alt=""/>
                                            <span class="title"><?php echo JText::_('Packages'); ?></span>
                                            <span class="text"><?php echo JText::_('Administrator can create package that how much jobs can added by a Employer when they were expired, also the package expiration date and many other feature relate to packages.'); ?></span>
                                        </div>
                                    </div>
                                    <div id="pro_featureWrap">
                                        <div id="pro_feature_11" class="leftalign">
                                            <img src="components/com_jsjobs/include/images/pro_payment.png" alt=""/>
                                            <span class="title"><?php echo JText::_('Payment Gateways'); ?></span>
                                            <span class="text"><?php echo JText::_('Administrator set payment gateways for selling their packages to the Employer and Job Seeker, JS Jobs Pro support over 18 payment methods.'); ?></span>
                                        </div>
                                        <div id="pro_feature_12" class="rightalign">
                                            <img src="components/com_jsjobs/include/images/pro_stats.png" alt=""/>
                                            <span class="title"><?php echo JText::_('Stats'); ?></span>
                                            <span class="text"><?php echo JText::_('Employer and job seeker have statistics relate to their jobs or resume, how many jobs or resume it have how many are GOLD and Featured, and how much jobs or resume he/she can add.'); ?></span>
                                        </div>
                                    </div>
                                    <div id="pro_featureWrap">
                                        <div id="pro_feature_13" class="leftalign">
                                            <img src="components/com_jsjobs/include/images/pro_cronjob.png" alt=""/>
                                            <span class="title"><?php echo JText::_('New listing Cron Job'); ?></span>
                                            <span class="text"><?php echo JText::_('New listing alert will send to subscriber by Cron Job.'); ?></span>
                                        </div>
                                        <div id="pro_feature_14" class="rightalign">
                                            <img src="components/com_jsjobs/include/images/pro_rss.png" alt=""/>
                                            <span class="title"><?php echo JText::_('RSS Feed'); ?></span>
                                            <span class="text"><?php echo JText::_('RSS feed can also be given for vehicles'); ?></span>
                                        </div>
                                    </div>
                                    <div id="pro_featureWrap">
                                        <div id="pro_feature_15" class="leftalign">
                                            <img src="components/com_jsjobs/include/images/pro_modules.png" alt=""/>
                                            <span class="title"><?php echo JText::_('Free Modules'); ?></span>
                                            <span class="text"><?php echo JText::_('We will give 14 modules with our Pro Version and 1 module with our Free Version.'); ?></span>
                                        </div>
                                        <div id="pro_feature_16" class="rightalign">
                                            <img src="components/com_jsjobs/include/images/pro_plugins.png" alt=""/>
                                            <span class="title"><?php echo JText::_('Free Plugins'); ?></span>
                                            <span class="text"><?php echo JText::_('Same as module we will give 14 plugins with our Pro Version and 1 plugins with our Free Version.'); ?></span>
                                        </div>
                                    </div>
                                    <div id="pro_featureWrap">
                                        <div id="pro_feature_17" class="leftalign">
                                            <img src="components/com_jsjobs/include/images/pro_copyright.png" alt=""/>
                                            <span class="title"><?php echo JText::_('Copyright Removed'); ?></span>
                                            <span class="text"><?php echo JText::_('You can remove our copyright tag to the site in Pro Version only.'); ?></span>
                                        </div>
                                        <div id="pro_feature_18" class="rightalign">
                                            <img src="components/com_jsjobs/include/images/pro_upgrade.png" alt=""/>
                                            <span class="title"><?php echo JText::_('Free Upgradation'); ?></span>
                                            <span class="text"><?php echo JText::_('No free up-gradation will be offer to free version only for Pro Version only.'); ?></span>
                                        </div>
                                    </div>
                                    <div id="pro_featureWrap">
                                        <div id="pro_feature_19" class="leftalign">
                                            <img src="components/com_jsjobs/include/images/pro_support.png" alt=""/>
                                            <span class="title"><?php echo JText::_('Support'); ?></span>
                                            <span class="text"><?php echo JText::_('No support will give to free version only for Pro Version only.'); ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                </table>




            </form>
        </td>
    </tr>
</table>							
<script language="javascript" type="text/javascript">
    dhtml.cycleTab('tab1');
</script>
