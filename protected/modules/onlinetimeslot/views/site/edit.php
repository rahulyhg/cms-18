<?php
$this->breadcrumbs = array(
    Yii::t('static', 'Online Timeslot Template'),
);

$this->menu = array(
    array('label' => Yii::t('static', 'Previous Page'), 'url' => 'javascript:history.go(-1)', 'class' => 'btn-1'),
);


$this->pageTitle = Yii::t('static', 'Online Timeslot Template');
?>

<input type="hidden" id="baseUrl" value="<?php echo Yii::app()->createAbsoluteUrl('onlinetimeslot'); ?>">
<input type="hidden" id="doctor_id" value="<?php echo $model->id; ?>">

<div class="res-style" ng-app="timeslotModule">
    <div class="docTimeSlot" ng-controller="bufferController as bufferCtrl">
        <?php $this->renderPartial('buffer/_buffer_time'); ?>

        <div class="row" ng-repeat="(templateIndex, template) in addresseTemplate">
            <h2 class="address-name">{{template.address.shortAddress}}</h2>
            <div class="form-group clearfix">
                <div class="col-sm-4 col-xs-5">
                    <select class="form-control" ng-model="bufferGeneral.inputs[$index].daysOfWeek" multiple ng-options="option for option in bufferGeneral.options.daysOfWeek"></select>
                </div>
                <div class="col-md-2 col-xs-3">
                    <select class="form-control" ng-model="bufferGeneral.inputs[$index].hour"  ng-options="c.label for c in bufferGeneral.options.hours"></select>
                </div>
                <div class="col-md-2 col-xs-3">
                    <select class="form-control" ng-model="bufferGeneral.inputs[$index].minute" ng-options="c.label for c in bufferGeneral.options.minutes"></select>
                </div>
                <div class="col-xs-1">
                    <button class="btn btn-primary"  ng-click="bufferGeneral.addBufferEvent(bufferGeneral.inputs[$index])">Add</button>
                </div>
            </div>
            <hr/>
        </div>
        <?php $this->renderPartial('buffer/_buffer_form_error'); ?>
        <?php $this->renderPartial('buffer/_buffer_template'); ?>
    </div>
</div>