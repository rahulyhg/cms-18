<div class="global-form">
	<div class="col-md-6">
				<?php $form=$this->beginWidget('CActiveForm', array(
					'id'=>'login-form',
					'enableClientValidation'=>false,
					'clientOptions'=>array(
						'validateOnSubmit'=>true,
					),
				)); ?>

					<div class="row">
						<?php echo $form->labelEx($model,'username', array('class' => 'col-sm-3')); ?>
						<div class="col-sm-9">
							<?php echo $form->textField($model,'username', array('class'=>'form-control','size'=>40)); ?>
							<?php echo $form->error($model,'username'); ?>
						</div>
					</div>
					<div class="row">
						<?php echo $form->labelEx($model,'password', array('class' => 'col-sm-3')); ?>
						<div class="col-sm-9">
							<?php echo $form->passwordField($model,'password', array('class'=>'form-control','size'=>40)); ?>
							<?php echo $form->error($model,'password'); ?>
						</div>
					</div>

					<div class="field rememberMe">
						<div class="col-sm-3">&nbsp;</div>
						<div class="col-sm-9">
						<?php echo $form->checkBox($model,'rememberMe'); ?>
						<?php echo $form->label($model,'rememberMe'); ?>
						<?php echo $form->error($model,'rememberMe'); ?>
						</div>
					</div>

					<div class="row button">
						<div class="col-sm-3">&nbsp;</div>
						<div class="col-sm-9">
							<a href="<?php echo Yii::app()->createAbsoluteUrl('users/forgotPassword') ?>">Forgot Password ?</a>&nbsp;&nbsp;
							<label>Not a member? <a href="<?php echo Yii::app()->createAbsoluteUrl('users/register'); ?>">Join Now</a></label>
						</div>
					</div>
					
					<div class="clearfix"></div>
					<div class="row buttons">
						<button type="submit" class="btn">Login <span class="glyphicon glyphicon-log-in"></span></button>
					</div>
				<?php $this->endWidget(); ?>

	</div>
	<div class="clearfix"></div>
</div>


