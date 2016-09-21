
<div class="form-horizontal">
    <div class="box-1">
        <div class="title-box clearfix">
            <h2 class="title"><?php echo Yii::t('static', 'Payments - Make Payment') ?></h2>
             <?php echo CHtml::link(Yii::t('static', '<span class="glyphicon glyphicon-print"></span>  Print'), array('reports/printAmount/id/'.$id), array('class' => 'btn-1 pull-right','target'=>'_blank')); ?>
             <?php echo CHtml::link(Yii::t('static', '<span class="glyphicon glyphicon-pencil"></span> Edit'), array('reports/updateAmount/id/'.$id), array('class' => 'btn-1 pull-right')); ?>
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
                                <p><b><?php echo $itemDrugAlert->comment; ?></b></p>

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
                                <div class="col-md-8">
                                    <?php
                                    if (!empty($langueges)) {
                                        echo $langueges;
                                    }
                                    ?>
                                </div>
                                <div class="col-md-4 alignright"><?php echo Yii::app()->params['doctorName'];//$patientInfor['doctor_name'] ?></div>
                            <?php } ?>
                        </div>
                    </div>

                </div>
            </div>
            <br>
          
            <?php echo $this->renderNotifyMessage(); ?>
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
                            <div class='form-group form-group-sm'>
                                <label class="col-sm-3 control-label">Receipt No: </label>
                                <div class="col-sm-6 ">
                                    <p style=" margin-top: 5px;"><?php echo $payAmonut->no_receipt;?></p>
                                </div>
                            </div>
                            <div class='form-group form-group-sm'>
                                <label class="col-sm-3 control-label">Pay Type: </label>
                                <div class="col-sm-6 ">
                                    <p style=" margin-top: 5px;"><?php echo $payAmonut->getType();?></p>
                                </div>
                            </div>
                            <div class='form-group form-group-sm'>
                                <label class="col-sm-3 control-label">Amount: </label>
                                <div class="col-sm-6 ">
                                    <p style=" margin-top: 5px;"><?php echo '$'.$payAmonut->amount_pay;?></p>
                                </div>
                            </div>
                            <div class='form-group form-group-sm'>
                                <label class="col-sm-3 control-label">Created: </label>
                                <div class="col-sm-6 ">
                                    <p style=" margin-top: 5px;"><?php echo date('Y/m/d',$payAmonut->created);?></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                             
                        </div>
                        
                        
                    </div>
                    
                </div>
                <?php $this->endWidget();?>
            </div>
        </div>
    </div>
</div>
