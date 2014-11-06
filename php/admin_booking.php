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
$getFieldEdit_str = 'edit';
$getFieldDelete_str = 'delete';


$isUpdate_str = 'isUpdate';
$carID_str = "carID";
$allCarID_query = "SELECT carID FROM car";
$allCarID_result = mysqli_query($con, $allCarID_query);

$carID_set = array();
while(($row =  mysqli_fetch_assoc($allCarID_result))) {
  $carID_set[] = $row[$carID_str];
}

$copyNum_str = "copyNum";
$userEmail_str = "userEmail";
$bookingTime_str = "bookingTime";
$collectDate_str = "collectDate";
$returnDate_str = "returnDate";
$cost_str = "cost";

$allCarID_query = "SELECT carID FROM car";
$allCarID_result = mysqli_query($con, $allCarID_query);
$carID_set = array();
while(($row =  mysqli_fetch_assoc($allCarID_result))) {
  $carID_set[] = $row[$carID_str];
}

$allCarCopy_query = "Select carID, copyNum FROM copy";
$allCarCopy_result = mysqli_query($con, $allCarCopy_query);
$carCopy_set = array();
while(($row =  mysqli_fetch_assoc($allCarCopy_result))) {
  $carCopy_set[] = array($row[$carID_str], $row[$copyNum_str]);
}

$allUserEmail_query = "Select email From User";
$allUserEmail_result = mysqli_query($con, $allUserEmail_query);
$userEmail_set = array();
while(($row =  mysqli_fetch_assoc($allUserEmail_result))) {
  $userEmail_set[] = $row["email"];
}




$carID_data = $copyNum_data = $userEmail_data = $bookingTime_data = $collectDate_data = $returnDate_data = $cost_data = '';
$carID_Err = $copyNum_Err = $userEmail_Err = $bookingTime_Err = $collectDate_err = $returnDate_err = $cost_err = '';

$isInsert = False;
$isUpdate = False;
$isGet = False;
$isOverwrite = false;

$Err_Required_Field = 'Required field!';

if ($_SERVER["REQUEST_METHOD"] == "GET") {

  if($_GET[$isUpdate_str] == "true"){
    $isUpdate = True;
  }

  if($_GET[$action_str] == $getFieldEdit_str){
    $carID_data = $_GET[$carID_str];
    $copyNum_data = $_GET[$copyNum_str];
    $userEmail_data = $_GET[$userEmail_str];
    $bookingTime_data = $_GET[$bookingTime_str];
    

    $bookingQuery = "SELECT * FROM booking ".
    " WHERE carID = '$carID_data' AND copyNum = '$copyNum_data' AND userEmail = '$userEmail_data' AND bookingTime='$bookingTime_data'
    ";
    $bookingResult = mysqli_query($con, $bookingQuery);

    $row = mysqli_fetch_assoc($bookingResult);

    $carID_data = $row[$carID_str];
    $copyNum_data = $row[$copyNum_str];
    $bookingTime_data = $row[$bookingTime_str];
    $userEmail_data = $row[$userEmail_str];
    $collectDate_data = $row[$collectDate_str];
    $returnDate_data = $row[$returnDate_str];
    $cost_data = $row[$cost_str];


  } else if($_GET[$action_str] == $getFieldDelete_str){
    $carID_data = $_GET[$carID_str];
    $copyNum_data = $_GET[$copyNum_str];
    $bookingTime_data = $_GET[$bookingTime_str];
    $userEmail_data = $_GET[$userEmail_str];

    $deleteBooking = "DELETE FROM booking" .
    " WHERE carID = '$carID_data' AND copyNum = '$copyNum_data' AND userEmail = '$userEmail_data' AND bookingTime='$bookingTime_data'";
    $carResult = mysqli_query($con, $deleteBooking);
    $feedback = "booking deleted successfully";
  }


} else if ($_SERVER["REQUEST_METHOD"] == "POST") {

  if($_POST[$isUpdate_str] == 'true'){
    $isOverwrite  = true;
    $isUpdate = true;
  }
  $isInsert = TRUE;
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


  if (empty($_POST[$bookingTime_str])) {
    $bookingTime_Err = $Err_Required_Field;
    $isInsert = False;
  } else {
    $bookingTime_data = test_input($_POST[$bookingTime_str]);
  } 


  if (empty($_POST[$userEmail_str])) {
    $userEmail_Err = $Err_Required_Field;
    $isInsert = False;
  } else {
    $userEmail_data = test_input($_POST[$userEmail_str]);
  } 


  if (empty($_POST[$collectDate_str])) {
    $collectDate_Err = $Err_Required_Field;
    $isInsert = False;
  } else {
    $collectDate_data = test_input($_POST[$collectDate_str]);
  } 


  if (empty($_POST[$returnDate_str])) {
    $returnDate_Err = $Err_Required_Field;
    $isInsert = False;
  } else {
    $returnDate_data = test_input($_POST[$returnDate_str]);
  } 


  if (empty($_POST[$cost_str])) {
    $cost_Err = $Err_Required_Field;
    $isInsert = False;
  } else if(!is_int(intval($_POST[$cost_str])) or intval($_POST[$cost_str]) < 0){
    $cost_Err = "cost must be positive";
    $isInsert = False;
  }else {
    $cost_data = test_input($_POST[$cost_str]);
  } 





}

