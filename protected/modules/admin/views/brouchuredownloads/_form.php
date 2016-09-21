<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title"><span class="<?php echo $model->isNewRecord ? $this->iconCreate : $this->iconEdit; ?>"></span> <?php echo $model->isNewRecord ? 'Create' : 'Update'; ?> <?php echo $this->singleTitle ?></h3>
	</div>
	<div class="panel-body">
		<div class="form">
		<?php $form=$this->beginWidget('CActiveForm', array(
			'id' => 'brouchuredownloads-form',
			'enableAjaxValidation'=>false,
			'htmlOptions' => array('class' => 'form-horizontal', 'role' => 'form', 'enctype' => 'multipart/form-data'),
		)); ?>
			<div class='form-group form-group-sm'>
<?php echo $form->labelEx($model,'name', array('class' => 'col-sm-1 control-label')); ?>
	<div class="col-sm-3">
		<?php echo $form->textField($model,'name', array('class' => 'form-control', 'maxlength' => 255)); ?>
	<?php echo $form->error($model,'name'); ?>
	</div>
</div>
    
			<div class='form-group form-group-sm'>
<?php echo $form->labelEx($model,'email', array('class' => 'col-sm-1 control-label')); ?>
	<div class="col-sm-3">
		<?php echo $form->textField($model,'email', array('class' => 'form-control', 'maxlength' => 255)); ?>
	<?php echo $form->error($model,'email'); ?>
	</div>
</div>
    
			<div class='form-group form-group-sm'>
<?php echo $form->labelEx($model,'mobile', array('class' => 'col-sm-1 control-label')); ?>
	<div class="col-sm-3">
		<?php echo $form->textField($model,'mobile', array('class' => 'form-control', 'maxlength' => 255)); ?>
	<?php echo $form->error($model,'mobile'); ?>
	</div>
</div>
    
			<div class='form-group form-group-sm'>
<?php echo $form->labelEx($model,'remark', array('class' => 'col-sm-1 control-label')); ?>
	<div class="col-sm-3">
	<?php echo $form->textArea($model,'remark', array('class' => 'my-editor-full', 'cols' => 63, 'rows' => 5)); ?>
	<?php echo $form->error($model,'remark'); ?>
	</div>
</div>
    
			<div class='form-group form-group-sm'>
<?php echo $form->labelEx($model,'latest_download_date', array('class' => 'col-sm-1 control-label')); ?>
	<div class="col-sm-3">
		<?php echo $form->textField($model,'latest_download_date', array('class' => 'my-datepicker-control form-control', 'readonly' => 'true')); ?>
	<?php echo $form->error($model,'latest_download_date'); ?>
	</div>
</div>
    
			<div class='form-group form-group-sm'>
<?php echo $form->labelEx($model,'download_web_count', array('class' => 'col-sm-1 control-label')); ?>
	<div class="col-sm-3">
		<?php echo $form->textField($model,'download_web_count', array('class' => 'form-control', 'maxlength' => 255)); ?>
	<?php echo $form->error($model,'download_web_count'); ?>
	</div>
</div>
    
			<div class='form-group form-group-sm'>
<?php echo $form->labelEx($model,'download_mobile_count', array('class' => 'col-sm-1 control-label')); ?>
	<div class="col-sm-3">
		<?php echo $form->textField($model,'download_mobile_count', array('class' => 'form-control', 'maxlength' => 255)); ?>
	<?php echo $form->error($model,'download_mobile_count'); ?>
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