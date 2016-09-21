
<?php
// alert('Please select one record to update');
Yii::app()->clientScript->registerScript('search', "
$('.update-button').click(function(){
        var atLeastOneIsChecked = $('input[name=\"company_medical_insurrance[]\"]:checked').length > 0;
        var url = '<?php echo Yii::app()->createAbsoluteUrl('Patientmedicalinsurrance/create', array('patient_id' => 21, 'company_id' => 8)) ?>';
        if (!atLeastOneIsChecked)
        {
                alert('Please select one record to update');
        }
        else if (window.confirm('Are you sure you want to update the selected records?'))
        {
                window.location.href=url;
        }
});

$('.delete-button').click(function(){
    if (window.confirm('Are you sure you want to delete the selected records?'))
    {
            document.getElementById('medical-insurrance-grid-bulk').action='" . Yii::app()->createAbsoluteUrl('Patientmedicalinsurrance/delete', array('patient_id' => 10)) . "';
            document.getElementById('medical-insurrance-grid-bulk').submit();
    }
});

");

$patient_id = isset($_GET['patient_id']) ? $_GET['patient_id'] : 0;
$cms = new BaseFormatter();
?>

<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><?php echo Yii::t('static', 'Company Medical Insurrance') ?></h3>
        <?php echo CHtml::link(Yii::t('static', '<span class="glyphicon glyphicon-print"></span> Print'), array('mpdfprint/index', 'patient_id' => $patient_id, 'type' => 'companymedicalinsurrance'), array('class' => 'btn-1 pull-right', 'target' => '_blank')); ?>
        <?php echo CHtml::link(Yii::t('static', '<span class="glyphicon glyphicon-plus"></span>  Add'), array('Patientmedicalinsurrance/create', 'patient_id' => $patient_id), array('class' => 'btn-1 pull-right')); ?>

    </div>
    <div class="panel-body">
        <div class="form">
            <?php if (count($dataProvider) <= 0): ?>
                <span class="empty">No results found.</span>
            <?php else: ?>
                <?php
                foreach ($dataProvider as $model):
                    $edit = Yii::app()->createAbsoluteUrl('patientmedicalinsurrance/update', array('patient_id' => $patient_id, 'id' => $model->id));
                    $delete = Yii::app()->createAbsoluteUrl('patientmedicalinsurrance/deleteinsurrance', array('patient_id' => $patient_id, 'id' => $model->id));
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
                                        <?php echo $cms->formatPrice(number_format($model->entitlement_from, 0) . '.' . number_format($model->entitlement_to, 0)) ?>
                                        
                                    </div>
                                </div>
                                <div class="col-md-4 form-group form-group-sm">
                                    <label class="col-md-4">To Bill Insurance 123 </label>      
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
                                        /* $data['patient_id'] = $model->patient_id;
                                          $data['patient_medical_insurrance_id'] = $model->id;
                                          $data['type'] = 'insurrance_card';

                                          echo $cms->formatDocumentDownload($data); */
                                        ?>
                                        <?php
                                        $fileInventory = PatientAttachFile::model()->findAll('patient_id = :patient_id and type = 3', array(':patient_id' => $patient_id));
                                        if (!empty($fileInventory)):
                                            ?>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <table class="table table-striped table-bordered">
                                                        <thead>
                                                        <th width="30%">File Name</th>
                                                        <th width="70%">Description</th>
                                                        </thead>
                                                        <tbody>
                                                            <?php foreach ($fileInventory as $item): ?>
                                                                <tr>
                                                                    <td><a  target="_blank" title="download file <?php echo $item->file; ?>" href="<?php echo Yii::app()->createAbsoluteUrl('/') . '/upload/patient/' . $model->id . '/insurrance_card/' . $item->file; ?>"><?php echo $item->name; ?><a/></td>
                                                                    <td><?php echo $item->description; ?></td>
                                                                </tr>
                                                            <?php endforeach; ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="col-md-4 form-group form-group-sm amount-copayment">
                                    <label class="col-md-4">Amount  </label>      
                                    <div class="col-md-8">
                                        <?php echo$cms->formatPrice(number_format($defaultInsurrance->copayment_amount_from, 0) . '.' . number_format($defaultInsurrance->copayment_amount_to, 0));?>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach;
            endif; ?>
        </div>
    </div>
</div>  

