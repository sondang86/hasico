<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_articles_latest
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
 
function limit_length($input){
    //check the text's length if larger than 20 chars, limit it to 20
    $string = strlen($input);
    if($string > 40){
        $string = substr($input, 0, 40) . '...';
        return $string;
    } else {
        return $input;
    }
}

?>

<script type="text/javascript">
  $(window).load(function() {           
  var img =0; 
  var images = ['http://www.camparigroup.com/sites/all/themes/camparicorp/images/fpcareers/bck-careers-row2-1200.jpg','http://www.arabianbusiness.com/incoming/article562437.ece/BINARY/14-WAITING-FOR-JOB-INTERVIE.jpg', 'http://www.arabianbusiness.com/incoming/article562431.ece/BINARY/1_JOB-INTERVIEW-facebook.jpg', 'http://globalcareerscompany.net/wp-content/uploads/2013/07/photodune-2360842-job-search-m1-1200x600_c.jpg'];
  var image = $('#slideshow');
                //Initial Background image setup
  image.css('background-image', 'url(http://globalcareerscompany.net/wp-content/uploads/2013/07/photodune-2360842-job-search-m1-1200x600_c.jpg)');
                //Change image at regular intervals
  setInterval(function(){   
     image.css('background-image', 'url(' + images [img++] +')');
//   image.fadeOut(1000, function () {
//   image.css('background-image', 'url(' + images [img++] +')');
//   image.fadeIn(1000);
//   });
   if(img == images.length){
    img = 0;
   }
   }, 15000);            
 });
</script>

<form action="index.php?option=com_jsjobs&amp;c=job&amp;view=job&amp;layout=job_searchresults&amp;Itemid=101" method="post" name="adminForm">
<div class="wallpaper1" id="slideshow">
    <div class="row">
        <!--Search box-->
        <div class="col-md-4 mx_block">
        <section class="search">
        <div id="ctl00_pl1_ucJobSearchControl" class="form job-search ">
            <h2 class="job-search__title">Find Jobs</h2>
        <fieldset class="job-search__fieldset">
        <div class="">
            <div class="form__input--is-search"><input class="form__input form__keywords full-width ui-autocomplete-input placeholder" autocomplete="off" maxlength="50" name="title" type="text" placeholder="Job title" /></div>
        </div>
        <div class="">
        <div class="select-wrapper"><label class="readers" for="ddllcctl00_pl1_ucJobSearchControl">Location</label><select id="jobcategory" class="form__select full-width" name="jobcategory">
            <option selected="selected" value="">Select Category</option>
            <option value="1">Accounting/Finance</option>
            <option value="2">Administrative</option>
            <option value="3">Advertising</option>
            <option value="4">Airlines/Avionics/Aerospace</option>
            <option value="5">Architectural</option>
            <option value="6">Automotive</option>
            <option value="7">Banking/Finance</option>
            <option value="8">Biotechnology</option>
            <option value="9">Civil/Construction</option>
            <option value="10">Engineering</option>
            <option value="11">Cleared Jobs</option>
            <option value="12">Communications</option>
            <option value="13">Computer/IT</option>
            <option value="14">Construction</option>
            <option value="15">Consultant/Contractual</option>
            <option value="16">Customer Service</option>
            <option value="17">Defense</option>
            <option value="18">Design</option>
            <option value="19">Education</option>
            <option value="20">Electrical Engineering</option>
            <option value="21">Electronics Engineering</option>
            <option value="22">Energy</option>
            <option value="24">Environmental/Safety</option>
            <option value="25">Fundraising</option>
            <option value="26">Health/Medicine</option>
            <option value="27">Homeland Security</option>
            <option value="28">Human Resources</option>
            <option value="29">Insurance</option>
            <option value="30">Intelligence Jobs</option>
            <option value="31">Internships/Trainees</option>
            <option value="32">Legal</option>
            <option value="33">Logistics/Transportation</option>
            <option value="34">Maintenance</option>
            <option value="35">Management</option>
            <option value="36">Manufacturing/Warehouse</option>
            <option value="37">Marketing</option>
            <option value="38">Materials Management</option>
            <option value="39">Mechanical Engineering</option>
            <option value="40">Mortgage/Real Estate</option>
            <option value="41">National Security</option>
            <option value="42">Part-time/Freelance</option>
            <option value="43">Printing</option>
            <option value="44">Product Design</option>
            <option value="45">Public Relations</option>
            <option value="46">Public Safety</option>
            <option value="47">Research</option>
            <option value="48">Retail</option>
            <option value="49">Sales</option>
            <option value="50">Scientific</option>
            <option value="51">Shipping/Distribution</option>
            <option value="52">Technicians</option>
            <option value="53">Trades</option>
            <option value="54">Transportation</option>
            <option value="55">Transportation Engineering</option>
            <option value="56">Web Site Development</option>
        </select></div>
        </div>
        <div class="">
        <div class="select-wrapper"><label class="readers" for="ddllcctl00_pl1_ucJobSearchControl">Location</label><select id="jobtype" class="form__select full-width" name="jobtype">
            <option selected="selected" value="">Select Job Type</option>
            <option value="1">Full-Time</option>
            <option value="2">Part-Time</option>
            <option value="3">Internship</option>
            </select></div>
        </div>
            <input id="txtcictl00_pl1_ucJobSearchControl" type="hidden" value="1" /> <input id="txtndctl00_pl1_ucJobSearchControl" type="hidden" /> <a class="job-search__link" title="Advanced search" href="index.php?option=com_jsjobs&amp;view=job&amp;layout=jobsearch&amp;c=job&amp;Itemid=101">Advanced search</a> <input id="txtexctl00_pl1_ucJobSearchControl" type="hidden" /> <input id="txtfzctl00_pl1_ucJobSearchControl" type="hidden" /> <input id="btnSearchctl00_pl1_ucJobSearchControl" class="job-search__button" name="submit" type="submit" value="JobSearch" /></fieldset></div>
        <!-- NON-EXPANDABLE TILE -->
            <div class="tiles"> </div>
        <!-- end of NON-EXPANDABLE TILE --></section>
        </div>
        <div class="col-md-8 mx_block">
            <div class="top-job">
                    <div class="panel">
                        <div class="panel-header">
                            <h2>Top Jobs</h2>
                        </div>
                        <div class="panel-content">
                            <div class="job-list scrollbar mCustomScrollbar _mCS_1"><div class="mCustomScrollBox mCS-home-vnw" id="mCSB_1" style="position:relative; height:100%; overflow:hidden; max-width:100%;"><div class="mCSB_container" style="position: relative; top: 0px;">
                                <ul>
                                
                                    <?php foreach ($latest_jobs as $key => $latest_job):?>
                                        <li>
                                            <?php $joblink = 'index.php?option=com_jsjobs&c=job&view=job&layout=view_job&nav=15&bd='.$latest_job->alias. '-' . $latest_job->id; ?>
                                            <a target="_blank" href="<?php echo $joblink?>" title="<?php echo $latest_job->title?>">
                                                <strong id="text_limit"><?php echo limit_length($latest_job->title)?></strong>
                                                <em><?php echo $latest_job->name?></em>
                                            </a>
                                        </li>
                                    <?php endforeach;?>
                                    
                                    
                                </ul>
                            </div><div class="mCSB_scrollTools" style="position: absolute; display: block;"><a class="mCSB_buttonUp" oncontextmenu="return false;"></a><div class="mCSB_draggerContainer"><div class="mCSB_dragger" style="position: absolute; height: 31px; top: 0px;" oncontextmenu="return false;"><div class="mCSB_dragger_bar" style="position: relative; line-height: 27px;"></div></div><div class="mCSB_draggerRail"></div></div><a class="mCSB_buttonDown" oncontextmenu="return false;"></a></div></div></div>
                        </div>
                    </div>
            </div>
        </div>
     </div>

