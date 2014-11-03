

<?php
$link = mysql_connect('localhost:3306', 'root');
if (!$link) {
  die('Database Not connected : ' . mysql_error());
}

$db_selected = mysql_select_db('AnyDrive', $link);
if (!$db_selected) {
  die ('Can\'t use AnyDrive : ' . mysql_error());
}

$sql = "INSERT INTO user (userID, email, name, password, phoneNum, age, gender)
      VALUES ('1', 'wingalong@gmail.com', 'Zhuang Weiming', '1', '85518503', '20', 'male')";
$retval = mysql_query( $sql, $link );
if(!$retval) {die('Could not insert user1 value: ' . mysql_error());}

$sql = "INSERT INTO user (userID, email, name, password, phoneNum, age, gender)
      VALUES ('2' ,'zhangji@gmail.com', 'Zhang Ji', '2', '85518506', '18', 'male')";
$retval = mysql_query( $sql, $link );
if(!$retval) {die('Could not insert user2 value: ' . mysql_error());}

$sql = "INSERT INTO user (userID, email, name, password, phoneNum, age, gender)
      VALUES ('3' ,'liangchao@gmail.com', 'Liang Chao', '3', '85518790', '19', 'male')";
$retval = mysql_query( $sql, $link );
if(!$retval) {die('Could not insert user3 value: ' . mysql_error());}


mysql_close($link);
?>