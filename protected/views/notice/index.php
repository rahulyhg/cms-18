<?php
/* @var $this DoctorController */
/* @var $dataProvider CActiveDataProvider */
$this->menu=array(
	// array('label' => Yii::t('static', 'Log out'), 'url' => array('/site/logout'), 'class' => 'btn-1'),
    array('label' => Yii::t('static', 'Add Notice'), 'url' => array('notice/create/'), 'class' => 'btn-1'),
    array('label' => Yii::t('static', 'Previous Page'), 'url' => 'javascript:history.go(-1)', 'class' => 'btn-1'),

);

$this->breadcrumbs = array(
    Yii::t('static', 'Black Out'),
);

$this->title = Yii::t('static', 'Notice Board');
?>

<div class="title-tb"><?php echo Yii::t('static','Notice Board')?>
	<div class="btn-add">
        <?php echo CHtml::link(Yii::t('static','Add'),array('notice/create/'),array(
            'data-toggle'=>'tooltip',
            'data-placement'=>'top',
            'title'=>Yii::t('static','Add'),
            'class'=>'ico ico-25',
        )) ?>
    </div>
</div>

<?php if (count($notice)  > 0) { ?>

<div class="scroll-pane scroll-4">
<table class="table tb-1 table-hover">
<thead>
<tr>
    <th style="width:80px;">&nbsp;</th>
    <th><?php echo Yii::t('model','Start Date')?></th>
    <th><?php echo Yii::t('model','End Date')?></th>
    <th><?php echo Yii::t('model','Title')?></th>
    <th><?php echo Yii::t('model','Content')?></th>
    <th style="width:80px;">&nbsp;</th>
    <th><?php echo Yii::t('model','Start Date')?></th>
    <th><?php echo Yii::t('model','End Date')?></th>
    <th><?php echo Yii::t('model','Title')?></th>
    <th><?php echo Yii::t('model','Content')?></th>
</tr>
</thead>
<tbody>
    <tr>
        <?php
        $count = 0;
        foreach ($notice as $item): ?>
        <td>
            <?php echo CHtml::link(Yii::t('static','Delete'),array('notice/delete','id'=>$item->id),array(
                'data-toggle'=>'tooltip',
                'data-placement'=>'top',
                'title'=>Yii::t('static','Delete'),
                'class'=>'ico ico-16 pull-right',
            )) ?>
            <?php echo CHtml::link(Yii::t('static','Update'),array('notice/update','id'=>$item->id),array(
                'data-toggle'=>'tooltip',
                'data-placement'=>'top',
                'title'=>Yii::t('static','Update'),
                'class'=>'ico ico-2 pull-right',
            )) ?></td>
        <td><?php echo Yii::app()->dateFormatter->format('EEE, MMM d, yyyy', $item->start)?></td>
        <td><?php echo Yii::app()->dateFormatter->format('EEE, MMM d, yyyy', $item->end)?></td>
        <td style="width:150px"><?php echo $item->title?></td>
        <td style="width:150px"><?php echo $item->content?></td>
        <?php if ((++$count%2) == 0) : ?>
            </tr>
            <tr>
        <?php endif; ?>
        <?php if (count($notice) == 1) : ?>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
        <?php endif; ?>
        
        <?php endforeach;  ?>
    </tr>

</tbody>
</table>
</div>
<?php } ?>
<style type="text/css">
.scroll-4 { height: 260px;}
div.title-tb {
    background: none repeat scroll 0 0 #da4a38;
    color: #fff;
    font-size: 14px;
    text-align: left;
    font-weight: bold;
    padding: 8px;
    margin-top: 10px;
}
.title-tb .btn-add { float:right; margin-top: -3px;}
</style>