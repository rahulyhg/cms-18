
<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'comment-form',
    'action'=>Yii::app()->createUrl('/patients/delete'),
    'enableAjaxValidation' => false,
    'htmlOptions' => array('class' => '', 'role' => 'form', 'enctype' => 'multipart/form-data'),
));
?>

<?php echo $form->textArea($model,'comment_deleted', array('cols'=>"60", 'row'=>"5", 'class' => '', 'style'=>"margin: 0px; width: 530px; height: 120px;")); ?>
<input type="hidden" name="patient_id" value="<?php echo $model->id ?>">

<div class="modal-footer">
    <?php $this->widget('bootstrap.widgets.TbButton', array(
            'buttonType'=>'submit',
            'type'=>'primary',
            'label'=> 'Save',
    )); ?>
<?php $this->widget('bootstrap.widgets.TbButton', array(
            'buttonType'=>'button',
            'label'=> 'Close',
            'htmlOptions' => array('class' => 'close-modal')
    )); ?>
</div>

<?php $this->endWidget(); ?>

<script>
    $(function(){
        $('.close-modal').click(function(){
            $('#myModal').modal('hide');
        });
    });
</script>