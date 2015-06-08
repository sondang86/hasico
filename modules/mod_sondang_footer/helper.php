<?php
/**
 * Helper class for Hello World! module
 * 
 * @package    Joomla.Tutorials
 * @subpackage Modules
 * @link http://docs.joomla.org/J3.x:Creating_a_simple_module/Developing_a_Basic_Module
 * @license        GNU/GPL, see LICENSE.php
 * mod_helloworld is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 */

require_once JPATH_SITE . '/components/com_content/helpers/route.php';

JModelLegacy::addIncludePath(JPATH_SITE . '/components/com_content/models', 'ContentModel');

abstract class FooterHelper
{
    /**
     * Retrieves the hello message
     *
     * @param   array  $params An object containing the module parameters
     *
     * @access public
     */    
    public static function getPopularArticles($params)
    {
        // Get an instance of the generic articles model
	$model = JModelLegacy::getInstance('Articles', 'ContentModel', array('ignore_request' => true));

	// Set application parameters in model
	$app = JFactory::getApplication();
	$appParams = $app->getParams();
	$model->setState('params', $appParams);
        
        // Access filter
	$access = !JComponentHelper::getParams('com_content')->get('show_noauth');
	$authorised = JAccess::getAuthorisedViewLevels(JFactory::getUser()->get('id'));
	$model->setState('filter.access', $access);
        
        // Set the filters based on the module params
	$model->setState('list.limit', (int) $params->get('count', 5));
        
        $items = $model->getItems();
        
        foreach ($items as &$item)
		{
			$item->slug = $item->id . ':' . $item->alias;
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
    }
}