<?php
    
include ('php/dbh.php');
global $dbc;
    
    $u_id = $_SESSION['u_id'];
    
    //If the user is logged an empty order will be created in the database 
    if (!empty($u_id)) {
      $sql = "SELECT * FROM user_order WHERE user_id = '".$u_id."' AND order_status = 1";  
      $query = mysqli_query($dbc, $sql);
      $row = mysqli_fetch_assoc($query);
      $orderID = $row['order_id'];
      
      if (empty($orderID)) {
          $sql = "INSERT INTO user_order (user_id, order_status, update_time) VALUES('$u_id', 1, NOW());";
          mysqli_query($dbc, $sql); 
        }     
    } 
      
    
    
    //Get users items from pending order if logged in
    function get_cart_items() {
      
          $u_id = $_SESSION['u_id'];
          global $dbc;
      
          if (!empty($u_id)) {
            //Get order ID
              $sql = "SELECT order_id FROM user_order WHERE user_id = '".$u_id."' AND order_status = 1";
              $query = mysqli_query($dbc, $sql);
              $row = mysqli_fetch_assoc($query);
              $orderID = $row['order_id'];
    
              //Get all products from the order
                $sql = "SELECT * FROM cart WHERE cart_order_id = '".$orderID."'";  
                $query = mysqli_query($dbc, $sql);
            
    
            if (mysqli_num_rows($query) > 0) {
              while($row = mysqli_fetch_assoc($query)) {
          
                  //Get all information about the product to show them in the cart
                  $sql = "SELECT * FROM lager WHERE product_id = '".$row['product_id']."'";
                  $product_query = mysqli_query($dbc, $sql);
                  $product = mysqli_fetch_assoc($product_query);
      
                  echo '
                  <tr>
                    <td>'.$product['product_name'].'</td>
                    <td>'.$row['quantity'].'</td>
                    <td>'.number_format($product['product_price'], 0, ',', ' ').' €</td>
                    <td>'.number_format(($product['product_price'] * $row['quantity']), 0, ',', ' ').' €</td>
                    <td><a href="php/remove_from_order.php?kalle='.$product['product_id'].'">X</a></td>
                  </tr>';
    
                  }  
                } else {
                    echo '
                    <td>Nothing in the cart</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>X</td>                
                    ';
                }    
            } else {
                echo "<h3>LOGIN!</h3>";
            }    
        }    
    
        // This function shows how many units of product the user has in the cart
        function cart_item_counter() {
          
              $u_id = $_SESSION['u_id'];
             
              global $dbc;
          
              //Get order ID
              $sql = "SELECT order_id FROM user_order WHERE user_id = '".$u_id."' AND order_status = 1";
              $query = mysqli_query($dbc, $sql);
              $row = mysqli_fetch_assoc($query);
              $orderID = $row['order_id'];
          
              //Get all order rows with order ID
              $sql = "SELECT * FROM cart WHERE cart_order_id = '".$orderID."'";
              $query = mysqli_query($dbc, $sql);
              
              //Get sum of all products in the order
              if (mysqli_num_rows($query) > 0) {
                  $total_quantity = 0;
                  while($row = mysqli_fetch_assoc($query)) {
                      $total_quantity += $row['quantity'];
                  }    
                  echo $total_quantity;
              } else {
                  echo 0;
              }    
          }    
          // This function shows the total amount to pay in the cart
          function cart_total_amount() {
              
              $u_id = $_SESSION['u_id'];
              global $dbc;
          
              //Get order totalAmount
              $sql = "SELECT order_amount FROM user_order WHERE user_id = '".$u_id."' AND order_status = 1";
              $query = mysqli_query($dbc, $sql);
              $row = mysqli_fetch_assoc($query);
              $order_amount = $row['order_amount'];
    
                //Save total into session
                $_SESSION['totalAmount'] = $order_amount;
          
                echo number_format($order_amount, 0, ',', ' ').'€';
          }   
          
          
?>
    

<div class=" container the-cart">
    <div class="jumbotron cart-container">
                
        <h2>This is your order</h2>  
        <div class="table-responsive">
            <table class="table ">
              <tr>
              <th width="35%">Product Name</th>
              <th width="15%">Quantity</th>
              <th width="15%">Price</th>
              <th width="15%">Subtotal</th>
              <th width="10%">Remove</th>
              </tr>
              <?php
              get_cart_items();
              ?>
            </table>
              
              
        <div class="table-responsive">
            <table class="table table-bordered">
              <tr>
              <th width="50%">Number of items in the cart</th>
              <th width="50%">Total</th>
              </tr>
              <tr>
              <td> <?php cart_item_counter(); ?></td>
              <td> <?php cart_total_amount(); ?></td>
              </tr>
            </table>
              <button type="button" class="left-btn btn btn-warning" ><a href="php/reset.php">Empty cart</a></button>
              <button type="button" class="right-btn btn btn-warning" onclick="checkOut()"><a href="php/check-out.php" >Check Out</a></button>
        </div>          
        </div> 
    </div>    
</div>
              
<script src="js/main.js"></script>
              

              
                             



