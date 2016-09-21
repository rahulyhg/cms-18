
<?php $patient_id = isset($_GET['patient_id'])?$_GET['patient_id']:0;?>

<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Glucose</h3>
        <?php echo CHtml::link(Yii::t('static', '<span class="glyphicon glyphicon-print"></span> Print'), array('mpdfprint/index', 'patient_id'=>$patient_id, 'type' => 'glucose'), array('class' => 'btn-1 pull-right', 'target'=>'_blank')); ?>
        <?php echo CHtml::link(Yii::t('static', '<span class="glyphicon glyphicon-trash"></span> Delete'), 'javascript:void(0);', array('class' => 'btn-1 pull-right', 'onclick' => 'deleteGlucose()')); ?>
        <?php echo CHtml::link(Yii::t('static', '<span class="glyphicon glyphicon-pencil"></span> Edit'), 'javascript:void(0);', array('class' => 'btn-1 pull-right', 'onclick' => 'editGlucose("glucose-grid", "glucose")')); ?>
        <?php echo CHtml::link(Yii::t('static', '<span class="glyphicon glyphicon-plus"></span>  Add'), array('glucose/create', 'patient_id'=>$patient_id), array('class' => 'btn-1 pull-right')); ?>
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
                'name' => 'comment',
                'type' => 'html',
                'value' => 'nl2br($data->comment)',
                'htmlOptions' => array('class' => 'clickable', 'style' => 'text-align:left;width: 22%')
                ),
            
            ));
        $form=$this->beginWidget('CActiveForm', array(
          'id'=>'glucose-grid-bulk',
          'enableAjaxValidation'=>false,
          'htmlOptions'=>array('enctype' => 'multipart/form-data')));

        $this->widget('zii.widgets.grid.CGridView', array(
          'id'=>'glucose-grid',
          'dataProvider'=>$glucose,
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
  var urlUpdateGlucose = '<?php echo $this->createAbsoluteUrl('glucose/update'); ?>';
  var urlDeleteGlucose = '<?php echo $this->createAbsoluteUrl('glucose/delete'); ?>';
  var urlReload = '<?php echo $_SERVER["REQUEST_URI"];?>';
</script>