<?php
include('../functions.php');

$username = htmlspecialchars(trim($_POST['username']), ENT_QUOTES, 'UTF-8');
$password = htmlspecialchars(md5(trim($_POST['password'])), ENT_QUOTES, 'UTF-8');

if(empty(trim($_POST['password']))){
  die('errorPass');
}

if(empty($username)){
  die('errorUser');
}


$sql = "SELECT * FROM users WHERE username='$username'";
$results = $conn->query($sql);

if ($results->num_rows < 1){
  die('error');
}

foreach ($results as $result) {
    $dbPassword = $result['password'];
    $id = $result['user_id'];
    $dbUsername =  $result['username'];

    if ($dbPassword == $password) {
        session_start();
        $_SESSION['logged_in'] = true;
        $_SESSION['id'] = $id;
        $_SESSION['username'] = $dbUsername;
    } else {
        die('error');
    }
}
