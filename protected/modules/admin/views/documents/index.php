<?php
$this->breadcrumbs = array(
	$this->pluralTitle,
);
$this->menu = array(
	array('label' => 'Create ' . $this->singleTitle, 'url' => array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('document-grid', {
                url : $(this).attr('action'),
		data: $(this).serialize()
	});
	return false;
});

$('#clearsearch').click(function(){
	var id='search-form';
	var inputSelector='#'+id+' input, '+'#'+id+' select';
	$(inputSelector).each( function(i,o) {
		 $(o).val('');
	});
	var data=$.param($(inputSelector));
	$.fn.yiiGridView.update('document-grid', {data: data});
	return false;
});

$('.deleteall-button').click(function(){
        var atLeastOneIsChecked = $('input[name=\"document-grid_c0[]\"]:checked').length > 0;
        if (!atLeastOneIsChecked)
        {
                alert('Please select at least one record to delete');
        }
        else if (window.confirm('Are you sure you want to delete the selected records?'))
        {
                document.getElementById('document-grid-bulk').action='" . Yii::app()->createAbsoluteUrl('admin/' . Yii::app()->controller->id . '/deleteall') . "';
                document.getElementById('document-grid-bulk').submit();
        }
});

");

Yii::app()->clientScript->registerScript('ajaxupdate', "
    $('#document-grid a.ajaxupdate').live('click', function() {
        $.fn.yiiGridView.update('document-grid', {
            type: 'POST',
            url: $(this).attr('href'),
            success: function() {
                $.fn.yiiGridView.update('document-grid');
            }
        });
        return false;
    });
");
?>
<h1><?php echo $this->pluralTitle; ?></h1>
<?php echo CHtml::link(Yii::t('translation', 'Advanced Search'), '#', array('class' => 'search-button')); ?>
<div class='search-form' style='display:none'>
	<?php
	$this->renderPartial('_search', array(
		'model' => $model,
	));
	?></div>

<?php echo $this->renderControlNav(); ?>
<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title"><span class="<?php echo $this->iconList; ?>"></span> Listing</h3>
	</div>
	<div class="panel-body">
		<?php
		$allowAction = in_array("delete", $this->listActionsCanAccess) ? 'CCheckBoxColumn' : '';
		$columnArray = array();
		if (in_array("Delete", $this->listActionsCanAccess))
		{
			$columnArray[] = array(
				'value' => '$data->id',
				'class' => "CCheckBoxColumn",
			);
		}
		$columnArray = array_merge($columnArray, array(
			array(
				'header' => 'S/N',
				'type' => 'raw',
				'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
				'headerHtmlOptions' => array('width' => '30px', 'style' => 'text-align:center;'),
				'htmlOptions' => array('style' => 'text-align:center;')
			),
			'document_name',
			'document_file',
			array(
				'name' => 'created_date',
				'type' => 'date',
				'htmlOptions' => array('style' => 'text-align:center;')
			),
			array(
				'name' => 'required_login',
				'htmlOptions' => array('style' => 'text-align:right;'),
				'value' => '$data->required_login == 1 ? "Yes" : "No"',
			),
            array(
				'name' => 'for_user_id',
				'htmlOptions' => array('style' => 'text-align:right;'),
				'value' => '!empty($data->user)? $data->user->username : ""',
			),
			array(
				'name' => 'status',
				'type' => 'status',
				'value' => 'array("id"=>$data->id,"status"=>$data->status)',
				'htmlOptions' => array('style' => 'text-align:center;')
			),
			array(
				'header' => 'Actions',
				'class' => 'CButtonColumn',
				'template' => '{view}{update}{delete}',
				'buttons' => array(
					'delete' => array('visible' => '!in_array($data->id, array(' . implode(',', $this->cannotDelete) . '))'),
					'update' => array('visible' => 'strpos("' . strtolower(implode(',', $actions)) . '", "update") !== false'),
					'view' => array('visible' => 'strpos("' . strtolower(implode(',', $actions)) . '", "view") !== false')
				),
			),
		));

		$form = $this->beginWidget('CActiveForm', array(
			'id' => 'document-grid-bulk',
			'enableAjaxValidation' => false,
			'htmlOptions' => array('enctype' => 'multipart/form-data')));

		$this->renderNotifyMessage();
		$this->renderDeleteAllButton();

		$this->widget('zii.widgets.grid.CGridView', array(
			'id' => 'document-grid',
			'dataProvider' => $model->search(),
			'pager' => array(
				'header' => '',
				'prevPageLabel' => 'Prev',
				'firstPageLabel' => 'First',
				'lastPageLabel' => 'Last',
				'nextPageLabel' => 'Next',
			),
			'selectableRows' => 2,
			'columns' => $columnArray,
		));
		$this->endWidget();
		?>
