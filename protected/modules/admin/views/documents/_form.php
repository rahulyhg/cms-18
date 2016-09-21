<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><span class="<?php echo $model->isNewRecord ? $this->iconCreate : $this->iconEdit; ?>"></span> <?php echo $model->isNewRecord ? 'Create' : 'Update'; ?> <?php echo $this->singleTitle ?></h3>
    </div>
    <div class="panel-body">
        <div class="form">
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'document-form',
                'enableAjaxValidation' => false,
                'htmlOptions' => array('class' => 'form-horizontal', 'role' => 'form', 'enctype' => 'multipart/form-data'),
                    ));
            ?>
            <div class='form-group form-group-sm'>
                <?php echo $form->labelEx($model, 'document_name', array('class' => 'col-sm-1 control-label')); ?>
                <div class="col-sm-3">
                    <?php echo $form->textField($model, 'document_name', array('class' => 'form-control', 'maxlength' => 255)); ?>
                    <?php echo $form->error($model, 'document_name'); ?>
                </div>
            </div>
            <div class='form-group form-group-sm'>
                <?php echo $form->labelEx($model, 'for_user_id', array('class' => 'col-sm-1 control-label')); ?>
                <div class="col-sm-3">
                    <?php
                    $dropdownData = CHtml::listData($userList, 'id', "email");
                    echo $form->dropDownList($model, 'for_user_id', $dropdownData, array('empty' => 'Public', 'class' => 'form-control', 'maxlength' => 255));
                    ?>
                    <?php echo $form->error($model, 'for_user_id'); ?>
                </div>
            </div>

            <div class='form-group form-group-sm'>
                <?php echo $form->labelEx($model, 'document_file', array('class' => 'col-sm-1 control-label')); ?>
                <div class="col-sm-3">
                    <?php if (!empty($model->document_file) && file_exists($model->uploadFileFolder . '/' . $model->id . '/' . $model->document_file)) {
                        ?>
                        <div id="thumb_document_file" class="thumbnail-file">
                            <div class="caption-file">
                                <a class="file-link" href="<?php echo Yii::app()->createAbsoluteUrl($model->uploadFileFolder . "/" . $model->id . "/" . $model->document_file); ?>"><?php echo $model->document_file; ?></a>
                                <p>Click on remove button to remove <?php echo $model->getAttributeLabel('document_file'); ?></p>
                                <p><a href="<?php echo $this->baseControllerIndexUrl(); ?>/removefile/fieldName/document_file/id/<?php echo $model->id; ?>" class="label label-danger removedfile" rel="tooltip" title="Remove">Remove</a>
                            </div>

                        </div><?php } ?>
                    <?php echo $form->fileField($model, 'document_file', array('accept' => 'document/*', 'title' => 'Upload  ' . $model->getAttributeLabel('document_file'))); ?>
                    <div class='notes'>Allow file type  <?php echo '*.' . str_replace(',', ', *.', $model->allowUploadType); ?> - Maximum file size : <?php echo ($model->maxUploadFileSize / 1024) / 1024; ?>M </div>
                    <?php echo $form->error($model, 'document_file'); ?>
                </div>
            </div>

            <div class='form-group form-group-sm'>
                <?php echo $form->labelEx($model, 'required_login', array('class' => 'col-sm-1 control-label')); ?>
                <div class="col-sm-3">
                    <?php echo $form->dropDownList($model, 'required_login', $model->optionYesNo, array('class' => 'form-control')); ?>
                    <?php echo $form->error($model, 'required_login'); ?>
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
                <?php echo CHtml::htmlButton('<span class="' . $this->iconCancel . '"></span> Cancel', array('class' => 'btn btn-default', 'onclick' => 'javascript: location.href=\'' . $this->baseControllerIndexUrl() . '\'')); ?>
            </div>
            <?php $this->endWidget(); ?>
        </div>
    </div>
</div>