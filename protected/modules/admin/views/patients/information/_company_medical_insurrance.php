
<?php
$companymedicalinsurrancePrintUrl = Yii::app()->createAbsoluteUrl('mpdfprint/index', array('patient_id'=>$patient_id, 'type' => 'companymedicalinsurrance'));
$add = Yii::app()->createAbsoluteUrl('patientmedicalinsurrance/create', array('patient_id'=>$patient_id));
$patient_id = isset($_GET['patient_id'])?$_GET['patient_id']:0;
$cms = new BaseFormatter();

?>

<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><?php echo Yii::t('static', 'Company Medical Insurrance') ?></h3>
        <?php echo CHtml::link(Yii::t('static', '<span class="glyphicon glyphicon-print"></span> Print'), $companymedicalinsurrancePrintUrl, array('class' => 'btn-1 pull-right', 'target'=>'_blank')); ?>
        <?php echo CHtml::link(Yii::t('static', '<span class="glyphicon glyphicon-plus"></span>  Add'), $add, array('class' => 'btn-1 pull-right')); ?>

    </div>
    <div class="panel-body">
        <div class="form">
            <?php if (count($dataProvider) <= 0): ?>
                <span class="empty">No results found.</span>
            <?php else: ?>
            <?php 
                foreach ($dataProvider as $model): 
                    $edit = Yii::app()->createAbsoluteUrl('patientmedicalinsurrance/update', array('patient_id'=>$patient_id, 'id'=>$model->id));
                    $delete = Yii::app()->createAbsoluteUrl('patientmedicalinsurrance/deleteinsurrance', array('patient_id'=>$patient_id, 'id'=>$model->id));
            ?>
            <div class="col-md-12 box-1">
                <div class="form">
                    <?php echo CHtml::link(Yii::t('static', '<span class="glyphicon glyphicon-trash"></span> Delete'), $delete, array('class' => 'btn-1 pull-right delete-button')); ?>
                    <?php echo CHtml::link(Yii::t('static', '<span class="glyphicon glyphicon-pencil"></span> Edit'), $edit, array('class' => 'btn-1 pull-right update-button')); ?>
                    <div class="row">
                        <div class="col-md-4 form-group form-group-sm">
                            <label class="col-md-4">Company Name  </label>      
                            <div class="col-md-8">
                                <?php echo $model->company_name ?>
                            </div>
                        </div>
                        <div class="col-md-4 form-group form-group-sm">
                            <label class="col-md-4">Department </label>      
                            <div class="col-md-8">
                                <?php echo $model->department ?>
                            </div>
                        </div>

                        <div class="col-md-4 form-group form-group-sm">
                            <label class="col-md-4">Staff No  </label>      
                            <div class="col-md-8">
                                <?php echo $model->staff_no ?>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 form-group form-group-sm">
                            <label class="col-md-4">Entitlement Amount</label>      
                            <div class="col-md-8">
                                <?php echo $cms->formatPrice($model->entitlement_from) ?> -
                                <?php echo $cms->formatPrice($model->entitlement_to) ?>
                            </div>
                        </div>
                        <div class="col-md-4 form-group form-group-sm">
                            <label class="col-md-4">To Bill Innsurance  </label>      
                            <div class="col-md-8">
                                <?php echo DeclareHelper::$toBillInsuranceFormat[$model->to_bill_insurrance]; ?>
                            </div>
                        </div>

                        <div class="col-md-4 form-group form-group-sm">
                            <label class="col-md-4">Insurance Name </label>     
                            <div class="col-md-8">
                                <?php echo $model->insurrance_name ?>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 form-group form-group-sm">
                            <label class="col-md-4">Follow  </label>      
                            <div class="col-md-8">
                                <?php echo DeclareHelper::$followFormat[$model->follow] ?>
                            </div>
                        </div>
                        <div class="col-md-4 form-group form-group-sm">
                            <label class="col-md-4">Copayment </label>      
                            <div class="col-md-8">
                                <?php echo $model->copayment ? "Yes" : "No" ?>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 form-group form-group-sm">
                            <label class="col-md-4">Attach Insurance Card, Letter or Document </label>
                            <div class="col-md-8">
                                <?php 
                                    $data['patient_id'] = $model->patient_id;
                                    $data['patient_medical_insurrance_id'] = $model->id;
                                    $data['type'] = 'insurrance_card';
                                    
                                    echo $cms->formatDocumentDownload($data); 
                                ?>
                            </div>
                        </div>
                        <div class="col-md-4 form-group form-group-sm amount-copayment">
                            <label class="col-md-4">Amount  </label>      
                            <div class="col-md-8">
                                <?php echo $cms->formatPrice($model->copayment_amount_from) ?> -
                                <?php echo $cms->formatPrice($model->copayment_amount_to) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; endif; ?>
        </div>
    </div>
</div>  

