<div class="box-1 add-new-patient add-new">
    <div class="title-box clearfix">
        <h2 class="title"><?php echo Yii::t('static', 'Edit Drug Alert') ?></h2>
        <?php echo CHtml::link(Yii::t('static', '<span class="glyphicon glyphicon-ban-circle"></span> Cancel and Back'), array('/patients/appointmenthistory'), array('class' => 'btn-1 pull-right')); ?>
        <?php echo CHtml::link(Yii::t('static', '<span class="glyphicon glyphicon-floppy-disk"></span> Save'), array('/patients/appointmenthistory'), array('class' => 'btn-1 pull-right')); ?>
    </div>
    <div class="box-body">
        <?php echo $this->renderPartial('_form'); ?>
    </div>
</div>

