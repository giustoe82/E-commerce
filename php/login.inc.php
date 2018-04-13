<?php

session_start();

if (isset($_POST['submit'])) {

    include 'dbh.php';

    $uid = mysqli_real_escape_string($dbc, $_POST['uid']);
    $pwd = mysqli_real_escape_string($dbc, $_POST['pwd']);

    //Error handlers
    
    //Check if the user submitted the necessary info in the login form 
    if (empty($uid) || empty($pwd)) {
        header("Location: ../index.php?login=empty");
        exit();
    } else {
        $sql = "SELECT * FROM users WHERE user_uid='$uid' OR user_email ='$uid'";
        $result = mysqli_query($dbc, $sql);
        $resultCheck = mysqli_num_rows($result);
        if ($resultCheck < 1) {
            header("Location: ../index.php?login=error");
            exit();
        } else {
            if ($row = mysqli_fetch_assoc($result)) {
                //De-hashing password
                $hashedPwdCheck = password_verify($pwd, $row['user_pwd']);
                if ($hashedPwdCheck == false) {
                    header("Location: ../index.php?login=error");
                    exit();
                } elseif ($hashedPwdCheck == true) {

                    // Log in user here defining all the variables for the current session
                    $_SESSION['u_id'] = $row['user_id'];
                    $_SESSION['u_first'] = $row['user_first'];
                    $_SESSION['u_last'] = $row['user_last'];
                    $_SESSION['u_email'] = $row['user_email'];
                    $_SESSION['u_uid'] = $row['user_uid'];
                    $_SESSION['u_birth'] = $row['user_birth'];
                    
                    header("Location: ../index.php?login=success");
                    exit();
                    
                }
            }
        }
    }
} else {
    header("Location: ../index.php?login=error");
    exit();
}