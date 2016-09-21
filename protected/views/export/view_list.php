
<h3>Appointment List of <?php echo $doctor->salutation.' '.$doctor->name; ?></h3>
<p><b>Date:</b> <?php $dateStr = '';
    if ($startDate != '' && $endDate != '' ) {
        if ($startDate == $endDate) $dateStr = date("d/m/Y",strtotime($startDate));
        else $dateStr = date("d/m/Y",strtotime($startDate)).' - '.date("d/m/Y",strtotime($endDate));
    }
    elseif ($startDate != '' && $endDate == '') $dateStr = date("d/m/Y",strtotime($startDate)).' - 01/01/2200';
    elseif ($startDate == '' && $endDate != '') $dateStr = '01/01/1990 - '.date("d/m/Y",strtotime($endDate));
    echo $dateStr;
?> </p>

<div>
<table class="appointment-tbl">
    <thead style="font-size:12px;">
        <th class="DoctorName">Doctor Name</th>
        <th class="name">Patient</th>
        <th class="nric">Patient's ID</th>
        <th class="contact">Contact</th>
        <th class="Date">Date</th>
        <th class="Time">Time</th>
        <th class="VisitReason">Visit Reason</th>
        <th class="comments">Comments</th>
        <th class="turnup">Turn Up</th>
    </thead>
    <tbody style="font-size:12px;">
        <?php
        $count = 0;
        foreach ($model as $m) {
            $checked = $m->turn_up == 1?'checked="checked"':'';
            ++$count;
        ?>
            <tr>
                <td class="DoctorName"><?php 
                    $doctor = Doctor::model()->findByPk($m->event->doctor_id);
                    echo $doctor->salutation.' '.$doctor->name;
                ?></td>
                <td class="name"><?php echo $m->name; ?></td>
                <td class="nric"><?php echo $m->nric; ?></td>
                <td class="contact"><?php echo $m->contact;?></td>
                <td class="Time"><?php echo date("d/m/Y",strtotime($m->event->start));?></td>
                <td class="Time"><?php echo date("g:i a",strtotime($m->event->start));?></td>
                <?php if ($m->event->type == 'op') { ?>
                <td class="VisitReason">Operation</td>
                <?php } else { ?>
                <td class="VisitReason" <?php  echo $m->visit_reason == 1 ?"style='color:red;'":"";?>> <?php echo Appointment::$visit_reason[$m->visit_reason]; ?></td>
                <?php } ?>
                <td class="comments"><?php echo $m->comments;?></td> 
                <td class="turnup" align="center"><input type="checkbox" value="<?php echo $m->event_id; ?>" class="turn_up" <?php echo $checked; ?> /></td>
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
    
    <?php foreach ($columns as $col) { ?>
            $('.<?php echo $col ?>').show();
    <?php } ?>
})

</script>


<style type="text/css">
.appointment-tbl { width: 100%; border-collapse: collapse; table-layout:fixed;}
.appointment-tbl, .appointment-tbl th, .appointment-tbl td {
   border: 1px solid #000;
   padding: 5px;
   word-wrap: break-word;
}
.appointment-tbl th, .appointment-tbl td { display:none;}
.print-group { float: right; margin-right: 50px;}

</style>
