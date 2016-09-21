<?php
/* @var $this DoctorController */
/* @var $dataProvider CActiveDataProvider */
$this->menu=array(
    array('label' => Yii::t('static', 'Log out'), 'url' => array('/site/logout'), 'class' => 'btn-1'),
    array('label'=>Yii::t('static', '<img src="'.Yii::app()->baseUrl . '/css/images/icon-print-sm.png'.'"" /> Print Appointment'), 'url'=>array('/appointment/print_appointment'),'class'=>'btn-1'),
    array('label'=>Yii::t('static', 'Add Appointment'), 'url'=>array('/appointment/create'),'class'=>'btn-1'),
    array('label' => Yii::t('static', 'Previous Page'), 'url' => 'javascript:history.go(-1)', 'class' => 'btn-1'),
);

$this->breadcrumbs = array(
    Yii::t('static', 'Black Out'),
);

$this->title = Yii::t('static', 'Black Out');
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
<div class="scroll-pane scroll-4">
<table class="table tb-1 table-hover">
<thead>
<tr class="title-tb">
    <th colspan="4"><?php echo Yii::t('static','Public Holiday')?></th>
    <th colspan="5"><?php echo Yii::t('static','Doctor’s Leave')?></th>
    <th colspan="4"><?php echo Yii::t('static','Other Events')?></th>
</tr>
<tr>
    <th>&nbsp;</th>
    <th><?php echo Yii::t('model','Start Date & Time')?></th>
    <th><?php echo Yii::t('model','End Date & Time')?></th>
    <th><?php echo Yii::t('model','Comments')?></th>
    <th>&nbsp;</th>
    <th><?php echo Yii::t('model','Doctor')?></th>
    <th><?php echo Yii::t('model','Start Date & Time')?></th>
    <th><?php echo Yii::t('model','End Date & Time')?></th>
    <th><?php echo Yii::t('model','Comments')?></th>
    <th>&nbsp;</th>
    <th><?php echo Yii::t('model','Start Date & Time')?></th>
    <th><?php echo Yii::t('model','End Date & Time')?></th>
    <th><?php echo Yii::t('model','Comments')?></th>
</tr>
</thead>
<tbody>
<?php for ($idx=0; $idx<max(count($holidays),count($leaves),count($others)); $idx++): ?>
    <tr>
        <?php if ($idx<count($holidays)): ?>
        <td><?php echo CHtml::link(Yii::t('static','Delete'),array('blackout/delete','id'=>$holidays[$idx]->id),array(
                'data-toggle'=>'tooltip',
                'data-placement'=>'top',
                'title'=>Yii::t('static','Delete'),
                'class'=>'ico ico-16 pull-right',
            )) ?>
            <?php echo CHtml::link(Yii::t('static','Update'),array('blackout/update','id'=>$holidays[$idx]->id),array(
                'data-toggle'=>'tooltip',
                'data-placement'=>'top',
                'title'=>Yii::t('static','Update'),
                'class'=>'ico ico-2 pull-right',
            )) ?></td>
        <td><?php echo Yii::app()->dateFormatter->format('EEE, MMM d, yyyy', $holidays[$idx]->start)?></td>
        <td><?php echo Yii::app()->dateFormatter->format('EEE, MMM d, yyyy', $holidays[$idx]->end)?></td>
        <td style="width:150px"><?php echo $holidays[$idx]->comments?></td>
        <?php else: ?>
        <td colspan="4"/>
        <?php endif; ?>

        <?php if ($idx<count($leaves)): ?>
            <td><?php echo CHtml::link(Yii::t('static','Delete'),array('blackout/delete','id'=>$leaves[$idx]->id),array(
                    'data-toggle'=>'tooltip',
                    'data-placement'=>'top',
                    'title'=>Yii::t('static','Delete'),
                    'class'=>'ico ico-16 pull-right',
                )) ?>
                <?php echo CHtml::link(Yii::t('static','Update'),array('blackout/update','id'=>$leaves[$idx]->id),array(
                    'data-toggle'=>'tooltip',
                    'data-placement'=>'top',
                    'title'=>Yii::t('static','Update'),
                    'class'=>'ico ico-2 pull-right',
                )) ?></td>
            <td><?php echo $leaves[$idx]->doctor->fullName?></td>
            <td><?php echo Yii::app()->dateFormatter->format('EEE, MMM d, yyyy', $leaves[$idx]->start)?></td>
            <td><?php echo Yii::app()->dateFormatter->format('EEE, MMM d, yyyy', $leaves[$idx]->end)?></td>
            <td style="width:150px"><?php echo $leaves[$idx]->comments?></td>
        <?php else: ?>
            <td colspan="5"/>
        <?php endif; ?>

        <?php if ($idx<count($others)): ?>
            <td><?php echo CHtml::link(Yii::t('static','Delete'),array('blackout/delete','id'=>$others[$idx]->id),array(
                    'data-toggle'=>'tooltip',
                    'data-placement'=>'top',
                    'title'=>Yii::t('static','Delete'),
                    'class'=>'ico ico-16 pull-right',
                )) ?>
                <?php echo CHtml::link(Yii::t('static','Update'),array('blackout/update','id'=>$others[$idx]->id),array(
                    'data-toggle'=>'tooltip',
                    'data-placement'=>'top',
                    'title'=>Yii::t('static','Update'),
                    'class'=>'ico ico-2 pull-right',
                )) ?></td>
            <td><?php echo Yii::app()->dateFormatter->format('EEE, MMM d, yyyy', $others[$idx]->start)?></td>
            <td><?php echo Yii::app()->dateFormatter->format('EEE, MMM d, yyyy', $others[$idx]->end)?></td>
            <td style="width:150px"><?php echo $others[$idx]->comments?></td>
        <?php else: ?>
            <td colspan="4"/>
        <?php endif; ?>
    </tr>
