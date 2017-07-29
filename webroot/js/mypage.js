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
    // キーボード操作などにより、オーバーレイが多重起動するのを防止する
    $(this).blur() ; //ボタンからフォーカスを外す
    if($("#modal-overlay")[0]) return false ; //新しくモーダルウィンドウを起動しない
    $("body").append('<div id="modal-overlay1"></div>');
    $("#modal-overlay1").fadeIn("slow");
    $(".userInfo-box-after,#btn-cancel,#btn-save").fadeIn("slow");

    //[#modal-overlay]をクリックしたら…
    $("#btn-cancel").click(function(){
      //[#modal-box]と[#modal-overlay]をフェードアウトした後に…
      $(".modal-box,#modal-overlay1,.change-imgsize-box").fadeOut("slow",function(){
        //[#modal-overlay]を削除する
        $('#modal-overlay1').remove();
        $(".modal-box,#btn-cancel,#btn-save").hide();
        $("#btn-myupdate,.userInfo-box-before").show();
      });
     });
  });

  $('#imgUpload').click(function(){
    $('#imgg').click();
    $("#imgg").on("change",function(){
      var url = $(this).attr("url");
      var file = $(this).prop("files")[0];
      var form_data = new FormData();
      form_data.append('file',file);
      $.ajax({
        url:url,
        cache: false,
        contentType: false,
        processData: false,
        type:"post",
        dataType:"script",
        data:form_data,
      }).done(function(response){
        $(".userInfo-box-after,#btn-cancel,#btn-save").hide();
        //選択肢したファイルに変更
        $("#user-img-sum").attr("src","img/userImages/" + response);
        $("#user-img-sum").cropper({
          aspectRatio: 4 / 4,
          viewMode:1,
          crop: function(e){
            // Output the result data for cropping image.
            console.log(e);
            console.log(e.x);
            console.log(e.y);
            console.log(e.width);
            console.log(e.height);
            console.log(e.rotate);
            console.log(e.scaleX);
            console.log(e.scaleY);
          }
        });
        if (file != null) {
          $("body").append('<div id="modal-overlay1"></div>');
          $("#modal-overlay1").fadeIn("slow");
          //コンテンツをセンタリングする
          centeringModalSyncer() ;
          $(".change-imgsize-box").fadeIn("slow");
          //[#modal-overlay1]をクリックしたら…
          $("#modal-overlay1").unbind().click(function(){
            //[..change-imgsize-box]と[#modal-overlay1]をフェードアウトした後に…
            $(".change-imgsize-box,#modal-overlay1").fadeOut("slow",function(){
              //[#modal-overlay1]を削除する
              $('#modal-overlay1').remove();
            });
           });
        }
        else {
          alert("not choosed");
        }
      }).fail(function(){
        alert("failed");
      });

    });
  });

  //センタリングをする関数
   function centeringModalSyncer(){
   //画面(ウィンドウ)の幅を取得し、変数[w]に格納
   var w = $(window).width();
   //画面(ウィンドウ)の高さを取得し、変数[h]に格納
   var h = $(window).height();
   //コンテンツ(.change-imgsize-box)の幅を取得し、変数[cw]に格納
   var cw = $(".change-imgsize-box").outerWidth();
   //コンテンツ(.change-imgsize-box)の高さを取得し、変数[ch]に格納
   var ch = $(".change-imgsize-box").outerHeight();
   //コンテンツ(.change-imgsize-box)を真ん中に配置するのに、左端から何ピクセル離せばいいか？を計算して、変数[pxleft]に格納
   var pxleft = ((w - cw)/2);
   //コンテンツ(.change-imgsize-box)を真ん中に配置するのに、上部から何ピクセル離せばいいか？を計算して、変数[pxtop]に格納
   var pxtop = ((h - ch)/2);
   //[.change-imgsize-box]のCSSに[left]の値(pxleft)を設定
   $(".change-imgsize-box").css({"left": pxleft + "px"});
   //[.change-imgsize-box]のCSSに[top]の値(pxtop)を設定
   $(".change-imgsize-box").css({"top": pxtop + "px"});
 }

});
