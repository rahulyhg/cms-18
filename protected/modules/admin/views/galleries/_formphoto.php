<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title"><span class="<?php echo $model->isNewRecord ? $this->iconCreate : $this->iconEdit; ?>"></span> <?php echo $model->isNewRecord ? 'Create' : 'Update'; ?> <?php echo $this->singleTitle ?></h3>
	</div>
	<div class="panel-body">
		<div class="form">
			<?php
			$form = $this->beginWidget('CActiveForm', array(
				'id' => 'product-form',
				'enableAjaxValidation' => false,
				'htmlOptions' => array('class' => 'form-horizontal', 'role' => 'form', 'enctype' => 'multipart/form-data'),
			));
			?>
			<div class='form-group form-group-sm'>
					<?php echo $form->labelEx($model, 'title', array('class' => 'col-sm-1 control-label')); ?>
				<div class="col-sm-6">
					<?php echo $form->textField($model, 'title', array('class' => 'form-control', 'maxlength' => 50)); ?>
					<?php echo $form->error($model, 'title'); ?>
				</div>
			</div>
            <div class='form-group form-group-sm'>
                <?php echo $form->labelEx($model, 'fileurl', array('class' => 'col-sm-1 control-label')); ?>
                <div class="col-sm-3">

                    <?php if (!empty($model->fileurl))
                    { ?>
                        <div class="thumbnail">
                        <div class="caption">
                            <h4><?php echo $model->getAttributeLabel('fileurl'); ?></h4>
                            <p>Click on remove button to remove <?php echo $model->getAttributeLabel('fileurl'); ?></p>
                            <p><a href="<?php echo $this->baseControllerIndexUrl(); ?>/removeimage/fieldName/product_image/id/<?php echo $this->id; ?>" class="label label-danger removedfile" rel="tooltip" title="Remove">Remove</a>
                        </div>
                        <img src="<?php echo Yii::app()->createAbsoluteUrl($model->uploadImageFolder . "/" . $model->id . "/" . $model->fileurl); ?>"  style="width:100%;" />
                        </div><?php } ?>
                    <?php echo $form->fileField($model, 'fileurl', array('accept' => 'image/*', 'title' => 'Upload  ' . $model->getAttributeLabel('fileurl'))); ?>
                    <div class='notes'>Allow file type  <?php echo '*.' . str_replace(',', ', *.', $model->allowImageType); ?> - Maximum file size : <?php echo ($model->maxImageFileSize/1024)/1024;?>M </div>
                    <?php echo $form->error($model, 'product_image'); ?>
                </div>
            </div>
			<div class='form-group form-group-sm'>
					<?php echo $form->labelEx($model, 'status', array('class' => 'col-sm-1 control-label')); ?>
				<div class="col-sm-3">
					<?php echo $form->dropDownList($model, 'status', $model->optionActive, array('class' => 'form-control')); ?>
					<?php echo $form->error($model, 'status'); ?>
				</div>
			</div>

			<div class="clr"></div>
			<div class="well">
			<?php echo CHtml::htmlButton($model->isNewRecord ? '<span class="' . $this->iconCreate . '"></span> Create' : '<span class="' . $this->iconSave . '"></span> Save', array('class' => 'btn btn-primary', 'type' => 'submit')); ?> &nbsp;  
			<?php echo CHtml::htmlButton('<span class="' . $this->iconCancel . '"></span> Cancel', array('class' => 'btn btn-default', 'onclick' => 'javascript: location.href=\'' . $this->baseControllerIndexUrl('') . '/photos\'')); ?>
			</div>
<?php $this->endWidget(); ?>
		</div>
	</div>
</div>