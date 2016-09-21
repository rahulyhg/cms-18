
<div class="form-horizontal">
    <div class="box-1">
        <div class="title-box clearfix">
            <h2 class="title"><?php echo Yii::t('static', 'Print By Patient') ?></h2>
            
        </div>

        <div class="box-body"> 
         
          
            <?php echo $this->renderNotifyMessage(); ?>
            <div class="form">
            <div class="row">
                <?php $form=$this->beginWidget('CActiveForm', array(
			'id' => 'Paid-form',
			'enableAjaxValidation'=>false,
			'htmlOptions' => array('class' => 'form-horizontal', 'role' => 'form', 'enctype' => 'multipart/form-data'),
		)); ?>
                     <div class="col-md-4">
                         <div class="row">
                            <div class='form-group form-group-sm'>
                                <label  class="col-md-4">Patient Name</label>      
                                <div class="col-md-6">
                                    <?php echo $form->textField($model, 'patient_name', array('class' => 'form-control patient_name','autocomplete'=>"off")) ?>
                                     <?php echo $form->error($model, 'patient_name'); ?>
                                </div>
                            </div>
                        </div>
                         <div class="row">
                             <div class='form-group form-group-sm'>
                                <label  class="col-md-4">Print Type</label>      
                                <div class="col-md-8"><?php echo $form->radioButton($model,'print_type',array('value'=>1,'checked'=>true)); ?> Medical
                                              <?php echo $form->radioButton($model,'print_type',array('value'=>2, 'style' => 'margin-left:20px;')); ?> Invoice
                                               <?php echo $form->radioButton($model,'print_type',array('value'=>3 , 'style' => 'margin-left:20px;')); ?> Receipt
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class='form-group form-group-sm'>
                                <div class="col-md-4"></div>
                                <div class="col-md-6">
                                        <button class="btn btn-primary" type="submit" name="yt0"><span class="glyphicon glyphicon-print"></span> Print</button>
                                </div>
                            </div>
                         </div>
                     </div>  
                    
                <?php $this->endWidget();?>
            </div>
            </div>
        </div>
    </div>
</div>
<script>
    var url = '<?php echo Yii::app()->createAbsoluteUrl('/reports/listPatient');?>';
    Print.init();
               
</script>