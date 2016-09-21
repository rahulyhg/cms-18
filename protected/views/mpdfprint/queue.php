
<?php 
    $cms = new BaseFormatter();
?>

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>PAYMENT INFORMATION</title>
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
          INVOICE
        </div>
        <?php 
        $tableHeader = '<tr>
                            <th id="drug-alert-grid_c1">Q-No</th>
                            <th id="drug-alert-grid_c1">Time In</th>
                            <th id="drug-alert-grid_c1">Time Out</th>
                            <th id="drug-alert-grid_c1">Patient Name</th>
                            <th id="drug-alert-grid_c1">Seen</th>
                            <th id="drug-alert-grid_c1">Dispense</th>
                            <th id="drug-alert-grid_c1">Bill</th> 
                            <th id="drug-alert-grid_c1">Paid</th>
                            <th id="drug-alert-grid_c1">Contact/Insurance</th>
                            <th id="drug-alert-grid_c1">Follow Up</th>
                        </tr>';
        ?>
        <div style="display: block;">      
            <table width="100%" border="0" align="center">
                <?php echo $tableHeader; 
                    $countNormalEx = 0; // count number records, except page break
                    $count         = 0; // count number records, includes Sub header & page break
                ?>
                <?php

                foreach ($dataProvider as $queueItem):
                    $count++;
                    $exPerPage = 23;
                    $countNormalEx++;
                    ?>
                    <tr>
                        <td style='text-align:left;'><?php echo $count; ?></td>
                        <td><?php echo date("h:i A", strtotime($queueItem->time_in)); ?></td>
                        <td><?php echo $queueItem->time_out != '' ? date("h:i A", strtotime($queueItem->time_out)) : ''; ?></td>
                        <td><?php echo $queueItem->patient_name;?></td>
                        <td><?php echo $queueItem->seen == 1?'V':'X';?></td>
                        <td><?php echo $queueItem->dispense == 1?'V':'X';?></td>
                        <td><?php echo $queueItem->bill;?></td>
                        <td><?php echo $queueItem->paid;?></td>
                        <td><?php echo $queueItem->patient->patientmedicalinsurrance ? $queueItem->patient->patientmedicalinsurrance->insurrance_name : '';?></td>
                        <td><?php echo $queueItem->follow_up;?></td>
                    </tr>
                    
            <?php
                    //Page Break
                    if($countNormalEx && ($countNormalEx % $exPerPage) == 0){ 
                        //PAGE BREAK
                        echo '</table></div>';                                            
                        echo '<div style="display:block;page-break-before:always"><table width="100%" border="0" align="center">';
                        echo $tableHeader;
                        $firstPage = false;
                        $countNormalEx = 0;
                    } 
                endforeach;
                ?>
            </table>
        </div>
    </body>
</html>