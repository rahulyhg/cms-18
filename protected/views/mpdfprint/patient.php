
<?php 
    $cms = new BaseFormatter();
?>

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Patients</title>
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
                margin-top: 100px !important;            
            }
            .noStyle{
                margin-top: 100px !important;    
                text-align: center;
                font-weight: bold;        
            }
            .border{border-color: white black black white;}
            .pageBreak{
                page-break-after:always;
                /*padding-top: 100px !important;    */
            }
        </style>
    </head>
    
    <body>
        <div class="noStyle">
            Patients Information
        </div>
        <?php 
        $tableHeader = '<tr>
                            <th id="drug-alert-grid_c1">Name</th>
                            <th id="drug-alert-grid_c1">ID</th>
                            <th id="drug-alert-grid_c1">Preferred Contact No</th>
                            <th id="drug-alert-grid_c1">Speaks</th>
                            <th id="drug-alert-grid_c1">Date of birth</th>
                            <th id="drug-alert-grid_c1">Gender</th>
                            <th id="drug-alert-grid_c1">Address</th>
                            <th id="drug-alert-grid_c1">Important Comment To Notes</th>
                        </tr>';
        ?>
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
                    echo "<td style='text-align:left;'>".$item->name."</td>";
                    echo "<td style='text-align:left;'>".$item->identity."</td>";
                    echo "<td style='text-align:left;'>".$item->contact_no."</td>";
                    echo "<td style='text-align:left;'>".$cms->formatLanguageName($item->id)."</td>";
                    echo "<td style='text-align:left;'>".$cms->formatDate($item->dob)."</td>";
                    echo "<td style='text-align:left;'>".$item->gender."</td>";
                    echo "<td style='text-align:left;'>".$cms->formatAddress($item)."</td>";
                    echo "<td style='text-align:left;'>".nl2br($item->important_comment_to_notes)."</td>";
                    echo "</tr>";  

                    //Page Break
                    if($countNormalEx && ($countNormalEx % $exPerPage) == 0){ 
                        //PAGE BREAK
                        echo '</table></div>';                                            
                        echo '<div style="display:block;page-break-before:always;"><table width="100%" border="0" align="center">';
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