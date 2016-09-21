<?php
/* @var $this FccTimetableController */
/* @var $model FccTimetable */

$this->breadcrumbs=array(
	'Fcc Timetables'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List FccTimetable', 'url'=>array('index')),
	array('label'=>'Create FccTimetable', 'url'=>array('create')),
	array('label'=>'Update FccTimetable', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete FccTimetable', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage FccTimetable', 'url'=>array('admin')),
);
?>

<h1>View FccTimetable #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'day',
		'time',
		'fcc_doctor_uuid',
		'uuid',
	),
)); ?>
