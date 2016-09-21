<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Patient Registration Biodata</h3>
    </div>
    <div class="panel-body">
        <div class="form form-horizontal">
            <div class="col-md-4">
                <div class="row">
                    <div class="col-md-12 form-group form-group-sm">
                        <?php echo $form->labelEx($model,'salutation', array('class' => 'col-md-4')); ?>  
                        <div class="col-md-8">
                            <?php echo $form->dropDownList($model,'salutation', DeclareHelper::$tilesFormat ,array('class' => 'form-control')); ?>
                            <?php echo $form->error($model,'salutation'); ?>
                        </div>
                    </div>
                    <div class="col-md-12 form-group form-group-sm">
                        <?php echo $form->labelEx($model,'name', array('class' => 'col-md-4')); ?>  
                        <div class="col-md-8">
                            <?php echo $form->textField($model,'name',array('size'=>47,'maxlength'=>255, 'class' => 'form-control')); ?>
                            <?php echo $form->error($model,'name'); ?>
                        </div>
                    </div>
                    <div class="col-md-12 form-group form-group-sm">
                        <?php echo $form->labelEx($model,'identity', array('class' => 'col-md-4')); ?>      
                        <div class="col-md-8">
                            <?php echo $form->textField($model,'identity',array('size'=>47,'maxlength'=>255, 'class' => 'form-control', 'placeHolder' => 'NRIC/WORK PERMIT/PASSPORT NO')); ?>
                            <?php echo $form->error($model,'identity'); ?>
                        </div>
                    </div>
                    <div class="col-md-12 form-group form-group-sm">
                        <?php echo $form->labelEx($model,'nationality', array('class' => 'col-md-4')); ?>          
                        <div class="col-md-8">
                            <?php echo $form->dropDownList($model,'nationality', AreaCode::loadArrNationality() ,array('class' => 'form-control', 'empty' => 'Select Nationality')); ?>
                            <?php echo $form->error($model,'nationality'); ?>         
                        </div>
                    </div>
                    <div class="col-md-12 form-group form-group-sm">
                        <?php echo $form->labelEx($model,'dob', array('class' => 'col-md-4')); ?>       
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-6">
                                    <?php                    
                                        echo $form->textField($model,'dob',
                                            array(
                                                'size'=>47,
                                                'maxlength'=>255, 
                                                'class' => 'form-control my-dob-datepicker'
                                        )); 
                                    ?>
                                    <?php echo $form->error($model,'dob'); ?>
                                </div>
                                <div class="col-md-2"><label>Age</label></div>
                                <div class="col-md-4 bio-age">
                                    <?php echo Yii::app()->controller->action->id == 'update' ? $model->age : 0 ?>
                                </div>
                                <?php echo $form->hiddenField($model,'age',array('class' => 'form-control')); ?>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="row">
                    <div class="col-md-12 form-group form-group-sm">
                        <?php echo $form->labelEx($model,'gender', array('class' => 'col-md-4')); ?>               
                        <div class="col-md-8">
                            <?php echo $form->dropDownList($model,'gender', DeclareHelper::$gendersFormat ,array('class' => 'form-control')); ?>
                            <?php echo $form->error($model,'gender'); ?>           
                        </div>
                    </div>
                    <div class="col-md-12 form-group form-group-sm">
                        <?php echo $form->labelEx($model,'marital', array('class' => 'col-md-4')); ?>                  
                        <div class="col-md-8">
                            <?php echo $form->dropDownList($model,'marital', DeclareHelper::$maritalFormat ,array('class' => 'form-control')); ?>
                            <?php echo $form->error($model,'marital'); ?>           
                        </div>
                    </div>
                    <div class="col-md-12 form-group form-group-sm">
                        <?php echo $form->labelEx($model,'race', array('class' => 'col-md-4')); ?>                   
                        <div class="col-md-8">
                            <?php 
                                $raceList = Race::getListDropdown();
                                $raceList['others'] = 'Others';
                            ?>
                            <?php echo $form->dropDownList($model,'race', $raceList ,array('class' => 'form-control', 'empty' => 'Select Race')); ?>
                            <?php echo $form->textField($model,'text_race',array('size'=>47,'maxlength'=>255, 'class' => 'form-control')); ?>
                            <?php echo $form->error($model,'race'); ?>        
                        </div>
                    </div>
                    <div class="col-md-12 form-group form-group-sm">
                        <?php echo $form->labelEx($model,'religion', array('class' => 'col-md-4')); ?>                       
                        <div class="col-md-8">
                            <?php 
                                $religionList = Religion::getListDropdown();
                                $religionList['others'] = 'Others';
                            ?>
                            <?php echo $form->dropDownList($model,'religion', $religionList ,array('class' => 'form-control', 'empty' => 'Select Religion')); ?>
                            <?php echo $form->textField($model,'text_religion',array('size'=>47,'maxlength'=>255, 'class' => 'form-control')); ?>
                            <?php echo $form->error($model,'religion'); ?> 
                        </div>
                    </div>
                    <div class="col-md-12 form-group form-group-sm">
                        <label  class="col-md-4">Language(s) Spoken  </label>  
                        <div class="col-md-8 wrap_multiselect_attribute display_none">
                            <?php
                            $data = Language::model()->loadAll();
                            echo CHtml::dropDownList('languages[]', $model->languages, $data, array('class' => 'multiselect_attribute', 'multiple' => 'multiple'));
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="row">
                    <div class="col-md-12 form-group form-group-sm">
                        <?php echo $form->labelEx($model,'registration_date', array('class' => 'col-md-4')); ?>                         
                        <div class="col-md-8">
                            <?php echo $form->textField($model,'registration_date',array('size'=>47,'maxlength'=>255, 'class' => 'form-control', 'readonly' => true)); ?>
                        </div>
                    </div>
                    <div class="col-md-12 form-group form-group-sm">
                        <?php echo $form->labelEx($model,'reference_no', array('class' => 'col-md-4')); ?>                             
                        <div class="col-md-8">
                            <?php echo $form->textField($model,'reference_no',array('size'=>47,'maxlength'=>255, 'class' => 'form-control', 'readonly' => true)); ?>
                        </div>
                    </div>
                    <div class="col-md-12 form-group form-group-sm">
                        <?php echo $form->labelEx($model,'occupation', array('class' => 'col-md-4')); ?>                             
                        <div class="col-md-8">
                            <?php echo $form->textField($model,'occupation',array('size'=>47,'maxlength'=>255, 'class' => 'form-control')); ?>
                            <?php echo $form->error($model,'occupation'); ?>
                        </div>
                    </div>
                    <div class="col-md-12 form-group form-group-sm">
                        <?php echo $form->labelEx($model,'company', array('class' => 'col-md-4')); ?>                               
                        <div class="col-md-8">
                            <?php echo $form->textField($model,'company',array('size'=>47,'maxlength'=>255, 'class' => 'form-control')); ?>
                            <?php echo $form->error($model,'company'); ?>
                        </div>
                    </div>
                    <div class="col-md-12 form-group form-group-sm">
                        <?php echo $form->labelEx($model,'doctor_id', array('class' => 'col-md-4')); ?>                                
                        <div class="col-md-8">
                            <?php echo $form->dropDownList($model,'doctor_id', Doctor::model()->loadAll() ,array('class' => 'form-control')); ?>
                            <?php echo $form->error($model,'doctor_id'); ?>      
                        </div>
                    </div>
                    <div class="col-md-12 form-group form-group-sm">
                        <?php echo $form->labelEx($model,'important_comment_to_notes', array('class' => 'col-md-4')); ?>                                      
                        <div class="col-md-8">
                            <?php echo $form->textArea($model,'important_comment_to_notes', array('cols'=>"60", 'row'=>"5", 'class' => '', 'style' => 'width: 100%;')); ?>
                            <?php echo $form->error($model,'important_comment_to_notes'); ?>   
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<style>
    .select2-container{
        width: 100% !important;
    }

    #Patient_text_race,
    #Patient_text_religion{
        margin-top: 10px;
    }
</style>

<?php 
    $action = Yii::app()->controller->action->id;
    if ($action == 'create') {
?>
<!-- Initialize the plugin: -->
<script type="text/javascript">
    $(function () {
        $(".multiselect_attribute").val("1").trigger("change");
    });
</script>
<?php 
    }
?>
<!-- Initialize the plugin: -->
<script type="text/javascript">

    $(function () {
        $('.multiselect_attribute').select2();
    });

    $(window).load(function () {
        $('.wrap_multiselect_attribute').show();
        $('.wrap_multiselect_hide').show();
        $('#Patient_race').trigger('change');
        $('#Patient_religion').trigger('change');
    });    

    $('#Patient_race').on('change', function(){
        var race = $(this).val();
        if ( race != 'others' ) {
            $('#Patient_text_race').hide();
            $('#Patient_text_race').val('');
        }
        else{
            $('#Patient_text_race').show();   
        }
    });

    $('#Patient_religion').on('change', function(){
        var religion = $(this).val();
        if ( religion != 'others' ) {
            $('#Patient_text_religion').hide();
            $('#Patient_text_religion').val('');
        }
        else{
            $('#Patient_text_religion').show();   
        }
    });
</script>

