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
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/admin/js/bootstrap.min.js"></script>
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/admin/js/bootstrap.file-input.js"></script>
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/admin/js/bootbox.min.js"></script>
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/admin/js/chosen.jquery.min.js"></script>
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/admin/js/custom.js"></script>
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/holder.js"></script>
    </head>
    <body>
        
        <div class="clr"></div>
        <div class="container-fluid">
            <div class="row-fluid">
                <?php echo $content;
                ?>
            </div>

        </div>
        
        <script type="text/javascript">
            //set class my-editor-basic for basic
            //set class my-editor-full for full toolbars
            $(document).ready(function() {
                runEditorBasic('<?php echo Yii::app()->baseUrl; ?>/resources/', <?php echo Yii::app()->params['ckeditor_basic']; ?>, '100%', 150);
                runEditorFull('<?php echo Yii::app()->baseUrl; ?>/resources/', <?php echo Yii::app()->params['ckeditor_full']; ?>, '100%', 250);
                runDatePicker('<?php echo Yii::app()->theme->baseUrl; ?>');
                runTimePicker('<?php echo Yii::app()->theme->baseUrl; ?>');
                runDateTimePicker('<?php echo Yii::app()->theme->baseUrl; ?>');
                validateNumber();
            });
        </script>
    </body>
</html>




