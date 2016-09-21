
<div class="form">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'queue-form',
        'enableAjaxValidation' => false,
        'htmlOptions' => array('class' => 'form-horizontal', 'role' => 'form', 'enctype' => 'multipart/form-data'),
    ));
    ?>
    <div class="row">
        <div class="col-sm-4">
            <div class='form-group form-group-sm'>
                <?php echo $form->labelEx($model, 'time_in', array('class' => 'col-sm-3 control-label')); ?>
                <div class="col-sm-6">
                    <?php echo $form->textField($model, 'time_in', array('class' => 'form-control ver_timepicker', 'readonly' => 'true', 'maxlength' => 255)); ?>
                    <span class="add-on"><i class="icon-time"></i></span>
                    <?php echo $form->error($model, 'time_in'); ?>
                </div>
            </div>

            <div class='form-group form-group-sm'>
                <?php echo $form->labelEx($model, 'time_out', array('class' => 'col-sm-3 control-label')); ?>
                <div class="col-sm-6">
                    <?php echo $form->textField($model, 'time_out', array('class' => 'form-control ver_timepicker', 'readonly' => 'true', 'maxlength' => 255)); ?>
                    <?php echo $form->error($model, 'time_out'); ?>
                </div>
            </div>

            <div class='form-group form-group-sm'>
                <?php echo $form->labelEx($model, 'seen', array('class' => 'col-sm-3 control-label')); ?>
                <div class="col-sm-6">
                    <?php echo $form->dropDownList($model, 'seen', $model->optionYesNo, array('class' => 'form-control')); ?>
                    <?php echo $form->error($model, 'seen'); ?>
                </div>
            </div>

            <div class='form-group form-group-sm'>
                <?php echo $form->labelEx($model, 'dispense', array('class' => 'col-sm-3 control-label')); ?>
                <div class="col-sm-6">
                    <?php echo $form->dropDownList($model, 'dispense', $model->optionYesNo, array('class' => 'form-control', 'maxlength' => 255)); ?>
                    <?php echo $form->error($model, 'dispense'); ?>
                </div>
            </div>

            <div class='form-group form-group-sm'>
                <?php echo $form->labelEx($model, 'bill', array('class' => 'col-sm-3 control-label')); ?>
                <div class="col-sm-6">
                    <?php echo $form->textField($model, 'bill', array('class' => 'form-control', 'maxlength' => 255)); ?>
                    <?php echo $form->error($model, 'bill'); ?>
                </div>
            </div>

            <div class='form-group form-group-sm'>
                <?php echo $form->labelEx($model, 'paid', array('class' => 'col-sm-3 control-label')); ?>
                <div class="col-sm-6">
                    <?php echo $form->textField($model, 'paid', array('class' => 'form-control', 'maxlength' => 255)); ?>
                    <?php echo $form->error($model, 'paid'); ?>
                </div>
            </div>
            <div class='form-group form-group-sm'>
                <?php echo $form->labelEx($model, 'doctor_id', array('class' => 'col-sm-3 control-label')); ?>
                <div class="col-sm-6">
                    <?php echo $form->dropDownList($model, 'doctor_id', Doctor::model()->getDoctorDropdown(), array('empty' => '--Select doctor--','class' => 'form-control', 'maxlength' => 255)); ?>
                    <?php echo $form->error($model, 'doctor_id'); ?>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class='form-group form-group-sm'>
                <?php echo $form->labelEx($model, 'contact_insurance', array('class' => 'col-sm-3 control-label')); ?>
                <div class="col-sm-6">
                    <?php echo $form->textField($model, 'contact_insurance', array('class' => 'form-control', 'maxlength' => 255)); ?>
                    <?php echo $form->error($model, 'contact_insurance'); ?>
                </div>
            </div>

            <div class='form-group form-group-sm'>
                <?php echo $form->labelEx($model, 'height', array('class' => 'col-sm-3 control-label')); ?>
                <div class="col-sm-6">
                    <?php echo $form->textField($model, 'height', array('class' => 'form-control', 'maxlength' => 255)); ?>
                    <?php echo $form->error($model, 'height'); ?>
                </div>
            </div>

            <div class='form-group form-group-sm'>
                <?php echo $form->labelEx($model, 'weight', array('class' => 'col-sm-3 control-label')); ?>
                <div class="col-sm-6">
                    <?php echo $form->textField($model, 'weight', array('class' => 'form-control', 'maxlength' => 255)); ?>
                    <?php echo $form->error($model, 'weight'); ?>
                </div>
            </div>

            <div class='form-group form-group-sm'>
                <?php echo $form->labelEx($model, 'comments', array('class' => 'col-sm-3 control-label')); ?>
                <div class="col-sm-6">
                    <?php echo $form->textArea($model, 'comments', array('class' => 'my-editor-full', 'cols' => 63, 'rows' => 5)); ?>
                    <?php echo $form->error($model, 'comments'); ?>
                </div>
            </div>

            <div class='form-group form-group-sm'>
                <?php echo $form->labelEx($model, 'status', array('class' => 'col-sm-3 control-label')); ?>
                <div class="col-sm-6">
                    <?php echo $form->dropDownList($model, 'status', $model->optionActive, array('class' => 'form-control')); ?>
                    <?php echo $form->error($model, 'status'); ?>
                </div>
            </div>

            
        </div>
    </div>
    
    <?php if ($model->isNewRecord):
        
        $model->patient_id = $_GET['patientId'];
        ?>
        <?php echo $form->hiddenField($model, 'patient_id', array('class' => 'form-control', 'maxlength' => 255)); ?>
    <?php else:?>
        <?php echo $form->hiddenField($model, 'patient_id', array('class' => 'form-control', 'maxlength' => 255)); ?>
    <?php endif;?>
    <div class="clr"></div>
<!--    <div class="well">
    <?php echo CHtml::htmlButton($model->isNewRecord ? $this->iconCreate . ' Create' : $this->iconSave . ' Save', array('class' => 'btn btn-primary', 'type' => 'submit')); ?> &nbsp;  
    <?php echo CHtml::htmlButton($this->iconCancel . ' Cancel', array('class' => 'btn btn-default', 'onclick' => 'javascript: location.href=\'' . $this->baseControllerIndexUrl() . '\'')); ?>
    </div>-->
<?php $this->endWidget(); ?>
</div>
