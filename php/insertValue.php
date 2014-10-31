<?php
$link = mysql_connect('localhost:3306', 'root');
if (!$link) {
  die('Database Not connected : ' . mysql_error());
}

$db_selected = mysql_select_db('AnyDrive', $link);
if (!$db_selected) {
  die ('Can\'t use AnyDrive : ' . mysql_error());
}

/*    //insert value into user
$sql = "INSERT INTO user (carID, price, passengerCap, brand)
VALUES ('2', 'ZhangJi', '2', 'zhangji@gmail.com', '85518503')";

$retval = mysql_query( $sql, $link );

    if(! $retval ) {
      die('Could not insert user value: ' . mysql_error());
    } else {
        echo "Insert user successfully";     
    }*/

    //insert value into table car 
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



$d=mktime(11, 11, 11, 1, 12, 2014);
$date = date("Y-m-d", $d);
    //insert value into copy 
$sql = "INSERT INTO copy (copyNum, carID, avaliable, startDateOfService)
VALUES ('1', 'A1', '1', $date)";
$retval = mysql_query( $sql, $link );

    if(! $retval ) {
      die('Could not insert copy value: ' . mysql_error());
    } else {
        echo "Insert copy successfully";     
    }


$date = date("Y-m-d", mktime(11, 11, 11,  3, 11, 2014));
$sql = "INSERT INTO copy (copyNum, carID, avaliable, startDateOfService)
VALUES ('2', 'A1', '1', $date)";
$retval = mysql_query( $sql, $link );
    if(! $retval ) {
      die('Could not insert copy value: ' . mysql_error());
    } else {
        echo "Insert copy successfully";     
    }

    $d=mktime(11, 11, 11, 4, 10, 2014);
    $date = date("Y-m-d", $d);
$sql = "INSERT INTO copy (copyNum, carID, avaliable, startDateOfService)
VALUES ('1', 'A2', '1', $date)";
$retval = mysql_query( $sql, $link );
    if(! $retval ) {
      die('Could not insert copy value: ' . mysql_error());
    } else {
        echo "Insert copy successfully";     
    }

    $d=mktime(11, 11, 11,  8, 12, 2014);
$date = date("Y-m-d", $d);
$sql = "INSERT INTO copy (copyNum, carID, avaliable, startDateOfService)
VALUES ('2', 'A2', '1', $date)";

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