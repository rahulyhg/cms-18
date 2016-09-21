/**
 * Author: Jason
 * Email: pmhai90@gmail.com
 */

function processAddToQueue(form, url) {
    var atLeastOneIsChecked = $('input[name=\"' + form + '_c0[]\"]:checked').length;
    if (atLeastOneIsChecked <= 0) {
        alert('Please select one record to add to queue');
    } else {
        var id = '';
        $('input[name=\"' + form + '_c0[]\"]:checked').each(function (index, item) {   
            if (id.length == 0) {
                id =$(item).val();

            }
            else {
                id += "," + $(item).val();

            }
        });
        window.location.href = url + '?patientId=' + id;
    }
}

function processAddToAppointment(form, url) {
    var atLeastOneIsChecked = $('input[name=\"' + form + '_c0[]\"]:checked').length;
    if (atLeastOneIsChecked <= 0) {
        alert('Please select one record to add to appointment');
    } 
    else if(atLeastOneIsChecked > 1)
    {
        alert('You can select only one patient to add to appointment');
    }
    else {
        var id = '';
        $('input[name=\"' + form + '_c0[]\"]:checked').each(function (index, item) {   
            if (id.length == 0) {
                id =$(item).val();

            }
            else {
                id += "," + $(item).val();

            }
        });
        window.location.href = url + '?patient_id=' + id;
    }
}

function processEdit(form, url) {
    var atLeastOneIsChecked = $('input[name=\"' + form + '_c0[]\"]:checked').length;
    if (atLeastOneIsChecked <= 0) {
        alert('Please select one record to update');
    } else if (atLeastOneIsChecked > 1) {
        alert('Please select only one record to update');
    } else {
        var id = $('input[name=\"' + form + '_c0[]\"]:checked').val();
        window.location.href = url + '/' + id;
    }
}

function processEditPatient(form, url) {
    var atLeastOneIsChecked = $('input[name=\"' + form + '_c0[]\"]:checked').length;
    if (atLeastOneIsChecked <= 0) {
        alert('Please select one record to update');
    } else if (atLeastOneIsChecked > 1) {
        alert('Please select only one record to update');
    } else {
        var id = $('input[name=\"' + form + '_c0[]\"]:checked').val();
        window.location.href = url + '?patient_id=' + id;
    }
}

function processDelete(form, url) {
    var atLeastOneIsChecked = $('input[name=\"' + form + '_c0[]\"]:checked').length;
    if (atLeastOneIsChecked <= 0) {
        alert('Please select at least one record to delete');
    } else if (window.confirm('Are you sure you want to delete the selected records?')) {
        
        $.ajax({
            type: 'POST',
            url: url,
            dataType: 'json',
            data: $('#' + form + '-bulk').serialize(),
//            success: function() {
//                
//                
//               
//            }
        }).done(function() {
            //alert( "success" );
          })
          .fail(function() {
            //alert( "error" );
          })
          .always(function() {
                
                console.info(111);
               //save success
               window.location.reload();
                
          });

    }
}

function processPrintSelected(form, url) {
    var atLeastOneIsChecked = $('input[name=\"' + form + '_c0[]\"]:checked').length;
    if (atLeastOneIsChecked <= 0) {
        alert('Please select at least one record to print');
    } else {
        $.ajax({
            type: 'POST',
            url: url,
            dataType: 'json',
            data: $('#' + form + '-bulk').serialize(),
            success: function(response) {}
        });
    }
}

function addToQueue(form) {
    processAddToQueue(form, urlAddToQueue);
}

function editPatient(form) {
    processEditPatient(form, urlUpdatePatient);
}

function editGlucose(form) {
    processEdit(form, urlUpdateGlucose);
}

function editBloodPressure(form) {
    processEdit(form, urlUpdateBloodPressure);
}

function editHeightWeight(form) {
    processEdit(form, urlUpdateHeightWeight);
}


function editDrugAlert(form) {
    processEdit(form, urlUpdateDrugAlert);
}

function editMedicalRecord(form) {
    processEdit(form, urlUpdateMedicalRecord);
}

function deleteDrugAlert() {
    var form = 'drug-alert-grid';
    processDelete(form, urlDeleteDrugAlert);
}

