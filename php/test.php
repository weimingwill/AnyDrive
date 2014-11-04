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
  <form action="test.php"  method="post">
    <div class="form-group">
      <label for="carType" class="col-sm-12 control-label">Car Type</label>
      <div class="input-group col-sm-12" id="carType">
        <input type="checkbox" name="carType[]" value="Sedan">Sedan 
        <input type="checkbox" name="carType[]" value="Luxury Sedan">Luxury Sedan 
        <input type="checkbox" name="carType[]" value="Sports">Sports 
        <input type="checkbox" name="carType[]" value="Hatchback">Hatchback 
        <input type="checkbox" name="carType[]" value="MPV">MPV         
        <input type="checkbox" name="carType[]" value="SUV">SUV 
      </div>
    </div>
    <button type="submit" value="submit" class="btn btn-primary">Submit</button>
  </form>             
</div>
<div class="col-md-9" >
    <?php
    $carType = "";
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
          //connect to database
      if(!empty($_POST["carType"])){
        $carType = $_POST["carType"];
        echo "Search by carType ";
        echo sizeof($carType);
        for ($i=0; $i <sizeof($carType) ; $i++) { 
          echo $carType[$i];
        }
        // echo $carType;
      }
    }

    function test_input($data) {
     $data = trim($data);
     $data = stripslashes($data);
     $data = htmlspecialchars($data);
     return $data;
   }
  ?>

</div>

</div><!--body part-->

<?php include 'footer.php'; ?>  


</body>
</html>