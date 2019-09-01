
 <?php 
 
//begin session 
 session_start();
 
//set submit button
isset($_POST["submit"]);

//initialize  variable
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "users";
$_SESSION["Amount"] = $_POST["Amount"];

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ( $conn->connect_error){
	
	die("Connection failed: " . $conn->connect_error);
} 


//display result begins here/////////

$sql2 = "SELECT Amount FROM users  WHERE username = '$_SESSION[username]'";

 if ($result = $conn->query($sql2));{
	
	//output 
	 
	 While($row = $result->fetch_assoc()){
		 
		 if(!empty($row["Amount"])) {
		 
		 $Amount = $row["Amount"] + $_SESSION["Amount"];
		 }
		 else if(empty($row["Amount"])) 
		 
		 { $row["Amount"] =0;
		
		$Amount = $row["Amount"] + $_SESSION["Amount"];
		 }
		 
	}
	
//update wallet balance in database

$username = $_SESSION["username"];

 $sql = "

  UPDATE users

   SET Amount = '$Amount'

    WHERE username = '$_SESSION[username]' ";
}
//update data ends here/////////

if ($conn->query($sql) === TRUE){
	
	// echo "Success! You've added: NGN ". $_SESSION["Amount"] . " to your wallet, your balance is: NGN". $Amount." ". "<br>";
	}
	else{
		
		echo "Error: " . $sql . "<br>" . $conn->error;
		}

$conn->close();

 
 
 
 
 
 
 
 
 
 

 ?>
 
 
 
<!DOCTYPE html>
<html lang="en">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8">
	
	<style> 

/* Button used to open the contact top up wallet form */

.Load-Wallet {
  background-color: #555;
  color: blue;
  padding: 16px 20px;
  border: none;
  cursor: pointer;
  opacity: 0.8;
  width: 280px;
}

/* The popup form - hidden by default */
.form-popup {
  display: none;
  
  bottom: 0;
  right: 15px;
  border: 3px solid #f1f1f1;
  z-index: 9;
}

/* Add styles to the form container */
.form-container {
  max-width: 300px;
  padding: 10px;
  background-color: white;
}

/* Full-width input fields */
.form-container input[type=text], .form-container input[type=Card_Expiry] {
  width: 80%;
  padding: 15px;
  margin: 5px 0 22px 0;
  border: none;
  background: #f1f1f1;
}

/* When the inputs get focus, do something */
.form-container input[type=text]:focus, .form-container input[type=Card_Expiry]:focus {
  background-color: #ddd;
  outline: none;
}

/* Set a style for the submit/Top Up Test Card button */
.form-container .btn {
  background-color: #4CAF50;
  color: white;
  padding: 16px 20px;
  border: none;
  cursor: pointer;
  width: 100%;
  margin-bottom:10px;
  opacity: 0.8;
}

/* Add a red background color to the cancel button */
.form-container .cancel {
  background-color: red;
}

/* Add some hover effects to buttons */
.form-container .btn:hover, .Load-Wallet:hover {
  opacity: 1;
}



 </style>
  <title>Welcome
	
	</title>
</head>

<body>

 
 <a href=""><body class="Load-Wallet" onload ="openForm()">  </body></a>

<div class="form-popup" id="myForm">
  <form action="wallet.php"  method = "POST" class="form-container">
    <h1>  </h1>

    <label for="Test Card"><b>Test Card</b></label>
    <input type="text" value="0000 0000 0000" name="Test Card">

    <label for="Card_Expiry"><b>Card_Expiry</b></label>
    <input type="Card_Expiry" placeholder="Enter Card_Expiry" name="Card_Expiry" value = "<?php echo date("d-m-y");?>" required>
	
<input type="hidden" value = " <?php echo $_SESSION["Amount"] ; ?>">

    <button type="button" class="btn" onclick="LOADForm()" >   <?php echo "Top Up   " . "NGN: ". $_SESSION["Amount"]; ?></button>
	
	
    <button type="button" class="btn cancel" onclick="window.location.href = 'welcome.php'">Close </button>
  </form>
</div>




 <a href=""><body class="Load-Wallet" onload ="openForm()">  </body></a>

<div class="form-popup" id="Load-Wallet">
  <form action="wallet.php"  method = "POST" class="form-container">
    <h1>  Successful! </h1>

    <label for="Amount"><b>Amount</b></label>
    <input type="text" value="<?php echo "NGN". $_SESSION["Amount"]; ?>" name="Test Card">

    <label for="Current Balance"><b>Current Balance</b></label>
    <input type="text"  name="Current Balance" value = "<?php  echo "NGN: ". $Amount?>" required?>
	
	
  </form>
</div>








<!--java script code to display top up form-->



<script>
function openForm() {
  document.getElementById("myForm").style.display = "block";
}

function closeForm() {
  document.getElementById("myForm").style.display = "none";
}
</script>


 
<script>
function LOADForm() {
  document.getElementById("Load-Wallet").style.display = "block";
}

function closeLOADForm() {
  document.getElementById("Load-Wallet").style.display = "none";
}
</script> 
 
    </p>
</body>
</html>