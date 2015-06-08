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
 * File Name:	models/jsjobs.php
  ^
 * Description: Model class for jsjobs data
  ^
 * History:		NONE
  ^
 */
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.model');
jimport('joomla.html.html');
$option = JRequest :: getVar('option', 'com_jsjobs');

class JSJobsModelPermissions extends JSModel {

    var $_user = null;
    var $_userrole = null;

    function __construct() {
        parent :: __construct();
        $this->_user = JFactory::getUser();
        if (!$this->_user->guest) {
            $this->_userrole = $this->getJSModel('userrole')->getUserRoleByUid($this->_user->id);
        }
        if (!defined('PERMISSION_CONSTANT')) {
            $this->prepareConstant();
        }
    }

    function prepareConstant() {
        define('PERMISSION_CONSTANT', 'PERMISSION_CONSTANT');
        define('USER_ROLE_NOT_SELECTED', 'USER_ROLE_NOT_SELECTED');
        define('EMPLOYER_NOT_ALLOWED_JOBSEEKER_PRIVATE_AREA', 'EMPLOYER_NOT_ALLOWED_JOBSEEKER_PRIVATE_AREA');
        define('VISITOR_NOT_ALLOWED_JOBSEEKER_PRIVATE_AREA', 'VISITOR_NOT_ALLOWED_JOBSEEKER_PRIVATE_AREA');
        define('VALIDATE', 'VALIDATE');
        define('NO_PACKAGE', 'NO_PACKAGE');
        define('EXPIRED_PACKAGE', 'EXPIRED_PACKAGE');
        define('RESUME_LIMIT_EXCEEDS', 'RESUME_LIMIT_EXCEEDS');
        define('COVER_LETTER_LIMIT_EXCEEDS', 'COVER_LETTER_LIMIT_EXCEEDS');
        define('JOB_SEARCH_NOT_ALLOWED_IN_PACKAGE', 'JOB_SEARCH_NOT_ALLOWED_IN_PACKAGE');
        define('VISITOR_NOT_ALLOWED_JOBSEARCH', 'VISITOR_NOT_ALLOWED_JOBSEARCH');
        define('EMPLOYER_NOT_ALLOWED_JOBSEARCH', 'EMPLOYER_NOT_ALLOWED_JOBSEARCH');
        define('JOB_SAVE_SEARCH_NOT_ALLOWED_IN_PACKAGE', 'JOB_SAVE_SEARCH_NOT_ALLOWED_IN_PACKAGE');
        define('COMPANY_LIMIT_EXCEEDS', 'COMPANY_LIMIT_EXCEEDS');
        define('JOBSEEKER_NOT_ALLOWED_EMPLOYER_PRIVATE_AREA', 'JOBSEEKER_NOT_ALLOWED_EMPLOYER_PRIVATE_AREA');
        define('VISITOR_NOT_ALLOWED_EMPLOYER_PRIVATE_AREA', 'VISITOR_NOT_ALLOWED_EMPLOYER_PRIVATE_AREA');
        define('JOB_LIMIT_EXCEEDS', 'JOB_LIMIT_EXCEEDS');
        define('VISITOR_NOT_ALLOWED_TO_EDIT_THEIR_JOBS', 'VISITOR_NOT_ALLOWED_TO_EDIT_THEIR_JOBS');
        define('FOLDER_LIMIT_EXCEEDS', 'FOLDER_LIMIT_EXCEEDS');
        define('RESUME_SEARCH_NOT_ALLOWED_IN_PACAKGE', 'RESUME_SEARCH_NOT_ALLOWED_IN_PACAKGE');
        define('JOB_APPLY_LIMIT_EXCEEDS', 'JOB_APPLY_LIMIT_EXCEEDS');
        define('YOU_DO_NOT_HAVE_ANY_RESUME', 'YOU_DO_NOT_HAVE_ANY_RESUME');
    }