if($isInsert){
  $sql = "SELECT carID FROM booking WHERE 
  carID = '$carID_data' AND copyNum = '$copyNum_data' AND userEmail = '$userEmail_data' AND bookingTime='$bookingTime_data'";
  $result = mysqli_query($con, $sql);

  if(!$isOverwrite) {

    $insertBooking = "INSERT INTO booking (carID, copyNum, bookingTime, userEmail, collectDate, returnDate, cost)
    VALUES ('$carID_data','$copyNum_data', '$bookingTime_data', '$userEmail_data', '$collectDate_data', '$returnDate_data', '$cost_data')";

    if (mysqli_num_rows($result) > 0) {
      $feedback = "This booking has already existed";
    } else {
      if ( $con->query($insertBooking) === TRUE) {
        $feedback = "New record created successfully";
        $carID_data = $copyNum_data = $bookingTime_data = $userEmail_data ='';
      } else {  
        $feedback = "Error: " . $insertBooking . "<br>" . $con->error;
      }
    } 
  } else {

   
      $updateBooking = "UPDATE booking SET collectDate='$collectDate_data', returnDate='$returnDate_data', cost = '$cost_data'".
      "WHERE carID = '$carID_data' AND copyNum = '$copyNum_data' AND userEmail = '$userEmail_data' AND bookingTime='$bookingTime_data'";
      if ( $con->query($updateBooking) === TRUE) {
        $feedback = "New record updated successfully";
      } else {  
        $feedback = "Error: " . $updateBooking . "<br>" . $con->error;
      }
    
    
  }
}
// query 

$query = "SELECT * FROM booking";
$bookingListResult = mysqli_query($con, $query);


?>


