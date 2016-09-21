<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Patient's Next of Kin</h3>
    </div>
    <div class="panel-body">
        <div class="form form-horizontal">
            <div class="col-md-4">
                <h4>Spouse / Partner</h4>

                <div class="row">
                    <div class="col-md-12 form-group form-group-sm">
                        <label  class="col-md-3">Name</label>      
                        <div class="col-md-9">
                            <?php echo $form->textField($model,'spouse_name',array('size'=>47,'maxlength'=>255, 'class' => 'form-control')); ?>
                        </div>    
                    </div>

                    <div class="col-md-12 form-group form-group-sm">
                        <label  class="col-md-3">Contact Number</label>      
                        <div class="col-md-9">
                            <div class="row phonenumber">
                                <div class="col-md-3">
                                    <?php echo $form->dropDownList($model,'spouse_mobile', DeclareHelper::$mobileFormat ,array('class' => 'form-control')); ?>                            
                                </div>
                                <div class="col-md-6">
                                    <?php echo $form->dropDownList($model,'spouse_country', AreaCode::getAreaCode() ,array('class' => 'form-control')); ?>
                                </div>
                                <div class="col-md-3">
                                    <?php echo $form->textField($model,'spouse_number',array('size'=>47,'maxlength'=>255, 'class' => 'form-control')); ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    

                    <div class="col-md-12 form-group form-group-sm">
                        <label class="col-md-3">ID  </label>      
                        <div class="col-md-9">
                            <?php echo $form->textField($model,'spouse_identity',array('size'=>47,'maxlength'=>255, 'class' => 'form-control', 'placeHolder' => 'NRIC/WORK PERMIT/PASSPORT NO')); ?>
                            <?php echo $form->error($model,'spouse_identity'); ?>
                        </div>
                    </div>

                    <div class="col-md-12 form-group form-group-sm">
                        <label class="col-md-3">Dob  </label>      
                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-md-6">
                                    <?php                    
                                        echo $form->textField($model,'spouse_dob',
                                            array(
                                                'size'=>47,
                                                'maxlength'=>255, 
                                                'class' => 'form-control my-dob-datepicker'
                                        )); 
                                    ?>                                
                                </div>
                                <div class="col-md-2"><label>Age</label></div>
                                <div class="col-md-4 spouse-age">0</div>
                                <?php echo $form->hiddenField($model,'spouse_age',array('class' => 'form-control')); ?>
                            </div>

                        </div>
                    </div>

                    <div class="col-md-12 form-group form-group-sm">
                        <label class="col-md-3">Occupation  </label>      
                        <div class="col-md-9">
                            <?php echo $form->textField($model,'spouse_occupation',array('size'=>47,'maxlength'=>255, 'class' => 'form-control')); ?>
                            <?php echo $form->error($model,'spouse_occupation'); ?>
                        </div>
                    </div>

                    <div class="col-md-12 form-group form-group-sm">
                        <label class="col-md-3">Company  </label>      
                        <div class="col-md-9">
                            <?php echo $form->textField($model,'spouse_company',array('size'=>47,'maxlength'=>255, 'class' => 'form-control')); ?>
                            <?php echo $form->error($model,'spouse_company'); ?>
                        </div>
                    </div>

                    <div class="col-md-12 form-group form-group-sm">
                        <label class="col-md-3">Comments  </label>      
                        <div class="col-md-9">
                            <?php echo $form->textArea($model,'spouse_comment', array('cols'=>"60", 'row'=>"5", 'class' => '', 'style' => 'width: 100%;')); ?>
                            <?php echo $form->error($model,'spouse_comment'); ?>  
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <h4>Next of Kin </h4>
                <div class="row">
                    <div class="col-md-12 form-group form-group-sm">
                        <label  class="col-md-3">Relationship</label>      
                        <div class="col-md-9">
                            <?php echo $form->textField($model,'nok_relationship_1',array('size'=>47,'maxlength'=>255, 'class' => 'form-control')); ?>
                            <?php echo $form->error($model,'nok_relationship_1'); ?>           
                        </div>    
                    </div>

                    <div class="col-md-12 form-group form-group-sm">
                        <label  class="col-md-3">Name</label>      
                        <div class="col-md-9">
                            <?php echo $form->textField($model,'nok_name_1',array('size'=>47,'maxlength'=>255, 'class' => 'form-control')); ?>
                            <?php echo $form->error($model,'nok_name_1'); ?>        
                        </div>    
                    </div>

                    <div class="col-md-12 form-group form-group-sm">
                        <label  class="col-md-3">Contact Number</label>      
                        <div class="col-md-9">
                            <div class="row phonenumber">
                                <div class="col-md-3">
                                    <?php echo $form->dropDownList($model,'nok_mobile_1', DeclareHelper::$mobileFormat ,array('class' => 'form-control')); ?>                            
                                </div>
                                <div class="col-md-6">
                                    <?php echo $form->dropDownList($model,'nok_country_1', AreaCode::getAreaCode() ,array('class' => 'form-control')); ?>
                                </div>
                                <div class="col-md-3">
                                    <?php echo $form->textField($model,'nok_number_1',array('size'=>47,'maxlength'=>255, 'class' => 'form-control')); ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 form-group form-group-sm">
                        <label class="col-md-3">Occupation  </label>      
                        <div class="col-md-9">
                            <?php echo $form->textField($model,'nok_occupation_1',array('size'=>47,'maxlength'=>255, 'class' => 'form-control')); ?>
                            <?php echo $form->error($model,'nok_occupation_1'); ?>
                        </div>
                    </div>

                    <div class="col-md-12 form-group form-group-sm">
                        <label class="col-md-3">Company  </label>      
                        <div class="col-md-9">
                            <?php echo $form->textField($model,'nok_company_1',array('size'=>47,'maxlength'=>255, 'class' => 'form-control')); ?>
                            <?php echo $form->error($model,'nok_company_1'); ?>
                        </div>
                    </div>

                    <div class="col-md-12 form-group form-group-sm">
                        <label class="col-md-3">Comments  </label>      
                        <div class="col-md-9">
                            <?php echo $form->textArea($model,'nok_comment_1', array('cols'=>"60", 'row'=>"5", 'class' => '', 'style' => 'width: 100%;')); ?>
                            <?php echo $form->error($model,'nok_comment_1'); ?>  
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <h4>Name of person to contact in Singapore </h4>
                <div class="row">
                    <div class="col-md-12 form-group form-group-sm">
                        <label  class="col-md-4">Singapore Contact Number  </label>      
                        <div class="col-md-8">
                            <?php echo $form->textField($model,'singapore_contact_number',array('size'=>47,'maxlength'=>255, 'class' => 'form-control')); ?>
                        </div>
                    </div>

                    <div class="col-md-12 form-group form-group-sm">
                        <label  class="col-md-4">Singapore Address </label>      
                        <div class="col-md-8">
                            <?php echo $form->textField($model,'singapore_address',array('size'=>47,'maxlength'=>255, 'class' => 'form-control')); ?>
                        </div>
                    </div>

                    <div class="col-md-12 form-group form-group-sm">
                        <label  class="col-md-4">Person to contact in Singapore </label>      
                        <div class="col-md-8">
                            <?php echo $form->textField($model,'person_contact_singapore',array('size'=>47,'maxlength'=>255, 'class' => 'form-control')); ?>
                        </div>
                    </div>

                    <div class="col-md-12 form-group form-group-sm">
                        <label class="col-md-4">Relationship  </label>      
                        <div class="col-md-8">
                            <?php echo $form->textField($model,'relationship',array('size'=>47,'maxlength'=>255, 'class' => 'form-control')); ?>
                            <?php echo $form->error($model,'relationship'); ?>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>