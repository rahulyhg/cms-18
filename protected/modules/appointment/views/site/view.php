<?php
$this->breadcrumbs = array(
    Yii::t('static', 'Add ppointment'),
);

$this->menu = array(
    // array('label' => Yii::t('static', 'Log out'), 'url' => array('/site/logout'), 'class' => 'btn-1'),
    // array('label' => Yii::t('static', 'Add Appointment'), 'url' => array('/appointment/site/addAppointment'), 'class' => 'btn-1'),
    array('label' => Yii::t('static', 'Delete'), 'url' => array('/appointment/site/delete/id'.$model->id), 'class' => 'btn-1'),
    array('label' => Yii::t('static', 'Previous Page'), 'url' => 'javascript:history.go(-1)', 'class' => 'btn-1'),
);

$this->title = Yii::t('static', 'Update ppointment');
?>
<div class="form-type">
    <div class="clearfix"></div>
	<div class="row">
		<div class="col-md-4">
            <div class="form-group">
                <label>Patient: <?php echo $model->patient_name; ?></label>
            </div>
            <div class="form-group">
                <label>Doctor: <?php echo $model->doctor->name ?></label>
            </div>
			<div class="form-group">
                <label>Start Time: <?php echo date("h:ia l d F Y", strtotime($model->timeslot->start)) ?></label>
            </div>
            <div class="form-group">
                <label>End Time: <?php echo date("h:ia l d F Y", strtotime($model->timeslot->start)) ?></label>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label>Patient ID: <?php echo $model->patientId; ?></label>
            </div>
            <div class="form-group">
                <label>Patient Mobile: <?php echo '(+'. AreaCode::model()->findByPk($model->area_code_id)->area_code.') '.HString::correctCalendarText($model->patient_mobile); ?></label>
            </div>
            <div class="form-group">
                <label>Patient Email: <?php echo $model->patient_email; ?></label>
            </div>
		</div>

		<div class="col-md-4">
        <?php  if ($model->is_operation) { ?>
            <div class="f-operation">
                <div class="form-group">
                    <label>Admission Hospital: <?php echo $modelOperation->admission_hospital; ?></label>
                </div>
                <div class="form-group">
                    <label>Where In Hospital: <?php echo $modelOperation->where_in_hospital; ?></label>
                </div>
                <div class="form-group">
                    <label>Bed Type': <?php echo $modelOperation->bed_type; ?></label>
                </div>
                <div class="form-group">
                    <label>Anaesthesia Type: <?php echo $modelOperation->anaesthesia_type; ?></label>
                </div>
                <div class="form-group">
                    <label>Anaesthetist: <?php echo $modelOperation->anaesthetist; ?></label>
                </div>
                <div class="form-group">
                    <label>Preparation: <?php echo $modelOperation->preparation; ?></label>
                </div>
                <div class="form-group">
                    <label>Surgical Assistant: <?php echo $modelOperation->surgical_assistant; ?></label>
                </div>
                <div class="form-group">
                    <label>Operation Type: <?php echo $modelOperation->operation_type == 'in' ? Yii::t('model', 'In Patient') : Yii::t('model', 'Day Surgery') ?></label>
                </div>
            </div>
        <?php } ?>
			<div class="form-group f-appointment">
                <label>Visit Reason: <?php echo Appointment::$visit_reason[$model->visit_reason]; ?></label>
            </div>
            <?php if ($model->visit_reason == 2) { ?>
                <div class="form-group visit_reason_text f-appointment">
                    <label>Visit Text: <?php echo $model->visit_reason_text; ?></label>
                </div>
            <?php } ?>
            <div class="form-group">
                <label>New Patient: <?php echo $model->is_new_patient == 1 ? 'Yes':'No'; ?></label>
            </div>
            <div class="form-group f-appointment">
                <label>Comment: </label>
                <div><?php echo $model->comments; ?></div>
            </div>
		</div>
	</div>
</div>



<style type="text/css">
    <?php if ($model->is_operation) { ?>
        .f-operation { display: block;}
        .f-appointment { display: none;}
    <?php } else { ?>
        .f-operation { display: none;}
        .f-appointment { display: block;}
    <?php } ?>
    .error-time { background: #DA4A38; color: #FFFFFF; padding: 10px; font-weight: bold; width: 95%; display: none;}
    #doctor-time-table table { margin: 20px 0 20px 0;}
</style>

