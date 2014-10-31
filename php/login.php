<!DOCTYPE html>
<!-- saved from url=(0029)http://bootswatch.com/united/ -->
<html lang="en">
<?php include 'head.php'; ?>
<body>
  <?php include 'navigation.php'; ?>


  <!--search form in homepage-->
  <div class="container">
   <div class="page page-container">

    <?php
    //connect to database
    $link = mysql_connect('127.0.0.1:3306', 'root');
    if (!$link) {
      die('Database Not connected : ' . mysql_error());
    }
    //select database
    $db_selected = mysql_select_db('AnyDrive', $link);
    if (!$db_selected) {
      die ('Can\'t use foo : ' . mysql_error());
    }
    //create table user
/*    $sql = "CREATE TABLE IF NOT EXISTS user (
            userID VARCHAR(64) PRIMARY KEY,
            name VARCHAR(64) NOT NULL,
            password VARCHAR(20) NOT NULL,
            email VARCHAR(50) NOT NULL UNIQUE,
            phoneNum CHAR(8),
            age INT CHECK(age>0),
            gender VARCHAR(6) CHECK(gender='male' OR gender='female'),
            birthday DATE,
            drivingLicenseNum CHAR(9)
            )";
    $retval = mysql_query( $sql, $link );
    if(! $retval )
    {
      die('Could not create table: ' . mysql_error());
    }

    //insert value into table user 
    $sql = "INSERT INTO user (userID, name, password, email, phoneNum, age, gender, birthday, drivingLicenseNum)
    VALUES ('2', 'ZhangJi', '2', 'zhangji@gmail.com', '85518503', '20', 'male', '1994-01-31', 'A0119405')";

    $retval = mysql_query( $sql, $link );*/

    //get input from form
    $email = $password = $emailErr = $emailErrClass = $passwordErr = $passwordErrClass = "";
    $login = false;
    $empty = false;
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      if(empty($_POST["email"])){
        $emailErr = "Email is required!";
        $emailErrClass = "has-error";
        $empty = true;
      } else {
        $email = test_input($_POST["email"]);
      }

      if(empty($_POST["password"])){
        $passwordErr = "Password cannot be empty!";
        $passwordErrClass = "has-error";
        $empty = true;
      } else {
        $password = test_input($_POST["password"]);
      }       
    }

    function test_input($data) {
       $data = trim($data);
       $data = stripslashes($data);
       $data = htmlspecialchars($data);
       return $data;
     }

    if(!$empty){
      //get data from database 
      $sql = "SELECT * FROM user";
      $result = mysql_query($sql, $link);

      while($row = mysql_fetch_assoc($result)){
        if($row["email"] == $email && $row["email"]!=null){
          if($row["password"] != $password){
            $emailErr = $emailErrClass = "";
            $passwordErr = "Password is wrong! Please try again";
            $passwordErrClass = "has-error";
            break;            
          } else {
            echo "Login successfully";
            $login = true;
            $passwordErr = $passwordErrClass = "";
            break;
          }
        } else {
          $emailErr = "Account does not exist!";
          $emailErrClass = "has-error";
        }
      }

      //redirect to home page if login successfully
      if($login){
        ?>
        <form method="post" action="home.php" id="emailForm"><input type="hidden" name="email" value="<?php echo $email ?>"></form>
        <script>
          document.getElementById('emailForm').submit(); // SUBMIT FORM
        </script>        
        <?php
      }
  }
        ?>


     <form method="post" class="form-horizontal" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
      <br>
      <div class="form-group <?php echo $emailErrClass ?>">
        <label for="email" class="col-lg-2 control-label">Email: </label>
        <div class="col-lg-6">
          <input type="text" name="email" class="form-control" id="email" placeholder="">
          <p><?php echo $emailErr ?></p>
        </div>
      </div>
      

      <div class="form-group <?php echo $passwordErrClass ?>">
        <label for="password" class="col-lg-2 control-label">Password: </label>
        <div class="col-lg-6">
          <input type="password" name="password" class="form-control" id="password" placeholder="">
          <p><?php echo $passwordErr ?></p>
        </div>
      </div>

      <div class="form-group">
        <div class="col-lg-10 col-lg-offset-2">
          <button type="submit" class="btn btn-primary">Login</button>
          <input type="hidden" value="">
        </div>
      </div>

    </form>

  </div>
</div><!--body part-->

<?php mysql_close($link); ?>

<?php include 'footer.php'; ?>  
</body>
</html>

