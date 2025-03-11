<?php
include("../functions.php");
include("../getid3/getid3.php");
session_start();

$post_id=0;

if ($_GET) {
    $post_id = $_GET['post_id'];
}
if (empty($post_id)) {
    die();
}

  $sql ="
          SELECT
          post_id,post_user,post_text,post_likes,date,file_name
           FROM
           posts
           WHERE post_id=$post_id
        ";
  $posts = $conn->query($sql);

  $getID3 = new getID3;

  $regex = ['@(https?://([-\w\.]+)+(:\d+)?(/([-\w/_\.]*(\?\S+)?)?)?)@','/(?:\r|[\r])/','/(^&gt;.*$)/m','/\[spoiler\][\r\n]*(.+?)\[\/spoiler\][\r\n]*/si',];
  $replacement = ['<a href="$1" target="_blank">$1</a>','<br>','<span style="color:#789922">$1</span>','<s>$1</s>'];


  foreach ($posts as $post) {
      $text = preg_replace($regex, $replacement, $post['post_text']);
      $dt = new DateTime($post['date']);
      $dateFormatted = $dt->format('d/m/y(D) H:i');

      if (empty($post['file_name'])) {
          echo '
  <div class="thread">
    <div class="post op">
      <div class="postInfo">';
      if($post['post_user'] == 'admin'){
        echo '<span style="color:purple;" class="name">admin</span> ';
      }else{
        echo '<span class="name">' . $post['post_user'] . '</span> ';
      }
        echo $dateFormatted . ' No.' . $post['post_id'] .
       '&nbsp;[<a href="post/?id=' . $post['post_id'] . '">Svara</a>]';
        if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true && $post['post_user'] == $_SESSION['username'] || isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true && $_SESSION['username'] == 'admin'){
          echo ' [<a href="#a" post_id="' . $post['post_id'] . '" class="delBtn">Radera</a>]';
        }
        echo ' [<a href="assets/services/save-like.php?id=' . $post['post_id'] . '">Gilla</a>]
        [' . $post['post_likes'] . ']
        </div>
      <blockquote class="postMessage">' . $text . '</blockquote>
    </div>
  </div>
  <hr>
  ';
      } else {
          $ext = strtolower(pathinfo($post['file_name'], PATHINFO_EXTENSION));
          list($width, $height) = getimagesize('../../upload/' . $post['post_id'] . '/' . $post['file_name']);
          $fileSize = filesize('../../upload/' . $post['post_id'] . '/' . $post['file_name']) . ' bytes';
          $fileSize = ceil($fileSize * 0.001) . ' KB';
          if ($fileSize > 1000) {
              $fileSize = $fileSize * 0.001 . ' MB';
          }
          $videoFile = $getID3->analyze('../../upload/' . $post['post_id'] . '/' . $post['file_name']);

          if ($ext == 'webm') {
              echo '<div class="thread">
    <div class="post op">
      <div class="fileText">File:
        <a href="upload/' . $post['post_id'] . '/' . $post['file_name'] . '" target="_blank">' . $post['file_name'] . '</a>
        (' . $fileSize . ', ' . $videoFile['video']['resolution_x'] . 'x' . $videoFile['video']['resolution_y'] . ')</div>
        <a href="#a" onclick="$(this).toggleClass(`largeImg`);">
          <video class="postImg" style="max-width:' . $videoFile['video']['resolution_x'] . 'px;" controls poster>
            <source src="upload/' . $post['post_id'] . '/' . $post['file_name'] . '" type="video/webm">
          </video>
        </a>
      <div class="postInfo">';
      if($post['post_user'] == 'admin'){
        echo '<span style="color:purple;" class="name">admin</span> ';
      }else{
        echo '<span class="name">' . $post['post_user'] . '</span> ';
      }
        echo $dateFormatted . ' No.' . $post['post_id'] . '&nbsp;
         [<a href="post/?id=' . $post['post_id'] . '">Svara</a>] ';
         if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true && $post['post_user'] == $_SESSION['username'] || isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true && $_SESSION['username'] == 'admin'){
           echo ' [<a href="#a" post_id="' . $post['post_id'] . '" class="delBtn">Radera</a>]';
         }
         echo ' [<a href="assets/services/save-like.php?id=' . $post['post_id'] . '">Gilla</a>]
        [' . $post['post_likes'] . ']
      </div>
      <blockquote class="postMessage">'
        . $text .
      '</blockquote>
    </div>
  </div>
  <hr style="clear:both;">
  ';
          } else {
              echo '<div class="thread">
    <div class="post op">
      <div class="fileText">File:
        <a href="upload/' . $post['post_id'] . '/' . $post['file_name'] . '" target="_blank">
        ' . $post['file_name'] .
        '</a>
        (' . $fileSize . ', ' . $width . 'x' . $height . ')
      </div>
      <a href="#a" onclick="$(this).toggleClass(`largeImg`);">
        <img class="postImg" src="upload/' . $post['post_id'] . '/' . $post['file_name'] . '" style="max-width:' . $width . 'px;">
      </a>
      <div class="postInfo">';
      if($post['post_user'] == 'admin'){
        echo '<span style="color:purple;" class="name">admin</span> ';
      }else{
        echo '<span class="name">' . $post['post_user'] . '</span> ';
      }
        echo $dateFormatted . ' No.' . $post['post_id'] . '&nbsp;
         [<a href="post/?id=' . $post['post_id'] . '">Svara</a>]';
         if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true && $post['post_user'] == $_SESSION['username'] || isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true && $_SESSION['username'] == 'admin'){
           echo ' [<a href="#a" post_id="' . $post['post_id'] . '" class="delBtn">Radera</a>]';
         }
         echo ' [<a href="assets/services/save-like.php?id=' . $post['post_id'] . '">Gilla</a>]
         [' . $post['post_likes'] . ']
      </div>
      <blockquote class="postMessage">' . $text . '</blockquote>
    </div>
  </div>
  <hr style="clear:both;">
  ';
          }
      }
  }
?>
<script src="/Minifourchan/assets/js/script.js"></script>
