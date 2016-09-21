<div class="global-form">
	<?php
		$form = $this->beginWidget('CActiveForm', array(
			'id' => 'users-model-form',
			'enableClientValidation' => false,
			'enableAjaxValidation' => false,
			'clientOptions' => array(
				'validateOnSubmit' => true,
			),
		));
		?>
	<div class="col-md-6">
		

		<p class="note">Fields with <span class="required">*</span> are required.</p>

			<?php //echo $form->errorSummary($model);  ?>

		<div class="row">
			<?php echo $form->labelEx($model, 'full_name', array('label' => 'Full Name', 'class' => 'col-sm-3')); ?>
			<div class="col-sm-9">
				<?php echo $form->textField($model, 'full_name', array('size' => 47, 'maxlength' => 150, 'class' => 'form-control')); ?>
				<?php echo $form->error($model, 'full_name'); ?>
			</div>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model, 'username', array('label' => 'User Name', 'class' => 'col-sm-3')); ?>
			<div class="col-sm-9">
				<?php echo $form->textField($model, 'username', array('size' => 47, 'maxlength' => 50, 'class' => 'form-control')); ?>
				<?php echo $form->error($model, 'username'); ?>
			</div>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model, 'temp_password', array('class' => 'col-sm-3')); ?>
			<div class="col-sm-9">
				<?php echo $form->passwordField($model, 'temp_password', array('maxlength' => 30, 'value' => '', 'class' => 'form-control')); ?>
				<?php echo $form->error($model, 'temp_password'); ?>
			</div>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model, 'password_confirm', array('class' => 'col-sm-3')); ?>
			<div class="col-sm-9">
				<?php echo $form->passwordField($model, 'password_confirm', array('maxlength' => 30, 'value' => '', 'class' => 'form-control')); ?>
				<?php echo $form->error($model, 'password_confirm'); ?>
			</div>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model, 'email', array('class' => 'col-sm-3')); ?>
			<div class="col-sm-9">
				<?php echo $form->textField($model, 'email', array('size' => 47, 'maxlength' => 200, 'class' => 'form-control')); ?>
				<?php echo $form->error($model, 'email'); ?>
			</div>
		</div>
		<div class="row">
			<?php echo CHtml::activeLabelEx($model, 'verifyCode', array('class' => 'col-sm-3')) ?>
			<div class="col-sm-9">
			<?php $this->widget('CCaptcha'); ?>
			<?php echo CHtml::activeTextField($model,'verifyCode', array('class' => 'form-control')); ?>
			<?php echo $form->error($model,'verifyCode'); ?>
			</div>
		</div>
		
		<div class="clearfix"></div>
	</div>
	<div class="col-md-6" style="padding-top: 25px">
		<div class="row">
			<?php echo $form->labelEx($model, 'company', array('class' => 'col-sm-3')); ?>
			<div class="col-sm-9">
				<?php echo $form->textField($model, 'company', array('size' => 47, 'maxlength' => 200, 'class' => 'form-control')); ?>
				<?php echo $form->error($model, 'company'); ?>
			</div>
		</div>
		<div class="row">
			<?php echo $form->labelEx($model, 'phone', array('class' => 'col-sm-3')); ?>
			<div class="col-sm-9">
				<?php echo $form->textField($model, 'phone', array('size' => 47, 'maxlength' => 200, 'class' => 'form-control numeric-control')); ?>
				<?php echo $form->error($model, 'phone'); ?>
			</div>
		</div>
		<div class="row">
			<?php echo $form->labelEx($model, 'address', array('class' => 'col-sm-3')); ?>
			<div class="col-sm-9">
				<?php echo $form->textField($model, 'address', array('size' => 47, 'maxlength' => 200, 'class' => 'form-control')); ?>
				<?php echo $form->error($model, 'address'); ?>
			</div>
		</div>
		<div class="row">
			<?php echo $form->labelEx($model, 'province', array('class' => 'col-sm-3')); ?>
			<div class="col-sm-9">
				<?php echo $form->textField($model, 'province', array('size' => 47, 'maxlength' => 200, 'class' => 'form-control')); ?>
				<?php echo $form->error($model, 'province'); ?>
			</div>
		</div>
		<div class="row">
			<?php echo $form->labelEx($model, 'city', array('class' => 'col-sm-3')); ?>
			<div class="col-sm-9">
				<?php echo $form->textField($model, 'city', array('size' => 47, 'maxlength' => 200, 'class' => 'form-control')); ?>
				<?php echo $form->error($model, 'city'); ?>
			</div>
		</div>
		<div class="row">
			<?php echo $form->labelEx($model, 'postal_code', array('class' => 'col-sm-3')); ?>
			<div class="col-sm-9">
				<?php echo $form->textField($model, 'postal_code', array('size' => 47, 'maxlength' => 11, 'class' => 'form-control')); ?>
				<?php echo $form->error($model, 'postal_code'); ?>
			</div>
		</div>
		<div class="row">
			<?php echo $form->labelEx($model, 'area_code_id', array('class' => 'col-sm-3')); ?>
			<div class="col-sm-9">
				<?php echo $form->dropDownList($model, 'area_code_id', AreaCode::loadArrArea(), array('empty' => '--Select One--', 'class' => 'form-control')); ?>
				<?php echo $form->error($model, 'area_code_id'); ?>
			</div>
		</div>
	</div>
	<div class="clearfix"></div>
	<div class="row buttons">
		<button type="submit" class="btn">Register <span class="glyphicon glyphicon-user"></span></button>
	</div>
	<?php $this->endWidget(); ?>
</div>


