
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
                                <h4 style=" text-align: center"><center>List Payments</center></h4>
                                 <div style="margin-top: 50px">
                                    <?php if(isset($patient_id) && !empty($patient_id)):?> 
                                    <?php
                                        $patient = Patient::model()->findByPk($patient_id);
                                    ?>
                                    <h3>
                                        Patient Name: <?php echo $patient->name;?>
                                    </h3>
                                     <h3>
                                        ID: <?php echo $patient->id;?>
                                    </h3>
                                     <?php endif;?>
                                </div>
                                <table class="table table-hover table-responsive table-bordered" data-example-id="hoverable-table" >
                                    <thead>
                                        <tr>
                                            <th style="width: 5%">S/N</th>
                                            <th style="width: 10%">Invoice no</th>
                                            <th style="width: 10%">Subtotal</th>
                                            <th style="width: 10%">Discount</th>
                                            <th style="width: 10%">Add GST</th>
                                            <th style="width: 15%">Total With GST</th>
                                            <th style="width: 15%">Amount After Discount</th>
                                            <th style="width: 10%">Amount</th>
                                            <th style="width: 10%">Receive</th>
                                        
                                            
                                        </tr>
                                    </thead>
                                    <tbody class="invoice-main">
                                       
                                         <?php foreach ($model as $index => $item):?>
                                            <tr>
                                                <td><?php echo $index+1;?></td>
                                                <td><?php echo $item["invoice_no"];?></td>
                                                <td><?php echo $item["subtotal"];?></td>
                                                <?php if($item['discount_type']==1):?>
                                                    <td><?php echo $item["discount"].'%';?></td>
                                                <?php else:?>
                                                    <td><?php echo '$'.$item["discount"];?></td>
                                                <?php endif;?>
                                                <td><?php echo $item["add_gst"];?></td>
                                                <td><?php echo $item["total_with_gst"];?></td>
                                                <td><?php echo $item["amount_after_discount"];?></td>
                                                <td><?php echo $item["amount_due"];?></td>
                                                <td><?php echo $item["total_receive"];?></td>
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