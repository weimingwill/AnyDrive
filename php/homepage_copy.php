<?php 
require('cookie.php');

?>

<!DOCTYPE html>
<!-- saved from url=(0029)http://bootswatch.com/united/ -->
<html lang="en">
<?php include 'head.php'; ?>
<?php
// set deafult varible name

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

function test_input($data) {
 $data = trim($data);
 $data = stripslashes($data);
 $data = htmlspecialchars($data);
 return $data;
}

$feedback = '';
$action_str = 'action';
$getFieldDelete_str = 'delete';
$isUpdate_str = 'isUpdate';

$carID_str = "carID";
$type_str = "type";
$model_str = "model";
$brand_str = "brand";
$price_str = "price";
$passengerCap_str = "passengerCap";
$imagePath_str ='imagePath';

$copyNum_str = "copyNum";
$startDateOfService_str = "startDateOfService"; 
$averageRating_str = "averageRating";
$rating_str = "rating";
$commentTime_str = "commentTime";
$userEmail_str = "userEmail";
$comment_str = "comment";

$carID_data = $type_data = $model_data = $price_data = $passengerCap_data = $brand_data = $imagePath_data ='';
$copyNum_data = $startDateOfService_data = '';
$averageRating_data = 'unavailable';
$rating_data = '';
echo "<br><br><br>";
date_default_timezone_set("Asia/Singapore");
$commentTime_data = date('Y-m-d H:i:s');
$userEmail_data =  $comment_data = "";

$carID_Err = $type_Err = $model_Err = $price_Err = $passengerCap_Err = $brand_Err = $imagePath_Err ='';
$carID_Err = $copyNum_Err = $available_Err = $startDateOfService_Err = $averageRating_Err = $rating_Err= '';
$userEmail_Err='';

if ($_SERVER["REQUEST_METHOD"] == "GET") {

  if(true){

    $carID_data = $_GET[$carID_str];
    $copyNum_data = $_GET[$copyNum_str];

    $carQuery = "SELECT * FROM copy, car WHERE car.carID = copy.carID AND copy.carID = '$carID_data' AND copy.copyNum = '$copyNum_data'";
    $carResult = mysqli_query($con, $carQuery);

    $row = mysqli_fetch_assoc($carResult);
    $brand_data = $row[$brand_str];
    $model_data = $row[$model_str];
    $type_data = $row[$type_str];
    $price_data = $row[$price_str];
    $passengerCap_data = $row[$passengerCap_str];
    $imagePath_data = $row[$imagePath_str];
    $startDateOfService_data = $row[$startDateOfService_str];

    // calculate average rating

    $averageRating_sql = "SELECT AVG(rating) FROM comment WHERE carID = '$carID_data' AND copyNum = '$copyNum_data'";
    $averageRating_result = mysqli_query($con, $averageRating_sql);

    $averageRating_row = mysqli_fetch_assoc($averageRating_result);
    if($averageRating_row[$rating_str] >= 1) {
      $averageRating_data = $averageRating_row[$rating_str];
    }  

    if(isset($_COOKIE[$userEmail_str])) {
      $userEmail_data = $_COOKIE[$userEmail_str];
    }

  } 


} else if ($_SERVER["REQUEST_METHOD"] == "POST") {

  $isInsert = true;
  if (empty($_POST[$carID_str])) {
    $carID_Err = $Err_Required_Field;
    $isInsert = False;
  } else {
    $carID_data = test_input($_POST[$carID_str]);
  }


  if (empty($_POST[$copyNum_str])) {
    $copyNum_Err = $Err_Required_Field;
    $isInsert = False;
  } else {
    $copyNum_data = test_input($_POST[$copyNum_str]);
  }   

  $carID_data = $_GET[$carID_str];
  $copyNum_data = $_GET[$copyNum_str];

  $carQuery = "SELECT * FROM copy, car WHERE car.carID = copy.carID AND copy.carID = '$carID_data' AND copy.copyNum = '$copyNum_data'";
  $carResult = mysqli_query($con, $carQuery);

  $row = mysqli_fetch_assoc($carResult);
  $brand_data = $row[$brand_str];
  $model_data = $row[$model_str];
  $type_data = $row[$type_str];
  $price_data = $row[$price_str];
  $passengerCap_data = $row[$passengerCap_str];
  $imagePath_data = $row[$imagePath_str];
  $startDateOfService_data = $row[$startDateOfService_str];

    // calculate average rating

  $averageRating_sql = "SELECT AVG(rating) FROM comment WHERE carID = '$carID_data' AND copyNum = '$copyNum_data'";
  $averageRating_result = mysqli_query($con, $averageRating_sql);

  $averageRating_row = mysqli_fetch_assoc($averageRating_result);
  if($averageRating_row[$rating_str] >= 1) {
    $averageRating_data = $averageRating_row[$rating_str];
  }  


  if (empty($_POST[$rating_str])) {
    $rating_Err = $Err_Required_Field;
    $isInsert = False;
  } else if (intval($_POST[$rating_str]) > 5 or intval($_POST[$rating_str]) < 1) {
    $rating_Err = "plz give a rating between 1 and 5";
    $isInsert = False;
  } else {
    $rating_data = test_input($_POST[$carID_str]);
  }

    // comment can be empty
  $comment_data = test_input($_POST[$comment_str]);
  
  if(isset($_COOKIE[$userEmail_str])) {
    $userEmail_data = $_COOKIE[$userEmail_str];
  } else {
    $isInsert = false;
    $feedback = "plz login first";
  }

}

