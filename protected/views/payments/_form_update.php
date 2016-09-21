<div class="box-body"> 
    <div class="row" >        
        <div class="col-md-4" >
            <div class="pay-inv">

                <h4>Drug Alert</h4>
                <?php
                if (!empty($drugalert)) {

                    foreach ($drugalert AS $itemDrugAlert) {
                        ?>
                          <p><b><?php echo $itemDrugAlert->name.' - '.$itemDrugAlert->comment; ?></b></p>

                        <?php
                    }
                }
                ?>

            </div>

        </div>
        <div class="col-md-4" >
            <div  class="pay-inv-infor">
                <h5> <u>PAYMENT INFORMATION </u></h4>
                    <p>Unpaid Bills (Outstanding amount) = <b id="bill-total"></b> </p>      
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
                <di<div class="row">
                            <?php if (!empty($patientInfor)) { ?>
                                <div class="col-md-3">
                                    <?php
                                    if (!empty($langueges)) {
                                        echo $langueges;
                                    }
                                    ?>
                                </div>
                            <div class="col-md-6">Insurance: <?php echo $patient->medical_insurance_name?></div>
                                <div class="col-md-3 alignright"><?php echo Yii::app()->params['doctorName'];// $patientInfor['doctor_name'] ?></div>
                            <?php } ?>
                        </div>
                </div>
            </div>

        </div>
    </div>
    <br>
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'dispense-model-form',
        'enableClientValidation' => false,
        'enableAjaxValidation' => FALSE,
        'clientOptions' => array(
            'validateOnSubmit' => true,
            'autocomplete'=>"off"
        ),
            ));
    ?>
    <?php if((int)$model->total_receive == 0): ?>
        <div class="row" >        
            <div class="col-md-12  pull-right">
                <button class="btn-1"  id="dispense">Save</button>
            </div>
        </div>
    <?php endif;?>
    <br>
    <?php if (Yii::app()->user->hasFlash('entry')): ?>
        <div class="alert alert-danger" role="alert">
            <?php echo Yii::app()->user->getFlash('entry'); ?> 
        </div>
    <?php endif; ?>
    <div class="row form-horizontal">
        <div class="col-md-12 form-group-sm">
            <div>
                <table class="table table-hover table-responsive table-bordered" data-example-id="hoverable-table" >
                    <thead>
                        <tr>
                            <th style="width: 5%">S/N</th>
                            <th style="width: 10%">Type</th>
                            <th style="width: 20%">Item Name</th>
                            <th style="width: 10%">Price / Unit</th>
                            <th style="width: 5%">Quantity</th>
                            <th style="width: 10%">Price</th>
                            <th style="width: 10%">Discount</th>
                            <th style="width: 5%">Discount Type</th>
                            <th style="width: 10%">Price After Discount</th>
                            <th style="width: 15%">Total</th>
                            <th style="width: 5%"></th>
                        </tr>
                    </thead>
                    <tbody class="invoice-main">
                        <?php
                        $number = 0;
                        foreach ($invoiceItem as $index => $item):
                                $item->price_quantity = number_format($item->price * $item->quantity, 2);
                        ?>
                            <tr class='clickable-row invoice-item' >
                                <td class="number-td"><?php echo $index + 1; ?></td>
                                 <td>
                                    <?php echo $form->dropDownList($invoiceItem[$index], '[' . $index . ']service_type', array('empty'=>'Service/Drug','1'=>'Service','2'=>'Drug') ,array('class' => 'form-control service_type',)) ?>
                                    <?php echo $form->error($invoiceItem[$index], 'service_type'); ?>
                                </td>
                                <td >
                                    <?php echo $form->hiddenField($item,'[' . $index . ']id',array('type'=>"hidden", 'class'=>'item-id')); ?>
                                    <?php echo $form->textField($item, '[' . $index . ']item_name', array('class' => 'form-control item_name','autocomplete'=>"off")) ?>
                                    <?php echo $form->error($item, 'item_name'); ?>
                                </td >


                                <td>
                                    <?php echo $form->textField($item, '[' . $index . ']price', array('class' => 'form-control price numeric-control')) ?>
                                    <?php echo $form->error($item, 'price'); ?>
                                </td>
                                <td>
                                    <?php echo $form->numberField($item, '[' . $index . ']quantity', array('class' => 'form-control quantity numeric-control')) ?>
                                    <?php echo $form->error($item, 'quantity'); ?>
                                </td>
                              
                                <td>
                                    <?php echo $form->textField($item, '[' . $index . ']price_quantity', array('class' => 'form-control price_quantity', 'readOnly' => true)) ?>
                                    <?php echo $form->error($invoiceItem[$index], 'price_quantity'); ?>
                                </td>
                                
                                <td>
                                    <?php echo $form->textField($item, '[' . $index . ']discount', array('class' => 'form-control discount numeric-control')) ?>
                                    <?php echo $form->error($item, 'discount'); ?>
                                </td>
                                <td>
                                     <?php echo $form->dropDownList($invoiceItem[$index], '[' . $index . ']discount_type', array('1'=>'%','2'=>'$') ,array('class' => 'form-control discount_type')) ?>
                                </td>
                                <td>     <?php echo $form->textField($item, '[' . $index . ']price_after_discount', array('class' => 'form-control price_after_discount', 'readOnly' => true)) ?> </td>
                                <td>     
                                    <?php echo $form->textField($item, '[' . $index . ']total', array('class' => 'form-control total', 'readOnly' => true)) ?> 
                                      <?php echo $form->hiddenField($invoiceItem[$index], '[' . $index . ']service_id', array('class' => 'form-control service_id',)); ?>
                                </td>
                                <td class="remove"> <i class="glyphicon glyphicon-trash  hide"></i> </td>
                            </tr>
                        <?php endforeach; ?>

                    </tbody>

                </table>


            </div>
            <div class="invoice-icon" >
                <i class="glyphicon glyphicon-plus " data-number="<?php echo count($invoiceItem);?>" ></i>
            </div>
        </div>
    </div>

    <div class="form bottom-form">
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-7">

            </div>
            <div class="col-md-5">
                <div class="col-md-12 form-group form-group-sm">
                    <label  class="col-md-5">Subtotal  </label>      
                    <div class="col-md-7">
                        <?php echo $form->textField($model, 'subtotal', array('class' => 'form-control', 'id' => 'subtotal', 'readOnly' => true)) ?>
                        <?php echo $form->error($model, 'subtotal'); ?>
                    </div>
                </div>
                <div class="col-md-12 form-group form-group-sm">
                    <label  class="col-md-5">Discount  </label>      
                    <div class="col-md-7">
                        <div class="clearfix"></div>
                        <div class="row">
                           <div class="col-md-4">
                                <?php echo $form->textField($model, 'discount', array('class' => 'form-control total-discount numeric-control')) ?>
                           </div>
                           <div class="col-md-2">
                                <?php echo $form->Dropdownlist($model, 'discount_type', array(1 => '%', 2 => '$'), array('class' => 'form-control discount_type_total', 'maxlength' => 10, 'style' => 'width:auto!important')); ?>
                            </div>
                            <div class="col-md-6">
                                <input type="text" id="discount-total" class="form-control " readOnly="true"/> 
                            </div>
                          
                        </div>

                    </div>
                </div>
                <div class="col-md-12 form-group form-group-sm">
                    <label  class="col-md-5">Amount after discount   </label>      
                    <div class="col-md-7">
                        <?php echo $form->textField($model, 'amount_after_discount', array('class' => 'form-control', 'id' => 'total_without_gst', 'readOnly' => true)) ?>
                    </div>
                </div>

                <div class="col-md-12 form-group form-group-sm">
                    <label  class="col-md-5">Add GST 7%   </label>      
                    <div class="col-md-7">
                        <?php echo $form->textField($model, 'add_gst', array('class' => 'form-control', 'id' => 'add_gst_7', 'readOnly' => true)) ?>

                    </div>
                </div>
                <div class="col-md-12 form-group form-group-sm">
                    <label  class="col-md-5">Total with GST </label>      
                    <div class="col-md-7">
                        <?php echo $form->textField($model, 'total_with_gst', array('class' => 'form-control', 'id' => 'total_with_gst', 'readOnly' => true)) ?>
                    </div>
                </div>
                <div class="col-md-12 form-group form-group-sm">
                    <label  class="col-md-5">Amount Due </label>      
                    <div class="col-md-7">
                        <?php echo $form->textField($model, 'amount_due', array('class' => 'form-control', 'id' => 'amount_due_total', 'readOnly' => true)) ?>
                    </div>
                </div>
                 <div class="col-md-12 form-group form-group-sm">
                    <label  class="col-md-5">Total receive </label>      
                    <div class="col-md-7">
                        <?php echo $form->textField($model, 'total_receive', array('class' => 'form-control', 'id' => 'total_receive', 'readOnly' => true)) ?>
                    </div>
                </div>
            </div>


        </div>
    </div>

    <?php $this->endWidget(); ?>
</div>