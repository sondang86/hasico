<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_articles_latest
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */


defined('_JEXEC') or die;

require_once JPATH_SITE . '/components/com_content/helpers/route.php';

JModelLegacy::addIncludePath(JPATH_SITE . '/components/com_content/models', 'ContentModel');

/**
 * Helper for mod_articles_latest
 *
 * @package     Joomla.Site
 * @subpackage  mod_articles_latest
 * @since       1.6
 */
abstract class SonDangHelper {
    
    public static function getList(&$params){
        // Get an instance of the generic articles model
	$model = JModelLegacy::getInstance('Articles', 'ContentModel', array('ignore_request' => true));
        
        // Access filter
	$access     = !JComponentHelper::getParams('com_content')->get('show_noauth');
	$authorised = JAccess::getAuthorisedViewLevels(JFactory::getUser()->get('id'));
	$model->setState('filter.access', $access);
        
        // Set application parameters in model
	$app       = JFactory::getApplication();
	$appParams = $app->getParams();
	$model->setState('params', $appParams);
        
        // Set the filters based on the module params
        $model->setState('list.start', 0);
	$model->setState('list.limit', (int) $params->get('count', 5));
	$model->setState('filter.published', 1);
        
//      check type & display respectively
        switch ($params->get('typeid')){
            case '0':

            $items = $model->getItems();
            foreach ($items as &$item)
		{
			$item->slug    = $item->id . ':' . $item->alias;
			$item->catslug = $item->catid . ':' . $item->category_alias;
                        
                        if ($access || in_array($item->access, $authorised))
			{
				// We know that user has the privilege to view the article
				$item->link = JRoute::_(ContentHelperRoute::getArticleRoute($item->slug, $item->catid, $item->language));
			}
			else
			{
				$item->link = JRoute::_('index.php?option=com_users&view=login');
			}
                }

		return $items;
                break;
            
//            case '1':
//                return 'type = 1';
//                
//             // Get a db connection.
//            $db = JFactory::getDbo();
//
//            // Create a new query object.
//            $query = $db->getQuery(true);   
//            
//            //Query the database
//            $query->select($db->quoteName(array('id', 'title', 'created')));
//            $query->from($db->quoteName('#__js_job_jobs'));
//            $query->order('ordering ASC');
//            // Reset the query using our newly populated query object.
//            $db->setQuery($query);
//
//            // Load the results as a list of stdClass objects (see later for more options on retrieving data).
//            $results = $db->loadObjectList();
//            return $results;
        }
        
        
    }
    
    public static function getLatestJobs(){
            // Get a db connection.
            $db = JFactory::getDbo();

            // Create a new query object.
            $query = $db->getQuery(true);  
            
            //Query to the database
            $query->select($db->quoteName(array('jobs.id', 'jobs.title', 'jobs.created', 'jobs.alias', 'jobs.companyid', 'companies.name')));
            $query->from($db->quoteName('#__js_job_jobs', 'jobs'));
            $query->join('LEFT', $db->quoteName('#__js_job_companies', 'companies') . ' ON (' . $db->quoteName('jobs.companyid') . ' = ' . $db->quoteName('companies.id') . ')'
            );
            $query->setLimit(10);
            $query->order('ordering ASC');
            
            // Reset the query using our newly populated query object.
            $db->setQuery($query);

            // Load the results as a list of stdClass objects (see later for more options on retrieving data).
            $results = $db->loadObjectList();
            return $results;
    }
}

