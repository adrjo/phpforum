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
$comment_id = $_POST['id'];

//Check if comment exists and is by the logged in users username
$sql = "SELECT * FROM comments WHERE comment_id=$comment_id AND comment_user='$username';";
$results = $conn->query($sql);
$count = $results->num_rows;

if($count > 0 && $count < 2 || $_SESSION['username'] == 'admin'){
  //Delete media
  $directory = $_SERVER["DOCUMENT_ROOT"];
  foreach($results as $result){
    $directory .= '/Minifourchan/upload/' . $result['post_id'] . '/';
    unlink($directory . $result['file_name']);
  }

  //Delete database data
  $delCMT  = "DELETE FROM comments WHERE comment_id=$comment_id;";
  $conn->query($delCMT);


  // header("Location: /Minifourchan");
}
