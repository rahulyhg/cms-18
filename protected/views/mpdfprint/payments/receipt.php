
<?php 
    $cms = new BaseFormatter();
?>

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>RECEIPT</title>
        <style type="text/css">
            body, table, tr, td{
                font-size: 11pt !important;
            } 
            table, td, tr
            {
                border: 1px solid;
                border-collapse: collapse;
                text-align: center;       
                height: 30px;    
                margin-top: 50px !important;            
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
        </style>
    </head>
    
    <body>
       
        <div class="noStyle">
          RECEIPT
        </div>
        <div style="display: block;">      
            <table width="100%" border="0" align="center">
                            <tr>
                                <th id="drug-alert-grid_c1">Payment Mode</th>
                                <th id="drug-alert-grid_c1">Amount</th>
                                <th id="drug-alert-grid_c1">Payment Reference</th>
                            </tr>
                            <tbody>
                                <?php if(!empty($dataProvider)):?>
                                <?php foreach ( $dataProvider as $item):?>
                                 <tr class='clickable-row' >
                                    <td >American Express</td>
                                    <td data-id="1">
                                         <?php echo $item-> american_express;?>
                                       
                                    </td>
                                    <td></td>

                                </tr>
                                <tr class='clickable-row' >
                                    <td >Cash</td>
                                    <td data-id="1">
                                       <?php echo $item->cash;?>
                                    </td>
                                    <td></td>


                                </tr>
                                <tr class='clickable-row' >
                                    <td >Cheque</td>
                                    <td data-id="1">
                                        <?php echo $item->cheque;?>
                                    </td>
                                    <td></td>

                                </tr>
                                <tr class='clickable-row' >
                                    <td >Master / VISA Credit Card</td>
                                    <td data-id="1">
                                        <?php echo $item->credit_card;?>
                                    </td>
                                    <td></td>

                                </tr>

                                <tr class='clickable-row' >
                                    <td >Nets</td>
                                    <td data-id="1">
                                        <?php echo $item->nets;?>
                                    </td>
                                    <td></td>

                                </tr>
                               
                                <?php endforeach;?>
                                <?php else:?>
                                    <tr class='clickable-row' >
                                    <td >American Express</td>
                                    <td data-id="1">
                                          0.00
                                       
                                    </td>
                                    <td></td>

                                </tr>
                                <tr class='clickable-row' >
                                    <td >Cash</td>
                                    <td data-id="1">
                                        0.00
                                    </td>
                                    <td></td>


                                </tr>
                                <tr class='clickable-row' >
                                    <td >Cheque</td>
                                    <td data-id="1">
                                        0.00
                                    </td>
                                    <td></td>

                                </tr>
                                <tr class='clickable-row' >
                                    <td >Master / VISA Credit Card</td>
                                    <td data-id="1">
                                         0.00
                                    </td>
                                    <td></td>

                                </tr>

                                <tr class='clickable-row' >
                                    <td >Nets</td>
                                    <td data-id="1">
                                        0.00
                                    </td>
                                    <td></td>

                                </tr>
                                <?php endif;?>
                            </tbody>
            </table>
        </div>
    </body>
</html>