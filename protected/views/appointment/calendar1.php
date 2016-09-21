<?php
$this->breadcrumbs=array(
    Yii::t('static', 'Appointments / Operations'),
);

$this->menu=array(
    array('label'=>Yii::t('static', '<img src="'.Yii::app()->baseUrl . '/css/images/icon-print-sm.png'.'"" /> Print Appointment'), 'url'=>array('/appointment/print_appointment'),'class'=>'btn-1'),
    array('label'=>Yii::t('static', 'Add Appointment'), 'url'=>array('/appointment/create'),'class'=>'btn-1'),
);

$this->title = Yii::t('static', 'Appointments / Operations');
?>

<div class="form-type">
    <div class="row">
        <div class="sidebar">
            <!-- <div class="clearfix">
                <?php echo CHtml::link(Yii::t('static','Create'), array('appointment/create'), array('class'=>'btn-3','id'=>'create-btn'))?>
                <a href="<?php echo Yii::app()->createAbsoluteUrl('/appointment/print_appointment'); ?>/" class="btn-green-1 btn-size-sx-3 printpopup" title="Print Appointments" target="_blank">
                    <img src="<?php echo Yii::app()->baseUrl; ?>/img/icon-print.png"  height="30" >
                </a>
            </div> -->
            <div class="current-month clearfix">
                <p id="small-month" class="month"><?php echo date('F Y') ?></p>
                <a href="#" title="<?php echo Yii::t('static','Next')?>" class="next" id="small-next">&rsaquo;</a>
                <a href="#" title="<?php echo Yii::t('static','Prev')?>" class="prev" id="small-prev">&lsaquo;</a>
            </div>
            <div class="calendar-content">
                <table class="calendar-tb">
                    <thead>
                    <tr>
                        <th><?php echo Yii::t('static','Sun')?></th>
                        <th><?php echo Yii::t('static','Mon')?></th>
                        <th><?php echo Yii::t('static','Tue')?></th>
                        <th><?php echo Yii::t('static','Wed')?></th>
                        <th><?php echo Yii::t('static','Thu')?></th>
                        <th><?php echo Yii::t('static','Fri')?></th>
                        <th><?php echo Yii::t('static','Sat')?></th>
                    </tr>
                    </thead>
                    <tbody id="small-cal">
                    </tbody>
                </table>
            </div>
            <div class="btn-group-vertical" data-toggle="buttons">
                <?php foreach ($doctors as $d) : ?>
                <label class="btn btn-default" id="btn-<?php echo $d->id?>">
                    <?php echo CHtml::radioButton('doctorSelect',false,array('value'=>$d->id,'uncheckValue'=>null,'id'=>'doctor'.$d->id)) ?> <?php echo $d->fullName?>
                </label>
                <?php endforeach; ?>
            </div>
            <div><br/>Note:
                <?php foreach (Clinic::model()->findAll() as $clinic) : ?>
                    <p><span style="background: <?php echo $clinic->color_code; ?>" >&nbsp;&nbsp;&nbsp;</span>&nbsp;<?php echo $clinic->name; ?></p>
                <?php endforeach; ?>
            </div>

        </div>
        <div class="main-content-wrap">
            <div class="main-content-inner">
                <div id='calendar'></div>
            </div>
        </div>
    </div>
</div>
<input type="hidden" id="ajaxGetDoctorTimeByDay" value="<?php echo Yii::app()->createUrl('ajax/getDoctorTimeByDay/');?>" />
<input type="hidden" id="ajaxGetDoctorTimeByWeek" value="<?php echo Yii::app()->createUrl('ajax/getDoctorTimeByWeek/');?>" />
<input type="hidden" id="ajaxGetSumaryEventByMonth" value="<?php echo Yii::app()->createUrl('ajax/getSumaryEventByMonth/');?>" />
<input type="hidden" id="ajaxGetDoctorLeaveByDoctor" value="<?php echo Yii::app()->createUrl('ajax/getDoctorLeaveByDoctor/');?>" />
<input type="hidden" id="ajaxHasLeave" value="<?php echo Yii::app()->createUrl('ajax/hasLeave/');?>" />

