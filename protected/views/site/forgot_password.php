<div class="form">

    <h1 class="title"><strong>Forgotten Password</strong></h1>

    <p class="note">Your new password will be sent to your registered email address.</p>

    <?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'forget-password-form',
        'enableClientValidation' => true,
        'enableAjaxValidation' => false,
        'clientOptions' => array(
            'validateOnSubmit' => true,
        ),
    )); ?>

    <?php
    foreach(Yii::app()->user->getFlashes() as $key => $message) {
        echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
    }
    ?>


        <div class="row">
            <?php echo $form->labelEx($model,'email'); ?>
            <?php echo $form->textField($model,'email',array('size'=>47,'maxlength'=>200)); ?>
            <?php echo $form->error($model,'email'); ?>
        </div>

        <div class="row buttons">
            <?php echo CHtml::submitButton($model->isNewRecord ? 'Send' : 'Submit'); ?>
        </div>

    <?php $this->endWidget(); ?>


</div>
