<!DOCTYPE html>
<html>
<?php include 'head.php'; ?>
<body>
<?php include 'navigation.php'; ?>

<!--register page-->

<?php 

// Create connection
$con = mysql_connect('127.0.0.1:3306','root', 'zhang123');
echo "<br><br><br><br>"; 

// Check connection
if (!$con){
  die('Could not connect: ' . mysql_error());
} else {
  echo 'database connected' . mysql_error();
}

if(!mysql_select_db('AnyDrive', $con)) {
  if (mysql_query("CREATE DATABASE AnyDrive",$con)){
    echo "Database created";
  } else {
  echo "Error creating database: " . mysql_error();
  }
}
$create_user = 
"CREATE TABLE IF NOT EXISTS user (
  userID VARCHAR(64) PRIMARY KEY,
  name VARCHAR(64) NOT NULL,
  password VARCHAR(20) NOT NULL,
  email VARCHAR(50) NOT NULL UNIQUE,
  phoneNum CHAR(8),
  age INT CHECK(age>0),
  gender VARCHAR(6) CHECK(gender='male' OR gender='female'),
)";

mysql_query($create_user, $con);

//mysql_close($con);
// set err varible name
$Err_Required_Field = "required field";
$userID_Err = $name_Err = $password_Err = $confirmPassword_Err = $email_Err = $phoneNum_Err = $age_Err = $gender_Err = "" ;
$userID = $name = $password = $confirmPassword = $email = $phoneNum  = $age = $gender = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["userID"])) {
      $User_Id_Err = $Err_Required_Field;
    } else {
      $userID = test_input($_POST["userID"]);
    }
    if (empty($_POST["name"])) {
      $name_Err = $Err_Required_Field;
    } else {
      $name = test_input($_POST["name"]);
    }   
    if (empty($_POST["password"])) {
      $password_Err = $Err_Required_Field;
    } else {
      $password = test_input($_POST["password"]);
    }        
    if (empty($_POST["confirmPassword"])) {
      $confirmPassword_Err = $Err_Required_Field;
    } else {
      $confirmPassword = test_input($_POST["confirmPassword"]);
    }   
    if( $password !== $confirmPassword) {    
     $confirmPassword_Err = "two passwords does not match";
    }   

    $email = test_input($_POST["email"]);     

    if (empty($_POST["phoneNum"]) or (is_numeric($_POST["phoneNum"]) and is_int(intval($_POST["phoneNum"]))))  {
      $phoneNum = intval(test_input($_POST["phoneNum"]));
    } else {
      $phoneNum_Err = "invalid phoneNum";
    }

    if (empty($_POST["age"]) or (is_numeric($_POST["age"]) and is_int(intval($_POST["age"])) and intval($_POST["age"]) > 0)) {
      $age = test_input($_POST["age"]);     
    } else {
      $age_Err = "invalid age";
    }   

    if($_POST["gender"] !== "male" and $_POST["gender"] !== "female") {
      $gender_Err = "invalid gender";
    } else {
      $gender = $_POST["gender"];
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
            <label for="userID" class="col-lg-2 control-label">User Id*</label>
              <div class="col-lg-6">
                <input type="text" name="userID" class="form-control" id="userID" value = "<?php echo $userID;?>" placeholder="User ID">
              </div>
              <div class = "col-lg-4">
                <span class="text-danger"><?php echo $User_Id_Err;?></span>
              </div>
          </div>

          <div class="form-group">
            <label for="name" class="col-lg-2 control-label">Name*</label>
            <div class="col-lg-6">
              <input type="text" name="name" class="form-control" id="password" value="<?php echo $name;?>" placeholder="name">
            </div>
            <div class = "col-lg-4">
                <span class="text-danger"><?php echo $name_Err;?></span>
            </div>
          </div>

          <div class="form-group">
            <label for="password" class="col-lg-2 control-label">Password*</label>
            <div class="col-lg-6">
              <input type="password" name="password" class="form-control" id="password" value="<?php echo $password;?>" placeholder="Password">
            </div>
            <div class = "col-lg-4">
                <span class="text-danger"><?php echo $password_Err;?></span>
            </div>
          </div>

          <div class="form-group">
            <label for="confirmPassword" class="col-lg-2 control-label">Confirm Password*</label>
            <div class="col-lg-6">
              <input type="password" name="confirmPassword" class="form-control" id="confirmPassword" value="<?php echo $confirmPassword;?>"  placeholder="Confirm Password">
            </div>
            <div class = "col-lg-4">
                <span class="text-danger"><?php echo $confirmPassword_Err;?></span>
            </div>
          </div>

          <div class="form-group">
            <label for="email" class="col-lg-2 control-label">Email</label>
            <div class="col-lg-6">
              <input type="email" name="email" class="form-control" id="email" value="<?php echo $email;?>"  placeholder="Email">
            </div>
            <div class = "col-lg-4">
                <span class="text-danger"><?php echo $email_Err;?></span>
            </div>
          </div>

          <div class="form-group">
            <label for="phoneNum" class="col-lg-2 control-label">Phone</label>
            <div class="col-lg-6">
              <input type="nutmber" name="phoneNum" class="form-control" id="phoneNum" value="<?php echo $phoneNum;?>" placeholder="Phone Number">
            </div>
            <div class = "col-lg-4">
                <span class="text-danger"><?php echo $phoneNum_Err;?></span>
            </div>
          </div>

          <div class="form-group">
            <label for="age" class="col-lg-2 control-label">Age</label>
            <div class="col-lg-6">
              <input type="number" name="age" class="form-control" id="age" value="<?php echo $age;?>"  placeholder="Age">
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
                    if($gender == "male") {
                      echo "checked";
                    }
                   ;?>
                > 
                <span>Male</span>
              </label>
              <label class="radio-inline">
                <input class='btn btn-deafult radio-inline'type="radio" name="gender" value="female" 
                <?php 
                    if($gender == "female") {
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