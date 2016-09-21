<div class="box-1">
    <div class="title-box clearfix">
        <h2 class="title"><?php echo Yii::t('static', 'Export') ?></h2>
    </div>
    <div class=" box-body form-horizontal">
        <ul>
            <li><a href="<?php echo Yii::app()->createAbsoluteUrl('export/exportpatientbyallentry');?>">Export Patient List - All Entry</a></li>
            <li><a href="<?php echo Yii::app()->createAbsoluteUrl('export/exportpatientbyalphabet');?>">Export Patient List - Name starting with alphabet to alphabet</a></li>
            <li><a href="<?php echo Yii::app()->createAbsoluteUrl('export/exportpatientbychecked');?>">Export Patient List - By Checked</a></li>
            <li><a href="<?php echo Yii::app()->createAbsoluteUrl('export/exportpatientbydoctorname');?>">Export Patient List - By doctor name </a></li>
            <li><a href="<?php echo Yii::app()->createAbsoluteUrl('export/exportpatientbyregistrationdate');?>">Export Patient List - By registration date </a></li>
            <li><a href="<?php echo Yii::app()->createAbsoluteUrl('export/exportpatientbyvisit');?>">Export Patient List - By visit date from to</a></li>
        </ul>
    </div>
</div>