<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'booking-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>
<div class="welcome pull-left">
	<p>Welcome to Fetal Care Centre, National University Hospital Instant Appointment Booking Service</p>
	<p>Select the time slot and fill in the form below to book an appointment</p>
	<p>Note that time slots are colour coded to Consultant in charge for that session</p>
</div>

<div class="date-button pull-right">
	<?php 
		$pre_week_link = $prev_week == 0 ? 'javascript:void(0);':Yii::app()->createAbsoluteUrl('site/index/',array('date'=>$prev_week));
		$pre_month_link = $prev_month == 0 ? 'javascript:void(0);':Yii::app()->createAbsoluteUrl('site/index/',array('date'=>$prev_month));

		$next_week_link = Yii::app()->createAbsoluteUrl('site/index/',array('date'=>$next_week));
		$next_month_link = Yii::app()->createAbsoluteUrl('site/index/',array('date'=>$next_month));
	?>
	<div class="prev-button btn-changedate pull-left"><a href="<?php echo $pre_week_link; ?>" class="<?php echo $prev_week == 0 ? 'disable':'';?>">Prev 7 Days<img src="<?php echo Yii::app()->theme->baseUrl; ?>/img/prev-icon.png" class="pull-left"></a></div>
	<div class="next-button btn-changedate pull-right"><a href="<?php echo $next_week_link; ?>">Next 7 Days<img src="<?php echo Yii::app()->theme->baseUrl; ?>/img/next-icon.png" class="pull-right"></a></div>
	<div class="clearfix"></div>
	<div class="prev-button btn-changedate pull-left"><a href="<?php echo $pre_month_link; ?>" class="<?php echo $prev_month == 0 ? 'disable':'';?>">Prev Month<img src="<?php echo Yii::app()->theme->baseUrl; ?>/img/prev-icon.png" class="pull-left"></a></div>
	<div class="next-button btn-changedate pull-right"><a href="<?php echo $next_month_link; ?>">Next Month<img src="<?php echo Yii::app()->theme->baseUrl; ?>/img/next-icon.png" class="pull-right"></a></div>
</div>

<div class="clearfix"></div>

<div class="responsive_table" id="tblTimeslot">
	<?php echo $form->error($mBooking,'timeslot_id'); ?>
	<table class="timeslot-table col-md-12">
		<thead>
			<tr>
				<th>&nbsp;</th>
			<?php
				$interval = DateInterval::createFromDateString('1 day');
    			$period = new DatePeriod($startDate, $interval, $endDate);
    			foreach ($period as $dt) :
			?>
				<th>
					<p><?php echo $dt->format('D'); ?></p>
					<p><?php echo $dt->format('d M Y'); ?></p>
				</th>
			<?php endforeach; ?>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td rowspan="100%">
				<?php
					foreach ($doctorList as $doctor) :
				?>
					<p class="doctor-name"><a href="javascript:void(0);" class="box-<?php echo $doctor->box_color ?>"><?php echo $doctor->fullname ?></a></p>
				<?php endforeach; ?>
				</td>
			<?php
				$interval = DateInterval::createFromDateString('1 day');
    			$period = new DatePeriod($startDate, $interval, $endDate);
    			foreach ($period as $dt) :
			?>
				<td class="timeslot_data">
				<?php foreach ($doctorList as $doctor) :
					$timeslots = Timeslot::getTimeslots($doctor->id,$dt->format('Y-m-d'));
				?>
					<?php foreach ($timeslots as $timeslot) :
					?>
						<p class="time-data"><a href="javascript:void(0);" timslotId = "<?php echo $timeslot->id; ?>" class="box-<?php echo $doctor->box_color; ?>"><?php echo date('h:i A', strtotime($timeslot->appointment_date)); ?></a></p>
					<?php endforeach; ?>
				<?php endforeach; ?>
				</td>
			<?php endforeach; ?>
			</tr>

		</tbody>
	</table>
	<div class="clearfix"></div>
</div>
<div class="book-form">
	<h3>Booked  by Dr Name from Clinic ABC</h3>
	<?php echo $form->errorSummary($mBooking, Yii::t('validation','Please fix the following input errors:')); ?>
	<?php echo $form->hiddenField($mBooking,'timeslot_id',array('size'=>45,'maxlength'=>45,'class'=>'form-control')); ?>

	<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 nopadding-left">
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
			<?php echo $form->labelEx($mBooking,'patient_contact'); ?>
	        <?php echo $form->textField($mBooking,'patient_contact',array('size'=>45,'maxlength'=>45,'class'=>'form-control', 'required' => 'required')); ?>
	        <?php echo $form->error($mBooking,'patient_contact'); ?>
		</div>
	</div>
	<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
		<div class="form-group">
			<?php echo $form->labelEx($mBooking,'scan_type'); ?>
			<?php echo $form->dropDownList($mBooking,'scan_type',Booking::$scanType,array('class'=>'form-control')); ?>
			<?php echo $form->error($mBooking,'scan_type'); ?>
		</div>
		<div class="form-group">
			<?php echo $form->labelEx($mBooking,'lmp'); ?>
			<?php echo $form->textField($mBooking,'lmp',array('class'=>'form-control datepicker')); ?>
			<?php echo $form->error($mBooking,'lmp'); ?>
		</div>
		<div class="form-group">
			<?php echo $form->labelEx($mBooking,'edd'); ?>
			<?php echo $form->textField($mBooking,'edd',array('class'=>'form-control datepicker')); ?>
			<?php echo $form->error($mBooking,'edd'); ?>
		</div>
	</div>
	<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 nopadding-right">
		<div class="form-group">
			<?php echo $form->labelEx($mBooking,'note'); ?>
			 <?php echo $form->textArea($mBooking, 'note', array('class' => 'form-control','rows'=>6)); ?>
			 <?php echo $form->error($mBooking,'note'); ?>
		</div>
		<div class="form-group">
			<input type="submit" value="Book Appointment"  class="btn btn-primary"/>
		</div>
	</div>
	<div class="clearfix"></div>
</div>
<?php $this->endWidget(); ?>
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/scripts/fcc_bookform.js"></script>