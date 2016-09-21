<?php
$base_url = Yii::app()->theme->baseUrl;
$this->menu = array(
    array('label' => Yii::t('static', 'Previous Page'), 'url' => 'javascript:history.go(-1)', 'class' => 'btn-1'),
);
$this->title = Yii::t('static', 'Book FCC Appointment');
?>

<div class="form-type">
    <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'booking-form',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableAjaxValidation' => false,
        // 'action'               => Yii::app()->createAbsoluteUrl($this->route, array('step' => 2)),
    )); ?>
    <div class="form-group pull-right">
        <input type="button" value="Next page" class="btn btn-primary"/>
    </div>
    <div class="welcome">
        <h3>Hello <?php echo Yii::app()->params['doctorName']; ?></h3>
        <p>Welcome to Fetal Care Centre, National University Hospital Instant Appointment Booking Platform<br/>
            Please make your selection below and click "Next page"</p>
    </div>
    <div class="clearfix"></div>

    <div class="col-md-3 row">
        <div class="form-group">
            <label>Select doctor</label>
            <?php echo $form->dropDownList($mBooking, 'doctor_selected', CHtml::listData($doctorList, 'uuid', 'fullName'), array('empty' => 'No Doctor Preference', 'class' => 'form-control', 'style' => 'width:85%;')) ?>
            <div class="clearfix"></div>
        </div>
    </div>
    <div class="col-md-9 row">
        <?php
        $this->renderPartial('_table_template', array(
            'doctorTime' => $doctorTime,
        ));
        ?>
        <div class="clearfix"></div>
        <div class="col-md-12">
            <p>FCC Doctors’ Time Table<br/>
                Note: Due to exigencies of services, the doctor in charge may change without prior notice</p>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="col-md-3">
        <div class="form-group">
            <label>Select pregnancy type</label>
            <?php echo $form->dropDownList($mBooking, 'pregnancy_type', FccBooking::$pregnancyType, array('class' => 'form-control', 'style' => 'width:240px;')) ?>
            <div class="clearfix"></div>
        </div>
    </div>
    <div class="clearfix"></div>
    <div style="width: 280px; float: left; margin-left: 15px;">
        <div class="form-group">

            <?php echo $form->dropDownList($mBooking, 'ultrasound_type', FccBooking::$ultrasoundType, array('empty' => 'Select ultrasound type', 'class' => 'form-control', 'style' => 'width:240px;')) ?>
            <div class="clearfix"></div>
        </div>
    </div>
    <div style="width: 60px; float: left; padding-top: 5px;">
        <p>OR</p>
    </div>
    <div style="width: 280px; float: left;">
        <div class="form-group">

            <?php echo $form->dropDownList($mBooking, 'procedure', FccBooking::$procedureType, array('empty' => 'Select Procedure', 'class' => 'form-control', 'style' => 'width:240px;')) ?>
            <div class="clearfix"></div>
        </div>
    </div>
    <div class="clearfix"></div>
    <div style="width: 280px; float: left; margin-left: 15px;">
        <div class="form-group">
            <?php echo $form->labelEx($mBooking, 'lmp'); ?>
            <?php echo $form->textField($mBooking, 'lmp', array('class' => 'form-control lmpdatepicker', 'style' => 'width:240px;')); ?>
            <div class="clearfix"></div>
        </div>
    </div>
    <div style="width: 60px; float: left;">
        <p></p>
    </div>
    <div class="eddgrp" style="width: 280px; float: left;">
        <div class="form-group">
            <?php echo $form->labelEx($mBooking, 'edd'); ?>
            <?php echo $form->textField($mBooking, 'edd', array('class' => 'form-control edddatepicker', 'style' => 'width:240px;')); ?>
            <div class="clearfix"></div>
        </div>
    </div>
    <div class="clearfix"></div>
    <?php $this->endWidget(); ?>
</div>
<div class="clearfix"></div>

<input type="hidden" id="ajaxCalculateEDD"
       value="<?php echo Yii::app()->createAbsoluteUrl('/appointment/pregnancy/getLmpEdd/'); ?>"/>

<?php
Yii::app()->clientScript->registerCssFile($base_url . '/css/jquery-ui.css');
Yii::app()->clientScript->registerCssFile($base_url . '/js/fullcalendar/fullcalendar.css');
// Yii::app()->clientScript->registerCssFile($base_url . '/js/fullcalendar/fullcalendar.print.css','print');
Yii::app()->clientScript->registerScriptFile($base_url . '/js/jquery-ui.custom.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile($base_url . '/js/moment.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile($base_url . '/js/fullcalendar/fullcalendar.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile($base_url . '/js/jquery.multiselect.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile($base_url . '/js/jquery.validate.min.js', CClientScript::POS_END);


?>

<script type="text/javascript">
    $(function () {
        $(".btn-primary").on("click", function () {
            $scan = $('#FccBooking_ultrasound_type').val();
            $procedure = $('#FccBooking_procedure').val();
            if ($scan != '' || $procedure != '')
                $("#booking-form").submit();
            else {
                alert('Please selece Ultrasound type OR Procedure!');
            }
        });


        $('#FccBooking_ultrasound_type').change(function (event) {
            $('#FccBooking_procedure').val('');
        });
        $('#FccBooking_procedure').change(function (event) {
            $('#FccBooking_ultrasound_type').val('');
        });
        if ($('#FccBooking_procedure').val() != '')
            $('#FccBooking_ultrasound_type').val('');
        if ($('#FccBooking_ultrasound_type').val() != '')
            $('#FccBooking_procedure').val('');

        $(".lmpdatepicker").on('blur',function () {
            if ($(this).val() == '') $('.edddatepicker').val('');
            return;
            url = $('#ajaxCalculateEDD').val();
            date = $(this).val();
            $.post(url, {date: date, getType: 'edd'}).done(function (data) {
                $('#FccBooking_edd').val(data);
            });
        });

        if ($('#FccBooking_pregnancy_type').val() == 0) {
            $(".eddgrp").hide();
        }
        else {
            $(".eddgrp").show();
        }

        $("#FccBooking_pregnancy_type").change(function(){
           if ($(this).val() == 0) {
               $(".eddgrp").hide();
           }
            else {
               $(".eddgrp").show();
           }
        });

        $(".lmpdatepicker").datepicker({
            showOtherMonths: true,
            selectOtherMonths: true,
            changeMonth: true,
            dateFormat: "dd-mm-yy",
            changeYear: true,
            onSelect: function (dateText) {
                url = $('#ajaxCalculateEDD').val();
                date = $(this).val();
                $.post(url, {date: date, getType: 'edd'})
                    .done(function (data) {
                        $('#FccBooking_edd').val(data);
                    });
            }
        });
        $(".edddatepicker").datepicker({
            showOtherMonths: true,
            selectOtherMonths: true,
            changeMonth: true,
            dateFormat: "dd-mm-yy",
            changeYear: true,
            onSelect: function (dateText) {
                url = $('#ajaxCalculateEDD').val();
                date = $(this).val();
                $.post(url, {date: date, getType: 'lmp'})
                    .done(function (data) {
                        $('#FccBooking_lmp').val(data);
                    });
            }
        });

    })
</script>

<style>
    .eddgrp { display: none;}
</style>