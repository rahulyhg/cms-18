<?php foreach ($model as $app) { ?>
	<div class="app-item">
		<div class="col-md-3"><b>Name:</b></div> <div class="col-md-9"><?php echo $app->doctor->name; ?></div>
		<div class="clearfix"></div>
		<div class="col-md-3"><b>Appointment:</b></div> <div class="col-md-9"><?php echo date('h:ia l d F Y', strtotime($app->timeslot->start)) ?></div>
		<div class="clearfix"></div>
		<div class="col-md-3"><b>Patient:</b></div> <div class="col-md-9"><?php echo $app->patient_name; ?></div>
		<div class="clearfix"></div>
		<div class="col-md-3"><b>Contact:</b></div> <div class="col-md-9"><?php echo $app->patientContact; ?></div>
		<div class="clearfix"></div>
	</div>
<?php } ?>

<style>
	.app-item {
		border-top: 1px solid #CCCCCC;
		padding: 20px 0;
	}
	.app-item:last-child {
		margin-bottom: 0px;
		padding-bottom: 0px;
	}
	.app-item:first-child {
		border: none !important;
		padding-top: 10px;
	}
</style>
