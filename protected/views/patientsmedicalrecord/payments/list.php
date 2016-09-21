
<div class="form-horizontal">
    <div class="box-1">
        <div class="title-box clearfix">
            <h2 class="title"><?php echo Yii::t('static', 'Dispensing Entry') ?></h2>
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
                    <p>Unpaid Bills (Outstanding amount) = <b id="bill-total"></b> </p>      
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
                        <div class="col-md-4 alignright"><?php echo $patientInfor['doctor_name'] ?></div>
                    <?php } ?>
                </div>
            </div>

        </div>
    </div>
    <br>
    
</div>
    </div>
</div>