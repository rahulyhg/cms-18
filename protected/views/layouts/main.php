<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
    <meta charset="utf-8" />
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

    <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap.min.css" rel="stylesheet" media="screen" />
    <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/plugin.css" rel="stylesheet" media="screen" />
    <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" rel="stylesheet" media="screen" />
    <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/extra.css" rel="stylesheet" media="screen" />

    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/modernizr.custom.17475.js"></script>

    <!--[if lt IE 9]>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/respond.min.js"></script>
    <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/fixie8.css" rel="stylesheet" media="screen" />
    <![endif]-->

    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery-1.8.3.min.js"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/bootstrap.min.js"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/plugins.js"></script>
</head>
<body>
<header class="header-container">
    <?php $title = empty(Yii::app()->params['clinicName']) ? "Singapore Redbull" : Yii::app()->params['clinicName'] ?>
    <h1><?php echo CHtml::link($title, array('/site/index')); ?></h1>
</header>
<div class="nav-list">
    <div class="nav-wrap">
        <?php $this->widget('zii.widgets.CMenu',array(
            'items'=>array(
                array('label'=>'<span class="text">'.Yii::t('sitemap','<b>Dashboard</b>').'</span>', 'url'=>array('/site/index')),
                array('label'=>'<span class="ico ico-15"></span>'.Yii::t('sitemap','Add Appointment'), 'url'=>array('/appointment/create')),

                array('label'=>'<span class="ico-print"></span>'.Yii::t('static','Print Appointment'), 'url'=>array('/appointment/print_appointment')),
                array('label'=>'<span class="ico-1 ico"></span>'.Yii::t('static','Export Appointment'), 'url'=>array('/export/appointment')),
                array('label'=>'<span class="ico ico-3"></span>'.Yii::t('sitemap','Calendar'), 'url'=>array('/appointment/calendar')),
//                    'linkOptions'=>array('data-toggle'=>'dropdown','title'=>Yii::t('sitemap','Appointments'), 'class'=>'dropdown-toggle'),
//                    'submenuOptions'=>array('class'=>'dropdown-menu'),
//                    'url'=>'#',
//                    'items'=>array(
//                        array('label'=>Yii::t('sitemap','By Calendar'),'url'=>array('/appointment/calendar')),
//                        array('label'=>Yii::t('sitemap','By Doctor'),'url'=>array('/appointment/doctor')),
//                        array('label'=>Yii::t('sitemap','Black Out Date'),'url'=>array('/blackout/index')),
//                    )
//                ),
                array('label'=>'<span class="ico ico-3"></span>'.Yii::t('static','All Doctors'), 'url'=>array('/appointment/doctor')),
                array('label'=>'<span class="ico ico-3"></span>'.Yii::t('static','Black Out'), 'url'=>array('/blackout/index')),
                array('label'=>'<span class="ico ico-3"></span>'.Yii::t('static','Doctor\'s Leave'), 'url'=>array('/blackout/doctorleave')),
                array('label'=>'<span class="ico ico-3"></span>'.Yii::t('static','Doctor\'s Time Table'), 'url'=>array('/doctor/tableTime')),

                //array('label'=>'<span class="ico ico-1"></span>'.Yii::t('sitemap','Patients'), 'url'=>array('/patient/index')),

            ),
            'encodeLabel' => false,
            'activeCssClass'=>'active',
            'firstItemCssClass'=>'first',
            'lastItemCssClass'=>'last',
            'submenuHtmlOptions'=>array(
                'class'=>"dropdown-menu",
            ),
        )); ?>
        <?php
        if (Yii::app()->user->role == 1)
            $this->widget('zii.widgets.CMenu',array(
                'items'=>array(
                    array('label'=>Yii::t('sitemap','Settings').' <span class="caret"></span>',
                        'linkOptions'=>array('data-toggle'=>'dropdown','title'=>Yii::t('sitemap','Settings'), 'class'=>'dropdown-toggle'),
                        'itemOptions'=>array('class'=>'dropup'),
                        'submenuOptions'=>array('class'=>'dropdown-menu'),
                        'url'=>'#',
                        'items'=>array(
                            array('label'=>Yii::t('static','Manage Users'),'url'=>array('/site/create')),
                          
                            array('label'=>Yii::t('static','Manage Users'),'url'=>array('/manage/user/index')),
                            array('label'=>Yii::t('static','Manage Clinics'),'url'=>array('/manage/clinic/index')),
                            array('label'=>Yii::t('static','Manage Doctors'),'url'=>array('/manage/doctor/index')),
                            array('label'=>Yii::t('static','Manage Clients'),'url'=>array('/manage/client/index')),
                            array('label'=>Yii::t('static','Manage Races'),'url'=>array('/manage/master/races')),
                            array('label'=>Yii::t('static','Manage Religions'),'url'=>array('/manage/master/religions')),
                            array('label'=>Yii::t('static','Manage Languages'),'url'=>array('/manage/master/languages')),
                            array('label'=>Yii::t('static','Manage Referrings'),'url'=>array('/manage/master/referrings')),
                        )
                    ),
                ),
                'encodeLabel' => false,
                'activeCssClass'=>'active',
                'htmlOptions'=>array(
                    'class'=>'bot-list',
                ),
            ));
        ?>
    </div>
</div>
<div class="main-content">
    <?php echo $content; ?>
</div>

<div class="footer-btn">
    <div class="wrap clearfix">
        <?php if(isset($this->breadcrumbs)):?>
            <?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
			'homeLink'=>CHtml::link(Yii::t('sitemap','Dashboard'), array('site/index'))
		)); ?><!-- breadcrumbs -->
        <?php endif?>
        <a href="#" class="go-top"><?php echo Yii::t('sitemap','Top')?></a>
        <?php echo CHtml::link(Yii::app()->user->username.' (logout)', array('/site/logout'), array('class'=>'btn-1'))?>

    </div>
</div>
</body>
</html>