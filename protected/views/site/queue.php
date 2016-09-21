<div class="row">
<div class="col-md-12">
    <div class="box-1">
        <div class="title-box clearfix">
            <h2 class="title"><?php echo Yii::t('static', 'Queue') ?></h2>
            <?php echo CHtml::htmlButton(Yii::t('static', '<span class="glyphicon glyphicon-trash"></span> Delete From Queue'), array('class' => 'btn-1 pull-right', 'onclick' => '$("#queueaction").submit();')); ?>
            <?php echo CHtml::link(Yii::t('static', '<span class="glyphicon glyphicon-print"></span> Print Queue'), array('#'), array('class' => 'btn-1 pull-right')); ?>
            <?php echo CHtml::link(Yii::t('static', '<span class="glyphicon glyphicon-plus"></span> Add To Queue'), array('queues/SearchPatient'), array('class' => 'btn-1 pull-right')); ?>
        </div>

        <div class="row note-bar">
            <div class="col-md-9"></div>
            <div class="col-md-3">
                <div class="legend bg-danger pull-right">Unbalance</div>
                <div class="legend bg-success pull-right">Paid</div>
                <div class="legend bg-primary pull-right">Seen</div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12" id="no-more-tables">
                <form method="post" action="<?php echo Yii::app()->createAbsoluteUrl('queues/queue');?>" name="queueaction" id="queueaction">
                    <?php
                    $hasQueue = false;
                    if (!empty($doctorList)):
                        foreach ($doctorList as $doctor):

                            $listQueue = Queue::model()->getQueuesByDoctorId($doctor->id);
                            if (!empty($listQueue)):
                                $hasQueue = true;
                                echo '<h5>' . $doctor->name . '</h5>';
                                $this->renderPartial('_doctor_queue', array('listQueue' => $listQueue));
                            endif;
                        endforeach;
                    endif;
                    if (!$hasQueue) :
                        ?>
                        No queues found
                    <?php endif; ?>
                </form>
            </div>
        </div>
    </div>
</div>
</div>