<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include("databaseConnect.php");

$search_branch = "";
if (isset($_REQUEST['search'])) {
  extract($_POST);
  //print_r($_REQUEST);die;
  $branch = $_REQUEST['branch_state'];
  if ($branch != "") {
    $search_branch .= "and provider_details.branch_name='$branch'";
  }
}
?>
<html>

<head>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
    integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
    integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
    crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
    integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
    crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
    integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
    crossorigin="anonymous"></script>
  <style>
    body {
      background-color: #f2f2f2;
    }

    .container {
      margin-top: 50px;
    }
  </style>
</head>

<body>
  <div class="container">
    <div id="list">
      <a class="btn btn-primary" href="./read.php" role="button">All Records</a>
      <a class="btn btn-primary" href="./index.php" role="button">Insert Record</a>
      <a class="btn btn-primary" href="./insert_state.php" role="button">Add State</a>
      <a class="btn btn-primary" href="./insert_city.php" role="button">Add Branch</a>
      <div>
        <div id="datatable">
          <form action="" method="POST">
            <table id="example" class="table table-striped table-bordered" style="width:100%">
              <thead>
                <tr>
                  <th>Branch</th>
                  <th>Service</th>
                  <th>Account Id</th>
                  <th>Plan</th>
                  <th>Speed</th>
                  <th>Start</th>
                  <th>End</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $sql_due = "SELECT * FROM provider_details WHERE end BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 10 DAY)";
                $due_run = mysqli_query($conn, $sql_due);
                while ($due_fetch_assoc = mysqli_fetch_assoc($due_run)) {
                  $branch = $due_fetch_assoc['branch_name'];
                  $service = $due_fetch_assoc['service'];
                  $account_id = $due_fetch_assoc['account_id'];
                  $plan = $due_fetch_assoc['plan'];
                  $speed = $due_fetch_assoc['speed'];
                  $start = $due_fetch_assoc['start'];
                  $end = $due_fetch_assoc['end'];
                  ?>
                  <tr>
                    <td>
                      <?php echo $branch; ?>
                    </td>
                    <td>
                      <?php echo $service; ?>
                    </td>
                    <td>
                      <?php echo $account_id; ?>
                    </td>
                    <td>
                      <?php echo $plan; ?>
                    </td>
                    <td>
                      <?php echo $speed; ?>
                    </td>
                    <td>
                      <?php echo $start; ?>
                    </td>
                    <td>
                      <?php echo $end; ?>
                    </td>
                  </tr>
                  <?php

                }
                ?>
              </tbody>
            </table>

            </table>
            </table>
          </form>

        </div>
      </div>
</body>

</html>