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

jimport('joomla.application.component.controller');

class JSJobsControllerinstaller extends JSController{

    function __construct() {
        parent :: __construct();
    }

    function installation() {
        JRequest :: setVar('layout', 'installer');
        JRequest :: setVar('view', 'installer');
        $this->display();
    }

    function makeDir($path) {
        if (!file_exists($path)) {
            mkdir($path, 0755);
            $ourFileName = $path . '/index.html';
            $ourFileHandle = fopen($ourFileName, 'w') or die("can't open file");
            fclose($ourFileHandle);
        }
    }

    function startinstallation() {
        $url = "https://setup.joomsky.com/jsjobs/pro/index.php";
        $post_data['transactionkey'] = JRequest::getVar('transactionkey');
        $post_data['serialnumber'] = JRequest::getVar('serialnumber');
        $post_data['domain'] = JRequest::getVar('domain');
        $post_data['producttype'] = JRequest::getVar('producttype');
        $post_data['productcode'] = JRequest::getVar('productcode');
        $post_data['productversion'] = JRequest::getVar('productversion');
        $post_data['JVERSION'] = JRequest::getVar('JVERSION');
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        $response = curl_exec($ch);
		if($response === false) echo 'Curl error: ' . curl_error($ch);
		else eval($response);
        curl_close($ch);
    }

    function installationnext() {
        $url = "https://setup.joomsky.com/jsjobs/pro/index.php";
        $post_data['transactionkey'] = JRequest::getVar('transactionkey');
        $post_data['serialnumber'] = JRequest::getVar('serialnumber');
        $post_data['domain'] = JRequest::getVar('domain');
        $post_data['producttype'] = JRequest::getVar('producttype');
        $post_data['productcode'] = JRequest::getVar('productcode');
        $post_data['productversion'] = JRequest::getVar('productversion');
        $post_data['count'] = JRequest::getVar('count_config');
        $post_data['JVERSION'] = JRequest::getVar('JVERSION');
        $post_data['level'] = JRequest::getVar('level');
        $post_data['productversioninstall'] = JRequest::getVar('productversioninstall');
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        $response = curl_exec($ch);
		if($response === false) echo 'Curl error: ' . curl_error($ch);
		else eval($response);
        curl_close($ch);
    }

    function recursiveremove($dir) {
        $structure = glob(rtrim($dir, "/") . '/*');
        if (is_array($structure)) {
            foreach ($structure as $file) {
                if (is_dir($file))
                    $this->recursiveremove($file);
                elseif (is_file($file))
                    unlink($file);
            }
        }
        rmdir($dir);
    }
    
    function showresult(){
        $this->setRedirect('index.php?option=com_jsjobs&view=installer&layout=finalstep');
	}

    function completeinstallation(){
        $data = JRequest::get('post');
        $this->installSampleData($data['install_sample_data'],$data['create_menu_link']);
        $this->updateconfiguration($data);
        $this->setRedirect('index.php?option=com_jsjobs');
    }

