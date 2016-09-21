
var monthList = ['January','February','March','April','May','June','July','August','September','October','November','December'];
// var defaultDate = moment().format('YYYY-MM-DD');
var defaultDate = '';
var leaveEvents = new Array();
var commonBlackoutEvents = new Array();
var doctor_id;
$(document).ready(function() {
    $('.fc-center').html('');
    doctor_id = $('#commonData').attr('doctorId');
    var hash = window.location.hash.replace('#', '');//get params from url
    var params = hash.split("|");

    if (params[1] != null) {
        doctor_id = params[1];
    }

    var d = new Date(params[0]);
    if (!isNaN(d.getMonth())) {
        defaultDate = params[0];
        calendarChange(doctor_id);
    }

    var _dt = new Date();
    var scroll_time = _dt.getHours() + ":" + _dt.getMinutes() + ":" + _dt.getSeconds();
    // var scroll_time = '08:00:00';
    if (params[2] != null) scroll_time = params[2] + ':00';
    renderSmallCal();

    $('#small-prev').click(function() {
        to_date = new Date();
        curMonth = new Date(curMonth.getFullYear(), curMonth.getMonth() - 1, 1);
        $('#small-month').text(monthList[curMonth.getMonth()] + " " + curMonth.getFullYear());
        $('#small-cal').empty();
        renderSmallCal(curMonth);
        // curMonth.setDate(curMonth.getDate()+1);
        // to_date.setDate(to_date.getDate()+1);
        if (to_date.getMonth() == curMonth.getMonth()) {
            $('#calendar').fullCalendar('gotoDate', to_date);
        } else {
            curMonth.setDate(1);
            $('#calendar').fullCalendar('gotoDate', curMonth);
        }
        $('#calendar').fullCalendar('changeView', 'month');

        changeEventSmallCalendar();
        calendarChange(doctor_id);
    });
    $('#small-next').click(function() {
        to_date = new Date();
        curMonth = new Date(curMonth.getFullYear(), curMonth.getMonth() + 1, 1);
        $('#small-month').text(monthList[curMonth.getMonth()] + " " + curMonth.getFullYear());
        $('#small-cal').empty();
        renderSmallCal(curMonth);
        // curMonth.setDate(curMonth.getDate()+1);
        // to_date.setDate(to_date.getDate()+1);
        if (to_date.getMonth() == curMonth.getMonth()) {
            $('#calendar').fullCalendar('gotoDate', to_date);
        } else {
            curMonth.setDate(1);
            $('#calendar').fullCalendar('gotoDate', curMonth);
        }
        $('#calendar').fullCalendar('changeView', 'month');
        changeEventSmallCalendar();
        calendarChange(doctor_id);
    });
    changeEventSmallCalendar();
    $('#calendar').fullCalendar({
        header: {
            left: '',
            center: '',
            right: 'month,agendaWeek,agendaDay,resourceDay'
        },
        slotMinutes: 15,
        slotDuration: '00:05:00',
        defaultDate: defaultDate != '' ? defaultDate : null,
        defaultView: defaultDate != '' ? 'agendaDay' : 'month',
        buttonText: {
            today: 'Today',
            month: 'Month',
            week: 'Week',
            day: 'Day'
        },
        allDayText: 'Notices',
        scrollTime: scroll_time,
        editable: false,
        columnFormat: {
            week: 'ddd D/M/YY',
            day: 'dddd, D/M/YYYY'
        },
        timeFormat: 'h:mma',
        // events: blackoutEvents,
        height: 700,
        dayClick: function(date, jsEvent, view) {
            var curdate = moment(date.format('YYYY-MM-DD')).unix();
            if (view.name == 'month' || date.hasTime()) {
                $('#calendar').fullCalendar('gotoDate',date);
                $('#calendar').fullCalendar('changeView','agendaDay');
                activeSmallCalendarDate(moment(date.format('YYYY-MM-DD')).unix());
                calendarChange(doctor_id);
            }
            if (view.name == 'agendaDay' || view.name=='agendaWeek') {
                $("#appointment-form")[0].reset();//Reset form before booking appointment
                // $("#addAppointmentPopup").fancybox().trigger('click');;
                bookDate = $('#calendar').fullCalendar('getDate').format('ddd MMM DD, YYYY');
                bookTime = $('#calendar').fullCalendar('getDate').format('hh:mm A');

                $('.bookStartDate').val(bookDate);
                $('.bookEndDate').val(bookDate);

                var d = new Date(bookDate + ' ' + bookTime);
                $('.startTime_show').timepicker('setTime',d);
                d.setMinutes(d.getMinutes() + 15);
                $('.endTime_show').timepicker('setTime', d);

                $('.startTime').val($('.startTime_show').timepicker('getHour')+':'+$('.startTime_show').timepicker('getMinute'));
                $('.endTime').val($('.endTime_show').timepicker('getHour')+':'+$('.endTime_show').timepicker('getMinute'));
                checkWorkingDay();//check load page
                $('#frmAddppointment').modal('show');
            }
        },
        eventClick: function(event) {
            view = $('#calendar').fullCalendar('getView').name;
            if (view == 'month') {
                $('#calendar').fullCalendar('gotoDate',event.start);
                $('#calendar').fullCalendar('changeView','agendaDay');
                calendarChange(doctor_id);
            }
        },
        eventRender: function(event, element)
        {
            element.attr('title', event.description);

        }
    });

    $('#closeNewApptPopup').click(function(){
        calendarChange(doctor_id);
        url = $('#deleteUnreadNew65doctorBooking').val();
        $.post(url);
    });
    //Event change ------------------------------
    $('.fc-agendaWeek-button, .fc-prev-button, .fc-next-button, .fc-agendaDay-button, .fc-month-button, .day-cell a').click( function() { //Event week click
        calendarChange(doctor_id);
    });

    $('.fc-agendaWeek-button').click(function(event) {
        calendar = $('#calendar');
        year = calendar.fullCalendar('getDate').format('YYYY');
        month = calendar.fullCalendar('getDate').format('MM');
        day = calendar.fullCalendar('getDate').format('DD');
        selectDate = new Date(year,month,day);
        selectDate = Date.parse(selectDate)/1000;
        $('.current-week').removeClass('active');
        $('.day-cell a[date="'+selectDate+'"]').parent('td').parent('tr').addClass('current-week active');
    });


    $('.fc-prev-button').click(function(event) {
        today = new Date();
        calendar = $('#calendar');
        viewName = $('#calendar').fullCalendar('getView').name;
        year = calendar.fullCalendar('getDate').format('YYYY');
        month = calendar.fullCalendar('getDate').format('MM');
        day = calendar.fullCalendar('getDate').format('DD');
        selectDate = new Date(year,month,day);
        if (viewName == 'month') {
            $( "#small-prev" ).trigger( "click" );
        }
        else if (viewName == 'agendaWeek') {
            selectDate = Date.parse(selectDate)/1000;
            $('.current-week').removeClass('active');
            $('.day-cell a[date="'+selectDate+'"]').parent('td').parent('tr').addClass('current-week active');
        }
        else {
            selectDate = Date.parse(selectDate)/1000;
            $('.day-cell').removeClass('active');
            $('.day-cell a[date="'+selectDate+'"]').parent('td').addClass('active');
        }

    });
    $('.fc-next-button').click(function(event) {
        today = new Date();
        calendar = $('#calendar');
        viewName = $('#calendar').fullCalendar('getView').name;
        year = calendar.fullCalendar('getDate').format('YYYY');
        month = calendar.fullCalendar('getDate').format('MM');
        day = calendar.fullCalendar('getDate').format('DD');
        selectDate = new Date(year,month,day);

        if (today.getMonth() != selectDate.getMonth) {
            $('#small-month').text(monthList[selectDate.getMonth()] + " " + selectDate.getFullYear());
            $('#small-cal').empty();
            renderSmallCal(selectDate);
        }

        if (viewName == 'month') {
            $( "#small-next" ).trigger( "click" );
        }
        else if (viewName == 'agendaWeek') {
            selectDate = Date.parse(selectDate)/1000;
            $('.current-week').removeClass('active');
            $('.day-cell a[date="'+selectDate+'"]').parent('td').parent('tr').addClass('current-week active');
        }
        else {
            selectDate = Date.parse(selectDate)/1000;
            $('.day-cell').removeClass('active');
            $('.day-cell a[date="'+selectDate+'"]').parent('td').addClass('active');

        }
    });

    //First Load ==================================
    calendarChange(doctor_id);
    loadNocticeBoard($('#calendar').fullCalendar('getDate').format('YYYY-MM-DD'));

    var leaveEventData = getLeaveEvent(doctor_id);//Get leave events | doctor leave
    $.each(leaveEventData, function() {
        event = new Object();
        event.start = this.start;
        event.end = this.end;
        event.title = this.title;
        event.className = 'blackout';
        event.allDay = true;
        event.url = this.url;
        leaveEvents.push(event);
    });

    var commonBlackoutData = getCommonBlackout();//Get common events | holiday; other
    $.each(commonBlackoutData, function() {
        event = new Object();
        event.start = this.start;
        event.end = this.end;
        event.title = this.title;
        event.className = 'blackout';
        if(this.type === 'notice') event.className = 'notice';
        event.allDay = true;
        event.url = this.url;
        commonBlackoutEvents.push(event);
    });

});

