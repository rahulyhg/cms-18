<?php
$this->title = Yii::t('static', 'Book Success');

$doctorName = 'No Doctor Preference';
$doctorUUId = 0;

if (!empty($booking['fcc_doctor_uuid'])) {
    $c            = new CDbCriteria;
    $c->compare('uuid', $booking['fcc_doctor_uuid']);
    $doctor = FccDoctor::model()->find($c);
    $doctorName = $doctor->fullName;
    $doctorUUId = $doctor->uuid;
}

?>

<div class="success">
	<h3>Appointment Confirmation</h3>
	<p>This appointment is confirmed. </p>
 	<p>To make changes, please contact FCC at Tel: 6772 5180 for assistance</p>
</div>



<div class="doctor-info" style="width:30%; float: left; margin-right:30px;">
	<p>Referral Doctor:  <?php echo Yii::app()->params['doctorName']; ?></p>
	<p>FCC Consultant in charge:  <?php echo $doctorName; ?></p>
	<p>Type:  <?php echo $scanText ?></p>
	<p>Appointment: <?php echo $booking->appointmentTime; ?></p><br/>
	<p>Patient Name:  <?php echo $data->patient_name; ?></p>
	<p>Patient ID: <?php echo $data->patient_ncic; ?></p>
	<?php
		 $date = new DateTime($data->dob);
		 $now = new DateTime();
		 $interval = $now->diff($date);
		 $age =  $interval->y;
	?>
	<p>Date of birth: <?php echo date('d M Y',strtotime($data->dob)); ?>; Age: <?php echo $age; ?> years old</p>
</div>


<div class="patient-info" style="width:30%; float: left; margin-right:20px;">
	<p>Contact Number: <?php echo '(+'. AreaCode::model()->findByPk($data->area_code_id)->area_code.') '.HString::correctCalendarText($data->patient_contact); ?></p>
	<p>Date of previous scan in FCC: <?php echo $data->previous_scan !== '' ? date('d l, M Y',strtotime($data->previous_scan)) : ''; ?></p>
	<p>G<?php echo $data->g; ?>P<?php echo $data->p; ?> </p>
	<p>LMP : <?php echo $data->lmp !== '' ? date('d l, M Y',strtotime($data->lmp)):""; ?></p>
	<p>EDD :  <?php echo $data->edd !== '' ? date('d l, M Y',strtotime($data->edd)):""; ?></p>
	<p>Medical conditions: <?php echo $data->medical_history; ?></p>
	<p>Reason for U/S scan OR procedure<br>Note to FCC doctor: <?php echo $data->comments; ?></p>
</div>

<div style="width:30%; float: right;" class="abutton">
	<div>
		<p><a href="<?php echo Yii::app()->createAbsoluteUrl('/appointment/pregnancy/cancelBooking/', array('id'=>$booking->id)); ?>" class="btn btn-primary">Cancel this appointment</a></p>
		<!-- <p><a href="<?php echo Yii::app()->createAbsoluteUrl('/manage/pregnancy/updateBooking/', array('id'=>$booking->id)); ?>" class="btn btn-primary">Edit this appointment</a></p> -->
		<p><a href="<?php echo Yii::app()->createAbsoluteUrl('/appointment/pregnancy/book'); ?>" class="btn btn-primary">Book another appointment appointment</a></p>
		<p><p><a href="<?php echo Yii::app()->createAbsoluteUrl('/appointment/pregnancy/index'); ?>" class="btn btn-primary">Return to Appointment list</a></p></p>
	</div>
</div>
<div class="clearfix"></div>


<div class="clearfix"></div>
<style type="text/css" media="screen">
	.success {
		padding: 20px;
		background: #A6E32F;
		font-size: 18px;
		margin: 20px auto;
		width: 590px;
	}
	.abutton a {
		color: #FFF;
	}
	.doctor-info, .patient-info {
		font-size: 16px;
	}
</style>