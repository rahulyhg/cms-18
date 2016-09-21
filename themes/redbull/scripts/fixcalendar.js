$(document).ready(function() {

	$('.day-cell a').click(function(){//Active current date
		$('.current-week').removeClass('active');
		$('.day-cell').removeClass('active');
		$(this).parent('.day-cell').addClass('active');
	});

	 $('.fc-month-button, .fc-agendaDay-button').click(function() {
        $('.current-week').removeClass('active');
    });

	 $('.fc-agendaWeek-button').click(function() {//Event week click
        current_date = $('.day-cell.active');
        current_date.parent('tr').addClass('current-week active');
      });

	 $('#small-prev, #small-next').attr('title','Select date to view');//Change title for pre, next arrows

});