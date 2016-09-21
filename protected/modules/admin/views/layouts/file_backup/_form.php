<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'layouts-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>
        
        <div class="row">
            <?php echo $form->labelEx($model,'content'); ?>
            <div style="float:left;">
                <?php
                $this->widget('ext.editMe.ExtEditMe',array(
                    'model'=>$model,
                    'height'=>'250px',
                    'width'=>'700px',
                    'attribute'=>'content',
                    'toolbar'=>Yii::app()->params['ckeditor_editMe'],
                    'filebrowserBrowseUrl' => Yii::app()->baseUrl.'/ckfinder/ckfinder.html',
                    'filebrowserImageBrowseUrl' => Yii::app()->baseUrl.'/ckfinder/ckfinder.html?type=Images',
                    'filebrowserFlashBrowseUrl' => Yii::app()->baseUrl.'/ckfinder/ckfinder.html?type=Flash',
                    'filebrowserUploadUrl' => Yii::app()->baseUrl.'/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
                    'filebrowserImageUploadUrl' => Yii::app()->baseUrl.'/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
                    'filebrowserFlashUploadUrl' => Yii::app()->baseUrl.'/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash',
                ));
                ?>
            </div>
            <?php echo $form->error($model,'content'); ?>
        </div>
        
        <div class="clr"></div>
        
        <?php
        $tmp_ = array();
        for($i=1;$i<10;$i++)
            $tmp_[$i]=$i;
        ?>

	<div class="row">
		<?php echo $form->labelEx($model,'order'); ?>
		<?php echo $form->dropDownList($model,'order',$tmp_); ?>
		<?php echo $form->error($model,'order'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->dropDownList($model,'status',ActiveRecord::getUserStatus());?>
		<?php echo $form->error($model,'status'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->