<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Patient Contact Information</h3>
    </div>
    <div class="panel-body">
        <div class="form form-horizontal">
            <div class="col-md-4">
                <div class="row">
                    <h4>Residential Address</h4>
                </div>
                <div class="col-md-12 form-group form-group-sm">
                    <?php echo $form->labelEx($model,'residential_country', array('class' => 'col-md-4')); ?>      
                    <div class="col-md-8">
                        <?php echo $form->dropDownList($model,'residential_country', AreaCode::loadArrArea() ,array('class' => 'form-control', 'empty' => 'Select Country')); ?>
                        <?php echo $form->error($model,'residential_country'); ?>                   
                    </div>
                </div>
                <div class="col-md-12 form-group form-group-sm">
                    <label  class="col-md-4">Block / House No</label>      
                    <div class="col-md-8">
                        <div class="row phonenumber">
                            <div class="col-md-3">
                                <?php echo $form->textField($model,'residential_block_house',array('size'=>47,'maxlength'=>255, 'class' => 'form-control')); ?>
                            </div>
                            <div class="col-md-3 alignright"><label  class="alignright">Unit #</label></div>
                            <div class="col-md-3">
                                <?php echo $form->textField($model,'residential_unit_from',array('placeHolder' => '','size'=>47,'maxlength'=>255, 'class' => 'form-control numeric-control')); ?>
                            </div>
                            <div class="col-md-3">
                                <?php echo $form->textField($model,'residential_unit_to',array('placeHolder' => '', 'size'=>47,'maxlength'=>255, 'class' => 'form-control numeric-control')); ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 form-group form-group-sm">
                    <label  class="col-md-4">Street  </label>      
                    <div class="col-md-8">
                        <?php echo $form->textField($model,'residential_street',array('size'=>47,'maxlength'=>255, 'class' => 'form-control')); ?>
                    </div>
                </div>
                <div class="col-md-12 form-group form-group-sm">
                    <label  class="col-md-4">Building Name  </label>      
                    <div class="col-md-8">
                        <?php echo $form->textField($model,'residential_building_name',array('size'=>47,'maxlength'=>255, 'class' => 'form-control')); ?>
                    </div>
                </div>
                <div class="col-md-12 form-group form-group-sm">
                    <label class="col-md-4">Postal Code  </label>      
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-5">
                                <?php echo $form->textField($model,'residential_postal_code',array('size'=>47,'maxlength'=>255, 'class' => 'form-control numeric-control postal-code')); ?>
                            </div>
                            <div class="col-md-7 residential_postal_name"></div>
                            <?php echo $form->hiddenField($model,'residential_geo_name',array('class' => 'form-control')); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="row">
                    <h4>Mailing Address</h4>
                </div>
                <div class="row">
                    <div class="col-md-12 form-group form-group-sm">
                        <label  class="col-md-4"></label>     
                        <div class="col-md-8">
                            <?php echo $form->checkbox($model, 'same_resedential_address'); ?> 
                            Mailing address is same as residential address 
                        </div>

                        <label  class="col-md-4">Country  </label>      
                        <div class="col-md-8">
                            <?php echo $form->dropDownList($model,'mailling_country', AreaCode::loadArrArea() ,array('class' => 'form-control', 'empty' => 'Select Country')); ?>
                            <?php echo $form->error($model,'mailling_country'); ?>                
                        </div>
                    </div>
                    <div class="col-md-12 form-group form-group-sm">
                        <label  class="col-md-4">Block / House No </label>      
                        <div class="col-md-8">
                            <div class="row phonenumber">
                                <div class="col-md-3">
                                    <?php echo $form->textField($model,'mailling_block_house',array('size'=>47,'maxlength'=>255, 'class' => 'form-control numeric-control')); ?>
                                </div>
                                <div class="col-md-3 alignright"><label  class="alignright">Unit #</label></div>
                                <div class="col-md-3">
                                    <?php echo $form->textField($model,'mailling_unit_from',array('placeHolder' => '','size'=>47,'maxlength'=>255, 'class' => 'form-control numeric-control')); ?>
                                </div>
                                <div class="col-md-3">
                                    <?php echo $form->textField($model,'mailling_unit_to',array('placeHolder' => '', 'size'=>47,'maxlength'=>255, 'class' => 'form-control numeric-control')); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 form-group form-group-sm">
                        <label  class="col-md-4">Street  </label>      
                        <div class="col-md-8">
                            <?php echo $form->textField($model,'mailling_street',array('size'=>47,'maxlength'=>255, 'class' => 'form-control')); ?>            
                        </div>
                    </div>
                    <div class="col-md-12 form-group form-group-sm">
                        <label  class="col-md-4">Building Name  </label>      
                        <div class="col-md-8">
                            <?php echo $form->textField($model,'mailling_building_name',array('size'=>47,'maxlength'=>255, 'class' => 'form-control')); ?>            
                        </div>
                    </div>

                    <div class="col-md-12 form-group form-group-sm">
                        <label  class="col-md-4">Postal Code  </label>      
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-5">
                                    <?php echo $form->textField($model,'mailling_postal_code',array('size'=>47,'maxlength'=>255, 'class' => 'form-control numeric-control postal-code')); ?>
                                </div>
                                <div class="col-md-7 mailling_postal_name"></div>
                                <?php echo $form->hiddenField($model,'mailling_geo_name',array('class' => 'form-control')); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="row">
                    <h4>Contact Number</h4>
                </div>
                <div class="row">
                    <div class="col-md-12 form-group form-group-sm">
                        <label  class="col-md-2">Contact Number</label>      
                        <div class="col-md-10">
                            <div class="row phonenumber">
                                <div class="col-md-3">
                                    <?php echo $form->dropDownList($model,'contact_mobile_1', DeclareHelper::$mobileFormat ,array('class' => 'form-control')); ?>                            
                                </div>
                                <div class="col-md-6">
                                    <?php echo $form->dropDownList($model,'contact_country_1', AreaCode::getAreaCode() ,array('class' => 'form-control')); ?>
                                </div>
                                <div class="col-md-3">
                                    <?php echo $form->textField($model,'contact_number_1',array('size'=>47,'maxlength'=>255, 'class' => 'form-control numeric-control')); ?>
                                </div>
                            </div>
                            <div class="col-md-12 nopadding">
                                <?php echo $form->radioButton($model, 'preferred_contact', array('class' => 'referred_contact_1')); ?> Preferred contact
                                <?php echo $form->hiddenField($model, 'referred_contact_1') ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 form-group form-group-sm">
                        <label  class="col-md-2">Contact Number</label>      
                        <div class="col-md-10">
                            <div class="row phonenumber">
                                <div class="col-md-3">
                                    <?php echo $form->dropDownList($model,'contact_mobile_2', DeclareHelper::$mobileFormat ,array('class' => 'form-control')); ?>                            
                                </div>
                                <div class="col-md-6">
                                    <?php echo $form->dropDownList($model,'contact_country_2', AreaCode::getAreaCode() ,array('class' => 'form-control')); ?>
                                </div>
                                <div class="col-md-3">
                                    <?php echo $form->textField($model,'contact_number_2',array('size'=>47,'maxlength'=>255, 'class' => 'form-control numeric-control')); ?>
                                </div>
                            </div>
                            <div class="col-md-12 nopadding">
                                <?php echo $form->radioButton($model, 'preferred_contact', array('class' => 'referred_contact_2')); ?> Preferred contact
                                <?php echo $form->hiddenField($model, 'referred_contact_2') ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 form-group form-group-sm">
                        <label  class="col-md-2">Contact Number</label>      
                        <div class="col-md-10">
                            <div class="row phonenumber">
                                <div class="col-md-3">
                                    <?php echo $form->dropDownList($model,'contact_mobile_3', DeclareHelper::$mobileFormat ,array('class' => 'form-control')); ?>                            
                                </div>
                                <div class="col-md-6">
                                    <?php echo $form->dropDownList($model,'contact_country_3', AreaCode::getAreaCode() ,array('class' => 'form-control')); ?>
                                </div>
                                <div class="col-md-3">
                                    <?php echo $form->textField($model,'contact_number_3',array('size'=>47,'maxlength'=>255, 'class' => 'form-control numeric-control')); ?>
                                </div>
                            </div>
                            <div class="col-md-12 nopadding">
                                <?php echo $form->radioButton($model, 'preferred_contact', array('class' => 'referred_contact_3')); ?> Preferred contact
                                <?php echo $form->hiddenField($model, 'referred_contact_3') ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 form-group form-group-sm">
                        <label  class="col-md-2">Email </label>      
                        <div class="col-md-10">
                            <?php echo $form->textField($model,'contact_email',array('size'=>47,'maxlength'=>255, 'class' => 'form-control')); ?>
                            <?php echo $form->error($model,'contact_email'); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Jason -->
