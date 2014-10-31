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

$d=mktime(2, 3, 2014);
echo "Created date is " . date("Y-m-d", $d);


        require('car_mysql.php');
        $sql = "SELECT * FROM car, copy ORDER BY startDateOfService";  
        $result = mysqli_query($con, $sql);
        if(mysqli_num_rows($result) > 0){
          while ($row = mysqli_fetch_assoc($result))   {
            echo "carID:".$row["carID"];
            echo " ";
            echo "price:".$row["price"];
            echo " ";
            echo "passengerCap:".$row["passengerCap"];
            echo " ";
            echo "copyNum:".$row["copyNum"];
            echo " ";
            echo "startDateOfService:".$row["startDateOfService"];
            echo " ";
            echo "brand:".$row["brand"]."<br>";
          }
        } else {
          echo "0 result";
        }
      ?>

          <form action="carlist.php"  method="post">


                <div class="form-group">
                  <label for="datePicker1" class="col-sm-3 control-label">Check in Date</label>
                  <div class="input-group col-sm-5">
                    <input name="event_date" type="text" placeholder="Select Date" class="form-control required" data-date-format="YYYY-MM-DD" id='datePicker1'/>
                    <span class="input-group-addon">
                      <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                  </div>
                </div>

                <div class="form-group">
                  <label for="datePicker2" class="col-sm-3 control-label">Check out Date</label>
                  <div class="input-group col-sm-5">
                    <input name="event_date" type="text" placeholder="Select Date" class="form-control required" data-date-format="YYYY-MM-DD" id='datePicker2'/>
                    <span class="input-group-addon">
                      <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                  </div>
                </div>

            <button type="submit" value="submit" class="btn btn-primary">Submit</button>
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