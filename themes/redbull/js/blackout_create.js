/**
 * Created by Nam on 6/14/14.
 */
$(function() {
    $('#div-doctor').hide();
    $('.timepicker').hide();
    $('#div-covering-doctor').hide();
    $( ".datepicker" ).datepicker({
        showOtherMonths: true,
        selectOtherMonths: true,
        changeMonth: true,
        dateFormat: "DD M d, yy",
        changeYear: true
    });
    $("input[name='Blackout[type]']").change(function(){
        var number = $("input[name='Blackout[type]']:checked").val();
        switch (number) {
            case 'leave': $('#div-doctor').show(); $('#div-covering-doctor').hide(); $('.timepicker').hide(); break;
                
            case 'time': $('#div-doctor').show(); $('#div-covering-doctor').hide(); $('.timepicker').show(); break;
                
            case 'covering': $('#div-doctor').show(); $('#div-covering-doctor').show(); $('.timepicker').hide(); break;
            
            default: $('#div-doctor').hide(); $('#div-covering-doctor').hide(); $('.timepicker').hide(); break;
        }
    });
    
});
