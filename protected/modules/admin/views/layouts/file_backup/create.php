<?php
$this->breadcrumbs=array(
	'Layouts'=>array('index'),
	'Create',
);

$menus = array(		
        array('label'=>'Layouts Management', 'url'=>array('index')),
);
$this->menu= ControllerActionsName::createMenusRoles($menus, $actions);
?>

<h1>Create Layouts</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>