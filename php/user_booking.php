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
$carID_data = $copyNum_data = $userEmail_data = $bookingTime_data = $collectDate_data = $returnDate_data = $cost_data = '';
$carID_Err = $copyNum_Err = $userEmail_Err = $bookingTime_Err = $collectDate_err = $returnDate_err = $cost_err = '';




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


$copyNum_str = "copyNum";
$userEmail_str = "userEmail";
$bookingTime_str = "bookingTime";
$collectDate_str = "collectDate";
$returnDate_str = "returnDate";
$cost_str = "cost";


$cookie_name = "userEmail";
if(isset($_COOKIE[$cookie_name])){
  $isLogin = TRUE;
  $currentUserEmail = $_COOKIE[$cookie_name];
} else {
  $isLogin = False;
}  


$isInsert = False;
$isGet = False;


$Err_Required_Field = 'Required field!';

if ($_SERVER["REQUEST_METHOD"] == "GET") {


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

  $updateBooking = "UPDATE booking SET collectDate='$collectDate_data', returnDate='$returnDate_data' 
  WHERE carID = '$carID_data' AND copyNum = '$copyNum_data' AND userEmail = '$userEmail_data' AND bookingTime='$bookingTime_data'";
  if ( $con->query($updateBooking) === TRUE) {
    $feedback = "Booking Info updated successfully";
    // $carID_data = $copyNum_data = $userEmail_data = $bookingTime_data = $collectDate_data = $returnDate_data = $cost_data = '';
  } else {  
    $feedback = "Error: " . $updateBooking . "<br>" . $con->error;
  }


}
// query 
$query = "SELECT * FROM booking where userEmail = '$currentUserEmail' ";
$bookingListResult = mysqli_query($con, $query);



?>


<body>

  <?php include 'navigation.php'; ?>

  <br>
  <br>

  <div class="container ">



   <div class="page-header" id="banner">
    <h1>Booking Info<small>&nbsp<?php echo $feedback;?></small></h1>
    <form method="post" class="form-horizontal">
      <br>
      <div class="form-group">
        <label for="carID" class="col-lg-2 control-label">Car ID*</label>
        <div class="col-lg-6 ">
          <input readonly type="text" name="carID" class="form-control" id="carID" value="<?php echo $carID_data; ?>" >
        </div>
        <div class = "col-lg-4">
          <span class="text-danger"><?php echo $carID_Err;?></span>
        </div>
      </div>

      <div class="form-group">
        <label for="copyNum" class="col-lg-2 control-label">Copy Num*</label>
        <div class="col-lg-6 ">
          <input readonly type="text" name="copyNum" class="form-control" id="copyNum" value="<?php echo $copyNum_data; ?>" >
        </div>
        <div class = "col-lg-4">
          <span class="text-danger"><?php echo $copyNum_Err;?></span>
        </div>
      </div>


        
        
      <input  type="hidden" name="userEmail" class="form-control" id="userEmail" value="<?php echo $userEmail_data; ?>" >
        


      <div class="form-group">
        <label for="bookingTime" class="col-lg-2 control-label">Booking Time*</label>
        <div class="col-lg-6 ">
          <input readonly type="text" name="bookingTime" class="form-control" id="bookingTime" value="<?php echo $bookingTime_data; ?>" >
        </div>
        <div class = "col-lg-4">
          <span class="text-danger"><?php echo $bookingTime_Err;?></span>
        </div>
      </div>

      <div class="form-group">
        <label for="cost" class="col-lg-2 control-label">Cost($)</label>
        <div class="col-lg-6"> 
          <input readonly type="number" name="cost" class="form-control" id="cost" value="<?php echo $cost_data;?>" >

        </div>
        <div class = "col-lg-4">
          <span class="text-danger"><?php echo $cost_Err;?></span>
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
        <div class="col-lg-10 col-lg-offset-2">
          <button type="submit" class="btn btn-primary">Update</button>
        </div>
      </div>

    </form>
  </div>

  <div class="page-header" id="banner">

    <div class="tab-pane fade in active" id="Open">
      <!-- Open Gig -->  
      <div class="panel  panel-default panel-primary">
        <!-- Default panel contents -->
        <div class="panel-heading"><h2>My List of Booking</h2></div>
        <div class="panel-body">
        </div>
        <!-- Table -->
        <!-- open gigs -->
        <div class="table-responsive">
          <table class='table table-hover' border="0">
            <tr>
              <th>Car ID</th>
              <th>Copy Number</th>
              <th>Booking Time</th>
              <th>Collect Day</th>
              <th>Return Day</th>
              <th>Cost</th>
              <th>Action</th>
            </tr>


            <?php
            if (mysqli_num_rows($bookingListResult) > 0) {
            // output data of each row
              while($row = mysqli_fetch_assoc($bookingListResult)) {
                echo "<tr>";
                echo "<td>".$row[$carID_str]."</td>";
                echo "<td>".$row[$copyNum_str]."</td>";
                echo "<td>".$row[$bookingTime_str]."</td>";
                echo "<td>".$row[$collectDate_str]."</td>";
                echo "<td>".$row[$returnDate_str]."</td>";
                echo "<td>".$row[$cost_str]."</td>";



                echo "<td><a href='?action=edit&carID=". $row[$carID_str] . "&copyNum=". $row[$copyNum_str].
                "&userEmail=" . $row[$userEmail_str] . "&bookingTime=" . $row[$bookingTime_str] .
                "'><button class='btn btn-primary btn-sm col-xs-offset-1 col-sm-3'>edit</button></a>";
                echo "<a href='?action=delete&carID=". $row[$carID_str] . "&copyNum=". $row[$copyNum_str].
                "&userEmail=" . $row[$userEmail_str] . "&bookingTime=" . $row[$bookingTime_str] .
                "'><button class='btn btn-primary btn-sm col-xs-offset-1 col-sm-3'>delete</button></a>";
                echo "<a href='homepage_copy?carID=". $row[$carID_str] . "&copyNum=". $row[$copyNum_str].
                "'><button class='btn btn-primary btn-sm col-xs-offset-1 col-sm-3'>detail</button></a></td>";
                echo "</tr>";

              }
            } else {
              echo "<tr><td colspan='7'><h4> No Booking Available Now</h4></td></tr>";
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

$(function(){

  

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

