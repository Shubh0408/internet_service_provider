<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include("databaseConnect.php");
if(isset($_POST['submit'],$_FILES['file']['tmp_name'])){
  /* print_r($_POST);die; */
    $branch_state=$_POST['branch_state'];
    $branch=$_POST['branch_name'];
    if ($_POST["service"] === "others") {
      $service = $_POST["service1"];
    }else {
      $service = $_POST["service"];
    }
    //$service=$_POST['service'];
    $account_id=$_POST['account_id'];
    $person_name=$_POST['person_name'];
    $person_number=$_POST['person_number'];
    $plan=$_POST['plan'];
    $speed=$_POST['speed'];
    $start=$_POST['start'];
    $end=$_POST['end'];
    $imgfile=$_FILES["file"]["name"];

  // get the image extension
  $extension = substr($imgfile,strlen($imgfile)-4,strlen($imgfile));
  // allowed extensions
  $allowed_extensions = array(".jpg","jpeg",".png",".gif",".pdf");
  // Validation for allowed extensions
  if(!in_array($extension,$allowed_extensions)){
  echo "<script>alert('Invalid format. Only jpg / jpeg/ png /gif format allowed');</script>";
  }else{
    //rename the image file
    $imgnewfile=md5($imgfile).$extension;  
    // Code for move image into directory
    move_uploaded_file($_FILES["file"]["tmp_name"],"uploads/".$imgnewfile);
    $sql_insert="INSERT INTO `provider_details`(`branch_state`,`branch_name`, `service`,`account_id`,`person_name`,`person_number`, `plan`,`speed`, `start`, `end`,`file`) VALUES ('$branch_state','$branch','$service','$account_id','$person_name','$person_number','$plan','$speed','$start','$end','$imgnewfile')";
    /* die; */
    $sql_conn=mysqli_query($conn,$sql_insert);
    //print_r($sql_conn);/* die; */
  }
}
?>
<html>
<head>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <style>
    body {
      background-color: #f2f2f2;
    }

    .container {
      margin-top: 50px;
    }
  </style>
  <script>
    $(document).ready(function(){
      $("#service").change(function(){
        var service_id = $(this).val();
        if(service_id != "others"){
          $("#others1").hide();
        } else {
          $("#others1").show();
        }
      });
      
      $("#state").change(function(){
        var state_id = $(this).val();
        $.ajax({
          url: "get_cities.php",
          method: "POST",
          data: {state_id: state_id},
          success: function(data) {
            $("#city").html(data);
          }
        });
      });
    });
  </script>
</head>
<body>
  <div class="container">
    <div id="list">
      <a class="btn btn-primary" href="./read.php" role="button">All Records</a>
      <a class="btn btn-primary" href="./dashboard.php" role="button">Dashboard</a>
      <a class="btn btn-primary" href="./insert_state.php" role="button">Add State</a>
      <a class="btn btn-primary" href="./insert_city.php" role="button">Add Branch</a>
    </div>
    <form action="index.php" method="POST" enctype="multipart/form-data">
      <div class="form-group">
        <label for="state">State:</label>
        <select id="state" class="form-control" name="branch_state">
          <option value="">Select State</option>
          <?php
            $sql = "SELECT id, state_name FROM branch_state";
            $result = mysqli_query($conn, $sql);

            while ($row = mysqli_fetch_assoc($result)) {
              echo '<option value="' . $row['id'] . '">' . $row['state_name'] . '</option>';
            }
          ?>
        </select>
      </div>
      <div class="form-group">
        <label for="city">City:</label>
        <select id="city" class="form-control" name="branch_name">
          <option value="">Select City</option>
        </select>
      </div>
      <div class="form-group">
        <label for="service">Service Provider:</label>
        <select id="service" class="form-control" name="service">
          <option value="">Select Service Provider</option>
          <?php
            $conn = mysqli_connect("localhost", "root", "", "ispdb");
            if (!$conn) {
              die("Connection failed: " . mysqli_connect_error());
            }
            $sql = "SELECT * FROM provider_details";
            $result = mysqli_query($conn, $sql);
            $options = array();

            while ($row = mysqli_fetch_assoc($result)) {
              $value = $row['service'];
              if (!in_array($value, $options)) {
                echo '<option value="' . $value . '">' . $value . '</option>';
                $options[] = $value;
              }
            }
          ?>
          <option value="others" id="others">Others</option>
        </select>
      </div>
      <div class="form-group" id="others1" style="display:none;">
        <label for="service_other">Service Provider:</label>
        <input type="text" class="form-control" id="service1" name="service1" placeholder="Enter the Service Provider">
      </div>
      <div class="form-group">
        <label for="account_id">Account Id/DSL Id:</label>
        <input type="text" class="form-control" id="account_id" name="account_id">
      </div>
      <div class="form-group">
        <label for="person_name">Contact Person:</label>
        <input type="text" class="form-control" id="person_name" name="person_name">
      </div>
      <div class="form-group">
        <label for="person_number">Contact Person Number:</label>
        <input type="text" class="form-control" id="person_number" name="person_number">
      </div>
      <div class="form-group">
        <label for="plan">Plan:</label>
        <input type="text" class="form-control" id="plan" name="plan">
      </div>
      <div class="form-group">
        <label for="speed">Speed:</label>
        <input type="text" class="form-control" id="speed" name="speed">
      </div>
      <div class="form-group">
        <label for="start">Start Date:</label>
        <input type="date" class="form-control" id="start" name="start">
        <label for="end">End Date:</label>
        <input type="date" class="form-control" id="end" name="end">
      </div>
      <div class="form-group">
        <label for="file">File:</label>
        <input type="file" class="form-control" id="file" name="file">
      </div>
      <input type="submit" name="submit" class="btn btn-primary" value="Submit">
    </form>
  </div>
</body>
</html>
