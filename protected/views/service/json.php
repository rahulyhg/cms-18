<?php 
header('Content-type: application/json');
//echo $_GET['callback'] . '(' . json_encode($response) . ');';
echo json_encode($response);
?>
