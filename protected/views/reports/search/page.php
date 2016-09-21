<div class="container main">
    <div class="row">
            <?php
            $this->widget('zii.widgets.CListView', array(
                'dataProvider'=>  $model->search(),
                'id' =>'product',
                'itemView'=>'_content',
                'ajaxUpdate'=>false,
                'itemsTagName'=>'div',
                'itemsCssClass'=>'',
                'pagerCssClass'=>'pager clearfix',
                'template'=>"{pager}\n{items}\n<div class='pagination-wrapper'>{summary}\n{pager}</div>",
                'emptyText' => 'The search key was not found in any record',
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