<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/jquery-ui.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/js/fullcalendar/fullcalendar.css');
// Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/js/fullcalendar/fullcalendar.print.css','print');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery-ui.custom.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/moment.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/fullcalendar/fullcalendar.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.multiselect.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/scripts/fixcalendar.js', CClientScript::POS_END);
?>
<script type="text/javascript">
var monthList=['<?php echo Yii::t('static','January')?>',
    '<?php echo Yii::t('static','February')?>',
    '<?php echo Yii::t('static','March')?>',
    '<?php echo Yii::t('static','April')?>',
    '<?php echo Yii::t('static','May')?>',
    '<?php echo Yii::t('static','June')?>',
    '<?php echo Yii::t('static','July')?>',
    '<?php echo Yii::t('static','August')?>',
    '<?php echo Yii::t('static','September')?>',
    '<?php echo Yii::t('static','October')?>',
    '<?php echo Yii::t('static','November')?>',
    '<?php echo Yii::t('static','December')?>'];
var defaultDate='<?php echo !empty($date) ? date('Y-m-d', $date) : ''?>';

var blackoutEvents = [
    <?php foreach ($blackout as $bo) : ?>
        {title:"Holiday: <?php echo $bo->comments?>",
            start:'<?php echo date('Y-m-d', strtotime($bo->start))?>',
            end:'<?php echo date('Y-m-d', strtotime('+1 day', strtotime($bo->end)))?>',
            className:'blackout',
            allDay:true,
            url:'<?php echo Yii::app()->createUrl('blackout/index')?>'},
    <?php endforeach ?>
];

