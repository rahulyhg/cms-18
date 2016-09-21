<?php
/* @var $this UserController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	Yii::t('static', $model->type=='race'?'Races':($model->type=='religion'?'Religions':($model->type=='language'?'Languages':'Referrings'))),
);

$this->title = Yii::t('static','Manage '.$model->type=='race'?'Races':($model->type=='religion'?'Religions':($model->type=='language'?'Languages':'Referrings')));
?>
<?php if(Yii::app()->user->hasFlash('error')): ?>
    <div class="alert alert-danger">
        <?php echo Yii::app()->user->getFlash('error'); ?>
    </div>
<?php endif; ?>
<?php if(Yii::app()->user->hasFlash('message')): ?>
    <div class="alert alert-success">
        <?php echo Yii::app()->user->getFlash('message'); ?>
    </div>
<?php endif; ?>
<div class="form-type">

    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'master-form',
        'enableAjaxValidation'=>true,
    )); ?>
    <div class="row">
        <div class="col-lg-5">
            <?php echo $form->errorSummary($model, Yii::t('validation','Please fix the following input errors:')); ?>

            <div class="form-group">
                <?php echo $form->labelEx($model,'value'); ?>
                <?php echo $form->textField($model,'value',array('size'=>45,'maxlength'=>45,'class'=>'form-control')); ?>
            </div>

            <div class="form-group">
                <?php echo CHtml::submitButton(Yii::t('static','Create'), array('class'=>'btn btn-primary')); ?>
            </div>
        </div>
    </div>
    <?php $this->endWidget(); ?>
</div><!-- form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'user-grid',
    'dataProvider'=>$model->search(),
    'emptyText'=>Yii::t('static', 'No records found.'),
    'enableSorting'=>false,
    'itemsCssClass'=>'table table-striped table-hover',
    'summaryText'=>Yii::t('static', 'Displaying {start}-{end} of {count} result.'),
    'columns'=>array(
        array(
            'header' => Yii::t('static', 'S/N'),
            'type' => 'raw',
            'value' => '$row+1',
            'headerHtmlOptions' => array('width' => '30px'),
            'htmlOptions' => array('style' => 'text-align:center;')
        ),
        'value:text:'.Yii::t('static',$model->type=='race'?'Race':($model->type=='religion'?'Religion':($model->type=='language'?'Language':'Referring'))),
        array(
            'header' => Yii::t('static','Actions'),
            'headerHtmlOptions' => array('width' => '150px', 'style'=>'text-align: center'),
            'class'=>'CButtonColumn',
            'template'=>'{update} {delete}',
            'deleteButtonLabel'=>Yii::t('static','Delete'),
            'deleteButtonImageUrl'=>Yii::app()->theme->baseUrl.'/img/btn/delete_button.png',
            'updateButtonImageUrl'=>Yii::app()->theme->baseUrl.'/img/btn/edit_button.png',
            'updateButtonLabel'=>Yii::t('static','Update'),
        ),
    ),
)); ?>
