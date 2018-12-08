<?php

if (isset($_POST['submit'])) {
    include_once 'dbh.inc.php';

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $cpassword = mysqli_real_escape_string($conn, $_POST['cpassword']);
    $token = uniqid();

    // Error handlers
    // Check for empty fields
    if (empty($name) || empty($email) || empty($password) || empty($cpassword)) {
        header("Location: ../register.php?signup=<b><p style='color:red;'>All fields must be filled out!</p></b>");
        exit();
    } else {
            // Check if email is valid
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                header("Location: ../register.php?=<b><p style='color:green;'>User registered, verification link sent to email</p></b>");
                exit();
            // Check if passwords match
            } else if ($password != $cpassword) {
                header("Location: ../register.php?signup=<b><p style='color:red;'>Passwords do not match!</p></b>");
                exit();
            }
            // Check if email taken
             else {
                $sql = "SELECT * FROM users WHERE email='$email';";
                $result = mysqli_query($conn, $sql);
                $resultCheck = mysqli_num_rows($result);

                if ($resultCheck > 0) {
                    header("Location: ../register.php?signup=<b><p style='color:red;'>Email taken</p></b>");
                    exit();
                } else {
                    // Hashing the password
                    $hashedPwd = password_hash($password, PASSWORD_DEFAULT);
                    // Insert user into database
                    $sql = "INSERT INTO users (name, email, password, token)
                        VALUES ('$name', '$email', '$hashedPwd', '$token');";
                    mysqli_query($conn, $sql);
                    // Sends out email with verification link
                    require '../PHPMailer/PHPMailerAutoload.php';
                    $mail = new PHPMailer;
                    $mail->isSMTP();
                    $mail->Host='smtp.gmail.com';
                    $mail->Port=587;
                    $mail->SMTPAuth=true;
                    $mail->SMTPSecure='tls';

                    $mail->Username='camagru.maljean@gmail.com';
                    $mail->Password='camagru42';
                    $mail->setFrom('camagru.maljean@gmail.com', 'Camagru');
                    $mail->addAddress($email);
                    $mail->addReplyTo('camagru.maljean@gmail.com');

                    $mail->isHTML(true);
                    $mail->Subject='Verification';
                    $mail->Body="Please click <a href='http://localhost/PHP-Playground/Camagru/confirm.php?email=$email&token=$token'> here </a> to verify email";
                    if (!$mail->send()){
                        header("Location: ../register.php?signup=MalError");
                        exit();
                    } else {
                        header("Location: ../register.php?signup=<b><p style='color:green;'>User registered, verification link sent to email</p></b>");
                        exit();
                    }
                    //header("Location: ../register.php?signup=success");
                    //exit();
                }
            }
        }
} else {
    header("Location: ../register.php");
    exit();
}