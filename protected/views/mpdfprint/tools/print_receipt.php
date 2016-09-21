<?php
/* @var $this DoctorController */
/* @var $model Doctor */


$this->title = Yii::t('static', $title);
?>

<div class="form-type">
    <div class="box-1">
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'print-patient-profile-form',
            'action' => Yii::app()->createUrl($this->route),
            ));
            ?>
            <div class="title-box clearfix">
                <h2 class="title"><?php echo Yii::t('static', $title) ?></h2>

            </div>
            <div class="box-body form-horizontal">
                <div class="row">
                  <div class="col-sm-12">
                      <div class="col-sm-7 pull-right form-group-sm">
                          <?php echo CHtml::button(Yii::t('static', 'Print'), array('class' => 'btn btn-default active', 'onclick' => 'printPatientProfile()')); ?>
                          <?php echo CHtml::link(Yii::t('static', 'Back'), array('tools/print'), array('class' => 'btn btn-primary')); ?>                            
                      </div>   
                  </div> 
                </div>
        <?php $this->endWidget(); ?>
                <div class="row">
                    <div class="col-md-12">
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
                  'header' => 'Invoice Date',
                  'name' => 'created_date',
                  'type' => 'date',
                  'htmlOptions' => array('class' => 'clickable', 'style' => 'text-align:left; width: 15%')
                  ),
                array(
                  'header' => 'Invoice No/Resceipt No',
                  'name' => 'invoice_no',
                  'htmlOptions' => array('class' => 'clickable', 'style' => 'text-align:left;width: 15%')
                  ),
                array(
                  'header' => 'Amount Paid',
                  'name' => 'id',
                  'value'=>'$data->Amout->amount_pay?$data->Amout->amount_pay:""',
                  'htmlOptions' => array('class' => 'clickable', 'style' => 'text-align:left;width: 15%')
                  ),
                array(
                  'header' => 'Change',
                  'name' => 'id',
                  'value'=>'$data->Amout->change?$data->Amout->change:""',
                  'htmlOptions' => array('class' => 'clickable', 'style' => 'text-align:left;width: 15%')
                  ),
                 array(
                  'header' => 'Comment',
                  'name' => 'comment',
                  'htmlOptions' => array('class' => 'clickable', 'style' => 'text-align:left;width: 15%')
                  ),
                array(
                  'name' => 'created_date',
                  'type' => 'date',
                  'htmlOptions' => array('class' => 'clickable', 'style' => 'text-align:left;width: 15%')
                  ),
              
               
               
                ));
            $form=$this->beginWidget('CActiveForm', array(
              'id'=>'payment-history-grid-bulk',
              'enableAjaxValidation'=>false,
              'htmlOptions'=>array('enctype' => 'multipart/form-data')));

            $this->widget('zii.widgets.grid.CGridView', array(
              'id'=>'payment-history-grid',
              'dataProvider'=>$receipt->search(),
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
        </div>
    </div><!-- form -->

<script type="application/javascript">
  var urlPrintPatientProfile = "<?php echo $this->createAbsoluteUrl('mpdfprint/printpatientprofile'); ?>";
</script>
