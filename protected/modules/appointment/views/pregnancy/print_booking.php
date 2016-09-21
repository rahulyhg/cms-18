<p class="print-now"><a title="" onclick="return window.print();" href="javascript:;" style="text-decoration: none;" ><img src="<?php echo Yii::app()->baseUrl . '/img/print-icon.png' ?>" /> Print now</a></p>
<div class="clearfix"></div>
<h3 style="color:#EE5733; font-weight:bold">Fetal Care Centre</h3>
<h4 style="color:#EE5733; font-weight:bold">National University Hospital Instant Appointment Booking Service</h4>
<hr/>
<div class="clearfix"></div>
<div class="col-xs-12nopadding-left">
	<div class="book_success_info">
		<p><strong>Appointment Date: </strong><?php echo date('d/m/Y',strtotime($mBooking->timeslot->appointment_date)); ?></p>
		<p><strong>Appointment Time: </strong><?php echo date('h:i a',strtotime($mBooking->timeslot->appointment_date)); ?></p>
	</div>
	<div class="book_success_info">
		<p><strong>Booked  by <?php echo $mBooking->fccmember->name; ?> from <?php echo $mBooking->fccmember->clinic_name; ?> </strong></p>
	</div>
	<div class="book_success_info">
		<p><strong>Patient Name 		 :</strong> <?php echo $mBooking->patient_name; ?></p>
		<p><strong>Patient ID		     :</strong></strong> <?php echo $mBooking->patient_ncic; ?></p>
		<p><strong>Patient Contact Number:</strong> <?php echo $mBooking->patient_contact; ?></p>
		<p><strong>Scan Type	 		 :</strong> <?php echo Booking::$scanType[$mBooking->scan_type]; ?></p>
		<p><strong>LMP			 		 :</strong> <?php echo date('d/m/Y', strtotime($mBooking->lmp)); ?></p>
		<p><strong>EDD           		 :</strong> <?php echo date('d/m/Y', strtotime($mBooking->edd)); ?></p>
		<p><strong>Clinical Notes		 :</strong></p>
		<p><?php echo $mBooking->note; ?></p>
	</div>
	<hr/>
	<div class="book_success_info" style="color:#575656;">
		<p><strong>Address: Fetal Care Centre, National University Hospital</strong></p>
		<p><strong>Contact Information: Tel: 67725180; Fax 67724974</strong></p>
		<p><strong>NOTE: Call our centre at 67725180 if you need to make any changes to the above booking which has been confirmed.</strong></p>
	</div>
</div>
<div class="clearfix"></div>
<style type="text/css">
.print-now {
  	float: right;
  	font-weight: bold;
  }
@media print {
  .print-now {
  	float: right;
  	font-weight: bold;
    display: none;
  }
}

</style>