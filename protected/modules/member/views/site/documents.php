<div class="container main">
	<div class="col-sm-3">
		<?php $this->renderPartial('_menu');?>
	</div>
	<div class="col-sm-9">
		<div class="bn-inner">
			<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
				<div class="carousel-inner">
					<div class="item active">
						<img src="<?php echo Yii::app()->theme->baseUrl; ?>/img/about-bn.jpg" alt="banner" />
					</div>
					<div class="item">
						<img src="<?php echo Yii::app()->theme->baseUrl; ?>/img/product-bn.jpg" alt="banner" />
					</div>
				</div>
			</div>
		</div>
		<div class="document">
			<?php $this->widget('zii.widgets.grid.CGridView', array(
			'id'=>'prec-whitepaper-grid',
			'dataProvider'=>  $model->searchFE(),
			'enableSorting' => false,
			'ajaxUpdate' => false,
			//'filter'=>$model,
			'pager' => array(
				'maxButtonCount' => 5,
				'header' => false,
				'firstPageLabel' => 'First',
				'prevPageLabel' =>  'Previous',
				'nextPageLabel' =>  'Next',
				'lastPageLabel' =>  'Last',
			),            
			'columns'=>array(
					array(
						'header' => 'S/N',
						'type' => 'raw',
						'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
						'headerHtmlOptions' => array('width' => '30px','style' => 'text-align:center;'),
						'htmlOptions' => array('style' => 'text-align:center;')
					),

					 array(
						'header' => 'Name',
						'value'=>'$data->document_name',
					),                       

					array(
						'header' => '',
						'type' => 'DocumentDownload',
						'value'=>'$data',
						'headerHtmlOptions' => array('width' => '50px','style' => 'text-align:center !important;'),
					),
			),
	)); ?>

		</div>
	</div>
</div><!-- form -->

