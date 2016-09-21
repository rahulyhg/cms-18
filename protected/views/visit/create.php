<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/form.css');
$this->breadcrumbs=array(
	Yii::t('static','Add Patient')
);

$this->menu=array(
    array('label'=>Yii::t('static', 'Cancel and Return'), 'url'=>array('site/index')),
);

$this->title = Yii::t('static','Add Patient');
?>
<div class="form-type">
    <?php $form = $this->beginWidget('CActiveForm', array(
        'id'=>'visit-form',
        'enableAjaxValidation'=>false,
        ));
    ?>
    <div class="col-lg-4">
        <div class="form-group">
            <label for="patientfield"><?php echo Yii::t('static','Enter NRIC or Patient\'s Name')?></label>
            <?php echo CHtml::textField('patient', '', array('class'=>'typeahead form-control', 'id'=>'patientfield', 'placeholder'=>Yii::t('static','enter name or NRIC'), 'style'=>'width: 350px')); ?>
            <?php echo $form->hiddenField($model, 'patient_id', array('id'=>'patientid')); ?>
        </div>
        <div class="form-group">
            <h3><?php echo Yii::t('static', 'Or') ?></h3>
        </div>
        <div class="form-group">
            <?php echo $form->label($model,'appointment_id',array('label'=>Yii::t('static','Select Today\'s Appointment'))); ?>
            <?php echo $form->dropDownList($model, 'appointment_id', CHtml::listData(Appointment::model()->today()->getData(), 'event_id', 'name'), array('class'=>'form-control', 'style'=>'width: 350px'))?>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="form-group">
            <?php echo $form->labelEx($model,'time_in'); ?>
            <?php echo $form->textField($model,'time_in',array('class'=>'form-control timepicker', 'style'=>'width: 150px')); ?>
        </div>
        <div class="form-group">
            <h3>&nbsp;</h3>
        </div>
        <div class="form-group">
            <label for=""><br/><br/><br/></label>
            <?php echo CHtml::submitButton(Yii::t('static','Submit'), array('class'=>'btn btn-primary')); ?>
        </div>
     </div>
    <?php $this->endWidget(); ?>
    <div class="clearfix"></div>
</div>
<script type="text/javascript">
    var hourText = "<?php echo Yii::t('static', 'Hour')?>";
    var minuteText = "<?php echo Yii::t('static', 'Minute')?>";
    var ampmText = ["<?php echo Yii::t('static', 'AM')?>","<?php echo Yii::t('static', 'PM')?>"];
</script>
<?php
$script = 'var datasource = [';
foreach ($patientlist as $t) {
    $script .= '{label: "'.$t->name.' ['.$t->identity.']", name: "'.$t->name.'", phone: "'.$t->contact1.'", id: "'.$t->id.'"},';
}
$script .= '];';
Yii::app()->clientScript->registerScript('binddata', $script);
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/jquery-ui-1.10.3.custom.min.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/jquery.ui.timepicker.css');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery-ui-1.10.3.custom.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.ui.timepicker.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/visit_create.js', CClientScript::POS_END);
?>