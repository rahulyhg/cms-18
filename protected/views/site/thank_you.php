<div class="main">
    <div class="container">
        <div class="breadcrumb"><a href="<?php echo yii::app()->createAbsoluteUrl('site')?>">Home</a> / Sponsors</div>
        <div class="row">
            <div class="col-sm-9">
                <h1>Your request has been successful. !</h1>
            </div>
            <!--right menu-->
            <div class="col-sm-3">
                <div class="clearfix"><a href="<?php echo yii::app()->createAbsoluteUrl('site')?>" class="back">Back to Home</a></div>
                <?php $this->widget('RightColumn', array('title' => 'Quick Links','data' => $quick_links)); ?>
                <?php $this->widget('RightColumn', array('title' => 'Event Details','data' => $events)); ?>
                <div class=""><a href="<?php echo yii::app()->createAbsoluteUrl('site/register')?>" class="btn-2">register now</a></div>
            </div>
            <!--right menu-->

        </div>

    </div>  
</div>
