$(document).ready(function(){
  $("#flist").click(function(){
    var url = $(this).attr('url');
    $.ajax({
      url:url,
      type:'post',
      dataType:'json'
    }).done(function(response){
      for (var i = 0; i < response.length; i++) {
        $("#" + response[i].userId + "online").addClass('active');
        $(".friends-list-box").show();
      }
    }).fail(function(response){
      alert("failed");
    });
  });
});
