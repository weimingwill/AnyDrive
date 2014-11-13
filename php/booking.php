<!DOCTYPE html>
<!-- saved from url=(0029)http://bootswatch.com/united/ -->
<html lang="en">
<?php include 'head.php'; ?>
<body>
  <?php include 'navigation.php'; ?>
  <!--search form in homepage-->
  <div class="container setFooter">

    <div class="col-md-12 content">
      <?php
      function test_input($data) {
       $data = trim($data);
       $data = stripslashes($data);
       $data = htmlspecialchars($data);
       return $data;
     }

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
      <table id="table-booking">
        <thead class="table-header-booking">
          <tr>
            <td>Car</td>
            <td>From</td>
            <td>To</td>
            <td>Payment amount</td>
            <td></td>
          </tr>
          <tr>
            <th><h3></h3></th>
          </tr>
        </thead>
        <tbody>
          <tr class="table-content-booking">
            <td><?php echo $brand." ".$model ?></td>
            <td><?php echo $collectDate ?></td>
            <td><?php echo $returnDate ?></td>
            <td><?php echo "$".$price ?></td>
            <td>
              <form action="booking.php" method="post" style="margin-right: -40px;">
                <input type="hidden" name="carId" value="<?php echo $carId ?>">
                <input type="hidden" name="copyNum" value="<?php echo $copyNum ?>">
                <input type="hidden" name="price" value="<?php echo $price ?>">
                <input type="hidden" name="collectDate" value="<?php echo $collectDate ?>">
                <input type="hidden" name="returnDate" value="<?php echo $returnDate ?>">
                <button class="btn btn-primary" style="width: 90px;">Book</button>
              </form>
            </td>
          </tr>
        </tbody>
      </table>
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
  <div class="booking-btns">
  <a href="carlist.php" class="btn btn-primary">Book another car</a>
  <a href="user_booking.php" class="btn btn-primary" style="margin-left: 20px;">Manage booking</a>
</div>
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