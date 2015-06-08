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
 * File Name:	router.php
  ^
 * Description: for Joomla SEF
  ^
 * History:		NONE
  ^
 */
defined('_JEXEC') or die('Restricted access');
function JSJobsBuildRoute(&$query) {
    $segments = array();
    $router = new jsjobsRouter;

    if (isset($query['c'])) {
        $segments[] = $query['c']; unset($query['c']);
    };
    if (isset($query['view'])) {
        $view = $query['view']; unset($query['view']);
    };
    if (isset($query['layout'])) {
        $value = $router->buildLayout($query['layout'], $view); $layout = $query['layout']; $segments[] = $value; unset($query['layout']);
    };
    if (isset($query['task'])) {
        //if (count($segments) == 1) $segments[] = 'tk';
        $segments[] = 'tk';
        $segments[] = $query['task']; unset($query['task']);
    };
    //category 
    if (isset($query['cat'])) {
        $segments[] = "cat-" . $query['cat']; unset($query['cat']);
    };
    //company
    if (isset($query['cd'])) {
        $segments[] = "company-" . $query['cd']; unset($query['cd']);
    };
    //resume
    if (isset($query['rd'])) {
        $segments[] = "resume-" . $query['rd']; unset($query['rd']);
    };
    //job
    if (isset($query['bd'])) {
        $segments[] = "job-" . $query['bd']; unset($query['bd']);
    };
    //email
    if (isset($query['email'])) {
        $segments[] = "email-" . $query['email']; unset($query['email']);
    };
    //cover letter
    if (isset($query['cl'])) {
        $segments[] = "letter-" . $query['cl']; unset($query['cl']);
    };
    //package
    if (isset($query['gd'])) {
        $segments[] = "package-" . $query['gd']; unset($query['gd']);
    };
    //package buy now
    if (isset($query['pb'])) {
        $segments[] = "pkgfrom-" . $router->getPackageFromTitle($query['pb']) . "-" . $query['pb']; unset($query['pb']);
    };
    //department
    if (isset($query['pd'])) {
        $segments[] = "dept-" . $query['pd']; unset($query['pd']);
    };
    //view department
    if (isset($query['vp'])) {
        $segments[] = "viewdept-" . $query['vp']; unset($query['vp']);
    };
    //sub category
    if (isset($query['jobsubcat'])) {
        $segments[] = "subcategory-" . $query['jobsubcat']; unset($query['jobsubcat']);
    };
    //resume pdf output
    if (isset($query['format'])) {
        if (isset($layout) AND $layout == "rssresumes") {
            $segments[] = "resumerssformat-" . $query['format']; unset($query['format']);
        } elseif (isset($layout) AND $layout == "rssjobs") {
            $segments[] = "jobsrssformat-" . $query['format']; unset($query['format']);
        } else {
            $segments[] = "format-".$query['format']; unset($query['format']);
        }
    };
    //folder
    if (isset($query['fd'])) {
        $segments[] = "fld-" . $query['fd']; unset($query['fd']);
    };
    //country
    if (isset($query['country'])) {
        $segments[] = "cn-" . $query['country']; unset($query['country']);
    };
    //state
    if (isset($query['state'])) {
        $segments[] = "st-" . $query['state']; unset($query['state']);
    };
    //city
    if (isset($query['city'])) {
        $segments[] = "cy-" . $query['city']; unset($query['city']);
    };
    if (isset($query['sortby'])) {
        $segments[] = "sort-" . $query['sortby']; unset($query['sortby']);
    };
    // form user registration
    if (isset($query['userrole'])) {
        if ($query['userrole'] == "2") {
            $segments[] = "jobseekerregistration-" . $query['userrole']; unset($query['userrole']);
        } elseif ($query['userrole'] == "3") {
            $segments[] = "employerregistration-" . $query['userrole']; unset($query['userrole']);
        }
    };
    // applied application tab
    if (isset($query['ta'])) {
        $segments[] = "tab-" . $router->getAppliedApplicationTabTitle($query['ta']) . "-" . $query['ta']; unset($query['ta']);
    };
    // view resume search
    if (isset($query['rs'])) {
        $segments[] = "rsaved-" . $query['rs']; unset($query['rs']);
    };
    // view job search
    if (isset($query['js'])) {
        $segments[] = "jsaved-" . $query['js']; unset($query['js']);
    };
    //resume by subcategory 
    if (isset($query['resumesubcat'])) { //subcat
        $segments[] = "subcat-" . $query['resumesubcat']; unset($query['resumesubcat']);
    };
    // nav used for the navigation
    if(isset($query['nav'])){
        $segments[] = "nav-".$query['nav']; unset($query['nav']);
    }

    // orderid used for payment method 
    if(isset($query['orderid'])){
        $segments[] = "orderid-".$query['orderid']; unset($query['orderid']);
    }
    // for used for payment method 
    if(isset($query['for'])){
        $segments[] = "paymentfor-".$query['for']; unset($query['for']);
    }
    // packagefor used for payment method 
    if(isset($query['packagefor'])){
        $segments[] = "packagefor-".$query['packagefor']; unset($query['packagefor']);
    }

    
    //itemid
    if (isset($query['Itemid'])) {
        $_SESSION['JSItemid'] = $query['Itemid'];
    };

    return $segments;
}

