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
    $sql = "CREATE TABLE IF NOT EXISTS user (
            email VARCHAR(50) NOT NULL PRIMARY KEY,
            name VARCHAR(64) NOT NULL,
            password VARCHAR(20) NOT NULL,
            phoneNum CHAR(8),
            age INT CHECK(age>0),
            gender VARCHAR(6) CHECK(gender='male' OR gender='female')
            )";
    $retval = mysql_query( $sql, $link );    
    if(! $retval ) {
      die('Could not create table user: ' . mysql_error());
    } else {
        echo "Table user created successfully";     
    }
    //create table car
    $sql = "CREATE TABLE IF NOT EXISTS car (
            carID CHAR(10) PRIMARY KEY,
            price INT NOT NULL CHECK(price>0),
            type VARCHAR(32) NOT NULL,
            passengerCap INT NOT NULL,
            brand VARCHAR(64) NOT NULL,
            gearType VARCHAR(32) NOT NULL
            )";

    $retval = mysql_query( $sql, $link );
    if(! $retval ) {
      die('Could not create table car: ' . mysql_error());
    } else {
        echo "Table car created successfully";     
    }
      

    //create table copy
    $sql = "CREATE TABLE IF NOT EXISTS copy (
            copyNum INT CHECK(copyNum > 0),
            carID CHAR(10) REFERENCES car(carID) ON DELETE CASCADE,
            available BIT(1) DEFAULT b'1',
            startDateOfService Date, 
            PRIMARY KEY(carID, copyNum)
            )";
    $retval = mysql_query( $sql, $link );
    if(! $retval ) {
      die('Could not create table copy: ' . mysql_error());
    } else {
        echo "Table copy created successfully";      
    }
    

    //create table booking
    $sql = "CREATE TABLE IF NOT EXISTS booking (
            userID VARCHAR(15) REFERENCES user(userID) ON DELETE CASCADE,
            copyNum INT CHECK(copyNum > 0), 
            carID CHAR(10) REFERENCES car(carID) ON DELETE CASCADE,
            bookingTime DATETIME NOT NULL ,
            rentDate DATE NOT NULL,
            returnDate DATE NOT NULL, 
            cost INT CHECK(price >= 0),
            CHECK(returnDATE > rentDATE),
            PRIMARY KEY(bookingTime,  userID, copyNum, carID)
            )";

    $retval = mysql_query( $sql, $link );
    if(! $retval ) {
      die('Could not create table booking: ' . mysql_error());
    } else {
        echo "Table booking created successfully";     
    }
    
    mysql_close($link);
?>