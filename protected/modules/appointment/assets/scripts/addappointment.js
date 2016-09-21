$(function(){

    $('.f-operation').hide();
    if ($("input[name='Appointment[eventType]']:checked").val() == 'appt') {
        $('.f-operation').hide();
        $('.f-appointment').show();
    } else {
        $('.f-operation').show();
        $('.f-appointment').hide();
    }

    $("input[name='Appointment[eventType]']").change(function () {
        var number = $("input[name='Appointment[eventType]']:checked").val();
        if (number == 'appt') {
            $('.f-operation').hide();
            $('.f-appointment').show();
        } else {
            $('.f-operation').show();
            $('.f-appointment').hide();
        }
        $("input[name='Appointment[eventType]']:checked").parent().parent().parent().addClass("active");
    });

    $(".bookdatepicker").datepicker({
        showOtherMonths: true,
        selectOtherMonths: true,
        changeMonth: true,
        dateFormat: "D M d, yy",
        changeYear: true,
        onSelect: function (dateText) {
            if ($(this).hasClass('startDate')) {
                $(".endDate").val($(this).val());
            }
            checkWorkingDay();
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
            if ($('#' + inst.id).hasClass('startTime')) {
                var d = new Date();
                d.setHours($('#' + inst.id).timepicker('getHour'));
                d.setMinutes($('#' + inst.id).timepicker('getMinute') + 15);
                $('.endTime').timepicker('setTime', d);
            }
            if ($('#' + inst.id).hasClass('startTime_show')) {
                var d = new Date();
                d.setHours($('#' + inst.id).timepicker('getHour'));
                d.setMinutes($('#' + inst.id).timepicker('getMinute') + 15);
                $('.endTime_show').timepicker('setTime', d);
                $('.startTime').val($('.startTime_show').timepicker('getHour')+':'+$('.startTime_show').timepicker('getMinute'));
                $('.endTime').val($('.endTime_show').timepicker('getHour')+':'+$('.endTime_show').timepicker('getMinute'));
            }
            checkWorkingDay();
        }
    });

    $('.visit_reason_text').hide();
    $('#Appointment_visit_reason').change(function (event) {
        if ($(this).val() == 2)
            $('.visit_reason_text').show();
        else
            $('.visit_reason_text').hide();
        
        if ($(this).val() == 3)
            $('#Appointment_is_new_patient').val(0);
        
        if ($(this).val() == 0)
            $('#Appointment_is_new_patient').val(1);
    });
    $('#Appointment_doctor_id').change(function (event) {
        checkNotWorkingDay();
    });
    checkWorkingDay();//check load page
});

function checkWorkingDay() {//Ajax function check working date/time - get time by datetime picker
    //$(".btn-primary").attr('disabled', 'disabled');
    doctor_id = $('#Appointment_doctor_id').val();
    date = $.datepicker.formatDate('yy-mm-dd', $('.bookdatepicker').datepicker('getDate'));
    time = $('.startTime').val() + ':00';
    startdate = $.datepicker.formatDate('yy-mm-dd', $('.startDate').datepicker('getDate'));
    endate = $.datepicker.formatDate('yy-mm-dd', $('.endDate').datepicker('getDate'));
    starttime = startdate + ' ' + ($('.startTime').val() == '' ? '00':$('.startTime').val());
    endtime = endate + ' ' + ($('.endTime').val() == '' ? '00':$('.startTime').val());

    update_id = $('#hiddId').val();
    noAppointmentText = '<p>No Appointments! </p>';
    notworking_msg = '<p>This time is not working</p>';
    blackout_msg = '<p>This is a Blackout Time!</p>';
    ddifferent_date_msg = '<p>Unable to book appointment<br/>Check date – the dates are on different days</p>';
    existTime_msg = '<p>Time slot is taken</p>';

    urlBlackout = $('#ajaxCheckBlackoutDate').val();
    urlNotWorking = $('#ajaxCheckNotWorkingDate').val();
    urlExistTime = $('#ajaxCheckExistTime').val();

    if (startdate != endate) {
        showErrorMsg(noAppointmentText+different_date_msg);
    }
    else {
        $.ajax({
            url: urlExistTime,//Check timeslot
            type: 'post',
            data: {doctor_id: doctor_id, date: date, time: time, update_id: update_id},
            async: false,
            cache: false,
            timeout: 10000,
        }).done(function (data) {
            if (data == 0) {
//                $.ajax({
//                    url: urlBlackout,//Check doctor leave blackout
//                    type: 'post',
//                    data: {doctor_id: doctor_id, starttime: starttime, endtime: endtime},
//                    async: false,
//                    cache: false,
//                    timeout: 10000,
//                })
//                .done(function (data) {
//                    if (data == 0) {
//                        $.ajax({
//                            url: urlNotWorking,//Check time table
//                            type: 'post',
//                            data: {doctor_id: doctor_id, date: date + ' ' + time},
//                            async: false,
//                            cache: false,
//                            timeout: 10000,
//                        })
//                        .done(function (data) {
//                            if (data == 0) {
//                                hideErrorMsg();
//                            }
//                            else {
//                                showErrorMsg(noAppointmentText+notworking_msg);//Show error message
//                            }
//                        });
//                    }
//                    else {
//                        showErrorMsg(noAppointmentText+blackout_msg);//Show error message
//                    }
//                });
            }
            else  {
                showErrorMsg(existTime_msg);//Show error message
                $(".btn-primary").removeAttr('disabled');//Allow to save
            }
        });
    }
}

$('#Appointment_visit_reason').change(function(e){
    var selectValue = $(this).val();
    if (selectValue == 0)
        $('#Appointment_is_new_patient').val(1);
})

function showErrorMsg(msg) {
    $(".btn-primary").attr('disabled', 'disabled');//Not allow to save
    $('.off-msg').html(msg);
    $('.error-time').show();
}

function hideErrorMsg() {
    $(".btn-primary").removeAttr('disabled');//Allow to save
    $('.error-time').hide();
}

function validateNumber() {    
    $(".numeric-control").keydown(function(e){
        var key = e.which;    
        // backspace, add, tab, left arrow, up arrow, right arrow, down arrow, delete, numpad decimal pt, period, enter
        if (key != 8 && key != 107 &&  key != 187 &&  key != 16 && key != 9 && 
            key != 37 && key != 38 && key != 39 && key != 40 && key != 46 && key != 110 && 
            key != 190 && key != 13 && key != 96 && key != 97 && key != 98 &&  key != 99 
            && key != 100 && key != 101 && key != 102 && key != 103 && key != 104 && key != 105)
        {
            if (e.shiftKey)
            {
                if (key == 61)
                    return key.returnValue;
                else
                    e.preventDefault();
            }
            else
            {
                if (key < 48){
                    e.preventDefault();
                }
                else if (key > 57){
                    e.preventDefault();
                }
            }
        }
    });
}
validateNumber()