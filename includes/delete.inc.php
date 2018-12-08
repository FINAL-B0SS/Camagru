<?php

    $img = $_POST['delete'];
    include_once 'dbh.inc.php';
    $sql = "DELETE FROM images WHERE image='$img';";
    mysqli_query($conn, $sql);
    header("Location: ../home.php");