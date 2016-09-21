<?php
$this->breadcrumbs=array(
	$this->pluralTitle => array('index'),
	'Add new ' . $this->singleTitle,
);

?>
<div class="form-horizontal">
<div class="box-1">
    <div class="title-box clearfix">
        <h2 class="title"><?php echo Yii::t('static', 'Add New Queue') ?></h2>
        <?php echo CHtml::htmlButton($this->iconCancel . ' Cancel', array('class' => 'btn-1 pull-right', 'onclick' => 'javascript: location.href=\'' . $this->baseControllerIndexUrl('queue') . '\'')); ?>
        <?php echo CHtml::htmlButton($this->iconCreate . ' Save', array('class' => 'btn-1 pull-right', 'onclick' => '$("#queue-form").submit();', 'type' => 'submit')); ?> &nbsp;  
        
    </div>
    <div class="box-body">
       <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
    </div>
</div>

