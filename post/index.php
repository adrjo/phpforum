<?php
include("../assets/functions.php");
include("../assets/getid3/getid3.php");
include("../assets/templates/head.php");

$post_id=1;

if ($_GET) {
    $post_id = $_GET['id'];


    $postSql ="
          SELECT
          *
          FROM
          posts
          WHERE post_id=$post_id
        ";
    $posts = $conn->query($postSql);

    $commentSql ="
            SELECT
            *
            FROM
            comments
            WHERE post_id=$post_id
            ORDER BY
            comment_id
            ASC
            ";
    $comments = $conn->query($commentSql);
}
?>
<title>POST <?php echo $post_id?> | Minifourchan</title>
<h1><a href="../index.php" style="position:absolute;left:1em;top:1em;">Home</a></h1>
<?php
if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true){
  include('../assets/templates/new_comment.php');
}
if ($_GET) {
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

    foreach ($posts as $post) {
        $text = preg_replace($regex, $replacement, $post['post_text']);
        $dt = new DateTime($post['date']);
        $dateFormatted = $dt->format('d/m/y(D) H:i');

        if (empty($post['file_name'])) {
            echo '
            <div class="post op">
              <div class="postInfo">';
              if($post['post_user'] == 'admin'){
                echo '<span style="color:purple;" class="name">' . $post['post_user'] . '</span> ';
              }else{
                echo '<span class="name">' . $post['post_user'] . '</span> ';
              }
                echo $dateFormatted . ' No.' . $post['post_id'];
                 if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] && $post['post_user'] == $_SESSION['username']
                 || isset($_SESSION['logged_in']) && $_SESSION['logged_in'] && $_SESSION['username'] == 'admin'){
                   echo ' [<a href="#a" post_id="' . $post['post_id'] . '" class="delBtn">Radera</a>]';
                 }
                 echo ' [<a href="../assets/services/save-like.php?id=' . $post['post_id'] . '">Gilla</a>]
                 [' . $post['post_likes'] . ']
              </div>
              <blockquote class="postMessage">' . $text . '</blockquote>
            </div>';
        } else {
            $ext = strtolower(pathinfo($post['file_name'], PATHINFO_EXTENSION));
            list($width, $height) = getimagesize('../upload/' . $post['post_id'] . '/' . $post['file_name']);
            $fileSize = filesize('../upload/' . $post['post_id'] . '/' . $post['file_name']) . ' bytes';
            $fileSize = ceil($fileSize * 0.001) . ' KB';
            if ($fileSize > 1000) {
                $fileSize = $fileSize * 0.001 . ' MB';
            }
            $videoFile = $getID3->analyze('../upload/' . $post['post_id'] . '/' . $post['file_name']);

            if ($ext == 'webm') {
                echo '
                <div class="post op">
                  <div class="fileText">File:
                    <a href="../upload/' . $post['post_id'] . '/' . $post['file_name'] . '" target="_blank">' . $post['file_name'] . '</a>
                    (' . $fileSize . ', ' . $videoFile['video']['resolution_x'] . 'x' . $videoFile['video']['resolution_y'] . ')
                  </div>
                  <a href="#a" onclick="$(this).toggleClass(`largeImg`);">
                    <video class="postImg" width="200px" controls poster>
                      <source src="../upload/' . $post['post_id'] . '/' . $post['file_name'] . '" type="video/webm">
                    </video>
                  </a>
                  <div class="postInfo">';
                  if($post['post_user'] == 'admin'){
                    echo '<span style="color:purple;" class="name">' . $post['post_user'] . '</span> ';
                  }else{
                    echo '<span class="name">' . $post['post_user'] . '</span> ';
                  }
                    echo $dateFormatted . ' No.' . $post['post_id'];
                   if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] && $post['post_user'] == $_SESSION['username']
                   || isset($_SESSION['logged_in']) && $_SESSION['logged_in'] && $_SESSION['username'] == 'admin'){
                     echo ' [<a href="#a" post_id="' . $post['post_id'] . '" class="delBtn">Radera</a>]';
                   }
                   echo ' [<a href="../assets/services/save-like.php?id=' . $post['post_id'] . '">Gilla</a>]
                   [' . $post['post_likes'] . ']
                  </div>
                  <blockquote class="postMessage">' . $text . '</blockquote>
                </div>';
            } else {
                echo '
                <div class="post op">
                  <div class="fileText">File:
                    <a href="../upload/' . $post['post_id'] . '/' . $post['file_name'] . '" target="_blank">' . $post['file_name'] . '</a>
                    (' . $fileSize . ', ' . $width . 'x' . $height . ')
                  </div>
                  <a href="#a" onclick="$(this).toggleClass(`largeImg`);">
                    <img class="postImg" src="../upload/' . $post['post_id'] . '/' . $post['file_name'] . '" style="max-width:' . $width . 'px;">
                  </a>
                  <div class="postInfo">';
                  if($post['post_user'] == 'admin'){
                    echo '<span style="color:purple;" class="name">' . $post['post_user'] . '</span> ';
                  }else{
                    echo '<span class="name">' . $post['post_user'] . '</span> ';
                  }
                    echo $dateFormatted . ' No.' . $post['post_id'];
                   if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true && $post['post_user'] == $_SESSION['username'] || isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true && $_SESSION['username'] == 'admin'){
                     echo ' [<a href="#a" post_id="' . $post['post_id'] . '" class="delBtn">Radera</a>]';
                   }
                   echo ' [<a href="../assets/services/save-like.php?id=' . $post['post_id'] . '">Gilla</a>]
                   [' . $post['post_likes'] . ']
                  </div><blockquote class="postMessage">' . $text . '</blockquote>
                </div>';
            }
        }
    }

    foreach ($comments as $comment) {
        $cmtText = preg_replace($regex, $replacement, $comment['comment_text']);
        $dt = new DateTime($comment['date']);
        $dateFormatted = $dt->format('d/m/y(D) H:i');


        if (empty($comment['file_name'])) {
            echo '
            <div class="post reply">
              <div class="postInfo">';
              if($comment['comment_user'] == 'admin'){
                echo '<span style="color:purple;" class="name">' . $comment['comment_user'] . '</span> ';
              }else{
                echo '<span class="name">' . $comment['comment_user'] . '</span> ';
              }
                echo $dateFormatted . ' No.' . $comment['comment_id'];
                 if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] && $comment['comment_user'] == $_SESSION['username'] 
                 || isset($_SESSION['logged_in']) && $_SESSION['logged_in'] && $_SESSION['username'] == 'admin'){
                   echo ' [<a href="#a" comment_id="' . $comment['comment_id'] . '" class="delBtn">Radera</a>]';
                 }
              echo '</div>
              <blockquote class="postMessage">' . $cmtText . '</blockquote>
            </div>';
        } else {
            $ext = strtolower(pathinfo($comment['file_name'], PATHINFO_EXTENSION));
            list($width, $height) = getimagesize('../upload/' . $comment['post_id'] . '/' . $comment['file_name']);
            $fileSize = filesize('../upload/' . $comment['post_id'] . '/' . $comment['file_name']) . ' bytes';
            $fileSize = ceil($fileSize * 0.001) . ' KB';
            if ($fileSize > 1000) {
                $fileSize = $fileSize * 0.001 . ' MB';
            }
            $videoFile = $getID3->analyze('../upload/' . $comment['post_id'] . '/' . $comment['file_name']);

            if ($ext == 'webm') {
                echo '
                <div class="post reply">
                  <div class="postInfo">';
                  if($comment['comment_user'] == 'admin'){
                    echo '<span style="color:purple;" class="name">' . $comment['comment_user'] . '</span> ';
                  }else{
                    echo '<span class="name">' . $comment['comment_user'] . '</span> ';
                  }
                    echo $dateFormatted . ' No.' . $comment['comment_id'];
                     if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true && $comment['comment_user'] == $_SESSION['username'] || isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true && $_SESSION['username'] == 'admin'){
                       echo ' [<a href="#a" comment_id="' . $comment['comment_id'] . '" class="delBtn">Radera</a>]';
                     }
                  echo '</div>
                  <div class="fileText">File:
                    <a href="../upload/' . $comment['post_id'] . '/' . $comment['file_name'] . '" target="_blank">' . $comment['file_name'] . '</a>
                    (' . $fileSize . ', ' . $videoFile['video']['resolution_x'] . 'x' . $videoFile['video']['resolution_y'] . ')
                  </div>
                  <a href="#a" onclick="$(this).toggleClass(`largeImg`);">
                    <video class="postImg" width="200px" controls poster>
                      <source src="../upload/' . $comment['post_id'] . '/' . $comment['file_name'] . '" type="video/webm">
                    </video>
                  </a>
                  <blockquote class="postMessage">' . $cmtText . '</blockquote>
                </div>';
            } else {
                echo '
                <div class="post reply">
                  <div class="postInfo">';
                  if($comment['comment_user'] == 'admin'){
                    echo '<span style="color:purple;" class="name">' . $comment['comment_user'] . '</span> ';
                  }else{
                    echo '<span class="name">' . $comment['comment_user'] . '</span> ';
                  }
                    echo $dateFormatted . ' No.' . $comment['comment_id'];
                     if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true && $comment['comment_user'] == $_SESSION['username'] || isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true && $_SESSION['username'] == 'admin'){
                       echo ' [<a href="#a" comment_id="' . $comment['comment_id'] . '" class="delBtn">Radera</a>]';
                     }
                  echo '</div>
                  <div class="fileText">File:
                    <a href="../upload/' . $comment['post_id'] . '/' . $comment['file_name'] . '" target="_blank">' . $comment['file_name'] . '</a>
                    (' . $fileSize . ', ' . $width . 'x' . $height . ')
                  </div>
                  <a href="#a" onclick="$(this).toggleClass(`largeImg`);">
                    <img class="postImg" src="../upload/' . $comment['post_id'] . '/' . $comment['file_name'] . '" style="max-width:' . $width . 'px;">
                  </a>
                  <blockquote class="postMessage">' . $cmtText . '</blockquote>
                </div>';
            }
        }
    }
}

  include('../assets/templates/overlay.php');

 ?>
<div class="" id="new_comment"></div>
