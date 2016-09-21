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
					<?php $message = Yii::app()->user->getFlash('success');
					if ($message != '') :?>
					<div class="alert alert-success">
						<a href="#" class="close" data-dismiss="alert">&times;</a>
						<?php echo $message ?>
					</div>
				<?php
					endif;
					$form = $this->beginWidget('CActiveForm', array(
						'id' => 'users-model-form',
						'enableClientValidation' => false,
						'enableAjaxValidation' => false,
						'clientOptions' => array(
							'validateOnSubmit' => true,
						),
					));
					?>

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
							<?php echo $model->username; ?>
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
					<div class="clearfix"></div>
					<div class="row buttons">
						<button style="margin-right:-25px" type="submit" class="btn">Update <span class="glyphicon glyphicon-user"></span></button>
					</div>
				</div>
				<div class="clearfix"></div>
				<?php $this->endWidget(); ?>
			</div>
		<div class="clearfix"></div>
	</div>

</div><!-- form -->
