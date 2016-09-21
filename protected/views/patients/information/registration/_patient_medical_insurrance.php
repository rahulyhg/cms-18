
<?php 
    $cms = new BaseFormatter();
?>

<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Patient Medical Insurance Information</h3>
    </div>
    <div class="panel-body">
        <div class="form">
            <?php if (isset($defaultInsurrance)): ?>
                <div class="col-md-4">
                    <div class="form-group form-group-sm clearfix">
                        <label class="col-md-5">Company Name  </label>      
                        <div class="col-md-7">
                            <?php echo $defaultInsurrance->company_name ?>
                        </div>
                    </div>
                    <div class="form-group form-group-sm clearfix">
                        <label class="col-md-5">Department </label>      
                        <div class="col-md-7">
                            <?php echo $defaultInsurrance->department ?>
                        </div>
                    </div>
                    <div class="form-group form-group-sm clearfix">
                        <label class="col-md-5">Staff No  </label>      
                        <div class="col-md-7">
                            <?php echo $defaultInsurrance->staff_no ?>
                        </div>
                    </div>

                    <div class="form-group form-group-sm clearfix">
                        <label class="col-md-5">Entitlement Amount</label>      
                        <div class="col-md-7">
                            <?php echo $cms->formatPrice(number_format($defaultInsurrance->entitlement_from, 0) . '.' . number_format($defaultInsurrance->entitlement_to, 0)) ?>
                            
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group form-group-sm clearfix">
                        <label class="col-md-5">To Bill Insurance  </label>      
                        <div class="col-md-7">
                            <?php echo DeclareHelper::$toBillInsuranceFormat[$defaultInsurrance->to_bill_insurrance]; ?>
                        </div>
                    </div>
                    <div class="form-group form-group-sm clearfix">
                        <label class="col-md-5">Insurance Name </label>     
                        <div class="col-md-7">
                            <?php echo $defaultInsurrance->insurrance_name ?>
                        </div>
                    </div>
                    <div class="form-group form-group-sm clearfix">
                        <label class="col-md-5">Follow  </label>      
                        <div class="col-md-7">
                            <?php echo DeclareHelper::$followFormat[$defaultInsurrance->follow] ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group form-group-sm clearfix">
                        <label class="col-md-5">Copayment </label>      
                        <div class="col-md-7">
                            <?php echo $defaultInsurrance->copayment ? "Yes" : "No" ?>
                        </div>
                    </div>
                    
                    <div class="form-group form-group-sm clearfix amount-copayment">
                        <label class="col-md-5">Copayment Amount  </label>      
                        <div class="col-md-7">
                            <?php echo$cms->formatPrice(number_format($defaultInsurrance->copayment_amount_from, 0) . '.' . number_format($defaultInsurrance->copayment_amount_to, 0));?>
                            
                        </div>
                    </div>
                    <div class="form-group form-group-sm clearfix">
                        <div class="col-md-12">
                            <div class="form-group">
                                <?php
                                        $fileInventory = PatientAttachFile::model()->findAll('patient_id = :patient_id and type = 3',array(':patient_id'=>$model->id));
                                        if(!empty($fileInventory )):
                                  ?>
                                <div class="row">
                                    <div class="col-md-12">
                                        <h4>Attach Insurance Card, Letter or Document</h4>
                                        <div class="col-md-12">
                                            <table class="table table-striped table-bordered">
                                                <thead>
                                                    <th width="30%">File Name</th>
                                                    <th width="70%">Description</th>
                                                </thead>
                                                <tbody>
                                                  <?php foreach ($fileInventory as $item):?>
                                                        <tr>
                                                            <td><a  target="_blank" title="download file <?php echo $item->file;?>" href="<?php echo Yii::app()->createAbsoluteUrl('/').'/upload/patient/'.$model->id.'/insurrance_card/'.$item->file;?>"><?php echo $item->name;?><a/></td>
                                                            <td><?php echo $item->description;?></td>
                                                        </tr>
                                                  <?php endforeach;?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <?php endif;?>
                            </div>     
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <span class="empty">No results found.</span>
            <?php endif; ?>
        </div>
    </div>
</div>

