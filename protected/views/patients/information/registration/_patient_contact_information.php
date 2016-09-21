
<?php 
    $cms = new BaseFormatter();
    $dob = $cms->formatDate($model->dob);
?>

<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Patient Contact Information</h3>
    </div>
    <div class="panel-body">
        <div class="form">
            <div class="row">
                <div class="col-md-4">
                    <h4>Residential Address </h4>   

                    <div class="form-group form-group-sm clearfix">
                        <label  class="col-md-4">Country: </label>      
                        <div class="col-md-8 ">
                            <?php echo AreaCode::model()->getAreaCodeSpecific($model->residential_country, true); ?>
                        </div>    
                    </div>
                    
                    <div class="form-group form-group-sm clearfix">
                        <label  class="col-md-4">Block / House: </label>
                        <div class="col-md-8 "> 
                            <?php echo $model->residential_block_house ?>
                            Unit #
                            <?php 
                                $sub = (!empty($model->residential_unit_from) && !empty($model->residential_unit_to )) ? " - " : "";
                                echo $model->residential_unit_from .$sub.$model->residential_unit_to;
                            ?>
                        </div>
                    </div>

                    <div class="form-group form-group-sm clearfix">
                        <label  class="col-md-4">Street: </label>      
                        <div class="col-md-8 ">
                            <?php echo $model->residential_street ?>        
                        </div>   
                    </div>

                    <div class="form-group form-group-sm clearfix">
                        <label  class="col-md-4">Building Name: </label>      
                        <div class="col-md-8 ">
                            <?php echo $model->residential_building_name ?>    
                        </div>   
                    </div>

                    <div class="form-group form-group-sm clearfix">
                        <label  class="col-md-4">Postal Code: </label>      
                        <div class="col-md-7">
                            <?php echo $model->residential_postal_code ?>        
                        </div>   
                    </div>
                </div>

                <div class="col-md-4">
                    <label  class="form-group form-group-sm"><h4>Malling Address</h4> </label>  

                    <div class="form-group form-group-sm clearfix">
                        <label  class="col-md-4">Country: </label>      
                        <div class="col-md-8 ">
                            <?php echo AreaCode::model()->getAreaCodeSpecific($model->mailling_country, true); ?> 
                        </div>    
                    </div>
                    
                    <div class="form-group form-group-sm clearfix">
                        <label  class="col-md-4">Block / House: </label> 
                        <div class="col-md-8 ">
                            <?php echo $model->mailling_block_house ?>
                            Unit #
                            <?php 
                                $sub = (!empty($model->mailling_unit_from) && !empty($model->mailling_unit_to )) ? " - " : "";
                                echo $model->mailling_unit_from .$sub.$model->mailling_unit_to;
                            ?>
                        </div>
                        
                    </div>

                    <div class="form-group form-group-sm clearfix">
                        <label  class="col-md-4">Street: </label>      
                        <div class="col-md-8 ">
                            <?php echo $model->mailling_street ?>          
                        </div>   
                    </div>

                    <div class="form-group form-group-sm clearfix">
                        <label  class="col-md-4">Building Name: </label>      
                        <div class="col-md-8 ">
                            <?php echo $model->mailling_building_name ?>          
                        </div>   
                    </div>

                    <div class="form-group form-group-sm clearfix">
                        <label  class="col-md-4">Postal Code: </label>      
                        <div class="col-md-8 ">
                            <?php echo $model->mailling_postal_code ?> 
                        </div>   
                    </div>
                </div>
                <div class="col-md-4">
                    <label  class="form-group form-group-sm"><h4>Contact Number </h4> </label>      

                    <div class="form-group form-group-sm clearfix">
                        <?php
                            $string = '';
                            $country = AreaCode::model()->getAreaCodeSpecific($model->contact_country_1);
                            if(!empty($model->contact_mobile_1) && !empty($country) && !empty($model->contact_number_1))
                                $string .= $model->contact_mobile_1.' - '.$country.' - '.$model->contact_number_1;
                            echo $string;
                        ?>
                    </div>
                    <div class="form-group form-group-sm clearfix">
                        Preferred Contact: <?php echo $model->referred_contact_1 ? "Yes" : "No"; ?>
                    </div>
                    
                    <div class="form-group form-group-sm clearfix">
                        <?php
                            $string = '';
                            $country = AreaCode::model()->getAreaCodeSpecific($model->contact_country_2);
                            if(!empty($model->contact_mobile_2) && !empty($country) && !empty($model->contact_number_2))
                                $string .= $model->contact_mobile_2.' - '.$country.' - '.$model->contact_number_2;
                            echo $string;
                        ?>
                    </div>
                    <div class="form-group form-group-sm clearfix">
                        Preferred Contact: <?php echo $model->referred_contact_2 ? "Yes" : "No"; ?>
                    </div>

                    <div class="form-group form-group-sm clearfix">
                        <?php
                            $string = '';
                            $country = AreaCode::model()->getAreaCodeSpecific($model->contact_country_3);
                            if(!empty($model->contact_mobile_3) && !empty($country) && !empty($model->contact_number_3))
                                $string .= $model->contact_mobile_3.' - '.$country.' - '.$model->contact_number_3;
                            echo $string;
                        ?>                        
                    </div>
                    <div class="form-group form-group-sm clearfix">
                        Preferred Contact: <?php echo $model->referred_contact_3 ? "Yes" : "No"; ?>
                    </div>
                    <div class="form-group form-group-sm clearfix">
                        Email: <?php echo $model->contact_email ?>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>