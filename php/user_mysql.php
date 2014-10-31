
<?php 

// Create connection
$con = mysqli_connect('127.0.0.1:3306','root');
 
 echo "<br><br><br>";
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
$create_user = 
"CREATE TABLE IF NOT EXISTS user (
  email VARCHAR(50) NOT NULL PRIMARY KEY,
  name VARCHAR(64) NOT NULL,
  password VARCHAR(20) NOT NULL,
  phoneNum CHAR(8),
  age INT CHECK(age>0),
  gender VARCHAR(6) CHECK(gender='male' OR gender='female')
)";

if(!mysqli_query($con, $create_user)){
   echo "Error creating database: " . $con->error;
}

// set deafult varible name
$email_str = "email";
$name_str = "name"; 
$password_str = "password";
$confirmPassword_str = "confirmPassword";
$phoneNum_str =  "phoneNum";
$age_str = "age";
$gender_str = "gender";

$email_data = $name_data = $password_data = $confirmPassword_data = $phoneNum_data = $age_data = $gender_data = "";

$user_array = array(
  $email_str => $email_data,
  $name_str => $name_data,
  $password_str => $password_data,
  $confirmPassword_str => $password_data,
  $phoneNum_str => $phoneNum_data,
  $age_str => $age_data,
  $gender_str => $gender_data,
);

?>
