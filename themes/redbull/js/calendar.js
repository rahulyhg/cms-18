/**
 * Created by Nam on 6/22/14.
 */
$(document).ready(function() {
    renderSmallCal();
    $('#small-prev').click(function(){
        curMonth=new Date(curMonth.getFullYear(),curMonth.getMonth()-1,1);
        $('#small-month').text(monthList[curMonth.getMonth()]+" "+curMonth.getFullYear());
        $('#small-cal').empty();
        renderSmallCal();
    });
    $('#small-next').click(function(){
        curMonth=new Date(curMonth.getFullYear(),curMonth.getMonth()+1,1);
        $('#small-month').text(monthList[curMonth.getMonth()]+" "+curMonth.getFullYear());
        $('#small-cal').empty();
        renderSmallCal();
    });

    $('#calendar').fullCalendar({
        header: {
            left: 'prev,next',
            center: 'title',
            right: 'month,agendaWeek,agendaDay,resourceDay'
        },
        slotMinutes: 15,
        defaultDate: defaultDate != '' ? defaultDate : null,
        defaultView: defaultDate != '' ? 'agendaDay' : 'month',
        buttonText: buttonText,
        scrollTime: '08:00:00',
        editable: false,
        events: events,
        height: 700,
        dayClick: function(date, jsEvent, view) {
            document.location=dayClickUrl.replace('var_d',date.format('X')).replace('var_t',date.hasTime()?date.format('HH:mm'):'');
        }
    });

    $(".multi-wrap select").multiselect(
        header: <?php echo Yii::t( ?>
    );
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
                toDate.setDate(toDate.getDate()+1);
                $('#calendar').fullCalendar( 'gotoDate', toDate.toISOString() );
                $('#calendar').fullCalendar( 'changeView', 'agendaDay' );
                return false;
            });
            tr.append($('<td/>').append(a));
            dd++;
        }
        body.append(tr);
        dayCount -= 7;
    }
}