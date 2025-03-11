<?php
include("../functions.php");
session_start();

if(!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] === false){
  header("Location: /Minifourchan");
}

// if(!isset($_GET['id'])){
//   header("Location: /Minifourchan");
// }

$username = $_SESSION['username'];
$post_id = $_POST['id'];

//Check if post exists and is by the logged in users username
$sql = "SELECT * FROM posts WHERE post_id=$post_id AND post_user='$username';";
$result = $conn->query($sql);
$count = $result->num_rows;

if($count > 0 && $count < 2 || $_SESSION['username'] == 'admin'){
  //Delete database data
  $delPOST = "DELETE FROM posts WHERE post_id=$post_id;";
  $delCMT  = "DELETE FROM comments WHERE post_id=$post_id;";
  $conn->query($delPOST);
  $conn->query($delCMT);

  //Delete media
  $directory = $_SERVER["DOCUMENT_ROOT"];
  $directory .= '/Minifourchan/upload/' . $post_id . '/*';

  $files = glob($directory);

  foreach ($files as $file) {
      unlink($file);
  }

  rmdir('../../upload/' . $post_id . '/');

  header("Location: /Minifourchan");
}
