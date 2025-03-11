<?php
include("assets/functions.php");
include("assets/getid3/getid3.php");
include("assets/templates/head.php");

if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true){
echo 'hi ' . $_SESSION['username'];
}else{
  echo 'no';
}
