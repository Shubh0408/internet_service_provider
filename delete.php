<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include("databaseConnect.php");
if(isset($_GET['id'])){
  $user_id = $_GET['id'];

    $get_query="DELETE FROM provider_details WHERE id = $user_id";
    $conn_query=mysqli_query($conn,$get_query);
    header("location:read.php");


}
