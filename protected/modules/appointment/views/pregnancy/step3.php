<?php
$base_url = Yii::app()->theme->baseUrl;
$this->title = Yii::t('static', 'Book FCC Appointment');

$this->menu = array(
    array('label' => Yii::t('static', 'Previous Page'), 'url' => 'javascript:history.go(-1)', 'class' => 'btn-1'),
);

$doctorName = 'No Doctor Preference';
$doctorUUId = 0;

if (!empty($booking['fcc_doctor_uuid'])) {
    $c            = new CDbCriteria;
    $c->compare('uuid', $booking['fcc_doctor_uuid']);
    $doctor = FccDoctor::model()->find($c);
    $doctorName = $doctor->fullName;
    $doctorUUId = $doctor->uuid;
}

$appointmentDateText = '';
if ($mBooking->start == $mBooking->end) {
	$appointmentDateText = date('l, d F Y, h:i A',strtotime($mBooking->start));
}
else {
	$appointmentDateText = date('l, d F Y, h:i A',strtotime($mBooking->start)).' - '.date('l, d F Y, h:i A',strtotime($mBooking->end));
}

?>
<div class="form-type">
	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'booking-form',
		// Please note: When you enable ajax validation, make sure the corresponding
		// controller action is handling ajax validation correctly.
		// There is a call to performAjaxValidation() commented in generated controller code.
		// See class documentation of CActiveForm for details on this.
		'enableAjaxValidation'=>false,
		// 'action' => Yii::app()->createAbsoluteUrl($this->route,array('step' => 4)),
	)); ?>



	<div class="col-md-4 nopadding-left">
		<div class="welcome">
			<p>Referral Doctor: <?php echo Yii::app()->params['doctorName']; ?></p>
			<p>FCC Consultant in charge: <?php echo $doctorName; ?> </p>
			<p>Type: <?php echo $scanText; ?> </p>
			<p>Appointment: <?php echo $appointmentDateText; ?></p>
		</div>
	</div>

	<div class="book-form col-md-4">
			<h3>Please fill in patient’s details: </h3>
			<div class="form-group">
				<?php echo $form->labelEx($mBooking,'patient_name'); ?>
		        <?php echo $form->textField($mBooking,'patient_name',array('size'=>45,'maxlength'=>45,'class'=>'form-control', 'required' => 'required')); ?>
		        <?php echo $form->error($mBooking,'patient_name'); ?>
			</div>
			<div class="form-group">
				<?php echo $form->labelEx($mBooking,'patient_ncic'); ?>
		        <?php echo $form->textField($mBooking,'patient_ncic',array('size'=>45,'maxlength'=>45,'class'=>'form-control', 'required' => 'required')); ?>
		        <?php echo $form->error($mBooking,'patient_ncic'); ?>
			</div>
			<div class="form-group">
				<?php echo $form->labelEx($mBooking,'dob'); ?>
		        <?php echo $form->textField($mBooking,'dob',array('size'=>45,'maxlength'=>45,'class'=>'form-control dob-datepicker', 'required' => 'required')); ?>
		        <?php echo $form->error($mBooking,'dob'); ?>
			</div>
			<div class="form-group">
                <?php echo $form->labelEx($mBooking, 'patient_contact'); ?>
				<div class="clearfix"></div>
				<div class="col-md-6" style="padding-left: 0 !important; margin-left: 0 !important;">
					<?php echo $form->dropDownList($mBooking,'area_code_id', AreaCode::getAreaCode(), array('class'=>'form-control patient-info rechedule nopadding-left', 'style' => '', 'required' => 'required')); ?>
				</div>
				<div class="col-md-6" style="padding-left: 0 !important; margin-left: 0 !important;">
					<?php echo $form->textField($mBooking,'patient_contact',array('size'=>45,'maxlength'=>45,'class'=>'form-control', 'required' => 'required','style' => '')); ?>
				</div>
				<div class="clearfix"></div>
            </div>
	</div>
	<div class="book-form col-md-4">
			<h3>&nbsp;</h3>
			<div class="form-group">
				<?php echo $form->labelEx($mBooking,'previous_scan'); ?>
				<?php echo $form->textField($mBooking,'previous_scan',array('class'=>'form-control datepicker')); ?>
				<?php echo $form->error($mBooking,'previous_scan'); ?>
			</div>

			<div class="form-group">

				G <?php echo $form->textField($mBooking,'g',array('size' => 2)); ?>
				P <?php echo $form->textField($mBooking,'p',array('size' => 2)); ?>

			</div>

			<div class="form-group">
				<?php echo $form->labelEx($mBooking,'medical_history'); ?>
				 <?php echo $form->textArea($mBooking, 'medical_history', array('class' => 'form-control','rows'=>2)); ?>
				 <?php echo $form->error($mBooking,'medical_history'); ?>
			</div>

			<div class="form-group">
				<?php echo $form->labelEx($mBooking,'comments'); ?>
				 <?php echo $form->textArea($mBooking, 'comments', array('class' => 'form-control','rows'=>2)); ?>
				 <?php echo $form->error($mBooking,'comments'); ?>
			</div>
			<div class="form-group">
				<input type="submit" value="Book Appointment"  class="btn btn-primary"/>
			</div>

		<div class="clearfix"></div>
	</div>
	<div class="clearfix"></div>

	<?php $this->endWidget(); ?>
</div>
<div class="clearfix"></div>

<?php
Yii::app()->clientScript->registerCssFile($base_url . '/css/jquery-ui.css');
Yii::app()->clientScript->registerCssFile($base_url . '/js/fullcalendar/fullcalendar.css');
// Yii::app()->clientScript->registerCssFile($base_url . '/js/fullcalendar/fullcalendar.print.css','print');
Yii::app()->clientScript->registerScriptFile($base_url . '/js/jquery-ui.custom.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile($base_url . '/js/moment.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile($base_url . '/js/fullcalendar/fullcalendar.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile($base_url . '/js/jquery.multiselect.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile($base_url . '/scripts/fixcalendar.js', CClientScript::POS_END);
?>


<script type="text/javascript">
$(function() {
	$(".datepicker").datepicker({
        showOtherMonths: true,
        selectOtherMonths: true,
        changeMonth: true,
        dateFormat: "dd-mm-yy",
        changeYear: true,
    });
    $(".dob-datepicker").datepicker({
        showOtherMonths: true,
        selectOtherMonths: true,
        changeMonth: true,
        dateFormat: "dd-mm-yy",
        changeYear: true,
        // defaultDate: 'today',
        yearRange: '1940:2016',
    });
});
</script>
