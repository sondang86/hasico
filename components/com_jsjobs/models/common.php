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

jimport('joomla.application.component.model');
jimport('joomla.html.html');

$option = JRequest :: getVar('option', 'com_jsjobs');

class JSJobsModelCommon extends JSModel {

    var $_siteurl = null;
    var $_stats = null;

    function __construct() {
        parent :: __construct();
        $this->_siteurl = JURI::root();
        $user = JFactory::getUser();
        $this->_uid = $user->id;
    }

    function b64ForEncode($string) {
        return base64_encode($string);
    }
    function setTheme($theme = '', $css = '') {
        $document = JFactory::getDocument();
        $document->addStyleSheet('components/com_jsjobs/css/style.css' . $css, 'text/css');
        $document->addStyleSheet('components/com_jsjobs/css/style_color.php' . $css, 'text/css');
    }

    function getExtension($str) {
        $i = strrpos($str, ".");
        if (!$i) {
            return "";
        }
        $l = strlen($str) - $i;
        $ext = substr($str, $i + 1, $l);
        return $ext;
    }

    function mpGetstats($employer, $jobseeker, $jobs, $companies, $activejobs, $resumes) {
        if (!$this->_stats) {
            $db = JFactory::getDBO();
            $result = array();
            $curdate = date('Y-m-d');
            if ($employer) {
                $query = "SELECT count(userrole.id) AS totalemployer
                    FROM `#__js_job_userroles` AS userrole
                    WHERE userrole.role = 1";
                $db->setQuery($query);
                $employer = $db->loadResult();
                $result['employer'] = $employer;
            }
            if ($jobseeker) {
                $query = "SELECT count(userrole.id) AS totaljobseeker
                    FROM `#__js_job_userroles` AS userrole
                    WHERE userrole.role = 2";
                $db->setQuery($query);
                $jobseeker = $db->loadResult();
                $result['jobseeker'] = $jobseeker;
            }
            if ($jobs) {
                $query = "SELECT count(job.id) AS totaljobs
                    FROM `#__js_job_jobs` AS job
                    WHERE job.status = 1 ";
                $db->setQuery($query);
                $totaljobs = $db->loadResult();
                $result['totaljobs'] = $totaljobs;
            }
            if ($companies) {
                $query = "SELECT count(company.id) AS totalcomapnies
                    FROM `#__js_job_companies` AS company
                    WHERE company.status = 1 ";
                $db->setQuery($query);
                $totalcompanies = $db->loadResult();
                $result['totalcompanies'] = $totalcompanies;
            }
            if ($activejobs) {
                $query = "SELECT count(job.id) AS totalactivejobs
                    FROM `#__js_job_jobs` AS job
                    WHERE job.status = 1 AND DATE(job.startpublishing) <= " . $db->Quote($curdate) . " AND DATE(job.stoppublishing) >= " . $db->Quote($curdate);
                $db->setQuery($query);
                $tatalactivejobs = $db->loadResult();
                $result['tatalactivejobs'] = $tatalactivejobs;
            }
            if ($resumes) {
                $query = "SELECT count(resume.id) AS totalresume
                    FROM `#__js_job_resume` AS resume
                    WHERE resume.status = 1 ";
                $db->setQuery($query);
                $totalresume = $db->loadResult();
                $result['totalresume'] = $totalresume;
            }
            if ($employer) {
                $query = "SELECT count(userrole.id) AS todayemployer
                    FROM `#__js_job_userroles` AS userrole
                    WHERE userrole.role = 1 AND DATE(userrole.dated) >= " . $db->Quote($curdate);
                $db->setQuery($query);
                $todyemployer = $db->loadResult();
                $result['todyemployer'] = $todyemployer;
            }
            if ($jobseeker) {
                $query = "SELECT count(userrole.id) AS todayjobseeker
                    FROM `#__js_job_userroles` AS userrole
                    WHERE userrole.role = 2 AND DATE(userrole.dated) >= " . $db->Quote($curdate);
                $db->setQuery($query);
                $todyjobseeker = $db->loadResult();
                $result['todyjobseeker'] = $todyjobseeker;
            }
            if ($jobs) {
                $query = "SELECT count(job.id) AS todayjobs
                    FROM `#__js_job_jobs` AS job
                    WHERE job.status = 1 AND DATE(job.startpublishing) >= " . $db->Quote($curdate);
                $db->setQuery($query);
                $todayjobs = $db->loadResult();
                $result['todayjobs'] = $todayjobs;
            }
            if ($companies) {
                $query = "SELECT count(company.id) AS todaycomapnies
                    FROM `#__js_job_companies` AS company
                    WHERE company.status = 1 AND DATE(company.created) >= " . $db->Quote($curdate);
                $db->setQuery($query);
                $todaycompanies = $db->loadResult();
                $result['todaycompanies'] = $todaycompanies;
            }
            if ($activejobs) {
                $query = "SELECT count(job.id) AS todayactivejobs
                    FROM `#__js_job_jobs` AS job
                    WHERE job.status = 1 AND DATE(job.startpublishing) >= " . $db->Quote($curdate);
                $db->setQuery($query);
                $todayactivejobs = $db->loadResult();
                $result['todayactivejobs'] = $todayactivejobs;
            }
            if ($resumes) {
                $query = "SELECT count(resume.id) AS todayresume
                    FROM `#__js_job_resume` AS resume
                    WHERE resume.status = 1 AND DATE(resume.create_date) >= " . $db->Quote($curdate);
                $db->setQuery($query);
                $todayresume = $db->loadResult();
                $result['todayresume'] = $todayresume;
            }


            $this->_stats = $result;
        }
        return $this->_stats;
    }

