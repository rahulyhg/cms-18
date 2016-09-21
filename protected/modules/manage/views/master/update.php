<?php
/* @var $this UserController */
/* @var $model User */

Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/form.css');

$this->breadcrumbs=array(
    Yii::t('static', $model->type=='race'?'Races':($model->type=='language'?'Languages':($model->type=='religion'?'Religions':'Referrings')))=>array('index'),
    Yii::t('static', 'Update'),
);

$this->menu=array(
    array('label'=>Yii::t('static', 'Cancel and Return'), 'url'=>array($model->type=='race'?'races':($model->type=='language'?'languages':($model->type=='religion'?'religions':'referrings')))),
);

$this->title = Yii::t('static', 'Updating ' .($model->type=='race'?'Race':($model->type=='language'?'Language':($model->type=='religion'?'Religion':'Referring'))));
?>

<div class="form-type">

    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'master-form',
        'enableAjaxValidation'=>true,
    )); ?>
    <div class="row">
        <div class="col-lg-5">
            <?php echo $form->errorSummary($model, Yii::t('validation','Please fix the following input errors:')); ?>
            <?php echo $form->hiddenField($model, 'id') ?>

            <div class="form-group">
                <?php echo $form->labelEx($model,'value'); ?>
                <?php echo $form->textField($model,'value',array('size'=>45,'maxlength'=>45,'class'=>'form-control')); ?>
            </div>

            <div class="form-group">
                <?php echo CHtml::submitButton(Yii::t('static','Update'), array('class'=>'btn btn-primary')); ?>
            </div>
        </div>
    </div>
    <?php $this->endWidget(); ?>

</div><!-- form -->