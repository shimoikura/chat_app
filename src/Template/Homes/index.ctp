<!-- ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^ -->
<!-- Tab -->
<!-- ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^ -->
<ul class="nav nav-tabs">
  <li role="presentation" class="active"><a href="#">Home</a></li>
  <li role="presentation"><?php echo $this->Html->link("Profile","/mypage"); ?></li>
  <li role="presentation"><a href="#" class="glyphicon glyphicon-plus"></a></li>
</ul>

<div class="container">
    <div class="row">
      <div class="col-md-3">
      </div>
      <!-- ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^ -->
      <!-- POST -->
      <!-- ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^ -->
      <div class="col-md-6">
        <?php
          $this->request->session();
          $userid = $this->request->session()->read('userid');
        ?>
        <div class="post-box">
          <?php
          echo $this->Form->create(null,['url' => ['controller'=>'Contents','action' => 'add']]);
          echo $this->Form->input("userId",['type'=>'hidden','value'=>$userid]);
          ?>
          <?php echo $this->Form->input("body",['placeholder'=>'What are you doing now?', 'label' => false]); ?>
          <?php echo $this->Form->submit("POST"); ?>
          <?php echo $this->Form->end(); ?>
        </div>



<!-- ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^ -->
<!-- A content -->
<!-- ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^ -->
<?php foreach ($contents as $value) { ?>
      <div class="content-box" style="background-color:orange; margin-bottom:5px; border:1px solid;">
        <div class="profile-box" style="width:100%; padding:5px; background-color:red; height:50px;">
          <div class="user-img-box" style="float:left; width:20%; background-color:red;">
            <?php echo $this->Html->image($value['userImg']); ?>
          </div>
          <div class="username-box" style="float:left; width:80%; background-color:red;">
            <p><?php echo $value['username']; ?></p>
          </div>
        </div>
        <div class="contant-container" style="width:100%; word-wrap:break-word; background-color:blue;">
          <p><?php echo $value['body']; ?></p>
          <p><?php echo $value['favo']; ?><span class="glyphicon glyphicon-heart favo" url="<?php echo $this->Url->build(['controller'=>'Contents','action'=>'favo']); ?>" id="<?php echo $value['id'].'favo'; ?>"></span></p>
          <p><?php echo $value['created']; ?></p>
        </div>
      </div>

<?php } ?>
      </div>
    </div>
  </div>

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
