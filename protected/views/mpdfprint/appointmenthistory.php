
<?php 
    $cms = new BaseFormatter();
?>

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Appointment History</title>
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
                margin-top: 30px !important;            
            }
            .noStyle{
                margin-top: 30px !important;    
                text-align: center;
                font-weight: bold;        
            }
            .border{border-color: white black black white;}
            .pageBreak{page-break-after:always}
        </style>
    </head>
    
    <body>
        <div class="noStyle">
            Appointment History
        </div>
        <?php 
        $tableHeader = '<tr>
                            <th id="drug-alert-grid_c1">Appointment Date</th>
                            <th id="drug-alert-grid_c1">Appointment Time</th>
                            <th id="drug-alert-grid_c1">Reason</th>
                            <th id="drug-alert-grid_c1">Turn Up</th>
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

                    echo "<tr>";   
                    echo "<td style='text-align:left;'>".$cms->formatDateTimeFull($item->timeslot->start)."</td>";
                    echo "<td style='text-align:left;'>".$cms->formatTimeFull($item->timeslot->start)."</td>";
                    echo "<td style='text-align:left;'>".nl2br($item->visit_reason_text)."</td>";
                    echo "<td style='text-align:left;'>".$cms->formatYNStatus($item->turn_up)."</td>";
                    echo "<td style='text-align:left;'>".nl2br($item->comments)."</td>";
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