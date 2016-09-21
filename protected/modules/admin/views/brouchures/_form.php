<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><span class="<?php echo $model->isNewRecord ? $this->iconCreate : $this->iconEdit; ?>"></span> <?php echo $model->isNewRecord ? 'Create' : 'Update'; ?> <?php echo $this->singleTitle ?></h3>
    </div>
    <div class="panel-body">
        <div class="form">
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'brouchures-form',
                'enableAjaxValidation' => false,
                'htmlOptions' => array('class' => 'form-horizontal', 'role' => 'form', 'enctype' => 'multipart/form-data'),
                    ));
            ?>
            <div class='form-group form-group-sm'>
                <?php echo $form->labelEx($model, 'file_name', array('class' => 'col-sm-1 control-label')); ?>
                <div class="col-sm-3">
                    <?php if (!empty($model->file_name) && file_exists($model->uploadFileFolder . '/' . $model->id . '/' . $model->file_name)) {
                        ?>
                        <div id="thumb_document_file" class="thumbnail-file">
                            <div class="caption-file">
                                <a class="file-link" href="<?php echo Yii::app()->createAbsoluteUrl($model->uploadFileFolder . "/" . $model->id . "/" . $model->file_name); ?>"><?php echo $model->file_name; ?></a>
                                <p>Click on remove button to remove <?php echo $model->getAttributeLabel('file_name'); ?></p>
                                <p><a href="<?php echo $this->baseControllerIndexUrl(); ?>/removefile/fieldName/file_name/id/<?php echo $model->id; ?>" class="label label-danger removedfile" rel="tooltip" title="Remove">Remove</a>
                            </div>

                        </div><?php } ?>
                    <?php echo $form->fileField($model, 'file_name', array('accept' => 'document/*', 'title' => 'Upload  ' . $model->getAttributeLabel('file_name'))); ?>
                    <div class='notes'>Allow file type  <?php echo '*.' . str_replace(',', ', *.', $model->allowUploadType); ?> - Maximum file size : <?php echo ($model->maxUploadFileSize / 1024) / 1024; ?>M </div>
                    <?php echo $form->error($model, 'file_name'); ?>
                </div>
            </div>
            <div class="clr"></div>
            <div class="well">
                <?php echo CHtml::htmlButton($model->isNewRecord ? '<span class="' . $this->iconCreate . '"></span> Create' : '<span class="' . $this->iconSave . '"></span> Save', array('class' => 'btn btn-primary', 'type' => 'submit')); ?> &nbsp;  
                <?php echo CHtml::htmlButton('<span class="' . $this->iconCancel . '"></span> Cancel', array('class' => 'btn btn-default', 'onclick' => 'javascript: location.href=\'' .  Yii::app()->createAbsoluteUrl('/admin/Properties') . '\'')); ?>
            </div>
            <?php $this->endWidget(); ?>
        </div>
    </div>
</div>

