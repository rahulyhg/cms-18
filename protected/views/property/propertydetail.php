
<div class="container">        
    <div id="breadcrumb"><a href="<?php echo Yii::app()->createAbsoluteUrl(''); ?>">Home</a> / <a href="<?php echo Yii::app()->createAbsoluteUrl('property'); ?>">Property Showcase</a> / <?php echo $model->title; ?></div>
    <div class="clear"></div>
    <div class="box1 clearfix">
        <div class="main">
            
            <div id="element-tabs">
                <ul class="tab-nav">
                    <li><a class="overview <?php if (empty($_POST)) echo 'current'; ?>" href="#tabnavone">Overview</a></li>
                    <li><a class="location" href="#tabnavtwo">Location</a></li>
                    <li><a class="ebrouchure <?php if (isset($_POST['Brouchuredownloads'])) echo 'current'; ?>" href="#tabnavthree">E Brochure</a></li>
                    <li><a class="enquiry <?php if (isset($_POST['Propertysearch']) || isset($_POST['Valuationrequests'])) echo 'current'; ?>" href="#tabnavfour">Enquiry</a></li>
                </ul>
                <div class="list-wrap">
                    <div class="<?php if (!empty($_POST)) echo 'hide'; ?>" id="tabnavone">
                        <div class="pageTitle">Project Info / Location</div>
                        <div class="clear"></div>
                        <?php echo $model->over_view; ?>
                    </div>

                    <div class="hide" id="tabnavtwo">
                        <h6>Location</h6>
                        <div id="map_canvas" class="map" style=" background-color: rgb(229, 227, 223);">
                        </div>
                    </div>

                    <div class="<?php if (!isset($_POST['Brouchuredownloads'])) echo 'hide'; ?>" id="tabnavthree">
                        <div class="pageTitle">E Brochure</div>
                        <div class="clear"></div>
                        <div class="contactFormWrapper">  
                            <?php $this->widget("ShowEbrouchureWidget", array('property_id' => $model->id)); ?>
                        </div>
                    </div>

                    <div class="<?php if (!isset($_POST['Propertysearch']) && !isset($_POST['Valuationrequests'])) echo 'hide';?>" id="tabnavfour">
                        <h2 class="pageTitle">Enquiry</h2>
                        <div class="leftContainer">
                            <?php echo $model->contact_enquiry; ?>
                        </div>

                        <div class="rightContainer">
                        </div>

                        <div class="clear"></div>

                        <div class="leftContainer">
                            <h2 class="box-heading">Property Search</h2>
                            <div class="contactFormWrapper">
                                <?php $this->widget("ShowPropertySearchWidget", array('property_id' => $model->id)); ?>
                            </div>
                        </div>
                        <div class="rightContainer">
                            <h2 class="box-heading">Valuation Request</h2>
                            <div class="contactFormWrapper">
                                <?php $this->widget("ShowValuationRequestWidget", array('property_id' => $model->id)); ?>
                            </div>
                        </div>
                    </div>
                </div>    
            </div>
        </div>
    </div>
</div>

<script src="http://maps.google.com/maps/api/js?sensor=false"></script>
<style type="text/css">
    .header{
        background: none repeat scroll 0 0 #7f0000;
        border-right: 1px solid;
        color: white;
        padding: 5px;
    }  

    .brouchure-fe tr{
        border-bottom: 1px solid;
    }  
</style>

<script>
    var map;
    var myLatlng;
    function initialize() {
        var latitude;
        var longitude;
        var geocoder = new google.maps.Geocoder();
        var address_head_office = "<?php echo $model->address; ?>";
        var name_head_office = "<?php echo $model->title; ?>";

        geocoder.geocode({'address': address_head_office}, function (results, status) {

            if (status == google.maps.GeocoderStatus.OK)
            {
                latitude = results[0].geometry.location.lat();
                longitude = results[0].geometry.location.lng();
                myLatlng = new google.maps.LatLng(latitude, longitude);

                var myOptions = {
                    zoom: 15,
                    center: results[0].geometry.location,
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                }

                map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
                map.setCenter(results[0].geometry.location);
                var contentString = '<div style="width:300px" id="content">' +
                        '<h1>' + name_head_office + '</h1>' +
                        '<div>' +
                        '<p>' + address_head_office + '</p>' +
                        '</div>' +
                        '</div>';

                var infowindow = new google.maps.InfoWindow({
                    content: contentString,
                    maxWidth: 500
                });

                var pinpng = "<?php echo Yii::app()->theme->baseUrl . '/images/map-icon.png'; ?>";
                var companyImage = new google.maps.MarkerImage(pinpng,
                        new google.maps.Size(32, 47),
                        new google.maps.Point(0, 0),
                        new google.maps.Point(50, 50)
                        );

                var marker = new google.maps.Marker({
                    position: myLatlng,
                    map: map,
                    icon: companyImage,
                    title: 'Singapore'
                });
                google.maps.event.addListener(marker, 'click', function () {
                    infowindow.open(map, marker);
                });
            }
        });
    }


    // jQuery(document).ready(function(){
    // jQuery(function(){
    initialize();
    // });
    // });
</script>            
