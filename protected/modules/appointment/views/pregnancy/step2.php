<?php
$base_url = Yii::app()->theme->baseUrl;
$this->title = Yii::t('static', 'Book FCC Appointment');

$this->menu = array(
    array('label' => Yii::t('static', 'Previous Page'), 'url' => Yii::app()->createAbsoluteUrl('/appointment/pregnancy/book/step/1'), 'class' => 'btn-1'),
);

$doctorName = 'No Doctor Preference';
$doctorUUId = 0;

if (!empty($booking['doctor_selected'])) {
    $c            = new CDbCriteria;
    $c->compare('uuid', $booking['doctor_selected']);
    $doctor = FccDoctor::model()->find($c);
    $doctorName = $doctor->fullName;
    $doctorUUId = $doctor->uuid;
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
        // 'action' => Yii::app()->createAbsoluteUrl($this->route,array('step' => 3)),
    )); ?>
    <div class="row pull-right" style="margin-top:30px;">
        <div class="col-md-5">
            <div class="form-group">
                <input type="submit" value="Next page"  class="btn btn-primary btnsubmit" />
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="welcome">
        <h3>You have selected:</h3>
        <p><?php echo $doctorName; ?> + <?php echo FccBooking::$pregnancyType[$booking['pregnancy_type']] ?> <?php echo $scanText; ?></p>
        <p>Lmp: <?php echo $booking['lmp'] != '' ? date('d M Y',strtotime($booking['lmp'])) :''; ?></p>
        <p>Edd: <?php echo $booking['edd'] != '' ? date('d M Y',strtotime($booking['edd'])) :''; ?></p>
    </div>
    <div class="clearfix"></div>


    <div class="responsive_table datetimeType1" id="tblTimeslot">
        <div  style="width: 100%;" class="next-prev-button">
            <div class="pull-left"><a href="<?php echo Yii::app()->createAbsoluteUrl('/appointment/pregnancy/book/step/2/?startDate='.$prev_week); ?>" class="btn btn-default btn-sm">See Time Slots Previous Week</a></div>
            <div class="pull-right"><a href="<?php echo Yii::app()->createAbsoluteUrl('/appointment/pregnancy/book/step/2/?startDate='.$next_week); ?>" class="btn btn-default btn-sm">See Time Slots Next Week</a></div>
            <div class="clearfix"></div>
        </div>
        <table class="timeslot-table col-md-12">
            <thead>
            <tr>
                <th class="first-col">&nbsp;</th>
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
                <td class="first-col">Notices</td>
                <?php
                $interval = DateInterval::createFromDateString('1 day');
                $period = new DatePeriod($startDate, $interval, $endDate);
                foreach ($period as $dt) :
                    $notices = Notice::getNoticeTimeslot($dt->format('Y-m-d'));
                    ?>
                    <td>
                        <?php foreach($notices as $item) { ?>
                            <p class="notice"><?php echo $item->title; ?></p>
                        <?php } ?>
                    </td>
                <?php endforeach; ?>
            </tr>
            <tr>
                <td class="first-col">&nbsp;</td>
                <?php
                $interval = DateInterval::createFromDateString('1 day');
                $period = new DatePeriod($startDate, $interval, $endDate);
                foreach ($period as $dt) :
                    ?>
                    <td class="timeslot_data d<?php echo $dt->format('Y-m-d'); ?>" date="<?php echo $dt->format('Y-m-d'); ?>"></td>
                <?php endforeach; ?>
            </tr>

            </tbody>
        </table>
        <div class="clearfix"></div>
    </div>

    <div class="form-group datetimeType2" style="width: 400px; display: none;">
        <?php echo $form->labelEx($mBooking, 'startTime'); ?>
        <div class="clearfix"></div>
        <div class="col-sm-7 col" style="padding-left: 0;">
            <?php echo $form->textField($mBooking, 'startDate', array('class' => 'form-control bookdatepicker startDate')); ?>
        </div>
        <div class="col-sm-5 col">
            <?php echo $form->textField($mBooking, 'startTime_show', array('class' => 'form-control booktimepicker startTime_show')); ?>
            <?php echo $form->textField($mBooking, 'startTime', array('class' => 'form-control startTime')); ?>
        </div>
        <div class="clearfix"></div>
        <?php echo $form->labelEx($mBooking, 'endTime'); ?>
        <div class="clearfix"></div>
        <div class="col-sm-7 col" style="padding-left: 0;">
            <?php echo $form->textField($mBooking, 'endDate', array('class' => 'form-control bookdatepicker endDate')); ?>
        </div>
        <div class="col-sm-5 col">
            <?php echo $form->textField($mBooking, 'endTime_show', array('class' => 'form-control booktimepicker endTime_show')); ?>
            <?php echo $form->textField($mBooking, 'endTime', array('class' => 'form-control endTime')); ?>
        </div>
        <?php echo $form->dropDownList($mBooking, 'fcc_doctor_uuid', CHtml::listData($doctorList, 'uuid', 'fullName'), array('empty' => 'No Doctor Preference', 'class' => 'form-control', 'style' => 'width:85%;')) ?>
        <div class="clearfix"></div>
    </div>
    <div class="clearfix"></div>



    <?php $this->endWidget(); ?>
