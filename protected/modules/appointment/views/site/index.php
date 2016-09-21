<?php
/* @var $this DefaultController */
$this->breadcrumbs = array(
    "Appointments",
);
$this->menu = array(
    // array('label' => Yii::t('static', 'Log out'), 'url' => array('/site/logout'), 'class' => 'btn-1'),
    // array('label' => Yii::t('static', '<img src="' . $base_url . '/css/images/icon-print-sm.png' . '"" /> Print Appointment'), 'url' => array('/appointment/print_appointment'), 'class' => 'btn-1'),
    array('label' => Yii::t('static', 'Add Appointment'), 'url' => array('/appointment/site/addAppointment'), 'class' => 'btn-1'),
    // array('label' => Yii::t('static', 'Export'), 'url' => 'javascript:void(0);', 'class' => 'btn-1 exportAppointment'),
    array('label' => Yii::t('static', 'Print'), 'url' => 'javascript:void(0);', 'class' => 'btn-1 printAppointment'),
    array('label' => Yii::t('static', 'Find Appointment'), 'url' => 'javascript:void(0);', 'class' => 'btn-1 findAppointment'),
    array('label' => Yii::t('static', 'Previous Page'), 'url' => 'javascript:history.go(-1)', 'class' => 'btn-1'),
);
$this->title = Yii::t('static', 'Appointments');
$searchDate = date('d/m/Y');
if ($modelSearch->startDate !== null && $modelSearch->endDate !== null) {
    if ($modelSearch->startDate == $modelSearch->endDate)
        $searchDate = date('d/m/Y', strtotime($modelSearch->startDate));
    else
        $searchDate = date('d/m/Y', strtotime($modelSearch->startDate)) . ' - ' . date('d/m/Y', strtotime($modelSearch->endDate));
}
?>

