<?php 
function redirect($url, $statusCode = 303)
{
 header('Location: ' . $url, true, $statusCode);
 die();
}

?>

<!DOCTYPE html>
<html>

<?php include 'head.php'; ?>
<body>
  <?php include 'navigation.php'; ?>

  <!--register page-->

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
$image_str ='image';
$imagePath_str = 'imagePath';

$email_data = $name_data = $password_data = $confirmPassword_data = $phoneNum_data = $age_data = $gender_data = $image_data = "";
$imagePath_data = "../images/user/default.png";
$isInsert = False;

$Err_Required_Field = 'Required field!';
$email_Err = $name_Err = $password_Err = $confirmPassword_Err = $phoneNum_Err = $age_Err = $gender_Err = $image_Err= "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $isInsert = TRUE;
  if (empty($_POST[$email_str])) {
    $email_Err = $Err_Required_Field;
    $isInsert = False;
  } else if (!filter_var($_POST[$email_str], FILTER_VALIDATE_EMAIL)) {
    $email_Err = "Invalid email format"; 
    $isInsert = False;
  } else {
    $email_data = test_input($_POST[$email_str]);
  }

  if (empty($_POST[$name_str])) {
    $name_Err = $Err_Required_Field;
    $isInsert = False;
  } else {
    $name_data = test_input($_POST[$name_str]);
  }   

  if (empty($_POST[$password_str])) {
    $password_Err = $Err_Required_Field;
    $isInsert = False;
  } else {
    $password_data = test_input($_POST[$password_str]);
  }       

  if (empty($_POST[$confirmPassword_str])) {
    $confirmPassword_Err = $Err_Required_Field;
    $isInsert = False;
  } else {
    $confirmPassword_data = test_input($_POST[$confirmPassword_str]);
  }   

  if( $password_data !== $confirmPassword_data) {    
    $confirmPassword_Err = "two passwords does not match";
    $isInsert = False;
  }     

  if (empty($_POST[$phoneNum_str]) or (is_numeric($_POST[$phoneNum_str]) and is_int(intval($_POST[$phoneNum_str]))))  {
    $phoneNum_data = test_input($_POST[$phoneNum_str]);
  } else {
    $phoneNum_Err = "invalid phoneNum";
    $isInsert = False;
  }

  if (empty($_POST[$age_str]) or (is_numeric($_POST[$age_str]) and is_int(intval($_POST[$age_str])) and intval($_POST[$age_str]) > 0)) {
    $age_data = test_input($_POST[$age_str]);     
  } else {
    $age_Err = "invalid age";
    $isInsert = False;
  }   

  if(empty($_POST[$age_str]) or ($_POST[$gender_str] === "male" or $_POST[$gender_str] === "female")) {

    $gender_data = $_POST[$gender_str];
  } else {
    $gender_Err = "invalid gender";
    $isInsert = False;
  }

  $image_data = $_FILES[$image_str];

  $target_dir = "../images/user/";
  $target_file = $target_dir . basename($_FILES[$image_str]["name"]);
  $uploadOk = 1;
  $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
  $target_file = $target_dir . $email_data ."." .$imageFileType; 
  $imagePath_data = $target_file;
// Check if image file is a actual image or fake image
  if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES[$image_str]["tmp_name"]);
    if($check !== false) {
      $image_Err = "File is an image - " . $check["mime"] . ".";
      $uploadOk = 1;
    } else {
      $image_Err = "File is not an image.";
      $uploadOk = 0;
    }
  }
// Check file size
  if ($_FILES[$image_str]["size"] > 500000) {
    $image_Err = "Sorry, your file is too large.";
    $uploadOk = 0;
  }
// Allow certain file formats
  if($imageFileType != "jpg" && $imageFileType != "JPG" && $imageFileType != "PNG" && $imageFileType != "png" 
    && $imageFileType != "JPEG" && $imageFileType != "jpeg") {
    $image_Err = "Sorry, only JPG, JPEG & PNG   files are allowed.";
  $uploadOk = 0;
  
// Check if $uploadOk is set to 0 by an error
  if ($uploadOk == 0) {
    $isInsert = false;
    $imagePath_data = "../images/user/default.png";
  } 
}

}



$insertUser = "INSERT INTO user (email, name, password, phoneNum, age, gender, imagePath)
VALUES ('$email_data', '$name_data','$password_data', '$phoneNum_data', '$age_data', '$gender_data', '$imagePath_data')";
if($isInsert){

  $sql = "SELECT email  FROM user where email='$email_data'";
  $result = mysqli_query($con, $sql);

  if (mysqli_num_rows($result) > 0) {
    $email_Err = "your email has been registered";
  } else {
    if (move_uploaded_file($_FILES[$image_str]["tmp_name"], $target_file)) {
      $feedback =  "The file ". basename( $_FILES[$image_str]["name"]). " has been uploaded.";
      if ( $con->query($insertUser) === TRUE) {
        echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=home.php'>";
      } else {
        $feedback =  "Error: " . $insertUser . "<br>" . $con->error;
      }
    } else {
      $feedback = "Sorry, there was an error uploading your file.";
 }

  } 
}

