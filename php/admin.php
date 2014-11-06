<?php 
  require('cookie.php');

 ?>
        
<!DOCTYPE html>
<!-- saved from url=(0029)http://bootswatch.com/united/ -->
<html lang="en">
<?php require 'head.php'; ?>

<body>
<?php include 'navigation.php'; ?>



<div class='container mainBody' >
  <div class='row col-xs-offset-0'>
    <div class='col-sm-4'>
      <a href="admin_booking.php">
        <button class='btn btn-info btn-lg  btn-block'>
          <p><span class="glyphicon actionIcon glyphicon-list-alt"></span></p>
          <p>Booking</p>
        </button>
      </a>
    </div>

    <div class='col-sm-4'>
      <a href="admin_car.php">
        <button class='btn btn-success btn-lg btn-block '>
          <p><span class="glyphicon actionIcon  glyphicon-road "></span></p>
          <p>Car Model</p>
        </button>
      </a>
    </div>

    <div class='col-sm-4'>
      <a href='admin_copy.php'>
        <button class='btn btn-lg btn-danger  btn-block'>
          <p><span class="glyphicon actionIcon glyphicon-user"></span></p>
          <p>Car</p>
        </button>
      </a>
    </div>
  </div>
</div>
<?php include 'footer.php'; ?>  
</body>

</html>

