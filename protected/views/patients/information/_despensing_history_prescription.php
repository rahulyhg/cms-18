<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><?php echo Yii::t('static', 'Dispensing History') ?></h3>
         <?php echo CHtml::link(Yii::t('static', '<span class="glyphicon glyphicon-plus"></span> Add Dispense'), array('/dispensing/entry','id'=>$patient_id), array('class' => 'btn-1 pull-right')); ?>
        <?php echo CHtml::link(Yii::t('static', '<span class="glyphicon glyphicon-print"></span> Print'), array('mpdfprint/index', 'patient_id'=>$patient_id, 'type' => 'dispensinghistory'), array('class' => 'btn-1 pull-right', 'target'=>'_blank')); ?>    
    </div>
    <div class="panel-body">
        <div class="form">
            <?php 
            $columnArray = array();
            $columnArray[] = array(
                'value'=>'$data->id',
                'class'=> "CCheckBoxColumn",
                'htmlOptions' => array('style' => 'width: 1%')
                );
            $columnArray = array_merge($columnArray, array(
                array(
                  'header' => 'Date',
                  'name' => 'created_date',
                  'type' => 'date',
                  'htmlOptions' => array('class' => 'clickable', 'style' => 'text-align:left; width: 20%')
                  ),
                 array(
                  'header' => 'Drug Name',
                  'name' => 'id',
                  'type' => 'DrugName',
                  'htmlOptions' => array('class' => 'clickable', 'style' => 'text-align:left; width: 20%')
                  ),
                array(
                  'header' => 'Quantity',
                  'value' => function ($data){
                       $dispensItem = DispenseItems::model()->findAll('dispense_id='.$data->id);
                       $value = '<ul style="list-style-type:none">';
                       foreach ($dispensItem as $data) {
                            $value.= '<li>'.$data->quantity.'</li>';
                       }
                       $value .= '</ul>';
                       return $value;
                  },
                  'type' =>'html',
                  'htmlOptions' => array('class' => 'clickable', 'style' => 'text-align:right; width: 20%')
                  ),
                array(
                  'header' => 'Selling Price',
                  'name' => 'subtotal',
                  'htmlOptions' => array('class' => 'clickable', 'style' => 'text-align:right; width: 20%')
                  ),
                array(
                  'header' => 'Comment',
                  'name' => '',
                  'type' => '',
                  'htmlOptions' => array('class' => 'clickable', 'style' => 'text-align:left; width: 20%')
                  ),
                
               
                ));
            $form=$this->beginWidget('CActiveForm', array(
              'id'=>'despensing-history-grid-bulk',
              'enableAjaxValidation'=>false,
              'htmlOptions'=>array('enctype' => 'multipart/form-data')));

            $this->widget('zii.widgets.grid.CGridView', array(
              'id'=>'despensing-history-grid',
              'dataProvider'=>$depensing,
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
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><?php echo Yii::t('static', 'Prescription') ?></h3>
        <?php echo CHtml::link(Yii::t('static', '<span class="glyphicon glyphicon-print"></span> Print Table'), array('mpdfprint/index', 'patient_id'=>$patient_id, 'type' => 'prescription'), array('class' => 'btn-1 pull-right', 'target'=>'_blank')); ?>
        <?php echo CHtml::link(Yii::t('static', '<span class="glyphicon glyphicon-print"></span> Print Prescription'), 'javascript:void(0);', array('class' => 'btn-1 pull-right', 'onclick' => 'printSelectedPrescription()')); ?>
    </div>
    <div class="panel-body">
        <div class="form">
          <?php 
          $columnArray = array();
          $columnArray[] = array(
              'value'=>'$data->id',
              'class'=> "CCheckBoxColumn",
              'htmlOptions' => array('style' => 'width: 1%')
              );
          $columnArray = array_merge($columnArray, array(
              array(
                'name' => 'date',
                'type' => 'date',
                'htmlOptions' => array('class' => 'clickable', 'style' => 'text-align:left; width: 20%')
                ),
              array(
                'name' => 'drug_dispensed',
                'htmlOptions' => array('class' => 'clickable', 'style' => 'text-align:left;width: 20%')
                ),
              array(
                'name' => 'quantity',
                'htmlOptions' => array('class' => 'clickable', 'style' => 'text-align:left;width: 10%')
                ),
              array(
                'name' => 'comments',
                'type' => 'html',
                'value' => 'nl2br($data->comments)',
                'htmlOptions' => array('class' => 'clickable', 'style' => 'text-align:left;width: 22%')
                ),
             
              ));
          $form=$this->beginWidget('CActiveForm', array(
            'id'=>'prescription-grid-bulk',
            'enableAjaxValidation'=>false,
            'htmlOptions'=>array('enctype' => 'multipart/form-data')));

          $this->widget('zii.widgets.grid.CGridView', array(
            'id'=>'prescription-grid',
            'dataProvider'=>$prescription,
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
  var urlPrintSelectedPrescription = "<?php echo $this->createAbsoluteUrl('dispensing/printSelected'); ?>";
</script>