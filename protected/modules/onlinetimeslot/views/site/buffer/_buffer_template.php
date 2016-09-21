<div>
    <h2>Template</h2>
    <table class="timeslot-table col-md-12" >
        <thead>
        <tr>
            <th>&nbsp;</th>
            <th class="a-center" ng-repeat="key in bufferGeneral.constants.daysOfWeek">
                <b>{{key}}</b>
            </th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>
                <p ng-repeat="number in [0,1,2,3]"><a class="box-color-{{4 + number}}">Address {{number + 1}}</a></p>
            </td>
            <td class="timeslot-table" ng-repeat="key in bufferGeneral.constants.daysOfWeek">
                <p ng-repeat="value in bufferGeneral.buffers[key]">
                    <a class="box-color-{{4 + value.addressIndex}}">{{toDigit2(value.hour)}}:{{toDigit2(value.minute)}}
                        <button  class="btn-delete-timeslot" ng-click="bufferGeneral.buffers[key].splice($index, 1)"></button>
                    </a>
                </p>
            </td>
        </tr>
        </tbody>
    </table>
</div>
<div class="clearfix"></div>
<div class="row" style="margin-top: 15px;">
    <div class="col-md-3 col-xs-6">
        <input type="hidden" id="baseUrl" value="<?php echo Yii::app()->createAbsoluteUrl("admin"); ?>">
        <button class="btn btn-primary" ng-click="saveTemplate()">Save Template</button>
        <img src="<?php echo Yii::app()->theme->baseUrl; ?>/img/loading1.gif" class="imgLoading small" ng-show="loading.save" >
    </div>
</div>
<div class="row" id="error_final" style="display: none;">
    <label class="caption" for="">&nbsp;</label>
    <div style="display: inline-block;">
        <p class="red" ng-repeat="error in errors.final">
            {{error}}
        </p>
    </div>
</div>