</form>
<div class="row">
    <!--Latest Articles-->
    <div class="col-md-3 col-xs-2">
        <article id="ctl00_pl1_ucRecentJobs" class="tile--non-expanding  recentJobs"><header>
        <h3 class="tile__section">Latest Articles</h3>
            <ul class="latestnews<?php echo $moduleclass_sfx; ?>" style="list-style-type: none">
            <?php foreach ($list as $key => $item) :?>
                    <li itemscope itemtype="http://schema.org/Article">
                            <a href="<?php echo $item->link; ?>" itemprop="url">
                                    <span itemprop="name">
                                            <?php echo $item->title; ?>
                                    </span>
                            </a>
                    </li>
            <?php endforeach; ?>
            </ul>
        </header></article>
    </div>
    
    
    <!--Latest jobs-->
    <div class="col-md-3 col-md-offset-1 col-xs-2">
        <article id="ctl00_pl1_ucRecentJobs" class="tile--non-expanding  recentJobs"><header>
            <h3 class="tile__section">Latest Jobs</h3>
                <ul class="latestnews<?php echo $moduleclass_sfx; ?>" style="list-style-type: none">
                <?php foreach ($latest_jobs as $key => $item) :?>
                        <li itemscope itemtype="http://schema.org/Article">
                                <?php $link = 'index.php?option=com_jsjobs&c=job&view=job&layout=view_job&nav=15&bd='.$item->alias. '-' . $item->id; ?>
                                <a href="<?php echo $link; ?>" itemprop="url">
                                        <span itemprop="name">
                                                <?php echo $item->title; ?>
                                        </span>
                                </a>
                        </li>
                <?php endforeach; ?>
                </ul>
        </header></article>
    </div>
    
    
    <!--Quick links-->
    <div class="col-md-3 col-md-offset-1 col-xs-2">
        <article id="ctl00_pl1_ucRecentJobs" class="tile--non-expanding  recentJobs"><header>
            <h3 class="tile__section">Quick Links</h3>
            <ul class="tile__headline list">
                <li class="list__item"><a href="../findajob/job.php">Links</a></li>
            </ul>
        </header></article>
    </div>
    
</div>
</div>