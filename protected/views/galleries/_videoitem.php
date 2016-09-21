<div class="row item-video">
	<div class="col-xs-6">
		<div class="col-video">
		<?php 
			$youtubeUrl = str_replace('https:', '', $data->youtubeurl);
			$youtubeUrl = str_replace('watch?v=', 'embed/', $youtubeUrl);
		
		?>
		<iframe allowfullscreen="" frameborder="0" height="232" src="<?php echo $youtubeUrl;?>" width="100%"></iframe>
		</div>
	</div>
	<div class="col-xs-6">
		<h3><?php echo $data->title?></h3>
		<!--p>by avpsolutions1</p>
		<p>5,699,878 views</p-->
	</div>
</div>
