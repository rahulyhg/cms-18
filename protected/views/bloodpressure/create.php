
<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'Patient-form',
    'enableAjaxValidation' => false,
    'htmlOptions' => array('class' => '', 'role' => 'form', 'enctype' => 'multipart/form-data'),
        ));
?>
<?php $patient_id = isset($_GET['patient_id'])?$_GET['patient_id']:0;?>
<?php $healthytype = isset($_GET['healthytype'])?$_GET['healthytype']: "blood_pressure";?>

<div class="box-1 add-new-patient add-new">
    <div class="title-box clearfix">
        <h2 class="title"><?php echo Yii::t('static', 'Add ').$this->singleTitle ?></h2>
        <?php echo CHtml::link(Yii::t('static', '<span class="glyphicon glyphicon-ban-circle"></span> Cancel and Back'), array('/patients/healthynotes', 'patient_id' => $patient_id, 'healthytype' => $healthytype), array('class' => 'btn-1 pull-right')); ?>
        <?php echo CHtml::htmlButton($model->isNewRecord ? '<span class="glyphicon glyphicon-floppy-disk"></span> Create' : '<span class="glyphicon glyphicon-floppy-disk"></span> Save', array('class' => 'btn-1 pull-right', 'type' => 'submit')); ?> &nbsp;  
    </div>
    <div class="box-body">
        <?php echo $this->renderPartial('_form', compact('model', 'form')); ?>
    </div>
</div>

  <?php $this->endWidget(); ?>
