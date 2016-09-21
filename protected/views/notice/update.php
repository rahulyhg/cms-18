<?php
$base_url = Yii::app()->theme->baseUrl;
Yii::app()->clientScript->registerCssFile($base_url . '/css/form.css');
$this->breadcrumbs = array(
    Yii::t('static', 'Update Message')
);

$this->menu = array(
    // array('label' => Yii::t('static', 'Log out'), 'url' => array('/site/logout'), 'class' => 'btn-1'),
    array('label' => Yii::t('static', 'Cancel and Home'), 'url' => array('/appointment/site/index'), 'class' => 'btn-1'),
    array('label' => Yii::t('static', 'Previous Page'), 'url' => 'javascript:history.go(-1)', 'class' => 'btn-1'),
);

$this->title = Yii::t('static', 'Add Message');
?>
<div class="form-type">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'notice-form',
        'enableAjaxValidation' => false,
    ));
    ?>
    <div class="action-button">
        <?php echo CHtml::submitButton(Yii::t('static', 'Update'), array('class' => 'btn btn-primary')); ?>
    </div>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-lg-5">
            <?php echo $form->errorSummary($model, Yii::t('validation', 'Please fix the following input errors:')); ?>

            <div class="form-group">
                <?php echo $form->labelEx($model, 'title'); ?>
                <?php echo $form->textField($model, 'title', array('size' => 45, 'maxlength' => 45, 'class' => 'form-control')); ?>
            </div>

            <div class="form-group">
                <?php echo $form->labelEx($model, 'content'); ?>
                <?php
                $this->widget('ext.ckeditor.CKEditorWidget', array(
                    "model" => $model,
                    "attribute" => 'content',
                    "config" => array(
                        "height" => "150px",
                        "width" => "500px",
                    )
                ));
                ?>
            </div>

<!--            <div class="form-group">
                <?php echo CHtml::submitButton(Yii::t('static', 'Update'), array('class' => 'btn btn-primary')); ?>
            </div>-->
        </div>
    </div>
    <?php $this->endWidget(); ?>
    <div class="clearfix"></div>
</div>