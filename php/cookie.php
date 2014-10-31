
<?php 

//set cookie
public function setCookie_UserEmail($email)
{
  $cookie_name = "userEmail";
  $cookie_value = $email;
  setcookie(cookie_name, $cookie_value, time() + (86400 * 1), "/");
}

public function isCookieSet_UserEmail() {
  $cookie_name = "userEmail";
  reurn isset($_COOKIE[$cookie_name]);
}

public function getCookie_UserEmail(){}
{
  $cookie_name = "userEmail";
  return $_COOKIE[$cookie_name];
}

?>
