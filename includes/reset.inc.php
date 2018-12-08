<?php

    include_once 'dbh.inc.php';

    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $cpassword = mysqli_real_escape_string($conn, $_POST['cpassword']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    if ($password == '' OR $cpassword == '') {
        header("Location: ../reset.php?login=<b><p style='color:red;'>Please fill out both fields!</p></b>");
        exit();
    } else if ($password != $cpassword){
        header("Location: ../reset.php?login=<b><p style='color:red;'>Passwords must match!</p></b>");
        exit();
    } else if ($password == $cpassword) {
            $password = password_hash($password, PASSWORD_DEFAULT);
            $sql = "UPDATE users set password='$password' WHERE email='$email';";

            mysqli_query($conn, $sql);
            header("Location: ../index.php");
            exit();
    }
    header("Location: ../index.php");
    exit();