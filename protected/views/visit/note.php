<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/form.css');
$this->breadcrumbs=array(
    Yii::t('static','Add Note')
);

$this->menu=array(
    array('label'=>Yii::t('static', 'Cancel and Return'), 'url'=>array('site/index')),
);

$this->title = Yii::t('static','Add Note');
?>
<div class="form-type">
    <?php $form = $this->beginWidget('CActiveForm', array(
        'id'=>'visit-form',
        'enableAjaxValidation'=>false,
    ));
    ?>
    <div class="col-lg-4">
        <?php echo $form->errorSummary($model, Yii::t('validation','Please fix the following input errors:')); ?>
        <?php echo $form->hiddenField($model, 'id') ?>

        <dl>
            <dt><?php echo $form->labelEx($model,'patient.name'); ?></dt>
            <dt><?php echo $model->patient->name ?></dt>
        </dl>

        <dl>
            <dt><?php echo $form->labelEx($model,'patient.identity'); ?>
            <dt><?php echo $model->patient->identity ?></dt>
        </dl>
<?php if (isset($model->appointment)) : ?>
        <dl>
            <dt><?php echo $form->labelEx($model,'appointment_id'); ?></dt>
            <dt><?php echo Yii::app()->format->formatTime($model->appointment->start) ?></dt>
        </dl>
<?php endif; ?>

        <div class="form-group">
            <?php echo $form->labelEx($model,'note'); ?>
            <?php echo $form->textArea($model, 'note', array('class' => 'form-control','rows'=>4)); ?>
        </div>

        <div class="form-group">
            <?php echo CHtml::submitButton(Yii::t('static','Update'), array('class'=>'btn btn-primary')); ?>
        </div>
    </div>
    <div class="clearfix"></div>
</div>
<?php $this->endWidget(); ?>