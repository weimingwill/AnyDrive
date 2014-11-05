
<?php 

// Create connection
$con = mysqli_connect('127.0.0.1:3306','root');
// Check connection
if (mysqli_connect_errno()){
  die('Could not connect: ' . mysqli_connect_error());
} 

if(!mysqli_select_db($con, 'AnyDrive')) {
  if (mysqli_query($con, "CREATE DATABASE AnyDrive")){

  } else {
    echo "Error creating database: " . mysqli_error();
  }
}
?>
