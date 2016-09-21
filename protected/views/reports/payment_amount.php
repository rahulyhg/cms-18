<div class="box-1">
    <div class="title-box clearfix">
        <h2 class="title"><?php echo Yii::t('static', 'List Transaction Payments') ?> : <?php echo $payment->invoice_no;?></h2>
        <?php echo CHtml::link(Yii::t('static', '<span class="glyphicon glyphicon-print"></span>  Print'), array('reports/printAllAmount','payment_id'=>$payment_id), array('class' => 'btn-1 pull-right','target'=>'_blank')); ?>
    
    </div>

    <div class=" box-body form-horizontal">
        <div class="row clearfix">
            <div class="col-md-12">


                <div class="table-responsive">


                    <?php
                     Yii::app()->clientScript;
                    $columnArray = array();
                    $columnArray = array_merge($columnArray, array(
                        array(
                            'header' => 'S/N',
                            'type' => 'raw',
                            'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
                            'headerHtmlOptions' => array('width' => '5%', 'style' => 'text-align:center;'),
                            'htmlOptions' => array('style' => 'text-align:center;'),
                        ),
                        array(
                            'header' => 'Receipt No',
                            'name' => 'no_receipt',
                            'value' =>'$data["no_receipt"]',
                            'htmlOptions' => array('class' => 'clickable', 'style' => 'text-align:center; width: 18%'),
                        ),
                        array(
                            'header' =>'Invoice No',
                            'name' => 'payment_id',
                            'value' =>'$data["id"]',
                            'htmlOptions' => array('class' => 'clickable', 'style' => 'text-align:center; width: 18%'),
                            'type'=>'invoice',
                            'filter' => false
                        ),
                        array(
                            'header' => 'Pay Model',
                            'name' => 'pay_type',
                            'htmlOptions' => array('class' => 'clickable', 'style' => 'text-align:center; width: 18%'),
                            'value' =>'$data["id"]',
                            'type' =>'model',
                            'filter' => false
                           
                        ),
                        
                         array(
                            'header' => 'Amount',
                            'name' => 'amount_pay',
                            'value' =>'$data["amount_pay"]',
                            'htmlOptions' => array('class' => 'clickable', 'style' => 'text-align:center; width: 18%'),
                            'type' => 'prices'
                        ),
                        
                        array(
                            'header' => 'Created',
                            'name' => 'created',
                            'htmlOptions' => array('class' => 'clickable', 'style' => 'text-align:center; width: 18%'),
                            'value' => 'date("d/m/Y",$data["created"])',
                            'filter' => false
                        ),
                        
                        
                        
                    ));


                    $this->widget('zii.widgets.grid.CGridView', array(
                        'id' => 'PaymentAmount-grid',
                        'dataProvider' => $model->search($payment_id),
                        'filter'=>$model,
                        'pager' => array(
                            'header' => '',
                            'prevPageLabel' => 'Prev',
                            'firstPageLabel' => 'First',
                            'lastPageLabel' => 'Last',
                            'nextPageLabel' => 'Next',
                        ),
                        'selectableRows' => 2,
                        'columns' => $columnArray,
                    ));
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>