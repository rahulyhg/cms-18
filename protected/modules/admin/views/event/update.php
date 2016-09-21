<?php
$this->breadcrumbs=array(
	Yii::t('translation','Event Management')=>array('index'),
	$model->title=>array('view','id'=>$model->id),
	Yii::t('translation','Update'),
);

$menus = array(	
    array('label'=> Yii::t('translation', 'Event Management'), 'url'=>array('index')),
	array('label'=> Yii::t('translation', 'View Event'), 'url'=>array('view', 'id'=>$model->id)),
	array('label'=> Yii::t('translation', 'Create Event'), 'url'=>array('create')),	
);
$this->menu= ControllerActionsName::createMenusRoles($menus, $actions);

?>

<h1><?php echo Yii::t('translation', 'Update Event: '.$model->title); ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>