<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
    <ol class="carousel-indicators">
		<?php
		if (!empty($data)):
			$i = 1;
			foreach ($data as $itemBanner){
			$class = '';
			if ($i == 1)
				$class = 'class="active"';
			?>
			<li data-target="#carousel-example-generic" data-slide-to="<?php echo $i; ?>" <?php echo $class;?>></li>
		<?php 
			$i++;
			}
		endif;
		?>
    </ol>
    <div class="carousel-inner">
		<?php
		if (!empty($data)):
			$i = 1;
			foreach ($data as $itemBanner){
				$class = '';
				if ($i == 1)
					$class = 'active';?>
        <div class="item <?php echo $class;?>">
            <div class="container clearfix">
                <div class="content">
                    <h1><?php echo MyFunctionCustom::stripTagBannerString($itemBanner->banner_title); ?></h1>
                    <p><?php echo MyFunctionCustom::stripTagBannerString($itemBanner->banner_description)?></p>
                </div>
                <div class="image">
                    <img src="<?php echo ImageHelper::getImageUrl($itemBanner, "large_image", "thumb1") ?>" alt="<?php echo $itemBanner->banner_title; ?>" />
                </div>
            </div>
        </div>
		<?php
			$i++;
			}
		endif;
		?>
       
    </div>
    <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left"></span>
    </a>
    <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right"></span>
    </a>
</div><!-- //banner -->
