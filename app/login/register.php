<?php
include("../assets/functions.php");
include("../assets/getid3/getid3.php");
include("../assets/templates/head.php");

if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true){
header("Location: ../");
}

?>
<title>Register | Mini4chan</title>
<h1><a href="../index.php" style="position:absolute;left:1em;top:1em;">Home</a></h1>
<?php
include("../assets/templates/register_page.php");
?>
<a href="index.php">Logga in</a>
