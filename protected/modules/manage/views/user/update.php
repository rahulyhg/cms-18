<?php
/* @var $this UserController */
/* @var $model User */

Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/form.css');

$this->breadcrumbs=array(
    Yii::t('static', 'Users')=>array('index'),
    $model->username,
    Yii::t('static', 'Update'),
);

$this->menu=array(
    array('label'=>Yii::t('static', 'Cancel and Return'), 'url'=>array('index')),
);

$this->title = Yii::t('static', 'Updating User {username}', array('{username}'=>$model->username));
?>

<div class="form-type">

    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'user-form',
        'enableAjaxValidation'=>true,
    )); ?>
    <div class="row">
        <div class="col-lg-5">
            <?php echo $form->errorSummary($model, Yii::t('validation','Please fix the following input errors:')); ?>
            <?php echo $form->hiddenField($model, 'id') ?>

            <div class="form-group">
                <?php echo $form->labelEx($model,'password'); ?>
                <?php echo $form->passwordField($model,'password',array('size'=>45,'maxlength'=>45,'class'=>'form-control')); ?>
            </div>

            <div class="form-group">
                <?php echo $form->labelEx($model,'password2'); ?>
                <?php echo $form->passwordField($model,'password2',array('size'=>45,'maxlength'=>45,'class'=>'form-control')); ?>
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
                <?php echo $form->labelEx($model,'name'); ?>
                <?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>100,'class'=>'form-control')); ?>
            </div>

            <div class="form-group">
                <?php echo $form->labelEx($model,'contact'); ?>
                <?php echo $form->textField($model,'contact',array('size'=>20,'maxlength'=>20,'class'=>'form-control')); ?>
            </div>

            <div class="form-group">
                <?php echo $form->labelEx($model,'email'); ?>
                <?php echo $form->textField($model,'email',array('size'=>45,'maxlength'=>45,'class'=>'form-control')); ?>
            </div>

            <div class="form-group">
                <?php echo $form->labelEx($model,'role'); ?>
                <?php echo $form->dropDownList($model,'role',User::$role,array('class'=>'form-control')); ?>
            </div>


            <div class="form-group">
                <?php echo CHtml::submitButton(Yii::t('static','Update'), array('class'=>'btn btn-primary')); ?>
            </div>
        </div>
    </div>
    <?php $this->endWidget(); ?>

</div><!-- form -->