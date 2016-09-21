<?php
/* @var $this DoctorController */
/* @var $dataProvider CActiveDataProvider */
$this->menu=array(
    // array('label' => Yii::t('static', 'Log out'), 'url' => array('/site/logout'), 'class' => 'btn-1'),
    // array('label'=>Yii::t('static', '<img src="'.Yii::app()->baseUrl . '/css/images/icon-print-sm.png'.'"" /> Print Appointment'), 'url'=>array('/appointment/print_appointment'),'class'=>'btn-1'),
    // array('label'=>Yii::t('static', 'Add Appointment'), 'url'=>array('/appointment/create'),'class'=>'btn-1'),
    array('label' => Yii::t('static', 'Previous Page'), 'url' => 'javascript:history.go(-1)', 'class' => 'btn-1'),
);

$this->breadcrumbs = array(
    Yii::t('static', 'Black Out'),
);

$this->title = Yii::t('static', 'Blackouts & Doctor Leave');
?>
<?php if (Yii::app()->user->hasFlash('error')): ?>
    <div class="alert alert-danger">
        <?php echo Yii::app()->user->getFlash('error'); ?>
    </div>
<?php endif; ?>
<?php if (Yii::app()->user->hasFlash('message')): ?>
    <div class="alert alert-success">
        <?php echo Yii::app()->user->getFlash('message'); ?>
    </div>
<?php endif; ?>


<div class="title-tb"><?php echo Yii::t('static','Black Out Time')?>
    <div class="btn-add">
        <?php echo CHtml::link(Yii::t('static','Add'),array('blackout/create/?type=time'),array(
            'data-toggle'=>'tooltip',
            'data-placement'=>'top',
            'title'=>Yii::t('static','Add'),
            'class'=>'ico ico-25',
        )) ?>
    </div>
</div>
<?php if (count($modelTime) > 0): ?>
<div class="scroll-pane scroll-4">
<table class="table tb-1 table-hover">
<thead>
<tr>
    <th style="width:80px;">&nbsp;</th>
    <th><?php echo Yii::t('model','Doctor')?></th>
    <th><?php echo Yii::t('model','Start Date & Time')?></th>
    <th><?php echo Yii::t('model','End Date & Time')?></th>
    <th><?php echo Yii::t('model','Comments')?></th>
    <th style="width:80px;">&nbsp;</th>
    <th><?php echo Yii::t('model','Doctor')?></th>
    <th><?php echo Yii::t('model','Start Date & Time')?></th>
    <th><?php echo Yii::t('model','End Date & Time')?></th>
    <th><?php echo Yii::t('model','Comments')?></th>
</tr>
</thead>
<tbody>

    <tr>
        <?php
        $count = 0;
        foreach ($modelTime as $bo): ?>
        <td style="width:80px;">
            <?php echo CHtml::link(Yii::t('static','Delete'),array('blackout/delete','id'=>$bo->id),array(
                'data-toggle'=>'tooltip',
                'data-placement'=>'top',
                'title'=>Yii::t('static','Delete'),
                'class'=>'ico ico-16 pull-right',
            )) ?>
            <?php echo CHtml::link(Yii::t('static','Update'),array('blackout/update','id'=>$bo->id),array(
                'data-toggle'=>'tooltip',
                'data-placement'=>'top',
                'title'=>Yii::t('static','Update'),
                'class'=>'ico ico-2 pull-right',
            )) ?></td>
        <td><?php echo $bo->doctor->fullName?></td>
        <td><?php echo Yii::app()->dateFormatter->format('EEE, MMM d, yyyy H:mm', $bo->start)?></td>
        <td><?php echo Yii::app()->dateFormatter->format('EEE, MMM d, yyyy H:mm', $bo->end)?></td>
        <td style="width:150px"><?php echo $bo->comments?></td>
        <?php if ((++$count%2) == 0) : ?>
            </tr>
            <tr>
        <?php endif; ?>
        <?php if (count($modelTime) == 0) : ?>
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
        <?php if (count($modelTime) == 1) : ?>
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
<?php endif; ?>

<div class="title-tb"><?php echo Yii::t('static','Public Holiday = Black Out Date')?>
    <div class="btn-add">
        <?php echo CHtml::link(Yii::t('static','Add'),array('blackout/create/?type=holiday'),array(
            'data-toggle'=>'tooltip',
            'data-placement'=>'top',
            'title'=>Yii::t('static','Add'),
            'class'=>'ico ico-25',
        )) ?>
    </div>