<div class="row">
    <div class="col-md-12">
        <div class="box-1">
            <div class="title-box clearfix">
                <h2 class="title"><?php echo Yii::t('static', 'Appointments') ?></h2>
                <?php echo CHtml::link(Yii::t('static', '<span class="glyphicon glyphicon-plus"></span> Add Appointment'), array('/appointment/site/addAppointment'), array('class' => 'btn-1 pull-right')); ?>
                <?php echo CHtml::link(Yii::t('static', '<span class="glyphicon glyphicon-search"></span> Find Appointment'), 'javascript:void(0);', array('class' => 'btn-1 pull-right findAppointment')); ?>
                <?php echo CHtml::link(Yii::t('static', '<span class="glyphicon glyphicon-print"></span> Print'), 'javascript:void(0);', array('class' => 'btn-1 pull-right printAppointment')); ?>
            </div>
            <div class="modal fade" id="myModal" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Find Appointment</h4>
                        </div>
                        <div class="modal-body form-type">
                            <?php
                            $form = $this->beginWidget('CActiveForm', array(
                                'id' => 'appointment-form',
                                'enableAjaxValidation' => true,
                            ));
                            ?>
                            <div class="row">
                                <div class="form-group">
                                    <div class="col-sm-3 col">
                                        <label>Patient name</label>
                                    </div>
                                    <div class="col-sm-7 col">
                                        <?php echo $form->textField($modelSearch, 'patient_name', array('class' => 'form-control')); ?>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-3 col">
                                        <?php echo $form->labelEx($modelSearch, 'patientId'); ?>
                                    </div>
                                    <div class="col-sm-7 col">
                                        <?php echo $form->textField($modelSearch, 'patientId', array('class' => 'form-control')); ?>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-3 col">
                                        <?php echo $form->labelEx($modelSearch, 'patient_mobile'); ?>
                                    </div>
                                    <div class="col-sm-7 col">
                                        <?php echo $form->textField($modelSearch, 'patient_mobile', array('class' => 'form-control')); ?>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-3 col">
                                        <?php echo $form->labelEx($modelSearch, 'patient_email'); ?>
                                    </div>
                                    <div class="col-sm-7 col">
                                        <?php echo $form->textField($modelSearch, 'patient_email', array('class' => 'form-control')); ?>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-3 col">
                                        <?php echo $form->labelEx($modelSearch, 'startDate'); ?>
                                    </div>
                                    <div class="col-sm-7 col">
                                        <?php echo $form->textField($modelSearch, 'startDate', array('class' => 'form-control datepicker startDate')); ?>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-3 col">
                                        <?php echo $form->labelEx($modelSearch, 'endDate'); ?>
                                    </div>
                                    <div class="col-sm-7 col">
                                        <?php echo $form->textField($modelSearch, 'endDate', array('class' => 'form-control datepicker endDate')); ?>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-3 col">
                                        <label>Turn up</label>
                                    </div>
                                    <div class="col-sm-7 col">
                                        <?php echo $form->checkBox($modelSearch, 'turn_up'); ?>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-3 col">
                                        <label>Time</label>
                                    </div>
                                    <div class="col-sm-7 col">
                                        <?php echo CHtml::dropDownList('Appointment[time]', $modelSearch->time, HDateTime::model()->getAMPM(), array('empty' => 'All Day', 'class' => 'form-control')); ?>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-7 col">
                                        <?php echo CHtml::submitButton(Yii::t('static', 'Find'), array('class' => 'btn btn-primary')); ?>
                                    </div>
                                </div>
                            </div>
                            <?php $this->endWidget(); ?>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-12 col print-section">
                <h4>Appointment List of Doctor <?php echo Yii::app()->params['doctorName']; ?></h4>
                <h4>Date: <?php echo $searchDate; ?></h4>
                <h4>Print Time: <?php echo date('d/m/Y h:i '); ?></h4>
                <table class="appointment-tbl">
                    <thead style="font-size:12px;">
                    <th>S/N</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Patient Name</th>
                    <th>Patient ID</th>
                    <th>Patient Email</th>
                    <th>Phone</th>
                    <th>Visit Reason</th>
                    <th>New Patient</th>
                    <th align="center">Turn Up</th>
                    <th>Comments</th>
                    <th class="noprint">Action</th>
                    </thead>
                    <tbody style="font-size:12px;">
                        <?php
                        $count = 0;
                        foreach ($model as $m) {
                            $checked = $m->turn_up == 1 ? 'checked="checked"' : '';
                            $appTime = strtotime($m->timeslot->start);
                            $currentDate = strtotime(date('Y-m-d H:i:s'));
                            ?>
                            <tr>
                                <td><?php echo ++$count; ?></td>
                                <td><?php echo date("l d F Y", strtotime($m->timeslot->start)); ?></td>
                                <td><?php echo date("h:ia", strtotime($m->timeslot->start)); ?></td>
                                <td><?php echo $m->patient_name; ?></td>
                                <td><?php echo $m->patientId; ?></td>
                                <td><?php echo $m->patient_email; ?></td>
                                <td><?php echo $m->patientContact; ?></td>
                                <?php if ($m->from_api) { ?>
                                    <td>from 65doctor</td>
                                <?php } elseif ($m->is_operation) { ?>
                                    <td>Operation</td>
                                <?php } else { ?>
                                    <td <?php echo $m->visit_reason == 1 ? "style='color:red;'" : ""; ?>> <?php
                                        echo Appointment::$visit_reason[$m->visit_reason];
                                        if ($m->visit_reason == 2)
                                            echo ': ' . $m->visit_reason_text;
                                        ?></td>
                                <?php } ?>
                                <td><?php echo $m->is_new_patient == 1 ? 'Yes' : 'No'; ?></td>
                                <td align="center">
                                    <input type="checkbox" <?php if ($appTime < $currentDate) echo 'readonly'; ?> value="<?php echo $m->id; ?>" class="turn_up" <?php echo $checked; ?> />
                                </td>
                                <td><?php echo $m->comments; ?></td>
                                <td align="center" class="noprint">
                                    <?php if (!$m->from_api) { ?>
                                        <a class="btn-sm btn-default" href="<?php echo Yii::app()->createAbsoluteUrl('appointment/site/update', array('id' => $m->id)); ?>">
                                            <i class="glyphicon glyphicon-pencil"> </i>
                                        </a>
                                        <a class="btn-sm btn-default" data-toggle="modal" data-message-id="<?php echo $m->id;?>" data-target="#myModalDelete" >
                                            <i class="glyphicon glyphicon-trash" > </i>
                                        </a>
                                    <?php } ?>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <p><i>Total: <?php echo $count; ?> patient(s)</i></p>
            </div>
            <div class="clearfix"></div>
            <input type="hidden" id="ajaxTurnUpAppointment" value="<?php echo Yii::app()->createAbsoluteUrl('appointment/ajax/turnUpAppointment/'); ?>" />
            <input type="hidden" id="exportAction" value="<?php echo Yii::app()->createAbsoluteUrl('export/exportAppointment') ?>" />
            <div class="clearfix"></div>
        </div>
    </div>
</div>

<div id="myModalDelete" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Do you want to delete this appointment?</h4>
            </div>
            <div class="modal-body">
                <div class="form-type">

                    <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'delete-appointment-form',
                        'enableAjaxValidation' => true,
                        'action'=>Yii::app()->createUrl('/appointment/site/delete'),
                    ));
                    ?>
                    <div class="row">
                        <?php //echo $form->hiddenField($model, 'id') ?>
                        <input name="Appointment[id]" type="hidden" id="deleteAppId">
                        <div class="clearfix"></div>
                        <div class="form-group">
                            <?php echo CHtml::submitButton(Yii::t('static', 'Delete'), array('class' => 'btn btn-primary')); ?>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                    <?php $this->endWidget(); ?>

                </div><!-- form -->
            </div>
           
        </div>

    </div>
