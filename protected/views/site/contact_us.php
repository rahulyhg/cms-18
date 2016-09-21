
<div class="main">
    <div id="breadcrumb"><a href="<?php echo Yii::app()->createAbsoluteUrl(''); ?>">Home</a> / Contact Us</div>
        <h2 class="pageTitle">Contact Us</h2>
        <div class="contactFormOuter">
            <?php echo Yii::app()->params['contactTitle']; ?>
            <?php echo SmartBlock::getBlockContent(15); ?>  
            <div class="contactFormContainer">                  
                <h2 class="box-heading">Enquiry Form</h2>
                <div class="contactFormWrapper">
                    <?php $form=$this->beginWidget('CActiveForm', array(
                        'id'=>'contact-us-form',
                        // 'enableClientValidation' => true,
                        'enableAjaxValidation' => false,
                        'clientOptions' => array(
                            'validateOnSubmit' => true,
                        ),
                    )); ?>
                    <table class="contactForm">
                        <tr>
                            <td>Name:</td>
                            <td>
                                <?php echo $form->textField($model,'name', array('maxlength'=>200,'class'=>'input','placeholder'=>'Name')); ?>
                                <?php echo $form->error($model,'name'); ?>
                            </td>
                            
                        </tr>

                        <tr>
                            <td>Mobile:</td>
                            <td>
                                <?php echo $form->textField($model,'contact_no', array('maxlength'=>200,'class'=>'input','placeholder'=>'Contact no'));?>
                                <?php echo $form->error($model,'contact_no'); ?>
                            </td>
                            
                        </tr>

                        <tr>
                            <td>Email:</td>
                            <td>
                                <?php echo $form->textField($model,'email', array('maxlength'=>200,'class'=>'input','placeholder'=>'Email Address'));?>
                                <?php echo $form->error($model,'email'); ?>
                            </td>
                            
                        </tr>

                        <tr>
                            <td>Message:</td>
                            <td>
                                <?php echo $form->textArea($model,'message', array('cols'=>50,'rows'=>5,'class'=>'textarea','placeholder'=>'Message'));?>
                                <?php echo $form->error($model,'message'); ?>
                            </td>
                            
                        </tr>      

                        <tr>
                            <td>&nbsp;</td>
                            <td><input type="submit" value="Submit" class="submit"></td>
                        </tr>

                    </table>                        
                    
                    <?php $this->endWidget(); ?>
                </div>
            </div>
        </div>
        <div class="addressBox">                    
            <?php echo SmartBlock::getBlockContent(16); ?>  
            <div id="map_canvas" class="map">
            </div>
        </div>
    </div>
</div>

<script src="http://maps.google.com/maps/api/js?sensor=false"></script>
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/map.js"></script>

<script>
function initialize() {
    var latitude;
    var longitude;
    var geocoder = new google.maps.Geocoder();
    var address_head_office = "<?php echo Yii::app()->setting->getItem('companyAddress'); ?>";
    var name_head_office = "<?php echo Yii::app()->setting->getItem('companyName'); ?>";

    geocoder.geocode( { 'address': address_head_office}, function(results, status) {

        if (status == google.maps.GeocoderStatus.OK) 
        {
                latitude = results[0].geometry.location.lat();
                longitude = results[0].geometry.location.lng();
                var myLatlng = new google.maps.LatLng(latitude, longitude);
                var myOptions = {
                  zoom: 16,
                  center: myLatlng,
                  mapTypeId: google.maps.MapTypeId.ROADMAP
                }
                
                var map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
                
                var contentString = '<div style="width:300px" id="content">'+
                    '<h1>'+name_head_office+'</h1>'+
                    '<div>'+
                    '<p>'+address_head_office+'</p>'+
                    '</div>'+
                    '</div>';

                var infowindow = new google.maps.InfoWindow({
                    content: contentString,
                    maxWidth: 500
                });
                
                var pinpng = "<?php echo Yii::app()->theme->baseUrl.'/images/map-icon.png'; ?>";    
                var companyImage = new google.maps.MarkerImage( pinpng,
                    new google.maps.Size(161,65),
                    new google.maps.Point(0,0),
                    new google.maps.Point(0,0)
                );

                var marker = new google.maps.Marker({
                    position: myLatlng,
                    map: map,
                    icon: companyImage,
                    title: 'Singapore'
                });
                google.maps.event.addListener(marker, 'click', function() {
                  infowindow.open(map,marker);
                });
        } 
    }); 
}

initialize();
</script>