    function removeSpecialCharacter($string) {
        $string = strtolower($string);
        $string = strip_tags($string, "");
//Strip any unwanted characters
        $string = preg_replace("/[^a-z0-9_\s-]/", "", $string);
//Clean multiple dashes or whitespaces
        $string = preg_replace("/[\s-]+/", " ", $string);
//Convert whitespaces and underscore to dash
        $string = preg_replace("/[\s_]/", "-", $string);
        return $string;
    }

    function getDefaultValue($table) {
        $db = JFactory :: getDBO();

        switch ($table) {
            case "categories":
            case "jobtypes":
            case "jobstatus":
            case "shifts":
            case "heighesteducation":
            case "ages":
            case "careerlevels":
            case "experiences":
            case "salaryrange":
            case "salaryrangetypes":
            case "subcategories":
                $query = "SELECT id FROM `#__js_job_" . $table . "` WHERE isdefault=1";
                $db->setQuery($query);
                $default_id = $db->loadResult();
                if ($default_id)
                    return $default_id;
                else {
                    $query = "SELECT min(id) AS id FROM `#__js_job_" . $table . "`";
                    $db->setQuery($query);
                    $min_id = $db->loadResult();
                    return $min_id;
                }
            case "currencies":
                $query = "SELECT id FROM `#__js_job_" . $table . "` WHERE `default`=1";
                $db->setQuery($query);
                $default_id = $db->loadResult();
                if ($default_id)
                    return $default_id;
                else {
                    $query = "SELECT min(id) AS id FROM `#__js_job_" . $table . "`";
                    $db->setQuery($query);
                    $min_id = $db->loadResult();
                    return $min_id;
                }
                break;
        }
    }

    function getServerSerialNumber() {
        $db = JFactory::getDbo();
        $ip = $_SERVER['SERVER_ADDR'];
        $siteurl = $this->_siteurl;
        $serial_number = "";
        $versioncode = "";
        $query = "SELECT * FROM `#__js_job_config` WHERE configname='server_serial_number' OR configname='versioncode'  ";
        $db->setQuery($query);
        $data = $db->loadObjectList();
        foreach ($data AS $d) {
            if ($d->configname == 'server_serial_number')
                $serial_number = $d->configvalue;
            if ($d->configname == 'versioncode')
                $versioncode = $d->configvalue;
        }
        $data = array('ip' => $ip, 'siteurl' => $siteurl, 'server_serialnumber' => $serial_number, 'versioncode' => $versioncode);
        $jsondata = json_encode($data);
        return $jsondata;
    }

    function getServerid($table, $id) {
        if ($id)
            if (is_numeric($id) === false)
                return false;
        $db = JFactory :: getDBO();
        switch ($table) {
            case "salaryrangetypes";
            case "careerlevels";
            case "experiences";
            case "ages";
            case "currencies";
            case "subcategories";
                $query = "SELECT serverid FROM #__js_job_" . $table . " WHERE status=1 AND id=" . $id;
                break;
            case "salaryrange";
                $query = "SELECT serverid FROM #__js_job_" . $table . " WHERE id=" . $id;
                break;
            case "countries";
            case "states";
            case "cities";
                $query = "SELECT serverid FROM #__js_job_" . $table . " WHERE enabled=1 AND id=" . $id;
                break;
            default:
                $query = "SELECT serverid FROM #__js_job_" . $table . " WHERE isactive=1 AND id=" . $id;
                break;
        }

        $db->setQuery($query);
        $server_id = $db->loadResult();
        return $server_id;
    }

