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
                <?php echo CHtml::link(Yii::t('static','Create'), array('appointment/create'), array('class'=>'btn-3'))?>
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
                        <th><?php echo Yii::t('static','Su')?></th>
                        <th><?php echo Yii::t('static','Mo')?></th>
                        <th><?php echo Yii::t('static','Tu')?></th>
                        <th><?php echo Yii::t('static','We')?></th>
                        <th><?php echo Yii::t('static','Th')?></th>
                        <th><?php echo Yii::t('static','Fr')?></th>
                        <th><?php echo Yii::t('static','Sa')?></th>
                    </tr>
                    </thead>
                    <tbody id="small-cal">
                    </tbody>
                </table>
            </div>
            <div>Note:
                <?php foreach (Clinic::model()->findAll() as $clinic) : ?>
                    <p><span style="background: <?php echo $clinic->color_code; ?>" >&nbsp;&nbsp;&nbsp;</span>&nbsp;<?php echo $clinic->name; ?></p>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="main-content-wrap">
            <div class="main-content-inner">
                <div id='calendar-doctor'></div>
            </div>
        </div>
    </div>
</div>
<input type="hidden" id="ajaxGetDoctorTimeByDay" value="<?php echo Yii::app()->createUrl('ajax/getDoctorTimeByDay/');?>" />
<input type="hidden" id="ajaxGetAppointmentByDay" value="<?php echo Yii::app()->createUrl('ajax/GetAppointmentByDay/');?>" />
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
    var dayClickUrl='<?php echo Yii::app()->createUrl('appointment/create',array('d'=>'var_d','t'=>'var_t','doctor'=>'var_dt'))?>';

    var events= {
            'events':[
                <?php foreach ($model as $event):
                    $eventFullComment =  preg_replace('/[^a-zA-Z0-9_ -]/s', '', $event->comments);
                    $eventComment =  preg_replace('/[^a-zA-Z0-9_ -]/s', '', $eventFullComment);
                    $eventName = preg_replace('/[^a-zA-Z0-9_ -]/s', '', $event->name);
                    $eventDiscription =  date('h:i A', strtotime($event->event->start)).' - '.date('h:i A', strtotime($event->event->end)).' - Patient: '.$eventName.' '.$event->contact.' - '.Appointment::$visit_reason[$event->visit_reason].($eventFullComment != ''? ' - Comments: '.$eventFullComment:'');
                    $eventContact =  preg_replace('/[^a-zA-Z0-9_ -]/s', '', $event->contact);
                ?>
                {title:'<?php echo $eventName;?>',
                    start:'<?php echo date('Y-m-d\TH:i:s', strtotime($event->event->start))?>',
                    end:'<?php echo date('Y-m-d\TH:i:s', strtotime($event->event->end))?>',
                    className:'<?php echo ($event->event->type=='appt'?'':'status1')?> <?php echo $event->visit_reason == 1 ?'visit-highlight ':'' ?> appt',
                    resources:'<?php echo $event->event->doctor_id?>',
                    description: "<?php echo $eventDiscription;?>",
                    allDay:false,
                    //backgroundColor: '#FFF',
                    url:'<?php echo Yii::app()->createUrl('appointment/view',array('id'=>$event->event_id))?>'},
                <?php endforeach; ?>
            ],
            // start blackout
            'blackout':[
                <?php foreach ($blackout as $event):
                    $className = 'blackout';
                    $eventFullComment =  preg_replace('/[^a-zA-Z0-9_ -]/s', '', $event->comments);
                    $eventComment = HString::excerpt($eventFullComment,16);
                ?>
                {title:"<?php echo ($event->type=='leave'?Yii::t('static','Leave').' ':'').$eventComment ?>",
                    start:'<?php echo date('Y-m-d', strtotime($event->start))?>',
                    end:'<?php echo date('Y-m-d 23:59:59', strtotime('+1 day', strtotime($event->end)))?>',
                    className:'<?php echo $className; ?>',
                    resources:<?php echo ($event->type=='leave'?"'$event->doctor_id'":"['".implode("','", CHtml::listData($doctors,'id','id'))."']") ?>,
                    description: "<?php echo $eventFullComment; ?>",
                    allDay:true,
                    url:'<?php echo Yii::app()->createUrl('/blackout/index')?>'},
                <?php endforeach; ?>
            ],
            //  start doctor time
            'doctortime': [
                <?php foreach ($doctorTimes as $time): ?>
                {
                    start: '<?php echo $time['starttime']; ?>',
                    end: '<?php echo $time['endtime']; ?>',
                    resources: '<?php echo $time['doctor_id']; ?>',
                    allDay:false,
                    backgroundColor: '<?php echo $time['color_code2']; ?>',
                    url:"<?php echo Yii::app()->createUrl('appointment/create',array('d' => strtotime($time['starttime']), 'doctor'=>$time['doctor_id'])); ?>"
                },
                <?php endforeach; ?>
            ],
    };

    var resources=[
        <?php foreach ($doctors as $d): ?>
        {id:'<?php echo $d->id?>',name:'<?php echo $d->fullName?>'},
        <?php endforeach; ?>
    ];
