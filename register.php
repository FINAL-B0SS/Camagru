<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale-1.0, maximum-scale=1.0, minimum-scale=0">
    <meta http-equiv="X-UA-Compatible" content="ie-edge"> 
    <title>Register</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="styles/style.css">
</head>
<body>

<!--  Content  -->
<article>
<div class="container" style="margin-top: 100px;">
        <div class="row justify-content-center">
            <div class="col-md-6 col-md-offset-3" align="center">

                    <img src="images/logo.png" align="center" height="100" width="500"><br><br>
                    <?php
                     if (isset($_GET['signup'])) {
                        echo $_GET['signup'];
                     }
                    ?>
                    <form method="post" action="includes/signup.inc.php">
                        <input class="form-control" name="name" placeholder="Name"><br>
                        <input class="form-control" name="email" ptype="email" placeholder="email"><br>
                        <input class="form-control" name="password"  type="password" placeholder="Password"><br>
                        <input class="form-control" name="cpassword"  type="password" placeholder="Confirm Password"><br>
                        <input class="btn bnt-primary" type="submit" name="submit" value="register"><br><br>
                    </form>
                    <form action="index.php">
                        <input class="btn bnt-primary" type="submit" name="Login" value="login">
                    </form>

                </div>
            </div>    
        </div>
    </div>
</article>
  
<!--  Video is muted & autoplays, placed after major DOM elements for performance & has an image fallback  -->
<video autoplay loop id="video-background" muted plays-inline>
  <source src="videos/registration_background.mp4" type="video/mp4">
</video>
</body>
</html>