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
	$.fn.yiiGridView.update('product-grid', {
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
	$.fn.yiiGridView.update('priceList-grid', {data: data});
	return false;
});

$('.deleteall-button').click(function(){
        var atLeastOneIsChecked = $('input[name=\"product-grid_c0[]\"]:checked').length > 0;
        if (!atLeastOneIsChecked)
        {
                alert('Please select at least one record to delete');
        }
        else if (window.confirm('Are you sure you want to delete the selected records?'))
        {
                document.getElementById('product-grid-bulk').action='" . Yii::app()->createAbsoluteUrl('admin/' . Yii::app()->controller->id . '/deleteall') . "';
                document.getElementById('product-grid-bulk').submit();
        }
});

    $('.btn-status').click(function(){
        var data = $(this).attr('data-status');
        var text = 'Are you sure you want to Inactive the selected records?';
        if(data == 0) {
            text = 'Are you sure you want to Active the selected records?';
        }
        if (window.confirm(text))
        {
               $.fn.yiiGridView.update('priceList-grid', {
                type: 'POST',
                url: $(this).attr('href'),
                success: function() {
                     $.fn.yiiGridView.update('priceList-grid');
                     location.href = location.href;
                }
                });
                return false;
        }
        
        return false;
});


 $('.delete-data').click(function(){
        var text = 'Are you sure you want to delete item?';
        if( $(this).attr('status') == -1) {
            text = 'Are you sure you want to recover item?';
        }
      
        if (window.confirm(text))
        {
               $.fn.yiiGridView.update('priceList-grid', {
                type: 'POST',
                url: $(this).attr('href'),
                success: function() {
                    $.fn.yiiGridView.update('priceList-grid');
                    location.href = location.href;
                }
                });
                return false;
        }
        
        return false;
});

");
?>

<div class="box-1">
    <div class="title-box clearfix">
        <h2 class="title"><?php echo Yii::t('static', 'PRICE LIST') ?></h2>
<?php echo CHtml::link(Yii::t('static', '<span class="glyphicon glyphicon-plus"></span> Add New Price List'), array('/serviceList/create'), array('class' => 'btn-1 pull-right ')); ?>
    </div>

    <div class=" box-body form-horizontal">
        <div class="row clearfix">
            <div class="col-md-12">
                <div class="col-md-12">
                    <p class="pull-right">
                        <a href="<?php echo Yii::app()->createAbsoluteUrl('/serviceList/index', array('status' => 1)); ?>"> <?php if ($status == 1) echo '<b>Active</b>';
else echo 'Active'; ?> </a>|
                        <a href="<?php echo Yii::app()->createAbsoluteUrl('/serviceList/index', array('status' => 0)); ?>"> <?php if ($status == 0) echo '<b>Inactive</b>';
else echo 'Inactive'; ?> </a> |
                        <a href="<?php echo Yii::app()->createAbsoluteUrl('/serviceList/index', array('status' => -1)); ?>"> <?php if ($status == -1) echo '<b>Deleted</b>';
else echo 'Deleted'; ?> </a>
                    </p>
                </div>

                <div class="table-responsive">


                    <?php
                    //Yii::app()->clientScript;
                    $delete = '<i class="glyphicon glyphicon-remove"> </i>';
                    if ($status == -1) {
                        $delete = '<i class="glyphicon glyphicon-ok"> </i>';
                    }
                    $columnArray = array();
                    $columnArray = array_merge($columnArray, array(
                        array(
                            'header' => 'S/N',
                            'type' => 'raw',
                            'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
                            'headerHtmlOptions' => array('width' => '5%', 'style' => 'text-align:center;'),
                            'htmlOptions' => array('style' => 'text-align:center;')
                        ),
                        'name',
                        array(
                            'name' => 'clinic_price',
                            'type' => "prices",
                             'filter' => false
                        ),
                        array(
                            'name' => 'insurance_price',
                            'type' => "prices",
                             'filter' => false
                        ),
                        array(
                            'name' => 'ctr_price',
                            'type' => "prices",
                             'filter' => false
                        ),
                        array(
                            'name' => 'new_price',
                            'type' => "prices",
                             'filter' => false
                        ),
                        array(
                            'name' => 'status',
                            'value' => '$data->id',
                            'type' => "statusPriceList",
                            'filter' => false
                        ),
                        array(
                            'header' => 'Actions',
                            'class' => 'CButtonColumn',
                            'htmlOptions' => array(
                                'style' => 'width:6%',
                            ),
                            'template' => '{views} {updates} {deletes}',
                            'buttons' => array(
                                'views' => array(
                                    'url' => 'Yii::app()->createAbsoluteUrl("/serviceList/view",array("id"=>$data->id))',
                                    'options' => array('title' => 'View'),
                                    'label' => '<i class="glyphicon glyphicon-eye-open"> </i>',
                                ),
                                'updates' => array(
                                    'url' => 'Yii::app()->createAbsoluteUrl("/serviceList/update",array("id"=>$data->id))',
                                    'options' => array('title' => 'Update'),
                                    'label' => '<i class="glyphicon glyphicon-pencil"> </i>',
                                ),
                                'deletes' => array(
                                    'url' => 'Yii::app()->createAbsoluteUrl("/serviceList/delete",array("id"=>$data->id))',
                                    'options' => array(
                                        'title' => $status != -1?'Delete':'Recover',
                                        'class' => 'delete-data',
                                        'status' => $status
                                    ),
                                    'label' => $delete
                                ),
                            )
                        ),
                    ));




                    $this->widget('zii.widgets.grid.CGridView', array(
                        'id' => 'priceList-grid',
                        'dataProvider' => $model->search($status),
                        'pager' => array(
                            'header' => '',
                            'prevPageLabel' => 'Prev',
                            'firstPageLabel' => 'First',
                            'lastPageLabel' => 'Last',
                            'nextPageLabel' => 'Next',
                            'htmlOptions' => array('class' => 'pagination'),
                        ),
                        'selectableRows' => 2,
                        'columns' => $columnArray,
                    ));
                    ?>
                </div>

            </div>
        </div>
    </div>
</div>