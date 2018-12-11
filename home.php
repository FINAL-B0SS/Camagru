<!DOCTYPE html>
<html>
<title>Home</title>
<link rel="stylesheet" href="styles/home_style.css">

<?php

  include_once 'includes/dbh.inc.php';
  include 'header.php';
  include 'camera.php';
  $db = $conn;
  $owner = $_SESSION['email'];

  // Initialize message variable
  $msg = "";
  // If upload button is clicked ...
  if (isset($_POST['upload']) AND $_FILES['image']['size'] > 0) {
    // Get image name
    $ext = explode('.',  $_FILES['image']['name']);
    $_FILES['image']['name'] = uniqid().'.'.$ext[1];
    //$_FILES['image']['name'] = explode('.',  $_FILES['image']['name']);
    $image = $_FILES['image']['name'];
  	// image file directory
    $target = "images/".basename($image);
  	$sql = "INSERT INTO images (image, owner) VALUES ('$image', '$owner')";
  	// execute query
  	mysqli_query($db, $sql);

  	if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
      $msg = "Image uploaded successfully";
  	}else{
  		$msg = "Failed to upload image";
  	}
  }
  $result = mysqli_query($db, "SELECT * FROM images WHERE owner='$owner'");
?>

<head>

</head>
<body>
<form method="POST" action="home.php" enctype="multipart/form-data">
  	<input type="hidden" name="size" value="1000000">
  	<div>
  	  <input type="file" name="image">
  	</div>
  	<div>
  		<button type="submit" name="upload">POST</button>
  	</div>
  </form>
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