<body>

  <?php include 'navigation.php'; ?>

  <div class="container ">
   <div class="page-header" id="banner">
    <h1>Car Copy Info<small>&nbsp<?php echo $feedback;?></small></h1>
    <form method="post" class="form-horizontal">
      <br>
      <div class="form-group">
        <label for="carID" class="col-lg-2 control-label">Car ID*</label>
        <div class="col-lg-6 ">
          <select 
          <?php 
          if($isUpdate){
            echo "disabled";
          }
          ?>
          type="text" name="carID" class="form-control" id="carID" >
          <?php
          for($x=0;$x<count($carID_set);$x++) {

            echo "<option value='$carID_set[$x]' ";
            if($carID_set[$x] == $carID_data) {
              echo "selected='selected'";
            }
            echo ">" . $carID_set[$x] . "</option>"; 
          }
          ?>
        </select>
        <?php 
        if($isUpdate){
          echo "<input type='hidden' name='carID' value=". $carID_data  . ">";
        }
        ?>

      </div>
      <div class = "col-lg-4">
        <span class="text-danger"><?php echo $carID_Err;?></span>
      </div>
    </div>

    <div class="form-group">
      <label for="copyNum" class="col-lg-2 control-label">Copy Number*</label>
      <div class="col-lg-6 id=""">
        <select id="copyNum"
        <?php 
        if($isUpdate){
          echo "disabled";
        }
        ?>
        type="text" name="copyNum" class="form-control"  >
        <?php 
        if(!empty($copyNum_data)){
          echo "<option value='$copyNum_data' selected='selected'>". $copyNum_data ."</option>";
        }
        ?>
      </select>
      <?php 
      if($isUpdate){
        echo "<input type='hidden' name='copyNum' value=". $copyNum_data  . ">";
      }
      ?>

    </div>
    <div class = "col-lg-4">
      <span class="text-danger"><?php echo $copyNum_Err;?></span>
    </div>
  </div>







  <div class="form-group">
    <label for="userEmail" class="col-lg-2 control-label">User email*</label>
    <div class="col-lg-6 ">
      <select 
      <?php 
      if($isUpdate){
        echo "disabled";
      }
      ?>
      type="text" name="userEmail" class="form-control" id="userEmail" >
      <?php
      for($x=0;$x<count($userEmail_set);$x++) {

        echo "<option value='$userEmail_set[$x]' ";
        if($userEmail_set[$x] == $userEmail_data) {
          echo "selected='selected'";
        }
        echo ">" . $userEmail_set[$x] . "</option>"; 
      }
      ?>
    </select>
    <?php 
    if($isUpdate){
      echo "<input type='hidden' name='userEmail' value=". $userEmail_data  . ">";
    }
    ?>

  </div>
  <div class = "col-lg-4">
    <span class="text-danger"><?php echo $carID_Err;?></span>
  </div>
</div>

<div class="form-group">
  <label for="bookingTime" class="col-lg-2 control-label">Booking Time</label>
  <div class=" col-lg-6">
    <input name="bookingTime"
    <?php 
    if($isUpdate){
      echo "readonly";
    }
    ?>
    value="<?php echo $bookingTime_data;?>" placeholder="Select Time" class="form-control"  id='bookingTime'>
  </div>
  <div class = "col-lg-4">
    <span class="text-danger"><?php echo $bookingTime_Err;?></span>
  </div>
</div>

<div class="form-group">
  <label for="collectDate" class="col-lg-2 control-label">Collect Date</label>
  <div class=" col-lg-6">
    <input name="collectDate"  value="<?php echo $collectDate_data;?>" placeholder="Select Date" class="form-control" data-date-format="YYYY-MM-DD" id='collectDate'>
  </div>
  <div class = "col-lg-4">
    <span class="text-danger"><?php echo $collectDate_Err;?></span>
  </div>
</div>

<div class="form-group">
  <label for="returnDate" class="col-lg-2 control-label">Return Date</label>
  <div class=" col-lg-6">
    <input name="returnDate"  value="<?php echo $returnDate_data;?>" placeholder="Select Date" class="form-control" data-date-format="YYYY-MM-DD" id='returnDate'>
  </div>
  <div class = "col-lg-4">
    <span class="text-danger"><?php echo $returnDate_Err;?></span>
  </div>
</div>

