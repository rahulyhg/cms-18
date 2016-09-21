<?php$this->breadcrumbs=array(	'Event Management',);$menus=array(	array('label'=> Yii::t('translation','Create Event'), 'url'=>array('create')),);$this->menu= ControllerActionsName::createMenusRoles($menus, $actions);Yii::app()->clientScript->registerScript('search', "    $('.search-button').click(function(){        $('.search-form').toggle();        return false;    });    $('.search-form form').submit(function(){        $.fn.yiiGridView.update('event-grid', {            url : $(this).attr('action'),            data: $(this).serialize()        });        return false;    });");Yii::app()->clientScript->registerScript('ajaxupdate', "    $('#event-grid a.ajaxupdate').live('click', function() {        $.fn.yiiGridView.update('event-grid', {            type: 'POST',            url: $(this).attr('href'),            success: function() {                $.fn.yiiGridView.update('event-grid');            }        });        return false;    });");?><h1><?php echo Yii::t('translation', 'Event Management'); ?></h1><?php echo CHtml::link(Yii::t('translation','Advanced Search'),'#',array('class'=>'search-button')); ?><div class="search-form" style="display:none">    <?php $this->renderPartial('_search',array(        'model'=>$model,    )); ?></div><!-- search-form --><?php $this->widget('zii.widgets.grid.CGridView', array(	'id'=>'event-grid',	'dataProvider'=>$model->search(),	'enableSorting' => false,	//'filter'=>$model,	'columns'=>array(            array(                'header' => 'S/N',                'type' => 'raw',                'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',                'headerHtmlOptions' => array('width' => '30px','style' => 'text-align:center;'),                'htmlOptions' => array('style' => 'text-align:center;')            ),            Yii::t('translation','title'),            array(                'name' => 'image1',                'type' => 'html',                'htmlOptions' => array('style' => 'text-align:center;'),                'value' => 'CHtml::image($data->getImageUrl("image1", Event::IMAGE1_WIDTH_2, Event::IMAGE1_HEIGHT_2), "image")',            ),            array(                'name' => 'image2',                'type' => 'html',                'htmlOptions' => array('style' => 'text-align:center;'),                'value' => 'CHtml::image($data->getImageUrl("image2", Event::IMAGE2_WIDTH_2, Event::IMAGE2_HEIGHT_2), "image")',            ),            array(                'name'=>'status',                'type'=>'status',                'htmlOptions' => array('style' => 'text-align:center;'),                'value'=>'array("status"=>$data->status,"id"=>$data->id)',            ),            array(                'header' => 'Actions',                'class'=>'CButtonColumn',                'template'=> ControllerActionsName::createIndexButtonRoles($actions),            ),	),)); ?>