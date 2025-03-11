<?php
include("../functions.php");

$flag = 0;
$post_user = $_POST['post_user'];
$post_text = $_POST['post_text'];

if(empty($post_user)){
  $post_user = 'Anonym';
}

if(empty($post_text)){
  $flag = 1;
}

if (mb_strlen($post_text) > 240){
  $flag = 1;
  $errorLength = 'Max characters is 240.';
}

if ($flag == 0){
$sql = "
    INSERT INTO posts
    (post_user,post_text,post_likes)
    VALUES
    ('$post_user','$post_text',0)
  ";
$results = $conn->query($sql);

echo mysqli_insert_id($conn);
}else {
  echo 'Characters: ' . mb_strlen($post_text) . ' / 240';
}
 ?>
