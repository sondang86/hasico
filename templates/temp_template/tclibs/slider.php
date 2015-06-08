<?php
/**
* @subpackage  mx_joomla121 Template
*/

defined('_JEXEC') or die;

$app = JFactory::getApplication();
$doc = JFactory::getDocument();//define path
$base_url = $this->baseurl;
$tpl_name = $this->template;

$caption         = $this->params->get ('caption');
$menu            = $this->params->get ('menu');
$slider	     = $this->params->get('slider');
$slides	     = $this->params->get('slides');
$sliders_thumb1 	= $this->params->get('sliders_thumb1', '' );
$sliders_thumb2 	= $this->params->get('sliders_thumb2', '' );
$sliders_thumb3 	= $this->params->get('sliders_thumb3', '' );
$sliders_thumb4 	= $this->params->get('sliders_thumb4', '' );
$sliders_thumb5 	= $this->params->get('sliders_thumb5', '' );
$sliders_thumb6 	= $this->params->get('sliders_thumb6', '' );

if ($sliders_thumb1 || $sliders_thumb2 || $sliders_thumb3 || $sliders_thumb4 || $sliders_thumb5) {
// use images from template manager
} else {
// use default images
$sliders_thumb1 = $this->baseurl . '/templates/' . $this->template . '/slider/header1.jpg';
$sliders_thumb2 = $this->baseurl . '/templates/' . $this->template . '/slider/header2.jpg';
}

(($this->countModules('slider') && $slides == 2) || ($slides == 1) ?

$tcParams .= '<div class="mx_wrapper_slider"><div class="container"><div id="layerslider" style="width:1000px;height:400px;max-width:1280px;">'
.($sliders_thumb1 ? '<div class="ls-slide" data-ls="slidedelay:5000;transition2d:all;transition3d:;"><img src="'.$sliders_thumb1.'" class="ls-bg" alt=""/>' : '')
.($sliders_thumb1 ? '</div>' : '')

.($sliders_thumb2 ? '<div class="ls-slide" data-ls="slidedelay:5000;transition2d:all;transition3d:;"><img src="'.$sliders_thumb2.'" class="ls-bg" alt=""/>' : '')
.($sliders_thumb2 ? '</div>' : '')

.($sliders_thumb3 ? '<div class="ls-slide" data-ls="slidedelay:5000;transition2d:all;transition3d:;"><img src="'.$sliders_thumb3.'" class="ls-bg" alt=""/>' : '')
.($sliders_thumb3 ? '</div>' : '')

.($sliders_thumb4 ? '<div class="ls-slide" data-ls="slidedelay:5000;transition2d:all;transition3d:;"><img src="'.$sliders_thumb4.'" class="ls-bg" alt=""/>' : '')
.($sliders_thumb4 ? '</div>' : '')

.($sliders_thumb5 ? '<div class="ls-slide" data-ls="slidedelay:5000;transition2d:all;transition3d:;"><img src="'.$sliders_thumb5.'" class="ls-bg" alt=""/>' : '')
.($sliders_thumb5 ? '</div>' : '')

.($sliders_thumb6 ? '<div class="ls-slide" data-ls="slidedelay:5000;transition2d:all;transition3d:;"><img src="'.$sliders_thumb6.'" class="ls-bg" alt=""/>' : '')
.($sliders_thumb6 ? '</div>' : '').
'</div></div></div>
<script>
jQuery("#layerslider").layerSlider({
pauseOnHover: true,
skin: "v5",
hoverBottomNav: true,
skinsPath: "'.$base_url.'/templates/mx_joomla121/slider/skins/"
});
</script>' : '')
?>

      