<?php

    if (!isset($_GET['email']) || !isset($_GET['token'])) {
        header('Location: register.php');
        exit();
    } else {
        include_once 'includes/dbh.inc.php';
        $email = $_GET['email'];
        $token = $_GET['token'];
        $sql = "SELECT id FROM users WHERE email='$email' AND token='$token' AND isEmailConfirmed=0";
        $result = mysqli_query($conn, $sql);
        $resultCheck = mysqli_num_rows($result);
        if ($resultCheck > 0) {
            $sql = "UPDATE users SET isEmailConfirmed=1, token='' WHERE email='$email'";
            mysqli_query($conn, $sql);
        }
        header('Location: index.php');
        exit();
    }   
?>