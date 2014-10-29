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


    $link = mysql_connect('localhost:3306', 'root');
    if (!$link) {
      die('Database Not connected : ' . mysql_error());
    }

    $db_selected = mysql_select_db('AnyDrive', $link);
    if (!$db_selected) {
      die ('Can\'t use foo : ' . mysql_error());
    }

    $sql = "CREATE TABLE IF NOT EXISTS user (
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
    echo "Table created successfully<br>";

    $sql = "INSERT INTO user (userID, name, password, email, phoneNum, age, gender, birthday, drivingLicenseNum)
    VALUES ('2', 'ZhangJi', '2', 'zhangji@gmail.com', '85518503', '20', 'male', '1994-01-31', 'A0119405')";

    $retval = mysql_query( $sql, $link );

    $email = $password = $emailErr = $emailErrClass = $passwordErr = $passwordErrClass = "";
    $login = false;
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      if(empty($_POST["email"])){
        $emailErr = "Email is required!";
        $emailErrClass = "has-error";
      } else {
        $email = test_input($_POST["email"]);
      }

      if(empty($_POST["email"])){
        $passwordErr = "Password cannot be empty!";
        $passwordErrClass = "has-error";
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

    $sql = "SELECT * FROM user";
    $result = mysql_query($sql, $link);

    while($row = mysql_fetch_assoc($result)) 
    {
      echo $row["userID"];
      echo $row["name"];
      echo $row["password"];
      echo $row["email"];
      echo "<br>";
      if($row["email"]  == $email && $row["password"] == $password){
        echo "Login successfully";
        $login = true;
      }
    }

    header("Location: http://http://localhost/AnyDrive/php/home.php");

    // if ($result->num_rows > 0) {
    //      // output data of each row
    //      while($row = $result->fetch_assoc()) {
    //          echo "<br> id: ". $row["id"]. " - Name: ". $row["firstname"]. " " . $row["lastname"] . "<br>";
    //      }
    // } else {
    //      echo "0 results";
    // }

/*    $data = mysql_query($sql, $link);
    if (count($data) > 0) {
      for($row = 0; $row < count($data); $row++){
        $data[$row]
      }
    }*/



    // define variables and set to empty values



?>     
<?php echo $emailErrClass ?>
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
        </div>
      </div>

      <div class="form-group">
        <div class="col-lg-10 col-lg-offset-2">
          <button type="submit" class="btn btn-primary">Login</button>
        </div>
      </div>

    </form>
  </div>
</div><!--body part-->
<?php mysql_close($link); ?>

<?php include 'footer.php'; ?>  
</body>
</html>