function deleteAppointmentHistory() {
    var form = 'appointment-history-grid';
    processDelete(form, urlDeleteAppointmentHistory);
}

function deleteGlucose() {
    var form = 'glucose-grid';
    processDelete(form, urlDeleteGlucose);
}

function deleteMedicalRecord() {
    var form = 'medical-record-grid';
    processDelete(form, urlDeleteMedicalRecord);
}

function deleteBloodPressure() {
    var form = 'blood-pressure-grid';
    processDelete(form, urlDeleteBloodPressure);
}

function deleteHeightWeight() {
    var form = 'heightweight-grid';
    processDelete(form, urlDeleteHeightWeight);
}

function printSelectedPrescription() {
    var form = 'prescription-grid';
    processPrintSelected(form, urlPrintSelectedPrescription);
}

function printSelectedPaymentHistory() {
    var form = 'payment-history-grid';
    processPrintSelected(form, urlPrintSelectedPaymentHistory);
}

function printSelectedHeightWeight() {
    var form = 'heightweight-grid';
    processPrintSelected(form, urlPrintSelectedHeightWeight);
}

function processToolPrintSelected(form, formcolumn, url) {
    var atLeastOneIsChecked = $('input[name=\"' + form + '_c0[]\"]:checked').length;
    if (atLeastOneIsChecked <= 0) {
        alert('Please select at least one record to print');
    } else {
        var params = {};
        var print_columns_array = $('#' + formcolumn).serializeArray();
        var print_columns = {};
        $.each(print_columns_array, function(index, element) {
            print_columns[element.name] = element.value;
        });
        params['print-column'] = print_columns;

        print_columns_array = $('input[name=\"' + form + '_c0[]\"]:checked').serializeArray();
        print_columns = {};
        $.each(print_columns_array, function(index, element) {
            print_columns[index] = element.value;
        });
        params['patient'] = print_columns;
        $.ajax({
            type: 'POST',
            url: url,
            dataType: 'json',
            data: params,
            success: function($response) {
                //save success
            }
        });
    }
}

function printPatientChecked() {
    var form = 'print-patient-checked-grid';
    var formcolumn = 'print-patient-checked-form';
    processToolPrintSelected(form, formcolumn, urlPrintPatientChecked);
}

function printPatientNameLabel() {
    var form = 'print-patient-name-label-grid';
    var formcolumn = 'print-patient-name-label-form';
    processToolPrintSelected(form, formcolumn, urlPrintPatientNameLabel);
}

function printPatientProfile() {
    var form = 'print-patient-profile-grid';
    var formcolumn = 'print-patient-profile-form';
    processToolPrintSelected(form, formcolumn, urlPrintPatientProfile);
}

function deleteDocument(id, type) {
    if (window.confirm('Are you sure you want to delete this item?')) {
        $.ajax({
            type: 'POST',
            url: urlDeleteDocument,
            dataType: 'json',
            data: { "id": id, "type": type },
            success: function($response) {
                if ($response.code) {
                    alert("Your item has been deleted successfully !");
                    var id = $response.id;
                    var cla = $response.type + '_' + $response.id;
                    $('.' + cla).css({ 'display': 'none' });
                };
            }
        });
    }
}

/**
 * Added class for all table
 * @param  {[type]} ) {               $('.grid-view').find('table').removeClass('items');    $('.grid-view').find('table').addClass('table table-hover table-responsive table-bordered');} [description]
 * @return {[type]}   [description]
 */
$(window).load(function() {
    $('.grid-view').find('table').removeClass('items');
    $('.grid-view').find('table').addClass('table table-hover table-responsive table-bordered');
});

