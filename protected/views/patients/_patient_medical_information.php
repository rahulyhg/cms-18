
<?php
    $cms = new BaseFormatter();
    $action = Yii::app()->controller->action->id;
?>

<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Patient Medical Information on Registration</h3>
    </div>
    <div class="panel-body">
        <div class="form-horizontal">
            <div class="row">
                <div class="col-md-4">
                    <div class="col-md-12 form-group form-group-sm">
                        <?php echo $form->labelEx($model,'allergy', array('class' => 'col-md-4 leftlabel')); ?>  
                        <div class="col-md-6  form-group">
                            <?php echo $form->dropDownList($model,'allergy', DeclareHelper::$yesNoDontKnowFormat ,array('class' => 'form-control specialselect')); ?>
                            <?php echo $form->error($model,'allergy'); ?>
                        </div>
                        <div class="col-md-12 comment-allgery">
                            <?php echo $form->textArea($model,'comment_allergy', array('cols'=>"40", 'row'=>"5", 'class' => '', 'style' => 'width: 100%;', 'placeholder'=>"Comments for allergy")); ?>
                            <?php echo $form->error($model,'comment_allergy'); ?>   
                        </div>
                    </div>
                    
                    <div class="col-md-12 form-group form-group-sm">
                        <?php echo $form->labelEx($model,'g6pd_deficiency', array('class' => 'col-md-4 leftlabel')); ?>     
                        <div class="col-md-8  form-group">
                            <?php echo $form->dropDownList($model,'g6pd_deficiency', DeclareHelper::$yesNoDontKnowFormat ,array('class' => 'form-control specialselect')); ?>
                            <?php echo $form->error($model,'g6pd_deficiency'); ?>            
                        </div>
                        <div class="col-md-12  comment-g6pd-deficient">
                            <?php echo $form->textArea($model,'comment_g6pd_deficiency', array('cols'=>"40", 'row'=>"5", 'class' => '', 'style' => 'width: 100%;', 'placeholder'=>"Comments for g6PD-deficient")); ?>
                            <?php echo $form->error($model,'comment_g6pd_deficiency'); ?>   
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                  
                    <div class="col-md-12 form-group form-group-sm">
                        <?php echo $form->labelEx($model,'had_any_medical_illness', array('class' => 'col-md-7 leftlabel')); ?>     
                        <div class="col-md-5 form-group">
                            <?php echo $form->dropDownList($model,'had_any_medical_illness', DeclareHelper::$yesNoDontKnowFormat ,array('class' => 'form-control specialselect')); ?>
                            <?php echo $form->error($model,'had_any_medical_illness'); ?>            
                        </div>
                        <div class="col-md-12 comment-medical-illness">
                            <?php echo $form->textArea($model,'comment_had_any_medical_illness', array('cols'=>"40", 'row'=>"5", 'class' => '', 'style' => 'width: 100%;', 'placeholder'=>"Comments for medical illness")); ?>
                            <?php echo $form->error($model,'comment_had_any_medical_illness'); ?>   
                        </div>
                    </div>
                    <div class="col-md-12 form-group form-group-sm">
                        <?php echo $form->labelEx($model,'had_any_surgery', array('class' => 'col-md-6 leftlabel')); ?>     
                        <div class="col-md-5 form-group">
                            <?php echo $form->dropDownList($model,'had_any_surgery', DeclareHelper::$yesNoDontKnowFormat ,array('class' => 'form-control specialselect')); ?>
                            <?php echo $form->error($model,'had_any_surgery'); ?>
                        </div>
                        <div class="col-md-12 comment-surgery">
                            <?php echo $form->textArea($model,'comment_had_any_surgery', array('cols'=>"40", 'row'=>"5", 'class' => '', 'style' => 'width: 100%;', 'placeholder'=>"Comments for surgery")); ?>
                            <?php echo $form->error($model,'comment_had_any_surgery'); ?>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="col-md-12 form-group form-group-sm">
                        <?php echo $form->labelEx($model,'referral', array('class' => 'col-md-4 leftlabel')); ?>     
                        <div class="col-md-7 form-group">
                            <?php echo $form->dropDownList($model,'referral', DeclareHelper::$referralFormat ,array('class' => 'form-control specialselect')); ?>
                            <?php echo $form->error($model,'referral'); ?>
                        </div>
                        <div class="col-md-12 comment-referal">
                            <?php echo $form->textArea($model,'comment_referral', array('cols'=>"40", 'row'=>"5", 'class' => '', 'style' => 'width: 100%;', 'placeholder'=>"Comments for referral")); ?>
                            <?php echo $form->error($model,'comment_referral'); ?>
                        </div>
                    </div>
                    <div class="col-md-12 form-group form-group-sm">
                        <div class="col-md-12">Attach Referral Letter</div> 
                        <div class="col-md-12">
                            <div class="clearfix"></div>
                            <table class="table table-striped table-bordered">
                                        <tbody id="image-main-1">
                                            <?php $number = 0; ?>
                                                <?php if(!$model->isNewRecord):?>
                                                        <?php  $file_attach_letter = PatientAttachFile::model()->findAll('patient_id = :patient_id and type = 1',array(':patient_id'=>$model->id));?>
                                                <?php endif;?> 
                                              <?php if (isset($file_attach_letter) && !empty($file_attach_letter)): ?>
                                                    <?php foreach ($file_attach_letter as $key => $file):?>
                                                        <tr class="image-item-1">
                                                            <td class="col-md-5"  title="Click to add file">
                                                                <input type="file"   title="Click to add file" data-type="1"  class="image-imageFile hide" name="Patient[attach_referral_letter_file][<?php echo $number ?>]" accept="*"/>
                                                                <a href="javascript:void(0)" class="click-file-1 hide"><i style="font-size: 40px;" class="glyphicon glyphicon-file"></i></a>
                                                                <p class="file-text-show"><?php echo $file->name;?></p>
                                                            </td>
                                                            <td class="col-md-7">
                                                                <input type="text" value="<?php echo $file->id;?>" class="image-id form-control hide" name="Patient[attach_referral_letter_id][<?php echo  $number ?>]" />
                                                                <textarea cols="30"  placeholder="Description"  class="image-description" name="Patient[attach_referral_letter_description][<?php echo  $number ?>]" ><?php echo $file->description;?></textarea>
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
                                                <tr class="image-item-1">
                                                    <td class="col-md-5"   title="Click to add file">
                                                        <input type="file"   title="Click to add file" data-type="1"  class="image-imageFile hide" name="Patient[attach_referral_letter_file][<?php echo  $number ?>]" accept="*" />
                                                        <a href="javascript:void(0)" class="click-file-1"><i style="font-size: 40px;" class="glyphicon glyphicon-file"></i></a>
                                                    </td>
                                                    <td class="col-md-7">
                                                            <textarea cols="30"  placeholder="Description" class="image-description" name="Patient[attach_referral_letter_description][<?php echo  $number ?>]" ></textarea>
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
                                        <i class="glyphicon glyphicon-plus glyphicon-plus-1" data-number="<?php echo $number + 1; ?>" data-type="1" data-name="attach_referral_letter"></i>
                                    </div>
                                    </div>
                                    
                                </div>
                            </div>
                        

                    </div>
                    <div class="col-md-12 form-group form-group-sm">
                        <div class="col-md-12">Attach Report</div> 
                        <div class="col-md-12">
                            <table class="table table-striped table-bordered">
                                        <tbody id="image-main-2">
                                            <?php $number = 0; ?>
                                            <?php if(!$model->isNewRecord):?>
                                                        <?php  $file_attach_report = PatientAttachFile::model()->findAll('patient_id = :patient_id and type = 2',array(':patient_id'=>$model->id));?>
                                            <?php endif;?> 
                                            <?php if (isset($file_attach_report) && !empty($file_attach_report)): ?>
                                                <?php foreach ($file_attach_report as $key => $file): ?>
                                                    <tr class="image-item-2">
                                                        <td class="col-md-5"  title="Click to add file">
                                                            <input type="file"  title="Click to add file" data-type="2"  class="image-imageFile hide" name="Patient[attach_report_file][<?php echo $number ?>]" accept="*"/>
                                                            <a href="javascript:void(0)" class="click-file-2 hide"><i style="font-size: 40px;" class="glyphicon glyphicon-file"></i></a>
                                                            <p class="file-text-show"><?php echo $file->name;?></p>
                                                        </td>
                                                        <td class="col-md-7">
                                                            <input type="text" value="<?php echo $file->id;?>" class="image-id form-control hide" name="Patient[attach_report_file_id][<?php echo  $number ?>]" />
                                                            <textarea cols="30"  placeholder="Description" class="image-description" name="Patient[attach_report_description][<?php echo  $number ?>]" ><?php echo $file->description;?></textarea>
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
                                                <tr class="image-item-2">
                                                    <td class="col-md-5"  title="Click to add file">
                                                        <input data-type="2"   title="Click to add file" type="file" class="image-imageFile hide" name="Patient[attach_report_file][<?php echo  $number ?>]" accept="*" />
                                                        <a href="javascript:void(0)" class="click-file-2"><i style="font-size: 40px;" class="glyphicon glyphicon-file"></i></a>
                                                    </td>
                                                    <td class="col-md-7">
                                                            <textarea cols="30"  placeholder="Description"  class="image-description" name="Patient[attach_report_description][<?php echo  $number ?>]" ></textarea>
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
                                        <i class="glyphicon glyphicon-plus glyphicon-plus-2" data-number="<?php echo $number + 1; ?>" data-type="2" data-name="attach_report"></i>
                                    </div>
                                    </div>
                                    
                                </div>
                            </div>

                    </div>
                    
                </div>
            </div>
            
            <div class="clearfix"></div>
        </div>
    </div>
