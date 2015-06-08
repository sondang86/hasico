<?php
/**
 * @Copyright Copyright (C) 2009-2011
 * @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
 + Created by:          Ahmad Bilal
 * Company:		Buruj Solutions
 + Contact:		www.burujsolutions.com , ahmad@burujsolutions.com
 * Created on:	Jun 06, 2010
 ^
 + Project: 		JS Jobs
 * File Name:	admin-----/tables/employerpackage.php
 ^ 
 * Description: Table for a employer package
 ^ 
 * History:		NONE
 ^ 
 */
 
defined('_JEXEC') or die('Restricted access');

// our table class for the application data
class TableEmployerPackage extends JTable
{
	var $id=null;
	var $title=null;
	var $currencyid=null;
	var $price=null;
	//var $discount` INT NULL ,
	var $discount=null;
	var $discounttype=null;
	var $discountmessage=null;
	var $discountstartdate=null;
	var $discountenddate=null;
	var $companiesallow=null;
	var $jobsallow=null;
	var $viewresumeindetails=null;
	var $resumesearch=null;
	var $saveresumesearch=null;
	var $featuredcompaines=null;
	var $goldcompanies=null;
	var $featuredjobs=null;
	var $goldjobs=null;
	var $jobseekershortlist=null;
	var $shortdetails=null;
	var $packageexpireindays=null;
	var $description=null;
	var $status=null;
	var $video=null;
	var $map=null;
	var $created=null;
	var $featuredcompaniesexpireindays=null;
	var $goldcompaniesexpireindays=null;
	var $featuredjobsexpireindays=null;
	var $goldjobsexpireindays=null;
	var $enforcestoppublishjob=0;
	var $enforcestoppublishjobvalue=null;
	var $enforcestoppublishjobtype=null;
	var $fastspringlink=null;
	var $otherpaymentlink=null;
	var $folders=null;
	var $messageallow=null;

	function __construct(&$db)
	{
		parent::__construct( '#__js_job_employerpackages', 'id' , $db );
	}
	
	/** 
	 * Validation
	 * 
	 * @return boolean True if buffer is valid
	 * 
	 */
	 function check()
	 {
	 	return true;
	 }
	 	 
}

?>
