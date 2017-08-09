$(document).ready(function(){
  $(".comment").click(function(){
    var id = $(this).attr("id");
    var contentId = id.replace(/comment/g,'');
    $("#" + contentId + "comment-box").fadeIn();
  });
  // ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^(^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
  // コメント機能
  // ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
  $(".btn-comment-submit").click(function(){
    var url = $(this).attr('url');
    var id = $(this).attr("id");
    var contentId = id.replace(/btn-comment-submit/g,'');
    var comment = $("#" + contentId + "text-comment").val();
    $("#" + contentId + "comment-box").append("<div><p>" + comment + "</p></div>");
    $.ajax({
      url:url,
      type:'post',
      dataType:'html',
      data:{
        id: contentId,
        comment:comment
      },
    }).done(function(response){
    }).fail(function(response){
      alert("failed");
    });
  });
});
