<div class="box-1">
    <div class="title-box clearfix">
        <h2 class="title"><?php echo Yii::t('static', 'Appointments') ?></h2>
        <?php echo CHtml::link(Yii::t('static', '<span class="glyphicon glyphicon-print"></span> Print Appointment'), array('appointment/print_appointment'), array('class' => 'btn-1')); ?>
        <?php echo CHtml::link(Yii::t('static', '<span class="glyphicon glyphicon-plus"></span> Add Appointment'), array('appointment/create'), array('class' => 'btn-1')); ?>
    </div>

    <div class="scroll-pane">

        <div id='calendar-doctor'></div>
        <div style="margin-top:10px; font-size:14px;">
            <?php foreach (Clinic::model()->findAll() as $clinic) : ?>
                <p style="float:left;margin-right:20px;"><span style="background: <?php echo $clinic->color_code; ?>" >&nbsp;&nbsp;&nbsp;</span>&nbsp;<?php echo $clinic->name; ?></p>
            <?php endforeach; ?>
            <div class="clearfix"></div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="box-1">
            <div class="title-box clearfix">
                <h2 class="title"><?php echo Yii::t('static', 'Notice Board') ?></h2>
                <?php echo CHtml::link(Yii::t('static', 'Delete'), array('notice/delete'), array('title' => Yii::t('static', 'Delete'), 'data-placement' => 'top', 'data-toggle' => 'tooltip', 'class' => 'ico ico-26 pull-right delete-action')) ?>
                <?php echo CHtml::link(Yii::t('static', 'Add'), array('notice/create'), array('title' => Yii::t('static', 'Add'), 'data-placement' => 'top', 'data-toggle' => 'tooltip', 'class' => 'ico ico-25 pull-right')) ?>
            </div>
            <div class="notice-board">
                <?php $this->renderPartial('/notice/_noticeboard', array('notice' => $notice)); ?>
                <div class="clearfix"></div>
            </div>
            <!--  <div class="foot-box clearfix">
            <?php echo CHtml::link(Yii::t('static', 'Delete'), array('notice/delete'), array('title' => Yii::t('static', 'Delete'), 'data-placement' => 'top', 'data-toggle' => 'tooltip', 'class' => 'ico ico-16 pull-right')) ?>
            <?php echo CHtml::link(Yii::t('static', 'Add'), array('notice/create'), array('title' => Yii::t('static', 'Add'), 'data-placement' => 'top', 'data-toggle' => 'tooltip', 'class' => 'ico ico-15 pull-right')) ?>
             </div> -->
        </div>
    </div>
</div>
<?php $this->widGet('AppoinmentCalendarWidget', array('htmlElementID' => 'calendar-doctor'));?>   
<script>
    function toggleComplete(o, value) {
    $.ajax({
    'type':'POST',
            'url':'<?php echo Yii::app()->createUrl('notice/toggle') ?>',
            'data':'Notice[id]=' + value,
            'cache':false,
            'success':function(html){
            //$(".notice-board").html(html)
            }});
            $('#li_' + value).toggleClass('notice-completed');
            return false;
            }
</script>

<style type="text/css">
    /*.fc-header-left,.fc-header-title { display: none;}*/
    .appt { background: none !important; border: none !important;}
</style>