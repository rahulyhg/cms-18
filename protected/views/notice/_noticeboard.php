<?php $this->widget('zii.widgets.CListView', array(
    'dataProvider'=>$notice->listData(),
    'itemView'=>'/notice/_notice',
    'emptyText'=>Yii::t('static','No records found.'),
    'enablePagination'=>false,
    'enableSorting'=>false,
    'itemsTagName'=>'ul',
    'template'=>'{items}'
));?>

<script type="text/javascript">
$(function(){
	$('.delete-action').click(function(){
		if ($(".notice-item:checked").length == 0) {
			alert('Select item then click delete');
            return false;
		}
	});
})
</script>