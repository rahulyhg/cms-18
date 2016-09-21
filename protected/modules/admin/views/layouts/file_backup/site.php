











<?php echo 'site layout not use'; die; ?>































<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="copyright" content="65doctor.com – by 65 Doctor" />
<meta name="description" content="<?php echo Yii::app()->params['meta_description']; ?>"/>
<meta name="keywords" content="<?php echo Yii::app()->params['meta_keywords']; ?>" />
<title><?php echo CHtml::encode($this->pageTitle); ?></title>
<link rel="shortcut icon" type="image/ico" href="<?php echo Yii::app()->theme->baseUrl; ?>/favicon.ico" />
<link rel="apple-touch-icon" href="<?php echo Yii::app()->theme->baseUrl; ?>/images/favicon.png" />
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/style.css" />
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/style2.css" />
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/jnice.css" />

<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/js/jnice.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/js/jquery.js"></script>

<script type="text/javascript">
$(document).ready(function(){
});


</script>
<?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
<?php Yii::app()->bootstrap->registerAllCss(); ?>
<!--[if lt IE 9]>
<style type="text/css">
	.banner .search-form, .page .page-link a, section .content, aside .people, .tab-container, .document img, .booking .group-1 img, .doctor-profile .image, .profile .group-2 img, .profile .group-2 .map, .box, .list-4 li, .health-info .link { behavior: url(<?php echo Yii::app()->theme->baseUrl; ?>/PIE.htc); }
</style>
<![endif]-->
<!--[if IE]>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<script type="text/javascript">var switchTo5x=true;</script>
<script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
<script type="text/javascript">stLight.options({publisher: "ur-b6512971-795c-3992-16f1-99cee80688f"}); </script>
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-33333926-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
</head>

<meta name="robots" content="noindex" />
<meta name="googlebot" content="noindex" />    

<body class="innerpage">
	<header>
    	<div class="wrapper">
        	<div class="logo"><a href="<?php echo Yii::app()->createAbsoluteUrl('/'); ?>">65 Doctor</a></div>
            <div class="share">
            	<p>Share this:</p>
                <span class='st_twitter_large' displayText='Tweet'></span>
                <span class='st_facebook_large' displayText='Facebook'></span>
                <span class='st_linkedin_large' displayText='LinkedIn'></span>
                <span class='st_email_large' displayText='Email'></span>
                <span class='st_sharethis_large' displayText='ShareThis'></span>
            </div>
            <ul class="link">
                <li class="twitter"><a href="https://twitter.com/#!/65doctor" target="_bank">Follow us on Twitter</a></li>
            	<li><a href="https://www.facebook.com/pages/65doctor/267042123402667" target="_bank">Find us on Facebook</a></li>
            </ul>
        </div>
    </header><!-- //header -->

    <div class="banner">
    	
    </div>
    <div id="main">
    	<div class="wrapper">
            <div class="maincontent">                
               <?php echo $content; ?>
            </div><!-- maincontent -->
            <div class="clear"></div>
    	</div>
    </div><!-- //main -->
    <footer>
    </footer><!-- //footer -->
    

</body>
</html>

