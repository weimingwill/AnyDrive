

<?php

$con = mysqli_connect('127.0.0.1:3306','root');
// Check connection
if (mysqli_connect_errno()){
	die('Could not connect: ' . mysqli_connect_error());
} 
if(!mysqli_select_db($con, 'AnyDrive')) {
	if (mysqli_query($con, "CREATE DATABASE AnyDrive")){

	} else {
		echo "Error creating database: " . mysqli_error();
	}
}
date_default_timezone_set("Asia/Singapore");

function GR_string($length = 10) {
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$randomString = '';
	for ($i = 0; $i < $length; $i++) {
		$randomString .= $characters[rand(0, strlen($characters) - 1)];
	}
	return $randomString;
}

function GR_number($length=10){
	$characters = '0123456789';
	$randomNum = '';
	for ($i = 0; $i < $length; $i++) {
		$randomNum .= $characters[rand(0, strlen($characters) - 1)];
	}
	return $randomNum;
}

$user_NUM = 100;
$car_NUM = 30;
$copyPerCar_Num = 5;
$bookingPerCopy_Num=10;
$commentPerCopy_Num=8;


function GR_name($length=10) {
	return 'user_' + GR_string($length);
}
function GR_password($length=10) {
	return GR_string($length);
}

function GR_Age($max=100) {
	return rand(18, $max);
}

function GR_phoneNum() {
	return GR_number(8);
}
function GR_gender() {
	if(rand(1,100)>50) {
		return 'male';
	} else {
		return 'female';
	}
} 
function GR_imagePath() {
	return 'default.jpeg';
}


function GR_user() {

	for($x=1; $x<=$GLOBALS['user_NUM']; $x++) {

		$email_data = $x."@anydrive.com";
		$name_data = GR_name();
		$password_data = GR_password();
		$phoneNum_data = GR_phoneNum();
		$age_data = GR_Age();
		$gender_data = GR_gender();
		$imagePath_data ="../images/user/" . GR_imagePath();

		$insertUser = "INSERT INTO user (email, name, password, phoneNum, age, gender, imagePath)
		VALUES ('$email_data', '$name_data','$password_data', '$phoneNum_data', '$age_data', '$gender_data', '$imagePath_data')";
		if ( $GLOBALS['con']->query($insertUser) === False){
			echo "cannot insert NO.". $x+1 ."user";
			break;
		}
	}

}
function SE_email($length=10) {
	return rand(1, $GLOBALS['user_NUM']). '@anydrive.com'; 
}

function SE_array($array) {
	$size = count($array);
	if($size == 0) {
		return null;
	} else {
		return $array[rand(0,$size-1)];		
	}
}







function GR_brand()
{	$brand_SET = array('Volvo', 'BMW', 'Toyota', 'Alfa Romeo', 'Aston Martin', 'Bugatti', 'Chevrolet',  'Dodge', 'Ferrari', 'Lamborghini');
	return SE_array($brand_SET);
}
function GR_type(){
	$type_SET = array('Sedan', 'Luxury Sedan', 'Sports', 'Hatchback', 'SUV', 'Supercar', 'Microcar', 'Grand tourer');
	return SE_array($type_SET);
}
function GR_model() {
	return GR_string(5);
}

function GR_price() {
	return rand(50, 500);
}
function GR_passengerCap() {
	return rand(4,12);
}


function GR_car() {
	for($x=1; $x<=$GLOBALS['car_NUM']; $x++) {
		$carID_data = 10000 + $x;
		$brand_data = GR_brand();
		$type_data = GR_type();
		$model_data = GR_model();
		$passengerCap_data = GR_passengerCap();
		$price_data = GR_price();
		$imagePath_data = "../images/car/" . GR_imagePath();
		$insertCar = "INSERT INTO car (carID, brand, type, model, price, passengerCap, imagePath)
	    VALUES ('$carID_data', '$brand_data','$type_data', '$model_data', '$price_data', '$passengerCap_data', '$imagePath_data')";
	    if ( $GLOBALS['con']->query($insertCar) === False){
			break;
			echo "cannot insert NO.". $x+1 ."car model";
		}
	}	
}

function SE_carID(){ 
	return rand(0, $GLOBALS['car_NUM']-1) + 10000;
}
function GR_available(){
	return true;
}

