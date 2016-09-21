

<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Blood Pressure</h3>
        <?php echo CHtml::link(Yii::t('static', '<span class="glyphicon glyphicon-print"></span> Print'), array('mpdfprint/index', 'patient_id'=>$patient_id, 'type' => 'blood_pressure'), array('class' => 'btn-1 pull-right', 'target'=>'_blank')); ?>
        <?php echo CHtml::link(Yii::t('static', '<span class="glyphicon glyphicon-trash"></span> Delete'), 'javascript:void(0);', array('class' => 'btn-1 pull-right', 'onclick' => 'deleteBloodPressure()')); ?>
        <?php echo CHtml::link(Yii::t('static', '<span class="glyphicon glyphicon-pencil"></span> Edit'), 'javascript:void(0);', array('class' => 'btn-1 pull-right', 'onclick' => 'editBloodPressure("blood-pressure-grid", "blood_pressure")')); ?>
        <?php echo CHtml::link(Yii::t('static', '<span class="glyphicon glyphicon-plus"></span>  Add'), array('bloodpressure/create', 'patient_id'=>$patient_id), array('class' => 'btn-1 pull-right')); ?>
    </div>
    <div class="panel-body">
        <?php 
        $columnArray = array();
        $columnArray[] = array(
            'header' => 'Select',
            'value'=>'$data->id',
            'class'=> "CCheckBoxColumn",
            'htmlOptions' => array('style' => 'width: 1%')
            );
        $columnArray = array_merge($columnArray, array(
            array(
              'header' => 'Date',
              'value' => '$data->date',
              'type' => 'date',
              'htmlOptions' => array('class' => 'clickable', 'style' => 'text-align:left; width: 20%')
              ),
            array(
              'header' => 'Time',
              'type' => 'time',
              'value' => '$data->date',
              'htmlOptions' => array('class' => 'clickable', 'style' => 'text-align:left;width: 20%')
              ),
            array(
              'name' => 'blood_pressure',
              'type' => 'YNStatus',
              'htmlOptions' => array('class' => 'clickable', 'style' => 'text-align:left;width: 10%')
              ),
            array(
              'name' => 'drugs',
              'htmlOptions' => array('class' => 'clickable', 'style' => 'text-align:left;width: 10%')
              ),
            array(
                'name' => 'comment',
                'type' => 'html',
                'value' => 'nl2br($data->comment)',
                'htmlOptions' => array('class' => 'clickable', 'style' => 'text-align:left;width: 22%')
                ),
            
            ));
        $form=$this->beginWidget('CActiveForm', array(
          'id'=>'blood-pressure-grid-bulk',
          'enableAjaxValidation'=>false,
          'htmlOptions'=>array('enctype' => 'multipart/form-data')));

        $this->widget('zii.widgets.grid.CGridView', array(
          'id'=>'blood-pressure-grid',
          'dataProvider'=>$blood_pressure,
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

<script type="text/javascript">
  var urlUpdateBloodPressure = '<?php echo $this->createAbsoluteUrl('bloodpressure/update'); ?>';
  var urlDeleteBloodPressure = '<?php echo $this->createAbsoluteUrl('bloodpressure/delete'); ?>';
</script>