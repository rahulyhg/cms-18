
<?php
    $printUrl = Yii::app()->createAbsoluteUrl('mpdfprint/index', array('patient_id'=>$patient_id, 'type' => 'appointmenthistory'));
    $reschedule = Yii::app()->createAbsoluteUrl('patientsappointmenthistory/reschedule', array('patient_id'=>$patient_id));
    $appointment = Yii::app()->createAbsoluteUrl('appointment/create', array('patient_id'=>$patient_id));

Yii::app()->clientScript->registerScript('search', "
$('.update-button').click(function(){
        var atLeastOneIsChecked = $('input[name=\"appointment-history-grid_c0[]\"]:checked').length > 0;
        if (!atLeastOneIsChecked)
        {
                alert('Please select one record to update');
        }
        else if (window.confirm('Are you sure you want to update the selected records?'))
        {
                document.getElementById('appointment-history-grid-bulk').action='" . Yii::app()->createAbsoluteUrl('patientsappointmenthistory/update') . "';
                document.getElementById('appointment-history-grid-bulk').submit();
        }
});

");
?>
<?php $patient_id = isset($_GET['patient_id'])?$_GET['patient_id']:0;?>
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><?php echo Yii::t('static', 'Appointment History') ?></h3>
        <?php echo CHtml::link(Yii::t('static', '<span class="glyphicon glyphicon-print"></span> Print'), $printUrl, array('class' => 'btn-1 pull-right print-button', 'target'=>'_blank')); ?>
        <?php echo CHtml::link(Yii::t('static', '<span class="glyphicon glyphicon-trash"></span> Delete Appointment'), 'javascript:void(0);', array('class' => 'btn-1 pull-right delete-button', 'onclick' => 'deleteAppointmentHistory()')); ?>
        <?php echo CHtml::link(Yii::t('static', '<span class="glyphicon glyphicon-refresh"></span> Reschedule Appointment'), $reschedule, array('class' => 'btn-1 pull-right reschedule-button')); ?>
        <?php echo CHtml::link(Yii::t('static', '<span class="glyphicon glyphicon-plus"></span>  Add Appointment'), $appointment, array('class' => 'btn-1 pull-right')); ?>
    </div>
    <div class="panel-body">
        <div class="form">
          <?php 
          $columnArray = array();
          $columnArray[] = array(
            'value'=>'$data->event_id',
            'class'=> "CCheckBoxColumn",
            );
          $columnArray = array_merge($columnArray, array(
            array(
              'name' => 'appointment_date',
              'type' => 'date',
              'value' => '$data->event->start',
              'htmlOptions' => array('style' => 'text-align:left;')
              ),
            array(
              'name' => 'visit_reason_text',
              'type' => 'html',
              'value' => 'nl2br($data->visit_reason_text)',
              'htmlOptions' => array('style' => 'text-align:left;')
              ),
            'turn_up:YNStatus',
            array(
              'name' => 'comments',
              'type' => 'html',
              'value' => 'nl2br($data->comments)',
              'htmlOptions' => array('style' => 'text-align:left;')
              ),
            ));
            $form=$this->beginWidget('CActiveForm', array(
              'id'=>'appointment-history-grid-bulk',
              'enableAjaxValidation'=>false,
              'htmlOptions'=>array('enctype' => 'multipart/form-data')));

            $this->widget('zii.widgets.grid.CGridView', array(
              'id'=>'appointment-history-grid',
              'dataProvider'=>$dataProvider,
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
        </div>
    </div>
</div>

<script type="text/javascript">
  var urlDeleteAppointmentHistory = "<?php echo $this->createAbsoluteUrl('patientsappointmenthistory/delete'); ?>";
</script>