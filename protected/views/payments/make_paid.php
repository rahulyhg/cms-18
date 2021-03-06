
<div class="form-horizontal">
    <div class="box-1">
        <div class="title-box clearfix">
            <h2 class="title"><?php echo Yii::t('static', 'Payments - Make Payment') ?></h2>
        </div>

        <div class="box-body"> 
            <div class="row" >        
                <div class="col-md-4" >
                    <div class="pay-inv">

                        <h4>Drug Alert</h4>
                        <?php
                        if (!empty($drugalert)) {

                            foreach ($drugalert AS $itemDrugAlert) {
                                ?>
                                <p><b><?php echo $itemDrugAlert->name.' - '.$itemDrugAlert->comment; ?></b></p>

                                <?php
                            }
                        }
                        ?>

                    </div>

                </div>
                <div class="col-md-4" >
                    <div  class="pay-inv-infor">
                        <h5> <u>PAYMENT INFORMATION </u></h4>
                        <p>Unpaid Bills (Outstanding amount) = <b id="bill-total"><?php echo Yii::app()->format->prices($model->amount_due);?></b> </p>      
                        <p>Bill To : <u> <?php if (!empty($patientInfor)) echo $patientInfor['name'] ?> </u> </p>      

                    </div>

                </div>
                <div class="col-md-4" >
                    <div  class="pay-inv-infor">
                        <div class="row margintext">
                            <?php if (!empty($patientInfor)) { ?>
                                <div class="col-md-4"><b><?php echo $patientInfor['name']; ?></b></div>
                                <div class="col-md-4 aligncenter"><?php echo $patientInfor['identity']; ?></div>
                                <div class="col-md-4 alignright"><?php echo $patientInfor['age']; ?> Years <?php echo $patientInfor['gender']; ?></div>
                            <?php } ?>
                        </div>
                       <div class="row">
                    <?php if (!empty($patientInfor)) { ?>
                        <div class="col-md-3">
                            <?php
                            if (!empty($langueges)) {
                                echo $langueges;
                            }
                            ?>
                        </div>
                   <div class="col-md-6">Insurance: <?php echo $patient->medical_insurance_name?></div>
                        <div class="col-md-3 alignright"><?php echo Yii::app()->params['doctorName'];// $patientInfor['doctor_name'] ?></div>
                    <?php } ?>
                </div>
                    </div>

                </div>
            </div>
            <br>
          
            <?php if(Yii::app()->user->hasFlash('entry')): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo Yii::app()->user->getFlash('entry');?> 
            </div>
            <?php endif;?>
            <div class="row">
                <?php $form=$this->beginWidget('CActiveForm', array(
			'id' => 'Paid-form',
			'enableAjaxValidation'=>false,
			'htmlOptions' => array('class' => 'form-horizontal', 'role' => 'form', 'enctype' => 'multipart/form-data'),
		)); ?>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-12">
                            <div class='form-group form-group-sm'>
                                <label class="col-sm-3 control-label">Invoice No: </label>
                                <div class="col-sm-6 ">
                                    <p style=" margin-top: 5px;"><?php echo $model->invoice_no;?></p>
                                </div>
                            </div>
                        </div>
                         <div class="col-md-12">
                             <div class='form-group form-group-sm'>
                                <?php echo $form->labelEx($payAmonut,'pay_type', array('class' => 'col-sm-3 control-label')); ?>
                                <div class="col-sm-6">
                                <?php echo $form->checkBoxList($payAmonut, 'pay_type', $payAmonut->getDropDownlistPayType()) ?>
                                <?php echo $form->error($payAmonut,'pay_type'); ?>
                                </div>
                            </div>
                        </div>
                       
                  
                        <div class="col-md-12">
                             <div class='form-group form-group-sm'>
                                <?php echo $form->labelEx($payAmonut,'total', array('class' => 'col-sm-3 control-label')); ?>
                                <div class="col-sm-6">
                                    <?php echo $form->textField($payAmonut,'total', array('class' => 'form-control', 'maxlength' => 255,'readOnly' => true,'amount' => $payAmonut->amount_pay)); ?>
                                <?php echo $form->error($payAmonut,'total'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                             <div class='form-group form-group-sm'>
                                <?php echo $form->labelEx($payAmonut,'amount_pay', array('class' => 'col-sm-3 control-label')); ?>
                                <div class="col-sm-6">
                                    <?php echo $form->textField($payAmonut,'amount_pay', array('class' => 'form-control', 'maxlength' => 255,'readOnly' => true, 'amount' => $payAmonut->amount_pay)); ?>
                                <?php echo $form->error($payAmonut,'amount_pay'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                             <div class='form-group form-group-sm'>
                                <?php echo $form->labelEx($payAmonut,'total_received', array('class' => 'col-sm-3 control-label')); ?>
                                <div class="col-sm-6">
                                    <?php echo $form->textField($payAmonut,'total_received', array('class' => 'form-control ', 'maxlength' => 255,'readOnly' => true)); ?>
                                <?php echo $form->error($payAmonut,'total_received'); ?>
                                </div>
                            </div>
                        </div>
                         <div class="col-md-12">
                             <div class='form-group form-group-sm'>
                                <?php echo $form->labelEx($payAmonut,'amount', array('class' => 'col-sm-3 control-label')); ?>
                                <div class="col-sm-6">
                                    <?php echo $form->textField($payAmonut,'amount', array('class' => 'form-control numeric-control', 'maxlength' => 255)); ?>
                                <?php echo $form->error($payAmonut,'amount'); ?>
                                </div>
                            </div>
                        </div>
                         <div class="col-md-12">
                             <div class='form-group form-group-sm'>
                                <div  class="col-sm-3"></div>
                                <div class="col-sm-6">
                                     <?php echo CHtml::htmlButton('Save', array('class' => 'btn btn-primary', 'type' => 'submit')); ?> &nbsp;  
                                     <?php echo CHtml::htmlButton('Cancel', array('class' => 'btn btn-default', 'onclick' => 'javascript: location.href=\'' . Yii::app()->createAbsoluteUrl('payments/view/id/'.$id) . '\'')); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
                <?php $this->endWidget();?>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
     $(document).ready(function(){
        function total() {
                var total = $('#PaymentAmount_total').val();
                var amount_due = $('#PaymentAmount_amount_pay');
                var _amount = $('#PaymentAmount_amount').val();
                var _received = parseFloat(_amount).toFixed(2);
                var _due = parseFloat( total) -  parseFloat(_amount);
                amount_due.val(_due.toFixed(2));
                $('#PaymentAmount_total_received').val(_received);
           }
        total();
        $(document).on('change','#PaymentAmount_amount', function(){
            total();
        });
     }) 
    
    
    
</script>