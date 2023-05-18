<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include("databaseConnect.php");
$search_branch ="";
if(isset($_REQUEST['search'])){
    extract($_POST);
    //print_r($_REQUEST);die;
    $branch=$_REQUEST['branch_state'];
    if($branch != ""){
        $search_branch .="and provider_details.branch_name='$branch'";
    }
  }
?>
<html>
  <head>
<!-- Include Bootstrap CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.2/css/buttons.dataTables.min.css">
<!-- Include jQuery library -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Include DataTables library -->
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.flash.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.print.min.js"></script>
<style>
div.dt-buttons {
   margin-right: 10px;
}
table.dataTable {
   width: 100%;
}
#example_length{

}
</style>

</head>
<body>
    
<form action="read.php" method="POST">
  <div class="form-group">
     <div class="col-sm-12">
      <div id ="list">
      <a class="btn btn-primary" href="./index.php" role="button">Insert Data</a>
      <a class="btn btn-primary" href="./dashboard.php" role="button">Dashboard</a>
      <a class="btn btn-primary" href="./insert_state.php" role="button">Add State</a>
      <a class="btn btn-primary" href="./insert_city.php" role="button">Add Branch</a>
      <div> 
      <?php  
      $sql_query="SELECT branch_name FROM branch";
      $sql_conn=mysqli_query($conn,$sql_query);
      ?>
  <label for="branch_state">Select list:</label>
  <select class="form-control" id="branch_state" name="branch_state">
  <option value="">Select</option>
    <?php while($sql_fetch=mysqli_fetch_assoc($sql_conn)){
      $branch_name=$sql_fetch['branch_name'];
     /*  $branch_value = str_replace(' ', '', $branch_name); */
      ?>
    <option value="<?php echo $branch_name;?>"><?php echo $branch_name; ?></option>

  <?php } ?>
  </select>
</div>
</div>
<input type="submit" name="search" class="btn btn-primary" value="search">
    </form>
    <div id="datatable">
      <form action ="" method="POST">
        <table id="example" class="table table-striped table-bordered" style="width:100%">
        <div id="length-menu-container">
          <thead>
          <tr>
              <th>State</th>
              <th>Branch</th>
              <th>Service</th>
              <th>Account Id</th>
              <th>Contact Person</th>
              <th>Contact Number</th>
              <th>Plan</th>
              <th>Speed</th>
              <th>Start</th>
              <th>End</th>
              <th>File</th>
              <th>Action</th>
          </tr>
          </thead>
          <tbody>
                <?php
                $st_query="SELECT provider_details.id, branch_state.state_name,branch_city.city_name,provider_details.service,provider_details.account_id,provider_details.person_name,provider_details.person_number,provider_details.plan,provider_details.speed,provider_details.start,provider_details.end,provider_details.file FROM provider_details INNER JOIN branch_state INNER JOIN branch_city ON provider_details.branch_state=branch_state.id AND provider_details.branch_name=branch_city.id WHERE 1 $search_branch";
                /* die; */
                $run_sql_query=mysqli_query($conn,$st_query);
                if($num_rows=mysqli_num_rows($run_sql_query)>0){
                  while($fetch_assoc=mysqli_fetch_assoc($run_sql_query)){
                    $id=$fetch_assoc['id'];
                    $branch_state=$fetch_assoc['state_name'];
                    $branch=$fetch_assoc['city_name'];
                    $service=$fetch_assoc['service'];
                    $account_id=$fetch_assoc['account_id'];
                    $person_name=$fetch_assoc['person_name'];
                    $person_number=$fetch_assoc['person_number'];
                    $plan=$fetch_assoc['plan'];
                    $speed=$fetch_assoc['speed'];
                    $start=$fetch_assoc['start'];
                    $end=$fetch_assoc['end'];
                    $file=$fetch_assoc['file'];
                  ?>
                  <tr>
                  <td><?php echo $branch_state ;?></td>
                    <td><?php echo $branch ;?></td>
                    <td><?php echo $service ;?></td>
                    <td><?php echo $account_id ;?></td>
                    <td><?php echo $person_name ;?></td>
                    <td><?php echo $person_number ;?></td>
                    <td><?php echo $plan ;?></td>
                    <td><?php echo $speed ;?></td>
                    <td><?php echo $start ;?></td>
                    <td><?php echo $end ;?></td>
                    <td><a href=<?echo "uploads/".$file ?>>Download</a></td>
                    <td >
                      <a href="update.php?id=<?php echo $id;?>">Update</a>
                      <a href="delete.php?id=<?php echo $id;?>">Delete</a>
                    </td>
                  </tr>
                  <?php
                  }
                }
                ?>
                </div>
          </tbody>
        </table>
      </form>

   
    <script>
   $(document).ready(function() {
   $('#example').DataTable( {
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "language": {
         "search": "Search:",
         "info": "Showing _START_ to _END_ of _TOTAL_ entries",
         "lengthMenu": "Show _MENU_ entries"
      },
      "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
      "dom": 'Blfrtip',
      "buttons": [
         'copy', 'csv', 'excel', 'pdf', 'print'
      ]
   });
});


    
    
    </script>
  </body>
</html>