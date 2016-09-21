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
                <?php echo $form->labelEx($model, 'name', array('class' => 'col-sm-1 control-label')); ?>
                <div class="col-sm-4">
                    <?php echo $form->textField($model, 'name', array('class' => 'form-control', 'maxlength' => 50)); ?>
                    <?php echo $form->error($model, 'name'); ?>
                </div>
            </div>
            <div class='form-group form-group-sm'>
                <?php echo $form->labelEx($model, 'clinic_price', array('class' => 'col-sm-1 control-label')); ?>
                <div class="col-sm-4">
                    <?php echo $form->textField($model, 'clinic_price', array('class' => 'form-control numeric-control', 'maxlength' => 50)); ?>
                    <?php echo $form->error($model, 'clinic_price'); ?>
                </div>
            </div>
            <div class='form-group form-group-sm'>
                <?php echo $form->labelEx($model, 'insurance_price', array('class' => 'col-sm-1 control-label')); ?>
                <div class="col-sm-4">
                    <?php echo $form->textField($model, 'insurance_price', array('class' => 'form-control numeric-control', 'maxlength' => 50)); ?>
                    <?php echo $form->error($model, 'insurance_price'); ?>
                </div>
            </div>
             <div class='form-group form-group-sm'>
                <?php echo $form->labelEx($model, 'ctr_price', array('class' => 'col-sm-1 control-label')); ?>
                <div class="col-sm-4">
                    <?php echo $form->textField($model, 'ctr_price', array('class' => 'form-control numeric-control', 'maxlength' => 50)); ?>
                    <?php echo $form->error($model, 'ctr_price'); ?>
                </div>
            </div>
             <div class='form-group form-group-sm'>
                <?php echo $form->labelEx($model, 'new_price', array('class' => 'col-sm-1 control-label')); ?>
                <div class="col-sm-4">
                    <?php echo $form->textField($model, 'new_price', array('class' => 'form-control numeric-control', 'maxlength' => 50)); ?>
                    <?php echo $form->error($model, 'new_price'); ?>
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