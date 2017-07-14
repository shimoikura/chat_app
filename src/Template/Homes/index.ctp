<!-- ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^ -->
<!-- Tab -->
<!-- ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^ -->
<ul class="nav nav-tabs">
  <li role="presentation" class="active"><a href="#">Home</a></li>
  <li role="presentation"><?php echo $this->Html->link("Profile","/mypage"); ?></li>
  <li role="presentation"><a href="#" class="glyphicon glyphicon-plus"></a></li>
</ul>

<!-- ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^ -->
<!-- POST -->
<!-- ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^ -->
<?php
  $this->request->session();
  $userid = $this->request->session()->read('userid');
  echo $this->Form->create(null,['url' => ['controller'=>'Contents','action' => 'add']]);
  echo $this->Form->input("userId",['type'=>'hidden','value'=>$userid]);
  echo $this->Form->input("body",['placeholder'=>'What are you doing now?']);
  echo $this->Form->submit("GO");
  echo $this->Form->end();
 ?>

<!-- ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^ -->
<!-- A content -->
<!-- ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^ -->
<?php foreach ($contents as $value) { ?>
  <div class="container">
    <div class="row">
      <div class="content-box col-md-6">
        <p><?php echo $value['username']; ?></p>
        <p><?php echo $value['body']; ?></p>
        <p><?php echo $value['favo']; ?><span class="glyphicon glyphicon-heart favo" url="<?php echo $this->Url->build(['controller'=>'Contents','action'=>'favo']); ?>" id="<?php echo $value['id'].'favo'; ?>"></span></p>
        <p><?php echo $value['created']; ?></p>
      </div>
    </div>
  </div>
<?php } ?>

<script>
  $(document).ready(function(){

    $(".favo").click(function(){
      // var url = $(this).attr('url');
      var id = $(this).attr("id"); //クリックされたid取得
      var contentId = id.replace(/favo/g,''); //クリックされたContenstableのid
      if ($(this).hasClass('acfavo')) {
        alert(contentId);
        var state = 0;
      }
      else {
        $("#" + id).css({'color':'red'});
        $("#" + id).addClass('acfavo');
        alert(contentId);
        var state = 1;
      }

      // $.ajax({
      //   url:url,
      //   type:'post',
        // data:{
        //   state: state,
        //   id: contentId
        // },
      //   dataType: 'text',
      //   success: function(data){
      //     console.log(data);
      //     alert(data);
      //   },
      //   error: function(response) {
      //     console.log(response.responseText);
      //   }
      // });

    });
  });
</script>
