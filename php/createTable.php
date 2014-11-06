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
            gender VARCHAR(6) CHECK(gender='male' OR gender='female'),
            imagePath VARCHAR(64)
            )";
    $retval = mysql_query( $sql, $link );    
    if(! $retval ) {
      die('Could not create table user: ' . mysql_error());
    } else {
        echo "<br>";
        echo "Table user created successfully";     
    }
    //create table car
    $sql = "CREATE TABLE IF NOT EXISTS car (
            carID VARCHAR(10) PRIMARY KEY,
            type  VARCHAR(32) NOT NULL,
            model VARCHAR(32) NOT NULL,
            price INT NOT NULL CHECK(price>0),
            passengerCap INT NOT NULL CHECK(passengerCap>0),
            brand VARCHAR(64) NOT NULL,
            imagePath VARCHAR(64)
            ) ENGINE=INNODB;";

    $retval = mysql_query( $sql, $link );
    if(! $retval ) {
      die('Could not create table car: ' . mysql_error());
    } else {
        echo "<br>";
        echo "Table car created successfully";     
    }
      

    //create table copy
    $sql = "CREATE TABLE IF NOT EXISTS copy (
            copyNum INT CHECK(copyNum > 0),
            carID VARCHAR(10) NOT NULL,
            available  BOOLEAN,
            startDateOfService Date, 
            PRIMARY KEY(carID, copyNum),
            FOREIGN KEY(carID) REFERENCES car(carID) 
            ON UPDATE CASCADE ON DELETE CASCADE
            ) ENGINE=INNODB;";
    $retval = mysql_query( $sql, $link );
    if(!$retval ) {
      die('Could not create table copy: ' . mysql_error());
    } else {
        echo "<br>";
        echo "Table copy created successfully";      
    }
    

    //create table booking
    $sql = "CREATE TABLE IF NOT EXISTS booking (
            userEmail VARCHAR(50) NOT NULL,
            carID CHAR(10) NOT NULL,
            copyNum INT NOT NULL CHECK(copyNum > 0), 
            bookingTime DATETIME NOT NULL,
            collectDate DATE NOT NULL,
            returnDate DATE NOT NULL, 
            cost INT CHECK(price >= 0),
            CHECK(returnDATE >= collectDate),
            PRIMARY KEY(bookingTime, userEmail, copyNum, carID),
            FOREIGN KEY(userEmail) REFERENCES user(email)
            ON UPDATE CASCADE ON DELETE CASCADE,
            FOREIGN KEY(carID, copyNum) REFERENCES copy(carID, copyNum) 
            ON UPDATE CASCADE ON DELETE CASCADE
            )ENGINE=INNODB;";

    $retval = mysql_query( $sql, $link );
    if(! $retval ) {
      die('Could not create table booking: ' . mysql_error());
    } else {
        echo "<br>";
        echo "Table booking created successfully";     
    }

   
    
    
    mysql_close($link);
?>