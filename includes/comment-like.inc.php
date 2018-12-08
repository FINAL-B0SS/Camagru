<?php

    session_start();
    include_once 'dbh.inc.php';

    $img = $_POST['comment-btn'];
    $sql = "SELECT * FROM images WHERE image='$img'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
    $email = $row['owner'];
    $owner = $_SESSION['name'];
    $commentEmail = $_SESSION['email'];
    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
    $notify = $row['notify'];
 
    if ($notify == 1 AND $commentEmail != $email) {
        // Sends out email with notification of comment to post owner
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
        $mail->Subject='Someone commented on your post';
        $mail->Body=$owner." commented on your post";
        $mail->send();
    }
    if (isset($_POST['like'])) {
        $img = $_POST['like'];
        $sql = "UPDATE images SET likes = likes+1 WHERE image='$img';";

        mysqli_query($conn, $sql);
        header("Location: ../feed.php");
        exit();
    } else if (isset($_POST['comment-btn'])) {
        $comment = $_POST['comment'];
        $sql = "INSERT INTO comments (owner, image, comment) VALUES ('$owner', '$img', '$comment')";

        mysqli_query($conn, $sql);
        header("Location: ../feed.php");
        exit();
    }
    