var events={
    <?php foreach ($events as $doctor_id => $list) : ?>
        <?php echo $doctor_id ?>:[
            <?php foreach ($list as $event) :
                 $eventComment =  preg_replace('/[^a-zA-Z0-9_ -]/s', '', $event->comments);

            ?>

            <?php if (get_class($event)=='Appointment'):
                $eventFullComment =  preg_replace('/[^a-zA-Z0-9_ -]/s', '', $event->comments);
                $eventComment =  HString::excerpt(preg_replace('/[^a-zA-Z0-9_ -]/s', '', $eventFullComment),20);
                $eventName = preg_replace('/[^a-zA-Z0-9_ -]/s', '', $event->name);
                $eventContact =  preg_replace('/[^a-zA-Z0-9_ -]/s', '', $event->contact);
            ?>
            {title:'<?php echo $eventName.' '.$eventContact;?><?php echo $eventComment != ''? ' - Comments: '.$eventComment:'';?>',
                start:'<?php echo date('Y-m-d\TH:i:s', strtotime($event->event->start))?>',
                end:'<?php echo date('Y-m-d\TH:i:s', strtotime($event->event->end))?>',
                className:'<?php echo ($event->event->type=='appt'?'':'status1')?> <?php echo $event->visit_reason == 1 ?'visit-highlight':'' ?> appt',
                allDay:false,
                description: "<?php echo $eventName.' '.$eventContact;?><?php echo $eventFullComment != ''? ' - Comments: '.$eventFullComment:'';?>",
                url:'<?php echo Yii::app()->createUrl('appointment/view',array('id'=>$event->event_id))?>'},
            <?php else : ?>
            {title:"Leave: <?php echo $eventComment; ?>",
                start:'<?php echo date('Y-m-d', strtotime($event->start))?>',
                end:'<?php echo date('Y-m-d', strtotime('+1 day', strtotime($event->end)))?>',
                className:'blackout',
                allDay:false,
            <?php endif; ?>
            <?php endforeach ?>
        ],
    <?php endforeach ?>
};
//var all_events=new Array();
//for (var key in events) {
//    $.merge(all_events, events[key]);
//}

$(document).ready(function() {

    var hash = window.location.hash.replace('#','');
    var params = hash.split("|");

    var doctor_id = <?php echo $doctors[0]->id?>;
    if (params.length == 2 && events[params[1]] != null) {
        doctor_id = params[1]-0;
    }

    var d = new Date(params[0]);
    if (!isNaN(d.getMonth())) {
        defaultDate = params[0];
    }

    renderSmallCal();
    $('#small-prev').click(function(){
        to_date = new Date();
        curMonth=new Date(curMonth.getFullYear(),curMonth.getMonth()-1,1);
        $('#small-month').text(monthList[curMonth.getMonth()]+" "+curMonth.getFullYear());
        $('#small-cal').empty();
        renderSmallCal();
        curMonth.setDate(curMonth.getDate()+1);
         if (to_date.getMonth() == curMonth.getMonth()) {
            $('#calendar').fullCalendar( 'gotoDate', to_date.toISOString());
        }
        else {
            $('#calendar').fullCalendar( 'gotoDate', curMonth.toISOString());
        }
        $('#calendar').fullCalendar( 'changeView', 'month' );
        calendarChange(doctor_id);
        $('.day-cell a').click(function(){//Active current date
           $('.day-cell').removeClass('active');
           $(this).parent('.day-cell').addClass('active');
           calendarChange(doctor_id);
        });
     });

     $('#small-next').click(function(){
        to_date = new Date();
        curMonth=new Date(curMonth.getFullYear(),curMonth.getMonth()+1,1);
        $('#small-month').text(monthList[curMonth.getMonth()]+" "+curMonth.getFullYear());
        $('#small-cal').empty();
        renderSmallCal();
        curMonth.setDate(curMonth.getDate()+1);
         if (to_date.getMonth() == curMonth.getMonth()) {
            $('#calendar').fullCalendar( 'gotoDate', to_date.toISOString());
        }
        else {
            $('#calendar').fullCalendar( 'gotoDate', curMonth.toISOString());
        }
        $('#calendar').fullCalendar( 'changeView', 'month' );
        calendarChange(doctor_id);
        $('.day-cell a').click(function(){//Active current date
           $('.day-cell').removeClass('active');
           $(this).parent('.day-cell').addClass('active');
           calendarChange(doctor_id);
        });
     });



    $('#calendar').fullCalendar({
        header: {
            left: 'prev,next',
            center: 'title',
            right: 'month,agendaWeek,agendaDay,resourceDay'
        },
        slotMinutes: 15,
        slotDuration: '00:05:00',
        defaultDate: defaultDate != '' ? defaultDate : null,
        defaultView: defaultDate != '' ? 'agendaDay' : 'month',
        buttonText: {today:'<?php echo Yii::t('static','Today')?>',month:'<?php echo Yii::t('static','Month')?>',week:'<?php echo Yii::t('static','Week')?>',day:'<?php echo Yii::t('static','Day')?>'},
        scrollTime: '08:00:00',
        editable: false,
        columnFormat: {week: 'ddd D/M/YY'},
        timeFormat: 'h:mma',
        events: blackoutEvents,
        height: 700,
        dayClick: function(date, jsEvent, view) {
            if (view.name == 'month' || date.hasTime()) {
                document.location='<?php echo Yii::app()->createUrl('appointment/create',array('d'=>'var_d','t'=>'var_t','doctor'=>'var_dt'))?>'.replace('var_d',date.format('X')).replace('var_t',date.format('HH:mm')).replace('var_dt', doctor_id);
            }
            else {
                document.location='<?php echo Yii::app()->createUrl('blackout/create',array('d'=>'var_d','doctor'=>'var_dt'))?>'.replace('var_d',date.format('X')).replace('var_dt', doctor_id);
            }
        },
        eventRender: function(event, element)
        {
            element.attr('title', event.description);
        }
    });

    calendarChange(doctor_id);//First load

//    for (var key in events) {
//        $('#calendar').fullCalendar('addEventSource', events[key]);
//    };
    $('#btn-'+doctor_id).button('toggle');
    $("#create-btn").attr("href", "<?php echo Yii::app()->createUrl('appointment/create',array('doctor'=>'_d_')) ?>".replace('_d_',doctor_id));
    // $('#calendar').fullCalendar('addEventSource', events[doctor_id]);

    //In week view, shade in grey the week

    $('.fc-agendaWeek-button').live('click',function() {//Event week click
        calendarChange(doctor_id);
    });

    $('.fc-agendaDay-button').click(function() {//Event Day click
        calendarChange(doctor_id);
    });

    $('.fc-month-button').click(function(event) {//Event month click
        calendarChange(doctor_id);
    });

    $('.day-cell a').click(function(){//Active current date
       calendarChange(doctor_id);
    });

    $('input[name=doctorSelect]').change(function() {
        $("#create-btn").attr("href", "<?php echo Yii::app()->createUrl('appointment/create',array('doctor'=>'_d_')) ?>".replace('_d_',this.value));
        doctor_id = this.value;
        calendarChange(doctor_id);
    });


});

var curMonth = new Date();
var to_date = new Date();

var monthNames = ["January", "February", "March", "April", "May", "June",
  "July", "August", "September", "October", "November", "December"
];

function renderSmallCal() {
    var hash = window.location.hash.replace('#','');
    var params = hash.split("|");

    var dfd = new Date(params[0]);
    if (!isNaN(dfd.getMonth())) {
        curMonth = dfd;
        $('#small-month').html(monthNames[curMonth.getMonth()]);
    }

    var body=$('#small-cal');
    var prevMonth = new Date(curMonth.getFullYear(),curMonth.getMonth(),0);

    // render prev month
    var firstWD = new Date(curMonth.getFullYear(),curMonth.getMonth(),1).getDay();
    var lastDate = new Date(curMonth.getFullYear(),curMonth.getMonth()+1,0).getDate();
    var dayCount = lastDate + firstWD;

    var dd=1;
    while(dayCount > 0){ // loop for every tr
        var tr =  $('<tr />');
        var d=0;
        if (firstWD > 0) {
            var prevMonthLastD = prevMonth.getDate();
            for(var i=0; i<firstWD; i++) {
                var td=$('<td/>');
                //td.addClass('invi');
                //td.text(''+prevMonthLastD-(firstWD-1-i));
                tr.append(td);
                d++;
            }
            firstWD=0;
        }



        for(i=d; i<7 && dd<=lastDate; i++) {
            var a=$('<a/>');

            a.text(''+dd);
            a.attr('href','#');
            a.click(function(){
                //alert(curMonth.getFullYear()+'-'+(curMonth.getMonth()+1)+'-'+this.text);
                var toDate=new Date(curMonth.getFullYear(),curMonth.getMonth(),this.text);
                toDate.setDate(toDate.getDate()+1);
                $('#calendar').fullCalendar( 'gotoDate', toDate.toISOString() );
                $('#calendar').fullCalendar( 'changeView', 'agendaDay' );
                $('.current-week').removeClass('active');
                return false;
            });
            if (!isNaN(dfd.getMonth())) {
                if (dfd.getDate() == dd) {
                    tr.append($('<td class="day-cell active"/>').append(a));//Active current date
                    tr.addClass('current-week');
                }
                else {tr.append($('<td class="day-cell"/>').append(a));}
            }
            else {
                if (to_date.getMonth() == curMonth.getMonth()) {
                    if (to_date.getDate() == dd) {
                        tr.append($('<td class="day-cell active"/>').append(a));//Active current date
                        tr.addClass('current-week');
                    }
                    else {tr.append($('<td class="day-cell"/>').append(a));}
                }
                else {
                    if (curMonth.getDate() == dd){
                        tr.append($('<td class="day-cell active"/>').append(a));//Active current date
                        tr.addClass('current-week');
                    }
                    else {tr.append($('<td class="day-cell"/>').append(a));}
                }
            }
            dd++;
        }
        body.append(tr);
        dayCount -= 7;
    }
}


function calendarChange(doctor_id) {
    setTimeout(function(){
        $('#calendar').fullCalendar('removeEvents');
        $('#calendar').fullCalendar('removeEventSources');
        viewName = $('#calendar').fullCalendar('getView').name;
        if ( viewName == 'month')
            getMonthEvents(doctor_id);
        else if (viewName == 'agendaWeek') getWeekEvents(doctor_id);
        else getDayEvents(doctor_id);
    },0);
}


function getMonthEvents(doctor_id) {
    currentDate = $('#calendar').fullCalendar('getDate');
    currentMonth =  currentDate.format('MM');
    currentYear =  currentDate.format('YYYY');
    url = $('#ajaxGetSumaryEventByMonth').val();

    $.ajax({//Add event for selected date
        type: "POST",
        dataType: "json",
        url: url, //Relative or absolute path to response.php file
        data: {month: currentMonth, year: currentYear, doctor_id: doctor_id},
        success: function(data) {
            var monthEvents = new Array();
            $.each(data, function() {
                event = new Object();
                totalEvent = this.operation + this.consult + this.chemotherapy + this.others;
                if (totalEvent > 0) {//If have one more events then show it
                    event.title = 'Operation = ' + this.operation + '\nConsult = ' + this.consult + '\nChemotherapy = ' + this.chemotherapy + '\nOthers = ' + this.others + '\nTotal = ' + totalEvent;
                    event.start = this.date;
                    event.end = this.date;
                    event.allDay =  true;
                    monthEvents.push(event);
                }
            });
            $('#calendar').fullCalendar('removeEvents');
            $('#calendar').fullCalendar('removeEventSources');
            $('#calendar').fullCalendar('addEventSource',monthEvents);
            $('#calendar').fullCalendar('addEventSource',blackoutEvents);//Add common event
            getLeaveEvent(doctor_id);
        }
    });
}



function getWeekEvents(doctor_id) {
    startWeek = $('#calendar').fullCalendar('getView').intervalStart;
    startWeek = (new Date(startWeek)).toISOString().slice(0, 10);//Format yy-mm-dd
    endWeek = $('#calendar').fullCalendar('getView').intervalEnd;
    endWeek = (new Date(endWeek)).toISOString().slice(0, 10);//Format yy-mm-dd

    url = $('#ajaxGetDoctorTimeByWeek').val();

    $.ajax({//Add event for selected date
        type: "POST",
        dataType: "json",
        url: url, //Relative or absolute path to response.php file
        data: {startdate: startWeek, enddate: endWeek, doctor_id: doctor_id},
        success: function(data) {
            var newEvents = new Array();
            $.each(data, function() {
                event = new Object();
                event.start = this.starttime;
                event.end = this.endtime;
                //event.resources = this.doctor_id;
                event.rendering = 'background';
                event.color = this.color_code2;
                //event.url =  '<?php echo Yii::app()->createUrl('appointment/create',array('d'=>'var_d','doctor'=>'var_dt'))?>'.replace('var_d', this.startTimeStamp).replace('var_dt', this.doctor_id);
                newEvents.push(event);
            });
            $('#calendar').fullCalendar('removeEvents');
            $('#calendar').fullCalendar('removeEventSources');
            $('#calendar').fullCalendar('addEventSource',newEvents);
            $('#calendar').fullCalendar('addEventSource', events[doctor_id]);
            $('#calendar').fullCalendar('addEventSource',blackoutEvents);
            getLeaveEvent(doctor_id);
        }
    });
}

function getDayEvents(doctor_id) {
    current =  $('#calendar').fullCalendar('getDate').format();
    current = (new Date(current)).toISOString().slice(0, 10);//Format yy-mm-dd
    url = $('#ajaxGetDoctorTimeByDay').val();
    urlHasLeave = $('#ajaxHasLeave').val();

    $.ajax({//Add event for selected date
        type: "POST",
        dataType: "json",
        url: url, //Relative or absolute path to response.php file
        data: {date: current, doctor_id: doctor_id},
        success: function(data) {
            var newEvents = new Array();
            $.each(data, function() {
                event = new Object();
                event.start = this.starttime;
                event.end = this.endtime;
                //event.resources = this.doctor_id;
                event.rendering = 'background';
                event.color = this.color_code2;
                //event.url =  '<?php echo Yii::app()->createUrl('appointment/create',array('d'=>'var_d','doctor'=>'var_dt'))?>'.replace('var_d', this.startTimeStamp).replace('var_dt', this.doctor_id);
                newEvents.push(event);
            });

            $('#calendar').fullCalendar('removeEvents');
            $('#calendar').fullCalendar('removeEventSources');
            $('#calendar').fullCalendar('addEventSource',blackoutEvents);
            $('#calendar').fullCalendar('addEventSource',newEvents);

            $.ajax({
                url: urlHasLeave,
                type: 'post',
                data: {doctor_id: doctor_id, date: current},
            })
            .done(function(rs) {
                alert(rs);
                if (rs == 0) {
                    $('#calendar').fullCalendar('addEventSource', events[doctor_id]);
                }
            });
            getLeaveEvent(doctor_id);


        }
    });
}

function getLeaveEvent(doctor_id) {
    url = $('#ajaxGetDoctorLeaveByDoctor').val();
    $.ajax({//Add blackout event for selected doctor
        type: "POST",
        dataType: "json",
        url: url, //Relative or absolute path to response.php file
        data: {doctor_id: doctor_id},
        success: function(data) {
            var newEvents = new Array();
            $.each(data, function() {
                event = new Object();
                event.start = this.start;
                event.end = this.end;
                event.title = this.title;
                event.className = 'blackout';
                event.allDay = true;
                newEvents.push(event);
            });
            $('#calendar').fullCalendar('addEventSource',newEvents);
        }
    });
}

</script>

<style type="text/css">
.fc-toolbar .fc-left,.fc-toolbar .fc-center { display: none;}
.appt { background: none !important;}
#calendar { margin-left: 5px;}
</style>