
<div class="form-horizontal">
    <div class="box-1">
        <div class="title-box clearfix">
            <h2 class="title"><?php echo Yii::t('static', 'MAKE PAYMENT') ?></h2>
            <?php echo CHtml::link(Yii::t('static', '<span class="glyphicon "></span> Save Make Payment'),'#', array('class' => 'btn-1 pull-right make-payment')); ?>
            <?php echo CHtml::link(Yii::t('static', '<span class="glyphicon glyphicon-print"></span> Print Receipt'), array('/mpdfprint/receipt','pay_id'=>$pay_id,'type'=>"receipt"), array('class' => 'btn-1 pull-right')); ?>
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
                            <p>Unpaid Bills (Outstanding amount) =  <?php echo $payment->total_with_gst; ?> </p>      
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
            <div class="clearfix"></div>
            <div class="row" >  
                <div class="row bottom-form">
                <div class="col-md-8 col-md-offset-4" >
                   
                        <div class="col-md-12 form-group form-group-sm">
                            <div class="btn-1" style="background: rgb(255, 255, 255); color: black!important; border-color:black!important;" >RECEIPT : <?php echo 'RC'.trim($payment->invoice_no,'IV'); ?></div>
                            <div class="btn-1" style="background: rgb(218, 74, 56); color: white!important;" >INVOICE : <?php echo $payment->invoice_no; ?></div>
                        </div>
                        
                           <div class="col-md-12 form-group form-group-sm">
                                <label  class="col-md-8">CURRENT BILL AMOUNT</label>      
                                <div class="col-md-3">
                                    <input type="text" ReadOnly="true" id="bill-cr" style="text-align: right; padding-right: 5px;" value="<?php echo $payment->total_with_gst; ?>"  class="form-control "/> 
                                </div>
                                <label  class="col-md-1"> CR </label>    
                            </div> 
                   
                </div>
            </div>
            </div>
             <br>
            <div class="clearfix"></div>
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'amount-model-form',
                'enableClientValidation' => false,
                'enableAjaxValidation' => FALSE,
                'clientOptions' => array(
                    'validateOnSubmit' => true,
                ),
                    ));
            ?>
            <div class="row">
                <div class="col-md-12 form-group-sm">
                    <div>
                        <table class="table table-hover table-responsive table-bordered" data-example-id="hoverable-table" >
                            <thead>
                                <tr>
                                    <th>Payment Mode</th>
                                    <th>Amount</th>
                                    <th>Payment Reference </th>

                                </tr>
                            </thead>
                            <tbody>
                                 <tr class='clickable-row' >
                                    <td >American Express</td>
                                    <td data-id="1">
                                          <?php echo $form->textField($model, 'american_express', array('class' => 'form-control make-payments-1')) ?>
                                          <?php echo $form->error($model, 'american_express'); ?>
                                       
                                    </td>
                                    <td></td>

                                </tr>
                                <tr class='clickable-row' >
                                    <td >Cash</td>
                                    <td data-id="1">
                                         <?php echo $form->textField($model, 'cash', array('class' => 'form-control make-payments-2')) ?>
                                          <?php echo $form->error($model, 'cash'); ?>
                                    </td>
                                    <td></td>


                                </tr>
                                <tr class='clickable-row' >
                                    <td >Cheque</td>
                                    <td data-id="1">
                                         <?php echo $form->textField($model, 'cheque', array('class' => 'form-control make-payments-3')) ?>
                                          <?php echo $form->error($model, 'cheque'); ?>
                                    </td>
                                    <td></td>

                                </tr>
                                <tr class='clickable-row' >
                                    <td >Master / VISA Credit Card</td>
                                    <td data-id="1">
                                          <?php echo $form->textField($model, 'credit_card', array('class' => 'form-control make-payments-4')) ?>
                                          <?php echo $form->error($model, 'credit_card'); ?>
                                    </td>
                                    <td></td>

                                </tr>

                                <tr class='clickable-row' >
                                    <td >Nets</td>
                                    <td data-id="1">
                                           <?php echo $form->textField($model, 'nets', array('class' => 'form-control make-payments-5')) ?>
                                          <?php echo $form->error($model, 'nets'); ?>
                                    </td>
                                    <td></td>

                                </tr>
                               

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


            <div class="row bottom-form">
                <div class="col-md-4 col-md-offset-8" >
                    <div class="col-md-12 form-group form-group-sm">
                        <label  class="col-md-4">Amount Paid </label>      
                        <div class="col-md-8">
                              <?php echo $form->textField($model, 'amount_pay', array('class' => 'form-control','style'=>"text-align: right; padding-right: 5px;",'ReadOnly'=>true)) ?>
                              <?php echo $form->error($model, 'amount_pay'); ?>           
                        </div>
                    </div>
                    <div class="col-md-12 form-group form-group-sm">
                        <label  class="col-md-4">Change </label>      
                        <div class="col-md-8">
                            <?php echo $form->textField($model, 'change', array('class' => 'form-control','style'=>"text-align: right; padding-right: 5px;",'ReadOnly'=>true,'value'=>($payment->total_with_gst-$model->amount_pay))) ?>
                             <?php echo $form->error($model, 'change'); ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php $this->endWidget(); ?>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        for( var i =1 ; i<6; i++) {
            var elm = $('.make-payments-'+i);
             if(elm.val()=="") {
                    elm.val(0)
            } 
        }
      
    });
</script>


