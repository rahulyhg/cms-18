<h3>Appointment List of <?php echo $doctor->salutation.' '.$doctor->name; ?></h3>
<p><b>Date:</b> <?php $dateStr = '';
    if ($startDate != '' && $endDate != '' ) {
        if ($startDate == $endDate) 
            $dateStr = date("d/m/Y",strtotime($startDate));
        else 
            $dateStr = date("d/m/Y",strtotime($startDate)).' - '.date("d/m/Y",strtotime($endDate));
    }
    elseif ($startDate != '' && $endDate == '') 
        $dateStr = date("d/m/Y",strtotime($startDate)).' - 01/01/2200';
    elseif ($startDate == '' && $endDate != '') 
        $dateStr = date("d/m/Y",strtotime($endDate));
    echo $dateStr;
?> </p>

<p><b>Print time:</b> <?php echo date('d/m/Y g:i a') ?></p>

<div class="col-sm-8 col">
<table class="appointment-tbl">
    <thead style="font-size:12px;">
        <th align="center" style="text-align: center">
            <input class="select-on-check-all" value="0" type="checkbox" name="checkAll" id="checkAll">
        </th>
        <th>S/N</th>
        <th>Date</th>
        <th>Time</th>
        <th>Name</th>
        <th>Phone</th>
        <th>Visit Reason</th>
        <th>Turn Up</th>
    </thead>
    <tbody style="font-size:12px;">
        <?php
        $count = 0;
        foreach ($model as $m) {
            $checked = $m->turn_up == 1?'checked="checked"':'';
        ?>
            <tr>
                <td align="center" class="select-patient">
                    <input class="select-on-check" value="<?= $m->timeslot_id ?>" id="patient-check" type="checkbox" name="patient-check">
                </td>
                <td><?php echo ++$count;?></td>
                <td><?php echo date("d/m/Y",strtotime($m->timeslot->start));?></td>
                <td><?php echo date("g:i a",strtotime($m->timeslot->start));?></td>
                <td><?php echo $m->patient_name; ?></td>
                <td><?php echo $m->patient_mobile;?></td>
                <td <?php echo $m->visit_reason == 1 ?"style='color:red;'":"";?>> <?php echo Appointment::$visit_reason[$m->visit_reason]; ?></td>
                <!-- <td><?php echo $m->comments;?></td> -->
                <td align="center"><input type="checkbox" value="<?php echo $m->timeslot_id; ?>" class="turn_up" <?php echo $checked; ?> /></td>
            </tr>
        <?php } ?>
    </tbody>
</table>
<p><i>Total: <?php echo $count; ?> patients</i></p>
</div>
<input type="hidden" id="ajaxTurnUpAppointment" value="<?php echo Yii::app()->createUrl('ajax/turnUpAppointment/');?>" />
<script type="text/javascript">
$(function(){
    $('.turn_up').click(function(){
        event_id = $(this).val();
        status = 0;
        url = $('#ajaxTurnUpAppointment').val();
        if ($(this).is(':checked')) status = 1;
        else status = 0;
        $.ajax({
            url: url,
            type: 'post',
            data: {event_id: event_id, status:status},
        })
        .done(function() {

        })
    });

    $("#checkAll").change(function () {
        $("input:checkbox[name='patient-check']").prop('checked', $(this).prop("checked"));
    });
})

</script>


<style type="text/css">
.appointment-tbl { width: 100%; border-collapse: collapse;}
.appointment-tbl, .appointment-tbl th, .appointment-tbl td {
   border: 1px solid #000;
   padding: 5px;
}
.print-group { float: right; margin-right: 50px;}

</style>
