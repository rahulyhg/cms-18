<?php
$this->title = Yii::t('static', 'EDD Calendar');

$this->menu=array(
	array('label' => Yii::t('static', 'Previous Page'), 'url' => 'javascript:history.go(-1)', 'class' => 'btn-1'),
    array('label'=>Yii::t('static','Appointments'), 'url'=>array('index'), 'class' => 'btn-1'),
	array('label'=>Yii::t('static','Book FCC Appointment'), 'url'=>array('book'), 'class' => 'btn-1'),
);

?>
<div class="form-type">
	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'booking-form',
		// Please note: When you enable ajax validation, make sure the corresponding
		// controller action is handling ajax validation correctly.
		// There is a call to performAjaxValidation() commented in generated controller code.
		// See class documentation of CActiveForm for details on this.
		'enableAjaxValidation'=>false,
		// 'action' => Yii::app()->createAbsoluteUrl($this->route,array('step' => 2)),
	)); ?>


	<div class="col-md-3 row">
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
		<div class="form-group">
			<input type="submit" value="Submit"  class="btn btn-primary"/>
		</div>
	</div>

	<div class="clearfix"></div>
	<?php $this->endWidget(); ?>
</div>
<div class="clearfix"></div>
<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/jquery-ui.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/js/fullcalendar/fullcalendar.css');
// Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/js/fullcalendar/fullcalendar.print.css','print');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery-ui.custom.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/moment.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/fullcalendar/fullcalendar.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.multiselect.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/scripts/fixcalendar.js', CClientScript::POS_END);
?>

<input type="hidden" id="ajaxCalculateEDD" value="<?php echo Yii::app()->createAbsoluteUrl('/manage/pregnancy/getEDD/'); ?>" />

<script type="text/javascript">
$(function() {

	$(".datepicker").datepicker({
        showOtherMonths: true,
        selectOtherMonths: true,
        changeMonth: true,
        dateFormat: "yy-mm-dd",
        changeYear: true,
    });

    


});
</script>