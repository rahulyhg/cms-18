<?php
/* @var $this DoctorController */
/* @var $model Doctor */

Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/form.css');

$this->menu=array(
    array('label'=>Yii::t('static', '<img src="'.Yii::app()->baseUrl . '/css/images/icon-print-sm.png'.'"" /> Print Appointment'), 'url'=>array('/appointment/print_appointment'),'class' => 'btn-1'),
    array('label'=>Yii::t('static', 'Add Appointment'), 'url'=>array('/appointment/create'), 'class' => 'btn-1'),
);

$this->title = Yii::t('static', 'Export Appointment');
?>


<div class="form-type">

    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'export-appointment-form',
        'enableAjaxValidation'=>true,
        'action'=>Yii::app()->createUrl($this->route),
    )); ?>
    <div class="row">
        <?php echo $form->errorSummary($model, Yii::t('validation','Please fix the following input errors:')); ?>
        <div class="col-md-5 col-sm-12 row">
            <div class="form-group">
                <?php echo $form->labelEx($model,'doctor_id'); ?>
                <?php echo $form->dropDownList($model,'doctor_id',CHtml::listData($doctorList, 'id', 'fullName'),array('class'=>'form-control', 'style' => 'width:56%')) ?>
            </div>
            <div class="form-group">
                <?php echo $form->labelEx($model,'startDate'); ?>
                <div class="col-sm-7 col">
                    <?php echo $form->textField($model,'startDate',array('class'=>'form-control datepicker')); ?>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="form-group">
                <?php echo $form->labelEx($model,'endDate'); ?>
                <div class="col-sm-7 col">
                    <?php echo $form->textField($model,'endDate',array('class'=>'form-control datepicker')); ?>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="form-group">
                <label>Time</label>
                <div class="col-sm-7 col">
                    <?php echo CHtml::dropDownList('ExportAppointment[time]', $model->time, HDateTime::model()->getAMPM(),array('empty' => 'All Day', 'class'=>'form-control')); ?>
                </div>
                <div class="clearfix"></div>
            </div>
            
            
            <div class="form-group">
                <label>Select Columns:</label>
                <div class="col-sm-5 col">
                    <div class="">                       
                        <p><input type="checkbox" name="export-column[]" value="DoctorName" <?php echo $this->exportColumns['DoctorName']; ?>/> Doctor Name</p>
                    </div>
                    <div class="">
                        <p><input type="checkbox" name="export-column[]" value="name" <?php echo $this->exportColumns['name']; ?> /> Patient</p>
                    </div>
                    <div class="">
                        <p><input type="checkbox" name="export-column[]" value="nric" <?php echo $this->exportColumns['nric']; ?> /> Patient's ID</p>
                    </div>
                    <div class="">
                        <p><input type="checkbox" name="export-column[]" value="contact" <?php echo $this->exportColumns['contact']; ?>/> Contact</p>
                    </div>
                </div>
                <div class="col-sm-5 col">
                    <div class="" style="display:none;">
                        <p><input type="checkbox" name="export-column[]" value="Date" <?php echo $this->exportColumns['Date']; ?> class="date-time"/> Date</p>
                    </div>
                    <div class="">
                        <p><input type="checkbox" name="export-column[]" value="Time" <?php echo $this->exportColumns['Time']; ?> class="date-time" /> Time</p>
                    </div>
                    <div class="">
                        <p><input type="checkbox" name="export-column[]" value="VisitReason" <?php echo $this->exportColumns['VisitReason']; ?> /> Visit Reason</p>
                    </div>
        <!--             <div class="">
                        <p><input type="checkbox" name="export-column[]" value="VisitReasonText" /> Visit Reason Text</p>
                    </div> -->
                     <!-- <div class="">
                        <p><input type="checkbox" name="export-column[]" value="Clinic" checked="checked" /> Clinic</p>
                    </div> -->
                    <div class="">
                        <p><input type="checkbox" name="export-column[]" value="comments" <?php echo $this->exportColumns['comments']; ?>/> Comments</p>
                    </div>
                     <div class="">
                        <p><input type="checkbox" name="export-column[]" value="turnup" <?php echo $this->exportColumns['turnup']; ?>/> Turn up</p>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
             <div class="form-group">
                <div class="col-sm-7 col">
                    <input type="hidden" value="excel" name="exportType" id="exportType" />
                    <?php echo CHtml::button(Yii::t('static','View'), array('class'=>'btn btn-primary btnview')); ?>                    
                </div>
            </div>
        </div>
