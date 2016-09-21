
<?php 
    $cms = new BaseFormatter();
?>

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Despensing History</title>
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
                margin-top: 100px !important;    
                text-align: center;
                font-weight: bold;        
            }
            .border{border-color: white black black white;}
            .pageBreak{page-break-after:always}
             ul{
                list-style-type: none!important
             }
        </style>
    </head>
    
    <body>
        <div class="noStyle">
            Dispensing History
        </div>
        <?php 
        $tableHeader = '<tr>
                            <th id="drug-alert-grid_c1">Date</th>
                            <th id="drug-alert-grid_c1">Drug Dispensed</th>
                            <th id="drug-alert-grid_c1">Quantity</th>
                            <th id="drug-alert-grid_c1">Selling Price</th>
                            <th id="drug-alert-grid_c1">Comments</th>
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
                foreach ($dataProvider as $item) {
                    $count++;
                    $exPerPage = 23;
                    $countNormalEx++;
                    $dispensingItem = DispenseItems::model()->findAll('dispense_id = '.$item->id);
                    $name = '<ol>';
                    $quantity ='';
                    foreach ($dispensingItem  as $value) {
                        $name .= '<li>'.$value->item_name.'</li>';
                        $quantity .=$value->quantity.'<br/>';
                    }
                 
                    $name .= '</ol>';
                    echo "<tr>";   
                    echo "<td style='text-align:left;'>".$cms->formatDate($item->created_date)."</td>";
                    echo "<td style='text-align:left;'>". $name ."</td>";
                    echo "<td style='text-align:right;'>".$quantity ."</td>";
                    echo "<td style='text-align:right;'>".$cms->formatPrice($item->subtotal)."</td>";
                    echo "<td style='text-align:left;'></td>";
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