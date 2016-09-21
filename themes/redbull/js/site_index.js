function toggleComplete(o, value) {
    $.ajax({
        'type':'POST',
        'url':url,
        'data':'Notice[id]='+value,
        'cache':false,
        'success':function(html){
            //$(".notice-board").html(html)
        }});
    $('#li_'+value).toggleClass('notice-completed');
    return false;
}
$(document).ready(function() {
    $('#calendar-box').fullCalendar({
        header: {
            left: 'prev,next',
            center: 'title',
            right: null
        },
        defaultDate: defaultDate,
        defaultView:'agendaDay',
        editable: false,
        events: events,
        height:517,
        scrollTime:'08:00:00',
        dayClick: function(date, jsEvent, view) {
            if (date.hasTime()) {
                document.location=dayClickUrl.replace('var_d',date.format('X')).replace('var_t',date.hasTime()?date.format('HH:mm'):'');
            }
            else {
                document.location=alldayClickUrl.replace('var_d',date.format('X'));
            }
        }
    });
});