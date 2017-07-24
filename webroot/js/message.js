$(document).ready(function(){
  $("#send-mes").click(function(){
    var url = $(this).attr("url");
    var receiverid = $("#mes-receiverId").val();
    var body = $("#mes-body").val();
    $("#mes-body").val('');
    // 今送ったメッセージ
    $('.message-content-box').append("<p class='my-mes'>"+ body +"</p>");
    $.ajax({
      url:url,
      type:'post',
      dataType:'html',
      data:{receiverid:receiverid,body:body},
    }).done(function(response){
      alert(response);
    }).fail(function(){
      alert("failed");
    });
  });
});