    function checkPermissionsFor($permissionfor) {
        switch ($permissionfor) {
            // Permission for Job seeker
            case "ADD_RESUME":
                $returnvalue = $this->checkJobseekerPermissions($permissionfor);
                return $returnvalue;
                break;
            case "MY_RESUME":
                $returnvalue = $this->checkJobseekerPermissions($permissionfor);
                return $returnvalue;
                break;
            case "ADD_COVER_LETTER":
                $returnvalue = $this->checkJobseekerPermissions($permissionfor);
                return $returnvalue;
                break;
            case "MY_COVER_LETTER":
                $returnvalue = $this->checkJobseekerPermissions($permissionfor);
                return $returnvalue;
                break;
            case "JOBSEEKER_MESSAGES":
                $returnvalue = $this->checkJobseekerPermissions($permissionfor);
                return $returnvalue;
                break;
            case "MY_APPLIED_JOB":
                $returnvalue = $this->checkJobseekerPermissions($permissionfor);
                return $returnvalue;
                break;
            case "JOB_SEARCH":
                $returnvalue = $this->checkJobseekerPermissions($permissionfor);
                return $returnvalue;
                break;
            case "JOB_SAVE_SEARCH":
                $returnvalue = $this->checkJobseekerPermissions($permissionfor);
                return $returnvalue;
                break;
            case "JOBSEEKER_PURCHASE_HISTORY":
                $returnvalue = $this->checkJobseekerPermissions($permissionfor);
                return $returnvalue;
                break;
            case "JOBSEEKER_STATS":
                $returnvalue = $this->checkJobseekerPermissions($permissionfor);
                return $returnvalue;
                break;
            case "APPLY_JOB": // default setting is working proper
                $returnvalue = $this->checkJobseekerPermissions($permissionfor);
                return $returnvalue;
                break;
            // Permission for Employer
            case "ADD_COMPANY":
                $returnvalue = $this->checkEmployerPermissions($permissionfor);
                return $returnvalue;
                break;
            case "MY_COMPANY":
                $returnvalue = $this->checkEmployerPermissions($permissionfor);
                return $returnvalue;
                break;
            case "ADD_JOB":
                $returnvalue = $this->checkEmployerPermissions($permissionfor);
                return $returnvalue;
                break;
            case "MY_JOB":
                $returnvalue = $this->checkEmployerPermissions($permissionfor);
                return $returnvalue;
                break;
            case "ADD_DEPARTMENT":
                $returnvalue = $this->checkEmployerPermissions($permissionfor);
                return $returnvalue;
                break;
            case "MY_DEPARTMENT":
                $returnvalue = $this->checkEmployerPermissions($permissionfor);
                return $returnvalue;
                break;
            case "MY_FOLDER":
                $returnvalue = $this->checkEmployerPermissions($permissionfor);
                return $returnvalue;
                break;
            case "ADD_FOLDER":
                $returnvalue = $this->checkEmployerPermissions($permissionfor);
                return $returnvalue;
                break;
            case "EMPLOYER_MESSAGES":
                $returnvalue = $this->checkEmployerPermissions($permissionfor);
                return $returnvalue;
                break;
            case "APPLIED_RESUME":
                $returnvalue = $this->checkEmployerPermissions($permissionfor);
                return $returnvalue;
                break;
            case "RESUME_SEARCH":
                $returnvalue = $this->checkEmployerPermissions($permissionfor);
                return $returnvalue;
                break;
            case "RESUME_SAVE_SEARCH":
                $returnvalue = $this->checkEmployerPermissions($permissionfor);
                return $returnvalue;
                break;
            case "RESUME_BY_CATEGORY":
                $returnvalue = $this->checkEmployerPermissions($permissionfor);
                return $returnvalue;
                break;
            case "EMPLOYER_PURCHASE_HISTORY":
                $returnvalue = $this->checkEmployerPermissions($permissionfor);
                return $returnvalue;
                break;
            case "EMPLOYER_STATS":
                $returnvalue = $this->checkEmployerPermissions($permissionfor);
                return $returnvalue;
                break;
        }
    }
    
