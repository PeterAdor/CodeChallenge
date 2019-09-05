<?php
// Initialize the session
session_start();


 
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

//initial variables

if(isset($_POST["Amount"])== true){
   
$_SESSION["Amount"] = $_POST["Amount"];

}
 
function wallet(){
//include the database configuration file
 include ("config.php");
 
 //display the current wallet balance 
$sql = "SELECT Amount FROM users  WHERE username = '$_SESSION[username]'";

if($resul3 = mysqli_query($link, $sql)){
	
$balance = $resul3->fetch_assoc();

echo "Balance: "."NGN".$balance["Amount"];
		
}
}
?>
 



































 
 
 
<!DOCTYPE html>
<html lang="en">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8">
	
	<style> .avatar {
  vertical-align: middle;
  width: 70px;
  height: 70px;
  border-radius: 50%;
}

.dropbtn {
  background-color: white;
  color: white;
  padding: px;
  font-size: 16px;
  border: none;
}

.dropdown {
  position: relative;
  display: inline-block;
}

.dropdown-content {
  display: none;
  position: absolute;
  background-color: #f1f1f1;
  min-width: 160px;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
}

.dropdown-content a {
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
}

.dropdown-content a:hover {color:green ;}

.dropdown:hover .dropdown-content {display: block;}

.dropdown:hover .dropbtn {background-color: white;}




body {
  font-family: Arial, Helvetica, sans-serif;
}

.navbar {
  overflow: hidden;
  background-color: green;
}

.navbar a {
  float: left;
  font-size: 16px;
  color: white;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
}

.dropdownM {
  float: left;
  overflow: hidden;
}

.dropdownM .dropbtn-menu {
  font-size: 16px;  
  border: none;
  outline: none;
  color: white;
  padding: 14px 16px;
  background-color: inherit;
  font-family: inherit;
  margin: 0;
}

.navbar a:hover, .dropdownM:hover .dropbtn-menu {
  background-color: red;
}

.dropdownM-menu-content {
  display: none;
  position: absolute;
  background-color: #f9f9f9;
  min-width: 160px;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
}

.dropdownM-menu-content a {
  float: none;
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
  text-align: left;
}

.dropdownM-menu-content a:hover {
  background-color: #ddd;
}

.dropdownM:hover .dropdownM-menu-content {
  display: block;
}



/* Button used to open the contact top up wallet form */
.Load-Wallet {
  background-color: #555;
  color: white;
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
.form-container input[type=text], .form-container input[type=Amount] {
  width: 100%;
  padding: 15px;
  margin: 5px 0 22px 0;
  border: none;
  background: #f1f1f1;
}

/* When the inputs get focus, do something */
.form-container input[type=text]:focus, .form-container input[type=Amount]:focus {
  background-color: #ddd;
  outline: none;
}

/* Set a style for the submit/Top Up Balance button */
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






<div class="dropdown" style = "float:right">

 Hi, <?php echo htmlspecialchars($_SESSION["username"]);  ?>
 
  
			<class="dropbtn">

  <img src="http://localhost/pay/avatar.png" alt="Avatar" class="avatar">
  
  
		<div class="dropdown-content">
 
			<a href="#">My Profile</a>
			<a href="#">Get Help</a>
			<a href="logout.php" class="btn btn-danger";>Sign Out</a>
					
			<class="dropbtn"/>
  </div>
</div>

<br>

 <div class="navbar">
  <a href="#home">Home</a>
  <a href="#news"><?php  wallet();?></a>
  <div class="dropdownM">
    <button class="dropbtn-menu">New Transfer 
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdownM-menu-content">
      <a href="#">Single Transfers</a>
	  <form method = "POST" action = "index.php">
	  <input type ="hidden" value= "<?php  echo $_SESSION["username"];?>">
	  <input type ="submit" value= "Bulk Transfers">
	  </form >
     
	  
	  
	  
      <a href="#"><button class="Load-Wallet" onclick="openForm()"> Top Up Balance  </button></a>
    </div>
  </div> 
</div>
 
 
 
 


<div class="form-popup" id="myForm">
  <form method ="POST" action=" wallet.php" class="form-container">
    <h1>Top Up Balance</h1>

    <label for="Balance"><b>Balance</b></label>
    <input type="text" value="NGN Balance" name="Balance">

    <label for="Amount"><b>Amount</b></label>
    <input type="Amount" placeholder="Enter Amount" name="Amount" required>

    <button type="submit" class="btn">Top Up Balance</button>
    <button type="button" class="btn cancel" onclick="closeForm()">Close</button>
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

 
 
 
    </p>
</body>
</html>
