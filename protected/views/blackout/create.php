<?php
/* @var $this DoctorController */
/* @var $model Doctor */
$base_url = Yii::app()->theme->baseUrl;
Yii::app()->clientScript->registerCssFile($base_url . '/css/form.css');

$this->breadcrumbs = array(
    Yii::t('static', 'Black Out Dates'),
    Yii::t('static', 'Create'),
);

$this->menu = array(
    array('label' => Yii::t('static', 'Log out'), 'url' => array('/site/logout'), 'class' => 'btn-1'),
    array('label' => Yii::t('static', 'Cancel and Return'), 'url' => array('/blackout'),'class'=>'btn-1'),
    array('label' => Yii::t('static', 'Previous Page'), 'url' => 'javascript:history.go(-1)', 'class' => 'btn-1'),
);

$this->title = Yii::t('static', 'Create Blackout / Doctor Leave');
?>


    <div class="form-type">

        <?php $form = $this->beginWidget('CActiveForm', array(
            'id' => 'blackout-form',
            'enableAjaxValidation' => true,
        )); ?>
        <div class="clearfix"></div>
        <div class="row">
            <?php echo $form->errorSummary($model, Yii::t('validation', 'Please fix the following input errors:')); ?>

            <div class="col-md-8 col-sm-12 row">
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'type'); ?>
                    <div class="btn-group clear" data-toggle="buttons">
                        <label class="btn btn-default" id="btn-time">
                            <?php echo $form->radioButton($model,'type',array('value'=>'time','uncheckValue'=>null)) ?> <?php echo Yii::t('static','Black Out Time')?>
                        </label>
                        <label class="btn btn-default" id="btn-holiday">
                            <?php echo $form->radioButton($model,'type',array('value'=>'holiday','uncheckValue'=>null)) ?> <?php echo Yii::t('static','Public Holiday = Black Out Date')?>
                        </label>
                        <label class="btn btn-default" id="btn-leave">
                            <?php echo $form->radioButton($model,'type',array('value'=>'leave','uncheckValue'=>null)) ?> <?php echo Yii::t('static','Doctor’s Leave = Black Out Date')?>
                        </label>
                        <div class="clearfix"></div>
                        <label class="btn btn-default" id="btn-covering">
                            <?php echo $form->radioButton($model,'type',array('value'=>'covering','uncheckValue'=>null)) ?> <?php echo Yii::t('static','Doctor\'s Leave with Covering Doctor')?>
                        </label>
                        <label class="btn btn-default" id="btn-other">
                            <?php echo $form->radioButton($model,'type',array('value'=>'other','uncheckValue'=>null)) ?> <?php echo Yii::t('static','This is NOT a Black Out Date Other Events')?>
                        </label>
                    </div>
                </div>
            </div>
            <div class="col-md-5 col-sm-12 row">
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'start'); ?>
                    <div class="col-sm-7 col">
                        <?php echo $form->textField($model, 'startDate', array('class' => 'form-control datepicker startDate')); ?>
                    </div>
                    <div class="col-sm-5 col">
                        <?php echo $form->textField($model,'startTime',array('class'=>'form-control timepicker startTime')); ?>
                    </div>
                    <div class="clearfix">
                    </div>
                </div>
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'end'); ?>
                    <div class="col-sm-7 col">
                        <?php echo $form->textField($model, 'endDate', array('class' => 'form-control datepicker endDate')); ?>
                    </div>
                    <div class="col-sm-5 col">
                        <?php echo $form->textField($model,'endTime',array('class'=>'form-control timepicker endTime')); ?>
                    </div>
                    <div class="clearfix">
                    </div>
                </div>

                <div class="error-time">
                    <div>
                        <p>Cannot blackout</p>
                        <p>The date already has appointments booked</p>

                    </div>
                </div>

                <div class="form-group" id="div-doctor">
                    <?php echo $form->labelEx($model, 'doctor_id'); ?>
                    <?php echo $form->dropDownList($model, 'doctor_id', CHtml::listData($doctorList, 'id', 'fullName'), array('class' => 'form-control doctor_id', 'style' => 'width:200px')) ?>
                </div>
                <div class="form-group" id="div-covering-doctor">
                    <?php echo $form->labelEx($model, 'covering_doctor_id'); ?>
                    <?php echo $form->dropDownList($model, 'covering_doctor_id', CHtml::listData($doctorList, 'id', 'fullName'), array('class' => 'form-control', 'style' => 'width:200px')) ?>
                </div>
               <div class="form-group">
                    <?php echo $form->labelEx($model, 'comments'); ?>
                    <?php echo $form->textArea($model, 'comments', array('class' => 'form-control', 'rows' => 6)); ?>
                </div>
                <div class="clearfix"></div>
                    <div class="form-group pull-right">
                        <?php echo CHtml::submitButton(Yii::t('static', 'Create'), array('class' => 'btn btn-primary')); ?>
                    </div>
                    <div class="clearfix"></div>
            </div>
        </div>
        <?php $this->endWidget(); ?>

    </div><!-- form -->

