$(document).ready(function(){
  // MesseageFriends一覧の表示
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

  // UserInformationの編集
  $("#btn-myupdate").click(function(){
    $(".userInfo-box-before,#btn-myupdate").hide();
    // $(".userInfo-box-after").show();
    // キーボード操作などにより、オーバーレイが多重起動するのを防止する
    $(this).blur() ; //ボタンからフォーカスを外す
    if($("#modal-overlay")[0]) return false ; //新しくモーダルウィンドウを起動しない
    $("body").append('<div id="modal-overlay1"></div>');
    $("#modal-overlay1").fadeIn("slow");
    $(".userInfo-box-after,#btn-cancel,#btn-save").fadeIn("slow");

    //[#modal-overlay]をクリックしたら…
    $("#btn-cancel").click(function(){
      //[#modal-box]と[#modal-overlay]をフェードアウトした後に…
      $(".modal-box,#modal-overlay1").fadeOut("slow",function(){
        //[#modal-overlay]を削除する
        $('#modal-overlay1,#btn-cancel,#btn-save').remove();
        $(".modal-box").hide();
        $("#btn-myupdate,.userInfo-box-before").show();
      });
     });
  });

  $('#imgUpload').click(function(){
      $('#imgg').click();
  });
});
