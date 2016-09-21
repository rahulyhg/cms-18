<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo CHtml::encode($this->pageTitle); ?></title>
        <meta charset="utf-8" />
        <meta name="description" content="" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <link href="<?php echo Yii::app()->theme->baseUrl; ?>/css/bootstrap.min.css" rel="stylesheet" media="screen" />
        <link href="<?php echo Yii::app()->theme->baseUrl; ?>/css/plugin.css" rel="stylesheet" media="screen" />
        <link href="<?php echo Yii::app()->theme->baseUrl; ?>/css/main.css" rel="stylesheet" media="screen" />
        <link href="<?php echo Yii::app()->theme->baseUrl; ?>/css/extra.css" rel="stylesheet" media="screen" />
        <link href="<?php echo Yii::app()->theme->baseUrl; ?>/css/redbull.css" rel="stylesheet" media="screen" />

        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/modernizr.custom.17475.js"></script>
          <?php Yii::app()->getClientScript()->registerCoreScript('jquery'); ?>
        <?php Yii::app()->clientScript->registerCoreScript('jquery.ui'); ?>
        <!--[if lt IE 9]>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/respond.min.js"></script>
        <link href="<?php echo Yii::app()->theme->baseUrl; ?>/css/fixie8.css" rel="stylesheet" media="screen" />
        <![endif]-->

<!--        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/jquery-1.8.3.min.js"></script>-->
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/bootstrap.min.js"></script>
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/plugins.js"></script>
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/function.js"></script>
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/redbull.js"></script>
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/autocomplete/bootstrap3-typeahead.min.js"></script>
       
        <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.2/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.2/js/select2.min.js"></script>
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/invoice.js"></script>
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/inventory.js"></script>
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/print.js"></script>
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/patient_attach_file.js"></script>
        <!-- Include the plugin's CSS and JS: -->
        <script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/js/bootstrap-multiselect.js"></script>
        <link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/bootstrap-multiselect.css" type="text/css"/>
        <?php
        Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl . '/css/jquery-ui-1.10.3.custom.min.css');
        Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl . '/css/jquery-ui.css');
        Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl . '/css/jquery.ui.timepicker.css');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/jquery-ui.custom.min.js', CClientScript::POS_END);
       // Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/jquery-ui-1.10.3.custom.min.js', CClientScript::POS_END);
        Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/jquery.ui.timepicker.js', CClientScript::POS_END);
        Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/jquery.validate.min.js', CClientScript::POS_END);
        Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/jquery.floatThead.min.js', CClientScript::POS_END);
        ?>

    </head>
    <body>
        <header class="header-container">
            <?php 
            $loggedUser = Users::model()->findByPk(Yii::app()->user->id);
            $title = $loggedUser? $loggedUser->full_name : 'Redbull' ?>

            <div class="header-left">
                <h1><?php echo CHtml::link(Yii::app()->params['doctorName'], array('/queues/queue')); ?></h1>
            </div>
            <div class="header-right">
                <?php echo date('l d F Y h:i:s A') ?>
            </div>
        </header>
        <?php
        $currentUrl = $this->getCurrentUrlWithoutParam();
        ?>
        <nav class="navbar navbar-default">
            <div class="container-fluid">
              <!-- Brand and toggle get grouped for better mobile display -->
              <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                  <span class="sr-only">Toggle navigation</span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                </button>
                <!--<a <?php if (trim($currentUrl, '/') == Yii::app()->createAbsoluteUrl('/')) echo 'class="navbar-brand active"'; else echo 'class="navbar-brand"';  ?> class="navbar-brand" href="<?php echo Yii::app()->createAbsoluteUrl('/'); ?>"><span class="glyphicon glyphicon-th"></span> Calendar</a>-->
              </div>

              <!-- Collect the nav links, forms, and other content for toggling -->
              <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                   
                    <li <?php if (trim($currentUrl, '/') == Yii::app()->createAbsoluteUrl('queues/queue')) echo 'class="active"'; ?>>
                        <a  href="<?php echo Yii::app()->createAbsoluteUrl('queues/queue'); ?>"><span class="glyphicon glyphicon-tasks"></span> Queue</a>
                    </li>
                    <li <?php if (strpos($currentUrl, 'appointment/') !== false) echo 'class="active"'; else echo 'class="dropdown"'; ?>>
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-calendar"></span> Appointments  <span class="caret"></span</a>
                        <ul class="dropdown-menu" id="appointment">
                            <li><a href="<?php echo Yii::app()->createAbsoluteUrl('/appointments/index'); ?>">All Appointments</a></li>
                            <li><a href="<?php echo Yii::app()->createAbsoluteUrl('appointments/addAppointment'); ?>">Add Appointment</a></li>
                            <li><a href="<?php echo Yii::app()->createAbsoluteUrl('appointments/deletedappointment'); ?>">Deleted Appointment</a></li>
                        </ul>
                    </li>
                   
                    <li <?php if (strpos($currentUrl, 'patients/') !== false) echo 'class="active"'; ?>>
                        <a href="<?php echo Yii::app()->createAbsoluteUrl('patients/index'); ?>"><span class="glyphicon glyphicon-user"></span> Patients</a>
                    </li>
                    <li <?php if (strpos($currentUrl, 'payments/') !== false) echo 'class="dropdown active"'; else echo 'class="dropdown"'; ?>>
                        <a data-toggle="collapse" data-target="#payment" href="<?php echo Yii::app()->createAbsoluteUrl('payments/index'); ?>"><span class="glyphicon glyphicon-send"></span> Payments</a>
                    </li>
                    <li <?php if (strpos($currentUrl, 'inventories/') !== false) echo 'class="active"'; ?>>
                        <a  href="<?php echo Yii::app()->createAbsoluteUrl('inventories/index?war=true'); ?>"><span class="glyphicon glyphicon-folder-open"></span> Inventory </a>
                    </li>
                    <li <?php if (strpos($currentUrl, 'priceList/') !== false) echo 'class="active"'; ?>>
                        <a  href="<?php echo Yii::app()->createAbsoluteUrl('serviceList/index'); ?>"><span class="glyphicon glyphicon-align-center"></span> Price List</a>
                    </li>
                    <li <?php if (strpos($currentUrl, 'tools/') !== false) echo 'class="active"'; ?>>
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#"><span class="glyphicon glyphicon-wrench"></span> Tools  <span class="caret"></span</a>
                        <ul class="dropdown-menu" id="tool">
                            <li><a href="<?php echo Yii::app()->createAbsoluteUrl('tools/edd'); ?>">EDD</a></li>
