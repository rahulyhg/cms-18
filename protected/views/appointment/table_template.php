
<table id="time-table-tb" class="time-table-tb cell-select col-xs-12">
    <thead>
        <tr>
            <th>&nbsp;</th>
            <?php foreach (HDateTime::model()->dayOfWeeks() as $key => $value) : ?>
            <th><?php echo $value; ?></th>
            <?php endforeach; ?>
        </tr>
    </thead>
    <tbody>
        <tr>
            <th><?php echo Yii::t('static', 'AM'); ?></td>
            <?php echo $this->renderTimeRow($data, 'AM'); ?>
        </tr>
        <tr>
            <th><?php echo Yii::t('static', 'PM'); ?></th>
            <?php echo $this->renderTimeRow($data, 'PM'); ?>
        </tr>
    </tbody>
</table>

<style type="text/css">
.time-table-tb { width: 100% !important;  margin-left: 15px;}
.time-table-tb , .time-table-tb td, .time-table-tb tr, .time-table-tb th {
    border-collapse: collapse;
    border-spacing: 0;
    border: 1px solid #666666;
    padding: 7px;
    font-size: 11px;
}

.time-table-tb > tbody td {
    padding: 0px;
    vertical-align: top;
    max-width: 14%;
    width: 14%;
}
.time-table-tb > tbody td div {
    padding: 5px;
}
.time-table-tb > tbody td.has-data:hover,  .time-table-tb > tbody td.has-data:hover div, .time-table-tb > tbody td.has-data.active, .time-table-tb > tbody td.has-data.active div {
    background: #ff0000!important;
    cursor: pointer;
    color: #fff;
}

</style>