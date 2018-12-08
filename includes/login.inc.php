<?php
    
    session_start();

    include_once 'dbh.inc.php';

    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    if (empty($email) || empty($password)) {
        header("Location: ../index.php?login=<b><p style='color:red;'>Fill in both fields!</p></b>");
        exit();
    } else {

        $sql = "SELECT * FROM users WHERE email='$email' AND isEmailConfirmed=0;";
        $result = mysqli_query($conn, $sql);
        $resultCheck = mysqli_num_rows($result);
    
        if ($resultCheck > 0) {
            header("Location: ../index.php?login=<b><p style='color:red;'>Emailed not verified</p></b>");
            exit();
        }

        $sql = "SELECT * FROM users WHERE email='$email'";
        $result = mysqli_query($conn, $sql);
        $resultCheck = mysqli_num_rows($result);
        if ($resultCheck < 1) {
            header("Location: ../index.php?login=<b><p style='color:red;'>Email not found</p></b>");
            exit();
        } else {
            if ($row = mysqli_fetch_assoc($result)) {
                if (password_verify($password, $row['password'])) {
                    $_SESSION['email'] = $row['email'];
                    $_SESSION['name'] = $row['name'];
                    header("Location: ../home.php");
                    exit();
                } else {
                    header("Location: ../index.php?login=<b><p style='color:red;'>Password and email do not match</p></b>");
                    exit();
                }
            }
        }
    }
    $sql = "SELECT * FROM users WHERE email='$email' AND isEmailConfirmed=0;";
    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);

    if ($resultCheck == 0) {
        header("Location: ../index.php?login=<b><p style='color:red;'>Emailed not verified</p></b>");
        exit();
    }

 