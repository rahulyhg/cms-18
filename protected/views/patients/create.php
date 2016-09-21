
<div class="box-1 add-new-patient add-new">

<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'Patient-form',
    'enableAjaxValidation' => false,
    'htmlOptions' => array('class' => '', 'role' => 'form', 'enctype' => 'multipart/form-data'),
));
?>

    <div class="title-box clearfix">
        <h2 class="title"><?php echo Yii::t('static', 'Add New Patient') ?></h2>
        <?php echo CHtml::link(Yii::t('static', '<span class="glyphicon glyphicon-ban-circle"></span> Cancel and Back'), array('patients/index'), array('class' => 'btn-1 pull-right')); ?>
        <?php echo CHtml::htmlButton($model->isNewRecord ? '<span class="glyphicon glyphicon-floppy-disk"></span> Create' : '<span class="glyphicon glyphicon-floppy-disk"></span> Save', array('class' => 'btn-1 pull-right', 'type' => 'submit')); ?> &nbsp;  
    </div>
    <div class="box-body">
        <?php echo $this->renderPartial('_biodata', compact('model', 'form')); ?>
        <?php echo $this->renderPartial('_patient_contact_information', compact('model', 'form')); ?>
        <?php echo $this->renderPartial('_patient_medical_information', compact('model', 'form')); ?>
        <?php echo $this->renderPartial('_partner_sponsor', compact('model', 'form')); ?>
        <?php echo $this->renderPartial('_patient_medical_insurrance', compact('model', 'form')); ?>
    </div>

<?php $this->endWidget(); ?>

</div>

<script type="text/javascript">
    $(window).ready(function(){
        $('#Patient_dob').change(function(){
            var dob = $(this).val();
            var age = getAge(dob);
            $('.bio-age').html(age);
            $('#Patient_age').val(age);
        });
        
        Patient.init();
    });

    function getAge(birth) {
        var pieces = birth.split('/');
        var birth_date = pieces[0];
        var birth_month = pieces[1];
        var birth_year = pieces[2];
        var today = new Date();
        var today_year = today.getFullYear();
        var today_month = today.getMonth();
        var today_day = today.getDate();

        var age = today_year - birth_year;
        if ( today_month < (birth_month - 1))
        {
            age--;
        }
        if (((birth_month - 1) == today_month) && (today_day < birth_date))
        {
            age--;
        }
        if (age <= 0) {
            age = 0;
        }
        return age;
    }
    
     
</script>
          