</div>
<div class="clearfix"></div>

<?php
$clientScript = Yii::app()->clientScript;
$clientScript->registerCssFile($base_url . '/css/jquery-ui-1.10.3.custom.min.css');
$clientScript->registerCssFile($base_url . '/css/jquery-ui.css');
$clientScript->registerCssFile($base_url . '/js/fullcalendar/fullcalendar.css');
$clientScript->registerCssFile($base_url . '/css/jquery.ui.timepicker.css');
$clientScript->registerScriptFile($base_url . '/js/jquery-ui.custom.min.js', CClientScript::POS_END);
$clientScript->registerScriptFile($base_url . '/js/jquery.ui.timepicker.js', CClientScript::POS_END);
$clientScript->registerScriptFile($base_url. '/js/moment.min.js', CClientScript::POS_END);
$clientScript->registerScriptFile($base_url . '/js/fullcalendar/fullcalendar.js', CClientScript::POS_END);
$clientScript->registerScriptFile($base_url . '/js/jquery.multiselect.min.js', CClientScript::POS_END);
$clientScript->registerScriptFile($base_url . '/scripts/fixcalendar.js', CClientScript::POS_END);

?>

<input type="hidden" id="ajaxLoadTemplate" value="<?php echo Yii::app()->createAbsoluteUrl('/appointment/ajax/getBookingTimeslot'); ?>" />


