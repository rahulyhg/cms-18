
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
                            <?php echo '$'.$defaultInsurrance->entitlement_from ?> -
                            <?php echo '$'.$defaultInsurrance->entitlement_to ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group form-group-sm clearfix">
                        <label class="col-md-5">To Bill Innsurance  </label>      
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
                            <?php echo '$'.$defaultInsurrance->copayment_amount_from ?> -
                            <?php echo '$'.$defaultInsurrance->copayment_amount_to ?>
                        </div>
                    </div>
                    <div class="form-group form-group-sm clearfix">
                        <label class="col-md-5">Attach Insurrance Card, Letter or Document </label>
                        <div class="col-md-7">
                            <?php 
                                $data['patient_id'] = $defaultInsurrance->patient_id;
                                $data['patient_medical_insurrance_id'] = $defaultInsurrance->id;
                                $data['type'] = 'insurrance_card';
                            ?>
                            <?php echo $cms->formatDocumentDownload($data); ?>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <span class="empty">No results found.</span>
            <?php endif; ?>
        </div>
    </div>
</div>

