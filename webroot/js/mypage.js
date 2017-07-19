$(document).ready(function(){
  $("#flist").click(function(){
    var url = $(this).attr('url');
    $.ajax({
      url:url,
      type:'post',
      dataType:'json'
    }).done(function(response){
      for (var i = 0; i < response.length; i++) {
        $("#" + response[i].id + "online").addClass('active');
      }
    }).fail(function(response){
      alert("failed");
    });
  });
});