function JSJobsParseRoute($segments) {
    $vars = array();
    $vars['c'] = 'jsjobs';
    $count = count($segments);
    $router = new jsjobsRouter;

    $layout="";    
    if (isset($segments[1])) {
        $layout = $segments[1];
    }
    
    if($segments[0]== 'tk') {
        $vars['task'] = $segments[1];
    } else {
        $lresult = $router->parseLayout($layout);
        $vars['view'] = $lresult["view"];
        $vars['layout'] = $lresult["layout"];
    }
    $i = 0;
    foreach ($segments AS $seg) {
        if ($i >= 1) {
            $array = explode(":", $seg);
            $index = $array[0];
            //unset the current index
            unset($array[0]);
            if (isset($array[1])) $value = implode("-", $array);

            switch ($index) {
                case "cat": $vars['cat'] = $value; break;
                case "company": $vars['cd'] = $value; break;
                case "resume": $vars['rd'] = $value; break;
                case "job": $vars['bd'] = $value; break;
                case "email": $vars['email'] = $value; break;
                case "letter": $vars['cl'] = $value; break;
                case "package": $vars['gd'] = $value; break;
                case "pkgfrom": $vars['pb'] = $router->parseId($value); break;
                case "dept": $vars['pd'] = $value; break;
                case "viewdept": $vars['vp'] = $value; break;
                case "subcategory": $vars['jobsubcat'] = $value; break;
                case "resumerssformat":
                case "jobsrssformat":
                case "format":
                    $vars['format'] = $value; break;
                case "fld": $vars['fd'] = $value; break;
                case "cn": $vars['country'] = $value; break;
                case "st": $vars['state'] = $value; break;
                case "cy": $vars['city'] = $value; break;
                case "sort": $vars['sortby'] = $value; break;
                case "jobseekerregistration":
                case "employerregistration":
                    $vars['userrole'] = $value; break;
                case "tab": $vars['ta'] = $router->parseId($value); break;
                case "rsaved": $vars['rs'] = $value; break;
                case "jsaved": $vars['js'] = $value; break;
                case "subcat":$vars['resumesubcat'] = $value; break;

                //from -nav
                case "nav" : $vars['nav'] = $value; break;

                //from -orderid
                case "orderid" : $vars['orderid'] = $value; break;
                //from -paymentfor
                case "paymentfor" : $vars['for'] = $value; break;
                //from -packagefor
                case "packagefor" : $vars['packagefor'] = $value; break;
            }
        }
        $i++;
    }

    if (isset($_SESSION['JSAzItemid'])) {
        $vars['Itemid'] = $_SESSION['JSAzItemid'];
    }
    return $vars;
}

class jsjobsRouter {

