<?php

    include_once 'dbh.inc.php';
    session_start();

    function exitMessage($msg) {
        header("Location: ../settings.php?signup=<b><p style='color:red;'>".$msg."</p></b>");
        exit();
    }

    function queryDatabase($conn, $sql) {
        mysqli_query($conn, $sql);
    }

    if (isset($_POST['submit'])) {
        $newName = mysqli_real_escape_string($conn, $_POST['name']);
        $newEmail = mysqli_real_escape_string($conn, $_POST['email']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);
        $cpassword = mysqli_real_escape_string($conn, $_POST['cpassword']);
        $rpassword = mysqli_real_escape_string($conn, $_POST['rpassword']);
        $notify = mysqli_real_escape_string($conn, $_POST['notify']);
        $name = $_SESSION['name'];
        $email = $_SESSION['email'];
 
        // Error handlers
        // Check if both password fields are filled and match
        if ($password != "" AND empty($cpassword))
            exitMessage("Confirm password!");
        if ($password != $cpassword)
            exitMessage("Passwords don't match!");
        // Check if email taken
        $sql = "SELECT * FROM users WHERE email='$newEmail';";
        $result = mysqli_query($conn, $sql);
        $resultCheck = mysqli_num_rows($result);
        if ($resultCheck > 0 AND $newEmail != "")
            exitMessage("Email taken");
        // This handles updating the user information
        $check = 0;
        if (isset($notify)) {
            if ($notify == 'yes') {
                $check = 1;
                queryDatabase($conn, "UPDATE users set notify=1 WHERE email='$email';");
            } else if ($notify == 'no') {
                $check = 1;
                queryDatabase($conn, "UPDATE users set notify=0 WHERE email='$email';");
            }
        }
        if (isset($newName) AND $newName != "") {
            queryDatabase($conn, "UPDATE users set name='$newName' WHERE email='$email';");
            $check = 1;
        }
        if ($password != "" AND $cpassword != "" AND $password == $cpassword) {
            $sql = "SELECT * FROM users WHERE email='$email'";
            $result = mysqli_query($conn, $sql);
            $resultCheck = mysqli_num_rows($result);
            if ($row = mysqli_fetch_assoc($result)) {
                if (password_verify($rpassword, $row['password'])) {
                    $password = password_hash($password, PASSWORD_DEFAULT);
                    queryDatabase($conn, "UPDATE users set password='$password' WHERE email='$email';");
                    $check = 1;
                } else {
                    exitMessage("Invalid password");
                }
            }
        }
        if ($newEmail != "") {
            queryDatabase($conn, "UPDATE users set email='$newEmail' WHERE email='$email';");
            queryDatabase($conn, "UPDATE images set owner='$newEmail' WHERE owner='$email';");
            $check = 1;
        }
        if ($check == 1) {
            header("Location: ../index.php?login=logout");
            exit();
        }
        exitMessage("No Changes Made");
}