<div class="form">
    <?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'users-model-form',
    'enableClientValidation' => false,
    'enableAjaxValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
    ),
)); ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model,'full_name',array('label'=>'Full Name')); ?>
        <?php echo $form->textField($model,'full_name',array('size'=>47,'maxlength'=>50)); ?>
        <?php echo $form->error($model,'full_name'); ?>
    </div>
    <div class="row">
        <?php echo $form->labelEx($model,'email'); ?>
        <?php echo $form->textField($model,'email',array('size'=>47,'maxlength'=>200)); ?>
        <?php echo $form->error($model,'email'); ?>
    </div>
    <div class="row">
        <?php echo $form->labelEx($model,'temp_password'); ?>
        <?php echo $form->passwordField($model,'temp_password',array('maxlength'=>30,'value'=>'')); ?>
        <?php echo $form->error($model,'temp_password'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'password_confirm'); ?>
        <?php echo $form->passwordField($model,'password_confirm',array('maxlength'=>30,'value'=>'')); ?>
        <?php echo $form->error($model,'password_confirm'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'phone', array('label'=>'Phone')); ?>
        <?php echo $form->textField($model,'phone',array('size'=>18,'maxlength'=>30)); ?>
        <?php echo $form->error($model,'phone'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'area_code_id',array('label'=>'Country:')); ?>
        <?php echo $form->dropDownList($model,'area_code_id',  AreaCode::loadArrArea(), array('empty'=>'Select a country'));?>
        <?php echo $form->error($model,'area_code_id'); ?>
    </div>

    <div class="field">
        <?php echo $form->checkbox($model,'agreeTermOfUse'); ?>
        <?php echo $form->label($model,'agreeTermOfUse',array('label'=>'I agree with '.CHtml::link('Term Of Use',array('/term-of-use'), array('target'=>'_blank')))); ?>
        <?php echo $form->error($model,'agreeTermOfUse'); ?>
    </div>

    <div class="field">
        <?php echo $form->checkbox($model,'recieveNewsletter',array('checked'=>true,)); ?>
        <?php echo $form->labelEx($model,'recieveNewsletter',array('label'=>'Receive Newsletter')); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
    </div>
    <?php $this->endWidget(); ?>

</div><!-- form -->