</div>

<style>
    .comment-allgery,
    .comment-medical-illness,
    .comment-g6pd-deficient
    .comment-surgery
    .comment-referal{
        display none;
    }
</style>

<script>
    $(document).ready(function () {
        $('#Patient_allergy').trigger('change');
        $('#medical-illness').trigger('change');
        $('#g6pd-deficient').trigger('change');
        $('#surgery').trigger('change');
        $('#referal').trigger('change');
    })

    $('#Patient_allergy').change(function () {
        var allergy = $(this).val();
        if (allergy == '1') //yes
        {
            $('.comment-allgery').css({'display': 'block'});
        }
        else {
            $('.comment-allgery').css({'display': 'none'});
        }
    });

    $('#Patient_had_any_medical_illness').change(function () {
        var medical_illness = $(this).val();
        if (medical_illness == '1') //yes
        {
            $('.comment-medical-illness').css({'display': 'block'});
        }
        else {
            $('.comment-medical-illness').css({'display': 'none'});
        }
    });

    $('#Patient_g6pd_deficiency').change(function () {
        var g6pd_deficient = $(this).val();
        if (g6pd_deficient == '1') //yes
        {
            $('.comment-g6pd-deficient').css({'display': 'block'});
        }
        else {
            $('.comment-g6pd-deficient').css({'display': 'none'});
        }
    });

    $('#Patient_had_any_surgery').change(function () {
        var surgery = $(this).val();
        if (surgery == '1') //yes
        {
            $('.comment-surgery').css({'display': 'block'});
        }
        else {
            $('.comment-surgery').css({'display': 'none'});
        }
    });

    $('#Patient_referral').change(function () {
        var referal = $(this).val();
        if (referal == '1' || referal == 2) //yes
        {
            $('.comment-referal').css({'display': 'block'});
        }
        else {
            $('.comment-referal').css({'display': 'none'});
        }
    });

    var urlDeleteDocument = '<?php echo Yii::app()->createAbsoluteUrl("site/deleteDocument"); ?>';
   
</script>
