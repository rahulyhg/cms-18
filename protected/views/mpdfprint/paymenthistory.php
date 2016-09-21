
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
        </style>
    </head>
    
    <body>
       
        <div class="noStyle">
          PAYMENT INFORMATION
        </div>
        <?php 
        $tableHeader = '<tr>
                            <th id="drug-alert-grid_c1">S/N</th>
                            <th id="drug-alert-grid_c1">Invoice Date</th>
                            <th id="drug-alert-grid_c1">Invoice No/Resceipt No</th>
                            <th id="drug-alert-grid_c1">Amount Paid</th>
                            <th id="drug-alert-grid_c1">Change</th>
                            <th id="drug-alert-grid_c1">Comment</th>
                            <th id="drug-alert-grid_c1">Created Date</th>
                        </tr>';
        ?>
         <div style="margin-top: 50px">
                <?php
                    $patient = Patient::model()->findByPk($patient_id);
                ?>
                <h3>
                    Patient Name: <?php echo $patient->name;?>
                </h3>
                 <h3>
                    ID: <?php echo $patient->reference_no;?>
                </h3>
            </div>
        <div style="display: block;">      
            <table width="100%" border="0" align="center">
                <?php echo $tableHeader; 
                    $countNormalEx = 0; // count number records, except page break
                    $count         = 0; // count number records, includes Sub header & page break
                ?>
                <?php
                foreach ($dataProvider as $number => $item) {
                    $count++;
                    $exPerPage = 23;
                    $countNormalEx++;

                    echo "<tr>";   
                     echo "<td style='text-align:left;'>". ($number+1)."</td>";
                    echo "<td style='text-align:left;'>".$cms->formatDate($item->created_date)."</td>";
                    echo "<td style='text-align:left;'>".$item->invoice_no."</td>";
                    echo "<td style='text-align:right;'>".$cms->formatPrice($item->Amout->amount_pay)."</td>";
                    echo "<td style='text-align:right;'>".$cms->formatPrice($item->Amout->change)."</td>";
                    echo "<td style='text-align:left;'>".$item->comment."</td>";
                    echo "<td style='text-align:left;'>".$cms->formatDate($item->created_date)."</td>";
                    echo "</tr>";  

                    //Page Break
                    if($countNormalEx && ($countNormalEx % $exPerPage) == 0){ 
                        //PAGE BREAK
                        echo '</table></div>';                                            
                        echo '<div style="display:block;page-break-before:always"><table width="100%" border="0" align="center">';
                        echo $tableHeader;
                        $firstPage = false;
                        $countNormalEx = 0;
                    } 
                }
                ?>
            </table>
        </div>
    </body>
</html>