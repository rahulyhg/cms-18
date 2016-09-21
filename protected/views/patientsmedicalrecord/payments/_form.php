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
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'dispense-model-form',
        'enableClientValidation' => false,
        'enableAjaxValidation' => FALSE,
        'clientOptions' => array(
            'validateOnSubmit' => true,
        ),
            ));
    ?>
    <div class="row" >        
        <div class="col-md-12  pull-right">
            <button class="btn-1"  id="dispense">Save</button>
        </div>
    </div>
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
                            <th style="width: 30%">Item Name</th>
                            <th style="width: 10%">Price / Unit</th>
                            <th style="width: 5%">Quantity</th>
                            <th style="width: 10%">Price</th>
                            <th style="width: 10%">Discount</th>
                            <th style="width: 10%">Price After Discount</th>
                            <th style="width: 15%">Total</th>
                            <th style="width: 5%"></th>
                        </tr>
                    </thead>
                    <tbody class="invoice-main">
                        <?php
                        $number = 0;
                        foreach ($invoiceItem as $index => $item):
                            
                           
                            ?>
                            <tr class='clickable-row invoice-item' >
                                <td class="number-td"><?php echo $index + 1; ?></td>
                                <td >
                                   
                                    <?php echo $form->textField($invoiceItem[$index], '[' . $index . ']item_name', array('class' => 'form-control item_name')) ?>
                                    <?php echo $form->error($invoiceItem[$index], 'item_name'); ?>
                                </td >


                                <td>
                                    <?php echo $form->numberField($invoiceItem[$index], '[' . $index . ']price', array('class' => 'form-control price')) ?>
                                    <?php echo $form->error($invoiceItem[$index], 'price'); ?>
                                </td>
                                <td>
                                    <?php echo $form->numberField($invoiceItem[$index], '[' . $index . ']quantity', array('class' => 'form-control quantity')) ?>
                                    <?php echo $form->error($invoiceItem[$index], 'quantity'); ?>
                                </td>
                                </td>
                                <td>
                                    <?php echo $form->textField($invoiceItem[$index], '[' . $index . ']price_quantity', array('class' => 'form-control price_quantity', 'readOnly' => true)) ?>

                                <td>
                                    <?php echo $form->numberField($invoiceItem[$index], '[' . $index . ']discount', array('class' => 'form-control discount')) ?>
                                    <?php echo $form->error($invoiceItem[$index], 'discount'); ?>
                                </td>
                                <td>     <?php echo $form->textField($invoiceItem[$index], '[' . $index . ']price_after_discount', array('class' => 'form-control price_after_discount', 'readOnly' => true)) ?> </td>
                                <td>     <?php echo $form->textField($invoiceItem[$index], '[' . $index . ']total', array('class' => 'form-control total', 'readOnly' => true)) ?> </td>
                                <td class="remove"> <i class="glyphicon glyphicon-trash  hide"></i> </td>
                            </tr>
                        <?php endforeach; ?>

                    </tbody>

                </table>


            </div>
            <div class="invoice-icon" >
                <i class="glyphicon glyphicon-plus " data-number="1" ></i>
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

                    </div>
                </div>
                <div class="col-md-12 form-group form-group-sm">
                    <label  class="col-md-5">Discount  </label>      
                    <div class="col-md-7">
                        <div class="clearfix"></div>
                        <div class="row">
                            <div class="col-md-4">
                                <?php echo $form->Dropdownlist($model, 'discount', array('0' => 0, '10' => 10, '20' => 20, '30' => 30, '40' => 40, '50' => 50), array('class' => 'form-control total-discount', 'maxlength' => 10, 'style' => 'width:auto!important')); ?>
                            </div>
                            <div class="col-md-8">
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