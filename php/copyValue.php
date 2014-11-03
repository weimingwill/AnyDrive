<?php
$link = mysql_connect('localhost:3306', 'root');
if (!$link) {
  die('Database Not connected : ' . mysql_error());
}

$db_selected = mysql_select_db('AnyDrive', $link);
if (!$db_selected) {
  die ('Can\'t use AnyDrive : ' . mysql_error());
}

$sql = "INSERT INTO copy (copyNum, carID, available, startDateOfService)
VALUES ('1', 'car1', '1', '2013-03-15')";
$retval = mysql_query( $sql, $link );
if(!$retval) {die('Could not insert car value: ' . mysql_error());}

$sql = "INSERT INTO copy (copyNum, carID, available, startDateOfService)
VALUES ('2', 'car1', '1', '2013-05-15')";
$retval = mysql_query( $sql, $link );
if(!$retval) {die('Could not insert car value: ' . mysql_error());}

$sql = "INSERT INTO copy (copyNum, carID, available, startDateOfService)
VALUES ('1', 'car2', '1', '2013-03-16')";
$retval = mysql_query( $sql, $link );
if(!$retval) {die('Could not insert car value: ' . mysql_error());}

$sql = "INSERT INTO copy (copyNum, carID, available, startDateOfService)
VALUES ('2', 'car2', '1', '2014-03-15')";
$retval = mysql_query( $sql, $link );
if(!$retval) {die('Could not insert car value: ' . mysql_error());}

$sql = "INSERT INTO copy (copyNum, carID, available, startDateOfService)
VALUES ('1', 'car3', '1', '2013-09-15')";
$retval = mysql_query( $sql, $link );
if(!$retval) {die('Could not insert car value: ' . mysql_error());}

$sql = "INSERT INTO copy (copyNum, carID, available, startDateOfService)
VALUES ('1', 'car4', '1', '2014-05-15')";
$retval = mysql_query( $sql, $link );
if(!$retval) {die('Could not insert car value: ' . mysql_error());}

$sql = "INSERT INTO copy (copyNum, carID, available, startDateOfService)
VALUES ('1', 'car5', '1', '2014-08-15')";
$retval = mysql_query( $sql, $link );
if(!$retval) {die('Could not insert car value: ' . mysql_error());}

$sql = "INSERT INTO copy (copyNum, carID, available, startDateOfService)
VALUES ('1', 'car6', '1', '2014-06-15')";
$retval = mysql_query( $sql, $link );
if(!$retval) {die('Could not insert car value: ' . mysql_error());}

$sql = "INSERT INTO copy (copyNum, carID, available, startDateOfService)
VALUES ('1', 'car7', '1', '2014-08-13')";
$retval = mysql_query( $sql, $link );
if(!$retval) {die('Could not insert car value: ' . mysql_error());}

mysql_close($link);
?>