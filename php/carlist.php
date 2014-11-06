<!DOCTYPE html>
<!-- saved from url=(0029)http://bootswatch.com/united/ -->
<html lang="en">
<?php include 'head.php'; ?>
<body>
  <?php include 'navigation.php'; ?>
  <!--search form in homepage-->
  <div class="container">
    <div class="col-sm-3 col-md-2 sidebar">
      <form action="carlist.php"  method="post" id="searchByPrice">
        <div class="form-group">
          <label for="price" class="col-sm-12 control-label">Price</label>
          <div class="input-group col-sm-12" id="price">
            <select class="form-control" name="price">
              <option id="priceOption">lower to higher</option>
              <option id="priceOption">higher to lower</option>
            </select>
          </div>
        </div>
      </form>     
      <form action="carlist.php"  method="post">  
        <div class="form-group">
          <div class="input-group col-sm-12">
            <input name="event_date" type="text" placeholder="Collect Date" class="form-control required" data-date-format="YYYY-MM-DD" id='datePicker1' />
            <span class="input-group-addon">
              <span class="glyphicon glyphicon-calendar"></span>
            </span>
          </div>
        </div>

        <div class="form-group">
          <div class="input-group col-sm-12">
            <input name="event_date" type="text" placeholder="Return Date" class="form-control required" data-date-format="YYYY-MM-DD" id='datePicker2'/ >
            <span class="input-group-addon">
              <span class="glyphicon glyphicon-calendar"></span>
            </span>
          </div>
        </div>

        <div class="form-group">
          <label for="passengerCap" class="col-sm-12 control-label">Passenger Capacity</label>
          <div class="input-group col-sm-12" id="passengerCap">
            <input name="passengerCap" type="text" class="form-control">
          </div>
        </div>

        <div class="form-group">
          <label for="brand" class="col-sm-12 control-label">brand</label>
          <div class="input-group col-sm-12" id="brand">
            <input name="brand" type="text" class="form-control">
          </div>
        </div>

        <div class="form-group">
          <label for="carType" class="col-sm-12 control-label">Car Type</label>
          <div class="input-group col-sm-12">
            <ul class="car-type">
              <li class="car-type-list"><input type="checkbox" name="carType[]" value="Sedan"> Sedan </li>
              <li class="car-type-list"><input type="checkbox" name="carType[]" value="Luxury Sedan"> Luxury Sedan </li>
              <li class="car-type-list"><input type="checkbox" name="carType[]" value="Sports"> Sports </li>
              <li class="car-type-list"><input type="checkbox" name="carType[]" value="Hatchback"> Hatchback </li>
              <li class="car-type-list"><input type="checkbox" name="carType[]" value="MPV"> MPV</li>
              <li class="car-type-list"><input type="checkbox" name="carType[]" value="SUV"> SUV </li>
            </ul>
          </div>
        </div>

        <button type="submit" value="submit" class="col-md-12 btn btn-primary">Search</button>
      </form>               
    </div>

    <div class="col-md-10 content">
      <?php
      function test_input($data) {
       $data = trim($data);
       $data = stripslashes($data);
       $data = htmlspecialchars($data);
       return $data;
     }

     $carType = array();
     $price = $passengerCap = $gearType = $brand = "";
     if ($_SERVER["REQUEST_METHOD"] == "POST") {
          //connect to database
      require('car_mysql.php');

      if(!empty($_POST["price"])){
        $price = test_input($_POST["price"]);
      }

      if(!empty($_POST["passengerCap"])){
        $passengerCap = test_input($_POST["passengerCap"]);
      }

      if(!empty($_POST["brand"])){
        $brand = test_input($_POST["brand"]);
      }

      if(!empty($_POST["carType"])){
        $carType = $_POST["carType"];
      }

      $sql = "";
      if(!empty($price)){
        if($price == "lower to higher"){
          $sql = "SELECT * FROM car, copy WHERE available = 1 AND car.carID = copy.carID ORDER BY price ASC";
        } else if($price == "higher to lower"){
          $sql = "SELECT * FROM car, copy WHERE available = 1 AND car.carID = copy.carID ORDER BY price DESC";
        }
      } else {
        $sql = "SELECT * FROM car, copy WHERE available = 1 AND car.carID = copy.carID ";
        if(!empty($brand)){
          $sql = $sql."AND brand LIKE '%$brand%' ";
        }
        if(!empty($passengerCap)){
          $sql = $sql."AND passengerCap >= $passengerCap ";
        }
        if(!empty($carType)){
          $sql = $sql."AND (";
            for ($i=0; $i < sizeof($carType) - 1; $i++) { 
              $sql = $sql."type LIKE '%$carType[$i]%' OR ";
            }
            $sql = $sql."type LIKE '%$carType[$i]%')";
        }
}

$result = mysqli_query($con, $sql);
?>

<table class="col-md-12 table-carlist">
  <thead class="table-header">
    <tr>
      <th></th>
      <th>Model</th>
      <th>Price</th>
    </tr> 
  </thead>
  <tbody>
    <?php
    if(mysqli_num_rows($result) > 0){
      while ($row = mysqli_fetch_assoc($result)){
       ?>
       <tr class="table-row">
        <td><img class="car-img" src="../images/car1.jpg"></td>
        <td><?php echo $row["brand"]." ".$row["model"] ?></td>
        <td>
          <?php echo "$".$row["price"] ?>
          <?php echo $row["carID"] ?>
            <form action="car.php" method="post">
              <input type="hidden" name="carId" value="<?php echo $row["carID"]?>">
              <button class="btn btn-primary">SELECT</button>
            </form>
        </td>
      </tr>
    </tbody>
    <?php
  }
}
?>
</table>
<?php
} else {
  require('car_mysql.php');
      // $sql = "SELECT * FROM car, copy WHERE available = 1 AND car.carID = copy.carID ORDER BY STR_TO_DATE(startDateOfService, '%Y-%m-%d') ASC"; 
  $sql = "SELECT * FROM car"; 
  $result = mysqli_query($con, $sql);
  ?>
  <table class="col-md-12">
    <thead class="table-header">
      <tr>
        <th></th>
        <th>Model</th>
        <th>Price<b class="caret"></b></a>
          <ul class="dropdown-menu">
            <li><a href="#"></a></li>
            <li><a href="#">Another action</a></li>
          </ul>
        </th>
      </tr> 
    </thead>
    <tbody>
      <?php
      if(mysqli_num_rows($result) > 0){
        while ($row = mysqli_fetch_assoc($result)){
         ?>
         <tr class="table-row">
          <td><img class="car-img" src="../images/car1.jpg"></td>
          <td><?php echo $row["brand"]." ".$row["model"] ?></td>
          <td>
            <form action="car.php" method="post">
              <input type="hidden" name="carId" value="<?php echo $row["carID"]?>">
              <button class="btn btn-primary">SELECT</button>
            </form>
          </td>
        </tr>
      </tbody>
      <?php  
    }
  }
  ?>
</table>
<?php
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