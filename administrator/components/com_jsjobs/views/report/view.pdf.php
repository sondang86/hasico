<?php
/**
 * @Copyright Copyright (C) 2009-2014
 * @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
  + Created by:          Ahmad Bilal
 * Company:     Buruj Solutions
  + Contact:        www.burujsolutions.com , ahmad@burujsolutions.com
 * Created on:  Jan 11, 2009
  ^
  + Project:        JS Jobs
 * File Name:   models/jsjobs.php
  ^
 * Description: Model class for jsjobs data
  ^
 * History:     NONE
  ^
 */

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');

class JSJobsViewReport extends JSView{

    function display($tpl = null) {
        require_once JPATH_COMPONENT_ADMINISTRATOR . '/views/common.php';
        if ($layoutName == 'resume1') {
            $resumeid = JRequest::getVar('rd');
            if (is_numeric($resumeid) == true)
                $result = $this->getJSModel('resume')->getResumeViewbyId($resumeid);
            $this->assignRef('resume', $result[0]);
            $this->assignRef('resume2', $result[1]);
            $this->assignRef('resume3', $result[2]);
            $this->assignRef('fieldsordering', $result[3]);
        }

        $this->assignRef('config', $config);

        $document = JFactory::getDocument();
        $document->setTitle('Resume');
        parent :: display();
    }

}

?>
