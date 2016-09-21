<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title"><span class="<?php echo $model->isNewRecord ? $this->iconCreate : $this->iconEdit; ?>"></span> <?php echo $model->isNewRecord ? 'Create' : 'Update'; ?> <?php echo $this->singleTitle ?></h3>
	</div>
	<div class="panel-body">
		<div class="form">
		<?php $form=$this->beginWidget('CActiveForm', array(
			'id' => 'payment-amount-form',
			'enableAjaxValidation'=>false,
			'htmlOptions' => array('class' => 'form-horizontal', 'role' => 'form', 'enctype' => 'multipart/form-data'),
		)); ?>
			<div class='form-group form-group-sm'>
<?php echo $form->labelEx($model,'amount_pay', array('class' => 'col-sm-1 control-label')); ?>
	<div class="col-sm-3">
		<?php echo $form->textField($model,'amount_pay', array('class' => 'form-control', 'maxlength' => 255)); ?>
	<?php echo $form->error($model,'amount_pay'); ?>
	</div>
</div>
    
			<div class='form-group form-group-sm'>
<?php echo $form->labelEx($model,'no_receipt', array('class' => 'col-sm-1 control-label')); ?>
	<div class="col-sm-3">
		<?php echo $form->textField($model,'no_receipt', array('class' => 'form-control', 'maxlength' => 255)); ?>
	<?php echo $form->error($model,'no_receipt'); ?>
	</div>
</div>
    
			<div class='form-group form-group-sm'>
<?php echo $form->labelEx($model,'payment_id', array('class' => 'col-sm-1 control-label')); ?>
	<div class="col-sm-3">
		<?php echo $form->textField($model,'payment_id', array('class' => 'form-control', 'maxlength' => 255)); ?>
	<?php echo $form->error($model,'payment_id'); ?>
	</div>
</div>
    
			<div class='form-group form-group-sm'>
<?php echo $form->labelEx($model,'pay_type', array('class' => 'col-sm-1 control-label')); ?>
	<div class="col-sm-3">
	<?php echo $form->dropDownList($model,'pay_type', $model->optionActive, array('class' => 'form-control')); ?>
	<?php echo $form->error($model,'pay_type'); ?>
	</div>
</div>
    
			<div class='form-group form-group-sm'>
<?php echo $form->labelEx($model,'created', array('class' => 'col-sm-1 control-label')); ?>
	<div class="col-sm-3">
		<?php echo $form->textField($model,'created', array('class' => 'form-control', 'maxlength' => 255)); ?>
	<?php echo $form->error($model,'created'); ?>
	</div>
</div>
    
			<div class='form-group form-group-sm'>
<?php echo $form->labelEx($model,'update', array('class' => 'col-sm-1 control-label')); ?>
	<div class="col-sm-3">
		<?php echo $form->textField($model,'update', array('class' => 'form-control', 'maxlength' => 255)); ?>
	<?php echo $form->error($model,'update'); ?>
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