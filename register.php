<?php
include_once 'header.php';
?>

<body class="bg2">
    <div class="container">
        <h1 class="regtit">Register</h1> <br>

        <!-- Here the user will fill all the fields and the informations will be sent to the database
            through being processed in php/register.inc.php -->
        <form action="php/register.inc.php" method="POST">
            <input type="text" name="first" placeholder="Firstname"> <br><br>
            <input type="text" name="last" placeholder="Lastname"> <br><br>
            <input type="text" name="email" placeholder="E_mail"> <br><br>
            <input type="date" name="birth" placeholder="Birth Date"> <label for="birth">Birth date</label><br><br>
            <input type="text" name="uid" placeholder="Username"> <br><br>
            <input type="password" name="pwd" placeholder="Password"> <br><br>
    
            <button type="submit" name="submit" class="btn btn-info" onclick="register()">Register</button><br><br>
        </form>
    
        <a href="index.php"><button type="button"  class="btn btn-info">Home</button></a>

    </div>
    
<script src="js/main.js"></script>
</body>
</html>
    
    
    
    
    
    
            


       

