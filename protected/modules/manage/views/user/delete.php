<?php
/* @var $this DoctorController */
/* @var $model Doctor */

$this->breadcrumbs=array(
    Yii::t('static', 'Users')=>array('index'),
    $model->username,
    Yii::t('static', 'Delete'),
);

$this->menu=array(
    array('label'=>Yii::t('static', 'Cancel and Return'), 'url'=>array('index')),
);

$this->title = Yii::t('static', 'Deleting User {name}', array('{name}'=>$model->name));
?>


<div class="form-type">

    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'doctor-form',
        'enableAjaxValidation'=>false,
    )); ?>
    <div class="row">
        <div class="col-lg-5">
            <?php echo $form->hiddenField($model, 'id') ?>

            <p><?php echo Yii::t('static', 'Deleting a user is not reversible.')?></p>
            <p><?php echo Yii::t('static', 'Do you want to proceed?')?></p>

            <div class="form-group">
                <?php echo CHtml::submitButton(Yii::t('static','Delete'), array('class'=>'btn btn-primary')); ?>
            </div>
        </div>
    </div>
    <?php $this->endWidget(); ?>

</div><!-- form -->