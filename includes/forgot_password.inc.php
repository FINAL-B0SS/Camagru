<?php

    include_once 'dbh.inc.php';
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);
    
    if ($resultCheck < 1) {
        header("Location: ../forgot_password.php?login=<b><p style='color:red;'>Account does not exist with this email</p></b>");
        exit();
    } else {
         // Sends out email with password reset link
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
         $mail->Subject='Reset password';
         $mail->Body="Please click <a href='http://localhost/reset.php?email=$email'> here </a> to reset your password";
         $mail->send();
         header("Location: ../forgot_password.php?login=<b><p style='color:green;'>Password reset link sent</p></b>");
    }