<?php
$link = mysql_connect('localhost:3306', 'root');
if (!$link) {
  die('Database Not connected : ' . mysql_error());
}

$db_selected = mysql_select_db('AnyDrive', $link);
if (!$db_selected) {
  die ('Can\'t use AnyDrive : ' . mysql_error());
}



$sql = "INSERT INTO car (carID, price, type, passengerCap, brand, gearType)
VALUES ('car1', 100, 'SUV', 4, 'BMW', 'Automatic')";
$retval = mysql_query( $sql, $link );
if(!$retval) {die('Could not insert car value: ' . mysql_error());}

$sql = "INSERT INTO car (carID, price, type, passengerCap, brand, gearType)
VALUES ('car2', '300', 'SUV', '6',  'BMW', 'Automatic')";
$retval = mysql_query( $sql, $link );
if(!$retval) {die('Could not insert car value: ' . mysql_error());}

$sql = "INSERT INTO car (carID, price, type, passengerCap, brand, gearType)
VALUES ('car3', '70', 'Sedan', '4', 'Nissan', 'Automatic')";
$retval = mysql_query( $sql, $link );
if(!$retval) {die('Could not insert car value: ' . mysql_error());}

$sql = "INSERT INTO car (carID, price, type, passengerCap, brand, gearType)
VALUES ('car4', '60', 'SUV', '6',  'Honda', 'Automatic')";
$retval = mysql_query( $sql, $link );
if(!$retval) {die('Could not insert car value: ' . mysql_error());}

$sql = "INSERT INTO car (carID, price, type, passengerCap, brand, gearType)
VALUES ('car5', '30', 'Sports', '6', 'Nissan', 'Automatic')";
$retval = mysql_query( $sql, $link );
if(!$retval) {die('Could not insert car value: ' . mysql_error());}

$sql = "INSERT INTO car (carID, price, type, passengerCap, brand, gearType)
VALUES ('car6', '90', 'SUV', '8',  'BMW', 'Automatic')";
$retval = mysql_query( $sql, $link );
if(!$retval) {die('Could not insert car value: ' . mysql_error());}

$sql = "INSERT INTO car (carID, price, type, passengerCap, brand, gearType)
VALUES ('car7', '300', 'Luxury Sedan', '5',  'BMW', 'Manual')";
$retval = mysql_query( $sql, $link );
if(!$retval) {die('Could not insert car value: ' . mysql_error());}

$sql = "INSERT INTO car (carID, price, type, passengerCap, brand, gearType)
VALUES ('car8', '400', 'Sedan', '4','Honda', 'Manual')";
$retval = mysql_query( $sql, $link );
if(!$retval) {die('Could not insert car value: ' . mysql_error());}

mysql_close($link);
?>