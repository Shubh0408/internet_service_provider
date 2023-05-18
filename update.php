<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include("databaseConnect.php");
if(isset($_GET['id'])){
  $user_id = $_GET['id'];
}
    $get_query="SELECT provider_details.id, branch_state.state_name,branch_city.city_name,branch_city.id as branch_id,provider_details.service,provider_details.account_id,provider_details.person_name,provider_details.person_number,provider_details.plan,provider_details.speed,provider_details.start,provider_details.end,provider_details.file FROM provider_details INNER JOIN branch_state INNER JOIN branch_city ON provider_details.branch_state=branch_state.id AND provider_details.branch_name=branch_city.id WHERE provider_details.id=$user_id";
    $conn_query=mysqli_query($conn,$get_query);
    while($fetch_assoc=mysqli_fetch_assoc($conn_query)){
      /* echo"<br>";
      print_r($fetch_assoc);
      die; */
    $branch_state=$fetch_assoc['state_name'];
    $branch_id=$fetch_assoc['branch_id'];
    $branch=$fetch_assoc['city_name'];
    $service=$fetch_assoc['service'];
    $account_id=$fetch_assoc['account_id'];
    $person_name=$fetch_assoc['person_name'];
    $person_number=$fetch_assoc['person_number'];
    $plan=$fetch_assoc['plan'];
    $speed=$fetch_assoc['speed'];
    $start=$fetch_assoc['start'];
    $end=$fetch_assoc['end'];
    $imgfile=$fetch_assoc["file"];
    /* die; */

  }