    function buildLayout($value, $view) {
        $returnvalue = "";
        switch ($value) {
            case "controlpanel":
                if ($view == 'jobseeker') $returnvalue = "controlpanel";
                else $returnvalue = "controlpannel";
                break;
            case "formjob": $returnvalue = "formjob"; break;
            case "myjobs": $returnvalue = "myjobs"; break;
            case "mycompanies": $returnvalue = "mycompanies"; break;
            case "formcompany": $returnvalue = "formcompany"; break;
            case "alljobsappliedapplications": $returnvalue = "appliedresume"; break;
            case "formdepartment": $returnvalue = "formdepartment"; break;
            case "mydepartments": $returnvalue = "mydepartments"; break;
            case "formfolder": $returnvalue = "formfolder"; break;
            case "myfolders": $returnvalue = "myfolders"; break;
            case "empmessages": $returnvalue = "employermessages"; break;
            case "resumesearch": $returnvalue = "resumesearch"; break;
            case "my_resumesearches": $returnvalue = "resumesavesearch"; break;
            case "resumebycategory": $returnvalue = "resumebycategory"; break;
            case "rssresumes": $returnvalue = "rssresumes"; break;
            case "packages":
                if ($view == 'jobseekerpackages') $returnvalue = "jobseekerpackages";
                else $returnvalue = "employerpackages";
                break;
            case "employerpurchasehistory": $returnvalue = "employerpurchasehistory"; break;
            case "jobseekerpurchasehistory": $returnvalue = "jobseekerpurchasehistory"; break;
            case "my_stats":
                if ($view == 'jobseeker') $returnvalue = "jobseekerstats";
                else $returnvalue = "employerstats";
                break;
            case "package_details":
                if ($view == 'jobseekerpackages') $returnvalue = "jobseekerpackagedetails";
                else $returnvalue = "employerpackagedetails";
                break;
            case "package_buynow":
                if ($view == 'jobseekerpackages') $returnvalue = "jobseekerbuynow";
                else $returnvalue = "employerbuynow";
                break;
            case "view_job": $returnvalue = "viewjob"; break;
            case "view_company": $returnvalue = "viewcompany"; break;
            case "view_department": $returnvalue = "viewdepartment"; break;
            case "viewfolder": $returnvalue = "viewfolder"; break;
            case "folder_resumes": $returnvalue = "folderresumes"; break;
            case "job_messages": $returnvalue = "employerjobmessages"; break;
            case "send_message": $returnvalue = "employersendmessages"; break;
            case "job_appliedapplications": $returnvalue = "jobappliedapplications"; break;
            case "resume_searchresults": $returnvalue = "resumesearchresults"; break;
            case "viewresumesearch": $returnvalue = "viewresumesearch"; break;
            case "resume_bycategory": $returnvalue = "resumecategory"; break;
            case "resume_bysubcategory": $returnvalue = "resumesubcategory"; break;
            case "formjob_visitor": $returnvalue = "formjobvisitor"; break;
            /* Jobseeker layout start  */
            case "formresume": $returnvalue = "formresume"; break;
            case "myresumes": $returnvalue = "myresumes"; break;
            case "formcoverletter": $returnvalue = "formcoverletter"; break;
            case "mycoverletters": $returnvalue = "mycoverletters"; break;
            case "jsmessages": $returnvalue = "jobseekermessages"; break;
            case "jobcat": $returnvalue = "jobcategory"; break;
            case "listnewestjobs": $returnvalue = "newestjobs"; break;
            case "myappliedjobs": $returnvalue = "myappliedjobs"; break;
            case "jobsearch": $returnvalue = "searchjob"; break;
            case "my_jobsearches": $returnvalue = "jobsearches"; break;
            case "jobalertsetting": $returnvalue = "jobalert"; break;
            case "rssjobs": $returnvalue = "rssjobs"; break;
            case "view_resume": $returnvalue = "viewresume"; break;
            case "view_coverletters": $returnvalue = "viewcoverletters"; break;
            case "view_coverletter": $returnvalue = "viewcoverletter"; break;
            case "resumepdf": $returnvalue = "resumepdf"; break;
            case "company_jobs": $returnvalue = "companyjobs"; break;
            case "job_apply": $returnvalue = "jobapply"; break;
            case "list_jobs": $returnvalue = "listjobs"; break;
            case "list_subcategoryjobs": $returnvalue = "listsubcategoryjobs"; break;
            case "job_searchresults": $returnvalue = "jobsearchresults"; break;
            case "viewjobsearch": $returnvalue = "viewjobsearch"; break;
            case "jobalertunsubscribe": $returnvalue = "jobalertunsubscribe"; break;
            case "rssjobs": $returnvalue = "rssjobs"; break;
            case "userregister": $returnvalue = "registration"; break;
            case "successfullogin": $returnvalue = "successfullogin"; break;
            case "new_injsjobs": $returnvalue = "newinjsjobs"; break;
        }
        return $returnvalue;
    }

