<?php
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
        <?php echo CHtml::link(Yii::t('static', '<span class="glyphicon glyphicon-print"></span> Print Table'), array('/reports/printAllPayments', 'patient_id'=>$patient_id), array('class' => 'btn-1 pull-right', 'target'=>'_blank')); ?>
        <?php //echo CHtml::link(Yii::t('static', '<span class="glyphicon glyphicon-"></span> Print Selected'), '#', array('class' => 'btn-1 pull-right print-list-select-payments','data-href'=>Yii::app()->createAbsoluteUrl('/mpdfprint/printSelect'))); ?>
    </div>
    <div class="panel-body">
        <div class="form">
           <?php
                    //Yii::app()->clientScript;
                    
                    $columnArray = array();
                    $columnArray = array_merge($columnArray, array(
                        array(
                            'header' => 'S/N',
                            'type' => 'raw',
                            'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
                            'headerHtmlOptions' => array('width' => '5%', 'style' => 'text-align:center;'),
                            'htmlOptions' => array('style' => 'text-align:center;')
                        ),
                        array(
                            'header' =>'Invoice No',
                            'name' => 'invoice_no',
                            'value' =>'$data["invoice_no"]',
                            'htmlOptions' => array('class' => 'clickable', 'style' => 'text-align:center; width: 18%'),
                        ),
                        array(
                            'header' =>'Subtotal',
                            'name' => 'subtotal',
                            'htmlOptions' => array('class' => 'clickable', 'style' => 'text-align:center; width: 10%'),
                            'type' => 'prices'
                        ),
                         array(
                            'header' =>'Discount',
                            'name' => 'discount',
                            'value' =>'$data["id"]',
                            'htmlOptions' => array('class' => 'clickable', 'style' => 'text-align:center; width:8%'),
                            'type' => 'discountType',
                            'filter' => false
                        ),
                        array(
                            'header' =>'Add GST',
                            'name' => 'add_gst',
                            'value' =>'$data["add_gst"]',
                            'htmlOptions' => array('class' => 'clickable', 'style' => 'text-align:center; width: 10%'),
                            'type' => 'prices',
                            'filter' => false
                         ),
                        array(
                            'header' =>'Total With GST',
                            'name' => 'total_with_gst',
                            'value' =>'$data["total_with_gst"]',
                            'htmlOptions' => array('class' => 'clickable', 'style' => 'text-align:center; width: 10%'),
                            'type' => 'prices',
                            'filter' => false
                        ),
                        array(
                            'header' =>'Amount After Discount',
                            'name' => 'amount_after_discount',
                            'value' =>'$data["amount_after_discount"]',
                            'htmlOptions' => array('class' => 'clickable', 'style' => 'text-align:center; width: 10%'),
                            'type' => 'prices'
                        ),
                        array(
                            'header' =>'Amount',
                            'name' => 'amount_due',
                            'value' =>'$data["amount_due"]',
                            'htmlOptions' => array('class' => 'clickable', 'style' => 'text-align:center; width: 10%'),
                            'type' => 'prices'
                        ),
                        array(
                            'header' =>'Receive',
                            'name' => 'total_receive',
                            'value' =>'$data["total_receive"]',
                            'htmlOptions' => array('class' => 'clickable', 'style' => 'text-align:center; width: 10%'),
                            'type' => 'prices'
                        ),
                        array(
                                'header' => 'Actions',
                                'class'=>'CButtonColumn',
                                'template'=> '{views} {updates} {transaction}',
                                 'buttons' => array(
                                    'views' => array (
                                        'url' => 'Yii::app()->createAbsoluteUrl("/payments/view",array("id"=>$data["id"]))',
                                        'options'=>array('title'=>'View'),
                                        'label' =>'<i class="glyphicon glyphicon-eye-open"> </i>',
                                    ),
                                    'updates' => array (
                                        'url' => 'Yii::app()->createAbsoluteUrl("/payments/update",array("id"=>$data["id"]))',
                                        'options'=>array('title'=>'Update'),
                                        'label' =>'<i class="glyphicon glyphicon-pencil"> </i>',
                                    ),
                                   'transaction' => array(
                                    'url' => 'Yii::app()->createAbsoluteUrl("/reports/payAmounts",array("payment_id"=>$data["id"]))',
                                    'options' => array(
                                        'title' => 'Transaction',
                                        'class' => 'delete-data',
                                       
                                    ),
                                     'label' =>'<i class="glyphicon glyphicon-usd"> </i>',
                                  
                                  ),
                                )
                        ),
                    ));


                    $this->widget('zii.widgets.grid.CGridView', array(
                        'id' => 'payments-grid',
                        'dataProvider' => $dataProvider->search($patient_id),
                        'filter'=>$dataProvider,
                        'pager' => array(
                            'header' => '',
                            'prevPageLabel' => 'Prev',
                            'firstPageLabel' => 'First',
                            'lastPageLabel' => 'Last',
                            'nextPageLabel' => 'Next',
                            'htmlOptions'=>array('class'=>'pagination'),
                        ),
                        'selectableRows' => 2,
                        'columns' => $columnArray,
                    ));
                    ?>
        </div>
    </div>
</div>

<script type="text/javascript">
  var urlPrintSelectedPaymentHistory = "<?php echo $this->createAbsoluteUrl('payments/printSelected'); ?>";
</script>