<input type="hidden" id="updateid" value="0" />
<input type="hidden" id="ajaxBlackOutCheckExistTime" value="<?php echo Yii::app()->createUrl('ajax/blackOutCheckExistTime/'); ?>" />

<?php
$script = "$('#btn-".$model->type."').button('toggle');";

Yii::app()->clientScript->registerScript('binddata', $script);

Yii::app()->clientScript->registerCssFile($base_url . '/css/jquery-ui-1.10.3.custom.min.css');
Yii::app()->clientScript->registerCssFile($base_url . '/css/jquery-ui.css');
Yii::app()->clientScript->registerCssFile($base_url . '/css/jquery.ui.timepicker.css');
Yii::app()->clientScript->registerScriptFile($base_url . '/js/jquery-ui.custom.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile($base_url . '/js/jquery-ui-1.10.3.custom.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile($base_url . '/js/jquery.ui.timepicker.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile($base_url . '/js/blackout_create.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile($base_url . '/js/blackout_check.js', CClientScript::POS_END);
?>

<script>
$(function(){
    $(".btn-primary").attr('disabled', 'disabled');
    $(".datepicker").datepicker({
        showOtherMonths: true,
        selectOtherMonths: true,
        changeMonth: true,
        dateFormat: "DD M d, yy",
        changeYear: true,
        onSelect: function (dateText) {
            // if ($(this).hasClass('startDate')) {
            //     $(".endDate").val($(this).val());
            // }
            checkBlackOutTime();
        }
    });
    $('.timepicker').timepicker({
        hourText: "<?php echo Yii::t('static', 'Hour')?>",
        minuteText: "<?php echo Yii::t('static', 'Minute')?>",
        amPmText: ["<?php echo Yii::t('static', 'AM')?>","<?php echo Yii::t('static', 'PM')?>"],
        showNowButton: true,
        showDeselectButton: true,
        showCloseButton: true,
        showLeadingZero: true,
        onClose: function(time, inst) {
            if ($('#' + inst.id).hasClass('startTime')) {
                var d = new Date();
                d.setHours($('#' + inst.id).timepicker('getHour'));
                d.setMinutes($('#' + inst.id).timepicker('getMinute') + 15);
                $('.endTime').timepicker('setTime', d);
            }
            checkBlackOutTime();
        }
    });

});

</script>

<style>
    .btn-group > .btn:hover, .btn-group-vertical > .btn:hover, .btn-group > .btn:focus, .btn-group-vertical > .btn:focus, .btn-group > .btn:active, .btn-group-vertical > .btn:active, .btn-group > .btn.active, .btn-group-vertical > .btn.active { z-index: 1 !important;}
    .error-time { background: #DA4A38; color: #FFFFFF; padding: 10px; font-weight: bold; width: 95%; display: none;}
</style>