</div>
<div class="scroll-pane scroll-4">
<?php if (count($modelHoliday) > 0): ?>
<table class="table tb-1 table-hover">
<thead>
<tr>
    <th style="width:80px;">&nbsp;</th>
    <th><?php echo Yii::t('model','Start Date')?></th>
    <th><?php echo Yii::t('model','End Date')?></th>
    <th><?php echo Yii::t('model','Comments')?></th>
    <th style="width:80px;">&nbsp;</th>
    <th><?php echo Yii::t('model','Start Date')?></th>
    <th><?php echo Yii::t('model','End Date')?></th>
    <th><?php echo Yii::t('model','Comments')?></th>
</tr>
</thead>
<tbody>
    <tr>
        <?php
        $count = 0;
        foreach ($modelHoliday as $bo): ?>
        <td style="width:80px;">
            <?php echo CHtml::link(Yii::t('static','Delete'),array('blackout/delete','id'=>$bo->id),array(
                'data-toggle'=>'tooltip',
                'data-placement'=>'top',
                'title'=>Yii::t('static','Delete'),
                'class'=>'ico ico-16 pull-right',
            )) ?>
            <?php echo CHtml::link(Yii::t('static','Update'),array('blackout/update','id'=>$bo->id),array(
                'data-toggle'=>'tooltip',
                'data-placement'=>'top',
                'title'=>Yii::t('static','Update'),
                'class'=>'ico ico-2 pull-right',
            )) ?></td>
        <td><?php echo Yii::app()->dateFormatter->format('EEE, MMM d, yyyy', $bo->start)?></td>
        <td><?php echo Yii::app()->dateFormatter->format('EEE, MMM d, yyyy', $bo->end)?></td>
        <td style="width:150px"><?php echo $bo->comments?></td>
        <?php if ((++$count%2) == 0) : ?>
            </tr>
            <tr>
        <?php endif; ?>
        <?php if (count($modelHoliday) == 0) : ?>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
        <?php endif; ?>
        <?php if (count($modelHoliday) == 1) : ?>
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
<?php endif; ?>



<div class="title-tb"><?php echo Yii::t('static','This is Not a Black Out Date = Other Events')?>
    <div class="btn-add">
        <?php echo CHtml::link(Yii::t('static','Add'),array('blackout/create/?type=other'),array(
            'data-toggle'=>'tooltip',
            'data-placement'=>'top',
            'title'=>Yii::t('static','Add'),
            'class'=>'ico ico-25',
        )) ?>
    </div>
</div>

<?php if (count($modelOther) > 0): ?>
<div class="scroll-pane scroll-4">
<table class="table tb-1 table-hover">
<thead>
<tr>
    <th style="width:80px;">&nbsp;</th>
    <th><?php echo Yii::t('model','Start Date')?></th>
    <th><?php echo Yii::t('model','End Date')?></th>
    <th><?php echo Yii::t('model','Comments')?></th>
    <th>&nbsp;</th>
    <th><?php echo Yii::t('model','Start Date')?></th>
    <th><?php echo Yii::t('model','End Date')?></th>
    <th><?php echo Yii::t('model','Comments')?></th>
</tr>
</thead>
<tbody>
    <tr>
        <?php
        $count = 0;
        foreach ($modelOther as $bo): ?>
        <td>
            <?php echo CHtml::link(Yii::t('static','Delete'),array('blackout/delete','id'=>$bo->id),array(
                'data-toggle'=>'tooltip',
                'data-placement'=>'top',
                'title'=>Yii::t('static','Delete'),
                'class'=>'ico ico-16 pull-right',
            )) ?>
            <?php echo CHtml::link(Yii::t('static','Update'),array('blackout/update','id'=>$bo->id),array(
                'data-toggle'=>'tooltip',
                'data-placement'=>'top',
                'title'=>Yii::t('static','Update'),
                'class'=>'ico ico-2 pull-right',
            )) ?></td>
        <td><?php echo Yii::app()->dateFormatter->format('EEE, MMM d, yyyy', $bo->start)?></td>
        <td><?php echo Yii::app()->dateFormatter->format('EEE, MMM d, yyyy', $bo->end)?></td>
        <td style="width:150px"><?php echo $bo->comments?></td>
        <?php if ((++$count%2) == 0) : ?>
            </tr>
            <tr>
        <?php endif; ?>
        <?php if (count($modelOther) == 0) : ?>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
        <?php endif; ?>
        <?php if (count($modelOther) == 1) : ?>
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
<?php endif; ?>


<div class="title-tb"><?php echo Yii::t('static','Doctor\'s Leave = Black Out Date')?>
    <div class="btn-add">
        <?php echo CHtml::link(Yii::t('static','Add'),array('blackout/create/?type=leave'),array(
            'data-toggle'=>'tooltip',
            'data-placement'=>'top',
            'title'=>Yii::t('static','Add'),
            'class'=>'ico ico-25',
        )) ?>
    </div>
