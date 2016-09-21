
<div class="form-horizontal">
    <div class="box-1">
        <div class="title-box clearfix">
            <h2 class="title"><?php echo Yii::t('static', 'PAYMENT - INVOICE') ?></h2>
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
                    <button class="btn-1"  id="dispense">Dispense</button>
<!--                    <input class="btn-1"  id="pay" type="button" value="Pay">-->
                    <button class="btn-1"  id="dispense-pay">Dispense + Pay</button>
                    <?php echo $form->textField($model[0], 'type', array('class' => 'form-control')) ?>
                </div>
            </div>
            <br>
            <?php if(Yii::app()->user->hasFlash('entry')): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo Yii::app()->user->getFlash('entry');?> 
            </div>
            <?php endif;?>
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
                                    <th style="width: 20%">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class='clickable-row row-0' >
                                    <td >1</td>
                                    <td >
                                        <?php echo $form->textField($model[0], '[0]item_name', array('class' => 'form-control')) ?>
                                        <?php echo $form->error($model[0], '[0]item_name'); ?>
                                    </td >


                                    <td>
                                        <?php echo $form->textField($model[0], '[0]price', array('class' => 'form-control price_0 qty')) ?>
                                        <?php echo $form->error($model[0], '[0]price'); ?>
                                    </td>
                                    <td>
                                        <?php echo $form->textField($model[0], '[0]quantity', array('class' => 'form-control quantity_0 qty')) ?>
                                        <?php echo $form->error($model[0], '[0]quantity'); ?>
                                    </td>
                                    </td>
                                    <td>
                                        <?php echo $form->textField($model[0], '[0]price_quantity', array('class' => 'form-control', 'readOnly' => true)) ?>

                                    <td>
                                        <?php echo $form->textField($model[0], '[0]discount', array('class' => 'form-control discount_0')) ?>
                                        <?php echo $form->error($model[0], '[]discount'); ?>
                                    </td>
                                    <td>     <?php echo $form->textField($model[0], '[0]price_after_discount', array('class' => 'form-control', 'readOnly' => true)) ?> </td>
                                    <td>     <?php echo $form->textField($model[0], '[0]total', array('class' => 'form-control', 'readOnly' => true)) ?> </td>
                                </tr>
                                <tr class='clickable-row row-1' >
                                    <td >2</td>
                                    <td >
                                        <?php echo $form->textField($model[1], '[1]item_name', array('class' => 'form-control')) ?>
                                        <?php echo $form->error($model[1], '[1]item_name'); ?>
                                    </td >


                                    <td>
                                        <?php echo $form->textField($model[1], '[1]price', array('class' => 'form-control price_1 qty')) ?>
                                        <?php echo $form->error($model[1], '[1]price'); ?>
                                    </td>
                                    <td>
                                        <?php echo $form->textField($model[1], '[1]quantity', array('class' => 'form-control quantity_1 qty')) ?>
                                        <?php echo $form->error($model[1], '[1]quantity'); ?>
                                    </td>
                                    </td>
                                    <td>     <?php echo $form->textField($model[1], '[1]price_quantity', array('class' => 'form-control', 'readOnly' => true)) ?> </td>
                                    <td>
                                        <?php echo $form->textField($model[1], '[1]discount', array('class' => 'form-control discount_1')) ?>
                                        <?php echo $form->error($model[1], '[1]discount'); ?>
                                    </td>
                                    <td>     <?php echo $form->textField($model[1], '[1]price_after_discount', array('class' => 'form-control', 'readOnly' => true)) ?> </td>
                                    <td>     <?php echo $form->textField($model[1], '[1]total', array('class' => 'form-control', 'readOnly' => true)) ?> </td>
                                </tr>
                                <tr class='clickable-row' >
                                    <td >3</td>
                                    <td >
                                        <?php echo $form->textField($model[2], '[2]item_name', array('class' => 'form-control')) ?>
                                        <?php echo $form->error($model[2], '[2]item_name'); ?>
                                    </td >


                                    <td>
                                        <?php echo $form->textField($model[2], '[2]price', array('class' => 'form-control price_2 qty')) ?>
                                        <?php echo $form->error($model[2], '[2]price'); ?>
                                    </td>
                                    <td>
                                        <?php echo $form->textField($model[2], '[2]quantity', array('class' => 'form-control quantity_2 qty')) ?>
                                        <?php echo $form->error($model[2], '[2]quantity'); ?>
                                    </td>
                                    </td>
                                    <td>     <?php echo $form->textField($model[2], '[2]price_quantity', array('class' => 'form-control', 'readOnly' => true)) ?> </td>
                                    <td>
                                        <?php echo $form->textField($model[2], '[2]discount', array('class' => 'form-control discount_2')) ?>
                                        <?php echo $form->error($model[2], '[2]discount'); ?>
                                    </td>
                                    <td>     <?php echo $form->textField($model[2], '[2]price_after_discount', array('class' => 'form-control', 'readOnly' => true)) ?> </td>
                                    <td>     <?php echo $form->textField($model[2], '[2]total', array('class' => 'form-control', 'readOnly' => true)) ?> </td>
                                </tr>

                                <tr class='clickable-row' >
                                    <td >4</td>
                                    <td >
                                        <?php echo $form->textField($model[3], '[3]item_name', array('class' => 'form-control')) ?>
                                        <?php echo $form->error($model[3], '[3]item_name'); ?>
                                    </td >


                                    <td>
                                        <?php echo $form->textField($model[3], '[3]price', array('class' => 'form-control price_3 qty')) ?>
                                        <?php echo $form->error($model[3], '[3]price'); ?>
                                    </td>
                                    <td>
                                        <?php echo $form->textField($model[3], '[3]quantity', array('class' => 'form-control quantity_3 qty')) ?>
                                        <?php echo $form->error($model[3], '[3]quantity'); ?>
                                    </td>
                                    </td>
                                    <td>    <?php echo $form->textField($model[3], '[3]price_quantity', array('class' => 'form-control', 'readOnly' => true)) ?> </td>
                                    <td>
                                        <?php echo $form->textField($model[3], '[3]discount', array('class' => 'form-control discount_3')) ?>
                                        <?php echo $form->error($model[3], '[3]discount'); ?>
                                    </td>
                                    <td>     <?php echo $form->textField($model[3], '[3]price_after_discount', array('class' => 'form-control', 'readOnly' => true)) ?> </td>
                                    <td>     <?php echo $form->textField($model[3], '[3]total', array('class' => 'form-control', 'readOnly' => true)) ?> </td>
                                </tr>
                                <tr class='clickable-row' >
                                    <td >5</td>
                                    <td >
                                        <?php echo $form->textField($model[4], '[4]item_name', array('class' => 'form-control')) ?>
                                        <?php echo $form->error($model[4], '[4]item_name'); ?>
                                    </td >


                                    <td>
                                        <?php echo $form->textField($model[4], '[4]price', array('class' => 'form-control price_4 qty')) ?>
                                        <?php echo $form->error($model[4], '[4]price'); ?>
                                    </td>
                                    <td>
                                        <?php echo $form->textField($model[4], '[4]quantity', array('class' => 'form-control quantity_4 qty')) ?>
                                        <?php echo $form->error($model[4], '[4]quantity'); ?>
                                    </td>
                                    </td>
                                    <td>     <?php echo $form->textField($model[4], '[4]price_quantity', array('class' => 'form-control', 'readOnly' => true)) ?></td>
                                    <td>
                                        <?php echo $form->textField($model[4], '[4]discount', array('class' => 'form-control discount_4')) ?>
                                        <?php echo $form->error($model[4], '[4]discount'); ?>
                                    </td>
                                    <td>     <?php echo $form->textField($model[4], '[4]price_after_discount', array('class' => 'form-control', 'readOnly' => true)) ?> </td>
                                    <td>     <?php echo $form->textField($model[4], '[4]total', array('class' => 'form-control', 'readOnly' => true)) ?> </td>
                                </tr>
                                <tr class='clickable-row' >
                                    <td> 6</td>
                                    <td >
                                        <?php echo $form->textField($model[5], '[5]item_name', array('class' => 'form-control')) ?>
                                        <?php echo $form->error($model[5], '[5]item_name'); ?>
                                    </td >


                                    <td>
                                        <?php echo $form->textField($model[5], '[5]price', array('class' => 'form-control price_5 qty')) ?>
                                        <?php echo $form->error($model[5], '[5]price'); ?>
                                    </td>
                                    <td>
                                        <?php echo $form->textField($model[5], '[5]quantity', array('class' => 'form-control quantity_5 qty')) ?>
                                        <?php echo $form->error($model[5], '[5]quantity'); ?>
                                    </td>
                                    </td>
                                    <td>    <?php echo $form->textField($model[5], '[5]price_quantity', array('class' => 'form-control', 'readOnly' => true)) ?> </td>
                                    <td>
                                        <?php echo $form->textField($model[5], '[5]discount', array('class' => 'form-control discount_5')) ?>
                                        <?php echo $form->error($model[5], '[5]discount'); ?>
                                    </td>
                                    <td>     <?php echo $form->textField($model[5], '[5]price_after_discount', array('class' => 'form-control', 'readOnly' => true)) ?> </td>
                                    <td>     <?php echo $form->textField($model[5], '[5]total', array('class' => 'form-control', 'readOnly' => true)) ?> </td>
                                </tr>
                                <tr class='clickable-row' >
                                    <td >7</td>
                                    <td >
                                        <?php echo $form->textField($model[6], '[6]item_name', array('class' => 'form-control')) ?>
                                        <?php echo $form->error($model[6], '[6]item_name'); ?>
                                    </td >


                                    <td>
                                        <?php echo $form->textField($model[6], '[6]price', array('class' => 'form-control price_6 qty')) ?>
                                        <?php echo $form->error($model[6], '[6]price'); ?>
                                    </td>
                                    <td>
                                        <?php echo $form->textField($model[6], '[6]quantity', array('class' => 'form-control quantity_6 qty')) ?>
                                        <?php echo $form->error($model[6], '[6]quantity'); ?>
                                    </td>
                                    </td>
                                    <td>    <?php echo $form->textField($model[6], '[6]price_quantity', array('class' => 'form-control', 'readOnly' => true)) ?> </td>
                                    <td>
                                        <?php echo $form->textField($model[6], '[6]discount', array('class' => 'form-control discount_6')) ?>
                                        <?php echo $form->error($model[6], '[6]discount'); ?>
                                    </td>
                                    <td>     <?php echo $form->textField($model[6], '[6]price_after_discount', array('class' => 'form-control', 'readOnly' => true)) ?> </td>
                                    <td>     <?php echo $form->textField($model[6], '[6]total', array('class' => 'form-control', 'readOnly' => true)) ?> </td>
                                </tr>
                                <tr class='clickable-row' >
                                    <td >8</td>
                                    <td >
                                        <?php echo $form->textField($model[7], '[7]item_name', array('class' => 'form-control')) ?>
                                        <?php echo $form->error($model[7], '[7]item_name'); ?>
                                    </td >


                                    <td>
                                        <?php echo $form->textField($model[7], '[7]price', array('class' => 'form-control price_7 qty')) ?>
                                        <?php echo $form->error($model[7], '[7]price'); ?>
                                    </td>
                                    <td>
                                        <?php echo $form->textField($model[7], '[7]quantity', array('class' => 'form-control quantity_7 qty')) ?>
                                        <?php echo $form->error($model[7], '[7]quantity'); ?>
                                    </td>
                                    </td>
                                    <td>     <?php echo $form->textField($model[7], '[7]price_quantity', array('class' => 'form-control', 'readOnly' => true)) ?> </td>
                                    <td>
                                        <?php echo $form->textField($model[7], '[7]discount', array('class' => 'form-control discount_7')) ?>
                                        <?php echo $form->error($model[7], '[7]discount'); ?>
                                    </td>
                                    <td>     <?php echo $form->textField($model[7], '[7]price_after_discount', array('class' => 'form-control', 'readOnly' => true)) ?> </td>
                                    <td>     <?php echo $form->textField($model[7], '[7]total', array('class' => 'form-control', 'readOnly' => true,)) ?> </td>
                                </tr>
                                <tr class='clickable-row' >
                                    <td >9</td>
                                    <td >
                                        <?php echo $form->textField($model[8], '[8]item_name', array('class' => 'form-control')) ?>
                                        <?php echo $form->error($model[8], '[8]item_name'); ?>
                                    </td >


                                    <td>
                                        <?php echo $form->textField($model[8], '[8]price', array('class' => 'form-control price_8 qty')) ?>
                                        <?php echo $form->error($model[8], '[8]price'); ?>
                                    </td>
                                    <td>
                                        <?php echo $form->textField($model[8], '[8]quantity', array('class' => 'form-control quantity_8 qty')) ?>
                                        <?php echo $form->error($model[8], '[8]quantity'); ?>
                                    </td>
                                    </td>
                                    <td>     <?php echo $form->textField($model[8], '[8]price_quantity', array('class' => 'form-control', 'readOnly' => true)) ?> </td>
                                    <td>
                                        <?php echo $form->textField($model[8], '[8]discount', array('class' => 'form-control discount_8',)) ?>
                                        <?php echo $form->error($model[8], '[8]discount'); ?>
                                    </td>
                                    <td>     <?php echo $form->textField($model[8], '[8]price_after_discount', array('class' => 'form-control', 'readOnly'=>true)) ?> </td>
                                    <td>     <?php echo $form->textField($model[8], '[8]total', array('class' => 'form-control','readOnly'=>true,)) ?> </td>
                                </tr>
                                <tr class='clickable-row' >
                                    <td >10</td>
                                    <td >
                                        <?php echo $form->textField($model[9], '[9]item_name', array('class' => 'form-control')) ?>
                                        <?php echo $form->error($model[9], '[9]item_name'); ?>
                                    </td >


                                    <td>
                                        <?php echo $form->textField($model[9], '[9]price', array('class' => 'form-control price_9 qty')) ?>
                                        <?php echo $form->error($model[9], '[9]price'); ?>
                                    </td>
                                    <td>
                                        <?php echo $form->textField($model[9], '[9]quantity', array('class' => 'form-control quantity_9 qty')) ?>
                                        <?php echo $form->error($model[9], '[9]quantity'); ?>
                                    </td>
                                    </td>
                                    <td>     <?php echo $form->textField($model[9], '[9]price_quantity', array('class' => 'form-control', 'readOnly' => true)) ?></td>
                                    <td>
                                        <?php echo $form->textField($model[9], '[9]discount', array('class' => 'form-control discount_9')) ?>
                                        <?php echo $form->error($model[9], '[9]discount'); ?>
                                    </td>
                                    <td>     <?php echo $form->textField($model[9], '[9]price_after_discount', array('class' => 'form-control', 'readOnly' => true)) ?> </td>
                                    <td>     <?php echo $form->textField($model[9], '[9]total', array('class' => 'form-control', 'readOnly' => true)) ?> </td>
                                </tr>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
           
            <div class="form bottom-form">
                <div class="clearfix"></div>
                <div class="row">
                    <div class="col-md-2">

                    </div>
                    <div class="col-md-5">
                        <div class="col-md-12 form-group form-group-sm">
                            <label  class="col-md-5">&nbsp;  </label>      
                            <div class="col-md-7" style="height: 35px">

                            </div>
                        </div>
                        <div class="col-md-12 form-group form-group-sm">
                            <label  class="col-md-5">Discount  </label>      
                            <div class="col-md-7">
                                <div class="clearfix"></div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <?php echo $form->Dropdownlist($model[0], 'discount', array('0' => 0,'10' => 10,'20'=>20,'30'=>30,'40'=>40,'50'=>50),array('class' => 'form-control', 'maxlength' => 10,'style'=>'width:auto!important')); ?>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" id="discount-total" class="form-control " readOnly="true"/> 
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-md-12 form-group form-group-sm">
                            <label  class="col-md-5">Total without GST  </label>      
                            <div class="col-md-7">
                                 <?php echo $form->textField($model[0], 'total_without_gst', array('class' => 'form-control','id'=>'total_without_gst','readOnly' => true)) ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="col-md-12 form-group form-group-sm">
                            <label  class="col-md-5">Subtotal  </label>      
                            <div class="col-md-7">
                                <?php echo $form->textField($model[0], 'subtotal', array('class' => 'form-control','id'=>'subtotal','readOnly' => true)) ?>
                                         
                            </div>
                        </div>
                        <div class="col-md-12 form-group form-group-sm">
                            <label  class="col-md-5">Add GST 7%   </label>      
                            <div class="col-md-7">
                                   <?php echo $form->textField($model[0], 'add_gst_7', array('class' => 'form-control','id'=>'add_gst_7','readOnly' => true)) ?>
                                  
                            </div>
                        </div>
                        <div class="col-md-12 form-group form-group-sm">
                            <label  class="col-md-5">Total with GST 7%  </label>      
                            <div class="col-md-7">
                                   <?php echo $form->textField($model[0], 'total_with_gst', array('class' => 'form-control','id'=>'total_with_gst','readOnly' => true)) ?>
                            </div>
                        </div>
                    </div>


                </div>
            </div>

            <?php $this->endWidget(); ?>
        </div>
    </div>
</div>

<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/js/functionentry.js"></script>

