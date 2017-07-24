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
    // キーボード操作などにより、オーバーレイが多重起動するのを防止する
    $(this).blur() ; //ボタンからフォーカスを外す
    if($("#modal-overlay")[0]) return false ; //新しくモーダルウィンドウを起動しない
    $("body").append('<div id="modal-overlay"></div>');
    $("#modal-overlay").fadeIn("slow");
    //[#modal-overlay]をクリックしたら…
    $("#modal-overlay").unbind().click(function(){
      //[#modal-box]と[#modal-overlay]をフェードアウトした後に…
      $(".modal-box,#modal-overlay").fadeOut("slow",function(){
        //[#modal-overlay]を削除する
        $('#modal-overlay').remove();
        $(".modal-box").hide();
      });
     });

    var receiverid = $(this).attr('id');
    var url = $(this).attr('url');
    $('.message-content-box').html("");
    $.ajax({
      url:url,
      type:'post',
      dataType:"json",
      data:{receiverid:receiverid},
    }).done(function(response){
      $(".modal-box").fadeIn("slow");
      for(var i=0; i<response.length; i++)
      {
          // 相手が送ったメッセージの場合
          if (response[i].message == receiverid) {
            $('.message-content-box').append($("<p class='my-mes'>").append(response[i].message));
          }
          // 自分が送ったメッセージの場合
          else {
            $('.message-content-box').append("<p class='my-mes'>"+response[i].message+"</p>");
          }
      }
    }).fail(function(response){
      alert("failed");
    });
    $(".message-user-box").hide();
    $("#mes-receiverId").val(receiverid);
  });
});
