/**
 * Created by Nam on 6/11/14.
 */
$(function() {
    $( ".dob" ).datepicker({
        showOtherMonths: true,
        selectOtherMonths: true,
        changeMonth: true,
        changeYear: true,
        dateFormat: "M d, yy",
        yearRange: "1900:+0"
    });
    $( ".datepicker" ).datepicker({
        showOtherMonths: true,
        selectOtherMonths: true,
        changeMonth: true,
        dateFormat: "M d, yy",
        changeYear: true
    });
});