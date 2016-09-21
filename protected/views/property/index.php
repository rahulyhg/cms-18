
<div class="main">
    <div id="breadcrumb"><a href="<?php echo Yii::app()->createAbsoluteUrl(''); ?>">Home</a> / Property Showcase</div>
        <h2 class="pageTitle">Property Showcase</h2>
        <div class="clear"></div>
            <?php
                $this->widget('zii.widgets.CListView', array(
                    'dataProvider'=>  $model->findActivePropertyShowcase(),
                    'id' =>'property',
                    'itemView'=>'_property',
                    'ajaxUpdate'=>false,
                    'itemsTagName'=>'div',
                    'itemsCssClass' => 'project-listing',
                    'template'=>"<div class='pagination-box'>{pager}</div>\n{items}\n<div class='pagination-box'>{pager}</div>",
                    'emptyText' => 'No properties found',
                    'summaryText' => '',
                    'enablePagination'=>true,
                    'pager' => array(
                        'maxButtonCount' => 10,
                        'header' => false,
                        'firstPageLabel' => '&nbsp;',
                        'prevPageLabel' =>  'PREVIOUS',
                        'nextPageLabel' =>  'NEXT',
                        'lastPageLabel' =>  '&nbsp;',
                        'maxButtonCount'=>3,
                        'htmlOptions'=>array('class'=>'pagination')
                    ),
                ));
            ?>                              
</div>

