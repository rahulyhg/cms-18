
<table class="table table-responsive table-bordered">
    <thead>
        <tr>
            <th width="2%" style="white-space: nowrap">Q-No.</th>
            <th width="8%">Time In</th>
            <th width="8%">Time Out</th>
            <th width="35%">Patient Name</th>
            <th width="10%">Paid</th>
            <th width="10%">Contact/Insurance</th>
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
            <td><?php echo $queueItem->paid;?></td>
            <td><?php echo $queueItem->contact_insurance;?></td>
            <td><?php echo $queueItem->comments;?></td>
        </tr>
        <?php endforeach; ?>
        
    </tbody>
</table>