<?php

/**
 * @Copyright Copyright (C) 2012 ... Ahmad Bilal
 * @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * Company:		Buruj Solutions
  + Contact:		www.burujsolutions.com , ahmad@burujsolutions.com
 * Created on:	April 05, 2012
  ^
  + Project: 		JS Autoz
  ^
 */
defined('_JEXEC') or die('Restricted access');
if (JVERSION < 3) {
    jimport('joomla.application.component.model');
    jimport('joomla.application.component.view');
    jimport('joomla.application.component.controller');
    if( !class_exists( 'JSModel', false ) ){
        abstract class JSModel extends JModel {
            function __construct() {
                parent::__construct();
            }
            static function getJSModel($model) {
                require_once JPATH_COMPONENT . '/models/' . $model . '.php';
                $modelclass = 'JSJobsModel' . $model;
                $model_object = new $modelclass;
                return $model_object;
            }
        }
    }
    if( !class_exists( 'JSView', false ) ){
        abstract class JSView extends JView{
            function __construct() {
                parent::__construct();
            }
            static function getJSModel($model){
                return JSModel::getJSModel($model);
            }
        }
    }
    if( !class_exists( 'JSController', false ) ){
        abstract class JSController extends JController{
            function __construct() {
                parent::__construct();
            }
            static function getJSController($controller) {
                require_once JPATH_COMPONENT . '/controllers/' . $controller . '.php';
                $controllerclass = 'JSJobsController' . $controller;
                $controller_object = new $controllerclass;
                return $controller_object;
            }
        }
    }
}else{
    if( !class_exists( 'JSView', false ) ){
        abstract class JSView extends JViewLegacy{
            function __construct() {
                parent::__construct();
            }

            static function getJSModel($model) {
                return JSModel::getJSModel($model);
            }
        }
    }
    if( !class_exists( 'JSController', false ) ){
        abstract class JSController extends JControllerLegacy{
            function __construct() {
                parent::__construct();
            }
            static function getJSController($controller) {
                require_once JPATH_COMPONENT . '/controllers/' . $controller . '.php';
                $controllerclass = 'JSJobsController' . $controller;
                $controller_object = new $controllerclass;
                return $controller_object;
            }
        }
    }
    if( !class_exists( 'JSModel', false ) ){
        abstract class JSModel extends JModelLegacy{
            function __construct() {
                parent::__construct();
            }
            static function getJSModel($model) {
                require_once JPATH_COMPONENT . '/models/' . $model . '.php';
                $modelclass = 'JSJobsModel' . $model;
                $model_object = new $modelclass;
                return $model_object;
            }

        }
    }    
}
?>
