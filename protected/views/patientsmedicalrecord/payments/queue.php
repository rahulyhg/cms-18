<div class="row">
<div class="col-md-12">
    <div class="box-1">
        <div class="title-box clearfix">
            <h2 class="title"><?php echo Yii::t('static', 'Queue') ?></h2>
            <?php echo CHtml::link(Yii::t('static', '<span class="glyphicon glyphicon-eye-open"></span> View Payments'),'javascript:void(0);', array('class' => 'btn-1 pull-right btn_view_payments','onClick' => 'viewToPayments("selectqueue")','data-url'=>Yii::app()->createAbsoluteUrl('/payments/list'))); ?>
            <?php echo CHtml::link(Yii::t('static', '<span class="glyphicon glyphicon-plus"></span> Make Payments'), 'javascript:void(0);', array('data-url'=>Yii::app()->createAbsoluteUrl('/payments/makePayments'),'class' => 'btn-1 pull-right btn_make_payments','onClick' => 'addToPayments("selectqueue")')); ?>
        </div>

        <div class="row note-bar">
            <div class="col-md-8"></div>
            <div class="col-md-4">
                <div class="legend bg-danger pull-right">Unbalance</div>
                <div class="legend bg-success pull-right">Paid</div>
                <div class="legend bg-primary pull-right">Seen</div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-12" id="no-more-tables">
                <form method="post" action="" name="queuepaymentaction" id="queuepaymentaction">
                    <?php
                    $hasQueue = false;
                    if (!empty($doctorList)):
                        foreach ($doctorList as $doctor):

                            $listQueue = Queue::model()->getQueuesByDoctorId($doctor->id);
                            if (!empty($listQueue)):
                                $hasQueue = true;
                                echo '<h5>' . $doctor->name . '</h5>';
                                $this->renderPartial('quoue/_doctor_queue', array('listQueue' => $listQueue));
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