function GR_datetime($min_date ="2000-01-01", $max_date= "2014-11-13") {
    /* Gets 2 dates as string, earlier and later date.
       Returns date in between them.
    */

    $min_epoch = strtotime($min_date);
    $max_epoch = strtotime($max_date);

    $rand_epoch = rand($min_epoch, $max_epoch);

    return date('Y-m-d H:i:s', $rand_epoch);
}

function GR_date($min_date ="2000-01-01", $max_date= "2014-10-13") {
    /* Gets 2 dates as string, earlier and later date.
       Returns date in between them.
    */

    $min_epoch = strtotime($min_date);
    $max_epoch = strtotime($max_date);

    $rand_epoch = rand($min_epoch, $max_epoch);

    return date('Y-m-d', $rand_epoch);
}
function ADD_Date($date) {
	$date1 = str_replace('-', '/', $date);
	$after = date('Y-m-d',strtotime($date1 . "+7 days"));
	return $after;
}
function GR_copy() {
	for($x=1; $x<=$GLOBALS['car_NUM']; $x++) {
		for($y=1; $y<=$GLOBALS['copyPerCar_Num']; $y++) {
			$carID_data = 10000 + $x;
			$copyNum_data = $y;
			$available_data = GR_available();
			$startDateOfService_data = GR_date();
			$insertCopy = "INSERT INTO copy (carID, copyNum, available, startDateOfService)
      		VALUES ('$carID_data','$copyNum_data', '$available_data', '$startDateOfService_data')";
      		if ( $GLOBALS['con']->query($insertCopy) === False){
				break;
				echo "cannot insert NO.". $x+1 ."car ---> No." . $y . 'copy';
			}
		}	
	}	

}


function GR_booking() {
	for($x=1; $x<=$GLOBALS['car_NUM']; $x++) {
		for($y=1; $y<=$GLOBALS['copyPerCar_Num']; $y++) {
			for($z=1; $z<=$GLOBALS['bookingPerCopy_Num']; $z++){
				$carID_data = 10000 + $x;
				$copyNum_data = $y;
				$userEmail_data = SE_email();
				$bookingTime_data = GR_datetime();
				$collectDate_data = ADD_Date($bookingTime_data);
				$returnDate_data = ADD_Date($collectDate_data);
				//!!!!!Problem
				$price_data = GR_price();
				$insertBooking = "INSERT INTO booking(userEmail, carID, copyNum ,bookingTime, collectDate, returnDate, cost)
    			VALUES ('$userEmail_data', '$carID_data', '$copyNum_data', '$bookingTime_data', '$collectDate_data', '$returnDate_data', '$price_data')";
    			if ( $GLOBALS['con']->query($insertBooking) === False){
				break;
				echo "cannot insert NO.". $x+1 ."booking" ;
				}
			}
		}
	}		
}
$bookingTime_data = GR_datetime();
				$collectDate_data = ADD_Date($bookingTime_data);
				$returnDate_data = ADD_Date($collectDate_data);

function GR_rating() {
	return rand(1, 5);
}
function GR_commentContent(){
	return GR_string(50);
}

function GR_comment() {
	for($x=1; $x<=$GLOBALS['car_NUM']; $x++) {
		for($y=1; $y<=$GLOBALS['copyPerCar_Num']; $y++) {
			for($z=1; $z<=$GLOBALS['commentPerCopy_Num']; $z++){
				$carID_data = 10000 + $x;
				$copyNum_data = $y;
				$userEmail_data = SE_email();
				$commentTime_data = GR_datetime();
				$rating_data = GR_rating();
				$comment_data = GR_commentContent();
				
				$insertComment = "INSERT INTO comment (carID, copyNum, userEmail, commentTime, rating, comment)
  				VALUES ('$carID_data','$copyNum_data', '$userEmail_data','$commentTime_data', '$rating_data', '$comment_data')";
    			if ( $GLOBALS['con']->query($insertComment) === False){
					break;
					echo "cannot insert NO.". $x+1 ."comment" ;
				}
			}
		}
	}	
}

 
function run(){


	GR_user();
	GR_car();
	GR_copy();
	GR_booking();
	GR_comment();
	echo 'success';
}
run();







mysqli_close($con);
?>