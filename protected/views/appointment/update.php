<?php
/* @var $this DoctorController */
/* @var $model Doctor */

Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/form.css');

$this->breadcrumbs = array(
    Yii::t('static', 'Appointments / Operations'),
    Yii::t('static', 'Update'),
);

$this->menu = array(
    array('label' => Yii::t('static', 'Cancel and Return'), 'url' => array('/appointment/view', 'id' => $model->event_id), 'class' => 'btn-1'),
);

// $this->title = Yii::t('static', 'Update ' . ($model->event->type == 'op' ? 'Operation' : ($model->event->type == 'appt' ? 'Appointment' : 'Event')));
?>

<div class="form-type">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'appointment-form',
        'enableAjaxValidation' => true,
    ));
    ?>
    <div class="action-button">
        <?php echo CHtml::submitButton(Yii::t('static', 'Update'), array('class' => 'btn btn-primary')); ?>
    </div>
    <div class="clearfix"></div>
    <div class="row">
        <?php echo $form->errorSummary($model, Yii::t('validation', 'Please fix the following input errors:')); ?>
        <div class="col-md-4 col-sm-12 row">
            <div class="form-group">
                <label>Patient: <?php echo $model->name ?></label>
            </div>
            <div class="form-group">
                <label>Doctor: <?php echo $model->event->doctor->fullName ?></label>
                <input type="hidden" id="hiddDoctorId" value="<?php echo $model->event->doctor_id ?>" />
            </div>


            <div class="form-group">
                <?php echo $form->labelEx($model, 'contact'); ?>
                <?php echo $form->textField($model, 'contact', array('class' => 'form-control')); ?>
            </div>
            <div class="form-group">
                <?php echo $form->labelEx($model, 'startTime'); ?>
                <div class="col-sm-7 col">
                    <?php echo $form->textField($model, 'startDate', array('class' => 'form-control datepicker startDate')); ?>
                </div>
                <div class="col-sm-5 col">
                    <?php echo $form->textField($model, 'startTime', array('class' => 'form-control timepicker startTime')); ?>
                </div>
            </div>
            <div class="form-group">
                <?php echo $form->labelEx($model, 'endTime'); ?>
                <div class="col-sm-7 col">
                    <?php echo $form->textField($model, 'endDate', array('class' => 'form-control datepicker endDate')); ?>
                </div>
                <div class="col-sm-5 col">
                    <?php echo $form->textField($model, 'endTime', array('class' => 'form-control timepicker endTime')); ?>
                </div>
                <div class="clearfix"></div>
                <div class="error-time">
                    <div>
                        <p>No Appointments! </p>
                        <p class="off-msg">This is a Blackout Date!</p>
                    </div>
                </div>
            </div>
             <?php if ($model->event->type == 'appt'): ?>
            <div class=" type-appt">
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'visit_reason'); ?>
                    <?php echo $form->dropDownList($model, 'visit_reason', Appointment::$visit_reason, array('class' => 'form-control', 'style' => 'width: 90%')); ?>
                </div>
                <div class="form-group visit_reason_text" style="display:none;">
                    <?php echo $form->labelEx($model, 'visit_reason_text'); ?>
                    <?php echo $form->textField($model, 'visit_reason_text', array('class' => 'form-control', 'style' => 'width: 90%')); ?>
                </div>                
            </div>
            <?php endif; ?>
            <div class="form-group">
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'is_new_patient'); ?>
                    <?php echo $form->dropDownList($model, 'is_new_patient', Appointment::$is_new_patient, array('class' => 'form-control', 'style' => 'width: 90%')); ?>
                </div>
            </div>
            <div class="form-group">
                <?php echo $form->labelEx($model, 'comments'); ?>
                <?php echo $form->textArea($model, 'comments', array('class' => 'form-control', 'rows' => 6)); ?>
            </div>
        </div>
        <?php if ($model->event->type == 'op'): ?>
            <div class="col-md-4 col-sm-12">
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'admission_hospital'); ?>
                    <?php echo $form->textField($model, 'admission_hospital', array('class' => 'form-control')); ?>
                </div>
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'where_in_hospital'); ?>
                    <?php echo $form->textField($model, 'where_in_hospital', array('class' => 'form-control')); ?>
                </div>
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'bed_type'); ?>
                    <?php echo $form->textField($model, 'bed_type', array('class' => 'form-control')); ?>
                </div>
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'anaesthesia_type'); ?>
                    <?php echo $form->textField($model, 'anaesthesia_type', array('class' => 'form-control')); ?>
                </div>
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'anaesthetist'); ?>
                    <?php echo $form->textField($model, 'anaesthetist', array('class' => 'form-control')); ?>
                </div>
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'preparation'); ?>
                    <?php echo $form->textField($model, 'preparation', array('class' => 'form-control')); ?>
                </div><div class="form-group">
                    <?php echo $form->labelEx($model, 'surgical_assistant'); ?>
                    <?php echo $form->textField($model, 'surgical_assistant', array('class' => 'form-control')); ?>
                </div>
                <div class="form-group list-2 clearfix">
                    <?php echo $form->radioButton($model, 'operation_type', array('id' => 'inpatient', 'value' => 'in', 'class' => 'radio-type')) ?><label for="inpatient"><?php echo Yii::t('model', 'In Patient') ?></label>
                    <?php echo $form->radioButton($model, 'operation_type', array('id' => 'day_surgery', 'value' => 'day', 'class' => 'radio-type')) ?><label for="day_surgery"><?php echo Yii::t('model', 'Day Surgery') ?></label>
                </div>
            </div>
        <?php endif; ?>
        <div class="clearfix"></div>
