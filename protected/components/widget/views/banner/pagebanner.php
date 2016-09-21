<?php
if (!empty($data)):
	$i = 1;
	foreach ($data as $itemBanner){
		
		?>
		<div class="bn-inner">
			<?php if ($itemBanner->large_image != ''):?>
				<img src="<?php echo ImageHelper::getImageUrl($itemBanner, "large_image", "pagethumb") ?>" alt="<?php echo $itemBanner->banner_title; ?>" />
			<?php else: ?>
				<?php echo MyFunctionCustom::stripTagBannerString($itemBanner->banner_title); ?>
			<?php endif;?>
		</div>
	<?php
		$i++;
	}
endif;
?>
