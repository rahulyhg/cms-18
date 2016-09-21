<?php
$this->breadcrumbs=array(
    Yii::t('static', 'Doctor Timeslot Template'),
);

$this->menu=array(
    // array('label'=>Yii::t('static', 'Add Time Table'), 'url'=>'javascript:void(0)', 'class'=>'btn-1 add-time'),
    // array('label' => Yii::t('static', 'Log out'), 'url' => array('/site/logout'), 'class' => 'btn-1'),
    array('label' => Yii::t('static', 'Previous Page'), 'url' => 'javascript:history.go(-1)', 'class' => 'btn-1'),
);


$this->title = Yii::t('static', 'Doctor Timeslot Template');
?>


<div class="form-type">
    <div class="form-group">
        <div class="col-xs-4">
            <select multiple="true" class="form-control" id="time_day">
             <!-- <option value="all">All Day</option> -->
              <?php foreach (HDateTime::model()->dayOfWeeks() as $key => $value) : ?>
              <option value="<?php echo $key ?>"><?php echo $value ?></option>
              <?php endforeach; ?>
            </select>
        </div>
        <div class="col-xs-2">
            <select class="form-control" id="time_hour">
                <?php foreach (HDateTime::model()->hours() as $key => $value) : ?>
                <option value="<?php echo $key ?>"><?php echo $value ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-xs-2">
            <select class="form-control" id="time_minute">
                <?php foreach (HDateTime::model()->minutes() as $key => $value) : ?>
                <option value="<?php echo $key ?>"><?php echo $value ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-xs-3">
            <button class="btn btn-primary" id="add_item">Add</button>
        </div>
    </div>

    <div class="clearfix"></div>
    <h3>Template</h3>
    <div class="form-group">
        <table id="timeslot-table-tb" class="col-xs-12">
        <thead>
            <tr>
                <th>&nbsp;</th>
                <?php foreach (HDateTime::model()->dayOfWeeks() as $key => $value) : ?>
                <th><?php echo $value; ?></th>
                <?php endforeach; ?>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><h3 class="doctor_name"><?php echo $model->fullname; ?></h3></td>
                <?php foreach (HDateTime::model()->dayOfWeeks() as $key => $value) : ?>
                <td class="timeslot_data d<?php echo $key; ?>" day="<?php echo $key; ?>">

                </td>
                <?php endforeach; ?>
            </tr>
        </tbody>
        </table>
        <div class="clearfix"></div>
    </div>
    <div class="form-group">
        <button class="btn btn-primary" id="save_template">Save Template</button>
        <button class="btn btn-primary" id="generate_timeslot">Generate Timeslot</button>
    </div>
    <div class="form-group test-rs">
    </div>
    <div class="clearfix"></div>
</div>

<input type="hidden" id="ajaxSaveTemplate" value="<?php echo Yii::app()->createUrl('onlinetimeslot/SaveTemplate/'); ?>" />
<input type="hidden" id="ajaxLoadTemplate" value="<?php echo Yii::app()->createUrl('onlinetimeslot/LoadTemplate/'); ?>" />


<style type="text/css" media="screen">
    #timeslot-table-tb th {
        background-color: #DA4A38;
        padding: 15px 0;
        color: #FFF;
    }
    #timeslot-table-tb th, #timeslot-table-tb td {
        border: 1px solid #BEBEBE;
        text-align: center;
    }
    #timeslot-table-tb td.timeslot_data {
         padding: 15px 10px;
         width: 12%;
         vertical-align: top;
    }
    .timeslot_data p {
        padding: 4px;
        background-color: #FAC090; <?php //echo $model->color_code; ?>;
        border-radius: 5px;
        color: #8B6136;
        font-weight: bold;
        font-size: 12px;
    }

    .doctor_name {
        color: #DA4A38;
    }
</style>

<script type="text/javascript">
$(function(){
    var doctor_id = "<?php echo $model->uuid; ?>";
    loadTemplate(doctor_id);
    $('#add_item').click(function(event) {
        hour = $('#time_hour').val();
        minute = $('#time_minute').val();
        timeText = hour+':'+minute;
        $.each($('#time_day').val(), function( index, value ) {
            // if ( $('.time-data[hour="'+hour+'"][minute="'+minute+'"][day="'+value+'"]').length == 0 )// Ignore exist timeslot
            $('.d'+value).append('<p class="time-data" hour="'+hour+'" minute="'+minute+'" day="'+value+'"><span>'+timeText+'</span><button class="time-delete"></button></p>');
        });
        $('.time-delete').click(function(event) {
            $(this).parent('.time-data').remove();
        });
    });

    $('#save_template').click(function(event) {
         var rs = {};
         $.each($('.timeslot_data'), function( index, value ) {
            day = $(this).attr('day');
            var timearr = [];
            $.each($(this).children('.time-data'), function( index, value ) {
                hour = $(this).attr('hour');
                minute = $(this).attr('minute');
                timearr.push({"hour":hour,"minute":minute});
            });
            rs[day]= timearr;
         });
        var jsonData = JSON.stringify(rs);
        url = $('#ajaxSaveTemplate').val();
        $.ajax({
            url: url,
            type: 'POST',
            data: {doctor_id: doctor_id, data: jsonData},
        })
        .done(function(rs) {
            if (rs == 1) alert('Saved successfully! Timeslots successfully created!');
            else {
                alert('Error! Cannot save');
            }
        })
    });


    $('.time-delete').click(function(event) {
        $(this).parent('.time-data').remove();
    });
});

function loadTemplate(doctor_id) {
    $('#add_item').attr('disabled', 'disabled');
    url = $('#ajaxLoadTemplate').val();
    $.ajax({
        url: url,
        type: 'POST',
        data: {doctor_id: doctor_id},
        dataType: 'json',
        async: false,
        cache: false,
        timeout: 30000,
    })
    .done(function(data) {
        $.each(data, function(dayName, timeslots) {
            $.each(timeslots, function(index, timeslot) {
                timeText = timeslot.hour+':'+timeslot.minute;
                $('.d'+dayName).append('<p class="time-data" hour="'+timeslot.hour+'" minute="'+timeslot.minute+'" day="'+dayName+'"><span>'+timeText+'</span><button class="time-delete"></button></p>');
            });
        });
    });
    $("#add_item").removeAttr('disabled');
}

</script>