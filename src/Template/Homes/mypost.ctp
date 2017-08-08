<div class="container">
  <div class="row">
    <!-- ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^ -->
    <!-- My USER INFORMATION -->
    <!-- ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^ -->
    <div class="col-md-4 col-sm-12">

      <!-- Origin (Before update) -->
      <div class="userInfo-box-before" style="width:200px; height:200px;">
        <div class="userImg-box">
          <?php echo $this->Html->image($user[0]["userImg"],['class' => 'img-responsive img-circle']); ?>
        </div>
        <table class="mypage-user">
          <tr>
            <td rowspan="2"><h3 style=" margin:0;"><span><?php echo $user[0]['username'] ?></span></h3></td>
            <?php $friends_num = count($friends) - 1; ?>
            <th>friends</th>
          </tr>
          <tr>
            <td><a href="#" id="flist" url="<?php echo $this->Url->build('/online'); ?>"><?php echo $friends_num; ?></a></td>
          </tr>
        </table>
        <p>aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa</p>
      </div>
      <!-- Chenge (After update) -->
      <div class="userInfo-box-after modal-box">
        <?php echo $this->Form->create(null,['url' => '/userupdate' , "type" => "file"]); ?>

        <table class="mypage-user">
          <div class="userImg-box">
            <?php echo $this->Html->image($user[0]['userImg'],['width'=>'200px', 'id'=>'imgUpload']); ?>
            <input type="file" style="display:none;" id="imgg" url="<?php echo $this->Url->build("/moveimg"); ?>">
            <?php echo $this->Form->input("userImg",['id' => "uImgname","type"=>"hidden"]); ?>
          </div>
          <tr>
            <td rowspan="2"><h3 style="margin:0;">
              <span><?php echo $this->Form->input('username',['id'=> 'ed-name' , 'label'=>false , 'value'=>$user[0]['username']]) ?></span>
            </h3></td>
            <?php $friends_num = count($friends) - 1; ?>
            <th>friends</th>
          </tr>
          <tr>
            <td><a href="#" id="flist" url="<?php echo $this->Url->build('/online'); ?>"><?php echo $friends_num; ?></a></td>
          </tr>
        </table>
        <p>aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa</p>
      </div>

      <!-- Friends LIST BOX -->
      <div class="friends-list-box" style="display:none;">
        <p>FRIENDS LIST</p>
        <?php foreach ($fusers as $fuser) { ?>
          <div class="fuser-box">
            <p style="float:left; width:70%;"><?php echo $fuser['username']; ?></p>
            <span id="<?php echo $fuser['id']; ?>online" class="glyphicon glyphicon-record" style="float:left; width:30%;"></span>
          </div>
        <?php } ?>
      </div>

    </div>

    <!-- アップロード画像のサイズの変更 -->

    <div class="change-imgsize-box">
      <?php echo $this->Html->image($user[0]['userImg'],[
                                        'id' => 'user-img-sum',
                                        'class' => 'img-responsive img-circle'
                                      ]); ?>
      <button id="btn-get" type="button" name="button" url="<?php echo $this->Url->build("/imger"); ?>">GET DATA</button>
    </div>



    <!-- ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^ -->
    <!-- A content -->
    <!-- ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^ -->
    <div class="col-md-5 col-sm-12">
    <?php foreach ($contents as $value) { ?>
            <p><?php echo $value['body']; ?></p>
            <p><?php echo $value['favo']; ?><span class="glyphicon glyphicon-heart favo" url="<?php echo $this->Url->build(['controller'=>'Contents','action'=>'favo']); ?>" id="<?php echo $value['id'].'favo'; ?>"></span></p>
            <p><?php echo $value['created']; ?></p>
    <?php } ?>
    </div>

    <!-- ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^ -->
    <!-- プロフィール編集ボタン -->
    <!-- ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^ -->
    <div class="mypage-btn-box col-md-3"
      <?php if ($value['status'] == 1) {
        echo "style = display:none;";
      } ?>
      >
      <p id="btn-myupdate" class="btn-mypage btn btn-primary" >Update Profile</p>
      <p id="btn-cancel" class="btn-mypage btn" style="float: left;">Cancel</p>
      <?php echo $this->Form->submit('Save Changes' ,["id"=>"btn-save","class" => "btn-mypage btn btn-primary"]); ?>
      <?php echo $this->Form->end(); ?>
    </div>
  </div>
</div>