if($isInsert){
  $sql = "SELECT carID FROM comment where carID = '$carID_data' AND copyNum ='$copyNum_data' ".
  "AND userEmail = '$userEmail_data' AND commentTime='$commentTime'";
  $result = mysqli_query($con, $sql);

  $insertComment = "INSERT INTO comment (carID, copyNum, userEmail, commentTime, rating, comment)
  VALUES ('$carID_data','$copyNum_data', '$userEmail_data','$commentTime_data', '$rating_data', '$comment_data')";

  if (mysqli_num_rows($result) > 0) {
    $feedback = "plz wait a while to post your comment";
  } else {
    if ( $con->query($insertComment) === TRUE) {
      $feedback = "New comment created successfully";
      $rating_data = $comment_data = '';
    } else {  
      $feedback = "Error: " . $insertCar . "<br>" . $con->error;
    }
  } 


}

?>
<body>
  <?php include 'navigation.php'; ?>

<div class="container mainBody">
   <div class="page-header" id="banner">
    <h1>Car Copy Info<small>&nbsp<?php echo $feedback;?></small></h1>
  </div>

  <div class='col-sm-12 row'>
    <div class='col-md-6'>
      <img src="<?php echo $imagePath_data; ?>" class='image'>
    </div>
    <div class="form-group col-md-6">
      <div class='JLabel'>
        <div class="label label-primary  col-lg-4 control-label">Brand:</div>
        <div class="col-lg-8 centerAlign">
          <span><?php echo $brand_data; ?></span>
        </div>
      </div>

      <div class='JLabel'>
        <div class="label label-primary  col-lg-4 control-label">Model:</div>
        <div class="col-lg-8 centerAlign">
          <span><?php echo $model_data; ?></span>
        </div>
      </div>
      
      <div class='JLabel'>
        <div class="label label-primary  col-lg-4 control-label">Type:</div>
        <div class="col-lg-8 centerAlign">
          <span><?php echo $type_data; ?></span>
        </div>
      </div>

      <div class='JLabel'>
        <div class="label label-primary  col-lg-4 control-label">Capacity:</div>
        <div class="col-lg-8 centerAlign">
          <span><?php echo $passengerCap_data; ?></span>
        </div>
      </div>

      <div class='JLabel'>
        <div class="label label-primary  col-lg-4 control-label">Price($):</div>
        <div class="col-lg-8 centerAlign">
          <span><?php echo $price_data; ?></span>
        </div>
      </div>
      <?php
        $averageRating_sql = "SELECT AVG(rating) FROM comment WHERE carID = '$carID_data' AND copyNum = '$copyNum_data'";
        $averageRating_result = mysqli_query($con, $averageRating_sql);

        $averageRating_row = mysqli_fetch_assoc($averageRating_result);
        
          $averageRating_data = $averageRating_row["AVG(rating)"];
         $averageRating_data = number_format($averageRating_data, 2, '.', '');
      ?>
      <div class='JLabel'>
        <div class="label label-primary  col-lg-4 control-label">Average Rating:</div>
        <div class="col-lg-8 centerAlign">
          <span class='star'><?php echo $averageRating_data; ?></span>
        </div>
      </div>
    
    </div> 
  </div> 

  <div class='emtpyBlock col-xs-12'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
  <div class="col-sm-12 row container">
  
    <h1 class='page-header'>Comments <a href="#post"><button class='btn btn-default btn-primary'>post your comment here</button></a>
    </h1>
  
    <?php

    $allRating_sql = "SELECT * FROM comment, user WHERE comment.userEmail = user.email AND comment.carID = '$carID_data' AND comment.copyNum = '$copyNum_data' ORDER BY commentTime DESC";
    $allRating_result = mysqli_query($con, $allRating_sql);
    $index = 0;
    

    while($allRating_row = mysqli_fetch_assoc($allRating_result)){

  echo " <div class='";
      if($index%2 == 0) {
        echo "col-sm-9'> ";
      } else {
        echo "col-sm-offset-3 col-sm-9'> ";
      }
      echo"<div class='panel panel-primary'>" .
            "<div class='panel-heading'>" .
              "<h4 class='panel-title'><a href='#'>" .
              $allRating_row["name"]. "&nbsp;".
              "<img src=" . $allRating_row[$imagePath_str]. " class='thumbnail'></a>".
              "</h4>".
            "</div>";
      echo  "<div class='panel-body'>" . "<div class='col-sm-4'>Rating:</div> <div class='col-sm-8 star'>".$allRating_row[$rating_str]."</div>".
            "</div>" .
            "<div class='panel-body'>" . $allRating_row[$comment_str] .
            "</div>" .
            "<div class='panel-footer'>". $allRating_row[$commentTime_str] .
            "</div>".
          "</div>";

  echo "</div>";
  if($index%2 == 0) {
  echo "<div class='emptyBlock col-sm-3'></div> ";
  }
  $index = $index + 1;  
   } 

    ?>

    </div>

   <div id="post" class='col-sm-12 row'>
    <div class='panel panel-primary'>
      <div class='panel-heading'>
        <h3 class='panel-title'>New Comment</h3>
      </div>
      <div class='panel-body'>
        <form method="post" class="form-horizontal">
          <input type='hidden' name='carID' value='<?php echo $carID_data;?>' >
          <input type='hidden' name='copyNum' value='<?php echo $copyNum_data?>'>

          <div class="form-group col-xs-12">
            <label for="rating" class="col-sm-4">Rating:</label>
            <span id='ratingReader'class='col-sm-1'>3</span>
            <div class='col-sm-7' class="form-control" id="rating" ></div>
            <input class='hidden' type="number" id ='ratingInput' value='3' name='rating'>
          </div>
          <textarea name='comment' rows='4' class="form-control newCommentContent"></textarea>
          <br>
          <button type='submit' class='btn btn-md btn-primary btn-commentSubmit'><span class="  glyphicon glyphicon-send"></span> Confirm</button>
        </form>
      </div>
    </div>

  </div>

  <?php include 'footer.php'; ?> 
 </div> 


  
  <script type="text/javascript">
  $(document).ready(function(){
    $('.star').each(function(){
      var n = parseInt($(this).text())

      $(this).append('&nbsp;')
      if(n<=5 && n>=1){
        var blackStar = '<span class="glyphicon glyphicon-star"></span>'
        var emptyStar = '<span class="glyphicon glyphicon-star-empty"></span>'
        for(var i=1;i<=n;i++){
          $(this).append(blackStar)  
        }
        for(var i=1;i<=(5-n);i++){
          $(this).append(emptyStar)  
        }
      } else {
          //alert('n is illegal');
        }

      });

  });
  </script>
  
 <link rel="stylesheet" href="../css/jquery-ui.css">
  <script src="../scripts/jquery-1.10.2.js"></script>
  <script src="../scripts/jquery-ui.js"></script>
  <script type="text/javascript">
  $(document).ready(function(){

    $("#rating").slider({min: 1}, {value:5}, {max: 5}, {slide: function( event, ui) {
      var value = ui.value;
      $('#ratingInput').val(value);
      $('#ratingReader').text(value);
    }});


  });
  </script>
</body>


</html>

