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
          echo $this->Form->create(null,['type' => 'file','url' => ['controller'=>'Contents','action' => 'add']]);
          echo $this->Form->input("userId",['type'=>'hidden','value'=>$userid]);
          ?>
          <?php echo $this->Form->input("body",['placeholder'=>'What are you doing now?', 'label' => false]); ?>
          <button type="button" name="button" id="btn-img-post" data-toggle='addimg' title="Add Image"><span class="glyphicon glyphicon-picture"></span></button>
          <?php echo $this->Form->file("postImg",[
            "id" => "post-img",
            "label" => false,
            "required"=>false,
            "errors"=>true,
            "style" => "display:none;"
          ]); ?>
          <?php echo $this->Form->submit("POST"); ?>
          <?php echo $this->Form->end(); ?>
        </div>



<!-- ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^ -->
<!-- A content -->
<!-- ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^ -->
<?php foreach ($contents as $value) { ?>
      <div class="content-box" style="display:table; width:100%; margin-bottom:5px; border:1px solid; border-radius:3px; background-color:#efefef;">
        <div class="user-img-box" style="display:table-cell; width:10%; height:100%; float:left;">
          <?php echo $this->Html->image($value['userImg']); ?>
        </div>
        <div class="content-box-right" style="display:table-cell; width:380px; float:left;">
          <div class="profile-box" style="width:100%; height:30px;">
            <div class="username-box" style="float:left;">
              <p style="font-size:20px; font-weight:bold; margin:0; float:left;"><?php echo $value['username']; ?></p>
              <p style="color:#dcdcdc; float:left; margin-left:10px; margin-top:5px;"><?php echo $value['created']; ?></p>
            </div>
          </div>
          <div class="contant-container" style="width:100%; word-wrap:break-word; padding:5px;">
            <p><?php echo $value['body']; ?></p>
            <p><?php echo $value['favo']; ?>
              <?php
              $favoUsers = explode(",",$value['favoUsers']);
               for ($i=0; $i < count($favoUsers); $i++) {
                if ($favoUsers[$i] == $userid) {
                  $favoClass = "acfavo";
                  $i = count($favoUsers);
                }
                else {
                  $favoClass = "";
                }
              } ?>
              <span class="glyphicon glyphicon-heart favo <?php echo $favoClass; ?>" url="<?php echo $this->Url->build('/favo'); ?>" id="<?php echo $value['id'].'favo'; ?>"></span>
            </p>
          </div>
        </div>

      </div>

<?php } ?>
      </div>
    </div>
  </div>
