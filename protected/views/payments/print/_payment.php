<div class="panel panel-default">
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
                  'header' => 'Invoice No/Resceipt No',
                  'name' => 'invoice_no',
                  'htmlOptions' => array('class' => 'clickable', 'style' => 'text-align:left;width: 15%')
                  ),
                array(
                  'header' => 'Amount Paid',
                  'name' => 'id',
                  'value'=>'isset($data->Amout)?$data->Amout->amount_pay:""',
                  'htmlOptions' => array('class' => 'clickable', 'style' => 'text-align:left;width: 15%')
                  ),
                array(
                  'header' => 'Change',
                  'name' => 'id',
                  'value'=>'isset($data->Amout)?$data->Amout->change:""',
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
            if (!empty($model))
            {
                $this->widget('zii.widgets.grid.CGridView', array(
                  'id'=>'payment-history-grid',
                  'dataProvider'=>$model,
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
            }
            else
                echo "No payment found";
            $this->endWidget();
            ?>
        </div>
    </div>
</div>