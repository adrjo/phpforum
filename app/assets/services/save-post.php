<?php
session_start();

if(!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] === false){
  die('loggedOut');
}

$flag = 0;
$flagimage = 0;

$post_user = $_SESSION['username'];
$post_text = htmlspecialchars($_POST['post_text'], ENT_QUOTES, 'UTF-8');

if (empty($post_user)) {
    $post_user = 'Anonym';
}

if (empty(trim($post_text))) {
    $flag = 1;
    echo 'txtEmpty';
}

if (mb_strlen($post_text) > 2000) {
    $flag = 1;
    echo 'errorLength';
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
          posts (post_user,post_text,post_likes,file_name)
          VALUES
          ('$post_user','$post_text',0,'$final_image')
          ";

    $result = $conn->query($sql);
    if ($flagimage == 0) {
        $makeDir = mkdir('../../upload/' . mysqli_insert_id($conn), 0777);
        $path = '../../upload/' . mysqli_insert_id($conn) . '/' . $final_image; // upload directory

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
