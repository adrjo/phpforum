<?php
include("../functions.php");
include("../getid3/getid3.php");

session_start();

$comment_id=0;
$flag = 0;

if ($_GET) {
    $comment_id = $_GET['comment_id'];
}
if (empty($comment_id)) {
    $flag = 1;
}

if ($flag == 0) {
    $sql ="
            SELECT
            comment_id,comment_user,comment_text,date,file_name,post_id
            FROM
            comments
            WHERE comment_id=$comment_id
            ";
    $comments = $conn->query($sql);

    $getID3 = new getID3;

    $regex = ['@(https?://([-\w\.]+)+(:\d+)?(/([-\w/_\.]*(\?\S+)?)?)?)@','/(?:\r|[\r])/','/(^&gt;.*$)/m','/\[spoiler\][\r\n]*(.+?)\[\/spoiler\][\r\n]*/si',];
    $replacement = ['<a href="$1" target="_blank">$1</a>','<br>','<span style="color:#789922">$1</span>','<s>$1</s>'];

    foreach ($comments as $comment) {
        $cmtText = preg_replace($regex, $replacement, $comment['comment_text']);
        $dt = new DateTime($comment['date']);
        $dateFormatted = $dt->format('d/m/y(D) H:i');


        if (empty($comment['file_name'])) {
            echo '
            <div class="post reply">
              <div class="postInfo">';
              if($comment['comment_user'] == 'admin'){
                echo '<span style="color:purple;" class="name">admin</span> ';
              }else{
                echo '<span class="name">' . $comment['comment_user'] . '</span> ';
              }
                echo $dateFormatted . ' No.' . $comment['comment_id'];
                 if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true && $comment['comment_user'] == $_SESSION['username'] || isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true && $_SESSION['username'] == 'admin'){
                   echo ' [<a href="#a" comment_id="' . $comment['comment_id'] . '" class="delBtn">Radera</a>]';
                 }
              echo '</div>
              <blockquote class="postMessage">' . $cmtText . '</blockquote>
            </div>';
        } else {
            $ext = strtolower(pathinfo($comment['file_name'], PATHINFO_EXTENSION));
            list($width, $height) = getimagesize('../../upload/' . $comment['post_id'] . '/' . $comment['file_name']);
            $fileSize = filesize('../../upload/' . $comment['post_id'] . '/' . $comment['file_name']) . ' bytes';
            $fileSize = ceil($fileSize * 0.001) . ' KB';
            if ($fileSize > 1000) {
                $fileSize = $fileSize * 0.001 . ' MB';
            }
            $videoFile = $getID3->analyze('../../upload/' . $comment['post_id'] . '/' . $comment['file_name']);

            if ($ext == 'webm') {
                echo '
                <div class="post reply">
                  <div class="postInfo">';
                  if($comment['comment_user'] == 'admin'){
                    echo '<span style="color:purple;" class="name">admin</span> ';
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
                    echo '<span style="color:purple;" class="name">admin</span> ';
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
                    <img class="postImg" src="../upload/' . $comment['post_id'] . '/' . $comment['file_name'] . '" width="200px">
                  </a>
                  <blockquote class="postMessage">' . $cmtText . '</blockquote>
                </div>';
            }
        }
    }
}
?>
<script src="/Minifourchan/assets/js/script.js"></script>