    function getClientId($table, $id) {
        if ($id)
            if (is_numeric($id) === false)
                return false;
        $db = JFactory :: getDBO();
        switch ($table) {
            case "salaryrangetypes";
            case "careerlevels";
            case "experiences";
            case "ages";
            case "currencies";
            case "subcategories";
                $query = "SELECT id FROM #__js_job_" . $table . " WHERE status=1 AND serverid=" . $id;
                break;
            case "salaryrange";
                $query = "SELECT id FROM #__js_job_" . $table . " WHERE serverid=" . $id;
                break;
            case "countries";
            case "states";
            case "cities";
                $query = "SELECT id FROM #__js_job_" . $table . " WHERE enabled=1 AND serverid=" . $id;
                break;
            default:
                $query = "SELECT id FROM #__js_job_" . $table . " WHERE isactive=1 AND serverid=" . $id;
                break;
        }

        $db->setQuery($query);
        $server_id = $db->loadResult();
        return $server_id;
    }

    function getClientAuthenticationKey() {
        $job_sharing_config = $this->getJSModel('configurations')->getConfigByFor('jobsharing');
        $client_auth_key = $job_sharing_config['authentication_client_key'];
        return $client_auth_key;
    }

    function checkAssignGroup($uid, $groupval) {
        if (is_numeric($uid) === false)
            return false;
        if (is_numeric($groupval) === false)
            return false;
        $db = $this->getDBO();
        $query = "SELECT  COUNT(user_id) FROM `#__user_usergroup_map` WHERE user_id=" . $uid . " AND group_id=" . $groupval;
        $db->setQuery($query);
        $alreadyassign = $db->loadResult();
        if ($alreadyassign > 0)
            return true;
        else
            return false;
    }

    function getRequiredTravel($title) {
        $requiredtravel = array();
        if ($title)
            $requiredtravel[] = array('value' => '', 'text' => $title);
        $requiredtravel[] = array('value' => 1, 'text' => JText::_('JS_NOT_REQUIRED'));
        $requiredtravel[] = array('value' => 2, 'text' => JText::_('JS_25_PER'));
        $requiredtravel[] = array('value' => 3, 'text' => JText::_('JS_50_PER'));
        $requiredtravel[] = array('value' => 4, 'text' => JText::_('JS_75_PER'));
        $requiredtravel[] = array('value' => 5, 'text' => JText::_('JS_100_PER'));
        return $requiredtravel;
    }

    function getGender($title) {
        $gender = array();
        if ($title)
            $gender[] = array('value' => '', 'text' => $title);
        $gender[] = array('value' => 1, 'text' => JText::_('JS_MALE'));
        $gender[] = array('value' => 2, 'text' => JText::_('JS_FEMALE'));
        return $gender;
    }

    public function spamCheckRandom() {
        $pw = '';
// first character has to be a letter
        $characters = range('a', 'z');
        $pw .= $characters[mt_rand(0, 25)];
// other characters arbitrarily
        $numbers = range(0, 9);
        $characters = array_merge($characters, $numbers);
        $pw_length = mt_rand(4, 12);
        for ($i = 0; $i < $pw_length; $i++) {
            $pw .= $characters[mt_rand(0, 35)];
        }
        return $pw;
    }

