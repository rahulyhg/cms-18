<?php
$this->breadcrumbs = array(
    $this->pluralTitle,
);


Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('brouchures-grid', {
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
	$.fn.yiiGridView.update('brouchures-grid', {data: data});
	return false;
});

$('.deleteall-button').click(function(){
        var atLeastOneIsChecked = $('input[name=\"brouchures-grid_c0[]\"]:checked').length > 0;
        if (!atLeastOneIsChecked)
        {
                alert('Please select at least one record to delete');
        }
        else if (window.confirm('Are you sure you want to delete the selected records?'))
        {
                document.getElementById('brouchures-grid-bulk').action='" . Yii::app()->createAbsoluteUrl('admin/' . Yii::app()->controller->id . '/deleteall') . "';
                document.getElementById('brouchures-grid-bulk').submit();
        }
});

");

Yii::app()->clientScript->registerScript('ajaxupdate', "
    $('#brouchures-grid a.ajaxupdate').live('click', function() {
        $.fn.yiiGridView.update('brouchures-grid', {
            type: 'POST',
            url: $(this).attr('href'),
            success: function() {
                $.fn.yiiGridView.update('brouchures-grid');
            }
        });
        return false;
    });
");
?>

<script>
    
    $('.btn-create').live('click', function(e) {
        $.fn.yiiGridView.update('brouchures-grid', {
            type: 'POST',
            url: <?php echo json_encode(Yii::app()->createAbsoluteUrl('admin/Brouchures/create')); ?>,
            success: function() {
                $.fn.yiiGridView.update('brouchures-grid');
            }
        });
        return false;
    
    });
</script>

<div class="panel panel-default" >
    <h1 style="margin-left:10px; margin-right: 10px;"><?php echo $this->pluralTitle; ?></h1>
    <div class="form" >
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'brouchures-form',
            'enableAjaxValidation' => false,
            'htmlOptions' => array('class' => 'form-horizontal', 'role' => 'form', 'enctype' => 'multipart/form-data'),
                ));
        ?>
        <div class='form-group form-group-sm' style="margin-left:10px; margin-right: 10px;">
            <?php echo $form->labelEx($model, 'name', array('class' => 'col-sm-1 control-label')); ?>
            <div class="col-sm-3">
                <?php echo $form->textField($model, 'name', array('class' => 'form-control', 'maxlength' => 255)); ?>
                <?php echo $form->error($model, 'name'); ?>
            </div>
        </div>
        <div class='form-group form-group-sm'style="margin-left:10px; margin-right: 10px;">
            <?php echo $form->labelEx($model, 'file_name', array('class' => 'col-sm-1 control-label')); ?>
            <div class="col-sm-3">
                <?php if (!empty($model->file_name) && file_exists($model->uploadFileFolder . '/' . $model->id . '/' . $model->file_name)) {
                    ?>
                    <div id="thumb_document_file" class="thumbnail-file">
                        <div class="caption-file">
                            <a class="file-link" href="<?php echo Yii::app()->createAbsoluteUrl($model->uploadFileFolder . "/" . $model->id . "/" . $model->file_name); ?>"><?php echo $model->file_name; ?></a>
                            <p>Click on remove button to remove <?php echo $model->getAttributeLabel('file_name'); ?></p>
                            <p><a href="<?php echo $this->baseControllerIndexUrl(); ?>/removefile/fieldName/file_name/id/<?php echo $model->id; ?>" class="label label-danger removedfile" rel="tooltip" title="Remove">Remove</a>
                        </div>

                    </div><?php } ?>
                <?php echo $form->fileField($model, 'file_name', array('accept' => 'document/*', 'title' => 'Upload  ' . $model->getAttributeLabel('file_name'))); ?>
                <div class='notes'>Allow file type  <?php echo '*.' . str_replace(',', ', *.', $model->allowUploadType); ?> - Maximum file size : <?php echo ($model->maxUploadFileSize / 1024) / 1024; ?>M </div>
                <?php echo $form->error($model, 'file_name'); ?>
            </div>
        </div>
        <div class="clr"></div>
        <div class="well" style="margin-left:10px; margin-right: 10px;">
            <?php echo CHtml::htmlButton($model->isNewRecord ? '<span class="' . $this->iconCreate . '"></span> Create' : '<span class="' . $this->iconSave . '"></span> Save', array('class' => 'btn btn-primary ', 'type' => 'submit')); ?> &nbsp;  

        </div>
        <?php $this->endWidget(); ?>
    </div>
    <div class="panel-heading" style="margin-left:10px; margin-right: 10px;">
        <h3 class="panel-title"><span class="<?php echo $this->iconList; ?>"></span> Listing</h3>
    </div>
    <div class="panel-body" style="margin-left:10px; margin-right: 10px;">
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
             'name',
            'file_name',
           
            array(
                'name' => 'property_id',
                'value' => 'isset($data->property->title)?$data->property->title:""',
                'htmlOptions' => array('style' => 'text-align:right;'),
                'type' => 'raw',
            ),
            array(
                'name' => 'created_date',
                'type' => 'date',
                'htmlOptions' => array('style' => 'text-align:center;')
            ),
            array(
                'name' => 'created_by',
                'value' => 'isset($data->user->username)?$data->user->username:""',
                'htmlOptions' => array('style' => 'text-align:right;'),
                'type' => 'raw',
            ),
            array(
                'header' => 'Actions',
                'class' => 'CButtonColumn',
                'template' => '{delete}',
            ),
                ));
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'brouchures-grid-bulk',
            'enableAjaxValidation' => false,
            'htmlOptions' => array('enctype' => 'multipart/form-data')));

        $this->renderNotifyMessage();

        $this->renderDeleteAllButton();
        $this->widget('zii.widgets.grid.CGridView', array(
            'id' => 'brouchures-grid',
            'dataProvider' => $modelBrochure->search(),
            'pager' => array(
                'header' => '',
                'prevPageLabel' => 'Prev',
                'firstPageLabel' => 'First',
                'lastPageLabel' => 'Last',
                'nextPageLabel' => 'Next',
            ),
            'summaryText' => '',
            'selectableRows' => 2,
            'columns' => $columnArray,
        ));
        $this->endWidget();
        ?>