function calendarChange(doctor_id) {
    setTimeout(function(){
        $('#calendar').fullCalendar('removeEvents');
            calendar = $('#calendar');
            year = calendar.fullCalendar('getDate').format('YYYY');
            month = calendar.fullCalendar('getDate').format('MM');
            day = calendar.fullCalendar('getDate').format('DD');
            selectDate = new Date(year,month,day);
            $('#calendar').fullCalendar('removeEventSources');
            viewName = $('#calendar').fullCalendar('getView').name;
            // alert(viewName);
            if (viewName == 'month') {
                $('.current-week').removeClass('active');
                $('.fc-center').hide();
                getMonthCalendarData(doctor_id);
            }
            else if (viewName == 'agendaWeek') {
                $('.fc-center').hide();
                getWeekCalendarData(doctor_id);
            }
            else {
                $('.current-week').removeClass('active');
                $('.fc-center').html('');
                $('.fc-center').show();
                selectDate = Date.parse(selectDate)/1000;
                $('.day-cell').removeClass('active');
                $('.day-cell a[date="'+selectDate+'"]').parent('td').addClass('active');
                getDayCalendarData(doctor_id);
            }
            $('#calendar').fullCalendar('addEventSource', leaveEvents);//Add leave event
            $('#calendar').fullCalendar('addEventSource', commonBlackoutEvents);//Add leave event
    }, 0);
}

