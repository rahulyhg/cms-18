<?php
$this->breadcrumbs = array(
    Yii::t('static', 'Update Appointment'),
);

$this->menu = array(
    array('label' => Yii::t('static', 'Add Appointment'), 'url' => array('/appointments/addAppointment'), 'class' => 'btn-1'),
    array('label' => Yii::t('static', 'Delete'), 'url' => array('/appointments/delete/id/'.$model->id), 'class' => 'btn-1'),
    array('label' => Yii::t('static', 'Previous Page'), 'url' => 'javascript:history.go(-1)', 'class' => 'btn-1'),
);

$this->title = Yii::t('static', 'Update Appointment');
?>
<div class="row">
    <div class="col-md-12">
        <div class="box-1">
            <div class="title-box clearfix">
                <h2 class="title"><?php echo Yii::t('static', 'Update Appointment') ?></h2>
            </div>
            
            <div class="form-type">
            <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'appointment-form',
                    'enableAjaxValidation' => true,
                ));
            ?>
                <div class="clearfix"></div>
                <div class="row">
                    <div class="col-md-12">
                        <?php echo $form->errorSummary($model, Yii::t('validation', 'Please fix the following input errors:')); ?>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group" style="display:none;">
                            <ul class="list-2 clearfix">
                                <li class="active"><?php echo $form->radioButton($model, 'eventType', array('id' => 'appointment', 'class' => 'radio-type', 'value' => 'appt', 'uncheckValue' => null)) ?><label for="appointment"><?php echo Yii::t('static', 'Appointment') ?></label></li>
                                <li class="active"><?php echo $form->radioButton($model, 'eventType', array('id' => 'operation', 'class' => 'radio-type', 'value' => 'op', 'uncheckValue' => null)) ?><label for="operation"><?php echo Yii::t('static', 'Operation') ?></label></li>
                            </ul>
                        </div>
                        <div class="form-group">
                            <?php echo $form->labelEx($model, 'startTime'); ?>
                            <div class="clearfix"></div>
                            <div class="col-sm-7 col" style="padding-left: 0;">
                                <?php echo $form->textField($model, 'startDate', array('class' => 'form-control bookdatepicker startDate', 'readonly' => 'true')); ?>
                            </div>
                            <div class="col-sm-5 col">
                                <?php echo $form->textField($model, 'startTime_show', array('class' => 'form-control booktimepicker startTime', 'readonly' => 'true')); ?>
                                <?php //echo $form->textField($model, 'startTime', array('class' => 'form-control startTime')); ?>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="form-group">
                            <?php echo $form->labelEx($model, 'endTime'); ?>
                            <div class="clearfix"></div>
                            <div class="col-sm-7 col" style="padding-left: 0;">
                                <?php echo $form->textField($model, 'endDate', array('class' => 'form-control bookdatepicker endDate', 'readonly' => 'true')); ?>
                            </div>
                            <div class="col-sm-5 col">
                                <?php echo $form->textField($model, 'endTime_show', array('class' => 'form-control booktimepicker endTime', 'readonly' => 'true')); ?>
                                <?php //echo $form->textField($model, 'endTime', array('class' => 'form-control endTime')); ?>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="error-time">
                            <div>
                                <p class="off-msg">This is a Blackout Date!</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <?php echo $form->labelEx($model, 'patient_name'); ?>
                            <?php echo $form->textField($model, 'patient_name', array('class' => 'typeahead form-control', 'id' => 'patientfield', 'placeholder' => Yii::t('static', 'enter patient\'s name'), 'style' => 'width: 90%', 'required' => 'required')); ?>
                        </div>
                        <div class="form-group">
                            <?php echo $form->labelEx($model, 'patientId'); ?>
                            <?php echo $form->textField($model, 'patientId', array('class' => 'typeahead form-control', 'id' => 'patientfield', 'placeholder' => Yii::t('static', 'enter patient\'s ID'), 'style' => 'width: 90%')); ?>
                        </div>
                        <div class="form-group">
                            <?php echo $form->labelEx($model, 'area_code_id'); ?>
                            <?php echo $form->dropDownList($model,'area_code_id', AreaCode::getAreaCode(), array('class'=>'form-control patient-info rechedule', 'style' => 'width: 90%')); ?>
                        </div>
                        <div class="form-group">
                            <?php echo $form->labelEx($model, 'patient_mobile'); ?>
                            <?php echo $form->textField($model, 'patient_mobile', array('class' => 'typeahead form-control numeric-control', 'id' => 'patientfield', 'placeholder' => Yii::t('static', 'enter patient\'s mobile'), 'style' => 'width: 90%')); ?>
                        </div>
                        <div class="form-group">
                            <?php echo $form->labelEx($model, 'patient_email'); ?>
                            <?php echo $form->textField($model, 'patient_email', array('class' => 'typeahead form-control', 'id' => 'patientfield', 'placeholder' => Yii::t('static', 'enter patient\'s email'), 'style' => 'width: 90%')); ?>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <?php  if ($model->is_operation) { ?>
                        <div class="f-operation">
                            <div class="form-group">
                                <?php echo $form->labelEx($modelOperation, 'admission_hospital'); ?>
                                <?php echo $form->textField($modelOperation, 'admission_hospital', array('class' => 'typeahead form-control', 'id' => 'patientfield', 'placeholder' => Yii::t('static', 'enter Admission Hospital'), 'style' => 'width: 90%')); ?>
                            </div>
                            <div class="form-group">
                                <?php echo $form->labelEx($modelOperation, 'where_in_hospital'); ?>
                                <?php echo $form->textField($modelOperation, 'where_in_hospital', array('class' => 'typeahead form-control', 'id' => 'patientfield', 'placeholder' => Yii::t('static', 'enter Where In Hospital'), 'style' => 'width: 90%')); ?>
                            </div>
                            <div class="form-group">
                                <?php echo $form->labelEx($modelOperation, 'bed_type'); ?>
                                <?php echo $form->textField($modelOperation, 'bed_type', array('class' => 'typeahead form-control', 'id' => 'patientfield', 'placeholder' => Yii::t('static', 'enter Bed Type'), 'style' => 'width: 90%')); ?>
                            </div>
                            <div class="form-group">
                                <?php echo $form->labelEx($modelOperation, 'anaesthesia_type'); ?>
                                <?php echo $form->textField($modelOperation, 'anaesthesia_type', array('class' => 'typeahead form-control', 'id' => 'patientfield', 'placeholder' => Yii::t('static', 'enter Anaesthesia Type'), 'style' => 'width: 90%')); ?>
                            </div>
                            <div class="form-group">
                                <?php echo $form->labelEx($modelOperation, 'anaesthetist'); ?>
                                <?php echo $form->textField($modelOperation, 'anaesthetist', array('class' => 'typeahead form-control', 'id' => 'patientfield', 'placeholder' => Yii::t('static', 'enter Anaesthetist'), 'style' => 'width: 90%')); ?>
                            </div>
                            <div class="form-group">
                                <?php echo $form->labelEx($modelOperation, 'preparation'); ?>
                                <?php echo $form->textField($modelOperation, 'preparation', array('class' => 'typeahead form-control', 'id' => 'patientfield', 'placeholder' => Yii::t('static', 'enter Preparation'), 'style' => 'width: 90%')); ?>
                            </div>
                            <div class="form-group">
                                <?php echo $form->labelEx($modelOperation, 'surgical_assistant'); ?>
                                <?php echo $form->textField($modelOperation, 'surgical_assistant', array('class' => 'typeahead form-control', 'id' => 'patientfield', 'placeholder' => Yii::t('static', 'enter Surgical Assistant'), 'style' => 'width: 90%')); ?>
                            </div>
                            <div class="form-group">
                                <ul class="list-2 clearfix">
                                    <li><?php echo $form->radioButton($modelOperation, 'operation_type', array('id' => 'inpatient', 'value' => 'in', 'class' => 'radio-type')) ?><label for="inpatient"><?php echo Yii::t('model', 'In Patient') ?></label></li>
                                    <li><?php echo $form->radioButton($modelOperation, 'operation_type', array('id' => 'day_surgery', 'value' => 'day', 'class' => 'radio-type')) ?><label for="day_surgery"><?php echo Yii::t('model', 'Day Surgery') ?></label></li>
                                </ul>
                            </div>
                        </div>
                        <?php } ?>
                        <div class="form-group f-appointment">
                            <?php echo $form->labelEx($model, 'visit_reason'); ?>
                            <?php echo $form->dropDownList($model, 'visit_reason', Appointment::$visit_reason, array('class' => 'form-control', 'style' => 'width: 90%')); ?>
                        </div>
                        <div class="form-group visit_reason_text f-appointment" style="display:none;">
                            <?php echo $form->labelEx($model, 'visit_reason_text'); ?>
                            <?php echo $form->textField($model, 'visit_reason_text', array('class' => 'form-control', 'style' => 'width: 90%')); ?>
                        </div>
                        <div class="form-group">
                            <?php echo $form->labelEx($model, 'is_new_patient'); ?>
                            <?php echo $form->dropDownList($model, 'is_new_patient', Appointment::$is_new_patient, array('class' => 'form-control', 'style' => 'width: 90%')); ?>
                        </div>
                        <div class="form-group f-appointment">
                            <?php echo $form->labelEx($model, 'comments'); ?>
                            <?php echo $form->textArea($model, 'comments', array('class' => 'form-control', 'rows' => 5)); ?>
                        </div>
                        <div class="action-button">
                            <span class="f-appointment"><?php echo CHtml::submitButton(Yii::t('static', 'Save Appointment'), array('class' => 'btn btn-primary btn-save')); ?></span>
                            <span class="f-operation"><?php echo CHtml::submitButton(Yii::t('static', 'Save Operation'), array('class' => 'btn btn-primary btn-save')); ?></span>
                        </div>
                    </div>
                </div>
            <?php $this->endWidget(); ?>
            </div>
        </div>
    </div>
