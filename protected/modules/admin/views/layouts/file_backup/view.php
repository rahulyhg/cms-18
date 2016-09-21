<?php
$this->breadcrumbs=array(
	'Layouts'=>array('index'),
	$model->title,
);

$menus = array(
        array('label'=>'Index', 'url'=>array('index')),
	array('label'=>'Create Layouts', 'url'=>array('create')),
	array('label'=>'Update Layouts', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Layouts', 'url'=>array('delete'), 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
);
$this->menu= ControllerActionsName::createMenusRoles($menus, $actions);
?>

<h1>View Layouts #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'title',
		'content',
		'order',
		array(
			'name'=>'status',
                        'value'=>(!empty($model->status) && $model->status==1) ? 'Active' : 'Inactive',
		),
	),
)); ?>
