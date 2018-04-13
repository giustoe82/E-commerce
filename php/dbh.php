<?php 

$servername = "localhost";
$root = "root";
$dbpassword = "";

$dbc = new mysqli($servername, $root, $dbpassword, 'Dreamshop');

if ($dbc->connect_error) {
    die("Connection failed: " . $dbc->connect_error);
}
//echo "Connected successfully";
?> 