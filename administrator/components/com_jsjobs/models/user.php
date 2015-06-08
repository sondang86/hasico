<?php

/**
 * @Copyright Copyright (C) 2009-2010 ... Ahmad Bilal
 * @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * Company:		Al-Barr Technologies
  + Contact:		www.al-barr.com , info@al-barr.com
 * Created on:	Jan 11, 2009
  ^
  + Project: 		Job Posting and Employment Application
 * File Name:	admin-----/models/jsjobs.php
  ^
 * Description: Model for application on admin site
  ^
 * History:		NONE
  ^
 */
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.model');
jimport('joomla.html.html');

class JSJobsModelUser extends JSModel{

    var $_config = null;
    var $_defaultcurrency = null;
    var $_client_auth_key = null;
    var $_siteurl = null;

    function __construct() {
        parent :: __construct();
        $this->_componentPath = JPATH_COMPONENT_ADMINISTRATOR . "/models/";
        $this->_client_auth_key = $this->getJSModel('jobsharing')->getClientAuthenticationKey();
        $this->_siteurl = JURI::root();
        $this->_defaultcurrency = $this->getJSModel('currency')->getDefaultCurrency();
        $user = JFactory::getUser();
        $this->_uid = $user->id;
    }

    function getAllUsers($searchname, $searchusername, $searchcompany, $searchresume, $searchrole, $limitstart, $limit) {
        $db = JFactory :: getDBO();
        $result = array();

        $query = 'SELECT COUNT(DISTINCT a.id)'
                . ' FROM #__users AS a'
                . ' LEFT JOIN #__js_job_userroles AS usr ON usr.uid = a.id '
                . ' LEFT JOIN #__js_job_roles AS role ON role.id = usr.role
			 LEFT JOIN #__js_job_companies AS company ON company.uid = a.id
			 LEFT JOIN #__js_job_resume AS resume ON resume.uid = a.id ';

        $clause = ' WHERE ';
        if ($searchname) {
            $query .= $clause . ' LOWER(a.name) LIKE ' . $db->Quote('%' . $searchname . '%', false);
            $clause = 'AND';
        }
        if ($searchusername) {
            $query .= $clause . ' LOWER(a.username) LIKE ' . $db->Quote('%' . $searchusername . '%', false);
            $clause = 'AND';
        }
        if ($searchcompany) {
            $query .= $clause . ' LOWER(company.name) LIKE ' . $db->Quote('%' . $searchcompany . '%', false);
            $clause = 'AND';
        }
        if ($searchresume) {
            $query .= $clause . ' ( LOWER(resume.first_name) LIKE ' . $db->Quote('%' . $searchresume . '%', false) . '
                                            OR LOWER(resume.last_name) LIKE ' . $db->Quote('%' . $searchresume . '%', false) . '
                                            OR LOWER(resume.middle_name) LIKE ' . $db->Quote('%' . $searchresume . '%', false) . ' )';
            $clause = 'AND';
        }
        if ($searchrole)
            $query .= $clause . ' LOWER( role.title) LIKE ' . $db->Quote('%' . $searchrole . '%', false);

