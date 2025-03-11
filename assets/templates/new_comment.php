<h2>[<a href="#" id="toggleForm">Skicka ett svar</a>]</h2>
<div class="postForm hidden">
    <h1>Nytt svar</h1>

<form id="commentForm" action="../assets/services/save-comment.php" method="post" enctype="multipart/form-data">
      <input type="hidden" name="post_id" value="<?php echo $post_id?>">
      <textarea name="comment_text" id="comment_text" rows="10" cols="30" style="width:200px;"></textarea><br>
      <input href="#new_comment" style="width:200px;" type="submit" value="Skicka" />
      <div class="" id="error_box"></div><br>
      <input id="uploadImage" type="file" name="image" /><br>
      </form>

      <ul class="rules">
        <li>Tip: Use '>' for greentext and [spoiler][/spoiler] for spoilers!</li>
      </ul>
</div>
<hr style="width:20%;">
<script>
$('#toggleForm').click(function(){
  $(this).toggleText('Skicka ett svar', 'Göm formulär');
})
</script>
