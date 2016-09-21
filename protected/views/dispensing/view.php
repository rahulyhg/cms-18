
<div class="form-horizontal">
    <div class="box-1">
        <div class="title-box clearfix">
            <h2 class="title"><?php echo Yii::t('static', 'Dispensing Entry') ?></h2>
        
        <?php echo CHtml::link(Yii::t('static', '<span class="glyphicon glyphicon-pencil"></span> Edit'), array('/dispensing/update?dispense='.$dispense_id.'&patient_id='.$patient_id.''), array('class' => 'btn-1 pull-right')); ?>
    </div>
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
                            <p>Unpaid Bills (Outstanding amount) = <b id="bill-total"><?php echo $dispensing->total_with_gst;?></b> </p>      
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

            <div class="row form-horizontal">
                <div class="col-md-12">
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
                                <?php if (!empty($model)): ?>

                                    <?php
                                    $stt = 0;
                                    foreach ($model as $data) {
                                        $stt++;
                                        ?>
                                        <tr class='clickable-row row-0' >
                                            <td ><?php echo $stt; ?></td>
                                            <td>  <?php echo $data->item_name; ?>  </td> 
                                            <td>  <?php echo $data->price; ?></td> 
                                            <td>  <?php echo $data->quantity; ?></td> 
                                            <td>  <?php echo $data->price_quantity; ?></td> 
                                            <td>  <?php echo $data->discount; ?></td> 
                                            <td>  <?php echo $data->price_after_discount; ?></td> 
                                            <td>  <?php echo $data->total; ?></td> 

                                        </tr>


                                    <?php }endif; ?>


                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
            <?php if(!empty($dispensing)):?>
            <div class="form bottom-form">
                <div class="row">
                    <div class="col-md-4">

                    </div>
                    <div class="col-md-4">
                        <div class="col-md-12 form-group form-group-sm">
                            <label  class="col-md-5">&nbsp;  </label>      
                            <div class="col-md-7" style="height: 35px">

                            </div>
                        </div>
                        <div class="col-md-12 form-group form-group-sm">
                            <label  class="col-md-5">Discount : </label>      
                            <div class="col-md-7">
                                <div class="row">
                                     <div class="col-md-4">
                                       <input readOnly="true" class="form-control" value="<?php echo $dispensing->discount.'%'?>"/>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" readonly="true" value="<?php echo  $dispensing->subtotal;?>"/>
                                      
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-md-12 form-group form-group-sm">
                            <label  class="col-md-5">Total without GST  </label>      
                            <div class="col-md-7">
                                <input type="text" class="form-control" readonly="true" value="<?php echo  $dispensing->total_without_gst;?>"/>
                                      
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="col-md-12 form-group form-group-sm">
                            <label  class="col-md-5">Subtotal  </label>      
                            <div class="col-md-7">
                                     <input type="text" class="form-control" readonly="true" value="<?php echo  $dispensing->subtotal;?>"/>
                                      

                            </div>
                        </div>
                        <div class="col-md-12 form-group form-group-sm">
                            <label  class="col-md-5">Add GST 7%   </label>      
                            <div class="col-md-7">
                                <input type="text" class="form-control" readonly="true" value="<?php echo ($dispensing->subtotal)*0.07;?>"/>
                             
                            </div>
                        </div>
                        <div class="col-md-12 form-group form-group-sm">
                            <label  class="col-md-5">Total with GST 7%  </label>      
                            <div class="col-md-7">
                             <input type="text" class="form-control" readonly="true" value="<?php echo  $dispensing->total_with_gst;?>"/>
                                      
                            </div>
                        </div>
                    </div>


                </div>
                <?php endif;?>
            </div>


        </div>
    </div>
</div>

<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/js/functionentry.js"></script>