function getMonthCalendarData(doctor_id) { // Month calendar
    currentDate = $('#calendar').fullCalendar('getDate');
    currentMonth = currentDate.format('MM');
    currentYear = currentDate.format('YYYY');

    firstDay = $('#calendar').fullCalendar('getView').start.format('YYYY-MM-DD');
    lastDay = $('#calendar').fullCalendar('getView').end.format('YYYY-MM-DD');
    $('#Appointment_startDate').val(firstDay);
    $('#Appointment_endDate').val(lastDay);

    url = $('#commonData').attr('urlGetMonthEvent');
    $.ajax({//Add event for selected date
        type: "POST",
        dataType: "json",
        async: false,
        cache: false,
        timeout: 30000,
        url: url, //Relative or absolute path to response.php file
        data: {month: currentMonth, year: currentYear, doctor_id: doctor_id},
        success: function(data) {
            var monthEvents = new Array();
            $.each(data, function() {
                event = new Object();
                        totalEvent =
                            this.fuConsult
                            + this.newConsult
                            + this.chemotherapy
                            + this.others
                            + this.operation
                            + this._65doctor;
                        if (totalEvent > 0) {//If have one more events then show it
                        event.title = 'Operation = ' + this.operation
                            + '\nFU Consult = '+ this.fuConsult
                            + '\nNew Consult = '+ this.newConsult
                            + '\nChemotherapy = '+ this.chemotherapy
                            + '\n65doctor = '+ this._65doctor
                            + '\nOthers = '+ this.others
                            + '\nTotal = ' + totalEvent;
                        event.start = this.date;
                        event.end = this.date;
                        event.allDay = true;
                        monthEvents.push(event);
                        event.className = 'sumary';
                        var curdate = moment(event.start).unix();
                        // event.url = this.url;
                }
            });
            $('#calendar').fullCalendar('addEventSource', monthEvents);

        }
    });
}

