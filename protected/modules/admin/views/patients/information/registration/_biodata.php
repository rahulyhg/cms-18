
<?php 
    $cms = new BaseFormatter();
    $dob = $cms->formatDate($model->dob);
    $registration_date = $cms->formatDate($model->registration_date);
    $languages = $cms->formatLanguageName($model->id);
    $doctor = isset($model->doctor) ? $model->doctor->name : "";
?>

<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Patient Registration Biodata</h3>
    </div>
    <div class="panel-body">
        <div class="form form-horizontal">
            <div class="col-md-4 ">
                <div class="form-group form-group-sm clearfix">
                    <label  class="col-md-4">Salutation  </label>      
                    <div class="col-md-8 "> <?php echo $model->salutation ?></div>
                </div>
                <div class="form-group form-group-sm clearfix">
                    <label  class="col-md-4">Name  </label>      
                    <div class="col-md-8 ">
                         <?php echo $model->name ?>
                    </div>
                </div>
                <div class="form-group form-group-sm clearfix">
                    <label  class="col-md-4">ID  </label>      
                    <div class="col-md-8 ">
                        <?php echo $model->identity ?>
                    </div>
                </div>
                <div class="form-group form-group-sm clearfix">
                    <label  class="col-md-4">Nationality  </label>      
                    <div class="col-md-8 ">
                        <?php echo $model->nationality ?>              
                    </div>
                </div>
                <div class="form-group form-group-sm clearfix">
                    <label  class="col-md-4">Dob  </label>      
                    <div class="col-md-8 ">
                        <?php echo $dob ?>
                    </div>
                </div>
                <div class="form-group form-group-sm clearfix">
                    <label  class="col-md-4">Important Comment To Notes  </label>      
                    <div class="col-md-8">
                        <?php echo nl2br($model->important_comment_to_notes) ?>
                    </div>
                </div>
            </div>
            <div class="col-md-4 ">
                <div class="form-group form-group-sm clearfix">
                    <label  class="col-md-4">Gender </label>      
                    <div class="col-md-8 "><?php echo $model->gender ?></div>
                </div>
                <div class="form-group form-group-sm clearfix">
                    <label  class="col-md-4">Marital Status  </label>      
                    <div class="col-md-8 ">
                        <?php echo $model->marital ?>           
                    </div>
                </div>
                <div class="form-group form-group-sm clearfix">
                    <label  class="col-md-4">Race  </label>      
                    <div class="col-md-8 ">
                        <?php 
                            if ( $model->race == 'others' ) {
                                echo $model->text_race;
                            }
                            else{
                                echo Race::getName($model->race);
                            }
                        ?>            
                    </div>
                </div>
                <div class="form-group form-group-sm clearfix">
                    <label  class="col-md-4">Religion  </label>      
                    <div class="col-md-8 ">
                        <?php 
                            if ( $model->religion == 'others' ) {
                                echo $model->text_religion;
                            }
                            else{
                                echo Religion::getName($model->religion);
                            }
                        ?>
                    </div>
                </div>
                <div class="form-group form-group-sm clearfix">
                    <label  class="col-md-4">Language(s) Spoken  </label>      
                    <div class="col-md-8 ">
                        <?php echo $languages; ?>                
                    </div>
                </div>
            </div>
            <div class="col-md-4 ">
                <div class="form-group form-group-sm clearfix">
                    <label  class="col-md-4">Registration Date  </label>      
                    <div class="col-md-8 "><?php echo $registration_date ?>
                    </div>
                </div>
                <div class="form-group form-group-sm clearfix">
                    <label  class="col-md-4">Reference No  </label>      
                    <div class="col-md-8 ">
                        <?php echo $model->reference_no ?>
                    </div>
                </div>
                <div class="form-group form-group-sm clearfix">
                    <label  class="col-md-4">Occupation  </label>      
                    <div class="col-md-8">
                        <?php echo $model->occupation ?>
                    </div>
                </div>
                <div class="form-group form-group-sm clearfix">
                    <label  class="col-md-4">Company  </label>      
                    <div class="col-md-8">
                        <?php echo $model->company ?>
                    </div>
                </div>
                <div class="form-group form-group-sm clearfix">
                    <label  class="col-md-4">Doctor  </label>      
                    <div class="col-md-8">
                        <?php echo $doctor ?>
                    </div>
                </div>
            </div>
   
        </div>
    </div>
</div>
