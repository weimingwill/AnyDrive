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

      function test_input($data) {
         $data = trim($data);
         $data = stripslashes($data);
         $data = htmlspecialchars($data);
         return $data;
      }  

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

    if(!$empty){
      require('user_mysql.php');
      require('cookie.php');
      if(checkUserEmail($email)){
        if(checkUserPassword($email, $password)){
          $emailErr = $emailErrClass = "";
          $passwordErr = "Password is wrong! Please try again";
          $passwordErrClass = "has-error";          
        } else {
          echo "Login successfully";
          $login = true;
          $passwordErr = $passwordErrClass = "";
          setCookie_UserEmail($email);
        }
      } else {
        $emailErr = "Account does not exist!";
        $emailErrClass = "has-error";        
      }
      


      //redirect to home page if login successfully
      if($login){
        echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=home.php'>";
        ?>
        <form method="post" action="home.php" id="emailForm"><input type="hidden" name="email" value="<?php echo $email ?>"></form>
        <script>
          document.getElementById('emailForm').submit(); // SUBMIT FORM
        </script>

        <?php
      }    
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
<?php include 'footer.php'; ?>  
</body>
</html>

