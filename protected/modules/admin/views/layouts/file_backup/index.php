<?php
$this->breadcrumbs=array(
	'Layouts',
);

$menus=array(
	array('label'=>'Create Layouts', 'url'=>array('create')),
);
$this->menu= ControllerActionsName::createMenusRoles($menus, $actions);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('layouts-grid', {
                url : $(this).attr('action'),
		data: $(this).serialize()
	});
	return false;
});
");

Yii::app()->clientScript->registerScript('ajaxupdate', "
$('#layouts-grid a.ajaxupdate').live('click', function() {
    $.fn.yiiGridView.update('layouts-grid', {
        type: 'POST',
        url: $(this).attr('href'),
        success: function() {
            $.fn.yiiGridView.update('layouts-grid');
        }
    });
    return false;
});
");
?>

<h1>List Layouts</h1>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php 
$visible = ControllerActionsName::checkVisibleButton($actions);

$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'layouts-grid',
	'dataProvider'=>$model->search(),
	//'filter'=>$model,
	'columns'=>array(
        array(
            'header' => 'S/N',
            'type' => 'raw',
            'value' => '$row+1',
            'headerHtmlOptions' => array('width' => '30px','style' => 'text-align:center;'),
            'htmlOptions' => array('style' => 'text-align:center;')
        ),
		array(
                    'name'=>'title',
                    'htmlOptions' => array('style' => 'text-align:center;'),
                ),
                array(
                    'name'=>'content',
                    'htmlOptions' => array('style' => 'text-align:center;'),
                ),
		array(
                    'header'=>'Display Order',
                    'name'=>'order',
                    'htmlOptions' => array('style' => 'text-align:center;'),
                ),
		array(
                    'header'=>'Status',
                    'name'=>'status',
                    'type'=>'status',
                    'htmlOptions' => array('style' => 'text-align:center;'),
                    'value'=>'array("status"=>$data->status,"id"=>$data->id)',
                    'visible'=>$visible,
                ),
		array(
			'class'=>'CButtonColumn',
                        'template'=> ControllerActionsName::createIndexButtonRoles($actions),
		),
	),
)); ?>
