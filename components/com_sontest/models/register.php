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
jimport('joomla.user.helper');
/**
 * DangVietSon Model
 *
 * @since  0.0.1
 */
class DangVietSonModelRegister extends JModelItem
{
    
    public function InsertData($data)
	{
		// Get a db connection.
                $db = JFactory::getDbo();

                // Create a new query object.
                $query = $db->getQuery(true);
                
                // Insert columns.
                $columns = array('username', 'email', 'password', 'registerDate');
                                
                // Prepare the insert query.
                $query
                    ->insert($db->quoteName('#__users'))
                    ->columns($db->quoteName($columns))
                    ->values(implode(',', $data));
                
                // Set the query using our newly populated query object and execute it.
                $db->setQuery($query);
                $db->execute();
	}
        
        public function get_registered_userid($name) {
                // Get a db connection.
                $db = JFactory::getDbo();
                
                // Create a new query object.
                $query = $db->getQuery(true);
                
                //Select user based on user_id provided
                $query->select($db->quoteName(array('id', 'name', 'username', 'email')));
                $query->from($db->quoteName('#__users'));
                $query->where($db->quoteName('username') . ' = ' . $db->quote("$name"));
                $query->setLimit(1);
                
                // Reset the query using our newly populated query object.
                $db->setQuery($query);
                
                // Load the results as a list of stdClass objects (see later for more options on retrieving data).
                $results = $db->loadObject();
                
                return $results;
                
        }
        
        public function get_users($column, $input) {
                // Get a db connection.
                $db = JFactory::getDbo();
                
                // Create a new query object.
                $query = $db->getQuery(true);
                
                //Select user based on user_id provided
                $query->select($db->quoteName(array('username', 'email')));
                $query->from($db->quoteName('#__users'));
                $query->where($db->quoteName($column) . ' = ' . $db->quote("$input"));
                $query->setLimit(1);
                
                // Reset the query using our newly populated query object.
                $db->setQuery($query);
                
                // Load the results as a list of stdClass objects (see later for more options on retrieving data).
                $results = $db->loadObjectList();
                
                return $results;
                
        }
        
        
        public function InsertUserGroup($data) {
                // Get a db connection.
                $db = JFactory::getDbo();
                
                // Create a new query object.
                $query = $db->getQuery(true);
                
                // Insert columns.
                $columns = array('user_id','group_id');
                                
                // Prepare the insert query.
                $query
                    ->insert($db->quoteName('#__user_usergroup_map'))
                    ->columns($db->quoteName($columns))
                    ->values(implode(',', $data));
                
                // Set the query using our newly populated query object and execute it.
                $db->setQuery($query);
                $db->execute();
        }
}