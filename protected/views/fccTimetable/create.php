<?php
/* @var $this FccTimetableController */
/* @var $model FccTimetable */

$this->breadcrumbs=array(
	'Fcc Timetables'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List FccTimetable', 'url'=>array('index')),
	array('label'=>'Manage FccTimetable', 'url'=>array('admin')),
);
?>

<h1>Create FccTimetable</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>