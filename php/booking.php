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

    $carId = $copyNum = $collectDate = $returnDate = "";
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
          //connect to database
      require('car_mysql.php');

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

      $sql = "SELECT * FROM car, copy WHERE available = 1 AND car.carID = copy.carID AND car.carID = '$carId' ";
      $result = mysqli_query($con, $sql);
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