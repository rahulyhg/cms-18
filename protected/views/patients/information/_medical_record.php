
<?php $patient_id = isset($_GET['patient_id'])?$_GET['patient_id']:0;?>
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><?php echo Yii::t('static', 'Medical Records') ?></h3>
        <?php echo CHtml::link(Yii::t('static', '<span class="glyphicon glyphicon-print"></span> Print'), array('mpdfprint/index', 'patient_id'=>$patient_id, 'type' => 'medicalrecord'), array('class' => 'btn-1 pull-right', 'target'=>'_blank')); ?>
        <?php echo CHtml::link(Yii::t('static', '<span class="glyphicon glyphicon-trash"></span> Delete'), 'javascript:void(0);', array('class' => 'btn-1 pull-right', 'onclick' => 'deleteMedicalRecord()')); ?>
        <?php echo CHtml::link(Yii::t('static', '<span class="glyphicon glyphicon-pencil"></span> Edit'), 'javascript:void(0);', array('class' => 'btn-1 pull-right', 'onclick' => 'editMedicalRecord("medical-record-grid")')); ?>
        <?php echo CHtml::link(Yii::t('static', '<span class="glyphicon glyphicon-plus"></span>  Add'), array('patientsmedicalrecord/create', 'patient_id'=>$patient_id), array('class' => 'btn-1 pull-right')); ?>
        <?php //echo CHtml::link(Yii::t('static', '<span class="glyphicon glyphicon-copy"></span> Add From Device'), array('patients/delete'), array('class' => 'btn-1 pull-right')); ?>
        <?php //echo CHtml::link(Yii::t('static', '<span class="glyphicon glyphicon-duplicate"></span> Add To Template'), array('patients/delete'), array('class' => 'btn-1 pull-right')); ?>
        <?php //echo CHtml::link(Yii::t('static', '<span class="glyphicon glyphicon-list-alt"></span> View'), array('patientsmedicalrecord/delete', 'patient_id' => 1), array('class' => 'btn-1 pull-right delete-button')); ?>
    </div>
    <div class="panel-body">
        <div class="form">
            <?php 
          $columnArray = array();
          $columnArray[] = array(
            'value'=>'$data->id',
            'class'=> "CCheckBoxColumn",
            );
          $columnArray = array_merge($columnArray, array(
            array(
              'name' => 'date',
              'type' => 'date',
              'htmlOptions' => array('style' => 'text-align:left;')
              ),
            array(
              'name' => 'comment',
              'type' => 'html',
              'value' => 'nl2br($data->comment)',
              'htmlOptions' => array('style' => 'text-align:left;')
              ),
            ));
            $form=$this->beginWidget('CActiveForm', array(
              'id'=>'medical-record-grid-bulk',
              'enableAjaxValidation'=>false,
              'htmlOptions'=>array('enctype' => 'multipart/form-data')));

            $this->widget('zii.widgets.grid.CGridView', array(
              'id'=>'medical-record-grid',
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
  var urlUpdateMedicalRecord = "<?php echo $this->createAbsoluteUrl('patientsmedicalrecord/update'); ?>";
  var urlDeleteMedicalRecord = "<?php echo $this->createAbsoluteUrl('patientsmedicalrecord/delete'); ?>";
</script>