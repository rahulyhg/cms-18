<table id="time-table-tb" class="time-table-tb cell-select col-xs-12">
    <thead>
        <tr>
            <th width="50">&nbsp;</th>
            <?php foreach (HDateTime::model()->dayOfWeeks2() as $key => $value) : ?>
            <th><?php echo $value; ?></th>
            <?php endforeach; ?>
        </tr>
    </thead>
    <tbody>
        <?php
        $time = array(0=>'AM', 1=>'PM');
        for ($i = 0; $i < 2; $i++) { ?>
        <tr>
            <th style="text-align: center;"><?php echo $time[$i]; ?></td>
            <?php foreach($doctorTime as $dt) :
                $doctor_name = $dt->doctor->fullname;
                if ($dt->time != $time[$i]) continue;
            ?>
                <td style="width: 150px;">
                    <div class="cell-time" >&nbsp;&nbsp;&nbsp;</span>&nbsp;<?php echo $doctor_name; ?></p>
                </td>
            <?php endforeach; ?>
        </tr>
        <?php } ?>
    </tbody>
</table>

<style type="text/css">
.time-table-tb { width: 100% !important;  margin-left: 15px;}
.time-table-tb , .time-table-tb td, .time-table-tb tr, .time-table-tb th {
    border-collapse: collapse;
    border-spacing: 0;
    border: 1px solid #666666;
    padding: 7px;
    font-size: 12px;
}

.time-table-tb > tbody td {
    padding: 0px;
    vertical-align: top;
   
}
.time-table-tb > tbody td div {
    padding: 1em;
}
.time-table-tb > tbody td.has-data:hover,  .time-table-tb > tbody td.has-data:hover div, .time-table-tb > tbody td.has-data.active, .time-table-tb > tbody td.has-data.active div {
    background: #ff0000!important;
    cursor: pointer;
    color: #fff;
    font-weight: bold;
}

</style>