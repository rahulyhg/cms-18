
<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'comment-form',
    'action'=>Yii::app()->createUrl('/patients/create'),
    'enableAjaxValidation' => false,
    'htmlOptions' => array('class' => '', 'role' => 'form', 'enctype' => 'multipart/form-data'),
));
?>

<p>This name is not in database <br>
Do you want to add this name to database ?</p>
<input type="hidden" name="patient_name" value="<?php echo $name ?>">

<div class="modal-footer">
    <?php $this->widget('bootstrap.widgets.TbButton', array(
            'buttonType'=>'submit',
            'type'=>'primary',
            'label'=> 'Ok',
    )); ?>
<?php $this->widget('bootstrap.widgets.TbButton', array(
            'buttonType'=>'button',
            'label'=> 'Cancel',
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