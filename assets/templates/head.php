<?php
session_start();
?>
<!DOCTYPE html>
<html lang="sv">

<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="/Minifourchan/assets/css/style.css">
  <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous">
  </script>
  <script src="/Minifourchan/assets/js/script.js"></script>
  <link rel="shortcut icon" href="/Minifourchan/assets/img/favicon.ico">
</head>

<body>
  <div class="boardBanner">
    <div id="bannerCnt">
      <img alt="4chan" src="/Minifourchan/assets/img/title/<?php echo rand(1, 3);?>.png">
    </div>
    <div class="boardTitle">/b/ - Random</div>
  </div>
  <hr style="width:90%;">
  <?php
  if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true){
  echo '<h3>Välkommen, <span style="color:purple;">' . $_SESSION['username'] . '</span>!
</h3>';
}
?>
