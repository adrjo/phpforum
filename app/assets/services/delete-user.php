<?php
include("../functions.php");
session_start();

if(!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true || $_SESSION['username'] !== 'admin') {
  header("Location: /Minifourchan");
  die();
}

$user_id = $_POST['id'];

$sql = "DELETE FROM users WHERE user_id=$user_id";
$conn->query($sql);
