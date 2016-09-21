
<?php
$this->setExport($model->search()->data);
$this->breadcrumbs = array(
    $this->pluralTitle,
);
$this->menu = array(
    array('label' => 'Export ' . $this->singleTitle, 'url' => array('export')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('propertysearch-grid', {
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
	$.fn.yiiGridView.update('propertysearch-grid', {data: data});
	return false;
});

$('.deleteall-button').click(function(){
        var atLeastOneIsChecked = $('input[name=\"propertysearch-grid_c0[]\"]:checked').length > 0;
        if (!atLeastOneIsChecked)
        {
                alert('Please select at least one record to delete');
        }
        else if (window.confirm('Are you sure you want to delete the selected records?'))
        {
                document.getElementById('propertysearch-grid-bulk').action='" . Yii::app()->createAbsoluteUrl('admin/' . Yii::app()->controller->id . '/deleteall') . "';
                document.getElementById('propertysearch-grid-bulk').submit();
        }
});

");

Yii::app()->clientScript->registerScript('ajaxupdate', "
    $('#propertysearch-grid a.ajaxupdate').live('click', function() {
        $.fn.yiiGridView.update('propertysearch-grid', {
            type: 'POST',
            url: $(this).attr('href'),
            success: function() {
                $.fn.yiiGridView.update('propertysearch-grid');
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
<div class="navbar-right">
    <div class="btn-group btn-group-sm">
        <form  name="form-export" action="<?php echo Yii::app()->createAbsoluteUrl('/admin/propertysearchs/export') ?>" method="post">
            <button class="btn" type="submit">Export</button>
        </form>
    </div>
</div>
<div class="clr"></div>
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><span class="<?php echo $this->iconList; ?>"></span> Listing</h3>
    </div>
    <div class="panel-body">
        <?php
        Yii::app()->session['export_search'] = $model->search();
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
                'name' => 'property_id',
                'value'=>'isset($data->properties->title)?$data->properties->title:"General"',
                'htmlOptions' => array('style' => 'text-align:right;'),
                'type'=>'raw',
            ),
            array(
                'name' => 'type_id',
                'value' => 'isset($data->propertytype->property_type)?$data->propertytype->property_type:""',
                'htmlOptions' => array('style' => 'text-align:right;'),
                'type' => 'raw',
            ),
            array(
                'header' => "No. of bedrooms",
                'value' => '($data->min_bedroom && $data->max_bedroom)?$data->min_bedroom . " - " . $data->max_bedroom:""',
                'htmlOptions' => array('style' => 'text-align:right;'),
            ),
            array(
                'name' => 'tenure_id',
                'value' => 'isset($data->tenures->name)?$data->tenures->name:""',
                'htmlOptions' => array('style' => 'text-align:right;'),
                'type' => 'raw',
            ),
            'location',
            'minimun_size',
            'budget',
            'name',
            'mobile',
            'email',
              
            array(
                'header' => 'Actions',
                'class' => 'CButtonColumn',
                'template' => '{view}{delete}',
            ),
                ));
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'propertysearch-grid-bulk',
            'enableAjaxValidation' => false,
            'htmlOptions' => array('enctype' => 'multipart/form-data')));

        $this->renderNotifyMessage();
        $this->renderDeleteAllButton();

        $this->widget('zii.widgets.grid.CGridView', array(
            'id' => 'propertysearch-grid',
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
      