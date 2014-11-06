<?php 
require('cookie.php');

?>

<!DOCTYPE html>
<!-- saved from url=(0029)http://bootswatch.com/united/ -->

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

function test_input($data) {
 $data = trim($data);
 $data = stripslashes($data);
 $data = htmlspecialchars($data);
 return $data;
}

$feedback = '';
$action_str = 'action';
$getFieldEdit_str = 'edit';
$getFieldDelete_str = 'delete';
$isUpdate_str = 'isUpdate';

$carID_str = "carID";

$type_str = "type";
$type_set = array('Sedan', 'Luxury Sedan', 'Sports', 'Hatchback', 'SUV');

$model_str = "model"; 

$brand_str = "brand";
$brand_set = array('Volvo', 'BMW', 'Toyota');

$price_str = "price";
$passengerCap_str = "passengerCap";
$image_str ='image';
$imagePath_str = 'imagePath';

$carID_data = $type_data = $model_data = $price_data = $passengerCap_data = $brand_data = $image_data ='';
$imagePath_data = "../images/car/default.jpeg";
$carID_Err = $type_Err = $model_Err = $price_Err = $passengerCap_Err = $brand_Err = $image_Err ='';



$isInsert = False;
$isUpdate = False;
$isGet = False;


$Err_Required_Field = 'Required field!';

if ($_SERVER["REQUEST_METHOD"] == "GET") {

  if($_GET[$isUpdate_str] == "true"){
    $isUpdate = True;
  }

  if($_GET[$action_str] == $getFieldEdit_str){
    $carID_data = $_GET[$carID_str];
    $carQuery = "SELECT * FROM car WHERE carID = '$carID_data'";
    $carResult = mysqli_query($con, $carQuery);

    $row = mysqli_fetch_assoc($carResult);
    $carID_data = $row[$carID_str];
    $type_data = $row[$type_str];
    $model_data = $row[$model_str];
    $price_data = $row[$price_str];
    $passengerCap_data = $row[$passengerCap_str];
    $brand_data = $row[$brand_str];
    $imagePath_data = $row[$imagePath_str];

  } else if($_GET[$action_str] == $getFieldDelete_str){
    $carID_data = $_GET[$carID_str];
    $deleteCar = "DELETE FROM car WHERE carID = '$carID_data'";
    $carResult = mysqli_query($con, $deleteCar);
    $feedback = "car deleted successfully";
  }


} else if ($_SERVER["REQUEST_METHOD"] == "POST") {

  if($_POST[$isUpdate_str] == 'true'){
    
    $isUpdate = true;
  }
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
  } else if(!is_int(intval($_POST[$price_str])) or intval($_POST[$price_str]) <= 0){
    $price_Err = "price must be positive!";
    $isInsert = False;
  } else {
    $price_data = test_input($_POST[$price_str]);
  }

  if (empty($_POST[$passengerCap_str])) {
    $passengerCap_Err = $Err_Required_Field;
    $isInsert = False;
  } else if(!is_int(intval($_POST[$passengerCap_str])) or intval($_POST[$passengerCap_str]) <= 0){
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

  if($isInsert){
    $target_dir = "../images/car/";
    $target_file = $target_dir . basename($_FILES[$image_str]["name"]);
    $uploadOk = 1;
    $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
    $target_file = $target_dir . $carID_data ."." .$imageFileType; 
    $imagePath_data = $target_file;
    
// Check if image file is a actual image or fake image
    if(isset($_POST["submit"])) {
      $check = getimagesize($_FILES[$image_str]["tmp_name"]);
      if($check !== false) {
        $image_Err = "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
      } else {
        $image_Err = "File is not an image.";
        $uploadOk = 0;
      }
    }
// Check if file already exists

// Check file size
    if ($_FILES[$image_str]["size"] > 500000) {
      $image_Err = "Sorry, your file is too large.";
      $uploadOk = 0;
    }
// Allow certain file formats
    
    if($imageFileType != "jpg" && $imageFileType != "JPG" && $imageFileType != "PNG" && $imageFileType != "png" 
      && $imageFileType != "JPEG" && $imageFileType != "jpeg") {
      $image_Err = "Sorry, only JPG, JPEG & PNG   files are allowed.";
      $uploadOk = 0;
    }
// Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0 ) {
      if(!$isUpdate) {
        $isInsert = false;
        $imagePath_data = "../images/car/default.jpeg"; 
      } else {
        $carQuery = "SELECT imagePath FROM car WHERE carID = '$carID_data'";
        $carResult = mysqli_query($con, $carQuery);
        $row = mysqli_fetch_assoc($carResult);
        $imagePath_data = $row[$imagePath_str];
      }
      
// if everything is ok, try to upload file
    } 
  }
}

