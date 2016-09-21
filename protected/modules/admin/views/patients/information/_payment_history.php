<?php
$paymenthistoryPrintUrl = Yii::app()->createAbsoluteUrl('mpdfprint/index', array('patient_id'=>$patient_id, 'type' => 'paymenthistory'));

Yii::app()->clientScript->registerScript('sprint', "
    
    $('.print-list-select-payments').click(function(e){
       e.preventDefault();
       var elm = $(this);
       var data = $('[type=checkbox]').serialize();
       if( data == '' ){
            alert('Please select at least one payment !');
            return false;
       }
       var url = elm.attr('data-href')+'?'+data+'&type=payments';
       window.open(
         url,
        '_blank' 
      );
        return false;
      
    });
   "
);
?>
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><?php echo Yii::t('static', 'Payment History') ?></h3>
        <?php echo CHtml::link(Yii::t('static', '<span class="glyphicon glyphicon-print"></span> Print Table'), $paymenthistoryPrintUrl, array('class' => 'btn-1 pull-right', 'target'=>'_blank')); ?>
        <?php echo CHtml::link(Yii::t('static', '<span class="glyphicon glyphicon-"></span> Print Selected'), '#', array('class' => 'btn-1 pull-right print-list-select-payments','data-href'=>Yii::app()->createAbsoluteUrl('/mpdfprint/printSelect'))); ?>
    </div>
    <div class="panel-body">
        <div class="form">
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
                  'header' => 'Invoice No/Receipt No',
                  'name' => 'invoice_no',
                  'htmlOptions' => array('class' => 'clickable', 'style' => 'text-align:left;width: 15%')
                  ),
                array(
                  'header' => 'Amount Paid',
                  'name' => 'id',
                  'value'=>'$data->Amout?$data->Amout->amount_pay:""',
                  'htmlOptions' => array('class' => 'clickable', 'style' => 'text-align:right;width: 15%')
                  ),
                array(
                  'header' => 'Change',
                  'name' => 'id',
                  'value'=>'$data->Amout?$data->Amout->change:""',
                  'htmlOptions' => array('class' => 'clickable', 'style' => 'text-align:right;width: 15%')
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
              
                 array(
                'header' => 'Actions',
                'class' => 'CButtonColumn',
                'template' => '{view}',
                 'buttons' => array
                    (
                    'view' => array
                        (
                        'url' => 'Yii::app()->createUrl("/payments/view",array("payment"=>$data->id))',
                        'options'=>array('title'=>'View Invoce'),
                      
                    ),
                'htmlOptions' => array('class' => 'clickable', 'style' => 'text-align:left; width:5%')
            ),)
               
                ));
            $form=$this->beginWidget('CActiveForm', array(
              'id'=>'payment-history-grid-bulk',
              'enableAjaxValidation'=>false,
              'htmlOptions'=>array('enctype' => 'multipart/form-data')));

            $this->widget('zii.widgets.grid.CGridView', array(
              'id'=>'payment-history-grid',
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
  var urlPrintSelectedPaymentHistory = "<?php echo $this->createAbsoluteUrl('payments/printSelected'); ?>";
</script>