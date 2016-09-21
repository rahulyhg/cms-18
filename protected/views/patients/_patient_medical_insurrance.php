
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
                        <div class="col-md-12">Attach Insurance Card, Letter or Document</div> 
                        <div class="col-md-12">
                            <table class="table table-striped table-bordered">
                                        <tbody id="image-main-3">
                                            <?php $number = 0; ?>
                                            <?php if(!$model->isNewRecord):?>
                                                        <?php  $file_attach_insurance = PatientAttachFile::model()->findAll('patient_id = :patient_id and type = 3',array(':patient_id'=>$model->id));?>
                                            <?php endif;?> 
                                            <?php if (isset($file_attach_insurance) && !empty($file_attach_insurance)): ?>
                                                <?php foreach ($file_attach_insurance as $key => $file): ?>
                                                    <tr class="image-item-3">
                                                        <td class="col-md-5"   title="Click to add file">
                                                            <input type="file"  title="Click to add file" data-type="3"  class="image-imageFile hide" name="Patient[attach_insurance_file][<?php echo $number ?>]" accept="*"/>
                                                            <a href="javascript:void(0)" class="click-file-3 hide"><i style="font-size: 40px;" class="glyphicon glyphicon-file"></i></a>
                                                            <p class="file-text-show"><?php echo $file->name;?></p>
                                                        </td>
                                                        <td class="col-md-7">
                                                            <input type="text" value="<?php echo $file->id;?>" class="image-id form-control hide" name="Patient[attach_insurance_file_id][<?php echo  $number ?>]" />
                                                            <textarea cols="30"  placeholder="Description" class="image-description" name="Patient[attach_insurance_description][<?php echo  $number ?>]" ><?php echo $file->description;?></textarea>
                                                        </td>
                                                        <td style="width: 3%">
                                                            <div class="invoice-icon">
                                                                <i class="glyphicon glyphicon-minus"></i>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <?php $number += 1; ?>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr class="image-item-3">
                                                    <td class="col-md-5"  title="Click to add file">
                                                        <input data-type="3"  title="Click to add file" type="file" class="image-imageFile hide" name="Patient[attach_insurance_file][<?php echo  $number ?>]" accept="*" />
                                                        <a href="javascript:void(0)" class="click-file-3"><i style="font-size: 40px;" class="glyphicon glyphicon-file"></i></a>
                                                    </td>
                                                    <td class="col-md-7">
                                                           <textarea cols="30"  placeholder="Description"  class="image-description" name="Patient[attach_insurance_description][<?php echo  $number ?>]" ></textarea>
                                                    </td>
                                                    <td style="width: 3%">
                                                        <div class="invoice-icon">
                                                            <i class="glyphicon glyphicon-minus"></i>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                </table>
                                <div class="col-sm-12">
                                    <div class="row">
                                        <div class="invoice-icon">
                                        <i class="glyphicon glyphicon-plus glyphicon-plus-3" data-number="<?php echo $number + 1; ?>" data-type="3" data-name="attach_insurance"></i>
                                    </div>
                                    </div>
                                    
                                </div>
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
<!--                                <span style="margin-right: 5px; margin-top: 3px;">$</span>-->
                                <?php echo $form->textField($model,'medical_entitlement_from',array('size'=>47,'maxlength'=>255, 'class' => 'form-control numeric-control', 'placeHolder' => "$")); ?>
                            </div>
                            <div class="col-md-6" style="display: inline-flex;">
<!--                                <span style="margin-right: 5px; margin-top: 3px;">$</span>-->
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

    var urlDeleteDocument = '<?php echo Yii::app()->createAbsoluteUrl("site/deleteDocument"); ?>';
</script>