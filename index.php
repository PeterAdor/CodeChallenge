<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" crossorigin="anonymous"></script>

</head>

<body>

<!-- export sample file -->

 <div>
            <form class="form-horizontal" action="functions.php" method="post" name="upload_excel"   
                      enctype="multipart/form-data">
                  <div class="form-group">
                            <div class="col-md-4 col-md-offset-4">
                                <input type="submit" name="Export" class="btn btn-success" value="Download Sample CSV"/>
								
                            </div>
                   </div>                    
 
 </form>
<center><a href ="welcome.php"><input type="submit" name="Back" class="btn btn-success" value="Back" /> </a>
 </div>
 


<!-- upload csv file -->


    <center><div id="wrap"  >
        <div class="container">
            <div class="row">

                <form class="form-horizontal" action="process.php" method="post" name="upload_excel" enctype="multipart/form-data">
                    <fieldset>

                        <!-- Form Name -->
                        <legend>Form Name</legend>

                        <!-- File Button -->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="filebutton">Select File</label>
                            <div class="col-md-4">
                                <input type="file" name="file" id="file" class="input-large" required>
                            </div>
                        </div>

                        <!-- Button -->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="singlebutton">Upload CSV</label>
                            <div class="col-md-4">
							<input type ="hidden" value= "<?php  echo $_SESSION["username"];?>">
                                <button type="submit" id="submit" name="Import" class="btn btn-primary button-loading" data-loading-text="Loading...">Import</button>
                            </div>
                        </div>

                    </fieldset>
                </form>

            </div>
			
			
			
            <?php
//session begins 
session_start();

//include the database configuration file
 include ("config.php");
 
  
   
  $Sql = "SELECT * FROM $_SESSION[username]";
	
   $result = mysqli_query($link, $Sql);   

if (empty($result)){
	
 $result = "";
 }
  else  if (mysqli_num_rows($result) > 0) {
	  
	  echo "<div class='table-responsive'><table id='myTable' class='table table-striped table-bordered'>
             <thead><tr><th>id</th>
                          <th>bank_name</th>
                          <th>account_number</th>
                          <th>account_name</th>
                          <th>amount</th>
						  <th>reference</th>
                        </tr></thead><tbody>";

      while($row = mysqli_fetch_assoc($result))
		if (null ==$row){
		
		$row = "";
		
	}else {

  echo "<tr><td>" . $row['id']."</td>
                   <td>" . $row['bank_name']."</td>
                   <td>" . $row['account_number']."</td>
                   <td>" . $row['account_name']."</td>
                   <td>" . $row['amount']."</td>
				   <td>" . $row['reference']."</td> </tr>";        
	 }
     echo "</tbody></table></div>";
	 
////sum total amount AND wallet balance in database////
  if( $sum = "SELECT sum(amount) FROM $_SESSION[username]"

	 AND
	
		$result3 = "SELECT Amount FROM users  WHERE username = '$_SESSION[username]'"){ 
		
	  if ($result2 = mysqli_query($link, $sum)
				
	AND

 $result3 = mysqli_query($link, $result3)) {  
	 
     while($sum_amount_column = mysqli_fetch_assoc($result2)
		 AND

		  $balance = $result3->fetch_assoc()){
			  
			 
		  if($sum_amount_column['sum(amount)'] >  $balance["Amount"]){
			 
			 
			//delete  CSV table when there's insuficient balance in your wallet
		
		$del = "DROP TABLE `$_SESSION[username]` "; mysqli_query($link, $del);

 echo '<script type="text/javascript">alert("Insuficient Balance, top-up your wallet first!"); window.location = "welcome.php"; </script>';

			  }
			  else {	
$wall=	  $balance["Amount"] - $sum_amount_column['sum(amount)'];			  
					  			  
				  $sum_amount_column = $sum_amount_column['sum(amount)'];
		
				echo "<b>"."<form method ='POST' action = 'index.php'>". "Sum Amount NGN:". $sum_amount_column.
				
"<input type='hidden' name = 'sum_amount_column' value = '$sum_amount_column'>

<button type='submit' id='Confirm_payment' name='Confirm_payment' class='btn btn-primary button-loading' data-loading-text='Confirm_payment'>Confirm_payment</button>

<button type='submit' id='Cancel_payment' name='Cancel_payment' style = 'color:red ;' class='btn btn-primary button-loading' data-loading-text='Cancel_payment'>Cancel_payment</button>
</form>";	
	
			  }	

//update wallet balance in database
if(isset($_POST["Confirm_payment"])){

 $wallet_balance = "

  UPDATE users

   SET Amount = '$wall'

    WHERE username = '$_SESSION[username]' ";

$link->query($wallet_balance);

$del = "DROP TABLE `$_SESSION[username]` "; mysqli_query($link, $del);
///////////////////////////////////////////////////////////////////////////////////////////////////////
///API call would be required here to authenticate account numbers and display feedback////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////

			echo "Your Wallet Balance: NGN ".$balance["Amount"];
		echo '<script type="text/javascript">alert("Successful!"); window.location = "welcome.php"; </script>';	

}
else if(isset($_POST["Cancel_payment"])){
	
	$del = "DROP TABLE `$_SESSION[username]` "; mysqli_query($link, $del);
	
	} 
			}
		  }	
			}
  }
  
 else {
	 echo "error";
	}
	
?>




        </div>
    </div> </center>
	
</body>

</html>