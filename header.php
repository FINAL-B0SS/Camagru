<?php
    session_start();
?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<link rel="stylesheet" href="home_style.css">
<style>

ul {
    list-style-type: none;
    margin: 0;
    padding: 0;
    overflow: hidden;
    background-color: #333;
}

li {
    float: left;
}

li a {
    display: block;
    color: white;
    text-align: center;
    padding: 14px 16px;
    text-decoration: none;
    font-weight: normal;
    font-weight: bold;
    font-weight: 900;
    font-size: 150%;
}

li a:hover:not(.active) {
    background-color: #111;
}

.active {
    background-color: #4CAF50;
}
</style>
</head>
<body>

<ul>
  <li><a href="home.php">My Post</a></li>
  <li><a href="feed.php">Feed</a></li>
  <li><a href="settings.php">Settings</a></li>
  <li><a href="index.php?login=logout">Logout</a></li>
  <li><a href="#"><?php echo $_SESSION['email'] ?></a></li>

</ul>

</body>
</html>