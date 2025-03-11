<?php
if ($_GET) {
    $page = $_GET['page'];
} else {
    $page = 0;
}
if ($page > 0) {
    $start = 15 * ($page - 1);
} else {
    $start = 0;
}
$rows = 15;

$countPosts ="SELECT * FROM posts";

$postCount = $conn->query($countPosts);
$row_count = $postCount->num_rows;
$pages = ceil(($row_count / $rows) + 0.1) ;
echo '<ul class="pages">';
for ($i=1; $i<$pages; $i++) {
    echo '<li><a href="?page=' . $i . '">' . $i . '</a></li> ';
}
echo '</ul>';

$postSql ="
        SELECT
        post_id,post_user,post_text,post_likes,date,file_name
         FROM
         posts
         ORDER BY
         post_id
         DESC
         LIMIT $start, $rows
      ";

$posts = $conn->query($postSql);

?>
<div class="thread">
  <div class="post op">
    <a href="#a" onclick="$(this).toggleClass(`largeImg`);"><img class="postImg" src="assets/img/title/3.png" style="max-width:300px;"></a>
    <div class="postInfo">
      <span style="color:purple;" class="name">Anonym ## Mod</span>
      2019-02-04 23:17:01 No.0 &nbsp;<img src="assets/img/sticky.gif" title="Sticky"> &nbsp;[<a href="#a" onclick="alert('Denna tråd är låst.');">Svara</a>]
    </div>
    <blockquote class="postMessage">
      Välkommen till mini-4chan.<br>
      <span style="color:#789922;">>Skriv '>' innan din text för att göra den grön.</span><br>
      Alla URLs blir automatiskt en länk. Ex. <a href="http://youtube.com">http://youtube.com</a><br>
      Använd [spoiler][/spoiler] för <s>spoilers.</s><br>
      Max text per inlägg är 2000.
    </blockquote>
  </div>
</div>
<hr style="clear:both;">

<div class="" id="new_post"></div>
<?php

$getID3 = new getID3;


$regex = [
          '@(https?://([-\w\.]+)+(:\d+)?(/([-\w/_\.]*(\?\S+)?)?)?)@',
          '/(?:\r|[\r])/',
          '/(^&gt;.*$)/m',
          '/\[spoiler\][\r\n]*(.+?)\[\/spoiler\][\r\n]*/si',
        ];
$replacement = [
                '<a href="$1" target="_blank">$1</a>',
                '<br>',
                '<span style="color:#789922">$1</span>',
                '<s>$1</s>'
              ];

// $commentCount = 'SELECT * FROM comments WHERE post_id=139';
// count($conn->query($commentCount));

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
      if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] && $post['post_user'] == $_SESSION['username']
      || isset($_SESSION['logged_in']) && $_SESSION['logged_in'] && $_SESSION['username'] == 'admin'){
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
        list($width, $height) = getimagesize('upload/' . $post['post_id'] . '/' . $post['file_name']);
        $fileSize = filesize('upload/' . $post['post_id'] . '/' . $post['file_name']) . ' bytes';
        $fileSize = ceil($fileSize * 0.001) . ' KB';
        if ($fileSize > 1000) {
            $fileSize = $fileSize * 0.001 . ' MB';
        }
        $videoFile = $getID3->analyze('upload/' . $post['post_id'] . '/' . $post['file_name']);

        if ($ext == 'webm') {
            echo '
<div class="thread">
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
       if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] && $post['post_user'] == $_SESSION['username']
       || isset($_SESSION['logged_in']) && $_SESSION['logged_in'] && $_SESSION['username'] == 'admin'){
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
       if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] && $post['post_user'] == $_SESSION['username']
       || isset($_SESSION['logged_in']) && $_SESSION['logged_in'] && $_SESSION['username'] == 'admin'){
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
echo '<ul class="pages" style="clear:both;">';
  for ($i=1; $i<$pages; $i++) {
      echo '<li><a href="?page=' . $i . '">' . $i . '</a></li> ' ;
  } echo '</ul>' ;

  include('assets/templates/overlay.php');
