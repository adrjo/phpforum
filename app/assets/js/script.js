$(document).ready(function(e){
  $.fn.toggleText = function(t1, t2){
    if (this.text() == t1) this.text(t2);
    else                   this.text(t1);
    return this;
  };

  $("#toggleForm").click(function(a) {
    $(".hidden").toggleClass("show");
  });
});

//Remove thread, comment & user
$(document).ready(function(e) {
  var removeThread="-1";
  var removeComment="-1";

  $(".delBtn, .close").click(function() {
    $(".overlay").toggleClass("show");
    removeThread = $(this).attr('post_id');
    removeComment = $(this).attr('comment_id');
    removeUser = $(this).attr('user_id');
  });

  //Remove thread
  $(".remove").click(function() {
    if(removeThread != undefined) {
      $.ajax({
        url: "/Minifourchan/assets/services/delete-post.php",
        type: "POST",
        data: {
          id:removeThread
        },
        success: function(postdata) {
          window.location.reload()
        }
      });
    }
  });

  //Remove comment
  $(".remove").click(function() {
    if(removeComment != undefined) {
      $.ajax({
        url: "/Minifourchan/assets/services/delete-comment.php",
        type: "POST",
        data: {
          id:removeComment
        },
        success: function(postdata) {
          window.location.reload()
        }
      });
    }
  });

  //Remove user
  $(".remove").click(function() {
    if(removeUser != undefined) {
      $.ajax({
        url: "/Minifourchan/assets/services/delete-user.php",
        type: "POST",
        data: {
          id:removeUser
        },
        success: function(postdata) {
          window.location.reload()
        }
      });
    }
  });

});

 //Register user
 $(document).ready(function(e) {
   $("#registerForm").on('submit', (function(e) {
     e.preventDefault();
     $.ajax({
       url: "../assets/services/register.php",
       type: "POST",
       data: new FormData(this),
       contentType: false,
       cache: false,
       processData: false,
       success: function(postdata) {
         if (postdata == 'passwordMatch') {
           $('#error_box').html('<strong style="color:red;">ERROR!</strong> Password doesn\'t match.').fadeIn();
           setTimeout(function () {
             $('#error_box').fadeOut();
           }, 2000);
         } else if (postdata == 'errorEmpty') {
           $('#error_box').html('<strong style="color:red;">ERROR!</strong> Empty username/password/email.').fadeIn();
           setTimeout(function () {
             $('#error_box').fadeOut();
           }, 2000);
         } else if (postdata == 'errorSpaces') {
           $('#error_box').html('<strong style="color:red;">ERROR!</strong> Spaces are not allowed.').fadeIn();
           setTimeout(function () {
             $('#error_box').fadeOut();
           }, 2000);
         }else if (postdata == 'userExists') {
           $('#error_box').html('<strong style="color:red;">ERROR!</strong> User exists.').fadeIn();
           setTimeout(function () {
             $('#error_box').fadeOut();
           }, 2000);
         } else {
           document.location.replace('index.php');
         }

       }
     });
   }));
 });

 //Login
 $(document).ready(function(e) {
   $("#loginForm").on('submit', (function(e) {
     e.preventDefault();
     $.ajax({
       url: "../assets/services/login.php",
       type: "POST",
       data: new FormData(this),
       contentType: false,
       cache: false,
       processData: false,
       success: function(postdata) {
         if (postdata == 'error') {
           $('#error_box').html('<strong style="color:red;">ERROR!</strong> Wrong password.').fadeIn();
           setTimeout(function () {
             $('#error_box').fadeOut();
           }, 2000);
         }else if (postdata == 'errorPass' || postdata == 'errorUser') {
           $('#error_box').html('<strong style="color:red;">ERROR!</strong> Fill in all fields!').fadeIn();
           setTimeout(function () {
             $('#error_box').fadeOut();
           }, 2000);
         }else {
           document.location.replace('../');
         }

       }
     });
   }));
 });

 //Post new thread
 $(document).ready(function(e) {
   $("#postForm").on('submit', (function(e) {
     e.preventDefault();
     $.ajax({
       url: "assets/services/save-post.php",
       type: "POST",
       data: new FormData(this),
       contentType: false,
       cache: false,
       processData: false,
       success: function(postdata) {
         if (postdata == 'errorLength') {
           $('#error_box').html('<strong style="color:red;">ERROR!</strong> Max characters is 2000!').fadeIn();
         } else if (postdata == 'loggedOut') {
           $('#error_box').html('<strong style="color:red;">ERROR!</strong> You\'re not logged in!').fadeIn();
         } else if (postdata == 'txtEmpty') {
           $('#error_box').html('<strong style="color:red;">ERROR!</strong> Textarea can\'t be empty!').fadeIn();
         } else if (postdata == 'errorExt') {
           $('#error_box').html('<strong style="color:red;">ERROR!</strong> Accepted filetypes: jpeg, jpg, png, gif, bmp, webm').fadeIn();
         } else if (postdata == 'errorSize') {
           $('#error_box').html('<strong style="color:red;">ERROR!</strong> Max file size is 2MB!').fadeIn();
         } else if (postdata == 'txtEmptyerrorSize') {
           $('#error_box').html('<strong style="color:red;">ERROR!</strong> Textarea can\'t be empty!<br><strong style="color:red;">ERROR!</strong> Max file size is 2MB!').fadeIn();
         } else if (postdata == 'errorLengtherrorSize') {
           $('#error_box').html('<strong style="color:red;">ERROR!</strong> Max characters is 2000!<br><strong style="color:red;">ERROR!</strong> Max file size is 2MB!').fadeIn();
         } else {
           $("#error_box").fadeOut();
           $("#postForm")[0].reset();
           $('#new_post').load("/Minifourchan/assets/services/get_post.php?post_id=" + postdata);
           document.location.replace('#new_post');
         }
       }

     });
   }));
 });

 //Post new reply
 $(document).ready(function(e) {
   $("#commentForm").on('submit', (function(e) {
     e.preventDefault();
     $.ajax({
       url: "../assets/services/save-comment.php",
       type: "POST",
       data: new FormData(this),
       contentType: false,
       cache: false,
       processData: false,
       success: function(postdata) {
         if (postdata == 'errorLength') {
           $('#error_box').html('<strong style="color:red;">ERROR!</strong> Max characters is 2000!').fadeIn();
         } else if (postdata == 'loggedOut') {
           $('#error_box').html('<strong style="color:red;">ERROR!</strong> You\'re not logged in!').fadeIn();
         } else if (postdata == 'txtEmpty') {
           $('#error_box').html('<strong style="color:red;">ERROR!</strong> Textarea can\'t be empty!').fadeIn();
         } else if (postdata == 'errorExt') {
           $('#error_box').html('<strong style="color:red;">ERROR!</strong> Accepted filetypes: jpeg, jpg, png, gif, bmp, webm').fadeIn();
         } else if (postdata == 'errorSize') {
           $('#error_box').html('<strong style="color:red;">ERROR!</strong> Max file size is 4MB!').fadeIn();
         } else if (postdata == 'txtEmptyerrorSize') {
           $('#error_box').html('<strong style="color:red;">ERROR!</strong> Textarea can\'t be empty!<br><strong style="color:red;">ERROR!</strong> Max file size is 2MB!').fadeIn();
         } else if (postdata == 'errorLengtherrorSize') {
           $('#error_box').html('<strong style="color:red;">ERROR!</strong> Max characters is 2000!<br><strong style="color:red;">ERROR!</strong> Max file size is 2MB!').fadeIn();
         } else {
           $("#error_box").fadeOut();
           $("#commentForm")[0].reset();
           $('#new_comment').load("/Minifourchan/assets/services/get_comment.php?comment_id=" + postdata);
           document.location.replace('#new_comment');
         }
       }

     });
   }));
 });
