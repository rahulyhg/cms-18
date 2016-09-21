<div class="box-1">
    <div class="title-box clearfix">
        <h2 class="title"><?php echo Yii::t('static', 'Print') ?></h2>
    </div>
    <div class=" box-body form-horizontal">
        <ul>
            <li><a href="<?php echo Yii::app()->createAbsoluteUrl('mpdfprint/printpatientnamelabel');?>">Print patient name label - Tick box to select one patient </a></li>
            <li><a href="<?php echo Yii::app()->createAbsoluteUrl('mpdfprint/printpatientbyallentry');?>">Print patient list - All entry</a></li>
            <li><a href="<?php echo Yii::app()->createAbsoluteUrl('mpdfprint/printpatientbyalphabet');?>">Print patient list - Name start with alphabet to alphabet</a></li>
            <li><a href="<?php echo Yii::app()->createAbsoluteUrl('mpdfprint/printpatientchecked');?>">Print patient list - By Checked </a></li>
            <li><a href="<?php echo Yii::app()->createAbsoluteUrl('mpdfprint/printpatientprofile');?>">Print patient Profile - Tick box to select one patient </a></li>
            <li><a href="<?php echo Yii::app()->createAbsoluteUrl('mpdfprint/printpayment');?>">Print patient Payment hitory - Tick box to select one patient </a></li>
            <li><a href="<?php echo Yii::app()->createAbsoluteUrl('mpdfprint/printinvoice');?>">Print patient Invoice - Tick box to select one patient </a></li>
            <li><a href="<?php echo Yii::app()->createAbsoluteUrl('mpdfprint/printreceipt');?>">Print patient Receipt - Tick box to select one patient</a></li>
            <li>Print patient Medical records- Tick box to select one patient</li>
        </ul>
    </div>
</div>