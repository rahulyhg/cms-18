<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><span class="<?php echo $model->isNewRecord ? $this->iconCreate : $this->iconEdit; ?>"></span> <?php echo $model->isNewRecord ? 'Create' : 'Update'; ?> <?php echo $this->singleTitle ?></h3>
    </div>
    <div class="panel-body">
        <div class="form">
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'banner-form',
                'enableAjaxValidation' => false,
                'htmlOptions' => array('class' => 'form-horizontal', 'role' => 'form', 'enctype' => 'multipart/form-data'),
                    ));
            ?>
            <div class='form-group form-group-sm'>
                <?php echo $form->labelEx($model, 'name', array('class' => 'col-sm-1 control-label')); ?>
                <div class="col-sm-6">
                    <?php echo $form->textField($model, 'name', array('class' => 'form-control', 'maxlength' => 50)); ?>
                    <?php echo $form->error($model, 'name'); ?>
                </div>
            </div>

            <div class='form-group form-group-sm'>
                <?php echo $form->labelEx($model, 'banner_title', array('class' => 'col-sm-1 control-label')); ?>
                <div class="col-sm-6">
                    <?php echo $form->textField($model, 'banner_title', array('class' => 'form-control', 'maxlength' => 50)); ?>
                    <?php echo $form->error($model, 'banner_title'); ?>
                </div>
            </div>

            <div class='form-group form-group-sm'>
                <?php echo $form->labelEx($model, 'banner_description', array('class' => 'col-sm-1 control-label')); ?>
                <div class="col-sm-6">
                    <?php echo $form->textArea($model, 'banner_description', array('class' => 'my-editor-basic', 'cols' => 63, 'rows' => 5, 'maxlength' => 500)); ?>
                    <?php echo $form->error($model, 'banner_description'); ?>
                </div>
            </div>
            <div class='form-group form-group-sm'>
                <?php echo $form->labelEx($model, 'large_image', array('class' => 'col-sm-1 control-label')); ?>
                <div class="col-sm-3">
                    <?php if ($model->large_image != '') { ?>
                        <div class="thumbnail" id="thumbnail-<?php echo $model->id; ?>">
                            <div class="caption">
                                <h4><?php echo $model->getAttributeLabel('large_image'); ?></h4>
                                <p>Click on remove button to remove <?php echo $model->getAttributeLabel('large_image'); ?></p>
                                <p><a href="<?php echo $this->baseControllerIndexUrl(); ?>/removeimage/fieldName/large_image/id/<?php echo $model->id; ?>" class="label label-danger removedfile" rel="tooltip" title="Remove">Remove</a>
                            </div>
                            <img src="<?php echo Yii::app()->createAbsoluteUrl($model->uploadImageFolder . '/' . $model->id . '/' . $model->large_image); ?>"  style="width:100%;" />
                        </div>
                    <?php } ?>
                    <?php echo $form->fileField($model, 'large_image', array('title' => "Upload " . $model->getAttributeLabel('large_image'))); ?>
                    <div class='notes'>Allow file type  <?php echo '*.' . str_replace(',', ', *.', $model->allowImageType); ?> - Maximum file size : <?php echo ($model->maxImageFileSize / 1024) / 1024; ?>M. <br />Recommended dimension 1280 x 379 </div>
                    <?php echo $form->error($model, 'large_image'); ?>
                </div>
            </div>
            <div class='form-group form-group-sm'>
                <?php echo $form->labelEx($model, 'link', array('class' => 'col-sm-1 control-label')); ?>
                <div class="col-sm-3">
                    <?php echo $form->textField($model, 'link', array('class' => 'form-control', 'maxlength' => 255)); ?>
                    <?php echo $form->error($model, 'link'); ?>
                </div>
            </div>
            <div class='form-group form-group-sm'>
                <?php echo $form->labelEx($model, 'status', array('class' => 'col-sm-1 control-label')); ?>
                <div class="col-sm-3">
                    <?php echo $form->dropDownList($model, 'status', $model->optionActive, array('class' => 'form-control')); ?>
                    <?php echo $form->error($model, 'status'); ?>
                </div>
            </div>

            <div class='form-group form-group-sm'>
                <?php echo $form->labelEx($model, 'order_display', array('class' => 'col-sm-1 control-label')); ?>
                <div class="col-sm-3">
                    <?php echo $form->textField($model, 'order_display', array('class' => 'numeric-control form-control', 'maxlength' => 10)); ?>
                    <?php echo $form->error($model, 'order_display'); ?>
                </div>
            </div>


            <div class="clr"></div>
            <div class="well">
                <?php echo CHtml::htmlButton($model->isNewRecord ? '<span class="' . $this->iconCreate . '"></span> Create' : '<span class="' . $this->iconSave . '"></span> Save', array('class' => 'btn btn-primary', 'type' => 'submit')); ?> &nbsp;  
                <?php echo CHtml::htmlButton('<span class="' . $this->iconCancel . '"></span> Cancel', array('class' => 'btn btn-default', 'onclick' => 'javascript: location.href=\'' . $this->baseControllerIndexUrl() . '\'')); ?>
            </div>
            <?php $this->endWidget(); ?>
        </div>
    </div>
</div>