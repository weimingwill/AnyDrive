<?php 
  require('cookie.php');
      function test_input($data) {
         $data = trim($data);
         $data = stripslashes($data);
         $data = htmlspecialchars($data);
         return $data;
      } 
    $email = $passwordErr = $emailErr = $emailErrClass = $passwordErr = $passwordErrClass = "";

    $isLogin = false;
    $isTryLogin = false;


    if(isset($_COOKIE[$cookie_userEmailStr])) {
      $isLogin = True;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $isTryLogin = True;
      if(empty($_POST["email"])){
        $isTryLogin = false;
        $emailErr = "Email is required!";
        $emailErrClass = "has-error";
        
      } else {
        $email = test_input($_POST["email"]);
      }

      if(empty($_POST["password"])){
        $isTryLogin = false;
        $passwordErr = "Password cannot be empty!";
        $passwordErrClass = "has-error";
        
      } else {
        $password = test_input($_POST["password"]);

      }
    }  

    if($isTryLogin){
      $isLogin = false;
      require('user_mysql.php');
     
      $selectEmail = "SELECT email FROM user where email='$email'";
      $result = mysqli_query($con, $selectEmail);

      if(mysqli_num_rows($result) > 0){ //user email exists
        $selectPassword = "SELECT email  FROM user where email='$email' AND password='$password'";
        $result = mysqli_query($con, $selectPassword);
      
        if(mysqli_num_rows($result) > 0){
          if(setcookie($cookie_userEmailStr, $email, time() + (86400 * 1), "/")){

            $isLogin = True;  
          } 
          
        } else {
          $passwordErr = "Password is wrong! Please try again";
          $passwordErrClass = "has-error"; 
          unset($_COOKIE[$cookie_userEmailStr]);
          $res = setcookie($cookie_userEmailStr, '', time() - 3600);

        }
      } else {
        $emailErr = "Account does not exist!";
        $emailErrClass = "has-error";  
        unset($_COOKIE[$cookie_userEmailStr]);
        $res = setcookie($cookie_userEmailStr, '', time() - 3600);    
      }
      
    }
    if($isLogin){
      //redirect to home page if login successfully
      echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=home.php'>";
    }

?>
<!DOCTYPE html>

<html lang="en">

<?php include 'head.php'; ?>

<?php include 'navigation.php'; ?>
<body>

  <!--search form in homepage-->
  <div class="container">
   <div class="page page-container">

     <form method="post" class="form-horizontal" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
      <br>
      <div class="form-group <?php echo $emailErrClass ?>">
        <label for="email" class="col-lg-2 control-label">Email: </label>
        <div class="col-lg-6">
          <input type="text" name="email" class="form-control" id="email" placeholder="" value="<?php echo $email ?>">
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

</body>
<?php include 'footer.php'; ?>  
</html>