if($isInsert){
  $sql = "SELECT carID  FROM car where carID='$carID_data'";
  $result = mysqli_query($con, $sql);

  if(!$isUpdate) {

    $insertCar = "INSERT INTO car (carID, brand, type, model, price, passengerCap, imagePath)
    VALUES ('$carID_data', '$brand_data','$type_data', '$model_data', '$price_data', '$passengerCap_data', '$imagePath_data')";

    if (mysqli_num_rows($result) > 0) {
      $carID_Err = "your carID has been registered";
    } else {
      if (move_uploaded_file($_FILES[$image_str]["tmp_name"], $target_file)) {
        $image_Err =  "The file ". basename( $_FILES[$image_str]["name"]). " has been uploaded.";
        if ( $con->query($insertCar) === TRUE) {
          $feedback = "New record created successfully";
          $carID_data = $type_data = $model_data = $price_data = $passengerCap_data = $brand_data ='';
        } else {  
          $feedback = "Error: " . $insertCar . "<br>" . $con->error;
        }
      } 
    }  
  } else {

    $updateCar = "UPDATE car SET brand='$brand_data', model='$model_data', price='$price_data', imagePath='$imagePath_data', " .
    "passengerCap='$passengerCap_data', type='$type_data'  WHERE carID='$carID_data' ";
    if (move_uploaded_file($_FILES[$image_str]["tmp_name"], $target_file)) {
        $image_Err =  "The file ". basename( $_FILES[$image_str]["name"]). " has been uploaded.";
        if ( $con->query($updateCar) === TRUE) {
          $feedback = "New record updated successfully";
        } else {  
          $feedback = "Error: " . $updateCar . "<br>" . $con->error;
        }
    }  
  }


}


// query 

$query = "SELECT * FROM car";
$carListResult = mysqli_query($con, $query);





?>
<body>
  <?php include 'navigation.php'; ?>
  <div class="container mainBody">
   <div class="page-header" id="banner">
    <h1>Car Info<small>&nbsp<?php echo $feedback;?></small></h1>
    <form method="post" enctype="multipart/form-data"  class="form-horizontal">
      <br>
      <div class="form-group">
        <label for="carID" class="col-lg-2 control-label">Car ID*</label>
        <div class="col-lg-6">
          <input type="carID" name="carID" class="form-control"
          <?php 
          if($isUpdate){
            echo "readonly";
          }
          ?>
          id="carID" value="<?php echo $carID_data;?>"  placeholder="unique CarID">
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
              echo "<option value='$brand_set[$x]' ";
              if($brand_set[$x] == $brand_data) {
                echo "selected='selected'";
              }
              echo ">" . $brand_set[$x] . "</option>"; 
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
              echo "<option value='$type_set[$x]' ";
              if($type_set[$x] == $type_data) {
                echo "selected='selected'";
              }
              echo ">" . $type_set[$x] . "</option>"; 

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
        <label for="image" class="col-lg-2 control-label">Image</label>
        <div class="col-lg-6">
          <img id="image" src="<?php echo $imagePath_data;?>">
          <input type="file" size="32" name="image" value="<?php echo $image_data;?>">
        </div>
        <div class = "col-lg-4">
          <span class="text-danger"><?php echo $image_Err;?></span>
        </div>
      </div>    

      <!-- hide class for submit isUpdate -->
      <input type="hidden" name='isUpdate' value= 
      <?php
      if($isUpdate){
        echo 'true';
      } else {
        echo 'false';
      }
      ?>
      >

      <div class="form-group">
        <div class="col-lg-10 col-lg-offset-2">
          <button type="submit" class="btn btn-primary">
            <?php
            if($isUpdate){
              echo "update";
            } else {
              echo "submit";
            }
            ?>
          </button>
        </div>
      </div>

    </form>
  </div>


  <div class="page-header" id="banner">

    <div class="tab-pane fade in active" id="Open">
      <!-- Open Gig -->  
      <div class="panel  panel-default panel-primary">
        <!-- Default panel contents -->
        <div class="panel-heading"><h2>Current Car List</h2>
        <a href="admin_car.php"><button class='btn btn-success'>Add a new Car</button></a>
        </div>
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
            if (mysqli_num_rows($carListResult) > 0) {
            // output data of each row
              while($row = mysqli_fetch_assoc($carListResult)) {
                echo "<tr>";
                echo "<td>".$row[$carID_str]."</td>";
                echo "<td>".$row[$brand_str]."</td>";
                echo "<td>".$row[$type_str]."</td>";
                echo "<td>".$row[$model_str]."</td>";
                echo "<td>".$row[$price_str]."</td>";
                echo "<td>".$row[$passengerCap_str]."</td>";

                echo "<td><a href='?isUpdate=true&action=edit&carID=". $row[$carID_str] .
                "'><button class='btn btn-primary btn-sm col-xs-offset-1 col-sm-4'>edit</button></a>";
                echo "<a href='?action=delete&carID=". $row[$carID_str] .
                "'><button class='btn btn-primary btn-sm col-xs-offset-1 col-sm-4'>delete</button></a></td>";

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

