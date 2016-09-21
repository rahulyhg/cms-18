<!DOCTYPE html>
<html>
<head>
    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
    <meta charset="utf-8" />
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

    <link href="<?php echo Yii::app()->theme->baseUrl; ?>/css/bootstrap.min.css" rel="stylesheet" media="screen" />
    <link href="<?php echo Yii::app()->theme->baseUrl; ?>/css/plugin.css" rel="stylesheet" media="screen" />
    <link href="<?php echo Yii::app()->theme->baseUrl; ?>/css/main.css" rel="stylesheet" media="screen" />
    <link href="<?php echo Yii::app()->theme->baseUrl; ?>/css/extra.css" rel="stylesheet" media="screen" />

    <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/modernizr.custom.17475.js"></script>

    <!--[if lt IE 9]>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/respond.min.js"></script>
    <link href="<?php echo Yii::app()->theme->baseUrl; ?>/css/fixie8.css" rel="stylesheet" media="screen" />
    <![endif]-->

    <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/jquery-1.8.3.min.js"></script>
    <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/bootstrap.min.js"></script>
    <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/plugins.js"></script>

</head>

<body class="plain">
<?php echo $content; ?>
</body>
</html>