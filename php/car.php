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

    $carId = $copyNum = "";
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
          //connect to database
      require('car_mysql.php');

      if(!empty($_POST["carId"])){
        $carId = $_POST["carId"];
      }

      $sql = "SELECT * FROM car, copy WHERE available = 1 AND car.carID = copy.carID AND car.carID = '$carId' ";
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
          <form action="car.php" method="get">
            <input type="hidden" name="carId" value="<?php echo $row["carID"]?>">
            <input type="hidden" name="copyNum" value="<?php echo $row["copyNum"] ?>">
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
//second post
} else if ($_SERVER["REQUEST_METHOD"] == "GET"){
      require('car_mysql.php');

      if(!empty($_GET["carId"])){
        $carId = $_GET["carId"];
      }

      if(!empty($_GET["copyNum"])){
        $copyNum = $_GET["copyNum"];
      }

      $sql = "SELECT * FROM car, copy WHERE available = 1 AND car.carID = copy.carID AND car.carID = '$carId' AND copyNum = '$copyNum' ";
      $result = mysqli_query($con, $sql);

      if(mysqli_num_rows($result) > 0){
        while ($row = mysqli_fetch_assoc($result)){
      ?>
      <div class="panel panel-primary">
        <div class="panel-heading">
          <h2 class="panel-title">About the car</h2>
        </div>
        
        <div class="panel-body">
          <table class="table-car-feature">
<!--             <thead>
              <tr>
                <th class="table-car-header"><?php echo $row["brand"]." ".$row["model"] ?></th>
              </tr>
            </thead> -->
            <tbody>
              <tr>
                <td><img class="car-img" src="../images/car1.jpg"></td>
                <td class="table-td-car-feature">
                  <h3><?php echo $row["brand"]." ".$row["model"] ?></h3>
                  <!-- <i class="fa fa-car fa-2x"></i> -->
                  <?php echo $row["type"] ?>
                  <?php echo $row["passengerCap"] ?>
                  <?php echo "$".$row["price"] ?>
                  <form action="booking.php" action="post">
                    <input type="hidden" name="carId" value="">
                    <input type="hidden" name="copyNum" value="">
                    <div class="form-group">
                      <div class="input-group col-sm-12">
                        <input name="collectDate" type="text" placeholder="Rent Date" class="form-control required" data-date-format="YYYY-MM-DD" id='rentdate' />
                        <span class="input-group-addon">
                          <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                      </div>
                    </div>

                    <div class="form-group">
                      <div class="input-group col-sm-12">
                        <input name="returnDate" type="text" placeholder="Return Date" class="form-control required" data-date-format="YYYY-MM-DD" id='returndate'/ >
                        <span class="input-group-addon">
                          <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                      </div>
                    </div>                    
                    <button class="btn btn-primary">Book</button>
                  </form>
<!--                   <div class="panel panel-warning car-feature">
                    <div class="panel-heading">
                      <h2 class="panel-title"><?php echo $row["brand"]." ".$row["model"] ?></h2>
                    </div>
                    <div class="panel-body">
                      <table>
                        <tbody>
                          <tr>
                            <td><?php echo $row["type"] ?></td>
                            <td><?php echo $row["passengerCap"] ?></td>
                          </tr>
                          <tr>
                            <td><?php echo $row["price"] ?></td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div> -->
                </td>
              </tr>
            </tbody>
          </table>
          
          
          
        </div>
      </div>

      <?php    
        }
      }   
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

  $('#rentdate').datetimepicker({
    pickTime: false
  });
  $('#returndate').datetimepicker({
    pickTime: false
  });      

  $('#rentdate').datetimepicker();
  $('#returndate').datetimepicker();
  $("#rentdate").on("dp.change",function (e) {
   $('#returndate').data("DateTimePicker").setMinDate(e.date);
 });
  $("#returndate").on("dp.change",function (e) {
   $('#rentdate').data("DateTimePicker").setMaxDate(e.date);
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