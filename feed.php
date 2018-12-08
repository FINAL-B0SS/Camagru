<!DOCTYPE html>
<html>
<title>Feed</title>
<link rel="stylesheet" href="home_style.css">

<?php

  include_once 'includes/dbh.inc.php';
  include 'header.php';
  $db = $conn;
  $owner = $_SESSION['email'];
  $result = mysqli_query($db, "SELECT * FROM images");
?>

<head>

</head>
<body>
<div id="content">
  <?php
    $email = $_SESSION['email'];
    while ($row = mysqli_fetch_array($result)) {
      $_SESSION['img'] = $row['image'];
      echo "<div id='img_div'>
              <img src='images/".$row['image']."' >
              <form method='POST' action='includes/comment-like.inc.php'>
                <textarea class='textbox' name='comments' readonly>";
                $img = $row['image'];
                $comments = mysqli_query($db, "SELECT * FROM comments WHERE image='$img'");
                while ($say = mysqli_fetch_array($comments)) {
                    echo $say['owner'].': '.$say['comment'].'&#13;';
                }
          echo "</textarea><br>
                <input class='commentBox' type='text' name='comment' placeholder='Leave a comment'>
                <button type='submit' name='comment-btn' value=". $_SESSION['img'].">Comment</button>
                <button type='submit' name='like' value=". $_SESSION['img'].">Like</button>";
                echo "👍".$row['likes'].
              "</form>";
          if ($row['owner'] == $email) {
              echo "<form method='POST' action='includes/delete.inc.php'>
                      <button type='submit' name='delete' value='".$row['image']."'>Delete Post</button>
                    </form>";
          } 
          echo "</div>";
    }
  ?>
</div>

</body>
</html>