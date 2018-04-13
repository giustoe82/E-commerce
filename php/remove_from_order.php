<?php 
session_start();

include('dbh.php');

global $dbc;

$u_id = $_SESSION['u_id'];
$p_id = $_GET['kalle'];

if (!empty($p_id) && !empty($u_id)) {

    // Retrieve the order id and the total amount to pay in the user_order table in the database
    $sql = "SELECT order_id, order_amount FROM user_order WHERE user_id = '".$u_id."' AND order_status = 1";
    $query = mysqli_query($dbc, $sql);
    $row = mysqli_fetch_assoc($query);
    $orderID = $row['order_id'];
    $order_amount = $row['order_amount'];

    $sql = "SELECT * FROM cart WHERE cart_order_id = '".$orderID."' AND product_id = '".$p_id."'";
    $query = mysqli_query($dbc, $sql);
    $row = mysqli_fetch_assoc($query);
    $quantity = $row['quantity'];
    $single_amount = $row['single_amount'];
    $total = $row['total'];
    
    //Check how many products of the same type are in the cart
    if ($quantity > 1) {
        
        /*Decrease quantity of products of the same type or remove the product from the cart in case the quantity
            is equal to 1 */
        $newquantity = $quantity - 1;
        $new_total = $total - $single_amount;

        $sql = "UPDATE cart SET quantity = '".$newquantity."', total = '".$new_total."' WHERE cart_order_id = '".$orderID."' AND product_id = '".$p_id."'";
        mysqli_query($dbc, $sql);       

        } else {
        //Remove the product from the cart
        $sql = "DELETE FROM cart WHERE cart_order_id = '".$orderID."' AND product_id = '".$p_id."'";
        mysqli_query($dbc, $sql);
    }

    //Update amount to pay in the order
    echo $order_amount;
    echo $single_amount;
    $new_order_amount = $order_amount - $single_amount;

    $sql = "UPDATE user_order SET order_amount = '".$new_order_amount."' WHERE user_id = '".$u_id."' AND order_status = 1";
    mysqli_query($dbc, $sql);  
    
    header("Location: ../index.php?hej");
    exit();


} else {
    //Error
    echo '<script>alert("RETRY!");</script>';
   // echo '<script>window.history.back();</script>';
}



