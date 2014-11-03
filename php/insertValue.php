<?php
$link = mysql_connect('localhost:3306', 'root');
if (!$link) {
  die('Database Not connected : ' . mysql_error());
}

$db_selected = mysql_select_db('AnyDrive', $link);
if (!$db_selected) {
  die ('Can\'t use AnyDrive : ' . mysql_error());
}

$sql = "INSERT INTO car (carID, price, passengerCap, brand)
VALUES ('A1', 100, 4, 'BMW')";
$retval = mysql_query( $sql, $link );

    if(! $retval ) {
      die('Could not insert car value: ' . mysql_error());
    } else {
        echo "Insert car successfully";     
    }

$sql = "INSERT INTO car (carID, price, passengerCap, brand)
VALUES ('A2', '200', '4', 'BMW')";
$retval = mysql_query( $sql, $link );

    if(! $retval ) {
      die('Could not insert car value: ' . mysql_error());
    } else {
        echo "Insert car successfully";     
    }


// $date=date("Y-m-d",mktime(0,0,0,12,36,2001));
// $date=date_create("2013-03-15");
    //insert value into copy 
$sql = "INSERT INTO copy (copyNum, carID, available, startDateOfService)
VALUES ('1', 'A1', '1', '2013-03-15')";
$retval = mysql_query( $sql, $link );

    if(! $retval ) {
      die('Could not insert copy value: ' . mysql_error());
    } else {
        echo "Insert copy successfully";     
    }


$sql = "INSERT INTO copy (copyNum, carID, available, startDateOfService)
VALUES ('2', 'A1', '1', '2013-05-16')";
$retval = mysql_query( $sql, $link );
    if(! $retval ) {
      die('Could not insert copy value: ' . mysql_error());
    } else {
        echo "Insert copy successfully";     
    }

$sql = "INSERT INTO copy (copyNum, carID, available, startDateOfService)
VALUES ('1', 'A2', '1', '2013-07-19')";
$retval = mysql_query( $sql, $link );
    if(! $retval ) {
      die('Could not insert copy value: ' . mysql_error());
    } else {
        echo "Insert copy successfully";     
    }


$sql = "INSERT INTO copy (copyNum, carID, available, startDateOfService)
VALUES ('2', 'A2', '1', '2013-09-19')";

$retval = mysql_query( $sql, $link );
    if(! $retval ) {
      die('Could not insert copy value: ' . mysql_error());
    } else {
        echo "Insert copy successfully";     
    }

    //insert value into booking 
$sql = "INSERT INTO booking (userID, copyNum, carID, bookingTime, rentDATE, returnDATE, cost)
VALUES ('1', '1', 'A1', '2014-10-20 10:20:55am', '2014-10-20', '2014-10-24', '200')";
$retval = mysql_query( $sql, $link );
    if(! $retval ) {
      die('Could not insert booking value: ' . mysql_error());
    } else {
        echo "Insert booking successfully";     
    }
$sql = "INSERT INTO booking (userID, copyNum, carID, bookingTime, rentDATE, returnDATE, cost)
VALUES ('1', '2', 'A1', '2014-10-21 10:20:55am', '2014-10-21', '2014-10-26', '300')";
$retval = mysql_query( $sql, $link );
    if(! $retval ) {
      die('Could not insert booking value: ' . mysql_error());
    } else {
        echo "Insert booking successfully";     
    }
$sql = "INSERT INTO booking (userID, copyNum, carID, bookingTime, rentDATE, returnDATE, cost)
VALUES ('1', '1', 'A2', '2014-10-24 10:20:55am', '2014-10-25', '2014-10-27', '200')";
$retval = mysql_query( $sql, $link );
    if(! $retval ) {
      die('Could not insert booking value: ' . mysql_error());
    } else {
        echo "Insert booking successfully";     
    }
$sql = "INSERT INTO booking (userID, copyNum, carID, bookingTime, rentDATE, returnDATE, cost)
VALUES ('1', '2', 'A2', '2014-10-26 10:20:55am', '2014-10-27', '2014-10-29', '200')";

$retval = mysql_query( $sql, $link );
    if(! $retval ) {
      die('Could not insert booking value: ' . mysql_error());
    } else {
        echo "Insert booking successfully";     
    }

mysql_close($link);
?>