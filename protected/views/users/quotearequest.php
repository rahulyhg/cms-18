<div class="form">
			<?php
			$form = $this->beginWidget('CActiveForm', array(
				'id' => 'enquiry-form',
				'enableAjaxValidation' => false,
				'htmlOptions' => array('class' => 'form-horizontal', 'role' => 'form', 'enctype' => 'multipart/form-data'),
			));
			?>
		<div class="col-sm-5">
			<div class='form-group form-group-sm'>
				<?php echo $form->labelEx($model, 'company_name', array('class' => 'col-sm-3 control-label')); ?>
				<div class="col-sm-6">
					<?php echo $form->textField($model, 'company_name', array('class' => 'form-control', 'maxlength' => 255)); ?>
					<?php echo $form->error($model, 'company_name'); ?>
				</div>
			</div>

			<div class='form-group form-group-sm'>
				<?php echo $form->labelEx($model, 'contact_name', array('class' => 'col-sm-3 control-label')); ?>
				<div class="col-sm-6">
					<?php echo $form->textField($model, 'contact_name', array('class' => 'form-control', 'maxlength' => 255)); ?>
					<?php echo $form->error($model, 'contact_name'); ?>
				</div>
			</div>

			<div class='form-group form-group-sm'>
				<?php echo $form->labelEx($model, 'street_name', array('class' => 'col-sm-3 control-label')); ?>
				<div class="col-sm-6">
					<?php echo $form->textField($model, 'street_name', array('class' => 'form-control', 'maxlength' => 255)); ?>
					<?php echo $form->error($model, 'street_name'); ?>
				</div>
			</div>

			<div class='form-group form-group-sm'>
				<?php echo $form->labelEx($model, 'city', array('class' => 'col-sm-3 control-label')); ?>
				<div class="col-sm-6">
					<?php echo $form->textField($model, 'city', array('class' => 'form-control', 'maxlength' => 255)); ?>
					<?php echo $form->error($model, 'city'); ?>
				</div>
			</div>

			<div class='form-group form-group-sm'>
				<?php echo $form->labelEx($model, 'country', array('class' => 'col-sm-3 control-label')); ?>
				<div class="col-sm-6">
					<?php echo $form->textField($model, 'country', array('class' => 'form-control', 'maxlength' => 255)); ?>
					<?php echo $form->error($model, 'country'); ?>
				</div>
			</div>
			<div class='form-group form-group-sm'>
				<?php echo $form->labelEx($model, 'phone', array('class' => 'col-sm-3 control-label')); ?>
				<div class="col-sm-6">
					<?php echo $form->textField($model, 'phone', array('class' => 'numeric-control form-control', 'maxlength' => 10)); ?>
					<?php echo $form->error($model, 'phone'); ?>
				</div>
			</div>

			<div class='form-group form-group-sm'>
				<?php echo $form->labelEx($model, 'email', array('class' => 'col-sm-3 control-label')); ?>
				<div class="col-sm-6">
					<?php echo $form->textField($model, 'email', array('class' => 'form-control', 'maxlength' => 255)); ?>
					<?php echo $form->error($model, 'email'); ?>
				</div>
			</div>
		</div>
		<div class="col-sm-5">
			

			<div class='form-group form-group-sm'>
				<?php echo $form->labelEx($model, 'website', array('class' => 'col-sm-3 control-label')); ?>
				<div class="col-sm-7">
					<?php echo $form->textField($model, 'website', array('class' => 'form-control', 'maxlength' => 255)); ?>
					<?php echo $form->error($model, 'website'); ?>
				</div>
			</div>

			<div class='form-group form-group-sm'>
				<?php echo $form->labelEx($model, 'enquiry_date', array('class' => 'col-sm-3 control-label')); ?>
				<div class="col-sm-7">
					<?php echo $form->textField($model, 'enquiry_date', array('class' => 'form-control my-datepicker-control', 'maxlength' => 255)); ?>
					<?php echo $form->error($model, 'enquiry_date'); ?>
				</div>
			</div>

			<div class='form-group form-group-sm'>
				<?php echo $form->labelEx($model, 'part', array('class' => 'col-sm-3 control-label')); ?>
				<div class="col-sm-7">
					<?php echo $form->textField($model, 'part', array('class' => 'form-control', 'maxlength' => 255)); ?>
					<?php echo $form->error($model, 'part'); ?>
				</div>
			</div>

			<div class='form-group form-group-sm'>
				<?php echo $form->labelEx($model, 'project', array('class' => 'col-sm-3 control-label')); ?>
				<div class="col-sm-7">
					<?php echo $form->textField($model, 'project', array('class' => 'form-control', 'maxlength' => 255)); ?>
					<?php echo $form->error($model, 'project'); ?>
				</div>
			</div>
		</div>
		<div class="col-sm-10">
			<div class='form-group form-group-sm col-sm-4 threecol'>
				<?php echo $form->labelEx($model, 'sorting_services', array('class' => 'control-label')); ?>
				<div>
					<?php echo $form->textField($model, 'sorting_services', array('class' => 'form-control', 'maxlength' => 255)); ?>
					<?php echo $form->error($model, 'sorting_services'); ?>
				</div>
			</div>

			<div class='form-group form-group-sm col-sm-4 threecol'>
				<?php echo $form->labelEx($model, 'system_intergration', array('class' => 'control-label')); ?>
				<div>
					<?php echo $form->textField($model, 'system_intergration', array('class' => 'form-control', 'maxlength' => 255)); ?>
					<?php echo $form->error($model, 'system_intergration'); ?>
				</div>
			</div>

			<div class='form-group form-group-sm col-sm-4 threecol'>
				<?php echo $form->labelEx($model, 'assembly_services', array('class' => 'control-label')); ?>
				<div>
					<?php echo $form->textField($model, 'assembly_services', array('class' => 'form-control', 'maxlength' => 255)); ?>
					<?php echo $form->error($model, 'assembly_services'); ?>
				</div>
			</div>
		</div>
		<div class="col-sm-10">
			<div class='form-group form-group-sm col-sm-4 threecol'>
				<?php echo $form->labelEx($model, 'retrofit', array('class' => 'control-label')); ?>
				<div>
					<?php echo $form->textField($model, 'retrofit', array('class' => 'form-control', 'maxlength' => 255)); ?>
					<?php echo $form->error($model, 'retrofit'); ?>
				</div>
			</div>

			<div class='form-group form-group-sm col-sm-4 threecol'>
				<?php echo $form->labelEx($model, 'vision', array('class' => 'control-label')); ?>
				<div>
					<?php echo $form->textField($model, 'vision', array('class' => 'form-control', 'maxlength' => 255)); ?>
					<?php echo $form->error($model, 'vision'); ?>
				</div>
			</div>

			<div class='form-group form-group-sm col-sm-4 threecol'>
				<?php echo $form->labelEx($model, 'eddy_current', array('class' => 'control-label')); ?>
				<div>
					<?php echo $form->textField($model, 'eddy_current', array('class' => 'form-control', 'maxlength' => 255)); ?>
					<?php echo $form->error($model, 'eddy_current'); ?>
				</div>
			</div>
		</div>
		<div class="col-sm-10">
			<div class='form-group form-group-sm col-sm-4 threecol'>
				<?php echo $form->labelEx($model, 'laser', array('class' => 'control-label')); ?>
				<div>
					<?php echo $form->textField($model, 'laser', array('class' => 'form-control', 'maxlength' => 255)); ?>
					<?php echo $form->error($model, 'laser'); ?>
				</div>
			</div>

			<div class='form-group form-group-sm col-sm-4 threecol'>
				<?php echo $form->labelEx($model, 'air_gage', array('class' => 'control-label')); ?>
				<div>
					<?php echo $form->textField($model, 'air_gage', array('class' => 'form-control', 'maxlength' => 255)); ?>
					<?php echo $form->error($model, 'air_gage'); ?>
				</div>
			</div>

			<div class='form-group form-group-sm col-sm-4 threecol'>
				<?php echo $form->labelEx($model, 'inspection_solutions_development', array('class' => 'control-label')); ?>
				<div>
					<?php echo $form->textField($model, 'inspection_solutions_development', array('class' => 'form-control', 'maxlength' => 255)); ?>
					<?php echo $form->error($model, 'inspection_solutions_development'); ?>
				</div>
			</div>
		</div>
		<div class="col-sm-10">
			<div class='form-group form-group-sm col-sm-4 threecol'>
				<?php echo $form->labelEx($model, 'portable_inspections_sorting_station', array('class' => 'control-label')); ?>
				<div>
					<?php echo $form->textField($model, 'portable_inspections_sorting_station', array('class' => 'form-control', 'maxlength' => 255)); ?>
					<?php echo $form->error($model, 'portable_inspections_sorting_station'); ?>
				</div>
			</div>

			<div class='form-group form-group-sm col-sm-4 threecol'>
				<?php echo $form->labelEx($model, 'automates_sorting_system', array('class' => 'control-label')); ?>
				<div>
					<?php echo $form->textField($model, 'automates_sorting_system', array('class' => 'form-control', 'maxlength' => 255)); ?>
					<?php echo $form->error($model, 'automates_sorting_system'); ?>
				</div>
			</div>

			<div class='form-group form-group-sm col-sm-4 threecol'>
				<?php echo $form->labelEx($model, 'imss_interlligent_multi_sorting_system', array('class' => 'control-label')); ?>
				<div>
					<?php echo $form->textField($model, 'imss_interlligent_multi_sorting_system', array('class' => 'form-control', 'maxlength' => 255)); ?>
					<?php echo $form->error($model, 'imss_interlligent_multi_sorting_system'); ?>
				</div>
			</div>
		</div>
		<div class="col-sm-10">
			<div class='form-group form-group-sm col-sm-4 threecol'>
				<?php echo $form->labelEx($model, 'pcl_control', array('class' => 'control-label')); ?>
				<div>
					<?php echo $form->textField($model, 'pcl_control', array('class' => 'form-control', 'maxlength' => 255)); ?>
					<?php echo $form->error($model, 'pcl_control'); ?>
				</div>
			</div>

			<div class='form-group form-group-sm col-sm-4 threecol'>
				<?php echo $form->labelEx($model, 'pc_control', array('class' => 'control-label')); ?>
				<div>
					<?php echo $form->textField($model, 'pc_control', array('class' => 'form-control', 'maxlength' => 255)); ?>
					<?php echo $form->error($model, 'pc_control'); ?>
				</div>
			</div>

			<div class='form-group form-group-sm col-sm-4 threecol'>
				<?php echo $form->labelEx($model, 'motion_control', array('class' => 'control-label')); ?>
				<div>
					<?php echo $form->textField($model, 'motion_control', array('class' => 'form-control', 'maxlength' => 255)); ?>
					<?php echo $form->error($model, 'motion_control'); ?>
				</div>
			</div>
		</div>
		<div class="col-sm-10">
			<div class='form-group form-group-sm col-sm-4 threecol'>
				<?php echo $form->labelEx($model, 'complete_custom_solutions', array('class' => 'control-label')); ?>
				<div>
					<?php echo $form->textField($model, 'complete_custom_solutions', array('class' => 'form-control', 'maxlength' => 255)); ?>
					<?php echo $form->error($model, 'complete_custom_solutions'); ?>
				</div>
			</div>

			<div class='form-group form-group-sm col-sm-4 threecol'>
				<?php if ($model->blue_print_attached != '' && file_exists($model->uploadImageFolder . '/' . $model->id . '/' . $model->blue_print_attached)) { ?>
                        <div class="thumbnail" id="thumbnail-<?php echo $model->id; ?>">
                            <div class="caption">
                                <h4><?php echo $model->getAttributeLabel('blue_print_attached'); ?></h4>
                                <p>Click on remove button to remove <?php echo $model->getAttributeLabel('blue_print_attached'); ?></p>
                                <p><a href="<?php echo $this->baseControllerIndexUrl(); ?>/removeimage/fieldName/blue_print_attached/id/<?php echo $model->id; ?>" class="label label-danger removedfile" rel="tooltip" title="Remove">Remove</a>
                            </div>
                            <img src="<?php echo Yii::app()->createAbsoluteUrl($model->uploadImageFolder . '/' . $model->id . '/' . $model->blue_print_attached); ?>"  style="width:100%;" />
                        </div>
				<?php } ?>
				<?php echo $form->fileField($model, 'blue_print_attached', array('title' => "Upload " . $model->getAttributeLabel('blue_print_attached'))); ?>
				<div class='notes'>Allow file type  <?php echo '*.' . str_replace(',', ', *.', $model->allowImageType); ?> - Maximum file size : <?php echo ($model->maxImageFileSize / 1024) / 1024; ?>M </div>
				<?php echo $form->error($model, 'blue_print_attached'); ?>
				
			</div>

			<div class='form-group form-group-sm col-sm-4 threecol'>
				<?php if ($model->picture_attached != '' && file_exists($model->uploadImageFolder . '/' . $model->id . '/' . $model->picture_attached)) { ?>
                        <div class="thumbnail" id="thumbnail-<?php echo $model->id; ?>">
                            <div class="caption">
                                <h4><?php echo $model->getAttributeLabel('picture_attached'); ?></h4>
                                <p>Click on remove button to remove <?php echo $model->getAttributeLabel('picture_attached'); ?></p>
                                <p><a href="<?php echo $this->baseControllerIndexUrl(); ?>/removeimage/fieldName/picture_attached/id/<?php echo $model->id; ?>" class="label label-danger removedfile" rel="tooltip" title="Remove">Remove</a>
                            </div>
                            <img src="<?php echo Yii::app()->createAbsoluteUrl($model->uploadImageFolder . '/' . $model->id . '/' . $model->picture_attached); ?>"  style="width:100%;" />
                        </div>
				<?php } ?>
				<?php echo $form->fileField($model, 'picture_attached', array('title' => "Upload " . $model->getAttributeLabel('picture_attached'))); ?>
				<div class='notes'>Allow file type  <?php echo '*.' . str_replace(',', ', *.', $model->allowImageType); ?> - Maximum file size : <?php echo ($model->maxImageFileSize / 1024) / 1024; ?>M </div>
				<?php echo $form->error($model, 'picture_attached'); ?>
				
			</div>
		</div>
		<div class="col-sm-10">
			<div class='form-group form-group-sm threeco col-sm-12'>
				<?php echo $form->labelEx($model, 'note', array('class' => 'control-label')); ?>
				<div>
					<?php echo $form->textArea($model, 'note', array('cols' => 216, 'rows' => 5)); ?>
					<?php echo $form->error($model, 'note'); ?>
				</div>
			</div>
		</div>

			<div class="clr"></div>
			<div class="well">
			<?php echo CHtml::htmlButton($model->isNewRecord ? '<span class="' . $this->iconCreate . '"></span> Create' : '<span class="' . $this->iconSave . '"></span> Save', array('class' => 'btn btn-primary', 'type' => 'submit')); ?> &nbsp;  
			<?php echo CHtml::htmlButton('<span class="' . $this->iconCancel . '"></span> Cancel', array('class' => 'btn btn-default', 'onclick' => 'javascript: location.href=\'' . $this->baseControllerIndexUrl() . '\'')); ?>
			</div>
			<?php $this->endWidget(); ?>
		</div>