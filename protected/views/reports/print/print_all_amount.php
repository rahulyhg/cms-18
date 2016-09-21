
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>PAYMENT </title>
        <style type="text/css">
            body, table, tr, td{
                font-size: 11pt !important;
            } 
            table, td, tr th
            {
                border: 1px solid;
                border-collapse: collapse;
                text-align: center;       
                height: 30px;    
                margin-top: 10px !important;            
            }
            .noStyle{
                margin-top: 50px !important;    
                text-align: center;
                font-weight: bold;        
            }
            .border{border-color: white black black white;}
            .pageBreak{page-break-after:always}
            .invoice-no {
                float: right!important;
            }

            .col-md-7 {
                width: 65%!important;
            }
            .col-md-5 {
                width: 35%;
                float:right;
                text-align: right;
            }

            .margintext_right {
                margin-left: 50px!important;
            }
            
            .info{
                width: 100%;
            }
            .info p {
                float: left;
                margin-right: 50px;
                width: 100px;
                margin-top: 5px;
            }
            .col-md-12{
                width: 100%;
            }
            .pay-inv-infor {
                width: 100%;
            }
        </style>
    </head>

    <body>

        <div class="form-horizontal">
            <div class="box-1">
                <div class="box-body"> 
                    <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'dispense-model-form',
                        'enableClientValidation' => false,
                        'enableAjaxValidation' => FALSE,
                        'clientOptions' => array(
                            'validateOnSubmit' => true,
                        ),
                            ));
                    ?>
                    <div class="row form-horizontal">
                        <div class="col-md-12 form-group-sm">
                            <div>
                                <h4 style=" text-align: center;">List Transaction Payments</h4>
                                <table class="table table-hover table-responsive table-bordered" data-example-id="hoverable-table" style=" margin-top: 50px;" >
                                    <thead>
                                        <tr>
                                            <th style="width: 5%">S/N</th>
                                            
                                            <th style="width: 20%">Receipt No</th>
                                            <th style="width: 30%">Invoice No</th>
                                            <th style="width: 20%">Pay Model</th>
                                            <th style="width: 10%">Amount</th>
                                            <th style="width: 10%">Created</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody class="invoice-main">
                                        <?php 
                                             $dataModel = array(
                                                    1 => 'Cash',
                                                    2 => 'Nets',
                                                    3 => 'Visa',
                                                    4 => 'MasterCard',
                                                    5 => 'Amex',
                                                );
                                        ?>
                                         <?php foreach ($model as $index => $item):?>
                                            <tr>
                                                <td><?php echo $index+1;?></td>
                                                <td><?php echo $item["no_receipt"]?></td>
                                                <td><?php echo $item["invoice_no"] ;?></td>
                                             
                                                <td><?php echo $dataModel[$item["pay_type"]];?></td>
                                                <td><?php echo $item["amount_pay"];?></td>
                                                <td><?php echo date('d/m/Y',$item["created"]);?></td>
                                                
                                            </tr>
                                        <?php endforeach; ?>

                                    </tbody>

                                </table>


                            </div>
                        </div>
                    </div>
                    <?php $this->endWidget(); ?>
                </div>
            </div>
          </div>
    </body>
</html>