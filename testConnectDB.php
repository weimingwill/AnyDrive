<?php
// Create connection
$con = mysqli_connect("localhost:3306","root");

// Check connection
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
} else {
	echo "connection to MySQL done fuck you";
}

// close connection
mysqli_close($con);
?>