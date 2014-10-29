<?php
    $link = mysql_connect('localhost:3306', 'root');
    if (!$link) {
      die('Database Not connected : ' . mysql_error());
    }

    $db_selected = mysql_select_db('AnyDrive', $link);
    if (!$db_selected) {
      die ('Can\'t use foo : ' . mysql_error());
    }

    $sql = "CREATE TABLE IF NOT EXISTS user (
            userID VARCHAR(64) PRIMARY KEY,
            password VARCHAR(20) NOT NULL,
            email VARCHAR(50) NOT NULL UNIQUE,
            phoneNum CHAR(8),
            age INT CHECK(age>0),
            gender VARCHAR(6) CHECK(gender='male' OR gender='female'),
            birthday DATE,
            drivingLicenseNum CHAR(9)
            )";

    $retval = mysql_query( $sql, $link );
    if(! $retval )
    {
      die('Could not create table: ' . mysql_error());
    }
    echo "Table user created successfully";	
?>