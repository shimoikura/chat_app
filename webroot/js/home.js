$(document).ready(function(){
  // NAVBAR
  $("#btn-notice").click(function(){
    $('[data-toggle="mypage"]').tooltip();
    $('[data-toggle="message"]').tooltip();
    $('[data-toggle="notice"]').tooltip();
    $('[data-toggle="login"]').tooltip();
    $('[data-toggle="logout"]').tooltip();
    $('[data-toggle="addfriends"]').tooltip();
  });

  // OPEN MESSAGE-BOX
  $("#btn-message").click(function(){
    $(".message-user-box").show();
  });

  // MESSAGE
  $(".send-mes").click(function(){
    var receiverid = $(this).attr('id');
    var url = $(this).attr('url');
    $.ajax({
      url:url,
      type:'post',
      dataType:"json",
      data:{receiverid:receiverid},
    }).done(function(response){
      for(var i=0; i<response.length; i++)
      {
        // 相手が送ったメッセージの場合
        if (response[i].message == receiverid) {
          $('.message-box').prepend($("<p class='part-mes'>").append(response[i].message));
        }
        // 自分が送ったメッセージの場合
        else {
          $('.message-box').prepend($("<p class='my-mes'>").append(response[i].message));
        }
        // alert(response[i].id);
      }
    }).fail(function(response){
      alert("failed");
    });

    $(".message-box").show();
    $("#mes-receiverId").val(receiverid);
  });
});
