<?php 
  require('cookie.php');

 ?>
        
<!DOCTYPE html>
<!-- saved from url=(0029)http://bootswatch.com/united/ -->
<html lang="en">
<?php require 'head.php'; ?>
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
$feedback = '';


$carID_str = "carID";

$type_str = "type";
$type_set = array('Sedan', 'Luxury Sedan', 'Sports', 'Hatchback', 'SUV');

$model_str = "model"; 

$brand_str = "brand";
$brand_set = array('Volvo', 'BMW', 'Toyota');

$price_str = "price";
$passengerCap_str = "passengerCap";

$carID_data = $type_data = $model_data = $price_data = $passengerCap_data = $brand_data ='';
$carID_Err = $type_Err = $model_Err = $price_Err = $passengerCap_Err = $brand_Err ='';

function test_input($data) {
   $data = trim($data);
   $data = stripslashes($data);
   $data = htmlspecialchars($data);
   return $data;
}

$isInsert = False;
$Err_Required_Field = 'Required field!';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $isInsert = TRUE;
    if (empty($_POST[$carID_str])) {
      $carID_Err = $Err_Required_Field;
      $isInsert = False;
    } else {
      $carID_data = test_input($_POST[$carID_str]);
    }

    if (empty($_POST[$type_str])) {
      $type_Err = $Err_Required_Field;
      $isInsert = False;
    } else {
      $type_data = test_input($_POST[$type_str]);
    }   

    if (empty($_POST[$model_str])) {
      $model_Err = $Err_Required_Field;
      $isInsert = False;
    } else {
      $model_data = test_input($_POST[$model_str]);
    }       

    if (empty($_POST[$price_str])) {
      $price_Err = $Err_Required_Field;
      $isInsert = False;
    } else if(!is_int(intval($_POST[$price_str])) or intval($_POST[$price_str]) < 0){
      $price_Err = "price must be positive!";
      $isInsert = False;
    } else {
      $price_data = test_input($_POST[$price_str]);
    }

   if (empty($_POST[$passengerCap_str])) {
      $passengerCap_Err = $Err_Required_Field;
      $isInsert = False;
    } else if(!is_int(intval($_POST[$passengerCap_str])) or intval($_POST[$passengerCap_str]) < 0){
      $passengerCap_Err = "passengerCap must be positive!";
      $isInsert = False;
    } else {
      $passengerCap_data = test_input($_POST[$passengerCap_str]);
    }

    if (empty($_POST[$brand_str])) {
      $brand_Err = $Err_Required_Field;
      $isInsert = False;
    } else {
      $brand_data = test_input($_POST[$brand_str]);
    }  
}

if($isInsert){

  $sql = "SELECT carID  FROM car where carID='$carID_data'";
  $result = mysqli_query($con, $sql);
  $insertCar = "INSERT INTO car (carID, brand, type, model, price, passengerCap)
      VALUES ('$carID_data', '$brand_data','$type_data', '$model_data', '$price_data', '$passengerCap_data')";

  if (mysqli_num_rows($result) > 0) {
    $carID_Err = "your carID has been registered";
  } else {
    if ( $con->query($insertCar) === TRUE) {
      $feedback = "New record created successfully";
      $carID_data = $type_data = $model_data = $price_data = $passengerCap_data = $brand_data ='';

    } else {
      $feedback = "Error: " . $insertCar . "<br>" . $con->error;
    }
  } 
}


// query 

$query = "SELECT * FROM car";
$queryResult = mysqli_query($con, $query);








