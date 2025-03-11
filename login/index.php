<?php
include("../assets/functions.php");
include("../assets/getid3/getid3.php");
include("../assets/templates/head.php");

if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true){
header("Location: ../");
}

?>
<title>Log in | Minifourchan</title>
<h1><a href="../index.php" style="position:absolute;left:1em;top:2em;">Home</a></h1>
<?php
include("../assets/templates/login_page.php");
?>
<a href="register.php" style="">Registrera</a>
