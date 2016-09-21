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
	$.fn.yiiGridView.update('Properties-grid', {
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
	$.fn.yiiGridView.update('Properties-grid', {data: data});
	return false;
});

$('.deleteall-button').click(function(){
        var atLeastOneIsChecked = $('input[name=\"Properties-grid_c0[]\"]:checked').length > 0;
        if (!atLeastOneIsChecked)
        {
                alert('Please select at least one record to delete');
        }
        else if (window.confirm('Are you sure you want to delete the selected records?'))
        {
                document.getElementById('Properties-grid-bulk').action='" . Yii::app()->createAbsoluteUrl('admin/' . Yii::app()->controller->id . '/deleteall') . "';
                document.getElementById('Properties-grid-bulk').submit();
        }
});

");

Yii::app()->clientScript->registerScript('ajaxupdate', "
    $('#Properties-grid a.ajaxupdate').live('click', function() {
        $.fn.yiiGridView.update('Properties-grid', {
            type: 'POST',
            url: $(this).attr('href'),
            success: function() {
                $.fn.yiiGridView.update('Properties-grid');
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
            'title',
            array(
                'name' => 'type_id',
                'value' => 'isset($data->propertytype->property_type)?$data->propertytype->property_type:""',
                'htmlOptions' => array('style' => 'text-align:left;'),
                'type' => 'raw',
            ),
            'address',
            array(
                'name' => 'district_id',
                'value' => 'isset($data->district->district_name)?$data->district->district_name:""',
                'htmlOptions' => array('style' => 'text-align:left;'),
                'type' => 'raw',
            ),
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
                'htmlOptions' => array('style' => 'width:107px;'),
                'template' => '{view}{update}{delete}{brouchures}{banner}{download}',
                'buttons' => array(
                    'delete' => array('visible' => '!in_array($data->id, array(' . implode(',', $this->cannotDetele) . '))'),
                    'brouchures' => array( 
                        'label' => 'Show Items',
                        'url' => 'CHtml::normalizeUrl(array("brouchures/brochure/property_id/". $data->id));', // My ajax url
                        'imageUrl' => Yii::app()->theme->baseUrl . "/admin/images/icon_documents.gif",
                        'click' => 'function(e) {
                                      $("#ajaxModal").remove();
                                      e.preventDefault();
                                      var $this = $(this)
                                        , $remote = $this.data("remote") || $this.attr("href")
                                        , $modal = $("<div class=\'modal\' id=\'ajaxModal\'><div class=\'modal-body\'><h5 align=\'center\'> <img src=\'' . Yii::app()->theme->baseUrl . '/admin/images/ajax-loader.gif\'>&nbsp;  Please Wait .. </h5></div></div>");
                                      $("body").append($modal);
                                      $modal.modal({backdrop: "static", keyboard: false});
                                      $modal.load($remote);
                                    }',
                        'options' => array('data-toggle' => 'ajaxModal','style' => 'padding:4px;'),
                        ),
                    'banner' => array( 
                        'label' => 'Show all banners',
                        'url' => 'CHtml::normalizeUrl(array("propertybanners/propertybanner/property_id/". $data->id));', // My ajax url
                        'imageUrl' => Yii::app()->theme->baseUrl . "/admin/images/view_gallery.png",
                        'click' => 'function(e) {
                                      $("#ajaxModal").remove();
                                      e.preventDefault();
                                      var $this = $(this)
                                        , $remote = $this.data("remote") || $this.attr("href")
                                        , $modal = $("<div class=\'modal\' id=\'ajaxModal\'><div class=\'modal-body\'><h5 align=\'center\'> <img src=\'' . Yii::app()->theme->baseUrl . '/admin/images/ajax-loader.gif\'>&nbsp;  Please Wait .. </h5></div></div>");
                                      $("body").append($modal);
                                      $modal.modal({backdrop: "static", keyboard: false});
                                      $modal.load($remote);
                                    }',
                        'options' => array('data-toggle' => 'ajaxModal','style' => 'padding:4px;'),
                        ),
                    'download' => array(
                        'label' => 'Brouchure download tracking',
                        'url' => 'CHtml::normalizeUrl(array("brouchuredownloads/index/property_id/". $data->id));', // My ajax url
                        'imageUrl' => Yii::app()->theme->baseUrl . "/admin/images/stats_history.gif",
                        'options' => array('target' => '_blank')
                    )
                ),
            ),
                ));
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'Properties-grid-bulk',
            'enableAjaxValidation' => false,
            'htmlOptions' => array('enctype' => 'multipart/form-data')));

        $this->renderNotifyMessage();
        $this->renderDeleteAllButton();

        $this->widget('zii.widgets.grid.CGridView', array(
            'id' => 'Properties-grid',
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