<?php endfor  ?>
</tbody>
</table>
</div>








<div class="scroll-pane scroll-4">
<table class="table tb-1 table-hover">
<thead>
<tr class="title-tb">
    <th colspan="13"><?php echo Yii::t('static','Black Out Time')?></th>
</tr>
<tr>
    <th>&nbsp;</th>
    <th><?php echo Yii::t('model','Start Date & Time')?></th>
    <th><?php echo Yii::t('model','End Date & Time')?></th>
    <th><?php echo Yii::t('model','Comments')?></th>
    <th>&nbsp;</th>
    <th><?php echo Yii::t('model','Doctor')?></th>
    <th><?php echo Yii::t('model','Start Date & Time')?></th>
    <th><?php echo Yii::t('model','End Date & Time')?></th>
    <th><?php echo Yii::t('model','Comments')?></th>
    <th>&nbsp;</th>
    <th><?php echo Yii::t('model','Start Date & Time')?></th>
    <th><?php echo Yii::t('model','End Date & Time')?></th>
    <th><?php echo Yii::t('model','Comments')?></th>
</tr>
</thead>
<tbody>
<?php for ($idx=0; $idx<count($times); $idx++): ?>
    <tr>
        <?php if ($idx<count($holidays)): ?>
        <td><?php echo CHtml::link(Yii::t('static','Delete'),array('blackout/delete','id'=>$holidays[$idx]->id),array(
                'data-toggle'=>'tooltip',
                'data-placement'=>'top',
                'title'=>Yii::t('static','Delete'),
                'class'=>'ico ico-16 pull-right',
            )) ?>
            <?php echo CHtml::link(Yii::t('static','Update'),array('blackout/update','id'=>$holidays[$idx]->id),array(
                'data-toggle'=>'tooltip',
                'data-placement'=>'top',
                'title'=>Yii::t('static','Update'),
                'class'=>'ico ico-2 pull-right',
            )) ?></td>
        <td><?php echo Yii::app()->dateFormatter->format('EEE, MMM d, yyyy', $holidays[$idx]->start)?></td>
        <td><?php echo Yii::app()->dateFormatter->format('EEE, MMM d, yyyy', $holidays[$idx]->end)?></td>
        <td style="width:150px"><?php echo $holidays[$idx]->comments?></td>
        <?php else: ?>
        <td colspan="4"/>
        <?php endif; ?>

        <?php if ($idx<count($leaves)): ?>
            <td><?php echo CHtml::link(Yii::t('static','Delete'),array('blackout/delete','id'=>$leaves[$idx]->id),array(
                    'data-toggle'=>'tooltip',
                    'data-placement'=>'top',
                    'title'=>Yii::t('static','Delete'),
                    'class'=>'ico ico-16 pull-right',
                )) ?>
                <?php echo CHtml::link(Yii::t('static','Update'),array('blackout/update','id'=>$leaves[$idx]->id),array(
                    'data-toggle'=>'tooltip',
                    'data-placement'=>'top',
                    'title'=>Yii::t('static','Update'),
                    'class'=>'ico ico-2 pull-right',
                )) ?></td>
            <td><?php echo $leaves[$idx]->doctor->fullName?></td>
            <td><?php echo Yii::app()->dateFormatter->format('EEE, MMM d, yyyy', $leaves[$idx]->start)?></td>
            <td><?php echo Yii::app()->dateFormatter->format('EEE, MMM d, yyyy', $leaves[$idx]->end)?></td>
            <td style="width:150px"><?php echo $leaves[$idx]->comments?></td>
        <?php else: ?>
            <td colspan="5"/>
        <?php endif; ?>

        <?php if ($idx<count($others)): ?>
            <td><?php echo CHtml::link(Yii::t('static','Delete'),array('blackout/delete','id'=>$others[$idx]->id),array(
                    'data-toggle'=>'tooltip',
                    'data-placement'=>'top',
                    'title'=>Yii::t('static','Delete'),
                    'class'=>'ico ico-16 pull-right',
                )) ?>
                <?php echo CHtml::link(Yii::t('static','Update'),array('blackout/update','id'=>$others[$idx]->id),array(
                    'data-toggle'=>'tooltip',
                    'data-placement'=>'top',
                    'title'=>Yii::t('static','Update'),
                    'class'=>'ico ico-2 pull-right',
                )) ?></td>
            <td><?php echo Yii::app()->dateFormatter->format('EEE, MMM d, yyyy', $others[$idx]->start)?></td>
            <td><?php echo Yii::app()->dateFormatter->format('EEE, MMM d, yyyy', $others[$idx]->end)?></td>
            <td style="width:150px"><?php echo $others[$idx]->comments?></td>
        <?php else: ?>
            <td colspan="4"/>
        <?php endif; ?>
    </tr>
<?php endfor  ?>
</tbody>
</table>
</div>









<div class="btn-group-1 clearfix">
    <?php echo CHtml::link(Yii::t('static','Add'),array('blackout/create'),array(
        'data-toggle'=>'tooltip',
        'data-placement'=>'top',
        'title'=>Yii::t('static','Add'),
        'class'=>'ico ico-17 pull-right',
    )) ?>
</div>

<style type="text/css">
.scroll-4 { height: 260px;}
</style>