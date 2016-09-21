<?php
$this->breadcrumbs=array(
	'Controllers'=>array('index'),
	$model->id,
);

$this->menu = array(	
	array('label' => $this->pluralTitle, 'url' => array('index'), 'icon' => $this->iconList),
	array('label' => 'Update ' . $this->singleTitle, 'url' => array('upldate', 'id' => $model->id)),	
	array('label' => 'Create ' . $this->singleTitle, 'url' => array('create')),
);
?>

<h1>View Controllers #<?php echo $model->controller_name; ?></h1>
<?php echo $this->renderControlNav();?>
<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(		
		'controller_name',
		'module_name',
		'actions',
	),
)); ?>
