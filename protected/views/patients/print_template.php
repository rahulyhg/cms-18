<title>Print Patients</title>
<h3>Appointment List of <?php echo $doctor->salutation.' '.$doctor->name; ?>
<p class="print-now"><a title="" onclick="return window.print();" href="javascript:;" style="text-decoration: none;" ><img src="<?php echo Yii::app()->theme->baseUrl . '/img/print-icon.png'?>" /> Print now</a></p>
</h3>
<p><b>Date:</b> <?php $dateStr = '';
    if ($startDate != '' && $endDate != '' ) {
        if ($startDate == $endDate) $dateStr = date("d/m/Y",strtotime($startDate));
        else $dateStr = date("d/m/Y",strtotime($startDate)).' - '.date("d/m/Y",strtotime($endDate));
    }
    elseif ($startDate != '' && $endDate == '') $dateStr = date("d/m/Y",strtotime($startDate)).' - 01/01/2200';
    elseif ($startDate == '' && $endDate != '') $dateStr = '01/01/1990 - '.date("d/m/Y",strtotime($endDate));
    echo $dateStr;
?> </p>
<p><b>Session:</b> <?php echo $time == '' ? 'All Day' : $time ?></p>

<p><b>Print time:</b> <?php echo date('d/m/Y g:i a') ?></p>




<div class="print-out">
<table class="appointment-tbl">
    <thead>
        <th>S/N</th>
        <th>Date</th>
        <th>Time</th>
        <th>Name</th>
        <th>Phone</th>
        <th>Visit Reason</th>
        <th>Turn Up</th>
    </thead>
    <tbody>
        <?php
        $count = 0;
        $turn_up = 0;
        $consult = 0;
        $consult_not_turn_up = 0;
        $others  = 0;
        $other_not_turn_up = 0;
        $chemotherapy  = 0;
        $chemotherapy_not_turn_up = 0;
        $totalEvent = count($model);
        $ids = explode('-', $ids);
        foreach ($model as $m) {
            switch ($m->visit_reason) {
                case 0:
                    $consult++;
                    if (!in_array($m->timeslot_id, $ids)) $consult_not_turn_up++;
                    break;
                case 1:
                    $chemotherapy++;
                    if (!in_array($m->timeslot_id, $ids)) $chemotherapy_not_turn_up++;
                    break;

                default:
                    $others++;
                    if (!in_array($m->timeslot_id, $ids)) $other_not_turn_up++;
                    break;
            }
        ?>
            <tr>
                <td><?php echo ++$count;?></td>
                <td><?php echo date("d/m/Y",strtotime($m->timeslot->start));?></td>
                <td><?php echo date("g:i a",strtotime($m->timeslot->start));?></td>
                <td><?php echo $m->patient_name; ?></td>
                <td><?php echo $m->patient_mobile;?></td>
                <td <?php  echo $m->visit_reason == 1 ?"style='color:red;'":"";?>> <?php echo Appointment::$visit_reason[$m->visit_reason]; ?></td>
                <td>
                    <?php
                        if (in_array($m->timeslot, $ids)) {
                            echo 'Yes';
                            $turn_up++;
                        }
                        else {
                            echo 'No';
                        }
                    ?>
                </td>
            </tr>
        <?php
            if (($count % 14) == 0) { ?>
                </tbody>
            </table>
                <div class="page-break"></div>
                <table class="appointment-tbl">
                    <thead>
                        <th>S/N</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Name</th>
                        <th>ID</th>
                        <th>Phone</th>
                        <th>Visit Reason</th>
                        <th>Turn Up</th>
                    </thead>
                    <tbody>
            <?php } ?>
        <?php } ?>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td valign="top" >
                    <p><strong>Summary:</strong></p>
                    <p>Consult = <?php echo $consult; if ($consult_not_turn_up > 0) echo ' (No='.$consult_not_turn_up.')'; ?></p>
                    <p>Others =  <?php echo $others; if ($other_not_turn_up > 0) echo ' (No='.$other_not_turn_up.')';?></p>
                    <p>Chemotherapy = <?php echo $chemotherapy; if ($chemotherapy_not_turn_up > 0) echo ' (No='.$chemotherapy_not_turn_up.')';?></p>
                </td>
                <td valign="top">
                    <p><strong>Summary:</strong></p>
                    <p>Yes = <?php echo $turn_up; ?></p>
                    <p>No = <?php echo $totalEvent-$turn_up; ?></p>
                </td>
            </tr>
    </tbody>
