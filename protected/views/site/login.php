
<?php
/* @var $this PatientController */
Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl . '/css/form.css');
?>
<h1 class="header-login">
    <?php //echo CHtml::image(Yii::app()->theme->baseUrl.'/img/logo.png') ?>
</h1>
<div class="col-md-6 col-md-10 centerbox">
    <div class="form-type round-box-3">
        <h1 class="text-center">LOGIN</h1>
            <?php
            CHtml::$errorCss = '';
            $form = $this->beginWidget('CActiveForm',
                array(
                    'id'=>'myform',
                    'enableAjaxValidation'=>false,
                    'errorMessageCssClass'=>'text-danger',
                    'focus'=>array($model,'username'),
                    
                )
            );
            ?>
        <div class="row form-group form-group-sm">
            <?php echo $form->errorSummary($model, Yii::t('validation', 'Please fix the following input errors:')); ?>
            <div class="form-group">
                <?php echo $form->labelEx($model,'username', array('class' => 'col-md-2')); ?>
                <div class="col-md-10">
                    <?php echo $form->textField($model,'username',array('class' => 'form-control')); ?>
                </div>
            </div>

            <div class="form-group">
                <?php echo $form->labelEx($model,'password', array('class' => 'col-md-2')); ?>
                <div class="col-md-10">
                    <?php echo $form->passwordField($model,'password',array('class' => 'form-control')); ?>
                </div>
            </div>

            <div class="form-group text-center">
                <?php echo CHtml::submitButton('Login'); ?>
            </div>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>
