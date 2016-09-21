<?php
/* @var $this DoctorController */
/* @var $model Doctor */

Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/form.css');

$this->breadcrumbs=array(
    Yii::t('static', 'Clinics')=>array('index'),
    $model->name,
    Yii::t('static', 'Update'),
);

$this->menu=array(
    array('label'=>Yii::t('static', 'Cancel and Return'), 'url'=>array('index')),
);

$this->title = Yii::t('static', 'Updating Clinic {name}', array('{name}'=>$model->name));
?>


<div class="form-type">

    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'clinic-form',
        'enableAjaxValidation'=>true,
    )); ?>
    <div class="row">
        <div class="col-lg-5">
            <?php echo $form->errorSummary($model, Yii::t('validation','Please fix the following input errors:')); ?>
            <?php echo $form->hiddenField($model, 'id') ?>

            <div class="form-group">
                <?php echo $form->labelEx($model,'name'); ?>
                <?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>100,'class'=>'form-control')); ?>
            </div>

            <div class="form-group">
                <?php echo $form->labelEx($model,'code'); ?>
                <?php echo $form->textField($model,'code',array('size'=>45,'maxlength'=>45,'class'=>'form-control')); ?>
            </div>

            <div class="form-group">
                <?php echo $form->labelEx($model,'salt'); ?>
                <?php echo $form->textField($model,'salt',array('size'=>45,'maxlength'=>45,'class'=>'form-control')); ?>
            </div>

            <div class="form-group">
                <?php echo $form->labelEx($model,'color_code'); ?>
                <?php echo $form->textField($model,'color_code',array('size'=>45,'maxlength'=>45,'class'=>'form-control')); ?>
            </div>

            <div class="form-group">
                <?php echo $form->labelEx($model,'active'); ?>
                <div class="list-2 clearfix">
                    <?php echo $form->radioButtonList($model, 'active',
                        array('0'=>Yii::t('static', 'No'), '1'=>Yii::t('static', 'Yes')),
                        array('class'=>'radio-type','separator'=>false,'encode'=>false)); ?>
                </div>
            </div>

            <div class="form-group">
                <?php echo CHtml::submitButton(Yii::t('static','Update'), array('class'=>'btn btn-primary')); ?>
            </div>
        </div>
    </div>
    <?php $this->endWidget(); ?>

</div><!-- form -->