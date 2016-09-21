<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title"><span class="<?php echo $model->isNewRecord ? $this->iconCreate : $this->iconEdit; ?>"></span> <?php echo $model->isNewRecord ? 'Create' : 'Update'; ?> <?php echo $this->singleTitle ?></h3>
	</div>
	<div class="panel-body">
		<div class="form">
		<?php $form=$this->beginWidget('CActiveForm', array(
			'id' => 'dispense-form',
			'enableAjaxValidation'=>false,
			'htmlOptions' => array('class' => 'form-horizontal', 'role' => 'form', 'enctype' => 'multipart/form-data'),
		)); ?>
			<div class='form-group form-group-sm'>
<?php echo $form->labelEx($model,'patient_id', array('class' => 'col-sm-1 control-label')); ?>
	<div class="col-sm-3">
		<?php echo $form->textField($model,'patient_id', array('class' => 'form-control', 'maxlength' => 255)); ?>
	<?php echo $form->error($model,'patient_id'); ?>
	</div>
</div>
    
			<div class='form-group form-group-sm'>
<?php echo $form->labelEx($model,'discount', array('class' => 'col-sm-1 control-label')); ?>
	<div class="col-sm-3">
		<?php echo $form->textField($model,'discount', array('class' => 'form-control', 'maxlength' => 255)); ?>
	<?php echo $form->error($model,'discount'); ?>
	</div>
</div>
    
			<div class='form-group form-group-sm'>
<?php echo $form->labelEx($model,'subtotal', array('class' => 'col-sm-1 control-label')); ?>
	<div class="col-sm-3">
		<?php echo $form->textField($model,'subtotal', array('class' => 'form-control', 'maxlength' => 255)); ?>
	<?php echo $form->error($model,'subtotal'); ?>
	</div>
</div>
    
			<div class='form-group form-group-sm'>
<?php echo $form->labelEx($model,'total_with_gst', array('class' => 'col-sm-1 control-label')); ?>
	<div class="col-sm-3">
		<?php echo $form->textField($model,'total_with_gst', array('class' => 'form-control', 'maxlength' => 255)); ?>
	<?php echo $form->error($model,'total_with_gst'); ?>
	</div>
</div>
    
			<div class='form-group form-group-sm'>
<?php echo $form->labelEx($model,'amount_after_discount', array('class' => 'col-sm-1 control-label')); ?>
	<div class="col-sm-3">
		<?php echo $form->textField($model,'amount_after_discount', array('class' => 'form-control', 'maxlength' => 255)); ?>
	<?php echo $form->error($model,'amount_after_discount'); ?>
	</div>
</div>
    
			<div class='form-group form-group-sm'>
<?php echo $form->labelEx($model,'add_gst', array('class' => 'col-sm-1 control-label')); ?>
	<div class="col-sm-3">
		<?php echo $form->textField($model,'add_gst', array('class' => 'form-control', 'maxlength' => 255)); ?>
	<?php echo $form->error($model,'add_gst'); ?>
	</div>
</div>
    
			<div class='form-group form-group-sm'>
<?php echo $form->labelEx($model,'queue_id', array('class' => 'col-sm-1 control-label')); ?>
	<div class="col-sm-3">
		<?php echo $form->textField($model,'queue_id', array('class' => 'form-control', 'maxlength' => 255)); ?>
	<?php echo $form->error($model,'queue_id'); ?>
	</div>
</div>
    
			<div class='form-group form-group-sm'>
<?php echo $form->labelEx($model,'invoice_no', array('class' => 'col-sm-1 control-label')); ?>
	<div class="col-sm-3">
		<?php echo $form->textField($model,'invoice_no', array('class' => 'form-control', 'maxlength' => 255)); ?>
	<?php echo $form->error($model,'invoice_no'); ?>
	</div>
</div>
    
			<div class='form-group form-group-sm'>
<?php echo $form->labelEx($model,'amount_due', array('class' => 'col-sm-1 control-label')); ?>
	<div class="col-sm-3">
		<?php echo $form->textField($model,'amount_due', array('class' => 'form-control', 'maxlength' => 255)); ?>
	<?php echo $form->error($model,'amount_due'); ?>
	</div>
</div>
    
			<div class='form-group form-group-sm'>
<?php echo $form->labelEx($model,'total_receive', array('class' => 'col-sm-1 control-label')); ?>
	<div class="col-sm-3">
		<?php echo $form->textField($model,'total_receive', array('class' => 'form-control', 'maxlength' => 255)); ?>
	<?php echo $form->error($model,'total_receive'); ?>
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