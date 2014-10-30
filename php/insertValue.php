<?php
    $link = mysql_connect('localhost:3306', 'root');
    if (!$link) {
      die('Database Not connected : ' . mysql_error());
    }

    $db_selected = mysql_select_db('AnyDrive', $link);
    if (!$db_selected) {
      die ('Can\'t use AnyDrive : ' . mysql_error());
    }

    //insert value into table user 
    $sql = "INSERT INTO user (carID, price, passengerCap, brand)
    VALUES ('2', 'ZhangJi', '2', 'zhangji@gmail.com', '85518503')";

    $retval = mysql_query( $sql, $link );

?>