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
    $(".message-box").show();
    $("#mes-receiverId").val(receiverid);
  });
});