<script type="text/javascript">
    $(function() {
        $('.btnsubmit').attr('disabled', 'disabled');
        loadTemplate("<?php echo $doctorUUId; ?>");
        $(".bookdatepicker").datepicker({
            showOtherMonths: true,
            selectOtherMonths: true,
            changeMonth: true,
            dateFormat: "yy-mm-dd",
            changeYear: true,
            onSelect: function (dateText) {

            }
        });

        $('.booktimepicker').timepicker({
            hourText: "Hour",
            minuteText: "Minute",
            amPmText: ["AM", "PM"],
            showNowButton: true,
            showDeselectButton: true,
            showCloseButton: true,
            showLeadingZero: true,
            showPeriod: true,
            onClose: function (time, inst) {
                if ($('#' + inst.id).hasClass('startTime_show')) {
                    var d = new Date();
                    d.setHours($('#' + inst.id).timepicker('getHour'));
                    d.setMinutes($('#' + inst.id).timepicker('getMinute') + 15);
                    $('.startTime').val($('.startTime_show').timepicker('getHour')+':'+$('.startTime_show').timepicker('getMinute'));
                }
            }
        });
    });


    var click = 0;
    var timeIndexStart = -1;
    var timeIndexEnd = -1;

    function loadTemplate(doctor_id) {
        url = $('#ajaxLoadTemplate').val();
        $.ajax({
                url: url,
                type: 'POST',
                data: {doctor_uuid: doctor_id, startDate: "<?php echo $startTimeslot;  ?>", endDate: "<?php echo $endTimeslot;  ?>"},
                dataType: 'json',
                async: false,
                cache: false,
                timeout: 30000,
            })
            .done(function(data) {
                count = 0;
                $.each(data, function() {
                    timeText = this.time_text;
                    $('.d'+this.date).append('<p class="time-data '+this.meridiem+'" index="'+count+'" hour="'+ this.hour +'" minute="'+ this.minute +'" time="'+this.time+'" day="'+this.day_name+'" date="'+this.date+'" date_time="'+this.date_time+'" doctor_uuid="'+this.doctor_uuid+'"><span>'+timeText+'</span></p>');
                    count++;
                });
                $('.time-data').click(function(event) {
                    date = $(this).attr('date');
                    time = $(this).attr('time');
                    datetime = date+ ' ' +time;
                    if (click == 0) {
                        var d = new Date();
                        d.setHours($(this).attr('hour'));
                        d.setMinutes($(this).attr('minute'));

                        $('.startTime_show').timepicker('setTime', d);
                        $('.startTime').val($('.startTime_show').timepicker('getHour')+':'+$('.startTime_show').timepicker('getMinute'));
                        $( ".startDate" ).datepicker( "setDate", new Date(date));

                        $('.endTime_show').timepicker('setTime', d);
                        $('.endTime').val($('.endTime_show').timepicker('getHour')+':'+$('.endTime_show').timepicker('getMinute'));
                        $( ".endDate" ).datepicker( "setDate", new Date(date));

                        $('.time-data').removeClass('active');
                        $(this).addClass('active');
                        click = 1;
                        timeIndexStart = $(this).attr('date_time');
                        $('#FccBooking_fcc_doctor_uuid').val($(this).attr('doctor_uuid'));
                    }
                    else {
                        timeIndexEnd = $(this).attr('date_time');
                        if (timeIndexStart != timeIndexEnd) {
                            if ($(this).hasClass('active')) {
                                $(this).removeClass('active');
                            }
                            $('.time-data').removeClass('active');

                            if (timeIndexEnd >= timeIndexStart) {
                                $('.time-data[date_time="'+timeIndexStart+'"]').addClass('active');
                                $('.time-data[date_time="'+timeIndexEnd+'"]').addClass('active');
                                $('.time-data[date_time="'+timeIndexStart+'"]').nextUntil('.time-data[date_time="'+timeIndexEnd+'"]').addClass('active');
                            }
                            else {
                                $('.time-data[date_time="'+timeIndexStart+'"]').addClass('active');
                                $('.time-data[date_time="'+timeIndexEnd+'"]').addClass('active');
                                $('.time-data[date_time="'+timeIndexEnd+'"]').nextUntil('.time-data[date_time="'+timeIndexStart+'"]').addClass('active');
                            }
                            var d = new Date();
                            d.setHours($('.time-data.active').last().attr('hour'));
                            d.setMinutes($('.time-data.active').last().attr('minute'));

                            $('.endTime_show').timepicker('setTime', d);
                            $('.endTime').val($('.endTime_show').timepicker('getHour')+':'+$('.endTime_show').timepicker('getMinute'));
                            $( ".endDate" ).datepicker( "setDate", new Date(date));

                            var d = new Date();
                            d.setHours($('.time-data.active').first().attr('hour'));
                            d.setMinutes($('.time-data.active').first().attr('minute'));

                            $('.startTime_show').timepicker('setTime', d);
                            $('.startTime').val($('.startTime_show').timepicker('getHour')+':'+$('.startTime_show').timepicker('getMinute'));
                            $( ".startDate" ).datepicker( "setDate", new Date(date));
                            $('#FccBooking_fcc_doctor_uuid').val($('.time-data.active').attr('doctor_uuid'));
                        }

                        click=0;
                    }

                    $('.btnsubmit').removeAttr('disabled');
                });
            });
    }
</script>

<style type="text/css" media="screen">
    #timeslot-table-tb th {
        background-color: #DA4A38;
        padding: 15px 0;
        color: #FFF;
    }
    #timeslot-table-tb th, #timeslot-table-tb td {
        border: 1px solid #BEBEBE;
        text-align: center;
    }
    #timeslot-table-tb td.timeslot_data {
        padding: 15px 10px;
        width: 12%;
        vertical-align: top;
    }
    .timeslot_data p {
        padding: 4px;
        font-weight: bold;
        font-size: 12px;
        /*width: 40%;
        float: left;
        margin-right: 10px;*/
        cursor: pointer;
    }

    p.time-data.AM{
        background-color: #FDE8B8;
        border-radius: 5px;
        color: #8B6136;
    }

    p.time-data.PM {
        background-color: #C1DCFD;
        border-radius: 5px;
        color: #8B6136;
    }

    .timeslot_data p.active {
        border: 2px solid #812828;
    }

    .doctor_name {
        color: #DA4A38;
    }
    .notice {
        background: #F8DB92;
        font-size: 13px;
        padding: 2px;
    }
    .timeslot-table-tb .first-col {
        width: 50px !important;
    }
    .timeslot-table .timeslot_data {
        width: 14%;
    }

    .next-prev-button .btn{
        background: #58BFE4;
        color: #FFF;
        border: 1px solid #00A6C7;
        margin-bottom: 15px;
        padding: 5px;;
    }
</style>