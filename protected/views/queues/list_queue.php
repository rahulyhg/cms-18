<script>
function deleteQueueAction()
{
    var atLeastOneIsChecked = $('input[name="selectqueue[]"]:checked').length > 0;
    if (atLeastOneIsChecked)
    {
        var r = confirm("Do you want to delete selected queues?");
        if (r == true) 
            $("#queueaction").submit();
    }
    else
    {
        alert('Please select queue you want to delete');
    }
}
</script>
<div class="row">
    <div class="col-md-12">
        <div class="box-1">
            <div class="title-box clearfix">
                <h2 class="title"><?php echo Yii::t('static', 'Queue') ?></h2>
                <?php echo CHtml::htmlButton(Yii::t('static', '<span class="glyphicon glyphicon-trash"></span> Delete From Queue'), array('class' => 'btn-1 pull-right', 'onclick' => 'deleteQueueAction()')); ?>
                <?php echo CHtml::link(Yii::t('static', '<span class="glyphicon glyphicon-print"></span> Print Queue'), array('mpdfprint/index', 'type' => 'queue'), array('class' => 'btn-1 pull-right')); ?>
                <?php echo CHtml::link(Yii::t('static', '<span class="glyphicon glyphicon-plus"></span> Add To Queue'), array('queues/SearchPatient'), array('class' => 'btn-1 pull-right')); ?>
            </div>

            <div class="row note-bar">
                <div class="col-md-8"></div>
                <div class="col-md-4">
                    <div class="legend bg-danger pull-right">Unbalance</div>
                    <div class="legend bg-success pull-right">Paid</div>
                    <div class="legend bg-primary pull-right">Seen</div>
                    <div class="pull-right">Legend: </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12" id="no-more-tables">
                    <form method="post" action="" name="queueaction" id="queueaction">
                        <?php
                        $this->renderNotifyMessage();
                        $hasQueue = false;
                        $i = 1;

                        $listQueue = Queue::model()->getQueuesByDoctorId(Yii::app()->user->id);
                        if (!empty($listQueue)):
                            $hasQueue = true;
                            //echo '<h5>' . $doctor->name . '</h5>';
                            $this->renderPartial('_doctor_queue', array('listQueue' => $listQueue, 'i' => $i));
                        endif;

                        if (!$hasQueue) :
                            ?>
                            No results found<br />
                            New patient : <a href="<?php echo Yii::app()->createAbsoluteUrl("/patients/create?add_queue=yes"); ?>">Click here</a> to Add New Patient

                        <?php endif; ?>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
