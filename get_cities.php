<?php
$conn = mysqli_connect("localhost", "root", "", "ispdb");
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

$state_id = $_POST['state_id'];
$branch =$_POST['city_id'];

$sql = "SELECT id, city_name FROM branch_city WHERE state_id = $state_id";
$result = mysqli_query($conn, $sql);


while ($row = mysqli_fetch_assoc($result)) {
  $selected2 = ($row['city_name'] == $branch) ? 'selected' : '';
  echo '<option value="' . $row['id'] . '" ' . $selected2 . '>' . $row['city_name'] . '</option>';

}

print_r($row);
mysqli_close($conn);
?>