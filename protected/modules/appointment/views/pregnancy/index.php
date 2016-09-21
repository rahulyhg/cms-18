<?php
$this->title = Yii::t('static', 'Book FCC Appointments');

$this->menu = array(
    array('label' => Yii::t('static', 'Previous Page'), 'url' => 'javascript:history.go(-1)', 'class' => 'btn-1'),
    array('label' => Yii::t('static', 'EDD Calendar'), 'url' => array('/appointment/pregnancy/edd'), 'class' => 'btn-1'),
    array('label' => Yii::t('static', 'Book FCC Appointment'), 'url' => array('/appointment/pregnancy/book'), 'class' => 'btn-1'),
);

?>
<?php if (Yii::app()->user->hasFlash('error')): ?>
    <div class="alert alert-danger">
        <?php echo Yii::app()->user->getFlash('error'); ?>
    </div>
<?php endif; ?>
<?php if (Yii::app()->user->hasFlash('message')): ?>
    <div class="alert alert-success">
        <?php echo Yii::app()->user->getFlash('message'); ?>
    </div>
<?php endif; ?>
<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'booking-grid',
    'dataProvider' => $model->search(),
    'emptyText' => Yii::t('static', 'No records found.'),
    'enableSorting' => false,
    'itemsCssClass' => 'table table-striped table-hover',
    'summaryText' => Yii::t('static', 'Displaying {start}-{end} of {count} result.'),
    'afterAjaxUpdate' => "fancyBoxLink",
    'columns' => array(
        array(
            'header' => Yii::t('static', 'S<br>/<Br>N'),
            'type' => 'raw',
            'value' => '$row+1',
            'headerHtmlOptions' => array('width' => '30px'),
            'htmlOptions' => array('style' => 'text-align:center;')
        ),
        array(
            'header' => 'Patient Name<br/>ID<br/>Date of Birth <Br> Age<br/>Mobile Number',
            'type' => 'raw',
            'value' => '$data->bookingData->patient_name ."<br/>". $data->bookingData->patient_ncic ."<br/>". date("d/m/Y",strtotime($data->bookingData->dob))."<br>". $data->calculateAge() . "year" ."<br/>". $data->getContact()',
            'htmlOptions' => array('style' => 'text-align:left; width:150px;', 'class' => 'viewBookingPopup')
        ),
        array(
            'header' => 'FCC<br>Doctor',
            'type' => 'raw',
            'value' => '$data->doctorName',
            'htmlOptions' => array('style' => 'text-align:left;width:100px;', 'class' => 'viewBookingPopup')
        ),
        array(
            'header' => 'Date<br>& Time',
            'type' => 'raw',
            'value' => '$data->appointmentTime',
            'htmlOptions' => array('style' => 'text-align:left;width:100px;', 'class' => 'viewBookingPopup')
        ),

        array(
            'header' => 'Type U/S<br>Scan OR<br>Procedure',
            'type' => 'raw',
            'value' => '$data->getScanType()',
            'htmlOptions' => array('style' => 'text-align:left;width:100px;', 'class' => 'viewBookingPopup')
        ),
        array(
            'header' => 'Date of previous scan in FCC',
            'type' => 'raw',
            'value' => '$data->bookingData->previous_scan !== "" ? date("d/m/Y",strtotime($data->bookingData->previous_scan)) : "-"',
            'htmlOptions' => array('style' => 'text-align:left;width:150px;', 'class' => 'viewBookingPopup')
        ),
        array(
            'header' => 'G_P_<br/>LMP <br/>EDD',
            'type' => 'raw',
            'value' => '"G".$data->bookingData->g."P".$data->bookingData->p."<br/>LMP:".($data->bookingData->lmp !== "" ? date("d/m/Y",strtotime($data->bookingData->lmp)) : "")."<br/>EDD:".($data->bookingData->edd !== "" ? date("d/m/Y",strtotime($data->bookingData->edd)) : "")',
            'htmlOptions' => array('style' => 'text-align:left;width:150px;', 'class' => 'viewBookingPopup')
        ),
        array(
            'header' => 'Medical<br>conditions',
            'type' => 'raw',
            'value' => '$data->bookingData->medical_history',
            'htmlOptions' => array('style' => 'text-align:left;width:150px;', 'class' => 'viewBookingPopup')
        ),
        array(
            'header' => 'Reason for U/S scan or Procedure<br>Note to doctor',
            'type' => 'raw',
            'value' => '$data->bookingData->comments',
            'htmlOptions' => array('style' => 'text-align:left;', 'class' => 'viewBookingPopup')
        ),
        array(
            'header' => 'Status',
            'type' => 'raw',
            'value' => '$data->is_deleted == 0 ? "Booked":"Cancelled"',
            'htmlOptions' => array('style' => 'text-align:left;','class' => 'viewBookingPopup')
        ),
        array(
            'headerHtmlOptions' => array('width' => '50px', 'style' => 'text-align: center;'),
            'class' => 'CButtonColumn',
            'template' => '{appointmentDetail}  {printAppointment}<br/><br/>{cancelAppointment}',
            'buttons' => array(
                'appointmentDetail' => array(
                    'imageUrl' => Yii::app()->theme->baseUrl . '/img/appointment-detail-icon.png',
                    'label' => Yii::t('static', 'View an appointment'),
                    'url' => 'Yii::app()->createUrl("/appointment/pregnancy/viewpopup", array("id"=>$data->uuid))',
                    'options' => array('target' => '_blank', 'class' => 'viewBooking'),
                ),
                'printAppointment' => array(
                    'imageUrl' => Yii::app()->theme->baseUrl . '/img/print-icon.png',
                    'label' => Yii::t('static', 'Print an appointment'),
                    'url' => 'Yii::app()->createUrl("/appointment/pregnancy/viewpopup", array("id"=>$data->uuid,"is_print"=>1))',
                    'options' => array('target' => '_blank', 'class' => 'viewPrintBooking'),
                ),
                'cancelAppointment' => array(
                    'imageUrl' => Yii::app()->theme->baseUrl . '/img/appointment-delete-icon.png',
                    'label' => Yii::t('static', 'Cancel this appointment'),
                    'url' => 'Yii::app()->createUrl("/appointment/pregnancy/cancelBookingPopup", array("id"=>$data->id))',
                    'options' => array('target' => '_blank', 'class' => 'deleteBooking'),
                    'visible'=>'$data->checkDeleteButton() == 1'
                ),

            ),
        ),
    ),
));
?>


<script type="text/javascript">
    $(function () {
        fancyBoxLink();
    });

    function fancyBoxLink() {
        $(".viewBooking,.viewPrintBooking,.deleteBooking").fancybox({
            'scrolling': 'hidden',
        });
        $(".deleteBooking").fancybox({
            'scrolling': 'hidden',
            onClosed: function() {
                $('#booking-grid').yiiGridView('update', {
                    data: $(this).serialize(),
                    complete: function(){ fancyBoxLink(); }
                });

            },
        });
        $(".viewBookingPopup").click(function (event) {
            $(this).parent('tr').children('.button-column').children('a.viewBooking').trigger('click');
        });
    }

</script>

<style type="text/css">
    .fancybox-overlay {
        overflow: hidden !important;
    }
    .viewBooking { display: none;}
    .viewBookingPopup {
        cursor: pointer;
    }

    #booking-grid th {
        font-weight: bold;
    }

    #booking-grid td, th {
        border: 1px solid #CCC;
    }


</style>