        $db->setQuery($query);
        $total = $db->loadResult();
        if ($total <= $limitstart)
            $limitstart = 0;
        $query = 'SELECT a.*, g.title AS groupname, role.title AS roletitle,
                                     company.name AS companyname, resume.first_name, resume.last_name'
                . ' FROM #__users AS a'
                . '	INNER JOIN #__user_usergroup_map AS groupmap ON groupmap.user_id = a.id '
                . '	INNER JOIN #__usergroups AS g ON g.id = groupmap.group_id '
                . ' LEFT JOIN #__js_job_userroles AS usr ON usr.uid = a.id '
                . ' LEFT JOIN #__js_job_roles AS role ON role.id = usr.role
                             LEFT JOIN #__js_job_companies AS company ON company.uid = a.id
                             LEFT JOIN #__js_job_resume AS resume ON resume.uid = a.id ';
        $clause = ' WHERE ';
        if ($searchname) {
            $query .= $clause . ' LOWER(a.name) LIKE ' . $db->Quote('%' . $searchname . '%', false);
            $clause = 'AND';
        }
        if ($searchusername) {
            $query .= $clause . ' LOWER(a.username) LIKE ' . $db->Quote('%' . $searchusername . '%', false);
            $clause = 'AND';
        }
        if ($searchcompany) {
            $query .= $clause . ' LOWER(company.name) LIKE ' . $db->Quote('%' . $searchcompany . '%', false);
            $clause = 'AND';
        }
        if ($searchresume) {
            $query .= $clause . ' ( LOWER(resume.first_name) LIKE ' . $db->Quote('%' . $searchresume . '%', false) . '
                                            OR LOWER(resume.last_name) LIKE ' . $db->Quote('%' . $searchresume . '%', false) . '
                                            OR LOWER(resume.middle_name) LIKE ' . $db->Quote('%' . $searchresume . '%', false) . ' )';
            $clause = 'AND';
        }
        if ($searchrole)
            $query .= $clause . ' LOWER( role.title) LIKE ' . $db->Quote('%' . $searchrole . '%', false);

        $query .= ' GROUP BY a.id';
        $db->setQuery($query, $limitstart, $limit);
        $result[0] = $db->loadObjectList();

        $lists = array();
        if ($searchname)
            $lists['searchname'] = $searchname;
        if ($searchusername)
            $lists['searchusername'] = $searchusername;
        if ($searchcompany)
            $lists['searchcompany'] = $searchcompany;
        if ($searchresume)
            $lists['searchresume'] = $searchresume;
        if ($searchrole)
            $lists['searchrole'] = $searchrole;
        $result[1] = $total;
        $result[2] = $lists;
        return $result;
    }

    function getUserStats($searchname, $searchusername, $limitstart, $limit) {
        $db = JFactory :: getDBO();
        $result = array();

        $query = 'SELECT COUNT(a.id)'
                . ' FROM #__users AS a';

        $clause = ' WHERE ';
        if ($searchname) {
            $query .= $clause . ' LOWER(a.name) LIKE ' . $db->Quote('%' . $searchname . '%', false);
            $clause = 'AND';
        }
        if ($searchusername)
            $query .= $clause . ' LOWER(a.username) LIKE ' . $db->Quote('%' . $searchusername . '%', false);

        $db->setQuery($query);
        $total = $db->loadResult();
        if ($total <= $limitstart)
            $limitstart = 0;

        $query = 'SELECT a.*,role.rolefor
                    ,(SELECT name FROM #__js_job_companies WHERE uid=a.id limit 1 ) AS companyname
                    ,(SELECT CONCAT(first_name," ",last_name) FROM #__js_job_resume WHERE uid=a.id limit 1 ) AS resumename
                    ,(SELECT count(id) FROM #__js_job_companies WHERE uid=a.id ) AS companies
                    ,(SELECT count(id) FROM #__js_job_jobs WHERE uid=a.id ) AS jobs
                    ,(SELECT count(id) FROM #__js_job_resume WHERE uid=a.id ) AS resumes
                    FROM #__users AS a
                    LEFT JOIN #__js_job_userroles AS userrole ON userrole.uid=a.id
                    LEFT JOIN #__js_job_roles AS role ON role.id=userrole.role';


        $clause = ' WHERE ';
        if ($searchname) {
            $query .= $clause . ' LOWER(a.name) LIKE ' . $db->Quote('%' . $searchname . '%', false);
            $clause = 'AND';
        }
        if ($searchusername)
            $query .= $clause . ' LOWER(a.username) LIKE ' . $db->Quote('%' . $searchusername . '%', false);

        $query .= ' GROUP BY a.id';

        $db->setQuery($query, $limitstart, $limit);
        $result[0] = $db->loadObjectList();

        $lists = array();
        if ($searchname)
            $lists['searchname'] = $searchname;
        if ($searchusername)
            $lists['searchusername'] = $searchusername;

        $result[1] = $total;
        $result[2] = $lists;
        return $result;
    }

    function getUserStatsCompanies($companyuid, $limitstart, $limit) {
        if (is_numeric($companyuid) == false) return false;
        $db = JFactory :: getDBO();
        $result = array();

        $query = 'SELECT COUNT(company.id)'
                . ' FROM #__js_job_companies AS company
		WHERE company.uid = ' . $companyuid;

        $db->setQuery($query);
        $total = $db->loadResult();
        if ($total <= $limitstart) $limitstart = 0;

        $query = 'SELECT company.*,cat.cat_title'
                . ' FROM #__js_job_companies AS company'
                . ' JOIN #__js_job_categories AS cat ON cat.id=company.category'
                . ' LEFT JOIN #__js_job_cities AS city ON city.id=company.city'
                . ' LEFT JOIN #__js_job_countries AS country ON country.id=city.countryid
		WHERE company.uid = ' . $companyuid;

        $query .= ' ORDER BY company.name';

        $db->setQuery($query, $limitstart, $limit);
        $result[0] = $db->loadObjectList();
        $result[1] = $total;
        return $result;
    }

    function getUserStatsJobs($jobuid, $limitstart, $limit) {
        if (is_numeric($jobuid) == false)
            return false;
        $db = JFactory :: getDBO();
        $result = array();

        $query = 'SELECT COUNT(job.id)'
                . ' FROM #__js_job_jobs AS job
		WHERE job.uid = ' . $jobuid;

        $db->setQuery($query);
        $total = $db->loadResult();
        if ($total <= $limitstart)
            $limitstart = 0;
        $query = 'SELECT job.*,company.name AS companyname,cat.cat_title,jobtype.title AS jobtypetitle'
                . ' FROM #__js_job_jobs AS job'
                . ' LEFT JOIN #__js_job_companies AS company ON company.id=job.companyid'
                . ' LEFT JOIN #__js_job_categories AS cat ON cat.id=job.jobcategory'
                . ' LEFT JOIN #__js_job_jobtypes AS jobtype ON jobtype.id=job.jobtype
		   WHERE job.uid = ' . $jobuid;
        $query .= ' ORDER BY job.title';

        $db->setQuery($query, $limitstart, $limit);
        $result[0] = $db->loadObjectList();
        $result[1] = $total;
        return $result;
    }

}

?>