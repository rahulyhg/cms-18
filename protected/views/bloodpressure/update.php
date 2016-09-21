
<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'Patient-form',
    'enableAjaxValidation' => false,
    'htmlOptions' => array('class' => '', 'role' => 'form', 'enctype' => 'multipart/form-data'),
        ));
?>

<div class="box-1 add-new-patient add-new">
    <div class="title-box clearfix">
        <h2 class="title"><?php echo Yii::t('static', 'Edit Drug Alert') ?></h2>
        <?php echo CHtml::link(Yii::t('static', '<span class="glyphicon glyphicon-ban-circle"></span> Cancel and Back'), array('/patients/healthynotes', 'patient_id' => $model->patient_id, 'healthytype' => "blood_pressure"), array('class' => 'btn-1 pull-right')); ?>
        <?php echo CHtml::htmlButton($model->isNewRecord ? '<span class="glyphicon glyphicon-floppy-disk"></span> Create' : '<span class="glyphicon glyphicon-floppy-disk"></span> Save', array('class' => 'btn-1 pull-right', 'type' => 'submit')); ?> &nbsp; 
    </div>
    <div class="box-body">
        <?php echo $this->renderPartial('_form', compact('model', 'form')); ?>
    </div>
</div>

  <?php $this->endWidget(); ?>
