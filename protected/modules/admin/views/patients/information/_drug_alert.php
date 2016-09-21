
<?php 
    $patient_id = isset($_GET['patient_id'])?$_GET['patient_id']:0;
    $printUrl = Yii::app()->createAbsoluteUrl('mpdfprint/index', array('patient_id'=>$patient_id, 'type' => 'drugalert'));
    $patientsdrugalert = Yii::app()->createAbsoluteUrl('patientsdrugalert/create', array('patient_id'=>$patient_id));
?>
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><?php echo Yii::t('static', 'Drug Alert Information') ?></h3>
        <?php echo CHtml::link(Yii::t('static', '<span class="glyphicon glyphicon-print"></span> Print'), $printUrl, array('class' => 'btn-1 pull-right', 'target'=>'_blank')); ?>
        <?php echo CHtml::link(Yii::t('static', '<span class="glyphicon glyphicon-trash"></span> Delete'), 'javascript:void(0);', array('class' => 'btn-1 pull-right delete-button', 'onclick' => 'deleteDrugAlert()')); ?>
        <?php echo CHtml::link(Yii::t('static', '<span class="glyphicon glyphicon-pencil"></span> Edit'), 'javascript:void(0);', array('class' => 'btn-1 pull-right update-button', 'onclick' => 'editDrugAlert("drug-alert-grid")')); ?>
        <?php echo CHtml::link(Yii::t('static', '<span class="glyphicon glyphicon-plus"></span>  Add'), $patientsdrugalert, array('class' => 'btn-1 pull-right')); ?>
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
              'name' => 'entry_date',
              'type' => 'date',
              'htmlOptions' => array('style' => 'text-align:left;')
              ),
            array(
              'name' => 'edit_date',
              'type' => 'date',
              'htmlOptions' => array('style' => 'text-align:left;')
              ),
            array(
              'name' => 'delete_date',
              'type' => 'date',
              'htmlOptions' => array('style' => 'text-align:left;', 'class' => 'delete')
              ),
            'name',
            array(
              'name' => 'comment',
              'type' => 'html',
              'value' => 'nl2br($data->comment)',
              'htmlOptions' => array('style' => 'text-align:left;')
              ),
            ));
            $form=$this->beginWidget('CActiveForm', array(
              'id'=>'drug-alert-grid-bulk',
              'enableAjaxValidation'=>false,
              'htmlOptions'=>array('enctype' => 'multipart/form-data')));

            $this->widget('zii.widgets.grid.CGridView', array(
              'id'=>'drug-alert-grid',
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

<style>
  .delete,
  #drug-alert-grid_c3{
    display: none;
  }
</style>

<script type="text/javascript">
var urlUpdateDrugAlert = "<?php echo $this->createAbsoluteUrl('patientsdrugalert/update'); ?>";
var urlDeleteDrugAlert = "<?php echo $this->createAbsoluteUrl('patientsdrugalert/delete'); ?>";

$(document).ready(function(){
    $( ".delete" ).each(function( index ) {
            var deleteDate = $(this).text();
            if (( deleteDate.length > 1 ) && ( deleteDate !== null )) {
                $(this).parent().find('td').css({'background' : 'gray', 'color' : 'red', 'text-decoration' : 'line-through'});
                $(this).parent().find('.select-on-check').css('display' , 'none'); 
                $(this).parent().hover(
                    function () {
                        $(this).children('td').css('background' , 'gray');   
                    }
                );
            };
        });
});
</script>
