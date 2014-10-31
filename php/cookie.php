
<?php 

$cookie_name = "userEmail";
//set cookie
 function setCookie_UserEmail($email)
{
  $cookie_value = $email;
  setcookie($cookie_name, $cookie_value, time() + (86400 * 1), "/");
}

 function isCookieSet_UserEmail() {
  return isset($_COOKIE[$cookie_name]);
}

 function getCookie_UserEmail(){}
{
  return $_COOKIE[$cookie_name];
}

?>
