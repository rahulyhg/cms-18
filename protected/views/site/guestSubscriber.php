<link href="<?php echo Yii::app()->theme->baseUrl; ?>/css/960-rtl.css" rel="stylesheet" type="text/css" media="screen" />        
<link href="<?php echo Yii::app()->theme->baseUrl; ?>/css/table-ui-sorter.css" rel="stylesheet" type="text/css" media="screen" />        

<div class="container_12">
    <div class="grid_6 alpha" style="text-align: center; padding-top: 100px;">
<?php if(isset($error['not_valid'])): ?>
    <?php
    $this->pageTitle=Yii::app()->name . ' - Error';
    $this->breadcrumbs=array(
            'Error',
    );
    ?>
     <div style="height: 100px;background-color: #BD3970;"><h2 style="padding-top: 40px;">Email: <?php echo $email;?>  not valid !</h2></div>

<?php elseif(isset($error['exists'])): ?>
     <div style="height: 100px;background-color: #BD3970;"><h2 style="padding-top: 40px;">Email: <?php echo $email;?>  had existed!</h2></div>
<?php else: ?>
    <div style="height: 100px;background-color: #BD3970;"><h2 style="padding-top: 40px;">Email: <?php echo $email;?>  successful subscriber!</h2></div>
<?php endif;?>
    </div>
</div>