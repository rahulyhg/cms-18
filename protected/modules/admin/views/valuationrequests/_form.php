<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><span class="<?php echo $model->isNewRecord ? $this->iconCreate : $this->iconEdit; ?>"></span> <?php echo $model->isNewRecord ? 'Create' : 'Update'; ?> <?php echo $this->singleTitle ?></h3>
    </div>
    <div class="panel-body">
        <div class="form">
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'valuationrequests-form',
                'enableAjaxValidation' => false,
                'htmlOptions' => array('class' => 'form-horizontal', 'role' => 'form', 'enctype' => 'multipart/form-data'),
                    ));
            ?>
            <div class='form-group form-group-sm'>
                <?php echo $form->labelEx($model, 'property_adress', array('class' => 'col-sm-1 control-label')); ?>
                <div class="col-sm-3">
                    <?php echo $form->textField($model, 'property_adress', array('class' => 'form-control', 'maxlength' => 255)); ?>
                    <?php echo $form->error($model, 'property_adress'); ?>
                </div>
            </div>

            <div class='form-group form-group-sm'>
                <?php echo $form->labelEx($model, 'type_id', array('class' => 'col-sm-1 control-label')); ?>
                <div class="col-sm-3">
                    <?php echo $form->dropDownList($model,'type_id',  Propertytype::model()->getDropDownPropertiesType(), array('empty'=>'Select Associate Properties Type','class' => 'form-control', 'maxlength' => 255)); ?>
                    <?php echo $form->error($model, 'type_id'); ?>
                </div>
            </div>
            <div class='form-group form-group-sm'>
                <?php echo $form->labelEx($model, 'unit_no_1', array('class' => 'col-sm-1 control-label')); ?>
                <div class="col-sm-3">
                    <?php echo $form->textField($model, 'unit_no_1', array('class' => 'form-control', 'maxlength' => 255)); ?>
                    <?php echo $form->error($model, 'unit_no_1'); ?>
                </div>
            </div>

            <div class='form-group form-group-sm'>
                <?php echo $form->labelEx($model, 'unit_no_2', array('class' => 'col-sm-1 control-label')); ?>
                <div class="col-sm-3">
                    <?php echo $form->textField($model, 'unit_no_2', array('class' => 'form-control', 'maxlength' => 255)); ?>
                    <?php echo $form->error($model, 'unit_no_2'); ?>
                </div>
            </div>

            <div class='form-group form-group-sm'>
                <?php echo $form->labelEx($model, 'size', array('class' => 'col-sm-1 control-label')); ?>
                <div class="col-sm-3">
                    <?php echo $form->textField($model, 'size', array('class' => 'form-control', 'maxlength' => 255)); ?>
                    <?php echo $form->error($model, 'size'); ?>
                </div>
            </div>

            <div class='form-group form-group-sm'>
                <?php echo $form->labelEx($model, 'pes', array('class' => 'col-sm-1 control-label')); ?>
                <div class="col-sm-3">
                    <?php echo $form->dropDownList($model,'pes', array('1'=>'Yes','2'=>'No') , array( 'form-control', 'maxlength' => 255)); ?>
                    <?php echo $form->error($model, 'pes'); ?>
                </div>
            </div>

            <div class='form-group form-group-sm'>
                <?php echo $form->labelEx($model, 'owner_name', array('class' => 'col-sm-1 control-label')); ?>
                <div class="col-sm-3">
                    <?php echo $form->textField($model, 'owner_name', array('class' => 'form-control', 'maxlength' => 255)); ?>
                    <?php echo $form->error($model, 'owner_name'); ?>
                </div>
            </div>

            <div class='form-group form-group-sm'>
                <?php echo $form->labelEx($model, 'owner_mobile', array('class' => 'col-sm-1 control-label')); ?>
                <div class="col-sm-3">
                    <?php echo $form->textField($model, 'owner_mobile', array('class' => 'form-control', 'maxlength' => 255)); ?>
                    <?php echo $form->error($model, 'owner_mobile'); ?>
                </div>
            </div>

            <div class='form-group form-group-sm'>
                <?php echo $form->labelEx($model, 'owner_email', array('class' => 'col-sm-1 control-label')); ?>
                <div class="col-sm-3">
                    <?php echo $form->textField($model, 'owner_email', array('class' => 'form-control', 'maxlength' => 255)); ?>
                    <?php echo $form->error($model, 'owner_email'); ?>
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