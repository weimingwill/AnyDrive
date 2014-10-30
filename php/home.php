<!DOCTYPE html>
<!-- saved from url=(0029)http://bootswatch.com/united/ -->
<html lang="en">
  <?php include 'head.php'; ?>
  <body>
    <?php include 'navigation.php'; ?>
    <!--search form in homepage-->
    <div class="container">
     <div class="page page-container">
      <?php
        $email = "";
        $login = false;
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
          if(empty($_POST["email"])){
            echo "User has not login";
          } else {
            $email = test_input($_POST["email"]);
            $login = true;
            echo "Login successfully";
          }
        }

        function test_input($data) {
           $data = trim($data);
           $data = stripslashes($data);
           $data = htmlspecialchars($data);
           return $data;
         }

      ?>

        <form method="post" class="form-horizontal">
          
          <div class="form-group">
            <label for="datePicker1" class="col-sm-3 control-label">Pick up date</label>
            <div class="input-group col-sm-5">
              <input name="event_date" type="text" placeholder="Select Date" class="form-control required" data-date-format="YYYY-MM-DD" id='datePicker1'/>
              <span class="input-group-addon">
                <span class="glyphicon glyphicon-calendar"></span>
              </span>
            </div>
          </div>


          <div class="form-group">
            <label for="datePicker2" class="col-sm-3 control-label">return date</label>
            <div class="input-group col-sm-5">
              <input name="event_date" type="text" placeholder="Select Date" class="form-control required" data-date-format="YYYY-MM-DD" id='datePicker2'/>
              <span class="input-group-addon">
                <span class="glyphicon glyphicon-calendar"></span>
              </span>
            </div>
          </div>
    
          <div class="form-group">
            <div class="col-lg-10 col-lg-offset-2">
              <button type="submit" class="btn btn-primary">Search</button>
            </div>
          </div>

        </form>
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

    });
    </script>

  </body>
</html>