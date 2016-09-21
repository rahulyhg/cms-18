<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/form.css');
$this->breadcrumbs=array(
    Yii::t('static','Update Patient')
);

$this->menu=array(
    array('label'=>Yii::t('static', 'Cancel and Return'), 'url'=>array('site/index')),
);

$this->title = Yii::t('static','Update Patient');
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

        <dl>
            <dt><?php echo $form->labelEx($model,'status'); ?></dt>
            <div class="btn-group clear" data-toggle="buttons">
                <label class="btn btn-info" id="btn-waiting">
                    <?php echo $form->radioButton($model,'status',array('value'=>'waiting','uncheckValue'=>null)) ?> <?php echo Yii::t('static','Waiting')?>
                </label>
                <label class="btn btn-info" id="btn-seen">
                    <?php echo $form->radioButton($model,'status',array('value'=>'seen','uncheckValue'=>null)) ?> <?php echo Yii::t('static','Seen')?>
                </label>
                <label class="btn btn-info" id="btn-cancel">
                    <?php echo $form->radioButton($model,'status',array('value'=>'cancel','uncheckValue'=>null)) ?> <?php echo Yii::t('static','Cancelled')?>
                </label>
            </div>
        </dl>

        <div class="form-group">
            <?php echo $form->labelEx($model,'time_in'); ?>
            <?php echo $form->textField($model,'timein',array('class'=>'form-control timepicker', 'style'=>'width: 150px')); ?>
        </div>

        <div class="form-group">
            <?php echo CHtml::submitButton(Yii::t('static','Update'), array('class'=>'btn btn-primary')); ?>
        </div>
    </div>
    <div class="clearfix"></div>
</div>
<?php $this->endWidget(); ?>
<script type="text/javascript">
    var hourText = "<?php echo Yii::t('static', 'Hour')?>";
    var minuteText = "<?php echo Yii::t('static', 'Minute')?>";
    var ampmText = ["<?php echo Yii::t('static', 'AM')?>","<?php echo Yii::t('static', 'PM')?>"];
</script>
<?php
$script = "$('#btn-".$model->status."').button('toggle');";
Yii::app()->clientScript->registerScript('binddata', $script);
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/jquery-ui-1.10.3.custom.min.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/jquery.ui.timepicker.css');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery-ui-1.10.3.custom.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.ui.timepicker.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/visit_update.js', CClientScript::POS_END);
?>