<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
jimport('joomla.user.helper');

class DangVietSonControllerRegister extends JControllerLegacy {
    
    public function jobseeker() {
        //Perform check & insert user info to database Users & User Map 
        
        // Get a db connection.
        $db = JFactory::getDbo();
        $model = $this->getModel('register');
        
        //Get the user inputs
        $jinput = JFactory::getApplication()->input;
        $data['username'] = $db->quote($jinput->get('name', null, null));
        $name = $jinput->get('name', null, null);
        $email = $jinput->get('email', null, null);
        $password = $db->quote($jinput->get('password', null, null));
        $data['email'] = $db->quote($jinput->get('email', null, null));
        $data['password'] = $db->quote(JUserHelper::hashPassword($jinput->get('password', null, null)));
        $data['date'] = $db->quote(date('Y-m-d H:i:s'));
        
        $validation['recheck_password'] = $db->quote($jinput->get('recheck_password', null, null));        
        $validation['recheck_email'] = $db->quote($jinput->get('recheck_email', null, null));
        $validation['phone'] = $db->quote($jinput->get('phone', null, null));
        $validation['street'] = $db->quote($jinput->get('street', null, null));
        $validation['city'] = $db->quote($jinput->get('city', null, null));
        $validation['website'] = $db->quote($jinput->get('website', null, null));
        $validation['country'] = $db->quote($jinput->get('country', null, null));
        $validation['gender'] = $db->quote($jinput->get('gender', null, null));
        $validation['date'] = $jinput->get('date', null, null);
        $validation['month'] = $jinput->get('month', null, null);
        $validation['year'] = $jinput->get('year', null, null);
        $validation['nation'] = $jinput->get('nation', null, null);
        $validation['children'] = $jinput->get('children', null, null);
        
        $url = 'index.php?option=com_sontest&view=registration&layout=form&Itemid=168';
        
        //Validate password & email should match
        if($data['email'] !== $validation['recheck_email']){
            $message = "emails did not match, please check";
            $this->setRedirect($url, $message);
        } elseif ($password !== $validation['recheck_password']) {
            $message = "passwords did not match, please check";
            $this->setRedirect($url, $message);
        }
        
        
        //Check if user || email already registered 
        
        if ($name == $model->get_users('username', $name)[0]->username){
            $message = "username already taken";
            $this->setRedirect($url, $message);
        } elseif ($email == $model->get_users('email', $email)[0]->email) {
            $message = "email already taken";
            $this->setRedirect($url, $message);
            
        } else {
            //Insert data to database
            $model->InsertData($data);

            //Insert data to usergroup_map table
            $user['user_id'] = $model->get_registered_userid($name)->id;
            $user['user_group'] = '2';
            $model->InsertUserGroup($user);
            
            $this->setRedirect('index.php?option=com_users&view=login');
        }
 }
    
    
    public function employer() {
        //Perform check & insert user info to database Users & User Map 
    }
    
}
