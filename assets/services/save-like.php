<?php
include('../functions/db.php');


if ($_GET) {
    $post_id = $_GET['id'];

    $sql = "UPDATE
          posts
          SET
          post_likes = post_likes+1
          WHERE
          post_id = $post_id
          ";

    $results = $conn->query($sql);
    header("Location: ../../post/?id=".$post_id."");
}
