<?php
$this->breadcrumbs=array(
	'Layouts'=>array('index'),
	$model->title=>array('view','id'=>$model->id),
	'Update',
);

$menus = array(	
        array('label'=>'Layouts Management', 'url'=>array('index')),
	array('label'=>'View Layouts', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Create Layouts', 'url'=>array('create')),	
);
$this->menu= ControllerActionsName::createMenusRoles($menus, $actions);

?>

<h1>Update Layouts <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>