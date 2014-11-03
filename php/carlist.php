<!DOCTYPE html>
<!-- saved from url=(0029)http://bootswatch.com/united/ -->
<html lang="en">
<?php include 'head.php'; ?>
<body>
  <?php include 'navigation.php'; ?>
  <!--search form in homepage-->
  <div class="container">
  <div class="jumbotron">
   <form action="carlist.php"  method="post">
    <div class="form-group col-md-3">
      <div class="input-group col-sm-12">
        <input name="event_date" type="text" placeholder="Collect Date" class="form-control required" data-date-format="YYYY-MM-DD" id='datePicker1' />
        <span class="input-group-addon">
          <span class="glyphicon glyphicon-calendar"></span>
        </span>
      </div>
    </div>

    <div class="form-group col-md-3">
      <div class="input-group col-sm-12">
        <input name="event_date" type="text" placeholder="Return Date" class="form-control required" data-date-format="YYYY-MM-DD" id='datePicker2'/ >
        <span class="input-group-addon">
          <span class="glyphicon glyphicon-calendar"></span>
        </span>
      </div>
    </div>
    <button type="submit" value="submit" class="btn btn-primary">Search</button>
  </form>
</div>

<div class="col-sm-3 col-md-3 sidebar">
  <form action="carlist.php"  method="post" id="searchByPrice">
    <div class="form-group">
      <label for="price" class="col-sm-12 control-label">Price</label>
      <div class="input-group col-sm-12" id="price">
        <select class="form-control" name="price">
          <option id="priceOption">From lower to higher</option>
          <option id="priceOption">From higher to lower</option>
        </select>
      </div>
    </div>
  </form>
  <br>
  <form action="carlist.php"  method="post">
    <div class="form-group">
      <label for="passengerCap" class="col-sm-12 control-label">Passenger Capacity</label>
      <div class="input-group col-sm-12" id="passengerCap">
        <input name="passengerCap" type="text" class="form-control">
      </div>
    </div>
    <button type="submit" value="submit" class="btn btn-primary">Submit</button>
  </form> 
  <br>
  <form action="carlist.php"  method="post">
    <div class="form-group">
      <label for="gearType" class="col-sm-12 control-label">gearType</label>
      <div class="input-group col-sm-12" id="gearType">
        <select class="form-control" name="gearType">
          <option>All gear type</option>
          <option>Automatic</option>
          <option>Manual</option>
        </select>
      </div>
    </div>
  </form>     
  <br>
  <form action="carlist.php"  method="post">
    <div class="form-group">
      <label for="brand" class="col-sm-12 control-label">brand</label>
      <div class="input-group col-sm-12" id="brand">
        <input name="brand" type="text" class="form-control">
      </div>
    </div>
    <button type="submit" value="submit" class="btn btn-primary">Submit</button>
  </form>               
</div>
<div class="col-md-9" >
    <?php
    $price = $passengerCap = $gearType = $brand = "";
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
          //connect to database
      require('car_mysql.php');

      if(!empty($_POST["price"])){
        $price = test_input($_POST["price"]);
        echo "Search by price ".$price;
      }

      if(!empty($_POST["passengerCap"])){
        $passengerCap = test_input($_POST["passengerCap"]);
        echo "Search by passengerCap ".$passengerCap;
      }

      if(!empty($_POST["gearType"])){
        $gearType = test_input($_POST["gearType"]);
        echo "Search by gearType ".$gearType;
      }          

      if(!empty($_POST["brand"])){
        $brand = test_input($_POST["brand"]);
        echo "Search by brand ".$brand;
      }

      $sql = "";
      if($price!=""){
        if($price == "From lower to higher"){
          $sql = "SELECT * FROM car, copy WHERE available = 1 AND car.carID = copy.carID ORDER BY price ASC";
        } else if($price == "From higher to lower"){
          $sql = "SELECT * FROM car, copy WHERE available = 1 AND car.carID = copy.carID ORDER BY price DESC";
        }
      } else if($gearType!=""){
        if($gearType == "All gear type"){
          $sql = "SELECT * FROM car, copy WHERE available = 1 AND car.carID = copy.carID";               
        } else {
          $sql = "SELECT * FROM car, copy WHERE available = 1 AND car.carID = copy.carID AND gearType LIKE '%$gearType%' ";
        }
      } else if($brand!=""){
        $sql = "SELECT * FROM car, copy WHERE available = 1 AND car.carID = copy.carID AND brand LIKE '%$brand%' ";
      } else if($passengerCap!=""){
        $sql = "SELECT * FROM car, copy WHERE available = 1 AND car.carID = copy.carID AND passengerCap >= $passengerCap";
      }

      $result = mysqli_query($con, $sql);
      if(mysqli_num_rows($result) > 0){
        while ($row = mysqli_fetch_assoc($result))   {
          echo "carID:".$row["carID"];
          echo " ";
          echo "price:".$row["price"];
          echo " ";
          echo "passengerCap:".$row["passengerCap"];
          echo " ";
          echo "copyNum:".$row["copyNum"];
          echo " ";
          echo "startDateOfService:".$row["startDateOfService"];
          echo " ";
          echo "brand:".$row["brand"]."<br>";
        }
      } else {
        echo "0 result";
      }

    }

    function test_input($data) {
     $data = trim($data);
     $data = stripslashes($data);
     $data = htmlspecialchars($data);
     return $data;
   }


   require('car_mysql.php');
        //search car by price
        // $sql = "SELECT * FROM car, copy ORDER BY price";

        //search car by date
   $sql = "SELECT * FROM car, copy WHERE available = 1 AND car.carID = copy.carID ORDER BY STR_TO_DATE(startDateOfService, '%Y-%m-%d') ASC";  
   $result = mysqli_query($con, $sql);
   if(mysqli_num_rows($result) > 0){
    while ($row = mysqli_fetch_assoc($result))   {
      echo "carID:".$row["carID"];
      echo " ";
      echo "price:".$row["price"];
      echo " ";
      echo "passengerCap:".$row["passengerCap"];
      echo " ";
      echo "copyNum:".$row["copyNum"];
      echo " ";
      echo "startDateOfService:".$row["startDateOfService"];
      echo " ";
      echo "brand:".$row["brand"]."<br>";
    }
  } else {
    echo "0 result";
  }
  ?>

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

});



</script>

</body>
</html>