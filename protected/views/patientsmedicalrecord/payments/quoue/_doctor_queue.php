
<table class="table table-responsive table-bordered">
    <thead>
        <tr>
            <th width="2%" style="white-space: nowrap">Q-No.</th>
            <th width="5%">Time In</th>
            <th width="5%">Time Out</th>
            <th width="35%">Patient Name</th>
            <th width="5%">Seen</th>
            <th width="5%">Dispense</th>
            <th width="5%">Bill</th>
            <th width="5%">Paid</th>
            <th width="5%">Contact/Insurance</th>
            <th width="5%">Height</th>
            <th width="5%">Weight</th>
            <th width="25%">Comments</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $i = 1;
        foreach($listQueue as $queueItem):?>
        <tr <?php echo Yii::app()->format->formatCheckQueueType($queueItem);?>>
            <td scope="row"><input type="checkbox" name="selectqueue[]" value="<?php echo $queueItem->id;?>"> <?php echo $i;?></td>
            <td><?php echo date("h:i A", strtotime($queueItem->time_in)); ?></td>
            <td><?php echo date("h:i A", strtotime($queueItem->time_out)); ?></td>
            <td><?php echo $queueItem->patient_name;?></td>
            <td><?php echo $queueItem->seen == 1?'<span class="glyphicon glyphicon-ok"></span>':'<span class="glyphicon glyphicon-remove"></span>';?></td>
            <td><?php echo $queueItem->dispense == 1?'<span class="glyphicon glyphicon-ok"></span>':'<span class="glyphicon glyphicon-remove"></span>';?></td>
            <td><?php echo $queueItem->bill;?></td>
            <td><?php echo $queueItem->paid;?></td>
            <td><?php echo $queueItem->contact_insurance;?></td>
            <td><?php echo $queueItem->height;?></td>
            <td><?php echo $queueItem->weight;?></td>
            <td><?php echo $queueItem->comments;?></td>
        </tr>
        <?php endforeach; ?>
        
    </tbody>
</table>