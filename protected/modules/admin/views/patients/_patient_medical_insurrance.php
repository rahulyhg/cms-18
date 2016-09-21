
<?php
    $cms = new BaseFormatter();
    $action = Yii::app()->controller->action->id;
?>

<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Patient Medical Insurance Information</h3>
    </div>
    <div class="panel-body">
        <div class="form form-horizontal">
            <div class="col-md-4">
                <div class="col-md-12 form-group form-group-sm">
                    <?php echo $form->labelEx($model,'medical_company_name', array('class' => 'col-md-3')); ?>
                    <div class="col-md-9">
                        <?php echo $form->textField($model,'medical_company_name',array('size'=>47,'maxlength'=>255, 'class' => 'form-control')); ?>
                        <?php echo $form->error($model,'medical_company_name'); ?>
                    </div>
                </div>
                <div class="col-md-12 form-group form-group-sm">
                    <?php echo $form->labelEx($model,'medical_department', array('class' => 'col-md-3')); ?>
                    <div class="col-md-9">
                        <?php echo $form->textField($model,'medical_department',array('size'=>47,'maxlength'=>255, 'class' => 'form-control')); ?>
                        <?php echo $form->error($model,'medical_department'); ?>
                    </div>
                </div>
                <div class="col-md-12 form-group form-group-sm">
                    <?php echo $form->labelEx($model,'medical_staff_no', array('class' => 'col-md-3')); ?>      
                    <div class="col-md-9">
                        <?php echo $form->textField($model,'medical_staff_no',array('size'=>47,'maxlength'=>255, 'class' => 'form-control')); ?>
                        <?php echo $form->error($model,'medical_staff_no'); ?>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="col-md-12 form-group form-group-sm">
                    <?php echo $form->labelEx($model,'medical_bill_insurance', array('class' => 'col-md-3')); ?>            
                    <div class="col-md-9">
                        <?php echo $form->dropDownList($model,'medical_bill_insurance', DeclareHelper::$toBillInsuranceFormat ,array('class' => 'form-control')); ?>
                        <?php echo $form->error($model,'medical_bill_insurance'); ?>                   
                    </div>
                </div>
                <div class="col-md-12 form-group form-group-sm">
                    <?php echo $form->labelEx($model,'medical_insurance_name', array('class' => 'col-md-3')); ?>    
                    <div class="col-md-9">
                        <?php echo $form->textField($model,'medical_insurance_name',array('size'=>47,'maxlength'=>255, 'class' => 'form-control')); ?>
                        <?php echo $form->error($model,'medical_insurance_name'); ?>
                    </div>
                </div>
                <div class="col-md-12 form-group form-group-sm">
                    <?php echo $form->labelEx($model,'medical_follow', array('class' => 'col-md-3')); ?>         
                    <div class="col-md-9">
                        <?php echo $form->dropDownList($model,'medical_follow', DeclareHelper::$followFormat ,array('class' => 'form-control')); ?>
                        <?php echo $form->error($model,'medical_follow'); ?>                   
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="col-md-12 form-group form-group-sm">
                    <?php echo $form->labelEx($model,'medical_copayment', array('class' => 'col-md-3')); ?>              
                    <div class="col-md-9">
                        <?php echo $form->dropDownList($model,'medical_copayment', DeclareHelper::$yesNoFormat ,array('class' => 'form-control')); ?>
                        <?php echo $form->error($model,'medical_copayment'); ?>    
                    </div>
                </div>
                <div class="col-md-12 form-group form-group-sm amount-copayment">
                    <label class="col-md-3">Copayment Amount  </label>      
                    <div class="col-md-9">
                        <div class="row">
                            <div class="col-md-6" style="display: inline-flex;">
                                <span style="margin-right: 5px; margin-top: 3px;">$</span>
                                <?php echo $form->textField($model,'medical_copayment_amount_from',array('size'=>47,'maxlength'=>255, 'class' => 'form-control numeric-control', 'placeHolder' => "$")); ?>
                            </div>
                            <div class="col-md-6" style="display: inline-flex;">
                                <span style="margin-right: 5px; margin-top: 3px;">$</span>
                                <?php echo $form->textField($model,'medical_copayment_amount_to',array('size'=>47,'maxlength'=>255, 'class' => 'form-control numeric-control', 'placeHolder' => "¢")); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 form-group form-group-sm">
                    <label class="col-md-3">Attach Insurance Card, Letter or Document </label>      
                    <div class="col-md-9">
                        <input type="file" name="Patient_medical_insurrance[]" multiple="multiple" accept="<?php echo $model->fileType ?>" />
                        <?php 
                            if ($action == 'update') {
                                $data['patient_id'] = $model->id;
                                $data['patient_medical_insurrance_id'] = isset($model->patientmedicalinsurrance) ? $model->patientmedicalinsurrance->id : 0;
                                $data['type'] = 'insurrance_card'; 
                                echo $cms->formatDocumentDelete($data);
                            }
                        ?>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="col-md-4">
                <div class="col-md-12 form-group form-group-sm">
                    <label class="col-md-3">Entitlement </label>      
                    <div class="col-md-9">
                        <div class="row">
                            <div class="col-md-6" style="display: inline-flex;">
                                <span style="margin-right: 5px; margin-top: 3px;">$</span>
                                <?php echo $form->textField($model,'medical_entitlement_from',array('size'=>47,'maxlength'=>255, 'class' => 'form-control numeric-control', 'placeHolder' => "$")); ?>
                            </div>
                            <div class="col-md-6" style="display: inline-flex;">
                                <span style="margin-right: 5px; margin-top: 3px;">$</span>
                                <?php echo $form->textField($model,'medical_entitlement_to',array('size'=>47,'maxlength'=>255, 'class' => 'form-control numeric-control', 'placeHolder' => "¢")); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>


<style>
    .amount-copayment{
        display none;
    }
</style>

<script>
    $(document).ready(function () {
        $('#Patient_medical_copayment').trigger('change');
    })

    $('#Patient_medical_copayment').change(function () {
        var copayment = $(this).val();
        if (copayment == '1') //yes
        {
            $('.amount-copayment').css({'display': 'block'});
        }
        else {
            $('.amount-copayment').css({'display': 'none'});
        }
    });

    var urlDeleteDocument = '<?php echo $this->createAbsoluteUrl("patients/deleteDocument"); ?>';
</script>