$(window).ready(function() {
    $('#Patient_same_resedential_address').trigger('change');

    $('#Patient_same_resedential_address').on('change', function() {
        var mailling = $("#Patient_same_resedential_address:checked").val();
        if (mailling == 1) {
            //copy residential data to mailling data
            var params = Array;
            params['country'] = $('#Patient_residential_country').val();
            params['block_house'] = $('#Patient_residential_block_house').val();
            params['unit_from'] = $('#Patient_residential_unit_from').val();
            params['unit_to'] = $('#Patient_residential_unit_to').val();
            params['street'] = $('#Patient_residential_street').val();
            params['building_name'] = $('#Patient_residential_building_name').val();
            params['postal_code'] = $('#Patient_residential_postal_code').val();

            fnCopyDataForMailling(params);
        } else {
            fnResetMailling();
        }
    });

    $('#Patient_dob').on('change', function() {
        var a = fnCountAge($(this).val());
        $('.bio-age').html(a);
        $('#Patient_age').val(a);
    });
    $('#Patient_spouse_dob').on('change', function() {
        var a = fnCountAge($(this).val());
        $('.spouse-age').html(a);
        $('#Patient_spouse_age').val(a);
    });
    validateNumber();
});

function fnResetMailling() {
    var nul = '';
    $('#Patient_mailling_country').val(nul);
    $('#Patient_mailling_block_house').val(nul);
    $('#Patient_mailling_unit_from').val(nul);
    $('#Patient_mailling_unit_to').val(nul);
    $('#Patient_mailling_street').val(nul);
    $('#Patient_mailling_building_name').val(nul);
    $('#Patient_mailling_postal_code').val(nul);
}

function fnCopyDataForMailling(params) {
    $('#Patient_mailling_country').val(params['country']);
    $('#Patient_mailling_block_house').val(params['block_house']);
    $('#Patient_mailling_unit_from').val(params['unit_from']);
    $('#Patient_mailling_unit_to').val(params['unit_to']);
    $('#Patient_mailling_street').val(params['street']);
    $('#Patient_mailling_building_name').val(params['building_name']);
    $('#Patient_mailling_postal_code').val(params['postal_code']);
}

function fnCountAge(dob) {
    var newDob = new Date(dob);
    var currentTime = new Date();
    var diff = currentTime.getTime() - newDob.getTime();
    var age = Math.floor(diff / ((1000 * 60 * 60 * 24 * 365.25) - 61775));
    return age;
}

function validateNumber() {
    $(".numeric-control").keydown(function(e) {
        var key = e.which;
        // backspace, add, tab, left arrow, up arrow, right arrow, down arrow, delete, numpad decimal pt, period, enter
        if (key != 8 && key != 107 && key != 187 && key != 16 && key != 9 &&
            key != 37 && key != 38 && key != 39 && key != 40 && key != 46 && key != 110 &&
            key != 190 && key != 13 && key != 96 && key != 97 && key != 98 && key != 99 && key != 100 && key != 101 && key != 102 && key != 103 && key != 104 && key != 105) {
            if (e.shiftKey) {
                if (key == 61)
                    return key.returnValue;
                else
                    e.preventDefault();
            } else {
                if (key < 48) {
                    e.preventDefault();
                } else if (key > 57) {
                    e.preventDefault();
                }
            }
        }
    });
}

function processAddToPayments(form, url) {
    var atLeastOneIsChecked = $('input[name=\"' + form + '[]\"]:checked').length;
    if (atLeastOneIsChecked <= 0) {
        alert('Please select one record to add to make payment');
    } else if (atLeastOneIsChecked > 1) {
        alert('Please select only one record to add to make payment');
    } else {
        var id = $('input[name=\"' + form + '[]\"]:checked').val();
        window.location.href = url + '?queue_id=' + id;
    }
}

function processViewToPayments(form, url) {
    var atLeastOneIsChecked = $('input[name=\"' + form + '[]\"]:checked').length;
    if (atLeastOneIsChecked <= 0) {
        alert('Please select one record to add to view payment');
    } else if (atLeastOneIsChecked > 1) {
        alert('Please select only one record to add to view payment');
    } else {
        var id = $('input[name=\"' + form + '[]\"]:checked').val();
        window.location.href = url + '/id/' + id;
    }
}

function addToPayments(form) {

    var url = $('.btn_make_payments').attr('data-url');
    processAddToPayments(form, url);
}

function viewToPayments(form) {
    var url = $('.btn_view_payments').attr('data-url');
    processViewToPayments(form, url);
}

jQuery(document).ready(function($) {
    $('#tabs').tab();
});
