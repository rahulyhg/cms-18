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
	$.fn.yiiGridView.update('valuationrequests-grid', {
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
	$.fn.yiiGridView.update('valuationrequests-grid', {data: data});
	return false;
});

$('.deleteall-button').click(function(){
        var atLeastOneIsChecked = $('input[name=\"valuationrequests-grid_c0[]\"]:checked').length > 0;
        if (!atLeastOneIsChecked)
        {
                alert('Please select at least one record to delete');
        }
        else if (window.confirm('Are you sure you want to delete the selected records?'))
        {
                document.getElementById('valuationrequests-grid-bulk').action='" . Yii::app()->createAbsoluteUrl('admin/' . Yii::app()->controller->id . '/deleteall') . "';
                document.getElementById('valuationrequests-grid-bulk').submit();
        }
});

");

Yii::app()->clientScript->registerScript('ajaxupdate', "
    $('#valuationrequests-grid a.ajaxupdate').live('click', function() {
        $.fn.yiiGridView.update('valuationrequests-grid', {
            type: 'POST',
            url: $(this).attr('href'),
            success: function() {
                $.fn.yiiGridView.update('valuationrequests-grid');
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

<?php //echo $this->renderControlNav(); ?>
<div class="navbar-right">
    <div class="btn-group btn-group-sm">
        <form  name="form-export" action="<?php echo Yii::app()->createAbsoluteUrl('/admin/Valuationrequests/export') ?>" method="post">
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
        
       Yii::app()->session['export_equest']=$model->search();
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
                'name' => 'property_adress',
                'value'=>'isset($data->property_adress)?$data->property_adress:"General"',
                'htmlOptions' => array('style' => 'text-align:right;'),
                'type'=>'raw',
            ),
           
            array(
                'name' => 'type_id',
                'value'=>'isset($data->propertytype->property_type)?$data->propertytype->property_type:""',
                'htmlOptions' => array('style' => 'text-align:right;'),
                'type'=>'raw',
            ),
           
            
            'owner_name',
            'owner_mobile',
            'owner_email',
            array(
                'name' => 'pes',
                'value'=>'($data->pes==1)?"Yes":"No"',
                'htmlOptions' => array('style' => 'text-align:right;'),
                'type'=>'raw',
            ),
            array(
                'name' => 'created_date',
                'type' => 'date',
                'htmlOptions' => array('style' => 'text-align:center;')
            ),
            array(
                'header' => 'Actions',
                'class' => 'CButtonColumn',
                'template' => '{view}{delete}',
            ),
                ));
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'valuationrequests-grid-bulk',
            'enableAjaxValidation' => false,
            'htmlOptions' => array('enctype' => 'multipart/form-data')));

        $this->renderNotifyMessage();
        $this->renderDeleteAllButton();

        $this->widget('zii.widgets.grid.CGridView', array(
            'id' => 'valuationrequests-grid',
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
        <!--'buttons' => array(
                                                                                'delete' => array('visible' => '!in_array(\$data->id, array(' . implode(',', \$this->cannotDelete) . '))'),
                                                                                'update' => array('visible' => 'strpos('" . strtolower(implode(',', $actions)) . "', 'update') !== false'),
                                                                                'view' => array('visible' => 'strpos('" . strtolower(implode(',', $actions)) . "', 'view'') !== false')
                                                                                ),-->