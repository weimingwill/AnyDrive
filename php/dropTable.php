<?php
    $link = mysql_connect('127.0.0.1:3306', 'root');
    if (!$link) {
      die('Database Not connected : ' . mysql_error());
    }

    $db_selected = mysql_select_db('AnyDrive', $link);
    if (!$db_selected) {
      die ('Can\'t use AnyDrive : ' . mysql_error());
    }

    //create table user
    // $sql = "DROP TABLE car;";
    // $retval = mysql_query( $sql, $link );    
    // if(! $retval ) {
    //   die('Could not create table user: ' . mysql_error());
    // } else {
    //     echo "Table user created successfully";     
    // }
     //drop table comment
    $sql = "DROP TABLE comment;";

    $retval = mysql_query( $sql, $link );
    if(! $retval ) {
      die('Could not drop table comment: ' . mysql_error());
    } else {
        echo "<br>Table comment dropped successfully";     
    }
   
    //drop table booking
    $sql = "DROP TABLE booking;";

    $retval = mysql_query( $sql, $link );
    if(! $retval ) {
      die('Could not drop table booking: ' . mysql_error());
    } else {
        echo "<br>Table booking dropped successfully";     
    }

    $sql = "DROP TABLE user;";

    $retval = mysql_query( $sql, $link );
    if(! $retval ) {
      die('Could not drop table user: ' . mysql_error());
    } else {
        echo "<br>Table user dropped successfully";     
    }
    
    //drop table copy
    $sql = "DROP TABLE copy;";
    $retval = mysql_query( $sql, $link );
    if(! $retval ) {
      die('Could not drop table copy: ' . mysql_error());
    } else {
        echo "<br>Table copy dropped successfully";      
    }
    
     //drop table car
    $sql = "DROP TABLE car;";
    $retval = mysql_query( $sql, $link );   

    if(! $retval ) {
      die('Could not drop table car: ' . mysql_error());
    } else {
        echo "<br>Table car dropped successfully";     
    }
      
    
    
    mysql_close($link);
?>
