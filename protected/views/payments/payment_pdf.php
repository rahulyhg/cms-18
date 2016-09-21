
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>PAYMENT INFORMATION</title>
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
                    <div class="row" >        
                        <div class="col-md-12" >
                            <div  class="pay-inv-infor">
                                <h5> <u>PAYMENT INFORMATION </u></h4>
                                    <p>Unpaid Bills (Outstanding amount) = <b id="bill-total"><?php echo Yii::app()->format->prices($model->amount_due); ?></b> </p>      
                                    <p>Bill To : <u> <?php if (!empty($patientInfor)) echo $patientInfor['name'] ?> </u> </p>      

                            </div>
                        </div>
                    </div>
                  
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
                                <table class="table table-hover table-responsive table-bordered" data-example-id="hoverable-table" >
                                    <thead>
                                        <tr>
                                            <th style="width: 5%">S/N</th>
                                            <th style="width: 30%">Item Name</th>
                                            <th style="width: 10%">Price / Unit</th>
                                            <th style="width: 5%">Quantity</th>
                                            <th style="width: 10%">Price</th>
                                            <th style="width: 10%">Discount</th>
                                            <th style="width: 10%">Price After Discount</th>
                                            <th style="width: 15%">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody class="invoice-main">
                                        <?php
                                        $number = 0;
                                        foreach ($invoiceItem as $index => $item):
                                            ?>
                                            <tr class='clickable-row invoice-item' >
                                                <td class="number-td"><?php echo $index + 1; ?></td>
                                                <td >
                                                    <?php echo $item->item_name; ?>
                                                </td >


                                                <td>
                                                    <?php echo Yii::app()->format->prices($item->price) ?>
                                                </td>
                                                <td>
                                                    <?php echo $item->quantity; ?>
                                                </td>
                                                </td>
                                                <td>
                                                    <?php echo Yii::app()->format->prices($item->price * $item->quantity); ?>

                                                <td>
                                                    <?php
                                                        if($item->discount_type == 1) {
                                                            echo $item->discount.' %'; 

                                                        }
                                                        else
                                                        {
                                                             echo '$'.$item->discount; 
                                                        }
                                                    ?>
                                                </td>
                                                <td>     
                                                    <?php echo Yii::app()->format->prices($item->price_after_discount); ?>
                                                </td>
                                                <td>      <?php echo Yii::app()->format->prices($item->total); ?></td>
                                            </tr>
                                        <?php endforeach; ?>

                                    </tbody>

                                </table>


                            </div>
                        </div>
                    </div>

                    <div class="form bottom-form">
                        <div class="clearfix"></div>
                        <div class="row">
                            <div class="col-md-7">

                            </div>
                            <div class="col-md-5 ">

                                <p> Subtotal:  <?php echo Yii::app()->format->prices($model->subtotal); ?></p>

                                <p> 
                                    Discount:  
                                    <?php
                                        if($model->discount_type == 1) {
                                            echo $model->discount.' %'; 
                                            
                                        }
                                        else
                                        {
                                             echo '$'.$model->discount; 
                                        }
                                    ?>
                                </p>

                                <p>Amount after discount:    <?php echo Yii::app()->format->prices($model->amount_after_discount); ?></p>

                                <p> Add GST 7%:    <?php echo Yii::app()->format->prices($model->add_gst); ?></p>

                                <p> Total with GST:    <?php echo Yii::app()->format->prices($model->total_with_gst); ?></p>
                                <p>Amount due:   <?php echo Yii::app()->format->prices($model->amount_due); ?></p>
                                <p>Total received:    <?php echo Yii::app()->format->prices($model->total_receive); ?></p>



                            </div>
                        </div>

                        <?php $this->endWidget(); ?>
                    </div>
                </div>
            </div>
              </div>
    </body>
</html>