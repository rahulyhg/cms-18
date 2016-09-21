<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'event-form',
	'enableAjaxValidation'=>false,
        'method'=>'post',
        'htmlOptions' => array('enctype' => 'multipart/form-data'),
)); ?>

	<?php echo Yii::t('translation', '<p class="note">Fields with <span class="required">*</span> are required.</p>'); ?>
	
	<div class="row">
		<?php echo Yii::t('translation', $form->labelEx($model,'title')); ?>
		<?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'title', array('style' => 'margin-left: 115px;')); ?>
	</div>

	<div class="row">
            <?php echo $form->labelEx($model, 'image1'); ?>
            <image style="margin-bottom: 5px;" src="<?php echo $model->getImageUrl('image1', Event::IMAGE1_WIDTH_1, Event::IMAGE1_HEIGHT_1) ?>">
            <div>
                <?php echo $form->fileField($model, 'image1', array('style' => 'margin-left: 115px;')); ?><span> (Recommended size: <?php echo Event::IMAGE1_WIDTH_1 ?>x<?php echo Event::IMAGE1_HEIGHT_1 ?>px)</span>
                <?php echo $form->error($model, 'image1', array('style' => 'margin-left: 115px;')); ?>
            </div>
        </div> 

	<div class="row">
            <?php echo $form->labelEx($model, 'image2'); ?>
            <image style="margin-bottom: 5px;" src="<?php echo $model->getImageUrl('image2', Event::IMAGE2_WIDTH_1, Event::IMAGE2_HEIGHT_1) ?>">
            <div>
                <?php echo $form->fileField($model, 'image2', array('style' => 'margin-left: 115px;')); ?><span> (Recommended size: <?php echo Event::IMAGE2_WIDTH_1 ?>x<?php echo Event::IMAGE2_HEIGHT_1 ?>px)</span>
                <?php echo $form->error($model, 'image2', array('style' => 'margin-left: 115px;')); ?>
            </div>
        </div> 

	<div class="row">
            <?php echo Yii::t('translation',$form->labelEx($model,'title_text')); ?>
            <div style="float:left;">
                <?php
                $this->widget('ext.ckeditor.CKEditorWidget',array(
                    "model"=>$model,
                    "attribute"=>'title_text',
                    "config" => array(
                        "height"=>"150px",
                        "width"=>"500px",
                        "toolbar"=>Yii::app()->params['ckeditor_simple']
                    )
                ));
                ?>
                <?php echo Yii::t('translation',$form->error($model,'title_text')); ?>
            </div>
        </div>
        <div class='clr'></div>

	<div class="row">
            <?php echo Yii::t('translation',$form->labelEx($model,'left_text')); ?>
            <div style="float:left;">
                <?php
                $this->widget('ext.ckeditor.CKEditorWidget',array(
                    "model"=>$model,
                    "attribute"=>'left_text',
                    "config" => array(
                        "height"=>"150px",
                        "width"=>"500px",
                        "toolbar"=>Yii::app()->params['ckeditor_simple']
                    )
                ));
                ?>
                <?php echo Yii::t('translation',$form->error($model,'left_text')); ?>
            </div>
        </div>
        <div class='clr'></div>

	<div class="row">
            <?php echo Yii::t('translation',$form->labelEx($model,'right_text')); ?>
            <div style="float:left;">
                <?php
                $this->widget('ext.ckeditor.CKEditorWidget',array(
                    "model"=>$model,
                    "attribute"=>'right_text',
                    "config" => array(
                        "height"=>"150px",
                        "width"=>"500px",
                        "toolbar"=>Yii::app()->params['ckeditor_simple']
                    )
                ));
                ?>
                <?php echo Yii::t('translation',$form->error($model,'right_text')); ?>
            </div>
        </div>
        <div class='clr'></div>

	<div class="row">
		<?php echo Yii::t('translation', $form->labelEx($model,'status')); ?>
		<?php echo $form->dropDownList($model,'status', array(STATUS_ACTIVE => 'Active', STATUS_INACTIVE => 'Inactive')); ?>
		<?php echo $form->error($model,'status', array('style' => 'margin-left: 115px;')); ?>
	</div>

	<div class="row buttons" style="padding-left: 115px;">
		        <?php $this->widget('bootstrap.widgets.TbButton', array(
            'buttonType'=>'submit',
            'label'=>$model->isNewRecord ? Yii::t('translation', 'Create') : Yii::t('translation', 'Save'),
            'type'=>'null', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
            'size'=>'small', // null, 'large', 'small' or 'mini'
            //'htmlOptions' => array('style' => 'margin-bottom: 10px; float: right;'),
        )); ?>	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->