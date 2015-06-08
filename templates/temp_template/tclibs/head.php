<head>
<?php JHtml::_('behavior.framework', true);
$IE6Warning = $this->params->get("IE6Warning", 1);
if(class_exists('JHtmlJquery')) JHtml::_('jquery.framework');?>
<jdoc:include type="head" />
<script type="text/javascript">
var tcDefault = jQuery.noConflict();
<?php if($IE6Warning == 1){?>
if (BrowserDetect.browser == 'Explorer' && BrowserDetect.version <= 7){ //CHECK IE 7
window.onload=function(){
document.body.innerHTML = '<div class="unsupport-ie7"><div class="container alert alert-warning clearfix"><h1>Unsupported Browser</h1><p>We have detected that you are using Internet Explorer 7, a browser version that is not supported by this website. Internet Explorer 7 was released in October of 2006, and the latest version of IE7 was released in October of 2007. It is no longer supported by Microsoft.</p><p>Continuing to run IE7 leaves you open to any and all security vulnerabilities discovered since that date. In March of 2011, Microsoft released version 9 of Internet Explorer that, in addition to providing greater security, is faster and more standards compliant than versions 6, 7, and 8 that came before it.</p><p>We suggest installing the <a href="http://www.microsoft.com/windows/internet-explorer/default.aspx" class="alert-link">latest version of Internet Explorer</a>, or the latest version of these other popular browsers: <a href="http://www.mozilla.com/en-US/firefox/firefox.html" class="alert-link">Firefox</a>, <a href="http://www.google.com/chrome" class="alert-link">Google Chrome</a>, <a href="http://www.apple.com/safari/download/" class="alert-link">Safari</a>, <a href="http://www.opera.com/" class="alert-link">Opera</a></p></div></div>';
}
}
<?php } ?>
jQuery(document).ready(function(e) {
(function($) {
$.fn.equalHeights = function() {
var maxHeight = 0,
$this = $(this);
$this.each( function() {
var height = $(this).innerHeight();
if ( height > maxHeight ) { maxHeight = height; }
});
return $this.css('min-height', maxHeight);
};
// auto-initialize plugin
$('[data-equal]').each(function(){
var $this = $(this),
target = $this.data('equal');
$this.find(target).equalHeights();
});
})(jQuery);
//jQuery('#mx_lbr').children().equalHeights();
if(!jQuery('.form-group').children('label[class*="col-md-"]').length)
jQuery('.form-group').children('label').addClass('col-md-3 control-label');
if(jQuery('.form-group').children('div[class*="col-md-"]').length){
jQuery('.form-group').find('input:not([type="checkbox"],[type="radio"],[type="hidden"],[type="submit"]), select').addClass('form-control');
jQuery('.form-group').find('textarea').addClass('form-control');
}
if(jQuery('.form-group').children('div:not([class*="col-md-"])')){
jQuery('.form-group').children('input:not([type="checkbox"],[type="radio"],[type="hidden"],[type="submit"]), select').addClass('form-control').wrap('<div class="col-md-5" />');
jQuery('.form-group').children('textarea').addClass('form-control').wrap('<div class="col-md-9" />');
}
});
</script>
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
<script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
<![endif]-->
<link rel="stylesheet" href="<?php echo $this->baseurl;?>/templates/<?php echo $this->template;?>/css/styles/style3.css" type="text/css" />
<link rel="stylesheet" href="<?php echo $this->baseurl;?>/templates/<?php echo $this->template;?>/css/responsive.css" type="text/css" />
<link rel="stylesheet" href="<?php echo $this->baseurl;?>/templates/<?php echo $this->template;?>/css/mod_tc/budicons.css" type="text/css" />
<link rel="stylesheet" href="<?php echo $this->baseurl;?>/templates/<?php echo $this->template;?>/css/mod_tc/mod_tcproshow2_default.css" type="text/css" />
<link rel="stylesheet" href="<?php echo $this->baseurl;?>/templates/<?php echo $this->template;?>/css/mod_tc/owl.carousel.css" type="text/css" />
<link rel="stylesheet" href="<?php echo $this->baseurl;?>/templates/<?php echo $this->template;?>/css/mod_tc/scrollscc3.css" type="text/css" />
<link rel="stylesheet" href="<?php echo $this->baseurl;?>/templates/<?php echo $this->template;?>/css/mod_tc/style.css" type="text/css" />
<link rel="stylesheet" href="<?php echo $this->baseurl;?>/templates/<?php echo $this->template;?>/css/mod_tc/style_2.css" type="text/css" />
<link rel="stylesheet" href="<?php echo $this->baseurl;?>/templates/<?php echo $this->template;?>/css/mod_tc/son_custom.css" type="text/css" />
<link rel="stylesheet" href="<?php echo $this->baseurl;?>/templates/<?php echo $this->template;?>/css/jobsearch.gov.au.css" type="text/css" />
<link rel="stylesheet" href="<?php echo $this->baseurl;?>/templates/<?php echo $this->template;?>/css/mod_tc/contact_us.css" type="text/css" />
<link rel="stylesheet" href="<?php echo $this->baseurl;?>/templates/<?php echo $this->template;?>/css/mod_tc/footer.css" type="text/css" />
<link rel="stylesheet" href="<?php echo $this->baseurl;?>/templates/<?php echo $this->template;?>/css/hotjobs_box.css" type="text/css" />


<style type="text/css">
    h1,h2,h3,h4,.main-mx-menu > li > a,.slide-item-title { font-family: Oswald, Arial, sans-serif; }
        .mx_wrapper, .container { max-width: 1160px !important;}
        .mx_wrapper_top .container {color: #ffffff; background: #a6a6a6;}
       .main-mx-menu > li > a {font-size:17px !important;}
       body#tc{font-family:Arial, Helvetica, sans-serif !important; font-size:14px !important;}
       .newsletter-signup input[type="text"] {width:90px;}
       @media (min-width: 1200px) { body.res1170 .newsletter-signup input[type="text"] {width:120px;} }
       #jumenu161 .service { width:25%;}#jumenu161 .getgap { margin-left:7px;} #jumenu161 .service:hover .service-sub {background-color:#99cc33;} #jumenu161 .service:hover .service-main {color:#99cc33;} #jumenu161 .service-icon { color:#99cc33; font-size:65px;; line-height:65px;}
       @media screen and (max-width: 50.5em) {
               #jumenu161 .service {
                       width: 50%; 
               }	
       }
       @media screen and (max-width: 24.5em) {
               #jumenu161 .service  {
                       width: 100%; 
               }
       }
       .accordion { animation-duration: 1.2s !important;	-webkit-animation-duration: 1.2s !important; visibility: hidden; }
       .service { animation-duration: 1.3s !important;	-webkit-animation-duration: 1.3s !important; visibility: hidden; }
       .reds, .greens, .blues, .oranges, .colors, .dark, .greys, .white { animation-duration: 1.5s !important;	-webkit-animation-duration: 1.5s !important; visibility: hidden; }
        #nebox159 .tc-inner { margin:7px;}
       #nebox159 .tc-inner:hover{background-color:#99cc00;}
  </style>
</head>

