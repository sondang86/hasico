<?php
/**
 * @Copyright Copyright (C) 2009-2011
 * @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
 + Created by:          Ahmad Bilal
 * Company:		Buruj Solutions
 + Contact:		www.burujsolutions.com , ahmad@burujsolutions.com
 * Created on:	Jan 11, 2009
 ^
 + Project: 		JS Jobs
 * File Name:	admin-----/tables/salaryrange.php
 ^ 
 * Description: Table for salary range
 ^ 
 * History:		NONE
 ^ 
 */
 
defined('_JEXEC') or die('Restricted access');

// our table class for the application data
class TableSalaryRange extends JTable
{
/** @var int Primary key */
	var $id=null;
/** @var string */
	var $rangevalue=null;
/** @var string */
	var $rangestart=null;
/** @var string */
	var $rangeend=null;
	var $status=0;
	var $ordering=null;
	var $isdefault=null;
	
	
	function __construct(&$db)
	{
		parent::__construct( '#__js_job_salaryrange', 'id' , $db );
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