</div>

<?php
//register javascripts Files
$clientScript = Yii::app()->clientScript;
$base_url = Yii::app()->theme->baseUrl;
$clientScript->registerCssFile($base_url . '/css/jquery-ui-1.10.3.custom.min.css');
$clientScript->registerCssFile($base_url . '/css/jquery-ui.css');
$clientScript->registerCssFile($base_url . '/css/jquery.ui.timepicker.css');
$clientScript->registerScriptFile($base_url . '/js/jquery-ui.custom.min.js', CClientScript::POS_END);
$clientScript->registerScriptFile($base_url . '/js/jquery-ui-1.10.3.custom.min.js', CClientScript::POS_END);
$clientScript->registerScriptFile($base_url . '/js/jquery.ui.timepicker.js', CClientScript::POS_END);
$clientScript->registerScriptFile($base_url . '/js/jquery.validate.min.js', CClientScript::POS_END);
$clientScript->registerScriptFile($base_url . '/js/jQuery.print.js', CClientScript::POS_END);
?>
<script type="text/javascript">

    $('#myModalDelete').on('shown.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var messageId = button.data('message-id');
        $('#deleteAppId').val(messageId);
        var action = $('#delete-appointment-form').attr('action');
        $('#delete-appointment-form').attr('action', action + '/id/' + messageId)
        $('#myInput').focus()
    })

    $(function () {
        $('.printAppointment').click(function (event) {
            $(".print-section").print({
                noPrintSelector: ".noprint",
                title: "Appointment List of <?php echo $doctor->salutation . ' ' . $doctor->name; ?>",
            });
        });
        $(".findAppointment").attr('data-toggle', 'modal');
        $(".findAppointment").attr('data-target', '#myModal');
        $('.findAppointment').click(function () {
            $('#appointment-form').find('input[type=text], input[type=checkbox], select').val('');
            $('#appointment-form').removeAttr('action');
        });
        $('.exportAppointment').click(function () {
            $('#appointment-form').attr('action', $('#exportAction').val());

            $('#appointment-form').submit();

        });

        $('.turn_up').click(function () {
            appointment_id = $(this).val();
            status = 0;
            url = $('#ajaxTurnUpAppointment').val();
            if ($(this).is(':checked'))
                status = 1;
            else
                status = 0;
            $.ajax({
                url: url,
                type: 'post',
                data: {appointment_id: appointment_id, status: status},
            })
                    .done(function () {
                        if (status == 1)
                        {
                            location.href = "<?php echo Yii::app()->createAbsoluteUrl('patients/create?appointment_id='); ?>" + appointment_id;
                        }
                    })
        });

        $(".datepicker").datepicker({
            showOtherMonths: true,
            selectOtherMonths: true,
            changeMonth: true,
            dateFormat: "dd-mm-yy",
            changeYear: true,
            onSelect: function (dateText) {
                if ($(this).hasClass('startDate')) {
                    if ($(".endDate").val() == '')
                        $(".endDate").val($(this).val());
                }
            }
        });
    })
</script>
<style type="text/css">
    .appointment-tbl { width: 100%; border-collapse: collapse;}
    .appointment-tbl, .appointment-tbl th, .appointment-tbl td {
        border: 1px solid #000;
        padding: 5px;
    }
    .print-group { float: right; margin-right: 50px;}
    .button { height: 24px !important;}
</style>