    function performChecks() {
        $request = JRequest::get();
        $session = JFactory::getSession();
        $type_calc = true;
        if ($type_calc) {
            if ($session->get('jsjobs_rot13', null, 'jsjobs_checkspamcalc') == 1) {
                $spamcheckresult = base64_decode(str_rot13($session->get('jsjobs_spamcheckresult', null, 'jsjobs_checkspamcalc')));
            } else {
                $spamcheckresult = base64_decode($session->get('jsjobs_spamcheckresult', null, 'jsjobs_checkspamcalc'));
            }
            $spamcheck = JRequest::getInt($session->get('jsjobs_spamcheckid', null, 'jsjobs_checkspamcalc'), '', 'post');
            $session->clear('jsjobs_rot13', 'jsjobs_checkspamcalc');
            $session->clear('jsjobs_spamcheckid', 'jsjobs_checkspamcalc');
            $session->clear('jsjobs_spamcheckresult', 'jsjobs_checkspamcalc');

            if (!is_numeric($spamcheckresult) || $spamcheckresult != $spamcheck) {
                return false; // Failed
            }
        }
// Hidden field
        $type_hidden = 0;
        if ($type_hidden) {
            $hidden_field = $session->get('hidden_field', null, 'checkspamcalc');
            $session->clear('hidden_field', 'checkspamcalc');

            if (JRequest::getVar($hidden_field, '', 'post')) {
                return false; // Hidden field was filled out - failed
            }
        }
// Time lock
        $type_time = 0;
        if ($type_time) {
            $time = $session->get('time', null, 'checkspamcalc');
            $session->clear('time', 'checkspamcalc');

            if (time() - $this->params->get('type_time_sec') <= $time) {
                return false; // Submitted too fast - failed
            }
        }
// Own Question
// Conversion to lower case
        $session->clear('ip', 'jsjobs_checkspamcalc');
        $session->clear('saved_data', 'jsjobs_checkspamcalc');

        return true;
    }

    function makeDir($path) {
        if (!file_exists($path)) { // create directory
            mkdir($path, 0755);
            $ourFileName = $path . '/index.html';
            $ourFileHandle = fopen($ourFileName, 'w') or die("can't open file");
            fclose($ourFileHandle);
        }
    }

    function checkUserDetail($val, $for) {
        $db = $this->getDBO();
        $query = "SELECT COUNT(id) FROM `#__users` WHERE $for =" . $db->quote($val);
        $db->setQuery($query);
        $total = $db->loadResult();
        return $total;
    }

    function parseId($value) {
        $ids = explode("-", $value);
        $count = count($ids);
        $id = (int) $ids[($count - 1)];
        return $id;
    }

    function checkImageFileExtensions($file_name, $file_tmp, $image_extension_allow) {
        $allow_image_extension = explode(',', $image_extension_allow);
        if ($file_name != '' AND $file_tmp != "") {
            $ext = $this->getJSModel('common')->getExtension($file_name);
            $ext = strtolower($ext);
            if (in_array($ext, $allow_image_extension))
                return 1;
            else
                return 6; //file type mistmathc
        }
    }

    function checkDocumentFileExtensions($file_name, $file_tmp, $document_extension_allow) {
        $allow_document_extension = explode(',', strtolower($document_extension_allow));
        if ($file_name != '' AND $file_tmp != "") {
            $ext = $this->getJSModel('common')->getExtension($file_name);
            $ext = strtolower($ext);
            if (in_array($ext, $allow_document_extension))
                return 1;
            else
                return 6; //file type mistmathc
        }
    }

