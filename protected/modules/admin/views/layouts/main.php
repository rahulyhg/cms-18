<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="robots" content="noindex" />
        <meta name="googlebot" content="noindex" />
        <title><?php echo CHtml::encode($this->pageTitle) . ' - ' . Yii::app()->params['projectName'] . ' Admin'; ?></title>

        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Admin panel developed with the Bootstrap from Twitter.">
        <meta name="author" content="travis">

        <link href="<?php echo Yii::app()->theme->baseUrl; ?>/admin/css/jquery-ui-1.8.18.custom.css" type=text/css rel=stylesheet>
        <link href="<?php echo Yii::app()->theme->baseUrl; ?>/admin/css/bootstrap.css" rel="stylesheet">
        <link href="<?php echo Yii::app()->theme->baseUrl; ?>/admin/css/site.css" rel="stylesheet">
        <link href="<?php echo Yii::app()->theme->baseUrl; ?>/admin/css/main-admin.css" rel="stylesheet" media="screen" />
        <link href="<?php echo Yii::app()->theme->baseUrl; ?>/admin/css/multiple-select.css" rel="stylesheet">
        <link href="<?php echo Yii::app()->theme->baseUrl; ?>/admin/css/bootstrap-responsive.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/admin/css/form.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/admin/css/nestable.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/admin/css/chosen.css" />
        <?php Yii::app()->getClientScript()->registerCoreScript('jquery'); ?>
        <?php Yii::app()->clientScript->registerCoreScript('jquery.ui'); ?>
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/admin/js/menu/jquery.nestable.js"></script>
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/admin/js/jquery.multiple.select.js"></script>
        <script type="text/javascript" src="<?php echo Yii::app()->baseUrl . '/resources/ckeditor/ckeditor.js'; ?>"></script>
        <script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl . '/admin/js/jquery-ui-timepicker-addon.js'; ?>"></script>
        <!--[if lt IE 9]>
          <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->

        <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.2/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.2/js/select2.min.js"></script>
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/redbull.js"></script>
                
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/admin/js/bootstrap.min.js"></script>
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/admin/js/bootstrap.file-input.js"></script>
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/admin/js/bootbox.min.js"></script>
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/admin/js/chosen.jquery.min.js"></script>
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/admin/js/custom.js"></script>
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/holder.js"></script>

        <!-- Include the plugin's CSS and JS: -->
        <?php 
            $controller = Yii::app()->controller->id;
            if ( $controller == 'patient' ) {
        ?>
        <script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/js/bootstrap-multiselect.js"></script>
        <link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/bootstrap-multiselect.css" type="text/css"/>
        <link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/admin/css/main-admin.css" type="text/css"/>
        <script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/js/redbull.js"></script>
        <?php } ?>
    </head>
    <body>
        <div class="navbar">
            <div class="navbar-inner">
                <div class="container-fluid">
                    <a class="brand" href="<?php echo Yii::app()->createAbsoluteUrl('admin/site/index'); ?>"><?php echo Yii::app()->params['projectName']; ?></a>
                    <?php if (isset(Yii::app()->user->id)): ?>
                        <div class="btn-group pull-right loginas">
                            <a class="btn btn-danger" href="<?php echo Yii::app()->createAbsoluteUrl('admin/manageadmin/update_my_profile'); ?>"><i class="icon-user"></i> <?php echo Yii::app()->user->name; ?></a>
                            <a class="btn btn-danger dropdown-toggle" data-toggle="dropdown" href="#">
                                <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu">
                                <li><a href="<?php echo Yii::app()->createAbsoluteUrl('admin/manageadmin/update_my_profile'); ?>">Profile</a></li>
                                <li class="divider"></li>
                                <li><a href="<?php echo Yii::app()->createAbsoluteUrl('admin/manageadmin/change_my_password'); ?>">Change password</a></li>
                                <li class="divider"></li>
                                <li><a href="<?php echo Yii::app()->createAbsoluteUrl('admin/site/logout'); ?>">Logout</a></li>
                            </ul>
                        </div>
                        <div class="welcome">Welcome </div>
                    <?php endif; ?>
                </div>
                <div class="clr"></div>
                <?php if (isset(Yii::app()->user->id)): ?>
                    <div class="nav-collapse">
                        <?php
                        $menu = new ShowAdminMenu();
                        echo $menu->showMenu();
                        ?>
                    </div>
                <?php else: ?>
                    <div class="nav-collapse">&nbsp;</div>
                <?php endif; ?>
            </div>
        </div>
        <div class="clr"></div>
        <div class="container-fluid">
            <div class="row-fluid">
                <?php if (isset($this->breadcrumbs)): ?>
                    <?php
                    $this->widget('ext.CBreadcrumbs.Cbreadcrumbs', array(
                        'links' => $this->breadcrumbs,
                    ));
                    ?><!-- breadcrumbs -->
                <?php endif ?>
                <?php echo $content;
                ?>
            </div>

        </div>
        <footer class="footer">
            Copyright &copy; <?php echo date('Y'); ?> <a href="<?php echo Yii::app()->createAbsoluteUrl('/'); ?>"><?php echo Yii::app()->params['projectName']; ?></a> <br/>
            Execution Time: <?php
            $log = new CLogger();
            echo round($log->getExecutionTime(), 3);
            ?> sec | 
            Memory Usage: <?php echo round($log->getMemoryUsage() / 1048576, 2); ?> mb
        </footer>
        <script type="text/javascript">
            //set class my-editor-basic for basic
            //set class my-editor-full for full toolbars
            $(document).ready(function () {
                runEditorBasic('<?php echo Yii::app()->baseUrl; ?>/resources/', <?php echo Yii::app()->params['ckeditor_basic']; ?>, '100%', 150);
                runEditorFull('<?php echo Yii::app()->baseUrl; ?>/resources/', <?php echo Yii::app()->params['ckeditor_full']; ?>, '100%', 250);
                runDatePicker('<?php echo Yii::app()->theme->baseUrl; ?>', '<?php echo Yii::app()->params['dateFormat']; ?>');
                runTimePicker('<?php echo Yii::app()->theme->baseUrl; ?>');
                runDateTimePicker('<?php echo Yii::app()->theme->baseUrl; ?>', 'dd/mm/yyyy h:i:s');
                runDobPicker('<?php echo Yii::app()->theme->baseUrl; ?>', '<?php echo Yii::app()->params['dateFormat']; ?>');
                validateNumber();
            });
        </script>
    </body>
</html>




