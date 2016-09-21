<?php
$this->breadcrumbs=array(
	'Event Management'=>array('index'),
	$model->title,
);

$menus = array(
	array('label'=>'Event Management', 'url'=>array('index')),
	array('label'=>'Create Event', 'url'=>array('create')),
	array('label'=>'Update Event', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Event', 'url'=>array('delete'), 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
);
$this->menu= ControllerActionsName::createMenusRoles($menus, $actions);
?>

<h1>View Event: <?php echo $model->title; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
            'title',
            array(
                'name' => 'image1',
                'type' => 'html',
                'htmlOptions' => array('style' => 'text-align:center;'),
                'value' => CHtml::image($model->getImageUrl("image1", Event::IMAGE1_WIDTH_1, Event::IMAGE1_HEIGHT_1), "image"),
            ),
            array(
                'name' => 'image2',
                'type' => 'html',
                'htmlOptions' => array('style' => 'text-align:center;'),
                'value' => CHtml::image($model->getImageUrl("image2", Event::IMAGE2_WIDTH_1, Event::IMAGE2_HEIGHT_1), "image"),
            ),
            'title_text:html',
            'left_text:html',
            'right_text:html',
            'created_date:date',
            'status:status',
	),
)); ?>