function getWeekCalendarData(doctor_id) { // Week calendar
    // cdate = $('.day-cell a').attr(date);
    // $('#calendar').fullCalendar('gotoDate',  cdate);
    startWeek = $('#calendar').fullCalendar('getView').intervalStart;
    startWeek = (new Date(startWeek)).toISOString().slice(0, 10); //Format yy-mm-dd
    endWeek = $('#calendar').fullCalendar('getView').intervalEnd;
    endWeek = (new Date(endWeek)).toISOString().slice(0, 10); //Format yy-mm-dd

    firstDay = $('#calendar').fullCalendar('getView').start.format('YYYY-MM-DD');
    lastDay = $('#calendar').fullCalendar('getView').end.format('YYYY-MM-DD');
    $('#searchStartDate').val(firstDay);
    $('#searchEndDate').val(lastDay);

    url = $('#commonData').attr('urlGetWeekEvent');
    $.ajax({//Add event for selected date
        type: "POST",
        dataType: "json",
        async: false,
        cache: false,
        timeout: 30000,
        url: url, //Relative or absolute path to response.php file
        data: {date: startWeek, doctor_id: doctor_id},
        success: function(data) {
            var newWeekApppointmentEvents = new Array();
            $.each(data, function() {
                event = new Object();
                event.title = this.title;
                event.start = this.start;
                event.end = this.end;
                event.className = this.className;
                event.resources = this.resources;
                event.description = this.description;
                event.allDay = this.allDay;
                event.backgroundColor = this.backgroundColor;
                event.url = this.url;
                newWeekApppointmentEvents.push(event);
            });
            $('#calendar').fullCalendar('addEventSource', newWeekApppointmentEvents);
        }
    });
}

function getDayCalendarData(doctor_id) { // Day calendar
    current = $('#calendar').fullCalendar('getDate').format('YYYY-MM-DD');
    loadNocticeBoard(current);
    url = $('#commonData').attr('urlGetDayEvent');
    // urlHasLeave = $('#ajaxHasLeave').val();
    // urlDateEvent = $('#ajaxDayEvent').val();

    firstDay = $('#calendar').fullCalendar('getView').start.format('YYYY-MM-DD');
    $('#searchStartDate').val(firstDay);
    $('#searchEndDate').val(firstDay);

    urlDoctorTime = $('#commonData').attr('urlGetDoctorTime');
    $.ajax({//Add event for selected date
        type: "POST",
        dataType: "json",
        async: false,
        cache: false,
        timeout: 30000,
        url: urlDoctorTime, //Relative or absolute path to response.php file
        data: {doctor_id: doctor_id, date: current},
        success: function(rs) {
            $('.fc-center').html('<h2>'+rs+'</h2>');
        }
    });


    $.ajax({//Add event for selected date
        type: "POST",
        dataType: "json",
        async: false,
        cache: false,
        timeout: 30000,
        url: url, //Relative or absolute path to response.php file
        data: {date: current, doctor_id: doctor_id, },
        success: function(data) {
            alert(data);
        var newApppointmentEvents = new Array();
            $.each(data, function() {
                event = new Object();
                event.title = this.title;
                event.start = this.start;
                event.end = this.end;
                event.className = this.className;
                event.resources = this.resources;
                event.description = this.description;
                event.allDay = this.allDay;
                event.backgroundColor = this.backgroundColor;
                event.url = this.url;
                newApppointmentEvents.push(event);

            });
            $('#calendar').fullCalendar('addEventSource', newApppointmentEvents);
        }
    });
}

function getLeaveEvent(doctor_id) {
    url = $('#commonData').attr('urlGetLeaveEvent');
    var rs = '';
    $.ajax({//Add blackout event for selected doctor
        type: "POST",
        dataType: "json",
        url: url, //Relative or absolute path to response.php file
        data: {doctor_id: doctor_id},
        async: false,
        cache: false,
        timeout: 30000,
        success: function(data) {
            rs = data;
        }
    });
    return rs;
}

function getCommonBlackout() {
    url = $('#commonData').attr('urlGetCommonBlackout');
    var rs = '';
    $.ajax({//Add blackout event for selected doctor
        type: "POST",
        dataType: "json",
        url: url, //Relative or absolute path to response.php file
        async: false,
        cache: false,
        timeout: 30000,
        success: function(data) {
            rs = data;
        }
    });
    return rs;
}

function loadNocticeBoard(date) {
    url = $('#commonData').attr('urlloadNoticeBoard');
    $('#noticeBoard .panel-body').html('');
    dateFormat = $.datepicker.formatDate('dd MM, yy', new Date(date));
    $('#noticeDate').html(dateFormat);
    $.ajax({//Add blackout event for selected doctor
        type: "POST",
        dataType: "json",
        url: url, //Relative or absolute path to response.php file
        async: false,
        cache: false,
        timeout: 30000,
        data: {date: date},
        success: function(data) {
            $.each(data, function() {
                $('#noticeBoard .panel-body').append('<div><h5>'+this.title+'</h5><p>'+this.content+'</p></div><hr/>');
            });
        }
    });
}


