
<?php 
    $cms = new BaseFormatter();
?>
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Patient Medical Information On Registration</h3>
    </div>
    <div class="panel-body">
        <div class="form">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group form-group-sm clearfix">
                        <label class="col-md-5">Allergy </label>      
                        <div class="col-md-7">
                            <div class="form-group">
                                <?php echo DeclareHelper::$yesNoDontKnowFormat[$model->allergy] ?>  
                            </div>     
                        </div>
                    </div>

                    <div class="form-group form-group-sm clearfix">
                        <label class="col-md-5">Comment for allergy </label>      
                        <div class="col-md-7">
                            <div class="form-group">
                                <?php echo nl2br($model->comment_allergy) ?>  
                            </div>     
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group form-group-sm clearfix">
                        <label class="col-md-5">Have you ever had any medical illness? </label>      
                        <div class="col-md-7">
                            <div class="form-group">
                                <?php echo DeclareHelper::$yesNoDontKnowFormat[$model->had_any_medical_illness] ?>  
                            </div>     
                        </div>
                    </div>

                    <div class="form-group form-group-sm clearfix">
                        <label class="col-md-5">Comment for medical illness </label>      
                        <div class="col-md-7">
                            <div class="form-group">
                                <?php echo nl2br($model->comment_had_any_medical_illness) ?>  
                            </div>     
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group form-group-sm clearfix">
                        <label class="col-md-5">Referral </label>      
                        <div class="col-md-7">
                            <div class="form-group">
                                <?php echo DeclareHelper::$referralFormat[$model->referral] ?> 
                            </div>     
                        </div>
                    </div>

                    <div class="form-group form-group-sm clearfix">
                        <label class="col-md-5">Comment for referral </label>      
                        <div class="col-md-7">
                            <div class="form-group">
                                <?php echo nl2br($model->comment_referral) ?>   
                            </div>     
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group form-group-sm clearfix">
                        <label class="col-md-5">G6PD Deficiency </label>      
                        <div class="col-md-7">
                            <div class="form-group">
                                <?php echo DeclareHelper::$yesNoDontKnowFormat[$model->g6pd_deficiency] ?>      
                            </div>     
                        </div>
                    </div>

                    <div class="form-group form-group-sm clearfix">
                        <label class="col-md-5">Comment for g6pd-deficient </label>      
                        <div class="col-md-7">
                            <div class="form-group">
                                <?php echo nl2br($model->comment_g6pd_deficiency) ?>  
                            </div>     
                        </div>
                    </div>

                </div>
                <div class="col-md-4">
                    <div class="form-group form-group-sm clearfix">
                        <label class="col-md-5">Have you ever had any surgery? </label>      
                        <div class="col-md-7">
                            <div class="form-group">
                                <?php echo DeclareHelper::$yesNoDontKnowFormat[$model->had_any_surgery] ?>       
                            </div>     
                        </div>
                    </div>

                    <div class="form-group form-group-sm clearfix">
                        <label class="col-md-5">Comment for surgery </label>      
                        <div class="col-md-7">
                            <div class="form-group">
                                <?php echo nl2br($model->comment_had_any_surgery) ?>  
                            </div>     
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group form-group-sm clearfix">  
                        <div class="col-md-12">
                            <div class="form-group">
                                <?php
                                        $fileInventory = PatientAttachFile::model()->findAll('patient_id = :patient_id and type = 1',array(':patient_id'=>$model->id));
                                        if(!empty($fileInventory )):
                                  ?>
                                <div class="row">
                                    <div class="col-md-12">
                                        <h4>Attach Referal Letter </h4>
                                        <div class="col-md-12">
                                            <table class="table table-striped table-bordered">
                                                <thead>
                                                    <th width="30%">File Name</th>
                                                    <th width="70%">Description</th>
                                                </thead>
                                                <tbody>
                                                  <?php foreach ($fileInventory as $item):?>
                                                        <tr>
                                                            <td><a target="_blank"  title="download file <?php echo $item->file;?>" href="<?php echo Yii::app()->createAbsoluteUrl('/').'/upload/patient/'.$model->id.'/referral_letter/'.$item->file;?>"><?php echo $item->name;?><a/></td>
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
                        
                        <div class="col-md-12">
                            <div class="form-group">
                                <?php
                                        $fileInventory = PatientAttachFile::model()->findAll('patient_id = :patient_id and type = 2',array(':patient_id'=>$model->id));
                                        if(!empty($fileInventory )):
                                  ?>
                                <div class="row">
                                    <div class="col-md-12">
                                        <h4>Attach Report</h4>
                                        <div class="col-md-12">
                                            <table class="table table-striped table-bordered">
                                                <thead>
                                                    <th width="30%">File Name</th>
                                                    <th width="70%">Description</th>
                                                </thead>
                                                <tbody>
                                                  <?php foreach ($fileInventory as $item):?>
                                                        <tr>
                                                            <td><a target="_blank" title="download file <?php echo $item->file;?>" href="<?php echo Yii::app()->createAbsoluteUrl('/').'/upload/patient/'.$model->id.'/report/'.$item->file;?>"><?php echo $item->name;?><a/></td>
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
    $(document).ready(function(){
        $('#allergy').trigger('change');
        $('#medical-illness').trigger('change');
        $('#g6pd-deficient').trigger('change');
        $('#surgery').trigger('change');
        $('#referal').trigger('change');
    })

    $('#allergy').change(function(){
        var allergy = $(this).val();
        if (allergy == '1') //yes
        {
            $('.comment-allgery').css({'display':'block'});
        }
        else{
            $('.comment-allgery').css({'display':'none'});   
        }
    });

    $('#medical-illness').change(function(){
        var medical_illness = $(this).val();
        if (medical_illness == '1') //yes
        {
            $('.comment-medical-illness').css({'display':'block'});
        }
        else{
            $('.comment-medical-illness').css({'display':'none'});   
        }
    });

    $('#g6pd-deficient').change(function(){
        var g6pd_deficient = $(this).val();
        if (g6pd_deficient == '1') //yes
        {
            $('.comment-g6pd-deficient').css({'display':'block'});
        }
        else{
            $('.comment-g6pd-deficient').css({'display':'none'});   
        }
    });

    $('#surgery').change(function(){
        var surgery = $(this).val();
        if (surgery == '1') //yes
        {
            $('.comment-surgery').css({'display':'block'});
        }
        else{
            $('.comment-surgery').css({'display':'none'});   
        }
    });

    $('#referal').change(function(){
        var referal = $(this).val();
        if (referal == '1' || referal == 2) //yes
        {
            $('.comment-referal').css({'display':'block'});
        }
        else{
            $('.comment-referal').css({'display':'none'});   
        }
    });

</script>