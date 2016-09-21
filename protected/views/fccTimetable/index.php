<?php
$this->breadcrumbs=array(
    Yii::t('static', 'Doctor\'s Time Table'),
);

$this->menu=array(
    // array('label'=>Yii::t('static', 'Add Time Table'), 'url'=>'javascript:void(0)', 'class'=>'btn-1 add-time'),
    // array('label' => Yii::t('static', 'Log out'), 'url' => array('/site/logout'), 'class' => 'btn-1'),
    array('label' => Yii::t('static', 'Previous Page'), 'url' => 'javascript:history.go(-1)', 'class' => 'btn-1'),
);


$this->title = Yii::t('static', 'Doctor\'s Time Table');
?>

<div class="form-type">
    <div class="row">
        <div class="main-content-inner">
            <div class="clearfix" id="doctor-time-table">
                <?php $this->renderPartial('table_template',array('data' => $data,'daysWeek'=>$daysWeek)); ?>
            </div>
            <div class="form-type">
                <div class="error">
                    <?php if($model->hasErrors()) {echo CHtml::errorSummary($model);} ?>
                </div>
                <form method="post" id="time-table-form" class="tmarg-sx-20" style="display: none;">
                    <div class="col-md-8 col-sm-12 row">
                        <div class="row">
                            <label>Doctor:</label>
                            <?php echo CHtml::dropDownList('FccTimetable[fcc_doctor_uuid]', $model->fcc_doctor_uuid, CHtml::listData($doctors, 'uuid', 'fullName')); ?>
                            <?php echo CHtml::hiddenField('FccTimetable[id]', $model->id); ?>
                        </div>
                        <div class="row clearfix"><input class="btn btn-primary" type="submit" value="<?php echo Yii::t('static', 'Save'); ?>"></div>
                    </div>
                </form>
            </div>
        </div>
</div>
<script type="text/javascript">

$(document).ready(function() {
	$('.cell-time').click(function(event) {
		$('#time-table-form').show();
		timeId= $(this).attr('time_id');
		doctorId = $(this).attr('doctor_id');
		$('#FccTimetable_id').val(timeId);
		$('#FccTimetable_fcc_doctor_uuid').val(doctorId);
		$('.cell-time').parent('td').removeClass('active');
		$(this).parent('td').addClass('active');
	});
});

</script>

<style type="text/css" media="screen">
    select:disabled {
        background: #dddddd;
    }
</style>