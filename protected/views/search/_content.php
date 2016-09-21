<div class="itemsearch">
    <div class="titlesearch">
    <a href="<?php echo Yii::app()->createAbsoluteUrl($data->slug) ?>"><?php echo $data->title;?></a>
        </div>
    <div class="itemsearch">
        <?php echo StringHelper::createShort($data->description,400,true,true);?>
    </div>
</div>
