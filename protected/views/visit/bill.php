<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/form.css');
$this->breadcrumbs=array(
    Yii::t('static','Bill Patient')
);

$this->menu=array(
    array('label'=>Yii::t('static', 'Cancel and Return'), 'url'=>array('site/index')),
);

$this->title = Yii::t('static','Bill Patient');
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

        <div class="form-group">
            <?php echo $form->labelEx($model,'billed'); ?>
            <?php echo $form->textField($model,'billed',array('class'=>'form-control', 'style'=>'width: 150px')); ?>
        </div>

        <div class="form-group">
            <?php echo $form->labelEx($model,'cash'); ?>
            <?php echo $form->textField($model,'cash',array('class'=>'form-control', 'style'=>'width: 150px')); ?>
        </div>

        <div class="form-group">
            <?php echo $form->labelEx($model,'nets'); ?>
            <?php echo $form->textField($model,'nets',array('class'=>'form-control', 'style'=>'width: 150px')); ?>
        </div>

        <div class="form-group">
            <?php echo $form->labelEx($model,'card'); ?>
            <?php echo $form->textField($model,'card',array('class'=>'form-control', 'style'=>'width: 150px')); ?>
        </div>

        <div class="form-group">
            <?php echo CHtml::submitButton(Yii::t('static','Bill'), array('class'=>'btn btn-primary','name'=>'update')); ?>
            <?php echo CHtml::submitButton(Yii::t('static','Paid and Complete'), array('class'=>'btn btn-success','name'=>'complete')); ?>
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