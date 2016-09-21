<?php
$base_url = Yii::app()->theme->baseUrl;
Yii::app()->clientScript->registerCssFile($base_url . '/css/form.css');
$this->breadcrumbs = array(
    Yii::t('static', 'Add Message')
);

$this->menu = array(
    // array('label' => Yii::t('static', 'Log out'), 'url' => array('/site/logout'), 'class' => 'btn-1'),
    array('label' => Yii::t('static', 'Cancel and Home'), 'url' => array('/appointment/site/index'), 'class' => 'btn-1'),
    array('label' => Yii::t('static', 'Previous Page'), 'url' => 'javascript:history.go(-1)', 'class' => 'btn-1'),
);

$this->title = Yii::t('static', $model->isNewRecord ? 'Add Message':'Update Message');
?>
<div class="form-type">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'notice-form',
        'enableAjaxValidation' => false,
    ));
    ?>
    <div class="action-button">
        <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('static', 'Create') : Yii::t('static', 'Save'), array('class' => 'btn btn-primary')); ?>
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
                <?php echo $form->labelEx($model, 'start'); ?>
                <?php echo $form->textField($model, 'startDate', array('class' => 'form-control datepicker startDate','style' => 'width: 40%;')); ?>
            </div>
            <div class="form-group">
                <?php echo $form->labelEx($model, 'end'); ?>
                <?php echo $form->textField($model, 'endDate', array('class' => 'form-control datepicker endDate','style' => 'width: 40%;')); ?>
            </div>

            <div class="form-group">
                <?php echo $form->labelEx($model, 'content'); ?>
                <?php echo $form->textArea($model, 'content', array('class' => 'form-control', 'rows' => 6)); ?>
            </div>

            <!--            <div class="form-group">
            <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('static', 'Create') : Yii::t('static', 'Save'), array('class' => 'btn btn-primary')); ?>
                        </div>-->
        </div>
    </div>
<?php $this->endWidget(); ?>
    <div class="clearfix"></div>
</div>

<?php

Yii::app()->clientScript->registerCssFile($base_url . '/css/jquery-ui-1.10.3.custom.min.css');
Yii::app()->clientScript->registerCssFile($base_url . '/css/jquery-ui.css');

Yii::app()->clientScript->registerScriptFile($base_url . '/js/jquery-ui.custom.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile($base_url . '/js/jquery-ui-1.10.3.custom.min.js', CClientScript::POS_END);

?>

<script>
$(function(){
    $(".datepicker").datepicker({
        showOtherMonths: true,
        selectOtherMonths: true,
        changeMonth: true,
        dateFormat: "DD M d, yy",
        changeYear: true,
        onSelect: function (dateText) {
            if ($(this).hasClass('startDate')) {
                $(".endDate").val($(this).val());
            }
        }
    });
});

</script>