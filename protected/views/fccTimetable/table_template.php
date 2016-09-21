<table id="time-table-tb" class="time-table-tb cell-select col-xs-8">
    <thead>
        <tr>
            <th style="width:50px !important;">&nbsp;</th>
            <?php foreach ($daysWeek as $key => $value) : ?>
            <th><?php echo $value; ?></th>
            <?php endforeach; ?>
        </tr>
    </thead>
    <tbody>
        <?php
        $time = array(0=>'AM', 1=>'PM');
        for ($i = 0; $i < 2; $i++) { ?>
	        <tr>
	            <th style="width:50px !important; text-align: center;"><?php echo $time[$i]; ?></td>
	            <?php foreach($data as $dt) :
	                $doctor = $dt->doctor;
	                if ($dt->time != $time[$i]) continue;
	            ?>
	                <td>
	                    <div  class="cell-time" time_id="<?php echo $dt->id; ?>"  doctor_id="<?php echo $dt->doctor->uuid; ?>" ><?php echo $doctor->fullname; ?></div>
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
    width: 100px;
}
.time-table-tb > tbody td div {
    padding: 1em;
}


.time-table-tb > tbody td:hover, .time-table-tb > tbody td.active{
    background: #ff0000!important;
    cursor: pointer;
    color: #fff;
    font-weight: bold;
}

</style>