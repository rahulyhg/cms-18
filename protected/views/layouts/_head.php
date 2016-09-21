<meta name="SKYPE_TOOLBAR" content ="SKYPE_TOOLBAR_PARSER_COMPATIBLE">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<!--[if IE]><meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'><![endif]-->
<title><?php echo CHtml::encode($this->pageTitle); ?></title>
<link rel="icon" type="image/x-icon" href="<?php echo Yii::app()->theme->baseUrl; ?>/favicon.ico">
<link rel='stylesheet' id='fluid_dg-css' href='<?php echo Yii::app()->theme->baseUrl; ?>/css/fluid_dg.css' type='text/css' media='all'>
<link rel="stylesheet" id="roster_slider_headcss-css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/roster-slider.css" type="text/css" media="all">
<link media="all" rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/style.css">
<link media="all" rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/verz_css.css">
<link media="all" rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/colorbox.css">

<?php Yii::app()->clientScript->registerCoreScript('jquery'); //jQuery JavaScript Library v1.8.3 ?>
<script type="text/javascript" src="http://s3.amazonaws.com/nwapi/nwmatcher/nwmatcher-1.2.5.js"></script>
<script>!window.jQuery && document.write(unescape('%3Cscript src="<?php echo Yii::app()->theme->baseUrl; ?>/js/jquery-1.7.2.min.js"%3E%3C/script%3E'))</script>
<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/js/respond.src.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/js/topMenu.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/js/roster.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/js/placeholders.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/js/jquery.easing.1.3.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/js/jquery.mousewheel.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/js/organictabs.jquery.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/js/jquery.mobile.customized.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/js/fluid_dg.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/js/verz_js.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/js/jquery.colorbox.js"></script>



<script type="text/javascript">
    var width = jQuery(window).width();
    var height = 0;             
    jQuery(document).ready(function(){
        jQuery(function(){
            jQuery('#fluid_dg_wrap_1').fluid_dg({thumbnails:false,height:"29.6%"});
        });
    })
</script>
<script type="text/javascript">
    jQuery(function() {
        jQuery("#element-tabs").organicTabs({
            "speed": 200
        });
    });
</script>
<!--[if (gte IE 6)&(lte IE 8)]>
    <script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/js/selectivizr.js"></script>
<![endif]-->
<!--[if lt IE 9]>
    <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/html5shiv.js"></script>
    <script src="http://ie7-js.googlecode.com/svn/version/2.1(beta4)/IE9.js"></script>
<![endif]-->

<script type="text/javascript">
    jQuery("html").addClass("roster_slider_fouc");
    jQuery(document).ready(function() {
        jQuery(".roster_slider_fouc .roster_slider").css({"display" : "block"});
    });
    jQuery(document).ready(function() {
        validateNumber();
        jQuery("#roster_slider_1").rosterSlider({
            items:3,
            next:   "#roster_slider_1_next", 
            prev:   "#roster_slider_1_prev",
            auto:3000,
            scroll: {
                items:1,
                fx: "slide",
                easing: "swing",
                duration: "700",
                pauseOnHover: true
            }
        }); 
    });

    function validateNumber(){
        jQuery(".number_only").each(function(){
                jQuery(this).unbind("keydown");
                jQuery(this).bind("keydown",function(event){
                    if( !(event.keyCode == 8                                // backspace
                        || event.keyCode == 46                              // delete
                        || event.keyCode == 9                           // tab
                        // || (event.keyCode == 190 || event.keyCode == 110 )                          // dấu chấm (point) 
                        || (event.keyCode >= 35 && event.keyCode <= 40)     // arrow keys/home/end
                        || (event.keyCode >= 48 && event.keyCode <= 57)     // numbers on keyboard
                        || (event.keyCode >= 96 && event.keyCode <= 105))   // number on keypad
                        ) {
                            event.preventDefault();     // Prevent character input
                        }
                });
        });
    }
</script>