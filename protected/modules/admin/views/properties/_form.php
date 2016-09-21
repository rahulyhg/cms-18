<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><span class="<?php echo $model->isNewRecord ? $this->iconCreate : $this->iconEdit; ?>"></span> <?php echo $model->isNewRecord ? 'Create' : 'Update'; ?> <?php echo $this->singleTitle ?></h3>
    </div>
    <div class="panel-body">
        <div class="form">
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'Properties-form',
                'enableAjaxValidation' => false,
                'htmlOptions' => array('class' => 'form-horizontal', 'role' => 'form', 'enctype' => 'multipart/form-data'),
                    ));
            ?>
            <div class='form-group form-group-sm'>
                <?php echo $form->labelEx($model, 'title', array('class' => 'col-sm-1 control-label')); ?>
                <div class="col-sm-3">
                    <?php echo $form->textField($model, 'title', array('class' => 'form-control', 'maxlength' => 255)); ?>
                    <?php echo $form->error($model, 'title'); ?>
                </div>
            </div>
           
           

            <div class='form-group form-group-sm'>
                <?php echo $form->labelEx($model, 'address', array('class' => 'col-sm-1 control-label')); ?>
                <div class="col-sm-3">
                    <?php echo $form->textField($model, 'address', array('class' => 'form-control', 'maxlength' => 255)); ?>
                    <?php echo $form->error($model, 'address'); ?>
                </div>
            </div>
            <div class='form-group form-group-sm'>
                <?php echo $form->labelEx($model, 'est_top', array('class' => 'col-sm-1 control-label')); ?>
                <div class="col-sm-3">
                    <?php echo $form->textField($model, 'est_top', array('class' => 'form-control', 'maxlength' => 255)); ?>
                    <?php echo $form->error($model, 'est_top'); ?>
                </div>
            </div>
             <div class='form-group form-group-sm'>
                <?php echo $form->labelEx($model, 'type_id', array('class' => 'col-sm-1 control-label')); ?>
                <div class="col-sm-3">
                    <?php echo $form->dropDownList($model, 'type_id', Propertytype::model()->getDropDownPropertiesType(), array('empty' => 'Select Associate Properties Type', 'class' => 'form-control', 'maxlength' => 255)); ?>
                    <?php echo $form->error($model, 'type_id'); ?>
                </div>
            </div>
            <div class='form-group form-group-sm'>
                <?php echo $form->labelEx($model, 'district_id', array('class' => 'col-sm-1 control-label')); ?>
                <div class="col-sm-3">
                    <?php echo $form->dropDownList($model, 'district_id', District::model()->getDropDownDistrict(), array('empty' => 'Select Associate District', 'class' => 'form-control', 'maxlength' => 255)); ?>
                    <?php echo $form->error($model, 'district_id'); ?>
                </div>
            </div>
            
             <div class='form-group form-group-sm'>
                <?php echo $form->labelEx($model, 'is_featured', array('class' => 'col-sm-1 control-label')); ?>
                <div class="col-sm-3">
                    <?php echo $form->dropDownList($model, 'is_featured', array('1' => 'Yes', '0' => 'No'), array('class' => 'form-control', 'maxlength' => 255)); ?>
                    <?php echo $form->error($model, 'is_featured'); ?>
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
                <?php echo $form->labelEx($model, 'featured_image', array('class' => 'col-sm-1 control-label')); ?>
                <div class="col-sm-3">

                    <?php if (!empty($model->featured_image)) {
                        ?>
                        <div class="thumbnail">
                            <div class="caption">
                                <h4><?php echo $model->getAttributeLabel('featured_image'); ?></h4>
                                <p>Click on remove button to remove <?php echo $model->getAttributeLabel('featured_image'); ?></p>
                                <p><a href="<?php echo $this->baseControllerIndexUrl(); ?>/removeimage/fieldName/featured_image/id/<?php echo $this->id; ?>" class="label label-danger removedfile" rel="tooltip" title="Remove">Remove</a>
                            </div>
                            <img src="<?php echo Yii::app()->createAbsoluteUrl($model->uploadImageFolder . "/" . $model->id . "/" . $model->featured_image); ?>"  style="width:100%;" />
                        </div><?php } ?>
                    <?php echo $form->fileField($model, 'featured_image', array('accept' => 'image/*', 'title' => 'Upload  ' . $model->getAttributeLabel('featured_image'))); ?>
                    <div class='notes'>Allow file type  <?php echo '*.' . str_replace(',', ', *.', $model->allowImageType); ?> - Maximum file size : <?php echo ($model->maxImageFileSize / 1024) / 1024; ?>M. <br />Recommended dimension 233 x 105 </div>
                    <?php echo $form->error($model, 'featured_image'); ?>
                </div>
            </div>
            <div class='form-group form-group-sm'>
                <?php echo $form->labelEx($model, 'brief_description', array('class' => 'col-sm-1 control-label')); ?>
                <div class="col-sm-9">
                    <?php echo $form->textArea($model, 'brief_description', array('class' => 'my-editor-full', 'cols' => 63, 'rows' => 5)); ?>
                    <?php echo $form->error($model, 'brief_description'); ?>
                </div>
            </div>
            <div class='form-group form-group-sm'>
                <?php echo $form->labelEx($model, 'contact_enquiry', array('class' => 'col-sm-1 control-label')); ?>
                <div class="col-sm-9">
                    <?php echo $form->textArea($model, 'contact_enquiry', array('class' => 'my-editor-full', 'cols' => 63, 'rows' => 5)); ?>
                    <?php echo $form->error($model, 'contact_enquiry'); ?>
                </div>
            </div>
            

            <div class='form-group form-group-sm'>
                <?php echo $form->labelEx($model, 'over_view', array('class' => 'col-sm-1 control-label')); ?>
                <div class="col-sm-9">
                    <?php echo $form->textArea($model, 'over_view', array('class' => 'my-editor-full', 'cols' => 63, 'rows' => 5)); ?>
                    <?php echo $form->error($model, 'over_view'); ?>
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