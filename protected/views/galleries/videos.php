<div class="row">
    <div class="col-sm-3">
        <h3 class="title-2">Videos</h3>
        <ul class="nav-list">
            <ul class="nav-list">
                <li><a href="<?php echo Yii::app()->createAbsoluteUrl('galleries/photos/') ?>">Photos</a></li>
                <li class="active"><a href="<?php echo Yii::app()->createAbsoluteUrl('galleries/videos/') ?>">Videos</a></li>
            </ul>
        </ul>
    </div>
    <div class="col-sm-9">
		<?php
			$this->widget('zii.widgets.CListView', array(
				'dataProvider'=>  $model->findGallery(),
				'id' =>'video',
				'itemView'=>'_videoitem',
				'ajaxUpdate'=>false,
				'itemsTagName'=>'div',
				'itemsCssClass'=>'',
				'pagerCssClass'=>'pager clearfix',
				'template'=>"{pager}\n{items}\n<div class='pagination-wrapper'>{summary}\n{pager}</div>",
				'emptyText' => 'No products found',
				'summaryText' => 'Showing items {start}-{end} of {count}',
				'enablePagination'=>true,
				'pager' => array(
					'maxButtonCount' => 10,
					'header' => false,
					'firstPageLabel' => 'FIRST',
					'prevPageLabel' =>  '&nbsp;',
					'nextPageLabel' =>  '&nbsp;',
					'lastPageLabel' =>  'LAST',
					'maxButtonCount'=>3,
					'htmlOptions'=>array('class'=>'pager clearfix')
				),
			));
		?>
		
                   
        </div>
    </div>
</div>