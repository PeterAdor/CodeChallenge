<?php
// Include config file
require_once "config.php";



 if(!null ==$_POST["Export"]){	
     
      header('Content-Type: text/csv; charset=utf-8');  
      header('Content-Disposition: attachment; filename=Sample.csv');  
      $output = fopen("php://output", "w");  
      fputcsv($output, array('id', 'bank_name', 'account_number', 'account_name', 'amount', 'reference'));  
      $query = "SELECT * from transfers ORDER BY id";  
      $result = mysqli_query($link, $query);  
      while($row = mysqli_fetch_assoc($result))  
      {  
           fputcsv($output, $row);
      }  
      fclose($output);  
 }

?>