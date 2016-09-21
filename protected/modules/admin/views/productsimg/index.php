<?php
$this->breadcrumbs = array(
    $this->pluralTitle => array('/admin/products/'),
    'Product Photos ',
);
$this->menu = array(
	array('label' => 'Create ' . $this->singleTitle, 'url' => array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.deleteall-button').click(function(){
        var atLeastOneIsChecked = $('input[name=\"product_img-grid_c0[]\"]:checked').length > 0;
        if (!atLeastOneIsChecked)
        {
                alert('Please select at least one record to delete');
        }
        else if (window.confirm('Are you sure you want to delete the selected records?'))
        {
                document.getElementById('product_img-grid-bulk').action='" . Yii::app()->createAbsoluteUrl('admin/' . Yii::app()->controller->id . '/deleteall') . "';
                document.getElementById('product_img-grid-bulk').submit();
        }
});

");

Yii::app()->clientScript->registerScript('ajaxupdate', "
    $('#product-grid a.ajaxupdate').live('click', function() {
        $.fn.yiiGridView.update('product_img-grid', {
            type: 'POST',
            url: $(this).attr('href'),
            success: function() {
                $.fn.yiiGridView.update('product_img-grid');
            }
        });
        return false;
    });
");
?>
<h1><?php echo $this->pluralTitle; ?></h1>
<?php $this->renderNotifyMessage(); ?>
<div class="form">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'productimg-form',
        'enableAjaxValidation' => false,
        'htmlOptions' => array('class' => 'form-horizontal', 'role' => 'form', 'enctype' => 'multipart/form-data'),
    ));
    ?>
    <div class='form-group form-group-sm'>
        <div class="col-sm-3">
            <?php echo $form->fileField($modelAdd, 'product_image', array('accept' => 'image/*', 'title' => 'Upload  ' . $modelAdd->getAttributeLabel('product_image'))); ?>
            <div class='notes'>Allow file type  <?php echo '*.' . str_replace(',', ', *.', $modelAdd->allowImageType); ?> - Maximum file size : <?php echo ($modelAdd->maxImageFileSize/1024)/1024;?>M </div>
            <?php echo $form->error($modelAdd, 'product_image'); ?>
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
			array(
                'name'=>'product_image',
                'value'=>'CHtml::image(ImageHelper::getImageUrl($data, "product_image", "thumb1"),"Product Image",array("style"=>"height:60px;"))',
                'type'=>"raw",
                ),
			
			array(
				'name' => 'product_id',
				'value' => 'isset($data->Product->title)?$data->Product->title:""',
				'htmlOptions' => array('style' => 'text-align:left;')
			),
			array(
				'name' => 'created_date',
				'type' => 'date',
				'htmlOptions' => array('style' => 'text-align:center;')
			),
			
			array(
				'header' => 'Actions',
				'class' => 'CButtonColumn',
				'template' => '{delete}',
			),
		));
		$form = $this->beginWidget('CActiveForm', array(
			'id' => 'product_img-grid-bulk',
			'enableAjaxValidation' => false,
			'htmlOptions' => array('enctype' => 'multipart/form-data')));

		$this->renderNotifyMessage();
		$this->renderDeleteAllButton();
        echo CHtml::hiddenField('returnUrl' , 'index/id/'.$_GET['id'], array('id' => 'returnUrl'));
		$this->widget('zii.widgets.grid.CGridView', array(
			'id' => 'product_img-grid',
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