</script>
<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/jquery-ui.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/fullcalendar.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/fullcalendar.print.css','print');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery-ui.custom.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/moment.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/fullcalendar.js', CClientScript::POS_END);
?>
<script type="text/javascript">
$(document).ready(function() {
    renderSmallCal();
    $('#small-prev').click(function(){
        curMonth=new Date(curMonth.getFullYear(),curMonth.getMonth()-1,1);
        $('#small-month').text(monthList[curMonth.getMonth()]+" "+curMonth.getFullYear());
        $('#small-cal').empty();
        renderSmallCal();
        //curMonth.setDate(curMonth.getDate()+1);
        $('#calendar-doctor').fullCalendar( 'gotoDate', curMonth);
        changeEvent();
        $('.day-cell a').click(function(){//Active current date
           $('.day-cell').removeClass('active');
           $(this).parent('.day-cell').addClass('active');
           changeEvent();
        });
    });
    $('#small-next').click(function(){
        curMonth=new Date(curMonth.getFullYear(),curMonth.getMonth()+1,1);
        $('#small-month').text(monthList[curMonth.getMonth()]+" "+curMonth.getFullYear());
        $('#small-cal').empty();
        renderSmallCal();
        //curMonth.setDate(curMonth.getDate()+1);
        $('#calendar-doctor').fullCalendar( 'gotoDate', curMonth);
        changeEvent();
        $('.day-cell a').click(function(){//Active current date
           $('.day-cell').removeClass('active');
           $(this).parent('.day-cell').addClass('active');
           changeEvent();
        });
    });



    $(document).ready(function() {
        $('#calendar-doctor').fullCalendar({
            header: {
                left: 'prev,next',
                center: 'title',
                right: ''
            },
            //events: events,
            slotMinutes: 5,
            slotDuration: '00:05:00',
            scrollTime: '08:00:00',
            defaultView: 'resourceDay',
            resources: resources,
            editable: false,
            height: 800,
            timeFormat: 'h:mma',
            selectable: true,
            select: function (date, end, ev) {
                if (date.hasTime()) {
                    document.location=dayClickUrl.replace('var_d',date.format('X')).replace('var_t',date.format('HH:mm')).replace('var_dt', ev.data.id);
                }
                else {
                    document.location='<?php echo Yii::app()->createUrl('blackout/create',array('d'=>'var_d'))?>'.replace('var_d',date.format('X')).replace('var_dt', ev.data.id);
                }
            },
            eventRender: function(event, element)
            {
                element.attr('title', event.description);
            },
            eventAfterAllRender: function( view )
            {
                $('.fc-event').each(function()
                {
                    var totalWidth = $('.fc-agenda-slots').width();
                    var colWidth = (totalWidth/<?php echo count($doctors);?>) - 6;

                    if ($(this).attr('href').indexOf('create') > 0)
                    {
                        $(this).css("width",  colWidth + 'px');
                        $(this).find('.fc-event-time').css('display', 'none');
                    }
                })
            }
        });
        $('#calendar-doctor').fullCalendar('addEventSource',events['doctortime']);
        $('#calendar-doctor').fullCalendar('addEventSource',events['events']);
        $('#calendar-doctor').fullCalendar('addEventSource',events['blackout']);
        $('.day-cell a').click(function(){//Active current date
           $('.day-cell').removeClass('active');
           $(this).parent('.day-cell').addClass('active');
           changeEvent();
        });
    });


});

var curMonth = new Date();
function renderSmallCal() {
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
                $('#calendar-doctor').fullCalendar( 'gotoDate', moment(toDate).format('YYYY-MM-DD') );
                return false;
            });
            if (curMonth.getDate() == dd) {
                tr.append($('<td class="day-cell active"/>').append(a));//Active current date
                tr.addClass('current-week');
            }
            else tr.append($('<td class="day-cell"/>').append(a));
            dd++;
        }
        body.append(tr);
        dayCount -= 7;
    }
}


function changeEvent() {
    var newApppointmentEvents = new Array();
    current =  $('#calendar-doctor').fullCalendar('getDate').format();
    current = moment(current).format('YYYY-MM-DD');
    // alert(current);
    url = $('#ajaxGetDoctorTimeByDay').val();
    urlAppt = $('#ajaxGetAppointmentByDay').val();
    $.ajax({//Add event for selected date
        type: "POST",
        dataType: "json",
        async: false,
        cache: false,
        timeout: 30000,
        url: url, //Relative or absolute path to response.php file
        data: {date: current},
        success: function(data) {
            var newEvents = new Array();
            $.each(data, function() {
                event = new Object();
                event.start = this.starttime;
                event.end = this.endtime;
                event.resources = this.doctor_id;
                event.backgroundColor = this.color_code2;
                event.url =  '<?php echo Yii::app()->createUrl('appointment/create',array('d'=>'var_d','doctor'=>'var_dt'))?>'.replace('var_d', this.startTimeStamp).replace('var_dt', this.doctor_id);
                newEvents.push(event);
            });
            $('#calendar-doctor').fullCalendar('removeEvents');
            $('#calendar-doctor').fullCalendar('removeEventSources')
            $('#calendar-doctor').fullCalendar('addEventSource',newEvents);
            $('#calendar-doctor').fullCalendar('addEventSource',events['blackout']);
        }
    });
    $.ajax({//Add event for selected date
            type: "POST",
            dataType: "json",
            async: false,
            cache: false,
            timeout: 30000,
            url: urlAppt, //Relative or absolute path to response.php file
            data: {date: current},
            success: function(data) {

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

                $('#calendar-doctor').fullCalendar('addEventSource',newApppointmentEvents);
            }
    });


}
</script>

<style type="text/css">
.fc-header-left,.fc-header-title { display: none;}
/*.appt { background: none !important; border: none !important;}
.fc-event { background: none !important; border: 0px !important;}
.appt { background: none !important; border: 0px !important;}*/
</style>