
<div id="pageHeader">
    <div class="logo">
        <h1><a href="<?php echo Yii::app()->createAbsoluteUrl(''); ?>" title="Property Cottage"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/PropertyCottage-Logo.png" alt="Property Cottage"></a></h1>
    </div>
    <div class="top-right-content">
        <div class="contact-no"><span>For sales<br>and enquiries</span><?php echo Yii::app()->params['contactFreeText']; ?></div>
        <div class="clear"></div>
        <nav class="nav">
            <div id="topMenu">
                <ul class="menu">
                    <?php
                    $menu = new ShowMenuFE();
                    echo $menu->showMainMenuFE();
                    ?>
                </ul>                        
            </div>
        </nav>
    </div>
</div>
