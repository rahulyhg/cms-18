<?php
/* @var $this DoctorController */
/* @var $model Doctor */

Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/form.css');

$this->breadcrumbs=array(
	Yii::t('static', 'Appointments / Operations'),
	Yii::t('static', 'Delete'),
);

$this->menu=array(
	array('label'=>Yii::t('static', 'Cancel and Return'), 'url'=>array('/appointment/view','id'=>$model->event_id),'class'=>'btn-1'),
);

$this->title = Yii::t('static', 'Delete '.($model->event->type=='op'?'Operation':($model->event->type=='appt'?'Appointment':'Event')));
?>

<div class="form-type">

    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'appointment-form',
        'enableAjaxValidation'=>true,
    )); ?>
    <div class="row">
        <?php echo $form->hiddenField($model, 'event_id') ?>
        <h4>Do you want to delete this event?</h4>
        <div class="clearfix"></div>
        <div class="form-group">
            <?php echo CHtml::submitButton(Yii::t('static','Delete'), array('class'=>'btn btn-primary')); ?>
        </div>
    </div>
    <?php $this->endWidget(); ?>

</div><!-- form -->