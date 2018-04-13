<?php
include_once 'header.php';
?>
<body id="page-top">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
        <div class="container">
            <a class="navbar-brand" href="index.php">DREAM MERCHANT</a>
            <button class="navbar-toggler navbar-toggler-right" type="button" 
                data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" 
                aria-expanded="false" aria-label="Toggle navigation">
                <i class="fa fa-bars"></i>
            </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto navbar-right">
            <li class="nav-item">
                    <a class="nav-link " href="api.php">CATALOGUE</a>
                    </li>

             <!-- If the user is not logged in the navbar will show the login form -->       
            <?php
                if (!isset($_SESSION['u_id'])) {
                echo'
                <li class="nav-item">
                    <form action="php/login.inc.php" method="POST">
                        <input type="text" name="uid" placeholder="Username/E-mail"> 
                        <input type="password" name="pwd" placeholder="Password" > 
                        <button type="submit" name="submit" class="btn btn-info">LOG IN</button>
                    </form>
                <li class="nav-item">
                    <a class="nav-link " href="register.php">REGISTER</a>
                </li>';
                /* If the user is logged in the navbar will show the logout button */
                } else{
                    echo'  
                <li class="nav-item">
                    <span class="nav-link " href="#">Welcome  '.$_SESSION['u_uid'].'  </span>
                </li>  
                <li class="nav-item">
                    <form action="php/logout.inc.php" method="POST">
                    <button type="submit" name="submit" class="btn btn-info">LOGOUT</button>
                    </form>
                </li>';
            }  
            ?>
            </ul>
        </div>
        </div>
    </nav>


    <header>
        <div class="head1 container"> 
            <h1 class="desc">DREAM MERCHANT</h1>
            <p class="desc">We want to give you the best experience of your life</p>
        </div>
    </header>


    <!-- Cart section shows only if the user is logged in -->
    <section class="cart-section">
    <?php
        if (isset($_SESSION['u_id'])) {
        echo'
            <div class="cart">
            <h1 class="cart-title">SHOPPING CART</h1>';
            include 'cart.php';
            echo'
            </div>';
        } else {
            echo'
                <div class="cart">
                    <h1 class="cart-title">SHOPPING CART</h1>
                        <h2 class="cart-title">YOU HAVE TO CREATE AN ACCOUNT TO IN ORDER TO MAKE A PURCHASE</h2>
                </div>';
                }
    ?>
    </section>

    <!-- In this section products are taken from the database through php  -->
    <section class="container products-wrap">
        <h1 class="cart-title">THE PRODUCTS</h1>
        <div class="container products-inside">
            
    
        <?php

        /*We take all the products from table "cart" in the the database made exception for the product
        with id = 6 which is shown only after a login and an age-check */
        $sql = "SELECT * FROM lager WHERE product_id !=6";
        $result = mysqli_query($dbc, $sql);
        $resultCheck = mysqli_num_rows($result);
      
        if ($resultCheck > 0) {
          while ($row = mysqli_fetch_assoc($result)) {
              echo '<div class="products">
                      <h1 class="title">'.$row['product_name'].'</h1>
                      <img class="picture" src="'.$row['product_image'].'"  style="width:260px; height:150px" alt="reload">
                      <p class="text-desc">'.$row['product_description'].'</p>
                      <h3 class="price">'.$row['product_price'].' €</h3>';

                      /* By clicking the "Add to cart" button the item will be added to the cart only if the user
                        is logged in */
                      if (!isset($_SESSION['u_id'])) {
                          echo'
                          <button type="button" class="btn btn-warning">
                          <a class ="cart-button" onclick="notLogged()">Add to Cart</a>
                          </button>';
                      } else {
                          echo'
                      <button type="button" class="btn btn-warning">
                      <a class ="cart-button" href="php/order.php?productID='.$row['product_id'].'">Add to Cart</a>
                      </button>
                    </div><br><br><br><br>';
                     }
                }
            }
                   

            if (isset($_SESSION['u_id']) && getAge() == true) {
            
            $sql = "SELECT * FROM lager WHERE product_id =6";
            $result = mysqli_query($dbc, $sql);
            $resultCheck = mysqli_num_rows($result);
          
            if ($resultCheck > 0) {
              while ($row = mysqli_fetch_assoc($result)) {
                  echo '<div class="products">
                          <h1 class="title">'.$row['product_name'].'</h1>
                          <img class="picture" src="'.$row['product_image'].'"  style="width:260px; height:150px" alt="reload">
                          <p class="text-desc">'.$row['product_description'].'</p>
                          <h3 class="price">'.$row['product_price'].' €</h3>
                          <button type="button" class="btn btn-warning">
                          <a class ="cart-button" href="php/order.php?productID='.$row['product_id'].'">Add to Cart</a>
                          </button>
                        </div><br><br><br><br>';
                       
                        }
                    }
                }

        ?>
      
        </div>
        </section>
    <script src="js/main.js"></script>
</body>
</html>

<?php
/* Age-check function: compares the current date with the user's birthday taken from the database:
    if the user is under 18 the function returns a false value */
function getAge() {

    $u_id = $_SESSION['u_id'];
    global $dbc;

    if (!empty($u_id)) {

        $sql = "SELECT user_birth FROM users WHERE user_id = '".$u_id."'";
        $query = mysqli_query($dbc, $sql);
        $row = mysqli_fetch_assoc($query);
        $birth = $row['user_birth'];

        if (time() < strtotime('+18 years', strtotime($birth))) {
            return false;
            
            } else {
                return true;
            }
        } 
    }
?>