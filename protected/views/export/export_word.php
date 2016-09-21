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
            table, td, th, tr
            {
                border: 1px solid;
                border-collapse: collapse;
                text-align: center;       
                height: 30px;    
                margin-top: 10px !important;            
            }
            .noStyle{
                /*margin-top: 100px !important;    */
                margin-bottom: 15px !important;
                text-align: center;
                font-weight: bold;        
            }
            /*.border{border-color: white black black white;}*/
            .pageBreak{
                page-break-after:always;
                /*padding-top: 100px !important;    */
            }
        </style>
    </head>
    
    <body>
        <div class="noStyle">
            <?php echo $title ?>
        </div>
        <?php 
            $tableHeader = '<tr>';
            $tableHeader .= '<th id="drug-alert-grid_c1">S/N</th>';
            foreach ($columns as $key => $value) {
                $tableHeader .= '<th id="drug-alert-grid_c1">'.$value.'</th>';
            }
            $tableHeader .= '</tr>';
        ?>
        <div style="display: block;">      
            <table width="100%" border="0" align="center">
                <?php echo $tableHeader; 
                    $countNormalEx = 0; // count number records, except page break
                    $count         = 1; // count number records, includes Sub header & page break
                ?>
                <?php

                foreach ($dataProvider as $value) {
                    $item = Patient::model()->findByPk($value['id']);
                    echo "<tr>"; 
                    echo "<td style='text-align:left;'>".$count."</td>";
                    foreach ($columns as $key => $v) {
                        $val = $item->$key;
                        if ($key == 'dob') {
                            $val = date('d/m/Y', strtotime($item->$key));
                        }
                        if ($key == 'doctor_name') {
                            $val = $item->doctor->name;
                        }
                        echo "<td style='text-align:left;'>".$val."</td>";    
                    }
                    echo "</tr>";  
                    $count++;
                }
                ?>
            </table>
        </div>
    </body>
</html>