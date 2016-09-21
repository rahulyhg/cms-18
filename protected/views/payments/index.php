
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
<div class="form-horizontal">
    <div class="box-1">
        <div class="title-box clearfix">
            <h2 class="title"><?php echo Yii::t('static', 'PAYMENTS') ?></h2>
            <?php echo CHtml::link(Yii::t('static', '<span class="glyphicon glyphicon-print"></span> Print Table'), array('mpdfprint/index', 'patient_id'=>$patient_id, 'type' => 'payments'), array('class' => 'btn-1 pull-right', 'target'=>'_blank')); ?>
            <?php echo CHtml::link(Yii::t('static', '<span class="glyphicon glyphicon-print"></span> Print Selected'),'#', array('class' => 'btn-1 pull-right  print-list-select-payments','data-href'=>Yii::app()->createAbsoluteUrl('/mpdfprint/printSelect'))); ?>
        </div>
        <div class="box-body"> 

            <div class="row" >        
                <div class="col-md-4" >
                    <div class="pay-inv">

                        <h4>Drug Alert</h4>
                        <?php
                        if (!empty($drugalert)) {

                            foreach ($drugalert AS $itemDrugAlert) {
                                ?>
                                <p><b><?php echo $itemDrugAlert->comment; ?></b></p>

                                <?php
                            }
                        }
                        ?>

                    </div>

                </div>
                <div class="col-md-4" >
                    <div  class="pay-inv-infor">
                        <h5> <u>PAYMENT INFORMATION </u></h4>
                            <p>Bill To : <u> <?php if (!empty($patientInfor)) echo $patientInfor['name'] ?> </u> </p>      

                    </div>

                </div>
                <div class="col-md-4" >
                    <div  class="pay-inv-infor">
                        <div class="row margintext">
                            <?php if (!empty($patientInfor)) { ?>
                                <div class="col-md-4"><b><?php echo $patientInfor['name']; ?></b></div>
                                <div class="col-md-4 aligncenter"><?php echo $patientInfor['identity']; ?></div>
                                <div class="col-md-4 alignright"><?php echo $patientInfor['age']; ?> Years <?php echo $patientInfor['gender']; ?></div>
                            <?php } ?>
                        </div>
                        <div class="row">
                            <?php if (!empty($patientInfor)) { ?>
                                <div class="col-md-8">
                                    <?php
                                    if (!empty($langueges)) {
                                        echo $langueges;
                                    }
                                    ?>
                                </div>
                                <div class="col-md-4 alignright"><?php echo $patientInfor['doctor_name'] ?></div>
                            <?php } ?>
                        </div>
                    </div>

                </div>


            </div>
            <br>
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
                  'htmlOptions' => array('class' => 'clickable', 'style' => 'text-align:left; width: 20%')
                  ),
                array(
                  'header' => 'Invoice No/Resceipt No',
                  'name' => 'invoice_no',
                  'htmlOptions' => array('class' => 'clickable', 'style' => 'text-align:left;width: 25%')
                  ),
                array(
                  'header' => 'Amount Paid',
                  'name' => 'id',
                  'value'=>'isset($data->Amout)?$data->Amout->amount_pay:""',
                  'htmlOptions' => array('class' => 'clickable', 'style' => 'text-align:right;width: 15%')
                  ),
                array(
                  'header' => 'Change',
                  'name' => 'id',
                  'value'=>'isset($data->Amout)?$data->Amout->change:""',
                  'htmlOptions' => array('class' => 'clickable', 'style' => 'text-align:right;width: 15%')
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
                     
                'htmlOptions' => array('class' => 'clickable', 'style' => 'text-align:left; width:100px')
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





