<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language;?>" >
<?php
/* @package     mx_joomla121 Template
 * @author		mixwebtemplates http://www.mixwebtemplates.com
 * @copyright	Copyright (c) 2006 - 2012 mixwebtemplates. All rights reserved
 */
defined( '_JEXEC' ) or die( 'Restricted access' );
if(!defined('DS')){define('DS',DIRECTORY_SEPARATOR);}
$tcParams = '';
include_once(dirname(__FILE__).DS.'tclibs'.DS.'head.php');
include_once(dirname(__FILE__).DS.'tclibs'.DS.'settings.php');
$tcParams .= '<body id="tc">';
$tcParams .= TCShowModule('adverts', 'mx_xhtml', 'container');

$tcParams .= '<div id="mx_wrapper" class="mx_wrapper">';

$tcParams .=  TCShowModule('header', 'mx_xhtml', 'container');
$tcParams .= '<jdoc:include type="modules" name="sign_in" />';

include_once(dirname(__FILE__).DS.'tclibs'.DS.'slider.php');
include_once(dirname(__FILE__).DS.'tclibs'.DS.'social.php');


$tcParams .=  TCShowModule('slider', 'mx_xhtml', 'container');
$tcParams .=  TCShowModule('top', 'mx_xhtml', 'container');
$tcParams .=  TCShowModule('info', 'mx_xhtml', 'container');

$tcParams .= '<section class="mx_wrapper_info mx_section">'
             .'<div class="container mx_group"><jdoc:include type="modules" name="search_jobs_box" />'
//             .'<div><jdoc:include type="modules" name="test1" /></div>'
             .'</div></section>';

//Latest Jobs blocks
$tcParams .=  '<div class="row"><jdoc:include type="modules" name="latest_jobs" /></div>'
             ;
             

//Slide top

$tcParams .= '<section class="mx_wrapper_top mx_section">'
             .'<div class="container mx_group">'
             .'<jdoc:include type="modules" name="top_slide" />'
             .'</div></section>';

//very maintop content block
$tcParams .= '<section class="mx_wrapper_maintop mx_section">'
             .'<div class="container mx_group">'
             .'<jdoc:include type="modules" name="top_block" />'
             .'</div></section>';


$tcParams .=  TCShowModule('maintop', 'mx_xhtml', 'container');
$tcParams .= '<main class="mx_main container clearfix">'.$component.'</main>';
$tcParams .=  TCShowModule('mainbottom', 'mx_xhtml', 'container').
TCShowModule('feature', 'mx_xhtml', 'container').
TCShowModule('bottom', 'mx_xhtml', 'container').
TCShowModule('footer', 'mx_xhtml', 'container');

//Advise widget

$tcParams .= '<div class="row">'
             .'<jdoc:include type="modules" name="advise-widget" />'
             .'</div>';  

//Resume nav bar
$tcParams .= '<div class="mod-content clearfix">'
             .'<jdoc:include type="modules" name="Create_ResumeNavBar" />'
             .'</div>';    
	

//Feature blocks
$tcParams .= '<section class="mx_wrapper_feature mx_section">'
             .'<div class="container mx_group">'
             .'<jdoc:include type="modules" name="feature-1" />'
             .'</div></section>';


//Footer blocks
$tcParams .= '<section class="mx_wrapper_bottom mx_section">'
             .'<div class="container mx_group">'
             .'<jdoc:include type="modules" name="footer_block" />'
             .'</div></section>';


$tcParams .= '<footer class="mx_wrapper_copyright mx_section">'.
'<div class="container clearfix">'.
'<div class="col-md-12">'.($copyright ? '<div style="padding:10px;">'.$cpright.' </div>' : ''). /* You CAN NOT remove (or unreadable) this without mixwebtemplates.com permission */ //'<div style="padding-bottom:10px; text-align:right; ">Designed by <a href="http://www.mixwebtemplates.com/" title="Visit mixwebtemplates.com!" target="blank">mixwebtemplates.com</a></div>'.
'</div>'.
'</div>'.
'</footer>';
$tcParams .='</div>';	   
include_once(dirname(__FILE__).DS.'tclibs'.DS.'debug.php');
$tcParams .='</body>';
$tcParams .='</html>';
echo $tcParams;
?>