    function getMiniMax($title) {
        $minimax = array();
        if ($title)
            $minimax[] = array('value' => JText::_(''), 'text' => $title);
        $minimax[] = array('value' => 1, 'text' => JText::_('JS_MINIMUM'));
        $minimax[] = array('value' => 2, 'text' => JText::_('JS_MAXIMUM'));

        return $minimax;
    }
    function getCaptchaForForm() {
        $session = JFactory::getSession();
        $rand = $this->spamCheckRandom();
        $session->set('jsjobs_spamcheckid', $rand, 'jsjobs_checkspamcalc');
        $session->set('jsjobs_rot13', mt_rand(0, 1), 'jsjobs_checkspamcalc');
        // Determine operator
        $operator = 2;
        if ($operator == 2) {
            $tcalc = mt_rand(1, 2);
        }
        $max_value = 20;
        $negativ = 0;

        $operend_1 = mt_rand(1, $max_value);
        $operend_2 = mt_rand(1, $max_value);
        $operand = 2;
        if ($operand == 3) {
            $operend_3 = mt_rand(0, $max_value);
        }

        if ($tcalc == 1) { // Addition
            if ($session->get('jsjobs_rot13', null, 'jsjobs_checkspamcalc') == 1) { // ROT13 coding
                if ($operand == 2) {
                    $session->set('jsjobs_spamcheckresult', str_rot13(base64_encode($operend_1 + $operend_2)), 'jsjobs_checkspamcalc');
                } elseif ($operand == 3) {
                    $session->set('jsjobs_spamcheckresult', str_rot13(base64_encode($operend_1 + $operend_2 + $operend_3)), 'jsjobs_checkspamcalc');
                }
            } else {
                if ($operand == 2) {
                    $session->set('jsjobs_spamcheckresult', base64_encode($operend_1 + $operend_2), 'jsjobs_checkspamcalc');
                } elseif ($operand == 3) {
                    $session->set('jsjobs_spamcheckresult', base64_encode($operend_1 + $operend_2 + $operend_3), 'jsjobs_checkspamcalc');
                }
            }
        } elseif ($tcalc == 2) { // Subtraction
            if ($session->get('jsjobs_rot13', null, 'jsjobs_checkspamcalc') == 1) {
                if ($operand == 2) {
                    $session->set('jsjobs_spamcheckresult', str_rot13(base64_encode($operend_1 - $operend_2)), 'jsjobs_checkspamcalc');
                } elseif ($operand == 3) {
                    $session->set('jsjobs_spamcheckresult', str_rot13(base64_encode($operend_1 - $operend_2 - $operend_3)), 'jsjobs_checkspamcalc');
                }
            } else {
                if ($operand == 2) {
                    $session->set('jsjobs_spamcheckresult', base64_encode($operend_1 - $operend_2), 'jsjobs_checkspamcalc');
                } elseif ($operand == 3) {
                    $session->set('jsjobs_spamcheckresult', base64_encode($operend_1 - $operend_2 - $operend_3), 'jsjobs_checkspamcalc');
                }
            }
        }
        $add_string = "";
        $add_string .= '<div><label for="' . $session->get('jsjobs_spamcheckid', null, 'jsjobs_checkspamcalc') . '">';

        $add_string .= JText::_('SPAM_CHECK') . ': ';

        if ($tcalc == 1) {
            $converttostring = 0;
            if ($converttostring == 1) {
                if ($operand == 2) {
                    $add_string .= $this->converttostring($operend_1) . ' ' . JText::_('PLUS') . ' ' . $this->converttostring($operend_2) . ' ' . JText::_('EQUALS') . ' ';
                } elseif ($operand == 3) {
                    $add_string .= $this->converttostring($operend_1) . ' ' . JText::_('PLUS') . ' ' . $this->converttostring($operend_2) . ' ' . JText::_('PLUS') . ' ' . $this->converttostring($operend_3) . ' ' . JText::_('EQUALS') . ' ';
                }
            } else {
                if ($operand == 2) {
                    $add_string .= $operend_1 . ' ' . JText::_('PLUS') . ' ' . $operend_2 . ' ' . JText::_('EQUALS') . ' ';
                } elseif ($operand == 3) {
                    $add_string .= $operend_1 . ' ' . JText::_('PLUS') . ' ' . $operend_2 . ' ' . JText::_('PLUS') . ' ' . $operend_3 . ' ' . JText::_('EQUALS') . ' ';
                }
            }
        } elseif ($tcalc == 2) {
            $converttostring = 0;
            if ($converttostring == 1) {
                if ($operand == 2) {
                    $add_string .= $this->converttostring($operend_1) . ' ' . JText::_('MINUS') . ' ' . $this->converttostring($operend_2) . ' ' . JText::_('EQUALS') . ' ';
                } elseif ($operand == 3) {
                    $add_string .= $this->converttostring($operend_1) . ' ' . JText::_('MINUS') . ' ' . $this->converttostring($operend_2) . ' ' . JText::_('MINUS') . ' ' . $this->converttostring($operend_3) . ' ' . JText::_('EQUALS') . ' ';
                }
            } else {
                if ($operand == 2) {
                    $add_string .= $operend_1 . ' ' . JText::_('MINUS') . ' ' . $operend_2 . ' ' . JText::_('EQUALS') . ' ';
                } elseif ($operand == 3) {
                    $add_string .= $operend_1 . ' ' . JText::_('MINUS') . ' ' . $operend_2 . ' ' . JText::_('MINUS') . ' ' . $operend_3 . ' ' . JText::_('EQUALS') . ' ';
                }
            }
        }

        $add_string .= '</label>';
        $add_string .= '<input type="text" name="' . $session->get('jsjobs_spamcheckid', null, 'jsjobs_checkspamcalc') . '" id="' . $session->get('jsjobs_spamcheckid', null, 'jsjobs_checkspamcalc') . '" size="3" class="inputbox ' . $rand . ' validate-numeric required" value="" required="required" />';
        $add_string .= '</div>';

        return $add_string;
    }

}

?>