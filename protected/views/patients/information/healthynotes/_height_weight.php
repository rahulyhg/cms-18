
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Height / Weight</h3>
        <?php echo CHtml::link(Yii::t('static', '<span class="glyphicon glyphicon-print"></span> Print'), array('mpdfprint/index', 'patient_id'=>$patient_id, 'type' => 'heightweight'), array('class' => 'btn-1 pull-right', 'target'=>'_blank')); ?>
         <?php echo CHtml::link(Yii::t('static', '<span class="glyphicon glyphicon-trash"></span> Delete'), 'javascript:void(0);', array('class' => 'btn-1 pull-right', 'onclick' => 'deleteHeightWeight()')); ?>
        <?php //echo CHtml::link(Yii::t('static', '<span class="glyphicon glyphicon-print"></span> Print Prescription'), 'javascript:void(0);', array('class' => 'btn-1 pull-right', 'onclick' => 'printSelectedHeightWeight()')); ?>
        <?php echo CHtml::link(Yii::t('static', '<span class="glyphicon glyphicon-pencil"></span> Edit'), 'javascript:void(0);', array('class' => 'btn-1 pull-right', 'onclick' => 'editHeightWeight("heightweight-grid", "height_weight")')); ?>
        <?php echo CHtml::link(Yii::t('static', '<span class="glyphicon glyphicon-plus"></span>  Add'), array('heightWeight/create', 'patient_id'=>$patient_id), array('class' => 'btn-1 pull-right')); ?>
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
              'header' => 'Height (cm)',
              'name' => 'height',
              'htmlOptions' => array('class' => 'clickable', 'style' => 'text-align:left;width: 20%')
              ),
            array(
              'header' => 'Weight (kg)',
              'name' => 'weight',
              'htmlOptions' => array('class' => 'clickable', 'style' => 'text-align:left;width: 10%')
              ),
            ));
        $form=$this->beginWidget('CActiveForm', array(
          'id'=>'heightweight-grid-bulk',
          'enableAjaxValidation'=>false,
          'htmlOptions'=>array('enctype' => 'multipart/form-data')));

        $this->widget('zii.widgets.grid.CGridView', array(
          'id'=>'heightweight-grid',
          'dataProvider'=>$heightweight,
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
  var urlPrintSelectedHeightWeight = '<?php echo $this->createAbsoluteUrl('heightweight/printSelected'); ?>';
  var urlUpdateHeightWeight = '<?php echo $this->createAbsoluteUrl('heightWeight/update'); ?>';
  var urlDeleteHeightWeight = '<?php echo $this->createAbsoluteUrl('heightWeight/delete'); ?>';
</script>