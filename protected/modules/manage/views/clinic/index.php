<?php
$this->breadcrumbs=array(
	Yii::t('static','Clinics'),
);

$this->menu=array(
	array('label'=>Yii::t('static','Create Clinic'), 'url'=>array('create')),
);

$this->title = Yii::t('static','Manage Clinics');
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
    'id'=>'clinic-grid',
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
        'name',
        'code',
        'active:boolean',
        array(
            'header' => Yii::t('static','Actions'),
            'headerHtmlOptions' => array('width' => '150px', 'style'=>'text-align: center'),
            'class'=>'CButtonColumn',
            'template'=>'{update} {del}',
            'buttons'=>array(
                'del'=>array(
                    'imageUrl'=>Yii::app()->theme->baseUrl.'/img/btn/delete_button.png',
                    'label'=>Yii::t('static','Delete'),
                    'url'=>'Yii::app()->createUrl("manage/clinic/delete", array("id"=>$data->id))',
                )
            ),
            'updateButtonImageUrl'=>Yii::app()->theme->baseUrl.'/img/btn/edit_button.png',
            'updateButtonLabel'=>Yii::t('static','Update'),
        ),
    ),
));
?>

