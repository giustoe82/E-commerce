<?php 
session_start();

include('dbh.php');

global $dbc;

$u_id = $_SESSION['u_id'];


if (!empty($u_id)) {

    // Retrieve the order id related to the actual session
    $sql = "SELECT order_id FROM user_order WHERE user_id = ".$u_id." AND order_status = 1";
    $query = mysqli_query($dbc, $sql);
    $row = mysqli_fetch_assoc($query);
    $orderID = $row['order_id'];

    // Delete the content of cart in the database
    $sql = "DELETE FROM cart WHERE cart_order_id = '".$orderID."'";
    mysqli_query($dbc, $sql);

    // Delete the current order from the database
    $sql = "DELETE FROM user_order WHERE order_id = '".$orderID."'";
    mysqli_query($dbc, $sql);

    header("Location: ../index.php?hej");
    exit();

} else {
    //Error
    echo '<script>alert("RETRY!");</script>';
    echo '<script>window.history.back();</script>';
}
    

   


    


    

    
    
   