<!-- Setup to show full address from postal code -->
<script type="text/javascript">
    $(document).ready(function(){
        $("#Patient_dob").keydown(function(e){
            e.preventDefault();
        });
        $("#Patient_spouse_dob").keydown(function(e){
            e.preventDefault();
        });

        <?php 
            if ($model->referred_contact_1){
        ?>
        $('.referred_contact_1').trigger('click');
        <?php } ?>
        <?php 
            if ($model->referred_contact_2){
        ?>
        $('.referred_contact_2').trigger('click');
        <?php } ?>
        <?php 
            if ($model->referred_contact_3){
        ?>
        $('.referred_contact_3').trigger('click');
        <?php } ?>

        $('.referred_contact_1').on('click', function(){
            $('#Patient_referred_contact_1').val(1);
            $('#Patient_referred_contact_2').val(0);
            $('#Patient_referred_contact_3').val(0);
        });  
        $('.referred_contact_2').on('click', function(){
            $('#Patient_referred_contact_1').val(0);
            $('#Patient_referred_contact_2').val(1);
            $('#Patient_referred_contact_3').val(0);
        }); 
        $('.referred_contact_3').on('click', function(){
            $('#Patient_referred_contact_1').val(0);
            $('#Patient_referred_contact_2').val(0);
            $('#Patient_referred_contact_3').val(1);
        });       
    });
    
    function processPostalName(postalNameDiv, postalNameId, zipcode, type){
        // Clear error
        postalNameDiv.empty();

        $.post("http://maps.googleapis.com/maps/api/geocode/json?address="+zipcode+",Singapore&sensor=false", function (response){
            if (response['status'] != 'OK') {
                postalNameDiv.html("Unable to find postal code!");
                var street, buildingName, blockHouse = '';
                if ( type === 'residential_postal_name' ) {
                    $('#Patient_residential_block_house').val(blockHouse);
                    $('#Patient_residential_street').val(street);
                    //$('#Patient_residential_building_name').val(buildingName);
                }
                else{
                    $('#Patient_mailling_block_house').val(blockHouse);
                    $('#Patient_mailling_street').val(street);
                    //$('#Patient_mailling_building_name').val(buildingName);
                }
            }else{
                var lat = response['results'][0]['geometry']['location']['lat'];
                var lng = response['results'][0]['geometry']['location']['lng'];
                //alert('http://maps.googleapis.com/maps/api/geocode/json?latlng='+lat+','+lng+'&sensor=false');
                $.post('http://maps.googleapis.com/maps/api/geocode/json?latlng='+lat+','+lng+'&sensor=false', function(address) {
                    var street, buildingName, blockHouse = '';
                    //alert(address['results'][0]['address_components'].toString());
                    var blockHouse      = address['results'][0]['address_components'][0]['long_name'];
                    var street          = address['results'][0]['address_components'][1]['long_name'];
                    var buildingName    = address['results'][0]['address_components'][2]['long_name'];
                    if ( !$.isNumeric(blockHouse) ) {
                        if (typeof( address['results'][0]['address_components'][address['results'][0]['address_components'].length - 1]['long_name'] ) !== 'undefined') {
                            blockHouse      = address['results'][0]['address_components'][address['results'][0]['address_components'].length - 1]['long_name'];
                        }
                        else{
                            blockHouse      = '';
                        }
                    };
                    if ( type === 'residential_postal_name' ) {
                        $('#Patient_residential_block_house').val(blockHouse);
                        $('#Patient_residential_street').val(street);
                        //$('#Patient_residential_building_name').val(buildingName);
                    }
                    else{
                        $('#Patient_mailling_block_house').val(blockHouse);
                        $('#Patient_mailling_street').val(street);
                        //$('#Patient_mailling_building_name').val(buildingName);
                    }
                });
            }
        });
    };

    $(function() {
        // Set up event handlers
        $("#Patient_residential_postal_code").on("keyup change", function() {
            var postalNameDiv = $('.residential_postal_name');
            var zipcode = $(this).val();
            var postalNameId = $('#Patient_residential_geo_name');
            if (zipcode.length >= 0 && /^[0-9]+$/.test(zipcode))
            {
                processPostalName(postalNameDiv, postalNameId, zipcode, 'residential_postal_name');
            }
        }).trigger("change");

        $("#Patient_mailling_postal_code").on("keyup change", function() {
            var maillingPostalNameDiv = $('.mailling_postal_name');
            var maillingZipcode = $(this).val();
            var maillingPostalNameId = $('#Patient_mailling_geo_name');
            if (maillingZipcode.length >= 0 && /^[0-9]+$/.test(maillingZipcode))
            {
                processPostalName(maillingPostalNameDiv, maillingPostalNameId, maillingZipcode);
            }
        }).trigger("change");
    });

</script>
