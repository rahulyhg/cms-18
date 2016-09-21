<div style="width: 500px; overflow: none;">
	<?php if (isset($_REQUEST['is_print'])) { ?>
	<div class="pull-left">
		<button class="btn-1 btn-primary btn printAppointment">Print</button>
	</div>
	<div class="clearfix"></div>
	<?php } ?>
	<div class="pull-left print-section">

		<div class="doctor-info">
			<p><b>Referral Doctor:  </b>Demo Doctor</p>
			<p><b>FCC Consultant in charge:  </b><?php echo $booking->doctorName; ?></p>
			<p><b>Type:  </b><?php echo $scanText ?></p>
			<p><b>Appointment: </b><?php echo $booking->appointmentTime; ?></p>
		</div>


		<div class="patient-info">
			<p><b>Patient Name:  </b><?php echo $data->patient_name; ?></p>
			<p><b>Patient ID: </b><?php echo $data->patient_ncic; ?></p>
			<?php
				 $date = new DateTime($data->dob);
				 $now = new DateTime();
				 $interval = $now->diff($date);
				 $age =  $interval->y;
			?>
			<p><b>Date of birth: </b><?php echo date('d M Y',strtotime($data->dob)); ?>; Age: <?php echo $age; ?> years old</p>
			<p><b>Contact Number: </b><?php echo '(+'. AreaCode::model()->findByPk($data->area_code_id)->area_code.') '.HString::correctCalendarText($data->patient_contact); ?></p>
			<p><b>Date of previous scan in FCC: </b><?php echo $data->previous_scan !== '' ? date('d l, M Y',strtotime($data->previous_scan)) : ''; ?></p>
			<p><b>G</b><?php echo $data->g; ?><b>P</b><?php echo $data->p; ?> </p>
			<p><b>LMP : </b><?php echo $data->lmp !== '' ? date('d l, M Y',strtotime($data->lmp)):""; ?></p>
			<p><b>EDD :  </b><?php echo $data->edd !== '' ? date('d l, M Y',strtotime($data->edd)):""; ?></p>
			<p><b>Medical conditions: </b><?php echo $data->medical_history; ?></p>
			<p><b>Reason for U/S scan OR procedure<br>Note to FCC doctor: </b><?php echo $data->comments; ?></p>
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
		.printAppointment { margin-left: 0px; margin-bottom: 20px;}
	</style>
</div>

<?php
//register javascripts Files
$clientScript = Yii::app()->clientScript;
$base_url = Yii::app()->theme->baseUrl;
$clientScript->registerScriptFile($base_url . '/js/jQuery.print.js', CClientScript::POS_END);
?>

<script>
	$(function() {
		$('.printAppointment').click(function (event) {
			$(".print-section").print({
				noPrintSelector: ".noprint",
				title: "Appointment: <?php echo $booking->appointmentTime; ?>",
			});
		});
	});
</script>
