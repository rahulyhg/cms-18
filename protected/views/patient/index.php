<?php
/* @var $this DoctorController */
/* @var $dataProvider CActiveDataProvider */
$this->breadcrumbs=array(
	Yii::t('static','Patients'),
);

$this->menu=array(
	array('label'=>Yii::t('static','Create Patient'), 'url'=>array('create')),
);

$this->title = Yii::t('static','Manage Patients');
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
<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'patient-grid',
    'dataProvider'=>$model->search(),
    'emptyText'=>Yii::t('static', 'No records found.'),
    'enableSorting'=>false,
    'filter'=>$model,
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
        array(
            'name'=>'name',
            'value'=>'(!empty($data->salutation)?$data->salutation." ":"").$data->name',
        ),
        'identity',
        array(
            'name'=>'dob',
            'type'=>'date',
            'filter'=>false,
        ),
        array(
            'name'=>'gender',
            'value'=>'$data->gender=="male"?Yii::t("static","Male"):Yii::t("static","Female")',
            'filter'=>array('male'=>Yii::t('static','Male'),'female'=>Yii::t('static','Female')),
        ),
        'language',
        'contact1',
        array(
            'header' => Yii::t('static','Actions'),
            'headerHtmlOptions' => array('width' => '150px', 'style'=>'text-align: center'),
            'class'=>'CButtonColumn',
            'template'=>'{view} {update}',
            'updateButtonImageUrl'=>Yii::app()->request->baseUrl.'/img/btn/edit_button.png',
            'updateButtonLabel'=>Yii::t('static','Update'),
            'deleteButtonImageUrl'=>Yii::app()->request->baseUrl.'/img/btn/delete_button.png',
            'deleteButtonLabel'=>Yii::t('static','Delete'),
            'viewButtonImageUrl'=>Yii::app()->request->baseUrl.'/img/btn/view_button.png',
            'viewButtonLabel'=>Yii::t('static','View'),
        ),
    ),
));
?>

