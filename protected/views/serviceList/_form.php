<div class="form">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'queue-form',
        'enableAjaxValidation' => false,
        'htmlOptions' => array('class' => 'form-horizontal', 'role' => 'form', 'enctype' => 'multipart/form-data'),
    ));
    ?>
    <br/>
    <div class="row">
        <div class="col-md-6 col-sm-6">
            <div class='form-group form-group-sm'>
                <?php echo $form->labelEx($model, 'name', array('class' => 'col-sm-5 control-label')); ?>
                <div class="col-sm-7">
                    <?php echo $form->textField($model, 'name', array('class' => 'form-control', 'maxlength' => 50)); ?>
                    <?php echo $form->error($model, 'name'); ?>
                </div>
            </div>
            <div class='form-group form-group-sm'>
                <?php echo $form->labelEx($model, 'clinic_price', array('class' => 'col-sm-5 control-label')); ?>
                <div class="col-sm-7">
                    <?php echo $form->numberField($model, 'clinic_price', array('class' => 'form-control', 'maxlength' => 50,'step' =>'0.01')); ?>
                    <?php echo $form->error($model, 'clinic_price'); ?>
                </div>
            </div>
            <div class='form-group form-group-sm'>
                <?php echo $form->labelEx($model, 'insurance_price', array('class' => 'col-sm-5 control-label')); ?>
                <div class="col-sm-7">
                    <?php echo $form->numberField($model, 'insurance_price', array('class' => 'form-control ', 'maxlength' => 50,'step' =>'0.01')); ?>
                    <?php echo $form->error($model, 'insurance_price'); ?>
                </div>
            </div>
             <div class='form-group form-group-sm'>
                <?php echo $form->labelEx($model, 'ctr_price', array('class' => 'col-sm-5 control-label')); ?>
                <div class="col-sm-7">
                    <?php echo $form->numberField($model, 'ctr_price', array('class' => 'form-control ', 'maxlength' => 50,'step' =>'0.01')); ?>
                    <?php echo $form->error($model, 'ctr_price'); ?>
                </div>
            </div>
             <div class='form-group form-group-sm'>
                <?php echo $form->labelEx($model, 'new_price', array('class' => 'col-sm-5 control-label')); ?>
                <div class="col-sm-7">
                    <?php echo $form->numberField($model, 'new_price', array('class' => 'form-control', 'maxlength' => 50,'step' =>'0.01')); ?>
                    <?php echo $form->error($model, 'new_price'); ?>
                </div>
            </div>
            
            <div class='form-group form-group-sm'>
                <?php echo $form->labelEx($model, 'status', array('class' => 'col-sm-5 control-label')); ?>
                <div class="col-sm-7">
                    <?php echo $form->dropDownList($model, 'status', $model->optionActive, array('class' => 'form-control')); ?>
                    <?php echo $form->error($model, 'status'); ?>
                </div>
            </div>
            
            
        </div>
        
        
    </div>
    
    <div class="clr"></div>
    <?php echo CHtml::htmlButton($model->isNewRecord ? $this->iconCreate . ' Create' : $this->iconSave . ' Save', array('class' => 'btn btn-primary', 'type' => 'submit')); ?> &nbsp;  
    <?php echo CHtml::htmlButton($this->iconCancel . ' Cancel', array('class' => 'btn btn-default', 'onclick' => 'javascript: location.href=\'' . Yii::app()->createAbsoluteUrl('/serviceList/index') . '\'')); ?>
    </div>
<?php $this->endWidget(); ?>
</div>
