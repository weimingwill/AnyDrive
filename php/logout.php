<?php 
  require('cookie.php');
  unset($_COOKIE[$cookie_userEmailStr]);

  if(setcookie($cookie_userEmailStr, '', time() - 3600, "/")){
    echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=home.php'>";
  }

?>

