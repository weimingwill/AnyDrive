
<?php 

//set cookie
 function setCookie_UserEmail($email)
{
  $cookie_name = "userEmail";
  $cookie_value = $email;
  setcookie($cookie_name, $cookie_value, time() + (86400 * 1), "/");
}

 function isCookieSet_UserEmail() {
  $cookie_name = "userEmail";
  return isset($_COOKIE[$cookie_name]);
}

 function getCookie_UserEmail(){}
{
  $cookie_name = "userEmail";
  return $_COOKIE[$cookie_name];
}
?>
