
<?php 
    $cms = new BaseFormatter();
?>

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Company Medical Insurrance</title>
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
                margin-top: 20px !important;            
            }
            .noStyle{
                margin-top: 20px !important;    
                text-align: center;
                font-weight: bold;        
            }
            .border{border-color: white black black white;}
            .pageBreak{page-break-after:always}
        </style>
    </head>
    
    <body>
        <div class="noStyle">
            Company Medical Insurrance
        </div>
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
        <?php 
        $tableHeader = '<tr>
                            <th id="drug-alert-grid_c1">Company Name</th>
                            <th id="drug-alert-grid_c1">Entitlement Amount</th>
                            <th id="drug-alert-grid_c1">Follow</th>
                            <th id="drug-alert-grid_c1">Department</th>
                            <th id="drug-alert-grid_c1">To Bill Innsurance</th>
                            <th id="drug-alert-grid_c1">Copayment</th>
                            <th id="drug-alert-grid_c1">Staff No</th>
                            <th id="drug-alert-grid_c1">Insurance Name</th>
                            <th id="drug-alert-grid_c1">Amount</th>
                            <th id="drug-alert-grid_c1">Attach Insurance Card, Letter or Document </th>
                        </tr>';
        ?>
        <div style="display: block;">      
            <?php if (count($dataProvider) <= 0): ?>
                
            <?php else: ?>

            
            <table width="100%" border="0" align="center">
                <?php echo $tableHeader; 
                    $countNormalEx = 0; // count number records, except page break
                    $count         = 0; // count number records, includes Sub header & page break
                ?>
                <?php
                foreach ($dataProvider as $item) {
                    $entitlement = $cms->formatPrice($item->entitlement_from).' - '.$cms->formatPrice($item->entitlement_to);
                    $amount = $cms->formatPrice($item->copayment_amount_from).' - '.$cms->formatPrice($item->copayment_amount_to);
                    $data['patient_id'] = $item->patient_id;
                    $data['patient_medical_insurrance_id'] = $item->id;
                    $copayment = $item->copayment ? "Yes" : "No";

                    $count++;
                    $exPerPage = 6;
                    $countNormalEx++;

                    echo "<tr>";   
                    echo "<td style='text-align:left;'>".$item->company_name."</td>";
                    echo "<td style='text-align:left;'>".$entitlement."</td>";
                    echo "<td style='text-align:left;'>".DeclareHelper::$followFormat[$item->follow]."</td>";
                    echo "<td style='text-align:left;'>".$item->department."</td>";
                    echo "<td style='text-align:left;'>".DeclareHelper::$toBillInsuranceFormat[$item->to_bill_insurrance]."</td>";
                    echo "<td style='text-align:left;'>".$copayment."</td>";
                    echo "<td style='text-align:left;'>".$item->staff_no."</td>";
                    echo "<td style='text-align:left;'>".$item->insurrance_name."</td>";
                    echo "<td style='text-align:left;'>".$amount."</td>";
                    echo "<td style='text-align:left;'>".$cms->formatDocumentDownload($data)."</td>";
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
        <?php endif; ?>
        </div>
            
    </body>
</html>