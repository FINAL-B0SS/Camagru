<?php
    
    session_start();
    include_once 'includes/dbh.inc.php';

    $img = $_POST['image'];
    $folderPath = "images/";
  
    $image_parts = explode(";base64,", $img);
    $image_type_aux = explode("image/", $image_parts[0]);
    $image_type = $image_type_aux[1];
  
    $image_base64 = base64_decode($image_parts[1]);
    $fileName = uniqid() . '.png';
  
    $file = $folderPath . $fileName;
    file_put_contents($file, $image_base64);
  
    $db = $conn;
    $owner = $_SESSION['email'];
    $filename =  str_replace("images/","",$file);
    $sql = "INSERT INTO images (image, owner) VALUES ('$filename', '$owner')";
    mysqli_query($db, $sql);
    header("Location: ../home.php");
    exit();
?>
