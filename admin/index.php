<?php

include("../assets/getid3/getid3.php");
include("../assets/functions.php");
include("../assets/templates/head.php");

if(!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true || $_SESSION['username'] !== 'admin') {
  header("Location: /Minifourchan");
}

if($_GET && $_SESSION['username'] == 'admin'){
  echo '<a href="index.php" style="position:absolute;left:1em;top:1em;text-decoration:underline;">&larr; Tillbaka till adminpanel</a>';
  include("../assets/services/list_posts.php");

  exit();
}

echo '<h1><a href="../index.php" style="position:absolute;left:1em;top:2em;">Home</a></h1>';
include("../assets/services/list_users.php");
