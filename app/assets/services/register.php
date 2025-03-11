<?php
include("../functions.php");

$username = htmlspecialchars(trim($_POST['username']), ENT_QUOTES, 'UTF-8');
$password = htmlspecialchars(md5(trim($_POST['password'])), ENT_QUOTES, 'UTF-8');
$password_conf = htmlspecialchars(md5(trim($_POST['password-conf'])), ENT_QUOTES, 'UTF-8');
$email = htmlspecialchars(trim($_POST['email']), ENT_QUOTES, 'UTF-8');

if (empty($username) || empty($_POST['password']) || empty($email)) {
    die('errorEmpty');
}

if ( preg_match('/\s/',$username) ){
  die('errorSpaces');
}

#Check if user exists in database
$userQuery = "SELECT * FROM users WHERE username = '$username'";
$result = $conn->query($userQuery);
$count = $result->num_rows;

if ($count > 0) {
    die('userExists');
}


if ($password !== $password_conf) {
    die('passwordMatch');
} else {
    $sql = "INSERT INTO
          users (username, password, email)
          VALUES
          ('$username','$password','$email')
          ";
    $conn->query($sql);
    echo $username . ' ID: ' . mysqli_insert_id($conn);
}
