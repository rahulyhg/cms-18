<?php
$this->title = Yii::t('static', 'View FCC Booking');


$this->menu = array(
    // array('label' => Yii::t('static', 'Log out'), 'url' => array('/site/logout'), 'class' => 'btn-1'),
    // array('label' => Yii::t('static', 'Add Appointment'), 'url' => array('/appointment/site/addAppointment'), 'class' => 'btn-1'),
    array('label' => Yii::t('static', 'Previous Page'), 'url' => 'javascript:history.go(-1)', 'class' => 'btn-1'),
    array('label' => Yii::t('static', 'Cancel This Appointment'), 'url' => array('/appointment/pregnancy/cancelBooking/id/'.$booking->id), 'class' => 'btn-1'),
);

?>


<div class="pull-left">

	<div class="doctor-info">
		<p>Referral Doctor:  Demo Doctor</p>
		<p>FCC Consultant in charge:  <?php echo $model->doctorName; ?></p>
		<p>Type:  <?php echo $scanText ?></p>
		<p>Appointment: <?php echo $booking->appointmentTime; ?></p>
	</div>


	<div class="patient-info">
		<p>Patient Name:  <?php echo $data->patient_name; ?></p>
		<p>Patient ID: <?php echo $data->patient_ncic; ?></p>
		<?php
			 $date = new DateTime($data->dob);
			 $now = new DateTime();
			 $interval = $now->diff($date);
			 $age =  $interval->y;
		?>
		<p>Date of birth: <?php echo date('d l Y',strtotime($data->dob)); ?>; Age: <?php echo $age; ?> years old</p>
		<p>Contact Number: <?php echo '(+'. AreaCode::model()->findByPk($data->area_code_id)->area_code.') '.HString::correctCalendarText($data->patient_contact); ?></p>
		<p>Date of previous scan in FCC: <?php echo isset($data->previous_scan) ? date('d l Y',strtotime($data->previous_scan)) : ''; ?></p>
		<p>G<?php echo $data->g; ?>P<?php echo $data->p; ?> </p>
		<p>LMP : <?php echo date('d l Y',strtotime($data->lmp)); ?></p>
		<p>EDD :  <?php echo date('d l Y',strtotime($data->edd)); ?></p>
		<p>Medical conditions: <?php echo $data->medical_history; ?></p>
		<p>Reason for U/S scan OR procedure<br>Note to FCC doctor: <?php echo $data->comments; ?></p>
	</div>
</div>

<div class="clearfix"></div>
<style type="text/css" media="screen">
	.success {
		padding: 20px;
		background: #A6E32F;
		font-size: 18px;
		margin: 0 auto;
		width: 800px;
	}
	.doctor-info {
		margin-bottom: 20px;
	}
	.doctor-info, .patient-info {
		font-size: 16px;
	}
</style>