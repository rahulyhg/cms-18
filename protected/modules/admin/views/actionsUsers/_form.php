<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'actions-users-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'user_id'); ?>
		<?php echo $form->textField($model,'user_id'); ?>
		<?php echo $form->error($model,'user_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'action_id'); ?>
		<?php echo $form->textField($model,'action_id'); ?>
		<?php echo $form->error($model,'action_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'can_access'); ?>
		<?php echo $form->textField($model,'can_access',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'can_access'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->