<!--                            <li><a href="<?php echo Yii::app()->createAbsoluteUrl('tools/export'); ?>">Export</a></li>
                            <li><a href="<?php echo Yii::app()->createAbsoluteUrl('tools/print'); ?>">Print</a></li>-->
                        </ul>
                    </li>
                    <li <?php if (strpos($currentUrl, 'reports/') !== false) echo 'class="active"'; ?>>
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#"><span class="glyphicon glyphicon-cog"></span> Reports  <span class="caret"></span</a>
                        <ul class="dropdown-menu" id="reports">
                            <li><a href="<?php echo Yii::app()->createAbsoluteUrl('reports/payments'); ?>">Payments</a></li>
                             <li><a href="<?php echo Yii::app()->createAbsoluteUrl('reports/print'); ?>">Print</a></li>
                        </ul>
                        </ul>
                    </li>
                  
              </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
        </nav>
        
        <div class="main-content">
            <?php echo $content; ?>
        </div>

        <div class="footer-btn">
            <div class="wrap clearfix">
                <?php if (isset($this->breadcrumbs)): ?>
                    <?php
                    $this->widget('zii.widgets.CBreadcrumbs', array(
                        'links' => $this->breadcrumbs,
                        'homeLink' => CHtml::link(Yii::t('sitemap', 'Dashboard'), array('site/index'))
                    ));
                    ?><!-- breadcrumbs -->
                <?php endif ?>
                <a href="#" class="go-top"><?php echo Yii::t('sitemap', 'Top') ?></a>
                    <?php echo CHtml::link(Yii::app()->user->username . ' (logout)', array('/site/logout'), array('class' => 'btn-1')) ?>
                <!--
                        <a href="#" class="btn-1"><strong<?php //echo $this->stats['message']>0?' class="type"':''     ?>>(<?php //echo $this->stats['message']     ?>)</strong> <?php //echo Yii::t('static','New Message')     ?></a>
                        <a href="#" class="btn-1"><strong<?php //echo $this->stats['appointment']>0?' class="type"':''     ?>>(<?php //echo $this->stats['appointment']     ?>)</strong> New <?php //echo Yii::t('static','Appointments')     ?></a>
                        <a href="#" class="btn-1"><strong<?php //echo $this->stats['cancelled']>0?' class="type"':''     ?>>(<?php //echo $this->stats['cancelled']     ?>)</strong> <?php // Yii::t('static','Not here')     ?></a>
                        <a href="#" class="btn-1"><strong<?php //echo $this->stats['waiting']>0?' class="type"':''     ?>>(<?php //echo $this->stats['waiting']     ?>)</strong> <?php //echo Yii::t('static','Waiting')     ?></a>
                        <a href="#" class="btn-1"><strong<?php //echo $this->stats['seen']>0?' class="type"':''     ?>>(<?php //echo $this->stats['seen']     ?>)</strong> <?php //echo Yii::t('static','Seen')     ?></a>
                        <a href="#" class="btn-1"><strong<?php //echo $this->stats['paid']>0?' class="type"':''     ?>>(<?php //echo $this->stats['paid']     ?>)</strong> <?php //echo Yii::t('static','Paid')     ?></a>
                -->
            </div>
        </div>
        <script type="text/javascript">
            //set class my-editor-basic for basic
            //set class my-editor-full for full toolbars
            $(document).ready(function () {
                runDatePicker('<?php echo Yii::app()->theme->baseUrl; ?>', '<?php echo Yii::app()->params['dateFormat']; ?>');
                runDobPicker('<?php echo Yii::app()->theme->baseUrl; ?>', '<?php echo Yii::app()->params['dateFormat']; ?>');
                runTimePicker('<?php echo Yii::app()->theme->baseUrl; ?>');
                runDateTimePicker('<?php echo Yii::app()->theme->baseUrl; ?>', 'dd/mm/yyyy h:i:s');
                validateNumber();
            });
        </script>
    </body>
</html>