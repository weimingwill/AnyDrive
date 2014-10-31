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
              $cookie_name = "userEmail";
              //set cookie

              function isCookieSet_UserEmail1() {
                return isset($_COOKIE[$cookie_name]);
              }

              function getCookie_UserEmail1(){
                return $_COOKIE[$cookie_name];
              }
              if(isCookieSet_UserEmail1()){
                echo '12';
                echo '<li><a href="#">'. getCookie_UserEmail1() . '</a></li>';
              } else {
                echo  '<li><a href="register.php">Register</a></li>';
              }
            ?>
           
            <li><a href="login.php">Sign in</a></li>
          </ul>
        </div>
      </div>
    </div> <!--nav-->