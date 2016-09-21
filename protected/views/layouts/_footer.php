<div class="footer">
    <ul class="foot-nav">
        <?php
        $menu = new ShowMenuFE();
        echo $menu->showMenuFooterFE();
        ?>
    </ul>
    <div class="copyright">
        <?php echo Yii::app()->params['copyrightOnFooter'] ?>	
    </div>
</div>
<a href="<?php echo Yii::app()->createAbsoluteUrl('site/contactUsAjax') ?>" id="contactUs" style="display: inline;"></a>