</div>


<style type="text/css">
    .f-operation { display: none;}
    .error-time { background: #DA4A38; color: #FFFFFF; padding: 10px; font-weight: bold; width: 95%; display: none;}
    #doctor-time-table table { margin: 20px 0 20px 0;}
</style>

<?php
//register javascripts Files
$clientScript = Yii::app()->clientScript;
$assets = $this->getAssets();
$base_url = Yii::app()->theme->baseUrl;
$clientScript->registerScriptFile("{$assets}/scripts/addappointment.js", CClientScript::POS_END);
$clientScript->registerCssFile($base_url . '/css/jquery-ui-1.10.3.custom.min.css');
$clientScript->registerCssFile($base_url . '/css/jquery-ui.css');
$clientScript->registerCssFile($base_url . '/css/jquery.ui.timepicker.css');
$clientScript->registerScriptFile($base_url . '/js/jquery-ui.custom.min.js', CClientScript::POS_END);
$clientScript->registerScriptFile($base_url . '/js/jquery-ui-1.10.3.custom.min.js', CClientScript::POS_END);
$clientScript->registerScriptFile($base_url . '/js/jquery.ui.timepicker.js', CClientScript::POS_END);
$clientScript->registerScriptFile($base_url . '/js/jquery.validate.min.js', CClientScript::POS_END);
?>

<input type="hidden" id="ajaxCheckBlackoutDate" value="<?php echo Yii::app()->createUrl('ajax/checkBlackoutDate/'); ?>" />
<input type="hidden" id="ajaxCheckNotWorkingDate" value="<?php echo Yii::app()->createUrl('ajax/checkNotWorkingDate/'); ?>" />
<input type="hidden" id="ajaxCheckExistTime" value="<?php echo Yii::app()->createUrl('ajax/checkExistTime/'); ?>" />
