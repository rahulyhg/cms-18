<?php
$this->breadcrumbs=array(
	$this->pluralTitle,
);
$this->menu=array(
	array('label'=>'Create ' . $this->singleTitle, 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('patient-grid', {
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
	$.fn.yiiGridView.update('patient-grid', {data: data});
	return false;
});

$('.deleteall-button').click(function(){
        var atLeastOneIsChecked = $('input[name=\"patient-grid_c0[]\"]:checked').length > 0;
        if (!atLeastOneIsChecked)
        {
                alert('Please select at least one record to delete');
        }
        else if (window.confirm('Are you sure you want to delete the selected records?'))
        {
                document.getElementById('patient-grid-bulk').action='" . Yii::app()->createAbsoluteUrl('admin/' . Yii::app()->controller->id  . '/deleteall') . "';
                document.getElementById('patient-grid-bulk').submit();
        }
});

");

Yii::app()->clientScript->registerScript('ajaxupdate', "
    $('#patient-grid a.ajaxupdate').live('click', function() {
        $.fn.yiiGridView.update('patient-grid', {
            type: 'POST',
            url: $(this).attr('href'),
            success: function() {
                $.fn.yiiGridView.update('patient-grid');
            }
        });
        return false;
    });
");
?>
<h1><?php echo $this->pluralTitle; ?></h1>
<?php //echo CHtml::link(Yii::t('translation','Advanced Search'),'#',array('class'=>'search-button')); ?>
<div class='search-form' style='display:none'>
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?></div>

<?php echo $this->renderControlNav();?>
<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title"><span class="<?php echo $this->iconList; ?>"></span> Listing</h3>
	</div>
	<div class="panel-body">
		<?php 
			$allowAction = in_array("delete", $this->listActionsCanAccess)?'CCheckBoxColumn':'';
			$columnArray = array(
				array(
							'header' => 'S/N',
							'type' => 'raw',
							'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
							'headerHtmlOptions' => array('width' => '30px','style' => 'text-align:center;'),
							'htmlOptions' => array('style' => 'text-align:center;')
						),
	'name',
	'identity',
	'contact_no',
	array(
          'header' => 'Speaks',
          'type' => 'languagename',
          'value' => '$data->id',
          'htmlOptions' => array('class' => 'clickable', 'style' => 'text-align:left;width: 10%')
          ),array(
          'header' => 'Date of birth',
          'type' => 'date',
          'value' => '$data->dob',
          'htmlOptions' => array('class' => 'clickable', 'style' => 'text-align:left;width: 10%')
          ),
        array(
          'name' => 'gender',
          'value' => '$data->gender',
          'htmlOptions' => array('class' => 'clickable', 'style' => 'text-align:left;width: 5%')
          ),
        array(
          'header' => 'Address',
          'type' => 'address',
          'value' => '$data',
          'htmlOptions' => array('class' => 'clickable', 'style' => 'text-align:left;width: 13%')
          ),
        array(
          'name' => 'important_comment_to_notes',
          'type' => 'html',
          'value' => 'nl2br($data->important_comment_to_notes)',
          'htmlOptions' => array('class' => 'clickable', 'style' => 'text-align:left;width: 22%')
          ),
	array(
							'header' => 'Actions',
							'class'=>'CButtonColumn',
							'template'=> '{view}{update}',
							'buttons' => array(
								'view' => array(
                                    'label'=>'View patient',     //Text label of the button.
                                    'url'=> 'Yii::app()->createAbsoluteUrl("admin/patients/detail", array("patient_id" => $data->id))',
                                )
							)
						)
			);

			$form=$this->beginWidget('CActiveForm', array(
			'id'=>'patient-grid-bulk',
			'enableAjaxValidation'=>false,
			'htmlOptions'=>array('enctype' => 'multipart/form-data')));

			$this->renderNotifyMessage(); 
			        
			$this->widget('zii.widgets.grid.CGridView', array(
				'id'=>'patient-grid',
				'dataProvider'=>$model->search(),
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