function test_input($data) {
 $data = trim($data);
 $data = stripslashes($data);
 $data = htmlspecialchars($data);
 return $data;
}


?>
<br>

<div class="container">
 <div class="page-header" id="banner">
  <h1>Registration<small>&nbsp<?php echo $feedback;?></small></h1>
  <form method="post" enctype="multipart/form-data" action="register.php" class="form-horizontal">
    <br>
    <div class="form-group">
      <label for="email" class="col-lg-2 control-label">Email*</label>
      <div class="col-lg-6">
        <input type="email" name="email" class="form-control" id="email" value="<?php echo $email_data;?>"  placeholder="Email">
      </div>
      <div class = "col-lg-4">
        <span class="text-danger"><?php echo $email_Err;?></span>
      </div>
    </div>

    <div class="form-group">
      <label for="name" class="col-lg-2 control-label">Name*</label>
      <div class="col-lg-6">
        <input type="text" name="name" class="form-control" id="password" value="<?php echo $name_data;?>" placeholder="name">
      </div>
      <div class = "col-lg-4">
        <span class="text-danger"><?php echo $name_Err;?></span>
      </div>
    </div>

    <div class="form-group">
      <label for="password" class="col-lg-2 control-label">Password*</label>
      <div class="col-lg-6">
        <input type="password" name="password" class="form-control" id="password" value="<?php echo $password_data;?>" placeholder="Password">
      </div>
      <div class = "col-lg-4">
        <span class="text-danger"><?php echo $password_Err;?></span>
      </div>
    </div>

    <div class="form-group">
      <label for="confirmPassword" class="col-lg-2 control-label">Confirm Password*</label>
      <div class="col-lg-6">
        <input type="password" name="confirmPassword" class="form-control" id="confirmPassword" value="<?php echo $confirmPassword_data;?>"  placeholder="Confirm Password">
      </div>
      <div class = "col-lg-4">
        <span class="text-danger"><?php echo $confirmPassword_Err;?></span>
      </div>
    </div>



    <div class="form-group">
      <label for="phoneNum" class="col-lg-2 control-label">Phone</label>
      <div class="col-lg-6">
        <input type="text" name="phoneNum" class="form-control" id="phoneNum" value="<?php echo $phoneNum_data;?>" placeholder="Phone Number">
      </div>
      <div class = "col-lg-4">
        <span class="text-danger"><?php echo $phoneNum_Err;?></span>
      </div>
    </div>

    <div class="form-group">
      <label for="age" class="col-lg-2 control-label">Age</label>
      <div class="col-lg-6">
        <input type="number" name="age" class="form-control" id="age" value="<?php echo $age_data;?>"  placeholder="Age">
      </div>
      <div class = "col-lg-4">
        <span class="text-danger"><?php echo $age_Err;?></span>
      </div>
    </div>

    <div class="form-group">
      <label for="gender" class="col-lg-2 control-label">Gender</label>
      <div class="col-lg-6">
        <label class="radio-inline">
          <input class='btn btn-deafult radio-inline'type="radio" name="gender" value="male" 
          <?php 
          if($gender_data == "male") {
            echo "checked";
          }
          ;?>
          > 
          <span>Male</span>
        </label>
        <label class="radio-inline">
          <input class='btn btn-deafult radio-inline'type="radio" name="gender" value="female" 
          <?php 
          if($gender_data == "female") {
            echo "checked";
          }
          ;?>
          > 
          <span>Female</span>
        </label>
      </div>
      <div class = "col-lg-4">
        <span class="text-danger"><?php echo $gender_Err;?></span>
      </div>
    </div>


    <div class="form-group">
      <label for="image" class="col-lg-2 control-label">Image</label>
      <div class="col-lg-6">
        <img id="image" src="<?php echo $imagePath_data;?>">
        <input type="file" size="32" name="image" value="<?php echo $image_data;?>">
      </div>
      <div class = "col-lg-4">
        <span class="text-danger"><?php echo $image_Err;?></span>
      </div>
    </div>     

    <div class="form-group">
      <div class="col-lg-10 col-lg-offset-2">
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
    </div>

  </form>
</div>
</div><!--body part-->

<?php include 'footer.php'; ?>
</body>
</html>