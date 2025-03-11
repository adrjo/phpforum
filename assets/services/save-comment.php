<?php
session_start();

if(!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] === false){
  die('loggedOut');
}

$flag = 0;
$flagimage = 0;

$post_id      = htmlspecialchars($_POST['post_id'], ENT_QUOTES, 'UTF-8');
$comment_user = $_SESSION['username'];
$comment_text = htmlspecialchars($_POST['comment_text'], ENT_QUOTES, 'UTF-8');

if (empty($comment_user)) {
    $comment_user = 'Anonym';
}

if (empty(trim($comment_text))) {
    $flag = 1;
    echo 'txtEmpty';
}

if (mb_strlen($comment_text) > 2000) {
    $flag = 1;
    echo 'errorLength';
}

if (empty($_FILES['image']['name'])) {
    $flagimage = 1;
    $final_image = '';
}

if ($_FILES['image']['size'] > 2000000) {
    $flag = 1;
    echo 'errorSize';
}

$valid_extensions = array('jpeg', 'jpg', 'png', 'gif', 'bmp', 'webm'); // valid extensions



if ($flag == 0) {
    if ($flagimage == 0) {
        $img = $_FILES['image']['name'];
        $tmp = $_FILES['image']['tmp_name'];

        // get uploaded file's extension
        $ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));

        // can upload same image using rand function
        $final_image = time().rand(100, 999). '.' .$ext;

        // check's valid format
        if (!in_array($ext, $valid_extensions)) {
            die('errorExt');
        }
    }
    //include database configuration file
    include_once '../functions/db.php';

    //insert form data in the database
    $sql = "INSERT INTO
          comments (comment_user,comment_text,file_name,post_id)
          VALUES
          ('$comment_user','$comment_text','$final_image','$post_id')
          ";
    $result = $conn->query($sql);


    if ($flagimage == 0) {
        $path = '../../upload/' . $post_id . '/' . $final_image; // upload directory

        if (move_uploaded_file($tmp, $path)) {
            // echo '<img src=' . $path . '>';


    //echo $insert?'ok':'err';
        }
    }
    echo mysqli_insert_id($conn);
    // }
  // else
  // {
  // echo 'invalid';
}
