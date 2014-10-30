<!DOCTYPE html>
<html>
<?php include 'head.php'; ?>
<body>
<?php include 'navigation.php'; ?>

<!--register page-->

<?php require('user_mysql.php');


$isInsert = TRUE;

$Err_Required_Field = 'Required field!';
$email_Err = $name_Err = $password_Err = $confirmPassword_Err = $phoneNum_Err = $age_Err = $gender_Err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
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
      $phoneNum_data = intval(test_input($_POST[$phoneNum_str]));
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

    if($_POST[$gender_str] !== "male" and $_POST[$gender_str] !== "female") {
      $gender_Err = "invalid gender";
      $isInsert = False;
    } else {
      $gender_data = $_POST[$gender_str];
    }

}

$insertUser = "INSERT INTO user (email, name, password, phoneNum, age, gender)
      VALUES ('$email_data', '$name_data','$password_data', '$phoneNum_data', '$age_data', '$gender_data')";
if($isInsert){

  $sql = "SELECT email  FROM user where email='$email_data'";
  $result = mysqli_query($con, $sql);

  if (mysqli_num_rows($result) > 0) {
    $email_Err = "your email has been registered";
  } else {
    if ( $con->query($insertUser) === TRUE) {
      echo "New record created successfully";
    } else {
      echo "Error: " . $insertUser . "<br>" . $con->error;
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
    <div class="container">
     <div class="page-header" id="banner">
     	<h1>Registration</h1>
        <form method="post" class="form-horizontal">
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
              <input type="nutmber" name="phoneNum" class="form-control" id="phoneNum" value="<?php echo $phoneNum_data;?>" placeholder="Phone Number">
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