<?php
$this->breadcrumbs=array(
    Yii::t('static', 'Doctor Timeslot Template'),
);

$this->menu=array(
    // array('label'=>Yii::t('static', 'Add Time Table'), 'url'=>'javascript:void(0)', 'class'=>'btn-1 add-time'),
    // array('label' => Yii::t('static', 'Log out'), 'url' => array('/site/logout'), 'class' => 'btn-1'),
    array('label' => Yii::t('static', 'Previous Page'), 'url' => 'javascript:history.go(-1)', 'class' => 'btn-1'),
);


$this->title = Yii::t('static', 'Doctor Timeslot Template');
?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'doctor-grid',
    'dataProvider'=>$model->search(),
    'emptyText'=>Yii::t('static', 'No records found.'),
    'enableSorting'=>false,
    'itemsCssClass'=>'table table-striped table-hover',
    'summaryText'=>Yii::t('static', 'Displaying {start}-{end} of {count} result.'),
    'columns'=>array(
        array(
            'header' => Yii::t('static', 'S/N'),
            'type' => 'raw',
            'value' => '$row+1',
            'headerHtmlOptions' => array('width' => '30px'),
            'htmlOptions' => array('style' => 'text-align:center;')
        ),
        'fullname',
        array(
            'header' => Yii::t('static','Timeslot Template'),
            'headerHtmlOptions' => array('width' => '150px', 'style'=>'text-align: center'),
            'class'=>'CButtonColumn',
            'template'=>'{timeslot}',
            'buttons'=>array(
                'timeslot'=>array(
                    'imageUrl'=>Yii::app()->theme->baseUrl.'/img/btn/calendar_button.png',
                    'label'=>Yii::t('static','View Timeslot Template'),
                    'url'=>'Yii::app()->createUrl("onlineTimeslot/edittimeslot", array("doctor_id"=>$data->id))',
                    'options'=>array('target'=>'_blank'),
                )
            ),
        ),
    ),
));
?>