?>
<body>
<?php include 'navigation.php'; ?>
 <div class="container mainBody">
     <div class="page-header" id="banner">
      <h1>Add a new car<small>&nbsp<?php echo $feedback;?></small></h1>
        <form method="post" class="form-horizontal">
          <br>
          <div class="form-group">
            <label for="carID" class="col-lg-2 control-label">Car ID*</label>
            <div class="col-lg-6">
              <input type="carID" name="carID" class="form-control" id="carID" value="<?php echo $carID_data;?>"  placeholder="unique CarID">
            </div>
            <div class = "col-lg-4">
                <span class="text-danger"><?php echo $carID_Err;?></span>
            </div>
          </div>

          <div class="form-group">
            <label for="brand" class="col-lg-2 control-label">Brand</label>
            <div class="col-lg-6">
              <select type="text" name="brand" class="form-control" id="type" value="<?php echo $brand_data;?>" >
                <?php
                  for($x=0;$x<count($brand_set);$x++) {
                  echo "<option value=$brand_set[$x]>" . $brand_set[$x] . "</option>"; 
                }
                ?>
              </select>
              
            </div>
            <div class = "col-lg-4">
                <span class="text-danger"><?php echo $brand_Err;?></span>
            </div>
          </div>

          <div class="form-group">
            <label for="type" class="col-lg-2 control-label">Type*</label>
            <div class="col-lg-6">
              <select type="text" name="type" class="form-control" id="type" value="<?php echo $type_data;?>" >
                <?php
                  for($x=0;$x<count($type_set);$x++) {
                  echo "<option value=$type_set[$x]>" . $type_set[$x] . "</option>"; 
                }
                ?>
              </select>
            </div>
            <div class = "col-lg-4">
                <span class="text-danger"><?php echo $type_Err;?></span>
            </div>
          </div>

          <div class="form-group">
            <label for="model" class="col-lg-2 control-label">Model*</label>
            <div class="col-lg-6">
              <input type="text" name="model" class="form-control" id="model" value="<?php echo $model_data;?>" placeholder="model">
            </div>
            <div class = "col-lg-4">
                <span class="text-danger"><?php echo $model_Err;?></span>
            </div>
          </div>

          <div class="form-group">
            <label for="price" class="col-lg-2 control-label">Price*</label>
            <div class="col-lg-6">
              <input type="number" name="price" class="form-control" id="price" value="<?php echo $price_data;?>"  placeholder="Singapore dollar">
            </div>
            <div class = "col-lg-4">
                <span class="text-danger"><?php echo $price_Err;?></span>
            </div>
          </div>

          

          <div class="form-group">
            <label for="passengerCap" class="col-lg-2 control-label">Passenger Capacity*</label>
            <div class="col-lg-6">
              <input type="number" name="passengerCap" class="form-control" id="passengerCap" value="<?php echo $passengerCap_data;?>" placeholder="maximum number of people">
            </div>
            <div class = "col-lg-4">
                <span class="text-danger"><?php echo $passengerCap_Err;?></span>
            </div>
          </div>

        
          <div class="form-group">
            <div class="col-lg-10 col-lg-offset-2">
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>
          </div>

        </form>
     </div>


<div class="page-header" id="banner">
      
  <div class="tab-pane fade in active" id="Open">
    <!-- Open Gig -->  
    <div class="panel  panel-default panel-primary">
      <!-- Default panel contents -->
      <div class="panel-heading"><h2>Current Car List</h2></div>
      <div class="panel-body">
      </div>

      <!-- Table -->
      <!-- open gigs -->
      <div class="table-responsive">
        <table class='table table-hover' border="0">
          <tr>
            <th>Car ID</th>
            <th>Brand</th>
            <th>Type($)</th>
            <th>Model</th>
            <th>Price</th>
            <th>Capacity</th>
            <th>Action</th>
          </tr>
         
          
            <?php
            if (mysqli_num_rows($queryResult) > 0) {
            // output data of each row
              while($row = mysqli_fetch_assoc($queryResult)) {
                echo "<tr>";
                echo "<td>".$row[$carID_str]."</td>";
                echo "<td>".$row[$brand_str]."</td>";
                echo "<td>".$row[$type_str]."</td>";
                echo "<td>".$row[$model_str]."</td>";
                echo "<td>".$row[$price_str]."</td>";
                echo "<td>".$row[$passengerCap_str]."</td>";

                echo "<td><a href=''><button class='btn btn-primary btn-sm col-xs-offset-1 col-sm-4'>edit</button></a>";
                echo "<a href=''><button class='btn btn-primary btn-sm col-xs-offset-1 col-sm-4'>delete</button></a></td>";

                echo "</tr>";
                
              }
            } else {
              echo "<tr><td colspan='7'><h4> No Cars Avaliable</h4></td></tr>";
            }
          ?>
        
        </table>
        </div>
    </div>
  </div>    
</div>   
 

    </div><!--body part-->


</div>





</body>


</html>

