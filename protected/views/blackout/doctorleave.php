<?php
/* @var $this DoctorController */
/* @var $dataProvider CActiveDataProvider */
$this->menu=array(
    array('label' => Yii::t('static', 'Log out'), 'url' => array('/site/logout'), 'class' => 'btn-1'),
    // array('label'=>Yii::t('static', '<img src="'.Yii::app()->baseUrl . '/css/images/icon-print-sm.png'.'"" /> Print Appointment'), 'url'=>array('/appointment/print_appointment'),'class'=>'btn-1'),
    array('label'=>Yii::t('static', 'Add Appointment'), 'url'=>array('/appointment/create'),'class'=>'btn-1'),
    array('label' => Yii::t('static', 'Previous Page'), 'url' => 'javascript:history.go(-1)', 'class' => 'btn-1'),
);

$this->breadcrumbs = array(
    Yii::t('static', 'Doctor\'s Leave'),
);

$this->title = Yii::t('static', 'Doctor\'s Leave');
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
    <th>&nbsp;</th>
    <th><?php echo Yii::t('model','Doctor')?></th>
    <th><?php echo Yii::t('model','Start Date')?></th>
    <th><?php echo Yii::t('model','End Date')?></th>
    <th><?php echo Yii::t('model','Comments')?></th>

</tr>
</thead>
<tbody>
    <?php
        $count = 0;
        foreach ($modelLeave as $bo): ?>
    <tr>
        <td style="width:80px;">
            <?php echo CHtml::link(Yii::t('static','Delete'),array('blackout/doctorleavedelete','id'=>$bo->id),array(
                'data-toggle'=>'tooltip',
                'data-placement'=>'top',
                'title'=>Yii::t('static','Delete'),
                'class'=>'ico ico-16 pull-right',
            )) ?>
            <?php echo CHtml::link(Yii::t('static','Update'),array('blackout/update','id'=>$bo->id, 'leave_page'=>1),array(
                'data-toggle'=>'tooltip',
                'data-placement'=>'top',
                'title'=>Yii::t('static','Update'),
                'class'=>'ico ico-2 pull-right',
            )) ?></td>
        <td><?php echo $bo->doctor->fullName?></td>
        <td><?php echo Yii::app()->dateFormatter->format('EEE, MMM d, yyyy', $bo->start)?></td>
        <td><?php echo Yii::app()->dateFormatter->format('EEE, MMM d, yyyy', $bo->end)?></td>
        <td style="width:150px !important"><?php echo $bo->comments?></td>
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
        'class'=>'ico ico-17 pull-right',
    )) ?>
</div>-->

<style type="text/css">
.scroll-4 {max-height: 260px;}
div.title-tb {
    background: none repeat scroll 0 0 #da4a38;
    color: #fff;
    font-size: 14px;
    text-align: left;
    font-weight: bold;
    padding: 8px;
    margin-top: 20px;
}
.title-tb .btn-add { float:right; margin-top: -3px;}
</style>