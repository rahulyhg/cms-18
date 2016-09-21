
<div class="form-horizontal">
    <div class="box-1">
        <div class="title-box clearfix">
            <h2 class="title"><?php echo Yii::t('static', 'Payments - Make Payment') ?></h2>
        </div>
       
        <?php include_once '_form.php';?>
    </div>
    <div id="invoice_new"></div>
</div>
<script type="text/javascript">
      var url_data_autocomplete = "<?php echo Yii::app()->createAbsoluteUrl('/payments/listPrice')?>";
      var url_data_autocomplete_inventory = "<?php echo Yii::app()->createAbsoluteUrl('/inventories/list')?>";
      var url_check_data_autocomplete = "<?php echo Yii::app()->createAbsoluteUrl('/payments/listPriceByName')?>";
      var patient_id = <?php echo $patient->id;?>;
     Invoice.init();
</script>