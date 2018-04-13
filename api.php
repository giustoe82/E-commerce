

<?php
include('php/dbh.php');

// Create a product list dynamically and print it in JSON format
$sql = "SELECT * FROM lager";
$row = mysqli_query($dbc, $sql); 
$rows = array();
while($r = mysqli_fetch_assoc($row)) {
   $rows[] = $r;
}
echo '<pre>';
echo json_encode($rows, JSON_PRETTY_PRINT); echo '</pre>';
?>
