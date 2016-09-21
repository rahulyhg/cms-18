<div class="global-form">
	<div class="col-md-6">

		<p class="note">Your new password will be sent to your registered email address.</p>

		<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'forget-password-form',
			'enableClientValidation' => false,
			'enableAjaxValidation' => false,
			'clientOptions' => array(
				'validateOnSubmit' => true,
			),
		)); ?>

		<?php
		foreach(Yii::app()->user->getFlashes() as $key => $message) {
			echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
		}
		?>
			<div class="row">
				<?php echo $form->labelEx($model,'email', array('class' => 'col-sm-4')); ?>
				<div class="col-sm-8">
					<?php echo $form->textField($model,'email',array('class'=>'form-control', 'style'=>'width: 300px')); ?>
					<?php echo $form->error($model,'email'); ?>
				</div>
			</div>

			<div class="row">
				<button type="submit" class="btn"> Submit </button> &nbsp; <button type="button" onclick="location.href='<?php echo Yii::app()->createAbsoluteUrl('users/login') ?>'" class="btn"> Cancel </button>
			</div>

		<?php $this->endWidget(); ?>
		<div class="clearfix"></div>
	</div>
	<div class="clearfix"></div>
</div>
