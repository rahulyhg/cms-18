<div class="panel panel-default">
  <div class="panel-body">

	<?php echo "<?php \$form = \$this->beginWidget('CActiveForm', array(
		'action'=>Yii::app()->createUrl(\$this->route),
		'method'=>'get',
		'htmlOptions' => array('class' => 'form-horizontal', 'role' => 'form', 'id' => 'search-form'),
	)); ?>\n";

	foreach ($this->type_option['search'] as $key => $val) {
		echo '<div class="col-sm-4">
				<div class="form-group form-group-sm">';
					echo "\n<?php echo \$form->labelEx(\$model,'{$key}', array('class' => 'col-sm-3 control-label')); ?>\n";
					echo "<div class=\"col-sm-7\">\n";
		if ($val == 'text') {
				echo "<?php echo \$form->textField(\$model,'{$key}', array('class' => 'form-control')); ?>\n";
		} elseif ($val == 'date_picker') {
				echo "<?php echo \$form->textField(\$model,'{$key}', array('class' => 'my-datepicker-control form-control')); ?>\n";
		} elseif ($val == 'date_time_picker') {
				echo "<?php echo \$form->textField(\$model,'{$key}', array('class' => 'my-datetimepicker-control form-control')); ?>\n";
		} elseif ($val == 'time') {
				echo "<?php echo \$form->textField(\$model,'{$key}', array('class' => 'my-timepicker-control form-control')); ?>\n";
		} elseif ($val == 'dropdown') {
				echo "<?php echo \$form->dropDownList(\$model,'{$key}', \$model->optionActive, array('class' => 'form-control')); ?>\n";

		} elseif ($val == 'yesno') {
				echo "<?php echo \$form->dropDownList(\$model, '{$key}', MyActiveRecord::getYesNo(), array('class' => 'form-control')); ?>";
		}
		echo "<?php echo \$form->error(\$model,'{$key}'); ?>\n";
		echo "\t\t</div>\n";
		echo "\t</div>\n";
		echo "</div>\n";
	} 
	?>
	<div class="col-sm-12">
		<div class="well">
			<?php echo "<?php echo CHtml::htmlButton('<span class=\"' . \$this->iconSearch .  '\"></span> Search', array('class' => 'btn btn-default btn-sm', 'type' => 'submit')); ?>";?>
			<?php echo "\n<?php echo CHtml::htmlButton('<span class=\"' . \$this->iconCancel . '\"></span> Clear', array('class' => 'btn btn-default btn-sm', 'type' => 'reset', 'id' => 'clearsearch')); ?>";?>
		</div>
	</div> 
	<?php echo "<?php \$this->endWidget(); ?>\n"; ?>

	</div>
</div>

