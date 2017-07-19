$(document).ready(function(){
  $(".favo").click(function(){
    var url = $(this).attr('url');
    var id = $(this).attr("id"); //クリックされたid取得
    var contentId = id.replace(/favo/g,''); //クリックされたContenstableのid
    if ($(this).hasClass('acfavo')) {
      alert(contentId);
      var state = 1;
    }
    else {
      $("#" + id).addClass('acfavo');
      alert(contentId);
      var state = 0;
    }

    $.ajax({
      url:url,
      type:'post',
      dataType:'html',
      data:{
        state: state,
        id: contentId
      },
      }).done(function(response){
        alert(response);
      }).fail(function(){
        alert("failed");
      });
  });
});
