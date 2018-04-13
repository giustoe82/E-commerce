<?php 
session_start();

include('dbh.php');

global $dbc;

$u_id = $_SESSION['u_id'];

// Retrieve the order id from the cart; in order to proceed with the check-out the cart has to be not empty
$sql = "SELECT cart_order_id FROM cart";
$query = mysqli_query($dbc, $sql);
$row = mysqli_fetch_assoc($query);
$cart_orderID = $row['cart_order_id'];

if (!empty($u_id) && !empty($cart_orderID)) {

    //Retrieve order id and amount to pay 
    $sql = "SELECT order_id, order_amount FROM user_order WHERE user_id = ".$u_id." AND order_status = 1";
    $query = mysqli_query($dbc, $sql);
    $row = mysqli_fetch_assoc($query);
    $orderID = $row['order_id'];
    $orderAmount = $row['order_amount'];

            // Get info about products in the order
            $sql = "SELECT product_id, quantity FROM cart WHERE cart_order_id = '".$orderID."'";
            $query = mysqli_query($dbc, $sql);
        
            // Send an email to the user with the info about the purchase
            $mailBody = 'Order number '.$orderID.' has been registered.'."\r\n".'Order details: '. "\r\n";
            
            if (mysqli_num_rows($query) > 0) {
                while($row = mysqli_fetch_assoc($query)) {
        
                    $p_id = $row['product_id'];
                    $sql = "SELECT product_name, product_price FROM lager WHERE product_id = '".$p_id."'";
                    $product_query = mysqli_query($dbc, $sql);
                    $product = mysqli_fetch_assoc($product_query);
                    $product_name = $product['product_name'];
                    $product_price = $product['product_price'];
                    $numberOfItems = $row['quantity'];

                    $mailBody .= 'Item name: '.$product_name.'';
                    $mailBody .= '   Item price: '.$product_price.' €';
                    $mailBody .= '   Number of items: '.$numberOfItems.''. "\r\n";
                }
            }
            $_SESSION['totalAmount']=$orderAmount;
            $mailBody .= 'Total to pay: '.$_SESSION['totalAmount'].' €'. "\r\n";
            $mailBody .= 'Thanks for shopping with us!';
        
            $user_email = $_SESSION['u_email'];
            $to      = $user_email.', order@dreammerchant.com';
            $subject = 'Order details - Dream Merchant';
        
            $headers = 'MIME-Version: 1.0' . "\r\n" . 'Content-type: text/plain; charset=UTF-8' . "\r\n";
            $headers .= "From: <order@dreammerchant.com>\r\n";
            mail($to, $subject, $mailBody, $headers);
        

    // After check-out the cart will be empty
    $sql = "DELETE FROM cart WHERE cart_order_id = '".$orderID."'";
    mysqli_query($dbc, $sql);
    
    // Set the order status to 2 (payed) and store info in the database
    $sql = "UPDATE user_order SET order_status = 2 WHERE order_id = ".$orderID." AND order_status = 1";
    mysqli_query($dbc, $sql);  

    header("Location: ../index.php?hej");
    exit();

} else {
    //Error
    echo '<script>alert("Cart is empty or some other problem occurred!");</script>';
    echo '<script>window.history.back();</script>';
}