<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title"><span class="<?php echo "<?php echo \$model->isNewRecord ? \$this->iconCreate : \$this->iconEdit; ?>";?>"></span> <?php echo "<?php echo \$model->isNewRecord ? 'Create' : 'Update'; ?> <?php echo \$this->singleTitle ?>";?></h3>
	</div>
	<div class="panel-body">
		<div class="form">
		<?php echo "<?php \$form=\$this->beginWidget('CActiveForm', array(
			'id' => '" . $this->class2id($this->model_name) . "-form',
			'enableAjaxValidation'=>false,
			'htmlOptions' => array('class' => 'form-horizontal', 'role' => 'form', 'enctype' => 'multipart/form-data'),
		)); ?>\n"; ?>
			<?php 
			if (isset($this->type_option['form']))
			{
			foreach ($this->type_option['form'] as $key => $val) { 
				echo "<div class='form-group form-group-sm'>\n";
				echo "<?php echo \$form->labelEx(\$model,'{$key}', array('class' => 'col-sm-1 control-label')); ?>\n";
				echo "\t<div class=\"col-sm-3\">\n";
				if ($val == 'text') {
					echo "\t\t<?php echo \$form->textField(\$model,'{$key}', array('class' => 'form-control', 'maxlength' => 255)); ?>\n";
				} elseif ($val == 'date_picker') {
					echo "\t\t<?php echo \$form->textField(\$model,'{$key}', array('class' => 'my-datepicker-control form-control', 'readonly' => 'true')); ?>\n";
				} elseif ($val == 'date_time_picker') {
					echo "\t\t<?php echo \$form->textField(\$model,'{$key}', array('class' => 'my-datetimepicker-control form-control', 'readonly' => 'true')); ?>\n";
				} elseif ($val == 'time') {
					echo "\t\t<?php echo \$form->textField(\$model,'{$key}', array('class' => 'my-timepicker-control form-control', 'readonly' => 'true')); ?>\n";
				} elseif (isset($val[0]) && $val[0] == 'textarea') {
					echo "\t\t<?php echo \$form->textArea(\$model,'{$key}', array('cols' => 63, 'rows' => 5)); ?>\n";
				} elseif ($val == 'image') {
					echo "<?php\n";
					echo "if (!empty(\$model->{$key}) && file_exists(\$model->uploadImageFolder . '/'.\$model->id.'/'.\$model->" . $key . ")) { ?>\n";
						echo '<div id="thumb_' .$key . '" class="thumbnail">
								<div class="caption">' . "\n" .
								'<h4><?php echo $model->getAttributeLabel(\'' . $key . '\');?></h4>
								<p>Click on remove button to remove <?php echo $model->getAttributeLabel(\'' . $key . '\');?></p>
								<p><a href="<?php echo $this->baseControllerIndexUrl();?>/removeimage/fieldName/' . $key . '/id/<?php echo $model->id;?>" class="label label-danger removedfile" rel="tooltip" title="Remove">Remove</a>
								</div>
								<img src="<?php echo Yii::app()->createAbsoluteUrl($model->uploadImageFolder . "/".$model->id."/".$model->' . $key . ');?>"  style="width:100%;" />
							</div>';
					echo "<?php } ?>\n";
					echo "\t<?php echo \$form->fileField(\$model, '{$key}', array('accept' => 'image/*', 'class' => 'form-control', 'title' => 'Upload  ' . \$model->getAttributeLabel('{$key}'))); ?>\n";
					echo "\t<div class='notes'>Allow file type  <?php echo '*.' . str_replace(',', ', *.', \$model->allowImageType); ?> - Maximum file size : <?php echo (\$model->maxImageFileSize/1024)/1024;?>M </div>\n";
					echo "\t<?php echo \$form->error(\$model, 'featured_image'); ?>\n";
				} elseif ($val == 'file') {
					echo "<?php\n";
					echo "if (!empty(\$model->{$key}) && file_exists(\$model->uploadFileFolder . '/'.\$model->id.'/'.\$model->" . $key . ")) { ?>\n";
						echo '<div id="thumb_' .$key . '" class="thumbnail-file">
								<div class="caption-file">' . "\n" .
								'<a class="file-link"  href="<?php echo Yii::app()->createAbsoluteUrl($model->uploadFileFolder . "/".$model->id."/".$model->' . $key . ');?>"><?php echo $model->' . $key . ';?></a>
								<p>Click on remove button to remove <?php echo $model->getAttributeLabel(\'' . $key . '\');?></p>
								<p><a href="<?php echo $this->baseControllerIndexUrl();?>/removefile/fieldName/' . $key . '/id/<?php echo $model->id;?>" class="label label-danger removedfile" rel="tooltip" title="Remove">Remove</a>
								</div>
							</div>';
					echo "<?php } ?>\n";
					echo "\t<?php echo \$form->fileField(\$model, '{$key}', array('accept' => 'image/*', 'class' => 'form-control', 'title' => 'Upload  ' . \$model->getAttributeLabel('{$key}'))); ?>\n";
					echo "\t<div class='notes'>Allow file type  <?php echo '*.' . str_replace(',', ', *.', \$model->allowImageType); ?> - Maximum file size : <?php echo (\$model->maxImageFileSize/1024)/1024;?>M </div>\n";
					echo "\t<?php echo \$form->error(\$model, 'featured_image'); ?>\n";
				} elseif (isset($val[0]) && $val[0] == 'ckeditor' && $val[1] == 'full') {
					echo "\t<?php echo \$form->textArea(\$model,'{$key}', array('class' => 'my-editor-full', 'cols' => 63, 'rows' => 5)); ?>\n";
				} elseif (isset($val[0]) && $val[0] == 'ckeditor' && $val[1] == 'basic') {
					echo "\t<?php echo \$form->textArea(\$model,'{$key}', array('class' => 'my-editor-basic', 'cols' => 63, 'rows' => 5)); ?>\n";
				} elseif ($val == 'dropdown') {
					echo "\t<?php echo \$form->dropDownList(\$model,'{$key}', \$model->optionActive, array('class' => 'form-control')); ?>\n";
				} elseif ($val == 'yesno') {
					echo "\t<?php echo \$form->dropDownList(\$model, '{$key}', \$model->optionYesNo, array('class' => 'form-control')); ?>\n";
				} elseif ($val == 'number') {
					echo "\t<?php echo \$form->textField(\$model,'{$key}', array('class' => 'numeric-control form-control', 'maxlength' => 10)); ?>\n";
				} elseif ($val == 'password') {
					echo "\t<?php echo \$form->passwordField(\$model,'{$key}', array('class' => 'form-control', 'maxlength' => 30)); ?>\n";
				}
				echo "\t<?php echo \$form->error(\$model,'{$key}'); ?>\n";
				echo "\t</div>\n";
				echo "</div>\n";
			?>    
			<?php } 
			}
			?>

			<div class="clr"></div>
			<div class="well">
				<?php echo "<?php echo CHtml::htmlButton(\$model->isNewRecord ? '<span class=\"' . \$this->iconCreate . '\"></span> Create' : '<span class=\"' . \$this->iconSave . '\"></span> Save', array('class' => 'btn btn-primary', 'type' => 'submit')); ?> &nbsp; "; ?> 
				<?php echo "<?php echo CHtml::htmlButton('<span class=\"' . \$this->iconCancel . '\"></span> Cancel', array('class' => 'btn btn-default', 'onclick' => 'javascript: location.href=\'' . \$this->baseControllerIndexUrl() . '\'')); ?>\n"; ?>
			</div>
		<?php echo "<?php \$this->endWidget(); ?>\n"; ?>
		</div>
	</div>
</div>