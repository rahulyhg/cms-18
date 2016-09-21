
<?php
    $patientName = isset($patient_id) ? Patient::model()->getPatientName($patient_id) : (isset($model) ? $model->name : "");
?>

<div class="box-1">
    <div class="title-box clearfix">
        <h2 class="title"><?php echo Yii::t('static', 'Patient Profile') ?>: <?php echo $patientName; ?></h2>
        <?php echo CHtml::link(Yii::t('static', '<span class="glyphicon glyphicon-plus"></span> Add New Patient'), array('patients/create'), array('class' => 'btn-1 pull-right')); ?>
    </div>
    <?php $patient_id = isset($_GET['patient_id'])?$_GET['patient_id']:0;?>
    <div class="box-body patient-info">
        <ul id="tabs" class="nav nav-tabs" data-tabs="tabs">
            <li class="<?php echo $type == 'patient_registration' ? "active" : "" ?>">
                <?php echo CHtml::link(Yii::t('static', 'Patient Registration Information'), array('patients/detail', 'patient_id' => $patient_id), array('class' => 'legend-custom pull-left')); ?>
            </li>
            <li class="<?php echo $type == 'drugalert' ? "active" : "" ?>">
                <?php echo CHtml::link(Yii::t('static', 'Drug Alert'), array('patients/drugalert', 'patient_id' => $patient_id), array('class' => 'lagend-custom pull-left')); ?>
            </li>
            <li class="<?php echo $type == 'appointment_history' ? "active" : "" ?>">
                <?php echo CHtml::link(Yii::t('static', 'Appointment History'), array('patients/appointmenthistory', 'patient_id' => $patient_id), array('class' => 'lagend-custom pull-left')); ?>
            </li>
            <li class="<?php echo $type == 'dispensing_history' ? "active" : "" ?>">
                <?php echo CHtml::link(Yii::t('static', 'Dispensing History Prescription'), array('patients/dispensinghistory', 'patient_id' => $patient_id), array('class' => 'lagend-custom pull-left')); ?>
            </li>
            <li class="<?php echo $type == 'payment_history' ? "active" : "" ?>">
                <?php echo CHtml::link(Yii::t('static', 'Payment History'), array('patients/paymenthistory', 'patient_id' => $patient_id), array('class' => 'lagend-custom pull-left')); ?>
            </li>
            <li class="<?php echo $type == 'medical_record' ? "active" : "" ?>">
                <?php echo CHtml::link(Yii::t('static', 'Medical Records'), array('patients/medicalrecord', 'patient_id' => $patient_id), array('class' => 'lagend-custom pull-left')); ?>
            </li>
            <li class="<?php echo $type == 'company_medical' ? "active" : "" ?>">
                <?php echo CHtml::link(Yii::t('static', 'Company Medical Insurrance'), array('patients/companymedical', 'patient_id' => $patient_id), array('class' => 'lagend-custom pull-left')); ?>
            </li>
            <li class="<?php echo $type == 'healthy_notes' ? "active" : "" ?>">
                <?php echo CHtml::link(Yii::t('static', 'Healthy Notes'), array('patients/healthynotes', 'patient_id' => $patient_id), array('class' => 'lagend-custom pull-left')); ?>
            </li>
        </ul>

        <?php 
            switch ($type) {
                case 'patient_registration':
                    $this->renderPartial('information/_registration_information', compact('model', 'defaultInsurrance'));
                    break;
                case 'drugalert':
                    $this->renderPartial('information/_drug_alert', compact('model', 'patient_id', 'dataProvider'));
                    break;
                case 'appointment_history':
                    $this->renderPartial('information/_appointment_history', compact('model', 'patient_id', 'dataProvider'));
                    break;
//                case 'dispensing_history':
//                    $this->renderPartial('information/_despensing_history_prescription', compact('model', 'patient_id', 'prescription', 'depensing'));
//                    break;
                case 'payment_history':
                    $this->renderPartial('information/_payment_history', compact('model', 'patient_id', 'dataProvider'));
                    break;
                case 'medical_record':
                    $this->renderPartial('information/_medical_record', compact('model', 'patient_id', 'dataProvider'));
                    break;
                case 'company_medical':
                    $this->renderPartial('information/_company_medical_insurrance', compact('model', 'patient_id', 'dataProvider'));
                    break;
                case 'healthy_notes':
                    $this->renderPartial('information/_healthy_notes', compact('model', 'patient_id', 'heightweight', 'healthytype', 'blood_pressure', 'glucose'));
                    break;
            }
        ?>

    </div>
</div>

