<?php
/* @var $this DoctorController */
/* @var $model Doctor */

Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl . '/css/form.css');

$this->breadcrumbs = array(
    Yii::t('static', 'Appointments / Operations'),
    Yii::t('static', 'Create'),
);

$this->menu = array(
    array('label' => Yii::t('static', 'Cancel and Return'), 'url' => array('/site'), 'class' => 'btn-1'),
);

// $this->title = Yii::t('static', 'Add Appointment / Operation');
?>

<div class="form-type">

    <div class="box-1">
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'appointment-form',
            'enableAjaxValidation' => true,
                ));
        ?>
        <div class="title-box clearfix">
            <h2 class="title"><?php echo Yii::t('static', 'Add Appointments') ?></h2>
            <span class='type-op'><?php echo CHtml::submitButton(Yii::t('static', 'Add Operation'), array('class' => 'btn btn-primary')); ?></span>
            <span class="type-appt"><?php echo CHtml::submitButton(Yii::t('static', 'Add Appointment'), array('class' => 'btn btn-primary pull-right')); ?></span>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-12 ">
                    <?php echo $form->errorSummary($model, Yii::t('validation', 'Please fix the following input errors:')); ?>
                    <?php echo $form->hiddenField($model, 'patient_id') ?>
                </div>
                <div class="col-md-12 ">
                    <ul class="list-2 clearfix">
                        <li class="active"><?php echo $form->radioButton($model, 'eventType', array('id' => 'appointment', 'class' => 'radio-type', 'value' => 'appt', 'checked' => true, 'uncheckValue' => null)) ?><label for="appointment"><?php echo Yii::t('static', 'Appointment') ?></label></li>
                        <li class="last"><?php echo $form->radioButton($model, 'eventType', array('id' => 'operation', 'class' => 'radio-type', 'value' => 'op', 'uncheckValue' => null)) ?><label for="operation"><?php echo Yii::t('static', 'Operation') ?></label></li>
                    </ul>
                </div>

                <div class="col-md-4 col-sm-12 row" id="main-info">
                    <div class=" col-md-12 form-group">
                        <?php echo $form->labelEx($model, 'doctor_id'); ?>
                        <?php echo $form->dropDownList($model, 'doctor_id', CHtml::listData($doctorList, 'id', 'fullName'), array('class' => 'form-control', 'style' => 'width:90%;')) ?>
                        <div class="clearfix"></div>
                    </div>
                    <div class="col-md-12 form-group" style="display:none;">
                        <?php echo $form->labelEx($model, 'clinic_id'); ?>
                        <?php echo $form->dropDownList($model, 'clinic_id', CHtml::listData($clinicList, 'id', 'name'), array('empty' => 'Select clinic', 'class' => 'form-control', 'style' => 'width:90%; display:none;')) ?>
                        <div class="clearfix"></div>
                    </div>
                    <div class=" col-md-12 form-group">
                        <label for="patientfield"><?php echo Yii::t('static', 'Patient\'s Name') ?></label>
                        <?php echo $form->textField($model, 'name', array('class' => 'typeahead form-control', 'id' => 'patientfield', 'placeholder' => Yii::t('static', 'enter patient\'s name'), 'style' => 'width: 90%')); ?>
                        <?php echo $form->hiddenField($model, 'patient_id', array('id' => 'patientid')); ?>
                    </div>
                    <div class="col-md-12 form-group">
                        <label for="patientfield"><?php echo Yii::t('static', 'Patient\'s ID') ?></label>
                        <?php echo $form->textField($model, 'nric', array('class' => 'typeahead form-control', 'id' => 'patientfield', 'placeholder' => Yii::t('static', 'enter patient\'s ID'), 'style' => 'width: 90%')); ?>
                        <?php echo $form->hiddenField($model, 'patient_id', array('id' => 'patientid')); ?>
                    </div>
                    <div class="col-md-12 form-group">
                        <?php echo $form->labelEx($model, 'contact'); ?>
                        <?php echo $form->textField($model, 'contact', array('class' => 'form-control', 'id' => 'contactfield', 'style' => 'width: 90%')); ?>
                    </div>
                    <div class="col-md-12 type-appt">
                        <div class="form-group">
                            <?php echo $form->labelEx($model, 'visit_reason'); ?>
                            <?php echo $form->dropDownList($model, 'visit_reason', Appointment::$visit_reason, array('class' => 'form-control', 'style' => 'width: 90%')); ?>
                        </div>
                        <div class="form-group visit_reason_text" style="display:none;">
                            <?php echo $form->labelEx($model, 'visit_reason_text'); ?>
                            <?php echo $form->textField($model, 'visit_reason_text', array('class' => 'form-control', 'style' => 'width: 90%')); ?>
                        </div>                
                    </div>
                    <div class="col-md-12 form-group">
                        <div class="form-group">
                            <?php echo $form->labelEx($model, 'is_new_patient'); ?>
                            <?php echo $form->dropDownList($model, 'is_new_patient', Appointment::$is_new_patient, array('class' => 'form-control', 'style' => 'width: 90%')); ?>
                        </div>
                    </div>
                </div>

                <div class="col-md-8 col-sm-16 row other-content">
                    <div id="doctor-time-table"><?php $this->renderPartial('table_template', array('data' => $data)); ?></div>
                    <div class="col-md-6 col-sm-12 type-appt" id="timeInfo">
                        <div class="apptTime">
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
                            </div>
                            <div class="clearfix"></div>
                            <div class="error-time">
                                <div>
                                    <p>No Appointments! </p>
                                    <p class="off-msg">This is a Blackout Date!</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12 type-appt">
                        <div class="form-group">
                            <?php echo $form->labelEx($model, 'comments'); ?>
                            <?php echo $form->textArea($model, 'comments', array('class' => 'form-control', 'rows' => 4)); ?>
                        </div>
                        <!--                <div class="form-group">
                        <?php echo CHtml::submitButton(Yii::t('static', 'Add Appointment'), array('class' => 'btn btn-primary')); ?>
                                        </div>-->
                    </div>

                    <div class="col-md-6 col-sm-12 type-op">
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
                    </div>
                    <div class="col-md-6 col-sm-12 type-op">
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
                        <!--                <div class="form-group">
                        <?php echo CHtml::submitButton(Yii::t('static', 'Add Operation'), array('class' => 'btn btn-primary')); ?>
                                        </div>-->
                    </div>
                </div>

                <div class="clearfix"></div>

            </div>


        </div><!-- form -->
        <?php $this->endWidget(); ?>
    </div>
    <input type="hidden" id="ajaxGetTableTemplate" value="<?php echo Yii::app()->createUrl('appointment/ajaxGetTableTemplate/'); ?>" />
    <input type="hidden" id="ajaxCheckBlackoutDate" value="<?php echo Yii::app()->createUrl('ajax/checkBlackoutDate/'); ?>" />
    <input type="hidden" id="ajaxCheckNotWorkingDate" value="<?php echo Yii::app()->createUrl('ajax/checkNotWorkingDate/'); ?>" />
    <input type="hidden" id="ajaxCheckExistTime" value="<?php echo Yii::app()->createUrl('ajax/checkExistTime/'); ?>" />

    <?php
    $script = 'var datasource = [';
    foreach ($patientlist as $t) {
        $script .= '{label: "' . $t->name . ' [' . $t->identity . ']", name: "' . $t->name . '", phone: "' . $t->contact1 . '", id: "' . $t->id . '"},';
    }
    $script .= '];';
    Yii::app()->clientScript->registerScript('binddata', $script);
    Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl . '/css/jquery-ui-1.10.3.custom.min.css');
    Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl . '/css/jquery-ui.css');
    Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl . '/css/jquery.ui.timepicker.css');
    Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/jquery-ui.custom.min.js', CClientScript::POS_END);
    Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/jquery-ui-1.10.3.custom.min.js', CClientScript::POS_END);
    Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/jquery.ui.timepicker.js', CClientScript::POS_END);
    Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/jquery.validate.min.js', CClientScript::POS_END);
    ?>
    <script type="text/javascript">
        $(function () {

            if ($("input[name='Appointment[eventType]']:checked").val() == 'appt') {
                $('.type-op').hide();
                $('.type-appt').show();
            } else {
                $('.type-op').show();
                $('.type-appt').hide();
            }

            $("input[name='Appointment[eventType]']").change(function () {
                var number = $("input[name='Appointment[eventType]']:checked").val();
                if (number == 'appt') {
                    $('.type-op').hide();
                    $('.type-appt').show();
                    $(".apptTime").detach().appendTo('#timeInfo');
                } else {
                    $('.type-op').show();
                    $('.type-appt').hide();
                    $(".apptTime").detach().appendTo('#main-info');
                }
                $("input[name='Appointment[eventType]']:checked").parent().parent().parent().addClass("active");
            });
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
            // $('.timepicker').change(function(event) {
            //     checkNotWorkingDay();
            // });
            $('#patientfield').autocomplete({delay: 0, minLength: 2,
                source: function (request, response) {
                    var results = $.ui.autocomplete.filter(datasource, request.term);
                    response(results.slice(0, 10));
                },
                select: function (even, ui) {
                    if (ui.item != null) {
                        $('#patientid').val(ui.item.id);
                        $('#contactfield').val(ui.item.phone);
                    }
                }
            });

            $('#Appointment_visit_reason').change(function (event) {
                if ($(this).val() == 2)
                    $('.visit_reason_text').show();
                else
                    $('.visit_reason_text').hide();
            });
            $('#Appointment_doctor_id').change(function (event) {
                checkNotWorkingDay();
                changeDoctorTime();
            });
            checkNotWorkingDay();
            changeDoctorTime();
        });


        function changeDoctorTime() {
            $('#doctor-time-table').html('');
            url = $('#ajaxGetTableTemplate').val();
            doctor_id = $('#Appointment_doctor_id').val();
            $.ajax({
                type: "POST",
                url: url,
                data: {doctor_id: doctor_id, },
            })
            .done(function (rs) {
                $('#doctor-time-table').html(rs);
                //alert(doctor_id);
            });
        }


        function checkNotWorkingDay() {
            $(".btn-primary").attr('disabled', 'disabled');
            doctor_id = $('#Appointment_doctor_id').val();
            date = $.datepicker.formatDate('yy-mm-dd', $('.datepicker').datepicker('getDate'));
            time = $('.timepicker').val() + ':00';

            notworking_msg = 'This time is not working';
            blackout_msg = 'This is a Blackout Time!';
            existTime_msg = 'Selected time is not available';

            urlBlackout = $('#ajaxCheckBlackoutDate').val();
            urlNotWorking = $('#ajaxCheckNotWorkingDate').val();
            urlExistTime = $('#ajaxCheckExistTime').val();
            $.ajax({
                url: urlBlackout,
                type: 'post',
                data: {doctor_id: doctor_id, date: date, time: time},
                async: false,
                cache: false,
                timeout: 10000,
            })
            .done(function (data) {
                // alert('Notworking: '+data);
                if (data == 0) {
                    $.ajax({
                        url: urlNotWorking,
                        type: 'post',
                        data: {doctor_id: doctor_id, date: date + ' ' + time},
                        async: false,
                        cache: false,
                        timeout: 10000,
                    })
                    .done(function (data) {
                        //alert('Blackout: '+data);
                        if (data == 0) {
                            $.ajax({
                                url: urlExistTime,
                                type: 'post',
                                data: {doctor_id: doctor_id, date: date, time: time},
                                async: false,
                                cache: false,
                                timeout: 10000,
                            }).done(function (data) {
                                if (data == 0) {
                                    $(".btn-primary").removeAttr('disabled');
                                    $('.error-time').hide();
                                }
                                else {
                                    $(".btn-primary").attr('disabled', 'disabled');
                                    $('.off-msg').html(existTime_msg);
                                    $('.error-time').show();
                                }
                            });
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