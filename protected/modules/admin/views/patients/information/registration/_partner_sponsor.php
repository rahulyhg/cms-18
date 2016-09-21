<?php 
    $cms = new BaseFormatter();
    $dob = $cms->formatDate($model->spouse_dob);
?>

<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Patient's Next of Kin</h3>
    </div>
    <div class="panel-body">
        <div class="form">
            <div class="col-md-4">
                <label  class="form-group form-group-sm clearfix">
                    <h4>Spouse / Partner</h4>
                </label>   

                <div class="form-group form-group-sm clearfix">
                    <label  class="col-md-4">Name: </label>      
                    <div class="col-md-8 ">
                        <?php echo $model->spouse_name ?>          
                    </div>    
                </div>
                
                <div class="form-group form-group-sm clearfix">
                    <label  class="col-md-4">Contact Number: </label>      
                    <div class="col-md-8 ">
                        <?php
                            $string = '';
                            $country = AreaCode::model()->getAreaCodeSpecific($model->spouse_country);
                            if(!empty($model->spouse_mobile) && !empty($country) && !empty($model->spouse_number))
                                $string .= $model->spouse_mobile.' - '.$country.' - '.$model->spouse_number;
                            echo $string;
                        ?>
                    </div>  
                </div>

                <div class="form-group form-group-sm clearfix">
                    <label  class="col-md-4">Dob: </label>      
                    <div class="col-md-8 ">
                        <?php echo $dob; ?>
                    </div>   
                </div>

                <div class="form-group form-group-sm clearfix">
                    <label  class="col-md-4">ID: </label>      
                    <div class="col-md-8 ">
                        <?php echo $model->spouse_identity ?>
                    </div>   
                </div>

                <div class="form-group form-group-sm clearfix">
                    <label  class="col-md-4">Occupation: </label>      
                    <div class="col-md-8 ">
                        <?php echo $model->spouse_occupation ?>          
                    </div>   
                </div>

                <div class="form-group form-group-sm clearfix">
                    <label  class="col-md-4">Company: </label>      
                    <div class="col-md-8 ">
                        <?php echo $model->spouse_company ?>                    
                    </div>   
                </div>

                <div class="form-group form-group-sm clearfix">
                    <label  class="col-md-4">Comment: </label>      
                    <div class="col-md-8 ">
                        <?php echo nl2br($model->spouse_comment) ?>                    
                    </div>   
                </div>
            </div>

            <div class="col-md-4 form-group form-group-sm">
                <label  class="form-group form-group-sm clearfix"><h4>Next of Kin </h4> </label>  
                
                <div class="form-group form-group-sm clearfix">
                    <label  class="col-md-4">Relationship: </label>      
                    <div class="col-md-8">
                        <?php echo $model->nok_relationship_1 ?>           
                    </div>    
                </div>

                <div class="form-group form-group-sm clearfix">
                    <label  class="col-md-4">Name: </label>      
                    <div class="col-md-8 ">
                        <?php echo $model->nok_name_1 ?>                      
                    </div>    
                </div>
                
                <div class="form-group form-group-sm clearfix">
                    <label  class="col-md-4">Contact Number: </label>      
                    <div class="col-md-8 ">
                        <?php
                            $string = '';
                            $country = AreaCode::model()->getAreaCodeSpecific($model->nok_country_1);
                            if(!empty($model->nok_mobile_1) && !empty($country) && !empty($model->nok_number_1))
                                $string .= $model->nok_mobile_1.' - '.$country.' - '.$model->nok_number_1;
                            echo $string;
                        ?>
                    </div>  
                </div>

                <div class="form-group form-group-sm clearfix">
                    <label  class="col-md-4">Occupation: </label>      
                    <div class="col-md-8 ">
                        <?php echo $model->nok_occupation_1 ?>          
                    </div>   
                </div>

                <div class="form-group form-group-sm clearfix">
                    <label  class="col-md-4">Company: </label>      
                    <div class="col-md-8 ">
                        <?php echo $model->nok_company_1 ?>           
                    </div>   
                </div>

                <div class="form-group form-group-sm clearfix">
                    <label  class="col-md-4">Comment: </label>      
                    <div class="col-md-8 ">
                        <?php echo nl2br($model->nok_comment_1) ?>           
                    </div>   
                </div>
            </div>
            <div class="col-md-4 form-group form-group-sm">
                <label  class="form-group form-group-sm clearfix"><h4>Name of person to contact in Singapore  </h4> </label>      
                <div class="form-group form-group-sm clearfix">
                    <label  class="col-md-4">Singapore Contact Number:  </label>      
                    <div class="col-md-8 ">
                        <?php echo $model->singapore_contact_number ?>
                    </div>
                </div>
                <div class="form-group form-group-sm clearfix">
                    <label  class="col-md-4">Singapore Address: </label>      
                    <div class="col-md-8 ">
                        <?php echo $model->singapore_address ?>
                    </div>
                </div>
                <div class="form-group form-group-sm clearfix">
                    <label  class="col-md-4">Person to contact in Singapore: </label>      
                    <div class="col-md-8 ">
                        <?php echo $model->person_contact_singapore ?>
                    </div>
                </div>
                <div class="form-group form-group-sm clearfix">
                    <label  class="col-md-4">Relationship: </label>      
                    <div class="col-md-8 ">
                        <?php echo $model->relationship ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>