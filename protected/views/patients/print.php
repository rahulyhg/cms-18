<?php
/* @var $this DoctorController */
/* @var $model Doctor */

Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/form.css');

$this->menu = array(
    array('label' => Yii::t('static', '<img src="' . Yii::app()->baseUrl . '/css/images/icon-print-sm.png' . '"" /> Print Patients'), 'url' => array('/appointment/print_appointment'), 'class' => 'btn-1'),
);
?>


<div class="form-type">
    <div class="box-1">
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'print-appointment-form',
                    'enableAjaxValidation' => true,
                ));
        ?>
        <div class="title-box clearfix">
            <h2 class="title"><?php echo Yii::t('static', 'Print Patients') ?></h2>

        </div>
        <div class="box-body">
            <div class="row">
                <?php //echo $form->errorSummary($model, Yii::t('validation', 'Please fix the following input errors:')); ?>
                <div class="col-md-4 col-sm-12 row">
                    <div class="form-group">
                        <label class="pull-left col-sm-2">Created By</label>
                        <div class="col-sm-7 col">
                            <?php echo $form->dropDownList($model, 'doctor_id', CHtml::listData($doctorList, 'id', 'fullName'), array('class' => 'form-control',)) ?>
                        </div>
                        <?php echo $form->error($model, 'doctor_id'); ?>
                        <div class="clearfix"></div>
                    </div>

                    <div class="form-group">
                        <?php echo $form->labelEx($model, 'startDate', array('class' => 'pull-left col-sm-2',)); ?>
                        <div class="col-sm-7 col">
                            <?php echo $form->textField($model, 'startDate', array('class' => 'form-control datepicker')); ?>
                            <?php echo $form->error($model, 'startDate'); ?>
                        </div>
                    
                        <div class="clearfix"></div>
                    </div>
                    <div class="form-group">
                        <?php echo $form->labelEx($model, 'endDate', array('class' => 'pull-left col-sm-2',)); ?>
                        <div class="col-sm-7 col">
                            <?php echo $form->textField($model, 'endDate', array('class' => 'form-control datepicker')); ?>
                             <?php echo $form->error($model, 'endDate'); ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    
                    <div class="form-group">
                        <label class="pull-left col-sm-2">Time</label>
                        <div class="col-sm-7 col">
                            <?php echo CHtml::dropDownList('Appointment[time]', $model->time, HDateTime::model()->getAMPM(), array('empty' => 'All Day', 'class' => 'form-control')); ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-7 col">
                            <?php echo CHtml::submitButton(Yii::t('static', 'View'), array('class' => 'btn btn-primary')); ?>
                        </div>
                    </div>
                </div>

                <?php if (isset($_POST['Appointment']['doctor_id'])) : ?>
                    <div class="form-group print-group">
                        <?php echo CHtml::button(Yii::t('static', 'Print'), array('class' => 'btn btn-primary btn-print')); ?>
                    </div>
                    
                    <?php
                    $this->renderPartial('print_list', array(
                        'model' => $modelPreview,
                        'doctor' => $doctorPreview,
                        'startDate' => $startDate, 'endDate' => $endDate));
                    ?>
                <?php endif; ?>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
    <?php $this->endWidget(); ?>
    <button class="open-popup" style="display:none;"></button>
</div><!-- form -->




<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl . '/css/jquery-ui-1.10.3.custom.min.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl . '/css/jquery-ui.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl . '/css/jquery.ui.timepicker.css');
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/jquery-ui.custom.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/jquery-ui-1.10.3.custom.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/jquery.ui.timepicker.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/jquery.popupWindow.js', CClientScript::POS_END);
?>

<script type="text/javascript">
    $(function () {
        var turn_up = '';
        $(".datepicker").datepicker({
            showOtherMonths: true,
            selectOtherMonths: true,
            changeMonth: true,
            dateFormat: "dd-mm-yy",
            changeYear: true,
        });

        $('.btn-print').click(function (event) {
            doctor_id = $('#Appointment_doctor_id').val();
            start = $("#Appointment_startDate").datepicker().val();
            end = $("#Appointment_endDate").datepicker().val();
            time = $("#Appointment_time").val();
            type = $('#print-type').val();
            turn_up = '';
            $(".turn_up:checked").each(function ()
            {
                turn_up += $(this).val() + '-';
            });
            turn_up = turn_up.substring(turn_up, turn_up.length - 1);

            patients = '';
            $(".select-on-check:checked").each(function ()
            {
                patients += $(this).val() + '-';
            });
            patients = patients.substring(patients, patients.length - 1);

            openPrintPopUp(doctor_id, start, end, time, type, turn_up, patients);
            $('.open-popup').trigger('click');
        });
    });

    function openPrintPopUp(doctor_id, start, end, time, type, turn_up, patients) {
        $('.open-popup').popupWindow({
            windowURL: "<?php echo Yii::app()->createAbsoluteUrl('/patients/print_appointment_result/'); ?>" + "?doctor_id=" + doctor_id + "&start=" + start + "&end=" + end + "&type=" + type + "&turnup=" + turn_up + '&time=' + time + '&patients=' + patients,
            windowName: 'swip',
            width: 1000,
            height: 600,
            scrollbars: 1
            
        });
        
        window.document.title = '';
        
    }
</script>

<script>window.onload = self.focus;</script>