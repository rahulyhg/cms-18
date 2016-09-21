
<?php 
    $cms = new BaseFormatter();
?>

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Drug Alert Information</title>
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
                /*margin-top: 100px !important;    */
                text-align: center;
                font-weight: bold;        
            }
            .border{border-color: white black black white;}
            .pageBreak{
                page-break-after:always;
                display: block;
                margin-top: 100px !important;
            }
        </style>
    </head>
    
    <body>
        <div class="noStyle">
            Drug Alert Information
        </div>
        <?php 
        $tableHeader = '<tr>
                            <th id="drug-alert-grid_c1">Entry Date</th>
                            <th id="drug-alert-grid_c1">Edit Date</th>
                            <th id="drug-alert-grid_c1">Name</th>
                            <th id="drug-alert-grid_c1">Comments</th>
                        </tr>';
        ?>
        <div style="display: block;"> 
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
                    if ($item->delete_date != "")
                        $comment = nl2br($item->comment) . "(Entry deleted)";
                    else
                        $comment = $item->comment;
                    echo "<tr>";   
                    echo "<td style='text-align:left;'>".$cms->formatDate($item->entry_date)."</td>";
                    echo "<td style='text-align:left;'>".$cms->formatDate($item->edit_date)."</td>";
                    echo "<td style='text-align:left;'>".nl2br($item->name)."</td>";
                    echo "<td style='text-align:left;'>".nl2br($comment)."</td>";
                    echo "</tr>";  

                    //Page Break
                    if($countNormalEx && ($countNormalEx % $exPerPage) == 0){ 
                        //PAGE BREAK
                        echo '</table></div>';                                            
                        echo '<div class="pageBreak"><table width="100%" border="0" align="center">';
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