<div class="form-group">
  <label for="cost" class="col-lg-2 control-label">Cost*</label>
  <div class="col-lg-6"> 
    <input type="number" name="cost" class="form-control" id="cost" value="<?php echo $cost_data;?>" >

  </div>
  <div class = "col-lg-4">
    <span class="text-danger"><?php echo $cost_Err;?></span>
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
      <div class="panel-heading"><h2>Current Car Copy List</h2></div>
      <div class="panel-body">
      </div>

      <!-- Table -->
      <!-- open gigs -->
      <div class="table-responsive">
        <table class='table table-hover' border="0">
          <tr>
            <th>Car ID</th>
            <th>Copy Number</th>
            <th>User Email</th>
            <th>Booking Time</th>
            <th>Collect Day</th>
            <th>Return Day</th>
            <th>Cost</th>
          </tr>

          
          <?php
          if (mysqli_num_rows($bookingListResult) > 0) {
            // output data of each row
            while($row = mysqli_fetch_assoc($bookingListResult)) {
              echo "<tr>";
              echo "<td>".$row[$carID_str]."</td>";
              echo "<td>".$row[$copyNum_str]."</td>";
              echo "<td>".$row[$userEmail_str]."</td>";
              echo "<td>".$row[$bookingTime_str]."</td>";
              echo "<td>".$row[$collectDate_str]."</td>";
              echo "<td>".$row[$returnDate_str]."</td>";
              echo "<td>".$row[$cost_str]."</td>";



              echo "<td><a href='?isUpdate=true&action=edit&carID=". $row[$carID_str] . "&copyNum=". $row[$copyNum_str].
              "&userEmail=" . $row[$userEmail_str] . "&bookingTime=" . $row[$bookingTime_str] .
              "'><button class='btn btn-primary btn-sm col-xs-offset-1 col-sm-4'>edit</button></a>";
              echo "<a href='?action=delete&carID=". $row[$carID_str] . "&copyNum=". $row[$copyNum_str].
              "&userEmail=" . $row[$userEmail_str] . "&bookingTime=" . $row[$bookingTime_str] .
              "'><button class='btn btn-primary btn-sm col-xs-offset-1 col-sm-4'>delete</button></a></td>";

              echo "</tr>";

            }
          } else {
            echo "<tr><td colspan='7'><h4> No Car Copy bookingTime</h4></td></tr>";
          }
          ?>

        </table>
      </div>
    </div>
  </div>    
</div>   


</div><!--body part-->



<?php include 'footer.php'; ?> 
<script type="text/javascript">
$(function() {
  $('#copyNum').empty();
  var allCopyPair = <?php echo json_encode($carCopy_set); ?>;
  var selectedCarID = $('#carID').val();
  var selectedCopyNum = <?php echo json_encode($copyNum_data); ?>;

  for(i=0; i<allCopyPair.length; i++){

    if(selectedCarID == allCopyPair[i][0]){
      var value = allCopyPair[i][1];
      if(selectedCopyNum && selectedCopyNum==value){
        $('#copyNum').append("<option value=" + value + " selected=selected>" + value + "</option>");
      } else {
        $('#copyNum').append("<option value=" + value + ">" + value + "</option>");
      }
      
    }
  }

});

$('#carID').change(function() {
  $('#copyNum').empty();
  var allCopyPair = <?php echo json_encode($carCopy_set); ?>;
  var selectedCarID = $(this).val();
  var selectedCopyNum = <?php echo json_encode($copyNum_data); ?>;
  for(i=0; i<allCopyPair.length; i++){

    if(selectedCarID == allCopyPair[i][0]){
      var value = allCopyPair[i][1];
      if(selectedCopyNum && selectedCopyNum==value){
        $('#copyNum').append("<option value=" + value + " selected=selected>" + value + "</option>");
      } else {
        $('#copyNum').append("<option value=" + value + ">" + value + "</option>");
      }
      
    }
  }

});

</script> 
<script type="text/javascript">

$(function(){

  $('#bookingTime').datetimepicker({
    format: 'YY-MM-DD hh:mm:ss',
    pickDate: true,
    pickTime: true,
    useMinutes: true,
    useSeconds: true,
    useCurrent: true,
    pick12HourFormat: false,
  });
  $('#bookingTime').datetimepicker();

  $('#collectDate').datetimepicker({
    pickTime: false
  });
  $('#returnDate').datetimepicker({
    pickTime: false
  });      

  $('#collectDate').datetimepicker();
  $('#returnDate').datetimepicker();
  $("#collectDate").on("dp.change",function (e) {
   $('#returnDate').data("DateTimePicker").setMinDate(e.date);
 });
  $("#returnDate").on("dp.change",function (e) {
   $('#collectDate').data("DateTimePicker").setMaxDate(e.date);
 });




});
</script>

</body>


</html>

