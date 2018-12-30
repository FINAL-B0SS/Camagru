# <a name="top">Camagru</a>

Camagru is an Instagram-like web application for capturing and sharing photos. Take a photo with your webcam (or upload an image) and select one of several cute and fun dog filters to embellish your photo before posting and sharing with your friends! Then head on to the Gallery to like and/or comment on any of the posted photos. Please check it out by creating an account or you may log in as "guest" with password "password123". 

## Contents

[Tehnologies Used](#technology) | [Preview Camagru](#preview) | [Features](#features) | [Run Camagru Locally](#run)

## <a name="technology">Technologies Used</a>

* PHP
* MySQL
* HTML/CSS

<a href="#top">↥ back to top</a>

## <a name="features">Features</a>

* User registration with account activation via email
* Login, logout, and forgot password processes
* Home page: view, delete or post photos created by applying dog-themed filters to an uploaded image or one taken with the webcam
* Gallery page with infinite scroll: view, like or comment on any shared photos
* Settings page: modify account information and notification preference
* Notify owner of the post via email when there is a new comment

<a href="#top">↥ back to top</a>

## <a name="run">Run Camagru Locally</a>

#### `Step 1` - clone the repo
  
```bash
$ git clone https://github.com/Maljean/Camagru.git
```

#### `Step 2` - edit database connection info
  
Modify config/database.php as required

#### `Step 3` - start your localhost server 
 
Example for using Apache on Windows

```bash
$ service apache2 start
$ service mysql start
```

#### `Step 4` - in browser, open [http://localhost:80/config/setup.php](http://localhost:80/config/setup.php)

This will create the database and tables in MySQL. Now your very own Camagru web application is ready!

<a href="#top">↥ back to top</a>
