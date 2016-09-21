
<table class="table table-responsive table-bordered">
    <thead>
        <tr>
            <th width="2%" style="white-space: nowrap">P-No.</th>
            <th width="5%">Time In</th>
            <th width="5%">Time Out</th>
            <th width="28%">Patient Name</th>
            <th width="5%">Seen</th>
            <th width="14%">Dispense</th>
            <th width="6%">Bill</th>
            <th width="6%">Paid</th>
            <th width="5%">Contact/Insurance</th>
            <th width="25%">Comments</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        
        foreach($listQueue as $queueItem):?>
            <tr <?php echo Yii::app()->format->formatCheckQueueType($queueItem);?>>
            <td scope="row">
                <input type="checkbox" name="selectqueue[]" value="<?php echo $queueItem->id;?>">
            </td>
            <td><?php echo date("h:i A", strtotime($queueItem->time_in)); ?></td>
            <td><?php echo $queueItem->time_out != '' ? date("h:i A", strtotime($queueItem->time_out)): ''; ?></td>
            <td><?php echo $queueItem->patient_name;?></td>
            <td style="text-align: center"><?php echo $queueItem->seen == 1?'<span class="glyphicon glyphicon-ok"></span>':'<a href="#" onclick="setSeen(' . $queueItem->id . ')"><span class="glyphicon glyphicon-remove"></span></a>';?></td>
            <td style="text-align: left">
                <?php if ($queueItem->dispense == 1){
                        $dispenseList = MyFunctionCustom::getDispense($queueItem->id,2);
                        if ($dispenseList != '')
                            echo $dispenseList;
                        else
                            echo '<span class="glyphicon glyphicon-ok"></span>';
                    }
                    else
                    {
                        if ($queueItem->bill == 0 || $queueItem->bill == '')
                        {
                            echo '<a href="' . Yii::app()->createAbsoluteUrl("payments/makePayments?queue_id=" . $queueItem->id) . '"><span class="glyphicon glyphicon-remove"></span></a>';
                        }
                        else
                        {
                            echo '<span class="glyphicon glyphicon-remove"></span>';
                        }
                    }
                    ?>
            </td>
            <td>
                <?php if ($queueItem->bill == 0 || $queueItem->bill == ''):?>
                    <a href="<?php echo Yii::app()->createAbsoluteUrl("payments/makePayments?queue_id=" . $queueItem->id);?>">No</a>
                <?php else: ?>
                    <?php echo $queueItem->bill;?>
                <?php endif;?>
                    
                
            </td>
            <td>
                <?php if ($queueItem->paid == 0 || $queueItem->paid == ''):?>
                    <a href="<?php echo Yii::app()->createAbsoluteUrl("payments/makePayments?queue_id=" . $queueItem->id);?>">No</a>
                <?php else: ?>
                    <?php echo $queueItem->paid;?>
                <?php endif;?>
            </td>
            <td><?php echo $queueItem->patient->patientmedicalinsurrance ? $queueItem->patient->patientmedicalinsurrance->insurrance_name : '';?></td>
            <td><?php echo $queueItem->comments;?></td>
            
        </tr>
        <?php endforeach; ?>
        
    </tbody>
</table>
<script>
    function setSeen(id)
    {
        var txt;
        var r = confirm("Do you want to set as seen for this item?");
        if (r == true) {
            location.href = "<?php echo Yii::app()->createAbsoluteUrl('/payments/changeSeen?id=');?>"+id;
        } 
    }
</script>