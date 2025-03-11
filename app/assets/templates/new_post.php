<h2>[<a href="#" id="toggleForm">Starta ny tråd</a>]</h2>
<div class="postForm hidden">
    <h1>Ny tråd</h1>

<form id="postForm" action="assets/services/save-post.php" method="post" enctype="multipart/form-data">
      <textarea name="post_text" id="post_text" rows="10" cols="30" style="width:200px;"></textarea>
      <div class="" id="error_box"></div><br>
      <input type="submit" value="Skicka" style="width:200px;"/><br>
      <input id="uploadImage" type="file" name="image" /><br>
      </form>

          <ul class="rules">
            <li>Tip: Use '>' for greentext and [spoiler][/spoiler] for spoilers!</li>
          </ul>
</div>
<hr style="width:20%;">
<script>
$('#toggleForm').click(function(){
  $(this).toggleText('Starta ny tråd', 'Göm formulär');
})
</script>
