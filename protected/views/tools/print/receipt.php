<?php
Yii::app()->clientScript->registerScript('select2', "
    
    $('.chosen-select-no-results').change(function(e){
            e.preventDefault();
            var data = $(this).val();
            var href = $('.link-selec2-options').attr('data-href');
            var url =href+'/printreceipt';
            window.location = url+'?patient_id='+data;
            return false;
    });"
);
?>

<link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl ?>/select2/chosen.css">
<div class="box-1">
    <div class="title-box clearfix">
        <h2 class="title"><?php echo Yii::t('static', 'Print Invoice') ?></h2>
          <a class="hide link-selec2-options" data-href="<?php echo Yii::app()->createAbsoluteUrl('/mpdfprint')?>" ></a>
    </div>
    <div class=" box-body form-horizontal">
        <div class="row">
            <div class="col-md-6">
                 <div class="clearfix"></div>
                <div class="row">
                    <div class="col-md-12">
                        <p>Patients</p>
                    </div>
                    <div class="col-md-12">
                        <select data-placeholder="Please select patient" style="width:350px;" class="chosen-select-no-results" tabindex="10">
                            <option value=""></option>
                            <?php
                            $modelPatient = Patient::model()->findAll();
                            foreach ($modelPatient as $item):
                                ?>
                               <?php if(!empty($patient_id) && $patient_id== $item->id ):?>
                                <option value="<?php echo $item->id; ?>" selected><?php echo $item->name; ?></option>
                               <?php else:?>
                                      <option value="<?php echo $item->id; ?>"><?php echo $item->name; ?></option>
                                <?php endif;?>
                             <?php
                            endforeach;
                            ?>
                        </select>
                    </div>
                </div>

            </div>
        </div>
       <div class="clearfix"></div>
        <br/>
        <div class="row">
            <div class="col-md-12">
                <div class="grid-invoice">
                    <?php
                    $columnArray = array();
                    $columnArray[] = array(
                        'header' => 'Select',
                        'value' => '$data->id',
                        'class' => "CCheckBoxColumn",
                        'htmlOptions' => array('style' => 'width: 1%')
                    );
                    $columnArray = array_merge($columnArray, array(
                        array(
                            'header' => 'Invoice Date',
                            'name' => 'created_date',
                            'type' => 'date',
                            'htmlOptions' => array('class' => 'clickable', 'style' => 'text-align:left; width: 20%')
                        ),
                        array(
                            'header' => 'Invoice No/Resceipt No',
                            'name' => 'invoice_no',
                            'htmlOptions' => array('class' => 'clickable', 'style' => 'text-align:left;width: 25%')
                        ),
                        array(
                            'header' => 'Amount Paid',
                            'name' => 'id',
                            'value' => 'isset($data->Amout)?$data->Amout->amount_pay:""',
                            'htmlOptions' => array('class' => 'clickable', 'style' => 'text-align:left;width: 15%')
                        ),
                        array(
                            'header' => 'Change',
                            'name' => 'id',
                            'value' => 'isset($data->Amout)?$data->Amout->change:""',
                            'htmlOptions' => array('class' => 'clickable', 'style' => 'text-align:left;width: 15%')
                        ),
                        array(
                            'name' => 'created_date',
                            'type' => 'date',
                            'htmlOptions' => array('class' => 'clickable', 'style' => 'text-align:left;width: 15%')
                        ),
                        array(
                            'header' => 'Actions',
                            'class' => 'CButtonColumn',
                            'template' => '{print}',
                            'buttons' => array
                                (
                                'print' => array
                                    (
                                    'label' =>'<i class="glyphicon glyphicon-print"></i>',
                                    'url' => 'Yii::app()->createUrl("/mpdfprint/receipt",array("pay_id"=>$data->id,"type"=>"receipt"))',
                                    'options' => array('title' => 'Print Invoce','target'=>'_blank'),
                                ),
                                'htmlOptions' => array('class' => 'clickable', 'style' => 'text-align:left; width:100px')
                            ),)
                            ));
                        $this->widget('zii.widgets.grid.CGridView', array(
                            'id' => 'payment-history-grid',
                            'dataProvider' => $patient_id ? $model :  $model->search(),
                            'pager' => array(
                                'header' => '',
                                'prevPageLabel' => 'Prev',
                                'firstPageLabel' => 'First',
                                'lastPageLabel' => 'Last',
                                'nextPageLabel' => 'Next',
                            ),
                            'selectableRows' => 2,
                            'columns' => $columnArray,
                        ));
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<script src="<?php echo Yii::app()->theme->baseUrl ?>/select2/chosen.jquery.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->theme->baseUrl ?>/select2/docsupport/prism.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">
    var config = {
        '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
    }
    for (var selector in config) {
        $(selector).chosen(config[selector]);
    }
</script>