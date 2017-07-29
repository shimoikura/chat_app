// /dist ディレクトリからファイルをダウンロードすること！！
  $(document).ready(function(){
    $("#btn-get").click(function(){
      var url = $(this).attr("url");
      // crop のデータを取得
      var data = $('#user-img-sum').cropper('getData');
      var name = $("#user-img-sum").attr("src");
      $("#data").text(data.width);
      $.ajax({
        url:url,
        type:"post",
        dataType:"html",
        data:{data:data,name:name},
      }).done(function(response){
        $("#imgUpload").attr("src","img/userImages/"+response);
        $(".change-imgsize-box").hide();
        $('#modal-overlay1').remove();
        $(".userInfo-box-after,#btn-cancel,#btn-save").show();
        alert(response);
      }).fail(function(){
        alert("failed");
      });
    });
  });
