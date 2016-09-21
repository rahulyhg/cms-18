<div class="form-group clearfix">
    <div class="row col-sm-1 col-xs-12">
        <label for="txt_buffer_time" class="form-label">Buffer Time</label>
    </div>
    <div class="col-lg-1 col-sm-2 col-xs-4">
        <input type="number" class="form-control" ng-model="bufferTime.year">
        <span class="comment"><?php echo Yii::t('static', 'Years'); ?></span>
    </div>
    <div class="col-lg-1 col-sm-2 col-xs-4">
        <input type="number" class="form-control" ng-model="bufferTime.month">
        <span class="comment"><?php echo Yii::t('static', 'Months'); ?></span>
    </div>
    <div class="col-lg-1 col-sm-2 col-xs-4">
        <input type="number" class="form-control" ng-model="bufferTime.day">
        <span class="comment"><?php echo Yii::t('static', 'Days'); ?></span>
    </div>
    <div class="col-lg-1 col-sm-2 col-xs-4">
        <input type="number" class="form-control" ng-model="bufferTime.hour">
        <span class="comment"><?php echo Yii::t('static', 'Hours'); ?></span>
    </div>
    <div class="col-lg-1 col-sm-2 col-xs-4">
        <input type="number" class="form-control" ng-model="bufferTime.minute">
        <span class="comment"><?php echo Yii::t('static', 'Minutes'); ?></span>
    </div>
    <div class="col-lg-2 col-md-3 col-sm-3 col-sm-offset-9 col-lg-offset-0">
        <button class="btn btn-primary" ng-click="saveBuffer()">Update Buffer Time</button>
    </div>
</div>