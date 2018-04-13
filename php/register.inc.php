<?php

if (isset($_POST['submit'])) {
    
    include_once 'dbh.php';
    global $dbc;

    $first = mysqli_real_escape_string($dbc, $_POST['first']);
    $last = mysqli_real_escape_string($dbc, $_POST['last']);
    $email = mysqli_real_escape_string($dbc, $_POST['email']);
    $uid = mysqli_real_escape_string($dbc, $_POST['uid']);
    $pwd = mysqli_real_escape_string($dbc, $_POST['pwd']);
    $birth = mysqli_real_escape_string($dbc, $_POST['birth']);

    
    // Error handlers
    
    // Check for empty fields
    if (empty($first) || empty($last) || empty($email) || empty($uid) || empty($pwd) || empty($birth)) {
        header("Location: ../register.php?register=empty");
        exit();
    } else {
        // Check if input characters are valid
        if (!preg_match("/^[a-zA-Z]*$/", $first) || !preg_match("/^[a-zA-Z]*$/", $last)) {
            header("Location: ../register.php?register=invalid");
            exit();
        } else {
            // Check if email is valid
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                header("Location: ../register.php?register=invalid-email");
                exit();
            } else {
                $sql = "SELECT * FROM users WHERE user_uid='$uid'";
                $result = mysqli_query($dbc, $sql);
                $resultCheck = mysqli_num_rows($result);

                if ($resultCheck > 0) {
                    header("Location: ../register.php?register=usertaken");
                    exit();
                } else {
                    // Hashing password
                    $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);
                    // Insert the user informations into the database
                    $sql = "INSERT INTO users (user_first, user_last, user_email, user_uid, user_pwd, user_birth) 
                    VALUES ('$first', '$last', '$email', '$uid', '$hashedPwd', '$birth');";
                    mysqli_query($dbc, $sql);
                    header("Location: ../register.php?register=success");

                    
                            // Upon registration an email with login info will be sent to the user
                            $to      = $email;
                            $subject = 'Dream Merchant Registration';
                            $message = '
                                Hello, '.$first.'
                                
                                Thanks for signing up!
                                Your account has been created, you can login with:
                        
                                ----------------------------------------------------------------------
                                Email: '.$email.' or Username: '.$uid.'
                                Password: '.$pwd.'
                                ----------------------------------------------------------------------';
                        
                            mail($to, $subject, $message, 'From: info@dreammerchant.com');
                   
                    exit();
                }
            }
        }
    }


}else {
    header("Location: ../register.php");
    exit();
}