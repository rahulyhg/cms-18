<?php
Yii::app()->clientScript->registerCssFile( Yii::app()->theme->baseUrl . '/css/jquery-ui.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl . '/css/fullcalendar.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl . '/css/fullcalendar.print.css', 'print');
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/jquery-ui.custom.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/moment.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/fullcalendar.js', CClientScript::POS_END);
?>
<script type="text/javascript">
    var dayClickUrl = '<?php echo Yii::app()->createUrl('appointment/create', array('d' => 'var_d', 't' => 'var_t', 'doctor' => 'var_dt')) ?>';
    var events = {
        'events':[
            <?php
            foreach ($model as $event):
                $eventFullComment = HString::correctCalendarText($event->comments);
                $eventComment = HString::correctCalendarText($eventFullComment);
                $eventName = HString::correctCalendarText($event->name);
                $eventContact = HString::correctCalendarText($event->contact);
                ?>
                {title:'<?php echo $eventName . ' ' . $eventContact; ?><?php //echo $eventFullComment != '' ? ' - Comments: ' . $eventFullComment : ''; ?>',
                start:'<?php echo date('Y-m-d\TH:i:s', strtotime($event->event->start)) ?>',
                end:'<?php echo date('Y-m-d\TH:i:s', strtotime($event->event->end)) ?>',
                className:'<?php echo ($event->event->type == 'appt' ? '' : 'status1') ?> <?php echo $event->visit_reason == 1 ? 'visit-highlight ' : '' ?> appt',
                resources:'<?php echo $event->event->doctor_id ?>',
                description: "<?php echo $eventName . ' ' . $event->contact ?> - <?php echo Appointment::$visit_reason[$event->visit_reason]; ?> <?php echo $eventFullComment != '' ? ' - Comments: ' . $eventFullComment : ''; ?>",
                allDay:false,
                backgroundColor: '#FFF',
                url:'<?php echo Yii::app()->createUrl('appointment/view', array('id' => $event->event_id)) ?>'},
            <?php endforeach; ?>
        ],
                                    // start blackout
        'blackout':[
            <?php
            foreach ($blackout as $event):
                $className = 'blackout';
                $eventFullComment = HString::correctCalendarText($event->comments);
                $eventComment = HString::excerpt($eventFullComment, 23);
                ?>
                {title:"<?php echo ($event->type == 'leave' ? Yii::t('static', 'Leave') . ' ' : '') . $eventComment ?>",
                start:'<?php echo date('Y-m-d', strtotime($event->start)) ?>',
                end:'<?php echo date('Y-m-d 23:59:59', strtotime('+1 day', strtotime($event->end))) ?>',
                className:'<?php echo $className; ?>',
                resources:<?php echo ($event->type == 'leave' ? "'$event->doctor_id'" : "['" . implode("','", CHtml::listData($doctors, 'id', 'id')) . "']") ?>,
                description: "<?php echo $eventFullComment; ?>",
                allDay:true,
                url:'<?php echo Yii::app()->createUrl('/blackout/index') ?>'},
            <?php endforeach; ?>
        ],
        //  start doctor time
        'doctortime': [
            <?php foreach ($doctorTimes as $time): ?>
            {
            start: '<?php echo $time['starttime']; ?>',
            end: '<?php echo $time['endtime']; ?>',
            allDay: false,
            resources: '<?php echo $time['doctor_id']; ?>',
            backgroundColor: '<?php echo $time['color_code2']; ?>',
            url:"<?php echo Yii::app()->createUrl('appointment/create', array('d' => strtotime($time['starttime']), 'doctor' => $time['doctor_id'])); ?>"
            },
            <?php endforeach; ?>
        ],
    };
    var resources = [
        <?php foreach ($doctors as $d): ?>
            {id:'<?php echo $d->id ?>', name:'<?php echo $d->fullName ?>'},
        <?php endforeach; ?>
    ];</script>

<input type="hidden" id="ajaxGetDoctorTimeByDay" value="<?php echo Yii::app()->createUrl('ajax/getDoctorTimeByDay/'); ?>" />
<input type="hidden" id="ajaxGetAppointmentByDay" value="<?php echo Yii::app()->createUrl('ajax/GetAppointmentByDay/'); ?>" />

<script type="text/javascript">
$(document).ready(function() {



    $('#<?php echo $this->htmlElementID;?>').fullCalendar({
        header: {
        left: 'prev,next',
                center: 'title',
                right: ''
        },
        slotMinutes: 5,
        slotDuration: '00:05:00',
        scrollTime: '08:00:00',
        defaultView: 'resourceDay',
        resources: resources,
        editable: false,
        height: 400,
        titleFormat: {
            day: 'dddd, MMMM D YYYY'
        },
        timeFormat: 'h:mma',
        events: events,
        selectable: true,
        select: function (date, end, ev) {
            var curdate = moment(date.format('YYYY-MM-DD')).unix();
            if (date.hasTime()) {
                document.location = dayClickUrl.replace('var_d', curdate).replace('var_t', date.format('HH:mm')).replace('var_dt', ev.data.id);
            }
            else
            {
                document.location = '<?php echo Yii::app()->createUrl('blackout/create', array('d' => 'var_d')) ?>'.replace('var_d', curdate).replace('var_dt', ev.data.id);
            }
        },

        eventRender: function(event, element)
        {
            element.attr('title', event.description);
        },
        eventAfterAllRender: function(view)
        {
            $('.fc-event').each(function()
            {
                var totalWidth = $('.fc-agenda-slots').width();
                var colWidth = (totalWidth /<?php echo count($doctors); ?>) - 6;
                if ($(this).attr('href').indexOf('create') > 0)
                {
                $(this).css("width", colWidth + 'px');
                        $(this).find('.fc-event-time').css('display', 'none');
                }
            });
        }
    });
    // $('#<?php echo $this->htmlElementID;?>').fullCalendar('addEventSource', events['events']);
    $('#<?php echo $this->htmlElementID;?>').fullCalendar('addEventSource', events['doctortime']);
    // $('#<?php echo $this->htmlElementID;?>').fullCalendar('addEventSource', events['blackout']);
    //changeEvent();


    $('.fc-button-prev, .fc-button-next').click(function(event) {
        changeEvent();
    });
});

function changeEvent() {
    var newApppointmentEvents = new Array();
        current = $('#<?php echo $this->htmlElementID;?>').fullCalendar('getDate').format();
        current = (new Date(current)).toISOString().slice(0, 10); //Format yy-mm-dd

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
                                event.rendering = 'background';
                                event.color = this.color_code2;
                                event.url = '<?php echo Yii::app()->createUrl('appointment/create', array('d' => 'var_d', 'doctor' => 'var_dt')) ?>'.replace('var_d', this.startTimeStamp).replace('var_dt', this.doctor_id);
                                newEvents.push(event);
                        });
                        //$('#<?php echo $this->htmlElementID;?>').fullCalendar('addEventSource',events['blackout']);
                        $('#<?php echo $this->htmlElementID;?>').fullCalendar('removeEvents');
                        $('#<?php echo $this->htmlElementID;?>').fullCalendar('removeEventSources')
                        $('#<?php echo $this->htmlElementID;?>').fullCalendar('addEventSource', newEvents);
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
                        $('#<?php echo $this->htmlElementID;?>').fullCalendar('addEventSource', newApppointmentEvents);
                        //$('#<?php echo $this->htmlElementID;?>').fullCalendar('addEventSource', events['blackout']);
                        $('#<?php echo $this->htmlElementID;?>').fullCalendar('addEventSource', events['doctortime']);
                }
        });
}
</script>