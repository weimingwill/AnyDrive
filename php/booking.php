<!DOCTYPE html>
<!-- saved from url=(0029)http://bootswatch.com/united/ -->
<html lang="en">
<?php include 'head.php'; ?>
<body>
  <?php include 'navigation.php'; ?>
  <!--search form in homepage-->
  <div class="container">

    <div class="col-md-12 content">
      <?php
      function test_input($data) {
       $data = trim($data);
       $data = stripslashes($data);
       $data = htmlspecialchars($data);
       return $data;
     }

    date_default_timezone_set("Asia/Singapore");
    $carId = $copyNum = $brand = $model = $collectDate = $returnDate = $userEmail = $price = $feedback = "";
    if ($_SERVER["REQUEST_METHOD"] == "GET") {
          //connect to database
      require('car_mysql.php');

      if(!isset($_COOKIE[$cookie_name])) {
        echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=login.php'>";
      }

      if(!empty($_GET["carId"])){
        $carId = $_GET["carId"];
      }

      if(!empty($_GET["copyNum"])){
        $copyNum = $_GET["copyNum"];
      }

      if(!empty($_GET["brand"])){
        $brand = $_GET["brand"];
      }

      if(!empty($_GET["model"])){
        $model = $_GET["model"];
      }

      if(!empty($_GET["collectDate"])){
        $collectDate = $_GET["collectDate"];
      }

      if(!empty($_GET["returnDate"])){
        $returnDate = $_GET["returnDate"];
      }

      if(!empty($_GET["price"])){
        $price = $_GET["price"];
      }    
      // $sql = "SELECT * FROM car, copy WHERE available = 1 AND car.carID = copy.carID AND car.carID = '$carId' AND copyNum = '$copyNum' ";
      // $result = mysqli_query($con, $sql);
?>
  <div class="panel panel-primary">
    <div class="panel-heading">
      <h1 class="panel-title">Booking Information</h1>
    </div>
    <div class="panel-body">
      <h3><span class="booking-label">Vehicle: </span><span><?php echo $brand." ".$model ?></span></h3>
      <h3><span>Collect Date: </span><span><?php echo $collectDate ?></span></h3>
      <h3><span>Return Date:  </span><span><?php echo $returnDate ?></span></h3>
      <form action="booking.php" method="post">
        <input type="hidden" name="carId" value="<?php echo $carId ?>">
        <input type="hidden" name="copyNum" value="<?php echo $copyNum ?>">
        <input type="hidden" name="price" value="<?php echo $price ?>">
        <input type="hidden" name="collectDate" value="<?php echo $collectDate ?>">
        <input type="hidden" name="returnDate" value="<?php echo $returnDate ?>">
        <button class="btn btn-primary">Book</button>
      </form>
    </div>
  </div>
<?php

}else if ($_SERVER["REQUEST_METHOD"] == "POST") {
        //connect to database
    require('car_mysql.php');

    if(isset($_COOKIE[$cookie_name])) {
      $userEmail = $_COOKIE[$cookie_name];
    }

    if(empty($userEmail)){
      echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=login.php'>";
    }

    if(!empty($_POST["carId"])){
      $carId = $_POST["carId"];
    }

    if(!empty($_POST["copyNum"])){
      $copyNum = $_POST["copyNum"];
    }

    if(!empty($_POST["collectDate"])){
      $collectDate = $_POST["collectDate"];
    }

    if(!empty($_POST["returnDate"])){
      $returnDate = $_POST["returnDate"];
    }

    if(!empty($_POST["price"])){
      $price = $_POST["price"];
    }


    // echo "carId: ".$carId;
    // echo "  ";
    // echo "copyNum: ".$copyNum;
    // echo "  ";
    // echo "collectDate: ".$collectDate;
    // echo "  ";
    // echo "returnDate: ".$returnDate;
    // echo "  ";
    // echo date("Y-m-d h:i:sa");
    // echo "<br>";
    $bookingTime = date("Y-m-d h:i:s");

    $sql = "INSERT INTO booking(userEmail, carID, copyNum ,bookingTime, collectDate, returnDate, cost)
    VALUES ('$userEmail', '$carId', '$copyNum', '$bookingTime', '$collectDate', '$returnDate', '$price')";

    if ( $con->query($sql) === TRUE) {
        $feedback = "New record created successfully";
    }else {  
      $feedback = "Error: " . $sql . "<br>" . $con->error;
    }
  }
?>
  <?php
    if(!empty($feedback)){
  ?>
  <div class="booking-feedback"><h1><?php echo $feedback ?></h1></div>
  <a href="carlist.php" class="btn btn-primary">Book another car</a>
  <a href="user_booking.php" class="btn btn-primary">Manage booking</a>
  <?php } ?>
</div>



</div><!--body part-->

<?php include 'footer.php'; ?>  

<script type="text/javascript">
$(function () {
  $('#datePicker1').datetimepicker({
    pickTime: false
  });
  $('#datePicker2').datetimepicker({
    pickTime: false
  });      

  $('#datePicker1').datetimepicker();
  $('#datePicker2').datetimepicker();
  $("#datePicker1").on("dp.change",function (e) {
   $('#datePicker2').data("DateTimePicker").setMinDate(e.date);
 });
  $("#datePicker2").on("dp.change",function (e) {
   $('#datePicker1').data("DateTimePicker").setMaxDate(e.date);
 });

  $('select').change(function (){
    $(this).closest('form').submit();
  });

  $('.caret').click(function(){
    $('.dropdown-menu').toggle();
  });

  // $('#carType').change(function (){
  //   $(this).closest('form').submit();
  // });

});

</script>

</body>
</html>