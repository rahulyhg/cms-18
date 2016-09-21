<div class="container">
	<div class="row" style="margin-top:20px">
		<div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
			<?php
            CHtml::$errorCss = '';
            $form = $this->beginWidget('CActiveForm',
                array(
                    'id'=>'myform',
                    'enableAjaxValidation'=>false,
                    'errorMessageCssClass'=>'text-danger',
                    'focus'=>array($model,'username'),
                )
            );
            ?>
				<fieldset>
					<h2>Welcome To <?php echo Yii::app()->params['clinicName']; ?></h2>
					<?php echo $form->errorSummary($model, Yii::t('validation', 'Please fix the following input errors:')); ?>
					<hr class="colorgraph">
					<div class="form-group">
						<?php echo $form->textField($model,'username',array('class' => 'form-control input-lg', 'placeholder'=> 'User name')); ?>
						<!-- <input type="email" name="email" id="email" class="form-control  input-lg" placeholder="Email Address"> -->
					</div>
					<div class="form-group">
						<?php echo $form->passwordField($model,'password',array('class' => 'form-control input-lg', 'placeholder'=> 'Password')); ?>
						<!-- <input type="password" name="password" id="password" class="form-control input-lg" placeholder="Password"> -->
					</div>
					<!-- <span class="button-checkbox">
						<button type="button" class="btn" data-color="info">Remember Me</button>
						<input type="checkbox" name="remember_me" id="remember_me" checked="checked" class="hidden">
						<a href="" class="btn btn-link pull-right">Forgot Password?</a>
					</span> -->
					<hr class="colorgraph">
					<div class="row">
						<div class="col-xs-6 col-sm-6 col-md-6">
							<input type="submit" class="btn btn-lg btn-success btn-block" value="Sign In">
						</div>
					</div>
				</fieldset>
			<?php $this->endWidget(); ?>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(function(){
		$('.button-checkbox').each(function(){
		var $widget = $(this),
			$button = $widget.find('button'),
			$checkbox = $widget.find('input:checkbox'),
			color = $button.data('color'),
			settings = {
					on: {
						icon: 'glyphicon glyphicon-check'
					},
					off: {
						icon: 'glyphicon glyphicon-unchecked'
					}
			};
		$button.on('click', function () {
			$checkbox.prop('checked', !$checkbox.is(':checked'));
			$checkbox.triggerHandler('change');
			updateDisplay();
		});
		$checkbox.on('change', function () {
			updateDisplay();
		});
		function updateDisplay() {
			var isChecked = $checkbox.is(':checked');
			// Set the button's state
			$button.data('state', (isChecked) ? "on" : "off");
			// Set the button's icon
			$button.find('.state-icon')
				.removeClass()
				.addClass('state-icon ' + settings[$button.data('state')].icon);
			// Update the button's color
			if (isChecked) {
				$button
					.removeClass('btn-default')
					.addClass('btn-' + color + ' active');
			}
			else
			{
				$button
					.removeClass('btn-' + color + ' active')
					.addClass('btn-default');
			}
		}
		function init() {
			updateDisplay();
			// Inject the icon if applicable
			if ($button.find('.state-icon').length == 0) {
				$button.prepend('<i class="state-icon ' + settings[$button.data('state')].icon + '"></i> ');
			}
		}
		init();
	});
});
</script>