    private function checkJobseekerPermissions($permissionfor){
        if (!$this->_user->guest) { // User is login
            if ($this->_userrole != null) { // userrole is selected
                if($this->_userrole == 1){ // user is employer
                    switch($permissionfor){
                        case "JOB_SEARCH":
                            if($this->getJSModel('configurations')->getConfigValue('employerview_js_controlpanel') == 1)
                                return VALIDATE;
                            else
                                return EMPLOYER_NOT_ALLOWED_JOBSEARCH;
                            break;
                        default:
                            return EMPLOYER_NOT_ALLOWED_JOBSEEKER_PRIVATE_AREA;
                            break;
                    }
                    
                }elseif($this->_userrole == 2){ // user is Job seeker
                    switch($permissionfor){
                        case "ADD_RESUME":
                            if($this->getJSModel('configurations')->getConfigValue('js_newlisting_requiredpackage') == 1){ // package is required for job seeker area
                                $package_result = $this->getJSModel('resume')->canAddNewResume($this->_user->id);
                                return $package_result;
                            }else{ // package is not required for the job seeker area
                                return VALIDATE;
                            }
                            break;
                        case "ADD_COVER_LETTER":
                            if($this->getJSModel('configurations')->getConfigValue('js_newlisting_requiredpackage') == 1){ // package is required for job seeker area
                                $package_result = $this->getJSModel('coverletter')->canAddNewCoverLetter($this->_user->id);
                                return $package_result;
                            }else{ // package is not required for the job seeker area
                                return VALIDATE;
                            }
                            break;
                        case "JOB_SEARCH":
                            if($this->getJSModel('configurations')->getConfigValue('js_newlisting_requiredpackage') == 1){ // package is required for job seeker area
                                $package_result = $this->getJSModel('jobsearch')->canJobSearch($this->_user->id);
                                return $package_result;
                            }else{ // package is not required for the job seeker area
                                return VALIDATE;
                            }
                            break;
                        case "JOB_SAVE_SEARCH":
                            if($this->getJSModel('configurations')->getConfigValue('js_newlisting_requiredpackage') == 1){ // package is required for job seeker area
                                $package_result = $this->getJSModel('jobsearch')->canAddNewJobSearch($this->_user->id);
                                if($package_result == 0){
                                    return JOB_SAVE_SEARCH_NOT_ALLOWED_IN_PACKAGE;
                                }else{
                                    return VALIDATE;
                                }
                            }else{ // package is not required for the job seeker area
                                return VALIDATE;
                            }
                            break;
                        case "APPLY_JOB":
                            if($this->getJSModel('configurations')->getConfigValue('js_newlisting_requiredpackage') == 1){ // package is required for job seeker area
                                $package_result = $this->getJSModel('jobapply')->canApplyJob($this->_user->id);
                                return $package_result;
                            }else{ // package is not required for the job seeker area
                                return VALIDATE;
                            }
                            break;
                        default:
                            return VALIDATE;
                            break;
                    }
                }
            } else { // userrole is not selected
                switch($permissionfor){
                    case "JOB_SEARCH":
                        if($this->getJSModel('configurations')->getConfigValue('visitorview_js_jobsearch') == 1)                        
                            return VALIDATE;
                        else
                            return USER_ROLE_NOT_SELECTED;
                        break;
                        break;
                    default:
                        return USER_ROLE_NOT_SELECTED;
                        break;
                }                
            }
        } else { // User is not login
            switch($permissionfor){
                case "JOB_SEARCH":
                    if($this->getJSModel('configurations')->getConfigValue('visitorview_js_jobsearch') == 1)                        
                        return VALIDATE;
                    else
                        return VISITOR_NOT_ALLOWED_JOBSEARCH;
                    break;
                default:
                    return VISITOR_NOT_ALLOWED_JOBSEEKER_PRIVATE_AREA;
                    break;
            }            
        }
    }
    
    private function checkEmployerPermissions($permissionfor){
        if (!$this->_user->guest) { // User is login
            if ($this->_userrole != null) { // userrole is selected
                if($this->_userrole == 1){ // user is employer
                    switch($permissionfor){
                        case "ADD_COMPANY":
                            if($this->getJSModel('configurations')->getConfigValue('newlisting_requiredpackage') == 1){ // package is required for employer area
                                $package_result = $this->getJSModel('company')->canAddNewCompany($this->_user->id);
                                return $package_result;
                            }else{ // package is not required for the employer area
                                return VALIDATE;
                            }
                            break;
                        case "ADD_JOB":
                            if($this->getJSModel('configurations')->getConfigValue('newlisting_requiredpackage') == 1){ // package is required for employer area
                                $package_result = $this->getJSModel('job')->canAddNewJob($this->_user->id);
                                return $package_result;
                            }else{ // package is not required for the employer area
                                return VALIDATE;
                            }
                            break;
                        case "ADD_FOLDER":
                            if($this->getJSModel('configurations')->getConfigValue('newlisting_requiredpackage') == 1){ // package is required for employer area
                                $package_result = $this->getJSModel('folder')->canAddNewFolder($this->_user->id);
                                return $package_result;
                            }else{ // package is not required for the employer area
                                return VALIDATE;
                            }
                            break;
                        case "RESUME_SEARCH":
                        case "RESUME_BY_CATEGORY":
                            if($this->getJSModel('configurations')->getConfigValue('newlisting_requiredpackage') == 1){ // package is required for employer area
                                $package_result = $this->getJSModel('resume')->canSearchResume($this->_user->id);
                                return $package_result;
                            }else{ // package is not required for the employer area
                                return VALIDATE;
                            }
                            break;
                        default:
                            return VALIDATE;
                            break;
                    }
                }elseif($this->_userrole == 2){ // user is Job seeker
                    switch($permissionfor){
                        default:
                            return JOBSEEKER_NOT_ALLOWED_EMPLOYER_PRIVATE_AREA;
                            break;
                    }
                }
            } else { // userrole is not selected
                switch($permissionfor){
                    default:
                        return USER_ROLE_NOT_SELECTED;
                        break;
                }                
            }
        } else { // User is not login
            switch($permissionfor){
                case "MY_JOB":
                    if($this->getJSModel('configurations')->getConfigValue("visitor_can_edit_job") == 1)
                        return VALIDATE;
                    else
                        return VISITOR_NOT_ALLOWED_TO_EDIT_THEIR_JOBS;
                    break;
                default:
                    return VISITOR_NOT_ALLOWED_EMPLOYER_PRIVATE_AREA;
                    break;
            }            
        }
    }

}
?>    
