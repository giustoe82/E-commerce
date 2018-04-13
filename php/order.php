<?php
session_start();

include 'dbh.php';
global $dbc;

    $p_id = $_GET['productID'];
    $u_id = $_SESSION['u_id'];

    if (!empty($u_id)) {

    //Get order-id from database in order to use it as a reference for adding products to the right order
    $sql = "SELECT order_id FROM user_order WHERE user_id = '".$u_id."' AND order_status = 1";
    $query = mysqli_query($dbc, $sql);
    $row = mysqli_fetch_assoc($query);
    $orderID = $row['order_id'];

    //Get product info
    $sql = "SELECT * FROM lager WHERE product_id = ".$p_id."";
    $query = mysqli_query($dbc ,$sql);
    $row = mysqli_fetch_assoc($query);
    $p_price = $row['product_price'];

    if (!empty($orderID)) {
        //Check if the product is already in the order
        $sql ="SELECT * FROM cart WHERE cart_order_id = '".$orderID."' AND product_id = '".$p_id."'";
        $query = mysqli_query($dbc, $sql);
        $row = mysqli_fetch_assoc($query);
        $quantity = $row['quantity'];

        if (!empty($quantity)) {
            //Update item counter if the product already exist in the order
            $new_quantity = $quantity +1;
            $new_total = $p_price * $new_quantity;
            $sql = "UPDATE cart SET quantity = '".$new_quantity."', total = '".$new_total."' WHERE cart_order_id = '".$orderID."' AND product_id = '".$p_id."'";
            mysqli_query($dbc, $sql);
            updateOrderValue($p_price);

        } else {
            
            //Add new product to the order
            $sql = "INSERT INTO cart (product_id, cart_order_id, quantity, single_amount, total) VALUES('$p_id', '$orderID', 1, '$p_price', '$p_price');";
            mysqli_query($dbc, $sql);  
            updateOrderValue($p_price);

            }
        
            header("Location: ../index.php");
            exit();  

    } else {
        //Error message if the user try to add to cart a product without being logged in
        echo '<script>alert("LOGIN TO BUY!");</script>';
        echo '<script>window.history.back();</script>';
    }

} else {
    header("Location: ../index.php");
    exit();

}

// This function update the total amount to pay in the database, table user_order
function updateOrderValue($amount_to_add) {
    
        $u_id = $_SESSION['u_id'];
        global $dbc;

        //Get order totalAmount
        $sql = "SELECT order_amount FROM user_order WHERE user_id = '".$u_id."' AND order_status = 1";
        $query = mysqli_query($dbc, $sql);
        $row = mysqli_fetch_assoc($query);
        $order_amount = $row['order_amount'];
        $new_order_amount = $order_amount + $amount_to_add;
    
        $sql = "UPDATE user_order SET order_amount = '".$new_order_amount."' WHERE user_id = '".$u_id."' AND order_status = 1";
        mysqli_query($dbc, $sql);
        mysqli_close($dbc);
    }

?>
    