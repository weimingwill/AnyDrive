    <div class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <a href="home.php" class="navbar-brand">AnyDrive</a>
          <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#navbar-main">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
        </div>
        <div class="navbar-collapse collapse" id="navbar-main">
          <ul class="nav navbar-nav">
            <li>
              <a href="home.php">Home</a>
            </li>
            <li>
              <a href="carlist.php">Browse</a>
            </li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <?php 
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
            $cookie_name = "userEmail";
            $constant_adminEmail = "admin@anydrive.com";

              // admin page 
            if(isset($_COOKIE[$cookie_name])){

              $sql = $carQuery = "SELECT name, imagePath FROM user WHERE email = '$_COOKIE[$cookie_name]'";
              $Result = mysqli_query($con, $sql);
              $row = mysqli_fetch_assoc($Result);

              $userImagePath_data = $row["imagePath"];

              if($_COOKIE[$cookie_name] === $constant_adminEmail) {
               echo '<li><a href="admin.php">'. 'Admin Page' . '</a></li>';
             } else {
                echo '<li><a href="user_booking.php">'. 'My Bookings' . '</a></li>';
             }
             echo "<li><image id= 'thumbnail' src='$userImagePath_data'></li>";
             echo '<li><a href="logout.php">Logout</a></li>';
           } else {
            echo  '<li><a href="register.php">Register</a></li>';
            echo '<li><a href="login.php">Sign in</a></li>';
          }

          ?>


        </ul>
      </div>
    </div>
  </div> <!--nav-->


