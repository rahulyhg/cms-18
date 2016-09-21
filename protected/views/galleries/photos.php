<div class="row">
    <div class="col-sm-3">
        <h3 class="title-2">gallery</h3>
        <ul class="nav-list">
            <ul class="nav-list">
                <li class="active"><a href="<?php echo Yii::app()->createAbsoluteUrl('galleries/photos/') ?>">Photos</a></li>
                <li ><a href="<?php echo Yii::app()->createAbsoluteUrl('galleries/videos/') ?>">Videos</a></li>
            </ul>
        </ul>
    </div>
    <div class="col-sm-9">
        <ul class="gallery isotope clearfix">
            <?php
			$photoList = $model->findGallery();
            $img='';
            foreach ($photoList->data as $item) {
                $img.='<li class="element-item"><a href="'.ImageHelper::getImageUrl($item, 'fileurl','photo') .'" caption="'.$item->title.'" class="show" rel="gallery">';
                $img.='<img src="'.ImageHelper::getImageUrl($item, 'fileurl', 'thumb1').'" alt="'.$item->title.'" /></a></li>';
                $img.='</a></li>';
            }
            echo $img;
            ?>
        </ul>
    </div>
</div>