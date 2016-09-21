
        
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?php echo $this->pluralTitle ?></h3>
            </div>
            <div class="panel-body">
                <div class="form-horizontal">
                    <div class="form">
                        <div class="row">
                            <div class="col-md-6 form-group form-group-sm">
                                <?php echo $form->labelEx($model,'company_name', array('class' => 'col-md-4')); ?>  
                                <div class="col-md-8">
                                <?php echo $form->textField($model,'company_name',array('size'=>47,'maxlength'=>255, 'class' => 'form-control')); ?>
                                <?php echo $form->error($model,'company_name'); ?>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group form-group-sm">
                            <?php echo $form->labelEx($model,'department', array('class' => 'col-md-4')); ?>  
                                <div class="col-md-8">
                                <?php echo $form->textField($model,'department',array('rows'=>5,'cols'=>76, 'style' => "width: 100%;", 'class' => '')); ?>
                                <?php echo $form->error($model,'department'); ?>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group form-group-sm">
                            <?php echo $form->labelEx($model,'staff_no', array('class' => 'col-md-4')); ?>  
                                <div class="col-md-8">
                                <?php echo $form->textField($model,'staff_no',array('rows'=>5,'cols'=>76, 'style' => "width: 100%;", 'class' => '')); ?>
                                <?php echo $form->error($model,'staff_no'); ?>
                                </div>
                            </div>

                        </div>

                        <div class="row">   
                            <div class="col-md-6 form-group form-group-sm">
                                <label class="col-md-4">Entitlement Amount  </label>      
                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <?php echo $form->textField($model,'entitlement_from',array('size'=>47,'maxlength'=>255, 'class' => 'form-control numeric-control', 'placeHolder' => "$")); ?>
                                        </div>
                                        <div class="col-md-6">
                                            <?php echo $form->textField($model,'entitlement_to',array('size'=>47,'maxlength'=>255, 'class' => 'form-control numeric-control', 'placeHolder' => "¢")); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 form-group form-group-sm">
                            <?php echo $form->labelEx($model,'to_bill_insurrance', array('class' => 'col-md-4')); ?>  
                                <div class="col-md-8">
                                <?php echo $form->dropDownList($model,'to_bill_insurrance', DeclareHelper::$toBillInsuranceFormat ,array('class' => 'form-control')); ?>
                                <?php echo $form->error($model,'to_bill_insurrance'); ?>
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-6 form-group form-group-sm">
                            <?php echo $form->labelEx($model,'insurrance_name', array('class' => 'col-md-4')); ?>  
                                <div class="col-md-8">
                                <?php echo $form->textField($model,'insurrance_name',array('rows'=>5,'cols'=>76, 'style' => "width: 100%;", 'class' => '')); ?>
                                <?php echo $form->error($model,'insurrance_name'); ?>
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-6 form-group form-group-sm">
                            <?php echo $form->labelEx($model,'follow', array('class' => 'col-md-4')); ?>  
                                <div class="col-md-8">
                                <?php echo $form->dropDownList($model,'follow', DeclareHelper::$followFormat ,array('class' => 'form-control')); ?>
                                <?php echo $form->error($model,'follow'); ?>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group form-group-sm">
                            <?php echo $form->labelEx($model,'copayment', array('class' => 'col-md-4')); ?>  
                                <div class="col-md-8">
                                <?php echo $form->dropDownList($model,'copayment', DeclareHelper::$yesNoFormat ,array('class' => 'form-control')); ?>
                                <?php echo $form->error($model,'copayment'); ?>
                                </div>
                            </div>

                        </div>

                        <div class="row amount-copayment">   
                            <div class="col-md-6 form-group form-group-sm">
                                <label class="col-md-4">Copayment Amount  </label>      
                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <?php echo $form->textField($model,'copayment_amount_from',array('size'=>47,'maxlength'=>255, 'class' => 'form-control numeric-control', 'placeHolder' => "$")); ?>
                                        </div>
                                        <div class="col-md-6">
                                            <?php echo $form->textField($model,'copayment_amount_to',array('size'=>47,'maxlength'=>255, 'class' => 'form-control numeric-control', 'placeHolder' => "¢")); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 form-group form-group-sm">
                            <label class="col-md-4">Attach Insurance Card, Letter or Document </label> 
                                <div class="col-md-8">
                                    <input type="file" name="PatientMedicalInsurrance_card[]" multiple="multiple" accept="<?php echo $model->fileType ?>" />
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
        $('#PatientMedicalInsurrance_copayment').trigger('change');
    })

    $('#PatientMedicalInsurrance_copayment').change(function () {
        var copayment = $(this).val();
        if (copayment == '1') //yes
        {
            $('.amount-copayment').css({'display': 'block'});
        }
        else {
            $('.amount-copayment').css({'display': 'none'});
        }
    });
</script>