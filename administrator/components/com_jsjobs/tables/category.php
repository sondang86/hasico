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
 * File Name:	admin-----/tables/category.php
 ^ 
 * Description: Table for a category
 ^ 
 * History:		NONE
 ^ 
 */
 
defined('_JEXEC') or die('Restricted access');

// our table class for the application data
class TableCategory extends JTable
{
/** @var int Primary key */
	var $id=null;
	var $cat_value=null;
	var $cat_title=null;
	var $isactive=0;
	var $ordering=null;
	var $isdefault=null;
	
	function __construct(&$db)
	{
		parent::__construct( '#__js_job_categories', 'id' , $db );
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
