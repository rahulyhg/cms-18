/**
 * Created by Nam on 6/11/14.
 */
$(function() {
    $('#patientfield').autocomplete({delay: 0, minLength: 2,
        source: function (request, response) {
            var results = $.ui.autocomplete.filter(datasource, request.term);
            response(results.slice(0, 10));
        },
        select: function (even, ui) {
            if (ui.item != null) {
                $('#patientid').val(ui.item.id);
            }
        }
    });
    $('.timepicker').timepicker({
        hourText: hourText,
        minuteText: minuteText,
        amPmText: ampmText,
        showNowButton: true,
        showDeselectButton: true,
        showCloseButton: true,
        showLeadingZero: false
    });
});