<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_helloworld
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
 
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
/**
 * HelloWorld Model
 *
 * @since  0.0.1
 */
class DangVietSonModelFeedback extends JModelItem
{
	/**
	 * @var string message
	 */
	protected $message;
 
	/**
	 * Get the message
         *
	 * @return  string  The message to be displayed to the user
	 */
	public function InsertData($data)
	{
		// Get a db connection.
                $db = JFactory::getDbo();

                // Create a new query object.
                $query = $db->getQuery(true);
                // Insert columns.
                $columns = array('name', 'email', 'type', 'subject', 'feedback');
                
                // Prepare the insert query.
                $query
                    ->insert($db->quoteName('#__feedbacks'))
                    ->columns($db->quoteName($columns))
                    ->values(implode(',', $data));

                // Set the query using our newly populated query object and execute it.
                $db->setQuery($query);
                $db->execute();
	}
}