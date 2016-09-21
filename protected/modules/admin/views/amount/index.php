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
	$.fn.yiiGridView.update('payment-amount-grid', {
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
	$.fn.yiiGridView.update('payment-amount-grid', {data: data});
	return false;
});

$('.deleteall-button').click(function(){
        var atLeastOneIsChecked = $('input[name=\"payment-amount-grid_c0[]\"]:checked').length > 0;
        if (!atLeastOneIsChecked)
        {
                alert('Please select at least one record to delete');
        }
        else if (window.confirm('Are you sure you want to delete the selected records?'))
        {
                document.getElementById('payment-amount-grid-bulk').action='" . Yii::app()->createAbsoluteUrl('admin/' . Yii::app()->controller->id . '/deleteall') . "';
                document.getElementById('payment-amount-grid-bulk').submit();
        }
});

");

Yii::app()->clientScript->registerScript('ajaxupdate', "
    $('#payment-amount-grid a.ajaxupdate').live('click', function() {
        $.fn.yiiGridView.update('payment-amount-grid', {
            type: 'POST',
            url: $(this).attr('href'),
            success: function() {
                $.fn.yiiGridView.update('payment-amount-grid');
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


<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><span class="<?php echo $this->iconList; ?>"></span> Listing</h3>
    </div>
    <div class="panel-body">
        <?php
        $allowAction = in_array("delete", $this->listActionsCanAccess) ? 'CCheckBoxColumn' : '';
        $columnArray = array();
        if (in_array("Delete", $this->listActionsCanAccess)) {
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
        'name' => 'amount_pay',
        'htmlOptions' => array('style' => 'text-align:right;'),
        'type' => 'prices'
        ),
        'no_receipt',
        array(
        'header' =>'Invoice No',
        'name' => 'payment_id',
        'htmlOptions' => array('style' => 'text-align:right;'),
        'value' => '$data->Payments? $data->Payments->invoice_no : ""'
        ),
        array(
        'name' => 'pay_type',
        'htmlOptions' => array('style' => 'text-align:right;'),
        'type' =>'model'
        ),
        array(
        'name' => 'created',
        'htmlOptions' => array('style' => 'text-align:right;'),
        'value' =>'date("d/m/Y",$data->created)'
        ),
       
        ));
			$form=$this->beginWidget('CActiveForm', array(
			'id'=>'payment-amount-grid-bulk',
			'enableAjaxValidation'=>false,
			'htmlOptions'=>array('enctype' => 'multipart/form-data')));

			$this->renderNotifyMessage(); 
			
			
			$this->widget('zii.widgets.grid.CGridView', array(
				'id'=>'payment-amount-grid',
				'dataProvider'=>$model->searchBE(),
				'pager'=>array(
							'header'         => '',
							'prevPageLabel'  => 'Prev',
							'firstPageLabel' => 'First',
							'lastPageLabel'  => 'Last',
							'nextPageLabel'  => 'Next',
						),
				'selectableRows'=>2,
				'columns'=>$columnArray,
		)); 
		$this->endWidget();
		?>