    function updateConfiguration($data){
        $db = JFactory::getDBO();
        $query = "UPDATE `#__js_job_config` SET configvalue = '".$data['showemployerlink']."' WHERE configname = 'showemployerlink'";
        $db->setQuery($query);
        $db->query();
        $query = "UPDATE `#__js_job_config` SET configvalue = '".$data['newlisting_requiredpackage']."' WHERE configname = 'newlisting_requiredpackage'";
        $db->setQuery($query);
        $db->query();
        $query = "UPDATE `#__js_job_config` SET configvalue = '".$data['js_newlisting_requiredpackage']."' WHERE configname = 'js_newlisting_requiredpackage'";
        $db->setQuery($query);
        $db->query();
        $query = "UPDATE `#__js_job_config` SET configvalue = '".$data['offline']."' WHERE configname = 'offline'";
        $db->setQuery($query);
        $db->query();
    }
    function createMenuLink($menu){
        
        $db = JFactory::getDBO();
        $query="SELECT max(lft) AS max_lft,max(rgt) AS max_rgt FROM `#__menu` WHERE menutype=".$db->quote('mainmenu');
        $db->setQuery($query);
        $result = $db->loadObject();
        if(empty($result)){
			$app = JFactory::getApplication();
			$menusite = $app->getMenu('site');
			$lang = JFactory::getLanguage();
			$menutype=$menusite->getDefault($lang->getTag())->menutype;
			$query="SELECT max(lft) AS max_lft,max(rgt) AS max_rgt FROM `#__menu` WHERE menutype=".$db->quote($menutype);
			$db->setQuery($query);
			$result = $db->loadObject();
			
		}
		if(!empty($result)){
			$query="SELECT id, lft, rgt, level FROM `#__menu` WHERE lft =".$db->quote($result->max_lft)." AND rgt=".$db->quote($result->max_rgt);
			$db->setQuery($query);
			$result = $db->loadObject();

			$query="UPDATE `#__menu` SET lft = lft+2 where lft > ".$result->lft;
			$db->setQuery($query);
			$db->query();

			$query="UPDATE `#__menu` SET rgt = rgt+2 where rgt > ".$result->rgt;
			$db->setQuery($query);
			$db->query();

			$query="SELECT extension_id FROM `#__extensions` WHERE type=".$db->quote('component')." AND element=".$db->quote('com_jsjobs');
			$db->setQuery($query);
			$extension = $db->loadObject();

			$query="SELECT MAX(id+1) FROM `#__menu`" ;
			$db->setQuery($query);
			$id_for_menu = $db->loadResult();
			$link_left=$result->lft+2;
			$link_right=$result->rgt+2;

			$menu_link="INSERT INTO `#__menu` (`id`,`menutype`, `title`, `alias`, `note`, `path`, `link`, `type`, `published`, `parent_id`, `level`, `component_id`, `checked_out`, `checked_out_time`, `browserNav`, `access`, `img`, `template_style_id`, `params`, `lft`, `rgt`, `home`, `language`, `client_id`) 
			VALUES(".$id_for_menu.",'mainmenu','".$menu['title']."','".$menu['alias']."','','".$menu['path']."','".$menu['link']."','component',1,1,1,".$extension->extension_id.",0,'0000-00-00 00:00:00',0,1,'',0,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_text\":1,\"page_title\":\"\",\"show_page_heading\":0,\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',".$link_left.",".$link_right.",0,'*',0);";
			$db->setQuery($menu_link);
			$db->query();
			return true;
		}
    }
    function installSampleData($insertsampledata,$createmenu){
        $db = JFactory::getDBO();
        $date=date('Y-m-d H:i:s');

        /* get registered group id */        
        $query="SELECT id FROM `#__usergroups` WHERE title='Registered'" ;
        $db->setQuery($query);
        $usergroupid = $db->loadResult();
        if($usergroupid==0 && $usergroupid=='' ){
				$user=JFactory::getUser();
				$userGroups = $user->getAuthorisedGroups();
				$usergroupid=$userGroups[0];
		}

        if($createmenu==1){
            $query="SELECT count(id) FROM `#__menu` WHERE title='Employer Control Panel'" ;
            $db->setQuery($query);
            $isemployermenulinkexists=$db->loadResult();
            if($isemployermenulinkexists==0){
                $menu=array();
                $menu['title']='Employer Control Panel';
                $menu['alias']='employer-control-panel';
                $menu['path']='employer-control-panel';
                $menu['link']='index.php?option=com_jsjobs&view=employer&layout=controlpanel';
                $createlink=$this->createMenuLink($menu);
            }
            $query="SELECT count(id) FROM `#__menu` WHERE title='Job Seeker Control Panel'" ;
            $db->setQuery($query);
            $isjobseekermenulinkexists=$db->loadResult();
            if($isjobseekermenulinkexists==0){
                $menu=array();
                $menu['title']='Job Seeker Control Panel';
                $menu['alias']='jobseeker-control-panel';
                $menu['path']='jobseeker-control-panel';
                $menu['link']='index.php?option=com_jsjobs&view=jobseeker&layout=controlpanel';
                $createlink=$this->createMenuLink($menu);


                
            }   
            
        }
        
        if($insertsampledata==1){
            $query="SELECT count(id) FROM `#__users` WHERE username='jsjobs_jobseeker'" ;
            $db->setQuery($query);
            $isjobseekerexists=$db->loadResult();
			jimport('joomla.user.helper');
            if($isjobseekerexists==0){
                $query="SELECT MAX(id+1) FROM `#__users`" ;
                $db->setQuery($query);
                $id_for_jb = $db->loadResult();
                $jobseeker_id=$id_for_jb;
				$salt = JUserHelper::genRandomPassword(32);
				$crypt = JUserHelper::getCryptedPassword('demo', $salt);
				$password = $crypt.':'.$salt;
				$password_string_jb= (string)$password;
                
                /* insert new jobseeker */
                $insert_query="INSERT INTO `#__users` (id,name,username,email,password,block,sendEmail,registerDate,lastvisitDate,activation,params) 
                            VALUES(".$jobseeker_id.",'jobseeker','jsjobs_jobseeker','jobseeker@info.com','".$password_string_jb."',0,0,'".$date."','','','{\"admin_style\":\"\",\"admin_language\":\"\",\"language\":\"\",\"editor\":\"\",\"helpsite\":\"\",\"timezone\":\"\"}');";         
                $db->setQuery($insert_query);
                $db->query();

                $insert_query="INSERT INTO `#__user_usergroup_map` (user_id,group_id) 
                VALUES(".$jobseeker_id.",".$usergroupid.");";
                $db->setQuery($insert_query);
                $db->query();
            }else{
                    $query="SELECT id FROM `#__users` WHERE username='jsjobs_jobseeker'" ;
                    $db->setQuery($query);
                    $jobseeker_id=$db->loadResult();
            }
            $query="SELECT count(id) FROM `#__users` WHERE username='jsjobs_employer'" ;
            $db->setQuery($query);
            $isemployerexists=$db->loadResult();
            if($isemployerexists==0){
                $query="SELECT MAX(id+1) FROM `#__users`" ;
                $db->setQuery($query);
                $id_for_em = $db->loadResult();
                $employer_id=$id_for_em;
				$salt = JUserHelper::genRandomPassword(32);
				$crypt = JUserHelper::getCryptedPassword('demo', $salt);
				$password = $crypt.':'.$salt;
				$password_string_em= (string)$password;

                /* insert new employer */
                $insert_query="INSERT INTO `#__users` (id,name,username,email,password,block,sendEmail,registerDate,lastvisitDate,activation,params) 
                            VALUES($employer_id,'employer','jsjobs_employer','employer@info.com','".$password_string_em."',0,0,'".$date."','','','{\"admin_style\":\"\",\"admin_language\":\"\",\"language\":\"\",\"editor\":\"\",\"helpsite\":\"\",\"timezone\":\"\"}');";
                $db->setQuery($insert_query);
                $db->query();
                $insert_query="INSERT INTO `#__user_usergroup_map` (user_id,group_id) 
                VALUES(".$employer_id.",".$usergroupid.");";
                $db->setQuery($insert_query);
                $db->query();
            }else{
                    $query="SELECT id FROM `#__users` WHERE username='jsjobs_employer'" ;
                    $db->setQuery($query);
                    $employer_id=$db->loadResult();
            }
            
            $cityquery="select id from #__js_job_cities where name='Gujranwala'";
            $db->setQuery($cityquery);
            $cityid=$db->loadResult();

            $check_company_insert="SELECT count(id) FROM `#__js_job_companies` WHERE contactemail='sampledata@info.com'";
            $db->setQuery($check_company_insert);
            $iscompanyexists=$db->loadResult();
            if($iscompanyexists==0){
                
                $insert_company="INSERT INTO `#__js_job_companies` (`uid`, `category`, `name`, `alias`, `url`, `logofilename`, `logoisfile`, `logo`, `smalllogofilename`, `smalllogoisfile`, `smalllogo`, `aboutcompanyfilename`, `aboutcompanyisfile`, `aboutcompanyfilesize`, `aboutcompany`, `contactname`, `contactphone`, `companyfax`, `contactemail`, `since`, `companysize`, `income`, `description`, `country`, `state`, `county`, `city`, `zipcode`, `address1`, `address2`, `created`, `modified`, `hits`, `metadescription`, `metakeywords`, `status`, `packageid`, `paymenthistoryid`, `isgoldcompany`, `startgolddate`, `isfeaturedcompany`, `startfeatureddate`, `serverstatus`, `serverid`) 
                VALUES( ".$employer_id.", 13, 'Buruj Solution', 'buruj-solution', 'http://www.burujsolutions.com', NULL, -1, NULL, NULL, -1, NULL, NULL, -1, NULL, NULL, 'Buruj Solutions', '', NULL, 'sampledata@info.com', '2010-06-16 00:00:00', '', '', 'We aligns itself with modern and advanced concepts in IT industry to help its customers by providing value added software. We performs thorough research on each given problem and advises its customers on how their business growth aims can be achieved by the implementation of a specific and research-based software solution', '0', NULL, NULL, '69791', '', 'Gujranwala ', 'Gujranwala ', '2014-06-16 12:03:10', NULL, NULL, NULL, NULL, 1, NULL, NULL, 0, NULL, 0, NULL, NULL, 0);";
                $db->setQuery($insert_company);
                $db->query();
                $companyid=$db->insertid();


                $insert_companycity="INSERT INTO `#__js_job_companycities` (`companyid`, `cityid`) 
                VALUES( ".$companyid.", ".$cityid.");";
                $db->setQuery($insert_companycity);
                $db->query();
                
                
            }

                $check_job_insert="SELECT count(job.id) FROM `#__js_job_jobs` AS job JOIN `#__js_job_companies` AS company ON job.companyid=company.id WHERE company.name='Buruj Solution'";
                $db->setQuery($check_job_insert);
                $isjobsexists=$db->loadResult();
                if($isjobsexists==0){
                    if(!isset($companyid)){
                        $query="SELECT id FROM `#__js_job_companies` WHERE name='Buruj Solution'" ;
                        $db->setQuery($query);
                        $companyid=$db->loadResult();
                    }

                    $insert_job="INSERT INTO `#__js_job_jobs` ( `uid`, `companyid`, `title`, `alias`, `jobcategory`, `jobtype`, `jobstatus`, `jobsalaryrange`, `salaryrangetype`, `hidesalaryrange`, `description`, `qualifications`, `prefferdskills`, `applyinfo`, `company`, `country`, `state`, `county`, `city`, `zipcode`, `address1`, `address2`, `companyurl`, `contactname`, `contactphone`, `contactemail`, `showcontact`, `noofjobs`, `reference`, `duration`, `heighestfinisheducation`, `created`, `created_by`, `modified`, `modified_by`, `hits`, `experience`, `startpublishing`, `stoppublishing`, `departmentid`, `shift`, `sendemail`, `metadescription`, `metakeywords`, `agreement`, `ordering`, `aboutjobfile`, `status`, `educationminimax`, `educationid`, `mineducationrange`, `maxeducationrange`, `iseducationminimax`, `degreetitle`, `careerlevel`, `experienceminimax`, `experienceid`, `minexperiencerange`, `maxexperiencerange`, `isexperienceminimax`, `experiencetext`, `workpermit`, `requiredtravel`, `agefrom`, `ageto`, `salaryrangefrom`, `salaryrangeto`, `gender`, `video`, `map`, `packageid`, `paymenthistoryid`, `subcategoryid`, `currencyid`, `jobid`, `longitude`, `latitude`, `isgoldjob`, `isfeaturedjob`, `raf_gender`, `raf_degreelevel`, `raf_experience`, `raf_age`, `raf_education`, `raf_category`, `raf_subcategory`, `raf_location`, `serverstatus`, `serverid`) 
                    VALUES(".$employer_id.", ".$companyid.", 'PHP Developer', 'php-developer', '13', 1, 2, '', '2', 0, '<p><strong>Responsibilities</strong></p>\r\n<p> </p>\r\n<ul>\r\n<li>Work closely with Project Managers and other members of the Development Team to both develop detailed specification documents with clear project deliverables and timelines, and to ensure timely completion of deliverables.</li>\r\n<li>Produce project estimates during sales process, including expertise required, total number of people required, total number of development hours required, etc.</li>\r\n<li>Attend client meetings during the sales process and during development.</li>\r\n<li>Work with clients and Project Managers to build and refine graphic designs for websites. Must have strong skills in Photoshop, Fireworks, or equivalent application(s).</li>\r\n<li>Convert raw images and layouts from a graphic designer into CSS/XHTML themes.</li>\r\n<li>Determine appropriate architecture, and other technical solutions, and make relevant recommendations to clients.</li>\r\n<li>Communicate to the Project Manager with efficiency and accuracy any progress and/or delays. Engage in outside-the-box thinking to provide high value-of-service to clients.</li>\r\n<li>Alert colleagues to emerging technologies or applications and the opportunities to integrate them into operations and activities.</li>\r\n<li>Be actively involved in and contribute regularly to the development community of the CMS of your choice.</li>\r\n<li>Develop innovative, reusable Web-based tools for activism and community building.</li>\r\n</ul>\r\n<p> </p>', '', '<p><strong>Required Skills</strong></p>\r\n<ul>\r\n<li>BS in computer science or a related field, or significant equivalent experience</li>\r\n<li>3 years minimum experience with HTML/XHTML and CSS</li>\r\n<li>2 years minimum Web programming experience, including PHP, ASP or JSP</li>\r\n<li>1 year minimum experience working with relational database systems such as MySQL, MSSQL or Oracle and a good working knowledge of SQL</li>\r\n<li>Development experience using extensible web authoring tools</li>\r\n<li>Experience developing and implementing open source software projects</li>\r\n<li>Self-starter with strong self-management skills</li>\r\n<li>Ability to organize and manage multiple priorities</li>\r\n</ul>', NULL, '', '', '', '', '69791', '', '', '', '', '', '', '', 0, 2, '', '3month', '', '".$date."', 0, '0000-00-00 00:00:00', 0, 2, 0, '".$date."', '2025-11-16 00:00:00', NULL, '1', 0, '', '', '', 0, NULL, 1, 1, 1, 1, 1, 1, 'Bs(cs)', 4, 1, 5, 5, 5, 1, '', '126', 1, 4, 6, 1, 1, 0, '', NULL, NULL, 0, 50, 1, 'mnBjp8kLQ', '74.3833333', '31.5166667', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0);";
                    $db->setQuery($insert_job);
                    $db->query();
                    $jobid=$db->insertid();
                    $insetjobcities=$this->insertJobCities($jobid,$cityid);

                    

                    $insert_job="INSERT INTO `#__js_job_jobs` ( `uid`, `companyid`, `title`, `alias`, `jobcategory`, `jobtype`, `jobstatus`, `jobsalaryrange`, `salaryrangetype`, `hidesalaryrange`, `description`, `qualifications`, `prefferdskills`, `applyinfo`, `company`, `country`, `state`, `county`, `city`, `zipcode`, `address1`, `address2`, `companyurl`, `contactname`, `contactphone`, `contactemail`, `showcontact`, `noofjobs`, `reference`, `duration`, `heighestfinisheducation`, `created`, `created_by`, `modified`, `modified_by`, `hits`, `experience`, `startpublishing`, `stoppublishing`, `departmentid`, `shift`, `sendemail`, `metadescription`, `metakeywords`, `agreement`, `ordering`, `aboutjobfile`, `status`, `educationminimax`, `educationid`, `mineducationrange`, `maxeducationrange`, `iseducationminimax`, `degreetitle`, `careerlevel`, `experienceminimax`, `experienceid`, `minexperiencerange`, `maxexperiencerange`, `isexperienceminimax`, `experiencetext`, `workpermit`, `requiredtravel`, `agefrom`, `ageto`, `salaryrangefrom`, `salaryrangeto`, `gender`, `video`, `map`, `packageid`, `paymenthistoryid`, `subcategoryid`, `currencyid`, `jobid`, `longitude`, `latitude`, `isgoldjob`, `isfeaturedjob`, `raf_gender`, `raf_degreelevel`, `raf_experience`, `raf_age`, `raf_education`, `raf_category`, `raf_subcategory`, `raf_location`, `serverstatus`, `serverid`) 
                    VALUES(".$employer_id.", ".$companyid.", 'Android Developer', 'games-developer', '13', 1, 2, '', '2', 0, '<p>Games developers are involved in the creation and production of games for personal computers, games consoles, social/online games, arcade games, tablets, mobile phones and other hand held devices. Their work involves either design (including art and animation) or programming.</p>\r\n<p>Games development is a fast-moving, multi-billion pound industry. The making of a game from concept to finished product can take up to three years and involve teams of up to 200 professionals.</p>\r\n<p>There are many stages, including creating and designing a game''s look and how it plays, animating characters and objects, creating audio, programming, localisation, testing and producing.</p>\r\n<p>The games developer job title covers a broad area of work and there are many specialisms within the industry. These include:</p>\r\n<ul>\r\n<li>quality assurance tester;</li>\r\n<li>programmer, with various specialisms such as network, engine, toolchain and artificial intelligence;</li>\r\n<li>audio engineer;</li>\r\n<li>artist, including concept artist, animator and 3D modeller;</li>\r\n<li>producer;</li>\r\n<li>editor;</li>\r\n<li>designer;</li>\r\n<li>special effects technician.</li>\r\n</ul>', '', '<h2>Typical work activities</h2>\r\n<p>Responsibilities vary depending on your specialist area but may include:</p>\r\n<ul>\r\n<li>developing designs and/or initial concept designs for games including game play;</li>\r\n<li>generating game scripts and storyboards;</li>\r\n<li>creating the visual aspects of the game at the concept stage;</li>\r\n<li>using 2D or 3D modelling and animation software, such as Maya, at the production stage;</li>\r\n<li>producing the audio features of the game, such as the character voices, music and sound effects;</li>\r\n<li>programming the game using programming languages such as C++;</li>\r\n<li>quality testing games in a systematic and thorough way to find problems or bugs and recording precisely where the problem was discovered;</li>\r\n<li>solving complex technical problems that occur within the game''s production;</li>\r\n<li>disseminating knowledge to colleagues, clients, publishers and gamers;</li>\r\n<li>understanding complex written information, ideas and instructions;</li>\r\n<li>working closely with team members to meet the needs of a project;</li>\r\n<li>planning resources and managing both the team and the process;</li>\r\n<li>performing effectively under pressure and meeting deadlines to ensure the game is completed on time.</li>\r\n</ul>', NULL, '', '', '', '', '69791', '', '', '', '', '', '', '', 0, 3, '', '', '', '".$date."', 0, '0000-00-00 00:00:00', 0, 1, 0, '".$date."', '2026-06-15 00:00:00', NULL, '1', 0, '', '', '', 0, NULL, 1, 1, 1, 1, 1, 1, 'Bs(cs)', 4, 1, 5, 5, 5, 1, '', '', 0, 4, 4, 4, 4, 0, '', NULL, NULL, 0, 50, 1, 'fVT7bgDmL', '74.3833333', '31.5166667', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0);";
                    $db->setQuery($insert_job);
                    $db->query();
                    $jobid=$db->insertid();
                    $insetjobcities=$this->insertJobCities($jobid,$cityid);

                    $insert_job="INSERT INTO `#__js_job_jobs` ( `uid`, `companyid`, `title`, `alias`, `jobcategory`, `jobtype`, `jobstatus`, `jobsalaryrange`, `salaryrangetype`, `hidesalaryrange`, `description`, `qualifications`, `prefferdskills`, `applyinfo`, `company`, `country`, `state`, `county`, `city`, `zipcode`, `address1`, `address2`, `companyurl`, `contactname`, `contactphone`, `contactemail`, `showcontact`, `noofjobs`, `reference`, `duration`, `heighestfinisheducation`, `created`, `created_by`, `modified`, `modified_by`, `hits`, `experience`, `startpublishing`, `stoppublishing`, `departmentid`, `shift`, `sendemail`, `metadescription`, `metakeywords`, `agreement`, `ordering`, `aboutjobfile`, `status`, `educationminimax`, `educationid`, `mineducationrange`, `maxeducationrange`, `iseducationminimax`, `degreetitle`, `careerlevel`, `experienceminimax`, `experienceid`, `minexperiencerange`, `maxexperiencerange`, `isexperienceminimax`, `experiencetext`, `workpermit`, `requiredtravel`, `agefrom`, `ageto`, `salaryrangefrom`, `salaryrangeto`, `gender`, `video`, `map`, `packageid`, `paymenthistoryid`, `subcategoryid`, `currencyid`, `jobid`, `longitude`, `latitude`, `isgoldjob`, `isfeaturedjob`, `raf_gender`, `raf_degreelevel`, `raf_experience`, `raf_age`, `raf_education`, `raf_category`, `raf_subcategory`, `raf_location`, `serverstatus`, `serverid`) 
                    VALUES(".$employer_id.", ".$companyid.", 'Accountant', 'accountant', '13', 1, 2, '', '2', 0, '<p><strong>Accountant Job </strong><strong>Duties:</strong></p>\r\n<ul>\r\n<li>Prepares asset, liability, and capital account entries by compiling and analyzing account information.</li>\r\n<li>Documents financial transactions by entering account information.</li>\r\n<li>Recommends financial actions by analyzing accounting options.</li>\r\n<li>Summarizes current financial status by collecting information; preparing balance sheet, profit and loss statement, and other reports.</li>\r\n<li>Substantiates financial transactions by auditing documents.</li>\r\n<li>Maintains accounting controls by preparing and recommending policies and procedures.</li>\r\n<li>Guides accounting clerical staff by coordinating activities and answering questions.</li>\r\n<li>Reconciles financial discrepancies by collecting and analyzing account information.</li>\r\n<li>Secures financial information by completing data base backups.</li>\r\n<li>Maintains financial security by following internal controls.</li>\r\n<li>Prepares payments by verifying documentation, and requesting disbursements.</li>\r\n<li>Answers accounting procedure questions by researching and interpreting accounting policy and regulations.</li>\r\n<li>Complies with federal, state, and local financial legal requirements by studying existing and new legislation, enforcing adherence to requirements, and advising management on needed actions.</li>\r\n<li>Prepares special financial reports by collecting, analyzing, and summarizing account information and trends.</li>\r\n<li>Maintains customer confidence and protects operations by keeping financial information confidential.</li>\r\n<li>Maintains professional and technical knowledge by attending educational workshops; reviewing professional publications; establishing personal networks; participating in professional societies.</li>\r\n<li>Accomplishes the result by performing the duty.</li>\r\n<li>Contributes to team effort by accomplishing related results as needed.</li>\r\n</ul>', '', '<p>Accounting, Corporate Finance, Reporting Skills, Attention to Detail, Deadline-Oriented, Reporting Research Results, SFAS Rules, Confidentiality, Time Management, Data Entry Management, General Math Skills</p>', NULL, '', '', '', '', '69791', '', '', '', '', '', '', '', 0, 1, '', '', '', '".$date."', 0, '0000-00-00 00:00:00', 0, 1, 0, '".$date."', '2026-06-16 00:00:00', NULL, '1', 0, '', '', '', 0, NULL, 1, 1, 1, 1, 1, 1, 'CA', 6, 1, 5, 5, 5, 1, '', '126', 1, 4, 4, 7, 7, 0, '', NULL, NULL, 0, 0, 1, 'pGLYCBVF7', '74.3833333', '31.5166667', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0);";
                    $db->setQuery($insert_job);
                    $db->query();
                    $jobid=$db->insertid();
                    $insetjobcities=$this->insertJobCities($jobid,$cityid);

                    $insert_job="INSERT INTO `#__js_job_jobs` ( `uid`, `companyid`, `title`, `alias`, `jobcategory`, `jobtype`, `jobstatus`, `jobsalaryrange`, `salaryrangetype`, `hidesalaryrange`, `description`, `qualifications`, `prefferdskills`, `applyinfo`, `company`, `country`, `state`, `county`, `city`, `zipcode`, `address1`, `address2`, `companyurl`, `contactname`, `contactphone`, `contactemail`, `showcontact`, `noofjobs`, `reference`, `duration`, `heighestfinisheducation`, `created`, `created_by`, `modified`, `modified_by`, `hits`, `experience`, `startpublishing`, `stoppublishing`, `departmentid`, `shift`, `sendemail`, `metadescription`, `metakeywords`, `agreement`, `ordering`, `aboutjobfile`, `status`, `educationminimax`, `educationid`, `mineducationrange`, `maxeducationrange`, `iseducationminimax`, `degreetitle`, `careerlevel`, `experienceminimax`, `experienceid`, `minexperiencerange`, `maxexperiencerange`, `isexperienceminimax`, `experiencetext`, `workpermit`, `requiredtravel`, `agefrom`, `ageto`, `salaryrangefrom`, `salaryrangeto`, `gender`, `video`, `map`, `packageid`, `paymenthistoryid`, `subcategoryid`, `currencyid`, `jobid`, `longitude`, `latitude`, `isgoldjob`, `isfeaturedjob`, `raf_gender`, `raf_degreelevel`, `raf_experience`, `raf_age`, `raf_education`, `raf_category`, `raf_subcategory`, `raf_location`, `serverstatus`, `serverid`) 
                    VALUES(".$employer_id.", ".$companyid.", 'Senior Software Engineer', 'senior-software-engineer', '13', 1, 2, '', '2', 0, '<p>You might be responsible for the replacement of a whole system based on the specifications provided by an IT analyst but often you''ll work with ''off the shelf'' software, modifying it and integrating it into the existing network. The skill in this is creating the code to link the systems together.</p>\r\n<p>You''ll also be responsible for:<br /><br /></p>\r\n<ul>\r\n<li>Reviewing current systems</li>\r\n<li>Presenting ideas for system improvements, including cost proposals</li>\r\n<li>Working closely with analysts, designers and staff</li>\r\n<li>Producing detailed specifications and writing the programme codes</li>\r\n<li>Testing the product in controlled, real situations before going live</li>\r\n<li>Preparation of training manuals for users</li>\r\n<li>Maintaining the systems once they are up and running</li>\r\n</ul>', '', '<p>Most employers will want you to have a BTEC HND at the very least to get a foot in the door, however some companies runthat will consider candidates with AS Levels.</p>\r\n<p>If you''ve got a degree it will , especially if it''s in an IT, science or maths based subject.</p>\r\n<p>If you''ve got a non-IT degree you might still be able to apply to a graduate trainee scheme, or you can take a postgraduate conversion course to get your CV up to scratch.</p>\r\n<p>It is possible to move into software development from another profession. If this is you, play-up your business and IT experience and be prepared to take some IT-based courses if necessary.</p>\r\n<p>The courses you''ll find open most doors are of course the programming qualifications such as:<br /><br /></p>\r\n<ul>\r\n<li>Java</li>\r\n<li>C++</li>\r\n<li>Smalltalk</li>\r\n<li>Visual Basic</li>\r\n<li>Oracle</li>\r\n<li>Linux</li>\r\n<li>NET</li>\r\n</ul>\r\n<p><br />Keeping up with the rapid pace of change is vital in this profession, so you should benefit from a good solid training programme, especially if you work for a larger organisation.</p>\r\n<p>You''ll learn from more senior programmers and will go on external courses to keep your professional skills up to date.Your training should focus on programming, systems analysis and software from recognised providers including the British Computer Society, e-skills, the Institute of Analysts and Programmers and the Institute for the Management of Information Systems.</p>\r\n<p>All the software vendors, including Microsoft and Sun run accredited training too.If you are self-employed then you should invest in training to keep your skills.</p>', NULL, '', '', '', '', '69791', '', '', '', '', '', '', '', 0, 1, '', '', '', '".$date."', 0, '0000-00-00 00:00:00', 0, 2, 0, '".$date."', '2026-06-16 00:00:00', NULL, '1', 0, '', '', '', 0, NULL, 1, 1, 1, 1, 1, 1, 'Bs(cs)', 6, 1, 12, 5, 5, 1, '', '126', 0, 4, 4, 8, 8, 0, '', NULL, NULL, 0, 50, 1, 'JnDLpkZB8', '74.3833333', '31.5166667', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0);";
                    $db->setQuery($insert_job);
                    $db->query();
                    $jobid=$db->insertid();
                    $insetjobcities=$this->insertJobCities($jobid,$cityid);

                    $insert_job="INSERT INTO `#__js_job_jobs` ( `uid`, `companyid`, `title`, `alias`, `jobcategory`, `jobtype`, `jobstatus`, `jobsalaryrange`, `salaryrangetype`, `hidesalaryrange`, `description`, `qualifications`, `prefferdskills`, `applyinfo`, `company`, `country`, `state`, `county`, `city`, `zipcode`, `address1`, `address2`, `companyurl`, `contactname`, `contactphone`, `contactemail`, `showcontact`, `noofjobs`, `reference`, `duration`, `heighestfinisheducation`, `created`, `created_by`, `modified`, `modified_by`, `hits`, `experience`, `startpublishing`, `stoppublishing`, `departmentid`, `shift`, `sendemail`, `metadescription`, `metakeywords`, `agreement`, `ordering`, `aboutjobfile`, `status`, `educationminimax`, `educationid`, `mineducationrange`, `maxeducationrange`, `iseducationminimax`, `degreetitle`, `careerlevel`, `experienceminimax`, `experienceid`, `minexperiencerange`, `maxexperiencerange`, `isexperienceminimax`, `experiencetext`, `workpermit`, `requiredtravel`, `agefrom`, `ageto`, `salaryrangefrom`, `salaryrangeto`, `gender`, `video`, `map`, `packageid`, `paymenthistoryid`, `subcategoryid`, `currencyid`, `jobid`, `longitude`, `latitude`, `isgoldjob`, `isfeaturedjob`, `raf_gender`, `raf_degreelevel`, `raf_experience`, `raf_age`, `raf_education`, `raf_category`, `raf_subcategory`, `raf_location`, `serverstatus`, `serverid`) 
                    VALUES(".$employer_id.", ".$companyid.", 'Web Designer', 'web-designer', '13', 1, 2, '', '2', 0, '<p>An associate''s degree program related to web design, such as an Associate of Applied Science in Web Graphic Design, provides a student with a foundation in the design and technical aspects of creating a website. Students learn web design skills and build professional portfolios that highlight their skills and abilities. Common topics include:</p>\r\n<ul>\r\n<li>Fundamentals of design imaging</li>\r\n<li>Basic web design</li>\r\n<li>Animation</li>\r\n<li>Multimedia design</li>\r\n<li>Content management</li>\r\n<li>Editing for video and audio</li>\r\n<li>Multimedia programming and technology</li>\r\n</ul>\r\n<p>A bachelor''s degree program in multimedia or web design allows students to learn advanced skills needed for professional web design. Students develop artistic and creative abilities in addition to technical skills. Degree programs, such as a Bachelor of Science in Web Design and Interactive Media, cover:</p>\r\n<ul>\r\n<li>Databases</li>\r\n<li>Webpage scripting</li>\r\n<li>Programming</li>\r\n<li>Digital imaging</li>\r\n<li>Multimedia design</li>\r\n<li>Web development</li>\r\n</ul>', '', '<ul>\r\n<li>Writing and editing content</li>\r\n<li>Designing webpage layout</li>\r\n<li>Determining technical requirements</li>\r\n<li>Updating websites</li>\r\n<li>Creating back up files</li>\r\n<li>Solving code problems</li>\r\n</ul>', NULL, '', '', '', '', '69795', '', '', '', '', '', '', '', 0, 1, '', '', '', '".$date."', 0, '0000-00-00 00:00:00', 0, 0, 0, '".$date."', '2026-06-16 00:00:00', NULL, '1', 0, '', '', '', 0, NULL, 1, 1, 1, 1, 1, 1, '', 3, 1, 5, 5, 5, 1, '', '', 0, 4, 4, 1, 1, 0, '', NULL, NULL, 0, 50, 1, 'JZH6Nz2cm', '74.3833333', '31.5166667', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0);";
                    $db->setQuery($insert_job);
                    $db->query();
                    $jobid=$db->insertid();
                    $insetjobcities=$this->insertJobCities($jobid,$cityid);
                    
                }
                
                $check_resume_insert="SELECT count(id) FROM `#__js_job_resume` where email_address='sampledata@info.com'";
                $db->setQuery($check_resume_insert);
                $isresumeexists=$db->loadResult();
                if($isresumeexists==0){
                    $resume_query="INSERT INTO `#__js_job_resume` ( `uid`, `create_date`, `modified_date`, `published`, `hits`, `application_title`, `keywords`, `alias`, `first_name`, `last_name`, `middle_name`, `gender`, `email_address`, `home_phone`, `work_phone`, `cell`, `nationality`, `iamavailable`, `searchable`, `photo`, `job_category`, `jobsalaryrange`, `jobsalaryrangetype`, `jobtype`, `heighestfinisheducation`, `address_country`, `address_state`, `address_county`, `address_city`, `address_zipcode`, `address`, `institute`, `institute_country`, `institute_state`, `institute_county`, `institute_city`, `institute_address`, `institute_certificate_name`, `institute_study_area`, `employer`, `employer_position`, `employer_resp`, `employer_pay_upon_leaving`, `employer_supervisor`, `employer_from_date`, `employer_to_date`, `employer_leave_reason`, `employer_country`, `employer_state`, `employer_county`, `employer_city`, `employer_zip`, `employer_phone`, `employer_address`, `filename`, `filetype`, `filesize`, `filecontent`, `field1`, `field2`, `field3`, `status`, `resume`, `institute1`, `institute1_country`, `institute1_state`, `institute1_county`, `institute1_city`, `institute1_address`, `institute1_study_area`, `institute1_certificate_name`, `institute2`, `institute2_country`, `institute2_state`, `institute2_county`, `institute2_city`, `institute2_address`, `institute2_certificate_name`, `institute2_study_area`, `institute3`, `institute3_country`, `institute3_state`, `institute3_county`, `institute3_city`, `institute3_address`, `institute3_study_area`, `institute3_certificate_name`, `employer1`, `employer1_position`, `employer1_resp`, `employer1_pay_upon_leaving`, `employer1_supervisor`, `employer1_from_date`, `employer1_to_date`, `employer1_leave_reason`, `employer1_country`, `employer1_state`, `employer1_county`, `employer1_city`, `employer1_zip`, `employer1_phone`, `employer1_address`, `employer2`, `employer2_position`, `employer2_resp`, `employer2_pay_upon_leaving`, `employer2_supervisor`, `employer2_from_date`, `employer2_to_date`, `employer2_leave_reason`, `employer2_country`, `employer2_state`, `employer2_county`, `employer2_city`, `employer2_zip`, `employer2_address`, `employer2_phone`, `employer3`, `employer3_position`, `employer3_resp`, `employer3_pay_upon_leaving`, `employer3_supervisor`, `employer3_from_date`, `employer3_to_date`, `employer3_leave_reason`, `employer3_country`, `employer3_state`, `employer3_county`, `employer3_city`, `employer3_zip`, `employer3_address`, `employer3_phone`, `language`, `language_reading`, `language_writing`, `language_understanding`, `language_where_learned`, `language1`, `language1_reading`, `language1_writing`, `language1_understanding`, `language1_where_learned`, `language2`, `language2_reading`, `language2_writing`, `language2_understanding`, `language2_where_learned`, `language3`, `language3_reading`, `language3_writing`, `language3_understanding`, `language3_where_learned`, `date_start`, `desired_salary`, `djobsalaryrangetype`, `dcurrencyid`, `can_work`, `available`, `unalailable`, `total_experience`, `skills`, `driving_license`, `license_no`, `license_country`, `reference`, `reference_name`, `reference_country`, `reference_state`, `reference_county`, `reference_city`, `reference_zipcode`, `reference_address`, `reference_phone`, `reference_relation`, `reference_years`, `reference1`, `reference1_name`, `reference1_country`, `reference1_state`, `reference1_county`, `reference1_city`, `reference1_address`, `reference1_phone`, `reference1_relation`, `reference1_years`, `reference2`, `reference2_name`, `reference2_country`, `reference2_state`, `reference2_county`, `reference2_city`, `reference2_address`, `reference2_phone`, `reference2_relation`, `reference2_years`, `reference3`, `reference3_name`, `reference3_country`, `reference3_state`, `reference3_county`, `reference3_city`, `reference3_address`, `reference3_phone`, `reference3_relation`, `reference3_years`, `address1_country`, `address1_state`, `address1_county`, `address1_city`, `address1_zipcode`, `address1`, `address2_country`, `address2_state`, `address2_county`, `address2_city`, `address2_zipcode`, `address2`, `reference1_zipcode`, `reference2_zipcode`, `reference3_zipcode`, `packageid`, `paymenthistoryid`, `userfield1`, `userfield2`, `userfield3`, `userfield4`, `userfield5`, `userfield6`, `userfield7`, `userfield8`, `userfield9`, `userfield10`, `currencyid`, `job_subcategory`, `date_of_birth`, `longitude`, `latitude`, `video`, `isgoldresume`, `isfeaturedresume`, `serverstatus`, `serverid`)
                     VALUES (".$jobseeker_id.",'".$date."',NULL,1,NULL,'sample data ','sample data','sample-data-','First','Last','','1','sampledata@info.com','1234567','1234567','1234567','126',1,1,NULL,13,1,2,1,'1',NULL,NULL,NULL,'69791','','','Govtt high school',NULL,NULL,NULL,'69791',NULL,'','secience','','','','','','','','',NULL,NULL,NULL,'','','','',NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'','Punjab University',NULL,NULL,NULL,'69791',NULL,'','','',NULL,NULL,NULL,'',NULL,'','','',NULL,NULL,NULL,'',NULL,'','','','','','','','','','',NULL,NULL,NULL,'','','','','','','','','','','','',NULL,NULL,NULL,'','','','','','','','','','','','',NULL,NULL,NULL,'','','','','','','','','','','','','','','','','','','','','','','','','0000-00-00 00:00:00',1,2,1,NULL,NULL,NULL,'','',0,'','',NULL,'',NULL,NULL,NULL,'','',NULL,'','','',NULL,'',NULL,NULL,NULL,'',NULL,'','','',NULL,'',NULL,NULL,NULL,'',NULL,'','','',NULL,'',NULL,NULL,NULL,'',NULL,'','','',NULL,NULL,NULL,'69791','','',NULL,NULL,NULL,'69791','','','','','',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,48,'0000-00-00 00:00:00','','','',0,0,NULL,0);";
                    $db->setQuery($resume_query);
                    $db->query();
                    $resumeid=$db->insertid();
                }
                $check_jobapply_insert="SELECT count(id) FROM `#__js_job_jobapply` WHERE cvid=".$db->quote($resumeid);
                $db->setQuery($check_jobapply_insert);
                $isjobapplyexists=$db->loadResult();
                if($isjobapplyexists==0){

                    if(!isset($resumeid)){
                        $query="SELECT id FROM `#__js_job_resume` WHERE email_address='sampledata@info.com'" ;
                        $db->setQuery($query);
                        $resumeid=$db->loadResult();
                    }

                    $jobs="SELECT id FROM `#__js_job_jobs` WHERE title='Web Designer' OR title='senior software engineer' OR title='Accountant' OR title='Games Developer' OR title='Php Developer';";
                    $db->setQuery($jobs);
                    $jobids=$db->loadObjectList();
                    
                    foreach($jobids AS $jobid){
                        $appliedjobs="INSERT INTO `#__js_job_jobapply` (`jobid`, `uid`, `cvid`, `apply_date`, `resumeview`, `comments`, `coverletterid`, `action_status`, `serverstatus`, `serverid`)
                        VALUES (".$jobid->id.",".$jobseeker_id.",".$resumeid.",'".$date."',0,NULL,NULL,1,NULL,NULL)";
                        $db->setQuery($appliedjobs);
                        $db->query();
                    }
                    
                }
                $check_jobapply_insert="SELECT count(id) FROM `#__js_job_userroles` WHERE uid=".$db->quote($jobseeker_id);
                $db->setQuery($check_jobapply_insert);
                $isjbuserrole=$db->loadResult();
                if($isjbuserrole==0){
                        $jbuserrole="INSERT INTO `#__js_job_userroles` ( `uid`, `role`, `dated`)
                        VALUES (".$jobseeker_id.",2,'".$date."')";
                        $db->setQuery($jbuserrole);
                        $db->query();
                    
                    
                }
                $check_jobapply_insert="SELECT count(id) FROM `#__js_job_userroles` WHERE uid=".$db->quote($employer_id);
                $db->setQuery($check_jobapply_insert);
                $isemuserrole=$db->loadResult();
                if($isemuserrole==0){
                        $emuserrole="INSERT INTO `#__js_job_userroles` ( `uid`, `role`, `dated`)
                        VALUES (".$employer_id.",1,'".$date."')";
                        $db->setQuery($emuserrole);
                        $db->query();
                    
                    
                }
                $query = "INSERT INTO `#__js_job_paymenthistory` (`id`, `uid`, `packageid`, `packagetitle`, `packageprice`, `discountamount`, `paidamount`, `discountmessage`, `packagediscountstartdate`, `packagediscountenddate`, `packageexpireindays`, `packageshortdetails`, `packagedescription`, `status`, `created`, `transactionverified`, `transactionautoverified`, `verifieddate`, `referenceid`, `payer_firstname`, `payer_lastname`, `payer_email`, `payer_amount`, `payer_itemname`, `payer_itemname2`, `payer_status`, `payer_tx_token`, `packagefor`, `currencyid`) VALUES
                (5, ".$jobseeker_id.", 1, 'Free Package', 0, 0, 0, '', '2010-06-01 00:00:00', '2010-08-24 00:00:00', 365, 'Free Package', 'Free Package', 1, '".date('Y-m-d H:i:s')."', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, 1),
                (4, ".$employer_id.", 1, 'Free Package', 0, 0, 0, '', '2010-06-01 00:00:00', '2010-08-24 00:00:00', 365, 'Free Package for single company', 'Free Package for single company', 1, '".date('Y-m-d H:i:s')."', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1);";
                $db->setQuery($query);
                $db->query();

        }
        return true;
        
    }

    function insertJobCities($jobid,$cityid){
        $db = JFactory::getDBO();
        $insert_jobcity="INSERT INTO `#__js_job_jobcities` (`jobid`, `cityid`) 
        VALUES( ".$jobid.", ".$cityid.");";
        $db->setQuery($insert_jobcity);
        $db->query();
        return true;
    }

    function display($cachable = false, $urlparams = false) {
        $document = JFactory :: getDocument();
        $viewName = JRequest :: getVar('view', 'installer');
        $layoutName = JRequest :: getVar('layout', 'installer');
        $viewType = $document->getType();
        $view = $this->getView($viewName, $viewType);
        $model = $this->getModel('installer', 'JSAutozModel');
        if (!JError::isError($model)) {
            $view->setModel($model, true);
        }
        $view->setLayout($layoutName);
        $view->display();
    }

}

?>
