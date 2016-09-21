<div class="container main">
	<div class="col-sm-3">
		<?php $this->renderPartial('_menu');?>

	</div>
	<div class="col-sm-9">
		<div class="bn-inner">
			<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
				<div class="carousel-inner">
					<div class="item active">
						<img src="<?php echo Yii::app()->theme->baseUrl; ?>/img/about-bn.jpg" alt="banner" />
					</div>
					<div class="item">
						<img src="<?php echo Yii::app()->theme->baseUrl; ?>/img/product-bn.jpg" alt="banner" />
					</div>
				</div>
			</div>
		</div>
		<div class="document global-form">
			<div class="col-md-9">
				<?php $message = Yii::app()->user->getFlash('successChangeMyPassword');
					if ($message != '') :?>
					<div class="alert alert-success">
						<a href="#" class="close" data-dismiss="alert">&times;</a>
						<?php echo $message ?>
					</div>
				<?php
					endif;
				$form=$this->beginWidget('CActiveForm', array(
				'id'=>'users-model-form',
				'enableClientValidation'=>true,
				'clientOptions'=>array(
					'validateOnSubmit'=>true,
				),
			)); ?>

				<?php
				foreach(Yii::app()->user->getFlashes() as $key => $message) {
					echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
				}
				?>

				<p class="note">Fields with <span class="required">*</span> are required.</p>

				<?php //echo $form->errorSummary($model); ?>

				<div class="row">
					<?php echo $form->labelEx($model,'currentPassword', array('class' => 'col-sm-4')); ?>
					<div class="col-sm-8">
						<?php echo $form->passwordField($model,'currentPassword',array('size'=>38,'maxlength'=>30,  'class' => 'form-control')); ?>
						<?php echo $form->error($model,'currentPassword',array('class'=>'errorMessage m-l-180')); ?>
					</div>
				</div>

				<div class="row">
					<?php echo $form->labelEx($model,'newPassword', array('class' => 'col-sm-4')); ?>
					<div class="col-sm-8">
						<?php echo $form->passwordField($model,'newPassword',array('size'=>38,'maxlength'=>30, 'class' => 'form-control')); ?>
						<?php echo $form->error($model,'newPassword',array('class'=>'errorMessage m-l-180')); ?>
					</div>
				</div>

				<div class="row">
					<?php echo $form->labelEx($model,'password_confirm',array('label'=>'Confirm New Password', 'class' => 'col-sm-4')); ?>
					<div class="col-sm-8">
						<?php echo $form->passwordField($model,'password_confirm',array('size'=>38,'maxlength'=>30, 'class' => 'form-control')); ?>
						<?php echo $form->error($model,'password_confirm',array('class'=>'errorMessage m-l-180')); ?>
					</div>
				</div>
				<div class="clearfix"></div>
				<div class="row buttons">
					<button style="margin-right:-25px" type="submit" class="btn">Change Password <span class="glyphicon glyphicon-floppy-disk"></span></button>
				</div>

				<?php $this->endWidget(); ?>
			</div>
			<div class="clearfix"></div>
		</div>
	</div>
</div><!-- form -->