<?php
/* @var $this DoctorController */
/* @var $model Doctor */

Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/form.css');

$this->breadcrumbs=array(
	Yii::t('static', 'Clinics')=>array('index'),
	Yii::t('static', 'Create'),
);

$this->menu=array(
	array('label'=>Yii::t('static', 'Cancel and Return'), 'url'=>array('index')),
);

$this->title = Yii::t('static', 'Create Clinic');
?>


<div class="form-type">

    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'clinic-form',
        'enableAjaxValidation'=>true,
    )); ?>
    <div class="row">
        <div class="col-lg-5">
            <?php echo $form->errorSummary($model, Yii::t('validation','Please fix the following input errors:')); ?>

            <div class="form-group">
                <?php echo $form->labelEx($model,'name'); ?>
                <?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>100,'class'=>'form-control')); ?>
            </div>

            <div class="form-group">
                <?php echo CHtml::submitButton(Yii::t('static','Create'), array('class'=>'btn btn-primary')); ?>
            </div>
        </div>
    </div>
    <?php $this->endWidget(); ?>

</div><!-- form -->