</table>
<p><i>Total: <?php echo $totalEvent; ?> patients</i></p>


</div>

<div class="col-sm-8 col print-preview">
<table class="appointment-tbl">
    <thead>
        <th>S/N</th>
        <th>Date</th>
        <th>Time</th>
        <th>Name</th>
        <th>Phone</th>
        <th>Visit Reason</th>
        <th>Turn Up</th>
    </thead>
    <tbody>
        <?php
        $count = 0;
        $turn_up = 0;
        $consult = 0;
        $consult_not_turn_up = 0;
        $others  = 0;
        $other_not_turn_up = 0;
        $chemotherapy  = 0;
        $chemotherapy_not_turn_up = 0;
        $totalEvent = count($model);
        //$ids = explode('-', $ids);
        foreach ($model as $m) {
            switch ($m->visit_reason) {
                case 0:
                    $consult++;
                    if (!in_array($m->timeslot_id, $ids)) $consult_not_turn_up++;
                    break;
                case 1:
                    $chemotherapy++;
                    if (!in_array($m->timeslot_id, $ids)) $chemotherapy_not_turn_up++;
                    break;

                default:
                    $others++;
                    if (!in_array($m->timeslot_id, $ids)) $other_not_turn_up++;
                    break;
            }
        ?>
            <tr>
                <td><?php echo ++$count;?></td>
                <td><?php echo date("d/m/Y",strtotime($m->timeslot->start));?></td>
                <td><?php echo date("g:i a",strtotime($m->timeslot->start));?></td>
                <td><?php echo $m->patient_name; ?></td>
                <td><?php echo $m->patient_mobile;?></td>
                <td <?php  echo $m->visit_reason == 1 ?"style='color:red;'":"";?>> <?php echo Appointment::$visit_reason[$m->visit_reason]; ?></td>
                <td>
                    <?php
                        if (in_array($m->timeslot_id, $ids)) {
                            echo 'Yes';
                            $turn_up++;
                        }
                        else {
                            echo 'No';
                        }
                    ?>
                </td>
            </tr>
        <?php } ?>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td valign="top" >
                    <p><strong>Summary:</strong></p>
                    <p>Consult = <?php echo $consult; if ($consult_not_turn_up > 0) echo ' (No='.$consult_not_turn_up.')'; ?></p>
                    <p>Others =  <?php echo $others; if ($other_not_turn_up > 0) echo ' (No='.$other_not_turn_up.')';?></p>
                    <p>Chemotherapy = <?php echo $chemotherapy; if ($chemotherapy_not_turn_up > 0) echo ' (No='.$chemotherapy_not_turn_up.')';?></p>
                </td>
                <td valign="top">
                    <p><strong>Summary:</strong></p>
                    <p>Yes = <?php echo $turn_up; ?></p>
                    <p>No = <?php echo $totalEvent-$turn_up; ?></p>
                </td>
            </tr>
    </tbody>
</table>
<p><i>Total: <?php echo $totalEvent; ?> patients</i></p>
</div>



<style type="text/css">
.appointment-tbl { width: 100%; border-collapse: collapse;}
.appointment-tbl, .appointment-tbl th, .appointment-tbl td {
   border: 1px solid #000;
   padding: 5px;
}
.btn-print { float: right; margin-right: 50px;}
a { color: #138ECA;}
.print-now { float: right;}
.print-out { display: none;}
@media all {
    .page-break { display: none; }
}

@media print {
    .print-out { display: block;}
    .print-preview { display: none;}
    .page-break { display: block; page-break-before: always; }
}

</style>