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
    $filename = str_replace("images/","",$file);

    // Load the stamp and the photo to apply the watermark to
    $stencil = $_POST['stencil'];
    $stamp = imagecreatefrompng($stencil);
    $im = imagecreatefromjpeg('images/'.$filename);

    // Set the margins for the stamp and get the height/width of the stamp image
    $marge_right = 0;
    $marge_bottom = 0;
    $sx = imagesx($stamp);
    $sy = imagesy($stamp);

    // Copy the stamp image onto our photo using the margin offsets and the photo 
    // width to calculate positioning of the stamp. 
    imagecopy($im, $stamp, imagesx($im) - $sx - $marge_right, imagesy($im) - $sy - $marge_bottom, -50, -400, imagesx($stamp), imagesy($stamp));
    $filename = uniqid().'.png';
    imagepng($im, 'images/'.$filename, 0);
    imagedestroy($im);

    $sql = "INSERT INTO images (image, owner) VALUES ('$filename', '$owner')";
    mysqli_query($db, $sql);
    header("Location: ../home.php");
    exit();
?>
