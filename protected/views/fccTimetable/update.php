<?php
/* @var $this FccTimetableController */
/* @var $model FccTimetable */

$this->breadcrumbs=array(
	'Fcc Timetables'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List FccTimetable', 'url'=>array('index')),
	array('label'=>'Create FccTimetable', 'url'=>array('create')),
	array('label'=>'View FccTimetable', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage FccTimetable', 'url'=>array('admin')),
);
?>

<h1>Update FccTimetable <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>