<!--        <div class="form-group">
            <?php echo CHtml::submitButton(Yii::t('static', 'Update'), array('class' => 'btn btn-primary')); ?>
        </div>-->
    </div>
    <?php $this->endWidget(); ?>
    <input type="hidden" id="ajaxCheckBlackoutDate" value="<?php echo Yii::app()->createUrl('ajax/checkBlackoutDate/'); ?>" />
    <input type="hidden" id="ajaxCheckNotWorkingDate" value="<?php echo Yii::app()->createUrl('ajax/checkNotWorkingDate/'); ?>" />
</div><!-- form -->
<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/jquery-ui-1.10.3.custom.min.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/jquery-ui.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/jquery.ui.timepicker.css');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery-ui.custom.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery-ui-1.10.3.custom.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.ui.timepicker.js', CClientScript::POS_END);
?>
<script type="text/javascript">
    $(function () {
       
        $(".datepicker").datepicker({
            showOtherMonths: true,
            selectOtherMonths: true,
            changeMonth: true,
            dateFormat: "M d, yy",
            changeYear: true,
            onSelect: function (dateText) {
                if ($(this).hasClass('startDate')) {
                    $(".endDate").val($(this).val());
                }
                checkNotWorkingDay();
            }
        });
        $('.timepicker').timepicker({
            hourText: "<?php echo Yii::t('static', 'Hour') ?>",
            minuteText: "<?php echo Yii::t('static', 'Minute') ?>",
            amPmText: ["<?php echo Yii::t('static', 'AM') ?>", "<?php echo Yii::t('static', 'PM') ?>"],
            showNowButton: true,
            showDeselectButton: true,
            showCloseButton: true,
            showLeadingZero: true,
            onClose: function (time, inst) {
                if ($('#' + inst.id).hasClass('startTime')) {
                    var d = new Date();
                    d.setHours($('#' + inst.id).timepicker('getHour'));
                    d.setMinutes($('#' + inst.id).timepicker('getMinute') + 15);
                    $('.endTime').timepicker('setTime', d);
                }
                checkNotWorkingDay();
            }
        });
        
        $('#Appointment_visit_reason').change(function (event) {          
            if ($(this).val() == 2)
                $('.visit_reason_text').show();
            else
                $('.visit_reason_text').hide();
        });
        
        checkNotWorkingDay();
    });


    function checkNotWorkingDay() {
        doctor_id = $('#hiddDoctorId').val();
        date = $.datepicker.formatDate('yy-mm-dd', $('.datepicker').datepicker('getDate'));
        time = $('.timepicker').val() + ':00';

        notworking_msg = 'This time is not working';
        blackout_msg = 'This is a Blackout Date!';

        urlBlackout = $('#ajaxCheckBlackoutDate').val();
        urlNotWorking = $('#ajaxCheckNotWorkingDate').val();
        $.ajax({
            url: urlBlackout,
            type: 'post',
            data: {doctor_id: doctor_id, date: date},
            async: false,
            cache: false,
            timeout: 30000,
        })
                .done(function (data) {
                    // alert('Notworking: '+data);
                    if (data == 0) {
                        $.ajax({
                            url: urlNotWorking,
                            type: 'post',
                            data: {doctor_id: doctor_id, date: date + ' ' + time},
                        })
                                .done(function (data) {
                                    //alert('Blackout: '+data);
                                    if (data == 0) {
                                        $(".btn-primary").removeAttr('disabled');
                                        $('.error-time').hide();
                                    }
                                    else {
                                        $(".btn-primary").attr('disabled', 'disabled');
                                        $('.off-msg').html(notworking_msg);
                                        $('.error-time').show();
                                    }
                                });
                    }
                    else {
                        $(".btn-primary").attr('disabled', 'disabled');
                        $('.off-msg').html(blackout_msg);
                        $('.error-time').show();
                    }
                });
    }
</script>

<style type="text/css">
    .error-time { background: #DA4A38; color: #FFFFFF; padding: 10px; font-weight: bold; width: 95%; display: none;}
</style>