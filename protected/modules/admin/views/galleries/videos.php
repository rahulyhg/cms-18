<?php
$this->breadcrumbs = array(
	$this->pluralTitle,
);
$this->menu = array(
	array('label' => 'Create ' . $this->singleTitle, 'url' => array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.deleteall-button').click(function(){
        var atLeastOneIsChecked = $('input[name=\"gallery-grid_c0[]\"]:checked').length > 0;
        if (!atLeastOneIsChecked)
        {
                alert('Please select at least one record to delete');
        }
        else if (window.confirm('Are you sure you want to delete the selected records?'))
        {
                document.getElementById('gallery-grid-bulk').action='" . Yii::app()->createAbsoluteUrl('admin/' . Yii::app()->controller->id . '/deletevideos') . "';
                document.getElementById('gallery-grid-bulk').submit();
        }
});

");

Yii::app()->clientScript->registerScript('ajaxupdate', "
    $('#gallery-grid a.ajaxupdate').live('click', function() {
        $.fn.yiiGridView.update('gallery-grid', {
            type: 'POST',
            url: $(this).attr('href'),
            success: function() {
                $.fn.yiiGridView.update('gallery-grid');
            }
        });
        return false;
    });
");
?>
<h1><?php echo $this->pluralTitle; ?></h1>
<div class="form">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'gallery-form',
        'enableAjaxValidation' => false,
        'htmlOptions' => array('class' => 'form-horizontal', 'role' => 'form'),
    ));
    ?>
    <div class='form-group form-group-sm'>
        <?php echo $form->labelEx($modelVideo, 'title', array('class' => 'col-sm-1 control-label')); ?>
        <div class="col-sm-6">
            <?php echo $form->textField($modelVideo, 'title', array('class' => 'form-control', 'maxlength' => 50,'style'=>'width:350px;')); ?>
            <?php echo $form->error($modelVideo, 'title'); ?>
        </div>
    </div>
    <div class='form-group form-group-sm'>
        <?php echo $form->labelEx($modelVideo, 'youtubeurl', array('class' => 'col-sm-1 control-label')); ?>
        <div class="col-sm-3">
            <?php echo $form->textField($modelVideo, 'youtubeurl', array('class' => 'form-control', 'maxlength' => 50,'style'=>'width:350px;')); ?>
            <?php echo $form->error($modelVideo, 'youtubeurl'); ?>
        </div>
    </div>

    <div class='form-group form-group-sm'>
        <?php echo $form->labelEx($modelVideo, 'status', array('class' => 'col-sm-1 control-label')); ?>
        <div class="col-sm-3">
            <?php echo $form->dropDownList($modelVideo, 'status', $modelVideo->optionActive, array('class' => 'form-control','style'=>'width:350px;')); ?>
            <?php echo $form->error($modelVideo, 'status'); ?>
        </div>
    </div>

    <div class="clr"></div>
    <div class="well">
        <?php echo CHtml::htmlButton('<span class="' . $this->iconSave . '"></span> Save', array('class' => 'btn btn-primary', 'type' => 'submit')); ?> &nbsp;
    </div>
    <?php $this->endWidget(); ?>
</div>
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
			'title',
			'youtubeurl',
			array(
				'name' => 'status',
				'type' => 'status',
				'value' => 'array("id"=>$data->id,"status"=>$data->status)',
				'htmlOptions' => array('style' => 'text-align:center;')
			),
			array(
				'name' => 'created_date',
				'type' => 'date',
				'htmlOptions' => array('style' => 'text-align:center;')
			),
			array(
				'header' => 'Actions',
				'class' => 'CButtonColumn',
				'template' => '{updatevideo}{delete}',
                'buttons'=>array
                (
                    'updatevideo' => array
                    (
                        'label'=>'<span class="' . $this->iconEdit . '"> </span> ',
                        'url'=>'Yii::app()->createUrl("admin/galleries/updatevideo/", array("id"=>$data->id))',
                        'options'=>array( 'class'=>'update' ),
                    ),
                ),
			),
		));
		$form = $this->beginWidget('CActiveForm', array(
			'id' => 'gallery-grid-bulk',
			'enableAjaxValidation' => false,
			'htmlOptions' => array('enctype' => 'multipart/form-data')));

		$this->renderNotifyMessage();
		$this->renderDeleteAllButton();

		$this->widget('zii.widgets.grid.CGridView', array(
			'id' => 'gallery-grid',
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
