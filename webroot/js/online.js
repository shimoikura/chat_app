$(document).ready(function(){
  // Windowを閉じたとき、OnlinesTableのコラムを消去する
  var url = $("#logout-link").attr('href');
  $(window).bind("beforeunload", function() {
     confirm("Do you really want to close?");
    return $.ajax({
      url:url,
      type:'post',
      dataType:'html',
    }).done(function(response){
    }).fail(function(){
      alert("failed");
    });
  });
});