<?php if (isset($_POST['ExportAppointment']['doctor_id'])) : ?>
        <div class="col-md-7 col-sm-12 ">
            <div class="form-group">
                Select type: <select class="print-type" id="print-type" name="print-type">
                    <option value="all">All</option>
                    <option value="seen">Seen</option>
                </select>
            <?php echo CHtml::button(Yii::t('static','Export Excel'), array('class'=>'btn btn-primary btnexport excel')); ?>
            <?php echo CHtml::button(Yii::t('static','Export Word'), array('class'=>'btn btn-primary btnexport word')); ?>
            </div>   
            <?php $this->renderPartial('view_list',array(
                'model'=>$modelPreview,
                'doctor'=>$doctorPreview,
                'startDate'=>$startDate,'endDate'=>$endDate,
                'columns'=>$columns,
            ));
            ?>
        </div>   
<?php endif; ?>
        

        <div class="clearfix"></div>
    </div>
    <?php $this->endWidget(); ?>
    <button class="open-popup" style="display:none;"></button>
</div><!-- form -->




<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/jquery-ui-1.10.3.custom.min.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/jquery-ui.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/jquery.ui.timepicker.css');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery-ui.custom.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery-ui-1.10.3.custom.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.ui.timepicker.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.popupWindow.js', CClientScript::POS_END);
?>

<script type="text/javascript">
$(function() {
    var turn_up = '';
    $( ".datepicker" ).datepicker({
        showOtherMonths: true,
        selectOtherMonths: true,
        changeMonth: true,
        dateFormat: "dd-mm-yy",
        changeYear: true,
    });

    $('.date-time').change(function(event) {
        if ($(this).is(':checked'))
            $('.date-time').attr('checked','checked');
        else $('.date-time').removeAttr('checked');
    });

    $('.btn-print').click(function(event) {
        doctor_id = $('#Appointment_doctor_id').val();
        start = $("#Appointment_startDate").datepicker().val();
        end = $("#Appointment_endDate").datepicker().val();
        type = $('#print-type').val();
        turn_up = '';
        $(".turn_up:checked").each(function()
        {
           turn_up += $(this).val()+'-';
        });
        turn_up = turn_up.substring(turn_up,turn_up.length-1)
        openPrintPopUp(doctor_id,start,end,type,turn_up);
        $('.open-popup').trigger('click');
    });

    // $(".turn_up").on('click', function() {
    //     if($(this).is(':checked'))

    // });

    // $('#print-type').change(function(event) {

    // });

    $('.btnview').click(function() {
        var action = $('#export-appointment-form').attr('action');
        action = action.replace('exportAppointment','appointment');
        $('#export-appointment-form').attr('action', action);
        $('#export-appointment-form').submit();
    });

    $('.btnexport').click(function() {
        if($(this).hasClass('excel'))
            $('#exportType').val('excel');
        else $('#exportType').val('word');
        
        var action = $('#export-appointment-form').attr('action');
        action = action.replace('appointment', 'exportAppointment');
        $('#export-appointment-form').attr('action', action);
        
        $('#export-appointment-form').submit();

    });

});

function openPrintPopUp(doctor_id,start,end,type,turn_up) {
    $('.open-popup').popupWindow({
        windowURL:"<?php echo Yii::app()->createAbsoluteUrl('/appointment/print_appointment_result/'); ?>" + "?doctor_id=" + doctor_id + "&start=" + start + "&end=" + end + "&type=" + type + "&turnup=" + turn_up,
        windowName:'swip',
       width:800,
     });
}
</script>