<!DOCTYPE html>
<!-- saved from url=(0029)http://bootswatch.com/united/ -->
<html lang="en">
  <?php include 'head.php'; ?>
  <body>
    <?php include 'navigation.php'; ?>

    <!--search form in homepage-->
    <div class="container">
     <div class="page-header" id="banner">
        <form method="post" class="form-horizontal">
          <br>
          <div class="form-group">
            <label for="pickUpDate" class="col-lg-2 control-label">Email: </label>
            <div class="col-lg-6">
              <input type="text" name="pick_up_date" class="form-control" id="pickUpDate" placeholder="pick up date">
            </div>
          </div>

          <div class="form-group">
            <label for="returnDate" class="col-lg-2 control-label">Password: </label>
            <div class="col-lg-6">
              <input type="text" name="return_date" class="form-control" id="returnDate" placeholder="return date">
            </div>
          </div>
          
          <div class="form-group">
            <div class="col-lg-10 col-lg-offset-2">
              <button type="submit" class="btn btn-primary">Login</button>
            </div>
          </div>

        </form>
     </div>
    </div><!--body part-->
    
    <?php include 'footer.php'; ?>  
  </body>
</html>