    function parseLayout($value) {
        //	$returnvalue = "";
        switch ($value) {
            case "controlpanel": $returnvalue["layout"] = "controlpanel"; $returnvalue["view"] = "jobseeker"; break;
            case "controlpannel": $returnvalue["layout"] = "controlpanel"; $returnvalue["view"] = "employer"; break;
            case "formjob": $returnvalue["layout"] = "formjob"; $returnvalue["view"] = "job"; break;
            case "myjobs": $returnvalue["layout"] = "myjobs"; $returnvalue["view"] = "job"; break;
            case "mycompanies": $returnvalue["layout"] = "mycompanies"; $returnvalue["view"] = "company"; break;
            case "formcompany": $returnvalue["layout"] = "formcompany"; $returnvalue["view"] = "company"; break;
            case "formdepartment": $returnvalue["layout"] = "formdepartment"; $returnvalue["view"] = "department"; break;
            case "mydepartments": $returnvalue["layout"] = "mydepartments"; $returnvalue["view"] = "department"; break;
            case "formfolder": $returnvalue["layout"] = "formfolder"; $returnvalue["view"] = "folder"; break;
            case "myfolders": $returnvalue["layout"] = "myfolders"; $returnvalue["view"] = "folder"; break;
            case "employermessages": $returnvalue["layout"] = "empmessages"; $returnvalue["view"] = "message"; break;
            case "resumesearch": $returnvalue["layout"] = "resumesearch"; $returnvalue["view"] = "resume"; break;
            case "resumesavesearch": $returnvalue["layout"] = "my_resumesearches"; $returnvalue["view"] = "resume"; break;
            case "resumebycategory": $returnvalue["layout"] = "resumebycategory"; $returnvalue["view"] = "resume"; break;
            case "rssresumes": $returnvalue["layout"] = "rssresumes"; $returnvalue["view"] = "rss"; break;
            case "jobseekerpackages": $returnvalue["layout"] = "packages"; $returnvalue["view"] = "jobseekerpackages"; break;
            case "employerpackages": $returnvalue["layout"] = "packages"; $returnvalue["view"] = "employerpackages"; break;
            case "jobseekerpurchasehistory": $returnvalue["layout"] = "jobseekerpurchasehistory"; $returnvalue["view"] = "purchasehistory"; break;
            case "employerpurchasehistory": $returnvalue["layout"] = "employerpurchasehistory"; $returnvalue["view"] = "purchasehistory"; break;
            case "jobseekerstats": $returnvalue["layout"] = "my_stats"; $returnvalue["view"] = "jobseeker"; break;
            case "employerstats": $returnvalue["layout"] = "my_stats"; $returnvalue["view"] = "employer"; break;
            case "viewjob": $returnvalue["layout"] = "view_job"; $returnvalue["view"] = "job"; break;
            case "viewcompany": $returnvalue["layout"] = "view_company"; $returnvalue["view"] = "company"; break;
            case "viewdepartment": $returnvalue["layout"] = "view_department"; $returnvalue["view"] = "department"; break;
            case "viewfolder": $returnvalue["layout"] = "viewfolder"; $returnvalue["view"] = "folder"; break;
            case "folderresumes": $returnvalue["layout"] = "folder_resumes"; $returnvalue["view"] = "folder"; break;
            case "employerjobmessages": $returnvalue["layout"] = "job_messages"; $returnvalue["view"] = "message"; break;
            case "employersendmessages": $returnvalue["layout"] = "send_message"; $returnvalue["view"] = "message"; break;
            case "jobappliedapplications": $returnvalue["layout"] = "job_appliedapplications"; $returnvalue["view"] = "jobapply"; break;
            case "resumesearchresults": $returnvalue["layout"] = "resume_searchresults"; $returnvalue["view"] = "resume"; break;
            case "viewresumesearch": $returnvalue["layout"] = "viewresumesearch"; $returnvalue["view"] = "resume"; break;
            case "resumecategory": $returnvalue["layout"] = "resume_bycategory"; $returnvalue["view"] = "resume"; break;
            case "resumesubcategory": $returnvalue["layout"] = "resume_bysubcategory"; $returnvalue["view"] = "resume"; break;
            case "employerpackagedetails": $returnvalue["layout"] = "package_details"; $returnvalue["view"] = "employerpackages"; break;
            case "jobseekerpackagedetails": $returnvalue["layout"] = "package_details"; $returnvalue["view"] = "jobseekerpackages"; break;
            case "employerbuynow": $returnvalue["layout"] = "package_buynow"; $returnvalue["view"] = "employerpackages"; break;
            case "jobseekerbuynow": $returnvalue["layout"] = "package_buynow"; $returnvalue["view"] = "jobseekerpackages"; break;
            case "formjobvisitor": $returnvalue["layout"] = "formjob_visitor"; $returnvalue["view"] = "job"; break;

            /* Jobseeker layout start  */
            case "formresume": $returnvalue["layout"] = "formresume"; $returnvalue["view"] = "resume"; break;
            case "myresumes": $returnvalue["layout"] = "myresumes"; $returnvalue["view"] = "resume"; break;
            case "formcoverletter": $returnvalue["layout"] = "formcoverletter"; $returnvalue["view"] = "coverletter"; break;
            case "mycoverletters": $returnvalue["layout"] = "mycoverletters"; $returnvalue["view"] = "coverletter"; break;
            case "jobseekermessages": $returnvalue["layout"] = "jsmessages"; $returnvalue["view"] = "message"; break;
            case "jobcategory": $returnvalue["layout"] = "jobcat"; $returnvalue["view"] = "category"; break;
            case "newestjobs": $returnvalue["layout"] = "listnewestjobs"; $returnvalue["view"] = "job"; break;
            case "myappliedjobs": $returnvalue["layout"] = "myappliedjobs"; $returnvalue["view"] = "jobapply"; break;
            case "searchjob": $returnvalue["layout"] = "jobsearch"; $returnvalue["view"] = "job"; break;
            case "jobsearches": $returnvalue["layout"] = "my_jobsearches"; $returnvalue["view"] = "jobsearch"; break;
            case "jobalert": $returnvalue["layout"] = "jobalertsetting"; $returnvalue["view"] = "jobalert"; break;
            case "rssjobs": $returnvalue["layout"] = "rssjobs"; $returnvalue["view"] = "rss"; break;
            case "jobseekerpackages": $returnvalue["layout"] = "packages"; $returnvalue["view"] = "jobseeker"; break;
            case "jobseekerpurchasehistory": $returnvalue["layout"] = "purchasehistory"; $returnvalue["view"] = "jobseeker"; break;
            case "jobseekerstats": $returnvalue["layout"] = "my_stats"; $returnvalue["view"] = "jobseeker"; break;
            case "viewresume": $returnvalue["layout"] = "view_resume"; $returnvalue["view"] = "resume"; break;
            case "viewcoverletters": $returnvalue["layout"] = "view_coverletters"; $returnvalue["view"] = "coverletter"; break;
            case "viewcoverletter": $returnvalue["layout"] = "view_coverletter"; $returnvalue["view"] = "coverletter"; break;
            case "resumepdf": $returnvalue["layout"] = "resumepdf"; $returnvalue["view"] = "output"; break;
            case "companyjobs": $returnvalue["layout"] = "company_jobs"; $returnvalue["view"] = "company"; break;
            case "jobapply": $returnvalue["layout"] = "job_apply"; $returnvalue["view"] = "jobapply"; break;
            case "listjobs": $returnvalue["layout"] = "list_jobs"; $returnvalue["view"] = "job"; break;
            case "listsubcategoryjobs": $returnvalue["layout"] = "list_subcategoryjobs"; $returnvalue["view"] = "subcategory"; break;
            case "jobsearchresults": $returnvalue["layout"] = "job_searchresults"; $returnvalue["view"] = "job"; break;
            case "viewjobsearch": $returnvalue["layout"] = "viewjobsearch"; $returnvalue["view"] = "jobsearch"; break;
            case "jobalertunsubscribe": $returnvalue["layout"] = "jobalertunsubscribe"; $returnvalue["view"] = "jobalert"; break;
            case "rssjobs": $returnvalue["layout"] = "rssjobs"; $returnvalue["view"] = "rss"; break;
            case "registration": $returnvalue["layout"] = "userregister"; $returnvalue["view"] = "common"; break;
            case "successfullogin": $returnvalue["layout"] = "successfullogin"; $returnvalue["view"] = "common"; break;
            case "newinjsjobs": $returnvalue["layout"] = "new_injsjobs"; $returnvalue["view"] = "common"; break;
        }
        if (isset($returnvalue))
            return $returnvalue;
    }

    function getPackageTitle($id, $view) {
        $db = JFactory::getDBO();
        if ($view == 'employer')
            $tablename = '#__js_job_employerpackages';
        else
            $tablename = '#__js_job_jobseekerpackages';
        $query = "SELECT LOWER(REPLACE(title,' ','-')) FROM `" . $tablename . "` WHERE id = " . (int) $id;
        $db->setQuery($query);
        $result = $db->loadResult();
        $result = strtolower(str_replace(' ', '-', $result));
        return $result;
    }

    function getPackageFromTitle($id) {
        if ($id == 1) $result = "packages";
        else $result = "package-detail";
        return $result;
    }

    function getAppliedApplicationTabTitle($id) {
        $result = '';
        switch ($id) {
            case 1: $result = "inbox"; break;
            case 2: $result = "spam"; break;
            case 3: $result = "hired"; break;
            case 4: $result = "rejected"; break;
            case 5: $result = "shortlist"; break;
        }
        return $result;
    }

    function parseId($value) {
        $id = explode("-", $value);
        $count = count($id);
        $id = (int) $id[($count - 1)];
        return $id;
    }
}