//Render small calendar ===============================================
// var curMonth = new Date();
var to_date = new Date();
var monthNames = monthList;
function renderSmallCal(selectDate = new Date()) {
    curMonth = selectDate;
    // $('.calendar-content').html('');
    // mainCalendarDate = new Date($('#calendar').fullCalendar('getDate'));
    var hash = window.location.hash.replace('#', '');
    var params = hash.split("|");
    var dfd = new Date(params[0]);
    // alert(dfd);
    // if (!isNaN(mainCalendarDate)) {
    //     curMonth = mainCalendarDate;
    //     $('#small-month').html(monthNames[curMonth.getMonth()]);
    // }
    if (!isNaN(dfd.getMonth())) {
        curMonth = dfd;
        $('#small-month').html(monthNames[curMonth.getMonth()]);
    }

    var body = $('#small-cal');
    var prevMonth = new Date(curMonth.getFullYear(), curMonth.getMonth(), 0);
    // render prev month
    var firstWD = new Date(curMonth.getFullYear(), curMonth.getMonth(), 1).getDay();
    var lastDate = new Date(curMonth.getFullYear(), curMonth.getMonth() + 1, 0).getDate();
    var dayCount = lastDate + firstWD;
    var dd = 1;
    while (dayCount > 0) { // loop for every tr
        var tr = $('<tr />');
        var d = 0;
        if (firstWD > 0) {
            var prevMonthLastD = prevMonth.getDate();
            for (var i = 0; i < firstWD; i++) {
                var td = $('<td/>');
                //td.addClass('invi');
                //td.text(''+prevMonthLastD-(firstWD-1-i));
                tr.append(td);
                d++;
            }
            firstWD = 0;
        }



        for (i = d; i < 7 && dd <= lastDate; i++) {
            var cellDate = new Date(curMonth.getFullYear(), curMonth.getMonth()+1, dd);
            var a = $('<a/>');
            a.text('' + dd);
            a.attr('href', '#');
            a.attr('date', Date.parse(cellDate)/1000);
            a.attr('date-full', cellDate.getFullYear()+'-'+cellDate.getMonth()+'-'+dd);
            a.click(function() {
                // alert(curMonth.getFullYear()+'-'+(curMonth.getMonth()+1)+'-'+this.text);
                var toDate = new Date(curMonth.getFullYear(), curMonth.getMonth(), this.text);
                toDate.setDate(toDate.getDate() + 1);
                $('#calendar').fullCalendar('gotoDate', toDate.toISOString());
                $('#calendar').fullCalendar('changeView', 'agendaDay');
                $('.current-week').removeClass('active');
                // cdate = $('#calendar').fullCalendar('getDate').format('YYYY-MM-DD');
                // alert(cdate);
                return false;
            });
            if (!isNaN(dfd.getMonth())) {
                if (dfd.getDate() == dd) {
                    tr.append($('<td class="day-cell active"/>').append(a)); //Active current date
                    tr.addClass('current-week');
                } else {
                    tr.append($('<td class="day-cell"/>').append(a));
                }
            } else {
                if (to_date.getMonth() == curMonth.getMonth()) {
                    if (to_date.getDate() == dd) {
                        tr.append($('<td class="day-cell active"/>').append(a)); //Active current date
                        tr.addClass('current-week');
                    } else {
                        tr.append($('<td class="day-cell"/>').append(a));
                    }
                } else {
                    if (curMonth.getDate() == dd) {
                        tr.append($('<td class="day-cell"/>').append(a)); //Active current date
                        tr.addClass('current-week');
                    } else {
                        tr.append($('<td class="day-cell"/>').append(a));
                    }
                }
            }
            dd++;
        }
        body.append(tr);
        dayCount -= 7;
    }
}

function changeEventSmallCalendar() {
    $('.day-cell a').click(function() { //Active current date
        $('.day-cell').removeClass('active');
        $(this).parent('.day-cell').addClass('active');

    });
}

function activeSmallCalendarDate(date) {
    $('.day-cell').removeClass('active');
    $( "a[date='"+date+"']" ).parent('.day-cell').addClass('active');

}
