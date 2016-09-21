<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title"><span class="<?php echo $model->isNewRecord ? $this->iconCreate : $this->iconEdit; ?>"></span> <?php echo $model->isNewRecord ? 'Create' : 'Update'; ?> <?php echo $this->singleTitle ?></h3>
	</div>
	<div class="panel-body">
		<div class="form">
		<?php $form=$this->beginWidget('CActiveForm', array(
			'id' => 'queue-form',
			'enableAjaxValidation'=>false,
			'htmlOptions' => array('class' => 'form-horizontal', 'role' => 'form', 'enctype' => 'multipart/form-data'),
		)); ?>
			<div class='form-group form-group-sm'>
                <?php echo $form->labelEx($model,'time_in', array('class' => 'col-sm-1 control-label')); ?>
                <div class="col-sm-3">
                    <?php echo $form->textField($model,'time_in', array('readonly' => 'true', 'class' => 'form-control ver_timepicker', 'maxlength' => 255)); ?>
                <?php echo $form->error($model,'time_in'); ?>
                </div>
            </div>
    
			<div class='form-group form-group-sm'>
                <?php echo $form->labelEx($model,'time_out', array('class' => 'col-sm-1 control-label')); ?>
                <div class="col-sm-3">
                    <?php echo $form->textField($model,'time_out', array('readonly' => 'true', 'class' => 'form-control ver_timepicker', 'maxlength' => 255)); ?>
                <?php echo $form->error($model,'time_out'); ?>
                </div>
            </div>
    
			<div class='form-group form-group-sm'>
                <?php echo $form->labelEx($model,'patient_name', array('class' => 'col-sm-1 control-label')); ?>
                <div class="col-sm-3">
                    <?php echo $form->textField($model,'patient_name', array('class' => 'form-control', 'maxlength' => 255)); ?>
                <?php echo $form->error($model,'patient_name'); ?>
                </div>
            </div>
    
			<div class='form-group form-group-sm'>
                <?php echo $form->labelEx($model,'seen', array('class' => 'col-sm-1 control-label')); ?>
                <div class="col-sm-3">
                    <?php echo $form->dropDownList($model, 'seen', $model->optionYesNo, array('empty' => '--Select--', 'class' => 'form-control')); ?>
                    <?php echo $form->error($model,'seen'); ?>
                </div>
            </div>
    
			<div class='form-group form-group-sm'>
                <?php echo $form->labelEx($model,'dispense', array('class' => 'col-sm-1 control-label')); ?>
                <div class="col-sm-3">
                    <?php echo $form->dropDownList($model, 'dispense', $model->optionYesNo, array('empty' => '--Select--', 'class' => 'form-control')); ?>
                    <?php echo $form->error($model,'dispense'); ?>
                </div>
            </div>
    
			<div class='form-group form-group-sm'>
                <?php echo $form->labelEx($model,'bill', array('class' => 'col-sm-1 control-label')); ?>
                <div class="col-sm-3">
                    <?php echo $form->textField($model,'bill', array('class' => 'form-control', 'maxlength' => 255)); ?>
                <?php echo $form->error($model,'bill'); ?>
                </div>
            </div>
    
			<div class='form-group form-group-sm'>
                <?php echo $form->labelEx($model,'paid', array('class' => 'col-sm-1 control-label')); ?>
                <div class="col-sm-3">
                    <?php echo $form->textField($model,'paid', array('class' => 'form-control', 'maxlength' => 255)); ?>
                <?php echo $form->error($model,'paid'); ?>
                </div>
            </div>
    
			
    
			<div class='form-group form-group-sm'>
                <?php echo $form->labelEx($model,'comments', array('class' => 'col-sm-1 control-label')); ?>
                <div class="col-sm-3">
                <?php echo $form->textArea($model,'comments', array('cols' => 63, 'rows' => 5)); ?>
                <?php echo $form->error($model,'comments'); ?>
                </div>
            </div>
    
			
			<div class='form-group form-group-sm'>
                <?php echo $form->labelEx($model,'doctor_id', array('class' => 'col-sm-1 control-label')); ?>
                <div class="col-sm-3">
                    <?php 
                    $doctorList = CHtml::listData(Users::model()->getAllMember(), 'id', 'full_name');
                    echo $form->dropDownList($model, 'doctor_id', $doctorList, array('empty' => '--Select--', 'class' => 'form-control')); ?>
                    <?php echo $form->error($model,'doctor_id'); ?>
                </div>
            </div>
    
			
    
			
    
			<div class='form-group form-group-sm'>
                <?php echo $form->labelEx($model,'follow_up', array('class' => 'col-sm-1 control-label')); ?>
                <div class="col-sm-3">
                    <?php echo $form->textField($model,'follow_up', array('class' => 'form-control', 'maxlength' => 255)); ?>
                <?php echo $form->error($model,'follow_up'); ?>
                </div>
            </div>
    
			
			<div class="clr"></div>
			<div class="well">
				<?php echo CHtml::htmlButton($model->isNewRecord ? '<span class="' . $this->iconCreate . '"></span> Create' : '<span class="' . $this->iconSave . '"></span> Save', array('class' => 'btn btn-primary', 'type' => 'submit')); ?> &nbsp;  
				<?php echo CHtml::htmlButton('<span class="' . $this->iconCancel . '"></span> Cancel', array('class' => 'btn btn-default', 'onclick' => 'javascript: location.href=\'' . $this->baseControllerIndexUrl() . '\'')); ?>
			</div>
		<?php $this->endWidget(); ?>
		</div>
	</div>
</div>