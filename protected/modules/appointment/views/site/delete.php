<?php


$this->menu=array(
	array('label' => Yii::t('static', 'Previous Page'), 'url' => 'javascript:history.go(-1)', 'class' => 'btn-1'),
);

$this->title = Yii::t('static', 'Delete Appointment');
?>

<div class="form-type">

    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'appointment-form',
        'enableAjaxValidation'=>true,
    )); ?>
    <div class="row">
        <?php echo $form->hiddenField($model, 'id') ?>
        <h4>Do you want to delete this appointment?</h4>
        <div class="clearfix"></div>
        <div class="form-group">
            <?php echo CHtml::submitButton(Yii::t('static','Delete'), array('class'=>'btn btn-primary')); ?>
            <?php echo CHtml::submitButton(Yii::t('static','Cancel'), array('class'=>'btn', 'onclick' => 'history.go(-1)')); ?>
        </div>
    </div>
    <?php $this->endWidget(); ?>

</div><!-- form -->