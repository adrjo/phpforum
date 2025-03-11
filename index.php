<?php
include("assets/functions.php");
include("assets/getid3/getid3.php");
include("assets/templates/head.php");
?>
<title>Minifourchan</title>
<?php

if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
  echo '<h1><a href="/Minifourchan/login/logout.php" style="position:absolute;right:1em;top:2em;">Logga ut</a></h1>';
}else{
  echo '<h1><a href="/Minifourchan/login" style="position:absolute;right:2em;top:2em;">Logga in</a></h1>';
}

if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] && $_SESSION['username'] == 'admin'){
  echo '<h1><a href="admin" style="position:absolute;left:1em;top:2em;">Adminpanel</a></h1>';
}


if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    include("assets/templates/new_post.php");
}
include("assets/templates/feed.php");
?>
</body>
</html>