if(isset($_POST['update'],$_FILES['file']['tmp_name'])){
 /*  print_r($_POST);die; */
    $branch_state=$_POST['branch_state'];
    $branch=$_POST['branch_name'];
    if ($_POST["service"] === "others") {
      $service = $_POST["service1"];
    } else {
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

$extension = substr($imgfile,strlen($imgfile)-4,strlen($imgfile));

$allowed_extensions = array(".jpg","jpeg",".png",".gif",".pdf");

if(!in_array($extension,$allowed_extensions))

{
echo "<script>alert('Invalid format. Only jpg / jpeg/ png /gif format allowed');</script>";
}else{

$imgnewfile=md5($imgfile).$extension;  

move_uploaded_file($_FILES["file"]["tmp_name"],"uploads/".$imgnewfile);

    //echo $sql_insert="INSERT INTO `provider_details`(`branch_state`,`branch_name`, `service`,`account_id`,`person_name`,`person_number`, `plan`,`speed`, `start`, `end`,`file`) VALUES ('$branch_state','$branch','$service','$account_id','$person_name','$person_number','$plan','$speed','$start','$end','$imgnewfile')";
     $sql_update="UPDATE `provider_details` SET `branch_state`='$branch_state',`branch_name`='$branch_id',`service`='$service',`account_id`='$account_id',`person_name`='$person_name',`person_number`='$person_number',`plan`='$plan',`speed`='$speed',`start`='$start',`end`='$end',`file`='$imgnewfile' WHERE id = $user_id";
    $sql_conn=mysqli_query($conn,$sql_update);
     //print_r($sql_conn);die;
     header("location:read.php");
  }
}
?>
<html>
  <head>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script> 
  $(document).ready(function(){  
    $("#service").change(function(){
      var service_id = $(this).val();
     
      if(service_id != "others"){
        
        document.getElementById("others1").style.display ="none";
      }else{
        document.getElementById("others1").style.display ="block";
      }
    });
    $("#state").change(function(){
      var state_id = $(this).val();
      $.ajax({
        url: "get_cities.php",
        method: "POST",
        data: {state_id:state_id},
        success: function(data) {
          $("#city").html(data);
          $("#city").val(<?php echo $branch_id; ?>);
        }
      });
    });
    setTimeout(function() {
      $("#state").change();
    }, 1000);
});
  </script>  
</head>
  <body>
<form action="" method="POST" enctype="multipart/form-data">
 <!--  <div class="container"> -->
  <div class="form-group">
    
    <div class="col-sm-6"> 
      <div id ="list">
      <a class="btn btn-primary" href="./read.php" role="button">All Records</a>
      <a class="btn btn-primary" href="./dashboard.php" role="button">Dashboard</a>
      <a class="btn btn-primary" href="./insert_state.php" role="button">Add State</a>
      <a class="btn btn-primary" href="./insert_city.php" role="button">Add Branch</a>
      <div class="form-group">
      <label for="state">State:</label>
  <select id="state"class="form-control" name="branch_state"  value="<?php echo $branch_state; ?>">
    <option value="">Select State</option>
    <?php
      $sql = "SELECT id, state_name FROM branch_state";
      $result = mysqli_query($conn, $sql);

      while ($row = mysqli_fetch_assoc($result)) {
        $selected1 = ($row['state_name'] == $branch_state) ? 'selected' : '';
             // echo '<option value="' . $value . '" ' . $selected . '>' . $value . '</option>';
        echo '<option value="' . $row['id'] . '" ' . $selected1 . '>' . $row['state_name'] . '</option>';
      }
    ?>
    </select>
    </div>
    <div class="form-group">
    <label for="city">City:</label>
  <select id="city" class="form-control" name="branch_name" value="<?php echo $branch; ?>">
    <option value="">Select City</option>
  </select>
    </div>
    <div class="form-group">
      <label for="service">Service Provider:</label>
      <select id="service"class="form-control" name="service" value="<?php echo $service; ?>">
        <option value="">Select Service Provider</option>
        <?php
        /*   $conn = mysqli_connect("localhost", "root", "", "ispdb");
          if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
          } */
          $sql = "SELECT * FROM provider_details";
          $result = mysqli_query($conn, $sql);
          $options = array();

          while ($row = mysqli_fetch_assoc($result)) {
            //print_r($row);
            $value = $row['service'];
            if (!in_array($value, $options)) {
              $selected = ($value == $service) ? 'selected' : '';
              echo '<option value="' . $value . '" ' . $selected . '>' . $value . '</option>';
              $options[] = $value;
            }
          }
        ?>
        <option value="others" id="others">Others</option>
      </select>
      <div class="form-group" id="others1" style="display:none;">
    <label for="service_other">Service Provider:</label>
    <input type="text" class="form-control" id="service1" name="service1" placeholder="Enter the Service Provider" value="">
      </div>
    </div>
  <div class="form-group">
    <label for="usr">Account Id/ DSL Id:</label>
    <input type="text" class="form-control" id="account_id" name="account_id" value= "<?php echo $account_id;?>">
  </div>
  <div class="form-group">
    <label for="usr">Contact Person:</label>
    <input type="text" class="form-control" id="person_name" name="person_name" value="<?php echo $person_name;?>">
  </div>
  <div class="form-group">
    <label for="usr">Contact Person Number:</label>
    <input type="text" class="form-control" id="person_number" name="person_number" value="<?php echo $person_number;?>">
  </div>
  <div class="form-group">
    <label for="usr">Plan:</label>
    <input type="text" class="form-control" id="plan" name="plan" value="<?php echo $plan;?>">
  </div>
  <div class="form-group">
    <label for="usr">Speed:</label>
    <input type="text" class="form-control" id="speed" name="speed" value="<?php echo $speed;?>">
  </div>
  <div class="form-group">
    <label for="usr">StartDate:</label>
    <input type="date" class="form-control" id="start"  name="start"value="<?php echo $start;?>">
    <label for="usr">EndDate:</label>
    <input type="date" class="form-control" id="end"  name="end" value="<?php echo $end;?>">
  </div>
  <div class="form-group">
    <label for="usr">File:</label>
    <input type="file" class="form-control" id="file" name="file"value="<?php echo $imgfile;?>">
  </div>
  <input type="submit" name="update" class="btn btn-primary" value="Update">
  <!-- </div> -->
      </div>
      </div>
    </form>
  </body>
</html>