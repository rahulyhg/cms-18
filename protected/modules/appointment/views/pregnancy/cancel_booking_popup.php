<?php
$this->title = Yii::t('static', 'Cancel Appointment');
?>

<div class="book_success_info">
    <p><h3>Do you want to cancel this appointment?</h3></p>
    <p><strong>Doctor: </strong><?php echo $model->doctorName; ?></p>
    <p><b>Patient Name:  </b><?php echo $data->patient_name; ?></p>
    <p><b>Type:  </b><?php echo $scanText ?></p>
    <p><b>Appointment: </b><?php echo $model->appointmentTime; ?></p>

</div>
<form  method="post">
    <div class="form-group">
        <input type="button" name="delete_confirm" value="Yes"  class="btn btn-primary btnYes"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <button type="button" class="btn btn-primary btnNo">No</button>
    </div>
</form>

<input type="hidden" id="ajaxCancel" value="<?php echo Yii::app()->createAbsoluteUrl('/appointment/ajax/cancelAppointment'); ?>" />

<script>
    $(function() {

        $('.btnYes').click(function() {
            url = $('#ajaxCancel').val();
            id = <?php echo $model->id; ?>;
            $.post(url, {id: id})
                .done(function (data) {
//                    alert(data);
                    $.fancybox.close();
                });
        });
        $('.btnNo').click(function() {
            $.fancybox.close();
        });
    });
</script>


