<div class="title">My Appointment</div>

<div class="responsive_table">
<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'myappointment-grid',
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
        array(
            'header' => 'Doctor',
            'type' => 'raw',
            'value'=> '$data->timeslot->doctor->fullname',
            'htmlOptions' => array('style' => 'text-align:left;')
        ),
        'patient_name',
        'patient_ncic',
        array(
            'header' => 'Contact',
            'type' => 'raw',
            'value'=> '$data->patient_contact',
            'htmlOptions' => array('style' => 'text-align:left;')
        ),
        array(
            'name' => 'created_date',
            'type' => 'raw',
            'value'=> 'date("d/m/Y h:i a",strtotime($data->created_date))',
            'htmlOptions' => array('style' => 'text-align:left;')
        ),
        array(
            'header' => 'Appointment date',
            'type' => 'raw',
            'value'=> 'date("d/m/Y h:i a",strtotime($data->timeslot->appointment_date))',
            'htmlOptions' => array('style' => 'text-align:left;')
        ),
        array(
            'header' => Yii::t('static','Actions'),
            'headerHtmlOptions' => array('width' => '150px', 'style'=>'text-align: center'),
            'class'=>'CButtonColumn',
            'template'=>'{appointmentDetail}&nbsp;&nbsp;&nbsp;{cancelAppointment}',
            'buttons'=>array(
            	'appointmentDetail'=>array(
                    'imageUrl'=>Yii::app()->theme->baseUrl.'/img/appointment-detail-icon.png',
                    'label'=>Yii::t('static','View this appointment'),
                    'url'=>'Yii::app()->createUrl("/site/viewBooking", array("id"=>$data->id))',
                    'options'=>array('target'=>'_blank'),
                ),
                'cancelAppointment'=>array(
                    'imageUrl'=>Yii::app()->theme->baseUrl.'/img/appointment-delete-icon.png',
                    'label'=>Yii::t('static','Cancel this appointment'),
                    'url'=>'Yii::app()->createUrl("/site/cancelBooking", array("id"=>$data->id))',
                )
            ),
        ),
    ),
));
?>
</div>