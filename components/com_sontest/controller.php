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
 * Hello World Component Controller
 *
 * @since  0.0.1
 */
class DangVietSonController extends JControllerLegacy
{
            
    public function insert() {
        // Get a db connection.
        $db = JFactory::getDbo();
        
        //Get the user inputs
        $jinput = JFactory::getApplication()->input;
        $data['name'] = $db->quote($jinput->get('Name', null, null));
        $data['email'] = $db->quote($jinput->get('Email', null, null));
        $data['type'] = $db->quote($jinput->get('Type', null, null));
        $data['subject'] = $db->quote($jinput->get('Subject', null, null));
        $data['feedback'] = $db->quote($jinput->get('Feedback', null, null));
        
        //Insert data to database
        $model = $this->getModel('feedback');
        $model->InsertData($data);	
        
        //Redirect to contact page
        $url = 'index.php?option=com_sondang&view=helloworld&layout=contactus&Itemid=149';
        $this->setRedirect($url);
        
        //Load the testing view folder
//        $view = $this->getView('testing', 'html');
//        
//        //Set the data
//        $view->data = $data;
//        
//        //Load the layout in tmpl folder
//        $view->setLayout('hey');
//        
//        //Display the view
//        $view->display();
    }
}
