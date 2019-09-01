<?php

session_start();

echo $_SESSION["username"];

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "users";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

// sql to create table
$sql = "CREATE TABLE $_SESSION[username] (

id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 

bank_name TEXT(30) NOT NULL,

account_number INT(11) NOT NULL,

account_name TEXT(30) NOT NULL,

amount INT(30) NOT NULL,

reference VARCHAR(50),

reg_date TIMESTAMP
)";
 

if ($conn->query($sql) === TRUE) {
    echo "Table".$_SESSION["username"]. "created successfully";
} else {
    echo "Error creating table: " . $conn->error;
}

if(isset($_POST["Import"])){
    
    $filename=$_FILES["file"]["tmp_name"];    


     if($_FILES["file"]["size"] > 0)
     {
		 //open file
        $file = fopen($filename, "r");
          while (($getData = fgetcsv($file, 10000, ",")) !== FALSE)
           {
//insert file content into table1

            if( $sql = "INSERT into $_SESSION[username] (id, bank_name, account_number, account_name, amount, reference) 
 
 values ('".$getData[0]."','".$getData[1]."','".$getData[2]."','".$getData[3]."','".$getData[4]."','".$getData[5]."')" 
                   	
				   
				 //insert file content into table2  
				 AND
				   
				   $sql5 = "INSERT into transfers (id, bank_name, account_number, account_name, amount, reference) 
 
 values ('".$getData[0]."','".$getData[1]."','".$getData[2]."','".$getData[3]."','".$getData[4]."','".$getData[5]."')") 
                  

				 $result5 = mysqli_query($conn, $sql5);
				   
				   $result = mysqli_query($conn, $sql);
				   
				   
			
			if(null== $result)
        {
		 echo "<script type=\"text/javascript\">
              alert(\"Invalid File:Please Upload CSV File.\");
              window.location = \"index.php\"
              </script>";
		}
        else 
		{ 
            echo "<script type=\"text/javascript\">
            alert(\"CSV File has been successfully Imported.\");
            window.location = \"index.php\"
          </script>";
        }
		
		}
}
 fclose($file); 

}

$conn->close();
?>