</div>
<?php if (count($modelLeave) > 0): ?>
<div class="scroll-pane scroll-4">
<table class="table tb-1 table-hover">
<thead>
<tr>
    <th style="width:80px;">&nbsp;</th>
    <th><?php echo Yii::t('model','Doctor')?></th>
    <th><?php echo Yii::t('model','Start Date')?></th>
    <th><?php echo Yii::t('model','End Date')?></th>
    <th><?php echo Yii::t('model','Comments')?></th>
    <th>&nbsp;</th>
    <th><?php echo Yii::t('model','Doctor')?></th>
    <th><?php echo Yii::t('model','Start Date')?></th>
    <th><?php echo Yii::t('model','End Date')?></th>
    <th><?php echo Yii::t('model','Comments')?></th>
</tr>
</thead>
<tbody>
    <tr>
        <?php
        $count = 0;
        foreach ($modelLeave as $bo): ?>
        <td>
            <?php echo CHtml::link(Yii::t('static','Delete'),array('blackout/delete','id'=>$bo->id),array(
                'data-toggle'=>'tooltip',
                'data-placement'=>'top',
                'title'=>Yii::t('static','Delete'),
                'class'=>'ico ico-16 pull-right',
            )) ?>
            <?php echo CHtml::link(Yii::t('static','Update'),array('blackout/update','id'=>$bo->id),array(
                'data-toggle'=>'tooltip',
                'data-placement'=>'top',
                'title'=>Yii::t('static','Update'),
                'class'=>'ico ico-2 pull-right',
            )) ?></td>
        <td><?php echo $bo->doctor->fullName?></td>
        <td><?php echo Yii::app()->dateFormatter->format('EEE, MMM d, yyyy', $bo->start)?></td>
        <td><?php echo Yii::app()->dateFormatter->format('EEE, MMM d, yyyy', $bo->end)?></td>
        <td style="width:150px"><?php echo $bo->comments?></td>
        <?php if ((++$count%2) == 0) : ?>
            </tr>
            <tr>
        <?php endif; ?>
        <?php if (count($modelLeave) == 0) : ?>
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
        <?php if (count($modelLeave) == 1) : ?>
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
<?php endif; ?>


<div class="title-tb"><?php echo Yii::t('static','Doctor\'s Leave With Covering Doctor')?>
    <div class="btn-add">
        <?php echo CHtml::link(Yii::t('static','Add'),array('blackout/create/?type=covering'),array(
            'data-toggle'=>'tooltip',
            'data-placement'=>'top',
            'title'=>Yii::t('static','Add'),
            'class'=>'ico ico-25',
        )) ?>
    </div>
</div>
<?php if (count($modelCovering) > 0): ?>
<div class="scroll-pane scroll-4">
<table class="table tb-1 table-hover">
<thead>
<tr>
    <th>&nbsp;</th>
    <th><?php echo Yii::t('model','Doctor')?></th>
    <th><?php echo Yii::t('model','Start Date')?></th>
    <th><?php echo Yii::t('model','End Date')?></th>
    <!-- <th><?php echo Yii::t('model','Covering Doctor')?></th> -->
    <th><?php echo Yii::t('model','Comments')?></th>
</tr>
</thead>
<tbody>
<?php
$count = 0;
foreach ($modelCovering as $bo): ?>
    <tr>
        <td style="width:80px;">
            <?php echo CHtml::link(Yii::t('static','Delete'),array('blackout/delete','id'=>$bo->id),array(
                'data-toggle'=>'tooltip',
                'data-placement'=>'top',
                'title'=>Yii::t('static','Delete'),
                'class'=>'ico ico-16 pull-right',
            )) ?>
            <?php echo CHtml::link(Yii::t('static','Update'),array('blackout/update','id'=>$bo->id),array(
                'data-toggle'=>'tooltip',
                'data-placement'=>'top',
                'title'=>Yii::t('static','Update'),
                'class'=>'ico ico-2 pull-right',
            )) ?></td>
        <td><?php echo $bo->doctor->fullName?></td>
        <td><?php echo Yii::app()->dateFormatter->format('EEE, MMM d, yyyy', $bo->start)?></td>
        <td><?php echo Yii::app()->dateFormatter->format('EEE, MMM d, yyyy', $bo->end)?></td>
        <!-- <td><?php echo $bo->covering_doctor->fullName?></td> -->
        <td style="width:350px"><?php echo $bo->comments?></td>
    </tr>
<?php endforeach;  ?>
</tbody>
</table>
</div>
<?php endif; ?>



<!--<div class="btn-group-1 clearfix">
    <?php echo CHtml::link(Yii::t('static','Add'),array('blackout/create'),array(
        'data-toggle'=>'tooltip',
        'data-placement'=>'top',
        'title'=>Yii::t('static','Add'),
        'class'=>'ico ico-25 pull-right',
    )) ?>
</div>-->

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